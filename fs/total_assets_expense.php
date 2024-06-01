<?php
session_start();

// Echo total expense
if(isset($_SESSION['total_assets_expense'])) {
    echo $_SESSION['total_assets_expense'];
}
?>
