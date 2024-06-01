<?php
session_start();

// Echo total savings
if(isset($_SESSION['total_savings'])) {
    echo $_SESSION['total_savings'];
}
?>
