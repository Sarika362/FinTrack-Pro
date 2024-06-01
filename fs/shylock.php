<?php
// Start or resume session
session_start();

// Include database configuration
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
        $result = $conn->query("SELECT * FROM shylock WHERE user_id='$user_id'");
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    case 'POST':
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
                $shylockData = json_decode(file_get_contents("php://input"));

                // Constant value for finance_id
                $finance_id = '1'; // Replace with your constant value

                // Extract data from request
                $borrower_name = $shylockData->borrower_name;
                $phone_number = $shylockData->phone_number;
                $lent_amount = $shylockData->lent_amount;
                $returned_amount = $shylockData->returned_amount;
                $balance_amount = $shylockData->balance_amount;
                $interest_rate = $shylockData->interest_rate;
                $start_date = $shylockData->start_date;
                $end_date = $shylockData->end_date;
                $status = $shylockData->status;

                // Insert data into database
                $sql = "INSERT INTO shylock (user_id, finance_id, borrower_name, phone_number, lent_amount, returned_amount, balance_amount, interest_rate, start_date, end_date, status)
                VALUES ('$user_id', '$finance_id', '$borrower_name', '$phone_number', '$lent_amount', '$returned_amount', '$balance_amount', '$interest_rate', '$start_date', '$end_date', '$status')";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "New record created successfully"));
                    // $stock_id=$_SESSION['stock_id'];
                } else {
                    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
                }
                break;

            case 'update':
                // Handle updating an item
                $shylockData = json_decode(file_get_contents("php://input"));

                // Extract data from request
                $shylock_id = $shylockData->shylock_id; // Retrieve shylock_id from request
                // $new_shylock_id = $shylockData->temp_shylock_id; // Retrieve new_stock_id from request
                $borrower_name = $shylockData->temp_borrower_name;
                $phone_number = $shylockData->temp_phone_number;
                $lent_amount = $shylockData->temp_lent_amount;
                $returned_amount = $shylockData->temp_returned_amount;
                $balance_amount = $shylockData->temp_balance_amount;
                $interest_rate = $shylockData->temp_interest_rate;
                $start_date = $shylockData->temp_start_date;
                $end_date = $shylockData->temp_end_date;
                $status = $shylockData->temp_status;

                // Update data in database
                $sql = "UPDATE shylock SET borrower_name='$borrower_name', phone_number='$phone_number', lent_amount='$lent_amount', returned_amount='$returned_amount', balance_amount='$balance_amount', interest_rate='$interest_rate', start_date='$start_date', end_date='$end_date', status='$status' WHERE shylock_id='$shylock_id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record updated successfully"));
                } else {
                    echo json_encode(array("error" => "Error updating record: " . $conn->error));
                }
                break;

            case 'delete':
                // Handle deleting an item
                // $stock_id = $_POST['stock_id'];
                // $sql = "DELETE FROM shylock WHERE stock_id='$stock_id'";
                
                // Handle deleting an item
                $inputJSON = file_get_contents('php://input');
                $input = json_decode($inputJSON, true);
                $shylock_id = $input['shylock_id'];
                $sql = "DELETE FROM shylock WHERE shylock_id='$shylock_id'";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record deleted successfully"));
                } else {
                    echo json_encode(array("error" => "Error deleting record: " . $conn->error));
                }
                break;
            default:
                // Invalid action
                echo json_encode(array("error" => "Invalid action"));
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
