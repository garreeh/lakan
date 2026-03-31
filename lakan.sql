/*
 Navicat Premium Data Transfer

 Source Server         : PersonalProjects
 Source Server Type    : MySQL
 Source Server Version : 100432
 Source Host           : localhost:3306
 Source Schema         : lakan

 Target Server Type    : MySQL
 Target Server Version : 100432
 File Encoding         : 65001

 Date: 01/04/2026 00:24:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for body_fats_history
-- ----------------------------
DROP TABLE IF EXISTS `body_fats_history`;
CREATE TABLE `body_fats_history`  (
  `bodyfats_id` int NOT NULL AUTO_INCREMENT,
  `bodyfats_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_id` int NULL DEFAULT NULL,
  `date_saved_bodyfats` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT current_timestamp,
  PRIMARY KEY (`bodyfats_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 117 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of body_fats_history
-- ----------------------------
INSERT INTO `body_fats_history` VALUES (111, '1', 68, '2026-04-01', '2026-04-01 00:21:16', '2026-04-01 00:21:16');
INSERT INTO `body_fats_history` VALUES (112, '2', 68, '2026-04-01', '2026-04-01 00:21:19', '2026-04-01 00:21:19');
INSERT INTO `body_fats_history` VALUES (113, '3', 68, '2026-04-01', '2026-04-01 00:21:22', '2026-04-01 00:21:22');
INSERT INTO `body_fats_history` VALUES (114, '4', 68, '2026-04-01', '2026-04-01 00:22:34', '2026-04-01 00:22:34');
INSERT INTO `body_fats_history` VALUES (115, '5', 68, '2026-04-01', '2026-04-01 00:22:57', '2026-04-01 00:22:57');
INSERT INTO `body_fats_history` VALUES (116, '6', 68, '2026-04-01', '2026-04-01 00:23:01', '2026-04-01 00:23:01');

-- ----------------------------
-- Table structure for coaching_service
-- ----------------------------
DROP TABLE IF EXISTS `coaching_service`;
CREATE TABLE `coaching_service`  (
  `coaching_id` int NOT NULL AUTO_INCREMENT,
  `client_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `coaching_price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `coaching_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `coaching_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`coaching_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of coaching_service
-- ----------------------------
INSERT INTO `coaching_service` VALUES (2, 'Garry', '35500', 'Platinum', '2026-03-31 20:21:34', '2026-03-31 20:21:34', '2026-03-31');
INSERT INTO `coaching_service` VALUES (3, 'Garry D', '24700', 'Gold', '2026-03-31 20:51:42', '2026-03-31 20:51:42', '2026-03-31');
INSERT INTO `coaching_service` VALUES (4, '1', '11200', 'Silver', '2026-03-31 20:55:23', '2026-03-31 20:55:23', '2026-03-31');
INSERT INTO `coaching_service` VALUES (5, '3', '24700', 'Bronze', '2026-03-31 20:55:28', '2026-03-31 20:55:28', '2026-03-31');
INSERT INTO `coaching_service` VALUES (6, '5', '500', 'Single Session', '2026-03-31 20:55:33', '2026-03-31 20:55:33', '2026-03-31');
INSERT INTO `coaching_service` VALUES (7, '6', '18000', 'Platinum (Promo)', '2026-03-31 20:55:36', '2026-03-31 20:55:36', '2026-03-31');
INSERT INTO `coaching_service` VALUES (8, '7', '13000', 'Gold (Promo)', '2026-03-31 20:55:39', '2026-03-31 20:55:39', '2026-03-31');
INSERT INTO `coaching_service` VALUES (9, '8', '6000', 'Silver (Promo)', '2026-03-31 20:55:43', '2026-03-31 20:55:43', '2026-03-31');

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `membership_type_id` int NULL DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `birth_date` datetime NULL DEFAULT NULL,
  `age` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `start_date_membership` datetime NULL DEFAULT NULL,
  `end_date_membership` datetime NULL DEFAULT NULL,
  `contact_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `emergency_contact_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `emergency_contact_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `civil_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `account_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `profile_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `is_paused` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_paused` datetime NULL DEFAULT NULL,
  `date_resumed` datetime NULL DEFAULT NULL,
  `last_paused_date` datetime NULL DEFAULT NULL,
  `bodyfats_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (1, 4, 'Gajultos', 'Garry', '', '1999-12-18 00:00:00', '26', 'Male', NULL, NULL, '09264753651', 'Marvin Dave Gajultos', '-', NULL, NULL, 'gajultos.garrydev@gmail.com', './../uploads/profile_picture/emp_1_1771997964.jpg', '2026-01-29 21:29:34', '2026-03-02 21:28:19', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (4, 4, 'Rosell', 'Michelle', '', '2004-02-07 00:00:00', '22', 'Female', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-01-29 20:01:10', '2026-02-19 19:28:10', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (5, 8, 'Dela Rosa', 'Nilo', '', '1973-12-24 00:00:00', '52', 'Male', '2026-03-15 00:00:00', '2026-04-15 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-01-30 18:42:47', '2026-03-19 23:01:12', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (6, 8, 'Villarosa', 'Arik', 'Nicholas', '2010-05-04 00:00:00', '15', 'Male', '2026-03-06 00:00:00', '2026-04-06 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 19:01:48', '2026-03-07 11:43:52', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (7, 1, 'Villarosa', 'Ryan', 'Nicholas', '1986-06-30 00:00:00', '39', 'Male', '2026-01-31 00:00:00', '2026-03-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 19:02:29', '2026-01-30 19:02:29', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (9, 1, 'San Pascual', 'Thaddeus', 'Gavilo', '1988-09-12 00:00:00', '37', 'Male', '2026-01-31 00:00:00', '2026-03-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 20:11:09', '2026-01-30 20:11:09', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (10, 2, 'Pangilinan', 'Maverick', 'Libaton', '2002-10-30 00:00:00', '23', 'Male', '2026-01-01 00:00:00', '2026-03-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-30 20:12:56', '2026-03-03 23:45:44', '1', '2026-02-16 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (11, 3, 'Colcol', 'MJ', '', '1993-11-12 00:00:00', '32', 'Male', '2026-01-05 00:00:00', '2026-07-05 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-01-30 20:14:05', '2026-02-01 18:03:20', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (12, 2, 'Jumapao', 'Dave Vincent', '', '1998-02-03 00:00:00', '28', 'Male', '2026-02-02 00:00:00', '2026-05-02 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-02-02 12:59:27', '2026-02-19 19:28:21', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (13, 11, 'Villena', 'Jakob', 'Carpio', '2005-11-03 00:00:00', '20', 'Male', '2026-03-12 00:00:00', '2026-04-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 14:08:16', '2026-03-12 13:53:37', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (14, 1, 'Peñaranda', 'Natasha', 'Baculo', '2002-10-08 00:00:00', '23', 'Female', '2026-02-02 00:00:00', '2026-03-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 16:49:04', '2026-02-02 16:49:04', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (15, 1, 'Clemente', 'Louise Yuri Amhiel', 'Nicasio', '2005-07-03 00:00:00', '20', 'Male', '2026-02-02 00:00:00', '2026-03-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 16:49:56', '2026-02-02 16:49:56', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (16, 1, 'De Jesus', 'Loraine', '', '1994-11-24 00:00:00', '31', 'Female', '2026-02-02 00:00:00', '2026-03-02 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-02-02 18:10:21', '2026-03-03 14:01:12', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (17, 1, 'Baluca', 'Rico', 'Aggabao', '2002-04-01 00:00:00', '23', 'Male', '2026-02-02 00:00:00', '2026-03-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 18:41:05', '2026-02-02 18:41:05', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (18, 1, 'Castillo', 'Korina', 'Gonzales', '2000-03-30 00:00:00', '25', 'Female', '2026-02-05 00:00:00', '2026-03-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 18:42:02', '2026-02-02 18:42:02', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (19, 1, 'Dykee', 'Garret', 'M', '2000-02-06 00:00:00', '26', 'Male', '2026-02-02 00:00:00', '2026-03-02 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-02-02 18:55:19', '2026-03-03 00:42:56', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (20, 1, 'Mendoza', 'Dan', 'Angana', '1993-08-05 00:00:00', '32', 'Male', '2026-03-06 00:00:00', '2026-04-06 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 09:50:26', '2026-03-07 11:45:04', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (21, 1, 'Talavera', 'Luke', 'Barcelo', '2002-04-10 00:00:00', '23', 'Male', '2026-02-03 00:00:00', '2026-03-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 16:36:28', '2026-02-03 16:36:28', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (22, 2, 'Singh', 'Jatinder', '', '2004-07-30 00:00:00', '21', 'Male', '2026-02-11 00:00:00', '2026-05-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 19:08:44', '2026-02-10 19:08:44', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (23, 2, 'Singh', 'Jaswant', '', '1992-01-05 00:00:00', '34', 'Male', '2026-02-11 00:00:00', '2026-05-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 19:09:44', '2026-02-10 19:09:44', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (24, 1, 'Tejada', 'Jazzer andre', 'Perez', '2004-06-27 00:00:00', '21', 'Male', '2026-02-11 00:00:00', '2026-03-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 19:41:47', '2026-02-10 19:41:47', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (25, 11, 'Sunico', 'John hayes', 'Alticen', '2002-11-24 00:00:00', '23', 'Male', '2026-03-09 00:00:00', '2026-04-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-10 19:43:47', '2026-03-13 11:11:26', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (26, 1, 'Bart', 'Franz', '', '1993-10-19 00:00:00', '32', 'Male', '2026-02-19 00:00:00', '2026-03-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-19 20:13:36', '2026-02-19 20:13:36', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (27, 1, 'Alcorin', 'Jonas', 'Lare', '2003-07-05 00:00:00', '22', 'Male', '2026-02-23 00:00:00', '2026-03-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 19:52:30', '2026-02-23 19:52:30', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (28, 1, 'Jabat', 'Evan lawrenz', 'Espinoza', '2004-09-24 00:00:00', '21', 'Male', '2026-02-23 00:00:00', '2026-03-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 19:53:09', '2026-02-23 19:53:09', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (29, 1, 'Abrajano', 'Gene Michael', 'Navarro', '2004-07-03 00:00:00', '21', 'Male', '2026-02-23 00:00:00', '2026-03-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 21:54:04', '2026-02-23 21:54:04', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (30, 2, 'Gian', 'Castro', '', '1996-04-08 00:00:00', '29', 'Male', '2026-03-01 00:00:00', '2026-06-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 15:49:02', '2026-02-25 15:49:02', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (31, 1, 'De Leon', 'Teo', 'Servanez', '1994-09-20 00:00:00', '31', 'Male', '2026-02-17 00:00:00', '2026-03-17 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-27 16:09:21', '2026-02-27 16:09:21', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (32, 1, 'Tan', 'Rory', 'Tercio', '2002-06-13 00:00:00', '23', 'Male', '2026-02-27 00:00:00', '2026-03-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-27 19:06:13', '2026-02-27 19:06:13', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (33, 1, 'Apolonio', 'Gilbert', '', '1969-02-12 00:00:00', '57', 'Male', '2026-03-01 00:00:00', '2026-04-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-01 15:25:29', '2026-03-01 15:25:29', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (34, 11, 'Bicaldo', 'Charm Beatrice', 'Telebrico', '2008-02-02 00:00:00', '18', 'Female', '2026-03-02 00:00:00', '2026-04-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-02 17:22:39', '2026-03-02 19:17:41', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (35, 12, 'Gerona', 'Danielle Angelo', '', '2000-01-20 00:00:00', '26', 'Male', '2026-03-02 00:00:00', '2026-07-12 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-03-02 17:26:08', '2026-03-21 18:31:19', '0', NULL, '2026-03-21 00:00:00', '2026-03-11 00:00:00', NULL);
INSERT INTO `customer` VALUES (36, 1, 'Apolonio', 'Levy', '', '1970-08-14 00:00:00', '55', 'Female', '2026-03-02 00:00:00', '2026-04-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-02 17:31:07', '2026-03-02 17:31:07', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
INSERT INTO `customer` VALUES (37, 11, 'Loropan', 'Febrix Jaelo', 'Santos', '2001-11-29 00:00:00', '24', 'Male', '2026-03-03 00:00:00', '2026-04-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03 17:38:02', '2026-03-03 17:38:02', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (38, 1, 'Cristobal', 'Jezreel Clemence', '', '2005-08-26 00:00:00', '20', 'Male', '2026-03-03 00:00:00', '2026-04-03 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03 17:48:19', '2026-03-03 17:48:19', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (39, 4, 'Gajultos', 'Marvin Dave', '', '1998-10-05 00:00:00', '27', 'Male', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03 23:54:17', '2026-03-03 23:54:17', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (40, 4, 'Alarde', 'John Edmund', 'Factura', '2000-02-29 00:00:00', '26', 'Male', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03 23:55:11', '2026-03-03 23:55:11', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (41, 8, 'Item', 'Jeshua Christi', 'Sanchez', '2001-05-21 00:00:00', '24', 'Male', '2026-03-04 00:00:00', '2026-04-04 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-04 16:24:22', '2026-03-04 16:24:22', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (42, 8, 'Colet', 'Wyatt', 'Brabante', '2006-02-23 00:00:00', '20', 'Male', '2026-03-06 00:00:00', '2026-04-06 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 15:23:48', '2026-03-07 15:23:48', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (43, 1, 'Barcena', 'Em', 'Orias', '1999-10-28 00:00:00', '26', 'Female', '2026-03-07 00:00:00', '2026-04-07 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:44:22', '2026-03-07 19:44:22', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (44, 8, 'Dumantay', 'Lysander', 'Dela cruz', '2000-10-08 00:00:00', '25', 'Male', '2026-03-09 00:00:00', '2026-04-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 13:20:25', '2026-03-09 13:20:25', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (45, 11, 'Go', 'Gesterd', 'Gaon', '2003-05-24 00:00:00', '22', 'Male', '2026-03-09 00:00:00', '2026-04-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 20:00:50', '2026-03-09 20:00:50', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (46, 11, 'Simbaco', 'Jian', 'Aratan', '2004-04-17 00:00:00', '21', 'Male', '2026-03-09 00:00:00', '2026-04-09 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 20:01:40', '2026-03-09 20:01:40', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (47, 11, 'Ledesma', 'Josh Roevhie', 'Gavino', '2008-11-12 00:00:00', '17', 'Male', '2026-03-10 00:00:00', '2026-04-10 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-03-09 21:40:30', '2026-03-09 21:41:15', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (48, 1, 'Tabuzo', 'Jeffrey', '', '2026-03-10 00:00:00', '0', 'Male', '2026-03-10 00:00:00', '2026-04-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 12:09:53', '2026-03-10 12:09:53', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (49, 1, 'Lauren', 'Abi', '', '2000-06-02 00:00:00', '25', 'Female', '2026-03-10 00:00:00', '2026-04-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 21:44:53', '2026-03-10 21:44:53', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (50, 1, 'Barreto', 'Bella', '', '2000-01-01 00:00:00', '26', 'Female', '2026-03-10 00:00:00', '2026-04-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 21:45:35', '2026-03-10 21:45:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (51, 1, 'Esplana', 'Paul', '', '1983-02-15 00:00:00', '43', 'Male', '2026-03-10 00:00:00', '2026-04-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 21:46:37', '2026-03-10 21:46:37', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (52, 1, 'Singh', 'Balkar', '', '1998-01-01 00:00:00', '28', 'Male', '2026-03-10 00:00:00', '2026-04-10 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 21:47:39', '2026-03-10 21:47:39', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (53, 11, 'Potolen', 'Maria Casandra', '', '2008-05-20 00:00:00', '17', 'Female', '2026-03-11 00:00:00', '2026-04-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-11 17:33:37', '2026-03-11 17:33:37', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (54, 10, 'Lim', 'Boyd', '', '1996-08-11 00:00:00', '29', 'Male', '2026-03-11 00:00:00', '2026-09-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-11 20:24:03', '2026-03-11 20:24:03', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (55, 1, 'Cuales', 'Rommel', '', '1994-09-14 00:00:00', '31', 'Male', '2026-03-11 00:00:00', '2026-04-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-11 21:59:09', '2026-03-11 21:59:09', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (56, 1, 'Bermoy', 'Royette', 'G', '1994-11-11 00:00:00', '31', 'Male', '2026-03-13 00:00:00', '2026-04-13 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-13 18:34:01', '2026-03-13 18:34:01', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (57, 1, 'Sarmiento', 'Ferdinand', 'Domingo', '1999-04-16 00:00:00', '26', 'Male', '2026-03-16 00:00:00', '2026-04-16 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-16 16:03:13', '2026-03-16 16:03:13', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (58, 10, 'Suba', 'Joshua Gabriel', '', '2000-02-23 00:00:00', '26', 'Male', '2026-03-18 00:00:00', '2026-09-18 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-18 09:26:19', '2026-03-18 09:26:19', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (59, 11, 'De Jesus', 'Liam Jerveine', 'Calimlim', '2003-12-15 00:00:00', '22', 'Male', '2026-03-19 00:00:00', '2026-04-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-19 20:01:18', '2026-03-19 20:01:18', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (60, 11, 'Domingo', 'Mark', 'De Castro', '2004-05-23 00:00:00', '21', 'Male', '2026-03-19 00:00:00', '2026-04-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-19 20:02:52', '2026-03-19 20:02:52', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (62, 1, 'Lopez', 'John', 'Managbanag', '1987-09-03 00:00:00', '38', 'Male', '2026-03-20 00:00:00', '2026-04-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-20 18:03:29', '2026-03-20 18:03:29', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (63, 11, 'Balanag', 'Miguel Andrei', 'M', '2003-10-06 00:00:00', '22', 'Male', '2026-03-23 00:00:00', '2026-04-23 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-22 11:51:16', '2026-03-22 11:51:16', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (64, 11, 'Montesa', 'Rhyl Vincent', 'Almayda', '1997-11-04 00:00:00', '28', 'Male', '2026-03-27 00:00:00', '2026-04-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-24 17:51:02', '2026-03-24 17:51:02', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (65, 11, 'Barranda', 'James Claude', 'Cincoflores', '2008-10-28 00:00:00', '17', 'Male', '2026-03-26 00:00:00', '2026-04-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-25 16:14:22', '2026-03-25 16:14:22', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (66, 11, 'Sanchez', 'Jiro', 'Ocania', '2004-05-13 00:00:00', '21', 'Male', '2026-03-26 00:00:00', '2026-04-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-26 13:06:25', '2026-03-26 13:06:25', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (67, 1, 'Quema', 'Zhaerel', 'Mahilum', '2000-12-05 00:00:00', '25', 'Male', '2026-03-26 00:00:00', '2026-04-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-26 20:10:46', '2026-03-26 20:10:46', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (68, 1, 'Bondoc', 'Vincent', 'Tolentino', '2000-07-28 00:00:00', '25', 'Male', '2026-03-27 00:00:00', '2026-04-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-27 14:02:34', '2026-03-27 14:02:34', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (69, 1, 'Cunanan', 'Adrielle', 'Guevarra', '1998-12-26 00:00:00', '27', 'Female', '2026-03-27 00:00:00', '2026-04-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-27 14:04:41', '2026-03-27 14:04:41', NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for membership_history
-- ----------------------------
DROP TABLE IF EXISTS `membership_history`;
CREATE TABLE `membership_history`  (
  `membership_history_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `start_date` datetime NULL DEFAULT NULL,
  `end_date` datetime NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `membership_type_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`membership_history_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of membership_history
-- ----------------------------
INSERT INTO `membership_history` VALUES (6, 6, '2026-01-31 00:00:00', '2026-03-05 00:00:00', '2026-03-07 11:43:52', '2026-03-07 11:43:52', 8);
INSERT INTO `membership_history` VALUES (7, 20, '2026-02-06 00:00:00', '2026-03-06 00:00:00', '2026-03-07 11:45:04', '2026-03-07 11:45:04', 1);
INSERT INTO `membership_history` VALUES (8, 13, '2026-02-03 00:00:00', '2026-03-03 00:00:00', '2026-03-12 13:53:37', '2026-03-12 13:53:37', 11);
INSERT INTO `membership_history` VALUES (9, 25, '2026-02-11 00:00:00', '2026-03-11 00:00:00', '2026-03-13 11:11:26', '2026-03-13 11:11:26', 11);
INSERT INTO `membership_history` VALUES (10, 5, '2026-02-10 00:00:00', '2026-03-10 00:00:00', '2026-03-15 14:54:19', '2026-03-15 14:54:19', 8);

-- ----------------------------
-- Table structure for membership_type
-- ----------------------------
DROP TABLE IF EXISTS `membership_type`;
CREATE TABLE `membership_type`  (
  `membership_type_id` int NOT NULL AUTO_INCREMENT,
  `membership_type_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `membershiptype_price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `discount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `membershiptype_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_vip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`membership_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of membership_type
-- ----------------------------
INSERT INTO `membership_type` VALUES (1, '1 Month', '1499.00', '0', 'Regular', NULL, '2026-01-17 19:50:43', '2026-03-02 19:18:45');
INSERT INTO `membership_type` VALUES (2, '3  Months', '3499.00', '0', 'Regular', NULL, '2026-01-17 19:51:48', '2026-03-02 19:18:40');
INSERT INTO `membership_type` VALUES (3, '6 Months', '6499.00', '0', 'Regular', NULL, '2026-01-17 19:51:59', '2026-03-02 19:18:33');
INSERT INTO `membership_type` VALUES (4, 'VIP', '0', '', '-', NULL, '2026-01-20 22:45:37', '2026-01-29 20:01:15');
INSERT INTO `membership_type` VALUES (8, '1 Month (30%)', '1050', '30', '30% less', NULL, '2026-02-15 00:01:18', '2026-03-02 19:14:48');
INSERT INTO `membership_type` VALUES (9, '3 Month (14.26%)', '3000', '14.26', '14.26% less', NULL, '2026-02-15 00:01:37', '2026-03-13 02:42:04');
INSERT INTO `membership_type` VALUES (10, '6 Months (7.68%)', '6000', '7.68', '7.68% less', NULL, '2026-02-15 00:02:00', '2026-03-02 19:14:13');
INSERT INTO `membership_type` VALUES (11, '1 Month (Student)', '999.00', '0', 'Student', NULL, '2026-02-15 00:03:29', '2026-02-15 00:03:29');
INSERT INTO `membership_type` VALUES (12, '4 Months (Promo from 3 Months)', '3000.00', '0', 'Promo from 3 Months', NULL, '2026-03-02 21:17:40', '2026-03-02 21:17:40');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `lakan_user_id` int NOT NULL AUTO_INCREMENT,
  `user_type_id` int NULL DEFAULT NULL,
  `lakan_firstname` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lakan_middlename` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `lakan_lastname` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lakan_username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `lakan_password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `lakan_pass_confirm` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `account_activated` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `lakan_email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`lakan_user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 296 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 1, 'Garry', 'Dela Torre', 'Gajultos', 'garry', '$2y$10$XZYyuL2IeWpjTyb5b/A.eeCqbZ8t.ItcBd5VxdB47XSjsruR66hau', '123123', '1', '2026-01-21 05:06:39', '2026-01-29 23:39:15', 'gajultos.garrydev@gmail.com');
INSERT INTO `users` VALUES (293, NULL, 'John Edmund', 'Factura', 'Alarde', 'joed', '$2y$10$V3WHudCGjI52UpSsYRx1V.a2HOh.oBLbnPSpTXkYVwXDYq441KIAG', '123123', NULL, '2026-01-29 23:32:00', '2026-01-29 23:39:03', 'joed@gmail.com');
INSERT INTO `users` VALUES (294, NULL, 'Teof', '', 'Adora', 'teofadora', '$2y$10$GCSYXMUCLM.9.13dPFg0huJ9jDVVIORWFuNEEcua19z3hogfKPrZu', '123456789', NULL, '2026-01-29 19:25:36', '2026-01-29 20:06:03', 'teofilo.adora@gmail.com');
INSERT INTO `users` VALUES (295, NULL, 'Joji', '', 'Manansala', 'Nyii0823', '$2y$10$hs0qFcVWaBtjFRXD06UR5usIqJ6A7FRSArZzmoLo/fPA3fR0.7tne', 'Qwerty123', NULL, '2026-02-27 15:42:54', '2026-02-27 15:42:54', 'manansalajie0823@gmail.com');

-- ----------------------------
-- Table structure for walk_in
-- ----------------------------
DROP TABLE IF EXISTS `walk_in`;
CREATE TABLE `walk_in`  (
  `walk_id` int NOT NULL AUTO_INCREMENT,
  `walk_in_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `walk_in_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `walk_in_price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`walk_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of walk_in
-- ----------------------------
INSERT INTO `walk_in` VALUES (2, 'Jiro', 'Non Member', '180', '2026-03-13 16:09:31', '2026-03-13 16:45:04');
INSERT INTO `walk_in` VALUES (3, 'Joshua', 'Non Member', '180', '2026-03-14 12:41:05', '2026-03-14 12:41:05');
INSERT INTO `walk_in` VALUES (4, 'Shielo', 'Non Member', '180', '2026-03-14 12:43:00', '2026-03-14 12:43:00');
INSERT INTO `walk_in` VALUES (5, 'Vince', 'Non Member', '180', '2026-03-16 18:38:35', '2026-03-16 18:38:35');
INSERT INTO `walk_in` VALUES (6, 'Dei', 'Non Member', '180', '2026-03-16 18:38:43', '2026-03-16 18:38:43');
INSERT INTO `walk_in` VALUES (7, 'Joshua', 'Non Member', '180', '2026-03-17 14:26:45', '2026-03-17 14:26:45');
INSERT INTO `walk_in` VALUES (8, 'Ethan', 'Student (Non Member)', '150', '2026-03-17 18:54:35', '2026-03-31 21:11:54');
INSERT INTO `walk_in` VALUES (9, 'Dex', 'Member', '150', '2026-03-20 15:11:11', '2026-03-20 15:11:11');
INSERT INTO `walk_in` VALUES (10, 'Jomar', 'Member', '150', '2026-03-20 15:12:13', '2026-03-20 15:12:13');
INSERT INTO `walk_in` VALUES (11, 'Vince', 'Non Member', '180', '2026-03-20 15:12:21', '2026-03-20 15:12:21');
INSERT INTO `walk_in` VALUES (12, 'Dei', 'Non Member', '180', '2026-03-20 15:12:29', '2026-03-20 15:12:29');
INSERT INTO `walk_in` VALUES (13, 'Jasper', 'Non Member', '180', '2026-03-22 16:21:18', '2026-03-22 16:21:18');
INSERT INTO `walk_in` VALUES (14, 'Ej', 'Non Member', '180', '2026-03-22 16:21:26', '2026-03-22 16:21:26');
INSERT INTO `walk_in` VALUES (15, 'Jiro', 'Non Member', '180', '2026-03-23 14:44:20', '2026-03-23 14:44:20');
INSERT INTO `walk_in` VALUES (16, 'Ramon', 'Non Member', '180', '2026-03-24 13:02:10', '2026-03-24 13:02:10');
INSERT INTO `walk_in` VALUES (17, 'Justine', 'Student (Non Member)', '150', '2026-03-25 12:37:57', '2026-03-26 15:28:10');
INSERT INTO `walk_in` VALUES (18, 'Mood', 'Non Member', '180', '2026-03-25 12:38:07', '2026-03-26 15:28:15');
INSERT INTO `walk_in` VALUES (19, 'Ivy', 'Member', '150', '2026-03-26 12:38:44', '2026-03-26 12:38:44');
INSERT INTO `walk_in` VALUES (20, 'Vince', 'Non Member', '180', '2026-03-26 12:55:48', '2026-03-26 12:55:48');
INSERT INTO `walk_in` VALUES (21, 'Dlei', 'Non Member', '180', '2026-03-26 12:56:38', '2026-03-26 12:56:38');
INSERT INTO `walk_in` VALUES (22, 'Jasmin', 'Member', '150', '2026-03-27 17:44:45', '2026-03-27 17:44:45');
INSERT INTO `walk_in` VALUES (23, '1', 'Member', '150', '2026-03-31 21:12:04', '2026-03-31 21:12:04');
INSERT INTO `walk_in` VALUES (24, '2', 'Non Member', '180', '2026-03-31 21:12:08', '2026-03-31 21:12:08');

-- ----------------------------
-- Table structure for weight_history
-- ----------------------------
DROP TABLE IF EXISTS `weight_history`;
CREATE TABLE `weight_history`  (
  `weight_id` int NOT NULL AUTO_INCREMENT,
  `weight_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_id` int NULL DEFAULT NULL,
  `date_saved_weight` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT current_timestamp,
  PRIMARY KEY (`weight_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of weight_history
-- ----------------------------
INSERT INTO `weight_history` VALUES (10, '1', 68, '2026-04-01', '2026-04-01 00:21:27', '2026-04-01 00:21:27');
INSERT INTO `weight_history` VALUES (11, '2', 68, '2026-04-01', '2026-04-01 00:21:31', '2026-04-01 00:21:31');
INSERT INTO `weight_history` VALUES (12, '3', 68, '2026-04-01', '2026-04-01 00:21:35', '2026-04-01 00:21:35');
INSERT INTO `weight_history` VALUES (13, '4', 68, '2026-04-01', '2026-04-01 00:23:05', '2026-04-01 00:23:05');
INSERT INTO `weight_history` VALUES (14, '5', 68, '2026-04-01', '2026-04-01 00:23:28', '2026-04-01 00:23:28');

SET FOREIGN_KEY_CHECKS = 1;
