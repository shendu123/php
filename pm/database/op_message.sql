/*
Navicat MySQL Data Transfer

Source Server         : linux_open
Source Server Version : 50628
Source Host           : 192.168.71.236:3306
Source Database       : op_message

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-08-23 15:24:00
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
  `msg_content` varchar(256) NOT NULL DEFAULT '' COMMENT '消息内容',
  `msg_link` varchar(128) NOT NULL DEFAULT '' COMMENT '消息链接',
  `msg_intime` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='app推送信息记录表';

-- ----------------------------
-- Records of opm_app_msg
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='短信发送记录表';

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
