/*
Navicat MySQL Data Transfer

Source Server         : linux_open
Source Server Version : 50628
Source Host           : 192.168.71.236:3306
Source Database       : op_bi

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-09-15 17:53:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `opbi_business_counter`
-- ----------------------------
DROP TABLE IF EXISTS `opbi_business_counter`;
CREATE TABLE `opbi_business_counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL COMMENT '商户id',
  `count_sale_num` int(11) DEFAULT '0' COMMENT '成交笔数',
  `count_sale_price` decimal(12,2) DEFAULT '0.00' COMMENT '成交金额',
  `count_attention_num` int(11) DEFAULT '0' COMMENT '粉丝数',
  PRIMARY KEY (`id`),
  KEY `business_id` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户计数器';

-- ----------------------------
-- Records of opbi_business_counter
-- ----------------------------
