<?php
// Assuming you have already connected to your database
// Replace the database credentials with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finance_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start or resume session
session_start();
// Assign user_id from session
$user_id = $_SESSION['user_id'];

// Fetch balance, start_date, end_date, and source from the loan table
$sql = "SELECT balance, start_date, end_date, source FROM loan where user_id='$user_id'";
$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close connection
$conn->close();

// Output the data as JSON
echo json_encode($data);
?>
