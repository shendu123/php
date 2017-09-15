/*
Navicat MySQL Data Transfer

Source Server         : 本地连接
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : open_basic

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-15 18:11:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `opm_member`
-- ----------------------------
DROP TABLE IF EXISTS `opm_member`;
CREATE TABLE `opm_member` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱地址',
  `account` varchar(20) DEFAULT NULL COMMENT '登录账号',
  `nickname` varchar(20) DEFAULT NULL COMMENT '用户昵称',
  `pwd` char(32) DEFAULT NULL,
  `truename` varchar(20) DEFAULT NULL COMMENT '真实姓名',
  `mobile` varchar(11) DEFAULT NULL,
  `reg_date` int(10) DEFAULT NULL COMMENT '注册时间',
  `reg_ip` char(15) DEFAULT NULL COMMENT '注册IP地址',
  `verify_email` int(1) DEFAULT '0' COMMENT '电子邮件验证标示 0未验证，1已验证',
  `verify_mobile` int(1) DEFAULT '0' COMMENT '手机验证状态',
  `find_fwd_code` varchar(32) DEFAULT NULL COMMENT '找回密码验证随机码',
  `find_pwd_time` int(10) DEFAULT NULL COMMENT '找回密码申请提交时间',
  `find_pwd_exp_time` int(10) DEFAULT NULL COMMENT '找回密码验证随机码过期时间',
  `avatar` varchar(100) DEFAULT NULL COMMENT '用户头像',
  `birthday` int(10) DEFAULT NULL COMMENT '用户生日',
  `sex` int(1) DEFAULT NULL COMMENT '0女1男',
  `address` varchar(50) DEFAULT NULL COMMENT '地址',
  `postalcode` int(10) DEFAULT NULL COMMENT '邮政编码',
  `province` int(6) DEFAULT '0' COMMENT '省份',
  `city` int(6) DEFAULT '0' COMMENT '城市',
  `area` int(6) NOT NULL DEFAULT '0' COMMENT '区、县',
  `phone` varchar(30) DEFAULT NULL COMMENT '电话',
  `wallet_pledge` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金账户',
  `wallet_pledge_freeze` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金冻结金额',
  `wallet_limsum` float(10,2) DEFAULT NULL COMMENT '信用额度',
  `wallet_limsum_freeze` float(10,2) DEFAULT NULL COMMENT '信用冻结额度',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '卖家得分',
  `scorebuy` int(11) NOT NULL DEFAULT '0' COMMENT '买家得分',
  `login_ip` varchar(15) DEFAULT NULL COMMENT '登录ip',
  `login_time` int(10) DEFAULT NULL COMMENT '登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `weiauto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1：自动登陆；0：手动登陆',
  `alerttype` varchar(30) DEFAULT NULL COMMENT '提醒方式（email，mobile，weixin）',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT 'business.business_id',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推广人id,admin.adi',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`uid`),
  KEY `account` (`account`),
  KEY `email` (`email`),
  KEY `account_2` (`account`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站前台会员表';

-- ----------------------------
-- Records of opm_member
-- ----------------------------
INSERT INTO `opm_member` VALUES ('1', null, 'admin', '', 'e10adc3949ba59abbe56e057f20f883e', '管理员', null, null, null, '0', '0', null, null, null, null, null, null, null, null, '0', '0', '0', null, '0.00', '0.00', '0.00', '0.00', '0', '0', null, null, '1', '0', '', '0', '0', '0');
INSERT INTO `opm_member` VALUES ('2', null, 'user1', null, 'e10adc3949ba59abbe56e057f20f883e', '李丽', null, null, null, '0', '0', null, null, null, null, null, null, null, null, '0', '0', '0', null, '0.00', '0.00', null, null, '0', '0', null, null, '1', '0', null, '0', '0', '0');
INSERT INTO `opm_member` VALUES ('4', null, 'test', null, '96e79218965eb72c92a549dd5a330112', '测试', null, null, null, '0', '0', null, null, null, null, null, null, null, null, '0', '0', '0', null, '0.00', '0.00', null, null, '0', '0', null, null, '1', '0', null, '0', '0', '0');

-- ----------------------------
-- Table structure for `opm_member_role`
-- ----------------------------
DROP TABLE IF EXISTS `opm_member_role`;
CREATE TABLE `opm_member_role` (
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `role_id` mediumint(9) unsigned NOT NULL DEFAULT '0',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of opm_member_role
-- ----------------------------
INSERT INTO `opm_member_role` VALUES ('9', '12');
INSERT INTO `opm_member_role` VALUES ('9', '5');
INSERT INTO `opm_member_role` VALUES ('2', '1');
INSERT INTO `opm_member_role` VALUES ('3', '1');
INSERT INTO `opm_member_role` VALUES ('1', '1');
INSERT INTO `opm_member_role` VALUES ('2', '2');
INSERT INTO `opm_member_role` VALUES ('3', '2');
INSERT INTO `opm_member_role` VALUES ('4', '2');

-- ----------------------------
-- Table structure for `opm_node`
-- ----------------------------
DROP TABLE IF EXISTS `opm_node`;
CREATE TABLE `opm_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(50) NOT NULL DEFAULT '',
  `remark` varchar(255) NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型，1-菜单 | 0-方法',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '50',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `isdelete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`),
  KEY `isdelete` (`isdelete`),
  KEY `sort` (`sort`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=382 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of opm_node
-- ----------------------------
INSERT INTO `opm_node` VALUES ('1', '0', '1', 'Admin', '后台管理', '后台管理，不可更改', '1', '1', '1', '1', '0');
INSERT INTO `opm_node` VALUES ('2', '1', '1', 'AdminGroup', '分组管理', ' ', '2', '1', '1', '1', '1');
INSERT INTO `opm_node` VALUES ('3', '1', '1', 'AdminNode', '节点管理', ' ', '2', '1', '2', '1', '0');
INSERT INTO `opm_node` VALUES ('4', '1', '1', 'AdminRole', '角色管理', ' ', '2', '1', '3', '1', '0');
INSERT INTO `opm_node` VALUES ('5', '1', '1', 'AdminUser', '用户管理', '', '2', '1', '4', '1', '0');
INSERT INTO `opm_node` VALUES ('29', '5', '0', 'add', '添加', '', '3', '0', '51', '1', '0');
INSERT INTO `opm_node` VALUES ('34', '5', '0', 'password', '修改密码', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('35', '5', '0', 'index', '首页', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('36', '5', '0', 'edit', '编辑', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('37', '5', '0', 'delete', '删除', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('38', '4', '0', 'user', '用户列表', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('39', '4', '0', 'access', '授权', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('40', '4', '0', 'index', '首页', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('41', '4', '0', 'add', '添加', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('42', '4', '0', 'edit', '编辑', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('43', '4', '0', 'forbid', '默认禁用操作', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('44', '4', '0', 'delete', '删除', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('46', '3', '0', 'index', '首页', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('47', '3', '0', 'add', '添加', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('48', '3', '0', 'edit', '编辑', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('49', '3', '0', 'forbid', '默认禁用操作', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('50', '3', '0', 'delete', '删除', '', '3', '0', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('378', '5', '0', 'AdminUserChild', '二级用户', '', '3', '1', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('379', '378', '0', 'AdminUserGrandSon', '三级用户', '', '4', '1', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('380', '3', '0', 'AdminNodeChild', '二级节点', '', '3', '1', '50', '1', '0');
INSERT INTO `opm_node` VALUES ('381', '3', '0', 'addChildNode', '添加子节点', '', '3', '0', '50', '1', '0');

-- ----------------------------
-- Table structure for `opm_role`
-- ----------------------------
DROP TABLE IF EXISTS `opm_role`;
CREATE TABLE `opm_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `isdelete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`),
  KEY `isdelete` (`isdelete`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of opm_role
-- ----------------------------
INSERT INTO `opm_role` VALUES ('1', '0', '领导组', '领导组', '1', '0', '1208784792', '1493171421');
INSERT INTO `opm_role` VALUES ('2', '0', '网编组', '网编组', '1', '0', '1215496283', '1493171427');
INSERT INTO `opm_role` VALUES ('3', '0', '运营部', '运营部', '1', '0', '1490254040', '1491371840');
INSERT INTO `opm_role` VALUES ('4', '0', '开发组', '开发组', '1', '0', '1490254126', '1491031706');
INSERT INTO `opm_role` VALUES ('5', '0', '行政组', '行政组', '1', '0', '1490254258', '1491032332');
INSERT INTO `opm_role` VALUES ('15', '0', 'hfghfg', 'hgh', '0', '0', '1493170950', '1493170950');

-- ----------------------------
-- Table structure for `opm_role_node`
-- ----------------------------
DROP TABLE IF EXISTS `opm_role_node`;
CREATE TABLE `opm_role_node` (
  `role_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `node_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of opm_role_node
-- ----------------------------
INSERT INTO `opm_role_node` VALUES ('12', '5', '2', '1');
INSERT INTO `opm_role_node` VALUES ('12', '29', '3', '5');
INSERT INTO `opm_role_node` VALUES ('3', '4', '2', '1');
INSERT INTO `opm_role_node` VALUES ('3', '3', '2', '1');
INSERT INTO `opm_role_node` VALUES ('3', '378', '3', '5');
INSERT INTO `opm_role_node` VALUES ('3', '5', '2', '1');
INSERT INTO `opm_role_node` VALUES ('3', '381', '3', '3');
INSERT INTO `opm_role_node` VALUES ('3', '47', '3', '3');
INSERT INTO `opm_role_node` VALUES ('2', '36', '3', '5');
INSERT INTO `opm_role_node` VALUES ('1', '39', '3', '4');
INSERT INTO `opm_role_node` VALUES ('1', '40', '3', '4');
INSERT INTO `opm_role_node` VALUES ('1', '41', '3', '4');
INSERT INTO `opm_role_node` VALUES ('1', '44', '3', '4');
INSERT INTO `opm_role_node` VALUES ('1', '4', '2', '1');
INSERT INTO `opm_role_node` VALUES ('1', '29', '3', '5');
INSERT INTO `opm_role_node` VALUES ('1', '34', '3', '5');
INSERT INTO `opm_role_node` VALUES ('1', '35', '3', '5');
INSERT INTO `opm_role_node` VALUES ('1', '36', '3', '5');
INSERT INTO `opm_role_node` VALUES ('1', '37', '3', '5');
INSERT INTO `opm_role_node` VALUES ('1', '378', '3', '5');
INSERT INTO `opm_role_node` VALUES ('1', '379', '4', '378');
INSERT INTO `opm_role_node` VALUES ('1', '5', '2', '1');
INSERT INTO `opm_role_node` VALUES ('1', '50', '3', '3');
INSERT INTO `opm_role_node` VALUES ('1', '3', '2', '1');
INSERT INTO `opm_role_node` VALUES ('1', '380', '3', '3');
INSERT INTO `opm_role_node` VALUES ('1', '381', '3', '3');
