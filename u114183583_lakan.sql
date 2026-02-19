-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 18, 2026 at 11:01 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u114183583_lakan`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `membership_type_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `start_date_membership` datetime DEFAULT NULL,
  `end_date_membership` datetime DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_no` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `account_status` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `membership_type_id`, `last_name`, `first_name`, `middle_name`, `birth_date`, `age`, `gender`, `start_date_membership`, `end_date_membership`, `contact_no`, `emergency_contact_name`, `emergency_contact_no`, `civil_status`, `account_status`, `email`, `profile_pic`, `created_at`, `updated_at`) VALUES
(1, 4, 'Gajultos', 'Garry', '', '1999-12-18 00:00:00', '26', 'Male', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '09264753651', 'Marvin Dave Gajultos', '-', NULL, NULL, 'gajultos.garrydev@gmail.com', './../uploads/profile_picture/emp_1_1769675769.png', '2026-01-29 13:29:34', '2026-01-30 00:26:52'),
(4, 4, 'Rosell', 'Michelle', '', '2004-02-07 00:00:00', '21', 'Female', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 12:01:10', '2026-01-29 12:01:10'),
(5, 1, 'Dela Roca', 'Nilo', '', '1973-12-24 00:00:00', '52', 'Male', '2026-02-10 00:00:00', '2026-03-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 10:42:47', '2026-01-30 10:42:47'),
(6, 1, 'Villarosa', 'Arik', 'Nicholas', '2010-05-04 00:00:00', '15', 'Male', '2026-01-31 00:00:00', '2026-03-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 11:01:48', '2026-01-30 11:01:48'),
(7, 1, 'Villarosa', 'Ryan', 'Nicholas', '1986-06-30 00:00:00', '39', 'Male', '2026-01-31 00:00:00', '2026-03-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 11:02:29', '2026-01-30 11:02:29'),
(9, 1, 'San Pascual', 'Thaddeus', 'Gavilo', '1988-09-12 00:00:00', '37', 'Male', '2026-01-31 00:00:00', '2026-03-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 12:11:09', '2026-01-30 12:11:09'),
(10, 2, 'Pangilinan', 'Maverick', 'Libaton', '2002-10-30 00:00:00', '23', 'Male', '2026-01-01 00:00:00', '2026-03-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 12:12:56', '2026-01-30 12:12:56'),
(11, 3, 'Colcol', 'MJ', '', '1993-11-12 00:00:00', '32', 'Male', '2026-01-05 00:00:00', '2026-07-05 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-01-30 12:14:05', '2026-02-01 10:03:20'),
(12, 2, 'Jumapao', 'Dave Vincent', '', '1998-02-03 00:00:00', '27', 'Male', '2026-02-02 00:00:00', '2026-05-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 04:59:27', '2026-02-02 04:59:27'),
(13, 1, 'Villena', 'Jakob', 'Carpio', '2005-11-03 00:00:00', '20', 'Male', '2026-02-03 00:00:00', '2026-03-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 06:08:16', '2026-02-02 06:08:16'),
(14, 1, 'Peñaranda', 'Natasha', 'Baculo', '2002-10-08 00:00:00', '23', 'Female', '2026-02-02 00:00:00', '2026-03-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 08:49:04', '2026-02-02 08:49:04'),
(15, 1, 'Clemente', 'Louise Yuri Amhiel', 'Nicasio', '2005-07-03 00:00:00', '20', 'Male', '2026-02-02 00:00:00', '2026-03-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 08:49:56', '2026-02-02 08:49:56'),
(16, 1, 'De jesus', 'Loraine', '', '1994-11-24 00:00:00', '31', 'Female', '2026-02-02 00:00:00', '2026-03-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 10:10:21', '2026-02-02 10:10:21'),
(17, 1, 'Baluca', 'Rico', 'Aggabao', '2002-04-01 00:00:00', '23', 'Male', '2026-02-02 00:00:00', '2026-03-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 10:41:05', '2026-02-02 10:41:05'),
(18, 1, 'Castillo', 'Korina', 'Gonzales', '2000-03-30 00:00:00', '25', 'Female', '2026-02-05 00:00:00', '2026-03-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 10:42:02', '2026-02-02 10:42:02'),
(19, 1, 'Dykee', 'Garret', 'M', '2026-02-10 00:00:00', '-1', 'Male', '2026-02-02 00:00:00', '2026-03-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 10:55:19', '2026-02-02 10:55:19'),
(20, 1, 'Mendoza', 'Dan', 'Angana', '1993-08-05 00:00:00', '32', 'Male', '2026-02-06 00:00:00', '2026-03-06 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 01:50:26', '2026-02-03 01:50:26'),
(21, 1, 'Talavera', 'Luke', 'Barcelo', '2002-04-10 00:00:00', '23', 'Male', '2026-02-03 00:00:00', '2026-03-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 08:36:28', '2026-02-03 08:36:28'),
(22, 2, 'Singh', 'Jatinder', '', '2004-07-30 00:00:00', '21', 'Male', '2026-02-11 00:00:00', '2026-05-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 11:08:44', '2026-02-10 11:08:44'),
(23, 2, 'Singh', 'Jaswant', '', '1992-01-05 00:00:00', '34', 'Male', '2026-02-11 00:00:00', '2026-05-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 11:09:44', '2026-02-10 11:09:44'),
(24, 1, 'Tejada', 'Jazzer andre', 'Perez', '2004-06-27 00:00:00', '21', 'Male', '2026-02-11 00:00:00', '2026-03-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 11:41:47', '2026-02-10 11:41:47'),
(25, 1, 'Sunico', 'John hayes', 'Alticen', '2002-11-24 00:00:00', '23', 'Male', '2026-02-11 00:00:00', '2026-03-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 11:43:47', '2026-02-10 11:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `membership_history`
--

CREATE TABLE `membership_history` (
  `membership_history_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `membership_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `membership_type`
--

CREATE TABLE `membership_type` (
  `membership_type_id` int(11) NOT NULL,
  `membership_type_name` varchar(255) DEFAULT NULL,
  `membershiptype_price` varchar(255) DEFAULT NULL,
  `discount` varchar(255) NOT NULL,
  `membershiptype_description` varchar(255) DEFAULT NULL,
  `is_vip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `membership_type`
