<?php

session_start();
include 'config.php';
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

        // Read items from database only for the current user
        $result = $conn->query("SELECT * FROM fixed WHERE user_id='$user_id'");
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    case 'POST':
        // Handle different actions
        $action = $_GET['action'];
        switch ($action) {
            case 'create':
                // Check if user_id is set in session
                if (!isset($_SESSION['user_id'])) {
                    // Handle case if user_id is not set
                    echo json_encode(array("error" => "User not authenticated"));
                    exit;
                }

                // Assign user_id from session
                $user_id = $_SESSION['user_id'];

                // Handle form submission
                $fixedData = json_decode(file_get_contents("php://input"));
                
                // Constant value for assets_id
                $assets_id = '1'; // Replace with your constant value
                
                // Create a new item
                $property_name = $fixedData->property_name;
                $type = $fixedData->type;
                $date_acquired = $fixedData->date_acquired;
                $purchase_price = $fixedData->purchase_price;
                $selling_price = $fixedData->selling_price;
                $profit = $fixedData->profit;

                $sql = "INSERT INTO fixed (user_id, assets_id, property_name, type, date_acquired, purchase_price, selling_price, profit)
                        VALUES ('$user_id', '$assets_id', '$property_name', '$type', '$date_acquired', '$purchase_price', '$selling_price', '$profit')";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "New record created successfully"));
                } else {
                    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
                }
                break;

                case 'update':
                    // Handle updating an item
                    $fixedData = json_decode(file_get_contents("php://input"));
    
                    // Extract data from request
                    $fixed_id = $fixedData->fixed_id; // Retrieve fixed_id from request
                    // $new_fixed_id = $fixedData->temp_fixed_id; // Retrieve new_fixed_id from request
                    $property_name = $fixedData->temp_property_name;
                    $type = $fixedData->temp_type;
                    $date_acquired = $fixedData->temp_date_acquired;
                    $purchase_price = $fixedData->temp_purchase_price;
                    $selling_price = $fixedData->temp_selling_price;
                    $profit = $fixedData->temp_profit;
    
                    // Update data in database
                    $sql = "UPDATE fixed SET property_name='$property_name', type='$type', date_acquired='$date_acquired', purchase_price='$purchase_price', selling_price='$selling_price', profit='$profit' WHERE fixed_id='$fixed_id'";

                    if ($conn->query($sql) === TRUE) {
                        echo json_encode(array("message" => "Record updated successfully"));
                    } else {
                        echo json_encode(array("error" => "Error updating record: " . $conn->error));
                    }
                    break;

            case 'delete':
                // Handle deleting an item
                // $fixed_id = $_POST['fixed_id'];
                $inputJSON = file_get_contents('php://input');
                $input = json_decode($inputJSON, true);
                $fixed_id = $input['fixed_id'];
                $sql = "DELETE FROM fixed WHERE fixed_id='$fixed_id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record deleted successfully"));
                } else {
                    echo json_encode(array("error" => "Error deleting record: " . $conn->error));
                }
                break;

            default:
                // Invalid action
                header("HTTP/1.0 400 Bad Request");
                break;
        }
        break;

    default:
        // Invalid request method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

$conn->close();
?>
