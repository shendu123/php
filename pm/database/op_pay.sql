/*
Navicat MySQL Data Transfer

Source Server         : linux_open
Source Server Version : 50628
Source Host           : 192.168.71.236:3306
Source Database       : op_pay

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-08-23 15:24:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `opa_express`
-- ----------------------------
DROP TABLE IF EXISTS `opa_express`;
CREATE TABLE `opa_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `letter` varchar(1) NOT NULL COMMENT '字母',
  `en` varchar(200) NOT NULL COMMENT '拼音',
  `ch` varchar(200) NOT NULL COMMENT '中文',
  `sort` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COMMENT='快递公司表用于查询快递';

-- ----------------------------
-- Records of opa_express
-- ----------------------------
INSERT INTO `opa_express` VALUES ('1', 'A', 'ANE', '安能物流', '0', '0');
INSERT INTO `opa_express` VALUES ('2', 'A', 'AXD', '安信达快递', '0', '2');
INSERT INTO `opa_express` VALUES ('3', 'B', 'BFDF', '百福东方', '0', '2');
INSERT INTO `opa_express` VALUES ('4', 'B', 'BQXHM', '北青小红帽', '0', '0');
INSERT INTO `opa_express` VALUES ('5', 'B', 'HTKY', '百世汇通', '0', '0');
INSERT INTO `opa_express` VALUES ('6', 'C', 'CCES', 'CCES快递', '0', '0');
INSERT INTO `opa_express` VALUES ('7', 'C', 'CITY100', '城市100', '0', '0');
INSERT INTO `opa_express` VALUES ('8', 'C', 'COE', 'COE东方快递', '0', '2');
INSERT INTO `opa_express` VALUES ('9', 'C', 'CSCY', '长沙创一', '0', '0');
INSERT INTO `opa_express` VALUES ('10', 'D', 'DBL', '德邦', '0', '0');
INSERT INTO `opa_express` VALUES ('11', 'D', 'DHL', 'DHL', '0', '0');
INSERT INTO `opa_express` VALUES ('12', 'D', 'DSWL', 'D速物流', '0', '0');
INSERT INTO `opa_express` VALUES ('13', 'D', 'DTWL', '大田物流', '0', '2');
INSERT INTO `opa_express` VALUES ('14', 'E', 'EMS', 'EMS', '0', '0');
INSERT INTO `opa_express` VALUES ('15', 'F', 'FEDEX', 'FedEx联邦快递', '0', '0');
INSERT INTO `opa_express` VALUES ('16', 'F', 'FKD', '飞康达', '0', '0');
INSERT INTO `opa_express` VALUES ('17', 'G', 'GDEMS', '广东邮政', '0', '0');
INSERT INTO `opa_express` VALUES ('18', 'G', 'GSD', '共速达', '0', '0');
INSERT INTO `opa_express` VALUES ('19', 'G', 'GTO', '国通快递', '0', '0');
INSERT INTO `opa_express` VALUES ('20', 'G', 'GTSD', '高铁速递', '0', '0');
INSERT INTO `opa_express` VALUES ('21', 'H', 'HFWL', '汇丰物流', '0', '0');
INSERT INTO `opa_express` VALUES ('22', 'H', 'HLWL', '恒路物流', '0', '0');
INSERT INTO `opa_express` VALUES ('23', 'H', 'HOAU', '天地华宇', '0', '0');
INSERT INTO `opa_express` VALUES ('24', 'H', 'hq568', '华强物流', '0', '0');
INSERT INTO `opa_express` VALUES ('25', 'H', 'HXLWL', '华夏龙物流', '0', '0');
INSERT INTO `opa_express` VALUES ('26', 'H', 'HYLSD', '好来运快递', '0', '0');
INSERT INTO `opa_express` VALUES ('27', 'H', 'ZHQKD', '汇强快递', '0', '0');
INSERT INTO `opa_express` VALUES ('28', 'J', 'JD', '京东快递', '0', '0');
INSERT INTO `opa_express` VALUES ('29', 'J', 'JGSD', '京广速递', '0', '0');
INSERT INTO `opa_express` VALUES ('30', 'J', 'JJKY', '佳吉快运', '0', '0');
INSERT INTO `opa_express` VALUES ('31', 'J', 'JTKD', '捷特快递', '0', '0');
INSERT INTO `opa_express` VALUES ('32', 'J', 'JXD', '急先达', '0', '0');
INSERT INTO `opa_express` VALUES ('33', 'J', 'JYKD', '晋越快递', '0', '0');
INSERT INTO `opa_express` VALUES ('34', 'J', 'JYM', '加运美', '0', '0');
INSERT INTO `opa_express` VALUES ('35', 'J', 'JYWL', '佳怡物流', '0', '0');
INSERT INTO `opa_express` VALUES ('36', 'K', 'FAST', '快捷速递', '0', '0');
INSERT INTO `opa_express` VALUES ('37', 'L', 'LB', '龙邦快递', '0', '0');
INSERT INTO `opa_express` VALUES ('38', 'L', 'LHT', '联昊通速递', '0', '0');
INSERT INTO `opa_express` VALUES ('39', 'M', 'MHKD', '民航快递', '0', '0');
INSERT INTO `opa_express` VALUES ('40', 'M', 'MLWL', '明亮物流', '0', '0');
INSERT INTO `opa_express` VALUES ('41', 'N', 'NEDA', '能达速递', '0', '0');
INSERT INTO `opa_express` VALUES ('42', 'Q', 'QCKD', '全晨快递', '0', '0');
INSERT INTO `opa_express` VALUES ('43', 'Q', 'QFKD', '全峰快递', '0', '0');
INSERT INTO `opa_express` VALUES ('44', 'Q', 'QRT', '全日通快递', '0', '0');
INSERT INTO `opa_express` VALUES ('45', 'Q', 'UAPEX', '全一快递', '0', '0');
INSERT INTO `opa_express` VALUES ('46', 'S', 'SAWL', '圣安物流', '0', '0');
INSERT INTO `opa_express` VALUES ('47', 'S', 'SDWL', '上大物流', '0', '0');
INSERT INTO `opa_express` VALUES ('48', 'S', 'SF', '顺丰快递', '0', '0');
INSERT INTO `opa_express` VALUES ('49', 'S', 'SFWL', '盛丰物流', '0', '0');
INSERT INTO `opa_express` VALUES ('50', 'S', 'SHWL', '盛辉物流', '0', '0');
INSERT INTO `opa_express` VALUES ('51', 'S', 'ST', '速通物流', '0', '0');
INSERT INTO `opa_express` VALUES ('52', 'S', 'STO', '申通快递', '0', '0');
INSERT INTO `opa_express` VALUES ('53', 'S', 'SURE', '速尔快递', '0', '0');
INSERT INTO `opa_express` VALUES ('54', 'T', 'TSSTO', '唐山申通', '0', '0');
INSERT INTO `opa_express` VALUES ('55', 'T', 'HHTT', '天天快递', '0', '0');
INSERT INTO `opa_express` VALUES ('56', 'W', 'WJWL', '万家物流', '0', '0');
INSERT INTO `opa_express` VALUES ('57', 'W', 'WXWL', '万象物流', '0', '0');
INSERT INTO `opa_express` VALUES ('58', 'X', 'XBWL', '新邦物流', '0', '0');
INSERT INTO `opa_express` VALUES ('59', 'X', 'XFEX', '信丰快递', '0', '0');
INSERT INTO `opa_express` VALUES ('60', 'X', 'XYT', '希优特', '0', '0');
INSERT INTO `opa_express` VALUES ('61', 'Y', 'YADEX', '源安达快递', '0', '0');
INSERT INTO `opa_express` VALUES ('62', 'Y', 'UC', '优速快递', '0', '0');
INSERT INTO `opa_express` VALUES ('63', 'Y', 'YCWL', '远成物流', '0', '0');
INSERT INTO `opa_express` VALUES ('64', 'Y', 'YD', '韵达快递', '7', '2');
INSERT INTO `opa_express` VALUES ('65', 'Y', 'YFEX', '越丰物流', '0', '0');
INSERT INTO `opa_express` VALUES ('66', 'Y', 'YFHEX', '原飞航物流', '0', '0');
INSERT INTO `opa_express` VALUES ('67', 'Y', 'YFSD', '亚风快递', '0', '0');
INSERT INTO `opa_express` VALUES ('68', 'Y', 'YTKD', '运通快递', '0', '0');
INSERT INTO `opa_express` VALUES ('69', 'Y', 'YTO', '圆通速递', '0', '0');
INSERT INTO `opa_express` VALUES ('70', 'Y', 'YZPY', '邮政平邮/小包', '0', '0');
INSERT INTO `opa_express` VALUES ('71', 'Z', 'ZENY', '增益快递', '0', '0');
INSERT INTO `opa_express` VALUES ('72', 'Z', 'ZJS', '宅急送', '0', '0');
INSERT INTO `opa_express` VALUES ('73', 'Z', 'ZTE', '众通快递', '0', '0');
INSERT INTO `opa_express` VALUES ('74', 'Z', 'ZTKY', '中铁快运', '0', '0');
INSERT INTO `opa_express` VALUES ('75', 'Z', 'ZTO', '中通速递', '0', '0');
INSERT INTO `opa_express` VALUES ('76', 'Z', 'ZTWL', '中铁物流', '0', '0');
INSERT INTO `opa_express` VALUES ('77', 'Z', 'ZYWL', '中邮物流', '0', '0');

-- ----------------------------
-- Table structure for `opa_fundflow`
-- ----------------------------
DROP TABLE IF EXISTS `opa_fundflow`;
CREATE TABLE `opa_fundflow` (
  `pay_fd_id` varchar(36) NOT NULL COMMENT '唯一id',
  `pay_flow_id` varchar(36) DEFAULT NULL COMMENT '流水号',
  `desc` varchar(200) DEFAULT NULL COMMENT '产品的相关描述',
  `pay_ototal_id` varchar(36) DEFAULT NULL COMMENT '总订单id号',
  `uid` varchar(36) DEFAULT NULL COMMENT '谁充值的 自身平台用户id',
  `toid` varchar(36) DEFAULT NULL COMMENT '冲入谁的 (一般为平台)',
  `businessid` int(11) DEFAULT NULL COMMENT '运营商',
  `sysid` int(11) DEFAULT NULL COMMENT '系統id 总部、合作伙伴、一级运营、二级运营、客户',
  `pay_third_fromid` varchar(36) DEFAULT NULL COMMENT '(三)谁充值的 微信为oppenid',
  `pay_third_toid` varchar(36) DEFAULT NULL COMMENT '(三)冲入谁的 微信为 商户号',
  `pay_third_orderid` varchar(36) DEFAULT NULL COMMENT '(三)第三方可查阅orderid',
  `payment` char(4) DEFAULT NULL COMMENT 'YE余额，W微信，P-pc支付，S手机支付，Aapp支付，Z支付宝，H回潮',
  `from` char(4) DEFAULT NULL COMMENT 'CZ 充值 S 申购 DJYE余额冻结 ...',
  `money` decimal(16,0) DEFAULT '0' COMMENT '资金 分',
  `error` varchar(50) DEFAULT NULL COMMENT '错误原因',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `isbalance` int(1) DEFAULT '2' COMMENT '2没有余额单子一起，1有',
  `ispay` int(2) DEFAULT '2' COMMENT '2初始支付 3失败 1成功 4未知 要检查 31余额不足支付',
  `isdelete` int(1) DEFAULT '2' COMMENT '2没有删除 1删除',
  `isadd` int(1) DEFAULT '2' COMMENT '2流入平台 1平台流出到其他账户',
  `ischeck` int(1) DEFAULT '2' COMMENT '2提现审核 3失败 1成功',
  `addressid` int(11) DEFAULT '1' COMMENT '地址id',
  `third_desc` varchar(100) DEFAULT NULL COMMENT '第三方需要的描述-连接',
  PRIMARY KEY (`pay_fd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资金流水';

-- ----------------------------
-- Records of opa_fundflow
-- ----------------------------
INSERT INTO `opa_fundflow` VALUES ('014c86d21834fcc58fc83dd800ffeda3', '17081017194451003711', '退还保证金', '108', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-10 09:19:44', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('023fd4614375a7b2ff07f17435f98f8a', '17080415453670820194', '充值保证金1元', 'f433577e2bd03ed4d658654977fc9666', '321', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 07:45:36', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('030a7ce3f5846f806e14db10c0a0e9f0', '17080113582455345463', '申购英语', '2fb6f09765724df75ee16731d25792c5', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 05:58:24', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('031a4d496eca9fcaa8aeb1dab117481e', '17080416532431771782', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 08:53:24', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('034769664ecfdaaaceb7715c39eda4a1', '17080116414483714643', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-01 08:41:44', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('041ee27d019d3dee6f24a595a15e4be7', '17080416173455872878', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:34', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('046ff6bca6c2763eaa5ad3d347adbbcc', '17080417120047494533', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:12:00', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('047e27356fe9a8fd25a25d8fcd10995e', '17073121124811095884', '余额支付1元', '7bb8d6f0b6dc228ddd195fbc2b46179d', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-07-31 13:12:48', '1', '1', '2', '2', '2', '62', '-');
INSERT INTO `opa_fundflow` VALUES ('04ca899ca82b092a19e95cfb2150e25a', '17081417283329379709', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-14 09:28:33', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('0508cf4778154ada2d09d73c17e0a772', '17081017165722490421', '缴纳保证金', '6e14bfa65f3f8e8225d0d55108b641d8', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '5', '-', '2017-08-10 09:16:57', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('0561f19a454d0a6a54d0d8f469fde900', '17080314392069652857', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 06:39:20', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('056c4ead71abc799e5985d1a1adff316', '17080210543965186738', '退还保证金1元', '79', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:54:39', '1', '3', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('0574eea68330053d54ae7d212f186739', '17080713574835655732', '退还保证金1元', '97', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-07 05:57:48', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('064f5179f93155185afe612afa21e5be', '17080214482125167925', '余额支付1元', '06cbfd01c19ec94278bc4fd03dcdf0ed', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-02 06:48:21', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('0687d68e1e7bf7dfbfd090470501c4bf', '17081108583125745949', '退还保证金', '108', '4', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-11 00:58:31', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('06fccc11d277205987949520e853f396', '17080211075082886528', '退还保证金1元', '81', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 03:07:50', '1', '0', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('07c6c6751762d95bddad24c4b1f1085f', '17081015384958945072', '余额支付1元', '8a496e6e0a900257476cfc5785e3cdb6', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-10 07:38:49', '1', '1', '2', '2', '2', '102', '-');
INSERT INTO `opa_fundflow` VALUES ('085f197d37a86c309f4b9967313a159c', '17080811064889925163', '缴纳保证金', 'bd65417f8a789a98418f13129dc9f4bb', '257', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-08 03:06:48', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('088ced5981ca1da2c87ccb7262e0a665', '17080717442951601952', '充值保证金100元', 'b5acca31e2d1e40679c5c41a82f38ff5', '257', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-07 09:44:29', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('093a1b27c817bc03cd14719894acf9f1', '17080417520619853966', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:52:06', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('0b2a0bc14c7aa4740cfa79f6b5d955f0', '17080714174381031298', '申购周杰伦', '34cca64f3df8cdbce1b8618a35793a93', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-07 06:17:43', '1', '2', '2', '2', '2', '95', '-');
INSERT INTO `opa_fundflow` VALUES ('0b3a57a01872c271938e793238217b1d', '17080415232582090460', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:23:25', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('0baea0b660c178dd1c064a8f06a84600', '17080714401948858232', '竞价兰陵王', 'f49c5d17083ac233a08374b2eca33e54', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '37', '-', '2017-08-07 06:40:19', '1', '1', '2', '2', '2', '95', '-');
INSERT INTO `opa_fundflow` VALUES ('0bbac9ae571384a82f28493b2e7e558f', '17080417083280413647', '余额支付2元', 'b8589f94767a418cb61b0c4cbff9eb90', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '2', '-', '2017-08-04 09:08:32', '1', '1', '2', '2', '2', '90', '-');
INSERT INTO `opa_fundflow` VALUES ('0d7f7ee19f5795c66c966eec096c14f9', '17080210554085495008', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:55:40', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('0da7c67443ab7b69f47ba8ef47fb423f', '17081117550885449460', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:55:08', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('0e7621e9c56bcea92c20260ccfb756cb', '17080415442937582080', '退还保证金1元', '94', '273', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-04 07:44:29', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('0f63dd944eb144aee4dd8239a5ce5ac5', '17080416173412945438', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:34', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('102135778ef34094cfa1b2d666c5a0d0', '17081017583860683270', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:58:38', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('10b9f96a5da615cfc352733eb33159ab', '17080417003289497659', '充值保证金1元', '71658e5de6b9e8c01a9f49a5836dca5c', '326', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 09:00:32', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('10c2644dcf45e27a763026b27c5c62dd', '17080705072119020658', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-06 21:07:21', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('1160cf0e92012930b33c031a18002d1f', '17080113590644549569', '申购物理', 'c9079f065e1ad4d1c0f9a8bbd803009d', '239', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 05:59:06', '1', '2', '2', '2', '2', '75', '-');
INSERT INTO `opa_fundflow` VALUES ('13f194fea9cfc1c03cc05782d744c197', '17080718100089888530', '缴纳保证金', '767636188e1bbf6d72db9b110ebaf7cd', '257', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 10:10:00', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('13f79c4ee1be2042e2f7513cc2b68439', '17080416172845231114', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:28', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('14184c3b94b05172025ff88f91c04475', '17080314493367719314', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 06:49:33', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('1447095fab9813b917081839c340c63e', '17080111053979699192', '充值保证金1元', 'd8f43d407ba342f448218bf32c667fbe', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 03:05:39', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('14da838de758963dc41e8656a80a640f', '17081017141074588666', '缴纳保证金', 'bbf188d17e5e91c980aa78cefe3eceaf', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-10 09:14:10', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('180c454ecb9157f5f41699e685047629', '17081017572897291552', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:57:28', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('18ad132b515351a031a6bda8533695c5', '17080410144161411159', '充值', '257', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 02:14:41', '1', '1', '2', '2', '2', '257', '-');
INSERT INTO `opa_fundflow` VALUES ('190c279ecc8dd8ae8384cf0f703c9451', '17080417521460220928', '建宁黄桃', 'fe6e55b03e346201ecd6338d144b95ad', '330', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-04 09:52:14', '1', '2', '2', '2', '2', '96', '-');
INSERT INTO `opa_fundflow` VALUES ('1b356bea6c7fb43a6efd9f74c09d5d28', '17080418000393149037', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 10:00:03', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('1bdbcb0c5b039740db0715b2e40118f1', '17081118335593787181', 'zxltest', '80d8625ca59ec4f73b336b8d24919ffb', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-11 10:33:55', '1', '1', '2', '2', '2', '78', '-');
INSERT INTO `opa_fundflow` VALUES ('1c955832ca77689edce48d11b69fa5f1', '17080113450649905870', '余额支付1元', 'cc97dec8a792ad80b570c06ad3719ddc', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-01 05:45:06', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('1ccb23f4d4db60d8356a412f02a3f0de', '17081516433980836732', 'zxltest', 'c17253f06a1c4526569c8862b29078f6', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-15 08:43:39', '1', '1', '2', '2', '2', '100', '-');
INSERT INTO `opa_fundflow` VALUES ('1ce1f7a94f34459760c045fef0b254be', '17080416173545961336', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:35', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('1d496b4d3f0249dc254a8d56ac60b748', '17080210353597185106', '充值保证金50000元', '0847e0805dbbaa6965b6312893d78bf7', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '50000', '-', '2017-08-02 02:35:35', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('1d982eb1420991b807746f5983ece88c', '17080416173548566496', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:35', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('1d9b01bae9a7f76e123581faea305c5f', '17080116033197981063', '充值保证金1元', '8cfb294ba6225d9e8dbd1751d1937e4e', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 08:03:31', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('1da4af36fe73de855d712bac6e7e1b14', '17081017584951222737', '缴纳保证金', '15eae3b720e7e0ec2b16622412295cfa', '331', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:58:49', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('1e5469e1ff45a1c0c0aa3eee11f2e3ea', '17080713293480385358', '充值保证金1元', '722384f42629697c62569ef9151893c9', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 05:29:34', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('1e74f169402c446963a40f1582e0d52e', '17080116271179753285', '申购化学', '761a0098a88cf1d2e5a03aa48314440b', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 08:27:11', '1', '1', '2', '2', '2', '77', '-');
INSERT INTO `opa_fundflow` VALUES ('1e7751dcaa8b346ec5b14d1f017c0a0b', '17080417395661038037', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '100', '-', '2017-08-04 09:39:56', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('1e7a6db3f0f8687d5b377a76c1017abe', '17080714242886105720', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 06:24:28', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('1f232d6918f42ff04265159c964ede5d', '17080711282441468654', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 03:28:24', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('1fc7a21e8cd1caa4a713800dc95416e5', '17080316541166571437', '充值保证金1元', '81e6a1c9e54f61b42e48f260b1576f5a', '273', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-03 08:54:11', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('2109e9183e60a7be67c415ffc9c32324', '17080714242971137838', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 06:24:29', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('221e977cfc7ebef4b89c03f4d557b1c9', '17080415232510794399', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:23:25', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('22f272c1284dfee2e0cd86a068e2f069', '17080214504273128506', '申购老虎', 'ea882cd21e411de0dd800365e5e1bdd8', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-02 06:50:42', '1', '2', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('245285b525d6a7dbdda27b3e3b554588', '17080713580574670943', '竞价电影', '5deb21b40bb32e7d6f2175fab7858b42', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '3', '-', '2017-08-07 05:58:05', '1', '1', '2', '2', '2', '86', '-');
INSERT INTO `opa_fundflow` VALUES ('2477dd2068163322899a269aae61f0e6', '17080116413139560172', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-01 08:41:31', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('26069d23e2d62bd533edd35692938dff', '17080116221521814662', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-01 08:22:15', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('27c808ed1dd3f05ab417dcf79543fbae', '17081210175639890992', '余额支付1元', 'c77e18c5eb12632c2be1d1434e46de84', '340', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-12 02:17:56', '1', '1', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('282b15aaa70f98bceb404b55f0ae2c7b', '17080210260011019317', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:26:00', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('2966797aa3028d58731b33d111f1569d', '17080315120983140978', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 07:12:09', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('29efd10a8bed44425651d4eccba2192f', '17073117202951433506', '充值', '239', '239', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '10', '-', '2017-07-31 09:20:29', '1', '2', '2', '2', '2', '239', '-');
INSERT INTO `opa_fundflow` VALUES ('2ae545eb9a2060da027353f78d9f88d6', '17081017274328490876', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:27:43', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('2af822e558f03cb6d3a985df774c6dd3', '17081417284395967203', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-14 09:28:43', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('2d2decdbfa44874f001deb205fc8c38b', '17081017274252059035', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:27:42', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('2d70ee831eec891b5664fe2861fbb2f5', '17080714255586709507', '充值保证金1元', '22a5e9a8249f5816ce8b43c66461c595', '329', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 06:25:55', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('2f7a680c9bb8b982f270044ff77a9afc', '17080315323510885878', '退还保证金1元', '92', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-03 07:32:35', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('2f803259dc97e9594077cb1b04f7971d', '17080114090731119640', '申购物理', 'aed5181fcca31e9db0583ee65606caae', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 06:09:07', '1', '1', '2', '2', '2', '76', '-');
INSERT INTO `opa_fundflow` VALUES ('2f9f9b245437382e9802bf27c1770a8e', '17080314013571473981', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 06:01:35', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('304e5511c2c0f57765cda6a136a92e75', '17081117521642183166', '缴纳保证金', '45e470612d12c082704d54b463875758', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-11 09:52:16', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('30e1b668f1974aba2dc629765e480a47', '17081017444098700590', '缴纳保证金', 'T', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:44:40', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('31893c36ba21dd718dd9a054eda37212', '17080416370924004754', '余额支付1元', '444585d216ceeb3cc328179d49ccabce', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:37:09', '1', '1', '2', '2', '2', '90', '-');
INSERT INTO `opa_fundflow` VALUES ('3268d8d2fea608c578c22a09de50191f', '17080717054266550333', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 09:05:42', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('3305c3401d40a39f0c2126c923e7354d', '17081809415527708038', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-18 01:41:55', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('33c774cebc7093a3b4a510e71b83e6d8', '17080416165672342941', '充值保证金1元', 'beba89f8328af4efd4efb02be4af8734', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 08:16:56', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('33cb54e75b26e95ef97b151c75620627', '17080314590847808112', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 06:59:08', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('33f4e1fc17bfb18282fc90e759b87258', '17080111064380674980', '申购语文', '9d1b42ea1a359a0545482d9986604c77', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 03:06:43', '1', '2', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('34cb08306c9af44afe2cc5a3cc572d40', '17081007363513691420', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-09 23:36:35', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('35626b9e7e4d1a2b2a56ca25ff417d4d', '17080911181814662466', '申购小米', '4e3cd5cf22aa539148bccad3164ba839', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-09 03:18:18', '1', '2', '2', '2', '2', '86', '-');
INSERT INTO `opa_fundflow` VALUES ('36b83d50c9c12ebdb1a47f1d0ab067a7', '17080417512862409325', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:51:28', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('36ec24ac3e3139e61b2b65c230a30036', '17081017554972161075', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:55:49', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('36f166bddbe0905e0b61ceaee2e264ee', '17081016561156609944', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '5', '-', '2017-08-10 08:56:11', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('378a1c76716a7b2c0b5c871abd201837', '17080210543819688044', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:54:38', '1', '3', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('384720d3156e2fcaff944517593f34ec', '17081417143033418448', '缴纳保证金', 'f702eff0ba697130467582012063678e', '340', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-14 09:14:30', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('387965721c7fb55b5c25142d03e1f3af', '17081115115913290055', '缴纳保证金', '3539003e65e3aabb05cb31c1fce7fbdd', '340', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-11 07:11:59', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('3a10012b6a73021a9b861083a32ffe8b', '17080317042948966062', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 09:04:29', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('3ac393ef5c6ac2feca3339bb1cd4bd33', '17080416174270120761', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:42', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('3ac4c4f0c7de874dad11b9e4a19b6a87', '17081017461666778701', '申购小米', '1c25fd4953532b69837e105331584060', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-10 09:46:16', '1', '2', '2', '2', '2', '88', '-');
INSERT INTO `opa_fundflow` VALUES ('3b62884e6349bb95306c2e937b8401b1', '17080416174252160743', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:42', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('3b9808c028b61890154a6879b0153afa', '17081608373129692484', 'zxltest', '01fde0981083e1594f81354ae78c7932', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-16 00:37:31', '1', '1', '2', '2', '2', '100', '-');
INSERT INTO `opa_fundflow` VALUES ('3c9f82b7ef8ea0a7d06c8785d5800fa7', '17080314013661471454', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 06:01:36', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('3da3dedfb61cc81396f70b9dd19fd73c', '17080416172663351396', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:26', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('3daf9cc9e93972f2ef66fc2b33408b68', '17081117550847323829', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:55:08', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('3e171bc777d964507189e41f95447ed7', '17080718114647813733', '充值', '257', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:11:46', '1', '1', '2', '2', '2', '257', '-');
INSERT INTO `opa_fundflow` VALUES ('3f580a3afc5cb04f219c8d61b16cbc3c', '17081017573627025781', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:57:36', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('40c4d7cb643022626fbc85af2e6caade', '17081017434571018294', '缴纳保证金', '88a252900807dacdca5caf92e5958307', '3', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:43:45', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('418de867d4d9e3eecdf2d92a04959a14', '17080417471025159459', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:47:10', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('41fef1f71bfa40a8d2d8b85c0f3de92c', '17081411180675382010', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-14 03:18:06', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('42a1531b779c95469b85c81dbf6812cb', '17080116555726868793', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '3', '-', '2017-08-01 08:55:57', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('440e4fe1ff5dc64bf2d51b87c2b6f748', '17081117582699609531', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:58:26', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('441c40dce54545683c3606f39721d705', '17080116223973811432', '充值保证金1元', 'f9bc66fe41de0546991870883562fb74', '271', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 08:22:39', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('443992bc2379772ee6713cfbe2fb9d53', '17080713564078238908', '余额支付1元', 'd14e622f3554d54bdd43b965e1043382', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-07 05:56:40', '1', '1', '2', '2', '2', '97', '-');
INSERT INTO `opa_fundflow` VALUES ('45dd36912d4edddf125ca5bb0c021d37', '17081514001238038824', '缴纳保证金', '7602dc26458fd32a23b7c25336f17ba1', '340', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-15 06:00:12', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('463c1640a348f7bd8a6bd4196f2ad0c6', '17080117101289796210', '余额支付1元', 'ee24be2e2749febf8ccde7f9ffd40487', '257', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-01 09:10:12', '1', '1', '2', '2', '2', '78', '-');
INSERT INTO `opa_fundflow` VALUES ('4642b9731c7e9d9ea838005adfdb8749', '17080417532571012991', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:53:25', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('473755110f0dcdb55e14cbef00678bee', '17081118342841304386', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 10:34:28', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('49f65444c433c5eae2996e921320a7f8', '17081017272392494207', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:27:23', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('4a6ff88bc42654501640e80546236fc6', '17081117445254973435', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:44:52', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('4ab81e517581a7628440ff4b35c35c6c', '17081117573193668723', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:57:31', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('4be88bc90bf6d0adb9184ed86cc7817f', '17081016560981507098', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '5', '-', '2017-08-10 08:56:09', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('4ca16715d210a0553a59085d3d115373', '17080718114795722578', '充值', '257', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:11:47', '1', '1', '2', '2', '2', '257', '-');
INSERT INTO `opa_fundflow` VALUES ('4d3ca19b382c41b2cf2e01090fb02e2b', '17080913214255682918', '退还保证金', '98', '329', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-09 05:21:42', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('4d87af84709e009fbd512333f29ebd49', '17080117415290557948', '充值保证金1元', '9716cbe9a91cb9a8021bba872d4ab397', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 09:41:52', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('4dcac9692b0c44b46cc99681818b3ad0', '17081117545618847161', '缴纳保证金', '4312ab1b70e3421010ad66c229c3d391', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-11 09:54:56', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('4dd3407a58d387e9ce5defb4c36802dc', '17080717582371989710', '充值保证金1元', 'ab567e77584a3790afc1f44ee145d311', '329', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 09:58:23', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('4e025e1104cf2fa28b22fbba1f40cf8a', '17080114101581809759', '申购物理', '531a86075b89d88efa69ef6b0bcefd7c', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 06:10:15', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('501ac4689f7f7073b4c05078358e0ad2', '17081511013671330528', '缴纳保证金', '882c6ea8205a8fb8b674b54c7f0b7c6e', '3', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-15 03:01:36', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('503aa60a05885f85988613a299971ef0', '17080417064346782308', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:06:43', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('5094764e267df5c934beddbd48d5af14', '17081017204346442973', '退还保证金', '90', '4', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-10 09:20:43', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('51b59d78ea931105d5b8d84768d9d611', '17080417470821611003', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:47:08', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('52cd249084201295a6f3ea3ca2816b2a', '17080713273321035304', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 05:27:33', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('53e33ed3f15cab20caec3f5cb372852a', '17080918034953057750', '充值', '321', '321', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-09 10:03:49', '1', '1', '2', '2', '2', '321', '-');
INSERT INTO `opa_fundflow` VALUES ('5401352dcc9c5671b0f89f017406b4b3', '17080416174235579436', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:42', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('559cc86380877b182a9bc4b31d0b843c', '17080214550982836886', '余额支付1元', '19aa63cbc2d45df2ebfbe3cad516d93b', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-02 06:55:09', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('559d8f34fd2e173d3890b2aed600e512', '17081117500618317552', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:50:06', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('567dc9654e5fec608fe8046b791449fd', '17080211001827059769', '退还保证金1元', '80', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 03:00:18', '1', '0', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('58293e9ca0fcb940857bab9bba1bbe88', '17080705115393604889', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-06 21:11:53', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('5865d84d2df2d1afc37bb823ddc8bac4', '17080116421745792716', '充值保证金1元', '0c2c731e07ac45785c1af3ac3a8bcae7', '271', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 08:42:17', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('59163e9c4d73c872672e5b060886da47', '17080415295552189065', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:29:55', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('59380149e3ef976fa53581cefe0c1930', '17081117453279804693', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:45:32', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('598552f6ec47114b8102c6b21031f52b', '17081017254721943701', '缴纳保证金', 'e6e3470bed5ff97d4abc21601f528489', '340', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:25:47', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('5a6bd93f39e2cab736b78e26c0d6561b', '17080110534656583396', '余额支付1元', 'b41d48eef3da47b355147bc367177987', '4', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-01 02:53:46', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('5add460440ad122e9f9db74cb8d0ffbd', '17080116241221893491', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-01 08:24:12', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('5b3b726f740038b7e5fc8b0eadfb5651', '17080318124967169997', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 10:12:49', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('5be0be0d35084b85b0661e3c5a4f6ce7', '17080416084933872238', '余额支付1元', '62bb1efa71a883d0ee39fd63d6ef5885', '322', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:08:49', '1', '31', '2', '2', '2', '89', '-');
INSERT INTO `opa_fundflow` VALUES ('5c44483a20112fc4fa426964f7d67b4a', '17080417321148649533', '建宁黄桃', '3e4779215c8cab9928efa91bdb6fc120', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-04 09:32:11', '1', '2', '2', '2', '2', '95', '-');
INSERT INTO `opa_fundflow` VALUES ('5d154389db5d26719cd9cc3dc8c2c272', '17081017194495055070', '退还保证金', '108', '322', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-10 09:19:44', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('5f1271847c9dcdbae2ac69c3a0220688', '17080113351356157698', '充值保证金1元', 'f8aa933e40695bf0a626ec89f3c31863', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 05:35:13', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('5f71346c009c7e7a3b538c7fac3189f3', '17081411190521241530', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-14 03:19:05', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('5f817daed5c7f124b009f741f3128c80', '17080210585120455048', '退还保证金1元', '80', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:58:51', '1', '0', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('5f8fd87add353c96b2c5bbe3181c6f86', '17081014205646606271', '经典水晶', 'a77c03267d2a0a789982c664cd500fce', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '2500000', '-', '2017-08-10 06:20:56', '1', '2', '2', '2', '2', '95', '-');
INSERT INTO `opa_fundflow` VALUES ('606f2288abcae02f4a82a8f1a0fe5571', '17080411160467158759', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 03:16:04', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('61184f5e22d6229e78edd0c2e88c2aeb', '17080907272446327012', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-08 23:27:24', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('6207bce5fe3cdc6813e0623fec49524c', '17080417145450706377', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:14:54', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('629c324e796f7a7ea0905e451527272f', '17080213544997296059', '充值保证金100元', 'b9378736dd3a130a4fb5909c0fe78973', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-02 05:54:49', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('62a9cbaf90d22e0f7cee34c4e0687407', '17081118101714925847', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 10:10:17', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('62b31bef2444749c4047cb016ae4f33e', '17080210371699112791', '充值保证金50000元', '1fdc5d6760f9130b556a47c0576fb4f5', '257', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '50000', '-', '2017-08-02 02:37:16', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('62c2d3ad0150896b957b24f8786b9ed9', '17080718061520168726', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:06:15', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('63411682c47a7b015a1c1a03e6ad5b78', '17080116371788330563', '充值保证金1元', 'f7aea2de8ade40125e1fd68f79a690b8', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 08:37:17', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('656812f4020a6eb2a43316c4271ca64b', '17080718123896500861', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:12:38', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('65e6b75790a39cf1a9e6cf6ca6720516', '17080416063468748412', '充值保证金100元', '5074874427a3ef9ef6068f76cbc4236c', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-04 08:06:34', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('66190cfbf4fe817d1b982ccba2aab8ad', '17081017123795237076', '缴纳保证金', 'e94c51924974888c3729c30463cd91ed', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-10 09:12:37', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('67058c4e3bda9c025f786ccab6c6d952', '17081117463679064237', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:46:36', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('67710fa1e1eff2da1c054d69e8827204', '17080414202117580356', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 06:20:21', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('689f051ad251f9abea784e73f631271e', '17080211075029297812', '退还保证金1元', '81', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 03:07:50', '1', '0', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('68bc765465df6eccf7f4f40dbfb4a82d', '17081108500233893311', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 00:50:02', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('6a2b637a78960ab4b03f86298bc50775', '17080116555141899226', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '3', '-', '2017-08-01 08:55:51', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('6a4c5a33be39c84eb34df3a3f2e84553', '17081509352162952897', '缴纳保证金', '69fcacdb0b345fc516347ce68106733b', '340', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-15 01:35:21', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('6a68e62d150a5fc17a2e48a31474b361', '17081516431192353959', '余额支付1元', 'ed8d2c62ee4843e515b60930d23cebb9', '331', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-15 08:43:11', '1', '1', '2', '2', '2', '100', '-');
INSERT INTO `opa_fundflow` VALUES ('6c0962e4e07903f019b5cba2f046e9a0', '17080415231737905663', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:23:17', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('6c1f7cedd3697bfc12f3d506bc0c95db', '17080416173381997855', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:33', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('6d5a7de60f0f96ef78e68a893fd958bf', '17080417420656680619', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:42:06', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('6db9db98d2d58afe135f7d4bc823dba0', '17080717555444932353', '充值保证金1元', '9e9078a37bc6d1dc613f194237cb4cf2', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 09:55:54', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('6dba2bc1fc4ad8bef401ef129da1f704', '17081108583096382409', '退还保证金', '108', '331', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-11 00:58:30', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('6de36cc3ea8e0a2d0e9a93adf90abbd7', '17080717053185475752', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 09:05:31', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('6e0588b4c846cc2e2665fa66147c09a7', '17080814322947456482', '余额支付1元', 'c46857e9466283c477bed27e1a68e5c5', '322', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-08 06:32:29', '1', '1', '2', '2', '2', '89', '-');
INSERT INTO `opa_fundflow` VALUES ('6e2d780df13409b729a00f1f3131d5f6', '17080210495530742450', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:49:55', '1', '3', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('6ead84892178fef5a44b7c645aff15b4', '17080713574967614845', '退还保证金1元', '97', '329', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-07 05:57:49', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('704df41088fae3309b31692a5225695c', '17081007281492332762', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-09 23:28:14', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('709ec0787d5dca8dd43cb89adc41c1cf', '17081017523847830421', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:52:38', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('711d378126271a7888321086f17a7271', '17080417464730714220', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:46:47', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('719436bf5b864879f29c82c4ec87cdc4', '17081108502392901645', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 00:50:23', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('71b32aa0c2268b64e2c41e59e1b30801', '17081117543488617823', '缴纳保证金', 'f8f5754ab70b2a7049a752d787caed9c', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-11 09:54:34', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('71dd53be6761626a8255ed64ea2bfc29', '17080210275539067797', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:27:55', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('735104eb9fd7c7e9649ef9ef89b439d7', '17080417103590308388', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:10:35', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('73984076ea8c8f258d6b0de4df0bc43e', '17080415442824574354', '退还保证金1元', '94', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-04 07:44:28', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('7434e2a15b29254d03c4b3073f6ec3e9', '17080409133733908438', '充值', '257', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 01:13:37', '1', '1', '2', '2', '2', '257', '-');
INSERT INTO `opa_fundflow` VALUES ('745ca1b046a513cd9ca9970292209c1d', '17080114061976824565', '申购英语', '134c4ed4fea1a044fce259695a073760', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 06:06:19', '1', '1', '2', '2', '2', '71', '-');
INSERT INTO `opa_fundflow` VALUES ('74a30ae7ce7f999a2f0484d7f4c5836b', '17080714155193567949', '申购周杰伦', '4c34007e1094cf86e1c251e44e31680a', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-07 06:15:51', '1', '2', '2', '2', '2', '97', '-');
INSERT INTO `opa_fundflow` VALUES ('758938c44828e509d0f2e73e700b062a', '17080414474422332916', '充值保证金1元', '8f7234fb00f40192828a8689c8a16e94', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 06:47:44', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('75f95ff83425b634ca6a644ba427928e', '17080411161168676545', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 03:16:11', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('763ca60b75025f67afc7924ce4874006', '17080717054117516951', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 09:05:41', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('76b5b4ebfe3baee4bd595714f33ae2e6', '17080409120437526720', '充值', '257', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '100', '-', '2017-08-04 01:12:04', '1', '1', '2', '2', '2', '257', '-');
INSERT INTO `opa_fundflow` VALUES ('76c5c538972eddee854f5a88f40e99ef', '17081617293386372884', '余额支付1元', '834209e0bc2ce520d94ba3452288d993', '340', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-16 09:29:33', '1', '1', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('77523312769ab4f78232ac0e28336c39', '17080211140483349739', '退还保证金1元', '82', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 03:14:04', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('7772444a9fa36579a16317d8dac800fa', '17081510264756610059', '退还保证金', '91', '257', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-15 02:26:47', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('77ee0dea2d1483e60b2dbcbb1b261f0c', '17080417564828306097', '建宁黄桃', 'caff3d6cc13d7620b6f3cda997c2e190', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-04 09:56:48', '1', '2', '2', '2', '2', '97', '-');
INSERT INTO `opa_fundflow` VALUES ('788ceb62ef48c1f8c76f7e947f6dce95', '17080711311853993504', '充值保证金1元', '9b98bf3cfc1b01599db4a0c61f59ae40', '329', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 03:31:18', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('78c73701c9dd83961e1d07c683ea4d7b', '17080416445691011701', '充值', '326', '326', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 08:44:56', '1', '1', '2', '2', '2', '326', '-');
INSERT INTO `opa_fundflow` VALUES ('79283ebb8ddb30047dd74ed15827bf63', '17081606582291421995', 'zxltest', 'ca9bc178a24f8870453bc46c89a935d7', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-15 22:58:22', '1', '1', '2', '2', '2', '100', '-');
INSERT INTO `opa_fundflow` VALUES ('7969e100e5a0071ef87860ccfebb5b37', '17081515505115647629', 'zxltest', 'be326ceb61f6a55364e0ea89fef45a72', '339', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-15 07:50:51', '1', '1', '2', '2', '2', '105', '-');
INSERT INTO `opa_fundflow` VALUES ('79f51feba11df298231d46a85e29781e', '17080417590431034138', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:59:04', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('79f7252de185bde6724bde39ef3be5f6', '17080717581021303400', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 09:58:10', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('7b5d4c1e21eff4d9b2960a3940776c0a', '17080417140796322320', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:14:07', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('7b9f07e9a4e772a1730e5caad165e154', '17080417531918210388', '建宁黄桃', 'b6089ee0c906eda9b1c507c9cf61090b', '330', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-04 09:53:19', '1', '1', '2', '2', '2', '96', '-');
INSERT INTO `opa_fundflow` VALUES ('7bddf870d0183141f6520e4cbd392a17', '17081510200630239199', '退还保证金', '91', '257', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-15 02:20:06', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('7c0916e2960a75af555d363205b13ff9', '17081018494233990737', '退还保证金', '104', '4', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '500', '-', '2017-08-10 10:49:42', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('7c6f152b22305f135ba280a9ed4045d7', '17080210543938693315', '退还保证金1元', '79', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:54:39', '1', '3', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('7ca6e4fbb9e5824963c3b1c2011c31a9', '17080114035252826781', '申购物理', '3ea87d399447748a0f44423ecfeedbd8', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 06:03:52', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('7d847f39d8c833bbeb0bb4f1687a5e45', '17073120344938757585', '申购总统', 'd5b76f165da329fa84aba6f57da064bc', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-07-31 12:34:49', '1', '2', '2', '2', '2', '62', '-');
INSERT INTO `opa_fundflow` VALUES ('7e815eef916596f8eceb5577b01a4a5a', '17080210550480702709', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:55:04', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('7ed8604b16082c0f4f25c4ceeda3bb4f', '17080417590360690963', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:59:03', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('7f5feb0326f8456af689155cbb9dabd4', '17080116142216963990', '余额支付2元', '21c3e5d3840264ae016a882ed2ef343a', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '2', '-', '2017-08-01 08:14:22', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('7fbef41ae15a59a20914ce568d129cc1', '17081007370010140396', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-09 23:37:00', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('7fd92bedc6429561cea2c93b822644d7', '17081117580166798855', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:58:01', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('81a5a8de4d99a01fa397530b48805893', '17080210561246302950', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:56:12', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('82e05b82c74d02ada25faf47de69fc55', '17080417083137671441', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:08:31', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('8489be4a63989a447ad8993f58c37351', '17080315323534136718', '退还保证金1元', '92', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-03 07:32:35', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('849fb804db327d0f397fa7cf701f5547', '17080316550282341591', '充值保证金1元', 'ef85730011b4fe92a4de8de5792e28c1', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-03 08:55:02', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('87d851628c999a8540e7295bef72c422', '17073121164764839668', '余额支付1元', 'e556abacd2b4719d31ae34baaa54f9ab', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-07-31 13:16:47', '1', '1', '2', '2', '2', '62', '-');
INSERT INTO `opa_fundflow` VALUES ('89590784acefc79473958f0bcd542b07', '17081017061370376451', '缴纳保证金', 'a9b13b48b286b723093d0ed0c4b75aea', '322', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:06:13', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('89c12341eff2726a007b08b78cec9ddf', '17081017103788871406', '缴纳保证金', 'd50bc01e28598a0499cce908bd122bb3', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:10:37', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('8a559a2a5aaff0ee0a99805a1bdbc62f', '17081510301783865221', '缴纳保证金', 'fc7dfde583399d81a5dd4705332bd4ba', '3', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-15 02:30:17', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('8ac49eb4c829e2ac694e5d7b14f8afac', '17082214045031782661', '经典水晶', 'f12f78b345e810016ad081e4d23fa0a1', '340', 'system_wallet', '0', '0', '-', '-', '-', 'ZWAP', 'SG', '2500000', '-', '2017-08-22 06:04:50', '1', '2', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('8b4c478d28a017be0a52a35e0304aac7', '17081118342914094490', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 10:34:29', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('8be22d8b3d84966071d680e1c75ba650', '17080718063246786453', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:06:32', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('8c4fef83f4de52eb1ff1cf0a65bde89e', '17081118245745365066', 'ffffffff', 'cf27c4f8d68f020d4be99c44adfad7a8', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '100', '-', '2017-08-11 10:24:57', '1', '2', '2', '2', '2', '78', '-');
INSERT INTO `opa_fundflow` VALUES ('8c85bf3c00411bf53f5a1703cd884d2a', '17080416433794574671', '余额支付1元', '165c9cd37d185028fbc8273307c98bad', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:43:37', '1', '1', '2', '2', '2', '88', '-');
INSERT INTO `opa_fundflow` VALUES ('8ce9ed367554e82c366f94a86e718865', '17081017234644379604', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-10 09:23:46', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('8d551cd96f9f568159ceb4b7054a04c1', '17080111305066615150', '申购语文', '06f090ae8bfdeac9c3918df84d786705', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 03:30:50', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('8d9852028b695172d90f4777adc2c34e', '17080417483510509153', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:48:35', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('8dc0b78f98f31ff4a8d3a6b5a02e932b', '17080718095633982216', '充值', '321', '321', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:09:56', '1', '1', '2', '2', '2', '321', '-');
INSERT INTO `opa_fundflow` VALUES ('8e5363fabc92996bfc955dcbf260d6fa', '17081017194430770295', '退还保证金', '108', '4', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-10 09:19:44', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('8eaca6f9a6c2903bb0bd4ad6f78aa9dc', '17080210495615354440', '退还保证金1元', '79', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:49:56', '1', '3', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('8eb0bee51253bca1f95fe4cfe6233cc6', '17080417345235103501', '充值保证金1元', 'a7a0b2e62c82c85787488e8a897bc5ca', '330', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 09:34:52', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('8f0f281f9d837740c298e5e0d297d0f7', '17080114075364313105', '申购英语', '7a551fe7adbf8cd6d3aaf694449f0c8e', '239', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 06:07:53', '1', '2', '2', '2', '2', '75', '-');
INSERT INTO `opa_fundflow` VALUES ('8fb0818293209f0ca200c437ce3bea27', '17080111134990526815', '申购语文', '8f23ef237ee39a43135215c5e2e70027', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 03:13:49', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('900f6dc7f383ec75a57c603c66c46f2a', '17080417584199157172', '建宁黄桃', '6648bcec0c228fba09dd764314f624a8', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-04 09:58:41', '1', '2', '2', '2', '2', '95', '-');
INSERT INTO `opa_fundflow` VALUES ('90bace78abdfedb12d11cd0f2d090d31', '17080116262791679743', '余额支付1元', 'dc08ec030b10aa3349d2234bfc5cdd4d', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-01 08:26:27', '1', '1', '2', '2', '2', '77', '-');
INSERT INTO `opa_fundflow` VALUES ('916b72c0abb3d57a9c09da7823ddf9df', '17081017092722328833', '缴纳保证金', 'de869e1d17d51a54b3cda0fc4d4cc46d', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:09:27', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('91d051a020bacc8f24ae189e25888b9a', '17081017194383321800', '退还保证金', '106', '4', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-10 09:19:43', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('92941918be2695d58c020913e26b1eda', '17080116441489389726', '充值保证金4000元', '182877cf6683a230eb157e82b890f326', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '4000', '-', '2017-08-01 08:44:14', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('934d7ef232a95edcebee2dd9614b4098', '17080315120873603875', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 07:12:08', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('93a90c80eabcc5d809b802abd0217291', '17080716581834205975', '充值保证金1元', '35a9f446b32e178ed242641d1df69cca', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 08:58:18', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('941f95faaf19e386e9c74bc13c194239', '17080411161079307857', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 03:16:10', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('9461407290ce26a66ed688f5e8a0d80e', '17080316551333144031', '充值保证金1元', '6f13ade474cb00d30da12233ea9d2d3f', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-03 08:55:13', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('94afa32a39983a5aaeac380eabfd3a42', '17080415442886699543', '退还保证金1元', '94', '0', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-04 07:44:28', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('971ee59b2bd2796737e2cd0886b1454f', '17081007370060428359', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-09 23:37:00', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('97345c53ed17c5b3d247afb88021259c', '17081600002667213916', '退还保证金', '118', '3', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-15 16:00:26', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('988aea9fe081352c7c3ecd2dc99a64b6', '17080209341914296951', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-02 01:34:19', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('98d8b62cbef3c3460e599a07a955b54d', '17081617325261693958', '拍卖皮卡丘', '20ffd44146678df21444385d247e0834', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '2', '-', '2017-08-16 09:32:52', '1', '1', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('99c1e3ca22f565d5ac5a14ca06bd7fd1', '17080711275324191921', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 03:27:53', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('9a6838d54a0b76e1fd841a4c9a09db22', '17080212355821612584', '充值保证金50000元', '9b43633d1af7a97f2d194db5d740c421', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '50000', '-', '2017-08-02 04:35:58', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('9a697b8a701a72069e5b31e7132c9ebe', '17080717061378980339', '充值保证金1元', '7422189b5d6bad50f54f668ab25ae72b', '329', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 09:06:13', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('9aeacaac9557a146ac712e58429f875f', '17080714003464620132', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '2', '-', '2017-08-07 06:00:34', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('9b7c3683cc599f8d215c687e4bcc8d9a', '17080116431899961583', '充值保证金1元', '408d09ef392911951e44fd6cc58ca2fb', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 08:43:18', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('9c4c9c00b707a72fd89ba0b0412949bf', '17080417061419767465', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:06:14', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('9d151ca34309f1aaf2fb2817c13ccc8b', '17080116222670094125', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-01 08:22:26', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('9dc7bcef51151e2d586c1372e82dec1b', '17080814052229910378', '退还保证金1元', '101', '257', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-08 06:05:22', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('9e3b05c09870cc2199a4f1b6da601caf', '17080705065726575493', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-06 21:06:57', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('9e4b19b1f7fcbe66eb06b380995d24dc', '17081017194394064236', '退还保证金', '108', '273', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-10 09:19:43', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a264ab548b528109ee6740389f23b109', '17080117221017210219', '充值保证金1元', '7a6aacf42b277e2c65cb5282f462ff43', '257', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 09:22:10', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a3ff5d15be183974a14ac74c7c81f6b3', '17080415171225434622', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:17:12', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('a4f0aa91ce941906bd53f3df2615c785', '17080711342220067630', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 03:34:22', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('a5a9aaee2276453636baecc20caa471e', '17080210554584766231', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:55:45', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a60a00a9f6b846fac7a37acf132fb25c', '17073117194652357908', '充值', '239', '239', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-07-31 09:19:46', '1', '2', '2', '2', '2', '239', '-');
INSERT INTO `opa_fundflow` VALUES ('a65b65fda729650c8a08dc2dba278a1b', '17080111173868383084', '申购语文', 'a02693ce49b620a32526b51b91ad23cc', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 03:17:38', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('a6d6b4d1b8a19793a4ea09890054e75e', '17081118103843429671', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 10:10:38', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('a6ece0628c2f0a5428ded2c578a97edf', '17082116331680058027', '缴纳保证金', '5437318d230e8504774ebfd27e9e681f', '329', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-21 08:33:16', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a6fa3428f8724172a1dc12f3cf42aef6', '17080210495624191375', '退还保证金1元', '79', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:49:56', '1', '3', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a768b7019458d645053760e59d56aefb', '17080414204032413164', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 06:20:40', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('a77649a0bbb4bf3502d1590ee7187784', '17080417473346011672', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:47:33', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('a8ca3a0a0020caaee8252b8a593021dd', '17080211001850432088', '退还保证金1元', '80', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 03:00:18', '1', '0', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a8d0ee67c7f24be60f602e9c364097eb', '17081118045654699788', '缴纳保证金', 'a4c18cc313747b0b85ca2b96bde411e7', '4', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-11 10:04:56', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a8db4481f42125e1e19098b786c776e2', '17080417060880431856', '充值保证金1元', '3841c06a313f8fc9012401f2ac4e9c09', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 09:06:08', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a95af0254a08bdffaeff2b3a2df4ab9e', '17080714332776339822', '退还保证金100元', '91', '257', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-07 06:33:27', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('a998a3adebc6b9feeea7ebc06bbcb7af', '17080210543974165546', '退还保证金1元', '79', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:54:39', '1', '3', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('aa211dadbcb73a7a60f93248e61d1150', '17080417064354720417', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:06:43', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('aa53e6e66eb13c49b5d09e253bc1757b', '17080110460454734380', '申购语文', 'a8ec355d834bf3b5d254f943dd49642c', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 02:46:04', '1', '2', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('aad9a6955bad3b54c11e34b9270f9c26', '17080116222033276277', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-01 08:22:20', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('aae1f24e02b0eac5c6b0977bf17f8539', '17080713271872424277', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 05:27:18', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('ab7ee928e981e90d941d07164bf29d28', '17080713463720990691', '余额支付1元', '0b322dd2dda5f4837df4d631a75e389e', '273', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-07 05:46:37', '1', '1', '2', '2', '2', '86', '-');
INSERT INTO `opa_fundflow` VALUES ('ad7db1d26970d08b67cded1ddfbdd532', '17082217485973746616', '余额支付', 'df268f6bc14467bf438f5c86168b45b9', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '2', '-', '2017-08-22 09:48:59', '1', '1', '2', '2', '2', '97', '-');
INSERT INTO `opa_fundflow` VALUES ('aee4e35ff3b7a31b232a7ebe0585e4cf', '17080417134169713938', '充值保证金1元', 'b56f10ed70373751ddc4b210112e576d', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 09:13:41', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('af042b836c5abae146f182133a67dd53', '17080416173560626173', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:35', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('afad45a710edb21c754c8b4d3980d7af', '17080711282365253449', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 03:28:23', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('b00e14d98c3116bae731a6ff5f950294', '17080409110762634684', '充值', '257', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '100', '-', '2017-08-04 01:11:07', '1', '1', '2', '2', '2', '257', '-');
INSERT INTO `opa_fundflow` VALUES ('b0261f77426f8af6c1e5b942ad2ed2a9', '17080314593233302273', '充值保证金1元', 'df9bac01c2752771e0a9e6399ceb22ac', '273', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-03 06:59:32', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('b0b306a1706548d56efe9f54fd2e1b5c', '17080417085225848187', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:08:52', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('b10a8d37843ee441e3b3072c3588853e', '17080415300071867781', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:30:00', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('b1b7aa8b34c44b836ccc3f3051c083f7', '17080714241911645460', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 06:24:19', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('b2cecb081b1d22198f21dd66ae8df777', '17080314591626016286', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 06:59:16', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('b47105d7d8f891920c78359b363ed7b8', '17081017130821521619', '余额支付100元', '96877f4978f4ab452085ca37e54008ae', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '100', '-', '2017-08-10 09:13:08', '1', '1', '2', '2', '2', '88', '-');
INSERT INTO `opa_fundflow` VALUES ('b4febbc632c83be96ac32c41475ea266', '17081210183528714231', 'zxltest', 'd21de55aa122a0530d538b87ece334a9', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-12 02:18:35', '1', '2', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('b5465759b6ba3591ebdd57ecd5fbe138', '17080714332877681658', '退还保证金100元', '91', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-07 06:33:28', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('b5470bc2feacc08355c3eadf4141c881', '17080210585280785680', '退还保证金1元', '80', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:58:52', '1', '0', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('b74d39ceafd803813196b8b143b9f095', '17080210495766787975', '退还保证金1元', '79', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:49:57', '1', '3', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('b7a3e9ed4acc8778fe355f31c244289c', '17081516011490070248', '充值', '339', '339', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-15 08:01:14', '1', '1', '2', '2', '2', '339', '-');
INSERT INTO `opa_fundflow` VALUES ('b80df9f8d8b97cce32055a2dde7197c2', '17080114520945596730', '充值保证金1元', 'df0adb4d9be25dc250698eb323008d28', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 06:52:09', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('b89f1727194f810921845eb22a5f13f9', '17081608460928542167', 'zxltest', '96db8d8ab3b54469b969ef0f596a22ce', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-16 00:46:09', '1', '1', '2', '2', '2', '100', '-');
INSERT INTO `opa_fundflow` VALUES ('b8f2c81cf86baf32c0b17d28b42469b4', '17081015432846397654', '竞价桌子', '1a56e47329958df06ef6398c31702986', '321', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '5', '-', '2017-08-10 07:43:28', '1', '2', '2', '2', '2', '102', '-');
INSERT INTO `opa_fundflow` VALUES ('ba60e771e89b53fb334be33341a9a010', '17080111091393924717', '申购语文', '88b416fa1e4e847793cffc12b996c482', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 03:09:13', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('bb4d238d3d528f6fe91f5e62ad61f6e1', '17080417341951544043', '充值', '330', '330', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:34:19', '1', '1', '2', '2', '2', '330', '-');
INSERT INTO `opa_fundflow` VALUES ('bc3a35a9f2c7ec3afc8f0fe8637d8302', '17080115122040681142', '余额支付1元', 'd768fc71f9d53b6ed47a2ab165efe933', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-01 07:12:20', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('bc830e220d74aa353bd85d421591a3c4', '17080416473529809695', '余额支付1元', '87389ad7dc3cf3b4d02dd6e85b16ac6a', '326', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:47:35', '1', '31', '2', '2', '2', '93', '-');
INSERT INTO `opa_fundflow` VALUES ('bdd2b1fc8731ab0b6da6d6091d2040b1', '17080214362881844129', '充值保证金100元', 'cfe9f99beb0b21ad0dd3a38210143ca3', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-02 06:36:28', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('be533c1147265379eaf2d45fc8de9a78', '17073117193073887483', '充值', '239', '239', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-07-31 09:19:30', '1', '2', '2', '2', '2', '239', '-');
INSERT INTO `opa_fundflow` VALUES ('be91b421d3cdf43170d81c84340d369f', '17080815284281058942', '退还保证金1元', '101', '329', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-08 07:28:42', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('bfa3b859debe549b0017f5ae2054ac23', '17080114030451118864', '申购英语', '9a9583d99d40c00fb8434102e638c31d', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 06:03:04', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('c055630ce5a54733e7405e73b665f377', '17080417235975805844', '充值保证金1元', '005157499b4025b00dd0e8beeb33a589', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 09:23:59', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('c0a779245aab10557f3c5b3dd1c9eae4', '17080210485023797662', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:48:50', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('c0c68f0780303ed835f8949f6b62923a', '17081516041656188207', '缴纳保证金', 'f77b586727deb8688dec0ab3cfb2be25', '339', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-15 08:04:16', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('c0d4b7c334d3090efa67189e2a87bf00', '17080907275512041484', '充值', '256', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-08 23:27:55', '1', '1', '2', '2', '2', '256', '-');
INSERT INTO `opa_fundflow` VALUES ('c0f15f1d438c82abc5f1154dde7190c1', '17080317044632797683', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 09:04:46', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('c27e16212267eff2fe177a160f153fe5', '17080111114578497509', '申购语文', '8f6bdee89e94f42b97fcd6f525e8673a', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 03:11:45', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('c2880d1cf62809bebe3d329fc16dce2c', '17080317250562807183', '余额支付3元', 'c3a3172f64665f16db741af8dd3c6c77', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '3', '-', '2017-08-03 09:25:05', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('c2991bb158e552fc9546715ced63d322', '17080110550265902421', '余额支付1元', '8246eef607c8693aebea5d1c578fa2e6', '4', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-01 02:55:02', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('c2be0ae143c868bc49e584229382310e', '17080607553035851348', 'ffffffff', '7c0dfe814c87effa1919871f46e29227', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '100', '-', '2017-08-05 23:55:30', '1', '2', '2', '2', '2', '98', '-');
INSERT INTO `opa_fundflow` VALUES ('c32056f675045263897110b43d38641e', '17080713571675923999', '申购周杰伦', '52ec3fc9edd8cc67c199f1421891a808', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-07 05:57:16', '1', '1', '2', '2', '2', '97', '-');
INSERT INTO `opa_fundflow` VALUES ('c372749676e1f4163103b0bbfc2f03e2', '17081017194462215710', '退还保证金', '108', '340', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-10 09:19:44', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('c394c9591ccea6cab0af9b5027ed893f', '17081606472167379084', 'zxltest', 'ac9c828970d93db7cc167f206e4fd6db', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-15 22:47:21', '1', '2', '2', '2', '2', '100', '-');
INSERT INTO `opa_fundflow` VALUES ('c434d701052135cf08b81ed3211d41e0', '17080314131397542601', '申购中学生', '3ed49857cd4ee66def917fbe4b07574b', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-03 06:13:13', '1', '1', '2', '2', '2', '86', '-');
INSERT INTO `opa_fundflow` VALUES ('c6b5eab1c2e4bfe8734e5a063a6f63b4', '17080416173581257652', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:35', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('c7d9f891ec04966e8f33663604d14c35', '17080416174137012116', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:41', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('c8577e910913bd7712a483840cd2b445', '17080417593814739132', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:59:38', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('c8d2ec5c86a6345b3e6c49ece3ed50d8', '17080214394287575998', '余额支付1元', '7be11cffc192aa36aec672609f3d6257', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-02 06:39:42', '1', '1', '2', '2', '2', '76', '-');
INSERT INTO `opa_fundflow` VALUES ('cb67a87b64fefd7ccb1608486d7b4bbb', '17081610595217719392', '拍卖树懒', '670c59737feaafa6e6dcf8d5472ca03d', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '2', '-', '2017-08-16 02:59:52', '1', '1', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('cc8cedf4013466ee48f2e1bbceba769d', '17080417191935239379', '充值保证金1元', '7f9f9fe8c16f1adb1585531263c75393', '257', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 09:19:19', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('cdaca429f730a90ff7a2a1dc19d7a98c', '17080417111522057000', '充值保证金1元', 'b255fe7fd6eeb6d56c645f533c8b692f', '328', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 09:11:15', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('ce65a516895e39cb9152b5d9447681cb', '17080714332938413918', '退还保证金100元', '91', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-07 06:33:29', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('cf49e6b93e29a4f78cc9f5ecb04bdc50', '17082117372884694610', '缴纳保证金', 'a54729be3d43ece0f6449213452d330b', '329', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '2', '-', '2017-08-21 09:37:28', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('cfa96b7d7507c9fbd7709c83f699d464', '17080415395586492500', '充值', '321', '321', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:39:55', '1', '1', '2', '2', '2', '321', '-');
INSERT INTO `opa_fundflow` VALUES ('cfc1ceed43c869e5809ac32a4a80d3f6', '17080314580542082232', '充值保证金1元', 'ceb20da756c3d0132dd77db277025eda', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-03 06:58:05', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('d00fbc67baee523bd0077dff59a84be6', '17080416174235295566', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:42', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('d04511388309688344324c8d1e47e5c4', '17080718123761069585', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:12:37', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('d162277b4072fe3d72d8140a4bba336a', '17081108583097392766', '退还保证金', '108', '3', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-11 00:58:30', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('d28119b264e3254f0ef89ae2bbadd78b', '17080415164898471335', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:16:48', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('d284b737fd7ba44c9bf557d1eeffb55f', '17080113552522731326', '申购英语', 'e15b7a2ea56da6d9693164023a020ec5', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 05:55:25', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('d3139a64a94b757a2a98310fda334388', '17080410274614438666', '充值', '257', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 02:27:46', '1', '1', '2', '2', '2', '257', '-');
INSERT INTO `opa_fundflow` VALUES ('d3c22eec9df2c34d624b54d5bc6c0e5e', '17080214343321651882', '余额支付2元', '5f0513b9f56c2e50d83b5d09d45a8703', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '2', '-', '2017-08-02 06:34:33', '1', '1', '2', '2', '2', '74', '-');
INSERT INTO `opa_fundflow` VALUES ('d5b3b0d13ca55e9614aa54e583b51eab', '17081017111277377245', '缴纳保证金', '4dd11a7f7da83e40a387a9a5fc3ef232', '273', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:11:12', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('d5c3b5228a09fe523e043aa84495198e', '17080113574685930094', '申购化学', '8269bb4ddd7e72fd3d44ba07d000cce1', '239', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 05:57:46', '1', '2', '2', '2', '2', '75', '-');
INSERT INTO `opa_fundflow` VALUES ('d5e8ed55eb1090a558ea0c126c4f4cbd', '17081509530916972813', '缴纳保证金', '27aa9903328d84d8dd3d90f63a67da32', '340', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-15 01:53:09', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('d635c009d80e66619bddb92050a0d8cd', '17080116565059681591', '充值保证金4000元', '5ae5d2fdac68141ab8d0d096b95ed716', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '4000', '-', '2017-08-01 08:56:50', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('d71059efd53cf1b1986aaa5dab0dacb6', '17080714003368496665', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '2', '-', '2017-08-07 06:00:33', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('d8a78e7424ee9d06bcb7def42902cdbc', '17080114453425874833', '充值保证金1元', '0b2a6c9c6f41718860f104b7fdcc3c1b', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 06:45:34', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('d8e189353aca64059120228f28a826a0', '17080417443142964862', '充值', '328', '328', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:44:31', '1', '1', '2', '2', '2', '328', '-');
INSERT INTO `opa_fundflow` VALUES ('d940ed8dd5c91b5f44a492d640d35677', '17080414464630412676', '充值保证金1元', '43fa2107601884af909a32a00b1405b2', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 06:46:46', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('da9e44f74dcbe826fb72f08304927853', '17080210270374249794', '退还保证金1元', '79', '271', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:27:03', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('db25bc2079ce816bee1ca8f581ecee4b', '17081510192675254143', '退还保证金', '91', '257', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-15 02:19:26', '1', '2', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('ddd8a4088d7b5552627b3b9c11db5f3b', '17080416173147153043', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:31', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('de903d8503167695dc5f71f6b9b3c235', '17080116245177343735', '申购化学', '251aeed6916aae9f58584c0a0b7ff811', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 08:24:51', '1', '1', '2', '2', '2', '77', '-');
INSERT INTO `opa_fundflow` VALUES ('dede1bec392aac861111e61310c09710', '17081809415379351537', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-18 01:41:53', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('dee6e503261071bae2234c853323e38f', '17080415233737654784', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:23:37', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('df784169db3d2229ec607bfd8d277a2c', '17080110581551680548', '余额支付1元', '2d467789dacc6b5a7cec6d2cabc10f1d', '4', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-01 02:58:15', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('df78e4e828391ed4c1d676358e18aeee', '17080210455129606287', '充值保证金50000元', 'b1193bc16ef97b94e6833839a4b38d94', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '50000', '-', '2017-08-02 02:45:51', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('df8eb5d059f0789e11d9778d7b6539a5', '17081016562061008724', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '5', '-', '2017-08-10 08:56:20', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('dfa3cb60021ad038f19b69643dd12621', '17080211001826263392', '退还保证金1元', '80', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 03:00:18', '1', '0', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('dfc2d2e6de3b3cd1212fa8a307d46062', '17080711342383153062', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 03:34:23', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('dff41b15c0b06cb099f935d5bc859ef4', '17080214511866533470', '充值保证金100元', 'ec7399974ddac075f3674d0c18cb1ace', '257', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-02 06:51:18', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e05ff04993580a5f9ee7a76418dbf9da', '17080718101454121374', '缴纳保证金', '4aad9c5ea98d875dc453b931af1fdcf2', '321', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 10:10:14', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e0ae4a3749db0b6f9d2ed826221ad019', '17080315421396880915', '竞价哥哥', 'e23cd9ac7d4043df8b438d9a2dbd5308', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '4', '-', '2017-08-03 07:42:13', '1', '1', '2', '2', '2', '86', '-');
INSERT INTO `opa_fundflow` VALUES ('e1897954a90d5c8f5cfd3fe7d24d2ff4', '17081617295044663551', '拍卖良心', '1c1545cefa5e3424177a6acd50b549d5', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '2', '-', '2017-08-16 09:29:50', '1', '1', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('e1a2095924cbccbd2eb942928c4969b3', '17081017035517125714', '缴纳保证金', '92f4bc938ba84bbd783ae78170b681c4', '340', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:03:55', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e28636cf7724dceedef4c8f8abfd8244', '17081016561979980534', '充值', '340', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '5', '-', '2017-08-10 08:56:19', '1', '1', '2', '2', '2', '340', '-');
INSERT INTO `opa_fundflow` VALUES ('e2c9e2fa3bb3465db311451835920a2e', '17081617322734071756', '拍卖胖虎', 'f8e1271a88482b064ff248ea41c3b2ea', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '5', '-', '2017-08-16 09:32:27', '1', '1', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('e30c4f84ac12655e558728ba6880852f', '17080317043086374267', '充值', '270', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-03 09:04:30', '1', '1', '2', '2', '2', '270', '-');
INSERT INTO `opa_fundflow` VALUES ('e37a59c3e94ce8f30d05338df745129a', '17080813422289720505', '缴纳保证金', '97f263acdc78c1c0dbb6f5ad7f0c1e1b', '329', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-08 05:42:22', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e5d6213589f3cf2ac6ab7346f6f0e5d8', '17080116132867812103', '申购化学', 'dc08ec030b10aa3349d2234bfc5cdd4d', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 08:13:28', '1', '1', '2', '2', '2', '77', '-');
INSERT INTO `opa_fundflow` VALUES ('e71a52abc04b017e84d26537311494f4', '17080314574145907396', '充值保证金1元', 'd13afff8dd09040bf6a02d80bec90bca', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-03 06:57:41', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e7d3b2ccab3242ec7920b3016227360e', '17080116413951178188', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-01 08:41:39', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('e7d66c2e92175f720700a11cd5c49763', '17080415214411705045', '充值保证金1元', '347a97938d60a49597cb9abcd42efb3d', '0', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 07:21:44', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e844edea63b27e2f645ea064d7884bb4', '17081017475868414470', '缴纳保证金', 'T', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-10 09:47:58', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e8e14d55700425ea6cca3a97cc211fa1', '17080209565884894562', '余额支付1元', '15fc11fcacc4c7b6747518139e2124f3', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-02 01:56:58', '1', '1', '2', '2', '2', '74', '-');
INSERT INTO `opa_fundflow` VALUES ('e9d45a9f0c811a049c177807c5dfe5b0', '17081810282441929582', '缴纳保证金', '2b2c3781bbbf55150c0eee5416a973c8', '340', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-18 02:28:24', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e9dc38a12419f0c3766f00e71de08129', '17080213540144114622', '充值保证金1元', '9b07747e35148270bccba1c082df3fa5', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-02 05:54:01', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('e9e5bbd93f0d084fb95c179354f6cddb', '17081117501799133685', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:50:17', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('ea2579c1b7ecebd01085ad4b8592fd9d', '17080713482895455872', '申购张学友', '7fd236b696a72cfde867c57ee1bd7c12', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-07 05:48:28', '1', '1', '2', '2', '2', '86', '-');
INSERT INTO `opa_fundflow` VALUES ('ea278524ca93e2b04c475726073b53bc', '17080713560682176044', '充值保证金1元', 'c1ddbd789ecb9dd74fcf81451fab4b2f', '273', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 05:56:06', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('ea95e34863914e69ff694f6315247acd', '17080417174280551268', '充值', '321', '321', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '100', '-', '2017-08-04 09:17:42', '1', '1', '2', '2', '2', '321', '-');
INSERT INTO `opa_fundflow` VALUES ('eb15f92cf7aebab4a371376aed0157d3', '17080415235962687648', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 07:23:59', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('eb6d82c99d298071fd6c1cc75eda625b', '17080116070467522118', '申购英语', '584781db7634eff6bb6a5413d6bff4cc', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 08:07:04', '1', '1', '2', '2', '2', '77', '-');
INSERT INTO `opa_fundflow` VALUES ('ecfd900dd0fa64795478f840e39ecffd', '17081514195556920553', '拍卖蘑菇', '03fb30ba4d8cdddf93155449bace68ff', '340', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '2', '-', '2017-08-15 06:19:55', '1', '1', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('ed40c18af590d3e0f48ed021ae5b7ba7', '17080115273714859129', '充值保证金1元', '60f53ec96cb63d0ec72f73454b54fbc0', '258', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 07:27:37', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('ee2a340fcce28a6d79d200e92afb7fe1', '17080908572581103389', 'ffffffff', 'bd8a54ee27b258380a6471890dddc874', '256', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '100', '-', '2017-08-09 00:57:25', '1', '2', '2', '2', '2', '88', '-');
INSERT INTO `opa_fundflow` VALUES ('ef2b3120aeb4bb7724569a77bc165db6', '17080116413083268224', '充值', '271', '271', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-01 08:41:30', '1', '1', '2', '2', '2', '271', '-');
INSERT INTO `opa_fundflow` VALUES ('f062771760e50f19a617e95ccf739f14', '17081118302815089128', 'zxltest', '8e861a7e3d6d4c651e6a70eaaf93323d', '257', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-11 10:30:28', '1', '1', '2', '2', '2', '78', '-');
INSERT INTO `opa_fundflow` VALUES ('f18bfb86f27116e0139984a0f5778593', '17080210585218406208', '退还保证金1元', '80', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-02 02:58:52', '1', '0', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('f1d1f6bc6eafc65da1fdcc16ddbdfa42', '17080417055162010044', '充值保证金1元', 'd2e59aadd44032ff854befe8f4b4a4c1', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-04 09:05:51', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('f22ef4f1842ecbd6955a9f7d5f86587f', '17080115275799892936', '充值保证金1元', '76b5d2f2061b9982c5f32dafb280cc17', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 07:27:57', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('f28b5e82838f168f92a2bef892e2d7b9', '17080113381359584908', '充值保证金1元', '4e4052ff51de12a1507a56acb15e6401', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 05:38:13', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('f2bb3fd2985c47ee7d5a6aa0bafc6d06', '17080416465759769644', '建宁黄桃', '5da317a9af66d21baf0a46bbb9606890', '326', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-04 08:46:57', '1', '1', '2', '2', '2', '93', '-');
INSERT INTO `opa_fundflow` VALUES ('f2c913a3b06d32ed60bf66b56c058373', '17081108502457137232', '充值', '331', '331', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 00:50:24', '1', '1', '2', '2', '2', '331', '-');
INSERT INTO `opa_fundflow` VALUES ('f2cf3fa80797a31776697e716c9c0da9', '17080714332857070744', '退还保证金100元', '91', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-07 06:33:28', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('f399989015f9f3df33334875527a104a', '17080718062912567715', '充值', '329', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:06:29', '1', '1', '2', '2', '2', '329', '-');
INSERT INTO `opa_fundflow` VALUES ('f40efea614e44e4c8312cc34ebe2e900', '17080417090845320188', '充值', '322', '322', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 09:09:08', '1', '1', '2', '2', '2', '322', '-');
INSERT INTO `opa_fundflow` VALUES ('f41829786e8e7107bcf0818784478ee9', '17080114404632622938', '充值保证金1元', '5f81f127ab7d2037588e798704c988e4', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-01 06:40:46', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('f5eb5946eca90c2ef07fb8569a6d0cf8', '17073117193114417783', '充值', '239', '239', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-07-31 09:19:31', '1', '2', '2', '2', '2', '239', '-');
INSERT INTO `opa_fundflow` VALUES ('f6dddfa8ccc93acb089c80a15012663d', '17081017333057669785', '余额支付2元', '7221f57afec2527f8ae94706fe3b00c4', '340', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '2', '-', '2017-08-10 09:33:30', '1', '1', '2', '2', '2', '103', '-');
INSERT INTO `opa_fundflow` VALUES ('f6e6f3935cfecffd9ccf5837b70811d5', '17081017144046891260', '余额支付100元', 'c20ae716734e97f5cf6f6937777bbb89', '256', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '100', '-', '2017-08-10 09:14:40', '1', '1', '2', '2', '2', '88', '-');
INSERT INTO `opa_fundflow` VALUES ('f76081201fbbc21e56933d1184813764', '17080717100964323140', '充值保证金100元', 'e59d44ff0184f241c5e3bdc2678f67ac', '270', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-07 09:10:09', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('f816f6c95bf2fcfeaa83c08bb5998ceb', '17080416181875749777', '充值', '321', '321', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-04 08:18:18', '1', '1', '2', '2', '2', '321', '-');
INSERT INTO `opa_fundflow` VALUES ('f8f823cd8aa66a08ed8f35d5a981eb99', '17080214370193778821', '充值保证金100元', '40716006e4b6c2957c28cd624218e3f4', '256', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '100', '-', '2017-08-02 06:37:01', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('f94a15b603cec4b697e58e255ae40ada', '17080110311070781521', '申购语文', 'd768fc71f9d53b6ed47a2ab165efe933', '270', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 02:31:10', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('fa0aacdac2b00e73d50b60e0ce1f9e44', '17081117453075975951', '充值', '273', '273', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-11 09:45:30', '1', '1', '2', '2', '2', '273', '-');
INSERT INTO `opa_fundflow` VALUES ('fa9960762d4f713b425e2080b83873a2', '17080113321669559722', '余额支付1元', '1ef50867e5d3f2480c54e64af230fac3', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-01 05:32:16', '1', '1', '2', '2', '2', '74', '-');
INSERT INTO `opa_fundflow` VALUES ('fb3eb6b40e383bb69c9691151af23084', '17080416174280179060', '建宁黄桃', '6025c57ed2485558ffd8e5b1bc2d6d06', '321', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'SG', '1', '-', '2017-08-04 08:17:42', '1', '1', '2', '2', '2', '91', '-');
INSERT INTO `opa_fundflow` VALUES ('fb5965d510785d116b8e38ab7af4147d', '17081510030524989972', '退还保证金', '91', '329', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '100', '-', '2017-08-15 02:03:05', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('fc044a761e49d5dd3e8f7b5484a488b6', '17080317035556685570', '余额支付3元', '09ef5134ae95cb6df0004e877d85210c', '270', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '3', '-', '2017-08-03 09:03:55', '1', '1', '2', '2', '2', '72', '-');
INSERT INTO `opa_fundflow` VALUES ('fc1409cbdb1f055ad51c0f5703ca59ef', '17080317222141886627', '退还保证金1元', '95', '258', 'system_wallet', '0', '0', '-', '-', '-', 'YE', 'PM', '1', '-', '2017-08-03 09:22:21', '1', '1', '2', '1', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('fc3c08b0223ad2d1f1fa9ef122a7dd61', '17080815162778248776', '竞价酷狗', 'ad81f68726e37b41a77557deb94304c0', '329', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'PM', '2', '-', '2017-08-08 07:16:27', '1', '1', '2', '2', '2', '95', '-');
INSERT INTO `opa_fundflow` VALUES ('fcaf45c0fa244a2fbc1edad50fd54526', '17081510491311196045', '缴纳保证金', '2f061877e06d72058030361d2e1244ad', '3', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-15 02:49:13', '1', '1', '2', '2', '2', '0', '-');
INSERT INTO `opa_fundflow` VALUES ('ff41812cd445c92edc088d01c6326607', '17080113264952013456', '申购语文', '9b54afb62527606c3f1733c9c57affe3', '4', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'SG', '1', '-', '2017-08-01 05:26:49', '1', '1', '2', '2', '2', '73', '-');
INSERT INTO `opa_fundflow` VALUES ('ff4e3b5765ca3fa2e12d36c0d050ee6d', '17080718093862221796', '充值', '321', '321', 'system_wallet', '0', '0', '-', '-', '-', 'WWAP', 'CZ', '1', '-', '2017-08-07 10:09:38', '1', '1', '2', '2', '2', '321', '-');
INSERT INTO `opa_fundflow` VALUES ('ffa874669eaa5f398b4e8ccc17aceafa', '17080714104444711459', '充值保证金1元', 'T', '329', 'system_wallet', '0', '0', '-', '-', '-', 'DJYE', 'PM', '1', '-', '2017-08-07 06:10:44', '1', '1', '2', '2', '2', '0', '-');

-- ----------------------------
-- Table structure for `opa_logistics`
-- ----------------------------
DROP TABLE IF EXISTS `opa_logistics`;
CREATE TABLE `opa_logistics` (
  `pay_logistics_id` varchar(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '第三方物流公司',
  `pay_third_logid` varchar(36) DEFAULT NULL COMMENT '第三方物流单号',
  `addressid` varchar(36) DEFAULT NULL COMMENT '物流地址id',
  `remark` varchar(50) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`pay_logistics_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='物流表';

-- ----------------------------
-- Records of opa_logistics
-- ----------------------------

-- ----------------------------
-- Table structure for `opa_order_auction`
-- ----------------------------
DROP TABLE IF EXISTS `opa_order_auction`;
CREATE TABLE `opa_order_auction` (
  `pay_o_auction_id` varchar(36) NOT NULL COMMENT '唯一id',
  `pay_ototal_id` varchar(36) DEFAULT NULL COMMENT '总订单id',
  `pay_auction_id` varchar(36) DEFAULT NULL COMMENT '拍卖id',
  `pay_goods_id` varchar(36) DEFAULT NULL COMMENT '商品id',
  `sellerid` varchar(36) DEFAULT NULL COMMENT '卖家id',
  `uid` varchar(36) DEFAULT NULL COMMENT '所属用户',
  `freight` decimal(16,0) DEFAULT '0' COMMENT '物流费用',
  `price` decimal(16,0) DEFAULT '0' COMMENT '商品售价',
  `addprice` decimal(16,0) DEFAULT '0' COMMENT '加价（拍卖加价格）',
  `broker` decimal(16,0) DEFAULT '0' COMMENT '佣金',
  `title` varchar(50) DEFAULT NULL COMMENT '名字',
  `amount` int(11) unsigned DEFAULT '0' COMMENT '数量',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `ispay` int(1) DEFAULT '2' COMMENT '2支付状态 3失败 1成功',
  `isdelete` int(1) DEFAULT '2' COMMENT '2没有删除 1删除',
  `username` varchar(50) DEFAULT NULL COMMENT '订单用户名',
  `phone` varchar(15) DEFAULT NULL COMMENT '用户电话',
  `businessid` int(11) DEFAULT NULL COMMENT '运营商',
  `sysid` int(11) DEFAULT NULL COMMENT '系統id 总部、合作伙伴、一级运营、二级运营、客户',
  `from` char(2) DEFAULT NULL COMMENT '申购(SG) 拍卖(PM) 自由买卖（ZM） 余额充值（YC）充值（CZ）竞价（JJ） 取两个大首字母',
  `isdelivery` int(1) DEFAULT '2' COMMENT '2未发货 1发货 3已收货',
  `addressid` varchar(36) DEFAULT NULL COMMENT '用户收货地址id',
  `pay_logistics_id` varchar(36) DEFAULT NULL COMMENT '物流id',
  `picurl` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `express_id` int(11) DEFAULT NULL COMMENT '快递公司id',
  `express_no` varchar(255) DEFAULT NULL COMMENT '物流单号',
  PRIMARY KEY (`pay_o_auction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拍卖订单';

-- ----------------------------
-- Records of opa_order_auction
-- ----------------------------
INSERT INTO `opa_order_auction` VALUES ('104b900ccd0ad0c510e2a27efcc4f618', 'ad81f68726e37b41a77557deb94304c0', '101', '-', '300', '329', '10', '2', '0', '0', '竞价酷狗', '1', '2017-08-08 14:05:21', '1', '1', '188*****637', '18860142637', '3', null, 'PM', '3', '95', null, 'http://api.wode-mall.com/uploads/20170808/25e12eaa464bc64a1a8ad7b880273d63.jpg', '1', '654940648');
INSERT INTO `opa_order_auction` VALUES ('16d119ba8e0b7be43d8b30d6abc3e975', 'f8e1271a88482b064ff248ea41c3b2ea', '110', '-', '3', '340', '0', '5', '0', '0', '拍卖胖虎', '1', '2017-08-15 10:02:23', '1', '2', '雨册', '13774508059', '1', null, 'PM', '3', '103', null, 'http://api.wode-mall.com/uploads/20170810/36ddaa50898e7c960d9a62d39370b9f4.jpg', '5', '4');
INSERT INTO `opa_order_auction` VALUES ('259ef5c38babbfea0da0f4fb81d3ba67', '1eb1dcaa2bc07ab470c312c95f3db00f', '106', '-', '1', '4', '0', '200', '0', '100', '212', '1', '2017-08-11 09:03:01', '2', '2', 'chyl', '13625085560', '1', null, 'PM', '2', '73', null, '', null, null);
INSERT INTO `opa_order_auction` VALUES ('2ad049486f8c1566773e33f4d834132f', '1c1545cefa5e3424177a6acd50b549d5', '115', '-', '3', '340', '0', '2', '0', '0', '拍卖良心', '1', '2017-08-15 10:14:28', '1', '2', '雨册', '13774508059', '1', null, 'PM', '3', '103', null, 'http://api.wode-mall.com/uploads/20170815/1eba10779107a8e9694037cc9f593e24.jpg', '5', '521');
INSERT INTO `opa_order_auction` VALUES ('3ad8ce2f5b92c48477850b21f0237798', '9ecf76695d455de35edb95758cd5bb01', '108', '-', '1', '256', '0', '1028', '0', '200', '螺蛳粉', '1', '2017-08-11 08:58:29', '2', '2', '131*****535', '13186785535', '3', null, 'PM', '2', '76', null, 'http://api.wode-mall.com/uploads/20170810/8c9373156c297f161047387d8796bd7b.jpg', null, null);
INSERT INTO `opa_order_auction` VALUES ('4c5008a7ea3f88ca03824fb47eb59d60', 'ab7d354526a9030d7f17d3fc396d8599', '113', '-', '1', '4', '0', '2000', '0', '0', '煽风点火就会看见好看', '1', '2017-08-15 10:14:27', '2', '2', 'chyl', '13625085560', '1', null, 'PM', '2', '73', null, 'http://api.wode-mall.com/uploads/20170811/1610aeb2e561e08c160279f4b8311756.jpg', null, null);
INSERT INTO `opa_order_auction` VALUES ('4cc4bd468fe2a6f8c59366dedbb4ec9e', '7221f57afec2527f8ae94706fe3b00c4', '109', '-', '3', '340', '0', '2', '0', '0', '谁动了我的拍卖', '1', '2017-08-10 17:28:45', '1', '1', '雨册', '13774508059', '1', null, 'PM', '3', '103', null, 'http://api.wode-mall.com/uploads/20170810/65cb195ab49f5f6b21a1a0097f8b89c1.jpg', '0', '4554');
INSERT INTO `opa_order_auction` VALUES ('68084dc81671504268185233a59ae272', 'df268f6bc14467bf438f5c86168b45b9', '98', '-', '300', '270', '0', '2', '0', '1', '竞价太阳', '1', '2017-08-09 13:21:42', '1', '2', '安东尼', '18065851576', '3', null, 'PM', '2', '97', null, 'http://api.wode-mall.com/uploads/20170807/2051a8f3bc7bcf8d7637759834d85af7.jpg', null, null);
INSERT INTO `opa_order_auction` VALUES ('7f3c7b9db7b88c753c97d7da8d9110d9', '03fb30ba4d8cdddf93155449bace68ff', '119', '-', '3', '340', '0', '2', '0', '0', '拍卖蘑菇', '1', '2017-08-15 14:03:02', '1', '2', '雨册', '13774508059', '1', null, 'PM', '3', '103', null, 'http://api.wode-mall.com/uploads/20170815/dbb9cf237fddda697e82ba287beb3585.jpg', '1', '2123');
INSERT INTO `opa_order_auction` VALUES ('8f47d47cada8faff803a9631ec29e38a', 'dff48b6a3777dc6b677920dd993b7809', '90', '-', '1', '4', '0', '1000', '0', '100', '竞价兰陵王', '1', '2017-08-11 09:02:30', '2', '2', 'chyl', '13625085560', '1', null, 'PM', '2', '73', null, 'http://api.wode-mall.com/uploads/20170802/6404666068c71f08b1d10e9fa7fc7d39.jpg', null, null);
INSERT INTO `opa_order_auction` VALUES ('9d6330270e3d1d0a35c3381f39beb8f6', '20ffd44146678df21444385d247e0834', '116', '-', '3', '340', '0', '2', '0', '0', '拍卖皮卡丘', '1', '2017-08-15 09:53:19', '1', '2', '雨册', '13774508059', '1', null, 'PM', '3', '103', null, 'http://api.wode-mall.com/uploads/20170815/82ecce13e73e473be11e82f5c2689d38.png', '5', '6');
INSERT INTO `opa_order_auction` VALUES ('a30c81ce1cca45f6e2fa2b7c67f9aaf4', '670c59737feaafa6e6dcf8d5472ca03d', '114', '-', '3', '340', '0', '2', '0', '0', '拍卖树懒', '1', '2017-08-15 10:14:27', '1', '2', '雨册', '13774508059', '1', null, 'PM', '3', '103', null, 'http://api.wode-mall.com/uploads/20170814/681379e8b8b28bd55f8b563c5d101152.jpg', '1', '415');
INSERT INTO `opa_order_auction` VALUES ('d088823aeb2b075591f7b36094f467e8', 'b1fad2a13ad66d69a1e7e5b04c34e969', '117', '-', '1', '3', '0', '101', '0', '100', 'test', '1', '2017-08-16 00:00:25', '2', '2', 'JackLin', '13800138000', '1', null, 'PM', '2', '104', null, 'http://api.wode-mall.com/uploads/20170815/60fffda3762ba7bff289f5a04abb31d6.jpg', null, null);
INSERT INTO `opa_order_auction` VALUES ('e826631d4dd54011aad673202b012a61', '1a56e47329958df06ef6398c31702986', '100', '-', '300', '321', '0', '5', '0', '4', '竞价桌子', '1', '2017-08-08 17:54:49', '2', '2', '177*****225', '17750288225', '1', null, 'PM', '2', '91', null, 'http://api.wode-mall.com/uploads/20170807/b45ae5b7aad36b7a0b6e13cdd4c24ef0.jpg', null, null);
INSERT INTO `opa_order_auction` VALUES ('ed0705fecfa893089fb1bc21568f7031', '4d53e013a53e7547e9db2ba5dfd31da3', '112', '-', '1', '4', '0', '1100', '0', '0', '发给对方时光隧道', '1', '2017-08-15 10:14:26', '2', '2', 'chyl', '13625085560', '1', null, 'PM', '2', '73', null, 'http://api.wode-mall.com/uploads/20170811/7ac3bda81eba53fcf81634233e558ce8.jpg', null, null);
INSERT INTO `opa_order_auction` VALUES ('ffa3d330c4faf61cf70348e644a22192', '46990854bf62de5c9e663f8a3275f03c', '118', '-', '1', '339', '0', '3', '0', '1000', 'testtt', '1', '2017-08-16 00:00:25', '2', '2', '132*****820', '13290931820', '2', null, 'PM', '2', '105', null, 'http://api.wode-mall.com/uploads/20170815/235ad446606ec2919df499c3f1629aeb.jpg', null, null);

-- ----------------------------
-- Table structure for `opa_order_bidding`
-- ----------------------------
DROP TABLE IF EXISTS `opa_order_bidding`;
CREATE TABLE `opa_order_bidding` (
  `pay_o_bidding_id` varchar(36) NOT NULL COMMENT '唯一id 一个商品一个订单',
  `pay_ototal_id` varchar(36) DEFAULT NULL COMMENT '所属哪一个订单 总的数据',
  `pay_bidding_id` varchar(36) DEFAULT NULL COMMENT '竞拍id',
  `pay_goods_id` varchar(36) DEFAULT NULL COMMENT '商品id',
  `sellerid` varchar(36) DEFAULT NULL COMMENT '卖家id',
  `uid` varchar(36) DEFAULT NULL COMMENT '所属用户',
  `freight` decimal(16,0) DEFAULT '0' COMMENT '物流费用',
  `price` decimal(16,0) DEFAULT '0' COMMENT '商品售价',
  `broker` decimal(16,0) DEFAULT '0' COMMENT '佣金',
  `title` varchar(50) DEFAULT NULL COMMENT '名字',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `ispay` int(1) DEFAULT '2' COMMENT '2初始状态 支付状态 3失败 1成功',
  `isdelete` int(1) DEFAULT '2' COMMENT '2没有删除 1删除',
  `username` varchar(50) DEFAULT NULL COMMENT '订单用户名',
  `phone` varchar(15) DEFAULT NULL COMMENT '用户电话',
  `addressid` varchar(36) DEFAULT NULL COMMENT '用户地址id',
  `businessid` int(11) DEFAULT NULL COMMENT 'level等級',
  `sysid` int(11) DEFAULT NULL COMMENT '系統id 总部、合作伙伴、一级运营、二级运营、客户',
  `from` char(2) DEFAULT NULL COMMENT '申购(SG) 拍卖(PM) 自由买卖（ZM） 余额充值（YC）充值（CZ）竞价（JJ） 取两个大首字母',
  `isdelivery` int(1) DEFAULT '2' COMMENT '2未发货 1发货 3已收货',
  `pay_logistics_id` varchar(36) DEFAULT NULL COMMENT '物流id',
  PRIMARY KEY (`pay_o_bidding_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='竞价订单列表';

-- ----------------------------
-- Records of opa_order_bidding
-- ----------------------------

-- ----------------------------
-- Table structure for `opa_order_crowd`
-- ----------------------------
DROP TABLE IF EXISTS `opa_order_crowd`;
CREATE TABLE `opa_order_crowd` (
  `pay_o_crowd_id` varchar(36) NOT NULL COMMENT '唯一id 一个商品一个订单',
  `pay_ototal_id` varchar(36) DEFAULT NULL COMMENT '所属哪一个订单 总的数据',
  `pay_crowd_id` varchar(36) DEFAULT NULL COMMENT '申购id',
  `pay_goods_id` varchar(36) DEFAULT NULL COMMENT '商品id',
  `sellerid` varchar(36) DEFAULT NULL COMMENT '卖家id',
  `uid` varchar(36) DEFAULT NULL COMMENT '所属用户',
  `freight` decimal(16,0) DEFAULT '0' COMMENT '物流费用',
  `broker` decimal(16,0) DEFAULT '0' COMMENT '佣金',
  `price` decimal(16,0) DEFAULT '0' COMMENT '商品售价',
  `title` varchar(50) DEFAULT NULL COMMENT '名字',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `ispay` int(1) DEFAULT '2' COMMENT '2初始状态 支付状态 3失败 1成功',
  `isdelete` int(1) DEFAULT '2' COMMENT '2没有删除 1删除',
  `username` varchar(50) DEFAULT NULL COMMENT '订单用户名',
  `phone` varchar(15) DEFAULT NULL COMMENT '用户电话',
  `addressid` varchar(36) DEFAULT NULL COMMENT '用户地址id',
  `businessid` int(11) DEFAULT NULL COMMENT 'level等級',
  `sysid` int(11) DEFAULT NULL COMMENT '系統id 总部、合作伙伴、一级运营、二级运营、客户',
  `from` char(2) DEFAULT NULL COMMENT '申购(SG) 拍卖(PM) 自由买卖（ZM） 余额充值（YC）充值（CZ）竞价（JJ） 取两个大首字母',
  `isdelivery` int(1) DEFAULT '2' COMMENT '2未发货 1发货 3已收货',
  `pay_logistics_id` varchar(36) DEFAULT NULL COMMENT '物流id',
  `amount` int(6) DEFAULT NULL COMMENT '数量',
  `picurl` varchar(100) DEFAULT NULL,
  `express_id` int(11) DEFAULT NULL COMMENT '快递公司id',
  `express_no` varchar(255) DEFAULT NULL COMMENT '物流单号 ',
  PRIMARY KEY (`pay_o_crowd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='申购订单';

-- ----------------------------
-- Records of opa_order_crowd
-- ----------------------------
INSERT INTO `opa_order_crowd` VALUES ('03aaf0f1b144b33565b3596844f54285', '8f23ef237ee39a43135215c5e2e70027', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 11:13:44', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('04b2695f722015110b3610f7b2fadcea', '6025c57ed2485558ffd8e5b1bc2d6d06', '78', '-', '1', '321', '0', '1', '1', '建宁黄桃', '2017-08-04 16:17:19', '1', '2', '177*****225', '17750288225', '91', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('07a171565af9c2817f9143d11f76819f', 'd5d25e0035dfe8c563ef5584f4ece06e', '79', '-', '1', '256', '0', '1', '1', 'zxltest', '2017-08-15 16:50:03', '2', '2', '131*****535', '13186785535', '76', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('08288ead5c0e12034640095543a82491', '2d467789dacc6b5a7cec6d2cabc10f1d', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 10:58:13', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('0c823231a05988014fb743b15ce53319', '8246eef607c8693aebea5d1c578fa2e6', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 10:54:58', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('0ef6b97f7e591d5da272a675f039843a', 'c9079f065e1ad4d1c0f9a8bbd803009d', '57', '-', '1', '239', '0', '4', '1', '申购物理', '2017-08-01 13:59:02', '2', '2', '塔里克考虑', '18650728487', '75', '0', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/9f3de91faa96864d4bf5d82e8ca7e7fa.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('1418db4a6316ba531a61f7021c3f18ad', 'b44e3130ba019482031f25b945eef2e1', '77', '-', '1', '329', '0', '20000', '2500000', '经典水晶', '2017-08-08 18:06:26', '2', '1', '库里', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('17d67f91279ed08e553f3d1d4b76a7d5', '8e861a7e3d6d4c651e6a70eaaf93323d', '79', '-', '1', '257', '0', '1', '1', 'zxltest', '2017-08-11 18:30:23', '1', '2', '152*****592', '15220191592', '78', '1', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('199f0c8c0864e63ee41d49333ffd75f3', 'ee24be2e2749febf8ccde7f9ffd40487', '58', '-', '1', '257', '0', '4', '1', '申购化学', '2017-08-01 17:09:43', '1', '2', '152*****592', '15220191592', '78', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/b26debe50c6e4adaf0106b6860b8b608.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('1fd1b511145cffe74b7a8fc4f20ccabb', '34cca64f3df8cdbce1b8618a35793a93', '81', '-', '3', '329', '0', '4', '1', '申购周杰伦', '2017-08-07 14:17:39', '2', '1', '188*****637', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170807/cd2d7de1027d625d62540ec0f7909c3f.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('21f75aedd5dc2fc5cb84aa27d8b12f03', 'a8ec355d834bf3b5d254f943dd49642c', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 10:45:09', '2', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('254e9614de32ad7187f11d02cfa17976', '7bb8d6f0b6dc228ddd195fbc2b46179d', '53', '-', '1', '256', '0', '4', '1', '申购总统', '2017-07-31 21:12:04', '1', '2', '131*****535', '13186785535', '62', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170731/2a07fb1941c99c42cc43dd1fc713dbcd.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('27be7ee04dcfe34add0c95d2d07bc366', 'ac9c828970d93db7cc167f206e4fd6db', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-16 06:44:35', '2', '1', '136*****412', '13675020412', '101', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('2a15cd13ac6fa63388251d562e634603', '834209e0bc2ce520d94ba3452288d993', '79', '-', '1', '340', '0', '0', '1', 'zxltest', '2017-08-16 08:25:15', '1', '2', '雨册', '13774508059', '103', '1', null, 'SG', '3', null, '1', '', '4', '2');
INSERT INTO `opa_order_crowd` VALUES ('3258bd653d3e4f2f8c3e0ffaf1e1e442', '1c25fd4953532b69837e105331584060', '84', '-', '3', '256', '0', '1', '1', '申购小米', '2017-08-10 17:46:10', '2', '2', '131*****535', '13186785535', '76', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170809/659c7e71190eb6ce1e144ecc62607975.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('3718779dacce984714d3cdf6e364227e', '58d1de8173779f594f352689dd799e5b', '77', '-', '1', '329', '0', '20000', '2500000', '经典水晶', '2017-08-08 15:28:54', '2', '1', '188*****637', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('39d5c85bfbccb7505af47008c4a1b52d', '8f6bdee89e94f42b97fcd6f525e8673a', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 11:11:37', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('3ce0c050536a0faa6aca2d5e2c442077', 'fe6e55b03e346201ecd6338d144b95ad', '78', '-', '1', '330', '0', '1', '1', '建宁黄桃', '2017-08-04 17:52:07', '2', '2', '', '13405958958', '96', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('3f694c5a9f4d56a426d5ea1e858a9f4d', 'aed5181fcca31e9db0583ee65606caae', '57', '-', '1', '256', '0', '4', '1', '申购物理', '2017-08-01 14:07:50', '1', '2', '131*****535', '13186785535', '71', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/9f3de91faa96864d4bf5d82e8ca7e7fa.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('414698e86cc4c36cfd21e1d3d4acb412', 'cf27c4f8d68f020d4be99c44adfad7a8', '75', '-', '1', '257', '0', '1100', '100', 'ffffffff', '2017-08-11 18:24:08', '2', '2', '152*****592', '15220191592', '78', '1', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('45f9a4e8918ce46e0f2270cf16bd04fe', '8269bb4ddd7e72fd3d44ba07d000cce1', '58', '-', '1', '239', '0', '4', '1', '申购化学', '2017-08-01 13:57:41', '2', '2', '塔里克考虑', '18650728487', '75', '0', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/b26debe50c6e4adaf0106b6860b8b608.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('490608b6820be347f0b520c05c542747', 'a02693ce49b620a32526b51b91ad23cc', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 11:17:21', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('49719b6ed07db7aed5646761dce1de63', 'b41d48eef3da47b355147bc367177987', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 10:53:42', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('4f9e1a06a5a317a4e93124967d505ec9', '5da317a9af66d21baf0a46bbb9606890', '78', '-', '1', '326', '0', '1', '1', '建宁黄桃', '2017-08-04 16:46:46', '1', '2', '136*****412', '13675020412', '93', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('53bf2c4f126c1d993b025625547cf819', '761a0098a88cf1d2e5a03aa48314440b', '58', '-', '1', '271', '0', '0', '1', '申购化学', '2017-08-01 16:26:55', '1', '2', 'OK了啦', '18650728487', '77', '1', null, 'SG', '3', null, '1', 'http://api.wode-mall.com/uploads/20170801/b26debe50c6e4adaf0106b6860b8b608.jpg', '1', '87454');
INSERT INTO `opa_order_crowd` VALUES ('55cdcf627993bf207f615c4a68ca81d3', '7ecea5a71710034d4bf8d4f1cedb6fa2', '77', '-', '1', '329', '0', '20000', '2500000', '经典水晶', '2017-08-08 15:22:00', '2', '1', '188*****637', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('59385326fe00cb34fb4265c1dd5260c9', '25a9a4c8da810a147eb620ad8bb43518', '77', '-', '1', '329', '0', '20000', '2500000', '经典水晶', '2017-08-21 17:29:15', '2', '1', '库里', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('5b902ef3bae563247180d611050f97c2', 'b75917875c8010c6256fe39529a247f8', '79', '-', '1', '340', '0', '1', '1', 'zxltest', '2017-08-14 18:22:17', '2', '1', '雨册', '13774508059', '103', '1', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('5e797569136746795cca95048b40b0ef', '62bb1efa71a883d0ee39fd63d6ef5885', '78', '-', '1', '322', '0', '1', '1', '建宁黄桃', '2017-08-04 16:08:43', '3', '2', '181*****005', '18120856005', '89', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('621122bb0c8601bb7dffe0e5ddb7c114', 'c17253f06a1c4526569c8862b29078f6', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-15 16:43:36', '1', '2', '136*****412', '13675020412', '99', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('690cb896749f94771c75001a8ba2896c', 'a2b73ffa1d913343a24adfb4ca25c8ea', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-16 06:41:45', '2', '1', '136*****412', '13675020412', '99', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('6b1030529964bdb08703a640239ebb40', '7a551fe7adbf8cd6d3aaf694449f0c8e', '56', '-', '1', '239', '0', '0', '1', '申购英语', '2017-08-01 14:07:48', '2', '2', '塔里克考虑', '18650728487', '75', '0', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/14d3b9f34ef6d18aac986b3a323b1412.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('6b5e457810f724a5865162c8fe97ae9d', '134c4ed4fea1a044fce259695a073760', '56', '-', '1', '256', '0', '4', '1', '申购英语', '2017-08-01 14:06:09', '1', '2', '131*****535', '13186785535', '71', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/14d3b9f34ef6d18aac986b3a323b1412.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('6fd80c295a6814b07b6e70391c333316', '26580eee26f0832e337b11c9435d6012', '77', '-', '1', '329', '0', '20000', '2500000', '经典水晶', '2017-08-14 20:54:59', '2', '1', '库里', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('70b4687fffcf7c75e8ded7f3e82b8c20', '584781db7634eff6bb6a5413d6bff4cc', '56', '-', '1', '271', '10', '0', '1', '申购英语', '2017-08-01 16:06:55', '1', '1', 'OK了啦', '18650728487', '77', '1', null, 'SG', '1', null, '1', 'http://api.wode-mall.com/uploads/20170801/14d3b9f34ef6d18aac986b3a323b1412.png', '4', '8774');
INSERT INTO `opa_order_crowd` VALUES ('710548506e34936daa472d9cfdcfb865', 'a77c03267d2a0a789982c664cd500fce', '77', '-', '1', '329', '0', '20000', '2500000', '经典水晶', '2017-08-10 14:20:14', '2', '1', '库里', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('720f830c9dedd3ac726d11f159c4cbe1', '251aeed6916aae9f58584c0a0b7ff811', '58', '-', '1', '271', '10', '0', '1', '申购化学', '2017-08-01 16:24:46', '1', '2', 'OK了啦', '18650728487', '77', '1', null, 'SG', '3', null, '1', 'http://api.wode-mall.com/uploads/20170801/b26debe50c6e4adaf0106b6860b8b608.jpg', '1', '412431');
INSERT INTO `opa_order_crowd` VALUES ('751fb19cb358301ee6954de83cdeed96', '87389ad7dc3cf3b4d02dd6e85b16ac6a', '78', '-', '1', '326', '0', '1', '1', '建宁黄桃', '2017-08-04 16:47:33', '3', '2', '136*****412', '13675020412', '93', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('756e13dad1bee2c82119794d1e1b8019', '956eafa467ba62078640929307186d6d', '78', '-', '1', '330', '0', '1', '1', '建宁黄桃', '2017-08-04 17:51:37', '2', '2', '', '13405958958', '96', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('7cc1e57a22c91b115443ef93cb0935f8', '96877f4978f4ab452085ca37e54008ae', '75', '-', '1', '256', '0', '1100', '100', 'ffffffff', '2017-08-10 17:12:59', '1', '2', '131*****535', '13186785535', '76', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('829372aa6f8e70ba01d23f46767e3046', '9b54afb62527606c3f1733c9c57affe3', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 13:26:43', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('855736cb0bb88e7cbd31eb38d577e61a', 'ab76c7cb4721707e9498f9279613522f', '53', '-', '1', '256', '0', '4', '1', '申购总统', '2017-08-01 05:42:00', '2', '1', '131*****535', '13186785535', '67', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170731/2a07fb1941c99c42cc43dd1fc713dbcd.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('8802e17c4dec3d812ea19d1d6b54ce4b', '7fd236b696a72cfde867c57ee1bd7c12', '80', '-', '3', '273', '0', '0', '1', '申购张学友', '2017-08-07 13:48:22', '1', '2', 'all他', '18650728487', '87', '3', null, 'SG', '3', null, '1', 'http://api.wode-mall.com/uploads/20170807/d5ba0697301ee6d784b64d15801f1d03.jpg', '4', '213');
INSERT INTO `opa_order_crowd` VALUES ('8ea22bf2495e530fda6e25fa33f862d6', '165c9cd37d185028fbc8273307c98bad', '78', '-', '1', '256', '0', '1', '1', '建宁黄桃', '2017-08-04 16:41:15', '1', '2', '131*****535', '13186785535', '71', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('931a51ad0787eea937fc1ab27554d1fc', 'b160537274416fc9e155d5ebcb521fd0', '84', '-', '3', '329', '0', '1', '1', '申购小米', '2017-08-10 14:18:17', '2', '1', '库里', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170809/659c7e71190eb6ce1e144ecc62607975.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('98df1adbac2da9a0d3472a04da3c74c5', 'be326ceb61f6a55364e0ea89fef45a72', '79', '-', '1', '339', '0', '0', '1', 'zxltest', '2017-08-15 15:50:41', '1', '2', '132*****820', '13290931820', '105', '2', null, 'SG', '3', null, '1', '', '1', '123456');
INSERT INTO `opa_order_crowd` VALUES ('99c5769c8f5cced4cad22b4499f1bfeb', 'ca9bc178a24f8870453bc46c89a935d7', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-16 06:52:24', '1', '2', '136*****412', '13675020412', '101', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('9e28fdc3c1de115a2b24a28a618bbef3', '0ecb5e68f5aa70ceb434c14f1b0a9589', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-15 16:22:23', '2', '1', '136*****412', '13675020412', '101', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('9e350ffd586a14e21b973e81c1380995', '80d8625ca59ec4f73b336b8d24919ffb', '79', '-', '1', '257', '0', '1', '1', 'zxltest', '2017-08-11 18:33:27', '1', '2', '152*****592', '15220191592', '78', '1', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('a36d9741769524d98cb84adf5e5bc049', '4e3cd5cf22aa539148bccad3164ba839', '84', '-', '3', '273', '0', '1', '1', '申购小米', '2017-08-09 11:18:08', '2', '1', 'all他', '18650728487', '87', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170809/659c7e71190eb6ce1e144ecc62607975.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('a5f62ef74568e476cd23baf2d597bab3', '9633cb883f04ec8e3fd3c5df1726712a', '77', '-', '1', '329', '0', '20000', '2500000', '经典水晶', '2017-08-22 13:15:20', '2', '2', '库里', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('a7f0571c70107407cf1ddeff726bb14f', '96db8d8ab3b54469b969ef0f596a22ce', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-16 08:46:01', '1', '2', '136*****412', '13675020412', '101', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('ae432cf607704346406dfad6f7d0c0de', '6648bcec0c228fba09dd764314f624a8', '78', '-', '1', '329', '0', '1', '1', '建宁黄桃', '2017-08-04 17:58:30', '2', '1', '188*****637', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('b1822052ce1ab315daf28a6273024338', '88b416fa1e4e847793cffc12b996c482', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 11:09:03', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('b35ffd46ecb7cd98b62dbdd3cd92b103', 'd21de55aa122a0530d538b87ece334a9', '79', '-', '1', '340', '0', '1', '1', 'zxltest', '2017-08-12 10:18:23', '2', '1', '雨册', '13774508059', '103', '1', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('b76cfa5c15955631057fe3e4ff05cbb3', 'bd8a54ee27b258380a6471890dddc874', '76', '-', '1', '256', '0', '1100', '100', 'ffffffff', '2017-08-06 07:50:21', '2', '2', '131*****535', '13186785535', '76', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('bad95a76769bf547c79b66b43a9ffd64', 'c05df2d24525112462237762d310bbeb', '79', '-', '1', '339', '0', '1', '1', 'zxltest', '2017-08-15 15:49:28', '2', '2', '132*****820', '13290931820', '105', '2', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('bd54734aa815b9d72c388bd115ee14c6', '9d1b42ea1a359a0545482d9986604c77', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 11:06:40', '2', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('bddfaf3e673fbef89f1c4d763eb5db23', 'ea271f500f763cbc9fa203243558983f', '77', '-', '1', '270', '0', '20000', '2500000', '经典水晶', '2017-08-07 17:29:55', '2', '1', '安东尼', '18065851576', '97', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('bfc1e2b1949f3fa61968564cd616c29a', '06f090ae8bfdeac9c3918df84d786705', '54', '-', '1', '4', '0', '4', '1', '申购语文', '2017-08-01 11:30:44', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('bfc6233b5834241867fa19b82d1dc79d', 'f12f78b345e810016ad081e4d23fa0a1', '77', '-', '1', '340', '0', '20000', '2500000', '经典水晶', '2017-08-18 14:16:14', '2', '2', '雨册', '13774508059', '103', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('c2e93843eff8af19e31ed8ae32c00c85', 'b0caf8760e85e16dfcfb237235fc2ae3', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-15 16:20:25', '2', '1', '136*****412', '13675020412', '101', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('cbc57fe8c74cab90082639b14f8aefb7', 'b6089ee0c906eda9b1c507c9cf61090b', '78', '-', '1', '330', '0', '1', '1', '建宁黄桃', '2017-08-04 17:53:12', '1', '2', '', '13405958958', '96', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('cc6bae07d06de7cd54f495318c10f536', '7c0dfe814c87effa1919871f46e29227', '76', '-', '1', '331', '0', '1100', '100', 'ffffffff', '2017-08-06 07:48:30', '2', '1', '136*****412', '13675020412', '98', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('d114efe7fa9a5873bd7cf8f15febd01a', '2fb6f09765724df75ee16731d25792c5', '56', '-', '1', '4', '0', '4', '1', '申购英语', '2017-08-01 13:58:18', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/14d3b9f34ef6d18aac986b3a323b1412.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('d13dc29151c4cf3faa8bc0dd7c2dc012', 'e15b7a2ea56da6d9693164023a020ec5', '56', '-', '1', '4', '0', '4', '1', '申购英语', '2017-08-01 13:54:50', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/14d3b9f34ef6d18aac986b3a323b1412.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('d7e05a69000be178be16793e53e3ff8f', '26197dc87ca3d520493094559d554a52', '53', '-', '1', '256', '0', '4', '1', '申购总统', '2017-08-01 05:58:46', '2', '1', '131*****535', '13186785535', '71', '3', null, 'SG', '2', null, '2', 'http://api.wode-mall.com/uploads/20170731/2a07fb1941c99c42cc43dd1fc713dbcd.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('d9f9ebbe5aa441794250021809e9356d', 'f5c9d50a8319677e179c18672c259e08', '53', '-', '1', '256', '0', '4', '1', '申购总统', '2017-08-01 05:34:44', '2', '1', '131*****535', '13186785535', '63', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170731/2a07fb1941c99c42cc43dd1fc713dbcd.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('de03020c8097ba5114c7140f4fbfbca5', 'fa1d8a78ed1e8b855e279e944f64810f', '54', '-', '1', '256', '0', '4', '1', '申购语文', '2017-08-01 13:18:03', '2', '1', '131*****535', '13186785535', '71', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/a966b780e73ab61ef7994bafa09a68f1.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('ded47099b333e45a0d57c1aa7f0d86ee', 'e556abacd2b4719d31ae34baaa54f9ab', '53', '-', '1', '256', '0', '4', '1', '申购总统', '2017-07-31 21:16:31', '1', '2', '131*****535', '13186785535', '62', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170731/2a07fb1941c99c42cc43dd1fc713dbcd.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('e03191aa455ebf00c85b08c7c3afa447', '3ea87d399447748a0f44423ecfeedbd8', '57', '-', '1', '4', '0', '4', '1', '申购物理', '2017-08-01 14:03:47', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/9f3de91faa96864d4bf5d82e8ca7e7fa.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('e2d67c91015574417a471918d2c270f6', 'df5518e299ffe3bdee8bdea041eb35d1', '77', '-', '1', '329', '0', '20000', '2500000', '经典水晶', '2017-08-22 13:14:25', '2', '2', '库里', '18860142637', '95', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/c2518d1f7dadb5ca2f1645be29ff75c7.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('e39fea95e72ad8e8c7fdb814f2ce05e2', 'c46857e9466283c477bed27e1a68e5c5', '82', '-', '3', '322', '0', '0', '1', '申购手机', '2017-08-08 14:32:25', '1', '2', '181*****005', '18120856005', '89', '3', null, 'SG', '3', null, '1', 'http://api.wode-mall.com/uploads/20170808/718085f0beea55a67708c9dcbbd421df.jpg', '1', '12455784522');
INSERT INTO `opa_order_crowd` VALUES ('e5bde946d7769a553c29663de043fe9c', '9c5ebe7885d69deea47b40a6a6bc4b66', '78', '-', '1', '330', '0', '1', '1', '建宁黄桃', '2017-08-04 17:51:11', '2', '2', '', '13405958958', '96', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170804/1f0d99438affab2e956da559fef3076d.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('e669bbc7772556c280606fed856f21f3', 'c77e18c5eb12632c2be1d1434e46de84', '79', '-', '1', '340', '0', '0', '1', 'zxltest', '2017-08-12 10:17:51', '1', '2', '雨册', '13774508059', '103', '1', null, 'SG', '3', null, '1', '', '7', '3');
INSERT INTO `opa_order_crowd` VALUES ('e687d248b616af0c4682728c4913812e', 'd5b76f165da329fa84aba6f57da064bc', '53', '-', '1', '256', '0', '4', '1', '申购总统', '2017-07-31 20:08:30', '2', '1', '131*****535', '13186785535', '62', '3', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170731/2a07fb1941c99c42cc43dd1fc713dbcd.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('ec671f23d3e5a93981b1ebcf1907ef60', 'c20ae716734e97f5cf6f6937777bbb89', '76', '-', '1', '256', '0', '1100', '100', 'ffffffff', '2017-08-10 17:14:08', '1', '2', '131*****535', '13186785535', '76', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('edfe9978dc07b1ec2661d9a8b2b1b653', '9a9583d99d40c00fb8434102e638c31d', '56', '-', '1', '4', '0', '4', '1', '申购英语', '2017-08-01 14:02:57', '1', '2', 'chyl', '13625085560', '73', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/14d3b9f34ef6d18aac986b3a323b1412.png', null, null);
INSERT INTO `opa_order_crowd` VALUES ('f3c7b640241669d893785a5543217274', '0b322dd2dda5f4837df4d631a75e389e', '81', '-', '3', '273', '0', '0', '1', '申购周杰伦', '2017-08-07 13:46:32', '1', '2', 'all他', '18650728487', '87', '3', null, 'SG', '3', null, '1', 'http://api.wode-mall.com/uploads/20170807/cd2d7de1027d625d62540ec0f7909c3f.jpg', '1', '123');
INSERT INTO `opa_order_crowd` VALUES ('fa502aa8881b894298a5d98a44c52ea9', '01fde0981083e1594f81354ae78c7932', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-16 08:33:39', '1', '2', '136*****412', '13675020412', '101', '3', null, 'SG', '2', null, '1', '', null, null);
INSERT INTO `opa_order_crowd` VALUES ('faa3346e9aa4465ce475db65c626e6ff', '8a496e6e0a900257476cfc5785e3cdb6', '84', '-', '3', '321', '0', '0', '1', '申购小米', '2017-08-10 15:38:45', '1', '2', '茄子', '17750288225', '102', '1', null, 'SG', '3', null, '1', 'http://api.wode-mall.com/uploads/20170809/659c7e71190eb6ce1e144ecc62607975.png', '1', '123456');
INSERT INTO `opa_order_crowd` VALUES ('fbdc8d3099527e36c0d4487440425254', 'dc08ec030b10aa3349d2234bfc5cdd4d', '58', '-', '1', '271', '0', '4', '1', '申购化学', '2017-08-01 16:13:24', '1', '1', 'OK了啦', '18650728487', '77', '1', null, 'SG', '2', null, '1', 'http://api.wode-mall.com/uploads/20170801/b26debe50c6e4adaf0106b6860b8b608.jpg', null, null);
INSERT INTO `opa_order_crowd` VALUES ('fbfb72ba9d48ef199466adc3d40bb66b', 'ed8d2c62ee4843e515b60930d23cebb9', '79', '-', '1', '331', '0', '1', '1', 'zxltest', '2017-08-15 16:27:49', '1', '2', '136*****412', '13675020412', '101', '3', null, 'SG', '2', null, '1', '', null, null);

-- ----------------------------
-- Table structure for `opa_order_deposit`
-- ----------------------------
DROP TABLE IF EXISTS `opa_order_deposit`;
CREATE TABLE `opa_order_deposit` (
  `depositid` varchar(36) NOT NULL COMMENT '唯一id',
  `pay_user_id` int(11) NOT NULL COMMENT '用户id',
  `pay_order_id` varchar(36) NOT NULL COMMENT '拍品id 等等',
  `money` decimal(16,0) NOT NULL DEFAULT '0' COMMENT '保证金多少钱',
  `state` char(1) NOT NULL DEFAULT 'W' COMMENT 'Y已交，W未交，T 退回，',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `from` char(4) DEFAULT NULL COMMENT 'CZ 充值 S 申购 DJYE余额冻结 ...',
  `title` varchar(60) DEFAULT NULL COMMENT '名称',
  `picurl` varchar(100) DEFAULT NULL COMMENT '图片url',
  `address_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`depositid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='保证金';

-- ----------------------------
-- Records of opa_order_deposit
-- ----------------------------
INSERT INTO `opa_order_deposit` VALUES ('005157499b4025b00dd0e8beeb33a589', '256', '93', '1', 'Y', '2017-08-04 17:23:59', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '76');
INSERT INTO `opa_order_deposit` VALUES ('0847e0805dbbaa6965b6312893d78bf7', '258', '88', '50000', 'Y', '2017-08-02 10:35:35', 'PM', '世贸', 'http://api.wode-mall.com/uploads/20170802/37ac56289bb381de8497c0a66825258f.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('0b2a6c9c6f41718860f104b7fdcc3c1b', '258', '80', '1', 'T', '2017-08-01 14:45:34', 'PM', '竞价水星', 'http://api.wode-mall.com/uploads/20170801/e140c7a1e08e526c5501fe346c787700.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('0c2c731e07ac45785c1af3ac3a8bcae7', '271', '86', '1', 'Y', '2017-08-01 16:41:20', 'PM', '竞价一号', 'http://api.wode-mall.com/uploads/20170801/5fdc060f51c21b2bb11c3f02f5c40cc3.jpg', '77');
INSERT INTO `opa_order_deposit` VALUES ('15eae3b720e7e0ec2b16622412295cfa', '331', '108', '1', 'T', '2017-08-10 17:52:12', 'PM', '螺蛳粉', 'http://api.wode-mall.com/uploads/20170810/8c9373156c297f161047387d8796bd7b.jpg', '101');
INSERT INTO `opa_order_deposit` VALUES ('163d357c19abd1c97b5f0096b4e52c3d', '328', '91', '100', 'W', '2017-08-04 17:39:47', 'PM', '竞价兰陵王', 'http://api.wode-mall.com/uploads/20170802/58e5fb62c590b81b264babed1d2d82a5.jpg', '94');
INSERT INTO `opa_order_deposit` VALUES ('182877cf6683a230eb157e82b890f326', '270', '85', '4000', 'Y', '2017-08-01 16:44:12', 'PM', '竞价月亮', 'http://api.wode-mall.com/uploads/20170801/7aee13000b0678a74b1a2b474c0b85df.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('1fdc5d6760f9130b556a47c0576fb4f5', '257', '88', '50000', 'Y', '2017-08-02 10:37:16', 'PM', '世贸', 'http://api.wode-mall.com/uploads/20170802/37ac56289bb381de8497c0a66825258f.jpg', '78');
INSERT INTO `opa_order_deposit` VALUES ('22a5e9a8249f5816ce8b43c66461c595', '329', '91', '100', 'T', '2017-08-07 14:11:08', 'PM', '竞价兰陵王', 'http://api.wode-mall.com/uploads/20170802/58e5fb62c590b81b264babed1d2d82a5.jpg', '95');
INSERT INTO `opa_order_deposit` VALUES ('27aa9903328d84d8dd3d90f63a67da32', '340', '116', '1', 'Y', '2017-08-15 09:53:09', 'PM', '拍卖皮卡丘', 'http://api.wode-mall.com/uploads/20170815/82ecce13e73e473be11e82f5c2689d38.png', '103');
INSERT INTO `opa_order_deposit` VALUES ('2b2c3781bbbf55150c0eee5416a973c8', '340', '120', '1', 'Y', '2017-08-18 09:41:41', 'PM', '拍卖尔康', 'http://api.wode-mall.com/uploads/20170816/6824ea2a062874e60214f8567483c66e.jpg', '103');
INSERT INTO `opa_order_deposit` VALUES ('2f061877e06d72058030361d2e1244ad', '3', '117', '1', 'Y', '2017-08-15 10:49:13', 'PM', 'test', 'http://api.wode-mall.com/uploads/20170815/60fffda3762ba7bff289f5a04abb31d6.jpg', '104');
INSERT INTO `opa_order_deposit` VALUES ('347a97938d60a49597cb9abcd42efb3d', '0', '94', '1', 'T', '2017-08-04 15:21:44', 'PM', '红茶', 'http://api.wode-mall.com/uploads/20170803/a5506b7b3a7764372fa33d16fda6c3f4.jpg', '89');
INSERT INTO `opa_order_deposit` VALUES ('3539003e65e3aabb05cb31c1fce7fbdd', '340', '110', '1', 'Y', '2017-08-11 15:11:58', 'PM', '拍卖胖虎', 'http://api.wode-mall.com/uploads/20170810/36ddaa50898e7c960d9a62d39370b9f4.jpg', '103');
INSERT INTO `opa_order_deposit` VALUES ('35a9f446b32e178ed242641d1df69cca', '270', '98', '1', 'Y', '2017-08-07 16:58:18', 'PM', '竞价太阳', 'http://api.wode-mall.com/uploads/20170807/2051a8f3bc7bcf8d7637759834d85af7.jpg', '97');
INSERT INTO `opa_order_deposit` VALUES ('3841c06a313f8fc9012401f2ac4e9c09', '258', '96', '1', 'Y', '2017-08-04 17:06:08', 'PM', '竞价京东', 'http://api.wode-mall.com/uploads/20170804/4322cba34d13bd1b6ecae6da46fb88dc.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('40716006e4b6c2957c28cd624218e3f4', '256', '91', '100', 'T', '2017-08-02 14:37:01', 'PM', '竞价兰陵王', 'http://api.wode-mall.com/uploads/20170802/58e5fb62c590b81b264babed1d2d82a5.jpg', '76');
INSERT INTO `opa_order_deposit` VALUES ('408d09ef392911951e44fd6cc58ca2fb', '256', '86', '1', 'Y', '2017-08-01 16:43:16', 'PM', '竞价一号', 'http://api.wode-mall.com/uploads/20170801/5fdc060f51c21b2bb11c3f02f5c40cc3.jpg', '76');
INSERT INTO `opa_order_deposit` VALUES ('4312ab1b70e3421010ad66c229c3d391', '4', '113', '1', 'Y', '2017-08-11 17:54:56', 'PM', '煽风点火就会看见好看', 'http://api.wode-mall.com/uploads/20170811/1610aeb2e561e08c160279f4b8311756.jpg', '73');
INSERT INTO `opa_order_deposit` VALUES ('43fa2107601884af909a32a00b1405b2', '270', '94', '1', 'T', '2017-08-04 14:46:46', 'PM', '红茶', 'http://api.wode-mall.com/uploads/20170803/a5506b7b3a7764372fa33d16fda6c3f4.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('45e470612d12c082704d54b463875758', '4', '111', '1', 'Y', '2017-08-11 17:52:16', 'PM', '打算范德萨发生的发生的', 'http://api.wode-mall.com/uploads/20170811/d0f9267f8770efc63b188ed79dada8fe.jpg', '73');
INSERT INTO `opa_order_deposit` VALUES ('4aad9c5ea98d875dc453b931af1fdcf2', '321', '100', '1', 'Y', '2017-08-07 18:09:31', 'PM', '竞价桌子', 'http://api.wode-mall.com/uploads/20170807/b45ae5b7aad36b7a0b6e13cdd4c24ef0.jpg', '91');
INSERT INTO `opa_order_deposit` VALUES ('4dd11a7f7da83e40a387a9a5fc3ef232', '273', '108', '1', 'T', '2017-08-10 17:11:12', 'PM', '螺蛳粉', 'http://api.wode-mall.com/uploads/20170810/8c9373156c297f161047387d8796bd7b.jpg', '87');
INSERT INTO `opa_order_deposit` VALUES ('4e4052ff51de12a1507a56acb15e6401', '256', '79', '1', 'Y', '2017-08-01 13:38:13', 'PM', '竞价木星', 'http://api.wode-mall.com/uploads/20170801/68b5518cd082ff65c477e9ab3bc9ec1d.jpg', '71');
INSERT INTO `opa_order_deposit` VALUES ('5074874427a3ef9ef6068f76cbc4236c', '256', '89', '100', 'Y', '2017-08-04 16:06:34', 'PM', 'aaa', '/deal/images/goods.png', '71');
INSERT INTO `opa_order_deposit` VALUES ('5437318d230e8504774ebfd27e9e681f', '329', '109', '1', 'Y', '2017-08-21 16:33:16', 'PM', '谁动了我的拍卖', 'http://api.wode-mall.com/uploads/20170810/65cb195ab49f5f6b21a1a0097f8b89c1.jpg', '95');
INSERT INTO `opa_order_deposit` VALUES ('550ed639980c2dfa8cac62442f9002e5', '322', '105', '20000', 'W', '2017-08-09 17:55:10', 'PM', '青花瓷', 'http://api.wode-mall.com/uploads/20170809/84e70ba6b35bbe07cf8444d86a2dc12c.jpg', '89');
INSERT INTO `opa_order_deposit` VALUES ('5ae5d2fdac68141ab8d0d096b95ed716', '256', '85', '4000', 'Y', '2017-08-01 16:56:50', 'PM', '竞价月亮', 'http://api.wode-mall.com/uploads/20170801/7aee13000b0678a74b1a2b474c0b85df.jpg', '76');
INSERT INTO `opa_order_deposit` VALUES ('5f81f127ab7d2037588e798704c988e4', '256', '80', '1', 'T', '2017-08-01 14:40:46', 'PM', '竞价水星', 'http://api.wode-mall.com/uploads/20170801/e140c7a1e08e526c5501fe346c787700.jpg', '76');
INSERT INTO `opa_order_deposit` VALUES ('60f53ec96cb63d0ec72f73454b54fbc0', '258', '81', '1', 'T', '2017-08-01 15:27:37', 'PM', '竞价土星', 'http://api.wode-mall.com/uploads/20170801/556d8aaac9395c97a76273d011dabb02.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('69fcacdb0b345fc516347ce68106733b', '340', '115', '1', 'Y', '2017-08-15 09:35:21', 'PM', '拍卖良心', 'http://api.wode-mall.com/uploads/20170815/1eba10779107a8e9694037cc9f593e24.jpg', '103');
INSERT INTO `opa_order_deposit` VALUES ('6e14bfa65f3f8e8225d0d55108b641d8', '4', '104', '500', 'T', '2017-08-10 17:16:29', 'PM', '青花瓷1', 'http://api.wode-mall.com/uploads/20170809/56a8e7aada99b016ce1ef839d42fbf16.jpg', '73');
INSERT INTO `opa_order_deposit` VALUES ('6f13ade474cb00d30da12233ea9d2d3f', '270', '95', '1', 'Y', '2017-08-03 16:55:13', 'PM', '竞价地瓜', 'http://api.wode-mall.com/uploads/20170803/197456e620e9a62276890e4c600e8e2f.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('71658e5de6b9e8c01a9f49a5836dca5c', '326', '93', '1', 'Y', '2017-08-04 15:51:20', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '93');
INSERT INTO `opa_order_deposit` VALUES ('722384f42629697c62569ef9151893c9', '270', '97', '1', 'T', '2017-08-07 13:29:34', 'PM', '竞价电影', 'http://api.wode-mall.com/uploads/20170807/83133ae5b641a3523ee4953954fdfa2b.jpg', '97');
INSERT INTO `opa_order_deposit` VALUES ('7422189b5d6bad50f54f668ab25ae72b', '329', '98', '1', 'T', '2017-08-07 13:40:43', 'PM', '竞价太阳', 'http://api.wode-mall.com/uploads/20170807/2051a8f3bc7bcf8d7637759834d85af7.jpg', '95');
INSERT INTO `opa_order_deposit` VALUES ('7602dc26458fd32a23b7c25336f17ba1', '340', '119', '1', 'Y', '2017-08-15 14:00:12', 'PM', '拍卖蘑菇', 'http://api.wode-mall.com/uploads/20170815/dbb9cf237fddda697e82ba287beb3585.jpg', '103');
INSERT INTO `opa_order_deposit` VALUES ('767636188e1bbf6d72db9b110ebaf7cd', '257', '100', '1', 'Y', '2017-08-07 18:10:00', 'PM', '竞价桌子', 'http://api.wode-mall.com/uploads/20170807/b45ae5b7aad36b7a0b6e13cdd4c24ef0.jpg', '78');
INSERT INTO `opa_order_deposit` VALUES ('76b5d2f2061b9982c5f32dafb280cc17', '270', '81', '1', 'T', '2017-08-01 15:27:56', 'PM', '竞价土星', 'http://api.wode-mall.com/uploads/20170801/556d8aaac9395c97a76273d011dabb02.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('7773de2a83757b8cecd6b9372c693f63', '325', '93', '1', 'W', '2017-08-04 15:40:14', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '92');
INSERT INTO `opa_order_deposit` VALUES ('7a6aacf42b277e2c65cb5282f462ff43', '257', '87', '1', 'Y', '2017-08-01 17:22:10', 'PM', '竞价中单', 'http://api.wode-mall.com/uploads/20170801/f16f177cc7de396db84d6cea22aa8c4e.jpg', '78');
INSERT INTO `opa_order_deposit` VALUES ('7f9f9fe8c16f1adb1585531263c75393', '257', '93', '1', 'Y', '2017-08-04 17:19:19', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '78');
INSERT INTO `opa_order_deposit` VALUES ('81e6a1c9e54f61b42e48f260b1576f5a', '273', '94', '1', 'T', '2017-08-03 16:54:11', 'PM', '红茶', 'http://api.wode-mall.com/uploads/20170803/a5506b7b3a7764372fa33d16fda6c3f4.jpg', '86');
INSERT INTO `opa_order_deposit` VALUES ('882c6ea8205a8fb8b674b54c7f0b7c6e', '3', '118', '1', 'T', '2017-08-15 11:01:36', 'PM', 'testtt', 'http://api.wode-mall.com/uploads/20170815/235ad446606ec2919df499c3f1629aeb.jpg', '104');
INSERT INTO `opa_order_deposit` VALUES ('88a252900807dacdca5caf92e5958307', '3', '108', '1', 'T', '2017-08-10 17:43:45', 'PM', '螺蛳粉', 'http://api.wode-mall.com/uploads/20170810/8c9373156c297f161047387d8796bd7b.jpg', '104');
INSERT INTO `opa_order_deposit` VALUES ('8cfb294ba6225d9e8dbd1751d1937e4e', '270', '82', '1', 'T', '2017-08-01 16:03:31', 'PM', '竞价火星', 'http://api.wode-mall.com/uploads/20170801/48fd088e7354db83dfe41c714698a992.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('8f7234fb00f40192828a8689c8a16e94', '258', '94', '1', 'Y', '2017-08-04 14:47:44', 'PM', '红茶', 'http://api.wode-mall.com/uploads/20170803/a5506b7b3a7764372fa33d16fda6c3f4.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('92f4bc938ba84bbd783ae78170b681c4', '340', '108', '1', 'T', '2017-08-10 17:03:55', 'PM', '螺蛳粉', 'http://api.wode-mall.com/uploads/20170810/8c9373156c297f161047387d8796bd7b.jpg', '103');
INSERT INTO `opa_order_deposit` VALUES ('953d658c498528c213f4461742bd8d6e', '321', '91', '100', 'W', '2017-08-04 17:17:25', 'PM', '竞价兰陵王', 'http://api.wode-mall.com/uploads/20170802/58e5fb62c590b81b264babed1d2d82a5.jpg', '91');
INSERT INTO `opa_order_deposit` VALUES ('9716cbe9a91cb9a8021bba872d4ab397', '258', '87', '1', 'Y', '2017-08-01 17:41:52', 'PM', '竞价中单', 'http://api.wode-mall.com/uploads/20170801/f16f177cc7de396db84d6cea22aa8c4e.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('97f263acdc78c1c0dbb6f5ad7f0c1e1b', '329', '101', '1', 'T', '2017-08-08 13:42:22', 'PM', '竞价酷狗', 'http://api.wode-mall.com/uploads/20170808/25e12eaa464bc64a1a8ad7b880273d63.jpg', '95');
INSERT INTO `opa_order_deposit` VALUES ('9b07747e35148270bccba1c082df3fa5', '258', '86', '1', 'Y', '2017-08-02 13:54:01', 'PM', '竞价一号', 'http://api.wode-mall.com/uploads/20170802/40b691781cc541be2bb80b723516d298.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('9b43633d1af7a97f2d194db5d740c421', '256', '88', '50000', 'Y', '2017-08-02 12:35:57', 'PM', '世贸', 'http://api.wode-mall.com/uploads/20170802/37ac56289bb381de8497c0a66825258f.jpg', '76');
INSERT INTO `opa_order_deposit` VALUES ('9b4a4a304955036884ca2ee3ea01b72d', '321', '98', '1', 'W', '2017-08-08 17:33:03', 'PM', '竞价太阳', 'http://api.wode-mall.com/uploads/20170807/2051a8f3bc7bcf8d7637759834d85af7.jpg', '91');
INSERT INTO `opa_order_deposit` VALUES ('9b98bf3cfc1b01599db4a0c61f59ae40', '329', '97', '1', 'Y', '2017-08-07 11:26:58', 'PM', '竞价电影', 'http://api.wode-mall.com/uploads/20170807/83133ae5b641a3523ee4953954fdfa2b.jpg', '95');
INSERT INTO `opa_order_deposit` VALUES ('9e9078a37bc6d1dc613f194237cb4cf2', '270', '100', '1', 'Y', '2017-08-07 17:55:53', 'PM', '竞价桌子', 'http://api.wode-mall.com/uploads/20170807/b45ae5b7aad36b7a0b6e13cdd4c24ef0.jpg', '97');
INSERT INTO `opa_order_deposit` VALUES ('a4c18cc313747b0b85ca2b96bde411e7', '4', '109', '1', 'Y', '2017-08-11 18:04:56', 'PM', '谁动了我的拍卖', 'http://api.wode-mall.com/uploads/20170810/65cb195ab49f5f6b21a1a0097f8b89c1.jpg', '73');
INSERT INTO `opa_order_deposit` VALUES ('a54729be3d43ece0f6449213452d330b', '329', '121', '2', 'Y', '2017-08-21 17:37:28', 'PM', '竞价王者荣耀', 'http://api.wode-mall.com/uploads/20170821/3270a6793b7ddeb0ed218a99fd93c770.jpg', '95');
INSERT INTO `opa_order_deposit` VALUES ('a7a0b2e62c82c85787488e8a897bc5ca', '330', '93', '1', 'Y', '2017-08-04 17:33:58', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '96');
INSERT INTO `opa_order_deposit` VALUES ('a8f18eb5549dae7a76b04e4a09bca2aa', '322', '94', '1', 'W', '2017-08-04 15:13:17', 'PM', '红茶', 'http://api.wode-mall.com/uploads/20170803/a5506b7b3a7764372fa33d16fda6c3f4.jpg', '89');
INSERT INTO `opa_order_deposit` VALUES ('a9b13b48b286b723093d0ed0c4b75aea', '322', '108', '1', 'T', '2017-08-10 17:06:12', 'PM', '螺蛳粉', 'http://api.wode-mall.com/uploads/20170810/8c9373156c297f161047387d8796bd7b.jpg', '89');
INSERT INTO `opa_order_deposit` VALUES ('ab567e77584a3790afc1f44ee145d311', '329', '100', '1', 'Y', '2017-08-07 17:55:33', 'PM', '竞价桌子', 'http://api.wode-mall.com/uploads/20170807/b45ae5b7aad36b7a0b6e13cdd4c24ef0.jpg', '95');
INSERT INTO `opa_order_deposit` VALUES ('b1193bc16ef97b94e6833839a4b38d94', '270', '88', '50000', 'Y', '2017-08-02 10:45:51', 'PM', '世贸', 'http://api.wode-mall.com/uploads/20170802/37ac56289bb381de8497c0a66825258f.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('b255fe7fd6eeb6d56c645f533c8b692f', '328', '93', '1', 'Y', '2017-08-04 17:05:02', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '94');
INSERT INTO `opa_order_deposit` VALUES ('b56f10ed70373751ddc4b210112e576d', '258', '93', '1', 'Y', '2017-08-04 17:13:41', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('b5acca31e2d1e40679c5c41a82f38ff5', '257', '89', '100', 'Y', '2017-08-07 17:44:29', 'PM', 'aaa', '/deal/images/goods.png', '78');
INSERT INTO `opa_order_deposit` VALUES ('b9378736dd3a130a4fb5909c0fe78973', '258', '91', '100', 'T', '2017-08-02 13:54:48', 'PM', '竞价兰陵王', 'http://api.wode-mall.com/uploads/20170802/be130b6941fb58972ff7d7298b6a9df8.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('bbf188d17e5e91c980aa78cefe3eceaf', '4', '106', '100', 'T', '2017-08-10 17:14:10', 'PM', '212', '/deal/images/goods.png', '73');
INSERT INTO `opa_order_deposit` VALUES ('bd65417f8a789a98418f13129dc9f4bb', '257', '101', '1', 'T', '2017-08-08 11:06:48', 'PM', '竞价酷狗', 'http://api.wode-mall.com/uploads/20170808/25e12eaa464bc64a1a8ad7b880273d63.jpg', '78');
INSERT INTO `opa_order_deposit` VALUES ('beba89f8328af4efd4efb02be4af8734', '270', '93', '1', 'Y', '2017-08-04 16:16:56', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('c1ddbd789ecb9dd74fcf81451fab4b2f', '273', '97', '1', 'Y', '2017-08-07 13:56:06', 'PM', '竞价电影', 'http://api.wode-mall.com/uploads/20170807/83133ae5b641a3523ee4953954fdfa2b.jpg', '87');
INSERT INTO `opa_order_deposit` VALUES ('ceb20da756c3d0132dd77db277025eda', '270', '92', '1', 'T', '2017-08-03 14:58:05', 'PM', '竞价哥哥', 'http://api.wode-mall.com/uploads/20170803/c58c4bf7806015baecfe927e587428f8.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('cfe9f99beb0b21ad0dd3a38210143ca3', '270', '91', '100', 'T', '2017-08-02 14:36:28', 'PM', '竞价兰陵王', 'http://api.wode-mall.com/uploads/20170802/58e5fb62c590b81b264babed1d2d82a5.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('d13afff8dd09040bf6a02d80bec90bca', '258', '92', '1', 'T', '2017-08-03 14:57:41', 'PM', '竞价哥哥', 'http://api.wode-mall.com/uploads/20170803/c58c4bf7806015baecfe927e587428f8.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('d2e59aadd44032ff854befe8f4b4a4c1', '270', '96', '1', 'Y', '2017-08-04 17:05:51', 'PM', '竞价京东', 'http://api.wode-mall.com/uploads/20170804/4322cba34d13bd1b6ecae6da46fb88dc.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('d50bc01e28598a0499cce908bd122bb3', '256', '108', '1', 'Y', '2017-08-10 17:10:37', 'PM', '螺蛳粉', 'http://api.wode-mall.com/uploads/20170810/8c9373156c297f161047387d8796bd7b.jpg', '76');
INSERT INTO `opa_order_deposit` VALUES ('d8f43d407ba342f448218bf32c667fbe', '270', '79', '1', 'Y', '2017-08-01 11:05:39', 'PM', '竞价木星', 'http://api.wode-mall.com/uploads/20170801/68b5518cd082ff65c477e9ab3bc9ec1d.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('de869e1d17d51a54b3cda0fc4d4cc46d', '4', '108', '1', 'T', '2017-08-10 17:09:27', 'PM', '螺蛳粉', 'http://api.wode-mall.com/uploads/20170810/8c9373156c297f161047387d8796bd7b.jpg', '73');
INSERT INTO `opa_order_deposit` VALUES ('df0adb4d9be25dc250698eb323008d28', '270', '80', '1', 'T', '2017-08-01 14:52:09', 'PM', '竞价水星', 'http://api.wode-mall.com/uploads/20170801/e140c7a1e08e526c5501fe346c787700.jpg', '72');
INSERT INTO `opa_order_deposit` VALUES ('df9bac01c2752771e0a9e6399ceb22ac', '273', '92', '1', 'Y', '2017-08-03 14:58:54', 'PM', '竞价哥哥', 'http://api.wode-mall.com/uploads/20170803/c58c4bf7806015baecfe927e587428f8.jpg', '86');
INSERT INTO `opa_order_deposit` VALUES ('e59d44ff0184f241c5e3bdc2678f67ac', '270', '89', '100', 'Y', '2017-08-07 17:10:09', 'PM', 'aaa', '/deal/images/goods.png', '97');
INSERT INTO `opa_order_deposit` VALUES ('e6e3470bed5ff97d4abc21601f528489', '340', '109', '1', 'Y', '2017-08-10 17:25:47', 'PM', '谁动了我的拍卖', 'http://api.wode-mall.com/uploads/20170810/65cb195ab49f5f6b21a1a0097f8b89c1.jpg', '103');
INSERT INTO `opa_order_deposit` VALUES ('e94c51924974888c3729c30463cd91ed', '4', '90', '100', 'T', '2017-08-10 17:12:37', 'PM', '竞价兰陵王', 'http://api.wode-mall.com/uploads/20170802/6404666068c71f08b1d10e9fa7fc7d39.jpg', '73');
INSERT INTO `opa_order_deposit` VALUES ('ec7399974ddac075f3674d0c18cb1ace', '257', '91', '100', 'T', '2017-08-02 14:51:18', 'PM', '竞价兰陵王', 'http://api.wode-mall.com/uploads/20170802/58e5fb62c590b81b264babed1d2d82a5.jpg', '78');
INSERT INTO `opa_order_deposit` VALUES ('ef85730011b4fe92a4de8de5792e28c1', '258', '95', '1', 'T', '2017-08-03 16:55:01', 'PM', '竞价地瓜', 'http://api.wode-mall.com/uploads/20170803/197456e620e9a62276890e4c600e8e2f.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('efec61289fb48994e8b91401956894d7', '257', '79', '1', 'W', '2017-08-01 16:16:39', 'PM', '竞价木星', 'http://api.wode-mall.com/uploads/20170801/68b5518cd082ff65c477e9ab3bc9ec1d.jpg', '78');
INSERT INTO `opa_order_deposit` VALUES ('f433577e2bd03ed4d658654977fc9666', '321', '93', '1', 'Y', '2017-08-04 15:38:28', 'PM', '竞价妹妹', 'http://api.wode-mall.com/uploads/20170803/e183da589a0fa9100ae00cb7b4ab0f99.jpg', '91');
INSERT INTO `opa_order_deposit` VALUES ('f702eff0ba697130467582012063678e', '340', '114', '1', 'Y', '2017-08-14 17:14:30', 'PM', '拍卖树懒', 'http://api.wode-mall.com/uploads/20170814/681379e8b8b28bd55f8b563c5d101152.jpg', '103');
INSERT INTO `opa_order_deposit` VALUES ('f77b586727deb8688dec0ab3cfb2be25', '339', '118', '1', 'Y', '2017-08-15 16:04:16', 'PM', 'testtt', 'http://api.wode-mall.com/uploads/20170815/235ad446606ec2919df499c3f1629aeb.jpg', '105');
INSERT INTO `opa_order_deposit` VALUES ('f7aea2de8ade40125e1fd68f79a690b8', '256', '84', '1', 'Y', '2017-08-01 16:37:17', 'PM', '竞价太阳', 'http://api.wode-mall.com/uploads/20170801/a6d0609cfe4afce395aa63a8464d4772.jpg', '76');
INSERT INTO `opa_order_deposit` VALUES ('f8aa933e40695bf0a626ec89f3c31863', '258', '79', '1', 'Y', '2017-08-01 13:35:13', 'PM', '竞价木星', 'http://api.wode-mall.com/uploads/20170801/68b5518cd082ff65c477e9ab3bc9ec1d.jpg', '74');
INSERT INTO `opa_order_deposit` VALUES ('f8f5754ab70b2a7049a752d787caed9c', '4', '112', '1', 'Y', '2017-08-11 17:54:34', 'PM', '发给对方时光隧道', 'http://api.wode-mall.com/uploads/20170811/7ac3bda81eba53fcf81634233e558ce8.jpg', '73');
INSERT INTO `opa_order_deposit` VALUES ('f9bc66fe41de0546991870883562fb74', '271', '79', '1', 'Y', '2017-08-01 16:21:59', 'PM', '竞价木星', 'http://api.wode-mall.com/uploads/20170801/68b5518cd082ff65c477e9ab3bc9ec1d.jpg', '77');
INSERT INTO `opa_order_deposit` VALUES ('fc7dfde583399d81a5dd4705332bd4ba', '3', '109', '1', 'Y', '2017-08-15 10:30:17', 'PM', '谁动了我的拍卖', 'http://api.wode-mall.com/uploads/20170810/65cb195ab49f5f6b21a1a0097f8b89c1.jpg', '104');

-- ----------------------------
-- Table structure for `opa_order_free`
-- ----------------------------
DROP TABLE IF EXISTS `opa_order_free`;
CREATE TABLE `opa_order_free` (
  `pay_o_free_id` varchar(36) NOT NULL COMMENT '唯一id 一个商品一个订单',
  `pay_ototal_id` varchar(36) DEFAULT NULL COMMENT '所属哪一个订单 总的数据',
  `pay_free_id` varchar(36) DEFAULT NULL COMMENT '自由竞拍id',
  `pay_goods_id` varchar(36) DEFAULT NULL COMMENT '商品id',
  `sellerid` varchar(36) DEFAULT NULL COMMENT '卖家id',
  `uid` varchar(36) DEFAULT NULL COMMENT '所属用户',
  `freight` decimal(16,0) DEFAULT '0' COMMENT '物流费用',
  `price` decimal(16,0) DEFAULT '0' COMMENT '商品售价',
  `broker` decimal(16,0) DEFAULT '0' COMMENT '佣金',
  `title` varchar(50) DEFAULT NULL COMMENT '名字',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `ispay` int(1) DEFAULT '2' COMMENT '2初始状态 支付状态 3失败 1成功',
  `isdelete` int(1) DEFAULT '2' COMMENT '2没有删除 1删除',
  `username` varchar(50) DEFAULT NULL COMMENT '订单用户名',
  `phone` varchar(15) DEFAULT NULL COMMENT '用户电话',
  `addressid` varchar(36) DEFAULT NULL COMMENT '用户地址id',
  `businessid` int(11) DEFAULT NULL COMMENT 'level等級',
  `sysid` int(11) DEFAULT NULL COMMENT '系統id 总部、合作伙伴、一级运营、二级运营、客户',
  `from` char(2) DEFAULT NULL COMMENT '申购(SG) 拍卖(PM) 自由买卖（ZM） 余额充值（YC）充值（CZ）竞价（JJ） 取两个大首字母',
  `isdelivery` int(1) DEFAULT '2' COMMENT '2未发货 1发货 3已收货',
  `pay_logistics_id` varchar(36) DEFAULT NULL COMMENT '物流id',
  PRIMARY KEY (`pay_o_free_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自由买卖订单';

-- ----------------------------
-- Records of opa_order_free
-- ----------------------------

-- ----------------------------
-- Table structure for `opa_order_total`
-- ----------------------------
DROP TABLE IF EXISTS `opa_order_total`;
CREATE TABLE `opa_order_total` (
  `pay_ototal_id` varchar(36) NOT NULL COMMENT '唯一id',
  `uid` varchar(36) DEFAULT NULL COMMENT '所属用户',
  `total_price` decimal(16,0) DEFAULT '0' COMMENT '物品花费',
  `total_broker` decimal(16,0) DEFAULT '0' COMMENT '总的佣金',
  `total_freight` decimal(16,0) DEFAULT '0' COMMENT '总物流费用',
  `total_deposit` decimal(16,0) DEFAULT '0' COMMENT '总的保证金',
  `total_all` decimal(16,0) DEFAULT '0' COMMENT '4个加起来',
  `desc` varchar(100) DEFAULT NULL COMMENT '描述',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `isdelete` int(1) DEFAULT '2' COMMENT '2没有删除 1删除',
  `ispay` int(1) DEFAULT '2' COMMENT '2支付状态 3失败 1成功',
  `addressid` int(11) DEFAULT '1' COMMENT '地址id',
  `isdelivery` int(1) DEFAULT '2',
  `title` varchar(100) DEFAULT NULL,
  `amount` int(11) DEFAULT '0' COMMENT '总数量',
  PRIMARY KEY (`pay_ototal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='总的订单';

-- ----------------------------
-- Records of opa_order_total
-- ----------------------------
INSERT INTO `opa_order_total` VALUES ('005799a248578f80fa586c560b67c316', '271', '1', '0', '0', '0', '0', null, '2017-08-01 08:30:23', '2', '2', '1', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('01fde0981083e1594f81354ae78c7932', '331', '1', '0', '0', '0', '0', null, '2017-08-16 00:33:39', '2', '1', '100', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('03464d5a8eeef21952a10c924d6b0ed9', '258', '1', '0', '0', '0', '0', null, '2017-08-02 06:34:04', '2', '2', '1', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('03fb30ba4d8cdddf93155449bace68ff', '340', '2', '0', '0', '0', '0', null, '2017-08-15 06:03:02', '2', '1', '103', '2', '拍卖蘑菇', '1');
INSERT INTO `opa_order_total` VALUES ('06cbfd01c19ec94278bc4fd03dcdf0ed', '270', '1', '0', '0', '0', '0', null, '2017-08-02 06:48:17', '2', '1', '72', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('06f090ae8bfdeac9c3918df84d786705', '4', '1', '0', '0', '0', '0', null, '2017-08-01 03:30:44', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('09ef5134ae95cb6df0004e877d85210c', '270', '3', '0', '0', '0', '0', null, '2017-08-03 08:57:13', '2', '1', '72', '2', '竞价地瓜', '1');
INSERT INTO `opa_order_total` VALUES ('0b322dd2dda5f4837df4d631a75e389e', '273', '1', '0', '0', '0', '0', null, '2017-08-07 05:46:32', '2', '1', '86', '2', '申购周杰伦', '1');
INSERT INTO `opa_order_total` VALUES ('0ecb5e68f5aa70ceb434c14f1b0a9589', '331', '1', '0', '0', '0', '0', null, '2017-08-15 08:22:22', '2', '2', '1', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('134c4ed4fea1a044fce259695a073760', '256', '1', '0', '0', '0', '0', null, '2017-08-01 06:06:09', '2', '1', '71', '2', '申购英语', '1');
INSERT INTO `opa_order_total` VALUES ('15fc11fcacc4c7b6747518139e2124f3', '258', '1', '0', '0', '0', '0', null, '2017-08-01 09:43:52', '2', '1', '74', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('165c9cd37d185028fbc8273307c98bad', '256', '1', '0', '0', '0', '0', null, '2017-08-04 08:41:15', '2', '1', '88', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('19aa63cbc2d45df2ebfbe3cad516d93b', '270', '1', '0', '0', '0', '0', null, '2017-08-02 06:54:58', '2', '1', '72', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('1a56e47329958df06ef6398c31702986', '321', '5', '0', '0', '0', '0', null, '2017-08-08 09:54:49', '2', '2', '102', '2', '竞价桌子', '1');
INSERT INTO `opa_order_total` VALUES ('1c1545cefa5e3424177a6acd50b549d5', '340', '2', '0', '0', '0', '0', null, '2017-08-15 02:14:28', '2', '1', '103', '2', '拍卖良心', '1');
INSERT INTO `opa_order_total` VALUES ('1c25fd4953532b69837e105331584060', '256', '1', '0', '0', '0', '0', null, '2017-08-10 09:46:10', '2', '2', '88', '2', '申购小米', '1');
INSERT INTO `opa_order_total` VALUES ('1eb1dcaa2bc07ab470c312c95f3db00f', '4', '200', '0', '0', '0', '0', null, '2017-08-11 01:03:00', '2', '2', '1', '2', '212', '1');
INSERT INTO `opa_order_total` VALUES ('1ef50867e5d3f2480c54e64af230fac3', '258', '1', '0', '0', '0', '0', null, '2017-08-01 05:32:12', '2', '1', '74', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('20ffd44146678df21444385d247e0834', '340', '2', '0', '0', '0', '0', null, '2017-08-15 01:53:19', '2', '1', '103', '2', '拍卖皮卡丘', '1');
INSERT INTO `opa_order_total` VALUES ('21517e6e3a234624088f0ef8148390de', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:12:57', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('21c3e5d3840264ae016a882ed2ef343a', '270', '2', '0', '0', '0', '0', null, '2017-08-01 08:13:05', '2', '1', '72', '2', '竞价火星', '1');
INSERT INTO `opa_order_total` VALUES ('2289899b749ab9f6b539a12530ef3f6b', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:09:50', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('251aeed6916aae9f58584c0a0b7ff811', '271', '1', '0', '0', '0', '0', null, '2017-08-01 08:24:45', '2', '1', '77', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('25a9a4c8da810a147eb620ad8bb43518', '329', '2500000', '0', '0', '0', '0', null, '2017-08-21 09:29:15', '2', '2', '1', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('26197dc87ca3d520493094559d554a52', '256', '2', '0', '0', '0', '0', null, '2017-07-31 21:58:46', '2', '2', '1', '2', '申购总统', '2');
INSERT INTO `opa_order_total` VALUES ('26580eee26f0832e337b11c9435d6012', '329', '2500000', '0', '0', '0', '0', null, '2017-08-14 12:54:59', '2', '2', '1', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('2685ec38b4557b96649514e21bc7d249', '270', '1', '0', '0', '0', '0', null, '2017-08-04 08:36:32', '2', '2', '1', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('2d467789dacc6b5a7cec6d2cabc10f1d', '4', '1', '0', '0', '0', '0', null, '2017-08-01 02:58:13', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('2fb6f09765724df75ee16731d25792c5', '4', '1', '0', '0', '0', '0', null, '2017-08-01 05:58:18', '2', '1', '73', '2', '申购英语', '1');
INSERT INTO `opa_order_total` VALUES ('3277627f592ae23edd89cc76a6d121b8', '4', '1', '0', '0', '0', '0', null, '2017-07-31 09:14:40', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('34cca64f3df8cdbce1b8618a35793a93', '329', '1', '0', '0', '0', '0', null, '2017-08-07 06:17:39', '2', '2', '95', '2', '申购周杰伦', '1');
INSERT INTO `opa_order_total` VALUES ('350b3145b3347ba0ca3d3552d8824739', '258', '1', '0', '0', '0', '0', null, '2017-08-02 07:18:58', '2', '2', '1', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('3a473e553c0db6f4e9d6755280f2cc78', '4', '1', '0', '0', '0', '0', null, '2017-07-31 09:13:34', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('3e4779215c8cab9928efa91bdb6fc120', '329', '1', '0', '0', '0', '0', null, '2017-08-04 09:32:06', '2', '2', '95', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('3ea87d399447748a0f44423ecfeedbd8', '4', '1', '0', '0', '0', '0', null, '2017-08-01 06:03:47', '2', '1', '73', '2', '申购物理', '1');
INSERT INTO `opa_order_total` VALUES ('3ed49857cd4ee66def917fbe4b07574b', '273', '1', '0', '0', '0', '0', null, '2017-08-03 06:13:09', '2', '1', '86', '2', '申购中学生', '1');
INSERT INTO `opa_order_total` VALUES ('444585d216ceeb3cc328179d49ccabce', '270', '1', '0', '0', '0', '0', null, '2017-08-04 08:37:05', '2', '1', '90', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('46990854bf62de5c9e663f8a3275f03c', '339', '3', '0', '0', '0', '0', null, '2017-08-15 16:00:25', '2', '2', '1', '2', 'testtt', '1');
INSERT INTO `opa_order_total` VALUES ('497b595befd18d5153d6d2a22fcb9103', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:39:04', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('4c34007e1094cf86e1c251e44e31680a', '270', '1', '0', '0', '0', '0', null, '2017-08-07 06:14:36', '2', '2', '97', '2', '申购周杰伦', '1');
INSERT INTO `opa_order_total` VALUES ('4c82a99dc8f9973980e492e777eacca2', '270', '1', '0', '0', '0', '0', null, '2017-08-02 07:01:12', '2', '2', '1', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('4d53e013a53e7547e9db2ba5dfd31da3', '4', '1100', '0', '0', '0', '0', null, '2017-08-15 02:14:26', '2', '2', '1', '2', '发给对方时光隧道', '1');
INSERT INTO `opa_order_total` VALUES ('4dc179c1fce397d736501f568acd8fcb', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:09:50', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('4e3cd5cf22aa539148bccad3164ba839', '273', '1', '0', '0', '0', '0', null, '2017-08-09 03:18:08', '2', '2', '86', '2', '申购小米', '1');
INSERT INTO `opa_order_total` VALUES ('52ec3fc9edd8cc67c199f1421891a808', '270', '1', '0', '0', '0', '0', null, '2017-08-07 05:56:58', '2', '1', '97', '2', '申购周杰伦', '1');
INSERT INTO `opa_order_total` VALUES ('531a86075b89d88efa69ef6b0bcefd7c', '270', '1', '0', '0', '0', '0', null, '2017-08-01 06:10:11', '2', '1', '72', '2', '申购物理', '1');
INSERT INTO `opa_order_total` VALUES ('584781db7634eff6bb6a5413d6bff4cc', '271', '1', '0', '0', '0', '0', null, '2017-08-01 08:06:54', '2', '1', '77', '2', '申购英语', '1');
INSERT INTO `opa_order_total` VALUES ('58d1de8173779f594f352689dd799e5b', '329', '2500000', '0', '0', '0', '0', null, '2017-08-08 07:28:54', '2', '2', '1', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('5da317a9af66d21baf0a46bbb9606890', '326', '1', '0', '0', '0', '0', null, '2017-08-04 08:46:46', '2', '1', '93', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('5deb21b40bb32e7d6f2175fab7858b42', '273', '3', '0', '0', '0', '0', null, '2017-08-07 05:57:48', '2', '1', '86', '2', '竞价电影', '1');
INSERT INTO `opa_order_total` VALUES ('5f0513b9f56c2e50d83b5d09d45a8703', '258', '2', '0', '0', '0', '0', null, '2017-08-02 06:34:28', '2', '1', '74', '2', '申购老虎', '2');
INSERT INTO `opa_order_total` VALUES ('6025c57ed2485558ffd8e5b1bc2d6d06', '321', '1', '0', '0', '0', '0', null, '2017-08-04 08:17:19', '2', '1', '91', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('62bb1efa71a883d0ee39fd63d6ef5885', '322', '1', '0', '0', '0', '0', null, '2017-08-04 08:08:42', '2', '31', '89', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('6648bcec0c228fba09dd764314f624a8', '329', '1', '0', '0', '0', '0', null, '2017-08-04 09:58:30', '2', '2', '95', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('670c59737feaafa6e6dcf8d5472ca03d', '340', '2', '0', '0', '0', '0', null, '2017-08-15 02:14:27', '2', '1', '103', '2', '拍卖树懒', '1');
INSERT INTO `opa_order_total` VALUES ('69d3aae8083a5999f6eaff58a97b04f2', '270', '3', '0', '0', '0', '0', null, '2017-08-03 09:19:20', '2', '2', '1', '2', '竞价地瓜', '1');
INSERT INTO `opa_order_total` VALUES ('6fac8ceb8bbb3ce45c2affcf51b15fe1', '239', '1', '0', '0', '0', '0', null, '2017-07-31 09:17:24', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('6ffa61c7222ce87ac4e18abf709ed130', '329', '1', '0', '0', '0', '0', null, '2017-08-04 09:36:26', '2', '2', '1', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('7221f57afec2527f8ae94706fe3b00c4', '340', '2', '0', '0', '0', '0', null, '2017-08-10 09:28:45', '2', '1', '103', '2', '谁动了我的拍卖', '1');
INSERT INTO `opa_order_total` VALUES ('761a0098a88cf1d2e5a03aa48314440b', '271', '1', '0', '0', '0', '0', null, '2017-08-01 08:26:55', '2', '1', '77', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('7a551fe7adbf8cd6d3aaf694449f0c8e', '239', '1', '0', '0', '0', '0', null, '2017-08-01 06:07:48', '2', '2', '75', '2', '申购英语', '1');
INSERT INTO `opa_order_total` VALUES ('7b4100713568ed1a3ca0458caba72f4a', '258', '3', '0', '0', '0', '0', null, '2017-08-02 07:22:03', '2', '2', '1', '2', '申购老虎', '3');
INSERT INTO `opa_order_total` VALUES ('7bb8d6f0b6dc228ddd195fbc2b46179d', '256', '1', '0', '0', '0', '0', null, '2017-07-31 13:12:04', '2', '1', '62', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('7be11cffc192aa36aec672609f3d6257', '256', '1', '0', '0', '0', '0', null, '2017-08-02 06:39:35', '2', '1', '76', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('7c0dfe814c87effa1919871f46e29227', '331', '100', '0', '0', '0', '0', null, '2017-08-05 23:48:30', '2', '2', '98', '2', 'ffffffff', '1');
INSERT INTO `opa_order_total` VALUES ('7cc65501baf933e7994b64aee106627a', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:24:10', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('7ecea5a71710034d4bf8d4f1cedb6fa2', '329', '2500000', '0', '0', '0', '0', null, '2017-08-08 07:22:00', '2', '2', '1', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('7fd236b696a72cfde867c57ee1bd7c12', '273', '1', '0', '0', '0', '0', null, '2017-08-07 05:48:22', '2', '1', '86', '2', '申购张学友', '1');
INSERT INTO `opa_order_total` VALUES ('80d8625ca59ec4f73b336b8d24919ffb', '257', '1', '0', '0', '0', '0', null, '2017-08-11 10:33:27', '2', '1', '78', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('8246eef607c8693aebea5d1c578fa2e6', '4', '1', '0', '0', '0', '0', null, '2017-08-01 02:54:58', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('8269bb4ddd7e72fd3d44ba07d000cce1', '239', '1', '0', '0', '0', '0', null, '2017-08-01 05:57:41', '2', '2', '75', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('834209e0bc2ce520d94ba3452288d993', '340', '1', '0', '0', '0', '0', null, '2017-08-16 00:25:15', '2', '1', '103', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('83902ee10cacacb87921b43b3bac7c3f', '270', '1', '0', '0', '0', '0', null, '2017-08-04 08:38:52', '2', '2', '1', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('87389ad7dc3cf3b4d02dd6e85b16ac6a', '326', '1', '0', '0', '0', '0', null, '2017-08-04 08:47:32', '2', '31', '93', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('88b416fa1e4e847793cffc12b996c482', '4', '1', '0', '0', '0', '0', null, '2017-08-01 03:09:03', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('8a496e6e0a900257476cfc5785e3cdb6', '321', '1', '0', '0', '0', '0', null, '2017-08-10 07:38:44', '2', '1', '102', '2', '申购小米', '1');
INSERT INTO `opa_order_total` VALUES ('8e861a7e3d6d4c651e6a70eaaf93323d', '257', '1', '0', '0', '0', '0', null, '2017-08-11 10:30:23', '2', '1', '78', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('8f23ef237ee39a43135215c5e2e70027', '4', '1', '0', '0', '0', '0', null, '2017-08-01 03:13:43', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('8f6bdee89e94f42b97fcd6f525e8673a', '4', '1', '0', '0', '0', '0', null, '2017-08-01 03:11:37', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('930cc9f973fedea624498840713b25cf', '4', '1', '0', '0', '0', '0', null, '2017-07-31 09:42:29', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('956eafa467ba62078640929307186d6d', '330', '1', '0', '0', '0', '0', null, '2017-08-04 09:51:37', '2', '2', '1', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('9633cb883f04ec8e3fd3c5df1726712a', '329', '2500000', '0', '0', '0', '0', null, '2017-08-22 05:15:20', '2', '2', '1', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('96877f4978f4ab452085ca37e54008ae', '256', '100', '0', '0', '0', '0', null, '2017-08-10 09:12:59', '2', '1', '88', '2', 'ffffffff', '1');
INSERT INTO `opa_order_total` VALUES ('96db8d8ab3b54469b969ef0f596a22ce', '331', '1', '0', '0', '0', '0', null, '2017-08-16 00:46:01', '2', '1', '100', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('9a9583d99d40c00fb8434102e638c31d', '4', '1', '0', '0', '0', '0', null, '2017-08-01 06:02:56', '2', '1', '73', '2', '申购英语', '1');
INSERT INTO `opa_order_total` VALUES ('9b54afb62527606c3f1733c9c57affe3', '4', '1', '0', '0', '0', '0', null, '2017-08-01 05:26:43', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('9c5ebe7885d69deea47b40a6a6bc4b66', '330', '1', '0', '0', '0', '0', null, '2017-08-04 09:51:11', '2', '2', '1', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('9d1b42ea1a359a0545482d9986604c77', '4', '1', '0', '0', '0', '0', null, '2017-08-01 03:06:40', '2', '2', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('9ecf76695d455de35edb95758cd5bb01', '256', '1028', '0', '0', '0', '0', null, '2017-08-11 00:58:29', '2', '2', '1', '2', '螺蛳粉', '1');
INSERT INTO `opa_order_total` VALUES ('a02693ce49b620a32526b51b91ad23cc', '4', '1', '0', '0', '0', '0', null, '2017-08-01 03:17:20', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('a28b4de13a36cd26a4e25482570d882d', '239', '1', '0', '0', '0', '0', null, '2017-07-31 09:18:24', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('a2b73ffa1d913343a24adfb4ca25c8ea', '331', '1', '0', '0', '0', '0', null, '2017-08-15 22:41:45', '2', '2', '1', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('a77c03267d2a0a789982c664cd500fce', '329', '2500000', '0', '0', '0', '0', null, '2017-08-10 06:20:13', '2', '2', '95', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('a8ec355d834bf3b5d254f943dd49642c', '4', '1', '0', '0', '0', '0', null, '2017-08-01 02:45:09', '2', '2', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('a9e643268d6322d1d0792c253708a735', '239', '1', '0', '0', '0', '0', null, '2017-07-31 09:17:02', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('ab76c7cb4721707e9498f9279613522f', '256', '1', '0', '0', '0', '0', null, '2017-07-31 21:42:00', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('ab7d354526a9030d7f17d3fc396d8599', '4', '2000', '0', '0', '0', '0', null, '2017-08-15 02:14:27', '2', '2', '1', '2', '煽风点火就会看见好看', '1');
INSERT INTO `opa_order_total` VALUES ('ac9c828970d93db7cc167f206e4fd6db', '331', '1', '0', '0', '0', '0', null, '2017-08-15 22:44:35', '2', '2', '100', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('ad81f68726e37b41a77557deb94304c0', '329', '2', '0', '0', '0', '0', null, '2017-08-08 06:05:21', '2', '1', '95', '2', '竞价酷狗', '1');
INSERT INTO `opa_order_total` VALUES ('aed5181fcca31e9db0583ee65606caae', '256', '1', '0', '0', '0', '0', null, '2017-08-01 06:07:50', '2', '1', '76', '2', '申购物理', '1');
INSERT INTO `opa_order_total` VALUES ('b0caf8760e85e16dfcfb237235fc2ae3', '331', '1', '0', '0', '0', '0', null, '2017-08-15 08:20:25', '2', '2', '1', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('b160537274416fc9e155d5ebcb521fd0', '329', '1', '0', '0', '0', '0', null, '2017-08-10 06:18:16', '2', '2', '1', '2', '申购小米', '1');
INSERT INTO `opa_order_total` VALUES ('b1fad2a13ad66d69a1e7e5b04c34e969', '3', '101', '0', '0', '0', '0', null, '2017-08-15 16:00:25', '2', '2', '1', '2', 'test', '1');
INSERT INTO `opa_order_total` VALUES ('b41d48eef3da47b355147bc367177987', '4', '1', '0', '0', '0', '0', null, '2017-08-01 02:53:42', '2', '1', '73', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('b44e3130ba019482031f25b945eef2e1', '329', '2500000', '0', '0', '0', '0', null, '2017-08-08 10:06:26', '2', '2', '1', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('b6089ee0c906eda9b1c507c9cf61090b', '330', '1', '0', '0', '0', '0', null, '2017-08-04 09:53:12', '2', '1', '96', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('b75917875c8010c6256fe39529a247f8', '340', '1', '0', '0', '0', '0', null, '2017-08-14 10:22:17', '2', '2', '1', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('b8589f94767a418cb61b0c4cbff9eb90', '270', '2', '0', '0', '0', '0', null, '2017-08-04 09:07:20', '2', '1', '90', '2', '竞价京东', '1');
INSERT INTO `opa_order_total` VALUES ('b8597daa1dfddec027f89c1201c8c369', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:24:11', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('bd8a54ee27b258380a6471890dddc874', '256', '100', '0', '0', '0', '0', null, '2017-08-05 23:50:21', '2', '2', '88', '2', 'ffffffff', '1');
INSERT INTO `opa_order_total` VALUES ('be326ceb61f6a55364e0ea89fef45a72', '339', '1', '0', '0', '0', '0', null, '2017-08-15 07:50:41', '2', '1', '105', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('c05df2d24525112462237762d310bbeb', '339', '1', '0', '0', '0', '0', null, '2017-08-15 07:49:28', '2', '2', '1', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('c17253f06a1c4526569c8862b29078f6', '331', '1', '0', '0', '0', '0', null, '2017-08-15 08:43:36', '2', '1', '100', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('c20ae716734e97f5cf6f6937777bbb89', '256', '100', '0', '0', '0', '0', null, '2017-08-10 09:14:08', '2', '1', '88', '2', 'ffffffff', '1');
INSERT INTO `opa_order_total` VALUES ('c3a3172f64665f16db741af8dd3c6c77', '270', '3', '0', '0', '0', '0', null, '2017-08-03 09:22:20', '2', '1', '72', '2', '竞价地瓜', '1');
INSERT INTO `opa_order_total` VALUES ('c46857e9466283c477bed27e1a68e5c5', '322', '1', '0', '0', '0', '0', null, '2017-08-08 06:32:25', '2', '1', '89', '2', '申购手机', '1');
INSERT INTO `opa_order_total` VALUES ('c4d0ee0c7b978a3562921ea20402eb4c', '271', '1', '0', '0', '0', '0', null, '2017-08-01 08:28:36', '2', '2', '1', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('c56979c8710fc6717080124de3e69b1c', '256', '1', '0', '0', '0', '0', null, '2017-07-31 09:30:17', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('c77e18c5eb12632c2be1d1434e46de84', '340', '1', '0', '0', '0', '0', null, '2017-08-12 02:17:51', '2', '1', '103', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('c7c4005238cebe85c2d616b6e1380a3d', '258', '1', '0', '0', '0', '0', null, '2017-08-01 09:45:24', '2', '2', '1', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('c9079f065e1ad4d1c0f9a8bbd803009d', '239', '1', '0', '0', '0', '0', null, '2017-08-01 05:59:02', '2', '2', '75', '2', '申购物理', '1');
INSERT INTO `opa_order_total` VALUES ('c90faad89de43de67289d59e0eabfdcf', '258', '1', '0', '0', '0', '0', null, '2017-08-02 06:34:21', '2', '2', '1', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('ca9bc178a24f8870453bc46c89a935d7', '331', '1', '0', '0', '0', '0', null, '2017-08-15 22:52:24', '2', '1', '100', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('caff3d6cc13d7620b6f3cda997c2e190', '270', '1', '0', '0', '0', '0', null, '2017-08-04 09:56:36', '2', '2', '97', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('cba275cebeb4fa018c1dfacce5c0c4fd', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:24:13', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('cc97dec8a792ad80b570c06ad3719ddc', '270', '1', '0', '0', '0', '0', null, '2017-08-01 05:45:02', '2', '1', '72', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('cf27c4f8d68f020d4be99c44adfad7a8', '257', '100', '0', '0', '0', '0', null, '2017-08-11 10:24:08', '2', '2', '78', '2', 'ffffffff', '1');
INSERT INTO `opa_order_total` VALUES ('d14e622f3554d54bdd43b965e1043382', '270', '1', '0', '0', '0', '0', null, '2017-08-07 05:56:36', '2', '1', '97', '2', '申购周杰伦', '1');
INSERT INTO `opa_order_total` VALUES ('d21de55aa122a0530d538b87ece334a9', '340', '1', '0', '0', '0', '0', null, '2017-08-12 02:18:23', '2', '2', '103', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('d43f1016e8f998bd04a7a1f6d74cd5a6', '270', '1', '0', '0', '0', '0', null, '2017-08-02 06:55:21', '2', '2', '1', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('d5b76f165da329fa84aba6f57da064bc', '256', '1', '0', '0', '0', '0', null, '2017-07-31 12:08:30', '2', '2', '62', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('d5d25e0035dfe8c563ef5584f4ece06e', '256', '1', '0', '0', '0', '0', null, '2017-08-15 08:50:03', '2', '2', '1', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('d768fc71f9d53b6ed47a2ab165efe933', '270', '1', '0', '0', '0', '0', null, '2017-08-01 02:31:04', '2', '1', '72', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('d84829320d56d17588bf09e8582693cb', '270', '1', '0', '0', '0', '0', null, '2017-08-04 08:39:22', '2', '2', '1', '2', '建宁黄桃', '1');
INSERT INTO `opa_order_total` VALUES ('dc08ec030b10aa3349d2234bfc5cdd4d', '271', '1', '0', '0', '0', '0', null, '2017-08-01 08:13:23', '2', '1', '77', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('df268f6bc14467bf438f5c86168b45b9', '270', '2', '0', '0', '0', '0', null, '2017-08-09 05:21:41', '2', '1', '97', '2', '竞价太阳', '1');
INSERT INTO `opa_order_total` VALUES ('df5518e299ffe3bdee8bdea041eb35d1', '329', '2500000', '0', '0', '0', '0', null, '2017-08-22 05:14:25', '2', '2', '1', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('dff48b6a3777dc6b677920dd993b7809', '4', '1000', '0', '0', '0', '0', null, '2017-08-11 01:02:30', '2', '2', '1', '2', '竞价兰陵王', '1');
INSERT INTO `opa_order_total` VALUES ('e15b7a2ea56da6d9693164023a020ec5', '4', '1', '0', '0', '0', '0', null, '2017-08-01 05:54:50', '2', '1', '73', '2', '申购英语', '1');
INSERT INTO `opa_order_total` VALUES ('e23cd9ac7d4043df8b438d9a2dbd5308', '273', '4', '0', '0', '0', '0', null, '2017-08-03 07:32:34', '2', '1', '86', '2', '竞价哥哥', '1');
INSERT INTO `opa_order_total` VALUES ('e556abacd2b4719d31ae34baaa54f9ab', '256', '1', '0', '0', '0', '0', null, '2017-07-31 13:16:30', '2', '1', '62', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('e5d167ba67b09455aa6d202aaf77bd6b', '4', '1', '0', '0', '0', '0', null, '2017-07-31 09:11:03', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('e9d627cefb65c734282871b078a5f3f7', '256', '1', '0', '0', '0', '0', null, '2017-07-31 09:07:55', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('ea271f500f763cbc9fa203243558983f', '270', '2500000', '0', '0', '0', '0', null, '2017-08-07 09:29:55', '2', '2', '1', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('ea882cd21e411de0dd800365e5e1bdd8', '270', '1', '0', '0', '0', '0', null, '2017-08-02 06:50:34', '2', '2', '72', '2', '申购老虎', '1');
INSERT INTO `opa_order_total` VALUES ('ec2f65648c7c49bee2de3508a2f601a3', '258', '3', '0', '0', '0', '0', null, '2017-08-04 07:44:27', '2', '2', '1', '2', '红茶', '1');
INSERT INTO `opa_order_total` VALUES ('ed8d2c62ee4843e515b60930d23cebb9', '331', '1', '0', '0', '0', '0', null, '2017-08-15 08:27:49', '2', '1', '100', '2', 'zxltest', '1');
INSERT INTO `opa_order_total` VALUES ('ee24be2e2749febf8ccde7f9ffd40487', '257', '1', '0', '0', '0', '0', null, '2017-08-01 09:09:43', '2', '1', '78', '2', '申购化学', '1');
INSERT INTO `opa_order_total` VALUES ('f101385eac874e96dd7900fa234f4c8b', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:09:50', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('f12f78b345e810016ad081e4d23fa0a1', '340', '2500000', '0', '0', '0', '0', null, '2017-08-18 06:16:14', '2', '2', '103', '2', '经典水晶', '1');
INSERT INTO `opa_order_total` VALUES ('f2d4f1440f6651ff038e82c1aea929d0', '256', '7', '0', '0', '0', '0', null, '2017-08-04 09:33:28', '2', '2', '1', '2', '竞价妹妹', '1');
INSERT INTO `opa_order_total` VALUES ('f49c5d17083ac233a08374b2eca33e54', '329', '37', '0', '0', '0', '0', null, '2017-08-07 06:33:27', '2', '1', '95', '2', '竞价兰陵王', '1');
INSERT INTO `opa_order_total` VALUES ('f4df91fc5309492e56d9c77500fcfa83', '258', '1', '0', '0', '0', '0', null, '2017-07-31 09:09:48', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('f5c9d50a8319677e179c18672c259e08', '256', '1', '0', '0', '0', '0', null, '2017-07-31 21:34:44', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('f8e1271a88482b064ff248ea41c3b2ea', '340', '5', '0', '0', '0', '0', null, '2017-08-15 02:02:23', '2', '1', '103', '2', '拍卖胖虎', '1');
INSERT INTO `opa_order_total` VALUES ('fa1d8a78ed1e8b855e279e944f64810f', '256', '1', '0', '0', '0', '0', null, '2017-08-01 05:18:03', '2', '2', '1', '2', '申购语文', '1');
INSERT INTO `opa_order_total` VALUES ('fd5ded276b97a4c0e1c184d23c4bea4a', '239', '1', '0', '0', '0', '0', null, '2017-07-31 09:17:00', '2', '2', '1', '2', '申购总统', '1');
INSERT INTO `opa_order_total` VALUES ('fe6e55b03e346201ecd6338d144b95ad', '330', '1', '0', '0', '0', '0', null, '2017-08-04 09:52:07', '2', '2', '96', '2', '建宁黄桃', '1');

-- ----------------------------
-- Table structure for `opa_wallet`
-- ----------------------------
DROP TABLE IF EXISTS `opa_wallet`;
CREATE TABLE `opa_wallet` (
  `pay_wallet_id` varchar(36) NOT NULL COMMENT '钱包id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `wallet_money` decimal(16,0) DEFAULT '0' COMMENT '1 额度 可用 = 1-2-3',
  `wallet_deposit` decimal(16,0) DEFAULT '0' COMMENT '2 保证金',
  `wallet_freeze` decimal(16,0) DEFAULT '0' COMMENT '3 冻结额度',
  `point` int(11) DEFAULT '0' COMMENT '积分',
  `auth_token` varchar(50) DEFAULT 'init_reset' COMMENT '签名',
  `wallet_in` decimal(16,0) DEFAULT '0' COMMENT '冲入该账户的所有钱',
  `wallet_out` decimal(16,0) DEFAULT '0' COMMENT '该账户消费的所有钱，提现也算',
  `operation_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最近的钱包操作时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='钱包';

-- ----------------------------
-- Records of opa_wallet
-- ----------------------------
INSERT INTO `opa_wallet` VALUES ('a8397533cc9562e6cd39f1f713218206', '0', '8498', '200', '-7500', '0', 'init_reset', '11', '2', '2017-07-13 03:01:47');
INSERT INTO `opa_wallet` VALUES ('system_wallet', '1', '1053508', '2', '0', '0', 'init_reset', '1060554', '0', '2017-07-10 01:07:45');
INSERT INTO `opa_wallet` VALUES ('15ef45aa4019b472d00d66faa30c0779', '2', '100000', '7500', '100', '0', 'init_reset', '178', '0', '2017-07-10 01:07:45');
INSERT INTO `opa_wallet` VALUES ('1811013926a1f17f4ce948e39e21457e', '3', '128000', '2', '0', '0', 'init_reset', '0', '0', '2017-07-17 07:15:25');
INSERT INTO `opa_wallet` VALUES ('16274acb7f79da69bdff669daec10afb', '4', '100010795', '10514', '-800', '0', 'init_reset', '19', '5', '2017-07-11 12:44:32');
INSERT INTO `opa_wallet` VALUES ('3db8c89cd8c4093c13607f43c8eb702f', '255', '0', '0', '0', '0', 'init_reset', '0', '0', '2017-07-31 07:59:57');
INSERT INTO `opa_wallet` VALUES ('1d48270edda56d3b925c4869fe622067', '256', '9999802', '54102', '0', '0', 'init_reset', '8', '204', '2017-07-31 08:25:53');
INSERT INTO `opa_wallet` VALUES ('cf0fe525f820be8685baecfad2b8af27', '257', '10000102', '50003', '0', '0', 'init_reset', '5', '1', '2017-07-31 08:27:08');
INSERT INTO `opa_wallet` VALUES ('f1655ed2e7b978b2c67d226200b54c15', '258', '0', '50003', '0', '0', 'init_reset', '0', '4', '2017-07-31 08:32:12');
INSERT INTO `opa_wallet` VALUES ('918a8b953fa84c09a30b949c0fdff51b', '270', '9999986', '54103', '0', '0', 'init_reset', '6', '18', '2017-08-01 02:12:15');
INSERT INTO `opa_wallet` VALUES ('6d1fdd472db19cb25ccbe550f6093caa', '271', '5', '-5', '0', '0', 'init_reset', '9', '1', '2017-08-01 08:21:59');
INSERT INTO `opa_wallet` VALUES ('973cd4bd6a0561d22bba8ef89006f19f', '273', '7', '2', '0', '0', 'init_reset', '17', '1', '2017-08-03 06:58:55');
INSERT INTO `opa_wallet` VALUES ('556ea9ed51b35493ad98edb85d9cdd9c', '321', '2', '2', '0', '0', 'init_reset', '4', '2', '2017-08-04 07:38:29');
INSERT INTO `opa_wallet` VALUES ('9fa8f2ba6385b3f0251590105e5f077e', '322', '1', '0', '0', '0', 'init_reset', '2', '1', '2017-08-04 07:13:17');
INSERT INTO `opa_wallet` VALUES ('7afdfcb159e7ea01fb2175d6c7c19e89', '325', '0', '0', '0', '0', 'init_reset', '0', '0', '2017-08-04 07:40:14');
INSERT INTO `opa_wallet` VALUES ('b1d225b274e88116a9d3a328fa8e8bfe', '326', '1', '1', '0', '0', 'init_reset', '2', '0', '2017-08-04 07:51:21');
INSERT INTO `opa_wallet` VALUES ('50145246d12f7e0813e948d18611f979', '328', '5', '1', '0', '0', 'init_reset', '5', '0', '2017-08-04 09:05:02');
INSERT INTO `opa_wallet` VALUES ('60bffe22fe2e039513a7932b115beaeb', '329', '6', '-94', '0', '0', 'init_reset', '45', '0', '2017-08-07 03:26:58');
INSERT INTO `opa_wallet` VALUES ('ace4dfa198227fc08412c6c787b910e8', '330', '1', '1', '0', '0', 'init_reset', '2', '0', '2017-08-04 09:31:26');
INSERT INTO `opa_wallet` VALUES ('37633df407eb9861fd952dccbbaed225', '331', '2', '0', '0', '0', 'init_reset', '7', '1', '2017-08-10 09:52:12');
INSERT INTO `opa_wallet` VALUES ('b2d39c43e8f50b3b647ac49967c8edd0', '332', '0', '0', '0', '0', 'init_reset', '0', '0', '2017-08-10 01:31:33');
INSERT INTO `opa_wallet` VALUES ('96bc3ee0f7530c5629a33a24a2eb4603', '338', '0', '0', '0', '0', 'init_reset', '0', '0', '2017-08-10 07:51:00');
INSERT INTO `opa_wallet` VALUES ('51c25256f99b299c2e0347fd8e20d5b0', '339', '1', '1', '0', '0', 'init_reset', '2', '0', '2017-08-10 07:55:20');
INSERT INTO `opa_wallet` VALUES ('2fc63018f8138320abf04bc9af841f85', '340', '7', '7', '0', '0', 'init_reset', '24', '4', '2017-08-10 08:35:08');
INSERT INTO `opa_wallet` VALUES ('60eda701e9ff42a5c0370952050497cd', '341', '0', '0', '0', '0', 'init_reset', '0', '0', '2017-08-10 09:19:33');
INSERT INTO `opa_wallet` VALUES ('adf1580ca04145436db59d545cbbae19', '342', '0', '0', '0', '0', 'init_reset', '0', '0', '2017-08-10 09:52:15');
INSERT INTO `opa_wallet` VALUES ('b36f3dc3f333fcae74a61f61b1649c66', '343', '0', '0', '0', '0', 'init_reset', '0', '0', '2017-08-14 01:37:40');

-- ----------------------------
-- Table structure for `opa_wallet_action`
-- ----------------------------
DROP TABLE IF EXISTS `opa_wallet_action`;
CREATE TABLE `opa_wallet_action` (
  `pay_wa_time_id` varchar(36) NOT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '流出',
  `toid` int(11) DEFAULT NULL COMMENT '流入',
  `money` decimal(16,0) DEFAULT '0' COMMENT '余额/保证/冻结金/in/out',
  `money_type` char(4) DEFAULT NULL COMMENT 'YE/BZ/DJ/IN/OUT uid相对于',
  `desc` varchar(100) DEFAULT NULL COMMENT '业务描述',
  `oldauth` varchar(50) DEFAULT NULL COMMENT '未改的時候的auth',
  `pay_ototal_id` varchar(36) DEFAULT NULL COMMENT '订单id',
  `isclose` int(1) DEFAULT '2' COMMENT '2 初始 1结算过了 3 未结算',
  `from` char(4) DEFAULT NULL COMMENT '什么单子',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '生成时间',
  `point` int(11) NOT NULL COMMENT '积分',
  `isadd` int(1) DEFAULT '2' COMMENT '2加 1减',
  PRIMARY KEY (`pay_wa_time_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='钱包流水';

-- ----------------------------
-- Records of opa_wallet_action
-- ----------------------------
INSERT INTO `opa_wallet_action` VALUES ('00103fdde0f41bda31c112aca187bf0f', '340', '0', '2', 'YE', '微信支付订单', null, '03fb30ba4d8cdddf93155449bace68ff', '2', 'PM', '2017-08-15 06:20:13', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('005368fef951f41639ea6ef27eace221', '329', '0', '1', 'DJYE', '充值保证金1元', null, 'T', '2', 'CZ', '2017-08-07 06:10:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('00fa7802575c877522bd9736131bc5c8', '256', '0', '1', 'YE', '微信支付订单', null, '134c4ed4fea1a044fce259695a073760', '2', 'SG', '2017-08-01 06:06:27', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('01efe85a814e58687b4282f396372d04', '256', '0', '1', 'YE', '微信支付订单', null, 'aed5181fcca31e9db0583ee65606caae', '2', 'SG', '2017-08-01 06:09:14', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('042f259e243de8132d9ac98594e874f9', '271', '0', '1', 'YE', '余额支付订单', null, 'dc08ec030b10aa3349d2234bfc5cdd4d', '2', 'SG', '2017-08-01 08:26:28', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('04c8d743aa1f0974d607322296349341', '0', '322', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-10 09:19:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('0a692eee3dace9ca58763ab1c5a0cfa2', '340', '0', '1', 'DJYE', '缴纳保证金', null, '7602dc26458fd32a23b7c25336f17ba1', '2', 'CZ', '2017-08-15 06:00:12', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('0ae0f06e0a2d40425b514bd4f9afc054', '0', '257', '100', 'YE', '余额充值', null, '0', '2', 'CZ', '2017-08-04 09:12:04', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('0b5c874a4f2f2b8e86a2a8b9feedb8c7', '258', '0', '1', 'DJYE', '充值保证金1元', null, '0b2a6c9c6f41718860f104b7fdcc3c1b', '2', 'CZ', '2017-08-01 06:45:35', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('0bfd77e21c7a49c039016c64615da525', '340', '0', '1', 'DJYE', '缴纳保证金', null, 'f702eff0ba697130467582012063678e', '2', 'CZ', '2017-08-14 09:14:30', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('0ca39c3d803f3e903e72eea3406466c9', '340', '0', '2', 'YE', '余额支付订单', null, '7221f57afec2527f8ae94706fe3b00c4', '2', 'PM', '2017-08-10 09:33:30', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('0d837589463d9642b1986702190336df', '0', '329', '1', 'YE', '微信支付订单', null, '329', '2', 'CZ', '2017-08-07 03:28:34', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('0efe7842bc1b82dc2f90840b80d3760f', '0', '270', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:49:57', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('0fc2bf740c8fae43f6da46224a82d511', '270', '0', '1', 'DJYE', '充值保证金1元', null, '8cfb294ba6225d9e8dbd1751d1937e4e', '2', 'CZ', '2017-08-01 08:03:33', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('0fc883e36c91c1bc0e17b924c5fe607a', '270', '0', '50000', 'DJYE', '充值保证金50000元', null, 'b1193bc16ef97b94e6833839a4b38d94', '2', 'CZ', '2017-08-02 02:45:51', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('115ebc50789161b91a7f280701d02d5c', '0', '256', '1', 'YE', '微信充值', null, '256', '2', 'CZ', '2017-08-08 23:28:03', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('11da9b8e876d9788f8d4792195569abd', '271', '0', '1', 'DJYE', '充值保证金1元', null, 'f9bc66fe41de0546991870883562fb74', '2', 'CZ', '2017-08-01 08:22:39', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('124f78b2d7842cfd00cb02c6e5b4aaf1', '270', '0', '1', 'DJYE', '充值保证金1元', null, 'beba89f8328af4efd4efb02be4af8734', '2', 'CZ', '2017-08-04 08:16:56', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('125991386e48e2f68923199d306791e7', '0', '256', '100', 'YE', '退还保证金100元', null, '91', '2', 'CZ', '2017-08-07 06:33:28', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('1386810423a8ecc3aef05e04a954d901', '4', '0', '1', 'YE', '余额支付订单', null, '2d467789dacc6b5a7cec6d2cabc10f1d', '2', 'SG', '2017-08-01 02:58:15', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('18c0a690a3720f2f84470f8eb943ff55', '0', '329', '1', 'YE', '微信支付订单', null, '329', '2', 'CZ', '2017-08-07 09:05:59', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('18efb7338023787f1566de05a5c567db', '4', '0', '5', 'DJYE', '缴纳保证金', null, '6e14bfa65f3f8e8225d0d55108b641d8', '2', 'CZ', '2017-08-10 09:16:57', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('1d19cc979225580f188f8e7d0d447da4', '0', '257', '100', 'YE', '退还保证金', null, '91', '2', 'CZ', '2017-08-15 02:20:07', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('1e137a9410d476c15b3896242cacd403', '0', '3', '1', 'YE', '退还保证金', null, '118', '2', 'CZ', '2017-08-15 16:00:26', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('1e7846488ea1633c01c6e769a5c35ecf', '273', '0', '4', 'YE', '微信支付订单', null, 'e23cd9ac7d4043df8b438d9a2dbd5308', '2', 'PM', '2017-08-03 07:42:31', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('1eb14c0dd878c0f19cb82425df534e0d', '257', '0', '1', 'DJYE', '充值保证金1元', null, '7f9f9fe8c16f1adb1585531263c75393', '2', 'CZ', '2017-08-04 09:19:19', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('1f1fce4710a5c0ad81306b601ea20f15', '339', '0', '1', 'YE', '微信支付订单', null, 'be326ceb61f6a55364e0ea89fef45a72', '2', 'SG', '2017-08-15 07:56:07', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('1f7a9c22754ec087a471e7d733c7fefa', '0', '257', '100', 'YE', '退还保证金', null, '91', '2', 'CZ', '2017-08-15 02:26:47', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('208f370caaea0baa4aaca054c125327c', '257', '0', '100', 'DJYE', '充值保证金100元', null, 'b5acca31e2d1e40679c5c41a82f38ff5', '2', 'CZ', '2017-08-07 09:44:29', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('20c3199f1e0d5395a50c720779485a94', '340', '0', '2', 'YE', '微信支付订单', null, '670c59737feaafa6e6dcf8d5472ca03d', '2', 'PM', '2017-08-16 03:00:13', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('211be87c9d0e9e552ffd8279ed40b0fc', '0', '273', '1', 'YE', '微信充值', null, '273', '2', 'CZ', '2017-08-11 10:10:25', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2153fdf628875d7f0d38f92f19d6e1f5', '0', '328', '1', 'YE', '微信支付订单', null, '328', '2', 'CZ', '2017-08-04 09:10:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2213e3b2fb379366b78580b69bb7c9d8', '271', '0', '1', 'YE', '微信支付订单', null, '584781db7634eff6bb6a5413d6bff4cc', '2', 'SG', '2017-08-01 08:41:33', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('22cba042b2d28b3736823d98b98b81f2', '270', '0', '1', 'YE', '余额支付订单', null, 'cc97dec8a792ad80b570c06ad3719ddc', '2', 'SG', '2017-08-01 05:45:06', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('23383d02dd88cab761389d087eec5d78', '340', '0', '1', 'DJYE', '缴纳保证金', null, '69fcacdb0b345fc516347ce68106733b', '2', 'CZ', '2017-08-15 01:35:21', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('24d9b2e17bbf8b99d25768d1788265be', '0', '270', '1', 'YE', '退还保证金1元', null, '94', '2', 'CZ', '2017-08-04 07:44:28', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('252f40cb2b672679755fd835231af122', '0', '331', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-11 00:58:30', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('263dd25efe6bfc0badf0f3bbb4b84fa8', '270', '0', '1', 'YE', '余额支付订单', null, '444585d216ceeb3cc328179d49ccabce', '2', 'SG', '2017-08-04 08:37:09', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('269f95e3eda607c37ec5e240f70f8286', '329', '0', '1', 'DJYE', '充值保证金1元', null, 'ab567e77584a3790afc1f44ee145d311', '2', 'CZ', '2017-08-07 09:58:23', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2731cf10ec91fcd227fef7c2ae333a6a', '0', '271', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:49:55', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('294a7b5ea9762aa2c25324c5ab0d467c', '0', '273', '1', 'YE', '微信支付订单', null, '273', '2', 'CZ', '2017-08-03 07:12:16', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2abd1eac4dd880c26ece94468a5096a7', '0', '329', '1', 'YE', '微信充值', null, '329', '2', 'CZ', '2017-08-07 10:12:45', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2b41e36d7a8c710075240d89e0d4b392', '0', '322', '1', 'YE', '微信支付订单', null, '322', '2', 'CZ', '2017-08-04 07:24:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2bd044d99ad847b60f094d8e028434cd', '0', '256', '1', 'YE', '微信充值', null, '256', '2', 'CZ', '2017-08-09 23:37:07', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2c697fc3986f1d9ebabff0b09449ed1a', '0', '331', '1', 'YE', '微信充值', null, '331', '2', 'CZ', '2017-08-11 00:50:32', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2c782987b491648576492c514c23daf0', '4', '0', '1', 'YE', '微信支付订单', null, '8f6bdee89e94f42b97fcd6f525e8673a', '2', 'SG', '2017-08-01 06:16:05', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('2e04e857bf60b9b1210850b16b56abf7', '4', '0', '1', 'DJYE', '缴纳保证金', null, 'f8f5754ab70b2a7049a752d787caed9c', '2', 'CZ', '2017-08-11 09:54:34', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('2fd65bc550531b80d3a9c1ff03e2641e', '256', '0', '1', 'DJYE', '充值保证金1元', null, '005157499b4025b00dd0e8beeb33a589', '2', 'CZ', '2017-08-04 09:23:59', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3092ee80c79aab79cd85d305cb24fae3', '256', '0', '1', 'YE', '余额支付订单', null, 'e556abacd2b4719d31ae34baaa54f9ab', '2', 'SG', '2017-07-31 13:16:47', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('31adef5ee3d163fef4a2703dadb84f6b', '270', '0', '1', 'DJYE', '充值保证金1元', null, '43fa2107601884af909a32a00b1405b2', '2', 'CZ', '2017-08-04 06:46:47', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('31e9e4cd2748d5dab155e99748992590', '4', '0', '1', 'YE', '余额支付订单', null, 'b41d48eef3da47b355147bc367177987', '2', 'SG', '2017-08-01 02:53:46', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('345f08c4bbe7e7f022e2ab60d87ac9e1', '330', '0', '1', 'DJYE', '充值保证金1元', null, 'a7a0b2e62c82c85787488e8a897bc5ca', '2', 'CZ', '2017-08-04 09:34:52', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('347fb5ceba7166a3010902de5ba17264', '4', '0', '1', 'YE', '微信支付订单', null, '88b416fa1e4e847793cffc12b996c482', '2', 'SG', '2017-08-01 06:13:39', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('352b4c7616b1c80f88ae93ce49e48710', '257', '0', '50000', 'DJYE', '充值保证金50000元', null, '1fdc5d6760f9130b556a47c0576fb4f5', '2', 'CZ', '2017-08-02 02:37:16', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('370fbb2a4e0e4bc0bb23c0f65be0c00c', '0', '271', '3', 'YE', '微信支付订单', null, '271', '2', 'CZ', '2017-08-01 08:56:05', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3715d8a772f9f3df562ec24059b17d55', '258', '0', '1', 'DJYE', '充值保证金1元', null, '9716cbe9a91cb9a8021bba872d4ab397', '2', 'CZ', '2017-08-01 09:41:52', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('38146c410dc3e173851621d65ef82980', '0', '0', '1', 'YE', '退还保证金1元', null, '94', '2', 'CZ', '2017-08-04 07:44:28', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('38c4504d3c6af2fb08d452443fe5be62', '270', '0', '1', 'DJYE', '充值保证金1元', null, '35a9f446b32e178ed242641d1df69cca', '2', 'CZ', '2017-08-07 08:58:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3962eeec10f876767626f25100a5ff5a', '0', '270', '1', 'YE', '退还保证金1元', null, '82', '2', 'CZ', '2017-08-02 03:14:04', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3a0e3e920d7c1a23d398e81ead81130c', '270', '0', '1', 'YE', '余额支付订单', null, 'd14e622f3554d54bdd43b965e1043382', '2', 'SG', '2017-08-07 05:56:40', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('3a4f7f0f92e05929c7d81b8db14ba719', '270', '0', '2', 'YE', '余额支付订单', null, '21c3e5d3840264ae016a882ed2ef343a', '2', 'PM', '2017-08-01 08:14:22', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('3a6aeb9106860c870a9b731763024636', '0', '331', '1', 'YE', '微信充值', null, '331', '2', 'CZ', '2017-08-10 09:58:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3a94b42473dd822bee2cc6dd096eaf4d', '273', '0', '1', 'DJYE', '缴纳保证金', null, '4dd11a7f7da83e40a387a9a5fc3ef232', '2', 'CZ', '2017-08-10 09:11:12', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3aab205f86f7995df3c634c1ec047964', '0', '3', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-11 00:58:30', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3bbdd9720aa9caa7a228d45e343f804f', '0', '258', '1', 'YE', '退还保证金1元', null, '80', '2', 'CZ', '2017-08-02 03:00:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3cfcc8f4da8778940eeb9e3e8b23754c', '4', '0', '100', 'DJYE', '缴纳保证金', null, 'bbf188d17e5e91c980aa78cefe3eceaf', '2', 'CZ', '2017-08-10 09:14:10', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3e34a8eabdf9a8ca9a27c234a179d2f0', '270', '0', '1', 'DJYE', '充值保证金1元', null, '6f13ade474cb00d30da12233ea9d2d3f', '2', 'CZ', '2017-08-03 08:55:13', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3f674042d7ecf8d0797853ab573b8a99', '0', '271', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:48:50', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('3f7fafd68a7da1d3089a75a236f83683', '271', '0', '1', 'DJYE', '充值保证金1元', null, '0c2c731e07ac45785c1af3ac3a8bcae7', '2', 'CZ', '2017-08-01 08:42:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('4169839c25ac3886b4c6547ff3aca72b', '258', '0', '1', 'DJYE', '充值保证金1元', null, '9b07747e35148270bccba1c082df3fa5', '2', 'CZ', '2017-08-02 05:54:01', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('43c7eb45e252a1b3f6939737eab8595a', '0', '270', '1', 'YE', '退还保证金1元', null, '97', '2', 'CZ', '2017-08-07 05:57:49', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('4454fab3b897d426173cb66170b37389', '0', '258', '1', 'YE', '退还保证金1元', null, '92', '2', 'CZ', '2017-08-03 07:32:35', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('454b5879e3fef18c3aa7c6af23ac389f', '0', '258', '1', 'YE', '退还保证金1元', null, '80', '2', 'CZ', '2017-08-02 02:58:52', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('458d473dff8a0d0309d62b169f31d354', '0', '271', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:55:40', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('4714a3d4851bcd5cfb90527a2eaaf2f6', '340', '0', '1', 'DJYE', '缴纳保证金', null, '3539003e65e3aabb05cb31c1fce7fbdd', '2', 'CZ', '2017-08-11 07:11:59', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('474414ecb7c563ea592ffd3aa389538f', '273', '0', '3', 'YE', '微信支付订单', null, '5deb21b40bb32e7d6f2175fab7858b42', '2', 'PM', '2017-08-07 05:58:13', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('4839d76e61aa6b3aa4f2b3e1938c057f', '257', '0', '100', 'DJYE', '充值保证金100元', null, 'ec7399974ddac075f3674d0c18cb1ace', '2', 'CZ', '2017-08-02 06:51:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('48a042c4486d0c1e86e47d8542005113', '0', '270', '1', 'YE', '退还保证金1元', null, '81', '2', 'CZ', '2017-08-02 03:07:50', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('493a051771dab2dc15f3b9ecdb42d515', '340', '0', '1', 'DJYE', '缴纳保证金', null, '27aa9903328d84d8dd3d90f63a67da32', '2', 'CZ', '2017-08-15 01:53:09', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('4adea31318e011f2d52c0485d2c03f0b', '0', '329', '100', 'YE', '退还保证金', null, '91', '2', 'CZ', '2017-08-15 02:03:05', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('4b4daced2b851a178719e35b8e874c5c', '0', '340', '1', 'YE', '微信充值', null, '340', '2', 'CZ', '2017-08-10 09:57:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('4d32d78e72dd0387731c6afac4055b57', '257', '0', '1', 'DJYE', '缴纳保证金', null, '767636188e1bbf6d72db9b110ebaf7cd', '2', 'CZ', '2017-08-07 10:10:00', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('4f4c91ea154070429ec86bada3279f0b', '328', '0', '1', 'DJYE', '充值保证金1元', null, 'b255fe7fd6eeb6d56c645f533c8b692f', '2', 'CZ', '2017-08-04 09:11:15', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('4feb52c9e01da01b4bd88648b143efb4', '329', '0', '1', 'DJYE', '充值保证金1元', null, '9b98bf3cfc1b01599db4a0c61f59ae40', '2', 'CZ', '2017-08-07 03:31:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('50c0f7204c0d1b499abbd271100366e9', '326', '0', '1', 'YE', '微信支付订单', null, '5da317a9af66d21baf0a46bbb9606890', '2', 'SG', '2017-08-04 08:47:04', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('517fc4c907af5dbf95829ca3af5d6e56', '256', '0', '4000', 'DJYE', '充值保证金4000元', null, '5ae5d2fdac68141ab8d0d096b95ed716', '2', 'CZ', '2017-08-01 08:56:51', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('51bbf68cf972940c95c1dc39ee2a2c07', '0', '340', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-10 09:19:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('541f0169fb65caf67088be6328cea154', '331', '0', '1', 'DJYE', '缴纳保证金', null, '15eae3b720e7e0ec2b16622412295cfa', '2', 'CZ', '2017-08-10 09:58:49', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('548edf0ed66ab537072d550eb866b7c7', '0', '271', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:54:38', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('54f5751598368b0bf48b08f1dff79978', '258', '0', '1', 'DJYE', '充值保证金1元', null, 'f8aa933e40695bf0a626ec89f3c31863', '2', 'CZ', '2017-08-01 05:35:13', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('55e60b0c7cdf166f7ac6def10a4be8c7', '0', '256', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:54:39', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5794c95379ed1b393aeb1a8989060c0d', '4', '0', '1', 'DJYE', '缴纳保证金', null, 'T', '2', 'CZ', '2017-08-10 09:44:41', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('58101cc37509dbf06ba9bf2ef2e9123c', '270', '0', '1', 'YE', '微信支付订单', null, '531a86075b89d88efa69ef6b0bcefd7c', '2', 'SG', '2017-08-01 06:12:17', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('58661892647bf8b332c1f146b020ff47', '0', '329', '1', 'YE', '微信支付订单', null, '329', '2', 'CZ', '2017-08-07 06:24:35', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('589101daededa0fb215360bf6e15f3e3', '329', '0', '1', 'DJYE', '缴纳保证金', null, '5437318d230e8504774ebfd27e9e681f', '2', 'CZ', '2017-08-21 08:33:16', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('58a2c15640d8f72a1741f57414b74f18', '0', '270', '1', 'YE', '微信支付订单', null, '270', '2', 'CZ', '2017-08-03 09:04:57', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5958ead68187a73698d1d537d6bf766e', '0', '4', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-11 00:58:31', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5aa4b379ba9ba18e3b3d76ab18187c10', '0', '273', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-10 09:19:43', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5b014940fc23cd180105c8048287ebc7', '0', '322', '1', 'YE', '微信支付订单', null, '322', '2', 'CZ', '2017-08-04 09:07:16', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5b17e965107ba692353c18d740f045c7', '0', '257', '100', 'YE', '退还保证金100元', null, '91', '2', 'CZ', '2017-08-07 06:33:28', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5b84a112dbdba1dc1d868c2777dfeea3', '0', '256', '1', 'YE', '微信充值', null, '256', '2', 'CZ', '2017-08-10 09:23:54', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5c340a598d25f07dd135790da9e628c1', '0', '256', '1', 'YE', '退还保证金1元', null, '80', '2', 'CZ', '2017-08-02 03:00:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5ca66767e23ef18428925ec999edac0e', '0', '340', '1', 'YE', '微信充值', null, '340', '2', 'CZ', '2017-08-18 01:42:06', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5e56f639057c1af459c777010a5503ea', '0', '257', '1', 'YE', '微信支付订单', null, '257', '2', 'CZ', '2017-08-04 01:13:48', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5fb0b7741827a8df1f65976b99ca9fdf', '0', '273', '1', 'YE', '微信支付订单', null, '273', '2', 'CZ', '2017-08-04 07:30:10', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5fc807c4ab8590f20bbd66cdb1039c89', '331', '0', '1', 'YE', '微信支付订单', null, 'c17253f06a1c4526569c8862b29078f6', '2', 'SG', '2017-08-15 08:43:47', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('609b8989c058a75405c2a845aebc5fb0', '0', '4', '100', 'YE', '退还保证金', null, '90', '2', 'CZ', '2017-08-10 09:20:43', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('610e05860010ee3fabfc312450494bd2', '4', '0', '100', 'DJYE', '缴纳保证金', null, 'e94c51924974888c3729c30463cd91ed', '2', 'CZ', '2017-08-10 09:12:37', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('62f302736e158486f55506bad2966304', '4', '0', '1', 'DJYE', '缴纳保证金', null, '45e470612d12c082704d54b463875758', '2', 'CZ', '2017-08-11 09:52:16', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('63113416b8f4d8241df5be53ea380a3a', '0', '258', '100', 'YE', '退还保证金100元', null, '91', '2', 'CZ', '2017-08-07 06:33:29', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('634c1bf0ec68212f3c999e06079563b1', '331', '0', '1', 'YE', '余额支付订单', null, 'ed8d2c62ee4843e515b60930d23cebb9', '2', 'SG', '2017-08-15 08:43:11', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('63ad64fbad36c1c4be10e1fe6e6ed128', '3', '0', '1', 'DJYE', '缴纳保证金', null, '882c6ea8205a8fb8b674b54c7f0b7c6e', '2', 'CZ', '2017-08-15 03:01:36', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('63da588381f6507d30362ddab27efe77', '256', '0', '50000', 'DJYE', '充值保证金50000元', null, '9b43633d1af7a97f2d194db5d740c421', '2', 'CZ', '2017-08-02 04:35:58', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('641e1ff0fb9d1b252663a98c134d4562', '0', '273', '1', 'YE', '微信充值', null, '273', '2', 'CZ', '2017-08-11 09:45:04', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('64ee7a714cb73f038aa77f77635a993b', '270', '0', '1', 'DJYE', '充值保证金1元', null, 'df0adb4d9be25dc250698eb323008d28', '2', 'CZ', '2017-08-01 06:52:09', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('666fa7bb4624e90ce1f7c6a92b4c307c', '321', '0', '1', 'DJYE', '缴纳保证金', null, '4aad9c5ea98d875dc453b931af1fdcf2', '2', 'CZ', '2017-08-07 10:10:14', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('66cea25f0cc314199b747dce01da2ff7', '0', '329', '1', 'YE', '退还保证金1元', null, '101', '2', 'CZ', '2017-08-08 07:28:42', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('66ea9cc77e590eea108647585ffccbcc', '321', '0', '1', 'YE', '余额支付订单', null, '6025c57ed2485558ffd8e5b1bc2d6d06', '2', 'SG', '2017-08-04 08:19:31', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('6b2b1e916db9ef86cfeaacc5de743c2a', '0', '273', '1', 'YE', '微信支付订单', null, '273', '2', 'CZ', '2017-08-07 05:27:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('6c80c2cae6c515b48cc84406493e539a', '256', '0', '100', 'DJYE', '充值保证金100元', null, '5074874427a3ef9ef6068f76cbc4236c', '2', 'CZ', '2017-08-04 08:06:34', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('6d2cb69c811ddea04e72203d0060287d', '256', '0', '1', 'YE', '余额支付订单', null, '165c9cd37d185028fbc8273307c98bad', '2', 'SG', '2017-08-04 08:43:37', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('6d56788f6a0ee430f33f5c7cf5745ae5', '321', '0', '1', 'YE', '余额支付订单', null, '8a496e6e0a900257476cfc5785e3cdb6', '2', 'SG', '2017-08-10 07:38:49', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('6da645996af0cbd64f68981bf802e9ed', '340', '0', '1', 'DJYE', '缴纳保证金', null, '2b2c3781bbbf55150c0eee5416a973c8', '2', 'CZ', '2017-08-18 02:28:24', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('6e3aa9ab9b35e0a4acd71ac2b4328caf', '0', '258', '1', 'YE', '退还保证金1元', null, '81', '2', 'CZ', '2017-08-02 03:07:50', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('6ebaf5c0d8b782580228a4739c3a3216', '0', '256', '1', 'YE', '微信支付订单', null, '256', '2', 'CZ', '2017-08-02 01:34:30', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('706c0e06db13d61a9a4e4653205dda9f', '258', '0', '1', 'DJYE', '充值保证金1元', null, 'b56f10ed70373751ddc4b210112e576d', '2', 'CZ', '2017-08-04 09:13:41', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('71a8353cdad023b11a63725bcb23b0bd', '3', '0', '1', 'DJYE', '缴纳保证金', null, 'fc7dfde583399d81a5dd4705332bd4ba', '2', 'CZ', '2017-08-15 02:30:17', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('746fd8283a574fa685aa5a3834d9e304', '329', '0', '2', 'DJYE', '缴纳保证金', null, 'a54729be3d43ece0f6449213452d330b', '2', 'CZ', '2017-08-21 09:37:28', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('759bbce05d394cdd47c0160468c7ad82', '340', '0', '1', 'DJYE', '缴纳保证金', null, 'e6e3470bed5ff97d4abc21601f528489', '2', 'CZ', '2017-08-10 09:25:47', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('76f5fd90aff3f2e6d078294c10f5b54d', '258', '0', '1', 'DJYE', '充值保证金1元', null, 'ef85730011b4fe92a4de8de5792e28c1', '2', 'CZ', '2017-08-03 08:55:02', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('7762d24e9b8d0ccb555bfff47edf0db7', '256', '0', '1', 'DJYE', '充值保证金1元', null, 'f7aea2de8ade40125e1fd68f79a690b8', '2', 'CZ', '2017-08-01 08:37:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('77de5515d2df2e643933f6bf60e8d32f', '270', '0', '2', 'YE', '余额支付订单', null, 'b8589f94767a418cb61b0c4cbff9eb90', '2', 'PM', '2017-08-04 09:08:32', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('781f5533e918bfa83b839a422935042d', '256', '0', '100', 'YE', '余额支付订单', null, 'c20ae716734e97f5cf6f6937777bbb89', '2', 'SG', '2017-08-10 09:14:40', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('78678f72dbb128f9282e1bc6e0fa12a8', '331', '0', '1', 'YE', '微信支付订单', null, 'ca9bc178a24f8870453bc46c89a935d7', '2', 'SG', '2017-08-16 00:18:29', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('7b380c70ef17363665754ddfc70f1aa2', '273', '0', '1', 'DJYE', '充值保证金1元', null, 'c1ddbd789ecb9dd74fcf81451fab4b2f', '2', 'CZ', '2017-08-07 05:56:06', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('7d33894751188f72a72fb2574be54c5d', '0', '328', '1', 'YE', '微信支付订单', null, '328', '2', 'CZ', '2017-08-04 09:52:14', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('7d6d10120c780cc297e35b0f8d5659ca', '340', '0', '5', 'YE', '微信支付订单', null, 'f8e1271a88482b064ff248ea41c3b2ea', '2', 'PM', '2017-08-16 09:32:36', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('7e3a715ad8491d789a3f22c450319c3a', '4', '0', '1', 'YE', '余额支付订单', null, '8246eef607c8693aebea5d1c578fa2e6', '2', 'SG', '2017-08-01 02:55:03', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('7eaf76bfae5a4613ad322d43a6550d5e', '258', '0', '1', 'DJYE', '充值保证金1元', null, 'd13afff8dd09040bf6a02d80bec90bca', '2', 'CZ', '2017-08-03 06:57:41', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('81d0cbf23bc476952d47e9f8a1ce6356', '0', '270', '1', 'YE', '微信支付订单', null, '270', '2', 'CZ', '2017-08-04 07:23:33', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('829409d0d8bce534f6bede3ef44c9a5e', '4', '0', '1', 'YE', '微信支付订单', null, '3ea87d399447748a0f44423ecfeedbd8', '2', 'SG', '2017-08-01 06:04:01', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('855ea4af565e706076b3e37a1d4bce17', '0', '0', '1', 'DJYE', '充值保证金1元', null, '347a97938d60a49597cb9abcd42efb3d', '2', 'CZ', '2017-08-04 07:21:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('85f98fd066ee0f63d70b4d89fe981667', '0', '270', '1', 'YE', '微信支付订单', null, '270', '2', 'CZ', '2017-08-04 06:20:52', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('86f19a22dfacbe78f3dbdf419256321e', '270', '0', '1', 'DJYE', '充值保证金1元', null, 'd8f43d407ba342f448218bf32c667fbe', '2', 'CZ', '2017-08-01 03:05:39', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('875041b1b4160846289a31d601c7d86d', '256', '0', '1', 'YE', '余额支付订单', null, '7bb8d6f0b6dc228ddd195fbc2b46179d', '2', 'SG', '2017-07-31 13:12:48', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('87b0ed00b35e4f105a4f4a6bdadbea77', '340', '0', '1', 'YE', '余额支付订单', null, '834209e0bc2ce520d94ba3452288d993', '2', 'SG', '2017-08-16 09:29:33', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('87e0785b4cb9ca360efbaf50ce253818', '256', '0', '100', 'YE', '余额支付订单', null, '96877f4978f4ab452085ca37e54008ae', '2', 'SG', '2017-08-10 09:13:08', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('893a034579f108e6b84a72df4a6e7164', '0', '4', '100', 'YE', '退还保证金', null, '106', '2', 'CZ', '2017-08-10 09:19:43', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('8c5f977890edaf0427bfce4446b545d4', '0', '321', '1', 'YE', '微信支付订单', null, '321', '2', 'CZ', '2017-08-04 08:18:27', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('8db9be1f226a53704baec66a2b252f77', '0', '257', '1', 'YE', '余额充值', null, '0', '2', 'CZ', '2017-08-04 09:13:37', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('8f41fb565a910888ed474cb5b37ce344', '4', '0', '1', 'YE', '微信支付订单', null, '8f23ef237ee39a43135215c5e2e70027', '2', 'SG', '2017-08-01 06:18:11', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('901ddd95dd524fcd0d36ea087f06c0e1', '270', '0', '1', 'YE', '余额支付订单', null, '19aa63cbc2d45df2ebfbe3cad516d93b', '2', 'SG', '2017-08-02 06:55:09', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('90a917c3e0df55536d31059117d35ab5', '329', '0', '1', 'DJYE', '充值保证金1元', null, '22a5e9a8249f5816ce8b43c66461c595', '2', 'CZ', '2017-08-07 06:25:55', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('90aa9b9431ea5a726ae543f4d14ece66', '4', '0', '1', 'YE', '微信支付订单', null, '06f090ae8bfdeac9c3918df84d786705', '2', 'SG', '2017-08-01 06:35:17', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('927cf15383eaecfb77ed63820265213e', '270', '0', '100', 'DJYE', '充值保证金100元', null, 'e59d44ff0184f241c5e3bdc2678f67ac', '2', 'CZ', '2017-08-07 09:10:09', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('95268d804525ed3603d1bd162c2497e7', '271', '0', '1', 'YE', '微信支付订单', null, '761a0098a88cf1d2e5a03aa48314440b', '2', 'SG', '2017-08-01 08:27:20', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('981a56c263d992dcc61f21b0330abf32', '273', '0', '1', 'DJYE', '充值保证金1元', null, 'df9bac01c2752771e0a9e6399ceb22ac', '2', 'CZ', '2017-08-03 06:59:32', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('9903775d70e2a9cc52bd5724ab362cd8', '4', '0', '1', 'YE', '微信支付订单', null, '2fb6f09765724df75ee16731d25792c5', '2', 'SG', '2017-08-01 06:02:41', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('99bbc2520e4b2b30b6490eaa127ef754', '3', '0', '1', 'DJYE', '缴纳保证金', null, '88a252900807dacdca5caf92e5958307', '2', 'CZ', '2017-08-10 09:43:45', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('9b0b5ddbdde122632f68c240ca903a01', '257', '0', '1', 'DJYE', '缴纳保证金', null, 'bd65417f8a789a98418f13129dc9f4bb', '2', 'CZ', '2017-08-08 03:06:48', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('a00cac239f8ea206348c6af1be4e01db', '256', '0', '1', 'DJYE', '缴纳保证金', null, 'T', '2', 'CZ', '2017-08-10 09:47:58', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('a037bc060f3af4f8418b459408e2fc9e', '256', '0', '1', 'DJYE', '充值保证金1元', null, '5f81f127ab7d2037588e798704c988e4', '2', 'CZ', '2017-08-01 06:40:46', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('a17cd47bc1e0e078a76a851e4760f0b3', '340', '0', '2', 'YE', '微信支付订单', null, '1c1545cefa5e3424177a6acd50b549d5', '2', 'PM', '2017-08-16 09:32:10', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('a1858635ced15fac3d1e91a4b1d39b11', '270', '0', '1', 'DJYE', '充值保证金1元', null, '76b5d2f2061b9982c5f32dafb280cc17', '2', 'CZ', '2017-08-01 07:27:57', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('a22b3c1bb573182547d7edb23786acde', '0', '257', '1', 'YE', '余额充值', null, '0', '2', 'CZ', '2017-08-04 10:14:41', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('a288a6afba6886ca8204c934d3e16568', '273', '0', '1', 'YE', '余额支付订单', null, '0b322dd2dda5f4837df4d631a75e389e', '2', 'SG', '2017-08-07 05:46:37', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('a5f20fc14f51e11da6c70a8a863a365d', '258', '0', '2', 'YE', '余额支付订单', null, '5f0513b9f56c2e50d83b5d09d45a8703', '2', 'SG', '2017-08-02 06:34:33', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('a63e52c071029e35f7b1a796f231b000', '270', '0', '1', 'YE', '余额支付订单', null, 'd768fc71f9d53b6ed47a2ab165efe933', '2', 'SG', '2017-08-01 07:12:20', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('a6472d9a1b407d61f9db688d6e42f87b', '0', '258', '1', 'YE', '退还保证金1元', null, '95', '2', 'CZ', '2017-08-03 09:22:21', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('a65882f467888e70e0118cbdcf73e6b3', '258', '0', '100', 'DJYE', '充值保证金100元', null, 'b9378736dd3a130a4fb5909c0fe78973', '2', 'CZ', '2017-08-02 05:54:49', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('a75bce42959aa79df93c8d9ef491496e', '0', '256', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-10 09:19:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('a9cd45ae6dfd36c260528ae3926dc7b3', '258', '0', '1', 'DJYE', '充值保证金1元', null, '3841c06a313f8fc9012401f2ac4e9c09', '2', 'CZ', '2017-08-04 09:06:08', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('aad6bad5877c7858aaf019aaee113be7', '321', '0', '1', 'DJYE', '充值保证金1元', null, 'f433577e2bd03ed4d658654977fc9666', '2', 'CZ', '2017-08-04 07:45:36', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ac36033ccb915d4659cb5c904a3999f9', '322', '0', '1', 'YE', '余额支付订单', null, 'c46857e9466283c477bed27e1a68e5c5', '2', 'SG', '2017-08-08 06:32:30', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('ac8c5b15e2278a881ce624104f3b1e3d', '270', '0', '1', 'YE', '微信支付订单', null, '52ec3fc9edd8cc67c199f1421891a808', '2', 'SG', '2017-08-07 05:57:38', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('acec8cd84065efb74779ee03b31ae465', '330', '0', '1', 'YE', '微信支付订单', null, 'b6089ee0c906eda9b1c507c9cf61090b', '2', 'SG', '2017-08-04 09:54:19', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('ad038c3e71b7608e237e8a9d7ebcb0fe', '0', '271', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:55:45', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ad6bb92e366ad3fa69cf0bbec52354d0', '271', '0', '1', 'YE', '微信支付订单', null, '251aeed6916aae9f58584c0a0b7ff811', '2', 'SG', '2017-08-01 08:24:59', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('af3333065e5b581776e8b2be39c9676a', '329', '0', '1', 'DJYE', '充值保证金1元', null, '7422189b5d6bad50f54f668ab25ae72b', '2', 'CZ', '2017-08-07 09:06:14', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('af53516f08da5ca933891f5d751140ee', '329', '0', '2', 'YE', '微信支付订单', null, 'ad81f68726e37b41a77557deb94304c0', '2', 'PM', '2017-08-08 07:17:03', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('b08acf92fb7086a8e597188cd87a30d6', '0', '257', '1', 'YE', '退还保证金1元', null, '101', '2', 'CZ', '2017-08-08 06:05:22', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b21b2a763f9a5ff83848f6dbeca19e71', '0', '321', '1', 'YE', '微信支付订单', null, '321', '2', 'CZ', '2017-08-04 07:40:14', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b224f73398655458728babfc32fa9c3d', '4', '0', '1', 'DJYE', '缴纳保证金', null, '4312ab1b70e3421010ad66c229c3d391', '2', 'CZ', '2017-08-11 09:54:56', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b2a84eb232ef9534fc5ea7f730fe3382', '0', '257', '1', 'YE', '微信支付订单', null, '257', '2', 'CZ', '2017-08-04 02:32:07', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b35ab98adadb41913b281d3410bff43a', '0', '329', '1', 'YE', '微信支付订单', null, '329', '2', 'CZ', '2017-08-07 09:58:20', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b49e2ed6111f52e5018eb72895e63a82', '0', '273', '1', 'YE', '退还保证金1元', null, '94', '2', 'CZ', '2017-08-04 07:44:29', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b4cad8569403c5ebc78259a9628b9df7', '270', '0', '100', 'DJYE', '充值保证金100元', null, 'cfe9f99beb0b21ad0dd3a38210143ca3', '2', 'CZ', '2017-08-02 06:36:28', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b6690c8d2f21b71aca689e8c688a4c5d', '258', '0', '50000', 'DJYE', '充值保证金50000元', null, '0847e0805dbbaa6965b6312893d78bf7', '2', 'CZ', '2017-08-02 02:35:35', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b80c782b43c3c5a8511bc1afbd7f339f', '258', '0', '1', 'YE', '余额支付订单', null, '15fc11fcacc4c7b6747518139e2124f3', '2', 'SG', '2017-08-02 01:56:58', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('b8e5ca467a08f0c558b7632ac94301a7', '329', '0', '1', 'DJYE', '缴纳保证金', null, '97f263acdc78c1c0dbb6f5ad7f0c1e1b', '2', 'CZ', '2017-08-08 05:42:22', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('b9b4037956462292434aefb4609aef3c', '257', '0', '1', 'YE', '余额支付订单', null, 'ee24be2e2749febf8ccde7f9ffd40487', '2', 'SG', '2017-08-01 09:10:13', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('b9c67ba762e8469d6ad12e259cd36f92', '0', '340', '1', 'YE', '微信充值', null, '340', '2', 'CZ', '2017-08-14 09:28:53', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('bc1752829167167a43e78bb537f5b635', '0', '271', '1', 'YE', '微信支付订单', null, '271', '2', 'CZ', '2017-08-01 08:24:23', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c04f536ccb568be7b6a86d061d2cf4d2', '340', '0', '1', 'DJYE', '缴纳保证金', null, '92f4bc938ba84bbd783ae78170b681c4', '2', 'CZ', '2017-08-10 09:03:55', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c0daaf27d272d0e04a7057252e03b6b3', '256', '0', '1', 'DJYE', '充值保证金1元', null, '4e4052ff51de12a1507a56acb15e6401', '2', 'CZ', '2017-08-01 05:38:13', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c0e71cd1b4d1b247a6fa34b2fe2387ff', '0', '270', '1', 'YE', '微信支付订单', null, '270', '2', 'CZ', '2017-08-04 06:20:31', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c161eff2650349f2369e3ff8f54a1986', '322', '0', '1', 'DJYE', '缴纳保证金', null, 'a9b13b48b286b723093d0ed0c4b75aea', '2', 'CZ', '2017-08-10 09:06:13', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c174ceab3172d3cce63adc24a32b6242', '270', '0', '1', 'DJYE', '充值保证金1元', null, 'd2e59aadd44032ff854befe8f4b4a4c1', '2', 'CZ', '2017-08-04 09:05:51', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c2a4886d768a1acdc44a796ba64d57f6', '0', '330', '1', 'YE', '微信支付订单', null, '330', '2', 'CZ', '2017-08-04 09:34:37', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c2b7be94beb9cb7ae583c296e5a2bd6d', '257', '0', '1', 'DJYE', '充值保证金1元', null, '7a6aacf42b277e2c65cb5282f462ff43', '2', 'CZ', '2017-08-01 09:22:10', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c2bd8e95157e73a1a7971a35765b2ba7', '0', '340', '1', 'YE', '微信充值', null, '340', '2', 'CZ', '2017-08-11 09:57:38', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c8aa74f44adf326f98dc6b99879dd7ab', '270', '0', '3', 'YE', '余额支付订单', null, 'c3a3172f64665f16db741af8dd3c6c77', '2', 'PM', '2017-08-03 09:25:05', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('c8f966fec566e90e8273d88f09d1c44b', '270', '0', '1', 'DJYE', '充值保证金1元', null, '9e9078a37bc6d1dc613f194237cb4cf2', '2', 'CZ', '2017-08-07 09:55:54', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c96301acc05312ac68d1ce19816d2992', '0', '328', '1', 'YE', '微信支付订单', null, '328', '2', 'CZ', '2017-08-04 09:47:39', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('c9b5ce52bd438adb0615fc0767095752', '0', '270', '1', 'YE', '退还保证金1元', null, '80', '2', 'CZ', '2017-08-02 02:58:51', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('caaf24da06523fefb311510980d98c92', '4', '0', '1', 'YE', '微信支付订单', null, 'e15b7a2ea56da6d9693164023a020ec5', '2', 'SG', '2017-08-01 06:29:59', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('cabafa6ce9d7d3ce32bf227bd151486f', '256', '0', '1', 'DJYE', '充值保证金1元', null, '408d09ef392911951e44fd6cc58ca2fb', '2', 'CZ', '2017-08-01 08:43:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('cb5539068af402c99f763524fade2e7c', '4', '0', '1', 'YE', '微信支付订单', null, '9a9583d99d40c00fb8434102e638c31d', '2', 'SG', '2017-08-01 06:03:14', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('cc3974801adede28dcfdf1cdccac872a', '0', '256', '1', 'YE', '退还保证金1元', null, '80', '2', 'CZ', '2017-08-02 02:58:52', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('cc84c9b7780a7b2745ab1d1ca0978014', '0', '256', '1', 'YE', '微信充值', null, '256', '2', 'CZ', '2017-08-10 09:27:56', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ccc4933c55d79e616c9b277ec599a65f', '0', '270', '100', 'YE', '退还保证金100元', null, '91', '2', 'CZ', '2017-08-07 06:33:28', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('cd437be5257d0bf93545e85d989525a9', '0', '340', '1', 'YE', '微信充值', null, '340', '2', 'CZ', '2017-08-11 10:34:36', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ceb766f0f41e1c01d7c1f97c410c25a2', '4', '0', '1', 'YE', '微信支付订单', null, 'a02693ce49b620a32526b51b91ad23cc', '2', 'SG', '2017-08-01 06:22:04', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('cefafaacddfe66cde9509d3bcd045ef2', '340', '0', '2', 'YE', '微信支付订单', null, '20ffd44146678df21444385d247e0834', '2', 'PM', '2017-08-16 09:33:01', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('cf99b2c9d36da8e1a448a4fba174c862', '258', '0', '1', 'YE', '余额支付订单', null, '1ef50867e5d3f2480c54e64af230fac3', '2', 'SG', '2017-08-01 05:32:16', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('d05560f76874b5574300bff4e1e892a7', '0', '256', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:49:56', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d129cf1ca2175666816e53c41c5402f7', '0', '340', '5', 'YE', '微信充值', null, '340', '2', 'CZ', '2017-08-10 08:56:30', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d153dfba93ce902526cb5e01b7a45d1d', '256', '0', '100', 'DJYE', '充值保证金100元', null, '40716006e4b6c2957c28cd624218e3f4', '2', 'CZ', '2017-08-02 06:37:02', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d55346441a4ec52b6631c71e88091e83', '0', '321', '1', 'YE', '微信充值', null, '321', '2', 'CZ', '2017-08-07 10:10:09', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d556ab64ef23082c549650d0f2e5bdf6', '256', '0', '1', 'DJYE', '缴纳保证金', null, 'd50bc01e28598a0499cce908bd122bb3', '2', 'CZ', '2017-08-10 09:10:37', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d5f5155c938da727e86fa5020c1af302', '0', '258', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:49:56', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d6105765c5d3c8c845b9cf0bda728770', '258', '0', '1', 'DJYE', '充值保证金1元', null, '8f7234fb00f40192828a8689c8a16e94', '2', 'CZ', '2017-08-04 06:47:45', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d6abfcc5b3a6b78c63d15d2df50052bc', '331', '0', '1', 'YE', '微信支付订单', null, '01fde0981083e1594f81354ae78c7932', '2', 'SG', '2017-08-16 00:37:39', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('d74ffbe91227cc583acaf4b03b3a8808', '0', '321', '1', 'YE', '微信充值', null, '321', '2', 'CZ', '2017-08-09 10:04:04', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d80c650c4bb4e24b4ad27bf820e80f2a', '0', '270', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:54:40', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d8a5cdd6516ff82887be903db65a087f', '0', '271', '1', 'YE', '微信支付订单', null, '271', '2', 'CZ', '2017-08-01 08:22:34', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d8ad20edf557859c474692cc6e9950ea', '0', '258', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:54:39', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('d952cddc7c0fa4966c776d3e2ab703a0', '4', '0', '1', 'DJYE', '缴纳保证金', null, 'a4c18cc313747b0b85ca2b96bde411e7', '2', 'CZ', '2017-08-11 10:04:56', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('db7d03afaec13ef22e2f4d802ce5b955', '257', '0', '1', 'YE', '微信支付订单', null, '8e861a7e3d6d4c651e6a70eaaf93323d', '2', 'SG', '2017-08-11 10:31:02', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('db89fc3b7ca765c966ccbceffb0382d8', '0', '4', '500', 'YE', '退还保证金', null, '104', '2', 'CZ', '2017-08-10 10:49:42', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('dc93cb0902fc4f20c0d6ceb75ad518d5', '0', '4', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-10 09:19:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('dcb8c9a11b383416617c27da211ab7a1', '270', '0', '3', 'YE', '余额支付订单', null, '09ef5134ae95cb6df0004e877d85210c', '2', 'PM', '2017-08-03 09:03:55', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('de014db7703918fc440b630679ba653a', '258', '0', '1', 'DJYE', '充值保证金1元', null, '60f53ec96cb63d0ec72f73454b54fbc0', '2', 'CZ', '2017-08-01 07:27:37', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('de84076e137d547f332cccd61cce6703', '0', '328', '1', 'YE', '微信支付订单', null, '328', '2', 'CZ', '2017-08-04 09:51:35', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('dfdf6d3237bd54156932e41ba6ee80d5', '257', '0', '1', 'YE', '微信支付订单', null, '80d8625ca59ec4f73b336b8d24919ffb', '2', 'SG', '2017-08-11 10:34:08', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('e108fdb7522ca119f348906c1dabbca0', '0', '328', '1', 'YE', '微信支付订单', null, '328', '2', 'CZ', '2017-08-04 09:53:32', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('e1caeb4e835ebdd0f277267894e9a1dc', '273', '0', '1', 'DJYE', '充值保证金1元', null, '81e6a1c9e54f61b42e48f260b1576f5a', '2', 'CZ', '2017-08-03 08:54:12', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('e2a834e03ab24e4a756ee6e06d195b35', '329', '0', '37', 'YE', '微信支付订单', null, 'f49c5d17083ac233a08374b2eca33e54', '2', 'PM', '2017-08-07 06:40:37', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('e6f85b02a673b4b546ca14a0de47243d', '0', '270', '1', 'YE', '退还保证金1元', null, '92', '2', 'CZ', '2017-08-03 07:32:35', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('e71a1244f27609ccf4354d6df2f02da1', '0', '340', '1', 'YE', '微信充值', null, '340', '2', 'CZ', '2017-08-11 09:58:34', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('e7362b0913a342a4e90d566e51a4f812', '0', '271', '1', 'YE', '微信支付订单', null, '271', '2', 'CZ', '2017-08-01 08:42:02', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('e7ab3046b53996ce16fe468b73210937', '0', '331', '1', 'YE', '微信充值', null, '331', '2', 'CZ', '2017-08-14 03:19:14', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ebb04340b1ef3ac525cf8acd29aeb852', '256', '0', '1', 'YE', '余额支付订单', null, '7be11cffc192aa36aec672609f3d6257', '2', 'SG', '2017-08-02 06:39:42', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('ebbbfd3caf5b336f15541600616d4886', '270', '0', '4000', 'DJYE', '充值保证金4000元', null, '182877cf6683a230eb157e82b890f326', '2', 'CZ', '2017-08-01 08:44:15', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ebfec3218f9806357f7d35cc195b298f', '270', '0', '1', 'DJYE', '充值保证金1元', null, '722384f42629697c62569ef9151893c9', '2', 'CZ', '2017-08-07 05:29:34', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ec58475508d35145ecd7cd5292233fe8', '0', '273', '2', 'YE', '微信支付订单', null, '273', '2', 'CZ', '2017-08-07 06:00:41', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ece615e0001816ca4b76139d92e96dcf', '326', '0', '1', 'DJYE', '充值保证金1元', null, '71658e5de6b9e8c01a9f49a5836dca5c', '2', 'CZ', '2017-08-04 09:00:32', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ed467c1cdf069dea7faf5ffc62c39f5e', '273', '0', '1', 'YE', '微信支付订单', null, '3ed49857cd4ee66def917fbe4b07574b', '2', 'SG', '2017-08-03 07:17:37', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('ef6c9ed152d4dd93a9b4b4384ca8c18a', '0', '257', '100', 'YE', '余额充值', null, '0', '2', 'CZ', '2017-08-04 09:11:07', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ef788fc4f797e4d48a03ea358fde0312', '0', '329', '1', 'YE', '退还保证金1元', null, '97', '2', 'CZ', '2017-08-07 05:57:49', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f03ca533134dbb27fc2af05765bda9e5', '273', '0', '1', 'YE', '微信支付订单', null, '7fd236b696a72cfde867c57ee1bd7c12', '2', 'SG', '2017-08-07 05:48:38', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('f248bbcd4eac63a50d884d3d49c9c4bb', '270', '0', '2', 'YE', '余额支付订单', null, 'df268f6bc14467bf438f5c86168b45b9', '2', 'PM', '2017-08-22 09:49:00', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('f2c4f9e8af54c2749156cdf4ffea555d', '0', '329', '1', 'YE', '退还保证金', null, '98', '2', 'CZ', '2017-08-09 05:21:42', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f3314f2a78636125302c5071b232303c', '0', '271', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:55:04', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f414421f4b2a521221ef18e46f9d42e9', '0', '271', '1', 'YE', '退还保证金1元', null, '79', '2', 'CZ', '2017-08-02 02:56:12', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f58152b03b0c334a9f9f0cf60953c400', '339', '0', '1', 'DJYE', '缴纳保证金', null, 'f77b586727deb8688dec0ab3cfb2be25', '2', 'CZ', '2017-08-15 08:04:16', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f5867d4ebb5505ab42dee5cca7ae2ca0', '0', '326', '1', 'YE', '微信支付订单', null, '326', '2', 'CZ', '2017-08-04 08:45:05', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f5a1200c39129a014acadbdab146aeec', '0', '256', '1', 'YE', '微信支付订单', null, '256', '2', 'CZ', '2017-08-03 10:12:58', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f6ff8d9b7629666c863ecc5c6eb59709', '4', '0', '1', 'DJYE', '缴纳保证金', null, 'de869e1d17d51a54b3cda0fc4d4cc46d', '2', 'CZ', '2017-08-10 09:09:27', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f7e5d51d0159b734a025302473aac531', '270', '0', '1', 'YE', '余额支付订单', null, '06cbfd01c19ec94278bc4fd03dcdf0ed', '2', 'SG', '2017-08-02 06:48:21', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('f97b5a113785dffe512740cb0e1445f6', '3', '0', '1', 'DJYE', '缴纳保证金', null, '2f061877e06d72058030361d2e1244ad', '2', 'CZ', '2017-08-15 02:49:13', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('f993d2be14a9fbf49a00e5eb48874c7d', '0', '257', '1', 'YE', '微信充值', null, '257', '2', 'CZ', '2017-08-07 10:11:58', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('fa0125fec0e1f8dd76370d326c0c54c3', '340', '0', '1', 'YE', '余额支付订单', null, 'c77e18c5eb12632c2be1d1434e46de84', '2', 'SG', '2017-08-12 02:17:57', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('fb1aae626759ad1467c52bf5fa9ad2e2', '0', '329', '1', 'YE', '微信支付订单', null, '329', '2', 'CZ', '2017-08-07 10:06:38', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('fcfccbc8552712a2043f0fa7664f7901', '0', '273', '1', 'YE', '微信支付订单', null, '273', '2', 'CZ', '2017-08-03 06:59:25', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('fd0cc12514942e0d62e53fe03e1f7fdd', '270', '0', '1', 'DJYE', '充值保证金1元', null, 'ceb20da756c3d0132dd77db277025eda', '2', 'CZ', '2017-08-03 06:58:05', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('fd0d3c142f4b0718724d66979987ab72', '4', '0', '1', 'YE', '微信支付订单', null, '9b54afb62527606c3f1733c9c57affe3', '2', 'SG', '2017-08-01 06:31:12', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('fd8032742822118602c6408bfcbfd7a2', '331', '0', '1', 'YE', '微信支付订单', null, '96db8d8ab3b54469b969ef0f596a22ce', '2', 'SG', '2017-08-16 00:46:17', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('fe042aefb8ab02041bbd2fa0f5b35939', '0', '339', '1', 'YE', '微信充值', null, '339', '2', 'CZ', '2017-08-15 08:01:23', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('fe550babef61f8fe694f698b160199ba', '0', '270', '1', 'YE', '退还保证金1元', null, '80', '2', 'CZ', '2017-08-02 03:00:18', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('ff24939e50dd985ab346b3b1b3e203a3', '0', '257', '1', 'YE', '余额充值', null, '0', '2', 'CZ', '2017-08-04 10:27:46', '0', '2');

-- ----------------------------
-- Table structure for `opa_withdraw`
-- ----------------------------
DROP TABLE IF EXISTS `opa_withdraw`;
CREATE TABLE `opa_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` decimal(16,0) DEFAULT '0' COMMENT '提现金额',
  `type` char(2) DEFAULT NULL COMMENT 'Z-支付宝 W-微信 Y-银行',
  `bankname` varchar(80) DEFAULT NULL COMMENT '银行名字',
  `bankdeposit` varchar(80) DEFAULT NULL COMMENT '开户行',
  `account` varchar(50) DEFAULT NULL COMMENT '帐号',
  `ischeck` int(1) DEFAULT '2' COMMENT '2初始 1审核通过 3不通过',
  `isdone` int(1) DEFAULT '2' COMMENT '2初始 1提成功 3 不成功',
  `error` varchar(100) DEFAULT NULL COMMENT '描述',
  `createat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='提现申请';

-- ----------------------------
-- Records of opa_withdraw
-- ----------------------------
INSERT INTO `opa_withdraw` VALUES ('42', '3', 'W', 'W', 'W', '6217001870000319078', '2', '2', null, '2017-08-03 09:06:53', '270');
INSERT INTO `opa_withdraw` VALUES ('43', '1', 'W', 'W', 'W', '18650728487', '2', '2', null, '2017-08-04 07:30:39', '273');
INSERT INTO `opa_withdraw` VALUES ('44', '1', 'Y', '还好还好', 'v宝贝', '6227001820508895', '2', '2', null, '2017-08-09 10:04:57', '321');
INSERT INTO `opa_withdraw` VALUES ('45', '1', 'Z', 'Z', 'Z', '558565', '2', '2', null, '2017-08-10 09:01:47', '340');
