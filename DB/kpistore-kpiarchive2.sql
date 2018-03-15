/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : kpistore

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-03-11 23:29:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for kpi_archive
-- ----------------------------
DROP TABLE IF EXISTS `kpi_archive`;
CREATE TABLE `kpi_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(50) DEFAULT NULL COMMENT 'หลายเลข referent สำหรับอัพโหลดไฟล์ ajax',
  `title` varchar(255) DEFAULT NULL COMMENT 'ชื่องาน',
  `description` text DEFAULT NULL COMMENT 'รายละเอียด',
  `covenant` varchar(255) DEFAULT NULL COMMENT 'หนังสือสัญญา',
  `docs` text DEFAULT NULL COMMENT 'เอกสารประกอบ',
  `start_date` date DEFAULT NULL COMMENT 'วันที่เริ่มสัญญา',
  `end_date` date DEFAULT NULL COMMENT 'วันที่สิ้นสุดสัญญา',
  `success_date` date DEFAULT NULL COMMENT 'งานเสร็จวันที่',
  `create_date` timestamp NULL DEFAULT current_timestamp() COMMENT 'สร้างวันที่',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kpi_archive
-- ----------------------------
INSERT INTO `kpi_archive` VALUES ('25', 'zO8DAi7jdJouo4QR8bI0JL', 'ตัวชี้วัดทดสอบ1', 'รายละเอียด ตัวชี้วัดทดสอบ1 ', '{\"fcf7c2f11470b878a760b674af43bad5.pdf\":\"สร้างฟอร์ม Upload File และเก็บข้อมูลเป็น json _ Yii 2 Learning.pdf\"}', '{\"d55a847e30b2cc59a631fdd412fddeae.pdf\":\"RBAC คืออะไร_ พร้อมสอนวิธีใช้ RBAC DB _ Yii 2 Learning.pdf\"}', null, null, null, '2018-03-11 23:27:03');

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1517460351');
INSERT INTO `migration` VALUES ('m140209_132017_init', '1517460354');
INSERT INTO `migration` VALUES ('m140403_174025_create_account_table', '1517460354');
INSERT INTO `migration` VALUES ('m140504_113157_update_tables', '1517460354');
INSERT INTO `migration` VALUES ('m140504_130429_create_token_table', '1517460355');
INSERT INTO `migration` VALUES ('m140830_171933_fix_ip_field', '1517460355');
INSERT INTO `migration` VALUES ('m140830_172703_change_account_table_name', '1517460355');
INSERT INTO `migration` VALUES ('m141222_110026_update_ip_field', '1517460355');
INSERT INTO `migration` VALUES ('m141222_135246_alter_username_length', '1517460355');
INSERT INTO `migration` VALUES ('m150614_103145_update_social_account_table', '1517460355');
INSERT INTO `migration` VALUES ('m150623_212711_fix_username_notnull', '1517460355');
INSERT INTO `migration` VALUES ('m151218_234654_add_timezone_to_profile', '1517460355');
INSERT INTO `migration` VALUES ('m160929_103127_add_last_login_at_to_user_table', '1517460355');

-- ----------------------------
-- Table structure for profile
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES ('1', null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('2', null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('3', null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for social_account
-- ----------------------------
DROP TABLE IF EXISTS `social_account`;
CREATE TABLE `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of social_account
-- ----------------------------

-- ----------------------------
-- Table structure for token
-- ----------------------------
DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of token
-- ----------------------------
INSERT INTO `token` VALUES ('1', 'LEF9Xh1x8JB7FoYTMbYPsNDqJJH2qdkv', '1517468719', '0');
INSERT INTO `token` VALUES ('2', 'seY-4Fgod8CAS8Yz1U8RoRtTziYFj8Lk', '1517469001', '0');
INSERT INTO `token` VALUES ('3', 'WtvzQhM7YkhPZQNBIH_rbewbu9_VY7DD', '1517504068', '0');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT 0,
  `last_login_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'klongthomhosptal@gmail.com', '$2y$10$xNTIrdDQkUGRKoxgSiNoYOqAitMZCd9crFniL5ncymxD/RkA/.WY6', 'LsnppAM-rFFa-HadV7j5EiGN5K5tRjqD', null, null, null, '127.0.0.1', '1517468719', '1517468719', '0', '1520738583');
INSERT INTO `user` VALUES ('2', 'nont', 'nontage24@gmail.com', '$2y$10$tQrbdbQmKCTY6nJADzfY6eSDM7zzFrUf8cE.cTAOk96ewkr.dO0e6', 'uiIFeiUjRe322nUZwKRAD0Blt80DS0Du', null, null, null, '127.0.0.1', '1517469001', '1517469001', '0', '1520738605');
INSERT INTO `user` VALUES ('3', 'nontawat', 'nontnii2530@gmail.com', '$2y$12$y8PEUPnMo8XLVjrQjPgORO.PXeteaprHT4AfLndZW9zCp9YqJ6lxe', 'qAdJCkEyXh5fMckv4mkUkrub5A5cDFMp', null, null, null, '127.0.0.1', '1517504068', '1517504068', '0', '1517504298');
