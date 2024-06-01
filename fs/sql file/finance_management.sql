-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2024 at 02:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finance_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `expense_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`expense_id`, `asset_id`, `type`) VALUES
(3, 1, 'Fixed'),
(3, 2, 'Liquid');

-- --------------------------------------------------------

--
-- Table structure for table `commodity`
--

CREATE TABLE `commodity` (
  `user_id` int(11) DEFAULT NULL,
  `trading_id` int(11) DEFAULT NULL,
  `commodity_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `profit` decimal(10,2) NOT NULL,
  `opening_price` decimal(10,2) DEFAULT NULL,
  `closing_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commodity`
--

INSERT INTO `commodity` (`user_id`, `trading_id`, `commodity_id`, `name`, `unit`, `quantity`, `profit`, `opening_price`, `closing_price`) VALUES
(3, 3, 5, 'Gold', 'gram', 100, 1000.00, 6000.00, 7000.00),
(3, 3, 6, 'Silver', 'kg', 2, 10000.00, 30000.00, 40000.00),
(3, 3, 7, 'Platinum', 'grams', 950, 20000.00, 300000.00, 500000.00),
(5, 3, 8, 'Gold', 'Ounce', 10, 75000.00, 135000.00, 138750.00),
(5, 3, 9, 'Oil', 'Barrel', 100, 37500.00, 4500.00, 4650.00),
(5, 3, 10, 'Silver', 'Ounce', 20, 60000.00, 1875.00, 1950.00),
(5, 3, 11, 'Copper', 'Pound', 200, 45000.00, 300.00, 337.50),
(5, 3, 12, 'Natural Gas', 'Million BTU', 500, 90000.00, 187.50, 202.50);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `user_id` int(11) DEFAULT NULL,
  `trading_id` int(11) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `exchange_rate` decimal(10,5) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL,
  `bought_price` decimal(10,2) DEFAULT NULL,
  `sell_price` decimal(10,2) DEFAULT NULL,
  `selling_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`user_id`, `trading_id`, `currency_id`, `name`, `code`, `exchange_rate`, `profit`, `bought_price`, `sell_price`, `selling_date`) VALUES
(1, 2, 2, '123', '1', 11.00000, 11.00, 111.00, 11.00, '2024-03-12'),
(1, 2, 3, '1', '1', 22.00000, 22.00, 22.00, 22.00, '2024-02-29'),
(3, 2, 12, 'Bitcoin', 'BTC', 0.20000, 2000.00, 8000.00, 10000.00, '2024-03-12'),
(3, 2, 13, 'Etherium', 'ETH', 0.54000, 30000.00, 20000.00, 50000.00, '2024-03-07'),
(3, 2, 14, 'Cardeno', 'ADA', 0.39000, 1800.00, 3000.00, 4800.00, '2024-02-14'),
(3, 2, 15, 'Tether', 'TRC', 1.00000, 6200.00, 2000.00, 8200.00, '2024-01-10'),
(3, 2, 16, 'Stellar', 'XLM', 0.39000, 40000.00, 20000.00, 60000.00, '2024-01-10'),
(5, 2, 17, 'Euro', 'EUR', 1.18000, 14800.00, 8850.00, 9000.00, '2024-03-19'),
(5, 2, 18, 'British Pound', 'GBP', 1.36000, 20400.00, 10200.00, 10350.00, '2024-03-20'),
(5, 2, 19, 'Japanese Yen', 'JPY', 0.00950, 22500.00, 213750.00, 216000.00, '2024-03-21'),
(5, 2, 20, 'Australian Dollar', 'AUD', 0.72000, 36000.00, 27000.00, 27450.00, '2024-03-22'),
(5, 2, 21, 'Canadian Dollar', 'CAD', 0.78000, 30000.00, 23400.00, 23700.00, '2024-03-23');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `type`) VALUES
(1, 'Trading'),
(2, 'Finances'),
(3, 'Assets');

-- --------------------------------------------------------

--
-- Table structure for table `finances`
--

CREATE TABLE `finances` (
  `expense_id` int(11) DEFAULT NULL,
  `finance_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finances`
--

INSERT INTO `finances` (`expense_id`, `finance_id`, `type`) VALUES
(2, 1, 'Shylock'),
(2, 2, 'Loan');

-- --------------------------------------------------------

--
-- Table structure for table `fixed`
--

CREATE TABLE `fixed` (
  `user_id` int(11) DEFAULT NULL,
  `assets_id` int(11) DEFAULT NULL,
  `fixed_id` int(11) NOT NULL,
  `property_name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `date_acquired` date DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fixed`
--

INSERT INTO `fixed` (`user_id`, `assets_id`, `fixed_id`, `property_name`, `type`, `date_acquired`, `purchase_price`, `selling_price`, `profit`) VALUES
(3, 1, 9, 'SGR', 'Land', '2023-12-07', 400000.00, 600000.00, 200000.00),
(3, 1, 10, 'MTR', 'House', '2024-03-11', 1000000.00, 1500000.00, 500000.00),
(3, 1, 11, 'SMT', 'Villa', '2023-11-15', 2000000.00, 3000000.00, 1000000.00),
(3, 1, 12, 'MS', 'Bakery', '2024-03-06', 300000.00, 0.00, 0.00),
(5, 1, 13, 'Oakwood Villa', 'Residential', '2020-05-14', 5000000.00, 6200000.00, 1200000.00),
(5, 1, 14, 'Tech Park Building', 'Commercial', '2018-09-19', 50000000.00, 65000000.00, 15000000.00),
(5, 1, 15, 'Farmland Estate', 'Agricultural', '2019-07-09', 3000000.00, 3800000.00, 800000.00),
(5, 1, 16, 'Lakeside Resort', 'Hospitality', '2021-02-07', 25000000.00, 32000000.00, 7000000.00),
(5, 1, 17, 'Office Space Tower', 'Commercial', '2017-11-11', 40000000.00, 50000000.00, 10000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `user_id` int(11) NOT NULL,
  `income_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`user_id`, `income_id`, `amount`) VALUES
