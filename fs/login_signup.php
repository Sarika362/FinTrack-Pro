<?php
session_start();

include_once "config.php";

// Function to authenticate user
function authenticate_user($emailOrUsername, $password, $conn) {
    // Query to check if user exists and credentials are correct
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedpassword = password_hash($row["password"], PASSWORD_DEFAULT);

        if (password_verify($password, $hashedpassword)) {
            $_SESSION['user_id'] = $row["user_id"];
            $_SESSION['username'] = $row["username"];
            return true;

        }
    }
    return false;
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["emailOrUsername"], $_POST["password"])) {
        $emailOrUsername = $_POST['emailOrUsername'];
        $password = $_POST['password'];
        
        // Trim the password to remove any leading or trailing whitespace
        $password = trim($password);

        // Authenticate user
        if (authenticate_user($emailOrUsername, $password, $conn)) {
            $_SESSION['authenticated'] = true;
            exit('success');
        } else {
            exit('error');
        }
    } elseif (isset($_POST["name"], $_POST["username"], $_POST["email"], $_POST["password"])) {
        // Handle signup
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Trim the password to remove any leading or trailing whitespace
        $password = trim($password);

        // Encrypt password
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (name, username, email, password, hashed_password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $username, $email, $password, $hashedpassword);
        
        if ($stmt->execute()) {
            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;

            exit('success');
        } else {
            exit('error');
        }
        
        $stmt->close();
    }
}
?>
