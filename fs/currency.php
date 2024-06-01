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
        $result = $conn->query("SELECT * FROM currency WHERE user_id='$user_id'");
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
                $currencyData = json_decode(file_get_contents("php://input"));

                // Constant value for trading_id
                $trading_id = '2'; // Replace with your constant value

                // Extract data from request
                $name = $currencyData->name;
                $code = $currencyData->code;
                $exchange_rate = $currencyData->exchange_rate;
                $profit = $currencyData->profit;
                $bought_price = $currencyData->bought_price;
                $sell_price = $currencyData->sell_price;
                $selling_date = $currencyData->selling_date;

                // Insert data into database
                $sql = "INSERT INTO currency (user_id, trading_id, name, code, exchange_rate, profit, bought_price, sell_price, selling_date)
                        VALUES ('$user_id', '$trading_id', '$name', '$code', '$exchange_rate', '$profit', '$bought_price', '$sell_price', '$selling_date')";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "New record created successfully"));
                } else {
                    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
                }
                break;

            case 'update':
                // Handle updating an item
                $currencyData = json_decode(file_get_contents("php://input"));

                // Extract data from request
                $currency_id = $currencyData->currency_id;
                $name = $currencyData->temp_name;
                $code = $currencyData->temp_code;
                $exchange_rate = $currencyData->temp_exchange_rate;
                $profit = $currencyData->temp_profit;
                $bought_price = $currencyData->temp_bought_price;
                $sell_price = $currencyData->temp_sell_price;
                $selling_date = $currencyData->temp_selling_date;

                // Update data in database
                $sql = "UPDATE currency SET name='$name', code='$code', exchange_rate='$exchange_rate', profit='$profit', bought_price='$bought_price', sell_price='$sell_price', selling_date='$selling_date' WHERE currency_id='$currency_id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record updated successfully"));
                } else {
                    echo json_encode(array("error" => "Error updating record: " . $conn->error));
                }
                break;

            case 'delete':
                // Handle deleting an item
                // $currency_id = $_POST['currency_id'];
                $inputJSON = file_get_contents('php://input');
                $input = json_decode($inputJSON, true);
                $currency_id = $input['currency_id'];
                $sql = "DELETE FROM currency WHERE currency_id='$currency_id'";

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
