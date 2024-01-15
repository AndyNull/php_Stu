/*
Navicat MySQL Data Transfer

Source Server         : 192.168.88.129
Source Server Version : 50505
Source Host           : 192.168.88.129:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2024-01-15 15:12:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for client
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientname` char(30) DEFAULT NULL,
  `phone` char(30) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `sex` char(6) DEFAULT NULL,
  `mastername` char(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientname` (`clientname`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client
-- ----------------------------
INSERT INTO `client` VALUES ('9', '李四', '13333333333', '12@qq.com', 'ma1', 'admin');
INSERT INTO `client` VALUES ('11', 'z2s22', '15555555555', '12@qq.com', 'ma', 'admin');
INSERT INTO `client` VALUES ('12', '1z2s', '11111', '12@qq.com', 'ma', 'admin');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(30) DEFAULT NULL,
  `password` char(30) DEFAULT NULL,
  `phone` char(30) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `sex` char(6) DEFAULT NULL,
  `images` char(100) DEFAULT NULL,
  `lv` int(1) NOT NULL,
  `state` char(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '123456', '13122226713', '111@qq.com', '男', '/StuSYS/assets/images/avatar/231102104737165.png', '1', 'enable');

-- ----------------------------
-- Procedure structure for AddGeometryColumn
-- ----------------------------
DROP PROCEDURE IF EXISTS `AddGeometryColumn`;
DELIMITER ;;
CREATE DEFINER=`` PROCEDURE `AddGeometryColumn`(catalog varchar(64), t_schema varchar(64),
   t_name varchar(64), geometry_column varchar(64), t_srid int)
begin
  set @qwe= concat('ALTER TABLE ', t_schema, '.', t_name, ' ADD ', geometry_column,' GEOMETRY REF_SYSTEM_ID=', t_srid); PREPARE ls from @qwe; execute ls; deallocate prepare ls; end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for DropGeometryColumn
-- ----------------------------
DROP PROCEDURE IF EXISTS `DropGeometryColumn`;
DELIMITER ;;
CREATE DEFINER=`` PROCEDURE `DropGeometryColumn`(catalog varchar(64), t_schema varchar(64),
   t_name varchar(64), geometry_column varchar(64))
begin
  set @qwe= concat('ALTER TABLE ', t_schema, '.', t_name, ' DROP ', geometry_column); PREPARE ls from @qwe; execute ls; deallocate prepare ls; end
;;
DELIMITER ;
