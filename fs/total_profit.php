<?php
session_start();

// Echo total profit
if(isset($_SESSION['total_profit'])) {
    echo $_SESSION['total_profit'];
}
?>
