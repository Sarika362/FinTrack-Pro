<?php
session_start();

// Echo total income
if(isset($_SESSION['total_trading_income'])) {
    echo $_SESSION['total_trading_income'];
}
?>
