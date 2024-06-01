<?php
include 'config.php';

// Start session
session_start();

// Set headers for CORS and JSON response
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Check if user_id is set in session
        if (!isset($_SESSION['user_id'])) {
            // Handle case if user_id is not set
            echo json_encode(array("error" => "User not authenticated"));
            exit;
        }

        // Assign user_id from session
        $user_id = $_SESSION['user_id'];

        // Fetch website settings from the database for the current user
        $result = $conn->query("SELECT * FROM website_settings WHERE user_id='$user_id'");
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            echo json_encode(array("error" => "No settings found for this user"));
        }
        break;
    case 'POST':
        // Check if user_id is set in session
        if (!isset($_SESSION['user_id'])) {
            // Handle case if user_id is not set
            echo json_encode(array("error" => "User not authenticated"));
            exit;
        }

        // Assign user_id from session
        $user_id = $_SESSION['user_id'];

        // Handle form submission
        $websiteSettingsData = json_decode(file_get_contents("php://input"));

        // Extract data from the JSON object
        $user_name = $websiteSettingsData->user_name;
        $user_password = $websiteSettingsData->user_password;
        $user_number = $websiteSettingsData->user_number;
        $user_email = $websiteSettingsData->user_email;
        $user_description = $websiteSettingsData->user_description;
        
        // Hash the password
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        
        
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO website_settings (user_id, user_name, user_password, user_number, user_email, user_description) 
            VALUES (?, ?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE user_name=?, user_password=?, user_number=?, user_email=?, 
            user_description=?");
        
        $stmt->bind_param("sssssssssss", $user_id, $user_name, $hashed_password, $user_number, $user_email, 
            $user_description, $user_name, $hashed_password, $user_number, $user_email, $user_description);
        
        if ($stmt->execute()) {
            // Update corresponding user details
            $stmt_user = $conn->prepare("UPDATE users SET username=?, password=?, hashed_password=?, email=? WHERE user_id=?");
            $stmt_user->bind_param("ssssi", $user_name, $user_password, $hashed_password, $user_email, $user_id);
            if ($stmt_user->execute()) {
                echo json_encode(array("message" => "Website settings updated successfully"));
            } else {
                echo json_encode(array("error" => "Error updating user details: " . $conn->error));
            }
        } else {
            echo json_encode(array("error" => "Error updating website settings: " . $conn->error));
        }

        // Close statements
        $stmt->close();
        $stmt_user->close();
        break;
    default:
        // Invalid request method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

$conn->close();
?>
