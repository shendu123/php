/*
Navicat MySQL Data Transfer

Source Server         : linux_open
Source Server Version : 50628
Source Host           : 192.168.71.236:3306
Source Database       : op_message

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-09-15 17:54:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `opm_app_msg`
-- ----------------------------
DROP TABLE IF EXISTS `opm_app_msg`;
CREATE TABLE `opm_app_msg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '消息id',
  `msg_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '消息类型: 0系统 1消费',
  `msg_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '消息发送者id: 0系统 msg_type=1时为商户id',
  `msg_receive_id` int(11) NOT NULL DEFAULT '0' COMMENT '接收者id',
  `msg_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '消息状态: 0未读 1已读 2删除',
  `msg_title` varchar(64) NOT NULL DEFAULT '' COMMENT '消息标题',
  `msg_content` varchar(512) NOT NULL DEFAULT '' COMMENT '消息内容',
  `msg_link` varchar(128) NOT NULL DEFAULT '' COMMENT '消息链接',
  `msg_attach` varchar(256) NOT NULL DEFAULT '' COMMENT '消息附加参数',
  `msg_intime` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='app推送信息记录表';

-- ----------------------------
-- Records of opm_app_msg
-- ----------------------------
INSERT INTO `opm_app_msg` VALUES ('1', '0', '0', '259', '0', '测试消息标题1', '测试消息内容1', '', '', '1503999108');
INSERT INTO `opm_app_msg` VALUES ('2', '0', '0', '259', '0', '测试消息标题1', '测试消息内容1', '', '', '1503999346');
INSERT INTO `opm_app_msg` VALUES ('3', '0', '0', '0', '0', '测试消息标题1', '测试消息内容1', '', '', '1504000269');
INSERT INTO `opm_app_msg` VALUES ('4', '0', '0', '0', '0', '测试消息标题1', '测试消息内容1', '', '', '1504000355');
INSERT INTO `opm_app_msg` VALUES ('5', '0', '0', '0', '0', '测试消息标题1', '测试消息内容1', '', '', '1504000414');
INSERT INTO `opm_app_msg` VALUES ('6', '0', '0', '1', '0', '测试消息标题1', '测试消息内容1', '', '', '1504000432');
INSERT INTO `opm_app_msg` VALUES ('7', '0', '0', '0', '0', '测试消息标题1', '测试消息内容1', '', '', '1504000445');
INSERT INTO `opm_app_msg` VALUES ('8', '0', '0', '0', '0', '测试消息标题1', '测试消息内容1', '', '', '1504000555');
INSERT INTO `opm_app_msg` VALUES ('9', '0', '0', '0', '0', '测试消息标题1', '测试消息内容1', '', '', '1504000728');
INSERT INTO `opm_app_msg` VALUES ('10', '0', '0', '259', '0', '测试消息标题1', '测试消息内容1', '', '', '1504000749');

-- ----------------------------
-- Table structure for `opm_group_chatlog`
-- ----------------------------
DROP TABLE IF EXISTS `opm_group_chatlog`;
CREATE TABLE `opm_group_chatlog` (
  `chat_id` bigint(32) NOT NULL COMMENT '聊天记录id',
  `chat_sender_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '发送者类型 1user 2business 3system',
  `chat_senderid` int(11) NOT NULL DEFAULT '0' COMMENT '发送者人',
  `chat_groupid` int(11) NOT NULL DEFAULT '0' COMMENT '群id',
  `chat_stuff_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '业务类型 1拍卖 2申购 3自由买卖',
  `chat_stuff_id` int(11) NOT NULL DEFAULT '0' COMMENT '业务类型id',
  `chat_content` varchar(512) NOT NULL DEFAULT '' COMMENT '【长度限制】单条聊天内容',
  `chat_intime` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群聊天记录表';

-- ----------------------------
-- Records of opm_group_chatlog
-- ----------------------------

-- ----------------------------
-- Table structure for `opm_single_chatlog`
-- ----------------------------
DROP TABLE IF EXISTS `opm_single_chatlog`;
CREATE TABLE `opm_single_chatlog` (
  `chat_id` bigint(32) NOT NULL AUTO_INCREMENT COMMENT '聊天记录id',
  `chat_sender_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '发送者类型 1user 2business 3system',
  `chat_senderid` int(11) NOT NULL DEFAULT '0' COMMENT '发送者人id 对应user_id 若为商户取rule_type = 95 对应的user_id',
  `chat_receiver_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '接收者类型 1user 2business 3system',
  `chat_receiverid` int(11) NOT NULL DEFAULT '0' COMMENT '接收者id 对应user_id 若为商户取rule_type = 95 对应的user_id',
  `chat_stuff_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '业务类型 0闲聊 1拍卖 2申购 3自由买卖',
  `chat_stuff_id` int(11) NOT NULL DEFAULT '0' COMMENT '业务id',
  `chat_content` varchar(512) NOT NULL DEFAULT '' COMMENT '【长度限制】单条聊天内容',
  `chat_isread` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否已读 0未读 1已读',
  `chat_intime` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='单对单聊天记录表';

-- ----------------------------
-- Records of opm_single_chatlog
-- ----------------------------
INSERT INTO `opm_single_chatlog` VALUES ('2', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:26:\"sadfsadfasdfasdfdsasdfsadf\";}', '0', '1503913456');
INSERT INTO `opm_single_chatlog` VALUES ('3', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:26:\"sadfsadfasdfasdfdsasdfsadf\";}', '0', '1503974090');
INSERT INTO `opm_single_chatlog` VALUES ('4', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:26:\"sadfsadfasdfasdfdsasdfsadf\";}', '0', '1503974152');
INSERT INTO `opm_single_chatlog` VALUES ('5', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:26:\"sadfsadfasdfasdfdsasdfsadf\";}', '0', '1503974253');
INSERT INTO `opm_single_chatlog` VALUES ('6', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:26:\"sadfsadfasdfasdfdsasdfsadf\";}', '0', '1503974331');
INSERT INTO `opm_single_chatlog` VALUES ('7', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:26:\"sadfsadfasdfasdfdsasdfsadf\";}', '0', '1503974587');
INSERT INTO `opm_single_chatlog` VALUES ('8', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:26:\"sadfsadfasdfasdfdsasdfsadf\";}', '0', '1503975661');
INSERT INTO `opm_single_chatlog` VALUES ('9', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"buyer say hello to business\";}', '0', '1503976213');
INSERT INTO `opm_single_chatlog` VALUES ('10', '2', '1', '1', '259', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"business say hello to buyer\";}', '0', '1503976229');
INSERT INTO `opm_single_chatlog` VALUES ('11', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"buyer say hello to business\";}', '0', '1503977351');
INSERT INTO `opm_single_chatlog` VALUES ('12', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"buyer say hello to business\";}', '0', '1503977355');
INSERT INTO `opm_single_chatlog` VALUES ('13', '2', '1', '1', '259', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"business say hello to buyer\";}', '0', '1503977399');
INSERT INTO `opm_single_chatlog` VALUES ('14', '2', '1', '1', '259', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"business say hello to buyer\";}', '0', '1503977402');
INSERT INTO `opm_single_chatlog` VALUES ('15', '2', '1', '1', '259', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"business say hello to buyer\";}', '0', '1503977406');
INSERT INTO `opm_single_chatlog` VALUES ('16', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"buyer say hello to business\";}', '0', '1504010639');
INSERT INTO `opm_single_chatlog` VALUES ('17', '2', '1', '1', '259', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"business say hello to buyer\";}', '0', '1504010673');
INSERT INTO `opm_single_chatlog` VALUES ('18', '1', '259', '2', '1', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"buyer say hello to business\";}', '0', '1504765628');
INSERT INTO `opm_single_chatlog` VALUES ('19', '2', '1', '1', '259', '1', '100', 'a:2:{s:4:\"type\";s:1:\"1\";s:7:\"content\";s:27:\"business say hello to buyer\";}', '0', '1504765638');

-- ----------------------------
-- Table structure for `opm_site_msg`
-- ----------------------------
DROP TABLE IF EXISTS `opm_site_msg`;
CREATE TABLE `opm_site_msg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '站内信id',
  `msg_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '站内信类型: 0系统 1消费',
  `msg_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '站内信发送者id: 0系统 msg_type=1时为商户id',
  `msg_receive_id` int(11) NOT NULL DEFAULT '0' COMMENT '接收者id',
  `msg_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '站内信状态: 0未读 1已读 2删除',
  `msg_title` varchar(64) NOT NULL DEFAULT '' COMMENT '站内信标题',
  `msg_content` varchar(256) NOT NULL DEFAULT '' COMMENT '站内信内容',
  `msg_link` varchar(128) NOT NULL DEFAULT '' COMMENT '信息链接',
  `msg_intime` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站内信表';

-- ----------------------------
-- Records of opm_site_msg
-- ----------------------------

-- ----------------------------
-- Table structure for `opm_sms`
-- ----------------------------
DROP TABLE IF EXISTS `opm_sms`;
CREATE TABLE `opm_sms` (
  `sms_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '短信id',
  `sms_channel` tinyint(3) NOT NULL DEFAULT '0' COMMENT '短信渠道: 0阿里 1极光',
  `sms_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '短信类型: 0系统 1消费 2验证码',
  `sms_receive_id` int(11) NOT NULL DEFAULT '0' COMMENT '接收者id',
  `sms_mobile` varchar(32) NOT NULL DEFAULT '' COMMENT '接收时的手机号码',
  `sms_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '发送状态: 0成功 1发送失败 10已验证',
  `sms_title` varchar(64) NOT NULL DEFAULT '' COMMENT '短信标题',
  `sms_content` varchar(256) NOT NULL DEFAULT '' COMMENT '短信内容',
  `sms_failed_reason` varchar(128) NOT NULL DEFAULT '' COMMENT '发送失败原因',
  `sms_outtime` int(11) NOT NULL DEFAULT '0' COMMENT '失效时间',
  `sms_intime` int(11) NOT NULL DEFAULT '0' COMMENT '短信发送时间',
  PRIMARY KEY (`sms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8 COMMENT='短信发送记录表';

-- ----------------------------
-- Records of opm_sms
-- ----------------------------
INSERT INTO `opm_sms` VALUES ('1', '0', '2', '0', '18650723093', '0', 'zhuce', '0999', '', '1501235698', '1501235398');
INSERT INTO `opm_sms` VALUES ('2', '0', '2', '0', '18650723093', '0', 'zhuce', '2456', '', '1501465518', '1501465218');
INSERT INTO `opm_sms` VALUES ('3', '0', '2', '0', '18650723093', '0', 'zhuce', '0269', '', '1501468349', '1501468049');
INSERT INTO `opm_sms` VALUES ('4', '0', '2', '0', '18650723093', '0', 'zhuce', '2909', '', '1501468752', '1501468452');
INSERT INTO `opm_sms` VALUES ('5', '0', '2', '0', '18650723093', '10', 'zhuce', '9089', '', '1501556322', '1501556022');
INSERT INTO `opm_sms` VALUES ('6', '0', '2', '0', '18350070534', '0', 'zhuce', '9290', '', '1501743401', '1501743101');
INSERT INTO `opm_sms` VALUES ('7', '0', '2', '0', '18350070534', '0', 'zhuce', '3686', '', '1501746509', '1501746209');
INSERT INTO `opm_sms` VALUES ('8', '0', '2', '0', '18350070531', '0', 'zhuce', '8189', '', '1502697315', '1502697015');
INSERT INTO `opm_sms` VALUES ('9', '0', '2', '0', '18350070534', '10', 'zhuce', '9962', '', '1503468586', '1503468286');
INSERT INTO `opm_sms` VALUES ('10', '0', '2', '0', '18350070531', '0', 'zhuce', '2039', '', '1503472059', '1503471759');
INSERT INTO `opm_sms` VALUES ('11', '0', '2', '0', '13350070531', '0', 'zhuce', '1610', '', '1503472231', '1503471931');
INSERT INTO `opm_sms` VALUES ('12', '0', '2', '0', '18350070534', '0', 'zhuce', '9898', '', '1503472541', '1503472241');
INSERT INTO `opm_sms` VALUES ('13', '0', '2', '0', '18350070534', '0', 'zhuce', '0299', '', '1503474753', '1503474453');
INSERT INTO `opm_sms` VALUES ('14', '0', '2', '0', '18350070534', '0', 'zhuce', '8679', '', '1503475886', '1503475586');
INSERT INTO `opm_sms` VALUES ('15', '0', '2', '0', '18350070532', '0', 'zhuce', '9099', '', '1503476225', '1503475925');
INSERT INTO `opm_sms` VALUES ('16', '0', '2', '0', '18350070534', '0', 'zhuce', '9689', '', '1503476871', '1503476571');
INSERT INTO `opm_sms` VALUES ('17', '0', '2', '0', '18350070534', '10', 'zhuce', '2689', '', '1503477378', '1503477078');
INSERT INTO `opm_sms` VALUES ('18', '0', '2', '0', '18350070534', '10', 'zhuce', '9900', '', '1503478115', '1503477815');
INSERT INTO `opm_sms` VALUES ('19', '0', '2', '0', '18350070534', '0', 'zhuce', '2990', '', '1503478533', '1503478233');
INSERT INTO `opm_sms` VALUES ('20', '0', '2', '0', '18350070534', '10', 'zhuce', '8896', '', '1503478861', '1503478561');
INSERT INTO `opm_sms` VALUES ('21', '0', '2', '0', '18350070534', '10', 'zhuce', '0808', '', '1503482718', '1503482418');
INSERT INTO `opm_sms` VALUES ('22', '0', '2', '0', '18350070534', '0', 'zhuce', '2796', '', '1503483300', '1503483000');
INSERT INTO `opm_sms` VALUES ('23', '0', '2', '0', '18350070534', '0', 'zhuce', '3399', '', '1503483996', '1503483696');
INSERT INTO `opm_sms` VALUES ('24', '0', '2', '0', '18350070534', '0', 'zhuce', '9980', '', '1503484438', '1503484138');
INSERT INTO `opm_sms` VALUES ('25', '0', '2', '0', '18350070534', '0', 'zhuce', '9809', '', '1503485161', '1503484861');
INSERT INTO `opm_sms` VALUES ('26', '0', '2', '0', '18350070520', '0', 'zhuce', '9635', '', '1503485330', '1503485030');
INSERT INTO `opm_sms` VALUES ('27', '0', '2', '0', '18350070534', '0', 'zhuce', '6999', '', '1503485475', '1503485175');
INSERT INTO `opm_sms` VALUES ('28', '0', '2', '0', '18350070534', '0', 'zhuce', '6882', '', '1503537992', '1503537692');
INSERT INTO `opm_sms` VALUES ('29', '0', '2', '0', '18350070534', '0', 'zhuce', '6089', '', '1503542195', '1503541895');
INSERT INTO `opm_sms` VALUES ('30', '0', '2', '0', '18350070521', '0', 'zhuce', '6879', '', '1503542480', '1503542180');
INSERT INTO `opm_sms` VALUES ('31', '0', '2', '0', '18350052322', '0', 'zhuce', '2929', '', '1503543514', '1503543214');
INSERT INTO `opm_sms` VALUES ('32', '0', '2', '0', '18350070534', '0', 'zhuce', '9266', '', '1503646398', '1503646098');
INSERT INTO `opm_sms` VALUES ('33', '0', '2', '0', '18350070534', '10', 'zhuce', '9880', '', '1503646951', '1503646651');
INSERT INTO `opm_sms` VALUES ('34', '0', '2', '0', '18350070534', '10', 'zhuce', '9226', '', '1503647278', '1503646978');
INSERT INTO `opm_sms` VALUES ('35', '0', '2', '0', '18350070534', '10', 'zhuce', '6620', '', '1503647627', '1503647327');
INSERT INTO `opm_sms` VALUES ('36', '0', '2', '0', '18350070534', '10', 'zhuce', '9929', '', '1503649256', '1503648956');
INSERT INTO `opm_sms` VALUES ('37', '0', '2', '0', '18350070534', '0', 'zhuce', '0928', '', '1503649587', '1503649287');
INSERT INTO `opm_sms` VALUES ('38', '0', '2', '0', '18350070534', '10', 'zhuce', '6968', '', '1503653515', '1503653215');
INSERT INTO `opm_sms` VALUES ('39', '0', '2', '0', '18350070534', '10', 'zhuce', '9902', '', '1503654059', '1503653759');
INSERT INTO `opm_sms` VALUES ('40', '0', '2', '0', '18350070534', '0', 'zhuce', '9888', '', '1503885492', '1503885192');
INSERT INTO `opm_sms` VALUES ('41', '0', '2', '0', '18350070534', '10', 'xiugai', '0968', '', '1503897555', '1503897255');
INSERT INTO `opm_sms` VALUES ('42', '0', '2', '0', '18350070534', '10', 'zhuce', '6688', '', '1503898551', '1503898251');
INSERT INTO `opm_sms` VALUES ('43', '0', '2', '0', '18350070534', '10', 'xiugai', '9586', '', '1503898929', '1503898629');
INSERT INTO `opm_sms` VALUES ('44', '0', '2', '0', '18350070534', '10', 'xiugai', '0536', '', '1503899252', '1503898952');
INSERT INTO `opm_sms` VALUES ('45', '0', '2', '0', '18350070534', '10', 'xiugai', '9698', '', '1503899602', '1503899302');
INSERT INTO `opm_sms` VALUES ('46', '0', '2', '0', '18350070534', '0', 'xiugai', '2080', '', '1503900071', '1503899771');
INSERT INTO `opm_sms` VALUES ('47', '0', '2', '0', '18350070534', '0', 'xiugai', '2680', '', '1503900498', '1503900198');
INSERT INTO `opm_sms` VALUES ('48', '0', '2', '0', '18350070534', '10', 'xiugai', '8681', '', '1503901382', '1503901082');
INSERT INTO `opm_sms` VALUES ('49', '0', '2', '0', '18350070534', '10', 'xiugai', '9999', '', '1503901817', '1503901517');
INSERT INTO `opm_sms` VALUES ('50', '0', '2', '0', '18350070534', '10', 'xiugai', '9972', '', '1503902174', '1503901874');
INSERT INTO `opm_sms` VALUES ('51', '0', '2', '0', '18350070534', '10', 'xiugai', '2206', '', '1503902702', '1503902402');
INSERT INTO `opm_sms` VALUES ('52', '0', '2', '0', '18350070534', '0', 'xiugai', '2602', '', '1503903276', '1503902976');
INSERT INTO `opm_sms` VALUES ('53', '0', '2', '0', '18350070534', '0', 'xiugai', '6299', '', '1503903621', '1503903321');
INSERT INTO `opm_sms` VALUES ('54', '0', '2', '0', '18350070534', '0', 'xiugai', '9689', '', '1503903950', '1503903650');
INSERT INTO `opm_sms` VALUES ('55', '0', '2', '0', '18350070534', '0', 'xiugai', '3956', '', '1503904581', '1503904281');
INSERT INTO `opm_sms` VALUES ('56', '0', '2', '0', '18350070534', '0', 'xiugai', '2691', '', '1503905027', '1503904727');
INSERT INTO `opm_sms` VALUES ('57', '0', '2', '0', '18350070534', '0', 'xiugai', '8688', '', '1503905421', '1503905121');
INSERT INTO `opm_sms` VALUES ('58', '0', '2', '0', '18350070534', '0', 'xiugai', '0898', '', '1503906217', '1503905917');
INSERT INTO `opm_sms` VALUES ('59', '0', '2', '0', '18350070534', '0', 'xiugai', '6289', '', '1503912678', '1503912378');
INSERT INTO `opm_sms` VALUES ('60', '0', '2', '0', '18350070534', '0', 'xiugai', '8938', '', '1503914232', '1503913932');
INSERT INTO `opm_sms` VALUES ('61', '0', '2', '0', '13665045615', '10', 'zhuce', '6190', '', '1503996077', '1503995777');
INSERT INTO `opm_sms` VALUES ('62', '0', '2', '0', '13665045615', '10', 'zhuce', '9671', '', '1504084171', '1504083871');
INSERT INTO `opm_sms` VALUES ('63', '0', '2', '0', '18350070534', '10', 'zhuce', '8896', '', '1504179852', '1504179552');
INSERT INTO `opm_sms` VALUES ('64', '0', '2', '0', '13559050752', '10', 'zhuce', '9999', '', '1504243389', '1504243089');
INSERT INTO `opm_sms` VALUES ('65', '0', '2', '0', '18350070534', '10', 'zhuce', '9656', '', '1504675879', '1504675579');
INSERT INTO `opm_sms` VALUES ('66', '0', '2', '0', '18350070534', '10', 'xiugai', '9292', '', '1504676330', '1504676030');
INSERT INTO `opm_sms` VALUES ('67', '0', '2', '0', '18350070534', '10', 'xiugai', '5109', '', '1504676878', '1504676578');
INSERT INTO `opm_sms` VALUES ('68', '0', '2', '0', '18350070534', '10', 'xiugai', '5999', '', '1504677330', '1504677030');
INSERT INTO `opm_sms` VALUES ('69', '0', '2', '0', '18350070534', '10', 'xiugai', '8998', '', '1504677833', '1504677533');
INSERT INTO `opm_sms` VALUES ('70', '0', '2', '0', '18350070534', '10', 'xiugai', '6929', '', '1504761528', '1504761228');
INSERT INTO `opm_sms` VALUES ('71', '0', '2', '0', '18350070534', '10', 'xiugai', '6962', '', '1504761880', '1504761580');
INSERT INTO `opm_sms` VALUES ('72', '0', '2', '0', '18350070534', '10', 'xiugai', '9326', '', '1504762214', '1504761914');
INSERT INTO `opm_sms` VALUES ('73', '0', '2', '0', '18350070534', '10', 'xiugai', '3299', '', '1504762589', '1504762289');
INSERT INTO `opm_sms` VALUES ('74', '0', '2', '0', '18350070534', '10', 'xiugai', '0699', '', '1504763192', '1504762892');
INSERT INTO `opm_sms` VALUES ('75', '0', '2', '0', '18350070534', '0', 'xiugai', '8900', '', '1504764269', '1504763969');
INSERT INTO `opm_sms` VALUES ('76', '0', '2', '0', '18350070534', '0', 'zhuce', '2909', '', '1504764679', '1504764379');
INSERT INTO `opm_sms` VALUES ('77', '0', '2', '0', '18065851576', '10', 'xiugai', '6190', '', '1504764787', '1504764487');
INSERT INTO `opm_sms` VALUES ('78', '0', '2', '0', '18065851576', '0', 'xiugai', '6866', '', '1504765202', '1504764902');
INSERT INTO `opm_sms` VALUES ('79', '0', '2', '0', '18065851576', '0', 'xiugai', '9856', '', '1504765511', '1504765211');
INSERT INTO `opm_sms` VALUES ('80', '0', '2', '0', '18350070534', '10', 'zhuce', '8929', '', '1504765757', '1504765457');
INSERT INTO `opm_sms` VALUES ('81', '0', '2', '0', '18065851576', '10', 'zhuce', '9299', '', '1504766149', '1504765849');
INSERT INTO `opm_sms` VALUES ('82', '0', '2', '0', '18350070534', '10', 'xiugai', '8635', '', '1504766439', '1504766139');
INSERT INTO `opm_sms` VALUES ('83', '0', '2', '0', '13696828906', '0', 'zhuce', '9996', '', '1504768289', '1504767989');
INSERT INTO `opm_sms` VALUES ('84', '0', '2', '0', '13696828906', '0', 'zhuce', '9369', '', '1504768468', '1504768168');
INSERT INTO `opm_sms` VALUES ('85', '0', '2', '0', '13696828906', '0', 'zhuce', '6229', '', '1504768492', '1504768192');
INSERT INTO `opm_sms` VALUES ('86', '0', '2', '0', '13696828906', '0', 'zhuce', '9999', '', '1504768494', '1504768194');
INSERT INTO `opm_sms` VALUES ('87', '0', '2', '0', '13696828906', '0', 'zhuce', '0991', '', '1504768674', '1504768374');
INSERT INTO `opm_sms` VALUES ('88', '0', '2', '0', '13696828906', '0', 'zhuce', '2096', '', '1504768675', '1504768375');
INSERT INTO `opm_sms` VALUES ('89', '0', '2', '0', '13696828906', '0', 'zhuce', '6689', '', '1504768676', '1504768376');
INSERT INTO `opm_sms` VALUES ('90', '0', '2', '0', '13696828906', '0', 'zhuce', '9993', '', '1504768677', '1504768377');
INSERT INTO `opm_sms` VALUES ('91', '0', '2', '0', '13696828906', '0', 'zhuce', '9290', '', '1504768791', '1504768491');
INSERT INTO `opm_sms` VALUES ('92', '0', '2', '0', '13696828906', '0', 'zhuce', '3986', '', '1504768970', '1504768670');
INSERT INTO `opm_sms` VALUES ('93', '0', '2', '0', '13696828906', '0', 'zhuce', '8909', '', '1504769212', '1504768912');
INSERT INTO `opm_sms` VALUES ('94', '0', '2', '0', '13696828906', '0', 'zhuce', '9307', '', '1504769287', '1504768987');
INSERT INTO `opm_sms` VALUES ('95', '0', '2', '0', '13696828906', '0', 'zhuce', '9188', '', '1504769917', '1504769617');
INSERT INTO `opm_sms` VALUES ('96', '0', '2', '0', '13696828906', '0', 'zhuce', '9889', '', '1504770238', '1504769938');
INSERT INTO `opm_sms` VALUES ('97', '0', '2', '0', '13696828906', '0', 'zhuce', '8899', '', '1504770243', '1504769943');
INSERT INTO `opm_sms` VALUES ('98', '0', '2', '0', '13696828906', '0', 'zhuce', '9899', '', '1504770584', '1504770284');
INSERT INTO `opm_sms` VALUES ('99', '0', '2', '0', '13696828906', '0', 'zhuce', '9109', '', '1504770799', '1504770499');
INSERT INTO `opm_sms` VALUES ('100', '0', '2', '0', '13696828906', '0', 'zhuce', '8298', '', '1504771009', '1504770709');
INSERT INTO `opm_sms` VALUES ('101', '0', '2', '0', '13696828906', '0', 'zhuce', '9899', '', '1504771159', '1504770859');
INSERT INTO `opm_sms` VALUES ('102', '0', '2', '0', '13696828906', '0', 'zhuce', '2969', '', '1504771165', '1504770865');
INSERT INTO `opm_sms` VALUES ('103', '0', '2', '0', '13696828906', '0', 'zhuce', '9828', '', '1504771334', '1504771034');
INSERT INTO `opm_sms` VALUES ('104', '0', '2', '0', '13696828906', '0', 'zhuce', '2959', '', '1504771368', '1504771068');
INSERT INTO `opm_sms` VALUES ('105', '0', '2', '0', '13696828906', '0', 'zhuce', '8029', '', '1504771441', '1504771141');
INSERT INTO `opm_sms` VALUES ('106', '0', '2', '0', '13696828906', '0', 'zhuce', '9699', '', '1504771889', '1504771589');
INSERT INTO `opm_sms` VALUES ('107', '0', '2', '0', '13696828906', '0', 'zhuce', '8252', '', '1504772535', '1504772235');
INSERT INTO `opm_sms` VALUES ('108', '0', '2', '0', '18650723093', '0', 'zhuce', '9998', '', '1504773650', '1504773350');
INSERT INTO `opm_sms` VALUES ('109', '0', '2', '0', '13696828906', '0', 'zhuce', '9286', '', '1504773731', '1504773431');
INSERT INTO `opm_sms` VALUES ('110', '0', '2', '0', '13696828906', '0', 'zhuce', '9260', '', '1504773771', '1504773471');
INSERT INTO `opm_sms` VALUES ('111', '0', '2', '0', '13696828906', '0', 'zhuce', '7312', '', '1504773772', '1504773472');
INSERT INTO `opm_sms` VALUES ('112', '0', '2', '0', '13696828906', '0', 'zhuce', '9269', '', '1504773853', '1504773553');
INSERT INTO `opm_sms` VALUES ('113', '0', '2', '0', '13696828906', '0', 'zhuce', '9896', '', '1504773885', '1504773585');
INSERT INTO `opm_sms` VALUES ('114', '0', '2', '0', '13696828906', '0', 'zhuce', '2089', '', '1504773978', '1504773678');
INSERT INTO `opm_sms` VALUES ('115', '0', '2', '0', '13696828906', '0', 'zhuce', '6960', '', '1504773979', '1504773679');
INSERT INTO `opm_sms` VALUES ('116', '0', '2', '0', '13696828906', '0', 'zhuce', '6629', '', '1504773983', '1504773683');
INSERT INTO `opm_sms` VALUES ('117', '0', '2', '0', '13696828906', '0', 'zhuce', '2629', '', '1504774016', '1504773716');
INSERT INTO `opm_sms` VALUES ('118', '0', '2', '0', '18350070534', '0', 'zhuce', '9169', '', '1504776234', '1504775934');
INSERT INTO `opm_sms` VALUES ('119', '0', '2', '0', '18350070534', '0', 'zhuce', '9909', '', '1504776254', '1504775954');
INSERT INTO `opm_sms` VALUES ('120', '0', '2', '0', '18006942218', '0', 'zhuce', '2699', '', '1504776255', '1504775955');
INSERT INTO `opm_sms` VALUES ('121', '0', '2', '0', '18350070534', '0', 'zhuce', '9038', '', '1504776383', '1504776083');
INSERT INTO `opm_sms` VALUES ('122', '0', '2', '0', '18350070534', '0', 'zhuce', '9600', '', '1504776510', '1504776210');
INSERT INTO `opm_sms` VALUES ('123', '0', '2', '0', '18350070534', '0', 'zhuce', '6868', '', '1504776523', '1504776223');
INSERT INTO `opm_sms` VALUES ('124', '0', '2', '0', '18350070534', '0', 'zhuce', '0299', '', '1504776894', '1504776594');
INSERT INTO `opm_sms` VALUES ('125', '0', '2', '0', '18350070534', '0', 'zhuce', '0998', '', '1504778710', '1504778410');
INSERT INTO `opm_sms` VALUES ('126', '0', '2', '0', '18350070534', '0', 'zhuce', '9029', '', '1504786231', '1504785931');
INSERT INTO `opm_sms` VALUES ('127', '0', '2', '0', '18350070534', '0', 'zhuce', '8806', '', '1504786615', '1504786315');
INSERT INTO `opm_sms` VALUES ('128', '0', '2', '0', '18350070534', '0', 'zhuce', '5929', '', '1504786653', '1504786353');
INSERT INTO `opm_sms` VALUES ('129', '0', '2', '0', '18350070534', '0', 'zhuce', '9618', '', '1504786683', '1504786383');
INSERT INTO `opm_sms` VALUES ('130', '0', '2', '0', '18350070534', '0', 'zhuce', '9220', '', '1504786706', '1504786406');
INSERT INTO `opm_sms` VALUES ('131', '0', '2', '0', '18350070534', '0', 'zhuce', '0096', '', '1504786723', '1504786423');
INSERT INTO `opm_sms` VALUES ('132', '0', '2', '0', '18350070534', '0', 'zhuce', '9682', '', '1504786765', '1504786465');
INSERT INTO `opm_sms` VALUES ('133', '0', '2', '0', '18350070534', '0', 'zhuce', '6059', '', '1504786806', '1504786506');
INSERT INTO `opm_sms` VALUES ('134', '0', '2', '0', '18350070534', '0', 'zhuce', '0886', '', '1504787409', '1504787109');
INSERT INTO `opm_sms` VALUES ('135', '0', '2', '0', '13665045615', '0', 'zhuce', '3629', '', '1504787412', '1504787112');
INSERT INTO `opm_sms` VALUES ('136', '0', '2', '0', '13696828906', '0', 'zhuce', '8119', '', '1504831976', '1504831676');
INSERT INTO `opm_sms` VALUES ('137', '0', '2', '0', '13696828906', '0', 'zhuce', '0609', '', '1504832230', '1504831930');
INSERT INTO `opm_sms` VALUES ('138', '0', '2', '0', '13696828906', '0', 'zhuce', '6029', '', '1504832232', '1504831932');
INSERT INTO `opm_sms` VALUES ('139', '0', '2', '0', '13696828906', '0', 'zhuce', '8569', '', '1504832233', '1504831933');
INSERT INTO `opm_sms` VALUES ('140', '0', '2', '0', '13696828906', '0', 'zhuce', '9839', '', '1504832234', '1504831934');
INSERT INTO `opm_sms` VALUES ('141', '0', '2', '0', '13696828906', '0', 'zhuce', '9629', '', '1504832234', '1504831934');
INSERT INTO `opm_sms` VALUES ('142', '0', '2', '0', '13696828906', '0', 'zhuce', '9862', '', '1504832349', '1504832049');
INSERT INTO `opm_sms` VALUES ('143', '0', '2', '0', '13696828906', '0', 'zhuce', '8939', '', '1504836039', '1504835739');
INSERT INTO `opm_sms` VALUES ('144', '0', '2', '0', '13696828906', '0', 'zhuce', '9069', '', '1504836153', '1504835853');
INSERT INTO `opm_sms` VALUES ('145', '0', '2', '0', '13696828906', '0', 'zhuce', '9900', '', '1504836155', '1504835855');
INSERT INTO `opm_sms` VALUES ('146', '0', '2', '0', '13696828906', '0', 'zhuce', '6889', '', '1504836157', '1504835857');
INSERT INTO `opm_sms` VALUES ('147', '0', '2', '0', '13696828906', '0', 'zhuce', '6602', '', '1504836158', '1504835858');
INSERT INTO `opm_sms` VALUES ('148', '0', '2', '0', '13696828906', '0', 'zhuce', '9887', '', '1504836159', '1504835859');
INSERT INTO `opm_sms` VALUES ('149', '0', '2', '0', '13696828906', '0', 'zhuce', '9296', '', '1504836419', '1504836119');
INSERT INTO `opm_sms` VALUES ('150', '0', '2', '0', '13696828906', '0', 'zhuce', '8929', '', '1504836499', '1504836199');
INSERT INTO `opm_sms` VALUES ('151', '0', '2', '0', '13696828906', '0', 'zhuce', '9989', '', '1504837723', '1504837423');
INSERT INTO `opm_sms` VALUES ('152', '0', '2', '0', '13696828906', '0', 'zhuce', '9886', '', '1504837729', '1504837429');
INSERT INTO `opm_sms` VALUES ('153', '0', '2', '0', '13696828906', '0', 'zhuce', '9299', '', '1504837730', '1504837430');
INSERT INTO `opm_sms` VALUES ('154', '0', '2', '0', '13696828906', '0', 'zhuce', '9826', '', '1504837731', '1504837431');
INSERT INTO `opm_sms` VALUES ('155', '0', '2', '0', '13696828906', '0', 'zhuce', '8980', '', '1504837733', '1504837433');
INSERT INTO `opm_sms` VALUES ('156', '0', '2', '0', '13696828906', '0', 'zhuce', '8268', '', '1504837741', '1504837441');
INSERT INTO `opm_sms` VALUES ('157', '0', '2', '0', '13696828906', '0', 'zhuce', '0090', '', '1504837742', '1504837442');
INSERT INTO `opm_sms` VALUES ('158', '0', '2', '0', '13696828906', '0', 'zhuce', '2906', '', '1504837744', '1504837444');
INSERT INTO `opm_sms` VALUES ('159', '0', '2', '0', '13696828906', '0', 'zhuce', '9868', '', '1504837749', '1504837449');
INSERT INTO `opm_sms` VALUES ('160', '0', '2', '0', '13696828906', '0', 'zhuce', '9686', '', '1504837750', '1504837450');
INSERT INTO `opm_sms` VALUES ('161', '0', '2', '0', '13696828906', '0', 'zhuce', '2680', '', '1504837751', '1504837451');
INSERT INTO `opm_sms` VALUES ('162', '0', '2', '0', '13696828906', '0', 'zhuce', '9958', '', '1504837751', '1504837451');
INSERT INTO `opm_sms` VALUES ('163', '0', '2', '0', '13696828906', '0', 'zhuce', '9998', '', '1504837752', '1504837452');
INSERT INTO `opm_sms` VALUES ('164', '0', '2', '0', '13696828906', '0', 'zhuce', '8826', '', '1504837753', '1504837453');
INSERT INTO `opm_sms` VALUES ('165', '0', '2', '0', '13696828906', '0', 'zhuce', '9980', '', '1504837753', '1504837453');
INSERT INTO `opm_sms` VALUES ('166', '0', '2', '0', '18350070534', '0', 'zhuce', '9996', '', '1504838460', '1504838160');
INSERT INTO `opm_sms` VALUES ('167', '0', '2', '0', '13950209856', '0', 'zhuce', '6379', '', '1504838486', '1504838186');
INSERT INTO `opm_sms` VALUES ('168', '0', '2', '0', '13696828906', '0', 'zhuce', '2888', '', '1504838879', '1504838579');
INSERT INTO `opm_sms` VALUES ('169', '0', '2', '0', '13696828906', '0', 'zhuce', '7996', '', '1504839006', '1504838706');
INSERT INTO `opm_sms` VALUES ('170', '0', '2', '0', '18350070534', '0', 'zhuce', '6089', '', '1504840279', '1504839979');
INSERT INTO `opm_sms` VALUES ('171', '0', '2', '0', '18350070531', '0', 'xiugai', '8076', '', '1504840844', '1504840544');
INSERT INTO `opm_sms` VALUES ('172', '0', '2', '0', '18350070534', '10', 'zhuce', '9295', '', '1504847376', '1504847076');
INSERT INTO `opm_sms` VALUES ('173', '0', '2', '0', '18350070534', '0', 'xiugai', '5862', '', '1504847428', '1504847128');
INSERT INTO `opm_sms` VALUES ('174', '0', '2', '0', '13665045615', '10', 'zhuce', '2366', '', '1504847966', '1504847666');
INSERT INTO `opm_sms` VALUES ('175', '0', '2', '0', '18350070534', '0', 'xiugai', '0580', '', '1504851343', '1504851043');
INSERT INTO `opm_sms` VALUES ('176', '0', '2', '0', '18350070534', '0', 'xiugai', '8093', '', '1504860900', '1504860600');
INSERT INTO `opm_sms` VALUES ('177', '0', '2', '0', '18350070534', '10', 'zhuce', '6968', '', '1504861279', '1504860979');
INSERT INTO `opm_sms` VALUES ('178', '0', '2', '0', '18350070534', '10', 'zhuce', '6067', '', '1504861709', '1504861409');
INSERT INTO `opm_sms` VALUES ('179', '0', '2', '0', '18350070534', '0', 'xiugai', '3690', '', '1504864433', '1504864133');
INSERT INTO `opm_sms` VALUES ('180', '0', '2', '0', '18350070534', '10', 'zhuce', '2009', '', '1504864875', '1504864575');
INSERT INTO `opm_sms` VALUES ('181', '0', '2', '0', '18350070534', '10', 'zhuce', '9929', '', '1504865766', '1504865466');
INSERT INTO `opm_sms` VALUES ('182', '0', '2', '0', '18350070534', '10', 'xiugai', '6988', '', '1504869126', '1504868826');
INSERT INTO `opm_sms` VALUES ('183', '0', '2', '0', '18350070534', '10', 'xiugai', '8598', '', '1505093010', '1505092710');
INSERT INTO `opm_sms` VALUES ('184', '0', '2', '0', '18350070534', '10', 'xiugai', '2688', '', '1505094361', '1505094061');
INSERT INTO `opm_sms` VALUES ('185', '0', '2', '0', '18065851576', '10', 'zhuce', '8680', '', '1505095062', '1505094762');
INSERT INTO `opm_sms` VALUES ('186', '0', '2', '0', '18065851576', '0', 'xiugai', '5992', '', '1505097091', '1505096791');
INSERT INTO `opm_sms` VALUES ('187', '0', '2', '0', '18350070534', '0', 'zhuce', '9960', '', '1505108456', '1505108156');
INSERT INTO `opm_sms` VALUES ('188', '0', '2', '0', '18350070534', '0', 'xiugai', '9689', '', '1505108756', '1505108456');
INSERT INTO `opm_sms` VALUES ('189', '0', '2', '0', '18350070534', '10', 'xiugai', '5961', '', '1505118333', '1505118033');
INSERT INTO `opm_sms` VALUES ('190', '0', '2', '0', '18065851576', '10', 'zhuce', '2380', '', '1505127310', '1505127010');
INSERT INTO `opm_sms` VALUES ('191', '0', '2', '0', '17750288225', '10', 'zhuce', '8971', '', '1505179731', '1505179431');
INSERT INTO `opm_sms` VALUES ('192', '0', '2', '0', '18065851576', '10', 'zhuce', '2829', '', '1505186339', '1505186039');
INSERT INTO `opm_sms` VALUES ('193', '0', '2', '0', '18065851576', '10', 'zhuce', '8897', '', '1505187076', '1505186776');
INSERT INTO `opm_sms` VALUES ('194', '0', '2', '0', '18350070534', '0', 'zhuce', '9692', '', '1505350679', '1505350379');
INSERT INTO `opm_sms` VALUES ('195', '0', '2', '0', '18350070534', '0', 'xiugai', '1696', '', '1505352308', '1505352008');
INSERT INTO `opm_sms` VALUES ('196', '0', '2', '0', '18350070534', '0', 'xiugai', '6816', '', '1505353154', '1505352854');
INSERT INTO `opm_sms` VALUES ('197', '0', '2', '0', '18350070534', '0', 'xiugai', '0996', '', '1505353720', '1505353420');
INSERT INTO `opm_sms` VALUES ('198', '0', '2', '0', '18350070534', '0', 'zhuce', '6008', '', '1505354384', '1505354084');
INSERT INTO `opm_sms` VALUES ('199', '0', '2', '0', '18350070534', '0', 'zhuce', '9809', '', '1505355114', '1505354814');
INSERT INTO `opm_sms` VALUES ('200', '0', '2', '0', '18350070534', '0', 'xiugai', '9692', '', '1505356315', '1505356015');
INSERT INTO `opm_sms` VALUES ('201', '0', '2', '0', '18350070534', '0', 'zhuce', '0691', '', '1505356655', '1505356355');

-- ----------------------------
-- Table structure for `opm_user_device`
-- ----------------------------
DROP TABLE IF EXISTS `opm_user_device`;
CREATE TABLE `opm_user_device` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '设备id',
  `device_code` varchar(64) NOT NULL DEFAULT '' COMMENT '设备唯一识别码',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联用户id',
  PRIMARY KEY (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户设备关联表';

-- ----------------------------
-- Records of opm_user_device
-- ----------------------------

-- ----------------------------
-- Table structure for `opm_wx_msg`
-- ----------------------------
DROP TABLE IF EXISTS `opm_wx_msg`;
CREATE TABLE `opm_wx_msg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '微信模板消息发送id',
  `msg_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '消息类型: 0系统 1消费',
  `msg_from_id` int(11) NOT NULL DEFAULT '0' COMMENT '消息发送者id: 0系统 若msg_type为1则为business_id',
  `msg_receive_id` int(11) NOT NULL DEFAULT '0' COMMENT '接收者id',
  `msg_title` varchar(64) NOT NULL DEFAULT '' COMMENT '消息标题',
  `msg_content` varchar(512) NOT NULL DEFAULT '' COMMENT '消息内容',
  `msg_link` varchar(128) NOT NULL DEFAULT '' COMMENT '消息链接',
  `msg_intime` int(11) NOT NULL DEFAULT '0' COMMENT '消息发送时间',
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信模板消息推送记录表';

-- ----------------------------
-- Records of opm_wx_msg
-- ----------------------------

-- ----------------------------
-- Table structure for `opm_wx_template`
-- ----------------------------
DROP TABLE IF EXISTS `opm_wx_template`;
CREATE TABLE `opm_wx_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '微信模板id',
  `template_name` varchar(64) NOT NULL DEFAULT '' COMMENT '模板名称',
  `template_wx_code` varchar(32) NOT NULL DEFAULT '' COMMENT '微信模板库中模板的编号',
  `template_wx_tmplid` varchar(128) NOT NULL DEFAULT '' COMMENT '微信模板ID',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信消息模板';

-- ----------------------------
-- Records of opm_wx_template
-- ----------------------------
