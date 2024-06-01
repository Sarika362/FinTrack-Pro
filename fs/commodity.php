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
        $result = $conn->query("SELECT * FROM commodity WHERE user_id='$user_id'");
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
                $commodityData = json_decode(file_get_contents("php://input"));

                // Constant value for trading_id
                $trading_id = '3'; // Replace with your constant value

                // Extract data from request
                $name = $commodityData->name;
                $unit = $commodityData->unit;
                $quantity = $commodityData->quantity;
                $profit = $commodityData->profit;
                $opening_price = $commodityData->opening_price;
                $closing_price = $commodityData->closing_price;

                // Insert data into database
                $sql = "INSERT INTO commodity (user_id, trading_id, name, unit, quantity, profit, opening_price, closing_price)
                        VALUES ('$user_id', '$trading_id', '$name', '$unit', '$quantity', '$profit', '$opening_price', '$closing_price')";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "New record created successfully"));
                } else {
                    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
                }
                break;

            case 'update':
                // Handle updating an item
                $commodityData = json_decode(file_get_contents("php://input"));

                // Extract data from request
                $commodity_id = $commodityData->commodity_id;
                $name = $commodityData->temp_name;
                $unit = $commodityData->temp_unit;
                $quantity = $commodityData->temp_quantity;
                $profit = $commodityData->temp_profit;
                $opening_price = $commodityData->temp_opening_price;
                $closing_price = $commodityData->temp_closing_price;

                // Update data in database
                $sql = "UPDATE commodity SET name='$name', unit='$unit', quantity='$quantity', profit='$profit', opening_price='$opening_price', closing_price='$closing_price' WHERE commodity_id='$commodity_id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record updated successfully"));
                } else {
                    echo json_encode(array("error" => "Error updating record: " . $conn->error));
                }
                break;

            case 'delete':
                // Handle deleting an item
                // $commodity_id = $_POST['commodity_id'];
                $inputJSON = file_get_contents('php://input');
                $input = json_decode($inputJSON, true);
                $commodity_id = $input['commodity_id'];
                $sql = "DELETE FROM commodity WHERE commodity_id='$commodity_id'";

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
