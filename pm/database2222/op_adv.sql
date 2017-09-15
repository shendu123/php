/*
Navicat MySQL Data Transfer

Source Server         : linux_open
Source Server Version : 50628
Source Host           : 192.168.71.236:3306
Source Database       : op_adv

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-09-15 17:52:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `opa_adv`
-- ----------------------------
DROP TABLE IF EXISTS `opa_adv`;
CREATE TABLE `opa_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '广告位id',
  `adv_name` varchar(255) NOT NULL COMMENT '广告名',
  `adv_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '广告图片',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示：0否，1是',
  `sort` int(11) NOT NULL DEFAULT '50',
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '广告链接',
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of opa_adv
-- ----------------------------
INSERT INTO `opa_adv` VALUES ('4', '2', 'adv2', 'http://api.wode-mall.com/uploads/20170821/de29cec31eb86f9947031b8965fcc0c7.jpg', '1', '50', 'http://www.baidu.com', '1502070000', '1503450900');
INSERT INTO `opa_adv` VALUES ('5', '4', 'aaa112121', 'http://api.wode-mall.com/uploads/20170821/ebabdcae58c9a2c2ec3077d3a3847536.jpg', '1', '2', 'http://abc.com', '1502933340', '1503556380');
INSERT INTO `opa_adv` VALUES ('6', '3', 'ttt', 'http://api.wode-mall.com/uploads/20170822/eab03a6c5fe7ba88aba91d42b855f836.jpg', '0', '50', 'http://www.sina.cn', '1501980300', '1502380800');
INSERT INTO `opa_adv` VALUES ('7', '4', 'testzzz', 'http://api.wode-mall.com/uploads/20170912/018e603d992e6ff58360e57c2dcdd019.jpg', '1', '1', 'www.baiduc.om', '1501609560', '1503594015');
INSERT INTO `opa_adv` VALUES ('8', '6', 'ccccc', 'http://api.wode-mall.com/uploads/20170912/141d385f61d61cb37a13c76d45893ea0.jpg', '1', '21', 'www.sina.com', '1507131930', '1509120915');

-- ----------------------------
-- Table structure for `opa_adv_position`
-- ----------------------------
DROP TABLE IF EXISTS `opa_adv_position`;
CREATE TABLE `opa_adv_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '广告位名称',
  `width` int(11) NOT NULL COMMENT '广告位宽',
  `height` int(11) NOT NULL COMMENT '广告位高',
  `desc` text COMMENT '描述',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0禁用，1启用',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of opa_adv_position
-- ----------------------------
INSERT INTO `opa_adv_position` VALUES ('2', 'test1111', '113', '112', '2121', '1', '1502871788');
INSERT INTO `opa_adv_position` VALUES ('3', 'test1', '11', '11', null, '1', '1502871910');
INSERT INTO `opa_adv_position` VALUES ('4', 'test2', '400', '100', 'test2desc', '1', '1503278644');
INSERT INTO `opa_adv_position` VALUES ('6', 'haha', '88', '100', 'keyi ma', '1', '1505180135');
