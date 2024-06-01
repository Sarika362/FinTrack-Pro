<?php
session_start();

include_once "config.php";

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    // User is authenticated, retrieve the username from the database
    $user_id = $_SESSION['user_id'];

    // Query to fetch the username from the database based on user_id
    $stmt = $conn->prepare("SELECT username FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        echo $row['username'];
    } else {
        echo 'Error: User not found';
    }
} else {
    echo 'Guest';
}
?> 
