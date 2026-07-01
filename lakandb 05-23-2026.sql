-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 23, 2026 at 01:01 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u831244580_lakan`
--

-- --------------------------------------------------------

--
-- Table structure for table `body_fats_history`
--

CREATE TABLE `body_fats_history` (
  `bodyfats_id` int(11) NOT NULL,
  `bodyfats_desc` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `date_saved_bodyfats` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `coaching_service`
--

CREATE TABLE `coaching_service` (
  `coaching_id` int(11) NOT NULL,
  `client_fullname` varchar(255) DEFAULT NULL,
  `coaching_price` varchar(255) DEFAULT NULL,
  `coaching_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `coaching_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `membership_type_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_paused` varchar(255) DEFAULT NULL,
  `date_paused` datetime DEFAULT NULL,
  `date_resumed` datetime DEFAULT NULL,
  `last_paused_date` datetime DEFAULT NULL,
  `payment_type` varchar(255) NOT NULL,
  `down_payment_amount` varchar(255) NOT NULL,
  `payment_terms` varchar(255) NOT NULL,
  `remaining_balance` varchar(255) NOT NULL,
  `months_term_remaining` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `membership_type_id`, `last_name`, `first_name`, `middle_name`, `birth_date`, `age`, `gender`, `start_date_membership`, `end_date_membership`, `contact_no`, `emergency_contact_name`, `emergency_contact_no`, `civil_status`, `account_status`, `email`, `profile_pic`, `created_at`, `updated_at`, `is_paused`, `date_paused`, `date_resumed`, `last_paused_date`, `payment_type`, `down_payment_amount`, `payment_terms`, `remaining_balance`, `months_term_remaining`) VALUES
(1, 4, 'Gajultos', 'Garry', '', '1999-12-18 00:00:00', '26', 'Male', NULL, NULL, '09264753651', 'Marvin Dave Gajultos', '-', NULL, NULL, 'gajultos.garrydev@gmail.com', './../uploads/profile_picture/emp_1_1775023382.png', '2026-01-29 13:29:34', '2026-04-01 06:03:02', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, 4, 'Rosell', 'Michelle', '', '2004-02-07 00:00:00', '22', 'Female', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_4_1775023555.jfif', '2026-01-29 12:01:10', '2026-04-01 06:05:55', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(5, 8, 'Dela Rosa', 'Nilo', '', '1973-12-24 00:00:00', '52', 'Male', '2026-03-15 00:00:00', '2026-04-15 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-01-30 10:42:47', '2026-03-19 15:01:12', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(6, 8, 'Villarosa', 'Arik', 'Nicholas', '2010-05-04 00:00:00', '15', 'Male', '2026-03-06 00:00:00', '2026-04-06 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 11:01:48', '2026-03-07 03:43:52', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(7, 1, 'Villarosa', 'Ryan', 'Nicholas', '1986-06-30 00:00:00', '39', 'Male', '2026-01-31 00:00:00', '2026-03-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 11:02:29', '2026-01-30 11:02:29', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(9, 1, 'San Pascual', 'Thaddeus', 'Gavilo', '1988-09-12 00:00:00', '37', 'Male', '2026-01-31 00:00:00', '2026-03-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 12:11:09', '2026-01-30 12:11:09', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(10, 2, 'Pangilinan', 'Maverick', 'Libaton', '2002-10-30 00:00:00', '23', 'Male', '2026-01-01 00:00:00', '2026-03-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 12:12:56', '2026-03-03 15:45:44', '1', '2026-02-16 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(11, 3, 'Colcol', 'MJ', '', '1993-11-12 00:00:00', '32', 'Male', '2026-01-05 00:00:00', '2026-07-05 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-01-30 12:14:05', '2026-02-01 10:03:20', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(12, 2, 'Jumapao', 'Dave Vincent', '', '1998-02-03 00:00:00', '28', 'Male', '2026-05-02 00:00:00', '2026-08-02 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_12_1775314472.jpg', '2026-02-02 04:59:27', '2026-05-12 23:19:12', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Full Payment', '0', '', '3499', '0'),
(13, 11, 'Villena', 'Jakob', 'Carpio', '2005-11-03 00:00:00', '20', 'Male', '2026-04-20 00:00:00', '2026-05-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 06:08:16', '2026-04-18 12:16:13', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(14, 1, 'Peñaranda', 'Natasha', 'Baculo', '2002-10-08 00:00:00', '23', 'Female', '2026-02-02 00:00:00', '2026-03-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 08:49:04', '2026-02-02 08:49:04', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(15, 1, 'Clemente', 'Louise Yuri Amhiel', 'Nicasio', '2005-07-03 00:00:00', '20', 'Male', '2026-02-02 00:00:00', '2026-03-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 08:49:56', '2026-02-02 08:49:56', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(16, 1, 'De Jesus', 'Loraine', '', '1994-11-24 00:00:00', '31', 'Female', '2026-02-02 00:00:00', '2026-03-02 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-02-02 10:10:21', '2026-03-03 06:01:12', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(17, 1, 'Baluca', 'Rico', 'Aggabao', '2002-04-01 00:00:00', '23', 'Male', '2026-02-02 00:00:00', '2026-03-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 10:41:05', '2026-02-02 10:41:05', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(18, 1, 'Castillo', 'Korina', 'Gonzales', '2000-03-30 00:00:00', '25', 'Female', '2026-02-05 00:00:00', '2026-03-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 10:42:02', '2026-02-02 10:42:02', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(19, 1, 'Dykee', 'Garret', 'M', '2000-02-06 00:00:00', '26', 'Male', '2026-02-02 00:00:00', '2026-03-02 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-02-02 10:55:19', '2026-03-02 16:42:56', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(20, 1, 'Mendoza', 'Dan', 'Angana', '1993-08-05 00:00:00', '32', 'Male', '2026-04-10 00:00:00', '2026-05-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 01:50:26', '2026-04-10 06:32:55', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(21, 8, 'Talavera', 'Luke', 'Barcelo', '2002-04-10 00:00:00', '23', 'Male', '2026-05-12 00:00:00', '2026-06-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 08:36:28', '2026-05-12 12:07:34', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Full Payment', '0', '', '1050', '0'),
(22, 2, 'Singh', 'Jatinder', '', '2004-07-30 00:00:00', '21', 'Male', '2026-05-12 00:00:00', '2026-08-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 11:08:44', '2026-05-12 11:24:34', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Full Payment', '0', '', '3499', '0'),
(23, 2, 'Singh', 'Jaswant', '', '1992-01-05 00:00:00', '34', 'Male', '2026-05-12 00:00:00', '2026-08-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 11:09:44', '2026-05-12 11:24:52', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Full Payment', '0', '', '3499', '0'),
(24, 1, 'Tejada', 'Jazzer andre', 'Perez', '2004-06-27 00:00:00', '21', 'Male', '2026-02-11 00:00:00', '2026-03-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 11:41:47', '2026-02-10 11:41:47', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(25, 11, 'Sunico', 'John hayes', 'Alticen', '2002-11-24 00:00:00', '23', 'Male', '2026-03-09 00:00:00', '2026-04-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 11:43:47', '2026-03-13 03:11:26', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(26, 1, 'Bart', 'Franz', '', '1993-10-19 00:00:00', '32', 'Male', '2026-02-19 00:00:00', '2026-03-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-19 12:13:36', '2026-02-19 12:13:36', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(27, 1, 'Alcorin', 'Jonas', 'Lare', '2003-07-05 00:00:00', '22', 'Male', '2026-02-23 00:00:00', '2026-03-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 11:52:30', '2026-02-23 11:52:30', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(28, 1, 'Jabat', 'Evan lawrenz', 'Espinoza', '2004-09-24 00:00:00', '21', 'Male', '2026-02-23 00:00:00', '2026-03-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 11:53:09', '2026-02-23 11:53:09', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(29, 1, 'Abrajano', 'Gene Michael', 'Navarro', '2004-07-03 00:00:00', '21', 'Male', '2026-02-23 00:00:00', '2026-03-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 13:54:04', '2026-02-23 13:54:04', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(30, 2, 'Gian', 'Castro', '', '1996-04-08 00:00:00', '29', 'Male', '2026-03-01 00:00:00', '2026-06-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 07:49:02', '2026-02-25 07:49:02', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(31, 3, 'De Leon', 'Teo', 'Servanez', '1994-09-20 00:00:00', '31', 'Male', '2026-04-20 00:00:00', '2026-10-20 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_31_1776671407.jpeg', '2026-02-27 08:09:21', '2026-04-20 07:50:09', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(32, 3, 'Tan', 'Rory', 'Tercio', '2002-06-13 00:00:00', '23', 'Male', '2026-04-30 00:00:00', '2026-10-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-27 11:06:13', '2026-04-30 08:52:17', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Downpayment', '1500', '3 Months', '4999', '3'),
(33, 1, 'Apolonio', 'Gilbert', '', '1969-02-12 00:00:00', '57', 'Male', '2026-03-01 00:00:00', '2026-04-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-01 07:25:29', '2026-03-01 07:25:29', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(34, 11, 'Bicaldo', 'Charm Beatrice', 'Telebrico', '2008-02-02 00:00:00', '18', 'Female', '2026-04-14 00:00:00', '2026-05-14 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-02 09:22:39', '2026-04-14 07:43:26', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(35, 12, 'Gerona', 'Danielle Angelo', '', '2000-01-20 00:00:00', '26', 'Male', '2026-03-02 00:00:00', '2026-07-12 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-03-02 09:26:08', '2026-04-28 10:59:53', '1', '2026-04-05 00:00:00', '2026-03-21 00:00:00', '2026-03-11 00:00:00', '', '', '', '', ''),
(36, 1, 'Apolonio', 'Levy', '', '1970-08-14 00:00:00', '55', 'Female', '2026-03-02 00:00:00', '2026-04-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-02 09:31:07', '2026-03-02 09:31:07', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', ''),
(37, 11, 'Loropan', 'Febrix Jaelo', 'Santos', '2001-11-29 00:00:00', '24', 'Male', '2026-03-03 00:00:00', '2026-04-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03 09:38:02', '2026-03-03 09:38:02', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(38, 1, 'Cristobal', 'Jezreel Clemence', '', '2005-08-26 00:00:00', '20', 'Male', '2026-03-03 00:00:00', '2026-04-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03 09:48:19', '2026-03-03 09:48:19', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(39, 4, 'Gajultos', 'Marvin Dave', '', '1998-10-05 00:00:00', '27', 'Male', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03 15:54:17', '2026-03-03 15:54:17', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(40, 4, 'Alarde', 'John Edmund', 'Factura', '2000-02-29 00:00:00', '26', 'Male', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_40_1775023860.jpg', '2026-03-03 15:55:11', '2026-04-01 06:11:00', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(41, 8, 'Item', 'Jeshua Christi', 'Sanchez', '2001-05-21 00:00:00', '24', 'Male', '2026-03-04 00:00:00', '2026-04-04 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-04 08:24:22', '2026-03-04 08:24:22', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(42, 8, 'Colet', 'Wyatt', 'Brabante', '2006-02-23 00:00:00', '20', 'Male', '2026-04-09 00:00:00', '2026-05-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 07:23:48', '2026-04-12 04:55:40', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(43, 1, 'Barcena', 'Em', 'Orias', '1999-10-28 00:00:00', '26', 'Female', '2026-04-14 00:00:00', '2026-05-14 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 11:44:22', '2026-04-14 09:11:54', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(44, 8, 'Dumantay', 'Lysander', 'Dela cruz', '2000-10-08 00:00:00', '25', 'Male', '2026-03-09 00:00:00', '2026-04-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 05:20:25', '2026-03-09 05:20:25', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(45, 11, 'Go', 'Gesterd', 'Gaon', '2003-05-24 00:00:00', '22', 'Male', '2026-03-09 00:00:00', '2026-04-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 12:00:50', '2026-03-09 12:00:50', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(46, 11, 'Simbaco', 'Jian', 'Aratan', '2004-04-17 00:00:00', '21', 'Male', '2026-03-09 00:00:00', '2026-04-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 12:01:40', '2026-03-09 12:01:40', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(47, 11, 'Ledesma', 'Josh Roevhie', 'Gavino', '2008-11-12 00:00:00', '17', 'Male', '2026-05-14 00:00:00', '2026-06-14 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-03-09 13:40:30', '2026-05-14 08:31:12', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(48, 1, 'Tabuzo', 'Jeffrey', '', '2026-03-10 00:00:00', '0', 'Male', '2026-04-12 00:00:00', '2026-05-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 04:09:53', '2026-04-12 04:55:02', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(49, 1, 'Lauren', 'Abi', '', '2000-06-02 00:00:00', '25', 'Female', '2026-05-06 00:00:00', '2026-06-06 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 13:44:53', '2026-05-06 12:52:47', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(50, 1, 'Barreto', 'Bella', '', '2000-01-01 00:00:00', '26', 'Female', '2026-04-21 00:00:00', '2026-05-21 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 13:45:35', '2026-04-21 12:32:04', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(51, 1, 'Esplana', 'Paul', '', '1983-02-15 00:00:00', '43', 'Male', '2026-04-15 00:00:00', '2026-05-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 13:46:37', '2026-04-15 13:58:09', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(52, 2, 'Singh', 'Balkar', '', '1998-01-01 00:00:00', '28', 'Male', '2026-05-20 00:00:00', '2026-08-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 13:47:39', '2026-05-21 12:58:24', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(53, 11, 'Potolen', 'Maria Casandra', '', '2008-05-20 00:00:00', '17', 'Female', '2026-03-11 00:00:00', '2026-04-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-11 09:33:37', '2026-03-11 09:33:37', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(54, 10, 'Lim', 'Boyd', '', '1996-08-11 00:00:00', '29', 'Male', '2026-03-11 00:00:00', '2026-09-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-11 12:24:03', '2026-03-11 12:24:03', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(55, 1, 'Cuales', 'Rommel', '', '1994-09-14 00:00:00', '31', 'Male', '2026-05-11 00:00:00', '2026-06-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-11 13:59:09', '2026-05-19 09:31:46', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(56, 1, 'Bermoy', 'Royette', 'G', '1994-11-11 00:00:00', '31', 'Male', '2026-04-14 00:00:00', '2026-05-14 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-13 10:34:01', '2026-04-14 11:18:43', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(57, 1, 'Sarmiento', 'Ferdinand', 'Domingo', '1999-04-16 00:00:00', '26', 'Male', '2026-05-15 00:00:00', '2026-06-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-16 08:03:13', '2026-05-15 09:26:24', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(58, 10, 'Suba', 'Joshua Gabriel', '', '2000-02-23 00:00:00', '26', 'Male', '2026-03-18 00:00:00', '2026-09-18 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-18 01:26:19', '2026-03-18 01:26:19', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(59, 11, 'De Jesus', 'Liam Jerveine', 'Calimlim', '2003-12-15 00:00:00', '22', 'Male', '2026-03-19 00:00:00', '2026-04-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-19 12:01:18', '2026-03-19 12:01:18', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(60, 11, 'Domingo', 'Mark', 'De Castro', '2004-05-23 00:00:00', '21', 'Male', '2026-03-19 00:00:00', '2026-04-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-19 12:02:52', '2026-03-19 12:02:52', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(62, 1, 'Lopez', 'John', 'Managbanag', '1987-09-03 00:00:00', '38', 'Male', '2026-03-20 00:00:00', '2026-04-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-20 10:03:29', '2026-03-20 10:03:29', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(63, 11, 'Balanag', 'Miguel Andrei', 'M', '2003-10-06 00:00:00', '22', 'Male', '2026-03-23 00:00:00', '2026-04-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-22 03:51:16', '2026-03-22 03:51:16', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(64, 11, 'Montesa', 'Rhyl Vincent', 'Almayda', '1997-11-04 00:00:00', '28', 'Male', '2026-04-27 00:00:00', '2026-05-27 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_64_1777281880.jpeg', '2026-03-24 09:51:02', '2026-04-27 11:23:01', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(65, 11, 'Barranda', 'James Claude', 'Cincoflores', '2008-10-28 00:00:00', '17', 'Male', '2026-03-26 00:00:00', '2026-04-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-25 08:14:22', '2026-03-25 08:14:22', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(66, 11, 'Sanchez', 'Jiro', 'Ocania', '2004-05-13 00:00:00', '21', 'Male', '2026-03-26 00:00:00', '2026-04-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-26 05:06:25', '2026-03-26 05:06:25', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(67, 1, 'Quema', 'Zhaerel', 'Mahilum', '2000-12-05 00:00:00', '25', 'Male', '2026-05-06 00:00:00', '2026-06-06 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-26 12:10:46', '2026-05-06 12:51:51', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(68, 1, 'Bondoc', 'Vincent', 'Tolentino', '2000-07-28 00:00:00', '25', 'Male', '2026-03-27 00:00:00', '2026-04-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-27 06:02:34', '2026-03-27 06:02:34', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(69, 1, 'Cunanan', 'Adrielle', 'Guevarra', '1998-12-26 00:00:00', '27', 'Female', '2026-03-27 00:00:00', '2026-04-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-27 06:04:41', '2026-03-27 06:04:41', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(70, 11, 'Aquino', 'Darlene Caryl', 'D.C', '2005-04-23 00:00:00', '20', 'Female', '2026-04-30 00:00:00', '2026-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-01 00:35:38', '2026-04-30 12:36:23', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(71, 11, 'Maragay', 'Ivana Lourdes', 'S.', '2006-02-11 00:00:00', '20', 'Female', '2026-04-30 00:00:00', '2026-05-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-01 00:36:26', '2026-04-30 12:37:33', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(72, 2, 'Bontog', 'Lynard', 'Sumamong', '1990-05-20 00:00:00', '35', 'Male', '2026-04-01 00:00:00', '2026-07-01 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_72_1775035973.jpeg', '2026-04-01 09:32:03', '2026-04-01 09:32:53', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(73, 1, 'Gonzales', 'Junelito', '', '1989-02-22 00:00:00', '37', 'Male', '2026-04-10 00:00:00', '2026-05-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-10 06:34:40', '2026-04-10 06:34:40', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(74, 1, 'Gonzales', 'Renee', '', '1991-07-16 00:00:00', '34', 'Female', '2026-04-10 00:00:00', '2026-05-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-10 06:36:39', '2026-04-10 06:36:39', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(75, 1, 'Funtalva', 'Christian', 'Fabela', '2001-04-17 00:00:00', '24', 'Male', '2026-05-13 00:00:00', '2026-06-13 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-10 10:54:35', '2026-05-13 15:21:14', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(76, 1, 'Valida', 'Michaella', '', '1998-09-16 00:00:00', '27', 'Female', '2026-04-11 00:00:00', '2026-05-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 12:46:18', '2026-04-11 12:46:18', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(77, 3, 'Cortez', 'John Carlo', '', '1996-01-04 00:00:00', '30', 'Male', '2026-04-13 00:00:00', '2026-10-13 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-13 08:02:30', '2026-04-13 08:02:30', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(78, 11, 'Quarteros', 'Daniel', 'Montejo', '2009-08-31 00:00:00', '16', 'Male', '2026-05-14 00:00:00', '2026-06-14 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-13 08:12:52', '2026-05-14 08:30:40', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(79, 11, 'Subaria', 'John carlo', 'Villahermosa', '2009-01-29 00:00:00', '17', 'Male', '2026-05-18 00:00:00', '2026-06-18 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-04-13 08:14:21', '2026-05-18 09:57:33', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(80, 1, 'Lopez', 'Ralf kennith', 'R', '1997-04-14 00:00:00', '29', 'Male', '2026-05-20 00:00:00', '2026-06-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 09:34:27', '2026-05-20 11:15:57', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(81, 11, 'Castro', 'Edward', '', '2004-01-23 00:00:00', '22', 'Male', '2026-04-15 00:00:00', '2026-05-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-15 11:00:50', '2026-04-15 11:00:50', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(82, 3, 'Asuncion', 'Melvin', 'Albart', '1989-06-24 00:00:00', '36', 'Male', '2026-01-07 00:00:00', '2026-07-07 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_82_1776345878.jpeg', '2026-04-16 13:22:16', '2026-04-16 13:24:38', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(83, 1, 'Belarmino', 'Reynaldo', 'Gautane', '2000-04-03 00:00:00', '26', 'Male', '2026-04-18 00:00:00', '2026-05-18 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_83_1776509984.jpeg', '2026-04-18 10:59:00', '2026-04-18 10:59:45', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(84, 11, 'Pedro', 'Christian', 'Trasmonte', '1991-11-07 00:00:00', '34', 'Male', '2026-04-21 00:00:00', '2026-05-21 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 01:44:15', '2026-04-21 01:44:15', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(85, 11, 'Angco', 'Aries', 'Nimo', '2008-11-07 00:00:00', '17', 'Male', '2026-05-22 00:00:00', '2026-06-22 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_85_1776759508.jpeg', '2026-04-21 08:17:17', '2026-05-22 10:49:48', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(86, 9, 'Lisay', 'Camille Joyce', 'M', '1998-01-01 00:00:00', '28', 'Female', '2026-04-21 00:00:00', '2026-07-21 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 13:03:27', '2026-04-21 13:03:27', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(87, 1, 'Abedin', 'Mostaqem', 'Pitembangan', '2002-05-22 00:00:00', '23', 'Male', '2026-04-22 00:00:00', '2026-05-22 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-22 01:39:32', '2026-04-22 01:39:32', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(88, 1, 'Ocampo', 'Ryan Vincent', 'Gadingan', '1999-07-22 00:00:00', '26', 'Male', '2026-04-22 00:00:00', '2026-05-22 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-22 06:29:08', '2026-04-22 06:29:08', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(89, 2, 'Ailes', 'Rose', 'V', '2000-10-22 00:00:00', '25', 'Female', '2026-04-22 00:00:00', '2026-07-22 00:00:00', '', '', '', NULL, NULL, '', './../uploads/profile_picture/emp_89_1776856046.jpeg', '2026-04-22 11:03:40', '2026-04-22 11:07:26', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(90, 12, 'Lagoc', 'Jinky Lyn', '', '1990-07-12 00:00:00', '35', 'Female', '2026-04-25 00:00:00', '2026-08-25 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-25 08:47:05', '2026-04-25 17:43:30', NULL, NULL, NULL, NULL, 'Downpayment', '1800', '1 Months', '1200', '1'),
(91, 12, 'Justine diane', 'Bobis', 'B', '1991-03-28 00:00:00', '35', 'Female', '2026-04-25 00:00:00', '2026-08-25 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-04-25 08:52:17', '2026-04-26 01:25:02', NULL, NULL, NULL, NULL, 'Downpayment', '1800', '1 Months', '1200', '1'),
(92, 8, 'Sakurai', 'Ichiro miko', '', '2004-09-26 00:00:00', '21', 'Male', '2026-04-26 00:00:00', '2026-05-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-26 08:40:17', '2026-04-26 09:49:17', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(93, 11, 'Uy', 'Joshua Jonathan Mark', 'Lozada', '2005-06-11 00:00:00', '20', 'Male', '2026-04-26 00:00:00', '2026-05-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-26 08:42:42', '2026-04-26 09:49:23', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1050', '0'),
(94, 1, 'Suñas', 'Christine Jay', '', '2026-04-27 00:00:00', '0', 'Female', '2026-04-27 00:00:00', '2026-05-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 05:37:59', '2026-04-27 05:37:59', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(95, 1, 'Garcia', 'Xerxes', 'L', '2026-07-26 00:00:00', '-1', 'Male', '2026-04-29 00:00:00', '2026-05-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 10:14:29', '2026-04-27 10:14:29', NULL, NULL, NULL, NULL, 'Downpayment', '1000', '2 Months', '499', '2'),
(96, 1, 'Parulan', 'Edmar thimoty', 'Comision', '2000-03-19 00:00:00', '26', 'Male', '2026-04-29 00:00:00', '2026-05-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-29 10:19:24', '2026-04-29 10:19:24', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(97, 2, 'Lumbrez', 'Rinier John', 'Tolentino', '2005-01-30 00:00:00', '21', 'Male', '2026-05-01 00:00:00', '2026-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-30 13:21:31', '2026-05-23 00:55:25', NULL, NULL, NULL, NULL, 'Downpayment', '1500', '2 Months', '1999', '2'),
(98, 11, 'Teodoro', 'Cheska Joy', 'N', '2003-12-05 00:00:00', '22', 'Female', '2026-05-01 00:00:00', '2026-06-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-01 09:27:52', '2026-05-01 09:27:52', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(99, 12, 'Grana', 'Princess', '', '1996-09-30 00:00:00', '29', 'Female', '2026-05-01 00:00:00', '2026-09-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-01 12:09:57', '2026-05-01 12:09:57', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '3000', '0'),
(100, 12, 'Pozas', 'Ven Jan Francis', '', '1992-01-22 00:00:00', '34', 'Male', '2026-05-01 00:00:00', '2026-09-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-01 12:12:47', '2026-05-01 12:12:47', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '3000', '0'),
(101, 11, 'Anatalio', 'Krisha', '', '2026-07-30 00:00:00', '-1', 'Female', '2026-05-02 00:00:00', '2026-06-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-02 10:34:28', '2026-05-02 10:34:28', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(102, 1, 'Estrella', 'Caila', '', '2002-04-08 00:00:00', '24', 'Female', '2026-05-08 00:00:00', '2026-06-08 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-08 10:56:20', '2026-05-08 10:56:20', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(103, 1, 'Policarpio', 'Aliyah', '', '2003-11-26 00:00:00', '22', 'Female', '2026-05-08 00:00:00', '2026-06-08 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-08 10:57:25', '2026-05-08 10:57:25', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(104, 11, 'Quilantang', 'Justine', '', '2007-07-10 00:00:00', '18', 'Male', '2026-05-09 00:00:00', '2026-06-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-09 04:58:16', '2026-05-09 04:58:16', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(105, 11, 'Fernandez', 'Ashley', '', '2006-06-11 00:00:00', '19', 'Female', '2026-05-09 00:00:00', '2026-06-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-09 05:01:47', '2026-05-09 05:01:47', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '999', '0'),
(106, 8, 'Lopez', 'Mark Kobe', 'M', '1999-06-13 00:00:00', '26', 'Male', '2026-05-12 00:00:00', '2026-06-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-12 09:48:39', '2026-05-12 09:48:39', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1050', '0'),
(107, 2, 'Salas', 'Raven', 'V', '2017-09-16 00:00:00', '8', 'Male', '2026-05-16 00:00:00', '2026-08-16 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-16 08:40:53', '2026-05-16 08:40:53', NULL, NULL, NULL, NULL, 'Downpayment', '1750', '3 Months', '1749', '3'),
(108, 8, 'Delos Reyes', 'Alvin Jeffrey', 'Macatingrao', '1993-09-17 00:00:00', '32', 'Male', '2026-05-17 00:00:00', '2026-06-17 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-17 08:21:38', '2026-05-17 08:21:38', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1050', '0'),
(109, 8, 'Cachuela', 'Zander Marcky', 'C.', '2005-07-08 00:00:00', '20', 'Male', '2026-05-20 00:00:00', '2026-06-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-20 07:57:24', '2026-05-20 07:57:24', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1050', '0'),
(110, 2, 'Singh', 'Jagwinder', '', '1998-09-25 00:00:00', '27', 'Male', '2026-05-20 00:00:00', '2026-08-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-20 11:36:55', '2026-05-20 11:36:55', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '3499', '0'),
(111, 1, 'Delos Reyes', 'Mark Kenneth', 'M', '2002-09-09 00:00:00', '23', 'Male', '2026-05-21 00:00:00', '2026-06-21 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-21 07:42:46', '2026-05-21 07:42:46', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '1499', '0'),
(112, 12, 'Pozas', 'Dinna', '', '1966-04-07 00:00:00', '60', 'Female', '2026-05-21 00:00:00', '2026-09-21 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-21 11:43:49', '2026-05-21 11:43:49', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '3000', '0'),
(113, 12, 'Pozas', 'Ferdinand', '', '1967-09-11 00:00:00', '58', 'Male', '2026-05-21 00:00:00', '2026-09-21 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-21 11:45:39', '2026-05-21 11:45:39', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '3000', '0'),
(114, 3, 'Bautista', 'John Renn', '', '1996-07-23 00:00:00', '29', 'Male', '2026-05-23 00:00:00', '2026-11-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-22 23:36:18', '2026-05-23 00:53:33', NULL, NULL, NULL, NULL, 'Full Payment', '0', '', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `downpayment_record_customer`
--

CREATE TABLE `downpayment_record_customer` (
  `downpayment_record_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_amount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `uploaded_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `membership_history_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

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
  `membership_type_id` int(11) DEFAULT NULL,
  `payment_type` varchar(255) NOT NULL,
  `down_payment_amount` varchar(255) NOT NULL,
  `payment_terms` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `membership_history`
