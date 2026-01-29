/*
 Navicat Premium Data Transfer

 Source Server         : PersonalProjectDB
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : lakan

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 29/01/2026 16:08:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `membership_type_id` int NULL DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
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
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (1, 2, 'Gajultos', 'Garry', '', '1998-12-18 00:00:00', '27', 'Male', '2025-12-12 00:00:00', '2026-12-12 00:00:00', 'Test34', 'Test3', 'Test3', NULL, NULL, 'gajultos.garrydevv@gmail.com', './../uploads/profile_picture/emp_1_1769663932.png', '2026-01-29 13:29:34', '2026-01-29 16:01:15');
INSERT INTO `customer` VALUES (3, 4, 'Mariano', 'System', '', '1999-12-12 00:00:00', '26', 'Male', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', NULL, NULL, '', NULL, '2026-01-29 15:58:30', '2026-01-29 16:05:29');

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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of membership_history
-- ----------------------------
INSERT INTO `membership_history` VALUES (1, 1, '2025-12-12 00:00:00', '2026-05-05 00:00:00', '2026-01-29 13:47:09', '2026-01-29 14:22:18', 4);

-- ----------------------------
-- Table structure for membership_type
-- ----------------------------
DROP TABLE IF EXISTS `membership_type`;
CREATE TABLE `membership_type`  (
  `membership_type_id` int NOT NULL AUTO_INCREMENT,
  `membership_type_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `membershiptype_price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `membershiptype_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_vip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`membership_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of membership_type
-- ----------------------------
INSERT INTO `membership_type` VALUES (1, '1 Month', '1500', '-', NULL, '2026-01-17 11:50:43', '2026-01-29 10:52:24');
INSERT INTO `membership_type` VALUES (2, '3  Months', '3500', '-', NULL, '2026-01-17 11:51:48', '2026-01-29 10:52:24');
INSERT INTO `membership_type` VALUES (3, '6 Months', '6500', '-', NULL, '2026-01-17 11:51:59', '2026-01-29 10:52:24');
INSERT INTO `membership_type` VALUES (4, 'VIP', '0', '-', NULL, '2026-01-20 14:45:37', '2026-01-29 12:01:15');

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
) ENGINE = InnoDB AUTO_INCREMENT = 294 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 1, 'Garry', 'Dela Torre', 'Gajultos', 'garry', '$2y$10$XZYyuL2IeWpjTyb5b/A.eeCqbZ8t.ItcBd5VxdB47XSjsruR66hau', '123123', '1', '2026-01-20 21:06:39', '2026-01-29 15:39:15', 'gajultos.garrydev@gmail.com');
INSERT INTO `users` VALUES (293, NULL, 'John Edmund', 'Factura', 'Alarde', 'joed', '$2y$10$V3WHudCGjI52UpSsYRx1V.a2HOh.oBLbnPSpTXkYVwXDYq441KIAG', '123123', NULL, '2026-01-29 15:32:00', '2026-01-29 15:39:03', 'joed@gmail.com');

SET FOREIGN_KEY_CHECKS = 1;
