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
        $result = $conn->query("SELECT * FROM stocks WHERE user_id='$user_id'");
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
                $stocksData = json_decode(file_get_contents("php://input"));

                // Constant value for trading_id
                $trading_id = '1'; // Replace with your constant value

                // Extract data from request
                $name = $stocksData->name;
                $symbol = $stocksData->symbol;
                $quantity = $stocksData->quantity;
                $profit = $stocksData->profit;
                $openingprice = $stocksData->openingprice;
                $closingprice = $stocksData->closingprice;
                $selling_date = $stocksData->selling_date;

                // Insert data into database
                $sql = "INSERT INTO stocks (user_id, trading_id, name, symbol, quantity, profit, openingprice, closingprice, selling_date)
                VALUES ('$user_id', '$trading_id', '$name', '$symbol', '$quantity', '$profit', '$openingprice', '$closingprice', '$selling_date')";


                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "New record created successfully"));
                    // $stock_id=$_SESSION['stock_id'];
                } else {
                    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
                }
                break;

            case 'update':
                // Handle updating an item
                $stocksData = json_decode(file_get_contents("php://input"));

                // Extract data from request
                $stock_id = $stocksData->stock_id; // Retrieve stock_id from request
                // $new_stock_id = $stocksData->temp_stock_id; // Retrieve new_stock_id from request
                $name = $stocksData->temp_name;
                $symbol = $stocksData->temp_symbol;
                $quantity = $stocksData->temp_quantity;
                $profit = $stocksData->temp_profit;
                $openingprice = $stocksData->temp_openingprice;
                $closingprice = $stocksData->temp_closingprice;
                $selling_date = $stocksData->temp_selling_date;

                // Update data in database
                $sql = "UPDATE stocks SET name='$name', symbol='$symbol', quantity='$quantity', profit='$profit', openingprice='$openingprice', closingprice='$closingprice', selling_date='$selling_date' WHERE stock_id='$stock_id'";

                // // Check if the new stock_id is already in use
                // $check_query = "SELECT * FROM stocks WHERE stock_id='$new_stock_id'";
                // $check_result = $conn->query($check_query);
                // if ($check_result->num_rows > 0) {
                //     echo json_encode(array("error" => "New stock ID is already in use"));
                //     exit; // Exit if the new stock_id is already in use
                // }

                // // Update data in database
                // $sql = "UPDATE stocks SET stock_id='$new_stock_id', name='$name', symbol='$symbol', quantity='$quantity', openingprice='$openingprice', closingprice='$closingprice', selling_date='$selling_date' WHERE stock_id='$stock_id'";

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record updated successfully"));
                } else {
                    echo json_encode(array("error" => "Error updating record: " . $conn->error));
                }
                break;

            case 'delete':
                // Handle deleting an item
                // $stock_id = $_POST['stock_id'];
                // $sql = "DELETE FROM stocks WHERE stock_id='$stock_id'";
                
                // Handle deleting an item
                $inputJSON = file_get_contents('php://input');
                $input = json_decode($inputJSON, true);
                $stock_id = $input['stock_id'];
                $sql = "DELETE FROM stocks WHERE stock_id='$stock_id'";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Record deleted successfully"));
                } else {
                    echo json_encode(array("error" => "Error deleting record: " . $conn->error));
                }
                break;
                // // Handle deleting an item
                // if (!isset($_POST['stock_id'])) {
                //     echo json_encode(array("error" => "Stock ID not provided"));
                //     exit;
                // }
                
                // $stock_id = $_POST['stock_id'];

                // // Construct the SQL query to delete the record
                // $sql = "DELETE FROM stocks WHERE stock_id='$stock_id'";

                // // Execute the query
                // if ($conn->query($sql) === TRUE) {
                //     echo json_encode(array("message" => "Record deleted successfully"));
                // } else {
                //     // Log the error to a file
                //     error_log("Error deleting record: " . $conn->error);

                //     echo json_encode(array("error" => "Error deleting record: " . $conn->error));
                // }
                // break;

                // // Handle deleting an item
                // // Check if identifier is provided in the request
                // if (!isset($_POST['identifier'])) {
                //     echo json_encode(array("error" => "Identifier not provided"));
                //     exit;
                // }
                
                // // Retrieve the identifier from the request
                // $identifier = $_POST['identifier'];
            
                // // Use the identifier to fetch the corresponding stock_id from the database
                // $result = $conn->query("SELECT stock_id FROM stocks WHERE name='$identifier' OR symbol='$identifier'");
                // if ($result->num_rows > 0) {
                //     $row = $result->fetch_assoc();
                //     $stock_id = $row['stock_id'];
                    
                //     // Construct the SQL query to delete the record
                //     $sql = "DELETE FROM stocks WHERE stock_id='$stock_id'";
            
                //     // Execute the query
                //     if ($conn->query($sql) === TRUE) {
                //         echo json_encode(array("message" => "Record deleted successfully"));
                //     } else {
                //         echo json_encode(array("error" => "Error deleting record: " . $conn->error));
                //     }
                // } else {
                //     echo json_encode(array("error" => "Stock record not found"));
                // }
                // break;

                // case 'delete':
                //     // // Handle deleting an item
                //     // $stock_id = $_POST['stock_id'];
                //     // $stock_id=$_SESSION['stock_id'];
                //     // $sql = "DELETE FROM stocks WHERE stock_id='$stock_id'";
                
                //     // if ($conn->query($sql) === TRUE) {
                //     //     echo json_encode(array("message" => "Record deleted successfully"));
                //     // } else {
                //     //     echo json_encode(array("error" => "Error deleting record: " . $conn->error));
                //     // }
                //     // break;

                //     // // Handle deleting an item
                //     // // Check if stock_id is provided in the request
                //     // if (!isset($_POST['stock_id'])) {
                //     //     echo json_encode(array("error" => "Stock ID not provided"));
                //     //     exit;
                //     // }
                    
                //     // // Retrieve stock_id from the request
                //     // $stock_id = $_POST['stock_id'];

                //     // // Construct the SQL query to delete the record
                //     // $sql = "DELETE FROM stocks WHERE stock_id='$stock_id'";

                //     // // Execute the query
                //     // if ($conn->query($sql) === TRUE) {
                //     //     echo json_encode(array("message" => "Record deleted successfully"));
                //     // } else {
                //     //     echo json_encode(array("error" => "Error deleting record: " . $conn->error));
                //     // }
                //     // break;

                //     // Handle deleting an item
                //     if (!isset($_POST['stock_id'])) {
                //         echo json_encode(array("error" => "Stock ID not provided"));
                //         exit;
                //     }
                    
                //     $stock_id = $_POST['stock_id'];
                //     $sql = "DELETE FROM stocks WHERE stock_id='$stock_id'";
                    
                //     if ($conn->query($sql) === TRUE) {
                //         echo json_encode(array("message" => "Record deleted successfully"));
                //     } else {
                //         echo json_encode(array("error" => "Error deleting record: " . $conn->error));
                //     }
                //     break;
                    
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
