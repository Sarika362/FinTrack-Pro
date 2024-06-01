<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// // Return a response to the client indicating successful logout
// echo "logout_success";

// Redirect to the index page or any other page after logout
header("Location: index.html");
exit();
?>