/*
Navicat MySQL Data Transfer

Source Server         : aliyun
Source Server Version : 50518
Source Host           : rdsuy8995snkrtskgq94w.mysql.rds.aliyuncs.com:3306
Source Database       : rrfut7h3c442xceb

Target Server Type    : MYSQL
Target Server Version : 50518
File Encoding         : 65001

Date: 2016-01-24 11:55:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE `tp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL COMMENT '用户名',
  `mobile` varchar(16) NOT NULL COMMENT '手机号',
  `email` varchar(48) NOT NULL COMMENT '邮箱',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `active` tinyint(1) DEFAULT NULL COMMENT '是否激活',
  `active_hash` varchar(32) DEFAULT NULL COMMENT '激活邮件token',
  `recover_hash` varchar(32) DEFAULT NULL COMMENT '重置密码token',
  `remember_identifier` tinyint(1) DEFAULT NULL COMMENT '记住密码标识',
  `remember_token` tinyint(1) DEFAULT NULL COMMENT '记住密码token',
  `created_at` date DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `phone` (`mobile`,`email`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户基础表';

-- ----------------------------
-- Records of tp_user
-- ----------------------------