(3, 1, 6985352.00),
(5, 24, 171255622.50);

-- --------------------------------------------------------

--
-- Table structure for table `liquid`
--

CREATE TABLE `liquid` (
  `user_id` int(11) DEFAULT NULL,
  `assets_id` int(11) DEFAULT NULL,
  `liquid_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date_acquired` date DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liquid`
--

INSERT INTO `liquid` (`user_id`, `assets_id`, `liquid_id`, `name`, `quantity`, `date_acquired`, `purchase_price`, `selling_price`, `profit`) VALUES
(3, 2, 6, 'Bonds', 1, '2024-02-29', 30000.00, 40000.00, 10000.00),
(3, 2, 7, 'Stocks', 300, '2024-02-28', 50000.00, 100000.00, 50000.00),
(3, 2, 8, 'Cars', 1, '2024-02-07', 200000.00, 300000.00, 100000.00),
(3, 2, 9, 'Bike', 1, '2024-02-26', 100000.00, 150000.00, 50000.00),
(3, 2, 10, 'Gold', 40, '2024-03-05', 500000.00, 600000.00, 100000.00),
(5, 2, 11, 'Gold Bars', 10, '2023-05-14', 1500000.00, 1800000.00, 300000.00),
(5, 2, 12, 'Government Bonds', 100, '2022-10-19', 2000000.00, 2200000.00, 200000.00),
(5, 2, 13, 'Mutual Fund Units', 500, '2021-07-09', 1000000.00, 1300000.00, 300000.00),
(5, 2, 14, 'Corporate Shares', 200, '2024-02-27', 1800000.00, 2500000.00, 700000.00),
(5, 2, 15, 'Fixed deposit', 1, '2020-11-11', 3000000.00, 3600000.00, 600000.00);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `user_id` int(11) DEFAULT NULL,
  `finance_id` int(11) DEFAULT NULL,
  `loan_id` int(11) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `principal_amount` decimal(10,2) DEFAULT NULL,
  `installments` int(11) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `term` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`user_id`, `finance_id`, `loan_id`, `source`, `type`, `principal_amount`, `installments`, `balance`, `term`, `start_date`, `end_date`) VALUES
(3, 2, 2, 'SBI', 'Loan', 100000.00, 10000, 50000.00, '6', '2024-01-31', '2024-06-30'),
(3, 2, 3, 'CANARA', 'Personal Loan', 50000.00, 3000, 20000.00, '8', '2024-03-20', '2024-10-22'),
(3, 2, 4, 'HDFC', 'Student Loan', 100000.00, 0, 50000.00, '10', '2024-02-29', '2025-01-22'),
(3, 2, 5, 'AXIS', 'Business Loan', 500000.00, 30000, 200000.00, '12', '2024-03-12', '2024-06-05'),
(5, 2, 6, 'Bank of India', 'Personal loan', 200000.00, 36, 150000.00, '3', '2023-07-14', '2026-07-14'),
(5, 2, 7, 'HDFC Bank', 'Home loan', 1500000.00, 120, 1200000.00, '10', '2022-11-19', '2032-11-19'),
(5, 2, 8, 'State Bank of India', 'Education Loan', 300000.00, 24, 200000.00, '2', '2023-04-09', '2025-04-09'),
(5, 2, 9, 'ICICI Bank', 'Car Loan', 800000.00, 60, 600000.00, '5', '2023-01-04', '2028-01-04'),
(5, 2, 10, 'Axis Bank', 'Zero Interest Loan', 100000.00, 12, 50000.00, '1', '2024-02-29', '2025-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `user_id` int(11) DEFAULT NULL,
  `savings_id` int(11) NOT NULL,
  `amount` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`user_id`, `savings_id`, `amount`) VALUES
(3, 1, 4019644.00),
(4, 22, 0.00),
(5, 24, 76228082.50);

-- --------------------------------------------------------

--
-- Table structure for table `shylock`
--

CREATE TABLE `shylock` (
  `user_id` int(11) DEFAULT NULL,
  `finance_id` int(11) DEFAULT NULL,
  `shylock_id` int(11) NOT NULL,
  `borrower_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `lent_amount` decimal(10,2) DEFAULT NULL,
  `returned_amount` decimal(10,2) DEFAULT NULL,
  `balance_amount` decimal(10,2) DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shylock`
--

INSERT INTO `shylock` (`user_id`, `finance_id`, `shylock_id`, `borrower_name`, `phone_number`, `lent_amount`, `returned_amount`, `balance_amount`, `interest_rate`, `start_date`, `end_date`, `status`) VALUES
(3, 1, 4, 'Josh', '9047890321', 30000.00, 20000.00, 10000.00, 0.00, '2024-01-31', '2024-06-19', 'pending'),
(3, 1, 5, 'Adam', '9803098201', 50000.00, 10000.00, 40000.00, 3.00, '2024-01-03', '2024-08-01', 'pending'),
(3, 1, 6, 'Abhishek', '8123737262', 100000.00, 50000.00, 50000.00, 5.00, '2023-12-13', '2024-06-20', 'pending'),
(3, 1, 7, 'Anya', '7927978923', 20000.00, 20000.00, 0.00, 0.00, '2024-02-29', '2024-03-09', 'cleared'),
(5, 1, 8, 'Rahul Sharma', '+91 9876543210', 50000.00, 10000.00, 40000.00, 10.00, '2023-05-14', '2024-05-14', 'Active'),
(5, 1, 9, 'Priya Singh', '+91 99887 65432', 30000.00, 5000.00, 25000.00, 12.00, '2023-08-19', '2024-08-19', 'Active'),
(5, 1, 10, 'Amit Patel', '+91 77665 12345', 70000.00, 20000.00, 50000.00, 8.00, '2023-03-09', '2024-03-09', 'Default'),
(5, 1, 11, 'Neha Gupta', '+91 78901 23456', 20000.00, 2000.00, 18000.00, 15.00, '2023-11-24', '2024-11-24', 'Closed'),
(5, 1, 12, 'Rajesh', '+91 88999 56789', 60000.00, 30000.00, 30000.00, 0.00, '2023-02-07', '2024-02-07', 'Paid Off');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `user_id` int(11) DEFAULT NULL,
  `trading_id` int(11) DEFAULT NULL,
  `stock_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `profit` decimal(10,2) NOT NULL,
  `openingprice` decimal(10,2) DEFAULT NULL,
  `closingprice` decimal(10,2) DEFAULT NULL,
  `selling_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`user_id`, `trading_id`, `stock_id`, `name`, `symbol`, `quantity`, `profit`, `openingprice`, `closingprice`, `selling_date`) VALUES
(1, 1, 2, '1', '11', 1, 1.00, 1.00, 1.00, '2024-03-05'),
(1, 1, 3, 'abc', 'cag', 12, 0.00, NULL, NULL, NULL),
(1, 1, 4, 'rr', 'rat', 13, 0.00, NULL, NULL, NULL),
(1, 1, 5, 'tat', 'twc', 15, 0.00, NULL, NULL, NULL),
(1, 1, 6, 'g', 'gg', 10, 0.00, NULL, NULL, NULL),
(1, 1, 8, '1', '1', 1, 0.00, NULL, NULL, NULL),
(1, 1, 9, '1', '1', 1, 0.00, 0.00, 0.00, '2024-02-29'),
(1, 1, 10, '2', '2', 2, 0.00, 2.00, 2.00, '2024-02-29'),
(3, 1, 26, 'Nvidia Ltd', 'N', 30, 392.00, 1730.00, 2122.00, '2024-02-29'),
(3, 1, 27, 'Apple inc', 'A', 25, 230.00, 2000.00, 2230.00, '2024-02-14'),
(3, 1, 28, 'Samsung tech', 'S', 30, 3000.00, 1000.00, 4000.00, '2024-03-06'),
(5, 1, 29, 'Apple Inc', 'AAPL', 100, 37500.00, 11318.75, 11655.00, '2024-03-19'),
(5, 1, 30, 'Microsoft Corporation', 'MSFT', 75, 22500.00, 18807.50, 19185.00, '2024-03-20'),
(5, 1, 31, 'Amazon.com Inc', 'AMZN', 50, 75000.00, 225037.50, 2228806.25, '2024-03-21'),
(5, 1, 32, 'Alphabet Inc', 'GOOGL', 200, 52500.00, 135045.00, 136942.50, '2024-03-22'),
(5, 1, 33, 'Facebook, Inc.', 'FB', 150, 30000.00, 26310.00, 26643.75, '2024-03-23');

-- --------------------------------------------------------

--
-- Table structure for table `trading`
--

CREATE TABLE `trading` (
  `expense_id` int(11) DEFAULT NULL,
  `trading_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trading`
--

INSERT INTO `trading` (`expense_id`, `trading_id`, `type`) VALUES
(1, 1, 'Stocks'),
(1, 2, 'Currency'),
(1, 3, 'Commodity');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `email`, `password`, `hashed_password`) VALUES
(1, 'abc', 'abc', 'abc@gmail.com', 'abcd', '$2y$10$iO1gujC0yu9xEJN8qFsx1.Uj2i.TjSxfhEU6KyAMv.L82KX32NN9S'),
(2, 'siri', 'siri', 'siri@gmail.com', 'siri', '$2y$10$wt4Enzgf2pxE.JJxkzZusuBtux0x/cJ3at8ILsfJ5H5s2mEryYV.e'),
(3, 'shashank', 'lightx22', 'lightyagami94848@gmail.com', '123456789', '$2y$10$dh7FtH9eZURv4yaNyVp9/eThQrAlDYuVe0AaXy1Rmwv7JlaES1d7q'),
(4, 'krishna', 'krishna', 'krishna@gmail.com', 'krishna', '$2y$10$qOV1r.EP4N3GEc0ROszCG.YmwyJm5YKDv/9WJx.xX8Vd9oWzQcTYC'),
(5, 'Sirisha', 'sirisha', 'sirisha.362@gmail.com', 'siri362', '$2y$10$tde6vN/Lq8RZTMYDRMbqWeS5MOBDWkKpkyjB4FE7.Y5.prYhGeYTS');

-- --------------------------------------------------------

--
-- Table structure for table `website_settings`
--

CREATE TABLE `website_settings` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_number` varchar(10) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_settings`
--

INSERT INTO `website_settings` (`user_id`, `user_name`, `user_password`, `user_number`, `user_email`, `user_description`) VALUES
(1, NULL, '$2y$10$iO1gujC0yu9xEJN8qFsx1.Uj2i.TjSxfhEU6KyAMv.L82KX32NN9S', NULL, NULL, NULL),
(3, 'lightx22', '$2y$10$dh7FtH9eZURv4yaNyVp9/eThQrAlDYuVe0AaXy1Rmwv7JlaES1d7q', '9876543211', 'lightyagami94848@gmail.com', 'shashank\'s finance app'),
(4, 'krishna', '$2y$10$qOV1r.EP4N3GEc0ROszCG.YmwyJm5YKDv/9WJx.xX8Vd9oWzQcTYC', 'krishna', 'krishna@gmail.com', 'krishna'),
(5, 'sirisha', '$2y$10$tde6vN/Lq8RZTMYDRMbqWeS5MOBDWkKpkyjB4FE7.Y5.prYhGeYTS', '7338016644', 'sirisha.362@gmail.com', 'siri\'s finance app');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `expense_id` (`expense_id`);

--
-- Indexes for table `commodity`
--
ALTER TABLE `commodity`
  ADD PRIMARY KEY (`commodity_id`),
  ADD KEY `trading_id` (`trading_id`),
  ADD KEY `fk_commodity_user_id` (`user_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`),
  ADD KEY `trading_id` (`trading_id`),
  ADD KEY `fk_currency_user_id` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `finances`
--
ALTER TABLE `finances`
  ADD PRIMARY KEY (`finance_id`),
  ADD KEY `expense_id` (`expense_id`);

--
-- Indexes for table `fixed`
--
ALTER TABLE `fixed`
  ADD PRIMARY KEY (`fixed_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assets_id` (`assets_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD UNIQUE KEY `income_id` (`user_id`) USING BTREE;

--
-- Indexes for table `liquid`
--
ALTER TABLE `liquid`
  ADD PRIMARY KEY (`liquid_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assets_id` (`assets_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `finance_id` (`finance_id`),
  ADD KEY `fk_loan_user_id` (`user_id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`savings_id`) USING BTREE,
  ADD UNIQUE KEY `savings_id` (`user_id`) USING BTREE;

--
-- Indexes for table `shylock`
--
ALTER TABLE `shylock`
  ADD PRIMARY KEY (`shylock_id`),
  ADD KEY `finance_id` (`finance_id`),
  ADD KEY `fk_shylock_user_id` (`user_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `trading_id` (`trading_id`),
  ADD KEY `fk_stocks_user_id` (`user_id`);

--
-- Indexes for table `trading`
--
ALTER TABLE `trading`
  ADD PRIMARY KEY (`trading_id`),
  ADD KEY `expense_id` (`expense_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `website_settings`
--
ALTER TABLE `website_settings`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commodity`
--
ALTER TABLE `commodity`
  MODIFY `commodity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `finances`
--
ALTER TABLE `finances`
  MODIFY `finance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fixed`
--
ALTER TABLE `fixed`
  MODIFY `fixed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `liquid`
--
ALTER TABLE `liquid`
  MODIFY `liquid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `savings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `shylock`
--
ALTER TABLE `shylock`
  MODIFY `shylock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `trading`
--
ALTER TABLE `trading`
  MODIFY `trading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`expense_id`);

--
-- Constraints for table `commodity`
--
ALTER TABLE `commodity`
  ADD CONSTRAINT `commodity_ibfk_1` FOREIGN KEY (`trading_id`) REFERENCES `trading` (`trading_id`),
  ADD CONSTRAINT `fk_commodity_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `currency`
--
ALTER TABLE `currency`
  ADD CONSTRAINT `currency_ibfk_1` FOREIGN KEY (`trading_id`) REFERENCES `trading` (`trading_id`),
  ADD CONSTRAINT `fk_currency_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `finances`
--
ALTER TABLE `finances`
  ADD CONSTRAINT `finances_ibfk_1` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`expense_id`);

--
-- Constraints for table `fixed`
--
ALTER TABLE `fixed`
  ADD CONSTRAINT `fixed_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fixed_ibfk_2` FOREIGN KEY (`assets_id`) REFERENCES `assets` (`asset_id`);

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `liquid`
--
ALTER TABLE `liquid`
  ADD CONSTRAINT `liquid_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `liquid_ibfk_2` FOREIGN KEY (`assets_id`) REFERENCES `assets` (`asset_id`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `fk_loan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`finance_id`) REFERENCES `finances` (`finance_id`);

--
-- Constraints for table `savings`
--
ALTER TABLE `savings`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `shylock`
--
ALTER TABLE `shylock`
  ADD CONSTRAINT `fk_shylock_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `shylock_ibfk_1` FOREIGN KEY (`finance_id`) REFERENCES `finances` (`finance_id`);

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `fk_stocks_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`trading_id`) REFERENCES `trading` (`trading_id`);

--
-- Constraints for table `trading`
--
ALTER TABLE `trading`
  ADD CONSTRAINT `trading_ibfk_1` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`expense_id`);

--
-- Constraints for table `website_settings`
--
ALTER TABLE `website_settings`
  ADD CONSTRAINT `website_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
