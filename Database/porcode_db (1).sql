-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2023 at 07:53 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `porcode_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_details`
--

CREATE TABLE `account_details` (
  `id` int(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_details`
--

INSERT INTO `account_details` (`id`, `bankname`, `account_name`, `account_number`, `type`) VALUES
(1, 'Opay', 'Hassan Abubakar', '9075379777', 'bank');

-- --------------------------------------------------------

--
-- Table structure for table `activation_numbers`
--

CREATE TABLE `activation_numbers` (
  `id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `product` varchar(70) NOT NULL,
  `price` varchar(10) NOT NULL,
  `expiry` varchar(100) NOT NULL,
  `created` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `forwarding` varchar(10) NOT NULL,
  `forwarding_number` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL,
  `order_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activation_numbers`
--

INSERT INTO `activation_numbers` (`id`, `user_id`, `operator`, `product`, `price`, `expiry`, `created`, `country`, `forwarding`, `forwarding_number`, `phone`, `status`, `order_id`) VALUES
(1, '', '', '', '', '', '', '', '', '', '', '', ''),
(2, '4', '', '', '', '', '', '', '', '', '', '', ''),
(3, '4', '', '', '', '', '', '', '', '', '', '', ''),
(4, '4', '', '', '', '', '', '', '', '', '', '', ''),
(5, '4', '', '', '', '', '', '', '', '', '', '', ''),
(6, '4', '', '', '', '', '', '', '', '', '', '', ''),
(7, '4', 'virtual40', 'fiverr', '21.5', '2023-09-07T13:13:33.79046149Z', '07-09-2023', 'usa', '', '', '+15743656277', 'RECEIVED', '498923638'),
(8, '4', 'virtual40', 'fiverr', '21.5', '2023-09-07T13:13:33.79046149Z', '07-09-2023', 'usa', '', '', '+15743656277', 'RECEIVED', '498923638'),
(9, '4', 'virtual40', 'fiverr', '21.5', '2023-09-07T13:13:33.79046149Z', '07-09-2023', 'usa', '', '', '+15743656277', 'RECEIVED', '498923638'),
(10, '4', 'virtual40', 'fiverr', '21.5', '2023-09-07T13:18:00.082233118Z', '07-09-2023', 'usa', '', '', '+16204777457', 'RECEIVED', '497672866'),
(11, '4', 'virtual4', 'offerup', '21.1', '2023-09-07T14:40:09.291368612Z', '07-09-2023', 'uruguay', '', '', '+59894940265', 'RECEIVED', '497672866');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profit`
--

CREATE TABLE `profit` (
  `id` int(255) NOT NULL,
  `percentage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profit`
--

INSERT INTO `profit` (`id`, `percentage`) VALUES
(1, '20');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topup`
--

CREATE TABLE `topup` (
  `id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `receipt` varchar(255) NOT NULL,
  `date` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topup`
--

INSERT INTO `topup` (`id`, `user_id`, `method`, `amount`, `receipt`, `date`, `status`) VALUES
(1, '', '', '', '', '', ''),
(2, '4', 'Manual', '100', 'uploads/amazon-logo.png.jpg', '03-09-2023', 'pending'),
(3, '4', 'Manual', '100', 'uploads/amazon-logo.png.jpg', '03-09-2023', 'pending'),
(4, '4', 'Manual', '100', 'uploads/amazon-logo.png.jpg', '03-09-2023', 'pending'),
(5, '4', 'Manual', '100', 'uploads/amazon-logo.png.jpg', '03-09-2023', 'pending'),
(6, '4', 'Manual', '10', 'uploads/landing-car.jpg', '06-09-2023', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(255) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `order_id` varchar(70) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `creation_date` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `order_id`, `amount`, `creation_date`, `status`) VALUES
(2, '4', 'topup', '91968175', '10', '06-09-2023', 'completed'),
(3, '', '', '', '', '', ''),
(4, '4', 'Number Purchase', '498925156', '25.8', '07-09-2023', 'preparing'),
(5, '4', 'Purchase', '498952655', '25.32', '07-09-2023', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `balance`) VALUES
(1, 'Hassan Abubakar', 'bnsadiq82@gmail.com', '$2y$10$EPeXXz8gp2IAsnERUy.aZuWzGNELVpTCilXnQzkuaJeLxhUYr1fnG', ''),
(4, 'Ahmad Abdul', 'a@b.com', '$2y$10$225hYneZAAslokgXu/QlkuyveKLE3VlHopq4uU4qM7qQHJRet2rdm', '8.88');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_details`
--
ALTER TABLE `account_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activation_numbers`
--
ALTER TABLE `activation_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profit`
--
ALTER TABLE `profit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_details`
--
ALTER TABLE `account_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activation_numbers`
--
ALTER TABLE `activation_numbers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profit`
--
ALTER TABLE `profit`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topup`
--
ALTER TABLE `topup`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
