<?php
session_start();

// Check if user is logged in and session contains username
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true && isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "Guest"; // Display "Guest" if user is not logged in
}
?>
