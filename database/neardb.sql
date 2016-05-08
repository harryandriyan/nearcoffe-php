

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
`comment_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`user_id`  int(4) NOT NULL ,
`venue_id`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`comment_data`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ,
`comment_date`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`comment_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=6

;

-- ----------------------------
-- Records of comment
-- ----------------------------
BEGIN;
INSERT INTO `comment` VALUES ('1', '1', '4baf3c8af964a520cdf23be3', 'tess', '2016-05-08 00:09:35'), ('2', '1', '4befdb46f831c928115701f2', 'tes', '2016-05-08 08:39:37'), ('3', '1', '4befdb46f831c928115701f2', 'asdas', '2016-05-08 08:40:19'), ('4', '1', '4befdb46f831c928115701f2', 'hello', '2016-05-08 09:09:13'), ('5', '1', '4befdb46f831c928115701f2', 'hello again', '2016-05-08 09:10:00');
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
AUTO_INCREMENT=5

;

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'Harry', 'harry.andriyan@gmail.com', '57ba172a6be125cca2f449826f9980ca', null, null, null, null, null, null, '2016-01-24 21:15:54'), ('2', 'Maulana', 'maulana@kernel.org', '202cb962ac59075b964b07152d234b70', null, null, null, null, null, null, '2016-01-24 22:03:15'), ('3', 'harry', 'harry@kernel.org', '57ba172a6be125cca2f449826f9980ca', null, null, null, null, null, null, '2016-04-02 14:49:03'), ('4', 'harry', 'andrian', 'aff4b352312d5569903d88e0e68d3fbb', null, null, null, null, null, null, '2016-04-02 15:18:44');
COMMIT;

-- ----------------------------
-- Table structure for venue
-- ----------------------------
DROP TABLE IF EXISTS `venue`;
CREATE TABLE `venue` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`foursquare_id`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`user_id`  int(11) NOT NULL ,
`note`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`status`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`saved`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=14

;

-- ----------------------------
-- Records of venue
-- ----------------------------
BEGIN;
INSERT INTO `venue` VALUES ('1', 'Starbucks Jogja City Mall', '54ec4378498e73ff8064fd5a', '2', null, null, '2016-03-25 16:09:04'), ('4', 'Kopi Luwak', '4befdb46f831c928115701f2', '1', null, null, '2016-03-25 18:58:45'), ('6', 'Peacock Coffee', '54917e11498e482af836c472', '1', null, null, '2016-03-28 08:20:50'), ('7', 'Starbucks Jogja City Mall', '54ec4378498e73ff8064fd5a', '4', null, null, '2016-04-02 15:40:57'), ('8', 'Peacock Coffee', '54917e11498e482af836c472', '2', null, null, '2016-04-02 15:41:46'), ('9', 'Excelso', '5391bf1c498ea85cdde72c0e', '2', null, null, '2016-04-02 15:42:00'), ('10', 'Gudeg Yu Djum', '4e2d2616fa76bbf847eac352', '2', null, null, '2016-04-02 15:42:36'), ('11', 'Calais Artisan Bubble Tea & Coffee', '549bce63498e3a6606932c65', '2', null, null, '2016-04-02 15:45:37'), ('12', 'Starbucks Jogja City Mall', '54ec4378498e73ff8064fd5a', '1', null, null, '2016-04-23 00:09:58'), ('13', 'Chacha Taiwan Milk Tea', '5194c374498ea886e69094ba', '1', null, null, '2016-05-01 14:00:04');
COMMIT;

-- ----------------------------
-- Auto increment value for comment
-- ----------------------------
ALTER TABLE `comment` AUTO_INCREMENT=6;

-- ----------------------------
-- Auto increment value for user
-- ----------------------------
ALTER TABLE `user` AUTO_INCREMENT=5;

-- ----------------------------
-- Auto increment value for venue
-- ----------------------------
ALTER TABLE `venue` AUTO_INCREMENT=14;
