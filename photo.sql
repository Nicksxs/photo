/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : photo

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-05-17 21:13:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_comment
-- ----------------------------
DROP TABLE IF EXISTS `tp_comment`;
CREATE TABLE `tp_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `pid` int(11) DEFAULT NULL COMMENT '评价的照片id',
  `comment` varchar(120) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '评论生成时间',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tp_like
-- ----------------------------
DROP TABLE IF EXISTS `tp_like`;
CREATE TABLE `tp_like` (
  `lid` int(11) NOT NULL AUTO_INCREMENT COMMENT '点赞记录id',
  `pid` int(11) DEFAULT NULL COMMENT '点赞的照片id',
  `uid` int(11) DEFAULT NULL COMMENT '给照片点赞的用户id',
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '点赞时间',
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `impression` text COMMENT '图片附带的感想',
  `comments` int(8) DEFAULT '0' COMMENT '评论数',
  `likes` int(8) DEFAULT '0' COMMENT '点赞数',
  UNIQUE KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tp_relationship
-- ----------------------------
DROP TABLE IF EXISTS `tp_relationship`;
CREATE TABLE `tp_relationship` (
  `uid` int(11) DEFAULT NULL COMMENT '关注者',
  `ruid` int(11) unsigned DEFAULT NULL COMMENT '被关注者',
  KEY `uid` (`uid`,`ruid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tp_stat
-- ----------------------------
DROP TABLE IF EXISTS `tp_stat`;
CREATE TABLE `tp_stat` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cookie` varchar(32) NOT NULL,
  `status` enum('logout','login') DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

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
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '用户注册时间',
  `status` enum('1','0') DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `phone` (`phone`,`email`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='用户基础表';
