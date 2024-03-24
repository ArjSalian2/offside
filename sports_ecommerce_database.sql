-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2024 at 12:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(100) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(56, 'red womens shoes', 10, 'red', 'womens', NULL, 'shoes', 6, 'red_shoes.webp', 'product 56 description red womens shoes'),
(57, 'white womens shoes', 10, 'white', 'womens', NULL, 'shoes', 10, 'white_shoes.webp', NULL),
(58, 'black womens shoes', 10, 'black', 'womens', NULL, 'shoes', 10, 'black_shoes.webp', NULL),
(59, 'red mens shoes', 10, 'red', 'mens', NULL, 'shoes', 10, 'red_shoes.webp', NULL),
(60, 'white mens shoes', 10, 'white', 'mens', NULL, 'shoes', 10, 'white_shoes.webp', NULL),
(61, 'black mens shoes', 10, 'black', 'mens', NULL, 'shoes', 10, 'black_shoes.webp', NULL),
(62, 'white womens t-shirt', 10, 'white', 'womens', NULL, 'tshirts', 10, 'womens_white_tshirt.webp', NULL),
(63, 'brown womens t-shirt', 10, 'brown', 'womens', NULL, 'tshirts', 10, 'womens_brown_tshirt.webp', NULL),
(64, 'black womens t-shirt', 10, 'black', 'womens', NULL, 'tshirts', 10, 'womens_black_tshirt.webp', NULL),
(65, 'white mens t-shirt', 10, 'white', 'mens', NULL, 'tshirts', 10, 'mens_white_tshirt.webp', NULL),
(66, 'brown mens t-shirt', 10, 'brown', 'mens', NULL, 'tshirts', 10, 'mens_brown_tshirt.webp', NULL),
(67, 'black mens t-shirt', 10, 'black', 'mens', NULL, 'tshirts', 10, 'mens_black_tshirt.webp', NULL),
(68, 'red womens trousers', 10, 'red', 'womens', NULL, 'trousers', 10, 'red_trousers.webp', NULL),
(69, 'white womens trousers', 10, 'white', 'womens', NULL, 'trousers', 10, 'womens_white_trousers.webp', NULL),
(70, 'black womens trousers', 10, 'black', 'womens', NULL, 'trousers', 10, 'womens_black_trousers.webp', NULL),
(71, 'red mens trousers', 10, 'red', 'mens', NULL, 'trousers', 10, 'red_trousers.webp', NULL),
(72, 'white mens trousers', 10, 'white', 'mens', NULL, 'trousers', 10, 'mens_white_trousers.webp', NULL),
(73, 'black mens trousers', 10, 'black', 'mens', NULL, 'trousers', 10, 'mens_black_trousers.webp', NULL),
(74, 'white womens hoodie', 10, 'white', 'womens', NULL, 'hoodies', 10, 'white_hoodie.webp', NULL),
(75, 'blue womens hoodie', 10, 'blue', 'womens', NULL, 'hoodies', 10, 'blue_hoodie.webp', NULL),
(76, 'black womens hoodie', 10, 'black', 'womens', NULL, 'hoodies', 10, 'black_hoodie.webp', NULL),
(77, 'white mens hoodie', 10, 'white', 'mens', NULL, 'hoodies', 10, 'white_hoodie.webp', NULL),
(78, 'blue mens hoodie', 10, 'blue', 'mens', NULL, 'hoodies', 10, 'blue_hoodie.webp', NULL),
(79, 'black mens hoodie', 10, 'black', 'mens', NULL, 'hoodies', 10, 'black_hoodie.webp', NULL),
(80, 'white womens cap', 10, 'white', 'womens', NULL, 'accessories', 10, 'white_cap.webp', NULL),
(81, 'black womens cap', 10, 'black', 'womens', NULL, 'accessories', 10, 'black_cap.webp', NULL),
(82, 'white mens cap', 10, 'white', 'mens', NULL, 'accessories', 10, 'white_cap.webp', NULL),
(83, 'black mens cap', 10, 'black', 'mens', NULL, 'accessories', 10, 'black_cap.webp', NULL),
(84, 'black womens bag', 10, 'red', 'womens', NULL, 'accessories', 10, 'black_bag.webp', NULL);

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
  `product_id` int(11) DEFAULT NULL,
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
  ADD KEY `reviews_ibfk_2` (`product_id`);

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
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `StatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OrderItemsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `shopping_basket`
--
ALTER TABLE `shopping_basket`
  MODIFY `BasketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `shopping_basket_items`
--
ALTER TABLE `shopping_basket_items`
  MODIFY `ShoppingBasketItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`OrderStatus`) REFERENCES `orderstatus` (`StatusID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`ReturnStatusID`) REFERENCES `returnstatus` (`ReturnStatusID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `product_configuration`
--
ALTER TABLE `product_configuration`
  ADD CONSTRAINT `product_configuration_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_configuration_ibfk_2` FOREIGN KEY (`VariationOptionID`) REFERENCES `variation_options` (`VariationOptionsID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `shopping_basket`
--
ALTER TABLE `shopping_basket`
  ADD CONSTRAINT `shopping_basket_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `shopping_basket_items`
--
ALTER TABLE `shopping_basket_items`
  ADD CONSTRAINT `shopping_basket_items_ibfk_1` FOREIGN KEY (`BasketID`) REFERENCES `shopping_basket` (`BasketID`),
  ADD CONSTRAINT `shopping_basket_items_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`UserTypeID`);

--
-- Constraints for table `variations`
--
ALTER TABLE `variations`
  ADD CONSTRAINT `variations_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `variation_options`
--
ALTER TABLE `variation_options`
  ADD CONSTRAINT `variation_options_ibfk_1` FOREIGN KEY (`VariationID`) REFERENCES `variations` (`VariationID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
