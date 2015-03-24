/*
Navicat MySQL Data Transfer

Source Server         : test1
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : photo

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-03-24 08:22:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_photo
-- ----------------------------
DROP TABLE IF EXISTS `tp_photo`;
CREATE TABLE `tp_photo` (
  `pid` bigint(64) NOT NULL AUTO_INCREMENT COMMENT '照片id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `time` timestamp NULL DEFAULT NULL COMMENT '照片上传时间',
  `pname` varchar(32) DEFAULT NULL COMMENT '照片名字md5加密',
  `path` varchar(80) DEFAULT NULL COMMENT '照片路径',
  `hash` char(32) NOT NULL,
  UNIQUE KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_photo
-- ----------------------------

-- ----------------------------
-- Table structure for tp_relationship
-- ----------------------------
DROP TABLE IF EXISTS `tp_relationship`;
CREATE TABLE `tp_relationship` (
  `uid` int(11) DEFAULT NULL,
  `ruid` int(11) unsigned DEFAULT NULL,
  KEY `uid` (`uid`,`ruid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_relationship
-- ----------------------------
INSERT INTO `tp_relationship` VALUES ('1', '2');

-- ----------------------------
-- Table structure for tp_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE `tp_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(16) NOT NULL,
  `email` varchar(48) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `phone` (`phone`,`email`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户基础表';

-- ----------------------------
-- Records of tp_user
-- ----------------------------
INSERT INTO `tp_user` VALUES ('1', '+8618768113974', '736886864@qq.com', 'Nicksxs', 'fb50d587c55e8568f77ea649133dda06');
INSERT INTO `tp_user` VALUES ('2', '18768113974', 'Nicksxs@163.com', 'Nicksxs01', 'fb50d587c55e8568f77ea649133dda06');
