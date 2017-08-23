/*
Navicat MySQL Data Transfer

Source Server         : linux_open
Source Server Version : 50628
Source Host           : 192.168.71.236:3306
Source Database       : op_item

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-08-23 15:23:49
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
  `item_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '申购价格 注意与商品本身价格的区别',
  `item_sort` int(11) NOT NULL DEFAULT '0' COMMENT '商品列表排序',
  `item_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `item_freight_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '【预留】运费 可能与商品数量有关系',
  `item_business_cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '商户分类id，0表示平台',
  `item_inventory` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `item_intime` int(11) NOT NULL DEFAULT '0' COMMENT '插入时间',
  `item_is_recommend` tinyint(4) NOT NULL COMMENT '0不推荐，1推荐',
  PRIMARY KEY (`id`),
  KEY `msort` (`item_sort`),
  KEY `gid` (`goods_id`),
  KEY `endstatus` (`item_check`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='自由买卖表';

-- ----------------------------
-- Records of opi_item
-- ----------------------------
INSERT INTO `opi_item` VALUES ('1', '283', '1', '1', '5', '5', '1112222', 'freeGoods', '22', '0', '1', '', '1', '', '7.00', '2', '1503472767', '0.00', '0', '2', '1503301697', '1');
INSERT INTO `opi_item` VALUES ('2', '285', '1', '1', '5', '5', '222', 'freegoods2', '7', '0', '0', '', '1', '', '12.00', '3', '1503472661', '0.00', '0', '7', '1503306936', '0');
