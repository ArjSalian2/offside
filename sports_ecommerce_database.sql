-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2024 at 09:40 PM
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
-- Database: `sports_ecommerce_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `AddressID` int(11) NOT NULL,
  `UserID` int(100) NOT NULL,
  `AddressLine` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Region` varchar(255) DEFAULT NULL,
  `Postcode` varchar(255) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`AddressID`, `UserID`, `AddressLine`, `City`, `Region`, `Postcode`, `Country`) VALUES
(1, 0, 'Aston St', 'Birmingham', 'West Midlands', 'B4 7ET', 'UK'),
(2, 0, 'Colmore Row', 'Birmingham', 'West Midlands', 'B3 EBJ', 'UK'),
(3, 0, 'Steelhouse Ln', 'Birmingham', 'West Midlands', 'B4 6SE', 'UK');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(100) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Name`) VALUES
(5, 'accessories'),
(1, 'hoodies'),
(3, 'shoes'),
(2, 'trousers'),
(4, 'tshirts');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(50) DEFAULT NULL,
  `OrderDate` date DEFAULT current_timestamp(),
  `OrderStatus` int(50) DEFAULT NULL,
  `AddressID` int(50) DEFAULT NULL,
  `TotalAmount` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `OrderDate`, `OrderStatus`, `AddressID`, `TotalAmount`) VALUES
(1, 9, '2023-12-05', 4, 1, 20),
(2, 8, '2023-12-05', 1, 2, 10),
(5, 12, '2024-03-18', 2, 3, 30),
(6, 10, '2024-03-18', 3, 1, 60),
(7, 9, '2024-03-18', 5, 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `StatusID` int(11) NOT NULL,
  `StatusName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderstatus`
--

INSERT INTO `orderstatus` (`StatusID`, `StatusName`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(3, 'Delivering'),
(4, 'Delivered'),
(5, 'Returned');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OrderItemsID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Price` int(50) DEFAULT NULL,
  `ReturnStatusID` int(100) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`OrderItemsID`, `ProductID`, `OrderID`, `Quantity`, `Price`, `ReturnStatusID`) VALUES
