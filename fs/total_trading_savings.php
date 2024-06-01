<?php
session_start();

// Echo total savings
if(isset($_SESSION['total_trading_savings'])) {
    echo $_SESSION['total_trading_savings'];
}
?>
