/*
Navicat MySQL Data Transfer

Source Server         : linux_open
Source Server Version : 50628
Source Host           : 192.168.71.236:3306
Source Database       : op_item

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-09-15 17:54:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `opi_item`
-- ----------------------------
DROP TABLE IF EXISTS `opi_item`;
CREATE TABLE `opi_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自由买卖id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT '商户id',
  `item_oprid` int(11) NOT NULL DEFAULT '0' COMMENT '操作者id',
  `item_publishid` int(11) NOT NULL DEFAULT '0' COMMENT '发布人id',
  `item_checkid` int(11) NOT NULL DEFAULT '0' COMMENT '审核人id',
  `item_code` varchar(64) NOT NULL DEFAULT '' COMMENT '商品编号【统一生成编号】',
  `item_name` varchar(256) NOT NULL DEFAULT '' COMMENT '商品名称或标题',
  `item_total` int(11) NOT NULL DEFAULT '0' COMMENT '商品总量',
  `item_consume` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `item_check` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商品状态流：0待审核 1审核通过 2审核失败',
  `item_check_reason` varchar(256) NOT NULL DEFAULT '' COMMENT '审核失败原因',
  `item_onsale` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商品上架 0未上架 1已上架 2已下架',
  `item_onsale_reason` varchar(256) NOT NULL DEFAULT '' COMMENT '商品下架原因',
  `item_price` int(11) NOT NULL DEFAULT '0' COMMENT '自由买卖价格 注意与商品本身价格的区别',
  `item_sort` int(11) NOT NULL DEFAULT '0' COMMENT '商品列表排序',
  `item_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `item_freight_price` int(11) NOT NULL DEFAULT '0' COMMENT '【预留】运费 可能与商品数量有关系',
  `item_business_cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '商户分类id，0表示平台',
  `item_inventory` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `item_intime` int(11) NOT NULL DEFAULT '0' COMMENT '插入时间',
  `item_is_recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0不推荐，1推荐',
  PRIMARY KEY (`id`),
  KEY `msort` (`item_sort`),
  KEY `gid` (`goods_id`),
  KEY `endstatus` (`item_check`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='自由买卖表';

-- ----------------------------
-- Records of opi_item
-- ----------------------------
INSERT INTO `opi_item` VALUES ('1', '283', '1', '3', '5', '5', 'hahaha', 'freeGoods', '100', '0', '1', '', '1', '', '1', '1', '1505442598', '0', '0', '2', '1503301697', '1');
INSERT INTO `opi_item` VALUES ('2', '285', '7', '5', '5', '5', 'hahaha', 'freeGoodss222', '100', '0', '1', '', '1', '', '1', '2', '1505456994', '0', '0', '7', '1503306936', '1');
INSERT INTO `opi_item` VALUES ('3', '295', '1', '5', '5', '5', 'hahaha', 'freeGoodss222', '300', '0', '1', '', '1', '', '1', '3', '1505454371', '0', '0', '3', '1503623439', '1');
INSERT INTO `opi_item` VALUES ('5', '285', '1', '5', '5', '5', '', '', '400', '0', '1', '', '1', '', '1', '0', '1505459896', '0', '0', '400', '1505373731', '0');
INSERT INTO `opi_item` VALUES ('6', '295', '1', '5', '5', '5', '', '', '400', '0', '1', '', '1', '', '1', '0', '1505373785', '0', '0', '400', '1505373785', '0');
INSERT INTO `opi_item` VALUES ('7', '286', '1', '5', '0', '0', '', '', '400', '0', '0', '', '0', '', '1', '0', '1505374323', '0', '0', '400', '1505374323', '0');
INSERT INTO `opi_item` VALUES ('8', '330', '3', '5', '5', '5', '22222', '111', '222222222', '0', '1', '', '1', '', '1', '0', '1505463040', '0', '0', '222222222', '1505455713', '0');