(1, 72, 1, 2, 20, 1),
(3, 68, 2, 1, 10, 1),
(5, 61, 1, 1, 10, 1),
(6, 56, 5, 1, 10, 1),
(7, 78, 5, 1, 10, 1),
(8, 73, 5, 1, 10, 1),
(9, 81, 6, 1, 10, 1),
(10, 58, 6, 1, 10, 1),
(11, 63, 6, 1, 10, 1),
(12, 84, 6, 1, 10, 1),
(13, 69, 6, 1, 10, 1),
(14, 76, 6, 1, 10, 1),
(15, 61, 7, 1, 10, 2),
(16, 67, 7, 1, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `AccountNumber` int(16) DEFAULT NULL,
  `ExpiryDate` int(11) DEFAULT NULL,
  `CVV` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_colour` varchar(43) NOT NULL,
  `product_gender` varchar(43) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `product_category` varchar(43) NOT NULL,
  `StockLevel` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `product_colour`, `product_gender`, `CategoryID`, `product_category`, `StockLevel`, `ImageURL`, `Description`) VALUES
(56, 'red womens shoes', 10, 'red', 'womens', 3, 'shoes', 50, 'red_shoes.webp', NULL),
(57, 'white womens shoes', 10, 'white', 'womens', 3, 'shoes', 39, 'white_shoes.webp', NULL),
(58, 'black womens shoes', 10, 'black', 'womens', 3, 'shoes', 30, 'black_shoes.webp', NULL),
(59, 'red mens shoes', 10, 'red', 'mens', 3, 'shoes', 25, 'red_shoes.webp', NULL),
(60, 'white mens shoes', 10, 'white', 'mens', 3, 'shoes', 45, 'white_shoes.webp', NULL),
(61, 'black mens shoes', 10, 'black', 'mens', 3, 'shoes', 64, 'black_shoes.webp', NULL),
(62, 'white womens t-shirt', 10, 'white', 'womens', 4, 'tshirts', 40, 'womens_white_tshirt.webp', NULL),
(63, 'brown womens t-shirt', 10, 'brown', 'womens', 4, 'tshirts', 34, 'womens_brown_tshirt.webp', NULL),
(64, 'black womens t-shirt', 10, 'black', 'womens', 4, 'tshirts', 76, 'womens_black_tshirt.webp', NULL),
(65, 'white mens t-shirt', 10, 'white', 'mens', 4, 'tshirts', 65, 'mens_white_tshirt.webp', NULL),
(66, 'brown mens t-shirt', 10, 'brown', 'mens', 4, 'tshirts', 23, 'mens_brown_tshirt.webp', NULL),
(67, 'black mens t-shirt', 10, 'black', 'mens', 4, 'tshirts', 87, 'mens_black_tshirt.webp', NULL),
(68, 'red womens trousers', 10, 'red', 'womens', 2, 'trousers', 54, 'red_trousers.webp', NULL),
(69, 'white womens trousers', 10, 'white', 'womens', 2, 'trousers', 76, 'womens_white_trousers.webp', NULL),
(70, 'black womens trousers', 10, 'black', 'womens', 2, 'trousers', 32, 'womens_black_trousers.webp', NULL),
(71, 'red mens trousers', 10, 'red', 'mens', 2, 'trousers', 34, 'red_trousers.webp', NULL),
(72, 'white mens trousers', 10, 'white', 'mens', 2, 'trousers', 23, 'mens_white_trousers.webp', NULL),
(73, 'black mens trousers', 10, 'black', 'mens', 2, 'trousers', 10, 'mens_black_trousers.webp', NULL),
(74, 'white womens hoodie', 10, 'white', 'womens', 1, 'hoodies', 43, 'white_hoodie.webp', NULL),
(75, 'blue womens hoodie', 10, 'blue', 'womens', 1, 'hoodies', 15, 'blue_hoodie.webp', NULL),
(76, 'black womens hoodie', 10, 'black', 'womens', 1, 'hoodies', 76, 'black_hoodie.webp', NULL),
(77, 'white mens hoodie', 10, 'white', 'mens', 1, 'hoodies', 22, 'white_hoodie.webp', NULL),
(78, 'blue mens hoodie', 10, 'blue', 'mens', 1, 'hoodies', 21, 'blue_hoodie.webp', NULL),
(79, 'black mens hoodie', 10, 'black', 'mens', 1, 'hoodies', 74, 'black_hoodie.webp', NULL),
(80, 'white womens cap', 10, 'white', 'womens', 5, 'accessories', 11, 'white_cap.webp', NULL),
(81, 'black womens cap', 10, 'black', 'womens', 5, 'accessories', 54, 'black_cap.webp', NULL),
(82, 'white mens cap', 10, 'white', 'mens', 5, 'accessories', 23, 'white_cap.webp', NULL),
(83, 'black mens cap', 10, 'black', 'mens', 5, 'accessories', 37, 'black_cap.webp', NULL),
(84, 'black womens bag', 10, 'red', 'womens', 5, 'accessories', 61, 'black_bag.webp', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_configuration`
--

CREATE TABLE `product_configuration` (
  `ProductID` int(11) DEFAULT NULL,
  `VariationOptionID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returnstatus`
--

CREATE TABLE `returnstatus` (
  `ReturnStatusID` int(100) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returnstatus`
--

INSERT INTO `returnstatus` (`ReturnStatusID`, `Name`) VALUES
(1, 'No Return'),
(2, 'Return Processed');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `OrderProductID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_basket`
--

CREATE TABLE `shopping_basket` (
  `BasketID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_basket_items`
--

CREATE TABLE `shopping_basket_items` (
  `ShoppingBasketItemID` int(11) NOT NULL,
  `BasketID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `First Name` varchar(100) NOT NULL,
  `Last Name` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Phone Number` varchar(100) NOT NULL,
  `user_type` int(11) NOT NULL,
  `Created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `First Name`, `Last Name`, `Email`, `Pass`, `Phone Number`, `user_type`, `Created`) VALUES
(7, 'first', 'last2', 'example@email.com', '$2y$10$5BsI59TrvvLRkLbk7MCUbeu2HUBhn6j9kEPHH7n0c/sPF1AFlIC1G', '00000 000000', 1, '2023-12-09'),
(8, 'Alex', 'Johnson', 'alex.johnson@example.com', '$2y$10$rqmgzEl4gYWo4iU4jR9iaOinTSADluH0jdxDpCH5cP1z83ePgWO6W', '555-123-4567', 1, '2024-03-18'),
(9, 'Micheal', 'Thompson', 'michael.thompson@example.com', '$2y$10$uuRk2xt9ZQimOap6jzwhDO55tAjh3Bjlp82pwMaOeLjQRLmSqHa3m', '555-321-9876', 1, '2024-03-18'),
(10, 'Samantha', 'Davies', 'samantha.davis@example.com', '$2y$10$1U4MLK2gn.5tDp1Yz2vRGunv2gfeIU4S.GbQNjMYs8bqqN9nbcoXa', '555-987-6543', 1, '2024-03-18'),
(11, 'Brian', 'Smith', 'brian.smith@example.com', '$2y$10$Gqmk1NgsDg5mWCauwRT3pO.kuWbnllBoV2s7qSM8AYD8A79QBkypG', '555-654-3210', 1, '2024-03-18'),
(12, 'Emily', 'Rodriguez', 'emily.rodriguez@example.com', '$2y$10$3JQJ5PU2yDNx3Wsd7q7wieYh1egmgg9i9Bm3bJker/lcqtnoad6di', '555-456-7891', 1, '2024-03-18'),
(13, 'Admin', 'User', 'admin.user@example.com', '$2y$10$J3pRTAiXIMkCDyS.1CdyOOAk.Ahid5y1HYSTaf98PsX7kKoL9bpba', '555-111-2222', 0, '2024-03-18');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `UserTypeID` int(11) NOT NULL,
  `Type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`UserTypeID`, `Type`) VALUES
(0, 'Admin'),
(1, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `VariationID` int(11) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variation_options`
--

CREATE TABLE `variation_options` (
  `VariationOptionsID` int(11) NOT NULL,
  `VariationID` int(11) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddressID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`),
  ADD UNIQUE KEY `FOREIGN` (`Name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `OrderStatus` (`OrderStatus`),
  ADD KEY `AddressID` (`AddressID`);

--
-- Indexes for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`StatusID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OrderItemsID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `order_items_ibfk_3` (`ReturnStatusID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `product_configuration`
--
ALTER TABLE `product_configuration`
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `VariationOptionID` (`VariationOptionID`);

--
-- Indexes for table `returnstatus`
--
ALTER TABLE `returnstatus`
  ADD PRIMARY KEY (`ReturnStatusID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `OrderProductID` (`OrderProductID`);

--
-- Indexes for table `shopping_basket`
--
ALTER TABLE `shopping_basket`
  ADD PRIMARY KEY (`BasketID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `shopping_basket_items`
--
ALTER TABLE `shopping_basket_items`
  ADD PRIMARY KEY (`ShoppingBasketItemID`),
  ADD KEY `BasketID` (`BasketID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `user_type` (`user_type`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`UserTypeID`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`VariationID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `variation_options`
--
ALTER TABLE `variation_options`
  ADD PRIMARY KEY (`VariationOptionsID`),
  ADD KEY `VariationID` (`VariationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `StatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OrderItemsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `returnstatus`
--
ALTER TABLE `returnstatus`
  MODIFY `ReturnStatusID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shopping_basket`
--
ALTER TABLE `shopping_basket`
  MODIFY `BasketID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shopping_basket_items`
--
ALTER TABLE `shopping_basket_items`
  MODIFY `ShoppingBasketItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `UserTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `variation_options`
--
ALTER TABLE `variation_options`
  MODIFY `VariationOptionsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`OrderStatus`) REFERENCES `orderstatus` (`StatusID`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `CategoryID_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
