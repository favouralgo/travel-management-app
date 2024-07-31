-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 01:30 PM
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
  `mypassword` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `adminname`, `email`, `mypassword`, `created_at`, `role`) VALUES
(3, 'Madu', 'favourmdev@gmail.com', '$2y$10$gDjNzKFsgBFNRS5qcU/rhuqtlzLxevE2xlJAD86Euc5g4.Z56Sp8a', '2024-07-24 00:20:17', 1),
(4, 'Quality', 'quality@gmail.com', '$2y$10$/tpCO6joSG5QfczxUpQl9e92w5cRq6vs6JUYNxw5LH474.H1gkhTO', '2024-07-24 05:19:22', 2),
(5, 'People', 'people@gmail.com', '$2y$10$0qXPUO0LRSsW2znYK5FrAODk.lpZaHmSMKB9bxkGkMCCJxVMy.Enq', '2024-07-24 18:47:48', 2),
(6, 'Batman', 'testadmin@admin.com', '$2y$10$CwYsdrlF3BlSKwbTTqxjku7neL2sho4xqSv5QGjQYkQ91N.QQ9swW', '2024-07-25 08:40:26', 2),
(7, 'Emmanuel', 'emma@gmail.com', '$2y$10$iKVJhywsad4OAH2g2cxr3e2uQ6pDXWngQJOvDQKysekxBDQJqlTz2', '2024-07-30 14:42:34', 2),
(9, 'Neon', 'neon@gmail.com', '$2y$10$MewgyuiN5/8i8FbeL4fxx..9buGxz5oWmBUidBXnY6clpps1SQiba', '2024-07-31 09:10:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone_number` int(30) NOT NULL,
  `num_of_guests` int(10) NOT NULL,
  `checkin_date` date NOT NULL,
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
(1, 'Ruto M', 549722299, 3, '0000-00-00', 'Konkonuru', 'Pending', 3, 1, '', '2024-06-26 18:05:50'),
(2, 'Malema', 547890123, 2, '0000-00-00', 'Cantonment', 'Pending', 4, 1, '', '2024-06-26 18:05:50'),
(3, 'Amin', 54671221, 3, '0000-00-00', 'Konkonuru', 'Pending', 3, 1, '', '2024-06-26 19:11:46'),
(15, 'No', 203456789, 3, '2024-06-28', 'Cantonment', 'Pending', 4, 4, '100', '2024-06-27 19:06:06'),
(16, 'Utali', 203456589, 2, '2024-07-20', 'Cantonment', 'Booked Successfully', 4, 5, '1000', '2024-07-03 20:56:10'),
(18, 'Bube', 203456589, 3, '2024-07-17', 'Accra', 'Pending', 1, 7, '600', '2024-07-16 08:53:23'),
(20, 'cool', 203456589, 2, '2024-07-31', 'Ketasco', 'Booked Successfully', 13, 10, '1000', '2024-07-30 03:03:09'),
(21, 'dev', 203456789, 1, '2024-07-31', 'Ketasco', 'Booked Successfully', 13, 10, '500', '2024-07-30 12:49:13');

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
  `region_id` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `image`, `trip_days`, `price`, `region_id`, `created_at`) VALUES
(1, 'Accra', 'offers-02.jpg', 4, '200', 1, '2024-06-25 15:00:27'),
(2, 'Kasoa', 'offers-02.jpg', 6, '450', 1, '2024-06-25 15:00:27'),
(3, 'Konkonuru', 'offers-02.jpg', 4, '600', 2, '2024-06-26 14:10:30'),
(4, 'Cantonment', 'deals-01.jpg', 5, '500', 2, '2024-06-26 14:10:30'),
(6, 'Aburi', 'deals-01.jpg', 5, '600', 3, '2024-07-25 00:17:05'),
(11, 'Prempeh', 'cities-03.jpg', 4, '2500', 4, '2024-07-29 18:21:25');

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
(2, 'Central', 'banner-02.jpg', '1500', 'Akosombo', 'A place to appreciate nature', '2024-06-25 14:57:18'),
(3, 'Western', 'banner-02.jpg', '1500', 'Kumasi', 'A place known as the food basket of the nation', '2024-07-24 20:16:36'),
(4, 'Upper', 'banner-02.jpg', '3500', 'Keta', 'Nice', '2024-07-29 20:43:23');

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
(5, 'huvoge@mailinator.com', 'gafib', '$2y$10$doY1bAvtPgrvGdps7yQNHuqWD8K1CMzozLN/pfDM04t.ma7HwGXyW', '2024-07-03 11:40:48'),
(6, 'gm@gmail.com', 'Loki', '$2y$10$5W/EBg6Jo.b6VUphsZbcyOrxxuOahWD32MsuGLZ8GZ/wBhftF9AXS', '2024-07-13 14:18:42'),
(7, 'amazingbrain01@gmail.com', 'Bube', '$2y$10$38HCBDLlzzj61fmtPG9UMOYaf9FwkWM8FcPnkZJ791rjsoFNlEKtO', '2024-07-16 08:51:45'),
(8, 'super@admin.com', 'Super', '$2y$10$FRClooDewvkRwR8XV63g8ulYF6JnD6oSwA8ecPHJdnB3647vx33VG', '2024-07-18 18:10:10'),
(10, 'fm@gmail.com', 'dev', '$2y$10$xAoPmX9c39vIt3OCcmMpAecsGrs1lxScliAA6HIkaSWY9svTnr0XW', '2024-07-24 20:24:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_region` (`region_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `fk_region` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
