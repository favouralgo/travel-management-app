-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2024 at 10:26 AM
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
-- Database: `wooxtravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(4) NOT NULL,
  `adminname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mypassword` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone_number` int(30) NOT NULL,
  `num_of_guests` int(10) NOT NULL,
  `checkin_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `destination` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `city_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `payment` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `phone_number`, `num_of_guests`, `checkin_date`, `destination`, `status`, `city_id`, `user_id`, `payment`, `created_at`) VALUES
(1, 'Ruto M', 549722299, 3, '0000-00-00 00:00:00.000000', 'Konkonuru', 'Pending', 3, 1, '', '2024-06-26 18:05:50'),
(2, 'Malema', 547890123, 2, '0000-00-00 00:00:00.000000', 'Cantonment', 'Pending', 4, 1, '', '2024-06-26 18:05:50'),
(3, 'Amin', 54671221, 3, '0000-00-00 00:00:00.000000', 'Konkonuru', 'Pending', 3, 1, '', '2024-06-26 19:11:46'),
(15, 'No', 203456789, 3, '2024-06-28 00:00:00.000000', 'Cantonment', 'Pending', 4, 4, '100', '2024-06-27 19:06:06'),
(16, 'Utali', 203456589, 2, '2024-07-20 00:00:00.000000', 'Cantonment', 'Pending', 4, 5, '1000', '2024-07-03 20:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `trip_days` int(4) NOT NULL,
  `price` varchar(4) NOT NULL,
  `region_id` int(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `image`, `trip_days`, `price`, `region_id`, `created_at`) VALUES
(1, 'Accra', 'offers-02.jpg', 4, '200', 1, '2024-06-25 15:00:27'),
(2, 'Kasoa', 'offers-03.jpg', 6, '450', 1, '2024-06-25 15:00:27'),
(3, 'Konkonuru', 'offers-03.jpg', 4, '600', 2, '2024-06-26 14:10:30'),
(4, 'Cantonment', 'deals-01.jpg', 5, '500', 2, '2024-06-26 14:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `population` varchar(30) NOT NULL,
  `landmark` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`, `image`, `population`, `landmark`, `description`, `created_at`) VALUES
(1, 'Eastern', 'banner-01.jpg', '1000', 'Berekuso', 'A good place to rest and explore', '2024-06-25 14:57:18'),
(2, 'Central', 'banner-02.jpg', '1500', 'Akosombo', 'A place to appreciate nature', '2024-06-25 14:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `userpassword` varchar(200) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `userpassword`, `date_created`) VALUES
(4, 'favourmdev@gmail.com', 'dev', '$2y$10$EqVothqyVH.MtZJbbnYoleBPeYnmjFFrn3t0aj65jMgBusRrUHPhG', '2024-06-24 16:34:24'),
(5, 'huvoge@mailinator.com', 'gafib', '$2y$10$doY1bAvtPgrvGdps7yQNHuqWD8K1CMzozLN/pfDM04t.ma7HwGXyW', '2024-07-03 11:40:48'),
(6, 'gm@gmail.com', 'Loki', '$2y$10$5W/EBg6Jo.b6VUphsZbcyOrxxuOahWD32MsuGLZ8GZ/wBhftF9AXS', '2024-07-13 14:18:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
