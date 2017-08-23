/*
Navicat MySQL Data Transfer

Source Server         : linux_open
Source Server Version : 50628
Source Host           : 192.168.71.236:3306
Source Database       : op_finance

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-08-23 15:23:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `aaa`
-- ----------------------------
DROP TABLE IF EXISTS `aaa`;
CREATE TABLE `aaa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `balance` int(11) NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aaa
-- ----------------------------
INSERT INTO `aaa` VALUES ('1', '1', '101', '99');
INSERT INTO `aaa` VALUES ('2', '2', '122', '78');
INSERT INTO `aaa` VALUES ('3', '3', '133', '67');
INSERT INTO `aaa` VALUES ('4', '4', '100', '100');
INSERT INTO `aaa` VALUES ('5', '5', '100', '0');
INSERT INTO `aaa` VALUES ('6', '6', '100', '0');

-- ----------------------------
-- Table structure for `opf_auction_order`
-- ----------------------------
DROP TABLE IF EXISTS `opf_auction_order`;
CREATE TABLE `opf_auction_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '拍卖订单id',
  `order_code` varchar(64) NOT NULL DEFAULT '' COMMENT '订单号(按规则统一生成唯一)',
  `order_name` varchar(64) NOT NULL DEFAULT '' COMMENT '订单名称',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属商户id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属买家id',
  `express_id` int(11) NOT NULL DEFAULT '0' COMMENT '快递公司id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '收货人地址id',
  `order_amount_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】订单总额(未做任何扣除)',
  `order_paytotal_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】用户支付总额 paytotal = (amount - youhui - integral_price) + freight;(amount - youhui - integral_price)必须为正',
  `order_youhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】订单优惠总额',
  `order_freight_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】运费总额',
  `order_integral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】结算时积分抵扣总额',
  `order_deposit_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买家已缴纳保证金总额',
  `order_broker_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】卖家需缴纳佣金总额',
  `order_integral` int(11) NOT NULL DEFAULT '0' COMMENT '结算时抵扣积分总数',
  `order_selfintegral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】【对总订单】结算时积分抵扣金额',
  `order_selfintegral` int(11) NOT NULL DEFAULT '0' COMMENT '【对总订单】结算时抵扣积分数',
  `order_selfyouhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】【对总订单】优惠金额',
  `order_pay_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式: 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它',
  `order_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单流程状态:0待付款 1付款中 2已付款/处理中/待发货 3付款失败 10已发货 20已完成 30申请退货 35驳回退货 40退货处理中 45已退货 99作废',
  `order_isxtrc` tinyint(3) NOT NULL DEFAULT '0' COMMENT '佣金提取状态: 0未提取 1已提取',
  `order_xtrctime` int(11) NOT NULL DEFAULT '0' COMMENT '佣金提取时间',
  `order_isdelete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单删除状态: 0正常 1已删除',
  `order_deltime` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除时间',
  `order_delid` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除操作者',
  `order_stuff_num` int(11) NOT NULL DEFAULT '0' COMMENT '物品总数',
  `order_paytime` int(11) NOT NULL DEFAULT '0' COMMENT '订单支付时间',
  `order_confirmid` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单操作者id',
  `order_confirm_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单时间',
  `order_express_info` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方物流信息，一般是物流单号',
  `order_deliverid` int(11) NOT NULL DEFAULT '0' COMMENT '发货人员id',
  `order_deliver_time` int(11) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `order_takeover_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认收货时间',
  `order_address_info` varchar(1024) NOT NULL DEFAULT '' COMMENT '序列化后的地址信息,防止用户修改,作为物流寄件地址',
  `order_buier_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '买家留言',
  `order_seller_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '卖家备注',
  `order_third_ordercode` varchar(128) NOT NULL DEFAULT '' COMMENT '第三方单号',
  `order_third_payinfo` varchar(512) NOT NULL DEFAULT '' COMMENT '【序列化保存】第三方支付返回信息',
  `order_intime` int(11) NOT NULL DEFAULT '0' COMMENT '订单生成时间',
  `order_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '订单修改时间，只要数据有变动就更新时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_code` (`order_code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='拍卖订单主表';

-- ----------------------------
-- Records of opf_auction_order
-- ----------------------------
INSERT INTO `opf_auction_order` VALUES ('12', 'AUCTION00027817082116533253385', '拍卖订单', '3', '259', '52', '85', '100', '90', '5', '10', '5', '1', '400', '5', '0', '0', '0', '0', '2', '0', '0', '0', '0', '0', '1', '1503305635', '0', '0', '', '0', '0', '0', 'a:17:{s:2:\"id\";i:85;s:9:\"addr_type\";i:0;s:8:\"owner_id\";i:259;s:8:\"province\";i:8765;s:4:\"city\";i:8766;s:4:\"area\";i:8769;s:12:\"addr_address\";s:17:\"金工路10223号\";s:15:\"addr_postalcode\";s:6:\"351100\";s:13:\"addr_truename\";s:9:\"林仲达\";s:11:\"addr_mobile\";s:11:\"18650723093\";s:10:\"addr_phone\";s:11:\"0591-888888\";s:14:\"addr_isdefault\";i:0;s:11:\"addr_uptime\";i:1503278947;s:11:\"addr_intime\";i:1501667222;s:12:\"province_tag\";s:9:\"福建省\";s:8:\"city_tag\";s:9:\"福州市\";s:8:\"area_tag\";s:9:\"仓山区\";}', '买家留言', '', '', 's:0:\"\";', '1503305612', '1503305635');

-- ----------------------------
-- Table structure for `opf_auction_order_detail`
-- ----------------------------
DROP TABLE IF EXISTS `opf_auction_order_detail`;
CREATE TABLE `opf_auction_order_detail` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引id 不能用于业务逻辑',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '拍卖订单id',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属商户id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `detail_stuff_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '拍卖类型:10竞价 11拍卖 12VIP 13专场 14拍卖会',
  `detail_stuff_id` int(11) NOT NULL DEFAULT '0' COMMENT '拍卖id',
  `detail_num` int(11) NOT NULL DEFAULT '0' COMMENT '拍卖商品数量',
  `detail_broker_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】卖家需缴纳佣金',
  `detail_deposit_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买家已缴纳保证金',
  `detail_youhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】优惠金额',
  `detail_integral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】结算时积分抵扣金额',
  `detail_freight_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】物流费用',
  `detail_integral` int(11) NOT NULL DEFAULT '0' COMMENT '结算时抵扣积分数',
  `detail_goods_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买时商品单价',
  `detail_goods_attr_value` text COMMENT '商品：买时sku',
  `detail_goods_attr_str` varchar(512) NOT NULL DEFAULT '' COMMENT '商品：买时sku解析后的字符串',
  `detail_goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品名称',
  `detail_goods_thumb` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品主图',
  `detail_goods_sn` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品序列号',
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='拍卖订单详情表';

-- ----------------------------
-- Records of opf_auction_order_detail
-- ----------------------------
INSERT INTO `opf_auction_order_detail` VALUES ('15', '12', '3', '259', '253', '10', '100', '1', '4', '1', '5', '5', '0', '5', '90', null, '', '竞价桌子', '', '5554');

-- ----------------------------
-- Table structure for `opf_crowd_order`
-- ----------------------------
DROP TABLE IF EXISTS `opf_crowd_order`;
CREATE TABLE `opf_crowd_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '申购订单id',
  `order_code` varchar(64) NOT NULL DEFAULT '' COMMENT '订单号(按规则统一生成唯一)',
  `order_name` varchar(64) NOT NULL DEFAULT '' COMMENT '订单名称',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属商户id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属买家id',
  `express_id` int(11) NOT NULL DEFAULT '0' COMMENT '快递公司id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '收货人地址id',
  `order_amount_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】订单总额(未做任何扣除)',
  `order_paytotal_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】用户支付总额 paytotal = (amount - youhui - integral_price) + freight;(amount - youhui - integral_price)必须为正',
  `order_youhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】订单优惠总额',
  `order_freight_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】运费总额',
  `order_integral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】结算时积分抵扣总额',
  `order_deposit_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买家已缴纳保证金总额',
  `order_broker_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】卖家需缴纳佣金总额',
  `order_integral` int(11) NOT NULL DEFAULT '0' COMMENT '结算时抵扣积分总数',
  `order_selfintegral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】【对总订单】结算时积分抵扣金额',
  `order_selfintegral` int(11) NOT NULL DEFAULT '0' COMMENT '【对总订单】结算时抵扣积分数',
  `order_selfyouhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】【对总订单】优惠金额',
  `order_pay_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式: 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它',
  `order_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单流程状态:0待付款 1付款中 2已付款/处理中/待发货 3付款失败 10已发货 20已完成 30申请退货 35驳回退货 40退货处理中 45已退货 99作废',
  `order_isxtrc` tinyint(3) NOT NULL DEFAULT '0' COMMENT '佣金提取状态: 0未提取 1已提取',
  `order_xtrctime` int(11) NOT NULL DEFAULT '0' COMMENT '佣金提取时间',
  `order_isdelete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单删除状态: 0正常 1已删除',
  `order_deltime` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除时间',
  `order_delid` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除操作者',
  `order_stuff_num` int(11) NOT NULL DEFAULT '0' COMMENT '物品总数',
  `order_paytime` int(11) NOT NULL DEFAULT '0' COMMENT '订单支付时间',
  `order_confirmid` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单操作者id',
  `order_confirm_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单时间',
  `order_express_info` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方物流信息，一般是物流单号',
  `order_deliverid` int(11) NOT NULL DEFAULT '0' COMMENT '发货人员id',
  `order_deliver_time` int(11) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `order_takeover_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认收货时间',
  `order_address_info` varchar(1024) NOT NULL DEFAULT '' COMMENT '序列化后的地址信息,防止用户修改,作为物流寄件地址',
  `order_buier_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '买家留言',
  `order_seller_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '卖家备注',
  `order_third_ordercode` varchar(128) NOT NULL DEFAULT '' COMMENT '第三方单号',
  `order_third_payinfo` varchar(512) NOT NULL DEFAULT '' COMMENT '【序列化保存】第三方支付返回信息',
  `order_intime` int(11) NOT NULL DEFAULT '0' COMMENT '订单生成时间',
  `order_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '订单修改时间，只要数据有变动就更新时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_code` (`order_code`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='申购订单主表';

-- ----------------------------
-- Records of opf_crowd_order
-- ----------------------------
INSERT INTO `opf_crowd_order` VALUES ('16', 'CROWD00027817082209552034900', '申购订单', '3', '259', '52', '85', '100', '90', '5', '10', '5', '0', '1', '5', '0', '0', '0', '0', '2', '0', '0', '0', '0', '0', '1', '1503366937', '0', '0', '', '0', '0', '0', 'a:17:{s:2:\"id\";i:85;s:9:\"addr_type\";i:0;s:8:\"owner_id\";i:259;s:8:\"province\";i:8765;s:4:\"city\";i:8766;s:4:\"area\";i:8769;s:12:\"addr_address\";s:17:\"金工路10223号\";s:15:\"addr_postalcode\";s:6:\"351100\";s:13:\"addr_truename\";s:9:\"林仲达\";s:11:\"addr_mobile\";s:11:\"18650723093\";s:10:\"addr_phone\";s:11:\"0591-888888\";s:14:\"addr_isdefault\";i:0;s:11:\"addr_uptime\";i:1503278947;s:11:\"addr_intime\";i:1501667222;s:12:\"province_tag\";s:9:\"福建省\";s:8:\"city_tag\";s:9:\"福州市\";s:8:\"area_tag\";s:9:\"仓山区\";}', '买家留言', '', '', 's:0:\"\";', '1503366918', '1503366937');
INSERT INTO `opf_crowd_order` VALUES ('17', 'CROWD00027817082209554319458', '申购订单', '3', '259', '52', '85', '100', '90', '5', '10', '5', '0', '1', '5', '0', '0', '0', '0', '2', '0', '0', '0', '0', '0', '1', '1503366951', '0', '0', '', '0', '0', '0', 'a:17:{s:2:\"id\";i:85;s:9:\"addr_type\";i:0;s:8:\"owner_id\";i:259;s:8:\"province\";i:8765;s:4:\"city\";i:8766;s:4:\"area\";i:8769;s:12:\"addr_address\";s:17:\"金工路10223号\";s:15:\"addr_postalcode\";s:6:\"351100\";s:13:\"addr_truename\";s:9:\"林仲达\";s:11:\"addr_mobile\";s:11:\"18650723093\";s:10:\"addr_phone\";s:11:\"0591-888888\";s:14:\"addr_isdefault\";i:0;s:11:\"addr_uptime\";i:1503278947;s:11:\"addr_intime\";i:1501667222;s:12:\"province_tag\";s:9:\"福建省\";s:8:\"city_tag\";s:9:\"福州市\";s:8:\"area_tag\";s:9:\"仓山区\";}', '买家留言', '', '', 's:0:\"\";', '1503366943', '1503366951');

-- ----------------------------
-- Table structure for `opf_crowd_order_detail`
-- ----------------------------
DROP TABLE IF EXISTS `opf_crowd_order_detail`;
CREATE TABLE `opf_crowd_order_detail` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引id 不能用于业务逻辑',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '申购订单id',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属商户id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `detail_stuff_id` int(11) NOT NULL DEFAULT '0' COMMENT '申购id',
  `detail_num` int(11) NOT NULL DEFAULT '0' COMMENT '申购商品数量',
  `detail_broker_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】卖家需缴纳佣金',
  `detail_deposit_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买家已缴纳保证金',
  `detail_youhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】优惠金额',
  `detail_integral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】结算时积分抵扣金额',
  `detail_freight_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】物流费用',
  `detail_integral` int(11) NOT NULL DEFAULT '0' COMMENT '结算时抵扣积分数',
  `detail_goods_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买时商品单价',
  `detail_goods_attr_value` text COMMENT '商品：买时sku',
  `detail_goods_attr_str` varchar(512) NOT NULL DEFAULT '' COMMENT '商品：买时sku解析后的字符串',
  `detail_goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品名称',
  `detail_goods_thumb` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品主图',
  `detail_goods_sn` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品序列号',
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of opf_crowd_order_detail
-- ----------------------------
INSERT INTO `opf_crowd_order_detail` VALUES ('12', '16', '3', '259', '258', '84', '1', '1', '1', '5', '5', '0', '5', '90', null, '', '申购小米', '', '');
INSERT INTO `opf_crowd_order_detail` VALUES ('13', '17', '3', '259', '258', '84', '1', '1', '1', '5', '5', '0', '5', '90', null, '', '申购小米', '', '');

-- ----------------------------
-- Table structure for `opf_deposit_order`
-- ----------------------------
DROP TABLE IF EXISTS `opf_deposit_order`;
CREATE TABLE `opf_deposit_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '保证金id',
  `order_code` varchar(64) NOT NULL DEFAULT '' COMMENT '订单号(按规则统一生成唯一)',
  `order_name` varchar(64) NOT NULL DEFAULT '' COMMENT '订单名称',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属商户id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属买家id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '收货人地址id',
  `order_stuff_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '业务类型:0竞价保证金',
  `order_stuff_id` int(11) NOT NULL DEFAULT '0' COMMENT '业务id: 0对应auction.id',
  `order_paytotal_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】用户支付总额',
  `order_pay_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式: 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它',
  `order_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单流程状态:0待付款 1付款中 2已付款 3付款失败 5转移成功 6释放成功 7扣除成功 11退款中 12已退款',
  `order_isdelete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单删除状态: 0正常 1已删除',
  `order_deltime` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除时间',
  `order_delid` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除操作者',
  `order_paytime` int(11) NOT NULL DEFAULT '0' COMMENT '订单支付时间',
  `order_confirmid` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单操作者id',
  `order_confirm_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单时间',
  `order_third_ordercode` varchar(128) NOT NULL DEFAULT '' COMMENT '第三方单号',
  `order_third_payinfo` varchar(512) NOT NULL DEFAULT '' COMMENT '【序列化保存】第三方支付返回信息',
  `order_address_info` varchar(1024) NOT NULL DEFAULT '' COMMENT '序列化后的地址信息,防止用户修改,作为物流寄件地址',
  `order_intime` int(11) NOT NULL DEFAULT '0' COMMENT '订单生成时间',
  `order_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '订单修改时间，只要数据有变动就更新时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_code` (`order_code`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='缴纳保证金订单主表';

-- ----------------------------
-- Records of opf_deposit_order
-- ----------------------------
INSERT INTO `opf_deposit_order` VALUES ('30', 'AUDEPOSIT00027817082116524676187', '拍卖保证金订单', '3', '259', '85', '0', '100', '1', '0', '5', '0', '0', '0', '1503305587', '0', '0', '', 's:0:\"\";', 'a:17:{s:2:\"id\";i:85;s:9:\"addr_type\";i:0;s:8:\"owner_id\";i:259;s:8:\"province\";i:8765;s:4:\"city\";i:8766;s:4:\"area\";i:8769;s:12:\"addr_address\";s:17:\"金工路10223号\";s:15:\"addr_postalcode\";s:6:\"351100\";s:13:\"addr_truename\";s:9:\"林仲达\";s:11:\"addr_mobile\";s:11:\"18650723093\";s:10:\"addr_phone\";s:11:\"0591-888888\";s:14:\"addr_isdefault\";i:0;s:11:\"addr_uptime\";i:1503278947;s:11:\"addr_intime\";i:1501667222;s:12:\"province_tag\";s:9:\"福建省\";s:8:\"city_tag\";s:9:\"福州市\";s:8:\"area_tag\";s:9:\"仓山区\";}', '1503305566', '1503305612');

-- ----------------------------
-- Table structure for `opf_freetrading_order`
-- ----------------------------
DROP TABLE IF EXISTS `opf_freetrading_order`;
CREATE TABLE `opf_freetrading_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自由买卖订单id',
  `order_code` varchar(64) NOT NULL DEFAULT '' COMMENT '订单号(按规则统一生成唯一)',
  `order_name` varchar(64) NOT NULL DEFAULT '' COMMENT '订单名称',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属商户id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属买家id',
  `express_id` int(11) NOT NULL DEFAULT '0' COMMENT '快递公司id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '收货人地址id',
  `order_amount_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】订单总额(未做任何扣除)',
  `order_paytotal_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】用户支付总额 paytotal = (amount - youhui - integral_price) + freight;(amount - youhui - integral_price)必须为正',
  `order_youhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】订单优惠总额',
  `order_freight_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】运费总额',
  `order_integral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】结算时积分抵扣总额',
  `order_deposit_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买家已缴纳保证金总额',
  `order_broker_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】卖家需缴纳佣金总额',
  `order_integral` int(11) NOT NULL DEFAULT '0' COMMENT '结算时抵扣积分总数',
  `order_selfintegral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】【对总订单】结算时积分抵扣金额',
  `order_selfintegral` int(11) NOT NULL DEFAULT '0' COMMENT '【对总订单】结算时抵扣积分数',
  `order_selfyouhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】【对总订单】优惠金额',
  `order_pay_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式: 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它',
  `order_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单流程状态:0待付款 1付款中 2已付款/处理中/待发货 3付款失败 10已发货 20已完成 30申请退货 35驳回退货 40退货处理中 45已退货',
  `order_isxtrc` tinyint(3) NOT NULL DEFAULT '0' COMMENT '佣金提取状态: 0未提取 1已提取',
  `order_xtrctime` int(11) NOT NULL DEFAULT '0' COMMENT '佣金提取时间',
  `order_isdelete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单删除状态: 0正常 1已删除',
  `order_deltime` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除时间',
  `order_delid` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除操作者',
  `order_stuff_num` int(11) NOT NULL DEFAULT '0' COMMENT '物品总数',
  `order_paytime` int(11) NOT NULL DEFAULT '0' COMMENT '订单支付时间',
  `order_confirmid` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单操作者id',
  `order_confirm_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单时间',
  `order_express_info` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方物流信息，一般是物流单号',
  `order_deliverid` int(11) NOT NULL DEFAULT '0' COMMENT '发货人员id',
  `order_deliver_time` int(11) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `order_takeover_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认收货时间',
  `order_address_info` varchar(1024) NOT NULL DEFAULT '' COMMENT '序列化后的地址信息,防止用户修改,作为物流寄件地址',
  `order_buier_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '买家留言',
  `order_seller_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '卖家备注',
  `order_third_ordercode` varchar(128) NOT NULL DEFAULT '' COMMENT '第三方单号',
  `order_third_payinfo` varchar(512) NOT NULL DEFAULT '' COMMENT '【序列化保存】第三方支付返回信息',
  `order_intime` int(11) NOT NULL DEFAULT '0' COMMENT '订单生成时间',
  `order_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '订单修改时间，只要数据有变动就更新时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_code` (`order_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='自由买卖订单主表';

-- ----------------------------
-- Records of opf_freetrading_order
-- ----------------------------
INSERT INTO `opf_freetrading_order` VALUES ('1', 'aaaa', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', '0', '0', '', '', '', '', '', '0', '0');

-- ----------------------------
-- Table structure for `opf_freetrading_order_detail`
-- ----------------------------
DROP TABLE IF EXISTS `opf_freetrading_order_detail`;
CREATE TABLE `opf_freetrading_order_detail` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引id 不能用于业务逻辑',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '自由买卖订单id',
  `business_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属商户id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `detail_stuff_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '拍卖类型:10竞价 11拍卖 12VIP 13专场 14拍卖会',
  `detail_stuff_id` int(11) NOT NULL DEFAULT '0' COMMENT '拍卖id',
  `detail_num` int(11) NOT NULL DEFAULT '0' COMMENT '拍卖商品数量',
  `detail_broker_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】卖家需缴纳佣金',
  `detail_deposit_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买家已缴纳保证金',
  `detail_youhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】优惠金额',
  `detail_integral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】结算时积分抵扣金额',
  `detail_freight_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】物流费用',
  `detail_integral` int(11) NOT NULL DEFAULT '0' COMMENT '结算时抵扣积分数',
  `detail_goods_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】买时商品单价',
  `detail_goods_attr_value` text COMMENT '商品：买时sku',
  `detail_goods_attr_str` varchar(512) NOT NULL DEFAULT '' COMMENT '商品：买时sku解析后的字符串',
  `detail_goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品名称',
  `detail_goods_thumb` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品主图',
  `detail_goods_sn` varchar(128) NOT NULL DEFAULT '' COMMENT '商品: 买时商品序列号',
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='自由买卖订单详情表';

-- ----------------------------
-- Records of opf_freetrading_order_detail
-- ----------------------------
INSERT INTO `opf_freetrading_order_detail` VALUES ('1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, '', '', '', '');
INSERT INTO `opf_freetrading_order_detail` VALUES ('2', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, '', '', '', '');

-- ----------------------------
-- Table structure for `opf_fund_flow`
-- ----------------------------
DROP TABLE IF EXISTS `opf_fund_flow`;
CREATE TABLE `opf_fund_flow` (
  `flow_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '资金流水id',
  `flow_code` varchar(64) NOT NULL DEFAULT '' COMMENT '资金流编号',
  `flow_fromid` int(11) NOT NULL DEFAULT '0' COMMENT '流水发起端: 0系统 其它为会员id',
  `flow_from_paytype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付类型: 0余额 1微信 2支付宝 3银行卡 4汇潮 99其它',
  `flow_toid` int(11) NOT NULL DEFAULT '0' COMMENT '流水结束端:-1未定义 0系统 其它为会员id',
  `flow_to_paytype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付类型: -1未定义 0余额 1微信 2支付宝 3银行卡 4汇潮 99其它',
  `flow_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0余额变动记录 1交易记录',
  `flow_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】流水金额 正数为增加 负数为减少',
  `flow_order_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类型: 1拍卖下单 2申购下单 3自由买卖下单 4缴纳保证金  5余额充值 6余额提现',
  `flow_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `flow_available_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】流水生成之前的钱包可用余额',
  `flow_remarks` varchar(128) NOT NULL DEFAULT '' COMMENT '流水描述',
  `flow_intime` int(11) NOT NULL DEFAULT '0' COMMENT '生成流水时间',
  PRIMARY KEY (`flow_id`),
  UNIQUE KEY `flow_code` (`flow_code`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='资金流水记录日志';

-- ----------------------------
-- Records of opf_fund_flow
-- ----------------------------
INSERT INTO `opf_fund_flow` VALUES ('76', 'FUNDFLOW00027817082116530773969', '259', '0', '-1', '-1', '0', '1', '4', '30', '1000', '保证金业务支付金额0.01元', '1503305587');
INSERT INTO `opf_fund_flow` VALUES ('77', 'FUNDFLOW00027817082116535585864', '259', '0', '-1', '-1', '0', '89', '1', '12', '999', '拍卖业务支付金额0.89元', '1503305635');
INSERT INTO `opf_fund_flow` VALUES ('80', 'FUNDFLOW00027817082209553725907', '259', '0', '-1', '-1', '0', '90', '2', '16', '910', '申购业务支付金额0.90元', '1503366937');
INSERT INTO `opf_fund_flow` VALUES ('81', 'FUNDFLOW00027817082209555164001', '259', '0', '-1', '-1', '0', '90', '2', '17', '820', '申购业务支付金额0.90元', '1503366951');
INSERT INTO `opf_fund_flow` VALUES ('82', 'FUNDFLOW00027817082215450153643', '259', '0', '-1', '-1', '0', '90', '2', '18', '730', '申购业务支付金额0.90元', '1503387901');

-- ----------------------------
-- Table structure for `opf_integral_flow`
-- ----------------------------
DROP TABLE IF EXISTS `opf_integral_flow`;
CREATE TABLE `opf_integral_flow` (
  `flow_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '积分流水id',
  `flow_code` varchar(64) NOT NULL DEFAULT '' COMMENT '积分流编号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `flow_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0:减少 1:增加',
  `flow_num` int(11) NOT NULL DEFAULT '0' COMMENT '积分变动数目',
  `flow_remarks` varchar(128) NOT NULL DEFAULT '' COMMENT '流水描述',
  `flow_intime` int(11) NOT NULL DEFAULT '0' COMMENT '生成流水时间',
  PRIMARY KEY (`flow_id`),
  UNIQUE KEY `flow_code` (`flow_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分流水记录日志';

-- ----------------------------
-- Records of opf_integral_flow
-- ----------------------------

-- ----------------------------
-- Table structure for `opf_order`
-- ----------------------------
DROP TABLE IF EXISTS `opf_order`;
CREATE TABLE `opf_order` (
  `id` bigint(32) NOT NULL AUTO_INCREMENT COMMENT '订单系统id',
  `order_code` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号(按规则统一生成唯一)',
  `order_name` varchar(64) NOT NULL DEFAULT '' COMMENT '订单名称',
  `stuff_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '业务类型 1:auction 2:crowd 3:freetrading 4:deposit 5:余额充值',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '业务订单id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_code` (`order_code`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='订单系统表';

-- ----------------------------
-- Records of opf_order
-- ----------------------------
INSERT INTO `opf_order` VALUES ('45', 'AUDEPOSIT00027817082116524676187', '拍卖保证金订单', '4', '30');
INSERT INTO `opf_order` VALUES ('46', 'AUCTION00027817082116533253385', '拍卖订单', '1', '12');
INSERT INTO `opf_order` VALUES ('49', 'CROWD00027817082209552034900', '申购订单', '2', '16');
INSERT INTO `opf_order` VALUES ('50', 'CROWD00027817082209554319458', '申购订单', '2', '17');

-- ----------------------------
-- Table structure for `opf_recharge_order`
-- ----------------------------
DROP TABLE IF EXISTS `opf_recharge_order`;
CREATE TABLE `opf_recharge_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '申购订单id',
  `order_code` varchar(64) NOT NULL DEFAULT '' COMMENT '订单号(按规则统一生成唯一)',
  `order_name` varchar(64) NOT NULL DEFAULT '' COMMENT '订单名称',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属买家id',
  `order_amount_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】订单总额(未做任何扣除)',
  `order_paytotal_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】用户支付总额 paytotal = (amount - youhui)',
  `order_youhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】订单优惠总额',
  `order_integral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】结算时积分抵扣总额',
  `order_integral` int(11) NOT NULL DEFAULT '0' COMMENT '结算时抵扣积分总数',
  `order_selfintegral_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】【对总订单】结算时积分抵扣金额',
  `order_selfintegral` int(11) NOT NULL DEFAULT '0' COMMENT '【对总订单】结算时抵扣积分数',
  `order_selfyouhui_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】【对总订单】优惠金额',
  `order_pay_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '支付方式: 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它',
  `order_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单支付状态:0待付款 1付款中 2已付款 3付款失败',
  `order_isdelete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单删除状态: 0正常 1已删除',
  `order_deltime` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除时间',
  `order_delid` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除操作者',
  `order_paytime` int(11) NOT NULL DEFAULT '0' COMMENT '订单支付时间',
  `order_buier_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '买家留言',
  `order_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '订单备注',
  `order_third_ordercode` varchar(128) NOT NULL DEFAULT '' COMMENT '第三方单号',
  `order_third_payinfo` varchar(512) NOT NULL DEFAULT '' COMMENT '【序列化保存】第三方支付返回信息',
  `order_intime` int(11) NOT NULL DEFAULT '0' COMMENT '订单生成时间',
  `order_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '订单修改时间，只要数据有变动就更新时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_code` (`order_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值订单表';

-- ----------------------------
-- Records of opf_recharge_order
-- ----------------------------

-- ----------------------------
-- Table structure for `opf_wallet`
-- ----------------------------
DROP TABLE IF EXISTS `opf_wallet`;
CREATE TABLE `opf_wallet` (
  `wallet_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '钱包id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `wallet_available_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】可用余额',
  `wallet_freeze_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】已冻结余额',
  `wallet_integral` int(11) NOT NULL DEFAULT '0' COMMENT '账户积分',
  `wallet_checktoken` varchar(64) NOT NULL DEFAULT '' COMMENT '【预留】三个price组合+salt 生成token 当验证不符合时，冻结账户，进行人工对账审核',
  `wallet_intime` int(11) NOT NULL DEFAULT '0' COMMENT '新增时间',
  `wallet_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`wallet_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='钱包';

-- ----------------------------
-- Records of opf_wallet
-- ----------------------------
INSERT INTO `opf_wallet` VALUES ('1', '259', '640', '0', '1000', '', '1501490477', '1501490477');
INSERT INTO `opf_wallet` VALUES ('2', '260', '0', '0', '0', '', '1501491101', '0');
INSERT INTO `opf_wallet` VALUES ('3', '261', '0', '0', '0', '', '1501491771', '0');
INSERT INTO `opf_wallet` VALUES ('4', '262', '0', '0', '0', '', '1501494093', '0');
INSERT INTO `opf_wallet` VALUES ('5', '263', '0', '0', '0', '', '1501548722', '0');
INSERT INTO `opf_wallet` VALUES ('7', '266', '1000', '0', '0', '', '1501550495', '0');
INSERT INTO `opf_wallet` VALUES ('8', '267', '1000', '0', '0', '', '1501550778', '0');
INSERT INTO `opf_wallet` VALUES ('9', '268', '0', '0', '0', '', '1501550930', '0');
INSERT INTO `opf_wallet` VALUES ('10', '269', '0', '0', '0', '', '1501551013', '0');

-- ----------------------------
-- Table structure for `opf_withdraw_order`
-- ----------------------------
DROP TABLE IF EXISTS `opf_withdraw_order`;
CREATE TABLE `opf_withdraw_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '申购订单id',
  `order_code` varchar(64) NOT NULL DEFAULT '' COMMENT '订单号(按规则统一生成唯一)',
  `order_name` varchar(64) NOT NULL DEFAULT '' COMMENT '订单名称',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单所属买家id',
  `order_withdraw_price` int(11) NOT NULL DEFAULT '0' COMMENT '【单位分】申请提现金额',
  `order_withdraw_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '提现方式: 0微信 1支付宝 2银行卡',
  `order_withdraw_account` varchar(64) NOT NULL DEFAULT '' COMMENT '转入的账户名称',
  `order_withdraw_bankname` varchar(64) NOT NULL DEFAULT '' COMMENT '提现方式为2时: 银行名字',
  `order_withdraw_bankdeposit` varchar(64) NOT NULL DEFAULT '' COMMENT '提现方式为2时: 开户行银行名字',
  `order_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单流程状态:0待确认 5处理中 10已完成 15拒绝',
  `order_isdelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单删除状态:0正常 1已删除',
  `order_deltime` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除时间',
  `order_delid` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除操作者',
  `order_oprid` int(11) NOT NULL DEFAULT '0' COMMENT '订单处理者id',
  `order_finishtime` int(11) NOT NULL DEFAULT '0' COMMENT '订单处理完成时间',
  `order_confirmid` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单操作者id',
  `order_confirm_time` int(11) NOT NULL DEFAULT '0' COMMENT '确认订单时间',
  `order_buier_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '买家提现留言',
  `order_refuge_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '拒绝提现原因',
  `order_remarks` varchar(256) NOT NULL DEFAULT '' COMMENT '订单备注',
  `order_third_ordercode` varchar(128) NOT NULL DEFAULT '' COMMENT '第三方单号',
  `order_third_payinfo` varchar(512) NOT NULL DEFAULT '' COMMENT '【序列化保存】第三方支付返回信息',
  `order_intime` int(11) NOT NULL DEFAULT '0' COMMENT '订单生成时间',
  `order_uptime` int(11) NOT NULL DEFAULT '0' COMMENT '订单修改时间，只要数据有变动就更新时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_code` (`order_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拍卖订单主表';

-- ----------------------------
-- Records of opf_withdraw_order
-- ----------------------------
