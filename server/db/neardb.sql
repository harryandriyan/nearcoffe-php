/*
Navicat MySQL Data Transfer

Source Server         : LOKAL
Source Server Version : 50541
Source Host           : localhost:3306
Source Database       : neardb

Target Server Type    : MYSQL
Target Server Version : 50541
File Encoding         : 65001

Date: 2016-02-28 20:25:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for places
-- ----------------------------
DROP TABLE IF EXISTS `places`;
CREATE TABLE `places` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`foursquare_id`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`user_id`  int(11) NOT NULL ,
`note`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`status`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`saved`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of places
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`email`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`password`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`photo`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`country`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`address`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ,
`auth_foursquare`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`auth_facebook`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`auth_google`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`created`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=3

;

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'Harry', 'harry.andriyan@gmail.com', '57ba172a6be125cca2f449826f9980ca', null, null, null, null, null, null, '2016-01-24 21:15:54'), ('2', 'Maulana', 'maulana@kernel.org', '202cb962ac59075b964b07152d234b70', null, null, null, null, null, null, '2016-01-24 22:03:15');
COMMIT;

-- ----------------------------
-- Auto increment value for places
-- ----------------------------
ALTER TABLE `places` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for user
-- ----------------------------
ALTER TABLE `user` AUTO_INCREMENT=3;
