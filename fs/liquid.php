<?php
include 'config.php';
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

        // Read items from database only for the current user
        $result = $conn->query("SELECT * FROM liquid WHERE user_id='$user_id'");
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
                $liquidData = json_decode(file_get_contents("php://input"));
                
                // Constant value for assets_id
                $assets_id = '2'; // Replace with your constant value
                
                // Create a new item
                $name = $liquidData->name;
                $quantity = $liquidData->quantity;
                $date_acquired = $liquidData->date_acquired;
                $purchase_price = $liquidData->purchase_price;
                $selling_price = $liquidData->selling_price;
                $profit = $liquidData->profit;

                $sql = "INSERT INTO liquid (user_id, assets_id, name, quantity, date_acquired, purchase_price, selling_price, profit)
                        VALUES ('$user_id', '$assets_id', '$name', '$quantity', '$date_acquired', '$purchase_price', '$selling_price', '$profit')";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "New record created successfully"));
                } else {
                    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
                }
                break;

            case 'update':
                // Handle updating an item
                $liquidData = json_decode(file_get_contents("php://input"));

                // Extract data from request
                $liquid_id = $liquidData->liquid_id; // Retrieve liquid_id from request
                // $new_liquid_id = $liquidData->temp_liquid_id; // Retrieve new_liquid_id from request
                $name = $liquidData->temp_name;
                $quantity = $liquidData->temp_quantity;
                $date_acquired = $liquidData->temp_date_acquired;
                $purchase_price = $liquidData->temp_purchase_price;
                $selling_price = $liquidData->temp_selling_price;
                $profit = $liquidData->temp_profit;

                // Update data in database
                $sql = "UPDATE liquid SET name='$name', quantity='$quantity', date_acquired='$date_acquired', purchase_price='$purchase_price', selling_price='$selling_price', profit='$profit' WHERE liquid_id='$liquid_id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record updated successfully"));
                } else {
                    echo json_encode(array("error" => "Error updating record: " . $conn->error));
                }
                break;

            case 'delete':
                // Handle deleting
                // $liquid_id = $_POST['liquid_id'];
                $inputJSON = file_get_contents('php://input');
                $input = json_decode($inputJSON, true);
                $liquid_id = $input['liquid_id'];

                $sql = "DELETE FROM liquid WHERE liquid_id='$liquid_id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record deleted successfully"));
                } else {
                    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
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
