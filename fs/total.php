<?php
session_start();

// Include the database configuration file
include 'config.php';

// Initialize variables
$total_trading_expense = 0;
$total_trading_income = 0;
$total_trading_profit = 0;
$total_trading_savings = 0;
$total_assets_expense = 0;
$total_assets_income = 0;
$total_assets_profit = 0;
$total_assets_savings = 0;

// Check if user is logged in and get user ID
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect or handle unauthenticated user
    exit("");
}

try {
    // Database connection from config.php
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Trading
    
    // Function to fetch total price from a table for a specific user
    function fetchTotalPrice($table_name, $price_column, $user_id, $pdo) {
        $stmt = $pdo->prepare("SELECT SUM($price_column) AS total_price FROM $table_name WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC); 
        return $result['total_price'];
    }

    // Calculate total trading expenses
    $total_trading_expense += fetchTotalPrice("stocks", "openingprice", $user_id, $pdo);
    $total_trading_expense += fetchTotalPrice("currency", "bought_price", $user_id, $pdo);
    $total_trading_expense += fetchTotalPrice("commodity", "opening_price", $user_id, $pdo);

    // Calculate total trading income
    $total_trading_income += fetchTotalPrice("stocks", "closingprice", $user_id, $pdo);
    $total_trading_income += fetchTotalPrice("currency", "sell_price", $user_id, $pdo);
    $total_trading_income += fetchTotalPrice("commodity", "closing_price", $user_id, $pdo);

    // Calculate total trading profit
    $stmt = $pdo->prepare("SELECT SUM(profit) AS total_profit FROM (SELECT closingprice - openingprice AS profit FROM stocks WHERE user_id = :user_id
                        UNION ALL
                        SELECT sell_price - bought_price AS profit FROM currency WHERE user_id = :user_id
                        UNION ALL
                        SELECT closing_price - opening_price AS profit FROM commodity WHERE user_id = :user_id) AS profits");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $total_trading_profit = $stmt->fetch(PDO::FETCH_ASSOC)['total_profit'];

    // Calculate total trading savings
    $total_trading_savings = $total_trading_income - $total_trading_expense + $total_trading_profit;

    // Store trading totals in session
    $_SESSION['total_trading_expense'] = $total_trading_expense;
    $_SESSION['total_trading_income'] = $total_trading_income;
    $_SESSION['total_trading_profit'] = $total_trading_profit;
    $_SESSION['total_trading_savings'] = $total_trading_savings;

    // Assets
    
    // Function to fetch total price from a table for a specific user
    function fetchTotalAssetPrice($table_name, $price_column, $user_id, $pdo) {
        $stmt = $pdo->prepare("SELECT SUM($price_column) AS total_price FROM $table_name WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC); 
        return $result['total_price'];
    }

    // Calculate total assets expenses
    $total_assets_expense += fetchTotalAssetPrice("fixed", "purchase_price", $user_id, $pdo);
    $total_assets_expense += fetchTotalAssetPrice("liquid", "purchase_price", $user_id, $pdo);

    // Calculate total assets income
    $total_assets_income += fetchTotalAssetPrice("fixed", "selling_price", $user_id, $pdo);
    $total_assets_income += fetchTotalAssetPrice("liquid", "selling_price", $user_id, $pdo);

    // Calculate total assets profit
    $stmt = $pdo->prepare("SELECT SUM(profit) AS total_profit FROM (SELECT selling_price - purchase_price AS profit FROM fixed WHERE user_id = :user_id
                        UNION ALL
                        SELECT selling_price - purchase_price AS profit FROM liquid WHERE user_id = :user_id) AS profits");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $total_assets_profit = $stmt->fetch(PDO::FETCH_ASSOC)['total_profit'];

    // Calculate total assets savings
    $total_assets_savings = $total_assets_income - $total_assets_expense + $total_assets_profit;

    // Store asset totals in session
    $_SESSION['total_assets_expense'] = $total_assets_expense;
    $_SESSION['total_assets_income'] = $total_assets_income;
    $_SESSION['total_assets_profit'] = $total_assets_profit;
    $_SESSION['total_assets_savings'] = $total_assets_savings;

    // Total
    
    // Calculate total expenses
    $total_expense = $total_trading_expense + $total_assets_expense;

    // Calculate total income
    $total_income = $total_trading_income + $total_assets_income;

    // Calculate total profit
    $total_profit = $total_trading_profit + $total_assets_profit;

    // Calculate total savings
    $total_savings = $total_trading_savings + $total_assets_savings;

    // Store totals in session
    $_SESSION['total_expense'] = $total_expense;
    $_SESSION['total_income'] = $total_income;
    $_SESSION['total_profit'] = $total_profit;
    $_SESSION['total_savings'] = $total_savings;


    // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE for income table
    $sql_income = "INSERT INTO income (user_id, amount) VALUES ('$user_id', '$total_income') 
    ON DUPLICATE KEY UPDATE amount = '$total_income'";

    // Execute the SQL query for income table
    if ($conn->query($sql_income) === TRUE) {
        echo "Total income updated successfully. ";
    } else {
        echo "Error updating total income: " . $conn->error;
    }
    // Define the SQL query using INSERT INTO ... ON DUPLICATE KEY UPDATE for savings table
    $sql_savings = "INSERT INTO savings (user_id, amount) VALUES ('$user_id', '$total_savings') 
    ON DUPLICATE KEY UPDATE amount = '$total_savings'";
    // Execute the SQL query for savings table
    if ($conn->query($sql_savings) === TRUE) {
        echo "Total savings updated successfully. ";
    } else {
        echo "Error updating total savings: " . $conn->error;
    }

    // // Update income table
    // $sql_income = "UPDATE income SET total_income = '$total_income' WHERE user_id = '$user_id'";

    // // Update savings table
    // $sql_savings = "UPDATE savings SET total_savings = '$total_savings' WHERE user_id = '$user_id'";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