--

INSERT INTO `membership_history` (`membership_history_id`, `customer_id`, `start_date`, `end_date`, `created_at`, `updated_at`, `membership_type_id`, `payment_type`, `down_payment_amount`, `payment_terms`) VALUES
(6, 6, '2026-01-31 00:00:00', '2026-03-05 00:00:00', '2026-03-07 03:43:52', '2026-03-07 03:43:52', 8, '', '', ''),
(7, 20, '2026-02-06 00:00:00', '2026-03-06 00:00:00', '2026-03-07 03:45:04', '2026-03-07 03:45:04', 1, '', '', ''),
(8, 13, '2026-02-03 00:00:00', '2026-03-03 00:00:00', '2026-03-12 05:53:37', '2026-03-12 05:53:37', 11, '', '', ''),
(9, 25, '2026-02-11 00:00:00', '2026-03-11 00:00:00', '2026-03-13 03:11:26', '2026-03-13 03:11:26', 11, '', '', ''),
(10, 5, '2026-02-10 00:00:00', '2026-03-10 00:00:00', '2026-03-15 06:54:19', '2026-03-15 06:54:19', 8, '', '', ''),
(11, 32, '2026-02-27 00:00:00', '2026-03-27 00:00:00', '2026-04-01 01:58:07', '2026-04-01 01:58:07', 1, '', '', ''),
(12, 20, '2026-03-06 00:00:00', '2026-04-06 00:00:00', '2026-04-10 06:32:55', '2026-04-10 06:32:55', 1, '', '', ''),
(13, 48, '2026-03-10 00:00:00', '2026-04-10 00:00:00', '2026-04-12 04:55:02', '2026-04-12 04:55:02', 1, '', '', ''),
(14, 42, '2026-03-06 00:00:00', '2026-04-06 00:00:00', '2026-04-12 04:55:40', '2026-04-12 04:55:40', 8, '', '', ''),
(15, 47, '2026-03-10 00:00:00', '2026-04-10 00:00:00', '2026-04-12 09:47:44', '2026-04-12 09:47:44', 11, '', '', ''),
(16, 55, '2026-03-11 00:00:00', '2026-04-11 00:00:00', '2026-04-13 13:59:59', '2026-04-13 13:59:59', 1, '', '', ''),
(17, 34, '2026-03-02 00:00:00', '2026-04-02 00:00:00', '2026-04-14 07:43:26', '2026-04-14 07:43:26', 11, '', '', ''),
(18, 43, '2026-03-07 00:00:00', '2026-04-07 00:00:00', '2026-04-14 09:11:54', '2026-04-14 09:11:54', 1, '', '', ''),
(19, 56, '2026-03-13 00:00:00', '2026-04-13 00:00:00', '2026-04-14 11:18:43', '2026-04-14 11:18:43', 1, '', '', ''),
(20, 52, '2026-03-10 00:00:00', '2026-04-10 00:00:00', '2026-04-15 13:57:37', '2026-04-15 13:57:37', 1, '', '', ''),
(21, 51, '2026-03-10 00:00:00', '2026-04-10 00:00:00', '2026-04-15 13:58:09', '2026-04-15 13:58:09', 1, '', '', ''),
(22, 57, '2026-03-16 00:00:00', '2026-04-16 00:00:00', '2026-04-16 08:55:32', '2026-04-16 08:55:32', 1, '', '', ''),
(23, 13, '2026-03-12 00:00:00', '2026-04-12 00:00:00', '2026-04-18 12:16:13', '2026-04-18 12:16:13', 11, '', '', ''),
(24, 31, '2026-02-17 00:00:00', '2026-03-17 00:00:00', '2026-04-20 07:42:52', '2026-04-20 07:42:52', 1, '', '', ''),
(25, 31, '2026-04-20 00:00:00', '2026-05-20 00:00:00', '2026-04-20 07:49:10', '2026-04-20 07:49:10', 3, '', '', ''),
(26, 50, '2026-03-10 00:00:00', '2026-04-10 00:00:00', '2026-04-21 12:32:04', '2026-04-21 12:32:04', 1, '', '', ''),
(28, 64, '2026-03-27 00:00:00', '2026-04-27 00:00:00', '2026-04-27 11:23:01', '2026-04-27 11:23:01', 11, '', '', ''),
(29, 32, '2026-04-01 00:00:00', '2026-05-01 00:00:00', '2026-04-30 08:52:17', '2026-04-30 08:52:17', 1, '', '', ''),
(30, 70, '2026-03-30 00:00:00', '2026-04-30 00:00:00', '2026-04-30 12:36:23', '2026-04-30 12:36:23', 11, '', '', ''),
(31, 71, '2026-03-30 00:00:00', '2026-04-30 00:00:00', '2026-04-30 12:37:33', '2026-04-30 12:37:33', 11, '', '', ''),
(32, 67, '2026-03-26 00:00:00', '2026-04-26 00:00:00', '2026-05-06 12:51:51', '2026-05-06 12:51:51', 1, '', '', ''),
(33, 49, '2026-03-10 00:00:00', '2026-04-10 00:00:00', '2026-05-06 12:52:47', '2026-05-06 12:52:47', 1, '', '', ''),
(34, 22, '2026-02-11 00:00:00', '2026-05-11 00:00:00', '2026-05-12 11:24:34', '2026-05-12 11:24:34', 2, '', '', ''),
(35, 23, '2026-02-11 00:00:00', '2026-05-11 00:00:00', '2026-05-12 11:24:52', '2026-05-12 11:24:52', 2, '', '', ''),
(36, 21, '2026-02-03 00:00:00', '2026-03-03 00:00:00', '2026-05-12 12:07:34', '2026-05-12 12:07:34', 1, '', '', ''),
(37, 12, '2026-02-02 00:00:00', '2026-05-02 00:00:00', '2026-05-12 23:19:12', '2026-05-12 23:19:12', 2, '', '', ''),
(38, 75, '2026-04-10 00:00:00', '2026-05-10 00:00:00', '2026-05-13 15:21:14', '2026-05-13 15:21:14', 1, '', '', ''),
(39, 78, '2026-04-13 00:00:00', '2026-05-13 00:00:00', '2026-05-14 08:30:40', '2026-05-14 08:30:40', 1, '', '', ''),
(40, 47, '2026-04-12 00:00:00', '2026-05-12 00:00:00', '2026-05-14 08:31:12', '2026-05-14 08:31:12', 11, '', '', ''),
(41, 57, '2026-04-16 00:00:00', '2026-05-16 00:00:00', '2026-05-15 09:26:24', '2026-05-15 09:26:24', 1, '', '', ''),
(42, 79, '2026-04-13 00:00:00', '2026-05-13 00:00:00', '2026-05-18 09:57:33', '2026-05-18 09:57:33', 1, '', '', ''),
(43, 55, '2026-04-13 00:00:00', '2026-05-13 00:00:00', '2026-05-19 09:31:46', '2026-05-19 09:31:46', 1, '', '', ''),
(44, 80, '2026-04-15 00:00:00', '2026-05-15 00:00:00', '2026-05-20 11:15:57', '2026-05-20 11:15:57', 1, '', '', ''),
(45, 52, '2026-04-15 00:00:00', '2026-05-15 00:00:00', '2026-05-20 12:32:42', '2026-05-20 12:32:42', 1, '', '', ''),
(46, 85, '2026-04-21 00:00:00', '2026-05-21 00:00:00', '2026-05-22 10:49:48', '2026-05-22 10:49:48', 11, '', '', '');

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
(1, '1 Month', '1499.00', '0', 'Regular', NULL, '2026-01-17 11:50:43', '2026-03-02 11:18:45'),
(2, '3  Months', '3499.00', '0', 'Regular', NULL, '2026-01-17 11:51:48', '2026-03-02 11:18:40'),
(3, '6 Months', '6499.00', '0', 'Regular', NULL, '2026-01-17 11:51:59', '2026-03-02 11:18:33'),
(4, 'VIP', '0', '', '-', NULL, '2026-01-20 14:45:37', '2026-01-29 12:01:15'),
(8, '1 Month (30%)', '1050', '30', '30% less', NULL, '2026-02-14 16:01:18', '2026-03-02 11:14:48'),
(9, '3 Month (14.26%)', '3000', '14.26', '14.26% less', NULL, '2026-02-14 16:01:37', '2026-03-12 18:42:04'),
(10, '6 Months (7.68%)', '6000', '7.68', '7.68% less', NULL, '2026-02-14 16:02:00', '2026-03-02 11:14:13'),
(11, '1 Month (Student)', '999.00', '0', 'Student', NULL, '2026-02-14 16:03:29', '2026-02-14 16:03:29'),
(12, '4 Months (Promo from 3 Months)', '3000.00', '0', 'Promo from 3 Months', NULL, '2026-03-02 13:17:40', '2026-03-02 13:17:40');

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
(294, NULL, 'Teof', '', 'Adora', 'teofadora', '$2y$10$GCSYXMUCLM.9.13dPFg0huJ9jDVVIORWFuNEEcua19z3hogfKPrZu', '123456789', NULL, '2026-01-29 11:25:36', '2026-01-29 12:06:03', 'teofilo.adora@gmail.com'),
(295, NULL, 'Joji', '', 'Manansala', 'Nyii0823', '$2y$10$hs0qFcVWaBtjFRXD06UR5usIqJ6A7FRSArZzmoLo/fPA3fR0.7tne', 'Qwerty123', NULL, '2026-02-27 07:42:54', '2026-02-27 07:42:54', 'manansalajie0823@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `walk_in`
--

CREATE TABLE `walk_in` (
  `walk_id` int(11) NOT NULL,
  `walk_in_name` varchar(255) NOT NULL,
  `walk_in_type` varchar(255) NOT NULL,
  `walk_in_price` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `walk_in`
--

INSERT INTO `walk_in` (`walk_id`, `walk_in_name`, `walk_in_type`, `walk_in_price`, `created_at`, `updated_at`) VALUES
(2, 'Jiro', 'Non Member', '180', '2026-03-13 08:09:31', '2026-03-13 08:45:04'),
(3, 'Joshua', 'Non Member', '180', '2026-03-14 04:41:05', '2026-03-14 04:41:05'),
(4, 'Shielo', 'Non Member', '180', '2026-03-14 04:43:00', '2026-03-14 04:43:00'),
(5, 'Vince', 'Non Member', '180', '2026-03-16 10:38:35', '2026-03-16 10:38:35'),
(6, 'Dei', 'Non Member', '180', '2026-03-16 10:38:43', '2026-03-16 10:38:43'),
(7, 'Joshua', 'Non Member', '180', '2026-03-17 06:26:45', '2026-03-17 06:26:45'),
(8, 'Ethan', 'Student (Non Member)', '150', '2026-03-17 10:54:35', '2026-03-31 13:11:37'),
(9, 'Dex', 'Member', '150', '2026-03-20 07:11:11', '2026-03-20 07:11:11'),
(10, 'Jomar', 'Member', '150', '2026-03-20 07:12:13', '2026-03-20 07:12:13'),
(11, 'Vince', 'Non Member', '180', '2026-03-20 07:12:21', '2026-03-20 07:12:21'),
(12, 'Dei', 'Non Member', '180', '2026-03-20 07:12:29', '2026-03-20 07:12:29'),
(13, 'Jasper', 'Non Member', '180', '2026-03-22 08:21:18', '2026-03-22 08:21:18'),
(14, 'Ej', 'Non Member', '180', '2026-03-22 08:21:26', '2026-03-22 08:21:26'),
(15, 'Jiro', 'Non Member', '180', '2026-03-23 06:44:20', '2026-03-23 06:44:20'),
(16, 'Ramon', 'Non Member', '180', '2026-03-24 05:02:10', '2026-03-24 05:02:10'),
(17, 'Justine', 'Student (Non Member)', '150', '2026-03-25 04:37:57', '2026-03-26 07:28:10'),
(18, 'Mood', 'Non Member', '180', '2026-03-25 04:38:07', '2026-03-26 07:28:15'),
(19, 'Ivy', 'Member', '150', '2026-03-26 04:38:44', '2026-03-26 04:38:44'),
(20, 'Vince', 'Non Member', '180', '2026-03-26 04:55:48', '2026-03-26 04:55:48'),
(21, 'Dlei', 'Non Member', '180', '2026-03-26 04:56:38', '2026-03-26 04:56:38'),
(22, 'Jasmin', 'Member', '150', '2026-03-27 09:44:45', '2026-03-27 09:44:45'),
(23, 'Joshua', 'Non Member', '180', '2026-03-31 14:45:15', '2026-03-31 14:45:15'),
(24, 'Yna', 'Student (Non Member)', '150', '2026-03-31 14:45:33', '2026-03-31 14:45:33'),
(25, 'Carlos', 'Non Member', '180', '2026-03-31 14:45:45', '2026-03-31 14:45:45'),
(26, 'Edmar', 'Member', '150', '2026-03-31 14:46:00', '2026-03-31 14:46:00'),
(27, 'Edmar', 'Member', '150', '2026-04-02 08:14:41', '2026-04-02 08:14:41'),
(28, 'Dex', 'Member', '150', '2026-04-04 05:16:32', '2026-04-04 05:16:32'),
(29, 'Joshua', 'Non Member', '180', '2026-04-04 05:17:03', '2026-04-04 05:17:03'),
(30, 'Edmar', 'Member', '150', '2026-04-04 09:01:08', '2026-04-04 09:01:08'),
(31, 'Joshua', 'Non Member', '180', '2026-04-07 08:31:01', '2026-04-07 08:31:01'),
(32, 'Chan', 'Student (Non Member)', '150', '2026-04-07 10:47:25', '2026-04-07 10:47:25'),
(33, 'Edmar', 'Member', '150', '2026-04-07 11:00:32', '2026-04-07 11:00:32'),
(34, 'Mark', 'Student (Non Member)', '150', '2026-04-07 11:32:40', '2026-04-07 11:32:40'),
(35, 'Giselle', 'Non Member', '180', '2026-04-08 05:14:49', '2026-04-08 05:14:49'),
(36, 'Jasmin', 'Student (Non Member)', '150', '2026-04-08 10:46:57', '2026-04-08 10:46:57'),
(37, 'Nicole', 'Student (Non Member)', '150', '2026-04-08 10:52:24', '2026-04-08 10:52:24'),
(38, 'Dex', 'Member', '150', '2026-04-09 06:07:02', '2026-04-09 06:07:02'),
(39, 'Nina', 'Non Member', '180', '2026-04-09 06:07:11', '2026-04-09 06:07:11'),
(40, '', 'Member', '150', '2026-04-09 06:07:17', '2026-04-09 06:07:17'),
(41, 'Joshua', 'Non Member', '180', '2026-04-11 06:10:31', '2026-04-11 06:10:31'),
(42, 'Ryan', 'Non Member', '180', '2026-04-12 06:54:21', '2026-04-12 06:54:21'),
(43, 'Edmar', 'Member', '150', '2026-04-13 11:30:53', '2026-04-13 11:30:53'),
(44, '', 'Non Member', '180', '2026-04-13 11:31:01', '2026-04-13 11:31:01'),
(45, 'Ivy', 'Member', '150', '2026-04-14 08:52:46', '2026-04-14 08:52:46'),
(46, 'Joshua', 'Non Member', '180', '2026-04-14 08:52:57', '2026-04-14 08:52:57'),
(47, '', 'Student (Non Member)', '150', '2026-04-16 08:57:27', '2026-04-16 08:57:27'),
(48, '', 'Student (Member)', '120', '2026-04-16 08:57:33', '2026-04-16 08:57:33'),
(49, '', 'Non Member', '180', '2026-04-16 08:57:39', '2026-04-16 08:57:39'),
(50, 'Ivy', 'Member', '150', '2026-04-20 05:29:36', '2026-04-20 05:29:36'),
(51, 'Nina', 'Non Member', '180', '2026-04-20 05:29:48', '2026-04-20 05:29:48'),
(52, 'Shiela', 'Student (Non Member)', '150', '2026-04-20 08:56:29', '2026-04-20 08:56:29'),
(53, '', 'Student (Non Member)', '150', '2026-04-20 08:56:34', '2026-04-20 08:56:34'),
(54, 'Joshua', 'Non Member', '180', '2026-04-21 08:46:01', '2026-04-21 08:46:01'),
(55, '', 'Member', '150', '2026-04-21 12:05:32', '2026-04-21 12:05:32'),
(56, '', 'Member', '150', '2026-04-21 12:05:36', '2026-04-21 12:05:36'),
(57, '', 'Member', '150', '2026-04-22 06:01:34', '2026-04-22 06:01:34'),
(58, '', 'Non Member', '180', '2026-04-22 10:58:48', '2026-04-22 10:58:48'),
(59, 'Ivy', 'Member', '150', '2026-04-23 06:34:50', '2026-04-23 06:34:50'),
(60, 'Nina', 'Non Member', '180', '2026-04-23 06:35:03', '2026-04-23 06:35:03'),
(61, '', 'Non Member', '180', '2026-04-27 05:34:37', '2026-04-27 05:34:37'),
(62, 'Edmar', 'Member', '150', '2026-04-27 11:23:19', '2026-04-27 11:23:19'),
(63, '', 'Non Member', '180', '2026-04-28 10:19:14', '2026-04-28 10:19:14'),
(64, 'Gerald', 'Member', '150', '2026-04-29 08:48:47', '2026-04-29 08:48:47'),
(65, 'Nina', 'Non Member', '180', '2026-04-29 08:48:57', '2026-04-29 08:48:57'),
(66, 'Cedrick', 'Non Member', '180', '2026-05-01 06:49:17', '2026-05-01 06:49:17'),
(67, 'Tanya', 'Non Member', '180', '2026-05-01 06:49:27', '2026-05-01 06:49:27'),
(68, 'Ivy', 'Member', '150', '2026-05-04 06:42:19', '2026-05-04 06:42:19'),
(69, 'Nina', 'Non Member', '180', '2026-05-04 06:42:25', '2026-05-04 06:42:25'),
(70, 'Ralph', 'Non Member', '180', '2026-05-04 10:59:31', '2026-05-04 10:59:31'),
(71, 'Gian', 'Non Member', '180', '2026-05-04 10:59:38', '2026-05-04 10:59:38'),
(72, 'Carla', 'Non Member', '180', '2026-05-05 08:21:43', '2026-05-05 08:21:43'),
(73, 'Miyah', 'Non Member', '180', '2026-05-05 08:21:51', '2026-05-05 08:21:51'),
(74, 'Nina', 'Non Member', '180', '2026-05-07 03:40:58', '2026-05-07 03:40:58'),
(75, 'Ivy', 'Member', '150', '2026-05-07 03:41:48', '2026-05-07 03:41:48'),
(76, '', 'Non Member', '180', '2026-05-07 11:47:14', '2026-05-07 11:47:14'),
(77, '', 'Non Member', '180', '2026-05-07 11:47:20', '2026-05-07 11:47:20'),
(78, '', 'Non Member', '180', '2026-05-07 11:47:27', '2026-05-07 11:47:27'),
(79, '', 'Non Member', '180', '2026-05-07 11:47:32', '2026-05-07 11:47:32'),
(80, '', 'Non Member', '180', '2026-05-13 15:21:37', '2026-05-13 15:21:37'),
(81, '', 'Student (Non Member)', '150', '2026-05-13 15:21:45', '2026-05-13 15:21:45'),
(82, '', 'Student (Non Member)', '150', '2026-05-13 15:21:50', '2026-05-13 15:21:50'),
(83, '', 'Non Member', '180', '2026-05-15 08:26:58', '2026-05-15 08:26:58'),
(84, '', 'Non Member', '180', '2026-05-15 09:46:29', '2026-05-15 09:46:29'),
(85, '', 'Non Member', '180', '2026-05-15 09:46:35', '2026-05-15 09:46:35'),
(86, '', 'Non Member', '180', '2026-05-19 09:50:28', '2026-05-19 09:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `weight_history`
--

CREATE TABLE `weight_history` (
  `weight_id` int(11) NOT NULL,
  `weight_desc` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `date_saved_weight` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `weight_history`
--

INSERT INTO `weight_history` (`weight_id`, `weight_desc`, `customer_id`, `date_saved_weight`, `created_at`, `updated_at`) VALUES
(1, '100', 82, '2026-04-16', '2026-04-16 13:25:19', '2026-04-16 13:25:19'),
(2, '49.8', 86, '2026-04-21', '2026-04-21 13:03:49', '2026-04-21 13:03:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `body_fats_history`
--
ALTER TABLE `body_fats_history`
  ADD PRIMARY KEY (`bodyfats_id`) USING BTREE;

--
-- Indexes for table `coaching_service`
--
ALTER TABLE `coaching_service`
  ADD PRIMARY KEY (`coaching_id`) USING BTREE;

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`) USING BTREE;

--
-- Indexes for table `downpayment_record_customer`
--
ALTER TABLE `downpayment_record_customer`
  ADD PRIMARY KEY (`downpayment_record_id`) USING BTREE;

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
-- Indexes for table `walk_in`
--
ALTER TABLE `walk_in`
  ADD PRIMARY KEY (`walk_id`);

--
-- Indexes for table `weight_history`
--
ALTER TABLE `weight_history`
  ADD PRIMARY KEY (`weight_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `body_fats_history`
--
ALTER TABLE `body_fats_history`
  MODIFY `bodyfats_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `coaching_service`
--
ALTER TABLE `coaching_service`
  MODIFY `coaching_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `downpayment_record_customer`
--
ALTER TABLE `downpayment_record_customer`
  MODIFY `downpayment_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `membership_history`
--
ALTER TABLE `membership_history`
  MODIFY `membership_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `membership_type`
--
ALTER TABLE `membership_type`
  MODIFY `membership_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `lakan_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT for table `walk_in`
--
ALTER TABLE `walk_in`
  MODIFY `walk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `weight_history`
--
ALTER TABLE `weight_history`
  MODIFY `weight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
