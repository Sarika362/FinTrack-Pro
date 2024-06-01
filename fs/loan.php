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
        $result = $conn->query("SELECT * FROM loan WHERE user_id='$user_id'");
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
                $loanData = json_decode(file_get_contents("php://input"));

                // Constant value for finance_id
                $finance_id = '2'; // Replace with your constant value

                // Extract data from request
                $source = $loanData->source;
                $type = $loanData->type;
                $principal_amount = $loanData->principal_amount;
                $installments = $loanData->installments;
                $balance = $loanData->balance;
                $term = $loanData->term;
                $start_date = $loanData->start_date;
                $end_date = $loanData->end_date;


                // Insert data into database
                $sql = "INSERT INTO loan (user_id, finance_id, source, type, principal_amount, installments, balance, term, start_date, end_date)
                VALUES ('$user_id', '$finance_id', '$source', '$type', '$principal_amount', '$installments', '$balance', '$term', '$start_date', '$end_date')";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "New record created successfully"));
                } else {
                    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
                }
                break;

            case 'update':
                // Handle updating an item
                $loanData = json_decode(file_get_contents("php://input"));

                // Extract data from request
                $loan_id = $loanData->loan_id; // Retrieve loan_id from request
                // $new_loan_id = $loanData->temp_loan_id; // Retrieve new_stock_id from request
                $source = $loanData->temp_source;
                $type = $loanData->temp_type;
                $principal_amount = $loanData->temp_principal_amount;
                $installments = $loanData->temp_installments;
                $balance = $loanData->temp_balance;
                $term = $loanData->temp_term;
                $start_date = $loanData->temp_start_date;
                $end_date = $loanData->temp_end_date;

                // Update data in database
                $sql = "UPDATE loan SET source='$source', type='$type', principal_amount='$principal_amount', installments='$installments', balance='$balance', term='$term', start_date='$start_date', end_date='$end_date' WHERE loan_id='$loan_id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record updated successfully"));
                } else {
                    echo json_encode(array("error" => "Error updating record: " . $conn->error));
                }
                break;

            case 'delete':
                
                // Handle deleting an item
                $inputJSON = file_get_contents('php://input');
                $input = json_decode($inputJSON, true);
                $loan_id = $input['loan_id'];
                $sql = "DELETE FROM loan WHERE loan_id='$loan_id'";
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