--

INSERT INTO `membership_type` (`membership_type_id`, `membership_type_name`, `membershiptype_price`, `discount`, `membershiptype_description`, `is_vip`, `created_at`, `updated_at`) VALUES
(1, '1 Month', '1499', '', '-', NULL, '2026-01-17 11:50:43', '2026-01-30 13:30:04'),
(2, '3  Months', '3499', '', '-', NULL, '2026-01-17 11:51:48', '2026-01-30 13:30:11'),
(3, '6 Months', '6499.00', '0', '-', NULL, '2026-01-17 11:51:59', '2026-02-14 16:01:01'),
(4, 'VIP', '0', '', '-', NULL, '2026-01-20 14:45:37', '2026-01-29 12:01:15'),
(8, '1 Month (30%)', '1049.30', '30', '30% less', NULL, '2026-02-14 16:01:18', '2026-02-14 16:01:18'),
(9, '3 Month (30%)', '2449.30', '30', '30% less', NULL, '2026-02-14 16:01:37', '2026-02-17 04:36:42'),
(10, '6 Months (30%)', '4549.30', '30', '30% less', NULL, '2026-02-14 16:02:00', '2026-02-14 16:02:00'),
(11, '1 Month (Student)', '999.00', '0', 'Student', NULL, '2026-02-14 16:03:29', '2026-02-14 16:03:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `lakan_user_id` int(11) NOT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `lakan_firstname` varchar(100) NOT NULL,
  `lakan_middlename` varchar(255) DEFAULT NULL,
  `lakan_lastname` varchar(100) NOT NULL,
  `lakan_username` varchar(100) DEFAULT NULL,
  `lakan_password` varchar(255) DEFAULT NULL,
  `lakan_pass_confirm` varchar(255) DEFAULT NULL,
  `account_activated` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lakan_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`lakan_user_id`, `user_type_id`, `lakan_firstname`, `lakan_middlename`, `lakan_lastname`, `lakan_username`, `lakan_password`, `lakan_pass_confirm`, `account_activated`, `created_at`, `updated_at`, `lakan_email`) VALUES
(1, 1, 'Garry', 'Dela Torre', 'Gajultos', 'garry', '$2y$10$XZYyuL2IeWpjTyb5b/A.eeCqbZ8t.ItcBd5VxdB47XSjsruR66hau', '123123', '1', '2026-01-20 21:06:39', '2026-01-29 15:39:15', 'gajultos.garrydev@gmail.com'),
(293, NULL, 'John Edmund', 'Factura', 'Alarde', 'joed', '$2y$10$V3WHudCGjI52UpSsYRx1V.a2HOh.oBLbnPSpTXkYVwXDYq441KIAG', '123123', NULL, '2026-01-29 15:32:00', '2026-01-29 15:39:03', 'joed@gmail.com'),
(294, NULL, 'Teof', '', 'Adora', 'teofadora', '$2y$10$GCSYXMUCLM.9.13dPFg0huJ9jDVVIORWFuNEEcua19z3hogfKPrZu', '123456789', NULL, '2026-01-29 11:25:36', '2026-01-29 12:06:03', 'teofilo.adora@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`) USING BTREE;

--
-- Indexes for table `membership_history`
--
ALTER TABLE `membership_history`
  ADD PRIMARY KEY (`membership_history_id`) USING BTREE;

--
-- Indexes for table `membership_type`
--
ALTER TABLE `membership_type`
  ADD PRIMARY KEY (`membership_type_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`lakan_user_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `membership_history`
--
ALTER TABLE `membership_history`
  MODIFY `membership_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `membership_type`
--
ALTER TABLE `membership_type`
  MODIFY `membership_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `lakan_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
