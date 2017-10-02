/*
Navicat MySQL Data Transfer

Source Server         : 本地连接
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : op_pay

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-28 14:47:20
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `opa_wallet_action` VALUES ('571d5588afc4db932a32fadb2022a75d', '270', '0', '1', 'YE', '余额支付订单', null, '7200d835c90e27131b9113212504b6b1', '2', 'SG', '2017-08-25 06:52:12', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('5794c95379ed1b393aeb1a8989060c0d', '4', '0', '1', 'DJYE', '缴纳保证金', null, 'T', '2', 'CZ', '2017-08-10 09:44:41', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('58101cc37509dbf06ba9bf2ef2e9123c', '270', '0', '1', 'YE', '微信支付订单', null, '531a86075b89d88efa69ef6b0bcefd7c', '2', 'SG', '2017-08-01 06:12:17', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('58661892647bf8b332c1f146b020ff47', '0', '329', '1', 'YE', '微信支付订单', null, '329', '2', 'CZ', '2017-08-07 06:24:35', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('589101daededa0fb215360bf6e15f3e3', '329', '0', '1', 'DJYE', '缴纳保证金', null, '5437318d230e8504774ebfd27e9e681f', '2', 'CZ', '2017-08-21 08:33:16', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('58a2c15640d8f72a1741f57414b74f18', '0', '270', '1', 'YE', '微信支付订单', null, '270', '2', 'CZ', '2017-08-03 09:04:57', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('5958ead68187a73698d1d537d6bf766e', '0', '4', '1', 'YE', '退还保证金', null, '108', '2', 'CZ', '2017-08-11 00:58:31', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('59ef42d731626a22a01551ed99cc5db0', '329', '0', '1', 'DJYE', '缴纳保证金', null, 'd26df4b4341685e7f29632ced6fdbfe3', '2', 'CZ', '2017-08-24 03:13:26', '0', '2');
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
INSERT INTO `opa_wallet_action` VALUES ('742ce17789462b664f5010ae4b080b34', '270', '0', '1', 'DJYE', '缴纳保证金', null, 'a30a551a3855dad57c831cce07407fd2', '2', 'CZ', '2017-08-25 01:26:46', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('746fd8283a574fa685aa5a3834d9e304', '329', '0', '2', 'DJYE', '缴纳保证金', null, 'a54729be3d43ece0f6449213452d330b', '2', 'CZ', '2017-08-21 09:37:28', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('7508ccf58c3e48dc17795048f79c3cd9', '257', '0', '100', 'YE', '余额支付订单', null, 'cf27c4f8d68f020d4be99c44adfad7a8', '2', 'SG', '2017-08-30 02:47:16', '0', '1');
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
INSERT INTO `opa_wallet_action` VALUES ('7f2834d6707cc133a29d9cbe2c674ae9', '257', '0', '1', 'DJYE', '缴纳保证金', null, 'f91ae18150bfb4a3be90fef02f3b5374', '2', 'CZ', '2017-08-25 09:02:15', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('81d0cbf23bc476952d47e9f8a1ce6356', '0', '270', '1', 'YE', '微信支付订单', null, '270', '2', 'CZ', '2017-08-04 07:23:33', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('829409d0d8bce534f6bede3ef44c9a5e', '4', '0', '1', 'YE', '微信支付订单', null, '3ea87d399447748a0f44423ecfeedbd8', '2', 'SG', '2017-08-01 06:04:01', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('8359d9c1c31a27137fb966a6900dd4ad', '257', '0', '15600', 'YE', '余额支付订单', null, 'd815061b9a09f95ab5e2a10a9efe4a33', '2', 'SG', '2017-08-30 01:48:42', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('855ea4af565e706076b3e37a1d4bce17', '0', '0', '1', 'DJYE', '充值保证金1元', null, '347a97938d60a49597cb9abcd42efb3d', '2', 'CZ', '2017-08-04 07:21:44', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('85f98fd066ee0f63d70b4d89fe981667', '0', '270', '1', 'YE', '微信支付订单', null, '270', '2', 'CZ', '2017-08-04 06:20:52', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('86f19a22dfacbe78f3dbdf419256321e', '270', '0', '1', 'DJYE', '充值保证金1元', null, 'd8f43d407ba342f448218bf32c667fbe', '2', 'CZ', '2017-08-01 03:05:39', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('875041b1b4160846289a31d601c7d86d', '256', '0', '1', 'YE', '余额支付订单', null, '7bb8d6f0b6dc228ddd195fbc2b46179d', '2', 'SG', '2017-07-31 13:12:48', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('87b0ed00b35e4f105a4f4a6bdadbea77', '340', '0', '1', 'YE', '余额支付订单', null, '834209e0bc2ce520d94ba3452288d993', '2', 'SG', '2017-08-16 09:29:33', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('87e0785b4cb9ca360efbaf50ce253818', '256', '0', '100', 'YE', '余额支付订单', null, '96877f4978f4ab452085ca37e54008ae', '2', 'SG', '2017-08-10 09:13:08', '0', '1');
INSERT INTO `opa_wallet_action` VALUES ('893a034579f108e6b84a72df4a6e7164', '0', '4', '100', 'YE', '退还保证金', null, '106', '2', 'CZ', '2017-08-10 09:19:43', '0', '2');
INSERT INTO `opa_wallet_action` VALUES ('8a229e8216ccad75d82a0af6a85d7a6f', '270', '0', '1', 'DJYE', '缴纳保证金', null, '907aa6caea7f59aafd2d8ca650ca02c3', '2', 'CZ', '2017-08-24 03:15:20', '0', '2');
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
INSERT INTO `opa_wallet_action` VALUES ('aded8a67569636a716ca272fd01969ac', '257', '0', '1', 'DJYE', '缴纳保证金', null, 'd5150ef07761887c5294527df49ad0ed', '2', 'CZ', '2017-08-25 09:07:01', '0', '2');
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
INSERT INTO `opa_wallet_action` VALUES ('f92d1fd49a415b70b5597f6ce04b0e09', '257', '0', '1', 'DJYE', '缴纳保证金', null, 'a670cdb8efde57ba48ce0d34fe5b6877', '2', 'CZ', '2017-08-30 01:23:54', '0', '2');
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
