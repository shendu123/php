# -----------------------------------------------------------
# PHP-Amateur database backup files
# Type: 系统自动备份
# Description:当前SQL文件包含了表：on_access、on_admin、on_advertising、on_advertising_position、on_attention、on_attention_seller、on_auction、on_auction_agency、on_auction_pledge、on_auction_record、on_category、on_deliver_address、on_express、on_feedback、on_goods、on_goods_category、on_goods_category_extend、on_goods_category_filtrate、on_goods_evaluate、on_goods_extend、on_goods_fields、on_goods_filtrate、on_goods_order、on_goods_user、on_link、on_meeting_auction、on_member、on_member_evaluate、on_member_limsum_bill、on_member_pledge_bill、on_member_pledge_take、on_member_weixin、on_mysms、on_navigation、on_news、on_node、on_order_break、on_payorder、on_region、on_role、on_role_user、on_scheduled、on_seller_pledge、on_share、on_special_auction、on_verify_email、on_verify_mobile、on_weiurl的结构信息，表：on_access、on_admin、on_advertising、on_advertising_position、on_attention、on_attention_seller、on_auction、on_auction_agency、on_auction_pledge、on_auction_record、on_category、on_deliver_address、on_express、on_feedback、on_goods、on_goods_category、on_goods_category_extend、on_goods_category_filtrate、on_goods_evaluate、on_goods_extend、on_goods_fields、on_goods_filtrate、on_goods_order、on_goods_user、on_link、on_meeting_auction、on_member、on_member_evaluate、on_member_limsum_bill、on_member_pledge_bill、on_member_pledge_take、on_member_weixin、on_mysms、on_navigation、on_news、on_node、on_order_break、on_payorder、on_region、on_role、on_role_user、on_scheduled、on_seller_pledge、on_share、on_special_auction、on_verify_email、on_verify_mobile、on_weiurl的数据
# Time: 2017-01-23 11:09:22
# -----------------------------------------------------------
# 当前SQL卷标：#1
# -----------------------------------------------------------


# 数据库表：on_access 结构信息
DROP TABLE IF EXISTS `on_access`;
CREATE TABLE `on_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限分配表' ;

# 数据库表：on_admin 结构信息
DROP TABLE IF EXISTS `on_admin`;
CREATE TABLE `on_admin` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL COMMENT '登录账号',
  `pwd` char(32) DEFAULT NULL COMMENT '登录密码',
  `status` int(11) DEFAULT '1' COMMENT '账号状态',
  `remark` varchar(255) DEFAULT '' COMMENT '备注信息',
  `find_code` char(5) DEFAULT NULL COMMENT '找回账号验证码',
  `time` int(10) DEFAULT NULL COMMENT '开通时间',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='网站后台管理员表' ;

# 数据库表：on_advertising 结构信息
DROP TABLE IF EXISTS `on_advertising`;
CREATE TABLE `on_advertising` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) NOT NULL COMMENT '所属广告位ID',
  `name` varchar(20) NOT NULL COMMENT '广告名称',
  `code` text NOT NULL COMMENT '广告代码',
  `type` tinyint(1) NOT NULL COMMENT '1: 图片 2:flash 3:自定义代码',
  `status` tinyint(4) NOT NULL COMMENT '显示状态',
  `url` varchar(255) NOT NULL COMMENT '链接地址',
  `click_count` int(11) NOT NULL COMMENT '点击统计',
  `desc` text NOT NULL COMMENT '说明',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `adv_start_time` int(11) DEFAULT '0' COMMENT '广告开始时间',
  `adv_end_time` int(11) DEFAULT '0' COMMENT '广告结束时间',
  `is_vote` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `position_id` (`pid`),
  KEY `inx_adv_001` (`status`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='广告表' ;

# 数据库表：on_advertising_position 结构信息
DROP TABLE IF EXISTS `on_advertising_position`;
CREATE TABLE `on_advertising_position` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tagname` varchar(30) NOT NULL COMMENT '广告标示',
  `name` varchar(60) NOT NULL COMMENT '广告名称',
  `width` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '宽度',
  `height` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '高度',
  `is_flash` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是不是flash',
  `flash_style` varchar(60) NOT NULL COMMENT 'flash样式',
  `style` text NOT NULL COMMENT '广告模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='广告位' ;

# 数据库表：on_attention 结构信息
DROP TABLE IF EXISTS `on_attention`;
CREATE TABLE `on_attention` (
  `gid` int(11) NOT NULL COMMENT '商品id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `rela` varchar(5) NOT NULL COMMENT '关注类型p-u：拍品关注g-u：一口价关注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户关注商品表' ;

# 数据库表：on_attention_seller 结构信息
DROP TABLE IF EXISTS `on_attention_seller`;
CREATE TABLE `on_attention_seller` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `sellerid` int(11) NOT NULL COMMENT '卖家id',
  `time` int(10) NOT NULL COMMENT '关注时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

# 数据库表：on_auction 结构信息
DROP TABLE IF EXISTS `on_auction`;
CREATE TABLE `on_auction` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '拍卖id',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `sid` int(11) NOT NULL COMMENT '专场id',
  `mid` int(11) NOT NULL COMMENT '拍卖会id',
  `bidnb` varchar(30) NOT NULL COMMENT '拍品编号',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '拍卖类型',
  `succtype` tinyint(1) NOT NULL COMMENT '成交模式0普通模式1即时成交',
  `succprice` decimal(10,2) NOT NULL COMMENT '即时成交价格',
  `freight` decimal(10,2) NOT NULL COMMENT '运费',
  `pattern` tinyint(1) NOT NULL DEFAULT '0' COMMENT '拍卖模式0：集市 1：专场扣除，2：专场单品 3：拍卖会4：拍卖会单品',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '拍卖状态0新增，1降价',
  `pname` varchar(255) NOT NULL COMMENT '拍卖名称',
  `onset` decimal(10,2) NOT NULL COMMENT '起拍价',
  `price` decimal(10,2) NOT NULL COMMENT '保留价',
  `nowprice` decimal(10,2) NOT NULL COMMENT '当前价',
  `starttime` int(10) NOT NULL COMMENT '开始时间',
  `endtime` int(10) NOT NULL COMMENT '结束时间',
  `stepsize` varchar(255) NOT NULL COMMENT '价格浮动',
  `stepsize_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '价格浮动方式',
  `pledge_type` varchar(10) NOT NULL DEFAULT 'fixation' COMMENT '保证金冻结方式',
  `broker_type` varchar(10) NOT NULL DEFAULT 'fixation' COMMENT '佣金收取方式ratio比例;fixation定额',
  `broker` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金',
  `pledge` decimal(10,2) NOT NULL COMMENT '参拍保证金',
  `steptime` int(10) NOT NULL DEFAULT '0' COMMENT '触发延时时间段',
  `deferred` int(10) NOT NULL DEFAULT '0' COMMENT '延时时间',
  `uid` int(11) NOT NULL COMMENT '当前出价人id',
  `agency_uid` int(11) NOT NULL COMMENT '最高代理人uid',
  `agency_price` decimal(10,2) NOT NULL COMMENT '最高代理价',
  `bidcount` int(11) NOT NULL DEFAULT '0' COMMENT '出价次数',
  `endstatus` tinyint(1) DEFAULT '0' COMMENT '0：无状态，1成交，2.流拍，3无人出价流拍，4.撤拍',
  `clcount` int(11) NOT NULL DEFAULT '0' COMMENT '想拍人数',
  `msort` int(11) NOT NULL COMMENT '拍卖会排序',
  `aid` int(11) NOT NULL COMMENT '发布人',
  PRIMARY KEY (`pid`),
  KEY `msort` (`msort`),
  KEY `gid` (`gid`),
  KEY `sid` (`sid`),
  KEY `mid` (`mid`),
  KEY `type` (`type`),
  KEY `pattern` (`pattern`),
  KEY `status` (`status`),
  KEY `onset` (`onset`),
  KEY `starttime` (`starttime`),
  KEY `endtime` (`endtime`),
  KEY `endstatus` (`endstatus`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='拍卖表' ;

# 数据库表：on_auction_agency 结构信息
DROP TABLE IF EXISTS `on_auction_agency`;
CREATE TABLE `on_auction_agency` (
  `pid` int(11) NOT NULL COMMENT '拍卖id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `price` int(11) NOT NULL COMMENT '目标价',
  `time` int(10) NOT NULL COMMENT '设置时间',
  `status` tinyint(1) NOT NULL COMMENT '代理出价状态0：执行中无状态；1：达到目标价；2：被超越；3已关闭',
  KEY `pid` (`pid`),
  KEY `uid` (`uid`),
  KEY `status` (`status`),
  KEY `price` (`price`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代理出价表' ;

# 数据库表：on_auction_pledge 结构信息
DROP TABLE IF EXISTS `on_auction_pledge`;
CREATE TABLE `on_auction_pledge` (
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `pledge` decimal(10,0) NOT NULL,
  `time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='拍卖冻结用户保证金记录' ;

# 数据库表：on_auction_record 结构信息
DROP TABLE IF EXISTS `on_auction_record`;
CREATE TABLE `on_auction_record` (
  `pid` int(11) NOT NULL COMMENT '拍品id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `time` int(10) NOT NULL COMMENT '出价时间',
  `money` decimal(10,2) NOT NULL COMMENT '出价金额',
  `bided` decimal(10,2) NOT NULL COMMENT '出价后',
  `type` varchar(10) NOT NULL COMMENT '出价方式',
  KEY `uid` (`uid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='拍卖出价记录' ;

# 数据库表：on_category 结构信息
DROP TABLE IF EXISTS `on_category`;
CREATE TABLE `on_category` (
  `cid` int(5) NOT NULL AUTO_INCREMENT,
  `pid` int(5) DEFAULT NULL COMMENT 'parentCategory上级分类',
  `name` varchar(20) DEFAULT NULL COMMENT '分类名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='新闻分类表' ;

# 数据库表：on_deliver_address 结构信息
DROP TABLE IF EXISTS `on_deliver_address`;
CREATE TABLE `on_deliver_address` (
  `adid` int(11) NOT NULL AUTO_INCREMENT COMMENT '地址id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `province` int(11) NOT NULL COMMENT '省id',
  `city` int(11) NOT NULL COMMENT '城市id',
  `area` int(11) NOT NULL COMMENT '区、县id',
  `address` varchar(50) NOT NULL COMMENT '详细地址',
  `postalcode` int(10) NOT NULL COMMENT '邮政编码',
  `truename` varchar(8) NOT NULL COMMENT '收件人姓名',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `phone` varchar(30) NOT NULL COMMENT '电话号码',
  `default` tinyint(1) NOT NULL COMMENT '是否默认：1是，0否',
  PRIMARY KEY (`adid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='地址表' ;

# 数据库表：on_express 结构信息
DROP TABLE IF EXISTS `on_express`;
CREATE TABLE `on_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `letter` varchar(1) NOT NULL COMMENT '字母',
  `en` varchar(200) NOT NULL COMMENT '拼音',
  `ch` varchar(200) NOT NULL COMMENT '中文',
  `sort` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COMMENT='快递公司表用于查询快递' ;

# 数据库表：on_feedback 结构信息
DROP TABLE IF EXISTS `on_feedback`;
CREATE TABLE `on_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL COMMENT '推广名',
  `count` int(11) DEFAULT '0' COMMENT '统计',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='推广类型表' ;

# 数据库表：on_goods 结构信息
DROP TABLE IF EXISTS `on_goods`;
CREATE TABLE `on_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL COMMENT '所属类',
  `title` varchar(200) DEFAULT NULL COMMENT '商品名称',
  `filtrate` varchar(255) DEFAULT NULL COMMENT '筛选条件id集合',
  `keywords` varchar(50) DEFAULT NULL COMMENT '商品关键字',
  `description` varchar(255) DEFAULT NULL COMMENT '商品描述',
  `price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `content` mediumtext COMMENT '商品详情',
  `province` int(6) NOT NULL DEFAULT '0' COMMENT '省',
  `city` int(6) NOT NULL DEFAULT '0' COMMENT '市',
  `area` int(6) NOT NULL DEFAULT '0' COMMENT '区',
  `pictures` text COMMENT '商品图片',
  `published` int(10) DEFAULT NULL COMMENT '发布时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `sellerid` int(11) NOT NULL COMMENT '卖家id',
  `aid` int(11) DEFAULT NULL COMMENT '发布者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='商品表' ;

# 数据库表：on_goods_category 结构信息
DROP TABLE IF EXISTS `on_goods_category`;
CREATE TABLE `on_goods_category` (
  `cid` int(5) NOT NULL AUTO_INCREMENT,
  `pid` int(5) DEFAULT NULL COMMENT 'parentCategory上级分类',
  `name` varchar(20) DEFAULT NULL COMMENT '分类名称',
  `ico` varchar(30) DEFAULT NULL COMMENT '分类图标',
  `hot` tinyint(1) NOT NULL COMMENT '是否推荐',
  `sort` int(5) NOT NULL COMMENT '排序',
  PRIMARY KEY (`cid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分类表' ;

# 数据库表：on_goods_category_extend 结构信息
DROP TABLE IF EXISTS `on_goods_category_extend`;
CREATE TABLE `on_goods_category_extend` (
  `cid` int(5) DEFAULT NULL COMMENT '商品分类id',
  `eid` int(5) DEFAULT NULL COMMENT '扩展字段id',
  KEY `cid` (`cid`),
  KEY `eid` (`eid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分类扩展字段关联表' ;

# 数据库表：on_goods_category_filtrate 结构信息
DROP TABLE IF EXISTS `on_goods_category_filtrate`;
CREATE TABLE `on_goods_category_filtrate` (
  `cid` int(5) DEFAULT NULL COMMENT '商品分类id',
  `fid` int(5) DEFAULT NULL COMMENT '筛选条件id',
  KEY `cid` (`cid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分类商品条件关联表' ;

# 数据库表：on_goods_evaluate 结构信息
DROP TABLE IF EXISTS `on_goods_evaluate`;
CREATE TABLE `on_goods_evaluate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评价id',
  `uid` int(11) NOT NULL COMMENT '评价用户id',
  `sellerid` int(11) NOT NULL COMMENT '商品所属用户',
  `pid` int(11) NOT NULL COMMENT '拍品id',
  `order_no` varchar(100) NOT NULL COMMENT '对应订单号',
  `service_evaluate` varchar(255) NOT NULL COMMENT '服务评价',
  `conform_evaluate` varchar(255) NOT NULL COMMENT '商品评价',
  `conform` int(1) NOT NULL COMMENT '商品评分',
  `service` int(1) NOT NULL COMMENT '服务评分',
  `express` int(1) NOT NULL COMMENT '物流评分',
  `time` int(10) NOT NULL COMMENT '评价时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商品评价表' ;

# 数据库表：on_goods_extend 结构信息
DROP TABLE IF EXISTS `on_goods_extend`;
CREATE TABLE `on_goods_extend` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) DEFAULT NULL COMMENT '字段名',
  `default` mediumtext COMMENT '字段默认值',
  `rank` int(2) NOT NULL DEFAULT '0' COMMENT '字段排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用0：不启用，1启用',
  PRIMARY KEY (`eid`),
  KEY `rank` (`rank`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商品扩展字段' ;

# 数据库表：on_goods_fields 结构信息
DROP TABLE IF EXISTS `on_goods_fields`;
CREATE TABLE `on_goods_fields` (
  `eid` int(11) NOT NULL,
  `default` text COMMENT '字段默认值',
  `gid` int(11) NOT NULL,
  KEY `eid` (`eid`),
  KEY `gid` (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品对应字段' ;

# 数据库表：on_goods_filtrate 结构信息
DROP TABLE IF EXISTS `on_goods_filtrate`;
CREATE TABLE `on_goods_filtrate` (
  `fid` int(5) NOT NULL AUTO_INCREMENT,
  `pid` int(5) DEFAULT NULL COMMENT '上级条件',
  `name` varchar(20) DEFAULT NULL COMMENT '条件名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`fid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品筛选条件表' ;

# 数据库表：on_goods_order 结构信息
DROP TABLE IF EXISTS `on_goods_order`;
CREATE TABLE `on_goods_order` (
  `order_no` varchar(100) NOT NULL COMMENT '订单号',
  `type` tinyint(1) NOT NULL COMMENT '订单类型  0竞拍 1 竞价 2一口价',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `sellerid` int(11) NOT NULL COMMENT '卖家uid',
  `price` decimal(10,2) NOT NULL COMMENT '商品价',
  `freight` decimal(10,2) NOT NULL COMMENT '运费',
  `broker` decimal(10,2) NOT NULL COMMENT '佣金',
  `time` int(10) NOT NULL COMMENT '订单生成时间',
  `time1` int(11) NOT NULL COMMENT '支付时间',
  `time2` int(11) NOT NULL COMMENT '发货时间',
  `time3` int(11) NOT NULL COMMENT '买家收货时间',
  `time4` int(11) NOT NULL COMMENT '评价卖家时间',
  `time5` int(10) NOT NULL COMMENT '申请退货时间',
  `time6` int(10) NOT NULL COMMENT '卖家拒绝退货',
  `time7` int(10) NOT NULL COMMENT '同意退货时间',
  `time8` int(10) NOT NULL COMMENT '买家已发货',
  `time9` int(10) NOT NULL COMMENT '卖家确认收货',
  `time10` int(10) NOT NULL COMMENT '卖家评价时间',
  `time11` int(10) NOT NULL COMMENT '卖家评价时间',
  `deftime2` int(10) NOT NULL COMMENT '默认发货时间',
  `deftime2st` tinyint(1) NOT NULL COMMENT '默认发货处理状态,0：执行，1已执行',
  `deftime3` int(10) NOT NULL COMMENT '默认收货时间',
  `deftime3st` tinyint(1) NOT NULL COMMENT '默认收货处理状态,0：未执行，1已执行',
  `deftime4` int(10) NOT NULL COMMENT '买家默认评价时间',
  `deftime4st` tinyint(1) NOT NULL COMMENT '买家默认评价状态,0：未执行，1已执行',
  `deftime10` int(10) NOT NULL COMMENT '卖家默认评价时间',
  `deftime10st` tinyint(1) NOT NULL COMMENT '卖家默认评价状态,0：未执行，1已执行',
  `deftime1` int(10) NOT NULL COMMENT '支付过期时间',
  `deftime1st` tinyint(1) NOT NULL COMMENT '支付过期状态，0：未处理，1：已处理',
  `status` tinyint(2) NOT NULL COMMENT '支付状态0：未支付1：已支付 2：已发货3：买家已收货 4：订单过期已扣除保证金 5：已评价 6：申请退货 7：已同意退货 8：不同意退货 9：买家已发货 10：卖家确认收货 11：已评价买家',
  `downpay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1：线下已支付',
  `buyer_msg` varchar(200) NOT NULL COMMENT '买家留言',
  `address` text NOT NULL COMMENT '收货地址',
  `express` varchar(50) NOT NULL COMMENT '快递公司',
  `express_other` varchar(20) NOT NULL COMMENT '其他快递物流',
  `express_no` varchar(30) NOT NULL COMMENT '快递单号',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  UNIQUE KEY `order_no_2` (`order_no`),
  KEY `order_no` (`order_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

# 数据库表：on_goods_user 结构信息
DROP TABLE IF EXISTS `on_goods_user`;
CREATE TABLE `on_goods_user` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `gid` int(11) NOT NULL COMMENT '商品id',
  `limsum` float(10,2) NOT NULL COMMENT '冻结信用额度',
  `pledge` float(10,2) NOT NULL COMMENT '冻结的保证金',
  `g-u` varchar(3) NOT NULL COMMENT 'p-u：拍品-用户g-u：商品-用户,s-u：专场-用户',
  `time` int(10) NOT NULL COMMENT '时间',
  `rtime` int(10) NOT NULL COMMENT '保证金处理时间',
  `status` tinyint(1) NOT NULL COMMENT '处理状态，0：未处理，1：已处理'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户对商品缴纳保证金' ;

# 数据库表：on_link 结构信息
DROP TABLE IF EXISTS `on_link`;
CREATE TABLE `on_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL COMMENT '名称',
  `url` varchar(255) NOT NULL COMMENT '链接',
  `ico` varchar(255) NOT NULL COMMENT '图标',
  `rec` tinyint(1) NOT NULL COMMENT '图标显示0：不显示1：显示',
  `sort` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='友情链接表' ;

# 数据库表：on_meeting_auction 结构信息
DROP TABLE IF EXISTS `on_meeting_auction`;
CREATE TABLE `on_meeting_auction` (
  `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '拍卖会id',
  `mname` varchar(200) NOT NULL COMMENT '拍卖会名',
  `mpicture` text NOT NULL COMMENT '拍卖会列表图',
  `mbanner` text NOT NULL COMMENT '拍卖会banner',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `starttime` int(10) NOT NULL COMMENT '开始时间',
  `endtime` int(10) NOT NULL COMMENT '结束时间',
  `losetime` int(10) NOT NULL COMMENT '流拍时间',
  `bidtime` int(10) NOT NULL COMMENT '拍卖时间',
  `intervaltime` int(10) NOT NULL COMMENT '间隔时间',
  `meeting_pledge_type` tinyint(1) NOT NULL COMMENT '保证金扣除模式',
  `mpledge` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '保证金',
  `mcount` int(11) NOT NULL COMMENT '拍卖会出价次数',
  `sendstatus` tinyint(1) NOT NULL DEFAULT '0' COMMENT '结束状态 0未结束 1结束',
  `aid` int(11) NOT NULL COMMENT '发布者',
  PRIMARY KEY (`mid`),
  KEY `sid` (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='拍卖会表' ;

# 数据库表：on_member 结构信息
DROP TABLE IF EXISTS `on_member`;
CREATE TABLE `on_member` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `weibo_uid` varchar(15) DEFAULT NULL COMMENT '对应的新浪微博uid',
  `tencent_uid` varchar(20) DEFAULT NULL COMMENT '腾讯微博UID',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱地址',
  `account` varchar(20) DEFAULT NULL COMMENT '登录账号',
  `nickname` varchar(20) DEFAULT NULL COMMENT '用户昵称',
  `organization` varchar(100) NOT NULL COMMENT '机构组织',
  `intro` varchar(255) NOT NULL COMMENT '机构简介',
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
  `intr` varchar(500) DEFAULT NULL COMMENT '个人介绍',
  `phone` varchar(30) DEFAULT NULL COMMENT '电话',
  `fax` varchar(30) DEFAULT NULL,
  `qq` int(15) DEFAULT NULL,
  `msn` varchar(100) DEFAULT NULL,
  `wallet_pledge` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金账户',
  `wallet_pledge_freeze` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金冻结金额',
  `wallet_limsum` float(10,2) NOT NULL COMMENT '信用额度',
  `wallet_limsum_freeze` float(10,2) NOT NULL COMMENT '信用冻结额度',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '卖家得分',
  `scorebuy` int(11) NOT NULL DEFAULT '0' COMMENT '买家得分',
  `login_ip` varchar(15) DEFAULT NULL COMMENT '登录ip',
  `login_time` int(10) DEFAULT NULL COMMENT '登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `weiauto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1：自动登陆；0：手动登陆',
  `alerttype` varchar(30) NOT NULL COMMENT '提醒方式（email，mobile，weixin）',
  PRIMARY KEY (`uid`),
  KEY `account` (`account`),
  KEY `email` (`email`),
  KEY `account_2` (`account`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=526 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站前台会员表' ;

# 数据库表：on_member_evaluate 结构信息
DROP TABLE IF EXISTS `on_member_evaluate`;
CREATE TABLE `on_member_evaluate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '评价所属人',
  `sellerid` int(11) NOT NULL COMMENT '卖家id',
  `pid` int(11) NOT NULL COMMENT '拍品id',
  `score` tinyint(1) NOT NULL COMMENT '得分：0差评；1中评；2好评',
  `evaluate` varchar(255) NOT NULL COMMENT '评价内容',
  `time` int(10) NOT NULL COMMENT '评价时间',
  `order_no` varchar(100) NOT NULL COMMENT '对应订单',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='卖家对用户的评价' ;

# 数据库表：on_member_limsum_bill 结构信息
DROP TABLE IF EXISTS `on_member_limsum_bill`;
CREATE TABLE `on_member_limsum_bill` (
  `order_no` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `changetype` varchar(20) NOT NULL COMMENT '竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 支付充值pay_deposit 支付扣除pay_deduct  提现extract',
  `time` int(10) DEFAULT NULL COMMENT '操作时间',
  `annotation` text COMMENT '记录操作说明',
  `income` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户收入',
  `expend` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户支出',
  KEY `order_no` (`order_no`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户信用额度账单' ;

# 数据库表：on_member_pledge_bill 结构信息
DROP TABLE IF EXISTS `on_member_pledge_bill`;
CREATE TABLE `on_member_pledge_bill` (
  `order_no` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `changetype` varchar(20) NOT NULL COMMENT '竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 支付充值pay_deposit 支付扣除pay_deduct  提现extract',
  `time` int(10) DEFAULT NULL COMMENT '操作时间',
  `annotation` text COMMENT '记录操作说明',
  `income` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户收入',
  `expend` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户支出',
  KEY `order_no` (`order_no`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户保证金账单' ;

# 数据库表：on_member_pledge_take 结构信息
DROP TABLE IF EXISTS `on_member_pledge_take`;
CREATE TABLE `on_member_pledge_take` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '提现用户',
  `money` float(10,2) NOT NULL COMMENT '金额',
  `bank` varchar(20) NOT NULL COMMENT '银行',
  `bankhome` varchar(255) NOT NULL COMMENT '开户行',
  `name` varchar(10) NOT NULL COMMENT '体现人名',
  `account` varchar(30) NOT NULL COMMENT '账号',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `time` int(10) NOT NULL COMMENT '时间',
  `dtime` int(10) NOT NULL COMMENT '处理时间',
  `cause` varchar(255) NOT NULL COMMENT '备注、原因',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0等待退款；1已退款；2驳回提现',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户提现账单' ;

# 数据库表：on_member_weixin 结构信息
DROP TABLE IF EXISTS `on_member_weixin`;
CREATE TABLE `on_member_weixin` (
  `openid` varchar(60) NOT NULL COMMENT '微信标示',
  `uid` int(11) NOT NULL COMMENT '对应用户表id',
  `nickname` varchar(20) NOT NULL COMMENT '微信昵称',
  `sex` tinyint(1) NOT NULL COMMENT '微信性别',
  `city` varchar(16) NOT NULL COMMENT '微信城市',
  `country` varchar(40) NOT NULL COMMENT '国家',
  `province` varchar(16) NOT NULL COMMENT '省份',
  `language` varchar(10) NOT NULL COMMENT '使用语言',
  `headimgurl` text NOT NULL COMMENT '微信头像地址',
  `subscribe_time` int(10) NOT NULL COMMENT '关注时间',
  `unionid` varchar(60) NOT NULL COMMENT '未用到备用',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `groupid` int(11) NOT NULL COMMENT '分组id',
  `weitime` int(10) NOT NULL COMMENT '微信登陆时间',
  UNIQUE KEY `openid_2` (`openid`),
  KEY `openid` (`openid`),
  KEY `uid` (`uid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信用户表' ;

# 数据库表：on_mysms 结构信息
DROP TABLE IF EXISTS `on_mysms`;
CREATE TABLE `on_mysms` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '收件人id',
  `rsid` int(11) NOT NULL COMMENT '回复消息的sid',
  `sendid` int(11) NOT NULL COMMENT '发送人id',
  `aid` int(11) NOT NULL COMMENT '管理员id',
  `pid` int(11) NOT NULL COMMENT '对应拍品的pid',
  `type` varchar(20) NOT NULL COMMENT '消息类型',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '信息状态0：未读；1：已读；',
  `delmark` tinyint(1) NOT NULL COMMENT '删除标记 1：设置删除',
  `content` text NOT NULL COMMENT '信息内容',
  `time` int(10) NOT NULL COMMENT '接收时间',
  PRIMARY KEY (`sid`),
  KEY `uid` (`uid`),
  KEY `sendid` (`sendid`),
  KEY `aid` (`aid`),
  KEY `time` (`time`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=607 DEFAULT CHARSET=utf8 COMMENT='用户消息提醒' ;

# 数据库表：on_navigation 结构信息
DROP TABLE IF EXISTS `on_navigation`;
CREATE TABLE `on_navigation` (
  `lid` int(5) NOT NULL AUTO_INCREMENT,
  `pid` int(5) DEFAULT NULL COMMENT '上级导航',
  `name` varchar(20) DEFAULT NULL COMMENT '导航名称',
  `target` varchar(10) NOT NULL DEFAULT '_self' COMMENT '_blank:新窗口；_self:当前窗口',
  `url` varchar(255) NOT NULL DEFAULT 'javascript:void(0);' COMMENT '链接地址',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站导航链接表' ;

# 数据库表：on_news 结构信息
DROP TABLE IF EXISTS `on_news`;
CREATE TABLE `on_news` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cid` smallint(3) DEFAULT NULL COMMENT '所在分类',
  `title` varchar(200) DEFAULT NULL COMMENT '新闻标题',
  `picture` varchar(255) NOT NULL COMMENT '文章图片show',
  `keywords` varchar(50) DEFAULT NULL COMMENT '文章关键字',
  `description` mediumtext COMMENT '文章描述',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `summary` varchar(255) DEFAULT NULL COMMENT '文章摘要',
  `published` int(10) DEFAULT NULL COMMENT '发布时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `content` text COMMENT '文章内容',
  `aid` smallint(3) DEFAULT NULL COMMENT '发布者UID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='新闻表' ;

# 数据库表：on_node 结构信息
DROP TABLE IF EXISTS `on_node`;
CREATE TABLE `on_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=128 DEFAULT CHARSET=utf8 COMMENT='权限节点表' ;

# 数据库表：on_order_break 结构信息
DROP TABLE IF EXISTS `on_order_break`;
CREATE TABLE `on_order_break` (
  `order_no` varchar(100) NOT NULL COMMENT '订单号',
  `pledge` decimal(10,2) NOT NULL COMMENT '保证金',
  `limsum` decimal(10,2) NOT NULL COMMENT '信誉额度',
  `time` int(10) NOT NULL COMMENT '收入时间',
  `how` varchar(4) NOT NULL COMMENT '角色，buy：买家 sel：卖家',
  KEY `order_no` (`order_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单违约网站收入' ;

# 数据库表：on_payorder 结构信息
DROP TABLE IF EXISTS `on_payorder`;
CREATE TABLE `on_payorder` (
  `bill_no` varchar(100) NOT NULL COMMENT '支付订单号',
  `order_no` varchar(100) NOT NULL COMMENT '本站订单号',
  `purpose` varchar(10) NOT NULL COMMENT '支付用途',
  `useid` int(11) NOT NULL COMMENT '支付用途的id号，如：拍品id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `money` decimal(10,2) NOT NULL COMMENT '在线支付金额',
  `yuemn` decimal(10,2) NOT NULL COMMENT '使用余额支付多少',
  `pledge` decimal(10,2) NOT NULL COMMENT '使用保证金支付多少',
  `paytype` varchar(20) NOT NULL COMMENT '支付方式',
  `title` varchar(255) NOT NULL COMMENT '订单标题',
  `return_url` varchar(255) NOT NULL COMMENT '同步返回页面',
  `show_url` varchar(255) NOT NULL COMMENT '商品展示地址以http://',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态0：未支付：1：已支付',
  `create_time` int(11) NOT NULL COMMENT '订单生成时间',
  `update_time` int(11) NOT NULL COMMENT '订单更新时间',
  KEY `bill_no` (`bill_no`),
  KEY `order_no` (`order_no`),
  KEY `status` (`status`),
  KEY `create_time` (`create_time`),
  KEY `update_time` (`update_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付订单' ;

# 数据库表：on_region 结构信息
DROP TABLE IF EXISTS `on_region`;
CREATE TABLE `on_region` (
  `region_id` double NOT NULL,
  `region_code` varchar(100) NOT NULL,
  `region_name` varchar(100) NOT NULL,
  `parent_id` double NOT NULL,
  `region_level` double NOT NULL,
  `region_order` double NOT NULL,
  `region_name_en` varchar(100) NOT NULL,
  `region_shortname_en` varchar(10) NOT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='地区表' ;

# 数据库表：on_role 结构信息
DROP TABLE IF EXISTS `on_role`;
CREATE TABLE `on_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='权限角色表' ;

# 数据库表：on_role_user 结构信息
DROP TABLE IF EXISTS `on_role_user`;
CREATE TABLE `on_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色表' ;

# 数据库表：on_scheduled 结构信息
DROP TABLE IF EXISTS `on_scheduled`;
CREATE TABLE `on_scheduled` (
  `pid` int(11) NOT NULL COMMENT '拍品pid',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `stype` varchar(5) NOT NULL COMMENT '提醒类型（fut:开拍提醒，ing：结束提醒）',
  `time` int(10) NOT NULL COMMENT '提醒时间',
  KEY `pid` (`pid`),
  KEY `uid` (`uid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='拍品开拍结束提醒表' ;

# 数据库表：on_seller_pledge 结构信息
DROP TABLE IF EXISTS `on_seller_pledge`;
CREATE TABLE `on_seller_pledge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sellerid` int(11) NOT NULL COMMENT '商户UID',
  `pid` int(11) NOT NULL COMMENT '拍品id',
  `type` varchar(15) NOT NULL COMMENT '[seller_pledge_disposable]一次性缴纳；[seller_pledge_every]每件缴纳；[seller_pledge_proportion]按照起拍比例缴纳',
  `pledge` decimal(10,2) NOT NULL COMMENT '保证金',
  `limsum` decimal(10,2) NOT NULL COMMENT '信誉额度',
  `time` int(10) NOT NULL COMMENT '缴纳时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '记录是否有效，1有效；0无效',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `sellerid` (`sellerid`),
  KEY `type` (`type`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='商家保证金表' ;

# 数据库表：on_share 结构信息
DROP TABLE IF EXISTS `on_share`;
CREATE TABLE `on_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `terrace` varchar(20) NOT NULL COMMENT '分享平台',
  `title` varchar(255) NOT NULL COMMENT '分享链接名称',
  `link` varchar(255) NOT NULL COMMENT '分享链接',
  `limsum` decimal(10,2) NOT NULL COMMENT '奖励信誉额度',
  `time` int(10) NOT NULL COMMENT '分享时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分享记录表' ;

# 数据库表：on_special_auction 结构信息
DROP TABLE IF EXISTS `on_special_auction`;
CREATE TABLE `on_special_auction` (
  `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '专场id',
  `sname` varchar(200) NOT NULL COMMENT '专场名',
  `spicture` text NOT NULL COMMENT '专场图',
  `sbanner` text NOT NULL COMMENT '专场banner',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `starttime` int(10) NOT NULL COMMENT '开始时间',
  `endtime` int(10) NOT NULL COMMENT '结束时间',
  `special_pledge_type` tinyint(1) NOT NULL COMMENT '保证金扣除模式',
  `spledge` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '保证金',
  `scount` int(11) NOT NULL COMMENT '专场出价次数',
  `aid` int(11) NOT NULL COMMENT '发布者',
  PRIMARY KEY (`sid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='专场表' ;

# 数据库表：on_verify_email 结构信息
DROP TABLE IF EXISTS `on_verify_email`;
CREATE TABLE `on_verify_email` (
  `email` varchar(100) NOT NULL COMMENT '邮箱',
  `code` char(10) NOT NULL COMMENT '验证码',
  `time` int(10) NOT NULL COMMENT '发送时间',
  `losetime` int(10) NOT NULL COMMENT '过期时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邮箱验证表' ;

# 数据库表：on_verify_mobile 结构信息
DROP TABLE IF EXISTS `on_verify_mobile`;
CREATE TABLE `on_verify_mobile` (
  `mobile` varchar(100) NOT NULL COMMENT '手机',
  `code` char(10) NOT NULL COMMENT '验证码',
  `time` int(10) NOT NULL COMMENT '发送时间',
  `losetime` int(10) NOT NULL COMMENT '过期时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='手机验证表' ;

# 数据库表：on_weiurl 结构信息
DROP TABLE IF EXISTS `on_weiurl`;
CREATE TABLE `on_weiurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL COMMENT '类型：auction 拍卖；article文章；',
  `rid` int(11) NOT NULL COMMENT '对应的id',
  `sellerid` int(11) NOT NULL COMMENT '卖家id',
  `url` text NOT NULL COMMENT 'url地址',
  `name` varchar(20) NOT NULL COMMENT '链接名称',
  `comment` varchar(255) NOT NULL COMMENT '链接描述',
  `toppic` varchar(255) NOT NULL COMMENT '头条图片',
  `picture` varchar(255) NOT NULL COMMENT '图文图片',
  `succount` int(11) NOT NULL COMMENT '成功推送统计',
  `errcount` int(11) NOT NULL COMMENT '推送失败统计',
  `status` tinyint(1) NOT NULL COMMENT '链接状态',
  PRIMARY KEY (`id`),
  KEY `sellerid` (`sellerid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ;



# 数据库表：on_access 数据信息
INSERT INTO `on_access` VALUES ('3','62','3','50','');
INSERT INTO `on_access` VALUES ('3','61','3','50','');
INSERT INTO `on_access` VALUES ('3','60','3','50','');
INSERT INTO `on_access` VALUES ('3','59','3','50','');
INSERT INTO `on_access` VALUES ('3','58','3','50','');
INSERT INTO `on_access` VALUES ('3','57','3','50','');
INSERT INTO `on_access` VALUES ('3','56','3','50','');
INSERT INTO `on_access` VALUES ('3','55','3','50','');
INSERT INTO `on_access` VALUES ('3','54','3','50','');
INSERT INTO `on_access` VALUES ('3','53','3','50','');
INSERT INTO `on_access` VALUES ('3','52','3','50','');
INSERT INTO `on_access` VALUES ('3','51','3','50','');
INSERT INTO `on_access` VALUES ('3','50','2','1','');
INSERT INTO `on_access` VALUES ('3','14','2','1','');
INSERT INTO `on_access` VALUES ('4','7','3','3','');
INSERT INTO `on_access` VALUES ('4','3','2','1','');
INSERT INTO `on_access` VALUES ('4','6','3','2','');
INSERT INTO `on_access` VALUES ('4','5','3','2','');
INSERT INTO `on_access` VALUES ('4','2','2','1','');
INSERT INTO `on_access` VALUES ('4','1','1','0','');
INSERT INTO `on_access` VALUES ('2','119','3','114','');
INSERT INTO `on_access` VALUES ('2','118','3','114','');
INSERT INTO `on_access` VALUES ('2','117','3','114','');
INSERT INTO `on_access` VALUES ('2','116','3','114','');
INSERT INTO `on_access` VALUES ('2','115','3','114','');
INSERT INTO `on_access` VALUES ('2','114','2','1','');
INSERT INTO `on_access` VALUES ('3','13','3','4','');
INSERT INTO `on_access` VALUES ('3','12','3','4','');
INSERT INTO `on_access` VALUES ('3','11','3','4','');
INSERT INTO `on_access` VALUES ('3','10','3','4','');
INSERT INTO `on_access` VALUES ('3','4','2','1','');
INSERT INTO `on_access` VALUES ('3','7','3','3','');
INSERT INTO `on_access` VALUES ('3','3','2','1','');
INSERT INTO `on_access` VALUES ('3','6','3','2','');
INSERT INTO `on_access` VALUES ('3','5','3','2','');
INSERT INTO `on_access` VALUES ('3','2','2','1','');
INSERT INTO `on_access` VALUES ('3','1','1','0','');
INSERT INTO `on_access` VALUES ('2','94','3','90','');
INSERT INTO `on_access` VALUES ('2','93','3','90','');
INSERT INTO `on_access` VALUES ('2','92','3','90','');
INSERT INTO `on_access` VALUES ('2','91','3','90','');
INSERT INTO `on_access` VALUES ('2','90','2','1','');
INSERT INTO `on_access` VALUES ('2','86','3','81','');
INSERT INTO `on_access` VALUES ('2','82','3','81','');
INSERT INTO `on_access` VALUES ('2','81','2','1','');
INSERT INTO `on_access` VALUES ('2','80','3','76','');
INSERT INTO `on_access` VALUES ('2','79','3','76','');
INSERT INTO `on_access` VALUES ('2','78','3','76','');
INSERT INTO `on_access` VALUES ('2','77','3','76','');
INSERT INTO `on_access` VALUES ('2','76','2','1','');
INSERT INTO `on_access` VALUES ('2','75','3','69','');
INSERT INTO `on_access` VALUES ('2','74','3','69','');
INSERT INTO `on_access` VALUES ('2','73','3','69','');
INSERT INTO `on_access` VALUES ('2','72','3','69','');
INSERT INTO `on_access` VALUES ('2','71','3','69','');
INSERT INTO `on_access` VALUES ('2','70','3','69','');
INSERT INTO `on_access` VALUES ('2','69','2','1','');
INSERT INTO `on_access` VALUES ('2','110','3','63','');
INSERT INTO `on_access` VALUES ('2','109','3','63','');
INSERT INTO `on_access` VALUES ('2','108','3','63','');
INSERT INTO `on_access` VALUES ('2','107','3','63','');
INSERT INTO `on_access` VALUES ('2','106','3','63','');
INSERT INTO `on_access` VALUES ('2','105','3','63','');
INSERT INTO `on_access` VALUES ('2','104','3','63','');
INSERT INTO `on_access` VALUES ('2','103','3','63','');
INSERT INTO `on_access` VALUES ('2','102','3','63','');
INSERT INTO `on_access` VALUES ('2','68','3','63','');
INSERT INTO `on_access` VALUES ('2','67','3','63','');
INSERT INTO `on_access` VALUES ('2','66','3','63','');
INSERT INTO `on_access` VALUES ('2','65','3','63','');
INSERT INTO `on_access` VALUES ('2','64','3','63','');
INSERT INTO `on_access` VALUES ('2','63','2','1','');
INSERT INTO `on_access` VALUES ('2','111','3','50','');
INSERT INTO `on_access` VALUES ('2','62','3','50','');
INSERT INTO `on_access` VALUES ('2','61','3','50','');
INSERT INTO `on_access` VALUES ('2','60','3','50','');
INSERT INTO `on_access` VALUES ('2','59','3','50','');
INSERT INTO `on_access` VALUES ('2','58','3','50','');
INSERT INTO `on_access` VALUES ('2','57','3','50','');
INSERT INTO `on_access` VALUES ('2','56','3','50','');
INSERT INTO `on_access` VALUES ('2','55','3','50','');
INSERT INTO `on_access` VALUES ('2','54','3','50','');
INSERT INTO `on_access` VALUES ('2','53','3','50','');
INSERT INTO `on_access` VALUES ('2','52','3','50','');
INSERT INTO `on_access` VALUES ('2','51','3','50','');
INSERT INTO `on_access` VALUES ('2','50','2','1','');
INSERT INTO `on_access` VALUES ('2','44','3','32','');
INSERT INTO `on_access` VALUES ('2','35','3','32','');
INSERT INTO `on_access` VALUES ('2','33','3','32','');
INSERT INTO `on_access` VALUES ('2','32','2','1','');
INSERT INTO `on_access` VALUES ('2','31','3','26','');
INSERT INTO `on_access` VALUES ('2','30','3','26','');
INSERT INTO `on_access` VALUES ('2','29','3','26','');
INSERT INTO `on_access` VALUES ('2','28','3','26','');
INSERT INTO `on_access` VALUES ('2','27','3','26','');
INSERT INTO `on_access` VALUES ('2','26','2','1','');
INSERT INTO `on_access` VALUES ('2','24','3','14','');
INSERT INTO `on_access` VALUES ('2','23','3','14','');
INSERT INTO `on_access` VALUES ('2','16','3','14','');
INSERT INTO `on_access` VALUES ('2','15','3','14','');
INSERT INTO `on_access` VALUES ('2','9','3','14','');
INSERT INTO `on_access` VALUES ('2','8','3','14','');
INSERT INTO `on_access` VALUES ('2','14','2','1','');
INSERT INTO `on_access` VALUES ('2','100','3','4','');
INSERT INTO `on_access` VALUES ('2','96','3','4','');
INSERT INTO `on_access` VALUES ('2','95','3','4','');
INSERT INTO `on_access` VALUES ('2','10','3','4','');
INSERT INTO `on_access` VALUES ('2','4','2','1','');
INSERT INTO `on_access` VALUES ('2','125','3','3','');
INSERT INTO `on_access` VALUES ('2','124','3','3','');
INSERT INTO `on_access` VALUES ('2','123','3','3','');
INSERT INTO `on_access` VALUES ('2','122','3','3','');
INSERT INTO `on_access` VALUES ('2','101','3','3','');
INSERT INTO `on_access` VALUES ('2','49','3','3','');
INSERT INTO `on_access` VALUES ('3','111','3','50','');
INSERT INTO `on_access` VALUES ('2','48','3','3','');
INSERT INTO `on_access` VALUES ('2','47','3','3','');
INSERT INTO `on_access` VALUES ('2','46','3','3','');
INSERT INTO `on_access` VALUES ('2','45','3','3','');
INSERT INTO `on_access` VALUES ('2','7','3','3','');
INSERT INTO `on_access` VALUES ('2','3','2','1','');
INSERT INTO `on_access` VALUES ('2','6','3','2','');
INSERT INTO `on_access` VALUES ('2','5','3','2','');
INSERT INTO `on_access` VALUES ('2','2','2','1','');
INSERT INTO `on_access` VALUES ('2','1','1','0','');


# 数据库表：on_admin 数据信息
INSERT INTO `on_admin` VALUES ('1','超级管理员','jzbis@sina.com','14e1b600b1fd579f47433b88e8d85291','1','我是超级管理员 哈哈~~','','1485135011');


# 数据库表：on_advertising 数据信息
INSERT INTO `on_advertising` VALUES ('1','2','首页幻灯001','Advertising/20160521/573fcc546cc2c.jpg','1','1','http://www.baidu.com','0','首页幻灯片001dfg','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('2','2','首页幻灯002','Advertising/20140831/54032ed8b5978.jpg','1','1','','0','首页幻灯002','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('3','2','首页幻灯003','Advertising/20140831/5402d31d32bb8.jpg','1','1','','0','首页幻灯003','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('4','2','首页幻灯004','Advertising/20141002/542cae920a280.jpg','1','1','','0','首页幻灯004','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('5','1','网站logo','Advertising/20140719/53ca26570df70.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('6','3','网站_宽_logo_右侧','Advertising/20140719/53ca26e70e358.png','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('7','4','首页—公告上部','Advertising/20140711/53bf3d40209e0.png','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('8','5','拍卖列表&lt;上方&gt;','Advertising/20140811/53e8283b13ec0.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('9','6','拍卖列表&lt;中部&gt;','Advertising/20140811/53e86bec9c658.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('10','7','拍卖列表&lt;下方&gt;','Advertising/20140811/53e88359ef100.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('11','8','拍卖列表四方图&lt;1&gt;','Advertising/20140811/53e887b499200.jpg','1','1','','0','考虑撒娇的疯狂','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('12','8','拍卖列表四方图&lt;2&gt;','Advertising/20140811/53e887f55fff0.jpg','1','1','','0','说大法师打发斯蒂芬','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('13','8','拍卖列表四方图&lt;3&gt;','Advertising/20140811/53e8884f3bdd0.jpg','1','1','','0','阿斯顿发斯蒂芬梵蒂冈','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('14','8','拍卖列表四方图&lt;4&gt;','Advertising/20140811/53e8886b54c40.jpg','1','1','','0','阿斯顿发斯蒂芬','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('15','9','公共底部--文章列表右侧','Advertising/20140813/53eb38552fa80.png','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('16','10','微信二维码','Advertising/20141002/542cb315abc70.jpg','1','1','http://www.baidu.com','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('17','11','注册页---注册有礼','Advertising/20140827/53fd3c6b25f08.png','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('18','12','拍品详细页广告','Advertising/20160625/576df3a26575c.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('19','13','注册页面广告','Advertising/20140826/53fc3f7794a20.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('20','14','网站文章列表页右侧','Advertising/20140908/540d71a990c68.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('21','15','最近成交页面广告','Advertising/20141009/5436966050cf8.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('22','0','最近成交页面头部广告','Advertising/20141009/543696b691820.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('23','16','专场首页顶部广告','Advertising/20141018/5441c8b6e1af0.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('24','17','拍卖会顶部广告','Advertising/20160516/5739430280023.jpg','1','1','','0','','0','0','0','0');
INSERT INTO `on_advertising` VALUES ('25','18','拍品详细页—竞拍流程广告','Advertising/20160625/576df2593a0b8.jpg','1','1','','0','拍卖流程','0','0','0','0');


# 数据库表：on_advertising_position 数据信息
INSERT INTO `on_advertising_position` VALUES ('1','web_logo','网站—logo','200','70','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('2','index_slides','首页—幻灯片','683','353','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('3','web_logo_right','网站_宽_logo_右侧','290','70','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('4','index_notice_top','首页—公告上部','279','65','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('5','auction_list_a','正在拍卖列表--上方','1200','90','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('6','auction_list_b','正在拍卖列表--中部','1200','90','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('7','auction_list_c','正在拍卖列表--下方','1200','90','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('8','auction_list_d','正在拍卖列表--四个方图','288','146','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('9','common_help_right','公共底部--文章列表右侧','270','130','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('10','weixin','微信二维码','80','80','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('11','logadd','注册页广告','300','210','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('12','details_add','拍品详细页—竞拍流程广告','1200','65','0','redfocus','<table cellpadding=\"0\" cellspacing=\"0\">
<tr>
<foreach name=\"adv_list\" item=\"adv\">
<td>{$adv.html}</td>
</foreach>
</tr>
</table>');
INSERT INTO `on_advertising_position` VALUES ('13','register_add','注册页面广告','1000','92','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('14','artice_right','网站文章列表页右侧','250','250','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('15','endall_list_a','最近成交页面头部广告','1200','90','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('16','auction_special_top','专场首页顶部广告','1200','90','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');
INSERT INTO `on_advertising_position` VALUES ('17','auction_meeting_top','拍卖会顶部广告','1200','90','0','redfocus','<table cellpadding="0" cellspacing="0"><tr><foreach name="adv_list" item="adv"><td>{$adv.html}</td></foreach></tr></table>');


# 数据库表：on_attention 数据信息
INSERT INTO `on_attention` VALUES ('23','525','p-u');


# 数据库表：on_attention_seller 数据信息


# 数据库表：on_auction 数据信息
INSERT INTO `on_auction` VALUES ('1','1','0','0','M1-1481165922','0','0','0.00','100.00','0','0','卡拉斯经典款浪费骄傲sd卡浪费','500.00','500.00','500.00','1481165880','1481166300','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','3','0','0');
INSERT INTO `on_auction` VALUES ('2','2','0','0','M2-1481166127','0','0','0.00','100.00','0','0','啥快递龙卷风卡拉斯蒂芬将快乐','200.00','200.00','200.00','1481166060','1481166540','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','1','0','0');
INSERT INTO `on_auction` VALUES ('3','3','0','0','M3-1481166827','0','0','0.00','200.00','0','0','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','600.00','600.00','600.00','1481166780','1481169000','1','1','fixation','ratio','20.00','50.00','120','300','0','0','0.00','0','3','0','0','0');
INSERT INTO `on_auction` VALUES ('4','4','0','0','M4-1481250319','0','0','0.00','100.00','0','0','了空间按快了速度激发垃圾似的','200.00','200.00','200.00','1481250300','1481250480','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','3','0','0');
INSERT INTO `on_auction` VALUES ('5','5','0','0','M5-1481252528','0','0','0.00','20.00','0','0','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','300.00','300.00','300.00','1481252460','1481254002','1','1','fixation','ratio','20.00','50.00','120','300','0','0','0.00','0','4','1','0','0');
INSERT INTO `on_auction` VALUES ('7','7','0','0','M7-1481593382','0','0','0.00','100.00','0','0','卡拉斯交电费卢卡斯交电费卡拉斯的','200.00','200.00','200.00','1481593320','1481593560','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','2','0','0');
INSERT INTO `on_auction` VALUES ('8','8','0','0','M8-1481593524','0','0','0.00','50.00','0','0','卡就死掉了咖啡将拉克丝的','300.00','300.00','300.00','1481593500','1481593680','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','4','0','0');
INSERT INTO `on_auction` VALUES ('9','6','0','0','M9-1481593582','0','0','0.00','20.00','0','0','克拉的肌肤看见了快递劫匪','10.00','10.00','10.00','1481593560','1481593800','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','1','0','0');
INSERT INTO `on_auction` VALUES ('10','9','0','0','M10-1481794743','0','0','0.00','50.00','0','0','卡就死掉了咖啡将拉克丝的','300.00','300.00','300.00','1481794680','1481881320','1','1','fixation','ratio','20.00','600.00','120','300','180','0','0.00','1','1','5','0','0');
INSERT INTO `on_auction` VALUES ('11','6','0','0','M11-1481794821','0','0','0.00','10.00','0','0','克拉的肌肤看见了快递劫匪','10.00','10.00','10.00','1481794800','1481794980','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','4','0','0');
INSERT INTO `on_auction` VALUES ('12','4','0','0','M12-1481794943','0','0','0.00','20.00','0','0','了空间按快了速度激发垃圾似的','200.00','200.00','200.00','1481794920','1481795100','1','1','fixation','ratio','20.00','600.00','120','300','180','0','0.00','1','1','16','0','0');
INSERT INTO `on_auction` VALUES ('13','6','0','0','M13-1481795853','0','0','0.00','100.00','0','0','克拉的肌肤看见了快递劫匪','10.00','10.00','10.00','1481795820','1481796240','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','3','0','0');
INSERT INTO `on_auction` VALUES ('14','3','0','0','M14-1481795946','0','0','0.00','10.00','0','0','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','600.00','600.00','600.00','1481795880','1481796360','1','1','fixation','ratio','20.00','50.00','120','300','180','0','0.00','1','1','9','0','0');
INSERT INTO `on_auction` VALUES ('15','6','0','0','M15-1481940375','0','0','0.00','100.00','0','0','克拉的肌肤看见了快递劫匪','10.00','10.00','10.00','1481940360','1483063560','1','1','fixation','ratio','20.00','50.00','120','300','0','0','0.00','0','3','50','0','0');
INSERT INTO `on_auction` VALUES ('16','10','0','0','M16-1482312443','0','0','0.00','10.00','0','0','阿里斯顿疯狂辣椒水电费','200.00','200.00','200.00','1482312180','1483089780','1','1','fixation','ratio','20.00','50.00','120','300','0','0','0.00','0','3','8','0','0');
INSERT INTO `on_auction` VALUES ('17','8','1','0','M17-1482760538','0','0','0.00','10.00','1','0','卡就死掉了咖啡将拉克丝的','300.00','300.00','301.00','1482760440','1482760800','20,1,1000,2000','0','fixation','ratio','20.00','0.00','120','300','524','0','0.00','2','1','6','0','1');
INSERT INTO `on_auction` VALUES ('18','7','1','0','M18-1482760556','0','0','0.00','10.00','1','0','卡拉斯交电费卢卡斯交电费卡拉斯的','200.00','200.00','201.00','1482760440','1482760800','20,1,1000,2000','0','fixation','ratio','20.00','0.00','120','300','524','0','0.00','2','1','34','0','1');
INSERT INTO `on_auction` VALUES ('19','5','1','0','M19-1482760573','0','0','0.00','10.00','1','0','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','300.00','300.00','301.00','1482760440','1482760800','20,1,1000,2000','0','fixation','ratio','20.00','0.00','120','300','524','0','0.00','2','1','4','0','1');
INSERT INTO `on_auction` VALUES ('20','9','5','0','M20-1483496550','0','0','0.00','100.00','1','0','卡就死掉了咖啡将拉克丝的','300.00','300.00','300.00','1483416480','1484971680','20,1,1000,2000','0','fixation','ratio','20.00','0.00','120','300','0','0','0.00','0','3','13','0','1');
INSERT INTO `on_auction` VALUES ('21','3','5','0','M21-1483496574','0','0','0.00','100.00','1','0','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','600.00','600.00','600.00','1483416480','1484971680','20,1,1000,2000','0','fixation','ratio','20.00','0.00','120','300','0','0','0.00','0','3','12','0','1');
INSERT INTO `on_auction` VALUES ('22','1','5','0','M22-1483496589','0','0','0.00','100.00','1','0','卡拉斯经典款浪费骄傲sd卡浪费','500.00','500.00','500.00','1483416480','1484971680','20,1,1000,2000','0','fixation','ratio','20.00','0.00','120','300','0','0','0.00','0','3','2','0','1');
INSERT INTO `on_auction` VALUES ('23','6','6','0','M23-1483496602','0','0','0.00','100.00','1','0','克拉的肌肤看见了快递劫匪','10.00','10.00','11.00','1483676100','1484885760','20,1,1000,2000','0','fixation','ratio','20.00','0.00','120','300','523','523','600.00','2','1','19','0','1');
INSERT INTO `on_auction` VALUES ('24','4','5','0','M24-1483496613','0','0','0.00','0.00','1','0','了空间按快了速度激发垃圾似的','200.00','200.00','200.00','1483416480','1484971680','20,1,1000,2000','0','fixation','ratio','20.00','0.00','120','300','0','0','0.00','0','3','7','0','1');
INSERT INTO `on_auction` VALUES ('25','12','0','0','M25-1483607602','0','0','0.00','100.00','0','0','顺口溜的卷发卡洛斯大姐夫','200.00','200.00','200.00','1483607580','1484298780','1','1','fixation','ratio','20.00','50.00','120','300','0','0','0.00','0','3','16','0','0');


# 数据库表：on_auction_agency 数据信息
INSERT INTO `on_auction_agency` VALUES ('23','523','600','1484041435','0');


# 数据库表：on_auction_pledge 数据信息


# 数据库表：on_auction_record 数据信息
INSERT INTO `on_auction_record` VALUES ('1','180','1481166046','0.00','500.00','手动');
INSERT INTO `on_auction_record` VALUES ('2','180','1481166141','0.00','200.00','手动');
INSERT INTO `on_auction_record` VALUES ('4','180','1481250359','0.00','200.00','手动');
INSERT INTO `on_auction_record` VALUES ('7','180','1481593433','0.00','200.00','手动');
INSERT INTO `on_auction_record` VALUES ('8','180','1481593543','0.00','300.00','手动');
INSERT INTO `on_auction_record` VALUES ('9','180','1481593594','0.00','10.00','手动');
INSERT INTO `on_auction_record` VALUES ('10','180','1481794787','0.00','300.00','手动');
INSERT INTO `on_auction_record` VALUES ('11','180','1481794836','0.00','10.00','手动');
INSERT INTO `on_auction_record` VALUES ('12','180','1481794954','0.00','200.00','手动');
INSERT INTO `on_auction_record` VALUES ('13','180','1481795868','0.00','10.00','手动');
INSERT INTO `on_auction_record` VALUES ('14','180','1481795959','0.00','600.00','手动');
INSERT INTO `on_auction_record` VALUES ('17','523','1482760596','0.00','300.00','手动');
INSERT INTO `on_auction_record` VALUES ('18','523','1482760610','0.00','200.00','手动');
INSERT INTO `on_auction_record` VALUES ('19','523','1482760622','0.00','300.00','手动');
INSERT INTO `on_auction_record` VALUES ('17','524','1482760648','1.00','301.00','手动');
INSERT INTO `on_auction_record` VALUES ('18','524','1482760662','1.00','201.00','手动');
INSERT INTO `on_auction_record` VALUES ('19','524','1482760672','1.00','301.00','手动');
INSERT INTO `on_auction_record` VALUES ('23','523','1484041091','1.00','11.00','手动');


# 数据库表：on_category 数据信息
INSERT INTO `on_category` VALUES ('1','0','底部、帮助文章列表-(不可删除)','4');
INSERT INTO `on_category` VALUES ('8','1','关于我们','1');
INSERT INTO `on_category` VALUES ('2','0','网站公告','3');
INSERT INTO `on_category` VALUES ('9','1','配送方式','0');
INSERT INTO `on_category` VALUES ('6','1','如何拍卖','3');
INSERT INTO `on_category` VALUES ('4','0','预留分类','5');
INSERT INTO `on_category` VALUES ('5','1','帮助中心','4');
INSERT INTO `on_category` VALUES ('3','0','拍卖资讯','2');
INSERT INTO `on_category` VALUES ('7','1','客服中心','2');


# 数据库表：on_deliver_address 数据信息
INSERT INTO `on_deliver_address` VALUES ('1','180','17','193','1959','南蒲区高店社区14号楼2单元502室','453400','占蛟','13803845077','8923288','1');
INSERT INTO `on_deliver_address` VALUES ('2','524','2','33','379','卡拉斯经典款垃圾啊手榴弹卡','450001','侯占蛟','13803656548','','1');


# 数据库表：on_express 数据信息
INSERT INTO `on_express` VALUES ('1','A','ANE','安能物流','0','0');
INSERT INTO `on_express` VALUES ('2','A','AXD','安信达快递','0','2');
INSERT INTO `on_express` VALUES ('3','B','BFDF','百福东方','0','2');
INSERT INTO `on_express` VALUES ('4','B','BQXHM','北青小红帽','0','0');
INSERT INTO `on_express` VALUES ('5','B','HTKY','百世汇通','0','0');
INSERT INTO `on_express` VALUES ('6','C','CCES','CCES快递','0','0');
INSERT INTO `on_express` VALUES ('7','C','CITY100','城市100','0','0');
INSERT INTO `on_express` VALUES ('8','C','COE','COE东方快递','0','2');
INSERT INTO `on_express` VALUES ('9','C','CSCY','长沙创一','0','0');
INSERT INTO `on_express` VALUES ('10','D','DBL','德邦','0','0');
INSERT INTO `on_express` VALUES ('11','D','DHL','DHL','0','0');
INSERT INTO `on_express` VALUES ('12','D','DSWL','D速物流','0','0');
INSERT INTO `on_express` VALUES ('13','D','DTWL','大田物流','0','2');
INSERT INTO `on_express` VALUES ('14','E','EMS','EMS','0','0');
INSERT INTO `on_express` VALUES ('15','F','FEDEX','FedEx联邦快递','0','0');
INSERT INTO `on_express` VALUES ('16','F','FKD','飞康达','0','0');
INSERT INTO `on_express` VALUES ('17','G','GDEMS','广东邮政','0','0');
INSERT INTO `on_express` VALUES ('18','G','GSD','共速达','0','0');
INSERT INTO `on_express` VALUES ('19','G','GTO','国通快递','0','0');
INSERT INTO `on_express` VALUES ('20','G','GTSD','高铁速递','0','0');
INSERT INTO `on_express` VALUES ('21','H','HFWL','汇丰物流','0','0');
INSERT INTO `on_express` VALUES ('22','H','HLWL','恒路物流','0','0');
INSERT INTO `on_express` VALUES ('23','H','HOAU','天地华宇','0','0');
INSERT INTO `on_express` VALUES ('24','H','hq568','华强物流','0','0');
INSERT INTO `on_express` VALUES ('25','H','HXLWL','华夏龙物流','0','0');
INSERT INTO `on_express` VALUES ('26','H','HYLSD','好来运快递','0','0');
INSERT INTO `on_express` VALUES ('27','H','ZHQKD','汇强快递','0','0');
INSERT INTO `on_express` VALUES ('28','J','JD','京东快递','0','0');
INSERT INTO `on_express` VALUES ('29','J','JGSD','京广速递','0','0');
INSERT INTO `on_express` VALUES ('30','J','JJKY','佳吉快运','0','0');
INSERT INTO `on_express` VALUES ('31','J','JTKD','捷特快递','0','0');
INSERT INTO `on_express` VALUES ('32','J','JXD','急先达','0','0');
INSERT INTO `on_express` VALUES ('33','J','JYKD','晋越快递','0','0');
INSERT INTO `on_express` VALUES ('34','J','JYM','加运美','0','0');
INSERT INTO `on_express` VALUES ('35','J','JYWL','佳怡物流','0','0');
INSERT INTO `on_express` VALUES ('36','K','FAST','快捷速递','0','0');
INSERT INTO `on_express` VALUES ('37','L','LB','龙邦快递','0','0');
INSERT INTO `on_express` VALUES ('38','L','LHT','联昊通速递','0','0');
INSERT INTO `on_express` VALUES ('39','M','MHKD','民航快递','0','0');
INSERT INTO `on_express` VALUES ('40','M','MLWL','明亮物流','0','0');
INSERT INTO `on_express` VALUES ('41','N','NEDA','能达速递','0','0');
INSERT INTO `on_express` VALUES ('42','Q','QCKD','全晨快递','0','0');
INSERT INTO `on_express` VALUES ('43','Q','QFKD','全峰快递','0','0');
INSERT INTO `on_express` VALUES ('44','Q','QRT','全日通快递','0','0');
INSERT INTO `on_express` VALUES ('45','Q','UAPEX','全一快递','0','0');
INSERT INTO `on_express` VALUES ('46','S','SAWL','圣安物流','0','0');
INSERT INTO `on_express` VALUES ('47','S','SDWL','上大物流','0','0');
INSERT INTO `on_express` VALUES ('48','S','SF','顺丰快递','0','0');
INSERT INTO `on_express` VALUES ('49','S','SFWL','盛丰物流','0','0');
INSERT INTO `on_express` VALUES ('50','S','SHWL','盛辉物流','0','0');
INSERT INTO `on_express` VALUES ('51','S','ST','速通物流','0','0');
INSERT INTO `on_express` VALUES ('52','S','STO','申通快递','0','0');
INSERT INTO `on_express` VALUES ('53','S','SURE','速尔快递','0','0');
INSERT INTO `on_express` VALUES ('54','T','TSSTO','唐山申通','0','0');
INSERT INTO `on_express` VALUES ('55','T','HHTT','天天快递','0','0');
INSERT INTO `on_express` VALUES ('56','W','WJWL','万家物流','0','0');
INSERT INTO `on_express` VALUES ('57','W','WXWL','万象物流','0','0');
INSERT INTO `on_express` VALUES ('58','X','XBWL','新邦物流','0','0');
INSERT INTO `on_express` VALUES ('59','X','XFEX','信丰快递','0','0');
INSERT INTO `on_express` VALUES ('60','X','XYT','希优特','0','0');
INSERT INTO `on_express` VALUES ('61','Y','YADEX','源安达快递','0','0');
INSERT INTO `on_express` VALUES ('62','Y','UC','优速快递','0','0');
INSERT INTO `on_express` VALUES ('63','Y','YCWL','远成物流','0','0');
INSERT INTO `on_express` VALUES ('64','Y','YD','韵达快递','7','2');
INSERT INTO `on_express` VALUES ('65','Y','YFEX','越丰物流','0','0');
INSERT INTO `on_express` VALUES ('66','Y','YFHEX','原飞航物流','0','0');
INSERT INTO `on_express` VALUES ('67','Y','YFSD','亚风快递','0','0');
INSERT INTO `on_express` VALUES ('68','Y','YTKD','运通快递','0','0');
INSERT INTO `on_express` VALUES ('69','Y','YTO','圆通速递','0','0');
INSERT INTO `on_express` VALUES ('70','Y','YZPY','邮政平邮/小包','0','0');
INSERT INTO `on_express` VALUES ('71','Z','ZENY','增益快递','0','0');
INSERT INTO `on_express` VALUES ('72','Z','ZJS','宅急送','0','0');
INSERT INTO `on_express` VALUES ('73','Z','ZTE','众通快递','0','0');
INSERT INTO `on_express` VALUES ('74','Z','ZTKY','中铁快运','0','0');
INSERT INTO `on_express` VALUES ('75','Z','ZTO','中通速递','0','0');
INSERT INTO `on_express` VALUES ('76','Z','ZTWL','中铁物流','0','0');
INSERT INTO `on_express` VALUES ('77','Z','ZYWL','中邮物流','0','0');


# 数据库表：on_feedback 数据信息
INSERT INTO `on_feedback` VALUES ('1','撒地方的','5');
INSERT INTO `on_feedback` VALUES ('2','报刊杂志','12');
INSERT INTO `on_feedback` VALUES ('3','实体广告','1');
INSERT INTO `on_feedback` VALUES ('4','亲朋介绍','4');
INSERT INTO `on_feedback` VALUES ('5','其他','3');


# 数据库表：on_goods 数据信息
INSERT INTO `on_goods` VALUES ('1','5','卡拉斯经典款浪费骄傲sd卡浪费','8_17_25_32_45_50','','卢卡斯将对方考虑将阿斯顿了咖啡机啊','500.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','4','39','455','Goods/20161208/5848cc0604ddf.jpg|Goods/20161208/5848cc07635e6.jpg|Goods/20161208/5848cc088ce39.jpg','1481165835','','1','');
INSERT INTO `on_goods` VALUES ('2','9','啥快递龙卷风卡拉斯蒂芬将快乐','8_18_3_35_45_53','','垃圾sd卡浪费就阿卡水电费','200.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','7','74','872','Goods/20161208/5848cd1380bf6.jpg|Goods/20161208/5848cd14bf825.jpg|Goods/20161208/5848cd15d6f64.jpg','1481166105','','1','');
INSERT INTO `on_goods` VALUES ('3','11','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','11_17_25_34_45_49','','辣椒水考虑打飞机卡拉胶三大类咖啡机考虑','600.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','8','87','973','Goods/20161208/5848cfd391e74.jpg|Goods/20161208/5848cfd52d957.JPG|Goods/20161208/5848cfd689e36.jpg','1481166810','','1','');
INSERT INTO `on_goods` VALUES ('4','8','了空间按快了速度激发垃圾似的','8_2_25_33_46_49','','啊时间到了福建按快了速度激发','200.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','9','99','1087','Goods/20161209/584a15f897748.jpg|Goods/20161209/584a15f9abbbe.jpg|Goods/20161209/584a15fadf43c.JPG','1481250301','','1','');
INSERT INTO `on_goods` VALUES ('5','57','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','59_75_81','','克拉就是快乐的骄傲收到了','300.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','0','0','0','Goods/20161209/584a1e8f51158.jpg|Goods/20161209/584a1e909bcf2.jpg|Goods/20161209/584a1e9207642.jpg','1481252500','','1','');
INSERT INTO `on_goods` VALUES ('6','62','克拉的肌肤看见了快递劫匪','59_75_83','','克拉斯记得付款垃圾速度开了房间阿里斯顿','10.00','<p><img src=\"/Uploads/Article/20161212/584e100c1f6f1.jpg\" title=\"GucnP_U471613T284844421396572702566.jpg\" style=\"width: 664px; height: 532px;\"/>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','0','0','0','Goods/20161209/584a1f5d5c819.jpg|Goods/20161209/584a1f5eadd2d.jpg|Goods/20161209/584a1f5fee0cd.jpg','1481252717','1481535537','1','1');
INSERT INTO `on_goods` VALUES ('7','6','卡拉斯交电费卢卡斯交电费卡拉斯的','8_18_29_34_45_52','','会计师的发生的痕迹咖啡哈快睡觉地方很近卡萨帝','200.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','8','87','973','Goods/20161213/584f520ee0568.jpg|Goods/20161213/584f520fef2ea.jpg|Goods/20161213/584f5210f299c.jpg','1481593362','','1','');
INSERT INTO `on_goods` VALUES ('8','58','卡就死掉了咖啡将拉克丝的','65_76_81','','绿卡就死掉了咖啡将阿里水电费将奥迪','300.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！</p><table><tbody><tr class=\"firstRow\"><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td></tr><tr><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td></tr><tr><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td><td width=\"157\" valign=\"top\"><br/></td></tr></tbody></table><p><br/></p>','0','0','0','Goods/20161213/584f5280062dd.jpg|Goods/20161213/584f52810ad4f.jpg|Goods/20161213/584f528223046.jpg','1481593496','1482221659','1','1');
INSERT INTO `on_goods` VALUES ('9','58','卡就死掉了咖啡将拉克丝的','65_76_81','','绿卡就死掉了咖啡将阿里水电费将奥迪','300.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','0','0','0','Goods/20161213/584f5280062dd.jpg|Goods/20161213/584f52810ad4f.jpg|Goods/20161213/584f528223046.jpg','1481593496','','1','');
INSERT INTO `on_goods` VALUES ('10','1','阿里斯顿疯狂辣椒水电费','8_18_24_34_46_51','','阿凡达是的发送到发送到','200.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','3','35','399','Goods/20161221/5859fb2275360.jpg|Goods/20161221/5859fb2371032.jpg','1482292005','','522','');
INSERT INTO `on_goods` VALUES ('11','7','卡拉胶sd卡浪费就阿克苏的解放军','1_2_3_4_5_6','','拉卡机sd卡浪费就阿喀琉斯点击率','100.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','3','35','398','Goods/20170104/586cbdc2a8f17.jpg|Goods/20170104/586cbdc4055e9.jpg|Goods/20170104/586cbdc51dc8b.jpg','1483521480','','1','');
INSERT INTO `on_goods` VALUES ('12','6','顺口溜的卷发卡洛斯大姐夫','10_20_25_4_46_52','','卡拉胶sd卡减肥卡拉较深的浪费空间','200.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','5','48','599','Goods/20170105/586e0e1930036.jpg|Goods/20170105/586e0e1ab8fbc.jpg|Goods/20170105/586e0e1c244d6.jpg','1483607582','1484365444','1','1');
INSERT INTO `on_goods` VALUES ('13','55','绿卡较深的咖啡机卡萨帝减肥了将','64_75_81','阿斯顿个撒旦刚发生大发','第三方嘎斯地打发斯蒂芬','0.00','<p>我是商品详情的默认值，每当发布商品时候我都会出现。你可以把我当成商品详情的模板，可以修改我达到快速发布的效果。</p><p>通常对于有网站商品有共同的商品参数或者内容的时候设置我可以快速发布商品！</p><p>如果不需要我，可以在登陆后台【商品管理】-》【扩展字段、默认值】中选择商品详情进行编辑！<br/></p>','0','0','0','Goods/20170113/5878446e31472.jpg|Goods/20170113/5878446fa5826.jpg|Goods/20170113/5878447157e57.jpg|Goods/20170113/58784472da886.jpg','1484276125','1484365379','1','1');


# 数据库表：on_goods_category 数据信息
INSERT INTO `on_goods_category` VALUES ('1','0','二手车','','0','3');
INSERT INTO `on_goods_category` VALUES ('2','0','和田玉','','0','5');
INSERT INTO `on_goods_category` VALUES ('3','1','奥迪','Category/573a913921fac.jpg','1','4');
INSERT INTO `on_goods_category` VALUES ('4','1','阿斯顿马','','1','0');
INSERT INTO `on_goods_category` VALUES ('5','1','本田','','1','0');
INSERT INTO `on_goods_category` VALUES ('6','1','宾利','','0','0');
INSERT INTO `on_goods_category` VALUES ('7','1','保时捷','Category/573a91486bb72.jpg','1','0');
INSERT INTO `on_goods_category` VALUES ('8','1','宝马','Category/573a90ff3d4d0.jpg','1','0');
INSERT INTO `on_goods_category` VALUES ('9','1','奔驰','Category/573a910c29c62.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('10','1','标致','','0','0');
INSERT INTO `on_goods_category` VALUES ('11','1','别克','Category/573a94811a570.jpg','1','0');
INSERT INTO `on_goods_category` VALUES ('12','1','大众','Category/573a91191b9e5.jpg','1','0');
INSERT INTO `on_goods_category` VALUES ('13','1','道奇','','0','0');
INSERT INTO `on_goods_category` VALUES ('14','1','丰田','Category/573a928a4c97e.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('15','1','福特','Category/573a924832320.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('16','1','菲亚特','','0','0');
INSERT INTO `on_goods_category` VALUES ('17','1','法拉利','','0','0');
INSERT INTO `on_goods_category` VALUES ('18','1','GMC','','0','0');
INSERT INTO `on_goods_category` VALUES ('19','1','悍马','Category/573a93948709e.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('20','1','Jeep','','0','0');
INSERT INTO `on_goods_category` VALUES ('21','1','捷豹','','0','0');
INSERT INTO `on_goods_category` VALUES ('22','1','克莱斯勒','','0','0');
INSERT INTO `on_goods_category` VALUES ('23','1','凯迪拉克','Category/573a933e45d2a.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('24','1','雷克萨斯','Category/573a94f01482a.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('25','1','路虎','Category/573a9236d8348.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('26','1','林肯','','0','0');
INSERT INTO `on_goods_category` VALUES ('27','1','雷诺','','0','0');
INSERT INTO `on_goods_category` VALUES ('28','1','兰博基尼','Category/573a9157684db.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('29','1','劳斯莱斯','Category/573a937824e25.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('30','1','铃木','','0','0');
INSERT INTO `on_goods_category` VALUES ('31','1','玛莎拉蒂','Category/573a931f92f5e.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('32','1','迈巴赫','','0','0');
INSERT INTO `on_goods_category` VALUES ('33','1','MINI','','0','0');
INSERT INTO `on_goods_category` VALUES ('34','1','马自达','Category/573a94954cf41.jpg','0','0');
INSERT INTO `on_goods_category` VALUES ('35','1','纳智捷','','0','0');
INSERT INTO `on_goods_category` VALUES ('36','1','欧宝','','0','0');
INSERT INTO `on_goods_category` VALUES ('37','1','讴歌','','0','0');
INSERT INTO `on_goods_category` VALUES ('38','1','起亚','','0','0');
INSERT INTO `on_goods_category` VALUES ('39','1','日产','','0','0');
INSERT INTO `on_goods_category` VALUES ('40','1','荣威','','0','0');
INSERT INTO `on_goods_category` VALUES ('41','1','Smart','','0','0');
INSERT INTO `on_goods_category` VALUES ('42','1','三菱','','0','0');
INSERT INTO `on_goods_category` VALUES ('43','1','斯柯达','','0','0');
INSERT INTO `on_goods_category` VALUES ('44','1','萨博','','0','0');
INSERT INTO `on_goods_category` VALUES ('45','1','斯巴鲁','','0','0');
INSERT INTO `on_goods_category` VALUES ('46','1','世爵','','0','0');
INSERT INTO `on_goods_category` VALUES ('47','1','沃尔沃','','0','0');
INSERT INTO `on_goods_category` VALUES ('48','1','雪佛兰','','0','0');
INSERT INTO `on_goods_category` VALUES ('49','1','现代','','0','0');
INSERT INTO `on_goods_category` VALUES ('50','1','雪铁龙','','0','0');
INSERT INTO `on_goods_category` VALUES ('51','1','西雅特','','0','0');
INSERT INTO `on_goods_category` VALUES ('52','1','英菲','','0','0');
INSERT INTO `on_goods_category` VALUES ('53','1','尼迪','','0','0');
INSERT INTO `on_goods_category` VALUES ('54','2','白玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('55','2','碧玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('56','2','青白玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('57','2','青玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('58','2','羊脂白玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('59','2','青花玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('60','2','墨玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('61','2','黄玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('62','2','糖玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('63','2','糖白玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('64','2','糖羊脂白玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('65','2','红沁','','0','0');
INSERT INTO `on_goods_category` VALUES ('66','2','糖青白玉','','0','0');
INSERT INTO `on_goods_category` VALUES ('67','2','黑碧玉','','0','5');
INSERT INTO `on_goods_category` VALUES ('68','2','糖沁','','0','26');
INSERT INTO `on_goods_category` VALUES ('69','3','的发送到','','0','4');
INSERT INTO `on_goods_category` VALUES ('70','69','撒地方','','0','0');
INSERT INTO `on_goods_category` VALUES ('71','69','撒旦法士大夫','','0','0');


# 数据库表：on_goods_category_extend 数据信息
INSERT INTO `on_goods_category_extend` VALUES ('1','1');
INSERT INTO `on_goods_category_extend` VALUES ('1','2');
INSERT INTO `on_goods_category_extend` VALUES ('1','3');
INSERT INTO `on_goods_category_extend` VALUES ('1','0');


# 数据库表：on_goods_category_filtrate 数据信息
INSERT INTO `on_goods_category_filtrate` VALUES ('1','5');
INSERT INTO `on_goods_category_filtrate` VALUES ('1','4');
INSERT INTO `on_goods_category_filtrate` VALUES ('1','3');
INSERT INTO `on_goods_category_filtrate` VALUES ('1','2');
INSERT INTO `on_goods_category_filtrate` VALUES ('1','1');
INSERT INTO `on_goods_category_filtrate` VALUES ('1','6');
INSERT INTO `on_goods_category_filtrate` VALUES ('2','61');
INSERT INTO `on_goods_category_filtrate` VALUES ('2','60');
INSERT INTO `on_goods_category_filtrate` VALUES ('2','59');


# 数据库表：on_goods_evaluate 数据信息
INSERT INTO `on_goods_evaluate` VALUES ('1','180','1','4','BID148125048193280','爱睡懒觉的疯狂邻居阿斯科拉点击付款啦','氨基酸的离开房间按快了速度激发拉屎的空间','5','5','5','1481252216');
INSERT INTO `on_goods_evaluate` VALUES ('2','180','1','4','BID148125048193280','爱睡懒觉的疯狂邻居阿斯科拉点击付款啦','氨基酸的离开房间按快了速度激发拉屎的空间','5','5','5','1481252251');


# 数据库表：on_goods_extend 数据信息
INSERT INTO `on_goods_extend` VALUES ('1','扩展字段（1）','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0028.gif&quot;/&gt;&lt;/p&gt;','7','1');
INSERT INTO `on_goods_extend` VALUES ('2','扩展字段（2）','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0040.gif&quot;/&gt;&lt;/p&gt;','0','1');
INSERT INTO `on_goods_extend` VALUES ('3','扩展字段（3）','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=&quot;http://img.baidu.com/hi/jx2/j_0063.gif&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','0','1');


# 数据库表：on_goods_fields 数据信息
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','1');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','1');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','1');
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','2');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','2');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','2');
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','3');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','3');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','3');
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','4');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','4');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','4');
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','7');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','7');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','7');
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','10');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','10');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','10');
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','11');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','11');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','11');
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','12');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','12');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','12');
INSERT INTO `on_goods_fields` VALUES ('1','&lt;p&gt;我是扩展字段（1）这里是我的默认值，你可以编辑发布&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0028.gif\&quot;/&gt;&lt;/p&gt;','13');
INSERT INTO `on_goods_fields` VALUES ('2','&lt;p&gt;我是扩展字段（2），这是我的默认值，你可以编辑内容&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0040.gif\&quot;/&gt;&lt;/p&gt;','13');
INSERT INTO `on_goods_fields` VALUES ('3','&lt;p&gt;我是扩展字段（3），我是设置的默认值，你可以编辑我&lt;img src=\&quot;http://img.baidu.com/hi/jx2/j_0063.gif\&quot;/&gt;&lt;br/&gt;&lt;/p&gt;','13');


# 数据库表：on_goods_filtrate 数据信息
INSERT INTO `on_goods_filtrate` VALUES ('1','0','车型','0');
INSERT INTO `on_goods_filtrate` VALUES ('2','0','价格','0');
INSERT INTO `on_goods_filtrate` VALUES ('3','0','年份','0');
INSERT INTO `on_goods_filtrate` VALUES ('4','0','颜色','0');
INSERT INTO `on_goods_filtrate` VALUES ('5','0','排量','0');
INSERT INTO `on_goods_filtrate` VALUES ('6','0','国别','0');
INSERT INTO `on_goods_filtrate` VALUES ('7','1','两厢轿车','0');
INSERT INTO `on_goods_filtrate` VALUES ('8','1','三厢轿车','0');
INSERT INTO `on_goods_filtrate` VALUES ('9','1','旅行轿车','0');
INSERT INTO `on_goods_filtrate` VALUES ('10','1','轿跑','0');
INSERT INTO `on_goods_filtrate` VALUES ('11','1','越野车','0');
INSERT INTO `on_goods_filtrate` VALUES ('12','1','跑车','0');
INSERT INTO `on_goods_filtrate` VALUES ('13','1','房车','0');
INSERT INTO `on_goods_filtrate` VALUES ('14','1','商务车','0');
INSERT INTO `on_goods_filtrate` VALUES ('15','1','皮卡','0');
INSERT INTO `on_goods_filtrate` VALUES ('16','2','10万以下','0');
INSERT INTO `on_goods_filtrate` VALUES ('17','2','10-20万','0');
INSERT INTO `on_goods_filtrate` VALUES ('18','2','20-30万','0');
INSERT INTO `on_goods_filtrate` VALUES ('19','2','30-50万','0');
INSERT INTO `on_goods_filtrate` VALUES ('20','2','50-90万','0');
INSERT INTO `on_goods_filtrate` VALUES ('21','2','90-120万','0');
INSERT INTO `on_goods_filtrate` VALUES ('22','2','120万以上','0');
INSERT INTO `on_goods_filtrate` VALUES ('23','3','2008年','0');
INSERT INTO `on_goods_filtrate` VALUES ('24','3','2009年','0');
INSERT INTO `on_goods_filtrate` VALUES ('25','3','2010年','0');
INSERT INTO `on_goods_filtrate` VALUES ('26','3','2011年','0');
INSERT INTO `on_goods_filtrate` VALUES ('27','3','2012年','0');
INSERT INTO `on_goods_filtrate` VALUES ('28','3','2013年','0');
INSERT INTO `on_goods_filtrate` VALUES ('29','3','2014年','0');
INSERT INTO `on_goods_filtrate` VALUES ('30','3','新车','0');
INSERT INTO `on_goods_filtrate` VALUES ('31','4','红色','0');
INSERT INTO `on_goods_filtrate` VALUES ('32','4','黑色','0');
INSERT INTO `on_goods_filtrate` VALUES ('33','4','蓝色','0');
INSERT INTO `on_goods_filtrate` VALUES ('34','4','灰色','0');
INSERT INTO `on_goods_filtrate` VALUES ('35','4','银色','0');
INSERT INTO `on_goods_filtrate` VALUES ('36','4','绿色','0');
INSERT INTO `on_goods_filtrate` VALUES ('37','4','香槟色','0');
INSERT INTO `on_goods_filtrate` VALUES ('38','4','黄色','0');
INSERT INTO `on_goods_filtrate` VALUES ('39','4','紫色','0');
INSERT INTO `on_goods_filtrate` VALUES ('40','4','棕色','0');
INSERT INTO `on_goods_filtrate` VALUES ('41','4','白色','0');
INSERT INTO `on_goods_filtrate` VALUES ('42','4','金色','0');
INSERT INTO `on_goods_filtrate` VALUES ('43','4','其他','0');
INSERT INTO `on_goods_filtrate` VALUES ('44','5','2.0L以下','0');
INSERT INTO `on_goods_filtrate` VALUES ('45','5','2.0-3.0L','0');
INSERT INTO `on_goods_filtrate` VALUES ('46','5','3.0-4.0L','0');
INSERT INTO `on_goods_filtrate` VALUES ('47','5','4.0L以上','0');
INSERT INTO `on_goods_filtrate` VALUES ('48','6','德国','0');
INSERT INTO `on_goods_filtrate` VALUES ('49','6','英国','0');
INSERT INTO `on_goods_filtrate` VALUES ('50','6','日本','0');
INSERT INTO `on_goods_filtrate` VALUES ('51','6','法国','0');
INSERT INTO `on_goods_filtrate` VALUES ('52','6','美国','0');
INSERT INTO `on_goods_filtrate` VALUES ('53','6','意大利','0');
INSERT INTO `on_goods_filtrate` VALUES ('54','6','韩国','0');
INSERT INTO `on_goods_filtrate` VALUES ('55','6','葡萄牙','0');
INSERT INTO `on_goods_filtrate` VALUES ('56','6','中国','0');
INSERT INTO `on_goods_filtrate` VALUES ('57','6','其他','0');
INSERT INTO `on_goods_filtrate` VALUES ('58','5','5.0以上','0');
INSERT INTO `on_goods_filtrate` VALUES ('59','0','商品形态','0');
INSERT INTO `on_goods_filtrate` VALUES ('60','0','产状','0');
INSERT INTO `on_goods_filtrate` VALUES ('61','0','外观造型','0');
INSERT INTO `on_goods_filtrate` VALUES ('62','59','挂件','0');
INSERT INTO `on_goods_filtrate` VALUES ('63','59','吊坠','0');
INSERT INTO `on_goods_filtrate` VALUES ('64','59','手镯','0');
INSERT INTO `on_goods_filtrate` VALUES ('65','59','手链','0');
INSERT INTO `on_goods_filtrate` VALUES ('66','59','籽料','0');
INSERT INTO `on_goods_filtrate` VALUES ('67','59','把件','0');
INSERT INTO `on_goods_filtrate` VALUES ('68','59','原石','0');
INSERT INTO `on_goods_filtrate` VALUES ('69','59','摆件','0');
INSERT INTO `on_goods_filtrate` VALUES ('70','59','戒指','0');
INSERT INTO `on_goods_filtrate` VALUES ('71','59','玉佩','0');
INSERT INTO `on_goods_filtrate` VALUES ('72','59','车挂','0');
INSERT INTO `on_goods_filtrate` VALUES ('73','60','山流水','0');
INSERT INTO `on_goods_filtrate` VALUES ('74','60','山料','0');
INSERT INTO `on_goods_filtrate` VALUES ('75','60','籽料','0');
INSERT INTO `on_goods_filtrate` VALUES ('76','60','黄沁皮籽料','0');
INSERT INTO `on_goods_filtrate` VALUES ('77','60','红沁皮籽料','0');
INSERT INTO `on_goods_filtrate` VALUES ('78','60','黄沁籽料','0');
INSERT INTO `on_goods_filtrate` VALUES ('79','61','观音','0');
INSERT INTO `on_goods_filtrate` VALUES ('80','61','笑佛','0');
INSERT INTO `on_goods_filtrate` VALUES ('81','61','貔貅','0');
INSERT INTO `on_goods_filtrate` VALUES ('82','61','十二生肖','0');
INSERT INTO `on_goods_filtrate` VALUES ('83','61','青龙','0');
INSERT INTO `on_goods_filtrate` VALUES ('84','61','鱼','0');
INSERT INTO `on_goods_filtrate` VALUES ('85','61','如意','0');
INSERT INTO `on_goods_filtrate` VALUES ('86','61','莲花','0');
INSERT INTO `on_goods_filtrate` VALUES ('87','61','凤凰','0');
INSERT INTO `on_goods_filtrate` VALUES ('88','61','蟾蜍','0');
INSERT INTO `on_goods_filtrate` VALUES ('89','61','麒麟','0');
INSERT INTO `on_goods_filtrate` VALUES ('90','61','葫芦','0');
INSERT INTO `on_goods_filtrate` VALUES ('91','61','龙龟','0');
INSERT INTO `on_goods_filtrate` VALUES ('92','61','白虎','0');
INSERT INTO `on_goods_filtrate` VALUES ('93','61','白菜','0');
INSERT INTO `on_goods_filtrate` VALUES ('94','61','玄武','0');
INSERT INTO `on_goods_filtrate` VALUES ('95','61','大象','0');
INSERT INTO `on_goods_filtrate` VALUES ('96','61','孔雀','0');
INSERT INTO `on_goods_filtrate` VALUES ('97','7','学才大发光','0');
INSERT INTO `on_goods_filtrate` VALUES ('98','97','就卡死','0');


# 数据库表：on_goods_order 数据信息
INSERT INTO `on_goods_order` VALUES ('BID148116654118114','0','1','180','1','500.00','100.00','100.00','1481166541','1481167806','1481184919','1481185472','0','0','0','0','0','0','0','0','0','0','1481789719','0','0','0','0','0','1481771341','0','3','0','发韵达快递','a:11:{s:4:"adid";s:1:"1";s:3:"uid";s:3:"180";s:8:"province";s:9:"河南省";s:4:"city";s:9:"新乡市";s:4:"area";s:9:"长垣县";s:7:"address";s:42:"南蒲区高店社区14号楼2单元502室";s:10:"postalcode";s:6:"453400";s:8:"truename";s:6:"占蛟";s:6:"mobile";s:11:"13803845077";s:5:"phone";s:7:"8923288";s:7:"default";s:1:"1";}','SF','','504514703966','给你发顺丰了');
INSERT INTO `on_goods_order` VALUES ('BID148116654173375','0','2','180','1','200.00','100.00','40.00','1481166541','1481249811','1481249922','1481251130','0','0','0','0','0','0','0','0','1481854611','0','1481854722','0','0','0','0','0','1481771341','0','3','0','发韵达快递','a:11:{s:4:"adid";s:1:"1";s:3:"uid";s:3:"180";s:8:"province";s:9:"河南省";s:4:"city";s:9:"新乡市";s:4:"area";s:9:"长垣县";s:7:"address";s:42:"南蒲区高店社区14号楼2单元502室";s:10:"postalcode";s:6:"453400";s:8:"truename";s:6:"占蛟";s:6:"mobile";s:11:"13803845077";s:5:"phone";s:7:"8923288";s:7:"default";s:1:"1";}','YD','','3900406703587','已发韵达快递');
INSERT INTO `on_goods_order` VALUES ('BID148125048193280','0','4','180','1','200.00','100.00','40.00','1481250481','1481250509','1481251984','1481252118','1481252251','0','0','0','0','0','0','0','1481855309','0','1481856784','0','1481856918','0','0','0','1481855281','0','4','0','发韵达快递','a:11:{s:4:"adid";s:1:"1";s:3:"uid";s:3:"180";s:8:"province";s:9:"河南省";s:4:"city";s:9:"新乡市";s:4:"area";s:9:"长垣县";s:7:"address";s:42:"南蒲区高店社区14号楼2单元502室";s:10:"postalcode";s:6:"453400";s:8:"truename";s:6:"占蛟";s:6:"mobile";s:11:"13803845077";s:5:"phone";s:7:"8923288";s:7:"default";s:1:"1";}','YD','','3900406703587','了卡机可视对讲阿克苏大姐');
INSERT INTO `on_goods_order` VALUES ('BID148159356345513','0','7','180','1','200.00','100.00','40.00','1481593563','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1481621127','1','0','0','','','','','','竞拍成功，请在订单有效期内进行支付！');
INSERT INTO `on_goods_order` VALUES ('BID148159922987522','0','8','180','1','300.00','50.00','60.00','1481599229','1481794581','0','0','0','0','0','0','0','0','0','0','1482399381','1','0','0','0','0','0','0','1482204029','0','1','0','','a:11:{s:4:"adid";s:1:"1";s:3:"uid";s:3:"180";s:8:"province";s:9:"河南省";s:4:"city";s:9:"新乡市";s:4:"area";s:9:"长垣县";s:7:"address";s:42:"南蒲区高店社区14号楼2单元502室";s:10:"postalcode";s:6:"453400";s:8:"truename";s:6:"占蛟";s:6:"mobile";s:11:"13803845077";s:5:"phone";s:7:"8923288";s:7:"default";s:1:"1";}','','','','已支付我们会尽快安排发货');
INSERT INTO `on_goods_order` VALUES ('BID148159923037371','0','9','180','1','10.00','20.00','2.00','1481599230','1481766901','0','0','0','0','0','0','0','0','0','0','1482371701','1','0','0','0','0','0','0','1482204030','0','1','0','','a:11:{s:4:"adid";s:1:"1";s:3:"uid";s:3:"180";s:8:"province";s:9:"河南省";s:4:"city";s:9:"新乡市";s:4:"area";s:9:"长垣县";s:7:"address";s:42:"南蒲区高店社区14号楼2单元502室";s:10:"postalcode";s:6:"453400";s:8:"truename";s:6:"占蛟";s:6:"mobile";s:11:"13803845077";s:5:"phone";s:7:"8923288";s:7:"default";s:1:"1";}','','','','已支付我们会尽快安排发货');
INSERT INTO `on_goods_order` VALUES ('BID148179498134885','0','11','180','1','10.00','10.00','2.00','1481794981','0','0','0','0','0','0','0','0','0','0','0','1481796802','1','0','0','0','0','0','0','1482399781','0','1','0','','a:11:{s:4:"adid";s:1:"1";s:3:"uid";s:3:"180";s:8:"province";s:9:"河南省";s:4:"city";s:9:"新乡市";s:4:"area";s:9:"长垣县";s:7:"address";s:42:"南蒲区高店社区14号楼2单元502室";s:10:"postalcode";s:6:"453400";s:8:"truename";s:6:"占蛟";s:6:"mobile";s:11:"13803845077";s:5:"phone";s:7:"8923288";s:7:"default";s:1:"1";}','','','','已支付我们会尽快安排发货');
INSERT INTO `on_goods_order` VALUES ('BID148179510117691','0','12','180','1','200.00','20.00','40.00','1481795101','1481795268','0','0','0','0','0','0','0','0','0','0','1481796449','1','0','0','0','0','0','0','1482399901','0','1','0','发韵达快递','a:11:{s:4:"adid";s:1:"1";s:3:"uid";s:3:"180";s:8:"province";s:9:"河南省";s:4:"city";s:9:"新乡市";s:4:"area";s:9:"长垣县";s:7:"address";s:42:"南蒲区高店社区14号楼2单元502室";s:10:"postalcode";s:6:"453400";s:8:"truename";s:6:"占蛟";s:6:"mobile";s:11:"13803845077";s:5:"phone";s:7:"8923288";s:7:"default";s:1:"1";}','','','','已支付我们会尽快安排发货');
INSERT INTO `on_goods_order` VALUES ('BID148179652969363','0','13','180','1','10.00','100.00','2.00','1481796529','1481879128','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1491041329','0','1','0','','','','','','竞拍成功，请在订单有效期内进行支付！');
INSERT INTO `on_goods_order` VALUES ('BID148179653013440','0','14','180','1','600.00','10.00','120.00','1481796530','1481879091','1481941111','1483756709','0','0','0','0','0','0','0','0','8640000','0','1482545911','1','0','0','0','0','1491041330','0','3','1','','','YTO','','883820252289286504','已发圆通速递');
INSERT INTO `on_goods_order` VALUES ('BID148193456477765','0','10','180','1','300.00','50.00','60.00','1481934564','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1482539364','1','0','0','','','','','','竞拍成功，请在订单有效期内进行支付！');
INSERT INTO `on_goods_order` VALUES ('BID148276080104251','0','17','524','1','301.00','10.00','60.20','1482760801','1482760979','0','0','0','0','0','0','0','0','0','0','1483365779','1','0','0','0','0','0','0','1483365601','0','1','0','','a:11:{s:4:"adid";s:1:"2";s:3:"uid";s:3:"524";s:8:"province";s:9:"北京市";s:4:"city";s:9:"市辖区";s:4:"area";s:9:"西城区";s:7:"address";s:39:"卡拉斯经典款垃圾啊手榴弹卡";s:10:"postalcode";s:6:"450001";s:8:"truename";s:9:"侯占蛟";s:6:"mobile";s:11:"13803656548";s:5:"phone";s:0:"";s:7:"default";s:1:"1";}','','','','已支付我们会尽快安排发货');
INSERT INTO `on_goods_order` VALUES ('BID148276081586549','0','19','524','1','301.00','10.00','60.20','1482760815','1482760930','0','0','0','0','0','0','0','0','0','0','1483365730','1','0','0','0','0','0','0','1483365615','0','1','0','','a:11:{s:4:"adid";s:1:"2";s:3:"uid";s:3:"524";s:8:"province";s:9:"北京市";s:4:"city";s:9:"市辖区";s:4:"area";s:9:"西城区";s:7:"address";s:39:"卡拉斯经典款垃圾啊手榴弹卡";s:10:"postalcode";s:6:"450001";s:8:"truename";s:9:"侯占蛟";s:6:"mobile";s:11:"13803656548";s:5:"phone";s:0:"";s:7:"default";s:1:"1";}','','','','已支付我们会尽快安排发货');
INSERT INTO `on_goods_order` VALUES ('BID14851350425910','0','23','523','1','11.00','100.00','2.20','1485135042','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1485739842','0','0','0','','','','','','竞拍成功，请在订单有效期内进行支付！');


# 数据库表：on_goods_user 数据信息
INSERT INTO `on_goods_user` VALUES ('180','1','0.00','50.00','p-u','1481166046','0','0');
INSERT INTO `on_goods_user` VALUES ('180','2','0.00','50.00','p-u','1481166141','0','0');
INSERT INTO `on_goods_user` VALUES ('180','4','0.00','50.00','p-u','1481250359','0','0');
INSERT INTO `on_goods_user` VALUES ('180','7','0.00','50.00','p-u','1481593432','1481621338','1');
INSERT INTO `on_goods_user` VALUES ('180','8','0.00','0.00','p-u','1481593543','0','0');
INSERT INTO `on_goods_user` VALUES ('180','9','0.00','20.00','p-u','1481593594','1481794272','1');
INSERT INTO `on_goods_user` VALUES ('180','10','0.00','600.00','p-u','1481794787','1483756559','1');
INSERT INTO `on_goods_user` VALUES ('180','11','0.00','30.00','p-u','1481794836','1481795001','1');
INSERT INTO `on_goods_user` VALUES ('180','12','0.00','380.00','p-u','1481794954','1481795268','1');
INSERT INTO `on_goods_user` VALUES ('180','13','0.00','50.00','p-u','1481795868','0','0');
INSERT INTO `on_goods_user` VALUES ('180','14','0.00','50.00','p-u','1481795959','1481879072','1');
INSERT INTO `on_goods_user` VALUES ('523','1','100.00','0.00','s-u','1482760596','1482760815','1');
INSERT INTO `on_goods_user` VALUES ('524','1','0.00','0.00','s-u','1482760648','0','0');
INSERT INTO `on_goods_user` VALUES ('523','6','100.00','0.00','s-u','1484041091','0','0');


# 数据库表：on_link 数据信息
INSERT INTO `on_link` VALUES ('1','昂酷网络','http://www.oncoo.net','Link/573a89b4dac40.jpg','1','89');
INSERT INTO `on_link` VALUES ('4','昂酷拍卖系统演示','http://paimai.oncoo.net','Link/542ca3c7a5938.gif','1','89');
INSERT INTO `on_link` VALUES ('5','百度','http://www.baidu.com','','0','4');
INSERT INTO `on_link` VALUES ('6','撒的发生的','阿斯蒂芬','Link/573a89c8017d1.jpg','1','0');


# 数据库表：on_meeting_auction 数据信息
INSERT INTO `on_meeting_auction` VALUES ('1','而过味儿奥迪哥','','','谁的分公司地方过水电费','1482312300','0','120','120','120','1','0','0','0','1');


# 数据库表：on_member 数据信息
INSERT INTO `on_member` VALUES ('1','','','1772703372@qq.com','houzhanjiao','oncoo','长垣昂酷网络有限公司','专注于拍卖系统的研发及销售！','96fc600ba51ffdcde25196b30a149981','侯占蛟','13803845077','1470012516','127.0.0.1','1','0','','0','0','User/579e9c728b658.jpg','0','0','卡机sd卡浪费骄傲快圣诞节费','450010','3','35','398','啊考虑撒旦尽快房间爱扩散到','','','0','','10101658.00','3308.60','0.00','0.00','30','2','192.168.1.238','1484214533','1','1','weixin,email');
INSERT INTO `on_member` VALUES ('2','','','76996382@qq.com','qq123345','qq123345','111111','222222222222','bfba6048dfe02170d6680440225dc39c','在路上','13500393837','1470033584','171.212.220.187','0','0','','0','0','','0','0','9999999999999','123555','2','33','378','11111111111111111111111111111','','','0','','9790.00','1349.80','100.00','100.00','114','2','182.149.124.205','1470238078','1','0','');
INSERT INTO `on_member` VALUES ('3','','','','ceshiceshi02','ceshi02','','','1d024528185b013e84a833d36de771ed','测试','17030880529','1470207691','113.140.11.3','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.140.11.3','1470207691','1','0','');
INSERT INTO `on_member` VALUES ('4','','','','8888','8888','8888','','f0bf6e5df2f60c99abf79d29d8ec8c67','','','0','','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','888888','0','','0','1','0','');
INSERT INTO `on_member` VALUES ('5','','','','zwy8888','zwy','','','f0bf6e5df2f60c99abf79d29d8ec8c67','李晓得','13726311117','1470218644','116.5.11.224','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','88888.00','0.00','888888.00','0.00','2147483647','0','116.5.11.224','1470220017','1','0','');
INSERT INTO `on_member` VALUES ('6','','','','wx0006','ONcoo Service','佳士得拍卖','葵花哭起来咯哦经纪人考虑考虑','96fc600ba51ffdcde25196b30a149981','','','1470274336','183.204.104.101','0','0','','0','0','','0','1','','0','17','193','0','','','','0','','9266.54','10.10','225.00','90.00','0','0','183.204.103.208','1480838315','1','0','weixin');
INSERT INTO `on_member` VALUES ('7','','','','wx0007','@','','','','','','1470276641','101.81.23.73','0','0','','0','0','','0','2','','0','13','133','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.81.23.73','1470276641','1','1','');
INSERT INTO `on_member` VALUES ('8','','','','wx0008','陶吉吉','','','','','','1470278055','125.82.184.249','0','0','','0','0','','0','1','','0','123','1315','0','','','','0','','0.00','0.00','0.00','0.00','0','0','125.82.184.249','1470278055','1','1','');
INSERT INTO `on_member` VALUES ('9','','','','wx0009','易君','','','','','','1470292125','60.176.12.117','0','0','','0','0','','0','1','','0','12','122','0','','','','0','','0.00','0.00','0.00','0.00','0','0','36.23.164.203','1470396019','1','1','');
INSERT INTO `on_member` VALUES ('10','','','','wx0010','雪煌','王子','hei hei hei q','','','','1470298821','112.17.246.67','0','0','','0','0','','0','1','','0','12','122','0','','','','0','','0.00','0.00','0.00','0.00','0','0','122.233.167.59','1470642184','1','1','');
INSERT INTO `on_member` VALUES ('11','','','','wx0011','孟鹤松','jjjj','shhssshdd','','','','1470301055','123.151.64.143','0','0','','0','0','','0','1','','0','17','202','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.64.143','1470396137','1','1','');
INSERT INTO `on_member` VALUES ('12','','','','wx0012','','','','','','','1470301760','123.151.64.143','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.64.143','1470301760','1','1','');
INSERT INTO `on_member` VALUES ('13','','','','wx0013','F','','','','','','1470302392','180.213.163.132','0','0','','0','0','','0','1','','0','4','47','0','','','','0','','0.00','0.00','0.00','0.00','0','0','180.213.163.132','1470736221','1','1','');
INSERT INTO `on_member` VALUES ('14','','','a@PC.com','wx0014','africa','africa','大家好','','又是一个','13812525885','1470309781','14.17.37.145','0','0','','0','0','','0','1','北京市区域自治州街道','123456','2','33','378','','','','0','','10000.01','0.00','100005.00','550.00','0','0','115.171.227.143','1480999865','1','1','weixin');
INSERT INTO `on_member` VALUES ('15','','','','wx0015','文玩部落','新人报到','新人报到 测试一下','','','','1470330861','223.104.227.157','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','1.180.214.31','1480308859','1','1','weixin');
INSERT INTO `on_member` VALUES ('16','','','','woyaopaimai','wyp','好的','321','96fc600ba51ffdcde25196b30a149981','王刚网','13806958624','1470366626','115.60.107.62','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','115.60.107.62','1470366626','1','0','');
INSERT INTO `on_member` VALUES ('17','','','','qiaoliang','起名真难','','','4f11432a9c6e1ab2a086c883572269eb','名字','13565658989','1470377448','59.49.39.55','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','10000.00','50.00','0.00','0.00','0','0','59.49.39.55','1478769259','1','0','');
INSERT INTO `on_member` VALUES ('18','','','','user01','user01','','','dace20fd1d61e060b931c98bb3e4f7fa','王刚','13816626592','1470378098','58.246.189.202','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','58.246.189.202','1470378098','1','0','');
INSERT INTO `on_member` VALUES ('19','','','','wx0019','曹峰','','','','','','1470380510','221.226.113.98','0','0','','0','0','','0','1','','0','11','109','0','','','','0','','0.00','0.00','0.00','0.00','0','0','221.226.113.98','1470380510','1','1','');
INSERT INTO `on_member` VALUES ('20','','','','wx0020','云中雨','','','','','','1470389563','219.147.217.126','0','0','','0','0','','0','1','','0','9','101','0','','','','0','','0.00','0.00','0.00','0.00','0','0','111.137.109.144','1478321053','1','1','weixin');
INSERT INTO `on_member` VALUES ('21','','','','wx0021','清风徐来@梵音绕','','','','','','1470389740','58.247.111.106','0','0','','0','0','','0','1','','0','107','1167','0','','','','0','','0.00','0.00','0.00','0.00','0','0','58.247.111.106','1470389740','1','1','');
INSERT INTO `on_member` VALUES ('22','','','','tomore','独步夕阳','独步夕阳','13344455555','76f4aa4c008d533b87f0a321066baac3','独步夕阳','18019431781','1470456291','112.65.143.130','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.65.143.130','1470456291','1','0','');
INSERT INTO `on_member` VALUES ('23','','','','wx0023','晨曦','独步夕阳','1228566','','','','1470457285','112.65.143.130','0','0','','0','0','','0','1','','0','107','1163','0','','','','0','','1000000.00','1000.00','0.00','0.00','0','0','112.65.143.130','1470457285','1','1','');
INSERT INTO `on_member` VALUES ('24','','','','wx0024','焦雪峰','','','','','','1470470441','101.20.249.110','0','0','','0','0','','0','1','','0','4','46','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.20.249.110','1470470441','1','1','');
INSERT INTO `on_member` VALUES ('30','','','','wx0030','A诺唯水晶','文轩阁','批发零售文玩饰品，南红','','','','1470622752','117.136.66.220','0','0','','0','0','','0','1','','0','20','232','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.136.66.220','1470622752','1','1','');
INSERT INTO `on_member` VALUES ('26','','','','wx0026','月之海','月之海','月之海','','','','1470546512','122.215.24.23','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','122.215.24.23','1477651136','1','1','');
INSERT INTO `on_member` VALUES ('27','','','','wx0027','李虎','','','','','','1470554585','221.179.140.132','0','0','','0','0','','0','1','','0','33','385','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.136.28.68','1471165564','1','1','');
INSERT INTO `on_member` VALUES ('28','','','','wx0028','许','','','','','','1470554605','112.17.244.139','0','0','','0','0','','0','1','','0','12','122','0','','','','0','','0.00','0.00','0.00','0.00','0','0','124.90.69.225','1474698596','1','1','');
INSERT INTO `on_member` VALUES ('29','','','','wx0029','허성일????????จุ๊บ ','','','','','','1470574871','119.131.198.190','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','119.131.198.190','1470574871','1','1','');
INSERT INTO `on_member` VALUES ('36','','','','wx0036','FCS(江)','','','','','','1470717408','123.151.12.152','0','0','','0','0','','0','1','','0','1','4','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.12.152','1472535190','1','1','');
INSERT INTO `on_member` VALUES ('31','','','','wx0031','億','','','','','','1470635615','101.226.69.109','0','0','','0','0','','0','1','','0','14','150','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.69.109','1470636853','1','1','');
INSERT INTO `on_member` VALUES ('32','','','','wx0032','不会咬人','','','','','','1470643130','180.153.81.159','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','180.153.81.159','1470643130','1','1','');
INSERT INTO `on_member` VALUES ('33','','','183636503@qq.com','wx0033','张鸿波·永馨斋','永馨','书画','7d7fd70bbc897c821c52cdbf6b7958ad','','13600192976','1470651281','14.17.37.144','1','1','','0','0','','0','0','','0','0','1','0','','','','0','','436.00','1.00','0.00','0.00','15','2','61.146.249.113','1477828843','1','1','weixin');
INSERT INTO `on_member` VALUES ('35','','','','wx0035','黄根','','','','','','1470660152','114.216.251.141','0','0','','0','0','','0','1','','0','11','113','0','','','','0','','0.00','0.00','0.00','0.00','0','0','114.216.12.27','1479816310','1','1','weixin');
INSERT INTO `on_member` VALUES ('37','','','','wx0037','……','','','','','','1470726068','14.17.37.144','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.37.144','1470726068','1','1','');
INSERT INTO `on_member` VALUES ('38','','','','wx0038','打落江涛声','high','看快乐健健康康','','','','1470728059','222.142.32.35','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.123.98.252','1480943966','1','1','weixin');
INSERT INTO `on_member` VALUES ('39','','','','wx0039',' evan','','','','','','1470731328','58.17.246.152','0','0','','0','0','','0','1','','0','270','2597','0','','','','0','','0.00','0.00','0.00','0.00','0','0','58.17.246.152','1470731328','1','1','');
INSERT INTO `on_member` VALUES ('40','','','','wx0040','阳光下的微笑','','','','','','1470801490','183.38.243.30','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.38.243.30','1470801490','1','1','');
INSERT INTO `on_member` VALUES ('41','','','','wx0041','枫林卫平光彩拍卖光华招标','','','','','','1470809410','101.226.125.14','0','0','','0','0','','0','1','','0','16','178','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.14','1470809410','1','1','');
INSERT INTO `on_member` VALUES ('42','','','','wx0042','照夜白','','','','','','1470811627','112.97.63.212','0','0','','0','0','','0','1','','0','20','234','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.60.162.92','1476961356','1','1','');
INSERT INTO `on_member` VALUES ('43','','','','wx0043','良匠','？惨','兔兔了','','','','1470820186','171.111.43.242','0','0','','0','0','','0','1','','0','21','253','0','','','','0','','0.00','0.00','0.00','0.00','0','0','114.135.113.76','1473303882','1','1','');
INSERT INTO `on_member` VALUES ('44','','','','wx0044','陈基建','','','','','','1470820609','101.226.125.122','0','0','','0','0','','0','1','','0','16','183','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.122','1470820609','1','1','');
INSERT INTO `on_member` VALUES ('45','','','','wx0045','静水','测试测试','测试测试','','','','1470830357','14.17.11.196','0','0','','0','0','','0','1','','0','20','237','0','','','','0','','999999.00','0.10','0.00','0.00','2147483647','2147483647','14.17.37.145','1478159353','1','1','weixin');
INSERT INTO `on_member` VALUES ('46','','','','wx0046','????????小书童大灰宏??????','','','','','','1470850894','120.85.65.118','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.21.61.239','1478766128','1','1','weixin');
INSERT INTO `on_member` VALUES ('55','','','ceshiceshi01@126.com','on_ceshiceshi01','ceshi001','','','96fc600ba51ffdcde25196b30a149981','张三','18123456788','1470969996','113.140.11.3','1','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.140.11.3','1470969996','1','0','');
INSERT INTO `on_member` VALUES ('47','','','','wx0047','文俊','','','','','','1470887113','117.114.129.57','0','0','','0','0','','0','1','','0','33','378','0','','','','0','','0.00','0.00','0.00','0.00','0','0','106.120.183.69','1470968696','1','1','');
INSERT INTO `on_member` VALUES ('48','','','','wx0048','Guardian','','','','','','1470887212','117.114.129.57','0','0','','0','0','','0','1','','0','33','390','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.114.129.57','1470887212','1','1','');
INSERT INTO `on_member` VALUES ('49','','','','wx0049','Z','','','','','','1470889269','112.114.88.213','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','163.177.69.59','1474024810','1','1','');
INSERT INTO `on_member` VALUES ('50','','','','wx0050','Tolerance','','','','','','1470899291','220.173.16.97','0','0','','0','0','','0','1','','0','21','253','0','','','','0','','0.00','0.00','0.00','0.00','0','0','220.173.16.97','1470899291','1','1','');
INSERT INTO `on_member` VALUES ('51','','','','wx0051','大爱小艾','','','','','','1470900558','60.223.222.71','0','0','','0','0','','0','1','','0','9','94','0','','','','0','','0.00','0.00','0.00','0.00','0','0','60.223.222.71','1470900558','1','1','');
INSERT INTO `on_member` VALUES ('52','','','','qw123456','womende','','','c8d0129297f79dd8c277efd65478c6da','夕阳','18986535452','1470904975','113.140.11.3','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.140.11.3','1470904975','1','0','');
INSERT INTO `on_member` VALUES ('53','','','','qw123','qw123456','','','c8d0129297f79dd8c277efd65478c6da','夕阳','17030880529','1470909490','113.140.11.3','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.140.11.3','1470909490','1','0','');
INSERT INTO `on_member` VALUES ('54','','','','wx0054','黄承志～油画','','','','','','1470910677','114.242.250.186','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','115.183.30.62','1479132494','1','1','weixin');
INSERT INTO `on_member` VALUES ('56','','','','wx0056','A广商所收藏品交易中心','','','','','','1470972997','180.153.81.159','0','0','','0','0','','0','1','','0','20','232','0','','','','0','','0.00','0.00','0.00','0.00','0','0','180.153.81.159','1472287454','1','1','');
INSERT INTO `on_member` VALUES ('57','','','','wx0057','奇珍艺宝','','','','','','1470983167','123.151.12.152','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.12.152','1470983167','1','1','');
INSERT INTO `on_member` VALUES ('58','','','','wx0058','林伟敏 ོ','','','','','','1470987622','121.33.119.181','0','0','','0','0','','0','1','','0','20','232','0','','','','0','','0.00','0.00','0.00','0.00','0','0','121.33.119.181','1470987717','1','1','');
INSERT INTO `on_member` VALUES ('59','','','','wx0059','俗人勇 ','','','','','','1470988301','101.226.125.118','0','0','','0','0','','0','1','','0','107','1167','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.118','1471038712','1','1','');
INSERT INTO `on_member` VALUES ('60','','','','wx0060','零点迷雾','','','','','','1470993546','61.187.53.140','0','0','','0','0','','0','1','','0','19','218','0','','','','0','','0.00','0.00','0.00','0.00','0','0','61.187.53.140','1470993546','1','1','');
INSERT INTO `on_member` VALUES ('61','','','','vsfdfer325','系的老爷','vsfdfer325','vsfdfer325vsfdfer325','419fb61de23f7768454fab9cb2978f98','系的老爷','13647534564','1470996760','120.85.65.150','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','120.85.65.150','1470996760','1','0','');
INSERT INTO `on_member` VALUES ('64','','','','wx0064','高文(瞻瞩世纪)','','','','','','1471087823','114.111.167.110','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.139.155','1473514839','1','1','');
INSERT INTO `on_member` VALUES ('62','','','','wx0062','艾泽宇','','','','','','1471004347','125.37.213.166','0','0','','0','0','','0','1','','0','35','405','0','','','','0','','0.00','0.00','0.00','0.00','0','0','111.166.77.165','1480659490','1','1','weixin');
INSERT INTO `on_member` VALUES ('63','','','','wx0063','曹艳军','伊木子','伊木子','','','','1471062318','219.133.40.15','0','0','','0','0','','0','1','','0','20','248','0','','','','0','','0.00','0.00','0.00','0.00','0','0','219.133.40.15','1471272458','1','1','');
INSERT INTO `on_member` VALUES ('65','','','','wx0065','以吃亏为乐、以帮助别人为荣','','','','','','1471104642','14.17.37.161','0','0','','0','0','','0','1','','0','21','253','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.37.161','1471104642','1','1','');
INSERT INTO `on_member` VALUES ('66','','','','wx0066','凤仪画馆','凤仪画馆','书画艺术品','','','','1471173005','163.177.69.13','0','0','','0','0','','0','1','','0','20','234','0','','','','0','','90.00','8.00','0.00','0.00','15','10','183.60.52.5','1477840087','1','1','weixin');
INSERT INTO `on_member` VALUES ('67','','','','wx0067','林悠远Will yeh','','','','','','1471240279','101.226.125.115','0','0','','0','0','','0','1','','0','12','122','0','','','','0','','0.00','0.00','0.00','0.00','0','0','58.100.190.251','1478104715','1','1','');
INSERT INTO `on_member` VALUES ('68','','','','wx0068','杨文华','小小白白','什么什么什么都卖','','','','1471321855','101.226.102.237','0','0','','0','0','','0','1','','0','14','151','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.102.237','1471674682','1','1','');
INSERT INTO `on_member` VALUES ('69','','','','wx0069','跨境产业 阿诺哥','','','','','','1471377931','110.88.34.129','0','0','','0','0','','0','1','','0','14','150','0','','','','0','','0.00','0.00','0.00','0.00','0','0','110.88.34.129','1471377931','1','1','');
INSERT INTO `on_member` VALUES ('70','','','','wx0070','彼岸','wosmaijia','aaaaa','','','','1471417112','14.104.103.32','0','0','','0','0','','0','1','','0','270','2602','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.104.102.136','1473040654','1','1','');
INSERT INTO `on_member` VALUES ('71','','','','wx0071','Mr.TK','','','','','','1471481967','101.226.125.119','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.119','1471481967','1','1','');
INSERT INTO `on_member` VALUES ('72','','','','wx0072','独自上路','','','','','','1471490779','58.23.113.60','0','0','','0','0','','0','1','','0','14','155','0','','','','0','','0.00','0.00','0.00','0.00','0','0','58.23.113.60','1471514717','1','1','');
INSERT INTO `on_member` VALUES ('73','','','','wx0073','段超喜(双喜网络&艾普达投资)','','','','','','1471573135','180.115.214.49','0','0','','0','0','','0','1','','0','11','112','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.207.216.101','1471867849','1','1','');
INSERT INTO `on_member` VALUES ('74','','','','wx0074','哲狼','','','','','','1471585733','101.226.125.116','0','0','','0','0','','0','1','','0','17','187','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.116','1471585733','1','1','');
INSERT INTO `on_member` VALUES ('75','','','','wx0075','静静','','','','','','1471597342','61.181.5.250','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','61.181.5.250','1471597342','1','1','');
INSERT INTO `on_member` VALUES ('76','','','11125@qq.com','A111111','111111','222222','222222','dace20fd1d61e060b931c98bb3e4f7fa','撒先','13852315164','1471658778','58.23.113.60','0','0','','0','0','','0','0','111111','355009','3','35','397','222','','','0','','111104.94','161.00','0.00','0.00','30','0','58.23.113.60','1474884102','1','0','');
INSERT INTO `on_member` VALUES ('77','','','','test123','test','测试','测试测试测试','96fc600ba51ffdcde25196b30a149981','测试','13123456789','1471672398','14.108.102.129','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.108.102.129','1471682683','1','0','');
INSERT INTO `on_member` VALUES ('78','','','','wx0078','杨妃献','','','','','','1471691126','113.104.195.105','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.104.195.105','1471700914','1','1','');
INSERT INTO `on_member` VALUES ('79','','','','yiwantong','yiwantong','333333','3222222222','caed9669cfbd01dfebbe7320918284c0','999','','0','','0','0','','0','0','','0','1','','0','0','0','0','','','','0','','99999.00','0.00','0.00','0.00','0','0','113.104.195.105','1471693694','1','0','');
INSERT INTO `on_member` VALUES ('80','','','','931811','9999','','','caed9669cfbd01dfebbe7320918284c0','999','','0','','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','999.00','0.00','0.00','0.00','999','0','','0','1','0','');
INSERT INTO `on_member` VALUES ('81','','','','wx0081','瑞','','','','','','1471740125','14.17.44.217','0','0','','0','0','','0','1','','0','21','257','0','','','','0','','0.00','0.10','0.00','0.00','0','0','14.17.37.68','1479778597','1','1','weixin');
INSERT INTO `on_member` VALUES ('82','','','','wx0082','……～！？','','','','','','1471754258','183.59.51.214','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.59.51.214','1471754258','1','1','');
INSERT INTO `on_member` VALUES ('83','','','','wx0083','赤风在线','','','','','','1471851200','101.226.61.190','0','0','','0','0','','0','1','','0','11','111','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.61.190','1471851200','1','1','');
INSERT INTO `on_member` VALUES ('84','','','','wx0084','时光','','','','','','1471965005','117.139.205.139','0','0','','0','0','','0','1','','0','24','273','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.139.205.139','1471965005','1','1','');
INSERT INTO `on_member` VALUES ('85','','','','wx0085','静以修身 俭不养德????','','','','','','1471997355','182.34.171.68','0','0','','0','0','','0','1','','0','12','122','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.34.171.68','1471997355','1','1','');
INSERT INTO `on_member` VALUES ('86','','','','wx0086','????金泉????','','','','','','1472023411','112.103.173.90','0','0','','0','0','','0','1','','0','9','94','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.103.173.90','1472023411','1','1','');
INSERT INTO `on_member` VALUES ('87','','','','dingliming','丁黎明','','','96fc600ba51ffdcde25196b30a149981','丁黎明','18584523339','1472023491','180.116.198.148','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','180.116.198.148','1472023491','1','0','');
INSERT INTO `on_member` VALUES ('88','','','','wx0088','leo','','','','','','1472029390','36.149.197.142','0','0','','0','0','','0','1','','0','11','113','0','','','','0','','0.00','0.00','0.00','0.00','0','0','36.149.69.93','1472543933','1','1','');
INSERT INTO `on_member` VALUES ('89','','','','souluojie','sou','村在','村夺大棒地','806f130e3265a8f32070d62102d7d028','李先','13911950841','1472111033','171.107.49.106','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','171.107.49.106','1472111033','1','0','');
INSERT INTO `on_member` VALUES ('94','','','','wx0094','singlife','','','','','','1472198340','101.226.69.112','0','0','','0','0','','0','1','','0','107','1163','0','','','','0','','0.00','0.00','0.00','0.00','0','0','180.173.129.3','1472200116','1','1','');
INSERT INTO `on_member` VALUES ('91','','','','ahgui','agui','','','19e4156acdb915657d4bc35a4d584725','三戒','18615554114','1472147973','121.127.250.252','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','1000.00','0.00','0.00','0.00','0','0','121.127.250.252','1472147973','1','0','');
INSERT INTO `on_member` VALUES ('92','','','','wx0092','王斌','','','','','','1472174363','111.7.170.244','0','0','','0','0','','0','1','','0','17','196','0','','','','0','','0.00','0.00','0.00','0.00','0','0','111.7.170.244','1472174363','1','1','');
INSERT INTO `on_member` VALUES ('93','','','','WX250444984','太阳','','','d87c72056eaba6f982e8f496f775c92a','太阳','13112314568','1472179629','111.196.74.221','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','111.196.74.221','1472179629','0','0','');
INSERT INTO `on_member` VALUES ('95','','','','dssy1234','我看我','杨钰莹','杨钰莹当代画家','3d7b4eabe09578e157222cbaa4d558df','哈哈哈','13881888111','1472232009','211.142.86.165','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','211.142.86.165','1472232009','1','0','');
INSERT INTO `on_member` VALUES ('96','','','','wx0096','王军博','','','','','','1472240833','211.142.86.165','0','0','','0','0','','0','1','','0','5','57','0','','','','0','','0.00','0.00','0.00','0.00','0','0','223.104.14.138','1472291190','1','1','');
INSERT INTO `on_member` VALUES ('97','','','372199007@qq.com','wx0097','翠绿赌石','赌石坊','翠凝祥瑞，丰泽万家','','雷震云','13713004904','1472266805','182.244.33.127','0','1','','0','0','','0','1','乐城街7-8号','678600','26','316','3050','','','','0','','500.00','500.00','0.00','0.00','0','0','39.128.200.126','1474855419','1','1','mobile,weixin');
INSERT INTO `on_member` VALUES ('98','','','','wx0098','万传','','','','','','1472271403','1.202.122.134','0','0','','0','0','','0','1','','0','33','385','0','','','','0','','0.00','0.00','0.00','0.00','0','0','1.202.122.134','1472271403','1','1','');
INSERT INTO `on_member` VALUES ('99','','','','wanchuan666','船长','万传','万传万传万传','f54c383e321d60289ec8d8c0904c5f4d','万传','18500321400','1472271686','1.202.122.134','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','1.202.122.134','1472280137','1','0','');
INSERT INTO `on_member` VALUES ('100','','','','wx0100','Causality','','','','','','1472279967','1.202.122.134','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','1.202.122.134','1472279967','1','1','');
INSERT INTO `on_member` VALUES ('101','','','','wx0101','簡海','测试一下','测试商品','','','','1472313465','101.226.102.237','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.102.237','1472313906','1','1','');
INSERT INTO `on_member` VALUES ('102','','','','wx0102','苦涩','文玩','哈哈镜','','','','1472318465','221.196.136.153','0','0','','0','0','','0','1','','0','35','407','0','','','','0','','0.00','0.00','0.00','0.00','0','0','221.196.136.153','1472318465','1','1','');
INSERT INTO `on_member` VALUES ('103','','','','wx0103','a卧云枕月*宗眀畫院','','','','','','1472345825','123.151.139.145','0','0','','0','0','','0','1','','0','5','57','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.139.145','1472345825','1','1','');
INSERT INTO `on_member` VALUES ('104','','','','wx0104','梵夫子','','','','','','1472382541','211.97.130.231','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.102.237','1479820425','1','1','weixin');
INSERT INTO `on_member` VALUES ('105','','','','wx0105','行云流水','','','','','','1472409929','123.154.160.208','0','0','','0','0','','0','1','','0','20','234','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.154.80.18','1472491888','1','1','');
INSERT INTO `on_member` VALUES ('106','','','','wx0106','A          人渣 ????','','','','','','1472432403','222.85.8.155','0','0','','0','0','','0','1','','0','17','196','0','','','','0','','0.00','0.00','0.00','0.00','0','0','222.85.8.155','1472432403','1','1','');
INSERT INTO `on_member` VALUES ('107','','','','wx0107','浪里个浪','1111去','换回来了路','','','','1472440708','14.17.44.214','0','0','','0','0','','0','1','','0','26','315','0','','','','0','','0.00','0.00','0.00','0.00','0','0','39.128.15.10','1480074999','1','1','weixin');
INSERT INTO `on_member` VALUES ('108','','','','wx0108','独家记忆','','','','','','1472445462','101.226.69.112','0','0','','0','0','','0','1','','0','14','150','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.69.112','1472445462','1','1','');
INSERT INTO `on_member` VALUES ('109','','','','wx0109','AAA萧萧13771080302','AAA','国际矿业','','','','1472451240','49.80.149.180','0','0','','0','0','','0','1','','0','11','113','0','','','','0','','0.00','0.00','0.00','0.00','0','0','49.80.149.35','1472527174','1','1','');
INSERT INTO `on_member` VALUES ('110','','','','wx0110','左','','','','','','1472452574','123.151.42.50','0','0','','0','0','','0','1','','0','4','45','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.42.50','1472558527','1','1','');
INSERT INTO `on_member` VALUES ('111','','','','adchn2016829','taiyang','','','5b5dd6d0d7d319ea72f3ab44c042399a','李先生','13071170550','1472454765','111.196.71.33','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','111.196.71.33','1472457606','1','0','');
INSERT INTO `on_member` VALUES ('112','','','','wx0112','经纬','','','','','','1472456299','182.140.184.85','0','0','','0','0','','0','1','','0','24','286','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.140.184.85','1474436285','1','1','');
INSERT INTO `on_member` VALUES ('113','','','','wx0113','笑语晏晏','','','','','','1472456405','223.85.132.35','0','0','','0','0','','0','1','','0','24','273','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.131.10.11','1472466190','1','1','');
INSERT INTO `on_member` VALUES ('114','','','','wx0114','AAA贺淳涛','','','','','','1472525706','101.226.61.190','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','1000000.00','114.40','0.00','0.00','0','0','101.226.61.190','1472525706','1','1','');
INSERT INTO `on_member` VALUES ('115','','','','wx0115','马可','','','','','','1472527901','211.97.122.8','0','0','','0','0','','0','1','','0','14','150','0','','','','0','','0.00','0.00','0.00','0.00','0','0','211.97.122.8','1472527901','1','1','');
INSERT INTO `on_member` VALUES ('116','','','','wx0116','罗永强','','','','','','1472538680','61.144.53.178','0','0','','0','0','','0','1','','0','20','232','0','','','','0','','0.00','0.00','0.00','0.00','0','0','61.144.53.178','1472538680','1','1','');
INSERT INTO `on_member` VALUES ('117','','','','wx0117','钢','','','','','','1472546484','103.240.124.117','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','103.240.124.117','1472546484','1','1','');
INSERT INTO `on_member` VALUES ('118','','','','wx0118','1颗温暖的心｀','','','','','','1472597239','113.135.140.69','0','0','','0','0','','0','1','','0','28','326','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.200.107.206','1480260337','1','1','weixin');
INSERT INTO `on_member` VALUES ('119','','','1445708819@qq.com','on_13803894661','阿杰','','','9c0d21eb51082a612cbfc85cdc523352','王杰','13803894661','1472612458','125.47.88.167','0','1','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','125.47.88.167','1472612458','1','0','');
INSERT INTO `on_member` VALUES ('120','','','24401706@qq.com','on_13098708609','121231','小米加','专注','66d150c5d153b3569a50e0c5a32bad58','彭钢','13098708609','1472612840','103.240.124.117','0','1','','0','0','','0','0','','0','0','0','0','','','','0','','11111.00','0.00','500.00','115.40','0','0','103.240.124.117','1472612840','1','0','');
INSERT INTO `on_member` VALUES ('121','','','','wx0121','静篤堂   篤之','','','','','','1472624442','163.177.94.120','0','0','','0','0','','0','1','','0','20','234','0','','','','0','','200.00','0.00','0.00','0.00','0','0','163.177.94.120','1472624442','1','1','');
INSERT INTO `on_member` VALUES ('122','','','','wx0122','゛温ゝ先生','','','','','','1472626054','218.62.64.152','0','0','','0','0','','0','1','','0','1','8','0','','','','0','','0.00','0.00','0.00','0.00','0','0','218.62.64.152','1472626054','1','1','');
INSERT INTO `on_member` VALUES ('123','','','','wx0123','仕君','','','','','','1472626926','219.133.40.15','0','0','','0','0','','0','1','','0','20','234','0','','','','0','','200.00','0.00','0.00','0.00','0','0','219.133.40.15','1472626926','1','1','');
INSERT INTO `on_member` VALUES ('124','','','','wx0124','纵横四海','','','','','','1472636862','210.79.121.114','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','163.177.69.59','1476433931','1','1','');
INSERT INTO `on_member` VALUES ('128','','','','wx0128','Andy朱小明','','','','','','1472712156','222.92.146.66','0','0','','0','0','','0','1','','0','11','113','0','','','','0','','0.00','0.00','0.00','0.00','0','0','222.92.146.66','1472712156','1','1','');
INSERT INTO `on_member` VALUES ('125','','','','wx0125','sandmanhx','测试卖家','测试','','','18975860980','1472648133','183.60.52.5','0','1','','0','0','','0','1','','0','19','218','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.37.68','1473436407','1','1','');
INSERT INTO `on_member` VALUES ('127','','','','Android','Android','看看','路路通','bba249fcccc4e6a9bbb6a43984b46f77','居然','13800138000','1472685594','110.85.214.14','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','110.85.214.14','1472685771','1','0','');
INSERT INTO `on_member` VALUES ('126','','','','wx0126','空谷幽兰','','','','','','1472659731','119.162.255.152','0','0','','0','0','','0','2','','0','33','385','0','','','','0','','0.00','0.00','0.00','0.00','0','0','119.162.255.152','1472659731','1','1','');
INSERT INTO `on_member` VALUES ('129','','','','wx0129','A0赵明海','','','','','','1472767815','123.151.12.152','0','0','','0','0','','0','1','','0','16','176','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.18','1473334373','1','1','');
INSERT INTO `on_member` VALUES ('133','','','','wx0133','书法达人秀报名咨询-易君','','','','','','1472794516','219.133.40.13','0','0','','0','0','','0','1','','0','20','234','0','','','','0','','0.00','0.00','0.00','0.00','0','0','219.133.40.13','1472794516','1','1','');
INSERT INTO `on_member` VALUES ('134','','','','wx0134','王杰','','','','','','1472813230','101.226.61.184','0','0','','0','0','','0','1','','0','107','1166','0','','','','0','','0.00','0.00','0.00','0.00','0','0','223.104.5.236','1480245954','1','1','weixin');
INSERT INTO `on_member` VALUES ('132','','','25162327@qq.com','on_15843633100','黄帅','草上飞的世界','客服电话：13803845077   客服邮箱：1772703372@qq.com   地址：地址：河南省新乡市长垣南蒲区 ','96fc600ba51ffdcde25196b30a149981','黄帅','13840306248','0','','0','1','','0','0','User/57c9631110d88.jpg','0','1','胜利大街7号','110300','7','71','849','没有最好的，只有更好的！','1111','','0','','4970.00','0.00','5000.00','120.00','15','100','60.16.246.4','1473812937','1','0','');
INSERT INTO `on_member` VALUES ('135','','','','on_15843633100','黄帅','黄泽小店','古玩','96fc600ba51ffdcde25196b30a149981','','','1472814167','123.191.59.157','0','0','','0','0','','0','1','','0','7','71','0','','','','0','','5000.00','0.00','5000.00','0.00','0','0','123.191.59.157','1472814167','1','1','');
INSERT INTO `on_member` VALUES ('136','','','','wx0136','默者非靡','','','','','','1472867256','101.226.125.116','0','0','','0','0','','0','1','','0','18','213','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.57.183.91','1479030843','1','1','weixin');
INSERT INTO `on_member` VALUES ('137','','','','lou116lou116','lou116','lou116lou116','lou116lou116lou116','bec8b00d90b90aba1c63c803f76e49e5','刘伟','13840306589','1472869149','123.191.59.157','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','5000.00','500.00','0.00','0.00','0','0','123.191.59.157','1472873906','1','0','');
INSERT INTO `on_member` VALUES ('138','','','','wx0138','威力兄弟','','','','','','1472890698','116.22.196.85','0','0','','0','0','','0','1','','0','20','232','0','','','','0','','0.00','0.00','0.00','0.00','0','0','116.22.196.85','1472890698','1','1','');
INSERT INTO `on_member` VALUES ('139','','','','wx0139','大可','','','','','','1472940847','123.151.139.145','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.139.145','1472940847','1','1','');
INSERT INTO `on_member` VALUES ('140','','','','wx0140','罗友财','来来往往','爱买就买不买就算','','','','1472981734','219.133.40.14','0','0','','0','0','','0','1','','0','21','253','0','','','','0','','0.00','0.00','0.00','0.00','0','0','219.133.40.14','1472981734','1','1','');
INSERT INTO `on_member` VALUES ('141','','','','wx0141','风语者','','','','','','1472996773','123.151.38.94','0','0','','0','0','','0','1','','0','6','60','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.38.94','1473401707','1','1','');
INSERT INTO `on_member` VALUES ('142','','','','wx0142','廖鹏飞','','','','','','1473009869','182.131.10.30','0','0','','0','0','','0','1','','0','24','282','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.131.10.30','1473009869','1','1','');
INSERT INTO `on_member` VALUES ('143','','','','noah1982','noah','车子拍卖','车子拍卖','96fc600ba51ffdcde25196b30a149981','车子','13122223333','1473038101','221.3.17.243','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','9774.00','500.00','0.00','0.00','15','0','124.129.204.191','1476414021','1','0','');
INSERT INTO `on_member` VALUES ('147','','','','wx0147','风清扬','','','','','','1473088035','101.226.89.14','0','0','','0','0','','0','1','','0','14','157','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.89.14','1473088035','1','1','');
INSERT INTO `on_member` VALUES ('144','','','','wx0144','天使老兵','','','','','','1473064024','113.109.212.20','0','0','','0','0','','0','1','','0','20','232','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.109.212.20','1473064024','1','1','');
INSERT INTO `on_member` VALUES ('145','','','','wx0145','白舒文','','','','','','1473067108','125.70.0.29','0','0','','0','0','','0','1','','0','24','273','0','','','','0','','0.00','0.00','0.00','0.00','0','0','125.70.0.29','1473067108','1','1','');
INSERT INTO `on_member` VALUES ('146','','','','wx0146','胡瀚文|一道堂','一道堂','一道堂','','','','1473067592','219.133.40.16','0','0','','0','0','','0','1','','0','20','232','0','','','','0','','0.00','0.00','0.00','0.00','0','0','219.133.40.16','1474859009','1','1','');
INSERT INTO `on_member` VALUES ('148','','','','wx0148','凪。','','','','','','1473120371','112.94.64.105','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.94.64.105','1473120371','1','1','');
INSERT INTO `on_member` VALUES ('150','','','','a123321','a123','淡淡的','谁是谁','6fd0446389bab4cc8bf553a448532164','喀喀喀','13800138000','1473176982','120.34.154.142','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','120.34.154.142','1473180651','1','0','');
INSERT INTO `on_member` VALUES ('149','','','','wx0149','马跃','','','','','','1473145509','123.151.64.143','0','0','','0','0','','0','1','','0','9','94','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.64.143','1473176770','1','1','');
INSERT INTO `on_member` VALUES ('151','','','','wx0151','君心醉紅顔','11好','哈哈哈','','','','1473177068','120.34.154.142','0','0','','0','0','','0','1','','0','14','155','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.119','1473387702','1','1','');
INSERT INTO `on_member` VALUES ('152','','','','wx0152','明心堂','空庐','中国画精品展销拍卖','36cf37589a611bd86798bd3f975b7a74','','','1473186154','183.232.120.39','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','5726.00','701.10','0.00','0.00','0','0','183.13.251.35','1477074505','1','1','weixin');
INSERT INTO `on_member` VALUES ('153','','','','wx0153','马小贱Yeah~☀','','','','','','1473211834','61.183.196.158','0','0','','0','0','','0','1','','0','208','2105','0','','','','0','','0.00','0.00','0.00','0.00','0','0','61.183.196.158','1473211834','1','1','');
INSERT INTO `on_member` VALUES ('154','','','','mymsdn','mymsdn','','','96fc600ba51ffdcde25196b30a149981','刘贵华','18602844096','1473221337','110.184.20.47','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','110.184.20.47','1473221337','1','0','');
INSERT INTO `on_member` VALUES ('155','','','','wx0155','圣婴','圣品古玩','圣品古玩','','','','1473241494','101.226.89.14','0','0','','0','0','','0','2','','0','107','1167','0','','','','0','','10100.00','520.00','0.00','0.00','0','0','101.226.89.14','1474182915','1','1','');
INSERT INTO `on_member` VALUES ('156','','','','wx0156','边防','','','','','','1473242749','101.226.125.15','0','0','','0','0','','0','1','','0','107','1168','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.15','1473983934','1','1','');
INSERT INTO `on_member` VALUES ('157','','','','wx0157','如风♛','龙媒','龙媒网络','','','','1473244235','113.99.14.206','0','0','','0','0','','0','1','','0','20','232','0','','','','0','','0.00','0.00','0.00','0.00','0','0','119.131.180.57','1478157080','1','1','weixin');
INSERT INTO `on_member` VALUES ('161','','','','wx0161','小香香','','','','','','1473268539','115.215.114.118','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','115.215.118.91','1473499758','1','1','');
INSERT INTO `on_member` VALUES ('158','','','','wx0158','蔚蓝屋檐','','','','','','1473249800','14.104.101.44','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.104.97.151','1473403801','1','1','');
INSERT INTO `on_member` VALUES ('159','','','283629086@qq.com','wx0159','徽脸小徽','金口玉言','来咯鲁磨路YY','','不哭','13365699665','1473254771','101.226.125.122','0','0','','0','0','','0','1','loll哦咯OTZ我摸1','230000','13','133','1401','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.122','1473254771','1','1','');
INSERT INTO `on_member` VALUES ('160','','','','wx0160','苗涛 l 文物大联盟','','','','','','1473261486','1.80.39.76','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.32.143.231','1476091071','1','1','');
INSERT INTO `on_member` VALUES ('162','','','','wx0162','咸阳 十年互联网+ 移动互联网 专家','','','','','','1473304025','101.226.125.122','0','0','','0','0','','0','1','','0','16','171','0','','','','0','','0.00','0.00','0.00','0.00','0','0','221.3.17.243','1473305942','1','1','');
INSERT INTO `on_member` VALUES ('163','','','','wx0163','车明玺','','','','','','1473305891','221.3.17.243','0','0','','0','0','','0','1','','0','16','171','0','','','','0','','0.00','0.00','0.00','0.00','0','0','221.215.255.76','1476082431','1','1','');
INSERT INTO `on_member` VALUES ('164','','','','wx0164','我自然    ????????微信美国会','小强','我车市','','','','1473391644','60.20.208.178','0','0','','0','0','','0','1','','0','7','72','0','','','','0','','0.00','0.00','0.00','0.00','0','0','119.113.151.197','1480752972','1','1','weixin');
INSERT INTO `on_member` VALUES ('165','','','','wx0165','邦仔????','','','','','','1473392532','223.159.28.153','0','0','','0','0','','0','1','','0','19','223','0','','','','0','','0.00','0.00','0.00','0.00','0','0','223.159.28.153','1473392532','1','1','');
INSERT INTO `on_member` VALUES ('166','','','','wx0166','Mayon','','','','','','1473399720','101.226.125.120','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.120','1473399720','1','1','');
INSERT INTO `on_member` VALUES ('167','','','','wx0167','三七友','','','','','','1473400868','125.95.207.161','0','0','','0','0','','0','1','','0','20','237','0','','','','0','','0.00','0.00','0.00','0.00','0','0','125.95.207.161','1473400868','1','1','');
INSERT INTO `on_member` VALUES ('168','','','ebian123@qq.com','on_13350740612','达a','dadadadada','ddddddddda','59d016ff9bef1066616f227668580298','达a','13350740612','1473409961','182.150.143.241','1','1','','0','0','','0','1','','0','0','0','0','','','','0','','99991000.00','-9000.00','100000000.00','0.00','10000','0','182.150.140.243','1474852941','1','0','email,mobile');
INSERT INTO `on_member` VALUES ('169','','','','001002','ceshi001','','','96fc600ba51ffdcde25196b30a149981','只会','13930122976','1473409967','124.239.181.34','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','1000000.00','0.00','0.00','0.00','0','0','124.239.181.34','1473409967','1','0','');
INSERT INTO `on_member` VALUES ('170','','','108938535@qq.com','13888888888','123456','亚太地区','不求有功','96fc600ba51ffdcde25196b30a149981','刘谦','13888888888','1473431916','163.142.175.209','0','0','','0','0','','0','1','fdsafsdfsdfdsfc','414000','18','205','2073','无奇不有载满','','','0','','100000.00','520.00','0.00','0.00','0','0','163.142.175.209','1473431916','1','0','');
INSERT INTO `on_member` VALUES ('171','','','','liuliu','fdsafsf','','','96fc600ba51ffdcde25196b30a149981','大规模','13666666666','1473432698','163.142.175.209','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','100000.00','0.00','0.00','0.00','0','0','163.142.175.209','1473432698','1','0','');
INSERT INTO `on_member` VALUES ('172','','','','wx0172','和平 ????','','','','','','1473478065','14.17.37.161','0','0','','0','0','','0','1','','0','19','229','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.37.161','1473478065','1','1','');
INSERT INTO `on_member` VALUES ('173','','','','mlaimie','mlaimie','宝宝珠宝','宝百福汇死哦','49e39d41a3901f0c72c3c05937a32ab8','骂了','13570906909','1473489104','14.213.156.115','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.213.156.115','1473489104','1','0','');
INSERT INTO `on_member` VALUES ('196','','','','xiaoming2','张晓','发发发','啊发发发','21793c89fa33393071b5a05760a228db','张晓','15665862146','1473820413','114.242.31.201','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','99999456.00','100.00','0.00','0.00','0','0','114.242.31.201','1474263313','1','1','');
INSERT INTO `on_member` VALUES ('175','','','','wx0175','NASA','','','','','','1473496051','101.226.125.115','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.140.184.154','1478152819','1','1','weixin');
INSERT INTO `on_member` VALUES ('176','','','','wx0176','平凡','云南兰花','专业做兰花信息','182892d75438d96b4468d2a13804bbca','','','1473553579','219.133.40.13','0','0','','0','0','','0','1','','0','26','303','0','','','','0','','500.00','500.00','600.00','0.00','0','4','39.128.28.40','1474073742','1','1','');
INSERT INTO `on_member` VALUES ('177','','','','wx0177','昆明兰花网','昆明兰花','专业兰花','182892d75438d96b4468d2a13804bbca','','13888785641','1473554707','219.133.40.13','0','1','','0','0','','0','1','','0','26','303','0','','','','0','','591.04','500.00','110.00','0.00','30','0','183.224.92.115','1480355516','1','0','weixin');
INSERT INTO `on_member` VALUES ('180','','','','zhanjiao','占蛟','','','96fc600ba51ffdcde25196b30a149981','占蛟','','0','','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','6510.00','-480.00','0.00','0.00','0','0','192.168.1.238','1482312807','1','0','');
INSERT INTO `on_member` VALUES ('178','','','','wang3917','浪了','云南兰花苑','专业花卉','182892d75438d96b4468d2a13804bbca','青春','15718718764','1473576678','183.224.93.187','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.224.93.187','1473576678','1','0','');
INSERT INTO `on_member` VALUES ('179','','','','wx0179','段皇后','','','','','','1473582485','163.177.82.13','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','163.177.82.13','1473582485','1','1','weixin');
INSERT INTO `on_member` VALUES ('181','','','','abcde','abcde','旺旺','问问','1fa1e0776c66199678ca0bd84ae2cd4d','哈哈哈','13812345678','1473656806','119.113.146.217','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','119.113.146.217','1473656806','1','0','');
INSERT INTO `on_member` VALUES ('182','','','','wx0182','龙波','','','','','','1473660439','106.36.58.83','0','0','','0','0','','0','1','','0','28','326','0','','','','0','','0.00','0.00','0.00','0.00','0','0','106.36.58.83','1473660439','1','1','weixin');
INSERT INTO `on_member` VALUES ('183','','','','wx0183','van','','','','','','1473679131','49.65.158.101','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','49.65.158.101','1473679131','1','1','weixin');
INSERT INTO `on_member` VALUES ('184','','','','wx0184','Aman','','','','','','1473688981','43.255.179.78','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','43.255.179.78','1473688981','1','1','weixin');
INSERT INTO `on_member` VALUES ('185','','','','wx0185','Andy·Zhang','','','','','','1473734354','101.226.68.141','0','0','','0','0','','0','1','','0','107','1165','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.68.141','1473734354','1','1','weixin');
INSERT INTO `on_member` VALUES ('186','','','','wx0186','方振','','','','','','1473737562','221.234.217.198','0','0','','0','0','','0','1','','0','18','204','0','','','','0','','0.00','0.00','0.00','0.00','0','0','223.104.20.105','1474072286','1','1','weixin');
INSERT INTO `on_member` VALUES ('199','','','','wx0199','闲拍','','','','','','1473844510','101.226.125.118','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.118','1473844510','1','1','weixin');
INSERT INTO `on_member` VALUES ('200','','','','wx0200','Randa_C.MEi','','','','','','1473846191','122.100.187.86','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','60.246.250.134','1474187891','1','1','weixin');
INSERT INTO `on_member` VALUES ('189','','','','wx0189','广润斋珠宝行','心在百货','大的点点滴滴','','','','1473749833','123.151.38.94','0','0','','0','0','','0','2','','0','26','316','0','','','','0','','0.00','0.00','0.00','0.00','0','0','116.249.47.32','1477136210','1','1','weixin');
INSERT INTO `on_member` VALUES ('190','','','49853086@qq.com','on_49853086','noahtest','','','96fc600ba51ffdcde25196b30a149981','竞拍','13355558888','1473751038','221.3.17.243','1','0','','0','0','','0','0','','0','0','0','0','','','','0','','10000.00','200.00','0.00','0.00','0','0','221.3.17.243','1473751038','1','0','');
INSERT INTO `on_member` VALUES ('191','','','','wx0191','目土土','','','','','','1473752830','119.132.14.244','0','0','','0','0','','0','1','','0','15','166','0','','','','0','','0.00','0.00','0.00','0.00','0','0','119.132.14.244','1473752830','1','1','weixin');
INSERT INTO `on_member` VALUES ('192','','','','wx0192','12点30分下雨的日子','','','','','','1473756635','219.133.40.16','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','219.133.40.16','1474683319','1','1','weixin');
INSERT INTO `on_member` VALUES ('193','','','','wx0193','緣亻分d兲空','','','','','','1473809025','101.226.61.186','0','0','','0','0','','0','1','','0','12','123','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.61.186','1473809025','1','1','weixin');
INSERT INTO `on_member` VALUES ('194','','','','guest','guest','哈哈','健健康康','96fc600ba51ffdcde25196b30a149981','听说','13800138000','1473811290','140.224.148.203','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','140.224.148.203','1473811290','1','0','');
INSERT INTO `on_member` VALUES ('195','','','','zhangxiaoming','张小明','发顺丰','是否是否方师傅师傅','904a349311507d02beed7e0aad2751ae','张小明','14242424424','1473818725','114.242.31.201','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','100000000.00','0.00','0.00','0.00','0','0','114.242.31.201','1473833537','1','0','');
INSERT INTO `on_member` VALUES ('201','','','','wx0201','A晶熙','','','','','','1473890600','101.226.125.122','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.122','1473890600','1','1','weixin');
INSERT INTO `on_member` VALUES ('202','','','','wx0202','Jack','','','','','','1473947092','14.17.44.215','0','0','','0','0','','0','1','','0','20','237','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.213.157.159','1477498551','1','1','weixin');
INSERT INTO `on_member` VALUES ('203','','','','wx0203','红魚谷','','','','','','1473980249','123.151.40.34','0','0','','0','0','','0','1','','0','9','103','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.40.34','1474123067','1','1','weixin');
INSERT INTO `on_member` VALUES ('204','','','','http1','a1254','','','6fd0446389bab4cc8bf553a448532164','非别想太','13500005555','1473987455','58.132.177.124','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','58.132.177.124','1473987455','1','0','');
INSERT INTO `on_member` VALUES ('205','','','','wx0205','马俊','','','','','','1474019354','183.196.13.6','0','0','','0','0','','0','1','','0','4','37','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.196.13.9','1474285295','1','1','weixin');
INSERT INTO `on_member` VALUES ('206','','','','wx0206','王立云：软件超市创始人','','','','','','1474021550','223.104.13.53','0','0','','0','0','','0','1','','0','4','37','0','','','','0','','0.00','0.00','0.00','0.00','0','0','223.104.13.8','1474285241','1','1','weixin');
INSERT INTO `on_member` VALUES ('207','','','','cqdjzls','cqdjzls','老左','老左','a21c4d6db140f7d5a11c496be04aa4c7','左林森','13452103173','1474046233','124.116.244.127','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','124.116.244.127','1474046233','1','0','');
INSERT INTO `on_member` VALUES ('208','','','','wx0208','小刚','','','','','','1474167530','123.151.42.57','0','0','','0','0','','0','1','','0','4','37','0','','','','0','','100000000.00','0.10','0.00','0.00','0','0','123.151.42.57','1474286094','1','1','weixin');
INSERT INTO `on_member` VALUES ('209','','','','hy111111','111111','','','dace20fd1d61e060b931c98bb3e4f7fa','张三','13333333333','1474183164','115.213.132.95','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','115.213.132.95','1474183164','1','1','');
INSERT INTO `on_member` VALUES ('210','','','','wx0210','香藏家剑峰','','','','','','1474211248','121.205.205.246','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','110.82.187.221','1478317261','1','1','weixin');
INSERT INTO `on_member` VALUES ('211','','','','wx0211','999。','','','','','','1474247339','219.144.146.212','0','0','','0','0','','0','1','','0','28','328','0','','','','0','','0.00','0.00','0.00','0.00','0','0','219.144.146.212','1474247339','1','1','weixin');
INSERT INTO `on_member` VALUES ('212','','','','wx0212','寻宝途网-张戈宁','','','','','','1474253237','175.9.181.228','0','0','','0','0','','0','1','','0','19','218','0','','','','0','','0.00','0.00','0.00','0.00','0','0','175.9.181.228','1474253237','1','1','weixin');
INSERT INTO `on_member` VALUES ('213','','','','wx0213','高文(莎文爱恋)','','','','','','1474254708','123.151.139.155','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.139.155','1474254708','1','1','weixin');
INSERT INTO `on_member` VALUES ('214','','','','wx0214','阿笔','','','','','','1474255000','101.226.125.113','0','0','','0','0','','0','1','','0','14','151','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.113','1474255000','1','1','weixin');
INSERT INTO `on_member` VALUES ('215','','','','wx0215','老哥','','','','','','1474267116','123.151.64.142','0','0','','0','0','','0','1','','0','7','71','0','','','','0','','100000000.00','0.00','100000000.00','0.00','0','0','123.151.64.142','1478076950','1','1','weixin');
INSERT INTO `on_member` VALUES ('220','','','','wx0220','挥手云端','','','','','','1474363990','123.151.64.142','0','0','','0','0','','0','1','','0','13','143','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.64.142','1474450083','1','1','weixin');
INSERT INTO `on_member` VALUES ('216','','','','wx0216','13802560070','','','','','','1474277990','101.226.125.118','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.118','1474445607','1','1','weixin');
INSERT INTO `on_member` VALUES ('217','','','','wx0217','越平凡〞越长久','','','','','','1474341127','180.104.198.40','0','0','','0','0','','0','1','','0','11','109','0','','','','0','','0.00','0.00','0.00','0.00','0','0','180.104.46.126','1474968195','1','1','weixin');
INSERT INTO `on_member` VALUES ('218','','','984644635@qq.com','wx0218','徕德古藏','徕德古藏','高端古玩、藏传、文玩及个人原创拍卖','','高庆奎','13099990578','1474342950','123.151.12.154','0','0','','0','0','','0','1','广福城沁福园','650000','26','303','2929','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.12.154','1474342950','1','1','weixin');
INSERT INTO `on_member` VALUES ('219','','','','wx0219','造福者','','','','','','1474345389','123.151.42.57','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.42.57','1474345665','1','1','weixin');
INSERT INTO `on_member` VALUES ('221','','','','wx0221','L@达','','','','','','1474368655','182.140.184.154','0','0','','0','0','','0','1','','0','24','282','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.140.184.154','1474368655','1','1','weixin');
INSERT INTO `on_member` VALUES ('222','','','','wx0222','子燕','燕南飞','燕语呢喃','','','','1474379121','163.177.93.244','0','0','','0','0','','0','2','','0','20','234','0','','','','0','','10000.00','500.00','0.00','0.00','0','0','14.17.37.145','1476671606','1','1','weixin');
INSERT INTO `on_member` VALUES ('223','','','','wx0223','昂酷客服','安卓手机测试','亏了苏联','','','','1474420555','123.151.139.145','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','9888.00','400.00','0.00','0.00','0','0','183.204.103.195','1478827398','1','1','weixin');
INSERT INTO `on_member` VALUES ('224','','','','wx0224','中国红客联盟','','','','','','1474439912','115.60.0.17','0','0','','0','0','','0','1','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','115.60.0.17','1474439912','1','1','weixin');
INSERT INTO `on_member` VALUES ('225','','','','wx0225','闻过则喜','','','','','','1474460470','101.226.61.193','0','0','','0','0','','0','1','','0','16','170','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.61.193','1474613532','1','1','weixin');
INSERT INTO `on_member` VALUES ('226','','','','wx0226','刘思海','测试','测试','82fb74314ee74ca8a4606120340a3357','','','1474466129','14.17.37.43','0','0','','0','0','','0','1','','0','20','243','0','','','','0','','0.00','0.00','0.00','0.00','0','0','111.148.3.210','1474470416','1','1','weixin');
INSERT INTO `on_member` VALUES ('227','','','','wx0227','金翼','','','','','','1474513754','123.151.139.156','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','106.38.103.170','1476342517','1','1','weixin');
INSERT INTO `on_member` VALUES ('228','','','','wx0228','房长','哼哼唧唧给','不健康吃饭估计刚吃饭尴尬','','','','1474529781','123.151.12.152','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.12.152','1474529781','1','1','weixin');
INSERT INTO `on_member` VALUES ('229','','','','wx0229','有无相生','','','','','','1474531050','101.226.125.109','0','0','','0','0','','0','1','','0','16','182','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.109','1474531086','1','1','weixin');
INSERT INTO `on_member` VALUES ('230','','','','wx0230','二串一','','','','','','1474593668','219.133.40.15','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','219.133.40.15','1474593668','1','1','weixin');
INSERT INTO `on_member` VALUES ('231','','','','wx0231','Ryan.Li','','','','','','1474596600','112.94.64.98','0','0','','0','0','','0','1','','0','20','235','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.94.66.163','1474596998','1','1','weixin');
INSERT INTO `on_member` VALUES ('232','','','','wx0232','玖月又拾玖','','','','','','1474601491','112.115.68.7','0','0','','0','0','','0','2','','0','26','303','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.115.68.7','1474601491','1','1','weixin');
INSERT INTO `on_member` VALUES ('233','','','16822810@qq.com','on_13520355157','laoshao','13520355157','上来试试','0016bf9f7c44ae7123b4b1358d90ce68','邵帅','13520355157','1474605191','222.131.152.3','0','1','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.116.60.24','1479973012','1','0','');
INSERT INTO `on_member` VALUES ('234','','','','warran','123456','','','96fc600ba51ffdcde25196b30a149981','王新','18210315163','1474614276','106.2.176.242','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','106.2.176.242','1474614276','1','0','');
INSERT INTO `on_member` VALUES ('235','','','','wx0235','Spider','','','','','','1474634098','112.94.69.150','0','0','','0','0','','0','1','','0','20','238','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.94.69.150','1474634098','1','1','weixin');
INSERT INTO `on_member` VALUES ('236','','','','qw123qq','dgsg','','','6fd0446389bab4cc8bf553a448532164','天工','13555555555','1474702402','222.245.239.100','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','222.245.239.100','1474702402','1','0','');
INSERT INTO `on_member` VALUES ('237','','','','wx0237','星也','','','','','','1474704212','117.136.24.134','0','0','','0','0','','0','1','','0','20','234','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.136.24.134','1474704212','1','1','weixin');
INSERT INTO `on_member` VALUES ('238','','','','wx0238','A睿智琥珀腾冲总店®','','','','','','1474705947','222.219.67.32','0','0','','0','0','','0','1','','0','26','306','0','','','','0','','0.00','0.00','0.00','0.00','0','0','222.219.67.32','1474705947','1','1','weixin');
INSERT INTO `on_member` VALUES ('239','','','','wx0239','nynna 去死海咕嘟归来','','','','','','1474846876','117.136.0.123','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.136.0.123','1474846876','1','1','weixin');
INSERT INTO `on_member` VALUES ('240','','','','wx0240','钱健','','','','','','1474950455','180.106.242.120','0','0','','0','0','','0','1','','0','11','113','0','','','','0','','0.00','0.00','0.00','0.00','0','0','180.106.242.120','1474950455','1','1','weixin');
INSERT INTO `on_member` VALUES ('242','','','','wx0242','明宇','','','','','','1474966120','42.102.240.15','0','0','','0','0','','0','1','','0','9','94','0','','','','0','','0.00','0.00','0.00','0.00','0','0','42.102.240.15','1474966120','1','1','weixin');
INSERT INTO `on_member` VALUES ('243','','','','wx0243','李波','李波','叫呃呃呃的拍卖','96fc600ba51ffdcde25196b30a149981','','','1475049247','115.171.17.118','0','0','','0','0','','0','1','','0','0','0','0','','','','0','','94299.00','600.10','0.00','0.00','0','0','106.39.146.246','1480919840','1','1','weixin');
INSERT INTO `on_member` VALUES ('244','','','','wx0244','针灸疗理专家','','','','','','1475049726','101.226.61.181','0','0','','0','0','','0','2','','0','12','128','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.61.181','1475049726','1','1','weixin');
INSERT INTO `on_member` VALUES ('245','','','','wx0245','A徐州起锚网站建设～吕','','','','','','1475053217','101.226.125.113','0','0','','0','0','','0','1','','0','11','111','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.113','1475053217','1','1','weixin');
INSERT INTO `on_member` VALUES ('246','','','','wx0246','汇通天下担保交易平台张先君58个群','','','','','','1475056697','101.226.125.15','0','0','','0','0','','0','1','','0','11','111','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.15','1475056697','1','1','weixin');
INSERT INTO `on_member` VALUES ('249','','','','ceshiceshi','ccc','测试测试','12121212','96fc600ba51ffdcde25196b30a149981','张三','13645682825','1475116784','222.134.87.102','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','222.134.87.102','1475116784','1','0','');
INSERT INTO `on_member` VALUES ('248','','','','wx0248','卢远','','','','','','1475057568','183.232.90.36','0','0','','0','0','','0','1','','0','19','218','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.232.90.36','1475057568','1','1','weixin');
INSERT INTO `on_member` VALUES ('250','','','','wx0250','聪敏','','','','','','1475197007','14.17.37.69','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.204.104.46','1478134977','1','1','weixin');
INSERT INTO `on_member` VALUES ('251','','','','wx0251','老少','','','','','','1475218612','123.151.64.142','0','0','','0','0','','0','1','','0','33','385','0','','','','0','','0.10','0.10','0.00','0.00','0','0','123.151.15.35','1478846640','1','1','weixin');
INSERT INTO `on_member` VALUES ('252','','','111@11.com','qfroot','test','','','96fc600ba51ffdcde25196b30a149981','阿斯蒂芬','13123212321','1475237818','168.235.93.221','0','0','','0','0','','0','0','dddsafe','111002','3','35','396','asdaaff','','','0','','100000000.00','30.00','0.00','0.00','0','0','123.190.71.201','1476595822','1','0','');
INSERT INTO `on_member` VALUES ('253','','','','woqule','test','','','96fc600ba51ffdcde25196b30a149981','阿斯蒂芬','13123212321','1475238001','168.235.93.221','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','168.235.93.221','1475238001','1','0','');
INSERT INTO `on_member` VALUES ('254','','','','woqule2','test','','','96fc600ba51ffdcde25196b30a149981','阿斯蒂芬','13123212321','1475238940','168.235.93.221','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','168.235.93.221','1475238940','1','0','');
INSERT INTO `on_member` VALUES ('255','','','','wx0255','peanut','','','','','','1475312505','219.133.40.13','0','0','','0','0','','0','1','','0','20','238','0','','','','0','','0.00','0.00','0.00','0.00','0','0','219.133.40.13','1477926377','1','1','weixin');
INSERT INTO `on_member` VALUES ('256','','','','wx0256','如鱼得水','','','','','','1475982806','123.151.64.142','0','0','','0','0','','0','1','','0','35','399','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.11.218.69','1477979215','1','1','weixin');
INSERT INTO `on_member` VALUES ('257','','','ddd@sina.com','on_18622423701','test','fsdfsdf','sdfsdfsdf','dace20fd1d61e060b931c98bb3e4f7fa','斯蒂芬','18622423701','1475983920','125.36.41.98','0','1','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','125.36.41.98','1475983920','1','0','');
INSERT INTO `on_member` VALUES ('258','','','','on_15638558993','全力以赴','杨洋的铺子','杨洋的铺子','b42dd603bd7522b3a70b8ee1f8aa9e7d','洋洋','15638558993','1475986033','115.60.87.134','0','1','','0','0','','0','0','','0','0','0','0','','','','0','','1000.00','0.00','2000.00','0.00','0','0','120.195.65.228','1475987769','1','0','mobile');
INSERT INTO `on_member` VALUES ('259','','','','wx0259','Balinda','','','','','','1475986387','123.151.42.57','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.42.57','1475989846','1','1','weixin');
INSERT INTO `on_member` VALUES ('260','','','','wx0260','杨昆','','','','','','1475988239','123.151.152.151','0','0','','0','0','','0','1','','0','17','196','0','','','','0','','0.00','0.00','5.00','0.00','0','0','115.60.87.208','1476962550','1','1','weixin');
INSERT INTO `on_member` VALUES ('261','','','','wx0261','朕','','','','','','1475988816','120.195.65.199','0','0','','0','0','','0','1','','0','17','201','0','','','','0','','0.00','0.00','0.00','0.00','0','0','120.195.65.199','1475988816','1','1','weixin');
INSERT INTO `on_member` VALUES ('262','','','','wx0262','小强','','','','','','1475990121','14.17.44.215','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.44.215','1475990121','1','1','weixin');
INSERT INTO `on_member` VALUES ('263','','','','wx0263','蓝宝','','','','','','1475997891','14.17.34.237','0','0','','0','0','','0','1','','0','20','251','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.34.237','1475997891','1','1','weixin');
INSERT INTO `on_member` VALUES ('264','','','','vsfsf324','测试收藏','','','d0d8f38252334064411a5f75bedba573','测试收藏','13640734254','1475998081','183.21.61.54','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.21.61.54','1475998081','1','0','');
INSERT INTO `on_member` VALUES ('265','','','7195843@qq.com','wx0265','汪聪','汪聪','我是','','汪聪','15900804260','1475999121','101.226.125.19','0','0','','0','0','','0','1','军工路','200438','10','107','1168','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.19','1476084766','1','1','weixin');
INSERT INTO `on_member` VALUES ('266','','','kk48323201@qq.com','on_kk48323201','kk888','','','96fc600ba51ffdcde25196b30a149981','里先生','13702768919','1476043606','14.125.48.18','1','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.211.208.236','1476800272','1','0','');
INSERT INTO `on_member` VALUES ('267','','','','wx0267','Jason.','','','','','','1476065559','112.4.218.74','0','0','','0','0','','0','1','','0','11','118','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.4.218.74','1476085196','1','1','weixin');
INSERT INTO `on_member` VALUES ('268','','','','wx0268','乔仂joey','','','','','','1476067067','112.4.218.74','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.4.218.74','1476067067','1','1','weixin');
INSERT INTO `on_member` VALUES ('269','','','','wx0269','YU','','','','','','1476069524','14.17.37.143','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.37.143','1476069524','1','1','weixin');
INSERT INTO `on_member` VALUES ('270','','','76313752@qq.com','on_76313752','测试123','12323','123123','25a346323d9ef2046c6365fa5a80d52b','测试','15922252222','1476075578','59.61.83.118','1','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','59.61.83.118','1476075578','1','0','');
INSERT INTO `on_member` VALUES ('271','','','','wx0271','林羽凡','','','','','','1476083168','60.194.192.3','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','60.194.192.3','1476083168','1','1','weixin');
INSERT INTO `on_member` VALUES ('272','','','','wx0272','徐宏兵','','','','','','1476084016','101.226.125.116','0','0','','0','0','','0','1','','0','11','114','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.116','1476084016','1','1','weixin');
INSERT INTO `on_member` VALUES ('273','','','','wx0273','木易','','','','','','1476088155','117.136.68.108','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.136.68.108','1476088155','1','1','weixin');
INSERT INTO `on_member` VALUES ('274','','','','wx0274','唯佑一鑫','','','','','','1476093522','182.138.166.150','0','0','','0','0','','0','1','','0','272','2632','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.138.166.150','1476093535','1','1','weixin');
INSERT INTO `on_member` VALUES ('275','','','','sadasdff','问问','','','96fc600ba51ffdcde25196b30a149981','啊啊啊','15011112123','1476097815','120.4.240.83','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','8998.00','0.00','5000.00','0.00','0','0','120.4.240.83','1476097815','1','0','');
INSERT INTO `on_member` VALUES ('276','','','','wx0276','海诺风息','','','','','','1476106381','123.151.139.155','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','117.136.38.5','1478134797','1','1','weixin');
INSERT INTO `on_member` VALUES ('277','','','','wx0277','【WJ】????京哥','','','','','','1476114870','123.151.42.46','0','0','','0','0','','0','1','','0','4','45','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.42.46','1476114870','1','1','weixin');
INSERT INTO `on_member` VALUES ('278','','','7195843@qq.com','on_15900807260','111','张张','11111','f0bf6e5df2f60c99abf79d29d8ec8c67','汪聪','15900807260','1476149141','211.136.152.82','0','1','','0','0','','0','0','','0','0','0','0','','','','0','','500.00','500.00','0.00','0.00','0','0','211.136.152.82','1476149141','1','0','');
INSERT INTO `on_member` VALUES ('279','','','','wx0279','空军刺龙','','','','','','1476176746','14.17.37.144','0','0','','0','0','','0','1','','0','22','267','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.37.144','1476176746','1','1','weixin');
INSERT INTO `on_member` VALUES ('280','','','','emba004','kong','','','182892d75438d96b4468d2a13804bbca','空空','13812345678','1476237070','139.189.79.96','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','139.189.79.96','1476237070','1','0','');
INSERT INTO `on_member` VALUES ('281','','','','wx0281','匠难_文杰','匠难','摸摸哦哦弄','','','','1476240924','183.50.167.61','0','0','','0','0','','0','1','','0','20','241','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.50.165.212','1476875854','1','1','weixin');
INSERT INTO `on_member` VALUES ('282','','','','wx0282','APP设计推广','','','','','','1476253906','114.95.13.64','0','0','','0','0','','0','1','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','114.95.13.64','1476253906','1','1','weixin');
INSERT INTO `on_member` VALUES ('288','','','','wx0288','策划者','','','','','','1476533608','101.226.61.142','0','0','','0','0','','0','1','','0','16','171','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.61.142','1476780777','1','1','weixin');
INSERT INTO `on_member` VALUES ('283','','','','wx0283','爱琴海','','','','','','1476346901','123.151.42.48','0','0','','0','0','','0','2','','0','7','71','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.42.48','1476346901','1','1','weixin');
INSERT INTO `on_member` VALUES ('284','','','','chenrg','chenrg','chenrg','chenrg','49af16833201552f8b5031da47ae1334','中国','13000000000','1476414903','116.10.78.181','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','5000.00','500.00','0.00','0.00','0','0','116.10.78.181','1476421959','1','0','');
INSERT INTO `on_member` VALUES ('285','','','3165599@qq.com','on_3165599','wanhe','','','96fc600ba51ffdcde25196b30a149981','万禾','13776097250','1476415768','121.227.192.75','1','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','121.227.192.75','1476421056','1','0','');
INSERT INTO `on_member` VALUES ('286','','','','wx0286','胖子','','','','','','1476430317','123.139.41.110','0','0','','0','0','','0','1','','0','28','326','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.139.41.110','1476430317','1','1','weixin');
INSERT INTO `on_member` VALUES ('287','','','','wx0287','A0雷道_互联网产品技术','','','','','','1476502725','123.151.42.48','0','0','','0','0','','0','1','','0','4','37','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.42.48','1476502725','1','1','weixin');
INSERT INTO `on_member` VALUES ('291','','','','wx0291','primo','','','','','','1476670944','118.212.213.209','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','118.212.213.209','1476670944','1','1','weixin');
INSERT INTO `on_member` VALUES ('289','','','','wx0289','杨华','','','','','','1476628102','163.177.94.114','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','5000.00','0.00','0.00','0.00','0','0','14.17.37.43','1476639976','1','1','weixin');
INSERT INTO `on_member` VALUES ('290','','','','asdfasdg123','以注册','asdfasdg123','asdfasdg123','a8c627f07e2aa100e37801940235ed82','以注册','13875454545','1476667238','122.235.161.132','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','122.235.161.132','1476667238','1','0','');
INSERT INTO `on_member` VALUES ('292','','','','a1111111','a1111111','','','82fb74314ee74ca8a4606120340a3357','你好','13812345678','1476672763','112.231.145.113','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','112.231.145.113','1476672763','1','0','');
INSERT INTO `on_member` VALUES ('293','','','','wx0293','鑫仔 ‍微信超級會員','','','','','','1476685415','116.55.200.15','0','0','','0','0','','0','1','','0','26','303','0','','','','0','','0.00','0.00','0.00','0.00','0','0','116.55.200.15','1476685415','1','1','weixin');
INSERT INTO `on_member` VALUES ('295','','','','wx0295','荣大松','','','','','','1476690717','182.91.210.49','0','0','','0','0','','0','1','','0','21','255','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.91.210.49','1476690717','1','1','weixin');
INSERT INTO `on_member` VALUES ('294','','','liuhexin@qq.com','on_13888621631','xinzai','','','806f130e3265a8f32070d62102d7d028','心在','13888621631','1476688099','116.55.200.15','0','1','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','116.55.200.15','1476688099','1','0','');
INSERT INTO `on_member` VALUES ('296','','','','wx0296','随心斋画馆','随心斋画馆','随心斋画馆','','','','1476690829','219.133.40.14','0','0','','0','0','','0','1','','0','33','388','0','','','','0','','5000.00','500.00','0.00','0.00','0','0','120.197.202.17','1477138332','1','1','weixin');
INSERT INTO `on_member` VALUES ('297','','','','shuimohui','水墨汇','水墨汇','水墨汇艺术网','2d391945a68806cd7570d8f0dc692f85','','','0','','0','0','','0','0','User/58077222ee8bf.jpg','0','0','','0','0','0','0','','','','0','','5079.54','602.10','0.00','0.00','30','0','59.40.158.223','1477491182','1','0','');
INSERT INTO `on_member` VALUES ('298','','','','wx0298','李雨航','','','','','','1476694837','113.221.241.15','0','0','','0','0','','0','1','','0','26','303','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.221.241.15','1476694837','1','1','weixin');
INSERT INTO `on_member` VALUES ('300','','','','dahaizhizi','大海之子','海上世界','海上生明月','c4e8a9ce500257740a9654462f3462ad','董少','','0','','0','0','','0','0','','0','1','','0','0','0','0','','','','0','','0.00','0.10','0.00','0.00','0','0','58.60.119.40','1476767007','1','0','');
INSERT INTO `on_member` VALUES ('299','','','','wx0299','带头大哥','','','','','','1476756332','14.17.37.72','0','0','','0','0','','0','1','','0','21','260','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.37.72','1476756332','1','1','weixin');
INSERT INTO `on_member` VALUES ('302','','','','wx0302','文杰','','','','','','1476860433','183.50.165.212','0','0','','0','0','','0','1','','0','20','241','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.50.165.212','1476860441','1','1','weixin');
INSERT INTO `on_member` VALUES ('310','','','','wx0310','邹鹏','','','','','','1476987947','223.73.57.193','0','0','','0','0','','0','1','','0','19','223','0','','','','0','','0.00','0.00','0.00','0.00','0','0','223.73.57.193','1476993853','1','1','weixin');
INSERT INTO `on_member` VALUES ('301','','','','wx0301','小楼……段','','','','','','1476858983','123.151.139.155','0','0','','0','0','','0','1','','0','62','753','0','','','','0','','0.00','0.00','0.00','0.00','0','0','180.174.228.99','1476874247','1','1','weixin');
INSERT INTO `on_member` VALUES ('304','','','','wx0304','莫   忧','','','','','','1476871427','61.158.146.186','0','0','','0','0','','0','1','','0','17','198','0','','','','0','','0.00','0.00','0.00','0.00','0','0','61.158.146.186','1476871427','1','1','weixin');
INSERT INTO `on_member` VALUES ('303','','','','wx0303','坐看云起时','周顺','收藏家','','','','1476868310','101.226.61.142','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','114.244.140.127','1477291309','1','1','weixin');
INSERT INTO `on_member` VALUES ('305','','','','wx0305','梦想成真','商廷勇','河南省平顶山新华区六矿西风共7号楼32号','','','','1476871485','123.5.73.198','0','0','','0','0','','0','2','','0','17','193','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.5.73.198','1476871485','1','1','weixin');
INSERT INTO `on_member` VALUES ('306','','','','wx0306','影子','1元竞拍','心宇9072，售价:80元，现在1元开始竞拍，','','','','1476876153','101.226.125.18','0','0','','0','0','','0','1','','0','12','131','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.18','1476876153','1','1','weixin');
INSERT INTO `on_member` VALUES ('307','','','','wx0307','京','','','','','','1476877030','122.7.213.145','0','0','','0','0','','0','1','','0','16','179','0','','','','0','','0.00','0.00','0.00','0.00','0','0','182.38.111.32','1478139403','1','1','weixin');
INSERT INTO `on_member` VALUES ('308','','','','wx0308','程威','巨魔','金骏眉','','','','1476932851','119.188.100.218','0','0','','0','0','','0','1','','0','16','186','0','','','','0','','6565.00','0.00','0.00','0.00','0','0','123.151.152.151','1478481354','1','1','weixin');
INSERT INTO `on_member` VALUES ('309','','','','mignxintang','千里草堂','千里草堂','千里草堂','2d391945a68806cd7570d8f0dc692f85','','','0','','0','0','','0','0','User/5808a84b45f61.jpg','0','1','','0','0','0','0','','','','0','','0.00','0.00','200.00','100.00','0','0','14.20.116.77','1477125581','1','0','');
INSERT INTO `on_member` VALUES ('311','','','','wx0311','赵志强','','','','','','1477013479','123.151.139.156','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.139.156','1477013479','1','1','weixin');
INSERT INTO `on_member` VALUES ('312','','','','melongfei','melongfe','ddddd','ddddd','9c4b906b994a5df44f0277c23eeb1025','里生','18038197528','1477014474','183.17.122.44','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.17.122.44','1477061288','1','0','');
INSERT INTO `on_member` VALUES ('323','','','14191192@qq.com','wx0323','李保山-千里夜行貓','李保山',' 職業畫家','','','13522596804','1477284029','123.151.42.48','1','1','','0','0','','0','1','','0','33','379','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.126.124.148','1477285632','1','1','weixin');
INSERT INTO `on_member` VALUES ('313','','','','wx0313','辛路','','','','','','1477027702','118.194.241.5','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','118.194.240.50','1477040263','1','1','weixin');
INSERT INTO `on_member` VALUES ('314','','','','p736368471','sdfsadf','','','96fc600ba51ffdcde25196b30a149981','阿斯顿飞','15854525652','1477028048','113.68.65.160','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.68.65.160','1477028048','1','0','');
INSERT INTO `on_member` VALUES ('315','','','','wx0315','地底人','','','','','','1477028133','14.17.37.72','0','0','','0','0','','0','1','','0','20','237','0','','','','0','','0.00','0.00','0.00','0.00','0','0','14.17.37.72','1477028133','1','1','weixin');
INSERT INTO `on_member` VALUES ('317','','','','svsf434','svsf434','','','2f68aa589931d36469e2d85d8cd4e4f1','李生','13640636974','1477105826','183.21.88.14','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.21.88.14','1477105826','1','0','');
INSERT INTO `on_member` VALUES ('316','','','','wx0316','美丽热线','','','','','','1477036116','122.241.208.222','0','0','','0','0','','0','1','','0','12','132','0','','','','0','','0.00','0.00','0.00','0.00','0','0','122.241.208.222','1477036116','1','1','weixin');
INSERT INTO `on_member` VALUES ('319','','','','cyinwang','yaowang','','','cb13bd6761aa712e38aafa567e749741','陈银','13968995071','1477139325','61.164.96.209','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','61.164.96.209','1477144723','1','0','');
INSERT INTO `on_member` VALUES ('318','','','','wx0318','shg','','','','','','1477121591','222.34.93.219','0','0','','0','0','','0','0','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','111.161.52.28','1480853669','1','1','weixin');
INSERT INTO `on_member` VALUES ('320','','','','wx0320','bbq','','','','','','1477146489','222.34.93.219','0','0','','0','0','','0','1','','0','4','38','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.139.155','1481068938','1','1','weixin');
INSERT INTO `on_member` VALUES ('321','','','','w12345','123','','','96fc600ba51ffdcde25196b30a149981','问问','18758251994','1477190376','183.156.158.33','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','183.156.158.33','1477190376','1','0','');
INSERT INTO `on_member` VALUES ('322','','','','wx0322','Seven','','','','','','1477274646','123.151.64.143','0','0','','0','0','','0','1','','0','7','72','0','','','','0','','0.00','0.00','0.00','0.00','0','0','123.151.64.143','1477274646','1','1','weixin');
INSERT INTO `on_member` VALUES ('324','','','','wx0324','雲起樓主','','','','','','1477284999','101.226.125.114','0','0','','0','0','','0','1','','0','16','170','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.125.114','1477361418','1','1','weixin');
INSERT INTO `on_member` VALUES ('325','','','','wx0325','Tim','','','','','','1477290007','118.194.241.5','0','0','','0','0','','0','1','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','118.194.241.5','1477290007','1','1','weixin');
INSERT INTO `on_member` VALUES ('326','','','','wx0326','Set me free','','','','','','1477293576','182.140.184.88','0','0','','0','0','','0','1','','0','24','273','0','','','','0','','0.00','0.00','0.00','0.00','0','0','125.69.53.10','1477809955','1','1','weixin');
INSERT INTO `on_member` VALUES ('327','','','','caiqingyu','蔡庆宇','看看咯哦','看快乐健健康康啦','96fc600ba51ffdcde25196b30a149981','蔡庆宇','','0','','0','0','','0','0','','0','0','','0','0','0','0','','','','0','','0.00','0.00','0.00','0.00','0','0','42.229.19.40','1477294526','1','0','');
INSERT INTO `on_member` VALUES ('328','','','','wx0328','Urum','','','','','','1477300902','58.246.144.98','0','0','','0','0','','0','1','','0','107','1167','0','','','','0','','0.00','0.00','0.00','0.00','0','0','58.246.144.98','1477300902','1','1','weixin');
INSERT INTO `on_member` VALUES ('329','','','','wx0329','小岳','','','','','','1477310942','111.30.131.144','0','0','','0','0','','0','2','','0','7','83','0','','','','0','','0.00','0.00','0.00','0.00','0','0','111.30.131.144','1477310942','1','1','weixin');
INSERT INTO `on_member` VALUES ('330','','','','wx0330','微盟史吉元15066450690','','','','','','1477310942','101.226.89.14','0','0','','0','0','','0','1','','0','16','184','0','','','','0','','0.00','0.00','0.00','0.00','0','0','101.226.89.14','1477310942','1','1','weixin');
INSERT INTO `on_member` VALUES ('331','','','','wx0331','微盟·周凤锐','','','','','','1477311417','113.129.193.43','0','0','','0','0','','0','1','','0','16','184','0','','','','0','','0.00','0.00','0.00','0.00','0','0','113.129.193.43','1477311417','1','1','weixin');
INSERT INTO `on_member` VALUES ('332','','','','wx0332','Tschüs','','','','','','1477317918','140.206.255.175','0','0','','0','0','','0','2','','0','0','1','0','','','','0','','0.00','0.00','0.00','0.00','0','0','140.206.255.175','1477317918','1','1','weixin');
INSERT INTO `on_member` VALUES ('333','','','','a123456','a123456','','','6fd0446389bab4cc8bf553a448532164','阿三','18310100321','1477327055','182.18.112.50','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','182.18.112.50','1477327055','1','0','');
INSERT INTO `on_member` VALUES ('334','','','','wx0334','[腾讯微盟]王迎','','','','','','1477361677','222.175.7.234','0','0','','','','','','2','','','16','184','0','','','','','','0.00','0.00','0.00','0.00','0','0','222.175.7.234','1477361677','1','1','weixin');
INSERT INTO `on_member` VALUES ('335','','','','wx0335','阿泽','','','','','','1477364692','113.116.215.185','0','0','','','','','','1','','','20','234','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.116.215.185','1477364692','1','1','weixin');
INSERT INTO `on_member` VALUES ('336','','','','wx0336','萍萍','','','','','','1477366693','120.194.95.81','0','0','','','','','','1','','','17','187','0','','','','','','0.00','0.00','0.00','0.00','0','0','116.226.155.125','1479949522','1','1','weixin');
INSERT INTO `on_member` VALUES ('337','','','','wx0337','奇珍异宝','','','','','','1477387337','113.108.11.50','0','0','','','','','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.108.11.50','1478104672','1','1','weixin');
INSERT INTO `on_member` VALUES ('338','','','','gaoyuan','yuan','','','e148772baf790e05c23d43be470f6312','高沅','18763366159','1477460502','58.58.176.82','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','58.58.176.82','1477460502','1','0','');
INSERT INTO `on_member` VALUES ('339','','','','wx0339','高沅','','','','','','1477460642','101.226.125.115','0','0','','','','','','2','','','16','180','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.125.115','1477460642','1','1','weixin');
INSERT INTO `on_member` VALUES ('340','','','yayalu@mail.com','denboo2016','denboo','denboo','','d3c45641dad28decef8ec3f6fd7b6755','denboo','17701952202','','','0','1','','','','','','1','黄洲工业园','1','20','232','2312','科技造福人类','17701952202','','','','1800.00','10.10','0.00','0.00','0','10','113.67.224.166','1479876563','1','0','mobile');
INSERT INTO `on_member` VALUES ('341','','','','super@oncoo.net','空','','','c4e8a9ce500257740a9654462f3462ad','','','','','0','0','','','','','','0','','0','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','','','1','0','');
INSERT INTO `on_member` VALUES ('342','','','','wx0342','艾龍','空庐书院','空庐艺术空间','c4e8a9ce500257740a9654462f3462ad','','13088885243','1477501241','59.40.158.223','0','1','','','','User/5810ec18e5b22.jpg','','1','','','20','234','0','','','','','','100.10','100.00','0.00','0.00','30','0','113.108.11.50','1480955359','1','1','weixin');
INSERT INTO `on_member` VALUES ('343','','','','wx0343','雲在堂','','','','','','1477581627','101.226.125.120','0','0','','','','','','1','','','14','150','0','','','','','','0.00','0.00','0.00','0.00','0','0','59.56.123.16','1477624374','1','1','weixin');
INSERT INTO `on_member` VALUES ('345','','','','wx0345','稀缺资源','','','','','','1477630536','223.104.38.154','0','0','','','','','','1','','','33','385','0','','','','','','0.00','0.00','0.00','0.00','0','0','120.52.92.227','1477644533','1','1','weixin');
INSERT INTO `on_member` VALUES ('344','','','','wx0344','a黄花梨文玩收藏余','老余','文玩拍卖','','','','1477624186','59.40.163.36','0','0','','','','','','1','','','20','234','0','','','','','','0.00','0.00','0.00','0.00','0','0','14.17.37.102','1480919505','1','1','weixin');
INSERT INTO `on_member` VALUES ('346','','','','wx0346','贞观国际拍卖(国际品牌值得信赖)','','','','','','1477647943','117.136.70.112','0','0','','','','','','1','','','7','83','0','','','','','','0.00','0.00','0.00','0.00','0','0','117.136.70.112','1477649618','1','1','weixin');
INSERT INTO `on_member` VALUES ('347','','','','wx0347','kennyluo','','','','','','1477711191','14.17.37.143','0','0','','','','','','1','','','20','235','0','','','','','','0.00','0.00','0.00','0.00','0','0','14.17.37.143','1477711191','1','1','weixin');
INSERT INTO `on_member` VALUES ('348','','','','gxx123456','smile','','','96fc600ba51ffdcde25196b30a149981','郭明','18311106400','1477712938','111.201.227.150','0','0','','','','','','','','','0','0','0','','','','','','100000.00','500.00','0.00','0.00','0','0','111.193.26.124','1477902805','1','0','');
INSERT INTO `on_member` VALUES ('349','','','','gxx654321','smile2','','','96fc600ba51ffdcde25196b30a149981','小明','14222223333','1477713266','111.201.227.150','0','0','','','','','','','','','0','0','0','','','','','','300000.00','100.00','0.00','0.00','0','0','111.193.26.124','1477895350','1','0','');
INSERT INTO `on_member` VALUES ('350','','','','daizeqi','daizeqi','daizeqi','daizeqi','6c55906b658d45e989ef65da47640056','戴泽琪','17702726613','1477753495','120.52.92.159','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','118.194.240.50','1478079407','1','0','');
INSERT INTO `on_member` VALUES ('351','','','','wx0351','Lee','','','','','','1477792193','101.226.114.166','0','0','','','','','','1','','','11','115','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.114.166','1477792193','1','1','weixin');
INSERT INTO `on_member` VALUES ('352','','','','ll13795123','tyw','','','b2e67086c992c8af920b9b606d8eb946','唐语文','18716035787','1477797180','111.227.218.87','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','111.227.218.87','1477797180','1','0','');
INSERT INTO `on_member` VALUES ('353','','','','wx0353','赵金明','','','','','','1477799500','1.189.170.173','0','0','','','','','','1','','','9','94','0','','','','','','0.00','0.00','0.00','0.00','0','0','1.189.170.173','1477799500','1','1','weixin');
INSERT INTO `on_member` VALUES ('354','','','','wx0354','','','','','','','1477822183','117.65.102.181','0','0','','','','','','1','','','13','135','0','','','','','','0.00','0.00','0.00','0.00','0','0','117.65.102.181','1477822183','1','1','weixin');
INSERT INTO `on_member` VALUES ('355','','','','wx0355','六方银楼','','','','','','1477883210','119.176.101.60','0','0','','','','','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','119.176.101.60','1477883210','1','1','weixin');
INSERT INTO `on_member` VALUES ('356','','','','wx0356','张卫平','','','','','','1477901537','101.226.125.113','0','0','','','','','','1','','','14','151','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.125.113','1477901537','1','1','weixin');
INSERT INTO `on_member` VALUES ('357','','','','wx0357','Nora燕','','','','','','1477919681','36.110.120.123','0','0','','','','','','2','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','36.110.120.123','1477919681','1','1','weixin');
INSERT INTO `on_member` VALUES ('358','','','','wx0358','领航未来','','','','','','1477929294','171.221.118.50','0','0','','','','','','1','','','20','234','0','','','','','','0.00','0.00','0.00','0.00','0','0','171.221.118.50','1477929294','1','1','weixin');
INSERT INTO `on_member` VALUES ('359','','','','clsc','clsc','','','8cca65179071015d595245784812eb68','clsc','','','','0','0','','','','','','0','','0','0','0','0','','','','','','100000000.00','0.10','0.00','0.00','0','0','119.130.200.180','1477961529','1','0','');
INSERT INTO `on_member` VALUES ('360','','','','clsc1','clsc','','','8cca65179071015d595245784812eb68','','','','','0','0','','','','','','0','','0','0','0','0','','','','','','100000000.00','0.10','0.00','0.00','0','0','119.130.200.180','1477961705','1','0','');
INSERT INTO `on_member` VALUES ('361','','','329013345@qq.com','super@oncoo.net','安特李','安特李','凉爽的受不了','922ab3a875550b71b83f50e617f814e8','李平','13896881207','1477967634','120.199.110.117','1','1','','','','headimgurl','','1','在一起就','325000','12','124','1326','你好我好，大家好','','','','','200.00','100.00','500.00','100.10','200','100','120.199.110.117','1480424901','1','1','email,weixin');
INSERT INTO `on_member` VALUES ('363','','','','wx0363','A0网站建设','','','','','','1477977486','123.151.42.57','0','0','','','','headimgurl','','1','','','7','71','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.42.57','1477977495','1','1','weixin');
INSERT INTO `on_member` VALUES ('364','','','','haofangfang','芳姐','','','cfee5d635f00f9811a390af4a3566487','郝芳芳','18234086303','1477987425','171.116.231.87','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','171.116.231.87','1477987425','1','0','');
INSERT INTO `on_member` VALUES ('365','','','','pang831221','李飞飞','','','1c1bbe23a732a1db6d8241c90a9582c3','李飞飞','18293412231','1478050526','111.225.247.50','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','111.225.247.50','1478050526','1','0','');
INSERT INTO `on_member` VALUES ('366','','','','wx0366','༄Hi-冯先生༄','','','','','','1478068262','222.188.168.221','0','0','','','','headimgurl','','1','','','11','112','0','','','','','','0.00','0.00','0.00','0.00','0','0','222.188.168.221','1478068262','1','1','weixin');
INSERT INTO `on_member` VALUES ('367','','','','wx0367','木子','','','','','','1478071064','120.199.110.117','0','0','','','','headimgurl','','2','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.89.14','1478508186','1','1','weixin');
INSERT INTO `on_member` VALUES ('368','','','','wx0368','网站建设','','','','','','1478073117','59.40.9.6','0','0','','','','headimgurl','','1','','','20','234','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.91.131.110','1478493763','1','1','weixin');
INSERT INTO `on_member` VALUES ('369','','','512698807@qq.com','qweqwe','qweqwe','ceshi','ceshi','82fb74314ee74ca8a4606120340a3357','夏夏','13530887780','1478073624','59.40.9.6','1','1','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.91.131.110','1478489181','1','0','');
INSERT INTO `on_member` VALUES ('370','','','','wx0370','Donnie','','','','','','1478076747','111.161.57.31','0','0','','','','headimgurl','','1','','','33','385','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.176.198','1478744564','1','1','weixin');
INSERT INTO `on_member` VALUES ('371','','','','wx0371','赵亮-無亮','','','','','','1478084989','110.87.189.101','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','110.87.189.101','1478084989','1','1','weixin');
INSERT INTO `on_member` VALUES ('372','','','','wx0372','xat','','','','','','1478092315','14.17.44.216','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','14.17.44.216','1478092315','1','1','weixin');
INSERT INTO `on_member` VALUES ('373','','','','wx0373','林东宇','','','','','','1478092388','113.66.16.3','0','0','','','','headimgurl','','1','','','20','232','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.66.16.3','1478092388','1','1','weixin');
INSERT INTO `on_member` VALUES ('374','','','','test@qq.com','test','test卖家名称','卖家简介','dace20fd1d61e060b931c98bb3e4f7fa','test','','','','0','0','','','','','','0','','0','0','0','0','test','','','','','0.00','0.00','0.00','0.00','0','1','','','0','0','');
INSERT INTO `on_member` VALUES ('375','','','','testtest','test','张三','李四','05bd7c4f9321c35ef133a887a762a16f','张三','13054412111','1478094978','27.212.207.175','0','0','','','','','','0','','0','0','0','0','','','','','','1212421.00','0.00','0.00','0.00','0','0','58.22.65.133','1479136914','1','0','');
INSERT INTO `on_member` VALUES ('376','','','','wx0376','国庆','','','','','','1478103274','182.119.65.188','0','0','','','','headimgurl','','1','','','17','187','0','','','','','','0.00','0.00','0.00','0.00','0','0','182.119.65.188','1478103274','1','1','weixin');
INSERT INTO `on_member` VALUES ('377','','','','wx0377','不努力哪有未来','','','','','','1478108428','61.159.123.45','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','0.00','0.00','0.00','0.00','0','0','61.159.123.45','1478108428','1','1','weixin');
INSERT INTO `on_member` VALUES ('378','','','','wx0378','(╯з╰)','','','','','','1478135517','123.151.42.52','0','0','','','','headimgurl','','1','','','20','234','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.42.52','1478135517','1','1','weixin');
INSERT INTO `on_member` VALUES ('379','','','','wx0379','黑鹰','','','','','','1478135617','211.162.33.45','0','0','','','','headimgurl','','1','','','14','152','0','','','','','','0.00','0.00','0.00','0.00','0','0','211.162.33.45','1478135617','1','1','weixin');
INSERT INTO `on_member` VALUES ('380','','','','wx0380','云信传英','','','','','','1478140018','118.186.6.178','0','0','','','','headimgurl','','0','','0','0','0','0','','','','','','100.00','0.00','500.00','0.00','90','90','118.186.6.178','1478140018','1','1','weixin');
INSERT INTO `on_member` VALUES ('381','','','','xiaoqiang','小强','小强','你好','0269e917d33f7ffa8e103f2a176aeaab','小强','13322225555','1478147024','42.249.154.157','0','0','','','','','','','','','0','0','0','','','','','','500.00','100.00','0.00','0.00','0','0','42.249.154.157','1478147024','1','0','');
INSERT INTO `on_member` VALUES ('393','','','','wx0393','路人己','','','','','','1478499203','101.226.125.120','0','0','','','','headimgurl','','1','','','28','326','0','','','','','','0.00','0.00','0.00','0.00','0','0','124.115.168.58','1480670758','1','1','weixin');
INSERT INTO `on_member` VALUES ('382','','','','wx0382','','','','','','','1478155722','49.83.91.11','0','0','','','','headimgurl','','2','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','49.83.91.11','1478155722','1','1','weixin');
INSERT INTO `on_member` VALUES ('383','','','','wx0383','真诚找老婆结婚','','','','','','1478158216','117.136.93.249','0','0','','','','headimgurl','','1','','','16','177','0','','','','','','0.00','0.00','0.00','0.00','0','0','117.136.93.249','1478158216','1','1','weixin');
INSERT INTO `on_member` VALUES ('384','','','','wx0384','於洪林13951077760','','','','','','1478175353','183.207.217.211','0','0','','','','headimgurl','','1','','','11','109','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.207.217.200','1478227704','1','1','');
INSERT INTO `on_member` VALUES ('385','','','','wx0385','MR·Zhao‍霸途科技','','','','','','1478231962','219.152.31.217','0','0','','','','headimgurl','','1','','','123','1315','0','','','','','','0.00','0.00','0.00','0.00','0','0','219.152.31.217','1478231962','1','1','');
INSERT INTO `on_member` VALUES ('386','','','','wx0386','Right Now','','','','','','1478240683','219.152.31.217','0','0','','','','headimgurl','','1','','','123','1315','0','','','','','','0.00','0.00','0.00','0.00','0','0','219.152.31.217','1478240683','1','1','weixin');
INSERT INTO `on_member` VALUES ('387','','','','m18181802386','拍卖源码','一拍','一拍','0c3a9b65f619f7cccdf699537a96cfb2','拍卖源码','18181802386','1478240986','219.152.31.217','0','1','','','','User/581c3f9a7cf94.jpg','','','','','0','0','0','','','','','','10000.00','0.00','0.00','0.00','0','0','219.152.31.217','1478240986','1','0','mobile');
INSERT INTO `on_member` VALUES ('388','','','','wx0388','周明','','','','','','1478247626','123.151.64.142','0','0','','','','headimgurl','','1','','','5','48','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.64.142','1478247626','1','1','weixin');
INSERT INTO `on_member` VALUES ('389','','','','ww','12','','','00e403d9bf1cf860a1942bf6bceed9df','ww','18758251999','1478312637','183.156.154.192','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.156.154.192','1478312637','1','0','');
INSERT INTO `on_member` VALUES ('390','','','','wx0390','易燃又美味。','','','','','','1478383700','112.195.8.95','0','0','','','','headimgurl','','1','','','24','283','0','','','','','','0.00','0.00','0.00','0.00','0','0','112.195.8.95','1478383700','1','1','weixin');
INSERT INTO `on_member` VALUES ('391','','','','wx0391','恭喜发财','','','','','','1478419292','123.151.40.34','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.161.91.173','1478419543','1','1','weixin');
INSERT INTO `on_member` VALUES ('392','','','13658139@qq.com','wx0392','木易楊','摄影馆','宏观经济','','','15959232388','1478431380','175.42.86.20','1','1','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','117.136.79.14','1481077703','1','1','email,mobile,weixin');
INSERT INTO `on_member` VALUES ('394','','','','huapopo','huapopo','哈哈','哈哈','dace20fd1d61e060b931c98bb3e4f7fa','哈哈','13641111111','1478499514','218.99.11.67','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','218.99.11.67','1478499514','1','0','');
INSERT INTO `on_member` VALUES ('395','','','','wx0395','Genpnail','','','','','','1478500690','223.96.65.242','0','0','','','','headimgurl','','1','','','16','172','0','','','','','','0.00','0.00','0.00','0.00','0','0','223.96.65.242','1478500690','1','1','weixin');
INSERT INTO `on_member` VALUES ('396','','','','wx0396','侯强','','','','','','1478501816','101.226.125.19','0','0','','','','headimgurl','','1','','','20','232','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.125.19','1478501816','1','1','weixin');
INSERT INTO `on_member` VALUES ('397','','','','yangxiawu','木易','','','6fd0446389bab4cc8bf553a448532164','木易','15959232389','1478519738','175.42.86.20','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','175.42.86.20','1478519738','1','0','');
INSERT INTO `on_member` VALUES ('398','','','','a_123','a_123','','','96fc600ba51ffdcde25196b30a149981','爱迪生','18310000000','1478571706','182.48.117.2','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','182.18.123.94','1479135145','1','0','');
INSERT INTO `on_member` VALUES ('399','','','','demo123','demo','商家','商家123','48ce95fd3a364231c259f8e7c479e7e2','测试','13811112222','1478584529','58.215.3.190','0','0','','','','User/58216967d8b5b.jpg','','','','','0','0','0','','','','','','1000.00','0.00','0.00','0.00','0','0','58.215.3.190','1478584529','1','0','');
INSERT INTO `on_member` VALUES ('400','','','','alex8686','alex','','','909087fa806cbfbd55cea66782a81036','阿吉','13255203050','1478594825','122.194.12.14','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','122.194.12.14','1478594825','1','0','');
INSERT INTO `on_member` VALUES ('401','','','','wx0401','.','','','','','','1478595438','175.25.174.112','0','0','','','','headimgurl','','1','','','33','385','0','','','','','','0.00','0.00','0.00','0.00','0','0','175.25.174.112','1478601027','1','1','weixin');
INSERT INTO `on_member` VALUES ('402','','','','wx0402','陈海宴','','','','','','1478606156','123.151.153.35','0','0','','','','headimgurl','','1','','','4','39','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.153.35','1478606156','1','1','');
INSERT INTO `on_member` VALUES ('403','','','','wx0403','平社晓（平汝原窑汝瓷1830395888','','','','','','1478618953','117.136.44.182','0','0','','','','headimgurl','','1','','','17','190','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.55.62.66','1480378478','1','1','weixin');
INSERT INTO `on_member` VALUES ('404','','','723694408@qq.com','on_18610692895','lalaz','','','9fb488fa7f810ac5c6f49dfd41fea975','冯志如','18610692895','1478654557','120.52.92.214','0','1','','','','','','','','','0','0','0','','','','','','1.00','0.00','0.00','0.00','0','0','120.52.92.214','1478654557','1','0','mobile');
INSERT INTO `on_member` VALUES ('405','','','','wx0405','符传龙 [玖魅网络]','','','','','','1478685341','183.61.37.28','0','0','','','','headimgurl','','1','','','269','2579','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.61.37.28','1478685341','1','1','weixin');
INSERT INTO `on_member` VALUES ('406','','','','wx0406','啦啦啦啦啦啦','','','','','','1478688815','182.150.63.55','0','0','','','','headimgurl','','2','','','24','273','0','','','','','','0.00','0.00','0.00','0.00','0','0','222.211.172.229','1478746903','1','1','weixin');
INSERT INTO `on_member` VALUES ('407','','','','wx0407','贺照云','','','','','','1478688820','222.211.172.229','0','0','','','','headimgurl','','1','','','24','273','0','','','','','','0.00','0.00','0.00','0.00','0','0','222.211.172.229','1478688820','1','1','');
INSERT INTO `on_member` VALUES ('408','','','','wx0408','联合的崛起','','','','','','1478702978','140.255.145.39','0','0','','','','headimgurl','','1','','','16','170','0','','','','','','0.00','0.00','0.00','0.00','0','0','140.255.145.39','1478702978','1','1','');
INSERT INTO `on_member` VALUES ('409','','','','wx0409','李孟炫 一天 1day.cc','','','','','','1478784197','123.151.40.34','0','0','','','','headimgurl','','1','','','4','37','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.40.34','1478784197','1','1','weixin');
INSERT INTO `on_member` VALUES ('410','','','','wx0410','让让爸爸','','','','','','1478841368','117.87.42.242','0','0','','','','headimgurl','','1','','','11','111','0','','','','','','0.00','0.00','0.00','0.00','0','0','117.87.42.242','1478841368','1','1','weixin');
INSERT INTO `on_member` VALUES ('411','','','','wx0411','天眷堂 艾亮','','','','','','1478846186','110.177.62.239','0','0','','','','headimgurl','','1','','','5','48','0','','','','','','0.00','0.00','0.00','0.00','0','0','110.177.62.239','1478852127','1','1','weixin');
INSERT INTO `on_member` VALUES ('412','','','','wx0412','任一民','','','','','','1478855345','110.177.62.239','0','0','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','110.177.62.239','1478855345','1','1','weixin');
INSERT INTO `on_member` VALUES ('413','','','','wx0413','海之风','','','','','','1478867918','101.226.93.201','0','0','','','','headimgurl','','1','','','11','109','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.93.201','1478867967','1','1','weixin');
INSERT INTO `on_member` VALUES ('414','','','','wx0414','叫我張無記','','','','','','1478941032','182.131.10.215','0','0','','','','headimgurl','','1','','','24','273','0','','','','','','0.00','0.00','0.00','0.00','0','0','182.131.10.215','1478941032','1','1','');
INSERT INTO `on_member` VALUES ('415','','','','wx0415','Challenger','','','','','','1478954323','219.133.40.15','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','180.136.164.90','1478954387','1','1','');
INSERT INTO `on_member` VALUES ('416','','','','wx0416','龙','','','','','','1478955802','101.226.102.52','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.102.52','1478955802','1','1','weixin');
INSERT INTO `on_member` VALUES ('417','','','','wx0417','丶','','','','','','1478958957','223.74.126.84','0','0','','','','headimgurl','','1','','','20','236','0','','','','','','0.00','0.00','0.00','0.00','0','0','223.74.126.84','1478958957','1','1','weixin');
INSERT INTO `on_member` VALUES ('418','','','','wx0418','山','','','','','','1478959834','123.151.38.94','0','0','','','','headimgurl','','1','','','17','190','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.38.94','1478959834','1','1','weixin');
INSERT INTO `on_member` VALUES ('419','','','','wx0419','裕霖-珍王璟和田玉','','','','','','1478960204','123.119.137.215','0','0','','','','headimgurl','','1','','','7','83','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.119.137.215','1478960204','1','1','weixin');
INSERT INTO `on_member` VALUES ('420','','','','wx0420','宇宙海船夫','','','','','','1479013097','218.66.160.58','0','0','','','','headimgurl','','1','','','15','169','0','','','','','','0.00','0.00','0.00','0.00','0','0','218.66.160.58','1479013097','1','1','weixin');
INSERT INTO `on_member` VALUES ('421','','','','RockyHuang','Rocky','','','96fc600ba51ffdcde25196b30a149981','洛奇','18625185192','1479039587','180.110.13.184','0','1','','','','','','0','','0','0','0','0','','','','','','10000.00','0.10','10000.00','0.00','0','0','218.26.96.249','1481155487','1','0','mobile');
INSERT INTO `on_member` VALUES ('422','','','','wx0422','Artuion','','','','','','1479042759','1.199.72.150','0','0','','','','headimgurl','','1','','','17','187','0','','','','','','0.00','0.00','0.00','0.00','0','0','120.195.65.231','1479084377','1','1','weixin');
INSERT INTO `on_member` VALUES ('423','','','','wx0423','樵夫','','','','','','1479045447','123.151.138.58','0','0','','','','headimgurl','','1','','','7','71','0','','','','','','0.00','0.00','0.00','0.00','0','0','119.108.110.58','1479081584','1','1','weixin');
INSERT INTO `on_member` VALUES ('424','','','','wx0424','丨依一丨Ｉ Lᵒᵛᵉᵧₒᵤ♥','','','','','','1479048110','222.88.236.225','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','222.88.236.225','1479048110','1','1','weixin');
INSERT INTO `on_member` VALUES ('425','','','','wx0425','黄友Rocky','','','','','','1479090143','101.226.114.166','0','0','','','','headimgurl','','1','','','11','109','0','','','','','','0.00','0.00','0.00','0.00','0','0','112.26.237.29','1479135239','1','1','weixin');
INSERT INTO `on_member` VALUES ('426','','','','m1234567','123456','','','96fc600ba51ffdcde25196b30a149981','马传国','13176442574','1479212938','123.171.254.119','0','0','','','','','','','','','0','0','0','','','','','','100.00','0.00','0.00','0.00','0','0','123.171.253.131','1479397752','1','0','');
INSERT INTO `on_member` VALUES ('427','','','','mcg7612','五五折网','齐鲁风','服装拍卖','96fc600ba51ffdcde25196b30a149981','马传国','13176442574','1479276268','123.171.254.119','0','1','','','','','','','','','0','0','0','','','','','','150.00','50.00','0.00','0.00','0','0','123.171.254.119','1479309002','1','0','mobile');
INSERT INTO `on_member` VALUES ('428','','','','wx0428','天猫特价2号客服','','','','','','1479279945','123.171.254.119','0','0','','','','headimgurl','','1','','','16','170','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.93.201','1479280047','1','1','weixin');
INSERT INTO `on_member` VALUES ('429','','','','wx0429','家教你我他-王刚','','','','','','1479296664','123.151.40.40','0','0','','','','headimgurl','','1','','','9','99','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.40.40','1479296664','1','1','weixin');
INSERT INTO `on_member` VALUES ('430','','','2447062007@qq.com','on_15311431953','china','','','e20dfc111a3bde1a805ddb4880d80b24','中国梦','15311431953','1479301958','182.18.126.108','0','1','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','182.18.126.108','1479301958','1','0','mobile');
INSERT INTO `on_member` VALUES ('431','','','','javalyao','jay','','wqww','0a166a8ff2094a30ac7a9337bdd1ec79','jay','','','','0','0','','','','','','0','','0','0','0','0','ewe','','','','','0.00','0.00','0.00','0.00','0','0','','','1','0','');
INSERT INTO `on_member` VALUES ('432','','','','wx0432','活佛','活佛','主营金刚，星月，小叶紫檀，橄榄核雕','','','','1479358901','101.226.93.241','0','0','','','','headimgurl','','2','','','33','390','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.93.241','1479358901','1','1','weixin');
INSERT INTO `on_member` VALUES ('433','','','','wx0433','猜猜我是谁','陈香归','学生党','','','','1479364807','219.133.40.15','0','0','','','','headimgurl','','2','','','19','218','0','','','','','','0.00','0.00','0.00','0.00','0','0','219.133.40.14','1479366189','1','1','weixin');
INSERT INTO `on_member` VALUES ('434','','','','wx0434','渡缘','','','','','','1479365912','101.226.61.181','0','0','','','','headimgurl','','1','','','107','1172','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.61.181','1479365912','1','1','weixin');
INSERT INTO `on_member` VALUES ('435','','','1005047219@qq.com','wx0435','小鬼不坏','嘿嘿混D','躲躲藏藏刚刚','','陈钢','','1479372353','122.236.133.159','0','0','','','','headimgurl','','1','东浦镇鉴湖村畈里姚92号','312000','12','127','1351','','','','','','500.00','300.00','0.00','0.00','0','0','122.236.115.235','1479430378','1','1','weixin');
INSERT INTO `on_member` VALUES ('437','','','','wx0437','村委主席','','','','','','1479436479','14.17.37.102','0','0','','','','headimgurl','','1','','','20','248','0','','','','','','0.00','0.00','0.00','0.00','0','0','14.17.37.102','1479436479','1','1','weixin');
INSERT INTO `on_member` VALUES ('438','','','','wx0438','拂尘阁','','','','','','1479454909','180.153.81.159','0','0','','','','headimgurl','','1','','','11','118','0','','','','','','0.00','0.00','0.00','0.00','0','0','117.91.18.175','1479518119','1','1','weixin');
INSERT INTO `on_member` VALUES ('439','','','','A000000','000000','0000000000000000','0000000000000000000000000','806f130e3265a8f32070d62102d7d028','是否','15612351650','1479455774','117.91.18.175','0','0','','','','','','','','','0','0','0','','','','','','5000.00','0.00','0.00','0.00','0','0','117.91.18.175','1479535843','1','0','');
INSERT INTO `on_member` VALUES ('440','','','xuhaooo@163.com','xuhao','徐浩','徐浩','徐浩','bd28d3e69fa5d78e0b0630659a84993e','徐浩','13995931111','1479478049','119.102.97.196','0','0','','','','','','1','湖北省浠水县','438200','18','213','2145','徐浩','','','','','0.00','0.00','0.00','0.00','0','0','111.183.90.121','1479607202','1','0','');
INSERT INTO `on_member` VALUES ('441','','','','wx0441','A00秦明辉 13891951640','','','96fc600ba51ffdcde25196b30a149981','','','1479526744','113.139.90.222','0','0','','','','headimgurl','','2','','0','28','326','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.139.107.175','1480665120','1','1','weixin');
INSERT INTO `on_member` VALUES ('442','','','','fstzw','fstzw','','','6a9f0925d517908ef9bd82e25d8e8782','佛山天之','13620113344','1479541716','113.70.17.64','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.70.17.64','1479541716','1','0','');
INSERT INTO `on_member` VALUES ('443','','','','wx0443','YYD516688','','','','','','1479553746','182.140.184.85','0','0','','','','headimgurl','','1','','','24','273','0','','','','','','0.00','0.00','0.00','0.00','0','0','125.69.123.14','1479553808','1','1','weixin');
INSERT INTO `on_member` VALUES ('444','','','2287199445@qq.com','office_fzx','冯稀饭','','','66e5e61b4dfab581b9ca3688221fdb5a','冯先生','18861485281','1479555743','222.185.2.78','1','1','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','222.185.2.78','1479555743','1','0','email,mobile');
INSERT INTO `on_member` VALUES ('445','','','','wx0445','猫123','古币收藏家','收藏以及拍卖','','','','1479635696','119.103.135.92','1','1','','','','headimgurl','','1','','0','0','0','0','','','','','','1000.00','0.00','0.00','0.00','600','0','27.16.94.220','1479657056','1','1','weixin');
INSERT INTO `on_member` VALUES ('446','','','','wx0446','...','','','','','','1479665102','101.226.61.189','0','0','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.61.189','1479836474','1','1','weixin');
INSERT INTO `on_member` VALUES ('447','','','','wx0447','ZY','','','','','','1479691937','101.226.61.142','0','0','','','','headimgurl','','2','','','16','170','0','','','','','','0.00','0.00','0.00','0.00','0','0','119.162.61.207','1479691956','1','1','weixin');
INSERT INTO `on_member` VALUES ('448','','','','damiliu','米器','','','806f130e3265a8f32070d62102d7d028','刘闵','13812345678','1479693177','219.157.76.9','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','219.157.76.9','1479693177','1','0','');
INSERT INTO `on_member` VALUES ('449','','','','wx0449','假友与假酒','4646','赶紧活动商城天福','','','','1479693244','111.161.57.31','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','111.161.57.31','1479776696','1','1','weixin');
INSERT INTO `on_member` VALUES ('450','','','','wx0450','樊晓杰','','','','','','1479696872','123.151.64.142','0','0','','','','headimgurl','','1','','','5','56','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.64.142','1479696872','1','1','weixin');
INSERT INTO `on_member` VALUES ('451','','','','wx0451','周晓乐','','','','','','1479717541','222.134.201.108','0','0','','','','headimgurl','','1','','','17','187','0','','','','','','0.00','0.00','0.00','0.00','0','0','222.134.201.108','1479717541','1','1','weixin');
INSERT INTO `on_member` VALUES ('452','','','','wx0452','Louis','','','','','','1479719529','183.49.119.98','0','0','','','','headimgurl','','1','','','20','234','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.49.119.98','1479719529','1','1','weixin');
INSERT INTO `on_member` VALUES ('453','','','','wx0453','罗某Cr','','','','','','1479720076','183.61.52.70','0','0','','','','headimgurl','','1','','','270','2606','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.61.52.70','1479720076','1','1','');
INSERT INTO `on_member` VALUES ('454','','','','wx0454','慧慧','','','','','','1479725071','110.51.154.111','0','0','','','','headimgurl','','2','','','5','49','0','','','','','','0.00','0.00','0.00','0.00','0','0','110.51.154.111','1479725071','1','1','weixin');
INSERT INTO `on_member` VALUES ('455','','','','wx0455','Colin','','','','','','1479726043','101.226.61.184','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.61.184','1479726043','1','1','weixin');
INSERT INTO `on_member` VALUES ('456','','','','wx0456','','','','','','','1479726068','27.10.74.130','0','0','','','','headimgurl','','2','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','27.10.74.130','1479726068','1','1','weixin');
INSERT INTO `on_member` VALUES ('457','','','','wx0457','雪山飞狐','','','','','','1479726993','113.250.255.160','0','0','','','','headimgurl','','1','','','123','1315','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.250.255.160','1479726993','1','1','weixin');
INSERT INTO `on_member` VALUES ('458','','','','wx0458','别拿管理员不当干部','','','','','','1479728308','101.226.125.18','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.125.18','1479728308','1','1','weixin');
INSERT INTO `on_member` VALUES ('459','','','','wx0459','金宝','','','','','','1479767478','101.226.61.190','0','0','','','','headimgurl','','1','','','16','183','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.61.190','1479767478','1','1','weixin');
INSERT INTO `on_member` VALUES ('460','','','','m15318758262','重楼','重楼拍卖会','重楼拍卖会重楼拍卖会重楼拍卖会','96fc600ba51ffdcde25196b30a149981','重楼','15318758262','1479776216','27.210.214.170','0','1','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','27.210.214.170','1479776216','1','0','mobile');
INSERT INTO `on_member` VALUES ('461','','','','wx0461','~오휘~','','','','','','1479785627','114.82.230.149','0','0','','','','headimgurl','','1','','','107','1177','0','','','','','','0.00','0.00','0.00','0.00','0','0','114.82.230.149','1479785627','1','1','weixin');
INSERT INTO `on_member` VALUES ('462','','','','wx0462','落叶枫华','','','','','','1479799824','123.158.49.79','0','0','','','','headimgurl','','1','','','20','249','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.158.49.79','1479799824','1','1','');
INSERT INTO `on_member` VALUES ('464','','','','dongdong','dongdong','','','96fc600ba51ffdcde25196b30a149981','董君','13332435697','1479817870','123.245.95.104','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.245.95.104','1479817870','1','0','');
INSERT INTO `on_member` VALUES ('465','','','','abcd12345','我是','','','3b3c4077dffbcdc5c1e343e7fb619413','我是','13812345432','1479823481','112.51.52.227','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','47.89.46.124','1479824956','1','0','');
INSERT INTO `on_member` VALUES ('466','','','','wx0466','feilong180','','','','','','1479865942','14.17.44.216','0','0','','','','headimgurl','','1','','','20','234','0','','','','','','0.00','0.00','0.00','0.00','0','0','14.17.44.216','1479865942','1','1','weixin');
INSERT INTO `on_member` VALUES ('467','','','','wx0467','中国饲料商城网～angela','','','','','','1479951005','111.161.52.28','0','0','','','','headimgurl','','2','','','4','37','0','','','','','','0.00','0.00','0.00','0.00','0','0','111.161.52.28','1479951005','1','1','');
INSERT INTO `on_member` VALUES ('468','','','','wx0468','Alex刘俊周','','','','','','1479961496','61.50.127.126','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','61.50.127.126','1479961496','1','1','weixin');
INSERT INTO `on_member` VALUES ('469','','','1021641518@qq.com','on_1021641518','ZXW','','','96fc600ba51ffdcde25196b30a149981','赵显玮','15105177028','1480039408','49.74.192.160','1','1','','','','','','1','南京南京南京','210018','11','109','1180','我是哈哈哈哈','','','','','10090.00','0.10','0.00','0.00','0','0','49.65.153.104','1480290425','1','0','email,mobile');
INSERT INTO `on_member` VALUES ('470','','','','wx0470','李嘉泰','','','','','','1480056774','116.231.154.49','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','116.231.154.49','1480056774','1','1','weixin');
INSERT INTO `on_member` VALUES ('471','','','','wx0471','佳且好','','','','','','1480160592','27.189.204.172','0','0','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','27.189.204.172','1480160592','1','1','weixin');
INSERT INTO `on_member` VALUES ('472','','','','wx0472','雨帆','','','','','','1480296109','223.104.6.93','0','0','','','','headimgurl','','1','','','14','152','0','','','','','','0.00','0.00','0.00','0.00','0','0','223.104.6.93','1480298847','1','1','weixin');
INSERT INTO `on_member` VALUES ('473','','','','wx0473','半城','','','','','','1480298291','171.111.40.13','0','0','','','','headimgurl','','1','','','21','255','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.61.51.195','1480300643','1','1','weixin');
INSERT INTO `on_member` VALUES ('474','','','','wx0474','zp','','','','','','1480301919','120.52.92.158','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','120.52.92.158','1480301927','1','1','');
INSERT INTO `on_member` VALUES ('475','','','','wx0475','A-万朋小K','','','','','','1480310825','114.95.153.16','0','0','','','','headimgurl','','1','','','14','155','0','','','','','','0.00','0.00','0.00','0.00','0','0','114.95.153.16','1480310825','1','1','');
INSERT INTO `on_member` VALUES ('476','','','','wx0476','阿涛','','','','','','1480333930','111.73.136.51','0','0','','','','headimgurl','','1','','','15','160','0','','','','','','0.00','0.00','0.00','0.00','0','0','117.136.60.30','1480349455','1','1','weixin');
INSERT INTO `on_member` VALUES ('477','','','','wx0477','SunCher','','','','','','1480384368','101.226.102.79','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.102.79','1480384368','1','1','');
INSERT INTO `on_member` VALUES ('478','','','939936921@qq.com','wx0478','chen','种鸽集中营','13696942270','','庄晨煌','13696942270','1480389415','27.154.128.9','0','0','','','','headimgurl','','1','灌口镇李林村','361023','14','151','1539','','','','','','0.00','0.00','0.00','0.00','0','0','27.154.128.9','1480389415','1','1','weixin');
INSERT INTO `on_member` VALUES ('479','','','','wx0479','無品芝麻官','','','','','','1480400276','123.151.42.50','0','0','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.186.73.218','1480400282','1','1','weixin');
INSERT INTO `on_member` VALUES ('480','','','','wx0480','郭亮','','','','','','1480434673','101.226.125.108','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.125.108','1480434673','1','1','weixin');
INSERT INTO `on_member` VALUES ('481','','','','wx0481','洋葱','','','','','','1480486237','123.151.42.52','0','0','','','','headimgurl','','1','','','31','358','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.42.52','1480486237','1','1','weixin');
INSERT INTO `on_member` VALUES ('482','','','','wx0482','小爵爷','小绿叶','户口','','','18781044383','1480490765','182.140.175.142','0','1','','','','headimgurl','','1','','','24','281','0','','','','','','0.00','0.00','0.00','0.00','0','0','182.140.175.142','1480560613','1','1','mobile,weixin');
INSERT INTO `on_member` VALUES ('483','','','','wx0483','深蓝','','','','','','1480509082','14.17.37.145','0','0','','','','headimgurl','','1','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','14.17.3.122','1480851040','1','1','weixin');
INSERT INTO `on_member` VALUES ('484','','','','TEST001','TEST001','TEST001','TEST001','1957162b87f5013be5f050097b39627a','测试','13057120643','1480509610','58.241.52.142','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','58.241.52.142','1480517219','1','0','');
INSERT INTO `on_member` VALUES ('485','','','','wx0485','阿丁','','','','','','1480509951','101.226.102.59','0','0','','','','headimgurl','','1','','','11','112','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.102.59','1480509951','1','1','weixin');
INSERT INTO `on_member` VALUES ('486','','','','wx0486','新思维','','','','','','1480562490','123.151.138.56','0','0','','','','headimgurl','','1','','','7','71','0','','','','','','0.01','0.00','0.00','0.00','0','0','123.151.138.56','1481024312','1','1','weixin');
INSERT INTO `on_member` VALUES ('487','','','','wx0487','刘华超','','','','','','1480586835','113.108.11.50','0','0','','','','headimgurl','','1','','','20','234','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.108.11.50','1480950300','1','1','weixin');
INSERT INTO `on_member` VALUES ('488','','','','wx0488','W j   ','','','','','','1480591065','113.108.0.15','0','0','','','','headimgurl','','1','','','20','246','0','','','','','','0.00','0.00','0.00','0.00','0','0','113.108.0.15','1480591065','1','1','weixin');
INSERT INTO `on_member` VALUES ('489','','','','wx0489','董龙文','','','','','','1480597252','101.226.61.186','0','0','','','','headimgurl','','1','','','11','112','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.226.61.186','1480597252','1','1','');
INSERT INTO `on_member` VALUES ('490','','','','wx0490','聚泉一品斋','','','','','','1480605557','101.226.125.15','0','0','','','','headimgurl','','1','','','18','214','0','','','','','','0.00','0.00','0.00','0.00','0','0','140.207.185.124','1480605932','1','1','weixin');
INSERT INTO `on_member` VALUES ('491','','','','wx0491','义宁先生~','','','','','','1480646327','172.56.34.232','0','0','','','','headimgurl','','1','','','','','0','','','','','','0.00','0.00','0.00','0.00','0','0','172.56.34.232','1480646327','1','1','weixin');
INSERT INTO `on_member` VALUES ('492','','','','wx0492','HankHao','','','','','','1480654982','223.72.102.149','0','0','','','','headimgurl','','1','','','33','379','0','','','','','','0.00','0.00','0.00','0.00','0','0','223.72.102.149','1480654982','1','1','');
INSERT INTO `on_member` VALUES ('493','','','','dongjunliang','dongdong','','','96fc600ba51ffdcde25196b30a149981','董俊良','13332435697','1480658538','61.161.158.10','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','61.161.158.10','1480658538','1','0','');
INSERT INTO `on_member` VALUES ('494','','','','wx0494','奔驰 的馬','','','','','','1480661276','123.151.42.49','0','0','','','','headimgurl','','1','','','17','198','0','','','','','','0.00','0.00','0.00','0.00','0','0','123.151.42.49','1480661276','1','1','');
INSERT INTO `on_member` VALUES ('495','','','','cys31289494','爱琴海','','','fef8a4166793400171aee5bcdbfe483b','爱琴海','18904002355','1480663938','119.108.101.158','0','0','','','','','','','','','0','0','0','','','','','','200.00','0.00','0.00','0.00','0','0','119.108.101.158','1480663938','1','0','');
INSERT INTO `on_member` VALUES ('496','','','','wx0496','杏坛美术馆 薛豪','','','','','','1480774729','114.252.185.181','0','0','','','','headimgurl','','1','','','7','83','0','','','','','','0.00','0.00','0.00','0.00','0','0','114.252.185.181','1480813050','1','1','weixin');
INSERT INTO `on_member` VALUES ('497','','','','wx0497','','','','96fc600ba51ffdcde25196b30a149981','笑脸','','1480843618','183.204.103.208','0','0','','','','headimgurl','','','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480843618','1','1','');
INSERT INTO `on_member` VALUES ('498','','','','wx0498','','','','96fc600ba51ffdcde25196b30a149981','笑脸','','1480843624','183.204.103.208','0','0','','','','headimgurl','','','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480843624','1','1','');
INSERT INTO `on_member` VALUES ('499','','','','wx0499','','','','96fc600ba51ffdcde25196b30a149981','笑脸','','1480843624','183.204.103.208','0','0','','','','headimgurl','','','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480843624','1','1','');
INSERT INTO `on_member` VALUES ('500','','','','wx0500','ONcoo Service','','','96fc600ba51ffdcde25196b30a149981','侯占蛟','','1480843853','183.204.103.208','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480843853','1','1','');
INSERT INTO `on_member` VALUES ('501','','','','asdfasdf','ONcoo Service','','','96fc600ba51ffdcde25196b30a149981','阿斯蒂芬','','1480846825','183.204.103.208','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480846825','1','1','');
INSERT INTO `on_member` VALUES ('502','','','','aklsdjf','ONcoo Service','','','96fc600ba51ffdcde25196b30a149981','爱迪生','','1480847777','183.204.103.208','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480847777','1','1','');
INSERT INTO `on_member` VALUES ('503','','','','asdfasd','ONcoo Service','','','96fc600ba51ffdcde25196b30a149981','阿斯蒂芬','','1480848099','183.204.103.208','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480848099','1','1','');
INSERT INTO `on_member` VALUES ('504','','','','houzhanjiaa','ONcoo Service','','','96fc600ba51ffdcde25196b30a149981','撒地方','','1480848735','183.204.103.208','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480848735','1','1','');
INSERT INTO `on_member` VALUES ('505','','','','sdfds','ONcoo Service','','','96fc600ba51ffdcde25196b30a149981','阿斯蒂芬','','1480849323','183.204.103.208','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480849323','1','1','');
INSERT INTO `on_member` VALUES ('506','','','','sdfsd','ONcoo Service','','','96fc600ba51ffdcde25196b30a149981','撒地方','','1480849495','183.204.103.208','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','0.00','0.00','0.00','0.00','0','0','183.204.103.208','1480849495','1','1','');
INSERT INTO `on_member` VALUES ('507','','','','dfsdf','ONcoo Service','','','96fc600ba51ffdcde25196b30a149981','第三方','','1480849888','183.204.103.208','0','0','','','','headimgurl','','1','','','17','193','0','','','','','','1000.00','0.10','0.00','0.00','0','0','192.168.1.238','1481165560','1','1','weixin');
INSERT INTO `on_member` VALUES ('508','','','','yuanwenmeng840511','袁','','','84ec219b14e215a86af5929f38a62198','袁文猛','','1480854587','42.6.152.121','0','0','','','','headimgurl','','1','','','7','76','0','','','','','','0.00','0.00','0.00','0.00','0','0','42.6.152.121','1480854587','1','1','weixin');
INSERT INTO `on_member` VALUES ('509','','','','maybeleo','sososo','test','测试专用','3f28b784db43aaccf0133410daa8c610','王平','13521835564','1480906743','116.226.156.21','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','116.226.156.21','1480928537','1','0','');
INSERT INTO `on_member` VALUES ('510','','','','sunshine','大海','大海','磊大','f0bf6e5df2f60c99abf79d29d8ec8c67','李大海','','','','0','0','','','','','','0','','0','0','0','0','','','','','','0.00','0.00','0.00','0.00','80','80','1.180.212.69','1480910574','1','0','');
INSERT INTO `on_member` VALUES ('511','','','','a5295595','123','2321','12321213213','ef62f0ac0f8c2a0a7a30d2f9f23f7a75','众创空间','13888888888','1480991080','122.194.12.15','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','122.194.12.15','1481161773','1','0','');
INSERT INTO `on_member` VALUES ('512','','','','gy1989411','','','','be1fb66ce2782c2aaed44eabaf5cc446','','','','','0','0','','','','','','0','','0','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','101.81.114.132','1481019953','1','0','');
INSERT INTO `on_member` VALUES ('513','','','King@126.com','on_13624112599','admin','','','96fc600ba51ffdcde25196b30a149981','你好','13624112599','1481049692','223.102.15.201','0','1','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','223.102.15.201','1481049692','1','0','mobile');
INSERT INTO `on_member` VALUES ('514','','','','aaaaa','aaaaa','','','1fa1e0776c66199678ca0bd84ae2cd4d','外网','13845678907','1481070068','122.194.3.225','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','122.194.3.225','1481071327','1','1','');
INSERT INTO `on_member` VALUES ('515','','','','Vincent','Vincent','','','4d0657857db98b0b0fa66f43e124cf1b','孙利勇','18315227045','1481077404','125.84.185.28','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','125.84.185.28','1481077404','1','0','');
INSERT INTO `on_member` VALUES ('516','','','','on_18511691851','宝裕国际拍卖有限公司（温立艳）','','','96fc600ba51ffdcde25196b30a149981','温立艳','18511691851','1481098222','61.148.242.131','0','1','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','61.148.242.131','1481098222','1','1','weixin');
INSERT INTO `on_member` VALUES ('517','','','','on_18511691851','宝裕国际拍卖有限公司（温立艳）','','','96fc600ba51ffdcde25196b30a149981','温立艳','18511691851','1481098263','61.148.242.131','0','1','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','61.148.242.131','1481098263','1','1','weixin');
INSERT INTO `on_member` VALUES ('518','','','','on_18511691851','宝裕国际拍卖有限公司（温立艳）','','','96fc600ba51ffdcde25196b30a149981','温立艳','18511691851','1481098263','61.148.242.131','0','1','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','61.148.242.131','1481098263','1','1','weixin');
INSERT INTO `on_member` VALUES ('519','','','','on_18511691851','宝裕国际拍卖有限公司（温立艳）','','','96fc600ba51ffdcde25196b30a149981','温立艳','18511691851','1481098263','61.148.242.131','0','1','','','','headimgurl','','0','','','0','1','0','','','','','','0.00','0.00','0.00','0.00','0','0','61.148.242.131','1481098263','1','1','weixin');
INSERT INTO `on_member` VALUES ('520','','','','ken_theone','ken','','','e57f6ad92f670926467b022488365796','王子','15058588654','1481101777','115.217.251.65','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','115.217.251.65','1481101777','1','0','');
INSERT INTO `on_member` VALUES ('521','','','','ren4722','ddddd','','','f2baa45620641e32e51d498e41339cbe','国王','18271941009','1481161728','59.174.5.94','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','59.174.5.94','1481161728','1','0','');
INSERT INTO `on_member` VALUES ('522','','','','test007','撒地方','测试卖家保证金冻结','卡拉胶sd卡法兰姬阿斯顿','96fc600ba51ffdcde25196b30a149981','阿迪发送','13856236598','1482291910','192.168.1.238','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','1000.00','0.00','0','0','192.168.1.238','1482312041','1','0','');
INSERT INTO `on_member` VALUES ('523','','','','t001','t001','','','96fc600ba51ffdcde25196b30a149981','t001','','','','0','1','','','','','','0','','0','0','0','0','','','','','','0.00','0.00','1000.00','100.00','0','0','192.168.1.238','1484041071','1','0','');
INSERT INTO `on_member` VALUES ('524','','','','t002','t002','','','96fc600ba51ffdcde25196b30a149981','t002','','','','0','1','','','','','','0','','0','0','0','0','','','','','','167.00','0.00','0.00','0.00','0','0','192.168.1.238','1482760637','1','0','');
INSERT INTO `on_member` VALUES ('525','','','','jzbis','jzbis','','','14e1b600b1fd579f47433b88e8d85291','小白','13067216009','1485138951','127.0.0.1','0','0','','','','','','','','','0','0','0','','','','','','0.00','0.00','0.00','0.00','0','0','127.0.0.1','1485138951','1','0','');


# 数据库表：on_member_evaluate 数据信息


# 数据库表：on_member_limsum_bill 数据信息
INSERT INTO `on_member_limsum_bill` VALUES ('aad148229209879470','522','admin_deposit','1482292098','','1000.00','0.00');
INSERT INTO `on_member_limsum_bill` VALUES ('add148231244317639','522','add_freeze','1482312443','发布拍卖：“<a href="/Auction/details/pid/16/aptitude/1.html">阿里斯顿疯狂辣椒水电费</a>”冻结信誉额度【300.00元】！','0.00','300.00');
INSERT INTO `on_member_limsum_bill` VALUES ('aad148275878169213','523','admin_deposit','1482758781','','1000.00','0.00');
INSERT INTO `on_member_limsum_bill` VALUES ('plg148276059635698','523','bid_freeze','1482760596','参拍“<a href="/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结专场信誉额度！','0.00','100.00');
INSERT INTO `on_member_limsum_bill` VALUES ('guf148276081587915','523','bid_unfreeze','1482760815','专场【<a  target="_blank" href="/Home/Special/speul/sid/1.html">专场拍卖测试001</a>】结束,拍品【<a  target="_blank" href="/Home/Auction/details/pid/19.html"></a>】结束','100.00','0.00');
INSERT INTO `on_member_limsum_bill` VALUES ('auf148314760335867','522','add_unfreeze','1483147603','拍品流拍<a href="/Home/Auction/details/pid/16/aptitude/1.html">【阿里斯顿疯狂辣椒水电费】</a>','300.00','0.00');
INSERT INTO `on_member_limsum_bill` VALUES ('plg148404109142122','523','bid_freeze','1484041091','参拍“<a href="/Auction/details/pid/23/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结专场信誉额度！','0.00','100.00');


# 数据库表：on_member_pledge_bill 数据信息
INSERT INTO `on_member_pledge_bill` VALUES ('add148116586426345','1','add_freeze','1481165864','','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148116592284928','1','add_freeze','1481165922','发布拍卖：“<a href="/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148116604633067','180','bid_freeze','1481166046','参拍“<a href="/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148116612771866','1','add_freeze','1481166127','发布拍卖：“<a href="/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148116614162999','180','bid_freeze','1481166141','参拍“<a href="/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148116682776882','1','add_freeze','1481166827','发布拍卖：“<a href="/Auction/details/pid/3/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148116654118114','180','pay_deduct','1481167806','支付商品：“<a href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”，支付成功！','0.00','550.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148116654118114','180','pay_pledge','1481167806','保证金抵商品：“<a href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148118196761391','1','add_unfreeze','1481181967','拍品流拍<a href="/Home/Auction/details/pid/3/aptitude/1.html">【卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148118547215158','1','add_unfreeze','1481185472','买家确认收到<a href="/Home/Auction/details/pid/1/aptitude/1.html">【卡拉斯经典款浪费骄傲sd卡浪费】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('pro148118547301283','1','profit','1481185473','买家确认收到拍品“<a href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”，拍品成交价：500.00元+运费：100.00元=订单总额：600元，扣除网站佣金：1','500.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148116654173375','180','pay_deduct','1481249811','支付商品：“<a href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”，支付成功！','0.00','250.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148116654173375','180','pay_pledge','1481249811','保证金抵商品：“<a href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148125031966231','1','add_freeze','1481250319','发布拍卖：“<a href="/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148125035920691','180','bid_freeze','1481250359','参拍“<a href="/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148125048193280','180','pay_deduct','1481250509','支付商品：“<a href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”，支付成功！','0.00','250.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148125048193280','180','pay_pledge','1481250509','保证金抵商品：“<a href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148125113069320','1','add_unfreeze','1481251130','买家确认收到<a href="/Home/Auction/details/pid/2/aptitude/1.html">【啥快递龙卷风卡拉斯蒂芬将快乐】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('pro148125113129244','1','profit','1481251131','买家确认收到拍品“<a href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”，拍品成交价：200.00元+运费：100.00元=订单总额：300元，扣除网站佣金：40','260.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148125211823367','1','add_unfreeze','1481252118','买家确认收到<a href="/Home/Auction/details/pid/4/aptitude/1.html">【了空间按快了速度激发垃圾似的】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('pro14812521187038','1','profit','1481252118','买家确认收到拍品“<a href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”，拍品成交价：200.00元+运费：100.00元=订单总额：300元，扣除网站佣金：40','260.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148125252892536','1','add_freeze','1481252528','发布拍卖：“<a href="/Auction/details/pid/5/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148125273277967','1','add_freeze','1481252732','发布拍卖：“<a href="/Auction/details/pid/6/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148125400251259','1','add_unfreeze','1481254002','撤拍<a href="/Home/Auction/details/pid/5/aptitude/1.html">【卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148159338213437','1','add_freeze','1481593382','发布拍卖：“<a href="/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148159343298693','180','bid_freeze','1481593432','参拍“<a href="/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add14815935248685','1','add_freeze','1481593524','发布拍卖：“<a href="/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148159354383340','180','bid_freeze','1481593543','参拍“<a href="/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148159358280346','1','add_freeze','1481593582','发布拍卖：“<a href="/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148159359442434','180','bid_freeze','1481593594','参拍“<a href="/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159906773028','180','buy_break_nopay','1481599067','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159906773876','1','seller_break_nopay','1481599067','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159912967799','180','buy_break_nopay','1481599129','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159912968639','1','seller_break_nopay','1481599129','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159913118935','180','buy_break_nopay','1481599131','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159913119868','1','seller_break_nopay','1481599131','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159922928617','180','buy_break_nopay','1481599229','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159922929491','1','seller_break_nopay','1481599229','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148159922930449','1','add_unfreeze','1481599229','买家未按时支付<a href="/Home/Auction/details/pid/7/aptitude/1.html">【卡拉斯交电费卢卡斯交电费卡拉斯的】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159923095766','180','buy_break_nopay','1481599230','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159923096566','1','seller_break_nopay','1481599230','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp14815992313632','180','buy_break_nopay','1481599231','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159923137343','1','seller_break_nopay','1481599231','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159923453567','180','buy_break_nopay','1481599234','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159923454465','1','seller_break_nopay','1481599234','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp14815992351582','180','buy_break_nopay','1481599235','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159923516794','1','seller_break_nopay','1481599235','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159924445386','180','buy_break_nopay','1481599244','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159924446339','1','seller_break_nopay','1481599244','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159924471379','180','buy_break_nopay','1481599244','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159924472016','1','seller_break_nopay','1481599244','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159924492010','180','buy_break_nopay','1481599244','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159924492991','1','seller_break_nopay','1481599244','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159924963158','180','buy_break_nopay','1481599249','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159924963918','1','seller_break_nopay','1481599249','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159925232158','180','buy_break_nopay','1481599252','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159925232944','1','seller_break_nopay','1481599252','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp14815992646349','180','buy_break_nopay','1481599264','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp14815992646429','1','seller_break_nopay','1481599264','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159926633648','180','buy_break_nopay','1481599266','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159926635299','1','seller_break_nopay','1481599266','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159928188920','180','buy_break_nopay','1481599281','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159928189859','1','seller_break_nopay','1481599281','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159928469592','180','buy_break_nopay','1481599284','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159928470389','1','seller_break_nopay','1481599284','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159949270979','180','buy_break_nopay','1481599492','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159949271792','1','seller_break_nopay','1481599492','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159949477748','180','buy_break_nopay','1481599494','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159949478660','1','seller_break_nopay','1481599494','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159949697840','180','buy_break_nopay','1481599496','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159949698633','1','seller_break_nopay','1481599496','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159952445982','180','buy_break_nopay','1481599524','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159952446783','1','seller_break_nopay','1481599524','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159952754422','180','buy_break_nopay','1481599527','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159952755263','1','seller_break_nopay','1481599527','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159952783071','180','buy_break_nopay','1481599527','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159952783987','1','seller_break_nopay','1481599527','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159954102762','180','buy_break_nopay','1481599541','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159954103628','1','seller_break_nopay','1481599541','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159954120987','180','buy_break_nopay','1481599541','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159954121773','1','seller_break_nopay','1481599541','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159954138892','180','buy_break_nopay','1481599541','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp14815995413963','1','seller_break_nopay','1481599541','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159954325732','180','buy_break_nopay','1481599543','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159954326779','1','seller_break_nopay','1481599543','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp14815995449649','180','buy_break_nopay','1481599544','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159954497210','1','seller_break_nopay','1481599544','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159954765317','180','buy_break_nopay','1481599547','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159954766178','1','seller_break_nopay','1481599547','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp14815995594277','180','buy_break_nopay','1481599559','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159955943616','1','seller_break_nopay','1481599559','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159980915313','180','buy_break_nopay','1481599809','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159980916194','1','seller_break_nopay','1481599809','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159981382455','180','buy_break_nopay','1481599813','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159981383271','1','seller_break_nopay','1481599813','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159981831989','180','buy_break_nopay','1481599818','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159981832769','1','seller_break_nopay','1481599818','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159984341029','180','buy_break_nopay','1481599843','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp14815998434185','1','seller_break_nopay','1481599843','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp14815999021668','180','buy_break_nopay','1481599902','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159990217468','1','seller_break_nopay','1481599902','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148159992746054','180','buy_break_nopay','1481599927','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('snp148159992746975','1','seller_break_nopay','1481599927','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','40.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148162133859926','180','buy_break_nopay','1481621338','您未在有效期支付，拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('anp148162133860861','1','seller_break_nopay','1481621338','买家未在有效期支付，拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','50.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148159923037371','180','pay_deduct','1481766901','支付商品：“<a href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”，支付成功！','0.00','-20.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148159923037371','180','pay_pledge','1481766901','保证金抵商品：“<a href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148159923037371','180','pay_pledge','1481794272','保证金抵商品：“<a href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”货款【30元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”','0.00','30.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148159923037371','180','paybid_unfreeze','1481794272','按时(在线)支付拍品订单<a href="/Home/Auction/details/pid/9/aptitude/1.html">【克拉的肌肤看见了快递劫匪】</a>','20.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148159922987522','180','pay_deduct','1481794581','支付商品：“<a href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148159922987522/aptitude/1.html">BID148159922987522</a>”，支付成功！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148159922987522','180','pay_pledge','1481794581','保证金抵商品：“<a href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148159922987522/aptitude/1.html">BID148159922987522</a>”','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148179474385421','1','add_freeze','1481794743','发布拍卖：“<a href="/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148179478785036','180','bid_freeze','1481794787','参拍“<a href="/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金！','0.00','600.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148179482180373','1','add_freeze','1481794821','发布拍卖：“<a href="/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148179483639749','180','bid_freeze','1481794836','参拍“<a href="/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148179494312231','1','add_freeze','1481794943','发布拍卖：“<a href="/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148179495475987','180','bid_freeze','1481794954','参拍“<a href="/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”冻结保证金！','0.00','600.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148179498134885','180','pay_pledge','1481795001','保证金抵商品：“<a href="/Home/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”货款【20元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148179498134885/aptitude/1.html">BID148179498134885</a>”','0.00','20.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148179498134885','180','paybid_unfreeze','1481795001','按时(在线)支付拍品订单<a href="/Home/Auction/details/pid/11/aptitude/1.html">【克拉的肌肤看见了快递劫匪】</a>','30.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148179510117691','180','pay_pledge','1481795268','保证金抵商品：“<a href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”货款【220元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148179510117691/aptitude/1.html">BID148179510117691</a>”','0.00','220.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148179510117691','180','paybid_unfreeze','1481795268','按时(在线)支付拍品订单<a href="/Home/Auction/details/pid/12/aptitude/1.html">【了空间按快了速度激发垃圾似的】</a>','380.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148179585313181','1','add_freeze','1481795853','发布拍卖：“<a href="/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148179586832165','180','bid_freeze','1481795868','参拍“<a href="/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148179594602495','1','add_freeze','1481795946','发布拍卖：“<a href="/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148179595951770','180','bid_freeze','1481795959','参拍“<a href="/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”冻结保证金！','0.00','50.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148179652902319','1','buy_break_nopay','1481796529','您未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/12.html">了空间按快了速度激发垃圾似的</a>】，扣除保证金300.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148179510117691.html">BID148179510117691</a>','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('anp148179652903197','180','seller_break_nopay','1481796529','卖家未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/12.html">了空间按快了速度激发垃圾似的</a>】，扣除保证金300元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148179510117691.html">BID148179510117691</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148179760071086','1','seller_break_deliver','1481797600','您未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/11.html">克拉的肌肤看见了快递劫匪</a>】，扣除保证金300.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148179498134885.html">BID148179498134885</a>','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('anp148179760071895','180','buy_break_deliver','1481797600','卖家未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/11.html">克拉的肌肤看见了快递劫匪</a>】，扣除保证金240元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148179498134885.html">BID148179498134885</a>','240.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148179653013440','180','paybid_unfreeze','1481879072','按时(线下)支付拍品订单<a href="/Home/Auction/details/pid/14/aptitude/1.html">【卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>','50.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148194037563862','1','add_freeze','1481940375','发布拍卖：“<a href="/Auction/details/pid/15/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('aad148275849563520','524','admin_deposit','1482758495','','1000.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('aad148275851770020','523','admin_deposit','1482758517','','1000.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('ami14827587719836','523','admin_deduct','1482758771','','0.00','1000.00');
INSERT INTO `on_member_pledge_bill` VALUES ('plg148276064842813','524','bid_freeze','1482760648','参拍“<a href="/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结专场保证金！','0.00','100.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148276081586549','524','pay_deduct','1482760930','支付商品：“<a href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148276081586549/aptitude/1.html">BID148276081586549</a>”，支付成功！','0.00','311.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148276080846045','524','pay_deduct','1482760949','支付商品：“<a href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148276080846045/aptitude/1.html">BID148276080846045</a>”，支付成功！','0.00','211.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148276080104251','524','pay_deduct','1482760979','支付商品：“<a href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148276080104251/aptitude/1.html">BID148276080104251</a>”，支付成功！','0.00','211.00');
INSERT INTO `on_member_pledge_bill` VALUES ('BID148276080104251','524','pay_pledge','1482760979','保证金抵商品：“<a href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”货款【100.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148276080104251/aptitude/1.html">BID148276080104251</a>”','0.00','100.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148314759510662','1','add_unfreeze','1483147595','拍品流拍<a href="/Home/Auction/details/pid/15/aptitude/1.html">【克拉的肌肤看见了快递劫匪】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('add148360760206195','1','add_freeze','1483607602','发布拍卖：“<a href="/Auction/details/pid/25/aptitude/1.html">顺口溜的卷发卡洛斯大姐夫</a>”冻结保证金【300.00元】！','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148375655220130','1','add_unfreeze','1483756552','买家未按时支付<a href="/Home/Auction/details/pid/10/aptitude/1.html">【卡就死掉了咖啡将拉克丝的】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148375655912782','180','buy_break_nopay','1483756559','您未在有效期支付，拍品【<a href="http://192.168.1.238/Auction/details/pid/10.html">卡就死掉了咖啡将拉克丝的</a>】，扣除保证金600.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148193456477765.html">BID148193456477765</a>','0.00','600.00');
INSERT INTO `on_member_pledge_bill` VALUES ('anp148375655914351','1','seller_break_nopay','1483756559','买家未在有效期支付，拍品【<a href="http://192.168.1.238/Auction/details/pid/10.html">卡就死掉了咖啡将拉克丝的</a>】，扣除保证金480元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148193456477765.html">BID148193456477765</a>','480.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148375656575730','1','seller_break_deliver','1483756565','您未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/8.html">卡就死掉了咖啡将拉克丝的</a>】，扣除保证金300.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159922987522.html">BID148159922987522</a>','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('anp14837565657578','180','buy_break_deliver','1483756565','卖家未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/8.html">卡就死掉了咖啡将拉克丝的</a>】，扣除保证金240元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159922987522.html">BID148159922987522</a>','240.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('bnp148375657235653','1','seller_break_deliver','1483756572','您未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/9.html">克拉的肌肤看见了快递劫匪</a>】，扣除保证金300.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159923037371.html">BID148159923037371</a>','0.00','300.00');
INSERT INTO `on_member_pledge_bill` VALUES ('anp148375657235646','180','buy_break_deliver','1483756572','卖家未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/9.html">克拉的肌肤看见了快递劫匪</a>】，扣除保证金240元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159923037371.html">BID148159923037371</a>','240.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148375670939144','1','payadd_unfreeze','1483756709','买家确认收到<a href="/Home/Auction/details/pid/14/aptitude/1.html">【卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>','300.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('pro148375671720633','1','profit','1483756717','买家确认收到拍品“<a href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179653013440/aptitude/1.html">BID148179653013440</a>”，拍品成交价：600.00元+运费：10.00元=订单总额：610元，扣除网站佣金：120.00元后收入490元','490.00','0.00');
INSERT INTO `on_member_pledge_bill` VALUES ('auf148436539651718','1','add_unfreeze','1484365396','拍品流拍<a href="/Home/Auction/details/pid/25/aptitude/1.html">【顺口溜的卷发卡洛斯大姐夫】</a>','300.00','0.00');


# 数据库表：on_member_pledge_take 数据信息


# 数据库表：on_member_weixin 数据信息
INSERT INTO `on_member_weixin` VALUES ('oL2W_s49jkyOpJIA53adUrkCmWl80000','6','ONcoo Service','1','新乡','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAfARa8ibbTppcicUHRWhDcTrSkEC7jMbeMyMUFYkWQOBwBhmqviaFWYyhOaWOvkOAQvtvVBgRn4ss8Q/0','0','ovLBgwUNIpRhhOAo3Qt5VLVtGOo0','','0','1481011187');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9EbujpnHg7yX79PW146ykQ','7','@','2','合肥','中国','安徽','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAbM9Tc3groh2icvaeBG6fnEmBvx1l7hrIosN80rtNFZMOMjlv9PXJ2PsadGCJavSxsStzkwzEkC4u/0','0','ovLBgwSfZUxXrkw1Rj9Q15zRnsHA','','0','1470449518');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxdjDdza2wuIUJHCVvsO40I','8','陶吉吉','1','江北','中国','重庆','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Pp7Qmib66ZdUlGSXwYJqqib1YwMSs7RgGgUiabdPgEAmansy1F39JCE0iad1EagIYiaC24NiaOeUDhg834GdEiauxYNaWh/0','0','ovLBgwV-3uwW6c2WnBhRH1lKKVPY','','0','1470450913');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9soafzw2XyF8rt0XCMPNUg','9','易君','1','杭州','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaELOEmvT3W7aicdG2YyRAKLB7slYVARdRgGocEM3Xlee2ANuxFua0cicnPicGh85cLawex9esnu1eTTGg/0','0','ovLBgwS3NEFThImy3bviRXuvuMlY','','0','1470568819');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_2uyqz3PFCktwq052TGKhU','10','雪煌','1','杭州','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJVyHXlo3FuJDVSoAo4R7WGjWz6xxa4HoqPYa5aU6G6L1lPYQo29p1Cte74oL9nRBBWwnUy5icyfjj/0','0','ovLBgwZacrEYbj5ioMLOWSZNjkLE','','0','1470814984');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swXvPFL_SipcCJHzpBw3pEw','11','孟鹤松','1','周口','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqKM7kPDON1aNWhrA2IPsKo8SEeib3hbYRFUJAdZj2wL1GvY2vnynhSqr7Xqvq0VS4lGDj4fRZGzZy/0','0','ovLBgwSweJHmvCWGZLlPKe8kurd4','','0','1470569207');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3PfY-Hh8CwbpLT1gtH9t8s','13','F','1','衡水','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwXnzBZGL6VwR09MPuErtEMHwIf3qHvRe2KxLxVSyMsRaOBJKibmmxJTiaDRMzWrAe0n3bJqjrSeJly/0','0','ovLBgwZgJR5Ho4FaxV0NNGNtqENg','','0','1471770100');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swkSUS0V1V1CZ0mOnSQcdBQ','14','africa','1','丰台','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJSiaialDQh3IMRIAEI7nVibvwFIibw6fjNh5zn26xTmV5sceukuKqHM8za2PAb33wQT5ES7NzcqbgdW9/0','0','ovLBgwbv1HFaoYys17Epx7HpB5fw','','0','1481172859');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxHmk-mWoEU5HTT2-9z5gTY','15','文玩部落','1','','中国','天津','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpkxCyMMHrWmHeDwPlh8FbnUbbIFKrjuTM7cF4oTSxaNs5coZ1eWjGZh6BpSPoS1cIveXsNtnEuhCyMVLe7kWwF/0','0','ovLBgwVf8mg6wSsW8BJJqc_ghu5U','','0','1480482323');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_5QwMYN7QmqHGYz2CO0YjI','19','曹峰','1','南京','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwSncs4G5mh5WRCpYianCU7s4ovyvlqjAKgyKgahCuGOjrjCCskN25kOiaOuQXRICg4MtyoB7el44hZ/0','0','ovLBgwfGx2Sfpk6CpCujsDb63fYc','','0','1475114770');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s65jHH6O7Of8-sHnF_iCVDg','20','中国-网络中心','1','佳木斯','中国','黑龙江','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLCjIKfKJX0tUepeiaNtYsW765DeBly2gxFwCUCM4OvkQ6SzAXEBbfRibiad6MeCReEudQmticvj1KQGbA/0','0','ovLBgwVbPw1jO-eDXWeiC0Y57mVA','','0','1478493902');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxps0vv3NhCPu0ymEG6Cm9I','21','清风徐来@梵音绕','1','虹口','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKXkVXncYdJibVPpwnxrjzriaicsUP4yQL5zQWxLP5ibW7n92IMK6YVwChQIqvjGNvwsBxAmfATaYLr4A/0','0','ovLBgwdIzF8yNNJeGF7BvV-iktVM','','0','1470562661');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9fucAhb7t6_ctT_-kKqa90','23','晨曦','1','长宁','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwXjQKARibbkiagp7h5sdhc6NEN3m3CeOLm8B5wXAhveURdVo0VxoHH7AFibWWM1XENfeKrOKtBvRiaou/0','0','ovLBgwbqICtr_OcES_-_fLd-4gvQ','','0','1470630666');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szBhk7qGjy_Z5Qt4DX7xTVU','24','焦雪峰','1','廊坊','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBjfqagkzNibR4QPRbgYcOpVMxewblziaVvOM3o6bAedqic76xNsAibAoF65RkVOan2fh12cpDgTB9QCQ/0','0','ovLBgwTyTfOfRm5TIncwkpvoMtsE','','0','1470645464');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5D3e57f2kGi-2FDV325HIg','30','A诺唯水晶','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7iazicicQOtGuZU42QhNfevG8gKN0Ua5bgCWCQ55RC5Bd8WDmV3fOZc8miczvHnhMtnsvWkibqx07dibLvQ/0','0','ovLBgwV-Nu0oyJC4tW2HEvTanEVA','','0','1471959857');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0UbARGvyVw8lyo6TjM9fTA','26','月之海','1','','日本','茨城','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM4olHnV9uWLRxhicOhSIrh6mKjKzau3ICuwvUWhXWrUHOvsnJnWA3XuzqWurRNFttz2UE4Gnmc97Oib5OicxWaIcbksgHLTszYXg8/0','0','ovLBgwSIlDId9mKgyHA9sWS4yrS0','','0','1477823941');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxNcgCxDMsIZkivQZ_p0YkI','27','李虎','1','海淀','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM72XFXvXLIVc1YubBHlcUz659b1gTUzK75DpibU45txcrVZh84YDtlbzxkPoCxbrNwINbrPiaMmYncw/0','0','ovLBgwVMdJHpaQQoefVYslKBYQbg','','0','1471338364');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sz09qidHkFZ6TyCEG8k0QEg','28','许学振-延信文创','1','杭州','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbMQYjiczaoW1ktYfvWiaMYog8dZ4eY70ibO4rjhDDMozxWT9tSz6IIvWcABuQJ1iafuycWZZTicEEO8OuA/0','0','ovLBgwYe8-UAO6IYWcHAHZ9IxMus','','0','1474871396');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0c3lUdFS2L55M5Vtgav5JI','29','허성일????????จุ๊บ ','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZiaJRqIOq7q7CuxicnicYGg16yvwtVAhKBHqWX8pqDtJ5GwaD2QhbhRHvuGQlRRDWD7PZwPjW3UboNQxhg42JLezicP/0','0','ovLBgwTxXZOBjuXCNWFtDA4DWAJE','','0','1470747671');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2VWwCJ17CX8aCLY-GYn9AQ','31','億','1','福州','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEL9aXsWcwGQqBNX4EHjQWLyxmFPhuu4kbTBumTdxBJJH6vOiaxOYbFvOlib78MoAKt4nTaNr5LiblN4w/0','0','ovLBgwSzSJjLs-Hh1GZJ8qFrb1XQ','','0','1470810045');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s41oMLmPhAGCywHr-Hf7S38','32','不会咬人','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqADuPVDxd0IbVtELe9GibZPX6ljJXeX7gFfLCKzXicrr2YJ7nErbWfW5p9AgdGiajpx0FsgrILjtrJs/0','0','ovLBgwWTjqrN2DOv65Qiyqlu8Mes','','0','1470815965');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8rBudooaPxztU6dk6JP_s8','33','张鸿波','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM7XYIIqQ3f55nGZ7nzZtXByDBzKqCia6K7mPR9J0IoOWfIIFibw3ACYtYN8Y7PxVAELUichNd3Nia8CxY23ib4UJHNM0Pjf6PTCdxhI/0','0','ovLBgwWSOOLzvrxHksITqtDfYW7k','','0','1478095481');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syHn5JRRqljwSCRyNZeYU1s','35','游牧人','1','苏州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJbMkjY5HLEibYlFgLddsmxLPq2Ms18JdZJr3HeiaTrUOOZtUCF0XKOTbGneomMuJvgZhtpCXcqnVDK/0','0','ovLBgwXeRJkYaJC6ZIw5VmlWEEqw','','0','1479989130');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2K2y3Q2zNGmqiZ6xasegpI','36','FCS(江)','1','河北','中国','天津','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJfmARLo0ckXctdQTP9WJWPFyg5ibbDWSqJIcfXs5MibQIg9NBfSRgrdrXyXSw45Xh7snsZ7KKKFVgj/0','0','ovLBgwWaWCUVl8miJmQz0eNEdgFY','','0','1472707990');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sw6UF4gF52AjzydoV39IVTs','37','……','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEJ7LffTibWtJtgshpmhMppnQzibm6CtYtmyHGLFbNCvuq1JOvvAIEiaTUbMo0TOL3vGfF99bvavus2QQ/0','0','ovLBgwQmk9V6wD4YCSDXDFwditVA','','0','1470898868');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sylmPvH6X6E05TGBVxBKf0U','38','打落江涛声','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqKJIFbDiaxUac4mPzZiaNicFFEnL5LkUg4pmPKrYnfYTycMsDz8kxDhSwxk0724AwOaF7WYOz7qQLt1/0','0','ovLBgwU0P25iP1by808_H_3wczlE','','0','1481116929');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7YJitGmrciJJZ4PgIiQz84','39',' evan','1','渝中','中国','重庆','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPgdWPqDRLbgTiamHB26wlIiakzNHcMuYiaITvuEVBXyfsjUAQsgic30CQpDjbzt0XLjkAiaAUDXFZd1BoJmsEKdPTpw/0','0','ovLBgwW-7_MDB4ZxcuKNO5pOQAH8','','0','1470904249');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swcP0gzurOL-p7AGUO8arFE','40','阳光下的微笑','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpejK6zohxRXTxTnvqBRcmJdyUX3JhwajNxKqeMgxwWY7KXGJ8DFhhic9xWrgHV9IM4Y1nVr3OWYyvXric5kuVyZm/0','0','ovLBgwSkF5V-dpRCzUfnsVZoJjEU','','0','1470974290');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5gvH2OD032Z7aRan3HoauA','41','枫林卫平光彩拍卖光华招标','1','泰安','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZj6Dr0cucUQeHtMSlCUeGB1Nib1gVnHr3sicHyWhQZvR6XPwrQzTtqnogDzkibMqeA1WIsmCmmjyGicsA/0','0','ovLBgwQBfCyLfi82RQqwIpyZOTi0','','0','1470982245');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-cV9IENGUCWTXduX9YFPu4','42','照夜白','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqGK9b9kw1neibiaxvSPmmsMAmbnBfpUSUDrLBzjo0jgxsmrsnXfz8TFH4W3SpM9mXt1EaJGhvWzH5M/0','0','ovLBgwZwvHJnUIgwH9dO0qfT61-w','','0','1479975649');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_ASt4HpRGVd9Mtu72-mKKA','43','良匠','1','南宁','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/OJ5j0lMpTBOKIl4giaqooqKM4VRQoyzI2UBwr51CoESibWiaibnByHbSeQ7oCKibr53jpXyQGLX6RFwIJvD1LxEY8fwf2a3FiavZlO/0','0','ovLBgwZz_XvSPu1SPQr1ZGCTlcag','','0','1473476682');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxlTdsuGX37lI-7VTpMyNHk','44','陈基建','1','德州','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEILfJfZicU5tO81sLeicpibT6LzCMKExyddiaxkkOfyeU3DwVN3KGCxNVhObxW4YDjbUg0ADbEaGeWkVA/0','0','ovLBgwcuTpX04g1lQASy1Rcuxp3o','','0','1470993409');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8wUr2AQgKANKIVFZ16nvKI','45','静水','1','佛山','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGWAfwibm4diaMiadDGbtNqWyFWJaczHibGoiamIgUj9SzI5R3GFyuOAMwsDGULj3FQxd0ibcGT0IAUaOAEND8wYibpiaQBu/0','0','ovLBgwX1JYLS-SLa5z87sRZCKZm4','','0','1478332243');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1NUNShIvV0Vc3hxqwSW8Ro','46','','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXae2eFrC3j9gEGoo48xfhNWr1icBpdSXko5lGwibnolan5nUyGoxnz4cCyib3wF6tMiaYicW4ewafIKDU5Lhmeq1bqT/0','0','ovLBgwYpKkyDx_pcX7OrRPAg3GKg','','0','1478939082');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6VbPFbebF6IbCpfKaeGYGw','47','文俊','1','东城','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAZibAN7icR6NRcbK5jRDra8G9yCx7k34tRNbLCjgFg541XoXFPiatahbMhsLLFebBP89k2SUicibSBd16/0','0','ovLBgwd6Vgveww9LvkFervU_KkCU','','0','1471141496');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0vVOJEG-xKzV_HHDn5eFr0','48','Guardian','1','昌平','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGUYhIgicCnxibYnic77x4WPkjDMkxIPd0nD2m4cIKP9kL32jft3dkYibPnF82XTEweWom4pHHxA5GwrICewCQ5klYJj/0','0','ovLBgwQEdxN2GAdvu2bTDAidtgTo','','0','1471060012');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6lUk-R8ar09u_jjUncEcwM','49','〰','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDZgxuhxG4bdZrOvTnk74nD11zuicMne5u3VS66vrTKibkKCCPZXeKEqAkMl8LOueMqd3iahBeG0ButA/0','0','ovLBgwfYJU9H0i5fUwRw5ytMtDnI','','0','1474197812');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s51XlE16vxo8RSv9SEAPyPY','50','Tolerance','1','南宁','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJeKuiareRFkibvAMCdul0R5Omf5zwXXhrPoqNQpgFccfW0aVnsf8Rpxs7MYVxibGC32GxjVLHWbgHa5/0','0','ovLBgwdkwbheY3x-nMSHDPUSpV-A','','0','1471072115');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5SL5hHM9ulDqLDwgzrS7L0','51','大爱小艾','1','哈尔滨','中国','黑龙江','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwZBqMfOBF9OonVf3O0cFVSusu2hnYOlCzicfAPSyJiaaw56IqOx7jcJia7FKMwTRzU0LWZgmyNxwialk/0','0','ovLBgwRAgKvQ2bZjZ8bknvefXqT4','','0','1471073358');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0qVCafgwVg7XezOtxLOTy0','54','黄承志～油画','0','','','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqIEicSHzdWmsHeE10bj3wFba1HZ31MJVPtxFlFDvQ1U7MPJ9gD8djlGUvgBib3Akuia7etwQNx1oEMp/0','0','ovLBgwXzvpdFsbN4DVU0vSWcT5GU','','0','1479305328');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szYCfm-0qHaH0TcFDAdc1G0','56','A广商所收藏品交易中心','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6uaMWKAWeeJ20FjpzjOa29XnH7YIBr17hY277ghyibbicdJW5lZpRRBvibJJhlWd7iaGDkKmpOlYx7I01D7DGGib6JnE5EHa3TibJvE/0','0','ovLBgwa5R3Q3iW0Wp9W7HDlHl50k','','0','1472460254');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0XfoXqo4BqpBdQbwpeeggU','57','奇珍艺宝','2','','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/b0fZPYOcotvhcAbOqYLClzaCgcAMBlMzqPP5pSltKZteQXzqLxfewS6e7n5icd0EtANQ7ic5BulLx01kwBemdiaqLNhUvMGcwPb/0','0','ovLBgwYYqFCwDorcL7-9JpJRYr1c','','0','1471155967');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2j3WL20d8qZNURm6bcMLUw','58','林伟敏 ོ','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/afrqzzuSf3LmPYcjYgpiahcGUHnJHZbeL4AGytyNoBdGAhXvBBvriaJjhibhPltbZVjTiagUibgQ28GRsibWBAGYlqicic9g44RPWLoJ/0','0','ovLBgwcGS7CLVFT5ZkdPIA7sUFjk','','0','1471160517');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2foWKt-5ITj5hssE_I7a8I','59','俗人勇 ','1','虹口','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwcENFpq8ybq5oTGiaWicg5CAtB9gD7zIEoJYCmZb2ib3pVl3n4MnzG1piboB7H5W1jwwjiad7ZtHLlu1u/0','0','ovLBgwQ3l0vjXALMHloRJO1M9mAY','','0','1471211512');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s30ZYO_iFSO3ivMIMHa_kwQ','60','零点迷雾','1','长沙','中国','湖南','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbMrIy2Iaiao32JEIDlk9J7dgXW1O7I5aWTpJLMP4VRXvxetcetcznl50GnmgJf9MuC4Kwh23icUibvk0l0mZFHkfiaY/0','0','ovLBgweaHcEGSX346itq3HW0mz8Y','','0','1471166346');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-jyWCMHNTsWS7ty0lsTqj4','62','艾泽宇','1','东丽','中国','天津','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBReQfX8oWw5vQeWKNfRfn9aAyAUV4G117GzicfRnwBiaUjONll8ev0yfGI4uPTQGws0PzljQP1u1aQ/0','0','ovLBgwUHhTvzIEkVu99R4njbPh-I','','0','1480832311');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9XE9TvcryZ6FD3xo5iCsHs','63','曹艳军','1','东莞','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVYgNUykd8Oicia1Aw4f5UzhCWoicFrZHUZaWlk1HMqlwsqK2p6lINGaHuold6ZibTICVJSzXATLPo6xeM5SMvxVPsV/0','0','ovLBgwcgDTR2qXYCNQCH3FXb43iI','','0','1471445674');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8f9Qq88fzjGn4uFmFniCaY','64','高文(瞻瞩世纪)','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM43fO9kD0wNKXnzkMgFG3FzDcmstVopwgkgnvic5ojkwImibv6l9mfribicK9q89JNrkKM9uk9cgKc8JTYOsicECR7HGmUyeeKny9Xc/0','0','ovLBgwdiGvLevyRKuMed4mcyKbZM','','0','1473687639');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6kH2TDTL0Tenr7MZUH2blM','65','以吃亏为乐、以帮助别人为荣','1','南宁','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbNv5nH2gArlRHK2gZVeNh72NLujqvfvW8wSkyyTNRHgUFoOsgJVRJUgpz3IYKLuYGHHXYZS3gndt9OQprFR6MD9/0','0','ovLBgwd5T3bqOBTJk50MysXoSfno','','0','1471277552');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4lnBItuarnsiT_QfylL6ME','66','凤仪画馆','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVYgNUykd8OicqGeOht8yVeo4n1ibNFPZmYenoo82VwXFVrke6AQFUGIMrwxicpj7YfYdqnUOFBYP7JiaxloKZIOc0ic/0','0','ovLBgweoPThzIgEf1NHLbd1VWHes','','0','1478257158');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szmaIvxonMqk98RH7mgFYYM','67','悠远Will yeh','1','杭州','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwf6Y7Z1TBFl1W6UnTjecEvluRjhQCaMZYyAv8f9crOWFM5CL7icx0Kl7FkCiaS5ticvbcKvzQpmOJXc/0','0','ovLBgwXIG4JMgDpPKnqfxfrvnRfA','','0','1478277695');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szrT8_cWx0l3wQZy1hWRQF4','68','杨文华','1','厦门','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqAD0tpErU4v9tfo69YHMvjHkrzTsHYljz9GiaNPSkAr9jbUFQ1ufeZIYUB2DgnSY9nwY8jZiaUeSnq/0','0','ovLBgwXsGLpvJojXAxmcPuJYAE5Y','','0','1471847482');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s28zFyUoq-b-tIqnxFyFS6U','69','跨境产业 阿诺哥','1','福州','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEJiambSFglTNSKdQUzqK97q4icNzuuia43ErOA9KWhyK4uymhW0rLFPXpS3UFkjZ4UBdmOQaVYebuNhw/0','0','ovLBgwWrYXYCGuJgPAPYz7jvJvmQ','','0','1471550913');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9jETgvZLq6h-BWIu-fatTg','70','彼岸','1','南岸','中国','重庆','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXnMuJBJiaswIgax5WqQv7ZGDgyS65j2ouOUa6Mh0BJmlesImWncF57lDSgaItbzQuqa1iah5daAlP5St7E953Giag/0','0','ovLBgwQ8PUup6teE0X25DRfrb6Uk','','0','1473213454');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swn8YM4YEiMq9bYZ7Jz8dno','71','Mr.TK','1','','','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwVFBEQ4x0yoYZz9uURS1asqgkOjoB8cx2YKrye2f9nWUYn5mnJBLsSuOXwuwKic2NWuc8Tdy0aSJy/0','0','ovLBgwU1QQk0XwbrjNSXXu45GKfM','','0','1471654831');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swL3Mcf3NoAAanjcXRPZe_c','72','独自上路','1','漳州','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZj5g0sYhMuxdLJtibl5YtnxT1GOViceicdSIJQKZiahBDhZ1ZN88WdeNHptbNQ6azezSsoHKKVibhTbQkA/0','0','ovLBgwZoWg-GXDzFcauG6-QRcr_0','','0','1471687517');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swh8-Zhb4906SYfG9KFFXQY','73','段超喜(双喜网络&艾普达投资)','1','常州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwaWWjibw5prxzicn0441Y5Gn8IXYfDkBXzJiaS42pTHXMRaUL9TxpogD0SJxsA7eUZwy7ibdSWphcydX/0','0','ovLBgwYvT1U92IoXKwfoB8vP77KA','','0','1472040649');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4-gSJcvkJ9Qbcr4E2PNlVg','74','哲狼','1','郑州','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqIWHaR73TdRU7yAjS6gn6fcJgJXJu7mFGoiaBlMkIPfaxAQCtvbdpAN5nxyUqD0zOaCfXB3yicyiasL/0','0','ovLBgwSejpwbJq0Fe61zg3XJptuY','','0','1471758533');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-vQejRYfp9zflJcsiuSkqc','75','静静','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwZMVJhNBR7XSa42eDs8mN1YDUdpo0wV8DEV9I439jsNlLvAej5c8arQReWIwAb2qHH5kn1F7PENU/0','0','ovLBgwfJ-v2gmQxopPdOdpFNpijQ','','0','1472428114');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swKKzgPPeyU6NAsCAh_nW-Q','78','杨妃献','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Po1fia5suK6fiaTiakTdLfCIYAgBVRpMGcgbyTEW1MQK7JKUPWFYNx0Tm7CvoWcmWzppqMtIGVafqiaqbOWdACdLGIc/0','0','ovLBgwQo1uMLU8jFq-xkksZSg3QQ','','0','1471873714');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2A_-xudV4-Jg5WW6sf18TQ','81','瑞','1','北海','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6uaMWKAWeeJ20FjpzjOa29XIc6uxtzl3aPIsQw6icibxUFLI2sQz7slKwoN6YDkX1g88D2XIWXvxzEC2TfUndh0GWAlBvibjmLKg/0','0','ovLBgweKmR5q4uaJk6XHJMwIVXoM','','0','1479951397');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5f5Xjj9ZmK1B9MPkubDGA8','82','……～！？','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PrgtpgBvgQoQuBeSbZtMHDOfdH119rE7zpv9UUW6gLFrJmjO1ZZJPLVJqFfZYufBcc6z9cMa49dtf34UTXbHsyb/0','0','ovLBgwYvJE_oZvnkrSS_FOYtHK1Y','','0','1471927058');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szD5C7tHUC3OHmw7B7ID_IM','83','赤风在线','1','徐州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbMb4huNiaTlpGTVTsy1hoxLA47ucD9MAymJWZN2ATe3YEB9KkkoXBM5svhicA4nHSDXLeDgicnfnDPtA/0','0','ovLBgwfiV1KrKfHmgYwmjePnfQJI','','0','1472024000');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5wwSkA2RS6rkQzlWx9RK5E','84','时光','1','成都','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhKNL2mSndJia9vVF9jibW3UgC3EX2ic7kwmBibVTA6dP9RCkNXmNDsDiaeIG01WWsIiabXNK0fuLMO7ianQ/0','0','ovLBgwRTe4Maz_Rc9BLbxRiBv4x0','','0','1472137805');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3Xo9B0yEFI8wFssS1ctqxk','85','静以修身 俭不养德????','1','杭州','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLAIvkiaxg3eKYUNNzJQ3nzWcTf9mzPFP3iabm0zmrWickY5WVyKukXvacD4ThichEfcq0lxOjeeWs0wqqeTanZiaN90qzVH7PyaB2e8/0','0','ovLBgwTeenMMsCU0vS-3oFfn6M7I','','0','1472170155');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3sWmYcl_CmYKejVWOtvbqQ','86','????金泉????','1','哈尔滨','中国','黑龙江','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoomQiaF9GQjb3o9YaQHdNibzeTibcKQIUK4McVuVBdjaE5cU7Q371UtGPBcgBiadP4QQxcLIqniajxd5Phe6FczGnbH/0','0','ovLBgwb7hhQkbudnMITsYSC0jbqQ','','0','1472196211');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swTDF76RnD4pwVunkBjXt_s','88','leo','1','苏州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjMkm2hGY9lDTfnv1TOL0rKtNGlcq0zYicNog6K5BrhKYniaU1UdgWOq1JOtpKq1x2tGiaC2FCDnBrcq0Hbd58k9T0/0','0','ovLBgwS7hW7wQcA_f-gdb22LOYvM','','0','1472716733');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6EejXeUF_spSCRCC4soEIs','94','singlife','1','长宁','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEIQFWUtp3mA6AHyicCLXCP8MWn7mlzehKmzKBVYCkx83iaicBic6CAY0g8O4HGxmYJ9Oibgu0icCYkDVsWg/0','0','ovLBgwXW942gaiEfg191lRkxUSIA','','0','1472372916');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6vw4OZ1ytf1Mh9d3DcZeMI','92','王斌','1','许昌','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM43fO9kD0wNKXnzkMgFG3FzSBsV3pO12GicfrySnouZ3Tia74ViblN89lyBGWCZT7M3TIR1N1tFb6Xrs63CZRlcYrGBwLwyiaHufWc/0','0','ovLBgwarUPScUhnDK_PdQammF4uo','','0','1472348542');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1sD9WtjZP5gmGsEQmEkgp8','96','王军博','1','临汾','中国','山西','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqMcwONyfV3eXjT95dZUMUjFjxpEoianKibfVrvE5wY70kZ7cv5IfMMYqoRvicFg9SrVVrrru94FE2w5/0','0','ovLBgwU-boYlt30zmx4i-qdFJtCQ','','0','1473265768');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4QU2pcCF9Dsl8cO1ViXkA4','97','A缅甸翡翠赌石13713094904','1','南宁','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqBrjgPrqsZOGloic1hk37ibPibU7ia17CVQfhbFiaodke6b7EwFrdsBs1T9Qd1EUvCnUgPCAT7hcMn94h/0','0','ovLBgwWjQlyp1dhPpKGzUb3h0nic','','0','1475028359');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4vxb1qdAFLoPBJYEy-zVUY','98','万传','1','海淀','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKwFicmRPLoTgzP8yCv1eQXj92O6RdNWTekSu1ldp3kGOGcWZXVJBSh4TBp0V0I2PneggcmtVOPZkw/0','0','ovLBgwXtoWtQrFTG12tIGnsNGThc','','0','1472444297');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_OjutphpIE3Hx3UebSqv7Q','100','Causality','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAXFjHg1lp7sF2ayEY6wOeNSI40keO2KHljsCibernTsWr7AcNZGzYWWziaFopdZc8TyOPWibvwDxx7n/0','0','ovLBgwXAJh9TPkrVWovutAKetUSI','','0','1472452767');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4opYziHqYGcM25zgE-D4SQ','101','簡海','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZiaQsvPrF0xDyDQJfdEZ7rcTDiau3TQDNtpLHqWQp6zvGgPHPjjE08RztBMM83IZfe6KkTSa6FdbD6iaM4GDTFhbgy/0','0','ovLBgwYe2Q_MOQHO3WhrGksAv6T0','','0','1472486869');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6GMIFtzFJesapNIpnF4vh8','102','苦涩','1','津南','中国','天津','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJTJxV8FEDV1A0odXcHLm71VJ1iaAxRTlKibdDLFVAsFQOsQibqcuItqEL80prcFSNsQ94RPobvoHXjR/0','0','ovLBgwaFrS1mZrfqzENy_ik1TxC0','','0','1472491408');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7g0QrD6bAu2p1HxyAut2A8','103','a卧云枕月*宗眀畫院','1','临汾','中国','山西','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbMIJibYypEFaARFHIKzfEXzQNM5ZKkwVmpsKBFRnqEWmicgmZMvWiaZhoua5ZjksNibkicrCfGWB4ERibJyVN0Yib7eYwR/0','0','ovLBgwYVoQkKeKc278dNv9QJaYb8','','0','1472518625');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6WLigG_IPWHYjNOHiXtlVI','104','梵夫子','1','厦门','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLCjuY6hibqQbxaicqBruvMX860Aq7tVt0TFoLnqOdY0S6HFYozlstOGLuBjD4EPEYolUSibmiac4xTiagw/0','0','ovLBgwWyBfuhf7IIj1LP6yk5frxE','','0','1479993264');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8ez67HPtVhPNbYq9Gq1jjs','105','行云流水','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXUwChzlbdm1JXwKBd7y13xYEe0drClBp0c73UTkGWJUJI6kMT7trWwHeOV9HibRpqqva2fJPhUoMDz3CW54fvEn/0','0','ovLBgwTM6wyFUCQbMWPJlv6FJzwE','','0','1472664688');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swceXk0XK8LwXlVQ1L4MgZY','106','A          人渣 ????','1','许昌','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM7kSAGYmVwZedzd6qzw9cQ9SxUMukibwLqZJuiah2vscBxc3KOPLmWJtfZEXEcBTz9R7fWySnwUKoGA/0','0','ovLBgwTTXzzAFOmJvmUcrB4ZLtsI','','0','1472605202');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8olj5bxL7_Xi0Rj0gsasw8','107','浪里个浪','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Nickanu2qkkWRmmDVgljkcJ3fgOeaiahj0ibI9iaVxgBvqkKjKia6IC5t9dib9VmbicPVENG7MBCmib1m12e0bp8rbvU5Wfb3kYR3KkC/0','0','ovLBgwV2C_gVJlnVXirqhMqUIikY','','0','1480247918');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-oJpZ_OYy-lX46hRbYtjTI','108','独家记忆','1','福州','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia6aupZIJGum1kxe6AWNLQmECIB8NYyDtaXkDib0jg2p7oiawOQjC6X4BZpeMpCSOmQNqIuLxiaheiaJF/0','0','ovLBgwc-p4yCYDvh7K1LPjIU8jPo','','0','1472618262');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_-adgdIH6o3e3ijogDSbcc','109','AAA萧萧13771080302','1','苏州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwSnkiawbYvfSdStethHf3JXO4F6He0ic6IM71e9edZo1LENqAMiaVbrsGoffXMC0w0tjqCicNTEfBzBh/0','0','ovLBgwSJGi3KmUcrD5HzpPOeQ9W4','','0','1472700360');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s73-6wRC9ojMMDl8VFltez4','110','左','1','沧州','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqIJgsfQqXDNfGKSYby2BMyH5cM6rfbyn8N7AcKibVeowqMDKJhQez6BPiauLQl7Xt30CJic03Ns1mj2/0','0','ovLBgwaXmdaenWlfDl7_GAV13x-c','','0','1472731327');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3C9RLHUJvnBXvXk-03sOS4','112','经纬','1','广安','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLAmdD8aiaX9TKswzoytw0iceeMXyX4ic8C8AZogicAYWCxro88Ca8jaUWFORDic1sTvJDj5n3bHHFTDDcQ/0','0','ovLBgwbWia3uPDmGZYup5bnI1r2g','','0','1476180934');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7OOBJ6HpMZw_Sie3sJoT_Y','113','笑语晏晏','1','成都','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPv3eUiahaKezI05XoK3vGn08hYy7ZMQSUOhtlKibyT0UMgicHvxe9E8Y8vj5hOHNibYBMLbKGq1tic9vVkb5fyibhNYv/0','0','ovLBgwcmTvqJHYRiiICySdsvw6y8','','0','1472638990');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5lqZkVdcwnvKTKi_S-b5Ko','114','AAA贺淳涛','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZha5PEy3I7RyicJY6ficImvRbLxXv2pUoJ08vapMOddvxMP10qr4XcdojMLt51VA7jlXMRSFvBQ56sw/0','0','ovLBgwT514USHEz1anCqXfabJnU4','','0','1472698506');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5LntNlIXib6JlFr3rPOvTM','115','马可','1','福州','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwYofiay2eYPAn3Yj8TVPyZT0F4gIVBYv9e0g7AyCDT73ZKLqcRxghoiccKvTmXGFibZNbSfl0c54Unic/0','0','ovLBgwZws24v96wk6FFLgXaBZtCk','','0','1472700701');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0lDY3NIpvVin6bFi8GsQXY','116','罗永强','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqJzlqTMgycnvzSYwSiaB6fBaF5bbo33J5qcdDPMibCL9rVtzAngHa1BMaQpL7Tk0fRwIyB60ahPdm5/0','0','ovLBgwY5NY7DVE6ZhV--RXJDNmzg','','0','1472711762');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2vsKn4JATyBhVD3WvBxcCI','117','钢','1','','','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjMkm2hGY9lDaia3FctxKAdyS8w9icXwd7S1pmOK5JVeqMvSq91lndB2RNdfeibxbWvZCTiamiaaV2MiavvH93DWOsTPO/0','0','ovLBgwW6zxVurGggAsJghsWKZQ6U','','0','1472719284');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7-DqmlBHkRFWxB_fCfqgLY','118','1颗温暖的心｀','1','西安','中国','陕西','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZiaJRqIOq7q7CkibhK5ewMIFiaTxNV443bKfNzlOM4BF1PjicQoDmKAwkk13LqN0SxOpHHpHzRprRk3HaCHN5wviax48/0','0','ovLBgwahbv5llAlpvQjnp-T0FQsU','','0','1480749539');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s75JMiSOzR20as81vPkSYlY','121','静篤堂   篤之','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwSkJfGgLVE30qbZTibRCQmxARKfyfxscD2pE3xm47BfaooHzWNE99QS2cD9JFI8vg0YMDurWQjRcV/0','0','ovLBgwXt6OzGLP61TlGk75Em0DnM','','0','1472797242');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s62KBxk_JGWFfkzWXxL7axY','122','゛温ゝ先生','1','吉林','中国','吉林','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBKEBibovibU49vAZzJmSewK4ZHD7YSia8JuVx92WbzDC9sGtUqt8XVfEjo6N7bgHlJOEqiaWNIIlOIKA/0','0','ovLBgwZyhT_yky6PEgxV8ofuufWc','','0','1475128878');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9thjVARhy-9l9_mxtfzom8','123','仕君','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVK4icSeSu3SJTGjsNqflAGXmFBh57eKzRZ5KDmTtHeEpuTh8DIe1LBkbHVDbQINFN50aJib2aQr8O4vIKBmCM4fd/0','0','ovLBgwZNlh6ezU74Kwf57dxC6TK4','','0','1472799726');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4HnJ46YqKgGdivP8yPg9Kk','124','纵横四海','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/JYaibnXjxSHn8dmRrZOUSrpNp16icNibKl7iapBKuy89SCT1wsexH9n4ibWicAVlcL9l4PMWbxWbJqBAaPQpCkoza0iaN8uYtBvUsva/0','0','ovLBgwbr99c2ZakM4fJQoSeMfx1U','','0','1476606873');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0QgqOZrSIosN8C8xwIcHgQ','125','sandmanhx','1','长沙','中国','湖南','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjXzaMtVbMA4fiarlE50acAiacWE7jCRItUxJl0l3BfuXthbws1NsTfSuiaAiaL1eibRPBgcQnzYtjbybw/0','0','ovLBgwQ_OJ8HF3wadzu9JWXXnzE4','','0','1473609207');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-lN4PHKSBusXqVgAUNyw4Y','126','空谷幽兰','2','海淀','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Poia43CtZkuycQibhmeQzs6JcT7DDbTrhayAIlibEnocvs1CUfiansmicu8D2fD3JgNRmDn4BvUOto5ABkXIllWsEibGia/0','0','ovLBgwXgpCdAuAG7V-Ex62XvCmiw','','0','1472832531');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8kSDeFLazA5r9uQpcVOSW4','128','Andy朱小明','1','苏州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoiancBA4V4dSb9JRdZGtlDOxfx2rWSia5Tg5thB2yvkkpsunh1Ux4ZuBtgXGBqoggPL7XH4LJnO9PZ5XYD0ppXdN/0','0','ovLBgwQNS_OY1YmKtyekedINH0eg','','0','1472884956');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7TuTF4hQ1EKGoAWZ43gIRs','129','赵明海','1','潍坊','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqFDne1wf9Rg8ic96hibw42tlEubfU6l6DiaZraiblO90G9FF1VLkNdPDdk3IcJPMicZOoTcwiaOIHkWeFL/0','0','ovLBgwbXLYyoS3W0WcZMNK5zFti4','','0','1473507173');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3a7PF4KsMxmm5GiEDeIoHk','133','书法达人秀报名咨询-易君','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLB8nurJqzicYI7htMicJ0NDw9icpj8QvFYITJFCFbswY11YYTRH6XREBhhY4xEF3IQY0HME7J7EpERqQ/0','0','ovLBgwRUFb5Jb918tBrRlAi8eFQ0','','0','1472967453');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8GrYABhKVt-4x1y04iLEBc','134','王杰','1','闸北','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwa7Fm3Yd5UXibOx8hoc3u1qvgQY2ibEuDLVlhzs6RwxadyvOeu9rfQDD5kpGvTNZhghz0yqLSVQTXo/0','0','ovLBgwWCIDLlD96urhqyumlczk4w','','0','1480418755');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s60CFQptVoO2pnUqjTdIPMU','135','黄帅','1','沈阳','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CARWAGcJQeYg1GD5xJ17UKSoPuzQLHpibNMmKVjKKysV4qNSMGXNNRHEpcOfJff1fEv0EFU2VHHy9v/0','0','ovLBgwQ80VlGi08NLvIEQak0cmAo','','0','1472986967');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6HPMA5OmulatnjTBG8TnC4','136','默者非靡','1','黄冈','中国','湖北','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Prl6YnVUu7iawkVxOW7NQQQ8hBvVDMNNrMbsFdNkcgkBEnYIkk6rtUlz1Ao9KTQI1bJcRYfuQppSzsSkKe0VXlmM/0','0','ovLBgwY50sut8eLNA77l4uYrsRJg','','0','1479203643');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_6OJDQtPX68nbJChPwt9bY','138','威力兄弟','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/JYaibnXjxSHn8dmRrZOUSriaibf1YYRBKsDupQFIHkdXK3iaNxcYsVjDiaiaVjNeZwAc2nib0kFXy22PibnAbjtgOK2bVZaPhbcDn5dr/0','0','ovLBgwVHGajQXOPvEwWnU7thcO5c','','0','1473063595');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8NKZjcXmxCC30bmrqfKAaE','139','大可','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqF41H0R8Mw4y9jyO1icIdmHvhhaSCQBic7ibDWTWHYzyibAFzs3uO9OpoeTIWn8PseP7ULnktY3NfsuK/0','0','ovLBgwZ_LTjhW4igv_w8FOS8dTag','','0','1473113647');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8SuBIPygYZDNrjeCyXBbqQ','140','罗友财','1','南宁','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM7ibN4eIdb76Jt6TwZRIE4olgQ463llc4yDKJ3Ouz1w6n9GUcm2VNicZjAe6tfsu2zIic8DvTcGKPzruaNT6iceGNaJJRxgfFIIPJo/0','0','ovLBgwWeWMv7g2X4PrAFxA_z8KWM','','0','1473154659');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5Qa9rU5eCzA3fGZFVbiOk8','141','风语者','1','包头','中国','内蒙古','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwRN91hsUWcZ7BvGniaOzGvIHRgPKnebukGt5ibvcw4ktULbaL0Y4rIDerWKxTEbtAkXcNBdxxsqxTs/0','0','ovLBgwTnwiQvnhYPMYE_QYkceW30','','0','1480594095');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swqYRKPBeHAmUJtGqaF2wXs','142','廖鹏飞','1','乐山','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7iaicxfsR9y30xEbib2v2DEmsmd9x2y1iaA72mJfiaHsQMnpwZ9dJLicEGCNJ20GVXe1qqG5xYKUnMDDuLL/0','0','ovLBgwS3cLfT30Eqn9FY0tdrDhlo','','0','1473182789');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8OgljJzSmzW_m998m3tQVk','144','天使老兵','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbOMZqXRSGlIeUUasJeEibyeJRKyFFibKntxnp4rK7kZYDTAqzD7ZXia8RmA5ApN7nTxteKkVaQicyzv6u0UZtlVatot/0','0','ovLBgwdLkMEA2-w42l0t9qHHoA_k','','0','1473236824');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-pL9-Zn_Un6n29nTf1VY-s','145','白舒文','1','成都','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/x56zUNdJibnF2mKItqWAqtCSmnQFvGGCNOGZXeYUJ5MLPOxzUHbfrfSSNa64jIkfn2miaIlEMIjMI2gV2hqEuxD7HdiaGNiajU4T/0','0','ovLBgwajP3vx230aBknu3M_VRZ_Q','','0','1473239908');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s81QboPrtx38oVskI0A-gmg','146','胡瀚文丨一道堂','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVDVPJTvaDrozNoPqZNrgqDw8oeSXQpk7aMoDzukzdZd9IzvoRniak51nka56JgBJ81ibzBpyOGpMvcEZTTKKpbaW/0','0','ovLBgwRssado5we3t8LZSid7Sqcw','','0','1478944655');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5GLRYHTmFWoMqoDQYE2VYs','147','风清扬','1','龙岩','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVaRjW8WPZ0JZ4Jkw8GzLg9MGHFI2MdbenxW1aEgGQEshRM9aCgzeiaNiaLf51hXWT4FtWUAxZDd60Q/0','0','ovLBgwZdmRRZX56UH0dm9eEzZhZs','','0','1473260835');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-E9bbMpDJ7r-RUBXEm7U_4','148','凪。','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPgdWPqDRLbgWbTQxI0TlBtxJibtgEBuYCXWhykJ4GbWUXUJCHJZHCQYpCQKhSVYKtXN4CwEExKUFicqxUJGCzZur/0','0','ovLBgwQJINXsuNjPI03KHX_klC9I','','0','1473293171');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1OorqytV5d52hOHWxEAFak','149','马跃','1','哈尔滨','中国','黑龙江','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJZiaLPBrXFxGiavrHZg4nhGicMxkWfSTicqAicW3X1D0DmHaxOOvlCJ1AY2c5uXwx7vnFBZX17vH9Xlic4/0','0','ovLBgwfHzrQ3PHgFied--mac6fWQ','','0','1473349570');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2omwHIYwzca4_iEFKKUzMY','151','君心醉紅顔','1','漳州','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLA7dUmGtcL30UPTmA8jlsW97EfcxgH1icibne5UxIRNsYJjicvZnT7D9Gwo5WnpmKFouuKaIPqoTWylA/0','0','ovLBgwfGdJsslD7ePWPrYPUuOe3w','','0','1473560502');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxPpVf5O9FxaLffClNgmzpA','152','水墨汇','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM54cvU73DvmyogVibwStwKe7I5DgNNH5AicIugicGF1Oz0F2LaTIRyAMshNWyUO1xGpAqB2oIRX2uhWg/0','0','ovLBgwQsWK0DDN3kj9yIeg1L9JfE','','0','1478095491');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8L07m8G8c7SsenIRuzEamA','153','马小贱Yeah~☀','1','襄阳','中国','湖北','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia4RiaxFIEd2Ah3Y7XGsGvW3FiaXqSD6VDO448Vm8N83Km6bN8ZHiauiaczhXhPVZibrFibtlvEce99jVZZ/0','0','ovLBgwVXU0Qi19HpKnnoUeaL29ts','','0','1473384634');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syGe10KtTxeZJRVmebZTZZI','155','圣婴','2','虹口','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBJndr3rNhBJF0MAOvicZSnFdia4rylHxp88ZctKLcHQXz7fykMe2nuL9b2BhIoBI0GeH6ZMmic2FZAA/0','0','ovLBgwZeEqN3aL-tos7U6HTTI2sY','','0','1474355715');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sybQksS7owIEcshggINn9UU','156','边防','1','杨浦','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7iawr0CXym5YZaYqicTGJ57eY5146TTRVwppPyTCRc6dzkgibuZmc9ORID8WY8llibTNSpvic1aKHnEBoc/0','0','ovLBgwdZPmKWflfQZa7NFBdGtFeQ','','0','1474156734');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sweqszi5OLRneEU87JyeKQk','157','如风♛','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoiancBA4V4dSeEEHSyGbm4f0ulFqOSobLibKNjOPtcZjfTOP8J5PPc4UNgFwRcZRnE5TQuUujVFP23QRmVbj2Ha2/0','0','ovLBgweFv2YIJUM0YZB1EGWUr1PQ','','0','1478331157');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syt4bag-9oFgYJAjv-JIOSw','158','蔚蓝屋檐','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia9boEaSRRPvmyls9gMyd6VatZVmATOIklWF8BmicPmtYuficZg2CibzCGorDZliamB4OqZibXalGtFGz5/0','0','ovLBgwSHQbt1sQ-F9U_PxVcPEQBk','','0','1473576601');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szmED1QqdRjYUtZ-_Cn1Up8','159','徽脸--小徽','1','合肥','中国','安徽','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaELIGmLpE5wkibbeFWfRErYEQJwBOqC15ic6pzjDupEXPET3w71DthETojibIppqH2aEePXxUw55T3ygQ/0','0','ovLBgwRrcYycUtjJ3T5IRY_J949w','','0','1473427714');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swykB7frjejwVoveoKfxCI8','160','苗涛 l 文物大联盟','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoomQiaF9GQjb8PVyftMAVtIftnTVnkhAbIVQkQ2t81lQ7lLRLia5L2Bia7py5w6rn9l950nhf3fxGvvKhOOrCASpr/0','0','ovLBgwddKBsHiB4H7qb2JT-6zUZM','','0','1476865671');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_issWJp-PoP-Xd6-fBBbU8','161','小香香','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpfAiaRicmHUqDBUlWElGQCicxl8d9LSCBfUt4W2wh87lhjBBoiboMTumqsdszwuOBhOPJE7lVtCy0u1icU8fRBkRibyn/0','0','ovLBgwUE3AWcog0UVyK79rCgX5_0','','0','1473672557');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sztLOmUOMYfhIa7MEFtxe1E','162','咸阳 十年互联网+ 移动互联网 专家','1','青岛','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBAR7f946X9Nd8COIcibIgtxoXcfK5TnxiaOnYzt6rz3gIH1FjrUgL9JGgqeUyYGxicWaVyA2nCGbXJA/0','0','ovLBgwb-FEyQaxXJuC2ZgEwMocdI','','0','1473479154');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4X0195YU4LuIM4p5eZlw8Q','163','车明玺','1','青岛','中国','山东','en','http://wx.qlogo.cn/mmopen/PiajxSqBRaEK2R4FyyD1urpqxudUtPXQYy3sjRlQrZccV7cjzEIwV8dvVwxUbgKicUpoeajcricoHRWP9dsD3ybUw/0','0','ovLBgwTxicQDiREIXvB8LoCV4hgU','','0','1476255231');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6gwG6IBO4a1p6OMP2DPaso','164','我自然    ','1','大连','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAevC5qzIuvGfJrO8nW5BqzibZibYhicnsdlBngn79nOuOen0rb27BRuwV9ibB0ibncO4Hp2SJRJYmBntw/0','0','ovLBgwci4jckgLcBpUTNgt-NuJmo','','0','1480925783');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-jXNFPJBsJHvh29hwYwWqY','165','邦仔????','1','岳阳','中国','湖南','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqBXu8qRJlRysFk4iaEn4RGW0JGQ1MYiaW7licFH5HoAJAnNo8hSfMAVW1176yiaBGSzjARwOVY3xNdpn/0','0','ovLBgwe16H2KBG4mI7XLj7B7oeJ8','','0','1473565332');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_aR8oYJ1FLrE26EaexqZyI','166','Mayon','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqHCDUPOLFOAhTlXe5Z8AAPMpicZOhGbpVQ52lEJwO3GibxLHKz1Nj4JxJBcrmsiaibX8iaGU5epB5CuSu/0','0','ovLBgwbWdI-9e11aOO_N2-pRr53A','','0','1475389642');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s20io_aIzqC24VDB_Rn-SmY','167','三七友','1','佛山','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia3nPNzCD4kSgFJTxpS4CNQgyYUZMYNGSkRWk8fJKyG7s5CribeWrGLqxeRXiczV0gBImOia7D6Uib6Zz/0','0','ovLBgwWadR7RU6vcVZ8flzgMb8HY','','0','1473573843');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-FtODRRK-WA8Gzt7Hj3EoY','172','和平 ????','1','怀化','中国','湖南','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhrVw7Q22wLqVNH0Ng5XOuqaA6Vzicg5LsE5D6R2Pt11mYXQTN4HdDXC3soZqiciayAg3fAcodxBcfKtbsW5M1wbPic/0','0','ovLBgwUIEUwvSbX_zjCCAsnLrXwo','','0','1473650865');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxRX6XPTyNja3Lo-4GOUjow','201','A晶熙','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFweOngRiasRDianR6zgtsUN25I3rbaH7W756iaEiaZsXjV3dVOS2L2M2zWEiaJliaruCDCTGoZ7FuibeYUVW/0','0','ovLBgwfDoViTW-PvahnZezPI-GxE','','0','1474063400');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6jBbjo9VmXMKSLhAMECKDs','175','NASA','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/x56zUNdJibnF2mKItqWAqtA0aiaWvFU0cn9BMIwEDuSBOeNt8qwA2PAzq1F6hEfGO5WGhllm1KehxCiavkxrBDqMXyuDbozrnMt/0','0','ovLBgwbw4PfSjhcgT3rZkaQ9l2Sc','','0','1478326338');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6ENeShv0RTxM07LjJylZ4U','176','平凡','1','昆明','中国','云南','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEIrKpD1UfNywODmY4wCEXcrqDGb6lUoV7z3z3IL7U1hBMuy0De76eKyjIsUtibiaibic0oicJich7X1wA0g/0','0','ovLBgwYrA3ucPMvwqgc1E-JMJkzE','','0','1474246744');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s27dI_j8WoC0wtP-u18Ysw0','177','昆明兰花网','1','昆明','中国','云南','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAfFsHG69jSPs0vJzwUicpxeQQhlGTHhmnDCwgdhKqRAiaC6CWQlZKnQ4iaJ1k1RuLvBRjvlErpeX13N/0','0','ovLBgwXED37T2Wm5IRzCozRxEmpA','','0','1480470589');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sw09lAl6YCHUHZt9P8QpAtQ','179','段皇后','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZgX7UianGJspkSZD9iaNQH1Sia0QibetsXu1ciaMftXrMcg6PWFNQLsBcSPt7iaIic2aO3wicR4a6DyicEFcNicZibK0cFDxxV/0','0','ovLBgwRIf6K-_qoEoVmzqb2qMa7U','','0','1473755285');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syx_XFim81T7KTc1EyXgcTE','182','龙波','1','西安','中国','陕西','zh_CN','http://wx.qlogo.cn/mmopen/x56zUNdJibnF2mKItqWAqtJQzDRp775FJ0KAklY0R8RPk4O5ghvVjbjtWIYR8EOwKUTHdCFFxG0IgKGXIbrDLZLicOs8UrGcKn/0','0','ovLBgwQ1HiFknVa8nZyz2bM2WorM','','0','1473833239');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0fO_XTJ9CRCB-mKaVdiCsI','183','van','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLCFFwbNhxLwHFiaQ5GJUdtgtoOxzmwT92jWKmvCLsvhT2x77VJp3BicM87PCON2PmZiaCJM4qqhVVviaA/0','0','ovLBgwQ1sHkuKzgRwn62r2Sz4me4','','0','1473851944');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_8on4I89pUrdmGHr-Q2R_w','184','Aman','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjvmVXg1AdRgkRlAtVLjo8HeYcwf9ChtO00lHzEXNN6HwYMPywzyr0vEGEZmC4RR1opo8iahMjdFNg/0','0','ovLBgwfu-pcVqIzZOP5DaqAPshGQ','','0','1473861812');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6w02NIrOjiwRSrszQFep7w','185','Andy·Zhang','1','普陀','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVYgNUykd8OickKaRr1uCL3c4YHiavNlDAYw48RoJBDteiccbOicFiaj23EV53kumGptpTuX4fRhMX3QvXcWQviblu22s/0','0','ovLBgwVjJ9Ol-yCNZF-MG4oXT08w','','0','1478001304');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_SXlyVmOxVTgc8Kmj5_Sg0','186','方振','1','武汉','中国','湖北','zh_CN','http://wx.qlogo.cn/mmopen/x56zUNdJibnF2mKItqWAqtP1K85De92Qia6kbHm5Aia5Cia96NISayFTKQERicM7Q7Vk2lgAtPrS9aYAk7hUpZbjnDAebtibzdKZxe/0','0','ovLBgwXLGtQzTp86jHKnCHVhiSi8','','0','1474245086');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8FkereKKLRAlp30Zycmw9A','199','闲拍','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPmNGeuAr861L7xMJV7Qso2Xr8I1nwLKGxliam3KI9eH7r9CRpTrJnhJLGdxojpSUjlBiaqrYXpc6dkYWjKaLpkC0KepxSMtqQia0/0','0','ovLBgwc9nkr5KVvzOjtBjjwdiFHk','','0','1474018240');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4fHFMlfTh7Dx4VcAc1rPYM','200','Randa_C.MEi','2','','中国澳门','','zh_HK','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXic9NAgFu4PvXl48meL1KHRjadplia0FU1dqAxA7SicEpt5OGJibAWdGhRaKWoZH83eAxia2diabXxtR1qqOP40jqSnh/0','0','ovLBgweUimkBWyb4YYp7H-YtPq-I','','0','1474360691');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s83nR-yKk6IHLqmbOSbARCc','189','滇西三彩','1','德宏','中国','云南','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqIqKJZ1bMofxlcANHrmmCExlu80rKaPH24dSJG9GIcsUIPAWsYYGVTjIoSMxiaiatV1NlGqcaBCYex/0','0','ovLBgwTaOA_EqcbLvu4HvNk80_9k','','0','1480908047');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxuLPaVYuSsToP6XiJP7hgw','191','目土土','1','吉安','中国','江西','en','http://wx.qlogo.cn/mmopen/SeLJmoK7uY5S4DTrXCynVraR8zlutmTv37IFAFQGqJy76lBYc0CjoT111mtA8cjp2PdicFx4TaWE4icBOtBuvho07wiaSRZCCmf/0','0','ovLBgwXzcZZEU0TuVzEgm1HNLmfI','','0','1473925630');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s391DF2Y8DjmVEZCVq76RYQ','192','12点30分下雨的日子','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZg9vw2hGKNOgtlsUfGdzcJqAkUqNrn1icT6creJwFYVcLmvjickLoyTzQpicuYZxJKN4FqUwnHPzslahAqpfChvBkD/0','0','ovLBgwdEr6qD60MNKCqRb7w_tAms','','0','1474856119');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3mC3TSbVInf432PSPFgWEM','193','緣亻分d兲空','1','宁波','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Ppe5guKIkHJ6QaichgGjvia4cJdbWoC5Bl9hjO6l7VqN5YWhFicF8U0taYQYHZ7VTYKibcgqf5y9HV6wQ/0','0','ovLBgwSnR4ZGgnCk8GEneePOi8mk','','0','1473981825');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s198zyUH--bwmPv7Qt3RNlw','202','Jack','1','佛山','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhGPPwzq9AzLasSNsYUPjP6evCpjquFeEO7vwdr8fshsng5Kq14I3XVOHPgLibtmfknFeicTZsGaNGA/0','0','ovLBgwfmlHFj4bca8KlcQpuB5NqU','','0','1477671354');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4FVICL13glrdcKy44alXJk','203','红魚谷','1','牡丹江','中国','黑龙江','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwVyR8Ctw03YDGy5g6BooQMSPiamOGJg33RYfaicA1TogHRf2Kico6qlZZVgicnZYPvI2vJiaMkHY23bo7/0','0','ovLBgwbHDc1I13e0qiiJ40cwh4s4','','0','1474295889');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4lSoQvYer15bjqr0srlEso','205','马俊','1','石家庄','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjUqwlklPMRrJ4TYSdVTlwxgSbt9o0LXrTVxBeqp3pbFvwuAxRM4hLgIB8rTI6NKjYoWicQzrsKYfMqnFTuSpSAF/0','0','ovLBgwZ0Pimq4zsMc7ky9Qzt7QJ8','','0','1474458356');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7T2CU1_EosMLSF5t7L--cE','206','王立云：软件超市创始人','1','石家庄','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEJD3Tdq8kGvLtVdyDCyIfw3PJichiahDRczw8Qggk6icroicy2XUPJibaFqwtWDsu0PKnMB1ibjuhAYb7fA/0','0','ovLBgwceqR7yzpOdbgIECfTH7CzU','','0','1474458100');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9r-2Ir6xwM0MzPWfzuDgUM','208','小刚','1','石家庄','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZgX7UianGJspkVr29nrpgiaTiawf3NSf8SvNp1ONKaHS2MLd7UWe27LEiaYP5n35cZ5ZhQ49VjJUSAoNWw4ZFWbZOlf/0','0','ovLBgwc4KLs4M1s1p9LHpx1JIFV8','','0','1474458894');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s69McmuSlRir7QuJr8DAk84','210','香藏家剑峰','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwbSq0ZXTGmRToaZKdPqosxHJBOWzHee2FAmGLTIlYEuoD6kuUKl5aMxJs0GKpCnq85XulnDWEQib8/0','0','ovLBgwVoMUDSxvFyDRvcl8ydRhGs','','0','1478495507');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szLv8GP8QR-xZwC-z8dvpUg','211','999。','1','宝鸡','中国','陕西','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJWocAkX6GvjVLCNHYtIs1fMt17Ec9l2QSzdVVg8n26VqgZfeR41IicJibxKey9iaia6uF2dbMAWjufkR/0','0','ovLBgwcg8S03gHn4ADerez5tIcdw','','0','1474420139');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3KFOdMi3AXpuSDlgT9uIFY','212','寻宝途网-张戈宁','1','长沙','中国','湖南','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia29vrYQQVyn4ViccssmBDPRQYHeqKTwGRwic9hIRCbuHnyoqvcJNEdGEheI6r07ZdLysfsEbYQOLSK/0','0','ovLBgwelZIZ5rJOeBYzD1GkPzACo','','0','1474426037');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2VUwS4WUkEt211v86jOFFE','213','高文(莎文爱恋)','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqKAHjEibd5rhvTCL1AuXvKDjNF8W5qfgY7LCa71SnHicCtcibpmH4fJiaiczA0w8IlREZb9Xq8CWoPM6z/0','0','ovLBgwc5_oiyHW0MFQRZYoCbzhNo','','0','1474427508');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sywWRWVuckY6szB4BokEC2M','214','阿笔','1','厦门','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLC6KicibQW1KmPfePpD0ARAykicK7hDUA2VvXnSyW2Lvj1VlicEuZwCOCNiaCC6dYMF31uRroUb2UC4Gtg/0','0','ovLBgwSowkAJVWdo6CNZexIcyM-k','','0','1478318024');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7_TlDYmzEewCelL6XxJOks','215','老哥','1','沈阳','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqF5nsOGM4HOLwYUvNV41oFJ1yWm6op3YVjPVSIt9sP1ORibYIllUb328YALfSltmtwhp85rZqvSx3/0','0','ovLBgwYIJD1Q9jdmLIYhi4jOO8H4','','0','1478249750');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swOx0PL0mAVj15_lJbFOiHo','216','13802560070','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLCRmJJHFMCfS9W9ZOof9uI7umba86kyCLGRQZUEsGyOxbHXhicycy9ytr0Or9nD7bb3apvxngo7UKw/0','0','ovLBgwd3vNp7UPGCiEk3atQJBTFA','','0','1474618407');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxNtmtUl3JGbyNhXwvfDP0E','217','越平凡〞越长久','1','南京','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLAwvD8j3TgEvQXwRLkRnEKblNibfSKRjFCAHJdnTS8iaUnfPjvwdlO9cNz9qJoKicxywrtWvqNWhSX8Q/0','0','ovLBgwaRlIGAE9F8j8CgmYERLyAU','','0','1475140995');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2M2RuVUkeV-x1nu2zRna1w','218','鞍山精品君子兰','1','鞍山','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoHTcuPicwwztIpGicjKkKMXn9ia2LiciczmUlgNgOXiaq4GWQd61kRiaqxiaKx2yJ3l6OwfIsUWt26W0icp6Nh9ic2El0ibaO/0','0','ovLBgwW6jofcAJVrJaji3L4SEjr8','','0','1479552022');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8dz8ndC6LM9wyuStPsWcBc','219','造福者','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwa4a7GX356FnDicwopgHQVqibpV0BibRJjjzb0bickexSFBCL3hfkNz1dhkuIZWFKJ2hVIRMBNf0ggDO/0','0','ovLBgwSJ-sSJ-Sl_-sdMOkDHP4yA','','0','1479552670');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4zzy9rbEC-XC-Qj82FKfe0','220','挥手云端','1','阜阳','中国','安徽','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbOBe2nL2aqmvs6h6ahQe3CAOnbNm1N1JMl6WZsABEm9qLlic0YA1V41hzW3V2dDr7b8pkM61OQYpuA/0','0','ovLBgwWI5QmCZqUolWGwmfb81ZiI','','0','1475378168');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6DqlMsFii3ej9N5cB_hx5A','221','L@达','1','乐山','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/Gicd8wkKey0dCia00nZRkeI1M6E4nfZzwwpTJ1AFj6eBGtWd1tx41d8ahBL0ubTmmiab6tk5N4A8kQy95sZmfiazuibfCJ99IrBRH/0','0','ovLBgwf4OMXbrCUeAJ8US51csLFs','','0','1474609502');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s01mRl7Q2xfWYtT2_dcP3Jo','222','子燕','2','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVF5EoiaHzsSH5BLpGRibBpxib5YO8jic09RK06YP1ydlOsH5LL5IibQmdFD7oWBiawRna5fppNSoPW3q9dC7mLk0iaBJJ/0','0','ovLBgwUoltbqJ0g5drWl6k_7eGvA','','0','1476844406');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5vgk9QnhyjAILNwwB8LElM','223','昂酷客服','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZj1jt6zWh02xQYia9Uh3xd5aNxMv7pYFLn5Z18iaLjZDYIkhqibYqpjriaibyL3FGC3YSRospiciaElhc2gA/0','0','ovLBgwYalyuMiV4hFpG9VNwlgPu4','','0','1479631635');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7Ifo6VZ5PhTO-oOcvPzNBg','224','中国红客联盟','1','九龙城区','中国','香港','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZg2Px3N2wPrAKxVPNNPKPjibkrqEkmL1Micf0IcQh0um4DG35ibA1jvLrqK1RqNuzFklEXXohBuhQvHDcBgicrSOcED/0','0','ovLBgwcfVSTR9OyORQ5rLX2rcbbo','','0','1474612800');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s08-55dqo8OxlCzuFsokv5I','225','闻过则喜','1','济南','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqDN8zxLJsB6sOlcXu74Uct1PRzdJ73Fm5ib80uibZ4BWiaEedOmQFHkqAbznvQtIyXicSgvVO89Stavic/0','0','ovLBgwRkpWAXpqOg0SWRpHKHXKUw','','0','1474786332');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s91MyqtLhL7D4N83V_esyOc','226','刘思海','1','梅州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXB5MxoUkqqLHR3KkmWa4rLtTBNbgQkPDgNDic65hMefjXZFwrgW1BQib1yqPdda2JZFc4DO8dwB9gtHCNVHQv348/0','0','ovLBgwcnu4rI7CD3CvrDe8hbBf2s','','0','1479886161');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s42KTNlVmYBWIgmGZzMW0I0','227','金翼','1','','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXOicqvlUpH7u9Nu2bJS0qt1z5qBib0I5BnLNxuodFjO4beYUiavbIDTuMsqnfwNc30uF5N0Gskp9YibJS80PmnIo3C/0','0','ovLBgwfW__hNgg47uYfOk817F0pQ','','0','1476515317');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9mzo59Vse2YkWicT3Tl_pY','228','房长','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6qwIJ60GicODkSUgHmoic6tTgmXlzCmw1icIdPtUSwdibbYIPOxeKp8UR5qSjyc3IK8BicMCqzIppCbou15srN5UEzceAONcjFPkN0/0','0','ovLBgwWG_g4CvNBGfGvqRt9i30Ms','','0','1474702763');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9xMkZLEjsA5aExTXBLcPhc','229','有无相生','1','临沂','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJfhiciaoJsP2ZTzBZoMwFLErVVUNGMFTZOicpkQVwoveicmxybFTtS1d3RvIv2oTo6rACEkOwWR75ZOW/0','0','ovLBgwSsS01uUSxWq8-DXKU0_NtQ','','0','1479950401');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swznQeo_nce-ELuNhQ14HNU','230','二串一','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6ia68MDUNBP33Nhlb22QuKIlyYvBWcsscAqsZyD2L4eibwgo6lOOkdJgI2wfXiacvhT8cbr1oKSlbr7J8wU2M30Tsx1aTib7u8ibtc/0','0','ovLBgwTOx7RejDGLpIQJPe_P2oP0','','0','1474766467');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3l4_U6V95QKM37DNqU37WM','231','Ryan.Li','1','珠海','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZia3296eoRgdUwWopXSDo0PKjrpLYjIMSMVBI0QNqY7T1gicFyzqyqGweL5tcpyukZibp9ITf3ILbD8tdFNgicB4xZ6/0','0','ovLBgwWv3Eo5_lUUem7smj8wL9Jo','','0','1474769798');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_PeEgziS7v-EJy-wp44HEc','232','玖月又拾玖','2','昆明','中国','云南','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLB52lg2oJQYicqsZG2EZXHhCzt1K1hEECglju3oPEicdp2zmp8hH7aVibEfibVibiaUL8uykw3XglicbE7aQ/0','0','ovLBgwTNXASciNZbgJqSkRJ8Vxc8','','0','1474774302');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sz3tJkmE_l4xcSMLquA0KLk','235','Spider','1','江门','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/j168eYib7Sbyyj0H8rOHH1g0hswkn1t6WaibUk7fl94EA4wCsZTn7QBtU82JeFE7radFcvkgp5TBLSeD5cWcPOfribeYx6fjHCK/0','0','ovLBgwZ3vLA_zX9buFXhh2kbX2nU','','0','1474806898');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syXGegkpz-jMcIDlXOwaaK8','237','星也','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLAhSqicak49UmKMazibK82YiaIL9ia9en3YibQlSYxkskPNca6YuPtIEHNFHH6tKf4XwsdgmicG9wIA9Bew/0','0','ovLBgwViUIblFAzDMZMIN9SUFY2E','','0','1474877030');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_9JqjSOD8mR_N31qxZZqEc','238','A睿智琥珀腾冲总店®','1','保山','中国','云南','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbMCAVlUAicXdt1bQVC9lMMon5I5T58MdvO3qOjcfwdWHQoWb3ceNnFc5BFIbjicwKZ76nB4JPTBvmvaa1T4pNYRuC/0','0','ovLBgwQTR3mdw0-tSvCG5JkJyYBY','','0','1480005676');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8Gs1cvMzvBr9gvmuFUz1qQ','239','nynna 去死海咕嘟归来','2','','','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqHFea3I1CbibiaMhvyzRqq9dOd1tzMD6KS7KA3ygs6Pv0uxqficRLXtpHhQgjlibgdv03Xbb20Xly3Uk/0','0','ovLBgweUkzYc8lkypQoFjVzTK_H0','','0','1475019676');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9Tkkn7virq8rdHz2sNmvyg','240','钱健','1','苏州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqDX2EicUFOuNd9zOMYsxXQhqomGxLBHVqLp4eF3lbg0yDvnicQDJdicJwY1QSpDFeR9Qxgib3u7dYcgq/0','0','ovLBgwSk9bb21FGZ3pp-VNXXKPWk','','0','1475123255');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_UFfIdrqaJ5yGsp5Fu--UM','242','明宇','1','哈尔滨','中国','黑龙江','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLCibPa5rKyNPdSmGGEwoaWn7H8QEAOa7iazE9HkRkYBhQRNma065wtUwgbU0oVrDhicW3UjKV4J11mLw/0','0','ovLBgwcPs394bfyEvA-pCqDtujQE','','0','1475138920');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6jl6sGFC4jwDj-GTfyut5E','243','李波','1','东城','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKcwXt9lbb3exiaV0w9t3qR1w48icnQtSNqB7Dib4EgjIkNMA4KHxia0P4ccRHiafIGWLqflbicBunAOOCQ/0','0','ovLBgwfPmAr_0A_rxPkb5tsSw9pQ','','0','1481092850');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxIB-uEF-BsTY8CqK11O7dg','244','针灸疗理专家','2','金华','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaELF15y1UJQIOFXrNEx5ib8rI37JlicNAIic2wbGbI7Jv1H8SmpwEPibgfn3Mzt3S9AR6pqiaLWVufkWxCg/0','0','ovLBgwQX4WmRlftc7TbRDuxoge7Q','','0','1475222526');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swVFrffCcvGV52u5OL_UZj0','245','A徐州起锚网站建设～吕','1','徐州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAZuzpCqZYibvXpxA5ys4AV8U5KqsLhJiciakUJlOCOfF7h6pRrobff0sddvBhj8icr1a9f2YibqVMG6LW/0','0','ovLBgwaeS-fcM_Bgy2yOTZTar9UE','','0','1480164251');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxFb7LmD-_42m9eCoKWh-A4','246','汇通天下担保交易平台张先君58个群','1','徐州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwUvDtmlqDiaWzvlWX4oYxSOABlGQJq4pcoNI3Jnde4EQeXR7HXANWUuiaS5MGBAdP99XDx9ngSxGj8/0','0','ovLBgwdup527Itzs40kkOgvfuhZ0','','0','1475229497');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0lUropri_YbEnIwuRNWiek','250','聪敏','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwdgW7pVu9cK8LbicY62wMeJpWSQ0QkCiaHGuuHeGRNHyYJmOanfAnNYa48U591U4MXsCkxwsbasQuU/0','0','ovLBgwasV0pb86-_oF7WlgKgGXuc','','0','1480474739');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxVkWEFm9W_0UJdu0YBX160','248','卢远','1','长沙','中国','湖南','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEIJd4yy5Ea3eChFplF6DBib1B1espzzDibCZe3z5ZtqhC46icmSxtyseIb2o6wrnQBWWyfK1e15Cv6bQ/0','0','ovLBgwV8R9hyzTpODfYIkabnj2R4','','0','1480633929');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6vHzJTi1Jf4CwU5oJCo6a4','251','老少','1','海淀','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpmEQNJCvrADicsvA2FRe9tDrWTsD5B6LJsoYgDwgqqjOX9KZCIfaR0yp1ZUQjCYeuqhPicup5NkWcw/0','0','ovLBgwTaSY-U7_SW2q-MH2QIqip0','','0','1479019479');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6Ime8m9vyuInMyiMR_0rTk','255','peanut','1','江门','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoY85UialyYgBjKBzibmcGflWhdcxMIQvl5fUa3VNdmne1cknDQFRsdp29iby7cQ3fmSVagRj6yxQHGb5YVYjQW7IO/0','0','ovLBgwdqzcwRqLrPMRohaoBmHEn0','','0','1480642359');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szuE0kNY5-MF-RO9w-m72eY','256','如鱼得水','1','南开','中国','天津','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBe9NwWecpUoYpFZia14xuBNlMn00ibo19vcV1FEh583n76XsLSQKdEPm2K6lRYcUmnMHD1aSeCy3YQ/0','0','ovLBgwfG7tjiU6Lyplr41LC5SPo4','','0','1478152095');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2btLC8curNmV6_Fb1OT3iY','259','Balinda','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqPyUeCXFntoQHOSqDPX5TPv9Xvia8yuFnbN058UgLbiaBwzHNBtBRlFH8wFhAGKDKuFS20oW4ZHwpia/0','0','ovLBgwSjN4VacfGQlkL7JD7QNFws','','0','1476162646');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7bcMEukabEdmZzvWn8F58w','260','杨昆','1','许昌','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAeJQrFtsMyMiaT0VwO6Giap395YFoVq2V2GmOHjxrJ8hKXb6a7kuNBEev9Q2TTWsydDw4dAiaeKZwPy/0','0','ovLBgwUMp8fvNcE1qoo-deCPyfAw','','0','1477135405');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5nQaOXg65t1unYKR79DiCk','261','朕','1','信阳','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJVAX2qiahY1fVVGG82wSH2b2OVpFz7fjHJb0ibsT03zInpa90StTznibrr00oZW2sC3HkOGqxW5tQd5/0','0','ovLBgwUZBzvNV9PRu_mEq7jTY02Y','','0','1476161616');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-Ocz04PFNiBRQUo64PB0IQ','262','小强','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbMjENHdFZXaMhtPiacekPH5naRdQzCIsDu7JYMicYVzqLAPk3Qb9hrxVrPKZjRWySTdLXEMYCuVDRK6em6ESxcc20/0','0','ovLBgwdI3WayYuYTfzmc1Ek22kho','','0','1476162921');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1Y4l69ZFBD6to_bBJ8hNNw','263','蓝宝','1','揭阳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/pjicwtoYSoor2D3AhaFJibrDhZAd4Jf37g1dtkU3EHLnULP9icJB48BhoRymFawcyXppLU32SJ2pvia6uxMOfVrBnRjLl3m7gaq0/0','0','ovLBgwVlnsZd90y36jSzixTOu8RE','','0','1476170691');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8dkoostRB3nWxxa5LgJlPo','265','汪聪','1','杨浦','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwTIb6iclfSqvcSPQKkribyanjfXJvrSEAreux41Nicqf7CncOz6McNZuYJow3icJzXslZYzTKr1miaJrL/0','0','ovLBgwRMaS-Pptj98bEhXdsqqy-E','','0','1480954530');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8IiYjVMlSmPWjPbmwcuXCA','269','YU','2','','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZiaJRqIOq7q7CjZibwPaIysvbUGuLP8QxbvMeB6Z7EUOUVOQ2AGgYlZRxqV8xtWLhDMfbbY0qbARO3lLAkic6Q1TCF/0','0','ovLBgwYVcHPyUkr-dkiT4c3ehYvs','','0','1476242365');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-AlS9FrduUT0dVdgoCnNug','267','Jason.','1','扬州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEImvvvrsylbIMBcZIyezqrmWPYA3eV1ZohqicBOKcWP6bLwSqGHuOUq3wkRIibUYptfdRzPkb0vUMug/0','0','ovLBgweFz_8Lj6pRlcfM0_Ap0wBg','','0','1476258002');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2_E14W5MivOZo1MKjSVC64','268','乔仂joey','1','','新西兰','','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDkuibeIWbzsHbPVyCdibicwWcmM31uGFjySxptYPqT2DuoFhic2rLgZPugcVJEAuFIbMoPAk5NB3qpWtiaCyRJKb1MvAgj5MKClMRg/0','0','ovLBgwX_FejoDflc23K314hIAed8','','0','1481018577');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0dEsLYQb5WADbbC1mPKTsg','271','林羽凡','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwSnb3VsibYiayUd4PwXxZysE9UnCDgiaZ5GgSASFHEfx62SWUnFsJiaeECWL42T4hslWKaVA5e9JR9G8/0','0','ovLBgwQt7HCRoifDuY-lF29SJqL0','','0','1476255968');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syNfS23LkxiRre88POpIYmQ','272','徐宏兵','1','南通','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLClqCAjMa8UzrgnMKwictJsTnQSkVtm0Mw5ZmyTxywibWg6bNHE6dqsJREjgtPbaQGoyZFZ1CXKCpYw/0','0','ovLBgwfFhOEZKCX3lWHVAOBhF-M0','','0','1480978209');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2hT8Ya2RFyy9EO3DsDaOVk','273','木易','1','','','','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPAicicTo1E8yDWo82cRku9NcqE60QMCavlgOCvV99h6JwpcicSzMuB1ibFHicjZI3YKV3tQhSiaM8ZW4RA/0','0','ovLBgwVHcrtT5b-7PeWjdmBEPVw4','','0','1476261009');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swZH0DmO589NFwN-abvWox4','274','唯佑一鑫','1','合川','中国','重庆','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PrlmqHY7JIg9fCs9y38Puia87hMysrGUbAbe61ISW8qbIZWvLncYAlrpSz8nRSYX9WJSNX8w6EibjgJq4lr7iaTEZd/0','0','ovLBgwZAupTx1CQ4IJMohSmCPZ9Q','','0','1476268314');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2L3pN37v7njjgr2x_47C7o','276','海诺风息','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZgLn7K5ksGUIOZy3kM1Wn4Km1bGvEibysKB3j4SpkmlNibgumRcEWeZGsDcAwgLp24ZNq8rAa7wAoibBXScCpibzAYn/0','0','ovLBgwTrBf_mR0bKXqJkN-fHHeqE','','0','1478307667');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sy2_7QqWB6YZC4NSMWXvf5o','277','【WJ】????京哥','1','沧州','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJerQqbXV4V6ad3mqZRh15ibXZLaCTmj4DUOGdTTdzaU98AicRf0icuKL98ZfJTZd1HSrbZC1cRZicJp6/0','0','ovLBgwX4WnR8HBhYSvJAzCakwrso','','0','1481024789');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2h3N_ZOWEyyFNMnIGCAZAQ','279','空军刺龙','1','海口','中国','海南','zh_CN','http://wx.qlogo.cn/mmopen/uMop07Sic8PricdQm71ic4DkeUuy4jG0DsBLIyaCOo6jLCiaxFX6NJCC2AeKeyZT444Ls8Wacu4tXvSXBkTIx4eayNX8d8TxF3y2/0','0','ovLBgwfLo3bIyal37bFHNI6FOWGY','','0','1476351632');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5gQpntD3JYO9NnZK7bQtZE','281','匠难_文杰','1','肇庆','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbO9JtEwAnJ5kT2lU3quSqcBmhAbRLSwcYbONPB2AQVL6v2ANu1PEFDiciaibA0mlphicwP9XFcFCu6gpl9gWt1w5icH2/0','0','ovLBgwUmbaIVjIPE3huLaaaU5IqU','','0','1477048701');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2ImWCHvjLkK4uLztrs5z5s','282','APP设计推广','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjGZjLI0UfLWiamdMb8Y3Sia8JErN4u0Cw17BuOf5f6EgB4sWtJPnCWHLOHgwCvym52RRjMOOicb20k2sgeYuibEciaO/0','0','ovLBgwVqVQpKNhS0bUUbI41_6zwI','','0','1476944130');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sx4m16zXGHNWsLVP8ntvTuE','283','爱琴海','2','沈阳','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKwDNxQfn4136oSVlx7drvu5axTvTB1JObW3DfbTVLEBUwslkziaoWsbZsqHYBrokMy5KGUHWibrEiaA/0','0','ovLBgwaz3_wvLzyaRlquP7dhzCsM','','0','1476519701');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sw8VpFgcP7lrFt9vS2nYTnc','286','胖子','1','西安','中国','陕西','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwYMkumfEuMKdl0uibAHbXUPr5XIjszXUoc48RIwtR1niayziakw9YgAeqCzfy4g7UdSXN6tyaliayAso/0','0','ovLBgwSzL3K08J9ooqV-Aqte22R4','','0','1476603117');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5pt9Rh-u_wMUYpyd7cFG10','287','A0雷道_互联网产品技术','1','石家庄','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAUibqCdUichA3Gd228yq8VlmUkJAYyLhpImFKo8eKh9ZK7CADcBUoPsZuBkpqVOZDJQib6haRUGdv1R/0','0','ovLBgwTs4dNGzzcHgGmWVW_djjzU','','0','1476675525');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2yNNjLCvlCgQIgY1fu7gZk','288','策划者','1','青岛','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGUVZxdHP3jGTHzrwx2e2okIia4EAqQ2FTV3P44fuIshpohQwblKZSLU03dcTYG1cA0lyXwHqrICXKdPlwgYnEC9X/0','0','ovLBgwWkJ3YCnQsVevzZauxALEiw','','0','1476953638');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3ifECiBCdEsFg7ElLn8Gm4','289','杨华','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Pq1sbGtjhYMtxibDyq6NFTuJrskloowQ5xyKo62OazGSSoKjt09289qCSa1e3GgALURHjwAV4dbicQvdbWEhoqsmD/0','0','ovLBgwbzGJ3GYbWuLkofQdJC_ghY','','0','1477446269');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0GgtCOcB5xrAkHAiP2g_UY','291','primo','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaELM8n9J1fL1oSzjStZRNBXdcCLOFmcLMzPDAicRtFZC2tPsSibm8S8icqqOLagdfvraLeaicqsxaFNytg/0','0','ovLBgwUWeMJ2JPHsQ-Tn0EAKXBnw','','0','1476843744');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swd3TCWsW4vsV_MerchJMKY','293','鑫仔 ‍微信超級會員','1','昆明','中国','云南','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PrllUMP1icyicehB9U4iaH1WgMZjvxD4rNMw92K6dicMIlic2Te1vaicJawErEHyelqQVI1Auia4VhVJ6EoQ/0','0','ovLBgwQC7U2sxIqTvlFUnx5GrBfU','','0','1477124484');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0rKqFTZLAr2Tushv3dM2sk','295','荣大松','1','桂林','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjHL0FyXC77vCACbMOQLb3Lf1s4icz9cwBT0sPuQAuyFibevMIcHQZVeAgezibCiaZvxED2lnibNTchs5QRRt2Se1a3l/0','0','ovLBgwcFDA8NoPWP5F81_k8U5MiE','','0','1476863517');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9V9gGuYFLSUIk7xHiksNKc','296','随心斋画馆','1','通州','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqLNygiazdy8kzoN1nU7ccKicA1danNMbUJYMVpibrOQlfX6yLvaRRk1Lgc6ScSFibhnmhcXKAIKxicobf/0','0','ovLBgweSEIg93Rt2hvy7eT1wV4RE','','0','1478095487');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0ykJt7Bsjwt--rUJAuuEu8','298','李雨航','1','昆明','中国','云南','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBPYf5ZBBmPfaPib1MNuOuwmdx0ZFoAfzFzBUBfDIJUEicPmexoWgb8icIn9aw0C8ibicSaxOsTbbTyqVA/0','0','ovLBgwbTgcSgsMf0VbsLvUrGWXww','','0','1476867637');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szP0l_ENsj9LeReYMuc056M','299','带头大哥','1','贵港','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqCW1PTS6uicvZHZJiauBps5rkP9vM6EeiaNqfnSTiagzaKg9KzicEXbTvr1HUj3PVaLnkUmEXM20z7SKD/0','0','ovLBgwWJBGpbRlUcKvUnVsQ2foQ4','','0','1476929132');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3XO9NbKz13zXN84E8mYkRY','301','小楼……段','1','宝山','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFweJVEfX7GxEE9LcpJXWdFM9KeKKClzexzk1xNFbZSMrnibqjOyCF1BZnqwDFs6IQMJJZpp4YicONk0/0','0','ovLBgwaTsTxK0yqv0QkJChx0ov1Q','','0','1477047047');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swnZYTiDlifjKgFGf9lI7nw','302','文杰','1','肇庆','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PptVApOMntXwib1WvyH959jDVHHw06BYkL4raM5iauq6YwZJ6OIibib6lakLY5siaotz2JDY3xfM0NicXkCEyq4d933tq/0','0','ovLBgwR-y7rDT69CVN9J1mUjU8GA','','0','1477034306');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5-gu5a4dUp0Xcj9i7dDvec','303','坐看云起时','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVYgNUykd8OickKP0ZO0B7NvY8QJLvcc62nrWSASTRRliaEibEn6n1q9OXn7wlRrs3zIgeT10Y5x79VwxaITFoibJ89/0','0','ovLBgwQI-yi60DgvGgXL_N9jBmsA','','0','1477464352');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3NOb8o--lYB5xMSK8Asni8','304','莫   忧','1','三门峡','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLCpiaalllt597n9ib12mkDkXhcKusZwVl7nSjTH6DCylibcfQXcia1icbfbpjDNR59nC1z3haVWFUZj6Jw/0','0','ovLBgwbV-_Q8Gb3mfusf8s2RsWiQ','','0','1477044227');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_LOCkN20EvDiGX97xsG7Ng','305','梦想成真','2','新乡','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwbcRW3m3aUuPaTR2zRwhXACWd4Jkkjic3ayPNckjic02rWllPYxZGPgwiaEpIDcwFiaJNAcrhcoaiaEW0/0','0','ovLBgwUQT4vBVyrlmzsbauwgrXRY','','0','1481243682');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szafYB-7le4roQdaOrdgWxA','306','影子','1','台州','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia1TuzNibUxExRQlS5IYVNVOLIibibCXcjyh7yVgDIQOSCMMSEpSc2LpySNx5aUKZ7ULH2ZBI5U4jDKW/0','0','ovLBgwUE84fJ-LFOotX55HW2BkIg','','0','1477048953');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3M0HEvnIwmzzuCRSBu_Nas','307','京','1','威海','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAXNyUNHN3ib5pucibWHgyntbxXdEVickomT52iaCtjY4PWuTzt4icbpicpr1ZhPNCiakxuEqCJIubqYSlWx/0','0','ovLBgwZ6rlHiyLR2oVikuqY_ZJyk','','0','1478312265');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4UcF1HuFTJQZArZEEZfZKs','308','程威','1','菏泽','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAbwG2ETzLl8BVCjsM6BpLoGKpibntG4B4xy5ibAVpW0oWv4n8dicAc2jGxM7IDr39nRRNptYVCbYkxG/0','0','ovLBgwYLBsQdqh_R1j-8mVU1OvNk','','0','1479485081');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1nLYOY1cJjuzMUUZy_5hFY','310','邹鹏','1','岳阳','中国','湖南','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAWicqnWHmc9ibv23Q0qIpNzxYicic11YrfyWcsxwpDbDzHicCXe01PJ9oomOCHQ4aSpa08XTw4VUbuhrs/0','0','ovLBgwXv2eqTIZrB_X2znat_Fzes','','0','1480995450');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szkPWLB_l7acoxQUdVo6FQs','311','赵志强','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqNIH7uXialDialDWx1ACPdUJImicZ3tl0uzicR707uWvKuTvAib5usMajOR9mTNpWjvxfjvFodVQT1BHh/0','0','ovLBgwUIMuzjsD9p8OAgpryJIbrw','','0','1477458524');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swD-EkAKuH30H5HrVLQjWS0','313','辛路','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDRECWQ89IooQHGHLpFSM34YibnlflCWZ7BQEphS5p88IEDJ1ngccsDLyceGiajffD5sIm3Kic3nDfNQ/0','0','ovLBgwQYEIpTa9PWdLCF3CflZIww','','0','1481269160');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-B5sKXLuTc9XaZbBItIg00','315','地底人','1','佛山','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/x56zUNdJibnF2mKItqWAqtBCiaA3k5J7chlUvZuBEMxFoeuhaFhDZibYXqjYrsgO1l9QQBr9ZuqQJ0lrh6W0TNjOjBMdLGQXEtF/0','0','ovLBgwUyj8VeaT6_AL-Js7DIyN5c','','0','1477201754');
INSERT INTO `on_member_weixin` VALUES ('oL2W_symdwN3qIsPYucM74CXFlh4','316','美丽热线','1','丽水','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6uaMWKAWeeJ20FjpzjOa29ibBx1Mp739Y72Rc1yMLxQYoPHAqO2icnndRt1Up1ghNHQEncyvxtKDjMxXbVlLl1MOVLO56JjWEAw/0','0','ovLBgweI5ygIWE8TqIhb7V0skEX4','','0','1477208916');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swyEmnhq2aX5wa38VXVq7Sc','318','shg','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwTABwM1vOTFwaic07YuxjfzwV9gNVy2LHdTp6vWXFStiap2PvIOZ2SboEYibk3BskwuE56VoBafAx8N/0','0','ovLBgwR5OaXkuhn6U8WTUZ5KkTfY','','0','1481026469');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s64icrfscV_aFjR5XaJ7wGU','320','bbq','1','唐山','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAc0ldic72FUcStKanKa72iagTXicUp6GAaSLsGxABFJsowwibUqxayZuxoyOc6XIfumo9n4QShzI3QOt/0','0','ovLBgwW2KSFF4ahcSjho0zj1zt6c','','0','1481241738');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sztwfKJgmJiafgjfKrMhaVU','322','Seven','1','大连','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZiafZNovsqd3DLEMHzF98Cso0WtuXXz9nAesRErjiadNVMWJj2nT6LRFickOQ4WuRljz8jVhRxxWU9qQ/0','0','ovLBgwa9suZjAZX_bwZOV3y6x4FY','','0','1477447446');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7vR98m__f-81x2864S6L1U','323','李保山-千里夜行貓','1','西城','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia2VlaLnqXV6XXkKFlEywSJAJOUlaON038qJZtgruD8dX8iaovxJIsIu1WXthMPMtNPoulaEVibqdlC/0','0','ovLBgwaGmM-F2LrOfCW-qIN4zSQg','','0','1477458432');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_sN9mqNga2zJNH5khqxnPg','324','雲起樓主','1','济南','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpcBaOxpibLvT5GJJGk0JzClTGHDt3xsMuxqa40mBwJ0vCqaLltaSNkfYOgJdQ2fPgQicD3gP4JLAz4ejGvb1tlKic/0','0','ovLBgwa2UEvo1Ml_DnD51A12MqQg','','0','1477534218');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5x3m__v2ZpUjAtyXEnAYGo','325','Tim','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKKnk9soekZXYJMjba5hnVLNRN2yCibjZpia91Qv0f9iaHqhVpaNwpB6RPrHUNlvQQ8N1kAM0R65tJmw/0','0','ovLBgwSHIczCQ1OG5A5BE6kEqWIc','','0','1477466077');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3E9glFU1PqimP730Et-j90','326','Set me free','1','成都','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/uMop07Sic8PrA3LibIdlicBouO0Z7zGa12g4sibesib695h9smC424hcWJ6M0KDDluXlGPvv8k0ouVGaFQ2DkuvxAdQNTEnI6NdYQ/0','0','ovLBgwVlAcDzW1LLkZpKwcY4PIo4','','0','1477982755');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swQopPM8_fayPlg9SJ3vE7s','328','Urum','1','虹口','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwSKyPqYww4iaTu7WrdfBQ24ic5JA30qqn7gtEJbWPoWamEhkXWyIESG6Licib9d6fTyGbjPbqlgS9SYN/0','0','ovLBgwR2xIjuTP-6_Nafl2lf_OoE','','0','1477473702');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxLrl8iCgrPkSZDPbmV1-Yw','329','小岳','2','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaELJwAF4Y3LSPDLTpsq6y7UdVnyoAdJRP9IUicicWa9947ibWuWR9rHHbQqHqFnkfKD1qI4tVIjFkXk9g/0','0','ovLBgwSaO9yM377b8UlhnYUuVabA','','0','1477525815');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-uGEQjJ4mziNSL6NUtT164','330','微盟史吉元15066450690','1','聊城','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqDalLoPu6txHZWK4h5lCn0GW6vPhoZWH8rm0Cj6aibNqYuvJjAI7ibn7fPicc0AnCsKWFwUickrS6VLq/0','0','ovLBgwdm3VHftTXg4ko0CVR1P6hE','','0','1480813378');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxb4UAshrsIzX4OlmNSoqIw','331','微盟·周凤锐','1','聊城','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEI3KFoiagZ9HFv2aU8rzJGickqIibDRQqV7DLUAscxiaIXxHyRC0jABicZA1rKkwcxfd0gynmmcTnYhDpA/0','0','ovLBgwZE3JWljs9V0Xe5ZKSEOM8U','','0','1477484217');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8GIGfgq0uD_dUyUZ5NOGoM','332','Tschüs','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqNTvre66znNHibnaJH693iavNXNkE7S1mxk820cRASibGYBwgx9WcXWXIkgmaSC8C6bUibsPszBUM0Bm/0','0','ovLBgwTFke0StW2KvB2aKinxHNSQ','','0','1477490718');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7-B2GQ5CO7KZHqFgYgnBYk','334','[腾讯微盟]王迎','2','聊城','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwUCDRXH0W2dg9HH9MriauFOFkiaSucA23TpHbgTXsjGy28ZCzJaLV4Rw0fUonwgCEialdleUGNsIq0S/0','0','ovLBgwYnIv-MMM8UlnJLHuTqHeq0','','0','1479209930');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2B5F1LXnvRwDhSojElgs1I','335','阿泽','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBKnicJvzsj4QmbgQCBgpmWY8hOeAn3MMlxKLjm5lf6Mbdvywu7pHtf7Lyn3zfbFBrEWAV2e3jAzfA/0','0','ovLBgwTrjtq_QBMq05JxEYQpnh_o','','0','1477537549');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szkVjSaQHRx4vSZWfWlVVjI','336','萍萍','1','郑州','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoomQiaF9GQjb0a61OONLr2hjdy7ruWZARdeK7rZ86U2l1WFibIAiaqeaFWWic4jstRtXtVEPbh9pDEN2vOjCwPqmiaX/0','0','ovLBgwWYKYJZ_e7k0uFH_-KOAbkI','','0','1480122322');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1UwKA2OlHSGkGSCGbY2eQc','337','安福百事通','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/WBib0zavv9jBU8l3sluqKWrz0XKPJQ2zcSdsBqYhaOcPryKstK3BqbhmMG5EibtVMRHhGkKyj9OVOWM5Ns5CRpO9qArLTOdGUY/0','0','ovLBgwUFbMUu69ZNkQol0So3_BDU','','0','1478791775');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_xndgAoREdC3kLAufOWO1I','339','高沅','2','日照','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PrYBZ76BS1qdUCuiaKDIjUcqzj5IJxtugibtBFPspdibYC2ZnAm2Sooo2gGpmicIgDKmfBpHRa9hA9lubeRxd3jsQXU/0','0','ovLBgwdfPLw4YoNDU_xvkPi1u3JA','','0','1477633646');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6xXEfmi4VSBrK4dkSwplE4','342','艾龍','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6uaMWKAWeeJ20FjpzjOa29Jr7GcGEXgedWFsmiaEfcbdg4jHAmfY8RMHHuQGa6oEjeyasWZ6E25WRXV1jQXSSAfKWReuS0byh4/0','0','ovLBgwdBnflyuo8tAWnLrEoXlp2E','','0','1481128406');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s87XHZBZmZriQscS-15tY-4','343','雲在堂','1','福州','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbOW3X4UM3yA6CziaBh52ibFjicQ01DSeibgnDczpMvg3wMulfK70jZ9xyia7vGFhw3qS33CPl93D7c3ibkQ/0','0','ovLBgwYT48Yh3BhDVzhJbNavTYJU','','0','1477797174');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9KV6eN3Q5DXQ5ZkdlCnSU0','344','黄花梨文玩收藏余','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwWhytiawou2rjsrQTL9zM4CT7fodGIFrBt1QOCbbYGFcHROEv50b3QT4m5PSPf8ASexlH7U4w34vF/0','0','ovLBgwbXAMY9-OznMTKH36lzlyXw','','0','1481092318');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6xZgTSVs-y7aAA2ms91Mzw','345','稀缺资源','1','海淀','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLCtriaAeLVyDqX3T7MxRuos6BkbibL3BMnf1nraFs5Ie1YhwPbibiaLDgREyWicN2icuxYvVMa20qbvuaEQ/0','0','ovLBgwVERaAwWj8Y1dtsa4h2N3oY','','0','1477817334');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4zsEKCnJsmSf7djekEwgbg','346','贞观国际拍卖(国际品牌值得信赖)','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAQF7lbZFs5EHRbj2SlGMY5lumHicdCfocsmhbLN4bxhl4oFUck0PWETCfo6I940ragKDpD9DhRYuN/0','0','ovLBgwcjdHpHmNuW1MIRrFT6LW2c','','0','1477822418');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1WOIK0MF7kz-rERSDRlm_o','347','kennyluo','1','珠海','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLAIvkiaxg3eKYUNNzJQ3nzWczhR0icSw6nD0clpCRjx0pKdjBWsPZRs4lVvyjfWCUOU6iamdVkrUiaPriazR7m7NBEhuJchyjwfpCz4/0','0','ovLBgwS24SnXXXyZxBCXK9J9r2P8','','0','1477883991');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-mEREweRlUafanRsoCPro8','351','Lee','1','连云港','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLApo30XoM2K5MPia6gc6NIxAVZuvM7omKGic3beAXowGO9KeshVFOfleCYJkG2cqRd4g2PvuaMiadr7w/0','0','ovLBgwTsm0cVqH5kPvW_X9XjaQUs','','0','1477965058');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5_O7JLMT1Qw3hfkpk9FcXQ','353','赵金明','1','哈尔滨','中国','黑龙江','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7iayNicqbzXDAfmnuzInXE4jX69ss4Wu0dPLfSUCjwAIhjbrZgCvhHlljfbUmXfFNVdnXCBYtu0cSR5/0','0','ovLBgwZa-QRTN2B7-BBXhNdiEeqw','','0','1477972300');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syvH8Y4p7wfDCzJ79rbqrPc','354','','1','蚌埠','中国','安徽','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGUGbMN5fPLT9dwBlDVYEvsWx02KiahgoyQ6p3y6vuKXxYhtdZXy53pVIeDFRfgG2ibI8HWHMWYQW4ibIj5RDEvLkhD/0','0','ovLBgwa1QyEOMSBW3QKYpyPzpxr0','','0','1477994983');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7xE4X3qfHhH0K7l2iUcH7w','355','六方银楼','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbOoFQlWWmsIfh17YwJ8ibSJr2oGcqicjHcvicSRVUQZdBTtepcKibX4ThVDV6ZTXnvEoaBA0Fa992KbibwgFNt6YhHDm/0','0','ovLBgwQlD4Af-sQRsgh3uXgbWiYU','','0','1478056231');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0LwM1yldFg14zTfqBwzrS8','356','张卫平','1','厦门','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbO5ok0bcZQRhxVt8qfNGibpkHMEZKEyictbsnlwYaZvLuHXcZ0CEln39W1AroxllmpWVQoWADtW9NXQ/0','0','ovLBgwV4rdzNTgIgx-duI5UztTe4','','0','1478244580');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1G6K-YyTh0rRI539zDqZq8','357','Nora燕','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJbYubtUMCZFZD6icLwd3vw4PfUNpo02aIXdfmdc3WOgGFktchhJ5qj1FULZHTrGRACicjcKBEdSYSG/0','0','ovLBgwVYFksUWxi-bX1k51VOv0F0','','0','1478092481');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3UprhKr4n9Oonjz5wDpqhk','358','领航未来','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqFDYMlKTCicG6BKk176giafib7mOkYQ85ERvicZFGRy9L4w7YOmbSibRVUkibW8K2Y4ibZk1CuATdAibxRYt/0','0','ovLBgwXY6KuUfT2p1bJV25xeuGZg','','0','1478102151');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_i_nOMKvR36NZ5AnAPhcmg','361','安特李(荣平）','1','温州','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEIZ4ugtibNjQicoGvdRJqla2v6gzycvl1CETaiaKg9FcLKXEib7FkQor1w5hiczANgNR8UKndb2wAyqOAg/0','0','ovLBgwdPcITMAWDGY2AVXMvSsxiI','','0','1480597767');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_HhoKAUlWS8VE790dEw9_k','363','A0网站建设','1','沈阳','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM43fO9kD0wNKXnzkMgFG3FzcBdEm8yRDNow7U9Fc3FSLetwGEE81bSZdGQ8ibcgniabXVUbuGQXT3m6ia3qOYxicSN1VHFrvBZmG6c/0','0','ovLBgwZGjXfMFxyQai0otk-Fxk6E','','0','1478150295');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9e353ssW3Wf7QufZRUqeH0','366','༄Hi-冯先生༄','1','常州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAUyEN2dWODbMpg1HibupI7b7nbDjdc4NbYKxMvFIAiaqBoQpjWQRuVUlkLd6RX9k7SVmplyVOESNsc/0','0','ovLBgwRJcavMm8eV6GD8ZWdVKsSM','','0','1478241062');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2r6Xd1zCZRo_BTSW7JNRQQ','367','木子','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoomQiaF9GQjbwel0AIU8T5JibMibZRJ6M9TteoHUrf0KY63Ebnz5c7kJsu7keYM42eiaxzMYVbTtBQeVDCIL6VD8mu/0','0','ovLBgwbOb6HxNjcmqxh_s8kdJqP8','','0','1478681050');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2dcd5-XNF-0i_y0Uu5pRts','368','夏伟 ','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpiceBPLia33YtZIBUjO5brjQSuRWe1RxQMzlLib6o2tcgWBAUaG6ZiaAQyXrba6eHUHq7Y7ibnxubNB0W1g9ffiaKDQG/0','0','ovLBgwX-dtFrlewnFwpsoq90N5DE','','0','1478666979');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4sn6uxkh0kyNHeoE87SJ_c','370','Donnie','1','海淀','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDps9DfVoRlp7ickp0f2bhXBqFjYAX2reNtBmojUFKTcLLibM00mRqmcydibnrTziaXjvOOE9bQw6WAlQ/0','0','ovLBgwfjLVL_4TO4TfHFpBu2rhLo','','0','1478917364');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8fPbDeIG_loIVY3Aipmsfk','371','赵亮-無亮','1','','','','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6MSrPYLLia0VfXwrIzsLBYVZr0vOmA4HN1TUscsGex6DexRvhkeCwHQQaodqjF4xs0QXNfibD7fhZA/0','0','ovLBgwUjwOVZ57FBkFcMpVvxDUQw','','0','1478257789');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sz4c2ZCB6Ic0FhO3sD1BYX4','372','xat','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM4QwxFvWAmGPQDNvQ2yIM4KxwRN9nibE7xkMmHRy4TZuEORXCdHiaPVqJIPyycNC0sMgs0uAPZj0nLw/0','0','ovLBgwaqt1IECemZkOyvN16zo9cg','','0','1478265154');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s49pWuqSn6gxBDq_ZWoWkaI','373','林东宇','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqNClSKtib3FIez8YvUmEjy4fkAg2hibEw4CwBnsQtRHw8fqGJyTTwGALVMQEDQghgV0NLLffGicEEx1/0','0','ovLBgwfjf3ztV1YMTx0TnoC37yo0','','0','1478265188');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-i9oLHpLc1qMGUSZ_rTXlg','376','国庆','1','郑州','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/j168eYib7Sbyyj0H8rOHH1juuTfAyTHX8nuOKcibPZ5KtYgb6kPHcF8Lm8EQMM60fNQJvTVqVgWa8Z4ibczA4LhPjSrLavJ94sc/0','0','ovLBgwTFAtOg1LmhKUADMlaicluw','','0','1478276090');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9-eJwAGE0JIqtx5nDOHOcM','377','不努力哪有未来','1','新乡','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXPKlAnOhgWiceIR5Dxenj7lZl1ura0kiapd8RQacDn6XT7sPpOlpydkVzE3M8acLzC56welu4jrtVVgib9mEGZLtl/0','0','ovLBgwcUNNZUeiqWXUpsOOeI9zvk','','0','1478281305');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syG6HIbpR8VaqFiBRgMY3qk','378','(╯з╰)','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqKmloXY6ergPickO9ltiaibyXUMtSsbCBACvzicQApqRbKIT1ejD11zrdhSESDEWOXjOVckXNrcE9wz4/0','0','ovLBgwYJgBzfIYGyEyQOgguf5E5c','','0','1478308334');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8xIqggDlmRx4VPJucjsk5U','379','黑鹰','1','莆田','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDNY96GiauZCCjLwxK3bOyt9CfQibJuxEmAibxvANpvpqGDPg6PpE5oAXuuQbuicksZh693xFM3hvXzhQ/0','0','ovLBgwYyCBbArapnTPpg4d69_CII','','0','1478309270');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swXbMrBhlWxLCymynt2LrSQ','380','云信传英','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7iawHlvV6oOvRzjA5x2Dicanl10dFG0rmsEOQv8Hn3OKNkGnruNGj4EJnXr96iaf6NibkWicxNZX3cxnT1/0','0','ovLBgwd4p8RbITqmwPaI5DHy1Hy0','','0','1478321378');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swwJM4hfhs2-CEZOA6ZnHNg','382','','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEIDxb12622tqyhNWfIC0sYENVYOJ3m0hicVyd7jurz2EibRZxFV5Zd383UGicT8z0NDGJ8jxKRgXZXQw/0','0','ovLBgwRirVJSOS9RdLFzmzdZjh3E','','0','1479720503');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5UvPPK-19w6lTauMhTqYH8','383','真诚找老婆结婚','1','济宁','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEJArbEpEsibR8WyDrnwXWOeKaDfaN8zBEgSFJEqJOrDIV0NrZPAxPhPwbBoqoXtKL6lW0DpIDst6zQ/0','0','ovLBgwbcWAs9Wv5eRXHwwohGda0g','','0','1478431103');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s74vQAbPKrLC-xoUsvPAm90','384','於洪林13951077760','1','南京','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6CqwceKztUeaV8qzicNOPJfAmrFQvyVctxjoZ7UxYKTEwHtJTUYgdu5klapGRJohJsopskicQfxPOw/0','0','ovLBgwWONi7sQNrdNwlViNy0N-yk','','0','1478400534');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swaxdsBBwYlDoga-ODS8WWA','385','MR·Zhao‍霸途科技','1','江北','中国','重庆','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Pol1QxGZhQeP5mGv7kE3W8x6yBaqzeBlXia59NoZw4ABIicdONPgTycKUicHXyWRooIc9BEAqyFhLBSAsoOHWBuNQ7/0','0','ovLBgwXiodsQ1WNyLRc8KoGcX_I0','','0','1478404771');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1syhM8GZX_FGBJZ2IOeuEc','386','Right Now','1','江北','中国','重庆','zh_CN','http://wx.qlogo.cn/mmopen/x56zUNdJibnF2mKItqWAqtJpGIuSM6etPHJ6czGzvyJXlvDW056CSpLaPHLpoXvuJXKcgUko8UlQPW36I9XGFHTtPrT6vkdBq/0','0','ovLBgwW2qKnMQz3XUJIGR7ZRgh-M','','0','1478413673');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_pGwn96PR0pXvA8ZpJfPLI','388','周明','1','太原','中国','山西','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLB3fSSXTdaoC8S4nXviaCqOfHsOX3jpdDh2bo15BTic7lY7l762kia1ZqaZeHjZX91uNaIQ6NUmmdcvg/0','0','ovLBgwaeJ8-P7PE-TyjGCTEiE-s0','','0','1478434219');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0nVo1AxtwfbaASDtLJcha4','390','易燃又美味。','1','南充','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM5qPRuTVKVFiaDGFia9OmKBLib3ciceMbgDxxANwSS1Z3bxoNoW5bwqJ1qlScQz5ic89wurKHMRibAprYDGvKIVSD0hGgogvvYdWTuys/0','0','ovLBgwbmvOzF7-Qoi2Hvm9hXHkUs','','0','1478556516');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6LTXyQ_TXJPJFtMwc-s-6M','391','恭喜发财','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia3eeGmZXPL9yOWvqZmTtvGZ63r5GDDN3HnHkRb6ZlMicgc58z3AJS1LQ0Bt4CVib1Act7SRicb9ZW2B/0','0','ovLBgwVPdp2AEXpH0XXbhA0rDcXo','','0','1478592343');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6cVwy6GGMh4ip867C4gRQA','392','木易楊','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjsDqRT8794ALnMZI1yQSiajK6zhhtu8TBa3SsEQA92wh0kjicvoSQemrCxXOgTsrDjK410wg9bfj2X0mUZQhiajkn/0','0','ovLBgwT-P7G0zhp7NTfPRvJkG9SQ','','0','1481250513');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxJA0TBGgPVH1jjVaDeBVp4','393','路人己','1','西安','中国','陕西','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVYgNUykd8Oicp57zZtv2ZG8K5kTicbQicFOBTZt75qTJlYKiaAAXmh0PeiagUgCGMy54YaCMRsPM8baHYIew4ponfqd/0','0','ovLBgwYQNY0HkK-qsOzuqGaMUgXA','','0','1480843978');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxHF0P61wEC6Do6AlGbijFM','395','Genpnail','1','淄博','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLA1Ew8w8K1coicuW4VL8W9JoMS56WVNz3UlvAKEsibpDAtJVbqBQHUHlkMQ8SJgHo4RqXlVLicuicWj4w/0','0','ovLBgwSDXps-7kKM0j9qDMHCg7-k','','0','1480865768');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szHMZdDJNlWvsSK_XIq2fa4','396','侯强','1','广州','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXgf8ibal58ibLtqO3OLsRyW5wd3bEdPMduY0p71gscicfYUSbstdQkHFnflRJQfJib82hBzjGTTPzRwQ/0','0','ovLBgwTlq8kGLMM3jEOd7FO6uvF0','','0','1478674650');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8iXKytyWtbHqm7Kb7MLrxM','401','.','1','海淀','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJcXf8E8EmbYoybBDB2z75icES92vIyrZASqdnTRKoenWU16L7MT44jk6GaMb2fgEGtZPb0ET0CMich/0','0','ovLBgwcJM_odRZJGp6tpdMcMNHjQ','','0','1478773831');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7oOPFLAYVPx-9HIGOlSAyk','402','陈海宴','1','秦皇岛','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbNuzI8wYPTCW3tw6uwDg7c8ibAibzMb9SqvqLYY6S0cQl09pQIF4h5jZoPn68f4FVnicJPibpPCvibdhxGU3SpkiagmMQ/0','0','ovLBgwemWU4p1R5vqGvag9Oy2Z9A','','0','1478779015');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_rBb5cpE-r0unkiVTsM0GQ','403','平社晓（平汝原窑汝瓷1830395888','1','平顶山','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7iay4833tvzDhTCxb7z3ybRolLO6GkibmOTiaszrUpy61fNSoqF6iaoTqM5HZz6iaMxM7VOA1FTL2hjLhB/0','0','ovLBgwSk3cPi6BD0h7XhIC0FG8EA','','0','1480633929');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1sze1UzbT-regoIL2vzp8U','405','符传龙 [玖魅网络]','1','文昌','中国','海南','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Pr6cDdYwjEDQ5vHAnKrAwrXM8OuddiadMjITZeBMC7iaV1xFIp6960fLzGwcvDIUS5jM6yVPpagTOK7OcUjcTBRPL/0','0','ovLBgwUkufxYGvb33dfwTfVgVLYA','','0','1478858345');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8K5eMzOg3BEiV4vu1vAIvc','406','啦啦啦啦啦啦','2','成都','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLD2OsCxiaymUGic3mmeSUGEFAGCte3Tic6HzdUrnmNriaedwicgTlBOyicG1wMAqGv1xNcOrc8o8ySg6Xrw/0','0','ovLBgwfzE0ZKdkrScJAfoyZLAnFI','','0','1478919785');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szgBzZNEI6sKS8HjjysEAuc','407','贺照云','1','成都','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/pjicwtoYSoooQFIoaYJ43TvCZWRbYMukNbic0PCpKfxEtrpllaARgvVrFwiavqe0b7eE0nOuZvIuEn8DXiaia32htiaTCZAUPsRh1N/0','0','ovLBgwfOdMZrWZcpP76Cu4YTU_5U','','0','1478861753');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3lYPpnLF7bniJ0Q2a0yq2s','408','联合的崛起','1','济南','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAYibowkqWlWwNzejYpfx66MnH5a8Sy1MxcrIIoibDHcBPsdLkjmiaHzZ7cFEQUed9E1W2e07nJmI2Od/0','0','ovLBgwTXyIwHJSspmXr9GoPZE9Kg','','0','1479211665');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5h8R0Tu99PaiY--zoDKpBY','409','李孟炫 一天 1day.cc','1','石家庄','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpjlbkLws1cYus3ue1c70jOoPxkdicNX0a13Kp8N34Chg1hkAFb7mTH5x91uzd2Wc8iaibIxzcAdiauaRdBbpzzw4KQ/0','0','ovLBgwWpXk4hlDqKyEA5tWWKuYQU','','0','1478957070');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8NjKT5coGqwNkFHakKIt4g','410','让让爸爸','1','徐州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDnhvdQuibsaoLbE1nZOROegeoUaBwbtRIvjCySc9Aiby5cC8kTZPCSMvHQ4ccJcW867VEMKz6wKF8w/0','0','ovLBgwaZp0lFRMugjbnlnkXJeUck','','0','1479025524');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7Va5oZsu68zy-rNP-8yrX8','411','天眷堂 艾亮','1','太原','中国','山西','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAW7yWfvdc4E3j8HJrlRzF5o1br7uKLuxoCM2zjR7FxkOXVZJZ6rrbvmzolowGZ1SUemWYpeeoXIE/0','0','ovLBgwcbmWWJsYTYlF2JUa-HeIpM','','0','1479025645');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9_U6RIz__sABzlg7kOdggE','412','任一民','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwSJGWDzEiblmTxlC3b6o4NiblAP0v7ozc1oQibiaxZ1QHq5PI0uUrRYZaZOqu9BtVyYhibicsAiawR5ojc7/0','0','ovLBgwfi9U-ECBNiQlGcBwZ1V76M','','0','1479028446');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s75AfzutYa3y1F_ESwGDqXg','413','海之风','1','南京','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEL4a5qH7eGSC15AtlzhWlcZftYb3YWvANFnzoBljS5nBibAUsCzB2xqmSkCbRTzRJ64CXia7QWVjNFQ/0','0','ovLBgwYVKlcyvAPt7gpr6VRrysdg','','0','1479040873');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5w2d5ZUJviPB1nH-V_YnXg','414','叫我張無記','1','成都','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbOX52ictN3HNCG995zI9dsVxCsWynNYzA4e1LiaERzyIs4RlgXVQ7cXClQ7QCr7iaUpGjmCGFn6gVDgA/0','0','ovLBgwfLWhKR0shdCXc6-m9Gv6Ok','','0','1479113907');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sx0uIfSeWa8e12wxfVxUW5Y','415','Challenger','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGURhficZDeG67ianVa68GP3iaT7Jp4CDX9j0x12nfxCP9DgmJdoYSS0iawfHhiazllSRDiaZ1CYzNOZrKqmMxcAeAKbnW/0','0','ovLBgwVIFj1O303AOgmprBY5o4wY','','0','1479127288');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5H9Ar-4oPXN0gyeL6wATas','416','龙','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEK1RMIQ89Yxoslej70Xjb96BadbDdiahFtuFiaicKCj1VfysObBbELch3AzDP1kCdf1jiazZWVHExib5EQ/0','0','ovLBgwUy-szFKj0YOYahQgLJi9I8','','0','1479128637');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sw-AIQhjtEyPBABBMuAIbkI','417','丶','1','汕头','中国','广东','zh_TW','http://wx.qlogo.cn/mmopen/hh8UniaFK5PribiaZ8kbWI54UsIJj7kQotmzL32LoMUb5BuVdrUjibMIaUyibVtDlg5QzhPqrWoYhutryuILcljIaLQ/0','0','ovLBgwRuMoHdkpyG0VYoE4SWlHxE','','0','1479131784');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6ueZoGYx_6lZ7HyiG8xEVQ','418','山','1','平顶山','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Pr3NthxNN9a7xFZcBkXdGy4qD2PJlMbe2iaM7OaKP8WoYV4BwzCqOl5FrOUKo0Zny0WO7EJZTKM12P3FoibLa2HCj/0','0','ovLBgwdrfv8IrlysEps-WOKXuNl0','','0','1479132706');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8v3YM3eY0G45joHqwnBQAM','419','裕霖-珍王璟和田玉','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLC0Y8t3LjFdkfo4fJSBwRPvnSdJks64sdicIzBGms3URXPuYtVNgQbXdHvaT1EmTibicoyaToC8lViaVQ/0','0','ovLBgwaP9By0a4SzxEEr5WPRluwo','','0','1479133018');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sw3gCmP2wv86CwV7c680eqg','420','宇宙海船夫','1','上饶','中国','江西','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGWyiagmvDmqcYnwf3sZglhX1micsmVo3tkpyBQAy8f60xV1Lx9hWff65sqLM7icGoM9vyA76zJ7SVXvhjEibguKTaiaQ/0','0','ovLBgwc9TqTUb9PN7TgUHVOTAMVg','','0','1479185934');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5KQTNAQl86xolRInb93Tn4','422','Artuion','1','郑州','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM4MLdegcU1HSWMVQgKMibrKauLL6wBdTIhpaIeIib3kjvFSrcF4fo4jvZTbNpAsTfkt9hXqbTd1x1pA/0','0','ovLBgwcKjE3Ug7i4fD0ktCik4WSk','','0','1479257177');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0ECIyJC6gGevquEp440yEk','423','樵夫','1','沈阳','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDRg0NNL135TiczPACoYyGbZXG90g12eB7GdqB2E4vd9GDb7iarlcomk0oWzu9o7iaZqdSU7BxqkRZQw/0','0','ovLBgwWs6ScysWSNFIQ_IhgPB09w','','0','1479254385');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1K_kzG3Tx9deYbeR2l269s','424','丨依一丨Ｉ Lᵒᵛᵉᵧₒᵤ♥','1','','','','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLATCuFibTveTnWjyLUV6ic3rBK8Sdu0yWHNoslZ1oV5icicVsXMv3kicVRickO9oU0wUyRUUs81vNib1RwIg/0','0','ovLBgwazl_toeFvBLtu81IuG_--o','','0','1479220999');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swj72pkr0z3tZrijqV1SQoY','425','黄友Rocky','1','南京','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbOvI0wkIItPBdwSDpiaWh4Z0NGaWWJKXDIic6A1v4NObNDLlu4uMztCmicVxhev84PBibSpxrLglwiboUg/0','0','ovLBgwYM2fCAp0vqIPjawWrSLiR4','','0','1479308050');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3-tjGyrAJzf6HocOR7zF3o','428','天猫特价2号客服','1','济南','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaELJrgX1Fr4tgSG4XZ3w7gzjYBbcdt15GauCyrNbGuKRgW2y4HhqpogOVpob9Z5libhicVDydT5cwAAw/0','0','ovLBgwfRwbK_2aYrblVTOqQF1j_I','','0','1479452848');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxBoTJYlo4aJ9xlumdIomVE','429','家教你我他-王刚','1','大庆','中国','黑龙江','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqL8o5wPrRwsEG6aiaabqrNqo1CicWN4LDD2icKDQGia3UaJibTa0uf4M0pnu6W0SdOEwOthqIwn5rDeI4/0','0','ovLBgwdLWcHvLm1RP5nxtn-vyrTc','','0','1479469464');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9f1aZPBD_NmnXNI55F2eKg','432','活佛','2','昌平','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVJGZ9UzbLlT5SgqujMwm8kMNZia9rBzXtE1MxlGw2YvicRibQMsTX2LfY5x23ytWN2Ehp48rGjsLBNGqYGxyicLrER/0','0','ovLBgwUFDcjrwwMyqinpGN2H4jVU','','0','1479532127');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5iuZMCoBEB4ron_LR7_hBw','433','猜猜我是谁','2','长沙','中国','湖南','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGVGP4fqreTImEWWOficdvsU2YSCNanh5DwHOlN6WLAFbZnOmecjZuic3icVCsVvXmR4ia9GtXRuklA7HJSShZeMuIUJ/0','0','ovLBgwVZJI_I9HyR6ZBo1L26b1n8','','0','1479539369');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9sx5rZaw23chFqyZWPGGg0','434','渡缘','1','浦东新区','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwZ5MvhbBtmkc9YtzU7WG8uckVDu1NnmeK1v43vDeePltFwmibqgsr0gc57fZudAfNxy4yJXelXZcs/0','0','ovLBgwaz-o2nM6vLx1AV_E4keexc','','0','1479538831');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syADLhueIl5h2x4L22tDN0M','435','小鬼不坏','1','绍兴','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqKWghaeq0at5t6GdcqlVtnZiau3SYqJaC89NZOLdiaKKxt1PEAtA9FITJ8FsGvkNh7icdomZhuUkx4K/0','0','ovLBgwcg1_sh3tcxtY7hIjWVBHco','','0','1479623390');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8q02sBp-GPKls71RhIB97s','437','村委主席','1','东莞','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGUBwSMtjw484SK3KkH4XpYRWqCNXICFo4kniatoBKN89sl11TbXOfKickSw0HfAZwxlrlERumK3Sick215g7aCRQoU/0','0','ovLBgwRy1B7fOGM6Q17hcexI3vyo','','0','1479609287');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4atHjVHafC1jAMi6FKhbhU','438','拂尘阁','1','扬州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZg2xEiahib6Bfp9UXZaIPlZDopHS2BNPKo0kdRXzeqONvDoIqPfAamRqQa4JefFkSq1ia54Xa1RRgc7KFaHyarCMoB/0','0','ovLBgwQZa2hWd18TmcXeIbcaFi9I','','0','1479787425');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swzt2apioO4gn83sgqqm9-Y','441','A00秦明辉 13891951640','2','西安','中国','陕西','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpzH418g1Ku42wngMwAia5STJteicib5qV96mLwtjicPK9dkH0L1DWxjdOJDK1kbOvyFvS4fCZ0VTQib4rT2iau0vNqUM/0','0','ovLBgwZ7HBgYkdloicH-_LkLI_2g','','0','1480838286');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9oK8nOYOkW9ebfdAzH0rHk','443','YYD516688','1','成都','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZg4aYdSQJfa5tib9A4RRxn26Tpadf06aGuVTyWH8YLtV8XS3JyWB3aNTiaicxSr9ZNbqLCicv6WDwbOgthyYIcib4buw/0','0','ovLBgwR-Ks9xmeRT2BN5W60Bi4XM','','0','1479726790');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swM5aa8e-BnefmYSX43GFmc','445','猫头鹰','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLB9L96skgZfGz3P2QW4iaphgKAicVAvpUfodh6AtW9qvKBGBhsk3lTdf35hvFNNbRe1dlIkxsLowejg/0','0','ovLBgwZRcwCoNBIZh9boOZAyLl5w','','0','1481168548');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4x99l27v8rX0I1Zw7D1JQc','446','...','0','杭州','中国','浙江','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGUxBr8E37xicolX9I5rJOOxLqlicaCGuDNsLWA1ubzVJ6cy2N3HbUIBUmIQQ4gPMHUrEvdsyNk2tIYnFbk8xtCwVz/0','0','ovLBgwSviTWFP7f2O9KpgPJFHv-M','','0','1480009469');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swDysFvf9_9sXIIZj_T-E3k','447','ZY','2','济南','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwT4EvEUdcpFPBHTVpiaG2FEtuY9YF9SnjicbaqXRPbjxIbK1PkYXFU0L24UcS6Y0FwzKu7H7fFZaiaM/0','0','ovLBgwQogjJKmP9jC3QbCy5Iz4kQ','','0','1479867038');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7yDldAMXLXytHiR97QxQ88','449','假友与假酒','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZjkz305IDEfBwKtbR49ZnZFg2PMrLNwoGyvibSVAMUZPM78vHRyvWX3iceibksG9EWRCYTHgLIt2kCiaGDJZwdv4w4w/0','0','ovLBgwbDi_tr6VQeiMcEjppEVg44','','0','1479949560');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s09Wcl0b2uQzKCg88k7x-zY','450','樊晓杰','1','忻州','中国','山西','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEIG8VibkCOzNnZscP3SPrY6bb2rW3jfl0rXOWJV6iatdWicQBDhic1xr15uHP6hHLaZCgg8zicYBTEA2yg/0','0','ovLBgwQgedmbS6QVo5C2KN7aX9lQ','','0','1479869713');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-aMHRKVwE4o22iXHDLHLDE','451','周晓乐','1','郑州','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLC3wVsWIPmrANFKgkorFuF3XMvN0R8TXyKMXauHeDldyVq4ib5hekz9ViaFGFK8iagYg7PHkTXhNzmAQ/0','0','ovLBgwWjw7eqPUIamiBmxzqVapvo','','0','1479890513');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7CzeP1U-rF1InhMGQHde-c','452','Louis','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaELDrpBsl7mqB12xJGto86hF6yhibibVHPeuDJd0nedYrVV901dAvXVCBdSBDWn9s2tAR1gNFUWW5ftg/0','0','ovLBgwUH4R1MfItXAuQHdtEMe-Vw','','0','1479892345');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szlk3GgC6LT4LjxOLgSc-rc','453','罗某Cr','1','渝北','中国','重庆','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7iaibZsoPwEicwlia56X8TXIxOzqWk1icSGSic0ZlYwymYyvhz5dOh1ia1XIVFibTbicfegnziaXNRFTB5QQlrY/0','0','ovLBgwVWEMgKzPmjs3TOrkx30VsY','','0','1479892908');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7DGT3aP6_qqIFg9OXIdWuA','454','慧慧','2','大同','中国','山西','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwdxE0AzGoZnfHuPVMmd3Y2goAj5mViaCxkUG8SQ6q98uquttZsqLKNH7uDpdajEicCST8OaS4vy4m7/0','0','ovLBgwTUmbNZWyNlpzZqP6DPtS7k','','0','1479897871');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2smFIaAZX1ce60AX267o7c','455','Colin','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwRWEYYyq8hYWb7be2twyTxo3PkMOWF0hpUOVGrs2Weovq1J50LXfKTKTf1MXVb7iaWUwwlbqkdShl/0','0','ovLBgwQOGAOIzJa2tEWNqRJkJq6g','','0','1479948120');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s8Fwu97rJ05MebXzFINdUUE','456','','2','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwX46aXpSQiac8Qwm4Ej1wLq7erNEO0LqhcgYe5XiaqZYFN8uicrfaMKtStHWFiblqLUEu6qvlq0EB6UR/0','0','ovLBgwXvt-SvAaPUv7e4i04q-ZaM','','0','1479985836');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-PIRVQ2WbZWs3fwaT79ujw','457','雪山飞狐','1','江北','中国','重庆','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqLOTUIeIib614rct6d0aCmHV0LZFfKV34JtFtUqGoZY8xEtXUlicWo3juyaaj4uLbAW7WBPxQ3NTiaZ/0','0','ovLBgwbkzFVFlh1UgrUrvS8lgtRI','','0','1479899863');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szeMrTZVlCsoHOyaJPgUdzw','458','别拿管理员不当干部','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia8NTOORvUAXRRXyLUFZ3VloR8IAriaLPnoUPW5VAQUBVy5qb92tkrF8TCWBibz01P8X3IKYERqUZ2r/0','0','ovLBgwWGqrkD-MJXhU7idPBOGPn4','','0','1479901225');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swlRVX9KHwQYIFPnXTLGy6c','459','金宝','1','德州','中国','山东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoomQiaF9GQjbyqFRR6eqTG9mGUzjqHY8avsUobglVicdPq6VuQ6XlNfO8Ho3MIWN8k1V7Qut86P9KFjf24j5Iiby3/0','0','ovLBgwQwHy8_k38YnkbV8zSc4mXw','','0','1479940377');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9UoUs14uFQysoQMQBbmcrY','461','~오휘~','1','奉贤','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwehrNmIfib8qVDGibzXd2rgRTZciaTSyzky8PVGqmw7GdqWv6g3XicxujhVxSqkm8BLXdJy3g3me8lyN/0','0','ovLBgwfZ6VOv5GQvVm7zsugjAgmY','','0','1479958427');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s26Ofhq2Z3IrYp0nHKMLZYc','462','落叶枫华','1','中山','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaELhlKcb1MicS7E10UuiaPLIjgIHEic6SibUSWXwia822ia6PAmWYwqmFJPmkic6ZyTDDnbly384dv86X3StLR43jI7t9CEI9MVhxxtQXI/0','0','ovLBgwb_kHEYMJH3PiUR1T2B6fpg','','0','1479994352');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_ly360UIKZzdgegCVQG-v8','466','feilong180','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/lR1ZqegQWkgb0dQBVaqPMBKQYDHjIGPQjJHth93j3Rvjqk2yhEEuxKFcoI08VgZTTjQfJicT2QHw4XxX9TRKcHYUAmcoZSgIR/0','0','ovLBgwfKkmS29NX-MLZYP1ryoX8s','','0','1480038787');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s097-0FvOBhfcQq9lNWMAL4','467','中国饲料商城网～angela','2','石家庄','中国','河北','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Pr7zjEl4iafOugMSLo4L90QBiavu8iaxYiboMGbbNsUSOC2AM59jbglVxLMDTmvviaALeZcq0WTPgFicX0bH56gffSheY/0','0','ovLBgwcbE60jhFvVexctADslRYek','','0','1480123866');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sw1orT04IB5-IVXPL7ROMuM','468','Alex刘俊周','1','','中国','','en','http://wx.qlogo.cn/mmopen/Q3auHgzwzM6lue7byLsWic605rpJetiavX7SiaA7xkXxkJIRWIrs9cShoRicb9b5cmyfOvbynFnn94vORSWJgOH8icg/0','0','ovLBgwdDfUJ0wjcslxlYYwbxsOCE','','0','1480134740');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s3BOiyRnZ6ac9RpA0EXQ-Hs','470','李嘉泰','1','','','Rotterdam','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqBGembnHJ43grsxCXsmqOfyzOtibjibeDMjfHYrBRv3egZibjia2ibibKDiawVWQcywq9FB9RGB3jmCMH66/0','0','ovLBgwfn_UDLK4VGS_mq2ziYHDKw','','0','1480229626');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1Rt4L3JbZ1mX-nM696BMVU','471','佳且好','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAeul9674OFRTqcuj2vLYRxBgiazK137SRCVJShSNTct7CRBicSYJ5MDd950NHMazvRY6AvTXGNzIew/0','0','ovLBgwRmgcMayDlV0-FQTOEqjvmQ','','0','1480333596');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s915t8V6svSktaT36v_r3eo','472','雨帆','1','莆田','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGXcmLuBFNr7ia7MWlvgXfpdCbvFf7qWRGic9jBibUwo8ibt2edVtMYnPeV2aBmNcBicLG2O8QGibar6oTw2j3lKEAYaWD/0','0','ovLBgwSv-joh6WkTY7iiTn_Mr_Ck','','0','1480471670');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sx-JPGbML_Ae_5a868kMhXk','473','半城','1','桂林','中国','广西','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PoomQiaF9GQjbzHgUibSkdMQsEVtCtb9Fb8Hm7TdND62SxcicvcMrOhJiadWeO8gSfTVicFmFkwlT4MI0c7IXChYX1M5/0','0','ovLBgwddc6PADcsVQuQX5IJqjMRc','','0','1481251097');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1451qvc5SEdcs8i2IaSago','474','zp','1','','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM56KwQsHbfEjq9cjp59VibNiakzsFnVIP2qu1AMuwO3UesHOhukTyhcaJ51bVYTrFd5sgN1wqia1I9vg/0','0','ovLBgwTUPP6733SnVBCRwtAJfeCU','','0','1480474759');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s5MOd7NlqlpixFIv4_gnmk0','475','A-万朋小K','1','漳州','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZhQNg74uoMKqLTu4PFwlrCHGkz8MEicWtegGXHp8VzLrErXtgn0DKptQqgon1gvKdk1jouPnF8XVibbbs8iaHLq1M3/0','0','ovLBgwZnzeKYR_DUNxYuY6oUmuos','','0','1480483625');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-IWpGILs3dg38f8iUNxkS4','476','阿涛','1','景德镇','中国','江西','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PojqicWUEOfw1nFrrD1OUqxYgSCagljv9nkiac1jHFRn8ibzwZS6dvbRPwLugmiacGu65OL1Z1lWjTaibMggl1e11kNk/0','0','ovLBgwRoNdNYGlLmyjtR_fpC0tJU','','0','1480522255');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s4Wnaio_RpP_9x3rQU8EypQ','477','SunCher','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGWr1A5LibTKia0NxSO6vficgia7qKchicdQnXUkhicRTQosE0rHZIGRiaphTmtZgOOJx1lJBgofz7F1MD4FZv5TccLYS7z/0','0','ovLBgweqzJytNFOlC7VFgTX1nvTQ','','0','1480557176');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szOBwNTw21FtxgJerTzcakk','478','晨13696942270','1','厦门','中国','福建','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKVxoxiaBNXrY1IGmPKmGH3EMhCNudxUmiaBicRUibK2gAwngDR9bicX8FaAoVdsDuUnnlHTKLoxGicnSXg/0','0','ovLBgwQ4lWQZJZJwFFLs3Xz2lnQQ','','0','1480563742');
INSERT INTO `on_member_weixin` VALUES ('oL2W_szJ12Dwqk5gpLKtDYJjjvMk','479','無品芝麻官','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/ajNVdqHZLLAIvkiaxg3eKYUNNzJQ3nzWc05gLib2Dn2oF2JciaAH40TBl3zF1ZQwiclvWicUUINaJCsj6IuicKWibxwpwOiclibx06xRQJFibMpPNNnqs/0','0','ovLBgwWoFsb9fuFmuiZlpCnRSqdI','','0','1480573151');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sxJfZUg2Ixukdph-5W1P_fQ','480','郭亮','1','','中国','上海','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEIrsrA1RsH3D1hcygl7fFnXsD3sOpGOicVic5VTzian3oMhq6sL4pIkVAwZR8icVRO2d8qjQ96PrfFyiaA/0','0','ovLBgwS6QiFsk1LyV5ZDyub-O6jA','','0','1480608032');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0kpc58vEobWMi5OdKbJ9YM','481','洋葱','1','银川','中国','宁夏','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM4KUORWJaU1M0g9cXT2FnyYRWeJNloX4ksQ68NqDNn80GAgUyfq75RcOqBdbQ9vh9QPkuV2Xian7Mg/0','0','ovLBgwfSm-1oXJB8KwBa_BOqJZaA','','0','1480659095');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6pJ1ShNVqLpasP3L_Fix6E','482','小爵爷','1','内江','中国','四川','zh_CN','http://wx.qlogo.cn/mmopen/3cS3WSPCyGUGbMN5fPLT9V4OP5ibpfuFib70RnFDyPCYeZxpAjpuicq5XrdJVupZk9ianHY7iaBAe5Kh8NPvETJVvaD3DOA4U4nyv/0','0','ovLBgwarExhMmvoz4auDzcLZYl_c','','0','1480733414');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s6KkDmh9QRSRq99K8aK3294','483','深蓝','1','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5Po8oTSAmo9OFXSld6jke94EB7qHktkuBS3oPo0PSgGhRtYjabPqOY4hwhRfqNmhN69RArVyQTnfSQ/0','0','ovLBgwTVa9L6BYr1diEJ_WyphFRw','','0','1481023841');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s2U6CeKWlpx76Xs1Cjb1tK4','485','阿丁','1','常州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJZw9cH1BDwPyyzcBeVclQBJ5KKx4vHKJ4aliaKnkBFrEvowCibY1f66xGFv4ribZLGCZZN4rs3kcCRo/0','0','ovLBgwfYUG84x2TcaLehrC0FAuos','','0','1480682848');
INSERT INTO `on_member_weixin` VALUES ('oL2W_syIPl8VYlTgeHLFPghI1xFU','486','新思维','1','沈阳','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAVib17Gc7F8gVuEehelKCTmdX5yxBJpfXZKpCHRZNDJ6IFQAsxYUHMqONHgF8HbOZDVE98ZnX6icdn/0','0','ovLBgwetl4-cGxBLKQ9LTj6lHxZg','','0','1481328135');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s1EQy9SsIGsPoRQBB2IWKaY','487','刘华超','1','深圳','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbMZEM3YfeEfTbpqbEbAH5wa7Cf5BvzcUjpajOIK6lrRspIp1zhonht34Xs34Z7PBGjSXNPKFCkZDg/0','0','ovLBgwfce5fQ4ng6P4VulAjiZRq0','','0','1481123215');
INSERT INTO `on_member_weixin` VALUES ('oL2W_swM9U5ByhQeZSNdd_8hZCOU','488','W j   ','1','阳江','中国','广东','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqyMm3g9AKdicTqFGBp0d9X2TW7SIXsQ21aDhg51qnznOUPRoEGRSAJr2MGibtXezScGDQEhV9WamVmsuiaOTF9GOe/0','0','ovLBgwdvdNHqAuaDV2STr0bhTa-s','','0','1480763932');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s-xcm1ENuqSZXwGsBLJkGq4','489','董龙文','1','常州','中国','江苏','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PpLK8tmY4hukaleYjhjY7c3QibROZQuc8qNqHCJB7sK5eHYiaa0WH5dBIzTGjyoPVFJGQ77Ge7Ztrucps5M9JQJbj/0','0','ovLBgwafcqCUDjGVg06kooylyTIE','','0','1480770092');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_lby7jNvSG49qcgsh0boyM','490','聚泉一品斋','1','咸宁','中国','湖北','zh_CN','http://wx.qlogo.cn/mmopen/PiajxSqBRaEKcGP47eaAZf7oeAdWXItj2vercKvWg4cm9Xw3F2ehCI8XRCOXn9aw2EgW2Q3TGWTn8tbKePfx0sw/0','0','ovLBgwfVMky2D9cSZMZizXK40Ruo','','0','1480778857');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s0fta_G-KyJdpBK9DefjUcs','491','义宁先生~','1','New York','','New York','zh_CN','http://wx.qlogo.cn/mmopen/Rzdyuy1FsZiaJRqIOq7q7CprxrVhd7nficMBhsEJKUfCgb7shqZSPqyyLmd4TaDIRuezWNlzkE2icOhde9TtYkmVxDpwTfp1jiaU/0','0','ovLBgwb4_Oi3zjB_eVYY6w6N7kYo','','0','1480819185');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9fxT19MlJ6uQmqhOdhjPT4','492','HankHao','1','西城','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/Q3auHgzwzM7XkgDYJ8uIibHd2plUV3khU5IIFrbw6Yia2PfL8Q2ibTzF9IeZdicUEJCLHI6oPjSmKyH0J2ywGrxcyQ/0','0','ovLBgwaOfGfJb1-5Cq4u_91M7-04','','0','1481088748');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s7FtO2HcXuiMOJmrronBH7Q','494','奔驰 的馬','1','三门峡','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbPBwT5BEd2VJXTQ1qhP9bTxUnne41LyQZHaOb11ZpeOCKKMyStRWTJqmtVl0N3AkeHQDuhx6pXkFH3U35zFsn0y/0','0','ovLBgwSFVa8-blaHs7SocikAlCWE','','0','1480834149');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s9QIaMZqWjkYPIkMd-pp2Sw','496','杏坛美术馆 薛豪','1','朝阳','中国','北京','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwdE0CW9lNStHjyUyFxQcPHtKv7257R65j1R3H1tJFUtwCyJ04OkZe2nNdsScuKDNjW5WS5XDzDEia/0','0','ovLBgwVhONXysFDCXnIhAHgaALWw','','0','1480985867');
INSERT INTO `on_member_weixin` VALUES ('','1','ONcoo Service','1','新乡','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAfARa8ibbTppcicUHRWhDcTrSkEC7jMbeMyMUFYkWQOBwBhmqviaFWYyhOaWOvkOAQvtvVBgRn4ss8Q/0','0','ovLBgwUNIpRhhOAo3Qt5VLVtGOo0','','0','1481016186');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s49jkyOpJIA53adUrkCmWl8','507','ONcoo Service','1','新乡','中国','河南','zh_CN','http://wx.qlogo.cn/mmopen/LiaMqfbjzUicR5QojnCu5CAfARa8ibbTppcicUHRWhDcTrSkEC7jMbeMyMUFYkWQOBwBhmqviaFWYyhOaWOvkOAQvtvVBgRn4ss8Q/0','0','ovLBgwUNIpRhhOAo3Qt5VLVtGOo0','','0','1481267879');
INSERT INTO `on_member_weixin` VALUES ('oL2W_sw_FNbKEZ32AAIlxcjVncxs','508','袁','1','丹东','中国','辽宁','zh_CN','http://wx.qlogo.cn/mmopen/hh8UniaFK5PqAH4dS3ssFwf30iaJ2mqRbQXtVJnlIXBRr5ibRtnqnUkhoYTygM0lpREMhYcALice4YgT4v3lx17jMHIdR21Crqs2/0','0','ovLBgwdCjeuPzIoTxSR-wwXBeu8c','','0','1481027548');
INSERT INTO `on_member_weixin` VALUES ('oL2W_s_fzK3RjEOF4EUcITUa2uZs','519','宝裕国际拍卖有限公司（温立艳）','0','','中国','','zh_CN','http://wx.qlogo.cn/mmopen/anblvjPKYbOGSZ1CrpFGzRU3TSGbUBaQTof9dOrjLXicw8Xzbibvm6o3nPWZPxLI0azUzwXFILa1XSOtwy7PqhZScL3PjoFskT/0','0','ovLBgwXi-0Sn0CZC0bJSV4VOlyKY','','0','1481271063');


# 数据库表：on_mysms 数据信息
INSERT INTO `on_mysms` VALUES ('1','1','0','0','0','0','系统发送','1','0','您好，后台管理员为您充值余额100000元！备注：','1470014061');
INSERT INTO `on_mysms` VALUES ('2','1','0','0','0','0','冻结提醒','1','0','系统冻结保证金400元备注：发布拍卖冻结','1470014093');
INSERT INTO `on_mysms` VALUES ('3','1','0','0','0','0','系统发送','1','0','您好，后台管理员为您充值信用额度10元！备注：','1470128103');
INSERT INTO `on_mysms` VALUES ('4','1','0','0','0','0','系统发送','1','0','您好，后台管理员扣除您的余额99600元！备注：','1470274826');
INSERT INTO `on_mysms` VALUES ('5','1','0','0','0','0','系统发送','1','0','您好，后台管理员扣除您的信用额度10元！备注：','1470274865');
INSERT INTO `on_mysms` VALUES ('6','1','0','0','0','0','冻结提醒','1','0','发布拍卖冻结信用额度0元！','1470823390');
INSERT INTO `on_mysms` VALUES ('7','2','0','0','0','0','系统发送','1','0','您好，后台管理员为您充值余额10000元！备注：','1471918537');
INSERT INTO `on_mysms` VALUES ('8','2','0','0','0','0','冻结提醒','1','0','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/8.html">和田白玉 手镯 重97.567g</a>】拍卖','1471918649');
INSERT INTO `on_mysms` VALUES ('9','2','0','0','0','0','冻结提醒','1','0','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/9.html">和田白玉 手镯 重97.567g</a>】拍卖','1471918713');
INSERT INTO `on_mysms` VALUES ('10','2','0','0','0','0','系统提示','1','0','恭喜您以500.00元拍到[【<a target="_blank" href="/Auction/details/pid/8.html">和田白玉 手镯 重97.567g</a>】请在2016-10-22 15:49之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1471938541');
INSERT INTO `on_mysms` VALUES ('11','2','0','0','0','0','系统提示','1','0','恭喜您以500.00元拍到[【<a target="_blank" href="/Auction/details/pid/9.html">和田白玉 手镯 重97.567g</a>】请在2016-10-22 15:49之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1471938541');
INSERT INTO `on_mysms` VALUES ('12','2','0','0','0','0','冻结提醒','1','0','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/10.html">阿隆索款到即发卡洛斯大姐夫</a>】拍卖','1472701168');
INSERT INTO `on_mysms` VALUES ('13','2','0','0','0','0','系统提示','1','0','恭喜您以2000.00元拍到[【<a target="_blank" href="/Auction/details/pid/10.html">阿隆索款到即发卡洛斯大姐夫</a>】请在2016-10-31 11:45之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1472701501');
INSERT INTO `on_mysms` VALUES ('14','2','0','0','0','0','支付订单','1','0','支付拍品【<a href="/Auction/details/pid/10.html">阿隆索款到即发卡洛斯大姐夫】</a>订单，扣除余额1970元','1472701799');
INSERT INTO `on_mysms` VALUES ('15','2','0','0','0','0','支付订单','1','0','支付拍品【<a href="/Auction/details/pid/10.html">阿隆索款到即发卡洛斯大姐夫】</a>订单，解冻保证金50.00元并扣除余额50.00元。','1472701799');
INSERT INTO `on_mysms` VALUES ('16','1','0','0','0','0','交易收入','0','0','拍品成交价：2000.00元+运费：20.00元=订单总额：2020元，扣除网站佣金：400.00元后收入1620元','1472702204');
INSERT INTO `on_mysms` VALUES ('17','2','0','0','0','0','冻结提醒','1','0','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/11.html">和田白玉 手镯 重97.567g</a>】拍卖','1472715180');
INSERT INTO `on_mysms` VALUES ('18','2','0','0','0','0','系统提示','1','0','恭喜您以500.00元拍到[【<a target="_blank" href="/Auction/details/pid/11.html">和田白玉 手镯 重97.567g</a>】请在2016-10-31 15:52之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1472716335');
INSERT INTO `on_mysms` VALUES ('19','2','0','0','0','0','支付订单','1','0','支付拍品【<a href="/Auction/details/pid/11.html">和田白玉 手镯 重97.567g】</a>订单，扣除余额550元','1472716394');
INSERT INTO `on_mysms` VALUES ('20','2','0','0','0','0','支付订单','1','0','支付拍品【<a href="/Auction/details/pid/11.html">和田白玉 手镯 重97.567g】</a>订单，解冻保证金50.00元并扣除余额50.00元。','1472716394');
INSERT INTO `on_mysms` VALUES ('21','1','0','0','0','0','交易收入','0','1','拍品成交价：500.00元+运费：100.00元=订单总额：600元，扣除网站佣金：100.00元后收入500元','1472716444');
INSERT INTO `on_mysms` VALUES ('22','2','0','0','0','0','冻结提醒','1','0','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/12.html">阿拉卡交电费卡拉斯绝地反击阿斯顿啦</a>】拍卖','1472803575');
INSERT INTO `on_mysms` VALUES ('23','2','0','0','0','0','系统提示','1','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/12.html">阿拉卡交电费卡拉斯绝地反击阿斯顿啦</a>】请在2016-11-02 09:24之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1472865866');
INSERT INTO `on_mysms` VALUES ('24','2','0','0','0','0','支付订单','1','0','支付拍品【<a href="/Auction/details/pid/12.html">阿拉卡交电费卡拉斯绝地反击阿斯顿啦】</a>订单，扣除余额170元','1472865955');
INSERT INTO `on_mysms` VALUES ('25','2','0','0','0','0','支付订单','1','0','支付拍品【<a href="/Auction/details/pid/12.html">阿拉卡交电费卡拉斯绝地反击阿斯顿啦】</a>订单，解冻保证金50.00元并扣除余额50.00元。','1472865955');
INSERT INTO `on_mysms` VALUES ('26','1','0','0','0','0','交易收入','0','1','拍品成交价：200.00元+运费：20.00元=订单总额：220元，扣除网站佣金：40.00元后收入180元','1472867697');
INSERT INTO `on_mysms` VALUES ('27','2','0','0','0','0','冻结提醒','1','0','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/13.html">阿訇地方卡机快递劫匪拉低反馈率</a>】拍卖','1473070341');
INSERT INTO `on_mysms` VALUES ('28','2','0','0','0','0','系统提示','1','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/13.html">阿訇地方卡机快递劫匪拉低反馈率</a>】请在2016-11-07 16:58之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1473325113');
INSERT INTO `on_mysms` VALUES ('29','1','0','0','0','0','冻结提醒','0','1','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/20.html">和田白玉 手镯 重97.567g</a>】拍卖','1473429643');
INSERT INTO `on_mysms` VALUES ('30','2','0','0','0','0','支付订单','0','0','支付拍品【<a href="/Auction/details/pid/13.html">阿訇地方卡机快递劫匪拉低反馈率】</a>订单，扣除余额170元','1473728294');
INSERT INTO `on_mysms` VALUES ('31','2','0','0','0','0','支付订单','0','0','支付拍品【<a href="/Auction/details/pid/13.html">阿訇地方卡机快递劫匪拉低反馈率】</a>订单，解冻保证金50.00元并扣除余额50.00元。','1473728294');
INSERT INTO `on_mysms` VALUES ('32','2','0','0','0','0','支付订单','0','0','支付拍品【<a href="/Auction/details/pid/8.html">和田白玉 手镯 重97.567g】</a>订单，扣除余额470元','1473728502');
INSERT INTO `on_mysms` VALUES ('33','2','0','0','0','0','支付订单','0','0','支付拍品【<a href="/Auction/details/pid/8.html">和田白玉 手镯 重97.567g】</a>订单，解冻保证金50.00元并扣除余额50.00元。','1473728502');
INSERT INTO `on_mysms` VALUES ('34','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147193854168383.html">BID147193854168383</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/8.html">和田白玉 手镯 重97.567g</a>”。','1473728502');
INSERT INTO `on_mysms` VALUES ('35','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147193854168383.html">BID147193854168383</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/8.html">和田白玉 手镯 重97.567g</a>”。','1473728502');
INSERT INTO `on_mysms` VALUES ('36','2','0','0','0','0','冻结提醒','0','0','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/21/aptitude/1.html">和田白玉 手镯 重97.567g</a>】拍卖','1473734720');
INSERT INTO `on_mysms` VALUES ('37','0','0','0','0','0','竞拍出价被超越','0','0','','1473734720');
INSERT INTO `on_mysms` VALUES ('38','2','0','0','0','0','竞拍出价被超越','0','0','','1473734720');
INSERT INTO `on_mysms` VALUES ('39','3','0','0','0','0','系统发送','0','0','您好，后台管理员为您充值余额10000元！备注：','1473735385');
INSERT INTO `on_mysms` VALUES ('40','3','0','0','0','0','冻结提醒','0','0','系统冻结保证金50.00元备注：参拍拍品【<a href="/Auction/details/pid/21/aptitude/1.html">和田白玉 手镯 重97.567g</a>】拍卖','1473735419');
INSERT INTO `on_mysms` VALUES ('41','2','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/21/aptitude/1.html">和田白玉 手镯 重97.567g</a>”出价【500.00元】已被超过。','1473735419');
INSERT INTO `on_mysms` VALUES ('42','3','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/21/aptitude/1.html">和田白玉 手镯 重97.567g</a>”出价【501】成功！','1473735419');
INSERT INTO `on_mysms` VALUES ('43','2','0','0','0','0','解冻保证金','0','0','拍品结束—解冻保证金50.00元！<br/>备注：bid_unfreeze','1473824386');
INSERT INTO `on_mysms` VALUES ('44','3','0','0','0','0','系统提示','0','0','恭喜您以501.00元拍到[【<a target="_blank" href="/Auction/details/pid/21/aptitude/1.html">和田白玉 手镯 重97.567g</a>】请在2016-11-13 11:39之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1473824386');
INSERT INTO `on_mysms` VALUES ('45','3','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147382438687231/aptitude/1.html">BID147382438687231</a>”已生成订单，请在2016-11-13 11:39前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/21/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1473824386');
INSERT INTO `on_mysms` VALUES ('46','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147382438687231/aptitude/1.html">BID147382438687231</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/21/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1473824386');
INSERT INTO `on_mysms` VALUES ('47','2','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/9/aptitude/1.html">和田白玉 手镯 重97.567g</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID147193854171654/aptitude/1.html">BID147193854171654</a>”扣除余额650元','1473824486');
INSERT INTO `on_mysms` VALUES ('48','2','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/9/aptitude/1.html">和田白玉 手镯 重97.567g</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID147193854171654/aptitude/1.html">BID147193854171654</a>”扣除余额50.00元','1473824486');
INSERT INTO `on_mysms` VALUES ('49','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/22/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>”冻结保证金【50.00元】','1473850294');
INSERT INTO `on_mysms` VALUES ('50','2','0','0','0','0','参拍冻结信誉额度','0','0','参拍“<a href="/Auction/details/pid/22/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>”冻结信誉额度【50.00元】','1473850294');
INSERT INTO `on_mysms` VALUES ('51','0','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/22/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>”出价【200.00元】已被超过。','1473850294');
INSERT INTO `on_mysms` VALUES ('52','2','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/22/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>”出价【200元】成功！','1473850294');
INSERT INTO `on_mysms` VALUES ('53','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/23/aptitude/1.html">阿斯顿发生地方</a>”冻结保证金【50.00元】','1473850472');
INSERT INTO `on_mysms` VALUES ('54','2','0','0','0','0','参拍冻结信誉额度','0','0','参拍“<a href="/Auction/details/pid/23/aptitude/1.html">阿斯顿发生地方</a>”冻结信誉额度【50.00元】','1473850472');
INSERT INTO `on_mysms` VALUES ('55','0','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/23/aptitude/1.html">阿斯顿发生地方</a>”出价【2000.00元】已被超过。','1473850472');
INSERT INTO `on_mysms` VALUES ('56','2','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/23/aptitude/1.html">阿斯顿发生地方</a>”出价【2000元】成功！','1473850472');
INSERT INTO `on_mysms` VALUES ('57','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/24/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”冻结保证金【50.00元】','1473850572');
INSERT INTO `on_mysms` VALUES ('58','2','0','0','0','0','参拍冻结信誉额度','0','0','参拍“<a href="/Auction/details/pid/24/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”冻结信誉额度【50.00元】','1473850572');
INSERT INTO `on_mysms` VALUES ('59','0','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/24/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”出价【300.00元】已被超过。','1473850572');
INSERT INTO `on_mysms` VALUES ('60','2','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/24/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”出价【300元】成功！','1473850572');
INSERT INTO `on_mysms` VALUES ('61','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/25/aptitude/1.html">了卡机sd卡了解阿里斯顿</a>”冻结保证金【50.00元】','1473850834');
INSERT INTO `on_mysms` VALUES ('62','0','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/25/aptitude/1.html">了卡机sd卡了解阿里斯顿</a>”出价【500.00元】已被超过。','1473850834');
INSERT INTO `on_mysms` VALUES ('63','2','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/25/aptitude/1.html">了卡机sd卡了解阿里斯顿</a>”出价【500元】成功！','1473850834');
INSERT INTO `on_mysms` VALUES ('64','2','0','0','0','0','系统提示','0','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/22/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>】请在2016-11-15 16:04之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474013050');
INSERT INTO `on_mysms` VALUES ('65','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147401305051559/aptitude/1.html">BID147401305051559</a>”已生成订单，请在2016-11-15 16:04前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/22/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>”。','1474013050');
INSERT INTO `on_mysms` VALUES ('66','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147401305051559/aptitude/1.html">BID147401305051559</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/22/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>”。','1474013050');
INSERT INTO `on_mysms` VALUES ('67','2','0','0','0','0','系统提示','0','0','恭喜您以2000.00元拍到[【<a target="_blank" href="/Auction/details/pid/23/aptitude/1.html">阿斯顿发生地方</a>】请在2016-11-15 16:04之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474013050');
INSERT INTO `on_mysms` VALUES ('68','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147401305056961/aptitude/1.html">BID147401305056961</a>”已生成订单，请在2016-11-15 16:04前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/23/aptitude/1.html">阿斯顿发生地方</a>”。','1474013050');
INSERT INTO `on_mysms` VALUES ('69','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147401305056961/aptitude/1.html">BID147401305056961</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/23/aptitude/1.html">阿斯顿发生地方</a>”。','1474013050');
INSERT INTO `on_mysms` VALUES ('70','2','0','0','0','0','系统提示','0','0','恭喜您以300.00元拍到[【<a target="_blank" href="/Auction/details/pid/24/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>】请在2016-11-15 16:04之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474013050');
INSERT INTO `on_mysms` VALUES ('71','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147401305058875/aptitude/1.html">BID147401305058875</a>”已生成订单，请在2016-11-15 16:04前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/24/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”。','1474013050');
INSERT INTO `on_mysms` VALUES ('72','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147401305058875/aptitude/1.html">BID147401305058875</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/24/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”。','1474013050');
INSERT INTO `on_mysms` VALUES ('73','2','0','0','0','0','系统提示','0','0','恭喜您以500.00元拍到[【<a target="_blank" href="/Auction/details/pid/25/aptitude/1.html">了卡机sd卡了解阿里斯顿</a>】请在2016-11-15 16:04之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474013050');
INSERT INTO `on_mysms` VALUES ('74','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147401305060783/aptitude/1.html">BID147401305060783</a>”已生成订单，请在2016-11-15 16:04前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/25/aptitude/1.html">了卡机sd卡了解阿里斯顿</a>”。','1474013050');
INSERT INTO `on_mysms` VALUES ('75','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147401305060783/aptitude/1.html">BID147401305060783</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/25/aptitude/1.html">了卡机sd卡了解阿里斯顿</a>”。','1474013050');
INSERT INTO `on_mysms` VALUES ('76','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”冻结保证金【50.00元】','1474013184');
INSERT INTO `on_mysms` VALUES ('77','0','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”出价【500.00元】已被超过。','1474013184');
INSERT INTO `on_mysms` VALUES ('78','2','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”出价【500元】成功！','1474013184');
INSERT INTO `on_mysms` VALUES ('79','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/27/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”冻结保证金【50.00元】','1474014180');
INSERT INTO `on_mysms` VALUES ('80','0','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/27/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”出价【300.00元】已被超过。','1474014180');
INSERT INTO `on_mysms` VALUES ('81','2','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/27/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”出价【300元】成功！','1474014180');
INSERT INTO `on_mysms` VALUES ('82','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/28/aptitude/1.html">冻结保证金测试001</a>”冻结保证金【50.00元】','1474014314');
INSERT INTO `on_mysms` VALUES ('83','0','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/28/aptitude/1.html">冻结保证金测试001</a>”出价【500.00元】已被超过。','1474014314');
INSERT INTO `on_mysms` VALUES ('84','2','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/28/aptitude/1.html">冻结保证金测试001</a>”出价【500元】成功！','1474014314');
INSERT INTO `on_mysms` VALUES ('85','2','0','0','0','0','冻结提醒','0','0','系统冻结保证金300元备注：发布拍卖冻结','1474015869');
INSERT INTO `on_mysms` VALUES ('86','2','0','0','0','0','冻结提醒','0','0','系统冻结保证金300元备注：发布拍卖冻结','1474015904');
INSERT INTO `on_mysms` VALUES ('87','1','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”冻结保证金【50.00元】','1474021223');
INSERT INTO `on_mysms` VALUES ('88','0','0','0','0','0','竞拍出价被超越','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”出价【200.00元】已被超过。','1474021223');
INSERT INTO `on_mysms` VALUES ('89','1','0','0','0','0','竞拍出价成功','0','0','您参拍商品：“<a target="_blank" href="/Home/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”出价【200元】成功！','1474021223');
INSERT INTO `on_mysms` VALUES ('90','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/36/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【add14740250402307元】','1474025040');
INSERT INTO `on_mysms` VALUES ('91','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/37/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【add147402509522530元】','1474025095');
INSERT INTO `on_mysms` VALUES ('92','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/38/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【300.00元】','1474025914');
INSERT INTO `on_mysms` VALUES ('93','2','0','0','0','0','系统提示','0','0','恭喜您以500.00元拍到[【<a target="_blank" href="/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>】请在2016-11-17 08:49之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474159791');
INSERT INTO `on_mysms` VALUES ('94','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”已生成订单，请在2016-11-17 08:49前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474159791');
INSERT INTO `on_mysms` VALUES ('95','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474159791');
INSERT INTO `on_mysms` VALUES ('96','2','0','0','0','0','系统提示','0','0','恭喜您以300.00元拍到[【<a target="_blank" href="/Auction/details/pid/27/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>】请在2016-11-17 08:49之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474159791');
INSERT INTO `on_mysms` VALUES ('97','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979191384/aptitude/1.html">BID147415979191384</a>”已生成订单，请在2016-11-17 08:49前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/27/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”。','1474159791');
INSERT INTO `on_mysms` VALUES ('98','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979191384/aptitude/1.html">BID147415979191384</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/27/aptitude/1.html">阿克苏交罚款辣椒水电费考虑将阿斯顿</a>”。','1474159791');
INSERT INTO `on_mysms` VALUES ('99','2','0','0','0','0','系统提示','0','0','恭喜您以500.00元拍到[【<a target="_blank" href="/Auction/details/pid/28/aptitude/1.html">冻结保证金测试001</a>】请在2016-11-17 08:49之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474159791');
INSERT INTO `on_mysms` VALUES ('100','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979192943/aptitude/1.html">BID147415979192943</a>”已生成订单，请在2016-11-17 08:49前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/28/aptitude/1.html">冻结保证金测试001</a>”。','1474159791');
INSERT INTO `on_mysms` VALUES ('101','1','0','0','0','0','订单状态通知','0','1','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979192943/aptitude/1.html">BID147415979192943</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/28/aptitude/1.html">冻结保证金测试001</a>”。','1474159791');
INSERT INTO `on_mysms` VALUES ('102','2','0','0','0','0','保证金解冻','0','0','拍品流拍<a href="/Home/Auction/details/pid/29/aptitude/1.html">【辣椒水点咖啡将两块阿斯顿发生地方】</a>解冻保证金：<strong>300.00</strong>;','1474159791');
INSERT INTO `on_mysms` VALUES ('103','1','0','0','0','0','系统提示','0','1','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>】请在2016-11-17 08:49之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474159791');
INSERT INTO `on_mysms` VALUES ('104','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979199168/aptitude/1.html">BID147415979199168</a>”已生成订单，请在2016-11-17 08:49前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”。','1474159792');
INSERT INTO `on_mysms` VALUES ('105','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979199168/aptitude/1.html">BID147415979199168</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”。','1474159792');
INSERT INTO `on_mysms` VALUES ('106','2','0','0','0','0','保证金解冻','0','0','拍品流拍<a href="/Home/Auction/details/pid/38/aptitude/1.html">【将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况】</a>解冻保证金：<strong>300.00</strong>;','1474159792');
INSERT INTO `on_mysms` VALUES ('107','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/39/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【300.00元】','1474161384');
INSERT INTO `on_mysms` VALUES ('108','2','0','0','0','0','保证金解冻','0','0','拍品流拍<a href="/Home/Auction/details/pid/39/aptitude/1.html">【将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况】</a>解冻保证金：<strong>300.00</strong>;','1474337199');
INSERT INTO `on_mysms` VALUES ('109','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147332511325773/aptitude/1.html">BID147332511325773</a>”卖家已发货，请保持电话畅通以便顺利收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/13/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>”。','1474357545');
INSERT INTO `on_mysms` VALUES ('110','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147332511325773/aptitude/1.html">BID147332511325773</a>”您已发货，等待买家确认收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/13/aptitude/1.html">阿訇地方卡机快递劫匪拉低反馈率</a>”。','1474357545');
INSERT INTO `on_mysms` VALUES ('111','2','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”扣除余额550元','1474357892');
INSERT INTO `on_mysms` VALUES ('112','2','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”','1474357892');
INSERT INTO `on_mysms` VALUES ('113','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”卖家已发货，请保持电话畅通以便顺利收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474357945');
INSERT INTO `on_mysms` VALUES ('114','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”您已发货，等待买家确认收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474357945');
INSERT INTO `on_mysms` VALUES ('115','1','0','0','0','0','交易收入','0','0','买家确认收到拍品“<a href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”，拍品成交价：500.00元+运费：100.00元=订单总额：600元，扣除网站佣金：100.00元后收入500元','1474359323');
INSERT INTO `on_mysms` VALUES ('116','1','0','0','0','0','交易收入','0','0','买家确认收到拍品“<a href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”，拍品成交价：500.00元+运费：100.00元=订单总额：600元，扣除网站佣金：100.00元后收入500元','1474359323');
INSERT INTO `on_mysms` VALUES ('117','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”卖家也对您做出了评价！双方已互评商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474359323');
INSERT INTO `on_mysms` VALUES ('118','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”您已评价买家，双方已互评商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474359323');
INSERT INTO `on_mysms` VALUES ('119','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”卖家也对您做出了评价！双方已互评商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474359353');
INSERT INTO `on_mysms` VALUES ('120','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”您已评价买家，双方已互评商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474359353');
INSERT INTO `on_mysms` VALUES ('121','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”卖家也对您做出了评价！双方已互评商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474359493');
INSERT INTO `on_mysms` VALUES ('122','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979183541/aptitude/1.html">BID147415979183541</a>”您已评价买家，双方已互评商品：“<a target="_blank" href="/Home/Auction/details/pid/26/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474359493');
INSERT INTO `on_mysms` VALUES ('123','1','0','0','0','0','系统提示','0','0','恭喜您以2580.00元拍到[【<a target="_blank" href="/Auction/details/pid/20/aptitude/1.html">和田白玉 手镯 重97.567g</a>】请在2016-11-23 09:41之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474681318');
INSERT INTO `on_mysms` VALUES ('124','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147468131840825/aptitude/1.html">BID147468131840825</a>”已生成订单，请在2016-11-23 09:41前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/20/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474681318');
INSERT INTO `on_mysms` VALUES ('125','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147468131840825/aptitude/1.html">BID147468131840825</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/20/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1474681318');
INSERT INTO `on_mysms` VALUES ('126','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/41/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>”冻结保证金【50.00元】','1474684250');
INSERT INTO `on_mysms` VALUES ('127','3','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Auction/details/pid/41/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>”冻结保证金【50.00元】','1474684417');
INSERT INTO `on_mysms` VALUES ('128','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/42/aptitude/1.html">保证金冻结001】</a>”上架已上架！','1474780438');
INSERT INTO `on_mysms` VALUES ('129','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/42/aptitude/1.html">保证金冻结001】</a>”上架已上架！','1474780438');
INSERT INTO `on_mysms` VALUES ('130','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/42/aptitude/1.html">保证金冻结001】</a>”上架已上架！','1474780438');
INSERT INTO `on_mysms` VALUES ('131','3','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/42/aptitude/1.html">保证金冻结001</a>”冻结保证金【50.00元】','1474780839');
INSERT INTO `on_mysms` VALUES ('132','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/43/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1474798052');
INSERT INTO `on_mysms` VALUES ('133','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/43/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1474798052');
INSERT INTO `on_mysms` VALUES ('134','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/43/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1474798052');
INSERT INTO `on_mysms` VALUES ('135','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/44/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1474798231');
INSERT INTO `on_mysms` VALUES ('136','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/44/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1474798231');
INSERT INTO `on_mysms` VALUES ('137','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/44/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1474798231');
INSERT INTO `on_mysms` VALUES ('138','3','0','0','0','0','系统提示','0','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/42/aptitude/1.html">保证金冻结001</a>】请在2016-11-25 16:41之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1474879300');
INSERT INTO `on_mysms` VALUES ('139','3','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147487930010724/aptitude/1.html">BID147487930010724</a>”已生成订单，请在2016-11-25 16:41前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/42/aptitude/1.html">保证金冻结001</a>”。','1474879300');
INSERT INTO `on_mysms` VALUES ('140','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147487930010724/aptitude/1.html">BID147487930010724</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/42/aptitude/1.html">保证金冻结001</a>”。','1474879300');
INSERT INTO `on_mysms` VALUES ('141','2','0','0','0','0','解冻保证金','0','0','拍品结束—解冻保证金50.00元！<br/>备注：bid_unfreeze','1475228082');
INSERT INTO `on_mysms` VALUES ('142','3','0','0','0','0','系统提示','0','0','恭喜您以105.00元拍到[【<a target="_blank" href="/Auction/details/pid/41/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>】请在2016-11-29 17:34之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1475228082');
INSERT INTO `on_mysms` VALUES ('143','3','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147522808224488/aptitude/1.html">BID147522808224488</a>”已生成订单，请在2016-11-29 17:34前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/41/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>”。','1475228082');
INSERT INTO `on_mysms` VALUES ('144','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147522808224488/aptitude/1.html">BID147522808224488</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/41/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>”。','1475228082');
INSERT INTO `on_mysms` VALUES ('145','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/45/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费】</a>”上架已上架！','1476428056');
INSERT INTO `on_mysms` VALUES ('146','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/45/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费】</a>”上架已上架！','1476428056');
INSERT INTO `on_mysms` VALUES ('147','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/45/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费】</a>”上架已上架！','1476428056');
INSERT INTO `on_mysms` VALUES ('148','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/45/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>”当前价【100.00元】，目前领先','1476428099');
INSERT INTO `on_mysms` VALUES ('149','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/45/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>”冻结保证金【50.00元】','1476428099');
INSERT INTO `on_mysms` VALUES ('150','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/46/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1476673589');
INSERT INTO `on_mysms` VALUES ('151','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/46/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1476673589');
INSERT INTO `on_mysms` VALUES ('152','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/46/aptitude/1.html">和田白玉 手镯 重97.567g】</a>”上架已上架！','1476673589');
INSERT INTO `on_mysms` VALUES ('153','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/46/aptitude/1.html">和田白玉 手镯 重97.567g</a>”当前价【1.00元】，目前领先','1476753916');
INSERT INTO `on_mysms` VALUES ('154','2','0','0','0','0','系统提示','0','0','恭喜您以1.00元拍到[【<a target="_blank" href="/Auction/details/pid/46/aptitude/1.html">和田白玉 手镯 重97.567g</a>】请在2016-12-17 11:06之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1476759963');
INSERT INTO `on_mysms` VALUES ('155','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147675996307283/aptitude/1.html">BID147675996307283</a>”已生成订单，请在2016-12-17 11:06前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/46/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1476759963');
INSERT INTO `on_mysms` VALUES ('156','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147675996307283/aptitude/1.html">BID147675996307283</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/46/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1476759963');
INSERT INTO `on_mysms` VALUES ('157','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476761824');
INSERT INTO `on_mysms` VALUES ('158','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476761824');
INSERT INTO `on_mysms` VALUES ('159','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476761824');
INSERT INTO `on_mysms` VALUES ('160','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777444');
INSERT INTO `on_mysms` VALUES ('161','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777444');
INSERT INTO `on_mysms` VALUES ('162','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777444');
INSERT INTO `on_mysms` VALUES ('163','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777604');
INSERT INTO `on_mysms` VALUES ('164','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777604');
INSERT INTO `on_mysms` VALUES ('165','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777604');
INSERT INTO `on_mysms` VALUES ('166','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777850');
INSERT INTO `on_mysms` VALUES ('167','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777850');
INSERT INTO `on_mysms` VALUES ('168','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/47/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1476777850');
INSERT INTO `on_mysms` VALUES ('169','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/48/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1476778851');
INSERT INTO `on_mysms` VALUES ('170','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/48/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1476778851');
INSERT INTO `on_mysms` VALUES ('171','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/48/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1476778851');
INSERT INTO `on_mysms` VALUES ('172','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/48/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1476782119');
INSERT INTO `on_mysms` VALUES ('173','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/48/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1476782119');
INSERT INTO `on_mysms` VALUES ('174','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/48/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1476782119');
INSERT INTO `on_mysms` VALUES ('175','2','0','0','0','0','系统提示','0','0','恭喜您以100.00元拍到[【<a target="_blank" href="/Auction/details/pid/45/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>】请在2016-12-29 16:29之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1477816142');
INSERT INTO `on_mysms` VALUES ('176','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147781614203217/aptitude/1.html">BID147781614203217</a>”已生成订单，请在2016-12-29 16:29前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/45/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>”。','1477816142');
INSERT INTO `on_mysms` VALUES ('177','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147781614203217/aptitude/1.html">BID147781614203217</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/45/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费</a>”。','1477816142');
INSERT INTO `on_mysms` VALUES ('178','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1477816836');
INSERT INTO `on_mysms` VALUES ('179','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1477816836');
INSERT INTO `on_mysms` VALUES ('180','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1477816836');
INSERT INTO `on_mysms` VALUES ('181','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/50/aptitude/1.html">阿克苏的减肥卡拉神盾舰</a>”当前价【100.00元】，目前领先','1478010158');
INSERT INTO `on_mysms` VALUES ('182','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/51/aptitude/1.html">卢卡斯交电费卡拉胶水电费考虑将阿里斯顿将</a>”当前价【100.00元】，目前领先','1478010324');
INSERT INTO `on_mysms` VALUES ('183','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>”冻结保证金【50.00元】','1478010331');
INSERT INTO `on_mysms` VALUES ('184','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>”当前价【200.00元】，目前领先','1478010331');
INSERT INTO `on_mysms` VALUES ('185','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/53/aptitude/1.html">就卡卡圣诞节】</a>”上架已上架！','1478073905');
INSERT INTO `on_mysms` VALUES ('186','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/53/aptitude/1.html">就卡卡圣诞节】</a>”上架已上架！','1478073905');
INSERT INTO `on_mysms` VALUES ('187','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/53/aptitude/1.html">就卡卡圣诞节】</a>”上架已上架！','1478073905');
INSERT INTO `on_mysms` VALUES ('188','2','0','0','0','0','系统提示','0','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>】请在2017-01-01 17:23之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1478078609');
INSERT INTO `on_mysms` VALUES ('189','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147807860939785/aptitude/1.html">BID147807860939785</a>”已生成订单，请在2017-01-01 17:23前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>”。','1478078609');
INSERT INTO `on_mysms` VALUES ('190','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147807860939785/aptitude/1.html">BID147807860939785</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>”。','1478078609');
INSERT INTO `on_mysms` VALUES ('191','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/54/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478307591');
INSERT INTO `on_mysms` VALUES ('192','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/54/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478307591');
INSERT INTO `on_mysms` VALUES ('193','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/54/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478307591');
INSERT INTO `on_mysms` VALUES ('194','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/55/aptitude/1.html">卡拉江苏旷达李方军卡拉斯的】</a>”上架已上架！','1478307699');
INSERT INTO `on_mysms` VALUES ('195','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/55/aptitude/1.html">卡拉江苏旷达李方军卡拉斯的】</a>”上架已上架！','1478307699');
INSERT INTO `on_mysms` VALUES ('196','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/55/aptitude/1.html">卡拉江苏旷达李方军卡拉斯的】</a>”上架已上架！','1478307699');
INSERT INTO `on_mysms` VALUES ('197','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.10元】，目前领先','1478312836');
INSERT INTO `on_mysms` VALUES ('198','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.10元】已被超过。','1478312893');
INSERT INTO `on_mysms` VALUES ('199','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.20元】，目前领先','1478312893');
INSERT INTO `on_mysms` VALUES ('200','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.20元】已被超过。','1478315198');
INSERT INTO `on_mysms` VALUES ('201','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.30元】，目前领先','1478315198');
INSERT INTO `on_mysms` VALUES ('202','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.30元】已被超过。','1478315214');
INSERT INTO `on_mysms` VALUES ('203','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.40元】，目前领先','1478315214');
INSERT INTO `on_mysms` VALUES ('204','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.40元】已被超过。','1478315218');
INSERT INTO `on_mysms` VALUES ('205','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.50元】，目前领先','1478315218');
INSERT INTO `on_mysms` VALUES ('206','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.50元】已被超过。','1478315230');
INSERT INTO `on_mysms` VALUES ('207','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.60元】，目前领先','1478315230');
INSERT INTO `on_mysms` VALUES ('208','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.60元】已被超过。','1478315748');
INSERT INTO `on_mysms` VALUES ('209','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.70元】，目前领先','1478315748');
INSERT INTO `on_mysms` VALUES ('210','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.70元】已被超过。','1478315788');
INSERT INTO `on_mysms` VALUES ('211','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.80元】，目前领先','1478315788');
INSERT INTO `on_mysms` VALUES ('212','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.80元】已被超过。','1478315791');
INSERT INTO `on_mysms` VALUES ('213','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【0.90元】，目前领先','1478315791');
INSERT INTO `on_mysms` VALUES ('214','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【0.90元】已被超过。','1478315794');
INSERT INTO `on_mysms` VALUES ('215','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.00元】，目前领先','1478315794');
INSERT INTO `on_mysms` VALUES ('216','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.00元】已被超过。','1478315797');
INSERT INTO `on_mysms` VALUES ('217','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.10元】，目前领先','1478315797');
INSERT INTO `on_mysms` VALUES ('218','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.10元】已被超过。','1478316042');
INSERT INTO `on_mysms` VALUES ('219','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.20元】，目前领先','1478316042');
INSERT INTO `on_mysms` VALUES ('220','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.20元】已被超过。','1478316044');
INSERT INTO `on_mysms` VALUES ('221','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.30元】，目前领先','1478316044');
INSERT INTO `on_mysms` VALUES ('222','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.30元】已被超过。','1478316249');
INSERT INTO `on_mysms` VALUES ('223','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.40元】，目前领先','1478316249');
INSERT INTO `on_mysms` VALUES ('224','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.40元】已被超过。','1478316384');
INSERT INTO `on_mysms` VALUES ('225','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.50元】，目前领先','1478316384');
INSERT INTO `on_mysms` VALUES ('226','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.50元】已被超过。','1478316387');
INSERT INTO `on_mysms` VALUES ('227','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.60元】，目前领先','1478316387');
INSERT INTO `on_mysms` VALUES ('228','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.60元】已被超过。','1478316390');
INSERT INTO `on_mysms` VALUES ('229','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.70元】，目前领先','1478316390');
INSERT INTO `on_mysms` VALUES ('230','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.70元】已被超过。','1478316393');
INSERT INTO `on_mysms` VALUES ('231','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.80元】，目前领先','1478316393');
INSERT INTO `on_mysms` VALUES ('232','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.80元】已被超过。','1478316396');
INSERT INTO `on_mysms` VALUES ('233','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【1.90元】，目前领先','1478316396');
INSERT INTO `on_mysms` VALUES ('234','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【1.90元】已被超过。','1478316399');
INSERT INTO `on_mysms` VALUES ('235','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.00元】，目前领先','1478316399');
INSERT INTO `on_mysms` VALUES ('236','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.00元】已被超过。','1478316401');
INSERT INTO `on_mysms` VALUES ('237','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.10元】，目前领先','1478316401');
INSERT INTO `on_mysms` VALUES ('238','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.10元】已被超过。','1478316403');
INSERT INTO `on_mysms` VALUES ('239','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.20元】，目前领先','1478316403');
INSERT INTO `on_mysms` VALUES ('240','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.20元】已被超过。','1478316405');
INSERT INTO `on_mysms` VALUES ('241','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.30元】，目前领先','1478316405');
INSERT INTO `on_mysms` VALUES ('242','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.30元】已被超过。','1478316407');
INSERT INTO `on_mysms` VALUES ('243','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.40元】，目前领先','1478316407');
INSERT INTO `on_mysms` VALUES ('244','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.40元】已被超过。','1478316409');
INSERT INTO `on_mysms` VALUES ('245','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.50元】，目前领先','1478316409');
INSERT INTO `on_mysms` VALUES ('246','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.50元】已被超过。','1478316411');
INSERT INTO `on_mysms` VALUES ('247','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.60元】，目前领先','1478316411');
INSERT INTO `on_mysms` VALUES ('248','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.60元】已被超过。','1478316413');
INSERT INTO `on_mysms` VALUES ('249','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.70元】，目前领先','1478316413');
INSERT INTO `on_mysms` VALUES ('250','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.70元】已被超过。','1478316415');
INSERT INTO `on_mysms` VALUES ('251','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.80元】，目前领先','1478316415');
INSERT INTO `on_mysms` VALUES ('252','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.80元】已被超过。','1478316417');
INSERT INTO `on_mysms` VALUES ('253','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【2.90元】，目前领先','1478316417');
INSERT INTO `on_mysms` VALUES ('254','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【2.90元】已被超过。','1478316419');
INSERT INTO `on_mysms` VALUES ('255','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.00元】，目前领先','1478316419');
INSERT INTO `on_mysms` VALUES ('256','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.00元】已被超过。','1478316421');
INSERT INTO `on_mysms` VALUES ('257','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.10元】，目前领先','1478316421');
INSERT INTO `on_mysms` VALUES ('258','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.10元】已被超过。','1478316423');
INSERT INTO `on_mysms` VALUES ('259','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.20元】，目前领先','1478316423');
INSERT INTO `on_mysms` VALUES ('260','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.20元】已被超过。','1478316425');
INSERT INTO `on_mysms` VALUES ('261','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.30元】，目前领先','1478316425');
INSERT INTO `on_mysms` VALUES ('262','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.30元】已被超过。','1478316427');
INSERT INTO `on_mysms` VALUES ('263','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.40元】，目前领先','1478316427');
INSERT INTO `on_mysms` VALUES ('264','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.40元】已被超过。','1478316429');
INSERT INTO `on_mysms` VALUES ('265','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.50元】，目前领先','1478316429');
INSERT INTO `on_mysms` VALUES ('266','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.50元】已被超过。','1478316431');
INSERT INTO `on_mysms` VALUES ('267','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.60元】，目前领先','1478316431');
INSERT INTO `on_mysms` VALUES ('268','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.60元】已被超过。','1478316435');
INSERT INTO `on_mysms` VALUES ('269','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.70元】，目前领先','1478316435');
INSERT INTO `on_mysms` VALUES ('270','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.70元】已被超过。','1478316437');
INSERT INTO `on_mysms` VALUES ('271','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.80元】，目前领先','1478316437');
INSERT INTO `on_mysms` VALUES ('272','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.80元】已被超过。','1478316438');
INSERT INTO `on_mysms` VALUES ('273','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【3.90元】，目前领先','1478316438');
INSERT INTO `on_mysms` VALUES ('274','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【3.90元】已被超过。','1478316440');
INSERT INTO `on_mysms` VALUES ('275','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.00元】，目前领先','1478316440');
INSERT INTO `on_mysms` VALUES ('276','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.00元】已被超过。','1478316442');
INSERT INTO `on_mysms` VALUES ('277','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.10元】，目前领先','1478316442');
INSERT INTO `on_mysms` VALUES ('278','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.10元】已被超过。','1478316443');
INSERT INTO `on_mysms` VALUES ('279','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.20元】，目前领先','1478316443');
INSERT INTO `on_mysms` VALUES ('280','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.20元】已被超过。','1478316445');
INSERT INTO `on_mysms` VALUES ('281','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.30元】，目前领先','1478316445');
INSERT INTO `on_mysms` VALUES ('282','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.30元】已被超过。','1478316447');
INSERT INTO `on_mysms` VALUES ('283','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.40元】，目前领先','1478316447');
INSERT INTO `on_mysms` VALUES ('284','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.40元】已被超过。','1478316448');
INSERT INTO `on_mysms` VALUES ('285','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.50元】，目前领先','1478316448');
INSERT INTO `on_mysms` VALUES ('286','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.50元】已被超过。','1478316450');
INSERT INTO `on_mysms` VALUES ('287','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.60元】，目前领先','1478316450');
INSERT INTO `on_mysms` VALUES ('288','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.60元】已被超过。','1478316451');
INSERT INTO `on_mysms` VALUES ('289','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.70元】，目前领先','1478316451');
INSERT INTO `on_mysms` VALUES ('290','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.70元】已被超过。','1478316453');
INSERT INTO `on_mysms` VALUES ('291','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.80元】，目前领先','1478316453');
INSERT INTO `on_mysms` VALUES ('292','3','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”出价【4.80元】已被超过。','1478316455');
INSERT INTO `on_mysms` VALUES ('293','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”当前价【4.90元】，目前领先','1478316455');
INSERT INTO `on_mysms` VALUES ('294','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/57/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478331760');
INSERT INTO `on_mysms` VALUES ('295','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/57/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478331760');
INSERT INTO `on_mysms` VALUES ('296','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/57/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478331760');
INSERT INTO `on_mysms` VALUES ('297','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/58/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478331847');
INSERT INTO `on_mysms` VALUES ('298','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/58/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478331847');
INSERT INTO `on_mysms` VALUES ('299','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/58/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478331847');
INSERT INTO `on_mysms` VALUES ('300','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/59/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478338043');
INSERT INTO `on_mysms` VALUES ('301','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/59/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478338043');
INSERT INTO `on_mysms` VALUES ('302','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/59/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478338043');
INSERT INTO `on_mysms` VALUES ('303','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/60/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478338510');
INSERT INTO `on_mysms` VALUES ('304','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/60/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478338510');
INSERT INTO `on_mysms` VALUES ('305','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/60/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478338510');
INSERT INTO `on_mysms` VALUES ('306','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/61/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费】</a>”上架已上架！','1478338532');
INSERT INTO `on_mysms` VALUES ('307','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/61/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费】</a>”上架已上架！','1478338532');
INSERT INTO `on_mysms` VALUES ('308','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/61/aptitude/1.html">阿娇快乐的减肥卡拉斯交电费】</a>”上架已上架！','1478338532');
INSERT INTO `on_mysms` VALUES ('309','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/62/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1478339435');
INSERT INTO `on_mysms` VALUES ('310','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/62/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1478339435');
INSERT INTO `on_mysms` VALUES ('311','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/62/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架已上架！','1478339435');
INSERT INTO `on_mysms` VALUES ('312','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/63/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478341534');
INSERT INTO `on_mysms` VALUES ('313','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/63/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478341534');
INSERT INTO `on_mysms` VALUES ('314','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/63/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1478341534');
INSERT INTO `on_mysms` VALUES ('315','2','0','0','0','0','系统提示','0','0','恭喜您以4.90元拍到[【<a target="_blank" href="/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>】请在2017-01-05 10:20之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1478398805');
INSERT INTO `on_mysms` VALUES ('316','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147839880538377/aptitude/1.html">BID147839880538377</a>”已生成订单，请在2017-01-05 10:20前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”。','1478398805');
INSERT INTO `on_mysms` VALUES ('317','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147839880538377/aptitude/1.html">BID147839880538377</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/56/aptitude/1.html">就卡卡圣诞节</a>”。','1478398805');
INSERT INTO `on_mysms` VALUES ('318','1','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID147415979199168/aptitude/1.html">BID147415979199168</a>”扣除余额160元','1478490723');
INSERT INTO `on_mysms` VALUES ('319','1','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID147415979199168/aptitude/1.html">BID147415979199168</a>”','1478490723');
INSERT INTO `on_mysms` VALUES ('320','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979199168/aptitude/1.html">BID147415979199168</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”。','1478490723');
INSERT INTO `on_mysms` VALUES ('321','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147415979199168/aptitude/1.html">BID147415979199168</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/30/aptitude/1.html">阿基拉空间的疯狂辣椒水快递费将卡拉斯点</a>”。','1478490723');
INSERT INTO `on_mysms` VALUES ('322','2','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID147807860939785/aptitude/1.html">BID147807860939785</a>”扣除余额160元','1478741941');
INSERT INTO `on_mysms` VALUES ('323','2','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID147807860939785/aptitude/1.html">BID147807860939785</a>”','1478741941');
INSERT INTO `on_mysms` VALUES ('324','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147807860939785/aptitude/1.html">BID147807860939785</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>”。','1478741941');
INSERT INTO `on_mysms` VALUES ('325','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147807860939785/aptitude/1.html">BID147807860939785</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/49/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的</a>”。','1478741941');
INSERT INTO `on_mysms` VALUES ('326','2','0','1','0','0','用户发送','0','0','地方公司的风格三等功水电费','1478777752');
INSERT INTO `on_mysms` VALUES ('327','3','0','1','0','0','用户发送','0','0','地方公司的风格三等功水电费','1478777752');
INSERT INTO `on_mysms` VALUES ('328','2','0','1','0','0','用户发送','0','0','阿迪公司的分公司地方官','1478777771');
INSERT INTO `on_mysms` VALUES ('329','3','0','1','0','0','用户发送','0','0','阿迪公司的分公司地方官','1478777771');
INSERT INTO `on_mysms` VALUES ('330','2','0','1','0','0','用户发送','0','0','阿娇快乐sd卡减肥了卡萨帝','1478777927');
INSERT INTO `on_mysms` VALUES ('331','3','0','1','0','0','用户发送','0','0','阿娇快乐sd卡减肥了卡萨帝','1478777927');
INSERT INTO `on_mysms` VALUES ('332','2','0','0','0','0','系统发送','0','0','您好，后台管理员为您充值余额10000元！备注：','1478779872');
INSERT INTO `on_mysms` VALUES ('333','1','0','0','0','0','系统发送','0','0','您好，后台管理员为您充值余额10000元！备注：','1478779896');
INSERT INTO `on_mysms` VALUES ('334','1','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/20/aptitude/1.html">和田白玉 手镯 重97.567g</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID147468131840825/aptitude/1.html">BID147468131840825</a>”扣除余额2630元','1478779909');
INSERT INTO `on_mysms` VALUES ('335','1','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/20/aptitude/1.html">和田白玉 手镯 重97.567g</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID147468131840825/aptitude/1.html">BID147468131840825</a>”','1478779909');
INSERT INTO `on_mysms` VALUES ('336','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147468131840825/aptitude/1.html">BID147468131840825</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/20/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1478779909');
INSERT INTO `on_mysms` VALUES ('337','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147468131840825/aptitude/1.html">BID147468131840825</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/20/aptitude/1.html">和田白玉 手镯 重97.567g</a>”。','1478779909');
INSERT INTO `on_mysms` VALUES ('338','4','0','0','0','0','管理员充值','0','0','管理员充值余额【100元】，单号aad147891585586971','1478915855');
INSERT INTO `on_mysms` VALUES ('339','1','0','0','0','0','管理员充值','0','0','管理员充值余额【100元】，单号aad147891591655277','1478915916');
INSERT INTO `on_mysms` VALUES ('340','1','0','0','0','0','管理员充值','0','0','管理员充值信用额度【1000元】，单号aad14791810254392','1479181025');
INSERT INTO `on_mysms` VALUES ('341','1','0','0','0','0','管理员扣除','0','0','管理员扣除信用额度【100元】，单号ami147918122972357','1479181229');
INSERT INTO `on_mysms` VALUES ('342','1','0','0','0','0','管理员扣除','0','0','管理员扣除信用额度【100元】，单号ami147918189828355','1479181898');
INSERT INTO `on_mysms` VALUES ('343','1','0','0','0','0','管理员冻结','0','0','管理员冻结信用额度【10元】，单号afr147918225267086','1479182252');
INSERT INTO `on_mysms` VALUES ('344','1','0','0','0','0','管理员解冻','0','0','管理员解冻信用额度【5元】，单号auf147918226429798','1479182264');
INSERT INTO `on_mysms` VALUES ('345','1','0','0','0','0','管理员冻结','0','0','管理员冻结余额【200元】，单号afr147918245123778','1479182451');
INSERT INTO `on_mysms` VALUES ('346','1','0','0','0','0','管理员解冻','0','0','管理员解冻余额【10元】，单号auf147918246671532','1479182466');
INSERT INTO `on_mysms` VALUES ('347','2','0','0','0','0','系统提示','0','0','恭喜您以100.00元拍到【<a target="_blank" href="/Special/speul/sid/3/aptitude/1.html">阿卡林减肥卡拉斯的减肥</a>】专场下【<a target="_blank" href="/Auction/details/pid/50/aptitude/1.html">阿克苏的减肥卡拉神盾舰</a>】请在2017-01-16 20:37之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1479386278');
INSERT INTO `on_mysms` VALUES ('348','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147938627802075/aptitude/1.html">BID147938627802075</a>”已生成订单，请在2017-01-16 20:37前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/50/aptitude/1.html">阿克苏的减肥卡拉神盾舰</a>”。','1479386278');
INSERT INTO `on_mysms` VALUES ('349','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147938627802075/aptitude/1.html">BID147938627802075</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/50/aptitude/1.html">阿克苏的减肥卡拉神盾舰</a>”。','1479386278');
INSERT INTO `on_mysms` VALUES ('350','2','0','0','0','0','系统提示','0','0','恭喜您以100.00元拍到【<a target="_blank" href="/Special/speul/sid/3/aptitude/1.html">阿卡林减肥卡拉斯的减肥</a>】专场下【<a target="_blank" href="/Auction/details/pid/51/aptitude/1.html">卢卡斯交电费卡拉胶水电费考虑将阿里斯顿将</a>】请在2017-01-16 20:37之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1479386278');
INSERT INTO `on_mysms` VALUES ('351','2','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147938627827855/aptitude/1.html">BID147938627827855</a>”已生成订单，请在2017-01-16 20:37前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/51/aptitude/1.html">卢卡斯交电费卡拉胶水电费考虑将阿里斯顿将</a>”。','1479386278');
INSERT INTO `on_mysms` VALUES ('352','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID147938627827855/aptitude/1.html">BID147938627827855</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/51/aptitude/1.html">卢卡斯交电费卡拉胶水电费考虑将阿里斯顿将</a>”。','1479386278');
INSERT INTO `on_mysms` VALUES ('353','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/64/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【300.00元】','1479736604');
INSERT INTO `on_mysms` VALUES ('354','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/65/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1479776699');
INSERT INTO `on_mysms` VALUES ('355','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/65/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1479776699');
INSERT INTO `on_mysms` VALUES ('356','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/65/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1479776699');
INSERT INTO `on_mysms` VALUES ('357','2','0','0','0','0','保证金解冻','0','0','拍品流拍<a href="/Home/Auction/details/pid/64/aptitude/1.html">【将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况】</a>解冻保证金：<strong>300.00</strong>;','1480057722');
INSERT INTO `on_mysms` VALUES ('358','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/66/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1480057859');
INSERT INTO `on_mysms` VALUES ('359','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/66/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1480057859');
INSERT INTO `on_mysms` VALUES ('360','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/66/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架已上架！','1480057859');
INSERT INTO `on_mysms` VALUES ('361','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/67/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架！','1480058235');
INSERT INTO `on_mysms` VALUES ('362','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/67/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架！','1480058235');
INSERT INTO `on_mysms` VALUES ('363','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/67/aptitude/1.html">了卡机sd卡了解阿里斯顿】</a>”上架！','1480058235');
INSERT INTO `on_mysms` VALUES ('364','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/68/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架！','1480058946');
INSERT INTO `on_mysms` VALUES ('365','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/68/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架！','1480058946');
INSERT INTO `on_mysms` VALUES ('366','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/68/aptitude/1.html">考虑骄傲考虑撒旦尽快拉萨的】</a>”上架！','1480058946');
INSERT INTO `on_mysms` VALUES ('367','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/69/aptitude/1.html">阿喀琉斯交电费卡拉圣诞节咖啡】</a>”上架！','1480121317');
INSERT INTO `on_mysms` VALUES ('368','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/69/aptitude/1.html">阿喀琉斯交电费卡拉圣诞节咖啡】</a>”上架！','1480121317');
INSERT INTO `on_mysms` VALUES ('369','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/69/aptitude/1.html">阿喀琉斯交电费卡拉圣诞节咖啡】</a>”上架！','1480121317');
INSERT INTO `on_mysms` VALUES ('370','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/70/aptitude/1.html">阿卡林交电费卡拉圣诞节反馈率</a>”冻结保证金【300.00元】','1480121694');
INSERT INTO `on_mysms` VALUES ('371','2','0','0','0','0','保证金解冻','0','0','撤拍<a href="/Home/Auction/details/pid/70/aptitude/1.html">【阿卡林交电费卡拉圣诞节反馈率】</a>解冻保证金：<strong>300.00</strong>;','1480121951');
INSERT INTO `on_mysms` VALUES ('372','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/71/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【300.00元】','1480121999');
INSERT INTO `on_mysms` VALUES ('373','2','0','0','0','0','保证金解冻','0','0','撤拍<a href="/Home/Auction/details/pid/71/aptitude/1.html">【将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况】</a>解冻保证金：<strong>300.00</strong>;','1480123571');
INSERT INTO `on_mysms` VALUES ('374','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/72/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【300.00元】','1480123622');
INSERT INTO `on_mysms` VALUES ('375','2','0','0','0','0','保证金解冻','0','0','撤拍<a href="/Home/Auction/details/pid/72/aptitude/1.html">【将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况】</a>解冻保证金：<strong>300.00</strong>;','1480124154');
INSERT INTO `on_mysms` VALUES ('376','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/73/aptitude/1.html">撤拍退还保证金</a>”冻结保证金【300.00元】','1480124883');
INSERT INTO `on_mysms` VALUES ('377','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/74/aptitude/1.html">阿卡林交电费卡拉圣诞节反馈率</a>”冻结保证金【300.00元】','1480146375');
INSERT INTO `on_mysms` VALUES ('378','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/75/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【300.00元】','1480146612');
INSERT INTO `on_mysms` VALUES ('379','2','0','0','0','0','解冻保证金','0','0','撤拍<a href="/Home/Auction/details/pid/75/aptitude/1.html">【将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况】</a>解冻保证金300.00元！','1480146638');
INSERT INTO `on_mysms` VALUES ('380','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/76/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【300.00元】','1480148499');
INSERT INTO `on_mysms` VALUES ('381','2','0','0','0','0','解冻保证金','0','0','撤拍<a href="/Home/Auction/details/pid/76/aptitude/1.html">【将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况】</a>解冻保证金300.00元！','1480149301');
INSERT INTO `on_mysms` VALUES ('382','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/77/aptitude/1.html">阿卡林交电费卡拉圣诞节反馈率</a>”冻结保证金【300.00元】','1480149431');
INSERT INTO `on_mysms` VALUES ('383','2','0','0','0','0','解冻保证金','0','0','撤拍<a href="/Home/Auction/details/pid/77/aptitude/1.html">【阿卡林交电费卡拉圣诞节反馈率】</a>解冻保证金300.00元！','1480149438');
INSERT INTO `on_mysms` VALUES ('384','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/78/aptitude/1.html">阿卡林交电费卡拉圣诞节反馈率</a>”冻结保证金【300.00元】','1480149519');
INSERT INTO `on_mysms` VALUES ('385','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/79/aptitude/1.html">将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况</a>”冻结保证金【300.00元】','1480149601');
INSERT INTO `on_mysms` VALUES ('386','2','0','0','0','0','解冻保证金','0','0','撤拍<a href="/Home/Auction/details/pid/78/aptitude/1.html">【阿卡林交电费卡拉圣诞节反馈率】</a>解冻保证金300.00元！','1480149999');
INSERT INTO `on_mysms` VALUES ('387','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/80/aptitude/1.html">阿卡林交电费卡拉圣诞节反馈率</a>”冻结保证金【300.00元】','1480150083');
INSERT INTO `on_mysms` VALUES ('388','2','0','0','0','0','解冻保证金','0','0','撤拍<a href="/Home/Auction/details/pid/80/aptitude/1.html">【阿卡林交电费卡拉圣诞节反馈率】</a>解冻保证金300.00元！','1480152506');
INSERT INTO `on_mysms` VALUES ('389','2','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/81/aptitude/1.html">阿卡林交电费卡拉圣诞节反馈率</a>”冻结保证金【300.00元】','1480152549');
INSERT INTO `on_mysms` VALUES ('390','2','0','0','0','0','解冻保证金','0','0','撤拍<a href="/Home/Auction/details/pid/81/aptitude/1.html">【阿卡林交电费卡拉圣诞节反馈率】</a>解冻保证金300.00元！','1480152559');
INSERT INTO `on_mysms` VALUES ('391','2','0','0','0','0','解冻保证金','0','0','拍品流拍<a href="/Home/Auction/details/pid/79/aptitude/1.html">【将阿克苏大黄蜂骄傲含税单价法律思考交电费卡拉斯的境况】</a>解冻保证金300.00元！','1480555624');
INSERT INTO `on_mysms` VALUES ('392','2','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/82/aptitude/1.html">拉克丝的减肥卡拉胶sd卡浪费就阿隆索快递费】</a>”上架！','1480565066');
INSERT INTO `on_mysms` VALUES ('393','3','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/82/aptitude/1.html">拉克丝的减肥卡拉胶sd卡浪费就阿隆索快递费】</a>”上架！','1480565066');
INSERT INTO `on_mysms` VALUES ('394','1','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/82/aptitude/1.html">拉克丝的减肥卡拉胶sd卡浪费就阿隆索快递费】</a>”上架！','1480565066');
INSERT INTO `on_mysms` VALUES ('395','2','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/82/aptitude/1.html">拉克丝的减肥卡拉胶sd卡浪费就阿隆索快递费</a>”冻结保证金【100.00元】','1480943909');
INSERT INTO `on_mysms` VALUES ('396','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/82/aptitude/1.html">拉克丝的减肥卡拉胶sd卡浪费就阿隆索快递费</a>”当前价【99999999.99元】，目前领先','1480943909');
INSERT INTO `on_mysms` VALUES ('397','2','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/82/aptitude/1.html">拉克丝的减肥卡拉胶sd卡浪费就阿隆索快递费</a>”出价【99999999.99元】已被超过。','1480944493');
INSERT INTO `on_mysms` VALUES ('398','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/82/aptitude/1.html">拉克丝的减肥卡拉胶sd卡浪费就阿隆索快递费</a>”当前价【99999999.99元】，目前领先','1480944493');
INSERT INTO `on_mysms` VALUES ('399','3','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/82/aptitude/1.html">拉克丝的减肥卡拉胶sd卡浪费就阿隆索快递费</a>”冻结保证金【100.00元】','1480944493');
INSERT INTO `on_mysms` VALUES ('400','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”冻结保证金【300.00元】','1481165922');
INSERT INTO `on_mysms` VALUES ('401','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”当前价【500.00元】，目前领先','1481166046');
INSERT INTO `on_mysms` VALUES ('402','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”冻结保证金【50.00元】','1481166047');
INSERT INTO `on_mysms` VALUES ('403','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”冻结保证金【300.00元】','1481166127');
INSERT INTO `on_mysms` VALUES ('404','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”当前价【200.00元】，目前领先','1481166141');
INSERT INTO `on_mysms` VALUES ('405','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”冻结保证金【50.00元】','1481166142');
INSERT INTO `on_mysms` VALUES ('406','180','0','0','0','0','系统提示','0','0','恭喜您以500.00元拍到[【<a target="_blank" href="/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>】请在2016-12-15 11:09之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481166541');
INSERT INTO `on_mysms` VALUES ('407','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”已生成订单，请在2016-12-15 11:09前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”。','1481166541');
INSERT INTO `on_mysms` VALUES ('408','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”。','1481166541');
INSERT INTO `on_mysms` VALUES ('409','180','0','0','0','0','系统提示','0','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>】请在2016-12-15 11:09之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481166541');
INSERT INTO `on_mysms` VALUES ('410','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”已生成订单，请在2016-12-15 11:09前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”。','1481166541');
INSERT INTO `on_mysms` VALUES ('411','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”。','1481166541');
INSERT INTO `on_mysms` VALUES ('412','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/3/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”冻结保证金【300.00元】','1481166827');
INSERT INTO `on_mysms` VALUES ('413','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/3/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>”上架！','1481166828');
INSERT INTO `on_mysms` VALUES ('414','180','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”扣除余额550元','1481167806');
INSERT INTO `on_mysms` VALUES ('415','180','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”','1481167806');
INSERT INTO `on_mysms` VALUES ('416','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”。','1481167806');
INSERT INTO `on_mysms` VALUES ('417','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”。','1481167806');
INSERT INTO `on_mysms` VALUES ('418','1','0','0','0','0','解冻保证金','0','0','拍品流拍<a href="/Home/Auction/details/pid/3/aptitude/1.html">【卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>解冻保证金300.00元！','1481181967');
INSERT INTO `on_mysms` VALUES ('419','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”卖家已发货，请保持电话畅通以便顺利收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”。','1481184919');
INSERT INTO `on_mysms` VALUES ('420','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”您已发货，等待买家确认收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”。','1481184919');
INSERT INTO `on_mysms` VALUES ('421','1','0','0','0','0','解冻保证金','0','0','买家确认收到<a href="/Home/Auction/details/pid/1/aptitude/1.html">【卡拉斯经典款浪费骄傲sd卡浪费】</a>解冻保证金300.00元！','1481185472');
INSERT INTO `on_mysms` VALUES ('422','1','0','0','0','0','交易收入','0','0','买家确认收到拍品“<a href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”，拍品成交价：500.00元+运费：100.00元=订单总额：600元，扣除网站佣金：100.00元后收入500元','1481185473');
INSERT INTO `on_mysms` VALUES ('423','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”您确认收货，请对卖家做出评价，其他小伙伴需要您的建议哦！商品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”。','1481185473');
INSERT INTO `on_mysms` VALUES ('424','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654118114/aptitude/1.html">BID148116654118114</a>”买家已确认收货，买家将对您的商品做出评价！商品：“<a target="_blank" href="/Home/Auction/details/pid/1/aptitude/1.html">卡拉斯经典款浪费骄傲sd卡浪费</a>”。','1481185473');
INSERT INTO `on_mysms` VALUES ('425','180','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”扣除余额250元','1481249811');
INSERT INTO `on_mysms` VALUES ('426','180','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”','1481249811');
INSERT INTO `on_mysms` VALUES ('427','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”。','1481249811');
INSERT INTO `on_mysms` VALUES ('428','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”。','1481249811');
INSERT INTO `on_mysms` VALUES ('429','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”卖家已发货，请保持电话畅通以便顺利收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”。','1481249922');
INSERT INTO `on_mysms` VALUES ('430','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”您已发货，等待买家确认收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”。','1481249922');
INSERT INTO `on_mysms` VALUES ('431','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”冻结保证金【300.00元】','1481250319');
INSERT INTO `on_mysms` VALUES ('432','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的】</a>”上架！','1481250320');
INSERT INTO `on_mysms` VALUES ('433','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”当前价【200.00元】，目前领先','1481250359');
INSERT INTO `on_mysms` VALUES ('434','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”冻结保证金【50.00元】','1481250360');
INSERT INTO `on_mysms` VALUES ('435','180','0','0','0','0','系统提示','0','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>】请在2016-12-16 10:28之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481250481');
INSERT INTO `on_mysms` VALUES ('436','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”已生成订单，请在2016-12-16 10:28前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481250481');
INSERT INTO `on_mysms` VALUES ('437','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481250481');
INSERT INTO `on_mysms` VALUES ('438','180','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”扣除余额250元','1481250509');
INSERT INTO `on_mysms` VALUES ('439','180','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”','1481250509');
INSERT INTO `on_mysms` VALUES ('440','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481250509');
INSERT INTO `on_mysms` VALUES ('441','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481250509');
INSERT INTO `on_mysms` VALUES ('442','1','0','0','0','0','解冻保证金','0','0','买家确认收到<a href="/Home/Auction/details/pid/2/aptitude/1.html">【啥快递龙卷风卡拉斯蒂芬将快乐】</a>解冻保证金300.00元！','1481251130');
INSERT INTO `on_mysms` VALUES ('443','1','0','0','0','0','交易收入','0','0','买家确认收到拍品“<a href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”，拍品成交价：200.00元+运费：100.00元=订单总额：300元，扣除网站佣金：40.00元后收入260元','1481251131');
INSERT INTO `on_mysms` VALUES ('444','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”您确认收货，请对卖家做出评价，其他小伙伴需要您的建议哦！商品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”。','1481251153');
INSERT INTO `on_mysms` VALUES ('445','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148116654173375/aptitude/1.html">BID148116654173375</a>”买家已确认收货，买家将对您的商品做出评价！商品：“<a target="_blank" href="/Home/Auction/details/pid/2/aptitude/1.html">啥快递龙卷风卡拉斯蒂芬将快乐</a>”。','1481251153');
INSERT INTO `on_mysms` VALUES ('446','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”卖家已发货，请保持电话畅通以便顺利收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481251984');
INSERT INTO `on_mysms` VALUES ('447','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”您已发货，等待买家确认收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481251984');
INSERT INTO `on_mysms` VALUES ('448','1','0','0','0','0','解冻保证金','0','0','买家确认收到<a href="/Home/Auction/details/pid/4/aptitude/1.html">【了空间按快了速度激发垃圾似的】</a>解冻保证金300.00元！','1481252118');
INSERT INTO `on_mysms` VALUES ('449','1','0','0','0','0','交易收入','0','0','买家确认收到拍品“<a href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”，拍品成交价：200.00元+运费：100.00元=订单总额：300元，扣除网站佣金：40.00元后收入260元','1481252118');
INSERT INTO `on_mysms` VALUES ('450','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”您确认收货，请对卖家做出评价，其他小伙伴需要您的建议哦！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481252119');
INSERT INTO `on_mysms` VALUES ('451','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”买家已确认收货，买家将对您的商品做出评价！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481252119');
INSERT INTO `on_mysms` VALUES ('452','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”您的订单已过期并扣除保证金！商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481252251');
INSERT INTO `on_mysms` VALUES ('453','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148125048193280/aptitude/1.html">BID148125048193280</a>”买家未在2016-12-16 10:28前支付订单，买家订单已过期并扣除保证金商品：“<a target="_blank" href="/Home/Auction/details/pid/4/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481252251');
INSERT INTO `on_mysms` VALUES ('454','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/5/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”冻结保证金【300.00元】','1481252528');
INSERT INTO `on_mysms` VALUES ('455','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/5/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>”上架！','1481252529');
INSERT INTO `on_mysms` VALUES ('456','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/6/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】','1481252732');
INSERT INTO `on_mysms` VALUES ('457','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/6/aptitude/1.html">克拉的肌肤看见了快递劫匪】</a>”上架！','1481252733');
INSERT INTO `on_mysms` VALUES ('458','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/6/aptitude/1.html">克拉的肌肤看见了快递劫匪】</a>”上架！','1481252924');
INSERT INTO `on_mysms` VALUES ('459','1','0','0','0','0','解冻保证金','0','0','撤拍<a href="/Home/Auction/details/pid/5/aptitude/1.html">【卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>解冻保证金300.00元！','1481254002');
INSERT INTO `on_mysms` VALUES ('460','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”冻结保证金【300.00元】','1481593382');
INSERT INTO `on_mysms` VALUES ('461','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的】</a>”上架！','1481593384');
INSERT INTO `on_mysms` VALUES ('462','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”当前价【200.00元】，目前领先','1481593433');
INSERT INTO `on_mysms` VALUES ('463','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”冻结保证金【50.00元】','1481593434');
INSERT INTO `on_mysms` VALUES ('464','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金【300.00元】','1481593524');
INSERT INTO `on_mysms` VALUES ('465','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的】</a>”上架！','1481593525');
INSERT INTO `on_mysms` VALUES ('466','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金【50.00元】','1481593544');
INSERT INTO `on_mysms` VALUES ('467','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”当前价【300.00元】，目前领先','1481593544');
INSERT INTO `on_mysms` VALUES ('468','180','0','0','0','0','系统提示','0','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】请在2016-12-20 09:46之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481593563');
INSERT INTO `on_mysms` VALUES ('469','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159356345513/aptitude/1.html">BID148159356345513</a>”已生成订单，请在2016-12-20 09:46前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”。','1481593563');
INSERT INTO `on_mysms` VALUES ('470','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159356345513/aptitude/1.html">BID148159356345513</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/7/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”。','1481593563');
INSERT INTO `on_mysms` VALUES ('471','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】','1481593582');
INSERT INTO `on_mysms` VALUES ('472','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪】</a>”上架！','1481593584');
INSERT INTO `on_mysms` VALUES ('473','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”当前价【10.00元】，目前领先','1481593594');
INSERT INTO `on_mysms` VALUES ('474','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【50.00元】','1481593595');
INSERT INTO `on_mysms` VALUES ('475','1','0','0','0','0','解冻保证金','0','0','买家未按时支付<a href="/Home/Auction/details/pid/7/aptitude/1.html">【卡拉斯交电费卢卡斯交电费卡拉斯的】</a>解冻保证金300.00元！','1481599229');
INSERT INTO `on_mysms` VALUES ('476','180','0','0','0','0','系统提示','0','0','恭喜您以300.00元拍到[【<a target="_blank" href="/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>】请在2016-12-20 11:20之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481599229');
INSERT INTO `on_mysms` VALUES ('477','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159922987522/aptitude/1.html">BID148159922987522</a>”已生成订单，请在2016-12-20 11:20前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1481599229');
INSERT INTO `on_mysms` VALUES ('478','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159922987522/aptitude/1.html">BID148159922987522</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1481599229');
INSERT INTO `on_mysms` VALUES ('479','180','0','0','0','0','系统提示','0','0','恭喜您以10.00元拍到[【<a target="_blank" href="/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>】请在2016-12-20 11:20之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481599230');
INSERT INTO `on_mysms` VALUES ('480','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”已生成订单，请在2016-12-20 11:20前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1481599230');
INSERT INTO `on_mysms` VALUES ('481','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1481599230');
INSERT INTO `on_mysms` VALUES ('482','180','0','0','0','0','扣除保证金','0','0','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','1481599902');
INSERT INTO `on_mysms` VALUES ('483','1','0','0','0','0','收入保证金','0','0','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','1481599902');
INSERT INTO `on_mysms` VALUES ('484','180','0','0','0','0','扣除保证金','0','0','您未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','1481599927');
INSERT INTO `on_mysms` VALUES ('485','1','0','0','0','0','收入保证金','0','0','买家未在有效期支付拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金40元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','1481599927');
INSERT INTO `on_mysms` VALUES ('486','180','0','0','0','0','扣除保证金','0','0','您未在有效期支付，拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','1481621338');
INSERT INTO `on_mysms` VALUES ('487','1','0','0','0','0','收入保证金','0','0','买家未在有效期支付，拍品【<a href="http://192.168.1.238/Auction/details/pid/7.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】，扣除保证金50元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159356345513.html">BID148159356345513</a>','1481621338');
INSERT INTO `on_mysms` VALUES ('488','180','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”扣除余额-20元','1481766901');
INSERT INTO `on_mysms` VALUES ('489','180','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”','1481766901');
INSERT INTO `on_mysms` VALUES ('490','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1481766901');
INSERT INTO `on_mysms` VALUES ('491','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1481766901');
INSERT INTO `on_mysms` VALUES ('492','180','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/9/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”货款【30元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148159923037371/aptitude/1.html">BID148159923037371</a>”','1481794272');
INSERT INTO `on_mysms` VALUES ('493','180','0','0','0','0','保证金解冻','0','0','按时(在线)支付拍品订单<a href="/Home/Auction/details/pid/9/aptitude/1.html">【克拉的肌肤看见了快递劫匪】</a>解冻缴纳拍品保证金20.00元','1481794272');
INSERT INTO `on_mysms` VALUES ('494','180','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148159922987522/aptitude/1.html">BID148159922987522</a>”扣除余额300元','1481794581');
INSERT INTO `on_mysms` VALUES ('495','180','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”货款【50.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148159922987522/aptitude/1.html">BID148159922987522</a>”','1481794581');
INSERT INTO `on_mysms` VALUES ('496','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159922987522/aptitude/1.html">BID148159922987522</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1481794581');
INSERT INTO `on_mysms` VALUES ('497','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148159922987522/aptitude/1.html">BID148159922987522</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/8/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1481794581');
INSERT INTO `on_mysms` VALUES ('498','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金【300.00元】','1481794743');
INSERT INTO `on_mysms` VALUES ('499','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的】</a>”上架！','1481794744');
INSERT INTO `on_mysms` VALUES ('500','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”当前价【300.00元】，目前领先','1481794788');
INSERT INTO `on_mysms` VALUES ('501','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金【600.00元】','1481794788');
INSERT INTO `on_mysms` VALUES ('502','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】','1481794821');
INSERT INTO `on_mysms` VALUES ('503','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪】</a>”上架！','1481794822');
INSERT INTO `on_mysms` VALUES ('504','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”当前价【10.00元】，目前领先','1481794836');
INSERT INTO `on_mysms` VALUES ('505','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【50.00元】','1481794837');
INSERT INTO `on_mysms` VALUES ('506','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”冻结保证金【300.00元】','1481794943');
INSERT INTO `on_mysms` VALUES ('507','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的】</a>”上架！','1481794943');
INSERT INTO `on_mysms` VALUES ('508','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”当前价【200.00元】，目前领先','1481794955');
INSERT INTO `on_mysms` VALUES ('509','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”冻结保证金【600.00元】','1481794955');
INSERT INTO `on_mysms` VALUES ('510','180','0','0','0','0','系统提示','0','0','恭喜您以10.00元拍到[【<a target="_blank" href="/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>】请在2016-12-22 17:43之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481794981');
INSERT INTO `on_mysms` VALUES ('511','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179498134885/aptitude/1.html">BID148179498134885</a>”已生成订单，请在2016-12-22 17:43前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1481794981');
INSERT INTO `on_mysms` VALUES ('512','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179498134885/aptitude/1.html">BID148179498134885</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1481794981');
INSERT INTO `on_mysms` VALUES ('513','180','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/11/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”货款【20元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148179498134885/aptitude/1.html">BID148179498134885</a>”','1481795001');
INSERT INTO `on_mysms` VALUES ('514','180','0','0','0','0','保证金解冻','0','0','按时(在线)支付拍品订单<a href="/Home/Auction/details/pid/11/aptitude/1.html">【克拉的肌肤看见了快递劫匪】</a>解冻缴纳拍品保证金30.00元','1481795001');
INSERT INTO `on_mysms` VALUES ('515','180','0','0','0','0','系统提示','0','0','恭喜您以200.00元拍到[【<a target="_blank" href="/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>】请在2016-12-22 17:45之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481795101');
INSERT INTO `on_mysms` VALUES ('516','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179510117691/aptitude/1.html">BID148179510117691</a>”已生成订单，请在2016-12-22 17:45前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481795101');
INSERT INTO `on_mysms` VALUES ('517','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179510117691/aptitude/1.html">BID148179510117691</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481795101');
INSERT INTO `on_mysms` VALUES ('518','180','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”货款【220元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148179510117691/aptitude/1.html">BID148179510117691</a>”','1481795268');
INSERT INTO `on_mysms` VALUES ('519','180','0','0','0','0','保证金解冻','0','0','按时(在线)支付拍品订单<a href="/Home/Auction/details/pid/12/aptitude/1.html">【了空间按快了速度激发垃圾似的】</a>解冻缴纳拍品保证金380.00元','1481795268');
INSERT INTO `on_mysms` VALUES ('520','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179510117691/aptitude/1.html">BID148179510117691</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481795268');
INSERT INTO `on_mysms` VALUES ('521','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179510117691/aptitude/1.html">BID148179510117691</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/12/aptitude/1.html">了空间按快了速度激发垃圾似的</a>”。','1481795268');
INSERT INTO `on_mysms` VALUES ('522','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】','1481795853');
INSERT INTO `on_mysms` VALUES ('523','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪】</a>”上架！','1481795853');
INSERT INTO `on_mysms` VALUES ('524','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【50.00元】','1481795868');
INSERT INTO `on_mysms` VALUES ('525','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”当前价【10.00元】，目前领先','1481795868');
INSERT INTO `on_mysms` VALUES ('526','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”冻结保证金【300.00元】','1481795946');
INSERT INTO `on_mysms` VALUES ('527','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>”上架！','1481795946');
INSERT INTO `on_mysms` VALUES ('528','180','0','0','0','0','参拍冻结保证金','0','0','参拍“<a href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”冻结保证金【50.00元】','1481795959');
INSERT INTO `on_mysms` VALUES ('529','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”当前价【600.00元】，目前领先','1481795959');
INSERT INTO `on_mysms` VALUES ('530','1','0','0','0','0','扣除保证金','0','0','您未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/12.html">了空间按快了速度激发垃圾似的</a>】，扣除保证金300.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148179510117691.html">BID148179510117691</a>','1481796529');
INSERT INTO `on_mysms` VALUES ('531','180','0','0','0','0','收入保证金','0','0','卖家未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/12.html">了空间按快了速度激发垃圾似的</a>】，扣除保证金300元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148179510117691.html">BID148179510117691</a>','1481796529');
INSERT INTO `on_mysms` VALUES ('532','180','0','0','0','0','系统提示','0','0','恭喜您以10.00元拍到[【<a target="_blank" href="/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>】请在2016-12-22 18:08之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481796529');
INSERT INTO `on_mysms` VALUES ('533','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179652969363/aptitude/1.html">BID148179652969363</a>”已生成订单，请在2016-12-22 18:08前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1481796529');
INSERT INTO `on_mysms` VALUES ('534','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179652969363/aptitude/1.html">BID148179652969363</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/13/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1481796529');
INSERT INTO `on_mysms` VALUES ('535','180','0','0','0','0','系统提示','0','0','恭喜您以600.00元拍到[【<a target="_blank" href="/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>】请在2016-12-22 18:08之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481796530');
INSERT INTO `on_mysms` VALUES ('536','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179653013440/aptitude/1.html">BID148179653013440</a>”已生成订单，请在2016-12-22 18:08前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1481796530');
INSERT INTO `on_mysms` VALUES ('537','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179653013440/aptitude/1.html">BID148179653013440</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1481796530');
INSERT INTO `on_mysms` VALUES ('538','1','0','0','0','0','扣除保证金','0','0','您未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/11.html">克拉的肌肤看见了快递劫匪</a>】，扣除保证金300.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148179498134885.html">BID148179498134885</a>','1481797600');
INSERT INTO `on_mysms` VALUES ('539','180','0','0','0','0','收入保证金','0','0','卖家未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/11.html">克拉的肌肤看见了快递劫匪</a>】，扣除保证金240元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148179498134885.html">BID148179498134885</a>','1481797601');
INSERT INTO `on_mysms` VALUES ('540','180','0','0','0','0','保证金解冻','0','0','按时(线下)支付拍品订单<a href="/Home/Auction/details/pid/14/aptitude/1.html">【卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>解冻缴纳拍品保证金50.00元','1481879072');
INSERT INTO `on_mysms` VALUES ('541','180','0','0','0','0','系统提示','0','0','恭喜您以300.00元拍到[【<a target="_blank" href="/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>】请在2016-12-24 08:29之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1481934564');
INSERT INTO `on_mysms` VALUES ('542','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148193456477765/aptitude/1.html">BID148193456477765</a>”已生成订单，请在2016-12-24 08:29前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1481934565');
INSERT INTO `on_mysms` VALUES ('543','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148193456477765/aptitude/1.html">BID148193456477765</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/10/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1481934565');
INSERT INTO `on_mysms` VALUES ('544','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/15/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结保证金【300.00元】','1481940375');
INSERT INTO `on_mysms` VALUES ('545','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/15/aptitude/1.html">克拉的肌肤看见了快递劫匪】</a>”上架！','1481940377');
INSERT INTO `on_mysms` VALUES ('546','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179653013440/aptitude/1.html">BID148179653013440</a>”卖家已发货，请保持电话畅通以便顺利收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1481941111');
INSERT INTO `on_mysms` VALUES ('547','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179653013440/aptitude/1.html">BID148179653013440</a>”您已发货，等待买家确认收货！商品：“<a target="_blank" href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1481941111');
INSERT INTO `on_mysms` VALUES ('548','522','0','0','0','0','管理员充值','0','0','管理员充值信用额度【1000元】，单号aad148229209879470','1482292098');
INSERT INTO `on_mysms` VALUES ('549','522','0','0','0','0','发布拍卖冻结信誉额度','0','0','发布拍卖：“<a href="/Auction/details/pid/16/aptitude/1.html">阿里斯顿疯狂辣椒水电费</a>”冻结信誉额度【300.00元】','1482312443');
INSERT INTO `on_mysms` VALUES ('550','524','0','0','0','0','管理员充值','0','0','管理员充值余额【1000元】，单号aad148275849563520','1482758495');
INSERT INTO `on_mysms` VALUES ('551','523','0','0','0','0','管理员充值','0','0','管理员充值余额【1000元】，单号aad148275851770020','1482758517');
INSERT INTO `on_mysms` VALUES ('552','523','0','0','0','0','管理员扣除','0','0','管理员扣除余额【1000元】，单号ami14827587719836','1482758771');
INSERT INTO `on_mysms` VALUES ('553','523','0','0','0','0','管理员充值','0','0','管理员充值信用额度【1000元】，单号aad148275878169213','1482758781');
INSERT INTO `on_mysms` VALUES ('554','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”当前价【300.00元】，目前领先','1482760596');
INSERT INTO `on_mysms` VALUES ('555','523','0','0','0','0','参拍冻结信誉额度','0','0','参拍专场“<a href="/Home/Special/speul/sid/1/aptitude/1.html">专场拍卖测试001</a>”下拍品“<a href="/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结信誉额度【100.00元】','1482760604');
INSERT INTO `on_mysms` VALUES ('556','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”当前价【200.00元】，目前领先','1482760610');
INSERT INTO `on_mysms` VALUES ('557','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”当前价【300.00元】，目前领先','1482760622');
INSERT INTO `on_mysms` VALUES ('558','524','0','0','0','0','参拍冻结保证金','0','0','参拍专场“<a href="/Home/Special/speul/sid/1/aptitude/1.html">专场拍卖测试001</a>”下拍品“<a href="/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”冻结保证金【100.00元】','1482760648');
INSERT INTO `on_mysms` VALUES ('559','523','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”出价【300.00元】已被超过。','1482760648');
INSERT INTO `on_mysms` VALUES ('560','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”当前价【301.00元】，目前领先','1482760648');
INSERT INTO `on_mysms` VALUES ('561','523','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”出价【200.00元】已被超过。','1482760662');
INSERT INTO `on_mysms` VALUES ('562','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”当前价【201.00元】，目前领先','1482760662');
INSERT INTO `on_mysms` VALUES ('563','523','0','0','0','0','竞拍出价被超越','0','0','您参拍拍品：“<a target="_blank" href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”出价【300.00元】已被超过。','1482760673');
INSERT INTO `on_mysms` VALUES ('564','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”当前价【301.00元】，目前领先','1482760673');
INSERT INTO `on_mysms` VALUES ('565','524','0','0','0','0','系统提示','0','0','恭喜您以301.00元拍到【<a target="_blank" href="/Special/speul/sid/1/aptitude/1.html">专场拍卖测试001</a>】专场下【<a target="_blank" href="/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>】请在2017-01-02 22:00之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1482760801');
INSERT INTO `on_mysms` VALUES ('566','524','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276080104251/aptitude/1.html">BID148276080104251</a>”已生成订单，请在2017-01-02 22:00前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1482760801');
INSERT INTO `on_mysms` VALUES ('567','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276080104251/aptitude/1.html">BID148276080104251</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1482760801');
INSERT INTO `on_mysms` VALUES ('568','524','0','0','0','0','系统提示','0','0','恭喜您以201.00元拍到【<a target="_blank" href="/Special/speul/sid/1/aptitude/1.html">专场拍卖测试001</a>】专场下【<a target="_blank" href="/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>】请在2017-01-02 22:00之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1482760808');
INSERT INTO `on_mysms` VALUES ('569','524','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276080846045/aptitude/1.html">BID148276080846045</a>”已生成订单，请在2017-01-02 22:00前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”。','1482760808');
INSERT INTO `on_mysms` VALUES ('570','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276080846045/aptitude/1.html">BID148276080846045</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”。','1482760808');
INSERT INTO `on_mysms` VALUES ('571','523','0','0','0','0','保证金解冻','0','0','解冻信誉额度100.00元；','1482760815');
INSERT INTO `on_mysms` VALUES ('572','524','0','0','0','0','系统提示','0','0','恭喜您以301.00元拍到【<a target="_blank" href="/Special/speul/sid/1/aptitude/1.html">专场拍卖测试001</a>】专场下【<a target="_blank" href="/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>】请在2017-01-02 22:00之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1482760815');
INSERT INTO `on_mysms` VALUES ('573','524','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276081586549/aptitude/1.html">BID148276081586549</a>”已生成订单，请在2017-01-02 22:00前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1482760815');
INSERT INTO `on_mysms` VALUES ('574','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276081586549/aptitude/1.html">BID148276081586549</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1482760815');
INSERT INTO `on_mysms` VALUES ('575','524','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148276081586549/aptitude/1.html">BID148276081586549</a>”扣除余额311元','1482760930');
INSERT INTO `on_mysms` VALUES ('576','524','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276081586549/aptitude/1.html">BID148276081586549</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1482760930');
INSERT INTO `on_mysms` VALUES ('577','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276081586549/aptitude/1.html">BID148276081586549</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/19/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1482760930');
INSERT INTO `on_mysms` VALUES ('578','524','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148276080846045/aptitude/1.html">BID148276080846045</a>”扣除余额211元','1482760949');
INSERT INTO `on_mysms` VALUES ('579','524','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276080846045/aptitude/1.html">BID148276080846045</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”。','1482760949');
INSERT INTO `on_mysms` VALUES ('580','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276080846045/aptitude/1.html">BID148276080846045</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/18/aptitude/1.html">卡拉斯交电费卢卡斯交电费卡拉斯的</a>”。','1482760949');
INSERT INTO `on_mysms` VALUES ('581','524','0','0','0','0','支付订单','0','0','支付商品：“<a href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”订单号：“<a href="/Home/Member/order_details/order_no/BID148276080104251/aptitude/1.html">BID148276080104251</a>”扣除余额211元','1482760979');
INSERT INTO `on_mysms` VALUES ('582','524','0','0','0','0','保证金抵货款','0','0','保证金抵商品：“<a href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”货款【100.00元】！订单号：“<a href="/Home/Member/order_details/order_no/BID148276080104251/aptitude/1.html">BID148276080104251</a>”','1482760979');
INSERT INTO `on_mysms` VALUES ('583','524','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276080104251/aptitude/1.html">BID148276080104251</a>”您已支付，等待卖家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1482760979');
INSERT INTO `on_mysms` VALUES ('584','1','0','0','0','0','订单状态通知','0','1','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148276080104251/aptitude/1.html">BID148276080104251</a>”买家已支付，请尽快给买家发货！商品：“<a target="_blank" href="/Home/Auction/details/pid/17/aptitude/1.html">卡就死掉了咖啡将拉克丝的</a>”。','1482760979');
INSERT INTO `on_mysms` VALUES ('585','1','0','0','0','0','解冻保证金','0','1','拍品流拍<a href="/Home/Auction/details/pid/15/aptitude/1.html">【克拉的肌肤看见了快递劫匪】</a>解冻保证金300.00元！','1483147595');
INSERT INTO `on_mysms` VALUES ('586','522','0','0','0','0','解冻信誉','0','0','拍品流拍<a href="/Home/Auction/details/pid/16/aptitude/1.html">【阿里斯顿疯狂辣椒水电费】</a>解冻信誉300.00元！','1483147603');
INSERT INTO `on_mysms` VALUES ('587','1','0','0','0','0','发布拍卖冻结保证金','0','0','发布拍卖：“<a href="/Auction/details/pid/25/aptitude/1.html">顺口溜的卷发卡洛斯大姐夫</a>”冻结保证金【300.00元】','1483607602');
INSERT INTO `on_mysms` VALUES ('588','180','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/25/aptitude/1.html">顺口溜的卷发卡洛斯大姐夫】</a>”上架！','1483607609');
INSERT INTO `on_mysms` VALUES ('589','524','0','0','0','0','拍品上架提醒','0','0','卖家[长垣昂酷网络有限公司]的拍品“<a href="/Home/Auction/details/pid/25/aptitude/1.html">顺口溜的卷发卡洛斯大姐夫】</a>”上架！','1483607609');
INSERT INTO `on_mysms` VALUES ('590','1','0','0','0','0','解冻保证金','0','0','买家未按时支付<a href="/Home/Auction/details/pid/10/aptitude/1.html">【卡就死掉了咖啡将拉克丝的】</a>解冻保证金300.00元！','1483756552');
INSERT INTO `on_mysms` VALUES ('591','180','0','0','0','0','扣除保证金','0','0','您未在有效期支付，拍品【<a href="http://192.168.1.238/Auction/details/pid/10.html">卡就死掉了咖啡将拉克丝的</a>】，扣除保证金600.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148193456477765.html">BID148193456477765</a>','1483756559');
INSERT INTO `on_mysms` VALUES ('592','1','0','0','0','0','收入保证金','0','0','买家未在有效期支付，拍品【<a href="http://192.168.1.238/Auction/details/pid/10.html">卡就死掉了咖啡将拉克丝的</a>】，扣除保证金480元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148193456477765.html">BID148193456477765</a>','1483756559');
INSERT INTO `on_mysms` VALUES ('593','1','0','0','0','0','扣除保证金','0','0','您未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/8.html">卡就死掉了咖啡将拉克丝的</a>】，扣除保证金300.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159922987522.html">BID148159922987522</a>','1483756565');
INSERT INTO `on_mysms` VALUES ('594','180','0','0','0','0','收入保证金','0','0','卖家未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/8.html">卡就死掉了咖啡将拉克丝的</a>】，扣除保证金240元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159922987522.html">BID148159922987522</a>','1483756572');
INSERT INTO `on_mysms` VALUES ('595','1','0','0','0','0','扣除保证金','0','0','您未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/9.html">克拉的肌肤看见了快递劫匪</a>】，扣除保证金300.00元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159923037371.html">BID148159923037371</a>','1483756572');
INSERT INTO `on_mysms` VALUES ('596','180','0','0','0','0','收入保证金','0','0','卖家未在有效期发货，拍品【<a href="http://192.168.1.238/Auction/details/pid/9.html">克拉的肌肤看见了快递劫匪</a>】，扣除保证金240元。订单号：<a href="http://192.168.1.238/Member/order_details/order_no/BID148159923037371.html">BID148159923037371</a>','1483756578');
INSERT INTO `on_mysms` VALUES ('597','1','0','0','0','0','解冻保证金','0','0','买家确认收到<a href="/Home/Auction/details/pid/14/aptitude/1.html">【卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>解冻保证金300.00元！','1483756709');
INSERT INTO `on_mysms` VALUES ('598','1','0','0','0','0','交易收入','0','0','买家确认收到拍品“<a href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡】</a>”；拍品订单：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179653013440/aptitude/1.html">BID148179653013440</a>”，拍品成交价：600.00元+运费：10.00元=订单总额：610元，扣除网站佣金：120.00元后收入490元','1483756717');
INSERT INTO `on_mysms` VALUES ('599','180','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179653013440/aptitude/1.html">BID148179653013440</a>”您确认收货，请对卖家做出评价，其他小伙伴需要您的建议哦！商品：“<a target="_blank" href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1483756723');
INSERT INTO `on_mysms` VALUES ('600','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID148179653013440/aptitude/1.html">BID148179653013440</a>”买家已确认收货，买家将对您的商品做出评价！商品：“<a target="_blank" href="/Home/Auction/details/pid/14/aptitude/1.html">卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡</a>”。','1483756723');
INSERT INTO `on_mysms` VALUES ('601','523','0','0','0','0','参拍冻结信誉额度','0','0','参拍专场“<a href="/Home/Special/speul/sid/6/aptitude/1.html">卡拉圣诞节快乐飞捐卡</a>”下拍品“<a href="/Auction/details/pid/23/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”冻结信誉额度【100.00元】','1484041091');
INSERT INTO `on_mysms` VALUES ('602','1','0','0','0','0','拍品出价更新','0','0','拍品：“<a target="_blank" href="/Home/Auction/details/pid/23/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”当前价【11.00元】，目前领先','1484041091');
INSERT INTO `on_mysms` VALUES ('603','1','0','0','0','0','解冻保证金','0','0','拍品流拍<a href="/Home/Auction/details/pid/25/aptitude/1.html">【顺口溜的卷发卡洛斯大姐夫】</a>解冻保证金300.00元！','1484365396');
INSERT INTO `on_mysms` VALUES ('604','523','0','0','0','0','系统提示','0','0','恭喜您以11.00元拍到【<a target="_blank" href="/Special/speul/sid/6/aptitude/1.html">卡拉圣诞节快乐飞捐卡</a>】专场下【<a target="_blank" href="/Auction/details/pid/23/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>】请在2017-01-30 09:30之前支付完成支付。否则将扣除您参与该拍卖所缴纳的保证金或信用额度！','1485135042');
INSERT INTO `on_mysms` VALUES ('605','523','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID14851350425910/aptitude/1.html">BID14851350425910</a>”已生成订单，请在2017-01-30 09:30前支付订单！商品：“<a target="_blank" href="/Home/Auction/details/pid/23/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1485135042');
INSERT INTO `on_mysms` VALUES ('606','1','0','0','0','0','订单状态通知','0','0','订单号：“<a target="_blank" href="/Home/Member/order_details/order_no/BID14851350425910/aptitude/1.html">BID14851350425910</a>”已生成订单，等待买家支付！商品：“<a target="_blank" href="/Home/Auction/details/pid/23/aptitude/1.html">克拉的肌肤看见了快递劫匪</a>”。','1485135042');


# 数据库表：on_navigation 数据信息
INSERT INTO `on_navigation` VALUES ('1','0','网站主导航','_self','','0');
INSERT INTO `on_navigation` VALUES ('2','0','网站底部导航','_self','','0');
INSERT INTO `on_navigation` VALUES ('3','0','网站推荐链接','_self','','0');
INSERT INTO `on_navigation` VALUES ('4','1','添加的导航','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('5','14','一口价','_self','','0');
INSERT INTO `on_navigation` VALUES ('6','2','合作媒体','_self','','0');
INSERT INTO `on_navigation` VALUES ('7','2','隐私保护','','','0');
INSERT INTO `on_navigation` VALUES ('8','2','版权声明','','','0');
INSERT INTO `on_navigation` VALUES ('9','2','诚聘英才','','','0');
INSERT INTO `on_navigation` VALUES ('10','14','二手车拍卖','_self','','0');
INSERT INTO `on_navigation` VALUES ('11','3','二手车拍卖','_self','','3');
INSERT INTO `on_navigation` VALUES ('12','11','正在拍卖','_self','','0');
INSERT INTO `on_navigation` VALUES ('13','11','即将拍卖','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('14','3','艺术品拍卖','_self','javascript:void(0);','2');
INSERT INTO `on_navigation` VALUES ('15','14','现代工艺','_self','','0');
INSERT INTO `on_navigation` VALUES ('16','14','珠宝玉器','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('17','3','拍卖咨询','_self','javascript:void(0);','1');
INSERT INTO `on_navigation` VALUES ('18','17','我要拍卖','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('19','17','如何拍卖','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('20','17','发布二手车','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('21','3','昂酷网络','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('22','21','拍卖系统','_self','http://www.oncoo.net','0');
INSERT INTO `on_navigation` VALUES ('23','21','竞拍系统','_self','http://www.oncoo.net','0');
INSERT INTO `on_navigation` VALUES ('24','21','在线拍卖程序','_self','http://www.baidu.com','0');
INSERT INTO `on_navigation` VALUES ('25','21','怎么样拍成功','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('26','21','如何购买呢','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('27','0','天上掉下林妹妹','_self','javascript:void(0);','0');
INSERT INTO `on_navigation` VALUES ('28','2','一口价','_self','baidu.com','0');
INSERT INTO `on_navigation` VALUES ('29','11','拍卖资讯','_self','','0');
INSERT INTO `on_navigation` VALUES ('32','11','死地方','_self','http://www.oncoo.net','1');
INSERT INTO `on_navigation` VALUES ('30','14','收藏车拍卖','_self','index.php/Auction/index','0');
INSERT INTO `on_navigation` VALUES ('31','14','报废车拍卖','_self','index.php/Auction/index','0');


# 数据库表：on_news 数据信息
INSERT INTO `on_news` VALUES ('2','5','如何竞买','','','随着安信信托、中信信托等多家信托公司曝出房地产信托计划的兑付风险，部分房地产投资私募基金(PE)已在其中看到了机会。','1','<div class=\\\"content\\\"><p>随着安信<a href=\\\"http://licai.so/Trust/\\\" target=\\\"_blank\\\">信托</a>、<a href=\\\"http://licai.so/Trust/agency-1061/\\\" target=\\\"_blank\\\">中信信托</a>等多家信托公司曝出房地产信托计划的兑付风险，部分房地产投资<a href=\\\"http...','1363141340','1447582363','<p>随着安信<a href=\"http://licai.so/Trust/\" target=\"_blank\">信托</a>、<a href=\"http://licai.so/Trust/agency-1061/\" target=\"_blank\">中信信托</a>等多家信托公司曝出房地产信托计划的兑付风险，部分房地产投资<a href=\"http://licai.so/Simu/\" target=\"_blank\">私募</a>基金(<a href=\"http://licai.so/Pe/\" target=\"_blank\">PE</a>)已在其中看到了机会。</p><p><br/></p><p>《每日经济新闻》记者了解到，2013年房地产信托兑付压力远超2012年，其中，兑付顶峰将出现在2013年第二季度，届时全国房地产信托兑付的总规模将超过1000亿元。通过信托融资的中小房地产企业将不得不面对资金上的窘境，而这对资金充裕的PE来说，无疑将是一次“捡馅饼”的机会。</p><p><br/></p><p>风险频现挑战“刚性兑付”/</p><p><br/></p><p>上周五(3月8日)，据《21世纪经济报道》称，<a href=\"http://licai.so/Trust/agency-1002/\" target=\"_blank\">安信信托</a>因为“昆山·联邦国际资产收益财产权信托”的融资方昆山纯高投资开发有限公司无法支付到期本金，已对纯高公司进行了起诉。</p><p><br/></p><p>不过，安信信托在当日发布澄清公告称，2009年9月24日，安信信托发起并设立了总规模为人民币62700万元的“昆山-联邦国际”资产收益财产权信托。但是到2012年9月18日，昆山纯高投资开发有限公司作为信托交易文件项下借款人未能按时足额偿还信托借款。</p><p><br/></p><p>为此，安信信托已向上海市第二中级人民法院提起金融借款纠纷诉讼。并且“根据信托文件约定，信托期限已自动延长，最长至2013年9月24日。”</p><p><br/></p><p>安信信托董办工作人员称，目前信托计划已经延期了,但是公司确实已进行了部分兑付。</p><p><br/></p><p>一位信托行业人士表示，项目出了问题，信托公司一般都会先托着，但如果真的出现较大的问题，这样做就会有很大风险。</p><p><br/></p><p>事实上，信托行业的“刚性兑付”此前就已经遇到了挑战。今年1月份，中信信托关于三峡全通的贷款资金兑付问题就已引起业界震动。</p><p><br/></p><p>资料显示，中信信托于2011年12月28日发起设立，“中信制造三峡全通贷款集合资金信托计划”分4次募集信托本金共计人民币13.335亿元，为三峡全通发放流动资金贷款。</p><p><br/></p><p>三峡全通公司应当于2013年1月14日和16日分别偿还贷款本息11855万元和47247万元。中信信托称，“截至2013年1月28日，本信托计划信托专户仍未收到该两期应收本息及违约金。”因此公司决定存续的优先级信托受益权的到期日延期3个月。</p><p><br/></p><p>而中信信托方面已表示，将不会去进行刚性兑付。业界认为该事件可能成信托业首个打破刚性兑付 “行规”的案例。</p><p><br/></p><p>二季度迎新一波兑付潮/</p><p><br/></p><p>虽然信托行业已经度过了此前预期兑付风险较大的2012年。但是到了2013年，房地产信托仍然面临较大的兑付压力。</p><p><br/></p><p>据北京恒天财富相关数据统计，2013年房地产信托面临兑付本息达2800亿元，远超过2012年的1759亿元。其中，兑付顶峰将出现在2013年第二季度，届时全国房地产信托兑付的总规模将达到1301亿元。</p><p><br/></p><p>另据新时代证券发布的研报，根据每月的成立规模与月平均期限测算，2013年房地产信托到期兑付规模将达2847.9亿元，其中二季度达1247.6亿元。</p><p><br/></p><p>上海一家信托公司项目经理接受《每日经济新闻》记者采访时表示，“在房地产信托计划的兑付中，中小房地产企业的压力要大得多。他们的融资原本就比大型的房地产企业要难，风险也相对要高一些。”</p><p><br/></p><p><a href=\"http://licai.so/Simu/200287/\" target=\"_blank\">诺亚财富</a>研究部李要深则对《每日经济新闻》记者表示，目前总体来说，房地产信托没有太大的问题，相比前两年，规模和占比已经下降很多，处在一个相对安全的范围，并且房地产信托一般都有较好的抵押物。</p><p><br/></p><p>事实上，今年以来，房地产信托发展速度仍然较快。用益信托数据显示，2月份共成立房地产信托52款，募集资金162.95亿元，占总成立规模的33.98%，高于上个月29.49%的占比，较去年23%左右的占比更是显著增加。</p><p><br/></p><p>PE伺机而动</p><p><br/></p><p>对资金充裕的PE来说，房地产信托接盘的时机也可能就在今年。</p><p><br/></p><p>“房地产公司现在都缺钱，尤其是中小房地产企业，更是困难。从目前的角度来看，这块的投资价值逐渐显现出来了。”某股权投资基金相关人士称，PE投资接盘的条件主要还是看具体的项目。</p><p><br/></p><p>“从实际情况看，房地产信托有兑付风险的项目眼下还不多，只是根据趋势判断，今年的投资将有很大的操作空间，也就是找一些缺资金、项目优质的企业合作。”上述股权投资基金人士表示。</p><p><br/></p><p>据《每日经济新闻》记者不完全统计，在即将到期的房地产信托项目中，北京、上海等一线城市的项目数量有限，而鄂尔多斯、青岛等二线城市项目则多一些。</p><p><br/></p><p>上述股权投资基金人士介绍，与房地产企业的合作，模式是多种多样的。“最简单的是折价收购整个项目，然而分拆出售，但是这对PE公司的资金实力和运作的要求很高。另外，不同PE主体的参与模式也不一样。<a href=\"http://licai.so/Jgzl/\" target=\"_blank\">金融机构</a>发起的地产基金主要是做债权，和信托公司联合发起信托型基金，这是一种‘类信托’的融资模式;大型房地产企业则更愿意做股权融资，进行大鱼吃小鱼的行业整合。”</p><p><br/></p><p>此前有消息称，万科、金地、华润、复兴为代表的房地产集团都在旗下设立PE投资公司，通过股权融资扩大行业版图。</p><p><br/></p><p>不过，上述股权投资基金人士也表示，“房地产信托的兑付风险都依靠PE来接盘肯定是不现实的，目前PE的实力也达不到。但是，PE对一些优质项目的兴趣比较大，也是一支不可忽视的力量。”</p>','1');
INSERT INTO `on_news` VALUES ('3','5','谁电费鬼地方过水电费','','银行理财','银行理财业务的迅猛增长，倒逼监管的步步升级。','1','银行理财业务的迅猛增长，倒逼监管的步步升级。记者从业内获得的最新统计数据显示，截至2012年末，各银行共存续理财产品32152款，理财资金账面余额7.1万亿元，比2011年末增长约55%。年初以来，银监会已将理财业务列为今年的重点监管工作。消息人士透露，对理财产品加大监管主要表现在两方面：一是将派出机构对银行理财产品销售活动进行专项检查；另一方面，将“资金池”操作模式作为现场检查的重点，“要求商业…','1363141499','1447582224','<p>银行理财业务的迅猛增长，倒逼监管的步步升级。</p><p>记者从业内获得的最新统计数据显示，截至2012年末，各银行共存续理财产品32152款，理财资金账面余额7.1万亿元，比2011年末增长约55%。</p><p>年初以来，银监会已将理财业务列为今年的重点监管工作。消息人士透露，对理财产品加大监管主要表现在两方面：一是将派出机构对银行理财产品销售活动进行专项检查；另一方面，将“资金池”操作模式作为现场检查的重点，“要求商业银行在2-4月份首先对‘资金池’类理财产品进行自查整改。”</p><p>随着理财业务的过快发展，监管部门对于理财业务参与机构的风险管理能力、资产管理能力等方面表现出担忧，特别是城商行和农村合作<a href=\"http://licai.so/Jgzl/\" target=\"_blank\">金融机构</a>。消息人士称，因此，监管部门正在酝酿开展理财业务的机构准入和业务准入制度。</p><p><strong> 严禁银行理财输血地方融资平台</strong></p><p>银行理财业务自2005年发端，至今经历了七年发展期。但时至今日仍有部分银行对理财业务的发展缺乏明确的战略定位，并未真正树立起“代客理财”的理念。</p><p>银行每季度末为冲规模大量发行期限短、收益高的理财产品，表明部分银行仅将理财业务当作其自营业务的附属，当存款规模紧张时，就通过发行保本、高收益产品争揽存款；当贷款规模紧张时，就通过理财实现贷款规模表外化，把银行理财作为“高息揽储”和“变相放贷”的工具。</p><p>记者了解到，监管部门因此要求商业银行董事会及高管层要对理财业务进行清晰的战略定位，避免理财业务沦为其他业务的调节工具和手段。</p><p>此前，部分银行将理财业务视为“变相放贷”的工具，通过规避银信合作监管规定的方式来开展项目融资，如以银证、银保、银基合作的方式，投资于票据资产或其他非标准化债券类资产。</p><p>记者获得的数据显示，截至2012年末，项目融资类理财产品余额同比增长了53%，占全部理财产品投资余额的30%，超过2万亿元。</p><p>前述消息人士透露，为了控制去年以来迅猛增长的银证、银保、银基合作等通道类业务所蕴含的风险，监管部门要求商业银行开展此类业务全程确保合规，这包括，首先要界定好投资过程中的法律关系；其次要在尽职调查的基础上合理安排交易结构和投资条款；第三，要求产品说明书要按照“解包还原”的原则充分披露；第四，要对最终投资标的的资产进行实质性管理和控制；最后还要求目标客户必须满足合格投资者的相关要求。</p><p>对于理财产品销售过程中的不规范行为，监管部门将针对这一环节进行专项检查，并计划要求银行通过投资者教育的门户网站来公示预期收益率和实际收益率的对比情况。</p><p>理财资金投向方面也要严格把关。银监会强调商业银行应严格限制资金通过各类渠道进入地方政府融资平台、“两高一剩”企业、商业房地产开发项目等限制性行业和领域。“特别强调要防止地方政府融资平台绕道通过银行理财进行直接或间接融资。”消息人士称。</p><p>银监会公布的数据显示，截至2012年末，政府融资平台贷款为93035亿元。</p><p><strong>中小机构冒进 监管层酝酿准入制度</strong></p><p>去年以来，中小金融机构特别是城商行和农村合作金融机构大量参与理财市场更加激进。记者获悉，大型银行和股份制银行在理财业务的市场份额已从2011年的88%，下降至2012年的83%。</p><p>理财业务发展过快而参与机构良莠不齐，引发监管部门的担忧。同时，部分机构还存在风险管理能力不足、业务开展不够审慎的问题。</p><p>如根据银率网的统计数据显示，今年2月份共有22款理财产品未达到预期收益率，其中有15款均为南洋商业银行所发行的产品。</p><p>而且，部分中小银行由于缺乏自主的产品设计能力，在与券商、基金、资产管理公司合作时，缺乏对产品风险和收益的实际控制权，极易沦为合作方的资金募集通道，一旦出现风险只能被动接受。</p><p>消息人士透露，对于此类风险管控能力较低、资产管理能力和专业素质还不足的中小金融机构，银监会将对其能够从事多大规模的理财业务，进行严格把关和密切监测。制定一套开展理财业务的机构准入和业务准入制度也纳入监管部门的计划中。</p><p>值得注意的是，一些创新型理财产品，如股权类投资、股票基金类投资和另类投资等，监管部门考虑到其高风险和结构复杂性，其发行将会受到严控。“特别是中小银行金融机构发行此类理财产品时，将需要逐笔上报银监会，加强合规性审查。”</p><p>此外，监管部门还注意到，部分银行存在将理财产品持有的资产与其他理财产品持有的资产，或银行自营业务资产，通过非公允的市场价格进行交易的违规行为。更有银行将一些较高收益率的理财产品销售给特定关系人，涉嫌利益输送。</p><p>银行理财业务存在的问题引起多部委的注意。记者获悉，去年，中纪委和监察部国家预防腐败局办公室也曾就此问题与银监会进行过专门的探讨，对于银行理财产品设计和交易中可能存在的腐败问题，中纪委、监察部和银监会都将进一步密切关注。</p>','1');
INSERT INTO `on_news` VALUES ('20','5','第三方公司的风格','','','','1','','1399731360','1404293860','','1');
INSERT INTO `on_news` VALUES ('21','5','放到公司的风格','','','','1','','1399731367','1404722287','<p>啊说大法师打发斯蒂芬</p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c6a0a348.jpg" style="float:none;" title="52c26ae8c9917.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c6a250f8.jpg" style="float:none;" title="52c26b053b631.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c6acb138.jpg" style="float:none;" title="52ca467cb658e.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c6ade9b8.jpg" style="float:none;" title="1268750893.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c6b09790.jpg" style="float:none;" title="1268750947.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c6b20aa8.jpg" style="float:none;" title="1285837932.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c6b31c18.jpg" style="float:none;" title="1285837946.jpg"/></p>','1');
INSERT INTO `on_news` VALUES ('22','8','地发撒旦法撒旦法','','','','1','','1399774795','1404293831','<p><img src="/Incipient/Uploads/Article/20140614/539c63bb1b7d8.jpg" title="52c26b053b631.jpg"/></p>','1');
INSERT INTO `on_news` VALUES ('5','7','地方公司公司的发生地方','','士大夫似的','多少分萨芬大时代','1','是地方地方工会是地方噶啥地方','1398178402','1404293907','<p><img src="http://127.0.0.1/yuanma/Common_System_TP3_2_1/Public/ueditor/php/../../../Uploads/article/20140422/1398180844946828.jpg" title="IMG_20131026_143644.jpg"/></p>','1');
INSERT INTO `on_news` VALUES ('19','5','的风格的身份核实','','','','1','','1399731353','1404293868','','1');
INSERT INTO `on_news` VALUES ('6','7','电视撒旦法斯蒂芬','','阿斯顿法师打发','阿斯顿法师打发是','1','阿斯顿法师打发是的','1398267688','1404293916','<p>阿斯顿法师打发是地方<br/></p>','1');
INSERT INTO `on_news` VALUES ('7','6','撒旦法斯蒂芬','','撒旦法师打发似的','阿斯顿发送到','1','撒旦法斯蒂芬','1398268188','1404293932','<p>阿斯顿法师打发<br/></p>','1');
INSERT INTO `on_news` VALUES ('8','6','撒旦法斯蒂芬','','撒旦法斯蒂芬','阿身份噶斯蒂芬','1','撒旦法斯蒂芬','1398268207','1404293924','<p>阿斯顿法师打发<br/></p>','1');
INSERT INTO `on_news` VALUES ('10','6','撒旦法斯蒂芬','','阿斯顿','阿斯顿发','1','撒旦法斯蒂芬','1399193620','1404293899','<p>阿斯顿法师打发<br/></p>','1');
INSERT INTO `on_news` VALUES ('17','6','撒旦法师打发似的','','','','1','','1399731338','1404293888','','1');
INSERT INTO `on_news` VALUES ('18','5','撒的发生广东分公司地方','','','','1','','1399731345','1404293880','','1');
INSERT INTO `on_news` VALUES ('23','8','光辉地方官地方官撒个','','','','1','','1402756156','1404722336','<p><img src="/Incipient/Uploads/Article/20140707/53ba5c9d55e38.jpg" style="float:none;" title="1268750893.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c9d6e4d8.jpg" style="float:none;" title="1268750947.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c9d7f648.jpg" style="float:none;" title="1285837932.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140707/53ba5c9d955d8.jpg" style="float:none;" title="1285837946.jpg"/></p><p><img src="/Incipient/Uploads/Article/20140614/539c6464ba2e8.jpg" title="52c26ae8c9917.jpg"/><img src="http://img.baidu.com/hi/jx2/j_0020.gif"/></p>','1');
INSERT INTO `on_news` VALUES ('25','2','电风扇该死地方官山东分公司地方给','','是大法官','更符合法规','1','撒地方噶舒服梵蒂冈放到','1404963310','1404988004','<p>啥地方和分工会斯蒂芬给第三方给<br/></p>','1');
INSERT INTO `on_news` VALUES ('24','2','公告公告','','地方官','四大飞洒地方','1','撒旦发送到发送到','1404963288','1404988012','<p>孙菲菲更划算地方公司地方官地方公司地方官地方<br/></p>','1');
INSERT INTO `on_news` VALUES ('26','2','罗杰斯考虑地方卡拉斯的','','第三方','地嘎斯地区vgewr','1','考虑将卡洛斯剑及履及卡机的了会计卡洛斯地','1404963355','1404987996','<p>考虑将卡洛斯剑及履及卡机的了会计卡洛斯地<br/></p>','1');
INSERT INTO `on_news` VALUES ('27','2','计划将很快将很快将','','宽裂黄堇','拉开距离会计拉开距离开具ioui','1','将考虑将','1404963379','1404987989','<p>客户考虑会尽快会尽快哈家咖啡店会尽快哈健康和电视剧卡和会计了<br/></p>','1');
INSERT INTO `on_news` VALUES ('28','2','发的噶死到发生发送打官司地方官','','','','1','','1404988266','0','','1');
INSERT INTO `on_news` VALUES ('29','2','放虎归山对方公司敌法嘎斯的费','','是大法官','死发电公司地方会啥地方噶水电工','1','地方三国魂水电工飞洒地方该','1404988286','0','<p>斯蒂芬给第三方回复该公司地方公司大飞给第三方刚<br/></p>','1');
INSERT INTO `on_news` VALUES ('30','2','山东分公司地方官方','','地方官和打官司地方公司地方官','山东分公司地方很反感给山东分公司地方','1','山东分公司地方','1404988316','1404988323','<p>山东分公司地方给黑化股份哈斯地方官<br/></p>','1');
INSERT INTO `on_news` VALUES ('31','3','屌丝歌神地方鬼地方会感受到','News/540d6fcab9ca8.jpg','是大法官','第三方格式大发光火山东分公司地方','1','山东分公司地方给','1405036973','1410166734','<p>水电费皇贵妃更划算地方公司地方官死<br/></p>','1');
INSERT INTO `on_news` VALUES ('32','3','啊司法斯蒂芬死地方官','','死放虎归山地方官撒地方官','地方公司大飞和公司地方','1','斯蒂芬化工给山东分公司地方','1405036997','1405037070','<p>舒服法规和山东分公司地方<br/></p>','1');
INSERT INTO `on_news` VALUES ('33','3','大发光火山东分公司地方给','','山东分公司地方给','官方话费单谁跟谁地方官','1','斯蒂芬工会费更划算地方官','1405037015','0','<p>啥地方和分工和健身房单核苷酸地方官<br/></p>','1');
INSERT INTO `on_news` VALUES ('34','3','斯蒂芬更划算地方公司大飞','News/540d60fdeadd0.jpg','第十四地方公司地方官','规范化山东分公司地方','1','水电费改电风扇山东分公司地方','1405037043','1422515506','<p>随着安信<a href="http://licai.so/Trust/" target="_blank">信托</a>、<a href="http://licai.so/Trust/agency-1061/" target="_blank">中信信托</a>等多家信托公司曝出房地产信托计划的兑付风险，部分房地产投资<a href="http://licai.so/Simu/" target="_blank">私募</a>基金(<a href="http://licai.so/Pe/" target="_blank">PE</a>)已在其中看到了机会。</p><p><br/></p><p>《每日经济新闻》记者了解到，2013年房地产信托兑付压力远超2012年，其中，兑付顶峰将出现在2013年第二季度，届时全国房地产信托兑付的总规模将超过1000亿元。通过信托融资的中小房地产企业将不得不面对资金上的窘境，而这对资金充裕的PE来说，无疑将是一次“捡馅饼”的机会。</p><p><br/></p><p>风险频现挑战“刚性兑付”/</p><p><br/></p><p>上周五(3月8日)，据《21世纪经济报道》称，<a href="http://licai.so/Trust/agency-1002/" target="_blank">安信信托</a>因为“昆山·联邦国际资产收益财产权信托”的融资方昆山纯高投资开发有限公司无法支付到期本金，已对纯高公司进行了起诉。</p><p><br/></p><p>不过，安信信托在当日发布澄清公告称，2009年9月24日，安信信托发起并设立了总规模为人民币62700万元的“昆山-联邦国际”资产收益财产权信托。但是到2012年9月18日，昆山纯高投资开发有限公司作为信托交易文件项下借款人未能按时足额偿还信托借款。</p><p><br/></p><p>为此，安信信托已向上海市第二中级人民法院提起金融借款纠纷诉讼。并且“根据信托文件约定，信托期限已自动延长，最长至2013年9月24日。”</p><p><br/></p><p>安信信托董办工作人员称，目前信托计划已经延期了,但是公司确实已进行了部分兑付。</p><p><br/></p><p>一位信托行业人士表示，项目出了问题，信托公司一般都会先托着，但如果真的出现较大的问题，这样做就会有很大风险。</p><p><br/></p><p>事实上，信托行业的“刚性兑付”此前就已经遇到了挑战。今年1月份，中信信托关于三峡全通的贷款资金兑付问题就已引起业界震动。</p><p><br/></p><p>资料显示，中信信托于2011年12月28日发起设立，“中信制造三峡全通贷款集合资金信托计划”分4次募集信托本金共计人民币13.335亿元，为三峡全通发放流动资金贷款。</p><p><br/></p><p>三峡全通公司应当于2013年1月14日和16日分别偿还贷款本息11855万元和47247万元。中信信托称，“截至2013年1月28日，本信托计划信托专户仍未收到该两期应收本息及违约金。”因此公司决定存续的优先级信托受益权的到期日延期3个月。</p><p><br/></p><p>而中信信托方面已表示，将不会去进行刚性兑付。业界认为该事件可能成信托业首个打破刚性兑付 “行规”的案例。</p><p><br/></p><p>二季度迎新一波兑付潮/</p><p><br/></p><p>虽然信托行业已经度过了此前预期兑付风险较大的2012年。但是到了2013年，房地产信托仍然面临较大的兑付压力。</p><p><br/></p><p>据北京恒天财富相关数据统计，2013年房地产信托面临兑付本息达2800亿元，远超过2012年的1759亿元。其中，兑付顶峰将出现在2013年第二季度，届时全国房地产信托兑付的总规模将达到1301亿元。</p><p><br/></p><p>另据新时代证券发布的研报，根据每月的成立规模与月平均期限测算，2013年房地产信托到期兑付规模将达2847.9亿元，其中二季度达1247.6亿元。</p><p><br/></p><p>上海一家信托公司项目经理接受《每日经济新闻》记者采访时表示，“在房地产信托计划的兑付中，中小房地产企业的压力要大得多。他们的融资原本就比大型的房地产企业要难，风险也相对要高一些。”</p><p><br/></p><p><a href="http://licai.so/Simu/200287/" target="_blank">诺亚财富</a>研究部李要深则对《每日经济新闻》记者表示，目前总体来说，房地产信托没有太大的问题，相比前两年，规模和占比已经下降很多，处在一个相对安全的范围，并且房地产信托一般都有较好的抵押物。</p><p><br/></p><p>事实上，今年以来，房地产信托发展速度仍然较快。用益信托数据显示，2月份共成立房地产信托52款，募集资金162.95亿元，占总成立规模的33.98%，高于上个月29.49%的占比，较去年23%左右的占比更是显著增加。</p><p><br/></p><p>PE伺机而动</p><p><br/></p><p>对资金充裕的PE来说，房地产信托接盘的时机也可能就在今年。</p><p><br/></p><p>“房地产公司现在都缺钱，尤其是中小房地产企业，更是困难。从目前的角度来看，这块的投资价值逐渐显现出来了。”某股权投资基金相关人士称，PE投资接盘的条件主要还是看具体的项目。</p><p><br/></p><p>“从实际情况看，房地产信托有兑付风险的项目眼下还不多，只是根据趋势判断，今年的投资将有很大的操作空间，也就是找一些缺资金、项目优质的企业合作。”上述股权投资基金人士表示。</p><p><br/></p><p>据《每日经济新闻》记者不完全统计，在即将到期的房地产信托项目中，北京、上海等一线城市的项目数量有限，而鄂尔多斯、青岛等二线城市项目则多一些。</p><p><br/></p><p>上述股权投资基金人士介绍，与房地产企业的合作，模式是多种多样的。“最简单的是折价收购整个项目，然而分拆出售，但是这对PE公司的资金实力和运作的要求很高。另外，不同PE主体的参与模式也不一样。<a href="http://licai.so/Jgzl/" target="_blank">金融机构</a>发起的地产基金主要是做债权，和信托公司联合发起信托型基金，这是一种‘类信托’的融资模式;大型房地产企业则更愿意做股权融资，进行大鱼吃小鱼的行业整合。”</p><p><br/></p><p>此前有消息称，万科、金地、华润、复兴为代表的房地产集团都在旗下设立PE投资公司，通过股权融资扩大行业版图。</p><p><br/></p><p>不过，上述股权投资基金人士也表示，“房地产信托的兑付风险都依靠PE来接盘肯定是不现实的，目前PE的实力也达不到。但是，PE对一些优质项目的兴趣比较大，也是一支不可忽视的力量。”</p><p><br/></p>','1');
INSERT INTO `on_news` VALUES ('1','5','拍卖须知','','斯蒂芬四大','合肥山东分公司地方','1','四大行山东分公司地方给地方','1363141340','1447582208','<p>三个和尚梵蒂冈和斯蒂芬给第三方给<br/></p>','1');
INSERT INTO `on_news` VALUES ('36','2','公安路建设的分开了就是','','神盾','阿范德萨地方地方','1','阿斯蒂芬地方','1417057221','0','<p>阿雷克斯建档立卡急死了都急死了<br/></p>','1');
INSERT INTO `on_news` VALUES ('37','2','123撒发生大幅度','','水电费水电费','阿斯顿发生地方','1','阿斯顿发生地方神盾','1417057753','1417057753','<p>阿斯蒂芬梵蒂冈的身份噶是的发送到发送到<br/></p>','1');
INSERT INTO `on_news` VALUES ('38','2','佛纳甘过水电费','','','','1','阿斯顿发送到','1417071466','1417071466','<p>阿斯顿发送到<br/></p>','1');
INSERT INTO `on_news` VALUES ('42','4','阿斯顿发生地方','News/573a8aab5b37f.jpg','阿斯顿发生地方','阿斯顿发送到','0','阿斯顿噶水电费','1463454362','1463454381','<p>阿古斯地方噶撒打发斯蒂芬<br/></p>','1');


# 数据库表：on_node 数据信息
INSERT INTO `on_node` VALUES ('1','Admin','后台管理','1','网站后台管理项目','10','0','1');
INSERT INTO `on_node` VALUES ('2','Index','管理首页','1','','1','1','2');
INSERT INTO `on_node` VALUES ('3','Member','注册用户管理','1','','3','1','2');
INSERT INTO `on_node` VALUES ('4','Webinfo','系统管理','1','','4','1','2');
INSERT INTO `on_node` VALUES ('5','index','默认页','1','','5','2','3');
INSERT INTO `on_node` VALUES ('6','myInfo','我的个人信息','1','','6','2','3');
INSERT INTO `on_node` VALUES ('7','index','注册用户列表','1','','7','3','3');
INSERT INTO `on_node` VALUES ('8','index','管理员列表','1','','8','14','3');
INSERT INTO `on_node` VALUES ('9','addAdmin','添加管理员','1','','9','14','3');
INSERT INTO `on_node` VALUES ('10','index','站点信息','1','','10','4','3');
INSERT INTO `on_node` VALUES ('11','setEmailConfig','邮箱配置','1','','12','4','3');
INSERT INTO `on_node` VALUES ('12','testEmailConfig','发送测试邮件','1','','0','4','3');
INSERT INTO `on_node` VALUES ('13','setSafeConfig','系统安全设置','1','','0','4','3');
INSERT INTO `on_node` VALUES ('14','Access','权限管理','1','权限管理，为系统后台管理员设置不同的权限','0','1','2');
INSERT INTO `on_node` VALUES ('15','nodeList','查看节点','1','节点列表信息','0','14','3');
INSERT INTO `on_node` VALUES ('16','roleList','角色列表查看','1','角色列表查看','0','14','3');
INSERT INTO `on_node` VALUES ('17','addRole','添加角色','1','','0','14','3');
INSERT INTO `on_node` VALUES ('18','editRole','编辑角色','1','','0','14','3');
INSERT INTO `on_node` VALUES ('19','opNodeStatus','便捷开启禁用节点','1','','0','14','3');
INSERT INTO `on_node` VALUES ('20','opRoleStatus','便捷开启禁用角色','1','','0','14','3');
INSERT INTO `on_node` VALUES ('21','editNode','编辑节点','1','','0','14','3');
INSERT INTO `on_node` VALUES ('22','addNode','添加节点','1','','0','14','3');
INSERT INTO `on_node` VALUES ('23','addAdmin','添加管理员','1','','0','14','3');
INSERT INTO `on_node` VALUES ('24','editAdmin','编辑管理员信息','1','','0','14','3');
INSERT INTO `on_node` VALUES ('25','changeRole','权限分配','1','','0','14','3');
INSERT INTO `on_node` VALUES ('26','News','文章管理','1','','0','1','2');
INSERT INTO `on_node` VALUES ('27','index','文章列表','1','','0','26','3');
INSERT INTO `on_node` VALUES ('28','category','文章分类管理','1','','0','26','3');
INSERT INTO `on_node` VALUES ('29','add','发布文章','1','','0','26','3');
INSERT INTO `on_node` VALUES ('30','edit','编辑文章','1','','0','26','3');
INSERT INTO `on_node` VALUES ('31','del','删除信息','0','','0','26','3');
INSERT INTO `on_node` VALUES ('32','SysData','数据库管理','1','包含数据库备份、还原、打包等','0','1','2');
INSERT INTO `on_node` VALUES ('33','index','查看数据库表结构信息','1','','0','32','3');
INSERT INTO `on_node` VALUES ('34','backup','备份数据库','1','','0','32','3');
INSERT INTO `on_node` VALUES ('35','restore','查看已备份SQL文件','1','','0','32','3');
INSERT INTO `on_node` VALUES ('36','restoreData','执行数据库还原操作','1','','0','32','3');
INSERT INTO `on_node` VALUES ('37','delSqlFiles','删除SQL文件','1','','0','32','3');
INSERT INTO `on_node` VALUES ('38','sendSql','邮件发送SQL文件','1','','0','32','3');
INSERT INTO `on_node` VALUES ('39','zipSql','打包SQL文件','1','','0','32','3');
INSERT INTO `on_node` VALUES ('40','zipList','查看已打包SQL文件','1','','0','32','3');
INSERT INTO `on_node` VALUES ('41','unzipSqlfile','解压缩ZIP文件','1','','0','32','3');
INSERT INTO `on_node` VALUES ('42','delZipFiles','删除zip压缩文件','1','','0','32','3');
INSERT INTO `on_node` VALUES ('43','downFile','下载备份的SQL,ZIP文件','1','','0','32','3');
INSERT INTO `on_node` VALUES ('44','repair','数据库优化修复','1','','0','32','3');
INSERT INTO `on_node` VALUES ('45','add','添加用户','1','添加用户的权限','0','3','3');
INSERT INTO `on_node` VALUES ('46','feedback','推广反馈','1','添加推广项的','0','3','3');
INSERT INTO `on_node` VALUES ('47','wallet','账户编辑','1','编辑用户资金账户','0','3','3');
INSERT INTO `on_node` VALUES ('48','edit','编辑用户','1','编辑用户信息','0','3','3');
INSERT INTO `on_node` VALUES ('49','del','删除用户','1','删除用户','0','3','3');
INSERT INTO `on_node` VALUES ('50','Goods','商品管理','1','商品仓库和一些商品频道、筛选、扩展的配置','0','1','2');
INSERT INTO `on_node` VALUES ('51','index','商品列表','1','商品列表的显示','0','50','3');
INSERT INTO `on_node` VALUES ('52','add','添加商品','1','添加商品','0','50','3');
INSERT INTO `on_node` VALUES ('53','category','频道分类管理','1','添加频道或分类的权限','0','50','3');
INSERT INTO `on_node` VALUES ('54','filtrate','筛选条件管理','1','添加编辑筛选条件的权限','0','50','3');
INSERT INTO `on_node` VALUES ('55','cate_filt','频道、分类与筛选条件关联','1','频道、分类与筛选条件关联','0','50','3');
INSERT INTO `on_node` VALUES ('56','fields_list','商品扩展字段列表','1','商品扩展字段列表','0','50','3');
INSERT INTO `on_node` VALUES ('57','cate_extend','频道、分类与扩展字段关联','1','频道、分类与扩展字段关联的操作','0','50','3');
INSERT INTO `on_node` VALUES ('58','del_goods','删除商品','1','商品的删除操作','0','50','3');
INSERT INTO `on_node` VALUES ('59','delLink','频道、分类与筛选条件关联的删除','1','频道、分类与筛选条件关联的删除','0','50','3');
INSERT INTO `on_node` VALUES ('60','fields_add','添加编辑扩展字段','1','扩展字段的添加和编辑','0','50','3');
INSERT INTO `on_node` VALUES ('61','delField','删除扩展字段','1','扩展字段的删除','0','50','3');
INSERT INTO `on_node` VALUES ('62','delExtend','频道、分类与扩展字段关联的删除','1','频道、分类与扩展字段关联的删除','0','50','3');
INSERT INTO `on_node` VALUES ('63','Auction','拍卖管理','1','拍卖管理','0','1','2');
INSERT INTO `on_node` VALUES ('64','index','拍卖列表','1','拍品列表','0','63','3');
INSERT INTO `on_node` VALUES ('65','add','发布拍卖','1','商品列表发布到拍卖的操作','0','63','3');
INSERT INTO `on_node` VALUES ('66','edit','编辑拍卖','1','编辑拍卖','0','63','3');
INSERT INTO `on_node` VALUES ('67','set_auction','拍卖配置','1','配置拍卖的一些信息','0','63','3');
INSERT INTO `on_node` VALUES ('68','del','删除拍卖','1','删除拍卖','0','63','3');
INSERT INTO `on_node` VALUES ('69','Order','订单管理','1','订单管理','0','1','2');
INSERT INTO `on_node` VALUES ('70','index','订单列表','1','订单列表','0','69','3');
INSERT INTO `on_node` VALUES ('71','lose','过期订单','1','过期的订单','0','69','3');
INSERT INTO `on_node` VALUES ('72','deduct','过期订单扣除保证金操作','1','过期订单扣除保证金操作','0','69','3');
INSERT INTO `on_node` VALUES ('73','edit','订单编辑','1','订单编辑','0','69','3');
INSERT INTO `on_node` VALUES ('74','del','订单删除','1','订单删除','0','69','3');
INSERT INTO `on_node` VALUES ('75','set_order','订单配置','1','订单有效期的配置','0','69','3');
INSERT INTO `on_node` VALUES ('76','Link','友情链接','1','友情链接','0','1','2');
INSERT INTO `on_node` VALUES ('77','index','列表','1','友情链接列表','0','76','3');
INSERT INTO `on_node` VALUES ('78','add','添加','1','添加友情链接','0','76','3');
INSERT INTO `on_node` VALUES ('79','edit','编辑','1','编辑友情链接','0','76','3');
INSERT INTO `on_node` VALUES ('80','del','删除','1','友情链接删除','0','76','3');
INSERT INTO `on_node` VALUES ('81','Advertising','广告管理','1','广告管理','0','1','2');
INSERT INTO `on_node` VALUES ('82','index','广告列表','1','广告列表','0','81','3');
INSERT INTO `on_node` VALUES ('83','add_advertising','添加广告','1','添加广告','0','81','3');
INSERT INTO `on_node` VALUES ('84','edit_advertising','编辑广告','1','编辑广告','0','81','3');
INSERT INTO `on_node` VALUES ('85','del_advertising','删除广告','1','删除广告','0','81','3');
INSERT INTO `on_node` VALUES ('86','position','广告位列表','1','广告位列表','0','81','3');
INSERT INTO `on_node` VALUES ('87','add_position','添加广告位','1','添加广告位','0','81','3');
INSERT INTO `on_node` VALUES ('88','edit_position','编辑广告位','1','编辑广告位','0','81','3');
INSERT INTO `on_node` VALUES ('89','del_position','删除广告位','1','删除广告位','0','81','3');
INSERT INTO `on_node` VALUES ('90','Payment','支付管理','1','支付管理','0','1','2');
INSERT INTO `on_node` VALUES ('91','pay_gallery','支付接口配置','1','支付接口配置','0','90','3');
INSERT INTO `on_node` VALUES ('92','edit','支付接口编辑','0','支付接口编辑','0','90','3');
INSERT INTO `on_node` VALUES ('93','index','支付订单列表','1','支付订单列表','0','90','3');
INSERT INTO `on_node` VALUES ('94','del','支付订单删除','1','支付订单删除','0','90','3');
INSERT INTO `on_node` VALUES ('95','setUserAgreement','用户协议','0','用户协议管理','0','4','3');
INSERT INTO `on_node` VALUES ('96','navigation','导航链接管理','1','导航链接管理','0','4','3');
INSERT INTO `on_node` VALUES ('97','steWebConfig','站点配置','1','配置站点的信息','0','4','3');
INSERT INTO `on_node` VALUES ('98','setNoteConfig','短信配置','1','配置短信接口','0','4','3');
INSERT INTO `on_node` VALUES ('99','testNoteConfig','发送测试短信','1','发送测试短信','0','4','3');
INSERT INTO `on_node` VALUES ('100','setUserAgreement','用户协议','1','编辑用户协议','0','4','3');
INSERT INTO `on_node` VALUES ('101','set_member','注册方式','1','注册方式的操作','0','3','3');
INSERT INTO `on_node` VALUES ('102','special','专场列表','1','专场列表查看各个状态的专场','0','63','3');
INSERT INTO `on_node` VALUES ('103','add_special','添加专场','1','添加专场的操作','0','63','3');
INSERT INTO `on_node` VALUES ('104','edit_special','编辑专场','1','编辑专场','0','63','3');
INSERT INTO `on_node` VALUES ('105','del_special','删除专场','1','删除专场操作','0','63','3');
INSERT INTO `on_node` VALUES ('106','meeting','拍卖会列表','1','拍卖会列表','0','63','3');
INSERT INTO `on_node` VALUES ('107','add_meeting','添加拍卖会','1','添加拍卖会','0','63','3');
INSERT INTO `on_node` VALUES ('108','edit_meeting','编辑拍卖会','1','编辑拍卖会','0','63','3');
INSERT INTO `on_node` VALUES ('109','del_meeting','删除拍卖会','1','删除拍卖会','0','63','3');
INSERT INTO `on_node` VALUES ('110','cancelPai','拍品撤拍','1','撤拍操作','0','63','3');
INSERT INTO `on_node` VALUES ('111','edit','商品编辑','1','编辑商品信息','0','50','3');
INSERT INTO `on_node` VALUES ('112','take','提现申请','1','提现申请的显示和回复','0','2','3');
INSERT INTO `on_node` VALUES ('113','cache','缓存管理','1','缓存的查看和清空操作','0','2','3');
INSERT INTO `on_node` VALUES ('114','Weixin','微信平台','1','微信平台管理','0','1','2');
INSERT INTO `on_node` VALUES ('115','index','图文消息列表','1','图文列表显示','0','114','3');
INSERT INTO `on_node` VALUES ('116','addurl','添加图文消息','1','添加图文消息','0','114','3');
INSERT INTO `on_node` VALUES ('117','editurl','编辑图文消息','1','编辑图文消息','0','114','3');
INSERT INTO `on_node` VALUES ('118','weipush','批量推送图文消息','1','批量推送图文消息','0','114','3');
INSERT INTO `on_node` VALUES ('119','delurl','删除图文消息','1','删除图文消息','0','114','3');
INSERT INTO `on_node` VALUES ('120','weimenu','自定义菜单编辑','1','自定义菜单编辑','0','114','3');
INSERT INTO `on_node` VALUES ('121','weiconfig','微信配置','1','微信配置','0','114','3');
INSERT INTO `on_node` VALUES ('122','webmail','站内信管理','1','站内信列表的显示','0','3','3');
INSERT INTO `on_node` VALUES ('123','sendsms','发送站内信','1','给用户发送站内信','0','3','3');
INSERT INTO `on_node` VALUES ('124','setdelsms','站内信设置删除','1','设置站内信为删除状态','0','3','3');
INSERT INTO `on_node` VALUES ('125','delsms','删除站内信','1','彻底删除站内信','0','3','3');
INSERT INTO `on_node` VALUES ('126','sharerecord','用户分享记录','1','显示微信版用户分享链接的记录','0','114','3');
INSERT INTO `on_node` VALUES ('127','showset','查看拍卖','1','查看拍卖信息','0','63','3');


# 数据库表：on_order_break 数据信息


# 数据库表：on_payorder 数据信息


# 数据库表：on_region 数据信息
INSERT INTO `on_region` VALUES ('1','中国','中国','0','0','0','Zhong Guo','2');
INSERT INTO `on_region` VALUES ('2','110000','北京市','1','0','0','Beijing Shi','BJ');
INSERT INTO `on_region` VALUES ('3','120000','天津市','1','0','0','Tianjin Shi','TJ');
INSERT INTO `on_region` VALUES ('4','130000','河北省','1','0','0','Hebei Sheng','HE');
INSERT INTO `on_region` VALUES ('5','140000','山西省','1','0','0','Shanxi Sheng ','SX');
INSERT INTO `on_region` VALUES ('6','150000','内蒙古自治区','1','0','0','Nei Mongol Zizhiqu','NM');
INSERT INTO `on_region` VALUES ('7','210000','辽宁省','1','0','0','Liaoning Sheng','LN');
INSERT INTO `on_region` VALUES ('8','220000','吉林省','1','0','0','Jilin Sheng','JL');
INSERT INTO `on_region` VALUES ('9','230000','黑龙江省','1','0','0','Heilongjiang Sheng','HL');
INSERT INTO `on_region` VALUES ('10','310000','上海市','1','0','0','Shanghai Shi','SH');
INSERT INTO `on_region` VALUES ('11','320000','江苏省','1','0','0','Jiangsu Sheng','JS');
INSERT INTO `on_region` VALUES ('12','330000','浙江省','1','0','0','Zhejiang Sheng','ZJ');
INSERT INTO `on_region` VALUES ('13','340000','安徽省','1','0','0','Anhui Sheng','AH');
INSERT INTO `on_region` VALUES ('14','350000','福建省','1','0','0','Fujian Sheng ','FJ');
INSERT INTO `on_region` VALUES ('15','360000','江西省','1','0','0','Jiangxi Sheng','JX');
INSERT INTO `on_region` VALUES ('16','370000','山东省','1','0','0','Shandong Sheng ','SD');
INSERT INTO `on_region` VALUES ('17','410000','河南省','1','0','0','Henan Sheng','HA');
INSERT INTO `on_region` VALUES ('18','420000','湖北省','1','0','0','Hubei Sheng','HB');
INSERT INTO `on_region` VALUES ('19','430000','湖南省','1','0','0','Hunan Sheng','HN');
INSERT INTO `on_region` VALUES ('20','440000','广东省','1','0','0','Guangdong Sheng','GD');
INSERT INTO `on_region` VALUES ('21','450000','广西壮族自治区','1','0','0','Guangxi Zhuangzu Zizhiqu','GX');
INSERT INTO `on_region` VALUES ('22','460000','海南省','1','0','0','Hainan Sheng','HI');
INSERT INTO `on_region` VALUES ('23','500000','重庆市','1','0','0','Chongqing Shi','CQ');
INSERT INTO `on_region` VALUES ('24','510000','四川省','1','0','0','Sichuan Sheng','SC');
INSERT INTO `on_region` VALUES ('25','520000','贵州省','1','0','0','Guizhou Sheng','GZ');
INSERT INTO `on_region` VALUES ('26','530000','云南省','1','0','0','Yunnan Sheng','YN');
INSERT INTO `on_region` VALUES ('27','540000','西藏自治区','1','0','0','Xizang Zizhiqu','XZ');
INSERT INTO `on_region` VALUES ('28','610000','陕西省','1','0','0','Shanxi Sheng ','SN');
INSERT INTO `on_region` VALUES ('29','620000','甘肃省','1','0','0','Gansu Sheng','GS');
INSERT INTO `on_region` VALUES ('30','630000','青海省','1','0','0','Qinghai Sheng','QH');
INSERT INTO `on_region` VALUES ('31','640000','宁夏回族自治区','1','0','0','Ningxia Huizu Zizhiqu','NX');
INSERT INTO `on_region` VALUES ('32','650000','新疆维吾尔自治区','1','0','0','Xinjiang Uygur Zizhiqu','XJ');
INSERT INTO `on_region` VALUES ('33','110100','市辖区','2','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('34','110200','县','2','0','0','Xian','2');
INSERT INTO `on_region` VALUES ('35','120100','市辖区','3','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('36','120200','县','3','0','0','Xian','2');
INSERT INTO `on_region` VALUES ('37','130100','石家庄市','4','0','0','Shijiazhuang Shi','SJW');
INSERT INTO `on_region` VALUES ('38','130200','唐山市','4','0','0','Tangshan Shi','TGS');
INSERT INTO `on_region` VALUES ('39','130300','秦皇岛市','4','0','0','Qinhuangdao Shi','SHP');
INSERT INTO `on_region` VALUES ('40','130400','邯郸市','4','0','0','Handan Shi','HDS');
INSERT INTO `on_region` VALUES ('41','130500','邢台市','4','0','0','Xingtai Shi','XTS');
INSERT INTO `on_region` VALUES ('42','130600','保定市','4','0','0','Baoding Shi','BDS');
INSERT INTO `on_region` VALUES ('43','130700','张家口市','4','0','0','Zhangjiakou Shi ','ZJK');
INSERT INTO `on_region` VALUES ('44','130800','承德市','4','0','0','Chengde Shi','CDS');
INSERT INTO `on_region` VALUES ('45','130900','沧州市','4','0','0','Cangzhou Shi','CGZ');
INSERT INTO `on_region` VALUES ('46','131000','廊坊市','4','0','0','Langfang Shi','LFS');
INSERT INTO `on_region` VALUES ('47','131100','衡水市','4','0','0','Hengshui Shi ','HGS');
INSERT INTO `on_region` VALUES ('48','140100','太原市','5','0','0','Taiyuan Shi','TYN');
INSERT INTO `on_region` VALUES ('49','140200','大同市','5','0','0','Datong Shi ','DTG');
INSERT INTO `on_region` VALUES ('50','140300','阳泉市','5','0','0','Yangquan Shi','YQS');
INSERT INTO `on_region` VALUES ('51','140400','长治市','5','0','0','Changzhi Shi','CZS');
INSERT INTO `on_region` VALUES ('52','140500','晋城市','5','0','0','Jincheng Shi ','JCG');
INSERT INTO `on_region` VALUES ('53','140600','朔州市','5','0','0','Shuozhou Shi ','SZJ');
INSERT INTO `on_region` VALUES ('54','140700','晋中市','5','0','0','Jinzhong Shi','2');
INSERT INTO `on_region` VALUES ('55','140800','运城市','5','0','0','Yuncheng Shi','2');
INSERT INTO `on_region` VALUES ('56','140900','忻州市','5','0','0','Xinzhou Shi','2');
INSERT INTO `on_region` VALUES ('57','141000','临汾市','5','0','0','Linfen Shi','2');
INSERT INTO `on_region` VALUES ('58','141100','吕梁市','5','0','0','Lvliang Shi','2');
INSERT INTO `on_region` VALUES ('59','150100','呼和浩特市','6','0','0','Hohhot Shi','Hhht');
INSERT INTO `on_region` VALUES ('60','150200','包头市','6','0','0','Baotou Shi ','BTS');
INSERT INTO `on_region` VALUES ('61','150300','乌海市','6','0','0','Wuhai Shi','WHM');
INSERT INTO `on_region` VALUES ('62','150400','赤峰市','6','0','0','Chifeng (Ulanhad)Shi','CFS');
INSERT INTO `on_region` VALUES ('63','150500','通辽市','6','0','0','Tongliao Shi','2');
INSERT INTO `on_region` VALUES ('64','150600','鄂尔多斯市','6','0','0','Eerduosi Shi','2');
INSERT INTO `on_region` VALUES ('65','150700','呼伦贝尔市','6','0','0','Hulunbeier Shi ','2');
INSERT INTO `on_region` VALUES ('66','150800','巴彦淖尔市','6','0','0','Bayannaoer Shi','2');
INSERT INTO `on_region` VALUES ('67','150900','乌兰察布市','6','0','0','Wulanchabu Shi','2');
INSERT INTO `on_region` VALUES ('68','152200','兴安盟','6','0','0','Hinggan Meng','HIN');
INSERT INTO `on_region` VALUES ('69','152500','锡林郭勒盟','6','0','0','Xilin Gol Meng','XGO');
INSERT INTO `on_region` VALUES ('70','152900','阿拉善盟','6','0','0','Alxa Meng','ALM');
INSERT INTO `on_region` VALUES ('71','210100','沈阳市','7','0','0','Shenyang Shi','SHE');
INSERT INTO `on_region` VALUES ('72','210200','大连市','7','0','0','Dalian Shi','DLC');
INSERT INTO `on_region` VALUES ('73','210300','鞍山市','7','0','0','AnShan Shi','ASN');
INSERT INTO `on_region` VALUES ('74','210400','抚顺市','7','0','0','Fushun Shi','FSN');
INSERT INTO `on_region` VALUES ('75','210500','本溪市','7','0','0','Benxi Shi','BXS');
INSERT INTO `on_region` VALUES ('76','210600','丹东市','7','0','0','Dandong Shi','DDG');
INSERT INTO `on_region` VALUES ('77','210700','锦州市','7','0','0','Jinzhou Shi','JNZ');
INSERT INTO `on_region` VALUES ('78','210800','营口市','7','0','0','Yingkou Shi','YIK');
INSERT INTO `on_region` VALUES ('79','210900','阜新市','7','0','0','Fuxin Shi','FXS');
INSERT INTO `on_region` VALUES ('80','211000','辽阳市','7','0','0','Liaoyang Shi','LYL');
INSERT INTO `on_region` VALUES ('81','211100','盘锦市','7','0','0','Panjin Shi','PJS');
INSERT INTO `on_region` VALUES ('82','211200','铁岭市','7','0','0','Tieling Shi','TLS');
INSERT INTO `on_region` VALUES ('83','211300','朝阳市','7','0','0','Chaoyang Shi','CYS');
INSERT INTO `on_region` VALUES ('84','211400','葫芦岛市','7','0','0','Huludao Shi','HLD');
INSERT INTO `on_region` VALUES ('85','220100','长春市','8','0','0','Changchun Shi ','CGQ');
INSERT INTO `on_region` VALUES ('86','220200','吉林市','8','0','0','Jilin Shi ','JLS');
INSERT INTO `on_region` VALUES ('87','220300','四平市','8','0','0','Siping Shi','SPS');
INSERT INTO `on_region` VALUES ('88','220400','辽源市','8','0','0','Liaoyuan Shi','LYH');
INSERT INTO `on_region` VALUES ('89','220500','通化市','8','0','0','Tonghua Shi','THS');
INSERT INTO `on_region` VALUES ('90','220600','白山市','8','0','0','Baishan Shi','BSN');
INSERT INTO `on_region` VALUES ('91','220700','松原市','8','0','0','Songyuan Shi','SYU');
INSERT INTO `on_region` VALUES ('92','220800','白城市','8','0','0','Baicheng Shi','BCS');
INSERT INTO `on_region` VALUES ('93','222400','延边朝鲜族自治州','8','0','0','Yanbian Chosenzu Zizhizhou','YBZ');
INSERT INTO `on_region` VALUES ('94','230100','哈尔滨市','9','0','0','Harbin Shi','HRB');
INSERT INTO `on_region` VALUES ('95','230200','齐齐哈尔市','9','0','0','Qiqihar Shi','NDG');
INSERT INTO `on_region` VALUES ('96','230300','鸡西市','9','0','0','Jixi Shi','JXI');
INSERT INTO `on_region` VALUES ('97','230400','鹤岗市','9','0','0','Hegang Shi','HEG');
INSERT INTO `on_region` VALUES ('98','230500','双鸭山市','9','0','0','Shuangyashan Shi','SYS');
INSERT INTO `on_region` VALUES ('99','230600','大庆市','9','0','0','Daqing Shi','DQG');
INSERT INTO `on_region` VALUES ('100','230700','伊春市','9','0','0','Yichun Shi','YCH');
INSERT INTO `on_region` VALUES ('101','230800','佳木斯市','9','0','0','Jiamusi Shi','JMU');
INSERT INTO `on_region` VALUES ('102','230900','七台河市','9','0','0','Qitaihe Shi','QTH');
INSERT INTO `on_region` VALUES ('103','231000','牡丹江市','9','0','0','Mudanjiang Shi','MDG');
INSERT INTO `on_region` VALUES ('104','231100','黑河市','9','0','0','Heihe Shi','HEK');
INSERT INTO `on_region` VALUES ('105','231200','绥化市','9','0','0','Suihua Shi','2');
INSERT INTO `on_region` VALUES ('106','232700','大兴安岭地区','9','0','0','Da Hinggan Ling Diqu','DHL');
INSERT INTO `on_region` VALUES ('107','310100','市辖区','10','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('108','310200','县','10','0','0','Xian','2');
INSERT INTO `on_region` VALUES ('109','320100','南京市','11','0','0','Nanjing Shi','NKG');
INSERT INTO `on_region` VALUES ('110','320200','无锡市','11','0','0','Wuxi Shi','WUX');
INSERT INTO `on_region` VALUES ('111','320300','徐州市','11','0','0','Xuzhou Shi','XUZ');
INSERT INTO `on_region` VALUES ('112','320400','常州市','11','0','0','Changzhou Shi','CZX');
INSERT INTO `on_region` VALUES ('113','320500','苏州市','11','0','0','Suzhou Shi','SZH');
INSERT INTO `on_region` VALUES ('114','320600','南通市','11','0','0','Nantong Shi','NTG');
INSERT INTO `on_region` VALUES ('115','320700','连云港市','11','0','0','Lianyungang Shi','LYG');
INSERT INTO `on_region` VALUES ('116','320800','淮安市','11','0','0','Huai,an Xian','2');
INSERT INTO `on_region` VALUES ('117','320900','盐城市','11','0','0','Yancheng Shi','YCK');
INSERT INTO `on_region` VALUES ('118','321000','扬州市','11','0','0','Yangzhou Shi','YZH');
INSERT INTO `on_region` VALUES ('119','321100','镇江市','11','0','0','Zhenjiang Shi','ZHE');
INSERT INTO `on_region` VALUES ('120','321200','泰州市','11','0','0','Taizhou Shi','TZS');
INSERT INTO `on_region` VALUES ('121','321300','宿迁市','11','0','0','Suqian Shi','SUQ');
INSERT INTO `on_region` VALUES ('122','330100','杭州市','12','0','0','Hangzhou Shi','HGH');
INSERT INTO `on_region` VALUES ('123','330200','宁波市','12','0','0','Ningbo Shi','NGB');
INSERT INTO `on_region` VALUES ('124','330300','温州市','12','0','0','Wenzhou Shi','WNZ');
INSERT INTO `on_region` VALUES ('125','330400','嘉兴市','12','0','0','Jiaxing Shi','JIX');
INSERT INTO `on_region` VALUES ('126','330500','湖州市','12','0','0','Huzhou Shi ','HZH');
INSERT INTO `on_region` VALUES ('127','330600','绍兴市','12','0','0','Shaoxing Shi','SXG');
INSERT INTO `on_region` VALUES ('128','330700','金华市','12','0','0','Jinhua Shi','JHA');
INSERT INTO `on_region` VALUES ('129','330800','衢州市','12','0','0','Quzhou Shi','QUZ');
INSERT INTO `on_region` VALUES ('130','330900','舟山市','12','0','0','Zhoushan Shi','ZOS');
INSERT INTO `on_region` VALUES ('131','331000','台州市','12','0','0','Taizhou Shi','TZZ');
INSERT INTO `on_region` VALUES ('132','331100','丽水市','12','0','0','Lishui Shi','2');
INSERT INTO `on_region` VALUES ('133','340100','合肥市','13','0','0','Hefei Shi','HFE');
INSERT INTO `on_region` VALUES ('134','340200','芜湖市','13','0','0','Wuhu Shi','WHI');
INSERT INTO `on_region` VALUES ('135','340300','蚌埠市','13','0','0','Bengbu Shi','BBU');
INSERT INTO `on_region` VALUES ('136','340400','淮南市','13','0','0','Huainan Shi','HNS');
INSERT INTO `on_region` VALUES ('137','340500','马鞍山市','13','0','0','Ma,anshan Shi','MAA');
INSERT INTO `on_region` VALUES ('138','340600','淮北市','13','0','0','Huaibei Shi','HBE');
INSERT INTO `on_region` VALUES ('139','340700','铜陵市','13','0','0','Tongling Shi','TOL');
INSERT INTO `on_region` VALUES ('140','340800','安庆市','13','0','0','Anqing Shi','AQG');
INSERT INTO `on_region` VALUES ('141','341000','黄山市','13','0','0','Huangshan Shi','HSN');
INSERT INTO `on_region` VALUES ('142','341100','滁州市','13','0','0','Chuzhou Shi','CUZ');
INSERT INTO `on_region` VALUES ('143','341200','阜阳市','13','0','0','Fuyang Shi','FYS');
INSERT INTO `on_region` VALUES ('144','341300','宿州市','13','0','0','Suzhou Shi','SUZ');
INSERT INTO `on_region` VALUES ('145','341400','巢湖市','13','0','0','Chaohu Shi','2');
INSERT INTO `on_region` VALUES ('146','341500','六安市','13','0','0','Liu,an Shi','2');
INSERT INTO `on_region` VALUES ('147','341600','亳州市','13','0','0','Bozhou Shi','2');
INSERT INTO `on_region` VALUES ('148','341700','池州市','13','0','0','Chizhou Shi','2');
INSERT INTO `on_region` VALUES ('149','341800','宣城市','13','0','0','Xuancheng Shi','2');
INSERT INTO `on_region` VALUES ('150','350100','福州市','14','0','0','Fuzhou Shi','FOC');
INSERT INTO `on_region` VALUES ('151','350200','厦门市','14','0','0','Xiamen Shi','XMN');
INSERT INTO `on_region` VALUES ('152','350300','莆田市','14','0','0','Putian Shi','PUT');
INSERT INTO `on_region` VALUES ('153','350400','三明市','14','0','0','Sanming Shi','SMS');
INSERT INTO `on_region` VALUES ('154','350500','泉州市','14','0','0','Quanzhou Shi','QZJ');
INSERT INTO `on_region` VALUES ('155','350600','漳州市','14','0','0','Zhangzhou Shi','ZZU');
INSERT INTO `on_region` VALUES ('156','350700','南平市','14','0','0','Nanping Shi','NPS');
INSERT INTO `on_region` VALUES ('157','350800','龙岩市','14','0','0','Longyan Shi','LYF');
INSERT INTO `on_region` VALUES ('158','350900','宁德市','14','0','0','Ningde Shi','2');
INSERT INTO `on_region` VALUES ('159','360100','南昌市','15','0','0','Nanchang Shi','KHN');
INSERT INTO `on_region` VALUES ('160','360200','景德镇市','15','0','0','Jingdezhen Shi','JDZ');
INSERT INTO `on_region` VALUES ('161','360300','萍乡市','15','0','0','Pingxiang Shi','PXS');
INSERT INTO `on_region` VALUES ('162','360400','九江市','15','0','0','Jiujiang Shi','JIU');
INSERT INTO `on_region` VALUES ('163','360500','新余市','15','0','0','Xinyu Shi','XYU');
INSERT INTO `on_region` VALUES ('164','360600','鹰潭市','15','0','0','Yingtan Shi','2');
INSERT INTO `on_region` VALUES ('165','360700','赣州市','15','0','0','Ganzhou Shi','GZH');
INSERT INTO `on_region` VALUES ('166','360800','吉安市','15','0','0','Ji,an Shi','2');
INSERT INTO `on_region` VALUES ('167','360900','宜春市','15','0','0','Yichun Shi','2');
INSERT INTO `on_region` VALUES ('168','361000','抚州市','15','0','0','Wuzhou Shi','2');
INSERT INTO `on_region` VALUES ('169','361100','上饶市','15','0','0','Shangrao Shi','2');
INSERT INTO `on_region` VALUES ('170','370100','济南市','16','0','0','Jinan Shi','TNA');
INSERT INTO `on_region` VALUES ('171','370200','青岛市','16','0','0','Qingdao Shi','TAO');
INSERT INTO `on_region` VALUES ('172','370300','淄博市','16','0','0','Zibo Shi','ZBO');
INSERT INTO `on_region` VALUES ('173','370400','枣庄市','16','0','0','Zaozhuang Shi','ZZG');
INSERT INTO `on_region` VALUES ('174','370500','东营市','16','0','0','Dongying Shi','DYG');
INSERT INTO `on_region` VALUES ('175','370600','烟台市','16','0','0','Yantai Shi','YNT');
INSERT INTO `on_region` VALUES ('176','370700','潍坊市','16','0','0','Weifang Shi','WEF');
INSERT INTO `on_region` VALUES ('177','370800','济宁市','16','0','0','Jining Shi','JNG');
INSERT INTO `on_region` VALUES ('178','370900','泰安市','16','0','0','Tai,an Shi','TAI');
INSERT INTO `on_region` VALUES ('179','371000','威海市','16','0','0','Weihai Shi','WEH');
INSERT INTO `on_region` VALUES ('180','371100','日照市','16','0','0','Rizhao Shi','RZH');
INSERT INTO `on_region` VALUES ('181','371200','莱芜市','16','0','0','Laiwu Shi','LWS');
INSERT INTO `on_region` VALUES ('182','371300','临沂市','16','0','0','Linyi Shi','LYI');
INSERT INTO `on_region` VALUES ('183','371400','德州市','16','0','0','Dezhou Shi','DZS');
INSERT INTO `on_region` VALUES ('184','371500','聊城市','16','0','0','Liaocheng Shi','LCH');
INSERT INTO `on_region` VALUES ('185','371600','滨州市','16','0','0','Binzhou Shi','2');
INSERT INTO `on_region` VALUES ('186','371700','菏泽市','16','3','0','Heze Shi','HZ');
INSERT INTO `on_region` VALUES ('187','410100','郑州市','17','0','0','Zhengzhou Shi','CGO');
INSERT INTO `on_region` VALUES ('188','410200','开封市','17','0','0','Kaifeng Shi','KFS');
INSERT INTO `on_region` VALUES ('189','410300','洛阳市','17','0','0','Luoyang Shi','LYA');
INSERT INTO `on_region` VALUES ('190','410400','平顶山市','17','0','0','Pingdingshan Shi','PDS');
INSERT INTO `on_region` VALUES ('191','410500','安阳市','17','0','0','Anyang Shi','AYS');
INSERT INTO `on_region` VALUES ('192','410600','鹤壁市','17','0','0','Hebi Shi','HBS');
INSERT INTO `on_region` VALUES ('193','410700','新乡市','17','0','0','Xinxiang Shi','XXS');
INSERT INTO `on_region` VALUES ('194','410800','焦作市','17','0','0','Jiaozuo Shi','JZY');
INSERT INTO `on_region` VALUES ('195','410900','濮阳市','17','0','0','Puyang Shi','PYS');
INSERT INTO `on_region` VALUES ('196','411000','许昌市','17','0','0','Xuchang Shi','XCS');
INSERT INTO `on_region` VALUES ('197','411100','漯河市','17','0','0','Luohe Shi','LHS');
INSERT INTO `on_region` VALUES ('198','411200','三门峡市','17','0','0','Sanmenxia Shi','SMX');
INSERT INTO `on_region` VALUES ('199','411300','南阳市','17','0','0','Nanyang Shi','NYS');
INSERT INTO `on_region` VALUES ('200','411400','商丘市','17','0','0','Shangqiu Shi','SQS');
INSERT INTO `on_region` VALUES ('201','411500','信阳市','17','0','0','Xinyang Shi','XYG');
INSERT INTO `on_region` VALUES ('202','411600','周口市','17','0','0','Zhoukou Shi','2');
INSERT INTO `on_region` VALUES ('203','411700','驻马店市','17','0','0','Zhumadian Shi','2');
INSERT INTO `on_region` VALUES ('204','420100','武汉市','18','0','0','Wuhan Shi','WUH');
INSERT INTO `on_region` VALUES ('205','420200','黄石市','18','0','0','Huangshi Shi','HIS');
INSERT INTO `on_region` VALUES ('206','420300','十堰市','18','0','0','Shiyan Shi','SYE');
INSERT INTO `on_region` VALUES ('207','420500','宜昌市','18','0','0','Yichang Shi','YCO');
INSERT INTO `on_region` VALUES ('208','420600','襄樊市','18','0','0','Xiangfan Shi','XFN');
INSERT INTO `on_region` VALUES ('209','420700','鄂州市','18','0','0','Ezhou Shi','EZS');
INSERT INTO `on_region` VALUES ('210','420800','荆门市','18','0','0','Jingmen Shi','JMS');
INSERT INTO `on_region` VALUES ('211','420900','孝感市','18','0','0','Xiaogan Shi','XGE');
INSERT INTO `on_region` VALUES ('212','421000','荆州市','18','0','0','Jingzhou Shi','JGZ');
INSERT INTO `on_region` VALUES ('213','421100','黄冈市','18','0','0','Huanggang Shi','HE');
INSERT INTO `on_region` VALUES ('214','421200','咸宁市','18','0','0','Xianning Xian','XNS');
INSERT INTO `on_region` VALUES ('215','421300','随州市','18','0','0','Suizhou Shi','2');
INSERT INTO `on_region` VALUES ('216','422800','恩施土家族苗族自治州','18','0','0','Enshi Tujiazu Miaozu Zizhizhou','ESH');
INSERT INTO `on_region` VALUES ('217','429000','省直辖县级行政区划','18','0','0','shengzhixiaxianjixingzhengquhua','2');
INSERT INTO `on_region` VALUES ('218','430100','长沙市','19','0','0','Changsha Shi','CSX');
INSERT INTO `on_region` VALUES ('219','430200','株洲市','19','0','0','Zhuzhou Shi','ZZS');
INSERT INTO `on_region` VALUES ('220','430300','湘潭市','19','0','0','Xiangtan Shi','XGT');
INSERT INTO `on_region` VALUES ('221','430400','衡阳市','19','0','0','Hengyang Shi','HNY');
INSERT INTO `on_region` VALUES ('222','430500','邵阳市','19','0','0','Shaoyang Shi','SYR');
INSERT INTO `on_region` VALUES ('223','430600','岳阳市','19','0','0','Yueyang Shi','YYG');
INSERT INTO `on_region` VALUES ('224','430700','常德市','19','0','0','Changde Shi','CDE');
INSERT INTO `on_region` VALUES ('225','430800','张家界市','19','0','0','Zhangjiajie Shi','ZJJ');
INSERT INTO `on_region` VALUES ('226','430900','益阳市','19','0','0','Yiyang Shi','YYS');
INSERT INTO `on_region` VALUES ('227','431000','郴州市','19','0','0','Chenzhou Shi','CNZ');
INSERT INTO `on_region` VALUES ('228','431100','永州市','19','0','0','Yongzhou Shi','YZS');
INSERT INTO `on_region` VALUES ('229','431200','怀化市','19','0','0','Huaihua Shi','HHS');
INSERT INTO `on_region` VALUES ('230','431300','娄底市','19','0','0','Loudi Shi','2');
INSERT INTO `on_region` VALUES ('231','433100','湘西土家族苗族自治州','19','0','0','Xiangxi Tujiazu Miaozu Zizhizhou ','XXZ');
INSERT INTO `on_region` VALUES ('232','440100','广州市','20','0','0','Guangzhou Shi','CAN');
INSERT INTO `on_region` VALUES ('233','440200','韶关市','20','0','0','Shaoguan Shi','HSC');
INSERT INTO `on_region` VALUES ('234','440300','深圳市','20','0','0','Shenzhen Shi','SZX');
INSERT INTO `on_region` VALUES ('235','440400','珠海市','20','0','0','Zhuhai Shi','ZUH');
INSERT INTO `on_region` VALUES ('236','440500','汕头市','20','0','0','Shantou Shi','SWA');
INSERT INTO `on_region` VALUES ('237','440600','佛山市','20','0','0','Foshan Shi','FOS');
INSERT INTO `on_region` VALUES ('238','440700','江门市','20','0','0','Jiangmen Shi','JMN');
INSERT INTO `on_region` VALUES ('239','440800','湛江市','20','0','0','Zhanjiang Shi','ZHA');
INSERT INTO `on_region` VALUES ('240','440900','茂名市','20','0','0','Maoming Shi','MMI');
INSERT INTO `on_region` VALUES ('241','441200','肇庆市','20','0','0','Zhaoqing Shi','ZQG');
INSERT INTO `on_region` VALUES ('242','441300','惠州市','20','0','0','Huizhou Shi','HUI');
INSERT INTO `on_region` VALUES ('243','441400','梅州市','20','0','0','Meizhou Shi','MXZ');
INSERT INTO `on_region` VALUES ('244','441500','汕尾市','20','0','0','Shanwei Shi','SWE');
INSERT INTO `on_region` VALUES ('245','441600','河源市','20','0','0','Heyuan Shi','HEY');
INSERT INTO `on_region` VALUES ('246','441700','阳江市','20','0','0','Yangjiang Shi','YJI');
INSERT INTO `on_region` VALUES ('247','441800','清远市','20','0','0','Qingyuan Shi','QYN');
INSERT INTO `on_region` VALUES ('248','441900','东莞市','20','0','0','Dongguan Shi','DGG');
INSERT INTO `on_region` VALUES ('249','442000','中山市','20','0','0','Zhongshan Shi','ZSN');
INSERT INTO `on_region` VALUES ('250','445100','潮州市','20','0','0','Chaozhou Shi','CZY');
INSERT INTO `on_region` VALUES ('251','445200','揭阳市','20','0','0','Jieyang Shi','JIY');
INSERT INTO `on_region` VALUES ('252','445300','云浮市','20','0','0','Yunfu Shi','YFS');
INSERT INTO `on_region` VALUES ('253','450100','南宁市','21','0','0','Nanning Shi','NNG');
INSERT INTO `on_region` VALUES ('254','450200','柳州市','21','0','0','Liuzhou Shi','LZH');
INSERT INTO `on_region` VALUES ('255','450300','桂林市','21','0','0','Guilin Shi','KWL');
INSERT INTO `on_region` VALUES ('256','450400','梧州市','21','0','0','Wuzhou Shi','WUZ');
INSERT INTO `on_region` VALUES ('257','450500','北海市','21','0','0','Beihai Shi','BHY');
INSERT INTO `on_region` VALUES ('258','450600','防城港市','21','0','0','Fangchenggang Shi','FAN');
INSERT INTO `on_region` VALUES ('259','450700','钦州市','21','0','0','Qinzhou Shi','QZH');
INSERT INTO `on_region` VALUES ('260','450800','贵港市','21','0','0','Guigang Shi','GUG');
INSERT INTO `on_region` VALUES ('261','450900','玉林市','21','0','0','Yulin Shi','YUL');
INSERT INTO `on_region` VALUES ('262','451000','百色市','21','0','0','Baise Shi','2');
INSERT INTO `on_region` VALUES ('263','451100','贺州市','21','0','0','Hezhou Shi','2');
INSERT INTO `on_region` VALUES ('264','451200','河池市','21','0','0','Hechi Shi','2');
INSERT INTO `on_region` VALUES ('265','451300','来宾市','21','0','0','Laibin Shi','2');
INSERT INTO `on_region` VALUES ('266','451400','崇左市','21','0','0','Chongzuo Shi','2');
INSERT INTO `on_region` VALUES ('267','460100','海口市','22','0','0','Haikou Shi','HAK');
INSERT INTO `on_region` VALUES ('268','460200','三亚市','22','0','0','Sanya Shi','SYX');
INSERT INTO `on_region` VALUES ('269','469000','省直辖县级行政区划','22','0','0','shengzhixiaxianjixingzhengquhua','2');
INSERT INTO `on_region` VALUES ('270','500100','市辖区','23','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('271','500200','县','23','0','0','Xian','2');
INSERT INTO `on_region` VALUES ('273','510100','成都市','24','0','0','Chengdu Shi','CTU');
INSERT INTO `on_region` VALUES ('274','510300','自贡市','24','0','0','Zigong Shi','ZGS');
INSERT INTO `on_region` VALUES ('275','510400','攀枝花市','24','0','0','Panzhihua Shi','PZH');
INSERT INTO `on_region` VALUES ('276','510500','泸州市','24','0','0','Luzhou Shi','LUZ');
INSERT INTO `on_region` VALUES ('277','510600','德阳市','24','0','0','Deyang Shi','DEY');
INSERT INTO `on_region` VALUES ('278','510700','绵阳市','24','0','0','Mianyang Shi','MYG');
INSERT INTO `on_region` VALUES ('279','510800','广元市','24','0','0','Guangyuan Shi','GYC');
INSERT INTO `on_region` VALUES ('280','510900','遂宁市','24','0','0','Suining Shi','SNS');
INSERT INTO `on_region` VALUES ('281','511000','内江市','24','0','0','Neijiang Shi','NJS');
INSERT INTO `on_region` VALUES ('282','511100','乐山市','24','0','0','Leshan Shi','LES');
INSERT INTO `on_region` VALUES ('283','511300','南充市','24','0','0','Nanchong Shi','NCO');
INSERT INTO `on_region` VALUES ('284','511400','眉山市','24','0','0','Meishan Shi','2');
INSERT INTO `on_region` VALUES ('285','511500','宜宾市','24','0','0','Yibin Shi','YBS');
INSERT INTO `on_region` VALUES ('286','511600','广安市','24','0','0','Guang,an Shi','GAC');
INSERT INTO `on_region` VALUES ('287','511700','达州市','24','0','0','Dazhou Shi','2');
INSERT INTO `on_region` VALUES ('288','511800','雅安市','24','0','0','Ya,an Shi','2');
INSERT INTO `on_region` VALUES ('289','511900','巴中市','24','0','0','Bazhong Shi','2');
INSERT INTO `on_region` VALUES ('290','512000','资阳市','24','0','0','Ziyang Shi','2');
INSERT INTO `on_region` VALUES ('291','513200','阿坝藏族羌族自治州','24','0','0','Aba(Ngawa) Zangzu Qiangzu Zizhizhou','ABA');
INSERT INTO `on_region` VALUES ('292','513300','甘孜藏族自治州','24','0','0','Garze Zangzu Zizhizhou','GAZ');
INSERT INTO `on_region` VALUES ('293','513400','凉山彝族自治州','24','0','0','Liangshan Yizu Zizhizhou','LSY');
INSERT INTO `on_region` VALUES ('294','520100','贵阳市','25','0','0','Guiyang Shi','KWE');
INSERT INTO `on_region` VALUES ('295','520200','六盘水市','25','0','0','Liupanshui Shi','LPS');
INSERT INTO `on_region` VALUES ('296','520300','遵义市','25','0','0','Zunyi Shi','ZNY');
INSERT INTO `on_region` VALUES ('297','520400','安顺市','25','0','0','Anshun Xian','2');
INSERT INTO `on_region` VALUES ('298','522200','铜仁地区','25','0','0','Tongren Diqu','TRD');
INSERT INTO `on_region` VALUES ('299','522300','黔西南布依族苗族自治州','25','0','0','Qianxinan Buyeizu Zizhizhou','QXZ');
INSERT INTO `on_region` VALUES ('300','522400','毕节地区','25','0','0','Bijie Diqu','BJD');
INSERT INTO `on_region` VALUES ('301','522600','黔东南苗族侗族自治州','25','0','0','Qiandongnan Miaozu Dongzu Zizhizhou','QND');
INSERT INTO `on_region` VALUES ('302','522700','黔南布依族苗族自治州','25','0','0','Qiannan Buyeizu Miaozu Zizhizhou','QNZ');
INSERT INTO `on_region` VALUES ('303','530100','昆明市','26','0','0','Kunming Shi','KMG');
INSERT INTO `on_region` VALUES ('304','530300','曲靖市','26','0','0','Qujing Shi','QJS');
INSERT INTO `on_region` VALUES ('305','530400','玉溪市','26','0','0','Yuxi Shi','YXS');
INSERT INTO `on_region` VALUES ('306','530500','保山市','26','0','0','Baoshan Shi','2');
INSERT INTO `on_region` VALUES ('307','530600','昭通市','26','0','0','Zhaotong Shi','2');
INSERT INTO `on_region` VALUES ('308','530700','丽江市','26','0','0','Lijiang Shi','2');
INSERT INTO `on_region` VALUES ('309','530800','普洱市','26','0','0','Simao Shi','2');
INSERT INTO `on_region` VALUES ('310','530900','临沧市','26','0','0','Lincang Shi','2');
INSERT INTO `on_region` VALUES ('311','532300','楚雄彝族自治州','26','0','0','Chuxiong Yizu Zizhizhou','CXD');
INSERT INTO `on_region` VALUES ('312','532500','红河哈尼族彝族自治州','26','0','0','Honghe Hanizu Yizu Zizhizhou','HHZ');
INSERT INTO `on_region` VALUES ('313','532600','文山壮族苗族自治州','26','0','0','Wenshan Zhuangzu Miaozu Zizhizhou','WSZ');
INSERT INTO `on_region` VALUES ('314','532800','西双版纳傣族自治州','26','0','0','Xishuangbanna Daizu Zizhizhou','XSB');
INSERT INTO `on_region` VALUES ('315','532900','大理白族自治州','26','0','0','Dali Baizu Zizhizhou','DLZ');
INSERT INTO `on_region` VALUES ('316','533100','德宏傣族景颇族自治州','26','0','0','Dehong Daizu Jingpozu Zizhizhou','DHG');
INSERT INTO `on_region` VALUES ('317','533300','怒江傈僳族自治州','26','0','0','Nujiang Lisuzu Zizhizhou','NUJ');
INSERT INTO `on_region` VALUES ('318','533400','迪庆藏族自治州','26','0','0','Deqen Zangzu Zizhizhou','DEZ');
INSERT INTO `on_region` VALUES ('319','540100','拉萨市','27','0','0','Lhasa Shi','LXA');
INSERT INTO `on_region` VALUES ('320','542100','昌都地区','27','0','0','Qamdo Diqu','QAD');
INSERT INTO `on_region` VALUES ('321','542200','山南地区','27','0','0','Shannan Diqu','SND');
INSERT INTO `on_region` VALUES ('322','542300','日喀则地区','27','0','0','Xigaze Diqu','XID');
INSERT INTO `on_region` VALUES ('323','542400','那曲地区','27','0','0','Nagqu Diqu','NAD');
INSERT INTO `on_region` VALUES ('324','542500','阿里地区','27','0','0','Ngari Diqu','NGD');
INSERT INTO `on_region` VALUES ('325','542600','林芝地区','27','0','0','Nyingchi Diqu','NYD');
INSERT INTO `on_region` VALUES ('326','610100','西安市','28','0','0','Xi,an Shi','SIA');
INSERT INTO `on_region` VALUES ('327','610200','铜川市','28','0','0','Tongchuan Shi','TCN');
INSERT INTO `on_region` VALUES ('328','610300','宝鸡市','28','0','0','Baoji Shi','BJI');
INSERT INTO `on_region` VALUES ('329','610400','咸阳市','28','0','0','Xianyang Shi','XYS');
INSERT INTO `on_region` VALUES ('330','610500','渭南市','28','0','0','Weinan Shi','WNA');
INSERT INTO `on_region` VALUES ('331','610600','延安市','28','0','0','Yan,an Shi','YNA');
INSERT INTO `on_region` VALUES ('332','610700','汉中市','28','0','0','Hanzhong Shi','HZJ');
INSERT INTO `on_region` VALUES ('333','610800','榆林市','28','0','0','Yulin Shi','2');
INSERT INTO `on_region` VALUES ('334','610900','安康市','28','0','0','Ankang Shi','2');
INSERT INTO `on_region` VALUES ('335','611000','商洛市','28','0','0','Shangluo Shi','2');
INSERT INTO `on_region` VALUES ('336','620100','兰州市','29','0','0','Lanzhou Shi','LHW');
INSERT INTO `on_region` VALUES ('337','620200','嘉峪关市','29','0','0','Jiayuguan Shi','JYG');
INSERT INTO `on_region` VALUES ('338','620300','金昌市','29','0','0','Jinchang Shi','JCS');
INSERT INTO `on_region` VALUES ('339','620400','白银市','29','0','0','Baiyin Shi','BYS');
INSERT INTO `on_region` VALUES ('340','620500','天水市','29','0','0','Tianshui Shi','TSU');
INSERT INTO `on_region` VALUES ('341','620600','武威市','29','0','0','Wuwei Shi','2');
INSERT INTO `on_region` VALUES ('342','620700','张掖市','29','0','0','Zhangye Shi','2');
INSERT INTO `on_region` VALUES ('343','620800','平凉市','29','0','0','Pingliang Shi','2');
INSERT INTO `on_region` VALUES ('344','620900','酒泉市','29','0','0','Jiuquan Shi','2');
INSERT INTO `on_region` VALUES ('345','621000','庆阳市','29','0','0','Qingyang Shi','2');
INSERT INTO `on_region` VALUES ('346','621100','定西市','29','0','0','Dingxi Shi','2');
INSERT INTO `on_region` VALUES ('347','621200','陇南市','29','0','0','Longnan Shi','2');
INSERT INTO `on_region` VALUES ('348','622900','临夏回族自治州','29','0','0','Linxia Huizu Zizhizhou ','LXH');
INSERT INTO `on_region` VALUES ('349','623000','甘南藏族自治州','29','0','0','Gannan Zangzu Zizhizhou','GNZ');
INSERT INTO `on_region` VALUES ('350','630100','西宁市','30','0','0','Xining Shi','XNN');
INSERT INTO `on_region` VALUES ('351','632100','海东地区','30','0','0','Haidong Diqu','HDD');
INSERT INTO `on_region` VALUES ('352','632200','海北藏族自治州','30','0','0','Haibei Zangzu Zizhizhou','HBZ');
INSERT INTO `on_region` VALUES ('353','632300','黄南藏族自治州','30','0','0','Huangnan Zangzu Zizhizhou','HNZ');
INSERT INTO `on_region` VALUES ('354','632500','海南藏族自治州','30','0','0','Hainan Zangzu Zizhizhou','HNN');
INSERT INTO `on_region` VALUES ('355','632600','果洛藏族自治州','30','0','0','Golog Zangzu Zizhizhou','GOL');
INSERT INTO `on_region` VALUES ('356','632700','玉树藏族自治州','30','0','0','Yushu Zangzu Zizhizhou','YSZ');
INSERT INTO `on_region` VALUES ('357','632800','海西蒙古族藏族自治州','30','0','0','Haixi Mongolzu Zangzu Zizhizhou','HXZ');
INSERT INTO `on_region` VALUES ('358','640100','银川市','31','0','0','Yinchuan Shi','INC');
INSERT INTO `on_region` VALUES ('359','640200','石嘴山市','31','0','0','Shizuishan Shi','SZS');
INSERT INTO `on_region` VALUES ('360','640300','吴忠市','31','0','0','Wuzhong Shi','WZS');
INSERT INTO `on_region` VALUES ('361','640400','固原市','31','0','0','Guyuan Shi','2');
INSERT INTO `on_region` VALUES ('362','640500','中卫市','31','0','0','Zhongwei Shi','2');
INSERT INTO `on_region` VALUES ('363','650100','乌鲁木齐市','32','0','0','Urumqi Shi','URC');
INSERT INTO `on_region` VALUES ('364','650200','克拉玛依市','32','0','0','Karamay Shi','KAR');
INSERT INTO `on_region` VALUES ('365','652100','吐鲁番地区','32','0','0','Turpan Diqu','TUD');
INSERT INTO `on_region` VALUES ('366','652200','哈密地区','32','0','0','Hami(kumul) Diqu','HMD');
INSERT INTO `on_region` VALUES ('367','652300','昌吉回族自治州','32','0','0','Changji Huizu Zizhizhou','CJZ');
INSERT INTO `on_region` VALUES ('368','652700','博尔塔拉蒙古自治州','32','0','0','Bortala Monglo Zizhizhou','BOR');
INSERT INTO `on_region` VALUES ('369','652800','巴音郭楞蒙古自治州','32','0','0','bayinguolengmengguzizhizhou','2');
INSERT INTO `on_region` VALUES ('370','652900','阿克苏地区','32','0','0','Aksu Diqu','AKD');
INSERT INTO `on_region` VALUES ('371','653000','克孜勒苏柯尔克孜自治州','32','0','0','Kizilsu Kirgiz Zizhizhou','KIZ');
INSERT INTO `on_region` VALUES ('372','653100','喀什地区','32','0','0','Kashi(Kaxgar) Diqu','KSI');
INSERT INTO `on_region` VALUES ('373','653200','和田地区','32','0','0','Hotan Diqu','HOD');
INSERT INTO `on_region` VALUES ('374','654000','伊犁哈萨克自治州','32','0','0','Ili Kazak Zizhizhou','ILD');
INSERT INTO `on_region` VALUES ('375','654200','塔城地区','32','0','0','Tacheng(Qoqek) Diqu','TCD');
INSERT INTO `on_region` VALUES ('376','654300','阿勒泰地区','32','0','0','Altay Diqu','ALD');
INSERT INTO `on_region` VALUES ('377','659000','自治区直辖县级行政区划','32','0','0','zizhiquzhixiaxianjixingzhengquhua','2');
INSERT INTO `on_region` VALUES ('378','110101','东城区','33','0','0','Dongcheng Qu','DCQ');
INSERT INTO `on_region` VALUES ('379','110102','西城区','33','0','0','Xicheng Qu','XCQ');
INSERT INTO `on_region` VALUES ('382','110105','朝阳区','33','0','0','Chaoyang Qu','CYQ');
INSERT INTO `on_region` VALUES ('383','110106','丰台区','33','0','0','Fengtai Qu','FTQ');
INSERT INTO `on_region` VALUES ('384','110107','石景山区','33','0','0','Shijingshan Qu','SJS');
INSERT INTO `on_region` VALUES ('385','110108','海淀区','33','0','0','Haidian Qu','HDN');
INSERT INTO `on_region` VALUES ('386','110109','门头沟区','33','0','0','Mentougou Qu','MTG');
INSERT INTO `on_region` VALUES ('387','110111','房山区','33','0','0','Fangshan Qu','FSQ');
INSERT INTO `on_region` VALUES ('388','110112','通州区','33','0','0','Tongzhou Qu','TZQ');
INSERT INTO `on_region` VALUES ('389','110113','顺义区','33','0','0','Shunyi Qu','SYI');
INSERT INTO `on_region` VALUES ('390','110114','昌平区','33','0','0','Changping Qu','CP Q');
INSERT INTO `on_region` VALUES ('391','110115','大兴区','33','0','0','Daxing Qu','DX Q');
INSERT INTO `on_region` VALUES ('392','110116','怀柔区','33','0','0','Huairou Qu','HR Q');
INSERT INTO `on_region` VALUES ('393','110117','平谷区','33','0','0','Pinggu Qu','PG Q');
INSERT INTO `on_region` VALUES ('394','110228','密云县','34','0','0','Miyun Xian ','MYN');
INSERT INTO `on_region` VALUES ('395','110229','延庆县','34','0','0','Yanqing Xian','YQX');
INSERT INTO `on_region` VALUES ('396','120101','和平区','35','0','0','Heping Qu','HPG');
INSERT INTO `on_region` VALUES ('397','120102','河东区','35','0','0','Hedong Qu','HDQ');
INSERT INTO `on_region` VALUES ('398','120103','河西区','35','0','0','Hexi Qu','HXQ');
INSERT INTO `on_region` VALUES ('399','120104','南开区','35','0','0','Nankai Qu','NKQ');
INSERT INTO `on_region` VALUES ('400','120105','河北区','35','0','0','Hebei Qu','HBQ');
INSERT INTO `on_region` VALUES ('401','120106','红桥区','35','0','0','Hongqiao Qu','HQO');
INSERT INTO `on_region` VALUES ('404','120116','滨海新区','35','0','0','Dagang Qu','2');
INSERT INTO `on_region` VALUES ('405','120110','东丽区','35','0','0','Dongli Qu','DLI');
INSERT INTO `on_region` VALUES ('406','120111','西青区','35','0','0','Xiqing Qu','XQG');
INSERT INTO `on_region` VALUES ('407','120112','津南区','35','0','0','Jinnan Qu','JNQ');
INSERT INTO `on_region` VALUES ('408','120113','北辰区','35','0','0','Beichen Qu','BCQ');
INSERT INTO `on_region` VALUES ('409','120114','武清区','35','0','0','Wuqing Qu','WQ Q');
INSERT INTO `on_region` VALUES ('410','120115','宝坻区','35','0','0','Baodi Qu','BDI');
INSERT INTO `on_region` VALUES ('411','120221','宁河县','36','0','0','Ninghe Xian','NHE');
INSERT INTO `on_region` VALUES ('412','120223','静海县','36','0','0','Jinghai Xian','JHT');
INSERT INTO `on_region` VALUES ('413','120225','蓟县','36','0','0','Ji Xian','JIT');
INSERT INTO `on_region` VALUES ('414','130101','市辖区','37','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('415','130102','长安区','37','0','0','Chang,an Qu','CAQ');
INSERT INTO `on_region` VALUES ('416','130103','桥东区','37','0','0','Qiaodong Qu','QDQ');
INSERT INTO `on_region` VALUES ('417','130104','桥西区','37','0','0','Qiaoxi Qu','QXQ');
INSERT INTO `on_region` VALUES ('418','130105','新华区','37','0','0','Xinhua Qu','XHK');
INSERT INTO `on_region` VALUES ('419','130107','井陉矿区','37','0','0','Jingxing Kuangqu','JXK');
INSERT INTO `on_region` VALUES ('420','130108','裕华区','37','0','0','Yuhua Qu','2');
INSERT INTO `on_region` VALUES ('421','130121','井陉县','37','0','0','Jingxing Xian','JXJ');
INSERT INTO `on_region` VALUES ('422','130123','正定县','37','0','0','Zhengding Xian','ZDJ');
INSERT INTO `on_region` VALUES ('423','130124','栾城县','37','0','0','Luancheng Xian','LCG');
INSERT INTO `on_region` VALUES ('424','130125','行唐县','37','0','0','Xingtang Xian','XTG');
INSERT INTO `on_region` VALUES ('425','130126','灵寿县','37','0','0','Lingshou Xian ','LSO');
INSERT INTO `on_region` VALUES ('426','130127','高邑县','37','0','0','Gaoyi Xian','GYJ');
INSERT INTO `on_region` VALUES ('427','130128','深泽县','37','0','0','Shenze Xian','2');
INSERT INTO `on_region` VALUES ('428','130129','赞皇县','37','0','0','Zanhuang Xian','ZHG');
INSERT INTO `on_region` VALUES ('429','130130','无极县','37','0','0','Wuji Xian','WJI');
INSERT INTO `on_region` VALUES ('430','130131','平山县','37','0','0','Pingshan Xian','PSH');
INSERT INTO `on_region` VALUES ('431','130132','元氏县','37','0','0','Yuanshi Xian','YSI');
INSERT INTO `on_region` VALUES ('432','130133','赵县','37','0','0','Zhao Xian','ZAO');
INSERT INTO `on_region` VALUES ('433','130181','辛集市','37','0','0','Xinji Shi','XJS');
INSERT INTO `on_region` VALUES ('434','130182','藁城市','37','0','0','Gaocheng Shi','GCS');
INSERT INTO `on_region` VALUES ('435','130183','晋州市','37','0','0','Jinzhou Shi','JZJ');
INSERT INTO `on_region` VALUES ('436','130184','新乐市','37','0','0','Xinle Shi','XLE');
INSERT INTO `on_region` VALUES ('437','130185','鹿泉市','37','0','0','Luquan Shi','LUQ');
INSERT INTO `on_region` VALUES ('438','130201','市辖区','38','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('439','130202','路南区','38','0','0','Lunan Qu','LNB');
INSERT INTO `on_region` VALUES ('440','130203','路北区','38','0','0','Lubei Qu','LBQ');
INSERT INTO `on_region` VALUES ('441','130204','古冶区','38','0','0','Guye Qu','GYE');
INSERT INTO `on_region` VALUES ('442','130205','开平区','38','0','0','Kaiping Qu','KPQ');
INSERT INTO `on_region` VALUES ('443','130207','丰南区','38','0','0','Fengnan Qu','2');
INSERT INTO `on_region` VALUES ('444','130208','丰润区','38','0','0','Fengrun Qu','2');
INSERT INTO `on_region` VALUES ('445','130223','滦县','38','0','0','Luan Xian','LUA');
INSERT INTO `on_region` VALUES ('446','130224','滦南县','38','0','0','Luannan Xian','LNJ');
INSERT INTO `on_region` VALUES ('447','130225','乐亭县','38','0','0','Leting Xian','LTJ');
INSERT INTO `on_region` VALUES ('448','130227','迁西县','38','0','0','Qianxi Xian','QXX');
INSERT INTO `on_region` VALUES ('449','130229','玉田县','38','0','0','Yutian Xian','YTJ');
INSERT INTO `on_region` VALUES ('450','130230','唐海县','38','0','0','Tanghai Xian ','THA');
INSERT INTO `on_region` VALUES ('451','130281','遵化市','38','0','0','Zunhua Shi','ZNH');
INSERT INTO `on_region` VALUES ('452','130283','迁安市','38','0','0','Qian,an Shi','QAS');
INSERT INTO `on_region` VALUES ('453','130301','市辖区','39','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('454','130302','海港区','39','0','0','Haigang Qu','HGG');
INSERT INTO `on_region` VALUES ('455','130303','山海关区','39','0','0','Shanhaiguan Qu','SHG');
INSERT INTO `on_region` VALUES ('456','130304','北戴河区','39','0','0','Beidaihe Qu','BDH');
INSERT INTO `on_region` VALUES ('457','130321','青龙满族自治县','39','0','0','Qinglong Manzu Zizhixian','QLM');
INSERT INTO `on_region` VALUES ('458','130322','昌黎县','39','0','0','Changli Xian','CGL');
INSERT INTO `on_region` VALUES ('459','130323','抚宁县','39','0','0','Funing Xian ','FUN');
INSERT INTO `on_region` VALUES ('460','130324','卢龙县','39','0','0','Lulong Xian','LLG');
INSERT INTO `on_region` VALUES ('461','130401','市辖区','40','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('462','130402','邯山区','40','0','0','Hanshan Qu','HHD');
INSERT INTO `on_region` VALUES ('463','130403','丛台区','40','0','0','Congtai Qu','CTQ');
INSERT INTO `on_region` VALUES ('464','130404','复兴区','40','0','0','Fuxing Qu','FXQ');
INSERT INTO `on_region` VALUES ('465','130406','峰峰矿区','40','0','0','Fengfeng Kuangqu','FFK');
INSERT INTO `on_region` VALUES ('466','130421','邯郸县','40','0','0','Handan Xian ','HDX');
INSERT INTO `on_region` VALUES ('467','130423','临漳县','40','0','0','Linzhang Xian ','LNZ');
INSERT INTO `on_region` VALUES ('468','130424','成安县','40','0','0','Cheng,an Xian','CAJ');
INSERT INTO `on_region` VALUES ('469','130425','大名县','40','0','0','Daming Xian','DMX');
INSERT INTO `on_region` VALUES ('470','130426','涉县','40','0','0','She Xian','SEJ');
INSERT INTO `on_region` VALUES ('471','130427','磁县','40','0','0','Ci Xian','CIX');
INSERT INTO `on_region` VALUES ('472','130428','肥乡县','40','0','0','Feixiang Xian','FXJ');
INSERT INTO `on_region` VALUES ('473','130429','永年县','40','0','0','Yongnian Xian','YON');
INSERT INTO `on_region` VALUES ('474','130430','邱县','40','0','0','Qiu Xian','QIU');
INSERT INTO `on_region` VALUES ('475','130431','鸡泽县','40','0','0','Jize Xian','JZE');
INSERT INTO `on_region` VALUES ('476','130432','广平县','40','0','0','Guangping Xian ','GPX');
INSERT INTO `on_region` VALUES ('477','130433','馆陶县','40','0','0','Guantao Xian','GTO');
INSERT INTO `on_region` VALUES ('478','130434','魏县','40','0','0','Wei Xian ','WEI');
INSERT INTO `on_region` VALUES ('479','130435','曲周县','40','0','0','Quzhou Xian ','QZX');
INSERT INTO `on_region` VALUES ('480','130481','武安市','40','0','0','Wu,an Shi','WUA');
INSERT INTO `on_region` VALUES ('481','130501','市辖区','41','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('482','130502','桥东区','41','0','0','Qiaodong Qu','QDG');
INSERT INTO `on_region` VALUES ('483','130503','桥西区','41','0','0','Qiaoxi Qu','QXT');
INSERT INTO `on_region` VALUES ('484','130521','邢台县','41','0','0','Xingtai Xian','XTJ');
INSERT INTO `on_region` VALUES ('485','130522','临城县','41','0','0','Lincheng Xian ','LNC');
INSERT INTO `on_region` VALUES ('486','130523','内丘县','41','0','0','Neiqiu Xian ','NQU');
INSERT INTO `on_region` VALUES ('487','130524','柏乡县','41','0','0','Baixiang Xian','BXG');
INSERT INTO `on_region` VALUES ('488','130525','隆尧县','41','0','0','Longyao Xian','LYO');
INSERT INTO `on_region` VALUES ('489','130526','任县','41','0','0','Ren Xian','REN');
INSERT INTO `on_region` VALUES ('490','130527','南和县','41','0','0','Nanhe Xian','NHX');
INSERT INTO `on_region` VALUES ('491','130528','宁晋县','41','0','0','Ningjin Xian','NJN');
INSERT INTO `on_region` VALUES ('492','130529','巨鹿县','41','0','0','Julu Xian','JLU');
INSERT INTO `on_region` VALUES ('493','130530','新河县','41','0','0','Xinhe Xian ','XHJ');
INSERT INTO `on_region` VALUES ('494','130531','广宗县','41','0','0','Guangzong Xian ','GZJ');
INSERT INTO `on_region` VALUES ('495','130532','平乡县','41','0','0','Pingxiang Xian','PXX');
INSERT INTO `on_region` VALUES ('496','130533','威县','41','0','0','Wei Xian ','WEX');
INSERT INTO `on_region` VALUES ('497','130534','清河县','41','0','0','Qinghe Xian','QHE');
INSERT INTO `on_region` VALUES ('498','130535','临西县','41','0','0','Linxi Xian','LXI');
INSERT INTO `on_region` VALUES ('499','130581','南宫市','41','0','0','Nangong Shi','NGO');
INSERT INTO `on_region` VALUES ('500','130582','沙河市','41','0','0','Shahe Shi','SHS');
INSERT INTO `on_region` VALUES ('501','130601','市辖区','42','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('502','130600','新市区','42','0','0','Xinshi Qu','2');
INSERT INTO `on_region` VALUES ('503','130603','北市区','42','0','0','Beishi Qu','BSI');
INSERT INTO `on_region` VALUES ('504','130604','南市区','42','0','0','Nanshi Qu','NSB');
INSERT INTO `on_region` VALUES ('505','130621','满城县','42','0','0','Mancheng Xian ','MCE');
INSERT INTO `on_region` VALUES ('506','130622','清苑县','42','0','0','Qingyuan Xian','QYJ');
INSERT INTO `on_region` VALUES ('507','130623','涞水县','42','0','0','Laishui Xian','LSM');
INSERT INTO `on_region` VALUES ('508','130624','阜平县','42','0','0','Fuping Xian ','FUP');
INSERT INTO `on_region` VALUES ('509','130625','徐水县','42','0','0','Xushui Xian ','XSJ');
INSERT INTO `on_region` VALUES ('510','130626','定兴县','42','0','0','Dingxing Xian ','DXG');
INSERT INTO `on_region` VALUES ('511','130627','唐县','42','0','0','Tang Xian ','TAG');
INSERT INTO `on_region` VALUES ('512','130628','高阳县','42','0','0','Gaoyang Xian ','GAY');
INSERT INTO `on_region` VALUES ('513','130629','容城县','42','0','0','Rongcheng Xian ','RCX');
INSERT INTO `on_region` VALUES ('514','130630','涞源县','42','0','0','Laiyuan Xian ','LIY');
INSERT INTO `on_region` VALUES ('515','130631','望都县','42','0','0','Wangdu Xian ','WDU');
INSERT INTO `on_region` VALUES ('516','130632','安新县','42','0','0','Anxin Xian ','AXX');
INSERT INTO `on_region` VALUES ('517','130633','易县','42','0','0','Yi Xian','YII');
INSERT INTO `on_region` VALUES ('518','130634','曲阳县','42','0','0','Quyang Xian ','QUY');
INSERT INTO `on_region` VALUES ('519','130635','蠡县','42','0','0','Li Xian','LXJ');
INSERT INTO `on_region` VALUES ('520','130636','顺平县','42','0','0','Shunping Xian ','SPI');
INSERT INTO `on_region` VALUES ('521','130637','博野县','42','0','0','Boye Xian ','BYE');
INSERT INTO `on_region` VALUES ('522','130638','雄县','42','0','0','Xiong Xian','XOX');
INSERT INTO `on_region` VALUES ('523','130681','涿州市','42','0','0','Zhuozhou Shi','ZZO');
INSERT INTO `on_region` VALUES ('524','130682','定州市','42','0','0','Dingzhou Shi ','DZO');
INSERT INTO `on_region` VALUES ('525','130683','安国市','42','0','0','Anguo Shi ','AGO');
INSERT INTO `on_region` VALUES ('526','130684','高碑店市','42','0','0','Gaobeidian Shi','GBD');
INSERT INTO `on_region` VALUES ('527','130701','市辖区','43','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('528','130702','桥东区','43','0','0','Qiaodong Qu','QDZ');
INSERT INTO `on_region` VALUES ('529','130703','桥西区','43','0','0','Qiaoxi Qu','QXI');
INSERT INTO `on_region` VALUES ('530','130705','宣化区','43','0','0','Xuanhua Qu','XHZ');
INSERT INTO `on_region` VALUES ('531','130706','下花园区','43','0','0','Xiahuayuan Qu ','XHY');
INSERT INTO `on_region` VALUES ('532','130721','宣化县','43','0','0','Xuanhua Xian ','XHX');
INSERT INTO `on_region` VALUES ('533','130722','张北县','43','0','0','Zhangbei Xian ','ZGB');
INSERT INTO `on_region` VALUES ('534','130723','康保县','43','0','0','Kangbao Xian','KBO');
INSERT INTO `on_region` VALUES ('535','130724','沽源县','43','0','0','Guyuan Xian','2');
INSERT INTO `on_region` VALUES ('536','130725','尚义县','43','0','0','Shangyi Xian','SYK');
INSERT INTO `on_region` VALUES ('537','130726','蔚县','43','0','0','Yu Xian','YXJ');
INSERT INTO `on_region` VALUES ('538','130727','阳原县','43','0','0','Yangyuan Xian','YYN');
INSERT INTO `on_region` VALUES ('539','130728','怀安县','43','0','0','Huai,an Xian','HAX');
INSERT INTO `on_region` VALUES ('540','130729','万全县','43','0','0','Wanquan Xian ','WQN');
INSERT INTO `on_region` VALUES ('541','130730','怀来县','43','0','0','Huailai Xian','HLA');
INSERT INTO `on_region` VALUES ('542','130731','涿鹿县','43','0','0','Zhuolu Xian ','ZLU');
INSERT INTO `on_region` VALUES ('543','130732','赤城县','43','0','0','Chicheng Xian','CCX');
INSERT INTO `on_region` VALUES ('544','130733','崇礼县','43','0','0','Chongli Xian','COL');
INSERT INTO `on_region` VALUES ('545','130801','市辖区','44','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('546','130802','双桥区','44','0','0','Shuangqiao Qu ','SQO');
INSERT INTO `on_region` VALUES ('547','130803','双滦区','44','0','0','Shuangluan Qu','SLQ');
INSERT INTO `on_region` VALUES ('548','130804','鹰手营子矿区','44','0','0','Yingshouyingzi Kuangqu','YSY');
INSERT INTO `on_region` VALUES ('549','130821','承德县','44','0','0','Chengde Xian','CDX');
INSERT INTO `on_region` VALUES ('550','130822','兴隆县','44','0','0','Xinglong Xian','XLJ');
INSERT INTO `on_region` VALUES ('551','130823','平泉县','44','0','0','Pingquan Xian','PQN');
INSERT INTO `on_region` VALUES ('552','130824','滦平县','44','0','0','Luanping Xian ','LUP');
INSERT INTO `on_region` VALUES ('553','130825','隆化县','44','0','0','Longhua Xian','LHJ');
INSERT INTO `on_region` VALUES ('554','130826','丰宁满族自治县','44','0','0','Fengning Manzu Zizhixian','FNJ');
INSERT INTO `on_region` VALUES ('555','130827','宽城满族自治县','44','0','0','Kuancheng Manzu Zizhixian','KCX');
INSERT INTO `on_region` VALUES ('556','130828','围场满族蒙古族自治县','44','0','0','Weichang Manzu Menggolzu Zizhixian','WCJ');
INSERT INTO `on_region` VALUES ('557','130901','市辖区','45','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('558','130902','新华区','45','0','0','Xinhua Qu','XHF');
INSERT INTO `on_region` VALUES ('559','130903','运河区','45','0','0','Yunhe Qu','YHC');
INSERT INTO `on_region` VALUES ('560','130921','沧县','45','0','0','Cang Xian','CAG');
INSERT INTO `on_region` VALUES ('561','130922','青县','45','0','0','Qing Xian','QIG');
INSERT INTO `on_region` VALUES ('562','130923','东光县','45','0','0','Dongguang Xian ','DGU');
INSERT INTO `on_region` VALUES ('563','130924','海兴县','45','0','0','Haixing Xian','HXG');
INSERT INTO `on_region` VALUES ('564','130925','盐山县','45','0','0','Yanshan Xian','YNS');
INSERT INTO `on_region` VALUES ('565','130926','肃宁县','45','0','0','Suning Xian ','SNG');
INSERT INTO `on_region` VALUES ('566','130927','南皮县','45','0','0','Nanpi Xian','NPI');
INSERT INTO `on_region` VALUES ('567','130928','吴桥县','45','0','0','Wuqiao Xian ','WUQ');
INSERT INTO `on_region` VALUES ('568','130929','献县','45','0','0','Xian Xian ','XXN');
INSERT INTO `on_region` VALUES ('569','130930','孟村回族自治县','45','0','0','Mengcun Huizu Zizhixian','MCN');
INSERT INTO `on_region` VALUES ('570','130981','泊头市','45','0','0','Botou Shi ','BOT');
INSERT INTO `on_region` VALUES ('571','130982','任丘市','45','0','0','Renqiu Shi','RQS');
INSERT INTO `on_region` VALUES ('572','130983','黄骅市','45','0','0','Huanghua Shi','HHJ');
INSERT INTO `on_region` VALUES ('573','130984','河间市','45','0','0','Hejian Shi','HJN');
INSERT INTO `on_region` VALUES ('574','131001','市辖区','46','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('575','131002','安次区','46','0','0','Anci Qu','ACI');
INSERT INTO `on_region` VALUES ('576','131003','广阳区','46','0','0','Guangyang Qu','2');
INSERT INTO `on_region` VALUES ('577','131022','固安县','46','0','0','Gu,an Xian','GUA');
INSERT INTO `on_region` VALUES ('578','131023','永清县','46','0','0','Yongqing Xian ','YQG');
INSERT INTO `on_region` VALUES ('579','131024','香河县','46','0','0','Xianghe Xian','XGH');
INSERT INTO `on_region` VALUES ('580','131025','大城县','46','0','0','Dacheng Xian','DCJ');
INSERT INTO `on_region` VALUES ('581','131026','文安县','46','0','0','Wen,an Xian','WEA');
INSERT INTO `on_region` VALUES ('582','131028','大厂回族自治县','46','0','0','Dachang Huizu Zizhixian','DCG');
INSERT INTO `on_region` VALUES ('583','131081','霸州市','46','0','0','Bazhou Shi','BZO');
INSERT INTO `on_region` VALUES ('584','131082','三河市','46','0','0','Sanhe Shi','SNH');
INSERT INTO `on_region` VALUES ('585','131101','市辖区','47','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('586','131102','桃城区','47','0','0','Taocheng Qu','TOC');
INSERT INTO `on_region` VALUES ('587','131121','枣强县','47','0','0','Zaoqiang Xian ','ZQJ');
INSERT INTO `on_region` VALUES ('588','131122','武邑县','47','0','0','Wuyi Xian','WYI');
INSERT INTO `on_region` VALUES ('589','131123','武强县','47','0','0','Wuqiang Xian ','WQG');
INSERT INTO `on_region` VALUES ('590','131124','饶阳县','47','0','0','Raoyang Xian','RYG');
INSERT INTO `on_region` VALUES ('591','131125','安平县','47','0','0','Anping Xian','APG');
INSERT INTO `on_region` VALUES ('592','131126','故城县','47','0','0','Gucheng Xian','GCE');
INSERT INTO `on_region` VALUES ('593','131127','景县','47','0','0','Jing Xian ','JIG');
INSERT INTO `on_region` VALUES ('594','131128','阜城县','47','0','0','Fucheng Xian ','FCE');
INSERT INTO `on_region` VALUES ('595','131181','冀州市','47','0','0','Jizhou Shi ','JIZ');
INSERT INTO `on_region` VALUES ('596','131182','深州市','47','0','0','Shenzhou Shi','SNZ');
INSERT INTO `on_region` VALUES ('597','140101','市辖区','48','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('598','140105','小店区','48','0','0','Xiaodian Qu','XDQ');
INSERT INTO `on_region` VALUES ('599','140106','迎泽区','48','0','0','Yingze Qu','YZT');
INSERT INTO `on_region` VALUES ('600','140107','杏花岭区','48','0','0','Xinghualing Qu','XHL');
INSERT INTO `on_region` VALUES ('601','140108','尖草坪区','48','0','0','Jiancaoping Qu','JCP');
INSERT INTO `on_region` VALUES ('602','140109','万柏林区','48','0','0','Wanbailin Qu','WBL');
INSERT INTO `on_region` VALUES ('603','140110','晋源区','48','0','0','Jinyuan Qu','JYM');
INSERT INTO `on_region` VALUES ('604','140121','清徐县','48','0','0','Qingxu Xian ','QXU');
INSERT INTO `on_region` VALUES ('605','140122','阳曲县','48','0','0','Yangqu Xian ','YGQ');
INSERT INTO `on_region` VALUES ('606','140123','娄烦县','48','0','0','Loufan Xian','LFA');
INSERT INTO `on_region` VALUES ('607','140181','古交市','48','0','0','Gujiao Shi','GUJ');
INSERT INTO `on_region` VALUES ('608','140201','市辖区','49','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('609','140202','城区','49','0','0','Chengqu','CQD');
INSERT INTO `on_region` VALUES ('610','140203','矿区','49','0','0','Kuangqu','KQD');
INSERT INTO `on_region` VALUES ('611','140211','南郊区','49','0','0','Nanjiao Qu','NJQ');
INSERT INTO `on_region` VALUES ('612','140212','新荣区','49','0','0','Xinrong Qu','XRQ');
INSERT INTO `on_region` VALUES ('613','140221','阳高县','49','0','0','Yanggao Xian ','YGO');
INSERT INTO `on_region` VALUES ('614','140222','天镇县','49','0','0','Tianzhen Xian ','TZE');
INSERT INTO `on_region` VALUES ('615','140223','广灵县','49','0','0','Guangling Xian ','GLJ');
INSERT INTO `on_region` VALUES ('616','140224','灵丘县','49','0','0','Lingqiu Xian ','LQX');
INSERT INTO `on_region` VALUES ('617','140225','浑源县','49','0','0','Hunyuan Xian','HYM');
INSERT INTO `on_region` VALUES ('618','140226','左云县','49','0','0','Zuoyun Xian','ZUY');
INSERT INTO `on_region` VALUES ('619','140227','大同县','49','0','0','Datong Xian ','DTX');
INSERT INTO `on_region` VALUES ('620','140301','市辖区','50','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('621','140302','城区','50','0','0','Chengqu','CQU');
INSERT INTO `on_region` VALUES ('622','140303','矿区','50','0','0','Kuangqu','KQY');
INSERT INTO `on_region` VALUES ('623','140311','郊区','50','0','0','Jiaoqu','JQY');
INSERT INTO `on_region` VALUES ('624','140321','平定县','50','0','0','Pingding Xian','PDG');
INSERT INTO `on_region` VALUES ('625','140322','盂县','50','0','0','Yu Xian','YUX');
INSERT INTO `on_region` VALUES ('626','140401','市辖区','51','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('627','140402','城区','51','0','0','Chengqu ','CQC');
INSERT INTO `on_region` VALUES ('628','140411','郊区','51','0','0','Jiaoqu','JQZ');
INSERT INTO `on_region` VALUES ('629','140421','长治县','51','0','0','Changzhi Xian','CZI');
INSERT INTO `on_region` VALUES ('630','140423','襄垣县','51','0','0','Xiangyuan Xian','XYJ');
INSERT INTO `on_region` VALUES ('631','140424','屯留县','51','0','0','Tunliu Xian','TNL');
INSERT INTO `on_region` VALUES ('632','140425','平顺县','51','0','0','Pingshun Xian','PSX');
INSERT INTO `on_region` VALUES ('633','140426','黎城县','51','0','0','Licheng Xian','LIC');
INSERT INTO `on_region` VALUES ('634','140427','壶关县','51','0','0','Huguan Xian','HGN');
INSERT INTO `on_region` VALUES ('635','140428','长子县','51','0','0','Zhangzi Xian ','ZHZ');
INSERT INTO `on_region` VALUES ('636','140429','武乡县','51','0','0','Wuxiang Xian','WXG');
INSERT INTO `on_region` VALUES ('637','140430','沁县','51','0','0','Qin Xian','QIN');
INSERT INTO `on_region` VALUES ('638','140431','沁源县','51','0','0','Qinyuan Xian ','QYU');
INSERT INTO `on_region` VALUES ('639','140481','潞城市','51','0','0','Lucheng Shi','LCS');
INSERT INTO `on_region` VALUES ('640','140501','市辖区','52','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('641','140502','城区','52','0','0','Chengqu ','CQJ');
INSERT INTO `on_region` VALUES ('642','140521','沁水县','52','0','0','Qinshui Xian','QSI');
INSERT INTO `on_region` VALUES ('643','140522','阳城县','52','0','0','Yangcheng Xian ','YGC');
INSERT INTO `on_region` VALUES ('644','140524','陵川县','52','0','0','Lingchuan Xian','LGC');
INSERT INTO `on_region` VALUES ('645','140525','泽州县','52','0','0','Zezhou Xian','ZEZ');
INSERT INTO `on_region` VALUES ('646','140581','高平市','52','0','0','Gaoping Shi ','GPG');
INSERT INTO `on_region` VALUES ('647','140601','市辖区','53','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('648','140602','朔城区','53','0','0','Shuocheng Qu','SCH');
INSERT INTO `on_region` VALUES ('649','140603','平鲁区','53','0','0','Pinglu Qu','PLU');
INSERT INTO `on_region` VALUES ('650','140621','山阴县','53','0','0','Shanyin Xian','SYP');
INSERT INTO `on_region` VALUES ('651','140622','应县','53','0','0','Ying Xian','YIG');
INSERT INTO `on_region` VALUES ('652','140623','右玉县','53','0','0','Youyu Xian ','YOY');
INSERT INTO `on_region` VALUES ('653','140624','怀仁县','53','0','0','Huairen Xian','HRN');
INSERT INTO `on_region` VALUES ('654','140701','市辖区','54','0','0','1','2');
INSERT INTO `on_region` VALUES ('655','140702','榆次区','54','0','0','Yuci Qu','2');
INSERT INTO `on_region` VALUES ('656','140721','榆社县','54','0','0','Yushe Xian','2');
INSERT INTO `on_region` VALUES ('657','140722','左权县','54','0','0','Zuoquan Xian','2');
INSERT INTO `on_region` VALUES ('658','140723','和顺县','54','0','0','Heshun Xian','2');
INSERT INTO `on_region` VALUES ('659','140724','昔阳县','54','0','0','Xiyang Xian','2');
INSERT INTO `on_region` VALUES ('660','140725','寿阳县','54','0','0','Shouyang Xian','2');
INSERT INTO `on_region` VALUES ('661','140726','太谷县','54','0','0','Taigu Xian','2');
INSERT INTO `on_region` VALUES ('662','140727','祁县','54','0','0','Qi Xian','2');
INSERT INTO `on_region` VALUES ('663','140728','平遥县','54','0','0','Pingyao Xian','2');
INSERT INTO `on_region` VALUES ('664','140729','灵石县','54','0','0','Lingshi Xian','2');
INSERT INTO `on_region` VALUES ('665','140781','介休市','54','0','0','Jiexiu Shi','2');
INSERT INTO `on_region` VALUES ('666','140801','市辖区','55','0','0','1','2');
INSERT INTO `on_region` VALUES ('667','140802','盐湖区','55','0','0','Yanhu Qu','2');
INSERT INTO `on_region` VALUES ('668','140821','临猗县','55','0','0','Linyi Xian','2');
INSERT INTO `on_region` VALUES ('669','140822','万荣县','55','0','0','Wanrong Xian','2');
INSERT INTO `on_region` VALUES ('670','140823','闻喜县','55','0','0','Wenxi Xian','2');
INSERT INTO `on_region` VALUES ('671','140824','稷山县','55','0','0','Jishan Xian','2');
INSERT INTO `on_region` VALUES ('672','140825','新绛县','55','0','0','Xinjiang Xian','2');
INSERT INTO `on_region` VALUES ('673','140826','绛县','55','0','0','Jiang Xian','2');
INSERT INTO `on_region` VALUES ('674','140827','垣曲县','55','0','0','Yuanqu Xian','2');
INSERT INTO `on_region` VALUES ('675','140828','夏县','55','0','0','Xia Xian ','2');
INSERT INTO `on_region` VALUES ('676','140829','平陆县','55','0','0','Pinglu Xian','2');
INSERT INTO `on_region` VALUES ('677','140830','芮城县','55','0','0','Ruicheng Xian','2');
INSERT INTO `on_region` VALUES ('678','140881','永济市','55','0','0','Yongji Shi ','2');
INSERT INTO `on_region` VALUES ('679','140882','河津市','55','0','0','Hejin Shi','2');
INSERT INTO `on_region` VALUES ('680','140901','市辖区','56','0','0','1','2');
INSERT INTO `on_region` VALUES ('681','140902','忻府区','56','0','0','Xinfu Qu','2');
INSERT INTO `on_region` VALUES ('682','140921','定襄县','56','0','0','Dingxiang Xian','2');
INSERT INTO `on_region` VALUES ('683','140922','五台县','56','0','0','Wutai Xian','2');
INSERT INTO `on_region` VALUES ('684','140923','代县','56','0','0','Dai Xian','2');
INSERT INTO `on_region` VALUES ('685','140924','繁峙县','56','0','0','Fanshi Xian','2');
INSERT INTO `on_region` VALUES ('686','140925','宁武县','56','0','0','Ningwu Xian','2');
INSERT INTO `on_region` VALUES ('687','140926','静乐县','56','0','0','Jingle Xian','2');
INSERT INTO `on_region` VALUES ('688','140927','神池县','56','0','0','Shenchi Xian','2');
INSERT INTO `on_region` VALUES ('689','140928','五寨县','56','0','0','Wuzhai Xian','2');
INSERT INTO `on_region` VALUES ('690','140929','岢岚县','56','0','0','Kelan Xian','2');
INSERT INTO `on_region` VALUES ('691','140930','河曲县','56','0','0','Hequ Xian ','2');
INSERT INTO `on_region` VALUES ('692','140931','保德县','56','0','0','Baode Xian','2');
INSERT INTO `on_region` VALUES ('693','140932','偏关县','56','0','0','Pianguan Xian','2');
INSERT INTO `on_region` VALUES ('694','140981','原平市','56','0','0','Yuanping Shi','2');
INSERT INTO `on_region` VALUES ('695','141001','市辖区','57','0','0','1','2');
INSERT INTO `on_region` VALUES ('696','141002','尧都区','57','0','0','Yaodu Qu','2');
INSERT INTO `on_region` VALUES ('697','141021','曲沃县','57','0','0','Quwo Xian ','2');
INSERT INTO `on_region` VALUES ('698','141022','翼城县','57','0','0','Yicheng Xian','2');
INSERT INTO `on_region` VALUES ('699','141023','襄汾县','57','0','0','Xiangfen Xian','2');
INSERT INTO `on_region` VALUES ('700','141024','洪洞县','57','0','0','Hongtong Xian','2');
INSERT INTO `on_region` VALUES ('701','141025','古县','57','0','0','Gu Xian','2');
INSERT INTO `on_region` VALUES ('702','141026','安泽县','57','0','0','Anze Xian','2');
INSERT INTO `on_region` VALUES ('703','141027','浮山县','57','0','0','Fushan Xian ','2');
INSERT INTO `on_region` VALUES ('704','141028','吉县','57','0','0','Ji Xian','2');
INSERT INTO `on_region` VALUES ('705','141029','乡宁县','57','0','0','Xiangning Xian','2');
INSERT INTO `on_region` VALUES ('706','141030','大宁县','57','0','0','Daning Xian','2');
INSERT INTO `on_region` VALUES ('707','141031','隰县','57','0','0','Xi Xian','2');
INSERT INTO `on_region` VALUES ('708','141032','永和县','57','0','0','Yonghe Xian','2');
INSERT INTO `on_region` VALUES ('709','141033','蒲县','57','0','0','Pu Xian','2');
INSERT INTO `on_region` VALUES ('710','141034','汾西县','57','0','0','Fenxi Xian','2');
INSERT INTO `on_region` VALUES ('711','141081','侯马市','57','0','0','Houma Shi ','2');
INSERT INTO `on_region` VALUES ('712','141082','霍州市','57','0','0','Huozhou Shi ','2');
INSERT INTO `on_region` VALUES ('713','141101','市辖区','58','0','0','1','2');
INSERT INTO `on_region` VALUES ('714','141102','离石区','58','0','0','Lishi Qu','2');
INSERT INTO `on_region` VALUES ('715','141121','文水县','58','0','0','Wenshui Xian','2');
INSERT INTO `on_region` VALUES ('716','141122','交城县','58','0','0','Jiaocheng Xian','2');
INSERT INTO `on_region` VALUES ('717','141123','兴县','58','0','0','Xing Xian','2');
INSERT INTO `on_region` VALUES ('718','141124','临县','58','0','0','Lin Xian ','2');
INSERT INTO `on_region` VALUES ('719','141125','柳林县','58','0','0','Liulin Xian','2');
INSERT INTO `on_region` VALUES ('720','141126','石楼县','58','0','0','Shilou Xian','2');
INSERT INTO `on_region` VALUES ('721','141127','岚县','58','0','0','Lan Xian','2');
INSERT INTO `on_region` VALUES ('722','141128','方山县','58','0','0','Fangshan Xian','2');
INSERT INTO `on_region` VALUES ('723','141129','中阳县','58','0','0','Zhongyang Xian','2');
INSERT INTO `on_region` VALUES ('724','141130','交口县','58','0','0','Jiaokou Xian','2');
INSERT INTO `on_region` VALUES ('725','141181','孝义市','58','0','0','Xiaoyi Shi','2');
INSERT INTO `on_region` VALUES ('726','141182','汾阳市','58','0','0','Fenyang Shi','2');
INSERT INTO `on_region` VALUES ('727','150101','市辖区','59','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('728','150102','新城区','59','0','0','Xincheng Qu','XCN');
INSERT INTO `on_region` VALUES ('729','150103','回民区','59','0','0','Huimin Qu','HMQ');
INSERT INTO `on_region` VALUES ('730','150104','玉泉区','59','0','0','Yuquan Qu','YQN');
INSERT INTO `on_region` VALUES ('731','150105','赛罕区','59','0','0','Saihan Qu','2');
INSERT INTO `on_region` VALUES ('732','150121','土默特左旗','59','0','0','Tumd Zuoqi','TUZ');
INSERT INTO `on_region` VALUES ('733','150122','托克托县','59','0','0','Togtoh Xian','TOG');
INSERT INTO `on_region` VALUES ('734','150123','和林格尔县','59','0','0','Horinger Xian','HOR');
INSERT INTO `on_region` VALUES ('735','150124','清水河县','59','0','0','Qingshuihe Xian','QSH');
INSERT INTO `on_region` VALUES ('736','150125','武川县','59','0','0','Wuchuan Xian','WCX');
INSERT INTO `on_region` VALUES ('737','150201','市辖区','60','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('738','150202','东河区','60','0','0','Donghe Qu','DHE');
INSERT INTO `on_region` VALUES ('739','150203','昆都仑区','60','0','0','Kundulun Qu','2');
INSERT INTO `on_region` VALUES ('740','150204','青山区','60','0','0','Qingshan Qu','QSB');
INSERT INTO `on_region` VALUES ('741','150205','石拐区','60','0','0','Shiguai Qu','2');
INSERT INTO `on_region` VALUES ('742','150206','白云鄂博矿区','60','0','0','Baiyun Kuangqu','2');
INSERT INTO `on_region` VALUES ('743','150207','九原区','60','0','0','Jiuyuan Qu','2');
INSERT INTO `on_region` VALUES ('744','150221','土默特右旗','60','0','0','Tumd Youqi','TUY');
INSERT INTO `on_region` VALUES ('745','150222','固阳县','60','0','0','Guyang Xian','GYM');
INSERT INTO `on_region` VALUES ('746','150223','达尔罕茂明安联合旗','60','0','0','Darhan Muminggan Lianheqi','DML');
INSERT INTO `on_region` VALUES ('747','150301','市辖区','61','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('748','150302','海勃湾区','61','0','0','Haibowan Qu','HBW');
INSERT INTO `on_region` VALUES ('749','150303','海南区','61','0','0','Hainan Qu','HNU');
INSERT INTO `on_region` VALUES ('750','150304','乌达区','61','0','0','Ud Qu','UDQ');
INSERT INTO `on_region` VALUES ('751','150401','市辖区','62','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('752','150402','红山区','62','0','0','Hongshan Qu','HSZ');
INSERT INTO `on_region` VALUES ('753','150403','元宝山区','62','0','0','Yuanbaoshan Qu','YBO');
INSERT INTO `on_region` VALUES ('754','150404','松山区','62','0','0','Songshan Qu','SSQ');
INSERT INTO `on_region` VALUES ('755','150421','阿鲁科尔沁旗','62','0','0','Ar Horqin Qi','AHO');
INSERT INTO `on_region` VALUES ('756','150422','巴林左旗','62','0','0','Bairin Zuoqi','BAZ');
INSERT INTO `on_region` VALUES ('757','150423','巴林右旗','62','0','0','Bairin Youqi','BAY');
INSERT INTO `on_region` VALUES ('758','150424','林西县','62','0','0','Linxi Xian','LXM');
INSERT INTO `on_region` VALUES ('759','150425','克什克腾旗','62','0','0','Hexigten Qi','HXT');
INSERT INTO `on_region` VALUES ('760','150426','翁牛特旗','62','0','0','Ongniud Qi','ONG');
INSERT INTO `on_region` VALUES ('761','150428','喀喇沁旗','62','0','0','Harqin Qi','HAR');
INSERT INTO `on_region` VALUES ('762','150429','宁城县','62','0','0','Ningcheng Xian','NCH');
INSERT INTO `on_region` VALUES ('763','150430','敖汉旗','62','0','0','Aohan Qi','AHN');
INSERT INTO `on_region` VALUES ('764','150501','市辖区','63','0','0','1','2');
INSERT INTO `on_region` VALUES ('765','150502','科尔沁区','63','0','0','Keermi Qu','2');
INSERT INTO `on_region` VALUES ('766','150521','科尔沁左翼中旗','63','0','0','Horqin Zuoyi Zhongqi','2');
INSERT INTO `on_region` VALUES ('767','150522','科尔沁左翼后旗','63','0','0','Horqin Zuoyi Houqi','2');
INSERT INTO `on_region` VALUES ('768','150523','开鲁县','63','0','0','Kailu Xian','2');
INSERT INTO `on_region` VALUES ('769','150524','库伦旗','63','0','0','Hure Qi','2');
INSERT INTO `on_region` VALUES ('770','150525','奈曼旗','63','0','0','Naiman Qi','2');
INSERT INTO `on_region` VALUES ('771','150526','扎鲁特旗','63','0','0','Jarud Qi','2');
INSERT INTO `on_region` VALUES ('772','150581','霍林郭勒市','63','0','0','Holingol Shi','2');
INSERT INTO `on_region` VALUES ('773','150602','东胜区','64','0','0','Dongsheng Qu','2');
INSERT INTO `on_region` VALUES ('774','150621','达拉特旗','64','0','0','Dalad Qi','2');
INSERT INTO `on_region` VALUES ('775','150622','准格尔旗','64','0','0','Jungar Qi','2');
INSERT INTO `on_region` VALUES ('776','150623','鄂托克前旗','64','0','0','Otog Qianqi','2');
INSERT INTO `on_region` VALUES ('777','150624','鄂托克旗','64','0','0','Otog Qi','2');
INSERT INTO `on_region` VALUES ('778','150625','杭锦旗','64','0','0','Hanggin Qi','2');
INSERT INTO `on_region` VALUES ('779','150626','乌审旗','64','0','0','Uxin Qi','2');
INSERT INTO `on_region` VALUES ('780','150627','伊金霍洛旗','64','0','0','Ejin Horo Qi','2');
INSERT INTO `on_region` VALUES ('781','150701','市辖区','65','0','0','1','2');
INSERT INTO `on_region` VALUES ('782','150702','海拉尔区','65','0','0','Hailaer Qu','2');
INSERT INTO `on_region` VALUES ('783','150721','阿荣旗','65','0','0','Arun Qi','2');
INSERT INTO `on_region` VALUES ('784','150722','莫力达瓦达斡尔族自治旗','65','0','0','Morin Dawa Daurzu Zizhiqi','2');
INSERT INTO `on_region` VALUES ('785','150723','鄂伦春自治旗','65','0','0','Oroqen Zizhiqi','2');
INSERT INTO `on_region` VALUES ('786','150724','鄂温克族自治旗','65','0','0','Ewenkizu Zizhiqi','2');
INSERT INTO `on_region` VALUES ('787','150725','陈巴尔虎旗','65','0','0','Chen Barag Qi','2');
INSERT INTO `on_region` VALUES ('788','150726','新巴尔虎左旗','65','0','0','Xin Barag Zuoqi','2');
INSERT INTO `on_region` VALUES ('789','150727','新巴尔虎右旗','65','0','0','Xin Barag Youqi','2');
INSERT INTO `on_region` VALUES ('790','150781','满洲里市','65','0','0','Manzhouli Shi','2');
INSERT INTO `on_region` VALUES ('791','150782','牙克石市','65','0','0','Yakeshi Shi','2');
INSERT INTO `on_region` VALUES ('792','150783','扎兰屯市','65','0','0','Zalantun Shi','2');
INSERT INTO `on_region` VALUES ('793','150784','额尔古纳市','65','0','0','Ergun Shi','2');
INSERT INTO `on_region` VALUES ('794','150785','根河市','65','0','0','Genhe Shi','2');
INSERT INTO `on_region` VALUES ('795','150801','市辖区','66','0','0','1','2');
INSERT INTO `on_region` VALUES ('796','150802','临河区','66','0','0','Linhe Qu','2');
INSERT INTO `on_region` VALUES ('797','150821','五原县','66','0','0','Wuyuan Xian','2');
INSERT INTO `on_region` VALUES ('798','150822','磴口县','66','0','0','Dengkou Xian','2');
INSERT INTO `on_region` VALUES ('799','150823','乌拉特前旗','66','0','0','Urad Qianqi','2');
INSERT INTO `on_region` VALUES ('800','150824','乌拉特中旗','66','0','0','Urad Zhongqi','2');
INSERT INTO `on_region` VALUES ('801','150825','乌拉特后旗','66','0','0','Urad Houqi','2');
INSERT INTO `on_region` VALUES ('802','150826','杭锦后旗','66','0','0','Hanggin Houqi','2');
INSERT INTO `on_region` VALUES ('803','150901','市辖区','67','0','0','1','2');
INSERT INTO `on_region` VALUES ('804','150902','集宁区','67','0','0','Jining Qu','2');
INSERT INTO `on_region` VALUES ('805','150921','卓资县','67','0','0','Zhuozi Xian','2');
INSERT INTO `on_region` VALUES ('806','150922','化德县','67','0','0','Huade Xian','2');
INSERT INTO `on_region` VALUES ('807','150923','商都县','67','0','0','Shangdu Xian','2');
INSERT INTO `on_region` VALUES ('808','150924','兴和县','67','0','0','Xinghe Xian','2');
INSERT INTO `on_region` VALUES ('809','150925','凉城县','67','0','0','Liangcheng Xian','2');
INSERT INTO `on_region` VALUES ('810','150926','察哈尔右翼前旗','67','0','0','Qahar Youyi Qianqi','2');
INSERT INTO `on_region` VALUES ('811','150927','察哈尔右翼中旗','67','0','0','Qahar Youyi Zhongqi','2');
INSERT INTO `on_region` VALUES ('812','150928','察哈尔右翼后旗','67','0','0','Qahar Youyi Houqi','2');
INSERT INTO `on_region` VALUES ('813','150929','四子王旗','67','0','0','Dorbod Qi','2');
INSERT INTO `on_region` VALUES ('814','150981','丰镇市','67','0','0','Fengzhen Shi','2');
INSERT INTO `on_region` VALUES ('815','152201','乌兰浩特市','68','0','0','Ulan Hot Shi','ULO');
INSERT INTO `on_region` VALUES ('816','152202','阿尔山市','68','0','0','Arxan Shi','ARS');
INSERT INTO `on_region` VALUES ('817','152221','科尔沁右翼前旗','68','0','0','Horqin Youyi Qianqi','HYQ');
INSERT INTO `on_region` VALUES ('818','152222','科尔沁右翼中旗','68','0','0','Horqin Youyi Zhongqi','HYZ');
INSERT INTO `on_region` VALUES ('819','152223','扎赉特旗','68','0','0','Jalaid Qi','JAL');
INSERT INTO `on_region` VALUES ('820','152224','突泉县','68','0','0','Tuquan Xian','TUQ');
INSERT INTO `on_region` VALUES ('821','152501','二连浩特市','69','0','0','Erenhot Shi','ERC');
INSERT INTO `on_region` VALUES ('822','152502','锡林浩特市','69','0','0','Xilinhot Shi','XLI');
INSERT INTO `on_region` VALUES ('823','152522','阿巴嘎旗','69','0','0','Abag Qi','ABG');
INSERT INTO `on_region` VALUES ('824','152523','苏尼特左旗','69','0','0','Sonid Zuoqi','SOZ');
INSERT INTO `on_region` VALUES ('825','152524','苏尼特右旗','69','0','0','Sonid Youqi','SOY');
INSERT INTO `on_region` VALUES ('826','152525','东乌珠穆沁旗','69','0','0','Dong Ujimqin Qi','DUJ');
INSERT INTO `on_region` VALUES ('827','152526','西乌珠穆沁旗','69','0','0','Xi Ujimqin Qi','XUJ');
INSERT INTO `on_region` VALUES ('828','152527','太仆寺旗','69','0','0','Taibus Qi','TAB');
INSERT INTO `on_region` VALUES ('829','152528','镶黄旗','69','0','0','Xianghuang(Hobot Xar) Qi','XHG');
INSERT INTO `on_region` VALUES ('830','152529','正镶白旗','69','0','0','Zhengxiangbai(Xulun Hobot Qagan)Qi','ZXB');
INSERT INTO `on_region` VALUES ('831','152530','正蓝旗','69','0','0','Zhenglan(Xulun Hoh)Qi','ZLM');
INSERT INTO `on_region` VALUES ('832','152531','多伦县','69','0','0','Duolun (Dolonnur)Xian','DLM');
INSERT INTO `on_region` VALUES ('833','152921','阿拉善左旗','70','0','0','Alxa Zuoqi','ALZ');
INSERT INTO `on_region` VALUES ('834','152922','阿拉善右旗','70','0','0','Alxa Youqi','ALY');
INSERT INTO `on_region` VALUES ('835','152923','额济纳旗','70','0','0','Ejin Qi','EJI');
INSERT INTO `on_region` VALUES ('836','210101','市辖区','71','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('837','210102','和平区','71','0','0','Heping Qu','HEP');
INSERT INTO `on_region` VALUES ('838','210103','沈河区','71','0','0','Shenhe Qu ','SHQ');
INSERT INTO `on_region` VALUES ('839','210104','大东区','71','0','0','Dadong Qu ','DDQ');
INSERT INTO `on_region` VALUES ('840','210105','皇姑区','71','0','0','Huanggu Qu','HGU');
INSERT INTO `on_region` VALUES ('841','210106','铁西区','71','0','0','Tiexi Qu','TXI');
INSERT INTO `on_region` VALUES ('842','210111','苏家屯区','71','0','0','Sujiatun Qu','SJT');
INSERT INTO `on_region` VALUES ('843','210112','东陵区','71','0','0','Dongling Qu ','DLQ');
INSERT INTO `on_region` VALUES ('844','210113','沈北新区','71','0','0','Xinchengzi Qu','2');
INSERT INTO `on_region` VALUES ('845','210114','于洪区','71','0','0','Yuhong Qu ','YHQ');
INSERT INTO `on_region` VALUES ('846','210122','辽中县','71','0','0','Liaozhong Xian','LZL');
INSERT INTO `on_region` VALUES ('847','210123','康平县','71','0','0','Kangping Xian','KPG');
INSERT INTO `on_region` VALUES ('848','210124','法库县','71','0','0','Faku Xian','FKU');
INSERT INTO `on_region` VALUES ('849','210181','新民市','71','0','0','Xinmin Shi','XMS');
INSERT INTO `on_region` VALUES ('850','210201','市辖区','72','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('851','210202','中山区','72','0','0','Zhongshan Qu','ZSD');
INSERT INTO `on_region` VALUES ('852','210203','西岗区','72','0','0','Xigang Qu','XGD');
INSERT INTO `on_region` VALUES ('853','210204','沙河口区','72','0','0','Shahekou Qu','SHK');
INSERT INTO `on_region` VALUES ('854','210211','甘井子区','72','0','0','Ganjingzi Qu','GJZ');
INSERT INTO `on_region` VALUES ('855','210212','旅顺口区','72','0','0','Lvshunkou Qu ','LSK');
INSERT INTO `on_region` VALUES ('856','210213','金州区','72','0','0','Jinzhou Qu','JZH');
INSERT INTO `on_region` VALUES ('857','210224','长海县','72','0','0','Changhai Xian','CHX');
INSERT INTO `on_region` VALUES ('858','210281','瓦房店市','72','0','0','Wafangdian Shi','WFD');
INSERT INTO `on_region` VALUES ('859','210282','普兰店市','72','0','0','Pulandian Shi','PLD');
INSERT INTO `on_region` VALUES ('860','210283','庄河市','72','0','0','Zhuanghe Shi','ZHH');
INSERT INTO `on_region` VALUES ('861','210301','市辖区','73','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('862','210302','铁东区','73','0','0','Tiedong Qu ','TED');
INSERT INTO `on_region` VALUES ('863','210303','铁西区','73','0','0','Tiexi Qu','TXL');
INSERT INTO `on_region` VALUES ('864','210304','立山区','73','0','0','Lishan Qu','LAS');
INSERT INTO `on_region` VALUES ('865','210311','千山区','73','0','0','Qianshan Qu ','QSQ');
INSERT INTO `on_region` VALUES ('866','210321','台安县','73','0','0','Tai,an Xian','TAX');
INSERT INTO `on_region` VALUES ('867','210323','岫岩满族自治县','73','0','0','Xiuyan Manzu Zizhixian','XYL');
INSERT INTO `on_region` VALUES ('868','210381','海城市','73','0','0','Haicheng Shi','HCL');
INSERT INTO `on_region` VALUES ('869','210401','市辖区','74','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('870','210402','新抚区','74','0','0','Xinfu Qu','XFU');
INSERT INTO `on_region` VALUES ('871','210403','东洲区','74','0','0','Dongzhou Qu','2');
INSERT INTO `on_region` VALUES ('872','210404','望花区','74','0','0','Wanghua Qu','WHF');
INSERT INTO `on_region` VALUES ('873','210411','顺城区','74','0','0','Shuncheng Qu','SCF');
INSERT INTO `on_region` VALUES ('874','210421','抚顺县','74','0','0','Fushun Xian','FSX');
INSERT INTO `on_region` VALUES ('875','210422','新宾满族自治县','74','0','0','Xinbinmanzuzizhi Xian','2');
INSERT INTO `on_region` VALUES ('876','210423','清原满族自治县','74','0','0','Qingyuanmanzuzizhi Xian','2');
INSERT INTO `on_region` VALUES ('877','210501','市辖区','75','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('878','210502','平山区','75','0','0','Pingshan Qu','PSN');
INSERT INTO `on_region` VALUES ('879','210503','溪湖区','75','0','0','Xihu Qu ','XHB');
INSERT INTO `on_region` VALUES ('880','210504','明山区','75','0','0','Mingshan Qu','MSB');
INSERT INTO `on_region` VALUES ('881','210505','南芬区','75','0','0','Nanfen Qu','NFQ');
INSERT INTO `on_region` VALUES ('882','210521','本溪满族自治县','75','0','0','Benxi Manzu Zizhixian','BXX');
INSERT INTO `on_region` VALUES ('883','210522','桓仁满族自治县','75','0','0','Huanren Manzu Zizhixian','HRL');
INSERT INTO `on_region` VALUES ('884','210601','市辖区','76','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('885','210602','元宝区','76','0','0','Yuanbao Qu','YBD');
INSERT INTO `on_region` VALUES ('886','210603','振兴区','76','0','0','Zhenxing Qu ','ZXQ');
INSERT INTO `on_region` VALUES ('887','210604','振安区','76','0','0','Zhen,an Qu','ZAQ');
INSERT INTO `on_region` VALUES ('888','210624','宽甸满族自治县','76','0','0','Kuandian Manzu Zizhixian','KDN');
INSERT INTO `on_region` VALUES ('889','210681','东港市','76','0','0','Donggang Shi','DGS');
INSERT INTO `on_region` VALUES ('890','210682','凤城市','76','0','0','Fengcheng Shi','FCL');
INSERT INTO `on_region` VALUES ('891','210701','市辖区','77','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('892','210702','古塔区','77','0','0','Guta Qu','GTQ');
INSERT INTO `on_region` VALUES ('893','210703','凌河区','77','0','0','Linghe Qu','LHF');
INSERT INTO `on_region` VALUES ('894','210711','太和区','77','0','0','Taihe Qu','2');
INSERT INTO `on_region` VALUES ('895','210726','黑山县','77','0','0','Heishan Xian','HSL');
INSERT INTO `on_region` VALUES ('896','210727','义县','77','0','0','Yi Xian','YXL');
INSERT INTO `on_region` VALUES ('897','210781','凌海市','77','0','0','Linghai Shi ','LHL');
INSERT INTO `on_region` VALUES ('898','210782','北镇市','77','0','0','Beining Shi','2');
INSERT INTO `on_region` VALUES ('899','210801','市辖区','78','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('900','210802','站前区','78','0','0','Zhanqian Qu','ZQQ');
INSERT INTO `on_region` VALUES ('901','210803','西市区','78','0','0','Xishi Qu','XII');
INSERT INTO `on_region` VALUES ('902','210804','鲅鱼圈区','78','0','0','Bayuquan Qu','BYQ');
INSERT INTO `on_region` VALUES ('903','210811','老边区','78','0','0','Laobian Qu','LOB');
INSERT INTO `on_region` VALUES ('904','210881','盖州市','78','0','0','Gaizhou Shi','GZU');
INSERT INTO `on_region` VALUES ('905','210882','大石桥市','78','0','0','Dashiqiao Shi','DSQ');
INSERT INTO `on_region` VALUES ('906','210901','市辖区','79','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('907','210902','海州区','79','0','0','Haizhou Qu','HZF');
INSERT INTO `on_region` VALUES ('908','210903','新邱区','79','0','0','Xinqiu Qu','XQF');
INSERT INTO `on_region` VALUES ('909','210904','太平区','79','0','0','Taiping Qu','TPG');
INSERT INTO `on_region` VALUES ('910','210905','清河门区','79','0','0','Qinghemen Qu','QHM');
INSERT INTO `on_region` VALUES ('911','210911','细河区','79','0','0','Xihe Qu','XHO');
INSERT INTO `on_region` VALUES ('912','210921','阜新蒙古族自治县','79','0','0','Fuxin Mongolzu Zizhixian','FXX');
INSERT INTO `on_region` VALUES ('913','210922','彰武县','79','0','0','Zhangwu Xian','ZWU');
INSERT INTO `on_region` VALUES ('914','211001','市辖区','80','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('915','211002','白塔区','80','0','0','Baita Qu','BTL');
INSERT INTO `on_region` VALUES ('916','211003','文圣区','80','0','0','Wensheng Qu','WST');
INSERT INTO `on_region` VALUES ('917','211004','宏伟区','80','0','0','Hongwei Qu','HWQ');
INSERT INTO `on_region` VALUES ('918','211005','弓长岭区','80','0','0','Gongchangling Qu','GCL');
INSERT INTO `on_region` VALUES ('919','211011','太子河区','80','0','0','Taizihe Qu','TZH');
INSERT INTO `on_region` VALUES ('920','211021','辽阳县','80','0','0','Liaoyang Xian','LYX');
INSERT INTO `on_region` VALUES ('921','211081','灯塔市','80','0','0','Dengta Shi','DTL');
INSERT INTO `on_region` VALUES ('922','211101','市辖区','81','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('923','211102','双台子区','81','0','0','Shuangtaizi Qu','STZ');
INSERT INTO `on_region` VALUES ('924','211103','兴隆台区','81','0','0','Xinglongtai Qu','XLT');
INSERT INTO `on_region` VALUES ('925','211121','大洼县','81','0','0','Dawa Xian','DWA');
INSERT INTO `on_region` VALUES ('926','211122','盘山县','81','0','0','Panshan Xian','PNS');
INSERT INTO `on_region` VALUES ('927','211201','市辖区','82','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('928','211202','银州区','82','0','0','Yinzhou Qu','YZU');
INSERT INTO `on_region` VALUES ('929','211204','清河区','82','0','0','Qinghe Qu','QHQ');
INSERT INTO `on_region` VALUES ('930','211221','铁岭县','82','0','0','Tieling Xian','TLG');
INSERT INTO `on_region` VALUES ('931','211223','西丰县','82','0','0','Xifeng Xian','XIF');
INSERT INTO `on_region` VALUES ('932','211224','昌图县','82','0','0','Changtu Xian','CTX');
INSERT INTO `on_region` VALUES ('933','211281','调兵山市','82','0','0','Diaobingshan Shi','2');
INSERT INTO `on_region` VALUES ('934','211282','开原市','82','0','0','Kaiyuan Shi','KYS');
INSERT INTO `on_region` VALUES ('935','211301','市辖区','83','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('936','211302','双塔区','83','0','0','Shuangta Qu','STQ');
INSERT INTO `on_region` VALUES ('937','211303','龙城区','83','0','0','Longcheng Qu','LCL');
INSERT INTO `on_region` VALUES ('938','211321','朝阳县','83','0','0','Chaoyang Xian','CYG');
INSERT INTO `on_region` VALUES ('939','211322','建平县','83','0','0','Jianping Xian','JPG');
INSERT INTO `on_region` VALUES ('940','211324','喀喇沁左翼蒙古族自治县','83','0','0','Harqin Zuoyi Mongolzu Zizhixian','HAZ');
INSERT INTO `on_region` VALUES ('941','211381','北票市','83','0','0','Beipiao Shi','BPO');
INSERT INTO `on_region` VALUES ('942','211382','凌源市','83','0','0','Lingyuan Shi','LYK');
INSERT INTO `on_region` VALUES ('943','211401','市辖区','84','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('944','211402','连山区','84','0','0','Lianshan Qu','LSQ');
INSERT INTO `on_region` VALUES ('945','211403','龙港区','84','0','0','Longgang Qu','LGD');
INSERT INTO `on_region` VALUES ('946','211404','南票区','84','0','0','Nanpiao Qu','NPQ');
INSERT INTO `on_region` VALUES ('947','211421','绥中县','84','0','0','Suizhong Xian','SZL');
INSERT INTO `on_region` VALUES ('948','211422','建昌县','84','0','0','Jianchang Xian','JCL');
INSERT INTO `on_region` VALUES ('949','211481','兴城市','84','0','0','Xingcheng Shi','XCL');
INSERT INTO `on_region` VALUES ('950','220101','市辖区','85','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('951','220102','南关区','85','0','0','Nanguan Qu','NGN');
INSERT INTO `on_region` VALUES ('952','220103','宽城区','85','0','0','Kuancheng Qu','KCQ');
INSERT INTO `on_region` VALUES ('953','220104','朝阳区','85','0','0','Chaoyang Qu ','CYC');
INSERT INTO `on_region` VALUES ('954','220105','二道区','85','0','0','Erdao Qu','EDQ');
INSERT INTO `on_region` VALUES ('955','220106','绿园区','85','0','0','Lvyuan Qu','LYQ');
INSERT INTO `on_region` VALUES ('956','220112','双阳区','85','0','0','Shuangyang Qu','SYQ');
INSERT INTO `on_region` VALUES ('957','220122','农安县','85','0','0','Nong,an Xian ','NAJ');
INSERT INTO `on_region` VALUES ('958','220181','九台市','85','0','0','Jiutai Shi','2');
INSERT INTO `on_region` VALUES ('959','220182','榆树市','85','0','0','Yushu Shi','YSS');
INSERT INTO `on_region` VALUES ('960','220183','德惠市','85','0','0','Dehui Shi','DEH');
INSERT INTO `on_region` VALUES ('961','220201','市辖区','86','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('962','220202','昌邑区','86','0','0','Changyi Qu','CYI');
INSERT INTO `on_region` VALUES ('963','220203','龙潭区','86','0','0','Longtan Qu','LTQ');
INSERT INTO `on_region` VALUES ('964','220204','船营区','86','0','0','Chuanying Qu','CYJ');
INSERT INTO `on_region` VALUES ('965','220211','丰满区','86','0','0','Fengman Qu','FMQ');
INSERT INTO `on_region` VALUES ('966','220221','永吉县','86','0','0','Yongji Xian','YOJ');
INSERT INTO `on_region` VALUES ('967','220281','蛟河市','86','0','0','Jiaohe Shi','JHJ');
INSERT INTO `on_region` VALUES ('968','220282','桦甸市','86','0','0','Huadian Shi','HDJ');
INSERT INTO `on_region` VALUES ('969','220283','舒兰市','86','0','0','Shulan Shi','SLN');
INSERT INTO `on_region` VALUES ('970','220284','磐石市','86','0','0','Panshi Shi','PSI');
INSERT INTO `on_region` VALUES ('971','220301','市辖区','87','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('972','220302','铁西区','87','0','0','Tiexi Qu','TXS');
INSERT INTO `on_region` VALUES ('973','220303','铁东区','87','0','0','Tiedong Qu ','TDQ');
INSERT INTO `on_region` VALUES ('974','220322','梨树县','87','0','0','Lishu Xian','LSU');
INSERT INTO `on_region` VALUES ('975','220323','伊通满族自治县','87','0','0','Yitong Manzu Zizhixian','YTO');
INSERT INTO `on_region` VALUES ('976','220381','公主岭市','87','0','0','Gongzhuling Shi','GZL');
INSERT INTO `on_region` VALUES ('977','220382','双辽市','87','0','0','Shuangliao Shi','SLS');
INSERT INTO `on_region` VALUES ('978','220401','市辖区','88','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('979','220402','龙山区','88','0','0','Longshan Qu','LGS');
INSERT INTO `on_region` VALUES ('980','220403','西安区','88','0','0','Xi,an Qu','XAA');
INSERT INTO `on_region` VALUES ('981','220421','东丰县','88','0','0','Dongfeng Xian','DGF');
INSERT INTO `on_region` VALUES ('982','220422','东辽县','88','0','0','Dongliao Xian ','DLX');
INSERT INTO `on_region` VALUES ('983','220501','市辖区','89','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('984','220502','东昌区','89','0','0','Dongchang Qu','DCT');
INSERT INTO `on_region` VALUES ('985','220503','二道江区','89','0','0','Erdaojiang Qu','EDJ');
INSERT INTO `on_region` VALUES ('986','220521','通化县','89','0','0','Tonghua Xian ','THX');
INSERT INTO `on_region` VALUES ('987','220523','辉南县','89','0','0','Huinan Xian ','HNA');
INSERT INTO `on_region` VALUES ('988','220524','柳河县','89','0','0','Liuhe Xian ','LHC');
INSERT INTO `on_region` VALUES ('989','220581','梅河口市','89','0','0','Meihekou Shi','MHK');
INSERT INTO `on_region` VALUES ('990','220582','集安市','89','0','0','Ji,an Shi','KNC');
INSERT INTO `on_region` VALUES ('991','220601','市辖区','90','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('992','220602','八道江区','90','0','0','Badaojiang Qu','BDJ');
INSERT INTO `on_region` VALUES ('993','220621','抚松县','90','0','0','Fusong Xian','FSG');
INSERT INTO `on_region` VALUES ('994','220622','靖宇县','90','0','0','Jingyu Xian','JYJ');
INSERT INTO `on_region` VALUES ('995','220623','长白朝鲜族自治县','90','0','0','Changbaichaoxianzuzizhi Xian','2');
INSERT INTO `on_region` VALUES ('996','220605','江源区','90','0','0','Jiangyuan Xian','2');
INSERT INTO `on_region` VALUES ('997','220681','临江市','90','0','0','Linjiang Shi','LIN');
INSERT INTO `on_region` VALUES ('998','220701','市辖区','91','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('999','220702','宁江区','91','0','0','Ningjiang Qu','NJA');
INSERT INTO `on_region` VALUES ('1000','220721','前郭尔罗斯蒙古族自治县','91','0','0','Qian Gorlos Mongolzu Zizhixian','QGO');
INSERT INTO `on_region` VALUES ('1001','220722','长岭县','91','0','0','Changling Xian','CLG');
INSERT INTO `on_region` VALUES ('1002','220723','乾安县','91','0','0','Qian,an Xian','QAJ');
INSERT INTO `on_region` VALUES ('1003','220724','扶余县','91','0','0','Fuyu Xian','FYU');
INSERT INTO `on_region` VALUES ('1004','220801','市辖区','92','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1005','220802','洮北区','92','0','0','Taobei Qu','TBQ');
INSERT INTO `on_region` VALUES ('1006','220821','镇赉县','92','0','0','Zhenlai Xian','ZLA');
INSERT INTO `on_region` VALUES ('1007','220822','通榆县','92','0','0','Tongyu Xian','TGY');
INSERT INTO `on_region` VALUES ('1008','220881','洮南市','92','0','0','Taonan Shi','TNS');
INSERT INTO `on_region` VALUES ('1009','220882','大安市','92','0','0','Da,an Shi','DNA');
INSERT INTO `on_region` VALUES ('1010','222401','延吉市','93','0','0','Yanji Shi','YNJ');
INSERT INTO `on_region` VALUES ('1011','222402','图们市','93','0','0','Tumen Shi','TME');
INSERT INTO `on_region` VALUES ('1012','222403','敦化市','93','0','0','Dunhua Shi','DHS');
INSERT INTO `on_region` VALUES ('1013','222404','珲春市','93','0','0','Hunchun Shi','HUC');
INSERT INTO `on_region` VALUES ('1014','222405','龙井市','93','0','0','Longjing Shi','LJJ');
INSERT INTO `on_region` VALUES ('1015','222406','和龙市','93','0','0','Helong Shi','HEL');
INSERT INTO `on_region` VALUES ('1016','222424','汪清县','93','0','0','Wangqing Xian','WGQ');
INSERT INTO `on_region` VALUES ('1017','222426','安图县','93','0','0','Antu Xian','ATU');
INSERT INTO `on_region` VALUES ('1018','230101','市辖区','94','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1019','230102','道里区','94','0','0','Daoli Qu','DLH');
INSERT INTO `on_region` VALUES ('1020','230103','南岗区','94','0','0','Nangang Qu','NGQ');
INSERT INTO `on_region` VALUES ('1021','230104','道外区','94','0','0','Daowai Qu','DWQ');
INSERT INTO `on_region` VALUES ('1022','230110','香坊区','94','0','0','Xiangfang Qu','2');
INSERT INTO `on_region` VALUES ('1024','230108','平房区','94','0','0','Pingfang Qu','PFQ');
INSERT INTO `on_region` VALUES ('1025','230109','松北区','94','0','0','Songbei Qu','2');
INSERT INTO `on_region` VALUES ('1026','230111','呼兰区','94','0','0','Hulan Qu','2');
INSERT INTO `on_region` VALUES ('1027','230123','依兰县','94','0','0','Yilan Xian','YLH');
INSERT INTO `on_region` VALUES ('1028','230124','方正县','94','0','0','Fangzheng Xian','FZH');
INSERT INTO `on_region` VALUES ('1029','230125','宾县','94','0','0','Bin Xian','BNX');
INSERT INTO `on_region` VALUES ('1030','230126','巴彦县','94','0','0','Bayan Xian','BYH');
INSERT INTO `on_region` VALUES ('1031','230127','木兰县','94','0','0','Mulan Xian ','MUL');
INSERT INTO `on_region` VALUES ('1032','230128','通河县','94','0','0','Tonghe Xian','TOH');
INSERT INTO `on_region` VALUES ('1033','230129','延寿县','94','0','0','Yanshou Xian','YSU');
INSERT INTO `on_region` VALUES ('1034','230112','阿城区','94','0','0','Acheng Shi','2');
INSERT INTO `on_region` VALUES ('1035','230182','双城市','94','0','0','Shuangcheng Shi','SCS');
INSERT INTO `on_region` VALUES ('1036','230183','尚志市','94','0','0','Shangzhi Shi','SZI');
INSERT INTO `on_region` VALUES ('1037','230184','五常市','94','0','0','Wuchang Shi','WCA');
INSERT INTO `on_region` VALUES ('1038','230201','市辖区','95','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1039','230202','龙沙区','95','0','0','Longsha Qu','LQQ');
INSERT INTO `on_region` VALUES ('1040','230203','建华区','95','0','0','Jianhua Qu','JHQ');
INSERT INTO `on_region` VALUES ('1041','230204','铁锋区','95','0','0','Tiefeng Qu','2');
INSERT INTO `on_region` VALUES ('1042','230205','昂昂溪区','95','0','0','Ang,angxi Qu','AAX');
INSERT INTO `on_region` VALUES ('1043','230206','富拉尔基区','95','0','0','Hulan Ergi Qu','HUE');
INSERT INTO `on_region` VALUES ('1044','230207','碾子山区','95','0','0','Nianzishan Qu','NZS');
INSERT INTO `on_region` VALUES ('1045','230208','梅里斯达斡尔族区','95','0','0','Meilisidawoerzu Qu','2');
INSERT INTO `on_region` VALUES ('1046','230221','龙江县','95','0','0','Longjiang Xian','LGJ');
INSERT INTO `on_region` VALUES ('1047','230223','依安县','95','0','0','Yi,an Xian','YAN');
INSERT INTO `on_region` VALUES ('1048','230224','泰来县','95','0','0','Tailai Xian','TLA');
INSERT INTO `on_region` VALUES ('1049','230225','甘南县','95','0','0','Gannan Xian','GNX');
INSERT INTO `on_region` VALUES ('1050','230227','富裕县','95','0','0','Fuyu Xian','FYX');
INSERT INTO `on_region` VALUES ('1051','230229','克山县','95','0','0','Keshan Xian','KSN');
INSERT INTO `on_region` VALUES ('1052','230230','克东县','95','0','0','Kedong Xian','KDO');
INSERT INTO `on_region` VALUES ('1053','230231','拜泉县','95','0','0','Baiquan Xian','BQN');
INSERT INTO `on_region` VALUES ('1054','230281','讷河市','95','0','0','Nehe Shi','NEH');
INSERT INTO `on_region` VALUES ('1055','230301','市辖区','96','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1056','230302','鸡冠区','96','0','0','Jiguan Qu','JGU');
INSERT INTO `on_region` VALUES ('1057','230303','恒山区','96','0','0','Hengshan Qu','HSD');
INSERT INTO `on_region` VALUES ('1058','230304','滴道区','96','0','0','Didao Qu','DDO');
INSERT INTO `on_region` VALUES ('1059','230305','梨树区','96','0','0','Lishu Qu','LJX');
INSERT INTO `on_region` VALUES ('1060','230306','城子河区','96','0','0','Chengzihe Qu','CZH');
INSERT INTO `on_region` VALUES ('1061','230307','麻山区','96','0','0','Mashan Qu','MSN');
INSERT INTO `on_region` VALUES ('1062','230321','鸡东县','96','0','0','Jidong Xian','JID');
INSERT INTO `on_region` VALUES ('1063','230381','虎林市','96','0','0','Hulin Shi','HUL');
INSERT INTO `on_region` VALUES ('1064','230382','密山市','96','0','0','Mishan Shi','MIS');
INSERT INTO `on_region` VALUES ('1065','230401','市辖区','97','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1066','230402','向阳区','97','0','0','Xiangyang  Qu ','XYZ');
INSERT INTO `on_region` VALUES ('1067','230403','工农区','97','0','0','Gongnong Qu','GNH');
INSERT INTO `on_region` VALUES ('1068','230404','南山区','97','0','0','Nanshan Qu','NSQ');
INSERT INTO `on_region` VALUES ('1069','230405','兴安区','97','0','0','Xing,an Qu','XAH');
INSERT INTO `on_region` VALUES ('1070','230406','东山区','97','0','0','Dongshan Qu','DSA');
INSERT INTO `on_region` VALUES ('1071','230407','兴山区','97','0','0','Xingshan Qu','XSQ');
INSERT INTO `on_region` VALUES ('1072','230421','萝北县','97','0','0','Luobei Xian','LUB');
INSERT INTO `on_region` VALUES ('1073','230422','绥滨县','97','0','0','Suibin Xian','2');
INSERT INTO `on_region` VALUES ('1074','230501','市辖区','98','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1075','230502','尖山区','98','0','0','Jianshan Qu','JSQ');
INSERT INTO `on_region` VALUES ('1076','230503','岭东区','98','0','0','Lingdong Qu','LDQ');
INSERT INTO `on_region` VALUES ('1077','230505','四方台区','98','0','0','Sifangtai Qu','SFT');
INSERT INTO `on_region` VALUES ('1078','230506','宝山区','98','0','0','Baoshan Qu','BSQ');
INSERT INTO `on_region` VALUES ('1079','230521','集贤县','98','0','0','Jixian Xian','JXH');
INSERT INTO `on_region` VALUES ('1080','230522','友谊县','98','0','0','Youyi Xian','YYI');
INSERT INTO `on_region` VALUES ('1081','230523','宝清县','98','0','0','Baoqing Xian','BQG');
INSERT INTO `on_region` VALUES ('1082','230524','饶河县','98','0','0','Raohe Xian ','ROH');
INSERT INTO `on_region` VALUES ('1083','230601','市辖区','99','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1084','230602','萨尔图区','99','0','0','Sairt Qu','SAI');
INSERT INTO `on_region` VALUES ('1085','230603','龙凤区','99','0','0','Longfeng Qu','LFQ');
INSERT INTO `on_region` VALUES ('1086','230604','让胡路区','99','0','0','Ranghulu Qu','RHL');
INSERT INTO `on_region` VALUES ('1087','230605','红岗区','99','0','0','Honggang Qu','HGD');
INSERT INTO `on_region` VALUES ('1088','230606','大同区','99','0','0','Datong Qu','DHD');
INSERT INTO `on_region` VALUES ('1089','230621','肇州县','99','0','0','Zhaozhou Xian','ZAZ');
INSERT INTO `on_region` VALUES ('1090','230622','肇源县','99','0','0','Zhaoyuan Xian','ZYH');
INSERT INTO `on_region` VALUES ('1091','230623','林甸县','99','0','0','Lindian Xian ','LDN');
INSERT INTO `on_region` VALUES ('1092','230624','杜尔伯特蒙古族自治县','99','0','0','Dorbod Mongolzu Zizhixian','DOM');
INSERT INTO `on_region` VALUES ('1093','230701','市辖区','100','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1094','230702','伊春区','100','0','0','Yichun Qu','YYC');
INSERT INTO `on_region` VALUES ('1095','230703','南岔区','100','0','0','Nancha Qu','NCQ');
INSERT INTO `on_region` VALUES ('1096','230704','友好区','100','0','0','Youhao Qu','YOH');
INSERT INTO `on_region` VALUES ('1097','230705','西林区','100','0','0','Xilin Qu','XIL');
INSERT INTO `on_region` VALUES ('1098','230706','翠峦区','100','0','0','Cuiluan Qu','CLN');
INSERT INTO `on_region` VALUES ('1099','230707','新青区','100','0','0','Xinqing Qu','XQQ');
INSERT INTO `on_region` VALUES ('1100','230708','美溪区','100','0','0','Meixi Qu','MXQ');
INSERT INTO `on_region` VALUES ('1101','230709','金山屯区','100','0','0','Jinshantun Qu','JST');
INSERT INTO `on_region` VALUES ('1102','230710','五营区','100','0','0','Wuying Qu','WYQ');
INSERT INTO `on_region` VALUES ('1103','230711','乌马河区','100','0','0','Wumahe Qu','WMH');
INSERT INTO `on_region` VALUES ('1104','230712','汤旺河区','100','0','0','Tangwanghe Qu','TWH');
INSERT INTO `on_region` VALUES ('1105','230713','带岭区','100','0','0','Dailing Qu','DLY');
INSERT INTO `on_region` VALUES ('1106','230714','乌伊岭区','100','0','0','Wuyiling Qu','WYL');
INSERT INTO `on_region` VALUES ('1107','230715','红星区','100','0','0','Hongxing Qu','HGX');
INSERT INTO `on_region` VALUES ('1108','230716','上甘岭区','100','0','0','Shangganling Qu','SGL');
INSERT INTO `on_region` VALUES ('1109','230722','嘉荫县','100','0','0','Jiayin Xian','2');
INSERT INTO `on_region` VALUES ('1110','230781','铁力市','100','0','0','Tieli Shi','TEL');
INSERT INTO `on_region` VALUES ('1111','230801','市辖区','101','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1113','230803','向阳区','101','0','0','Xiangyang  Qu ','XYQ');
INSERT INTO `on_region` VALUES ('1114','230804','前进区','101','0','0','Qianjin Qu','QJQ');
INSERT INTO `on_region` VALUES ('1115','230805','东风区','101','0','0','Dongfeng Qu','DFQ');
INSERT INTO `on_region` VALUES ('1116','230811','郊区','101','0','0','Jiaoqu','JQJ');
INSERT INTO `on_region` VALUES ('1117','230822','桦南县','101','0','0','Huanan Xian','HNH');
INSERT INTO `on_region` VALUES ('1118','230826','桦川县','101','0','0','Huachuan Xian','HCN');
INSERT INTO `on_region` VALUES ('1119','230828','汤原县','101','0','0','Tangyuan Xian','TYX');
INSERT INTO `on_region` VALUES ('1120','230833','抚远县','101','0','0','Fuyuan Xian','FUY');
INSERT INTO `on_region` VALUES ('1121','230881','同江市','101','0','0','Tongjiang Shi','TOJ');
INSERT INTO `on_region` VALUES ('1122','230882','富锦市','101','0','0','Fujin Shi','FUJ');
INSERT INTO `on_region` VALUES ('1123','230901','市辖区','102','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1124','230902','新兴区','102','0','0','Xinxing Qu','XXQ');
INSERT INTO `on_region` VALUES ('1125','230903','桃山区','102','0','0','Taoshan Qu','TSC');
INSERT INTO `on_region` VALUES ('1126','230904','茄子河区','102','0','0','Qiezihe Qu','QZI');
INSERT INTO `on_region` VALUES ('1127','230921','勃利县','102','0','0','Boli Xian','BLI');
INSERT INTO `on_region` VALUES ('1128','231001','市辖区','103','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1129','231002','东安区','103','0','0','Dong,an Qu','DGA');
INSERT INTO `on_region` VALUES ('1130','231003','阳明区','103','0','0','Yangming Qu','YMQ');
INSERT INTO `on_region` VALUES ('1131','231004','爱民区','103','0','0','Aimin Qu','AMQ');
INSERT INTO `on_region` VALUES ('1132','231005','西安区','103','0','0','Xi,an Qu','XAQ');
INSERT INTO `on_region` VALUES ('1133','231024','东宁县','103','0','0','Dongning Xian','DON');
INSERT INTO `on_region` VALUES ('1134','231025','林口县','103','0','0','Linkou Xian','LKO');
INSERT INTO `on_region` VALUES ('1135','231081','绥芬河市','103','0','0','Suifenhe Shi','SFE');
INSERT INTO `on_region` VALUES ('1136','231083','海林市','103','0','0','Hailin Shi','HLS');
INSERT INTO `on_region` VALUES ('1137','231084','宁安市','103','0','0','Ning,an Shi','NAI');
INSERT INTO `on_region` VALUES ('1138','231085','穆棱市','103','0','0','Muling Shi','MLG');
INSERT INTO `on_region` VALUES ('1139','231101','市辖区','104','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1140','231102','爱辉区','104','0','0','Aihui Qu','AHQ');
INSERT INTO `on_region` VALUES ('1141','231121','嫩江县','104','0','0','Nenjiang Xian','NJH');
INSERT INTO `on_region` VALUES ('1142','231123','逊克县','104','0','0','Xunke Xian','XUK');
INSERT INTO `on_region` VALUES ('1143','231124','孙吴县','104','0','0','Sunwu Xian','SUW');
INSERT INTO `on_region` VALUES ('1144','231181','北安市','104','0','0','Bei,an Shi','BAS');
INSERT INTO `on_region` VALUES ('1145','231182','五大连池市','104','0','0','Wudalianchi Shi','WDL');
INSERT INTO `on_region` VALUES ('1146','231201','市辖区','105','0','0','1','2');
INSERT INTO `on_region` VALUES ('1147','231202','北林区','105','0','0','Beilin Qu','2');
INSERT INTO `on_region` VALUES ('1148','231221','望奎县','105','0','0','Wangkui Xian','2');
INSERT INTO `on_region` VALUES ('1149','231222','兰西县','105','0','0','Lanxi Xian','2');
INSERT INTO `on_region` VALUES ('1150','231223','青冈县','105','0','0','Qinggang Xian','2');
INSERT INTO `on_region` VALUES ('1151','231224','庆安县','105','0','0','Qing,an Xian','2');
INSERT INTO `on_region` VALUES ('1152','231225','明水县','105','0','0','Mingshui Xian','2');
INSERT INTO `on_region` VALUES ('1153','231226','绥棱县','105','0','0','Suileng Xian','2');
INSERT INTO `on_region` VALUES ('1154','231281','安达市','105','0','0','Anda Shi','2');
INSERT INTO `on_region` VALUES ('1155','231282','肇东市','105','0','0','Zhaodong Shi','2');
INSERT INTO `on_region` VALUES ('1156','231283','海伦市','105','0','0','Hailun Shi','2');
INSERT INTO `on_region` VALUES ('1157','232721','呼玛县','106','0','0','Huma Xian','HUM');
INSERT INTO `on_region` VALUES ('1158','232722','塔河县','106','0','0','Tahe Xian','TAH');
INSERT INTO `on_region` VALUES ('1159','232723','漠河县','106','0','0','Mohe Xian','MOH');
INSERT INTO `on_region` VALUES ('1160','310101','黄浦区','107','0','0','Huangpu Qu','HGP');
INSERT INTO `on_region` VALUES ('1161','310103','卢湾区','107','0','0','Luwan Qu','LWN');
INSERT INTO `on_region` VALUES ('1162','310104','徐汇区','107','0','0','Xuhui Qu','XHI');
INSERT INTO `on_region` VALUES ('1163','310105','长宁区','107','0','0','Changning Qu','CNQ');
INSERT INTO `on_region` VALUES ('1164','310106','静安区','107','0','0','Jing,an Qu','JAQ');
INSERT INTO `on_region` VALUES ('1165','310107','普陀区','107','0','0','Putuo Qu','PTQ');
INSERT INTO `on_region` VALUES ('1166','310108','闸北区','107','0','0','Zhabei Qu','ZBE');
INSERT INTO `on_region` VALUES ('1167','310109','虹口区','107','0','0','Hongkou Qu','HKQ');
INSERT INTO `on_region` VALUES ('1168','310110','杨浦区','107','0','0','Yangpu Qu','YPU');
INSERT INTO `on_region` VALUES ('1169','310112','闵行区','107','0','0','Minhang Qu','MHQ');
INSERT INTO `on_region` VALUES ('1170','310113','宝山区','107','0','0','Baoshan Qu','BAO');
INSERT INTO `on_region` VALUES ('1171','310114','嘉定区','107','0','0','Jiading Qu','JDG');
INSERT INTO `on_region` VALUES ('1172','310115','浦东新区','107','0','0','Pudong Xinqu','PDX');
INSERT INTO `on_region` VALUES ('1173','310116','金山区','107','0','0','Jinshan Qu','JSH');
INSERT INTO `on_region` VALUES ('1174','310117','松江区','107','0','0','Songjiang Qu','SOJ');
INSERT INTO `on_region` VALUES ('1175','310118','青浦区','107','0','0','Qingpu  Qu','QPU');
INSERT INTO `on_region` VALUES ('1177','310120','奉贤区','107','0','0','Fengxian Qu','FXI');
INSERT INTO `on_region` VALUES ('1178','310230','崇明县','108','0','0','Chongming Xian','CMI');
INSERT INTO `on_region` VALUES ('1179','320101','市辖区','109','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1180','320102','玄武区','109','0','0','Xuanwu Qu','XWU');
INSERT INTO `on_region` VALUES ('1181','320103','白下区','109','0','0','Baixia Qu','BXQ');
INSERT INTO `on_region` VALUES ('1182','320104','秦淮区','109','0','0','Qinhuai Qu','QHU');
INSERT INTO `on_region` VALUES ('1183','320105','建邺区','109','0','0','Jianye Qu','JYQ');
INSERT INTO `on_region` VALUES ('1184','320106','鼓楼区','109','0','0','Gulou Qu','GLQ');
INSERT INTO `on_region` VALUES ('1185','320107','下关区','109','0','0','Xiaguan Qu','XGQ');
INSERT INTO `on_region` VALUES ('1186','320111','浦口区','109','0','0','Pukou Qu','PKO');
INSERT INTO `on_region` VALUES ('1187','320113','栖霞区','109','0','0','Qixia Qu','QAX');
INSERT INTO `on_region` VALUES ('1188','320114','雨花台区','109','0','0','Yuhuatai Qu','YHT');
INSERT INTO `on_region` VALUES ('1189','320115','江宁区','109','0','0','Jiangning Qu','2');
INSERT INTO `on_region` VALUES ('1190','320116','六合区','109','0','0','Liuhe Qu','2');
INSERT INTO `on_region` VALUES ('1191','320124','溧水县','109','0','0','Lishui Xian','LIS');
INSERT INTO `on_region` VALUES ('1192','320125','高淳县','109','0','0','Gaochun Xian','GCN');
INSERT INTO `on_region` VALUES ('1193','320201','市辖区','110','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1194','320202','崇安区','110','0','0','Chong,an Qu','CGA');
INSERT INTO `on_region` VALUES ('1195','320203','南长区','110','0','0','Nanchang Qu','NCG');
INSERT INTO `on_region` VALUES ('1196','320204','北塘区','110','0','0','Beitang Qu','BTQ');
INSERT INTO `on_region` VALUES ('1197','320205','锡山区','110','0','0','Xishan Qu','2');
INSERT INTO `on_region` VALUES ('1198','320206','惠山区','110','0','0','Huishan Qu','2');
INSERT INTO `on_region` VALUES ('1199','320211','滨湖区','110','0','0','Binhu Qu','2');
INSERT INTO `on_region` VALUES ('1200','320281','江阴市','110','0','0','Jiangyin Shi','JIA');
INSERT INTO `on_region` VALUES ('1201','320282','宜兴市','110','0','0','Yixing Shi','YIX');
INSERT INTO `on_region` VALUES ('1202','320301','市辖区','111','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1203','320302','鼓楼区','111','0','0','Gulou Qu','GLU');
INSERT INTO `on_region` VALUES ('1204','320303','云龙区','111','0','0','Yunlong Qu','YLF');
INSERT INTO `on_region` VALUES ('1206','320305','贾汪区','111','0','0','Jiawang Qu','JWQ');
INSERT INTO `on_region` VALUES ('1207','320311','泉山区','111','0','0','Quanshan Qu','QSX');
INSERT INTO `on_region` VALUES ('1208','320321','丰县','111','0','0','Feng Xian','FXN');
INSERT INTO `on_region` VALUES ('1209','320322','沛县','111','0','0','Pei Xian','PEI');
INSERT INTO `on_region` VALUES ('1210','320312','铜山区','111','0','0','Tongshan Xian','2');
INSERT INTO `on_region` VALUES ('1211','320324','睢宁县','111','0','0','Suining Xian','SNI');
INSERT INTO `on_region` VALUES ('1212','320381','新沂市','111','0','0','Xinyi Shi','XYW');
INSERT INTO `on_region` VALUES ('1213','320382','邳州市','111','0','0','Pizhou Shi','PZO');
INSERT INTO `on_region` VALUES ('1214','320401','市辖区','112','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1215','320402','天宁区','112','0','0','Tianning Qu','TNQ');
INSERT INTO `on_region` VALUES ('1216','320404','钟楼区','112','0','0','Zhonglou Qu','ZLQ');
INSERT INTO `on_region` VALUES ('1217','320405','戚墅堰区','112','0','0','Qishuyan Qu','QSY');
INSERT INTO `on_region` VALUES ('1218','320411','新北区','112','0','0','Xinbei Qu','2');
INSERT INTO `on_region` VALUES ('1219','320412','武进区','112','0','0','Wujin Qu','2');
INSERT INTO `on_region` VALUES ('1220','320481','溧阳市','112','0','0','Liyang Shi','LYR');
INSERT INTO `on_region` VALUES ('1221','320482','金坛市','112','0','0','Jintan Shi','JTS');
INSERT INTO `on_region` VALUES ('1222','320501','市辖区','113','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1223','320502','沧浪区','113','0','0','Canglang Qu','CLQ');
INSERT INTO `on_region` VALUES ('1224','320503','平江区','113','0','0','Pingjiang Qu','PJQ');
INSERT INTO `on_region` VALUES ('1225','320504','金阊区','113','0','0','Jinchang Qu','JCA');
INSERT INTO `on_region` VALUES ('1226','320505','虎丘区','113','0','0','Huqiu Qu','2');
INSERT INTO `on_region` VALUES ('1227','320506','吴中区','113','0','0','Wuzhong Qu','2');
INSERT INTO `on_region` VALUES ('1228','320507','相城区','113','0','0','Xiangcheng Qu','2');
INSERT INTO `on_region` VALUES ('1229','320581','常熟市','113','0','0','Changshu Shi','CGS');
INSERT INTO `on_region` VALUES ('1230','320582','张家港市','113','0','0','Zhangjiagang Shi ','ZJG');
INSERT INTO `on_region` VALUES ('1231','320583','昆山市','113','0','0','Kunshan Shi','KUS');
INSERT INTO `on_region` VALUES ('1232','320584','吴江市','113','0','0','Wujiang Shi','WUJ');
INSERT INTO `on_region` VALUES ('1233','320585','太仓市','113','0','0','Taicang Shi','TAC');
INSERT INTO `on_region` VALUES ('1234','320601','市辖区','114','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1235','320602','崇川区','114','0','0','Chongchuan Qu','CCQ');
INSERT INTO `on_region` VALUES ('1236','320611','港闸区','114','0','0','Gangzha Qu','GZQ');
INSERT INTO `on_region` VALUES ('1237','320621','海安县','114','0','0','Hai,an Xian','HIA');
INSERT INTO `on_region` VALUES ('1238','320623','如东县','114','0','0','Rudong Xian','RDG');
INSERT INTO `on_region` VALUES ('1239','320681','启东市','114','0','0','Qidong Shi','QID');
INSERT INTO `on_region` VALUES ('1240','320682','如皋市','114','0','0','Rugao Shi','RGO');
INSERT INTO `on_region` VALUES ('1241','320612','通州区','114','0','0','Tongzhou Shi','2');
INSERT INTO `on_region` VALUES ('1242','320684','海门市','114','0','0','Haimen Shi','HME');
INSERT INTO `on_region` VALUES ('1243','320701','市辖区','115','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1244','320703','连云区','115','0','0','Lianyun Qu','LYB');
INSERT INTO `on_region` VALUES ('1245','320705','新浦区','115','0','0','Xinpu Qu','XPQ');
INSERT INTO `on_region` VALUES ('1246','320706','海州区','115','0','0','Haizhou Qu','HIZ');
INSERT INTO `on_region` VALUES ('1247','320721','赣榆县','115','0','0','Ganyu Xian','GYU');
INSERT INTO `on_region` VALUES ('1248','320722','东海县','115','0','0','Donghai Xian','DHX');
INSERT INTO `on_region` VALUES ('1249','320723','灌云县','115','0','0','Guanyun Xian','GYS');
INSERT INTO `on_region` VALUES ('1250','320724','灌南县','115','0','0','Guannan Xian','GUN');
INSERT INTO `on_region` VALUES ('1251','320801','市辖区','116','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1252','320802','清河区','116','0','0','Qinghe Qu','QHH');
INSERT INTO `on_region` VALUES ('1253','320803','楚州区','116','0','0','Chuzhou Qu','2');
INSERT INTO `on_region` VALUES ('1254','320804','淮阴区','116','0','0','Huaiyin Qu','2');
INSERT INTO `on_region` VALUES ('1255','320811','清浦区','116','0','0','Qingpu Qu','QPQ');
INSERT INTO `on_region` VALUES ('1256','320826','涟水县','116','0','0','Lianshui Xian','LSI');
INSERT INTO `on_region` VALUES ('1257','320829','洪泽县','116','0','0','Hongze Xian','HGZ');
INSERT INTO `on_region` VALUES ('1258','320830','盱眙县','116','0','0','Xuyi Xian','XUY');
INSERT INTO `on_region` VALUES ('1259','320831','金湖县','116','0','0','Jinhu Xian','JHU');
INSERT INTO `on_region` VALUES ('1260','320901','市辖区','117','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1261','320902','亭湖区','117','0','0','Tinghu Qu','2');
INSERT INTO `on_region` VALUES ('1262','320903','盐都区','117','0','0','Yandu Qu','2');
INSERT INTO `on_region` VALUES ('1263','320921','响水县','117','0','0','Xiangshui Xian','XSH');
INSERT INTO `on_region` VALUES ('1264','320922','滨海县','117','0','0','Binhai Xian','BHI');
INSERT INTO `on_region` VALUES ('1265','320923','阜宁县','117','0','0','Funing Xian','FNG');
INSERT INTO `on_region` VALUES ('1266','320924','射阳县','117','0','0','Sheyang Xian','SEY');
INSERT INTO `on_region` VALUES ('1267','320925','建湖县','117','0','0','Jianhu Xian','JIH');
INSERT INTO `on_region` VALUES ('1268','320981','东台市','117','0','0','Dongtai Shi','DTS');
INSERT INTO `on_region` VALUES ('1269','320982','大丰市','117','0','0','Dafeng Shi','DFS');
INSERT INTO `on_region` VALUES ('1270','321001','市辖区','118','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1271','321002','广陵区','118','0','0','Guangling Qu','GGL');
INSERT INTO `on_region` VALUES ('1272','321003','邗江区','118','0','0','Hanjiang Qu','2');
INSERT INTO `on_region` VALUES ('1273','321011','维扬区','118','0','0','Weiyang Qu','2');
INSERT INTO `on_region` VALUES ('1274','321023','宝应县','118','0','0','Baoying Xian ','BYI');
INSERT INTO `on_region` VALUES ('1275','321081','仪征市','118','0','0','Yizheng Shi','YZE');
INSERT INTO `on_region` VALUES ('1276','321084','高邮市','118','0','0','Gaoyou Shi','GYO');
INSERT INTO `on_region` VALUES ('1277','321088','江都市','118','0','0','Jiangdu Shi','JDU');
INSERT INTO `on_region` VALUES ('1278','321101','市辖区','119','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1279','321102','京口区','119','0','0','Jingkou Qu','2');
INSERT INTO `on_region` VALUES ('1280','321111','润州区','119','0','0','Runzhou Qu','RZQ');
INSERT INTO `on_region` VALUES ('1281','321112','丹徒区','119','0','0','Dantu Qu','2');
INSERT INTO `on_region` VALUES ('1282','321181','丹阳市','119','0','0','Danyang Xian','DNY');
INSERT INTO `on_region` VALUES ('1283','321182','扬中市','119','0','0','Yangzhong Shi','YZG');
INSERT INTO `on_region` VALUES ('1284','321183','句容市','119','0','0','Jurong Shi','JRG');
INSERT INTO `on_region` VALUES ('1285','321201','市辖区','120','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1286','321202','海陵区','120','0','0','Hailing Qu','HIL');
INSERT INTO `on_region` VALUES ('1287','321203','高港区','120','0','0','Gaogang Qu','GGQ');
INSERT INTO `on_region` VALUES ('1288','321281','兴化市','120','0','0','Xinghua Shi','XHS');
INSERT INTO `on_region` VALUES ('1289','321282','靖江市','120','0','0','Jingjiang Shi','JGJ');
INSERT INTO `on_region` VALUES ('1290','321283','泰兴市','120','0','0','Taixing Shi','TXG');
INSERT INTO `on_region` VALUES ('1291','321284','姜堰市','120','0','0','Jiangyan Shi','JYS');
INSERT INTO `on_region` VALUES ('1292','321301','市辖区','121','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1293','321302','宿城区','121','0','0','Sucheng Qu','SCE');
INSERT INTO `on_region` VALUES ('1294','321311','宿豫区','121','0','0','Suyu Qu','2');
INSERT INTO `on_region` VALUES ('1295','321322','沭阳县','121','0','0','Shuyang Xian','SYD');
INSERT INTO `on_region` VALUES ('1296','321323','泗阳县','121','0','0','Siyang Xian ','SIY');
INSERT INTO `on_region` VALUES ('1297','321324','泗洪县','121','0','0','Sihong Xian','SIH');
INSERT INTO `on_region` VALUES ('1298','330101','市辖区','122','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1299','330102','上城区','122','0','0','Shangcheng Qu','SCQ');
INSERT INTO `on_region` VALUES ('1300','330103','下城区','122','0','0','Xiacheng Qu','XCG');
INSERT INTO `on_region` VALUES ('1301','330104','江干区','122','0','0','Jianggan Qu','JGQ');
INSERT INTO `on_region` VALUES ('1302','330105','拱墅区','122','0','0','Gongshu Qu','GSQ');
INSERT INTO `on_region` VALUES ('1303','330106','西湖区','122','0','0','Xihu Qu ','XHU');
INSERT INTO `on_region` VALUES ('1304','330108','滨江区','122','0','0','Binjiang Qu','BJQ');
INSERT INTO `on_region` VALUES ('1305','330109','萧山区','122','0','0','Xiaoshan Qu','2');
INSERT INTO `on_region` VALUES ('1306','330110','余杭区','122','0','0','Yuhang Qu','2');
INSERT INTO `on_region` VALUES ('1307','330122','桐庐县','122','0','0','Tonglu Xian','TLU');
INSERT INTO `on_region` VALUES ('1308','330127','淳安县','122','0','0','Chun,an Xian','CAZ');
INSERT INTO `on_region` VALUES ('1309','330182','建德市','122','0','0','Jiande Shi','JDS');
INSERT INTO `on_region` VALUES ('1310','330183','富阳市','122','0','0','Fuyang Shi','FYZ');
INSERT INTO `on_region` VALUES ('1311','330185','临安市','122','0','0','Lin,an Shi','LNA');
INSERT INTO `on_region` VALUES ('1312','330201','市辖区','123','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1313','330203','海曙区','123','0','0','Haishu Qu','HNB');
INSERT INTO `on_region` VALUES ('1314','330204','江东区','123','0','0','Jiangdong Qu','JDO');
INSERT INTO `on_region` VALUES ('1315','330205','江北区','123','0','0','Jiangbei Qu','JBQ');
INSERT INTO `on_region` VALUES ('1316','330206','北仑区','123','0','0','Beilun Qu','BLN');
INSERT INTO `on_region` VALUES ('1317','330211','镇海区','123','0','0','Zhenhai Qu','ZHF');
INSERT INTO `on_region` VALUES ('1318','330212','鄞州区','123','0','0','Yinzhou Qu','2');
INSERT INTO `on_region` VALUES ('1319','330225','象山县','123','0','0','Xiangshan Xian','YSZ');
INSERT INTO `on_region` VALUES ('1320','330226','宁海县','123','0','0','Ninghai Xian','NHI');
INSERT INTO `on_region` VALUES ('1321','330281','余姚市','123','0','0','Yuyao Shi','YYO');
INSERT INTO `on_region` VALUES ('1322','330282','慈溪市','123','0','0','Cixi Shi','CXI');
INSERT INTO `on_region` VALUES ('1323','330283','奉化市','123','0','0','Fenghua Shi','FHU');
INSERT INTO `on_region` VALUES ('1324','330301','市辖区','124','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1325','330302','鹿城区','124','0','0','Lucheng Qu','LUW');
INSERT INTO `on_region` VALUES ('1326','330303','龙湾区','124','0','0','Longwan Qu','LWW');
INSERT INTO `on_region` VALUES ('1327','330304','瓯海区','124','0','0','Ouhai Qu','OHQ');
INSERT INTO `on_region` VALUES ('1328','330322','洞头县','124','0','0','Dongtou Xian','DTO');
INSERT INTO `on_region` VALUES ('1329','330324','永嘉县','124','0','0','Yongjia Xian','YJX');
INSERT INTO `on_region` VALUES ('1330','330326','平阳县','124','0','0','Pingyang Xian','PYG');
INSERT INTO `on_region` VALUES ('1331','330327','苍南县','124','0','0','Cangnan Xian','CAN');
INSERT INTO `on_region` VALUES ('1332','330328','文成县','124','0','0','Wencheng Xian','WCZ');
INSERT INTO `on_region` VALUES ('1333','330329','泰顺县','124','0','0','Taishun Xian','TSZ');
INSERT INTO `on_region` VALUES ('1334','330381','瑞安市','124','0','0','Rui,an Xian','RAS');
INSERT INTO `on_region` VALUES ('1335','330382','乐清市','124','0','0','Yueqing Shi','YQZ');
INSERT INTO `on_region` VALUES ('1336','330401','市辖区','125','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1338','330411','秀洲区','125','0','0','Xiuzhou Qu','2');
INSERT INTO `on_region` VALUES ('1339','330421','嘉善县','125','0','0','Jiashan Xian','JSK');
INSERT INTO `on_region` VALUES ('1340','330424','海盐县','125','0','0','Haiyan Xian','HYN');
INSERT INTO `on_region` VALUES ('1341','330481','海宁市','125','0','0','Haining Shi','HNG');
INSERT INTO `on_region` VALUES ('1342','330482','平湖市','125','0','0','Pinghu Shi','PHU');
INSERT INTO `on_region` VALUES ('1343','330483','桐乡市','125','0','0','Tongxiang Shi','TXZ');
INSERT INTO `on_region` VALUES ('1344','330501','市辖区','126','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1345','330502','吴兴区','126','0','0','Wuxing Qu','2');
INSERT INTO `on_region` VALUES ('1346','330503','南浔区','126','0','0','Nanxun Qu','2');
INSERT INTO `on_region` VALUES ('1347','330521','德清县','126','0','0','Deqing Xian','DQX');
INSERT INTO `on_region` VALUES ('1348','330522','长兴县','126','0','0','Changxing Xian','CXG');
INSERT INTO `on_region` VALUES ('1349','330523','安吉县','126','0','0','Anji Xian','AJI');
INSERT INTO `on_region` VALUES ('1350','330601','市辖区','127','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1351','330602','越城区','127','0','0','Yuecheng Qu','YSX');
INSERT INTO `on_region` VALUES ('1352','330621','绍兴县','127','0','0','Shaoxing Xian','SXZ');
INSERT INTO `on_region` VALUES ('1353','330624','新昌县','127','0','0','Xinchang Xian','XCX');
INSERT INTO `on_region` VALUES ('1354','330681','诸暨市','127','0','0','Zhuji Shi','ZHJ');
INSERT INTO `on_region` VALUES ('1355','330682','上虞市','127','0','0','Shangyu Shi','SYZ');
INSERT INTO `on_region` VALUES ('1356','330683','嵊州市','127','0','0','Shengzhou Shi','SGZ');
INSERT INTO `on_region` VALUES ('1357','330701','市辖区','128','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1358','330702','婺城区','128','0','0','Wucheng Qu','WCF');
INSERT INTO `on_region` VALUES ('1359','330703','金东区','128','0','0','Jindong Qu','2');
INSERT INTO `on_region` VALUES ('1360','330723','武义县','128','0','0','Wuyi Xian','WYX');
INSERT INTO `on_region` VALUES ('1361','330726','浦江县','128','0','0','Pujiang Xian ','PJG');
INSERT INTO `on_region` VALUES ('1362','330727','磐安县','128','0','0','Pan,an Xian','PAX');
INSERT INTO `on_region` VALUES ('1363','330781','兰溪市','128','0','0','Lanxi Shi','LXZ');
INSERT INTO `on_region` VALUES ('1364','330782','义乌市','128','0','0','Yiwu Shi','YWS');
INSERT INTO `on_region` VALUES ('1365','330783','东阳市','128','0','0','Dongyang Shi','DGY');
INSERT INTO `on_region` VALUES ('1366','330784','永康市','128','0','0','Yongkang Shi','YKG');
INSERT INTO `on_region` VALUES ('1367','330801','市辖区','129','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1368','330802','柯城区','129','0','0','Kecheng Qu','KEC');
INSERT INTO `on_region` VALUES ('1369','330803','衢江区','129','0','0','Qujiang Qu','2');
INSERT INTO `on_region` VALUES ('1370','330822','常山县','129','0','0','Changshan Xian','CSN');
INSERT INTO `on_region` VALUES ('1371','330824','开化县','129','0','0','Kaihua Xian','KHU');
INSERT INTO `on_region` VALUES ('1372','330825','龙游县','129','0','0','Longyou Xian ','LGY');
INSERT INTO `on_region` VALUES ('1373','330881','江山市','129','0','0','Jiangshan Shi','JIS');
INSERT INTO `on_region` VALUES ('1374','330901','市辖区','130','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1375','330902','定海区','130','0','0','Dinghai Qu','DHQ');
INSERT INTO `on_region` VALUES ('1376','330903','普陀区','130','0','0','Putuo Qu','PTO');
INSERT INTO `on_region` VALUES ('1377','330921','岱山县','130','0','0','Daishan Xian','DSH');
INSERT INTO `on_region` VALUES ('1378','330922','嵊泗县','130','0','0','Shengsi Xian','SSZ');
INSERT INTO `on_region` VALUES ('1379','331001','市辖区','131','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1380','331002','椒江区','131','0','0','Jiaojiang Qu','JJT');
INSERT INTO `on_region` VALUES ('1381','331003','黄岩区','131','0','0','Huangyan Qu','HYT');
INSERT INTO `on_region` VALUES ('1382','331004','路桥区','131','0','0','Luqiao Qu','LQT');
INSERT INTO `on_region` VALUES ('1383','331021','玉环县','131','0','0','Yuhuan Xian','YHN');
INSERT INTO `on_region` VALUES ('1384','331022','三门县','131','0','0','Sanmen Xian','SMN');
INSERT INTO `on_region` VALUES ('1385','331023','天台县','131','0','0','Tiantai Xian','TTA');
INSERT INTO `on_region` VALUES ('1386','331024','仙居县','131','0','0','Xianju Xian','XJU');
INSERT INTO `on_region` VALUES ('1387','331081','温岭市','131','0','0','Wenling Shi','WLS');
INSERT INTO `on_region` VALUES ('1388','331082','临海市','131','0','0','Linhai Shi','LHI');
INSERT INTO `on_region` VALUES ('1389','331101','市辖区','132','0','0','1','2');
INSERT INTO `on_region` VALUES ('1390','331102','莲都区','132','0','0','Liandu Qu','2');
INSERT INTO `on_region` VALUES ('1391','331121','青田县','132','0','0','Qingtian Xian','2');
INSERT INTO `on_region` VALUES ('1392','331122','缙云县','132','0','0','Jinyun Xian','2');
INSERT INTO `on_region` VALUES ('1393','331123','遂昌县','132','0','0','Suichang Xian','2');
INSERT INTO `on_region` VALUES ('1394','331124','松阳县','132','0','0','Songyang Xian','2');
INSERT INTO `on_region` VALUES ('1395','331125','云和县','132','0','0','Yunhe Xian','2');
INSERT INTO `on_region` VALUES ('1396','331126','庆元县','132','0','0','Qingyuan Xian','2');
INSERT INTO `on_region` VALUES ('1397','331127','景宁畲族自治县','132','0','0','Jingning Shezu Zizhixian','2');
INSERT INTO `on_region` VALUES ('1398','331181','龙泉市','132','0','0','Longquan Shi','2');
INSERT INTO `on_region` VALUES ('1399','340101','市辖区','133','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1400','340102','瑶海区','133','0','0','Yaohai Qu','2');
INSERT INTO `on_region` VALUES ('1401','340103','庐阳区','133','0','0','Luyang Qu','2');
INSERT INTO `on_region` VALUES ('1402','340104','蜀山区','133','0','0','Shushan Qu','2');
INSERT INTO `on_region` VALUES ('1403','340111','包河区','133','0','0','Baohe Qu','2');
INSERT INTO `on_region` VALUES ('1404','340121','长丰县','133','0','0','Changfeng Xian','CFG');
INSERT INTO `on_region` VALUES ('1405','340122','肥东县','133','0','0','Feidong Xian','FDO');
INSERT INTO `on_region` VALUES ('1406','340123','肥西县','133','0','0','Feixi Xian','FIX');
INSERT INTO `on_region` VALUES ('1407','340201','市辖区','1412','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1408','340202','镜湖区','1412','0','0','Jinghu Qu','JHW');
INSERT INTO `on_region` VALUES ('1409','340208','三山区','1412','0','0','Matang Qu','2');
INSERT INTO `on_region` VALUES ('1410','340203','弋江区','1412','0','0','Xinwu Qu','2');
INSERT INTO `on_region` VALUES ('1411','340207','鸠江区','1412','0','0','Jiujiang Qu','JJW');
INSERT INTO `on_region` VALUES ('1412','340200','芜湖市','134','0','0','Wuhu Shi','WHI');
INSERT INTO `on_region` VALUES ('1413','340222','繁昌县','1412','0','0','Fanchang Xian','FCH');
INSERT INTO `on_region` VALUES ('1414','340223','南陵县','1412','0','0','Nanling Xian','NLX');
INSERT INTO `on_region` VALUES ('1415','340301','市辖区','135','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1416','340302','龙子湖区','135','0','0','Longzihu Qu','2');
INSERT INTO `on_region` VALUES ('1417','340303','蚌山区','135','0','0','Bangshan Qu','2');
INSERT INTO `on_region` VALUES ('1418','340304','禹会区','135','0','0','Yuhui Qu','2');
INSERT INTO `on_region` VALUES ('1419','340311','淮上区','135','0','0','Huaishang Qu','2');
INSERT INTO `on_region` VALUES ('1420','340321','怀远县','135','0','0','Huaiyuan Qu','HYW');
INSERT INTO `on_region` VALUES ('1421','340322','五河县','135','0','0','Wuhe Xian','WHE');
INSERT INTO `on_region` VALUES ('1422','340323','固镇县','135','0','0','Guzhen Xian','GZX');
INSERT INTO `on_region` VALUES ('1423','340401','市辖区','136','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1424','340402','大通区','136','0','0','Datong Qu','DTQ');
INSERT INTO `on_region` VALUES ('1425','340403','田家庵区','136','0','0','Tianjia,an Qu','TJA');
INSERT INTO `on_region` VALUES ('1426','340404','谢家集区','136','0','0','Xiejiaji Qu','XJJ');
INSERT INTO `on_region` VALUES ('1427','340405','八公山区','136','0','0','Bagongshan Qu','BGS');
INSERT INTO `on_region` VALUES ('1428','340406','潘集区','136','0','0','Panji Qu','PJI');
INSERT INTO `on_region` VALUES ('1429','340421','凤台县','136','0','0','Fengtai Xian','2');
INSERT INTO `on_region` VALUES ('1430','340501','市辖区','137','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1431','340502','金家庄区','137','0','0','Jinjiazhuang Qu','JJZ');
INSERT INTO `on_region` VALUES ('1432','340503','花山区','137','0','0','Huashan Qu','HSM');
INSERT INTO `on_region` VALUES ('1433','340504','雨山区','137','0','0','Yushan Qu','YSQ');
INSERT INTO `on_region` VALUES ('1434','340521','当涂县','137','0','0','Dangtu Xian','DTU');
INSERT INTO `on_region` VALUES ('1435','340601','市辖区','138','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1436','340602','杜集区','138','0','0','Duji Qu','DJQ');
INSERT INTO `on_region` VALUES ('1437','340603','相山区','138','0','0','Xiangshan Qu','XSA');
INSERT INTO `on_region` VALUES ('1438','340604','烈山区','138','0','0','Lieshan Qu','LHB');
INSERT INTO `on_region` VALUES ('1439','340621','濉溪县','138','0','0','Suixi Xian','SXW');
INSERT INTO `on_region` VALUES ('1440','340701','市辖区','139','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1441','340702','铜官山区','139','0','0','Tongguanshan Qu','TGQ');
INSERT INTO `on_region` VALUES ('1442','340703','狮子山区','139','0','0','Shizishan Qu','SZN');
INSERT INTO `on_region` VALUES ('1443','340711','郊区','139','0','0','Jiaoqu','JTL');
INSERT INTO `on_region` VALUES ('1444','340721','铜陵县','139','0','0','Tongling Xian','TLX');
INSERT INTO `on_region` VALUES ('1445','340801','市辖区','140','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1446','340802','迎江区','140','0','0','Yingjiang Qu','YJQ');
INSERT INTO `on_region` VALUES ('1447','340803','大观区','140','0','0','Daguan Qu','DGQ');
INSERT INTO `on_region` VALUES ('1448','340811','宜秀区','140','0','0','Yixiu Qu','2');
INSERT INTO `on_region` VALUES ('1449','340822','怀宁县','140','0','0','Huaining Xian','HNW');
INSERT INTO `on_region` VALUES ('1450','340823','枞阳县','140','0','0','Zongyang Xian','ZYW');
INSERT INTO `on_region` VALUES ('1451','340824','潜山县','140','0','0','Qianshan Xian','QSW');
INSERT INTO `on_region` VALUES ('1452','340825','太湖县','140','0','0','Taihu Xian','THU');
INSERT INTO `on_region` VALUES ('1453','340826','宿松县','140','0','0','Susong Xian','SUS');
INSERT INTO `on_region` VALUES ('1454','340827','望江县','140','0','0','Wangjiang Xian','WJX');
INSERT INTO `on_region` VALUES ('1455','340828','岳西县','140','0','0','Yuexi Xian','YXW');
INSERT INTO `on_region` VALUES ('1456','340881','桐城市','140','0','0','Tongcheng Shi','TCW');
INSERT INTO `on_region` VALUES ('1457','341001','市辖区','141','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1458','341002','屯溪区','141','0','0','Tunxi Qu','TXN');
INSERT INTO `on_region` VALUES ('1459','341003','黄山区','141','0','0','Huangshan Qu','HSK');
INSERT INTO `on_region` VALUES ('1460','341004','徽州区','141','0','0','Huizhou Qu','HZQ');
INSERT INTO `on_region` VALUES ('1461','341021','歙县','141','0','0','She Xian','SEX');
INSERT INTO `on_region` VALUES ('1462','341022','休宁县','141','0','0','Xiuning Xian','XUN');
INSERT INTO `on_region` VALUES ('1463','341023','黟县','141','0','0','Yi Xian','YIW');
INSERT INTO `on_region` VALUES ('1464','341024','祁门县','141','0','0','Qimen Xian','QMN');
INSERT INTO `on_region` VALUES ('1465','341101','市辖区','142','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1466','341102','琅琊区','142','0','0','Langya Qu','LYU');
INSERT INTO `on_region` VALUES ('1467','341103','南谯区','142','0','0','Nanqiao Qu','NQQ');
INSERT INTO `on_region` VALUES ('1468','341122','来安县','142','0','0','Lai,an Xian','LAX');
INSERT INTO `on_region` VALUES ('1469','341124','全椒县','142','0','0','Quanjiao Xian','QJO');
INSERT INTO `on_region` VALUES ('1470','341125','定远县','142','0','0','Dingyuan Xian','DYW');
INSERT INTO `on_region` VALUES ('1471','341126','凤阳县','142','0','0','Fengyang Xian','FYG');
INSERT INTO `on_region` VALUES ('1472','341181','天长市','142','0','0','Tianchang Shi','TNC');
INSERT INTO `on_region` VALUES ('1473','341182','明光市','142','0','0','Mingguang Shi','MGG');
INSERT INTO `on_region` VALUES ('1474','341201','市辖区','143','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1475','341202','颍州区','143','0','0','Yingzhou Qu','2');
INSERT INTO `on_region` VALUES ('1476','341203','颍东区','143','0','0','Yingdong Qu','2');
INSERT INTO `on_region` VALUES ('1477','341204','颍泉区','143','0','0','Yingquan Qu','2');
INSERT INTO `on_region` VALUES ('1478','341221','临泉县','143','0','0','Linquan Xian','LQN');
INSERT INTO `on_region` VALUES ('1479','341222','太和县','143','0','0','Taihe Xian','TIH');
INSERT INTO `on_region` VALUES ('1480','341225','阜南县','143','0','0','Funan Xian','FNX');
INSERT INTO `on_region` VALUES ('1481','341226','颍上县','143','0','0','Yingshang Xian','2');
INSERT INTO `on_region` VALUES ('1482','341282','界首市','143','0','0','Jieshou Shi','JSW');
INSERT INTO `on_region` VALUES ('1483','341301','市辖区','144','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1484','341302','埇桥区','144','0','0','Yongqiao Qu','2');
INSERT INTO `on_region` VALUES ('1485','341321','砀山县','144','0','0','Dangshan Xian','DSW');
INSERT INTO `on_region` VALUES ('1486','341322','萧县','144','0','0','Xiao Xian','XIO');
INSERT INTO `on_region` VALUES ('1487','341323','灵璧县','144','0','0','Lingbi Xian','LBI');
INSERT INTO `on_region` VALUES ('1488','341324','泗县','144','0','0','Si Xian ','SIX');
INSERT INTO `on_region` VALUES ('1489','341401','市辖区','145','0','0','1','2');
INSERT INTO `on_region` VALUES ('1490','341402','居巢区','145','0','0','Juchao Qu','2');
INSERT INTO `on_region` VALUES ('1491','341421','庐江县','145','0','0','Lujiang Xian','2');
INSERT INTO `on_region` VALUES ('1492','341422','无为县','145','0','0','Wuwei Xian','2');
INSERT INTO `on_region` VALUES ('1493','341423','含山县','145','0','0','Hanshan Xian','2');
INSERT INTO `on_region` VALUES ('1494','341424','和县','145','0','0','He Xian ','2');
INSERT INTO `on_region` VALUES ('1495','341501','市辖区','146','0','0','1','2');
INSERT INTO `on_region` VALUES ('1496','341502','金安区','146','0','0','Jinan Qu','2');
INSERT INTO `on_region` VALUES ('1497','341503','裕安区','146','0','0','Yuan Qu','2');
INSERT INTO `on_region` VALUES ('1498','341521','寿县','146','0','0','Shou Xian','2');
INSERT INTO `on_region` VALUES ('1499','341522','霍邱县','146','0','0','Huoqiu Xian','2');
INSERT INTO `on_region` VALUES ('1500','341523','舒城县','146','0','0','Shucheng Xian','2');
INSERT INTO `on_region` VALUES ('1501','341524','金寨县','146','0','0','Jingzhai Xian','2');
INSERT INTO `on_region` VALUES ('1502','341525','霍山县','146','0','0','Huoshan Xian','2');
INSERT INTO `on_region` VALUES ('1503','341601','市辖区','147','0','0','1','2');
INSERT INTO `on_region` VALUES ('1504','341602','谯城区','147','0','0','Qiaocheng Qu','2');
INSERT INTO `on_region` VALUES ('1505','341621','涡阳县','147','0','0','Guoyang Xian','2');
INSERT INTO `on_region` VALUES ('1506','341622','蒙城县','147','0','0','Mengcheng Xian','2');
INSERT INTO `on_region` VALUES ('1507','341623','利辛县','147','0','0','Lixin Xian','2');
INSERT INTO `on_region` VALUES ('1508','341701','市辖区','148','0','0','1','2');
INSERT INTO `on_region` VALUES ('1509','341702','贵池区','148','0','0','Guichi Qu','2');
INSERT INTO `on_region` VALUES ('1510','341721','东至县','148','0','0','Dongzhi Xian','2');
INSERT INTO `on_region` VALUES ('1511','341722','石台县','148','0','0','Shitai Xian','2');
INSERT INTO `on_region` VALUES ('1512','341723','青阳县','148','0','0','Qingyang Xian','2');
INSERT INTO `on_region` VALUES ('1513','341801','市辖区','149','0','0','1','2');
INSERT INTO `on_region` VALUES ('1514','341802','宣州区','149','0','0','Xuanzhou Qu','2');
INSERT INTO `on_region` VALUES ('1515','341821','郎溪县','149','0','0','Langxi Xian','2');
INSERT INTO `on_region` VALUES ('1516','341822','广德县','149','0','0','Guangde Xian','2');
INSERT INTO `on_region` VALUES ('1517','341823','泾县','149','0','0','Jing Xian','2');
INSERT INTO `on_region` VALUES ('1518','341824','绩溪县','149','0','0','Jixi Xian','2');
INSERT INTO `on_region` VALUES ('1519','341825','旌德县','149','0','0','Jingde Xian','2');
INSERT INTO `on_region` VALUES ('1520','341881','宁国市','149','0','0','Ningguo Shi','2');
INSERT INTO `on_region` VALUES ('1521','350101','市辖区','150','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1522','350102','鼓楼区','150','0','0','Gulou Qu','GLR');
INSERT INTO `on_region` VALUES ('1523','350103','台江区','150','0','0','Taijiang Qu','TJQ');
INSERT INTO `on_region` VALUES ('1524','350104','仓山区','150','0','0','Cangshan Qu','CSQ');
INSERT INTO `on_region` VALUES ('1525','350105','马尾区','150','0','0','Mawei Qu','MWQ');
INSERT INTO `on_region` VALUES ('1526','350111','晋安区','150','0','0','Jin,an Qu','JAF');
INSERT INTO `on_region` VALUES ('1527','350121','闽侯县','150','0','0','Minhou Qu','MHO');
INSERT INTO `on_region` VALUES ('1528','350122','连江县','150','0','0','Lianjiang Xian','LJF');
INSERT INTO `on_region` VALUES ('1529','350123','罗源县','150','0','0','Luoyuan Xian','LOY');
INSERT INTO `on_region` VALUES ('1530','350124','闽清县','150','0','0','Minqing Xian','MQG');
INSERT INTO `on_region` VALUES ('1531','350125','永泰县','150','0','0','Yongtai Xian','YTX');
INSERT INTO `on_region` VALUES ('1532','350128','平潭县','150','0','0','Pingtan Xian','PTN');
INSERT INTO `on_region` VALUES ('1533','350181','福清市','150','0','0','Fuqing Shi','FQS');
INSERT INTO `on_region` VALUES ('1534','350182','长乐市','150','0','0','Changle Shi','CLS');
INSERT INTO `on_region` VALUES ('1535','350201','市辖区','151','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1536','350203','思明区','151','0','0','Siming Qu','SMQ');
INSERT INTO `on_region` VALUES ('1537','350205','海沧区','151','0','0','Haicang Qu','2');
INSERT INTO `on_region` VALUES ('1538','350206','湖里区','151','0','0','Huli Qu','HLQ');
INSERT INTO `on_region` VALUES ('1539','350211','集美区','151','0','0','Jimei Qu','JMQ');
INSERT INTO `on_region` VALUES ('1540','350212','同安区','151','0','0','Tong,an Qu','TAQ');
INSERT INTO `on_region` VALUES ('1541','350213','翔安区','151','0','0','Xiangan Qu','2');
INSERT INTO `on_region` VALUES ('1542','350301','市辖区','152','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1543','350302','城厢区','152','0','0','Chengxiang Qu','CXP');
INSERT INTO `on_region` VALUES ('1544','350303','涵江区','152','0','0','Hanjiang Qu','HJQ');
INSERT INTO `on_region` VALUES ('1545','350304','荔城区','152','0','0','Licheng Qu','2');
INSERT INTO `on_region` VALUES ('1546','350305','秀屿区','152','0','0','Xiuyu Qu','2');
INSERT INTO `on_region` VALUES ('1547','350322','仙游县','152','0','0','Xianyou Xian','XYF');
INSERT INTO `on_region` VALUES ('1548','350401','市辖区','153','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1549','350402','梅列区','153','0','0','Meilie Qu','MLQ');
INSERT INTO `on_region` VALUES ('1550','350403','三元区','153','0','0','Sanyuan Qu','SYB');
INSERT INTO `on_region` VALUES ('1551','350421','明溪县','153','0','0','Mingxi Xian','MXI');
INSERT INTO `on_region` VALUES ('1552','350423','清流县','153','0','0','Qingliu Xian','QLX');
INSERT INTO `on_region` VALUES ('1553','350424','宁化县','153','0','0','Ninghua Xian','NGH');
INSERT INTO `on_region` VALUES ('1554','350425','大田县','153','0','0','Datian Xian','DTM');
INSERT INTO `on_region` VALUES ('1555','350426','尤溪县','153','0','0','Youxi Xian','YXF');
INSERT INTO `on_region` VALUES ('1556','350427','沙县','153','0','0','Sha Xian','SAX');
INSERT INTO `on_region` VALUES ('1557','350428','将乐县','153','0','0','Jiangle Xian','JLE');
INSERT INTO `on_region` VALUES ('1558','350429','泰宁县','153','0','0','Taining Xian','TNG');
INSERT INTO `on_region` VALUES ('1559','350430','建宁县','153','0','0','Jianning Xian','JNF');
INSERT INTO `on_region` VALUES ('1560','350481','永安市','153','0','0','Yong,an Shi','YAF');
INSERT INTO `on_region` VALUES ('1561','350501','市辖区','154','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1562','350502','鲤城区','154','0','0','Licheng Qu','LCQ');
INSERT INTO `on_region` VALUES ('1563','350503','丰泽区','154','0','0','Fengze Qu','FZE');
INSERT INTO `on_region` VALUES ('1564','350504','洛江区','154','0','0','Luojiang Qu','LJQ');
INSERT INTO `on_region` VALUES ('1565','350505','泉港区','154','0','0','Quangang Qu','2');
INSERT INTO `on_region` VALUES ('1566','350521','惠安县','154','0','0','Hui,an Xian','HAF');
INSERT INTO `on_region` VALUES ('1567','350524','安溪县','154','0','0','Anxi Xian','ANX');
INSERT INTO `on_region` VALUES ('1568','350525','永春县','154','0','0','Yongchun Xian','YCM');
INSERT INTO `on_region` VALUES ('1569','350526','德化县','154','0','0','Dehua Xian','DHA');
INSERT INTO `on_region` VALUES ('1570','350527','金门县','154','0','0','Jinmen Xian','JME');
INSERT INTO `on_region` VALUES ('1571','350581','石狮市','154','0','0','Shishi Shi','SHH');
INSERT INTO `on_region` VALUES ('1572','350582','晋江市','154','0','0','Jinjiang Shi','JJG');
INSERT INTO `on_region` VALUES ('1573','350583','南安市','154','0','0','Nan,an Shi','NAS');
INSERT INTO `on_region` VALUES ('1574','350601','市辖区','155','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1575','350602','芗城区','155','0','0','Xiangcheng Qu','XZZ');
INSERT INTO `on_region` VALUES ('1576','350603','龙文区','155','0','0','Longwen Qu','LWZ');
INSERT INTO `on_region` VALUES ('1577','350622','云霄县','155','0','0','Yunxiao Xian','YXO');
INSERT INTO `on_region` VALUES ('1578','350623','漳浦县','155','0','0','Zhangpu Xian','ZPU');
INSERT INTO `on_region` VALUES ('1579','350624','诏安县','155','0','0','Zhao,an Xian','ZAF');
INSERT INTO `on_region` VALUES ('1580','350625','长泰县','155','0','0','Changtai Xian','CTA');
INSERT INTO `on_region` VALUES ('1581','350626','东山县','155','0','0','Dongshan Xian','DSN');
INSERT INTO `on_region` VALUES ('1582','350627','南靖县','155','0','0','Nanjing Xian','NJX');
INSERT INTO `on_region` VALUES ('1583','350628','平和县','155','0','0','Pinghe Xian','PHE');
INSERT INTO `on_region` VALUES ('1584','350629','华安县','155','0','0','Hua,an Xian','HAN');
INSERT INTO `on_region` VALUES ('1585','350681','龙海市','155','0','0','Longhai Shi','LHM');
INSERT INTO `on_region` VALUES ('1586','350701','市辖区','156','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1587','350702','延平区','156','0','0','Yanping Qu','YPQ');
INSERT INTO `on_region` VALUES ('1588','350721','顺昌县','156','0','0','Shunchang Xian','SCG');
INSERT INTO `on_region` VALUES ('1589','350722','浦城县','156','0','0','Pucheng Xian','PCX');
INSERT INTO `on_region` VALUES ('1590','350723','光泽县','156','0','0','Guangze Xian','GZE');
INSERT INTO `on_region` VALUES ('1591','350724','松溪县','156','0','0','Songxi Xian','SOX');
INSERT INTO `on_region` VALUES ('1592','350725','政和县','156','0','0','Zhenghe Xian','ZGH');
INSERT INTO `on_region` VALUES ('1593','350781','邵武市','156','0','0','Shaowu Shi','SWU');
INSERT INTO `on_region` VALUES ('1594','350782','武夷山市','156','0','0','Wuyishan Shi','WUS');
INSERT INTO `on_region` VALUES ('1595','350783','建瓯市','156','0','0','Jian,ou Shi','JOU');
INSERT INTO `on_region` VALUES ('1596','350784','建阳市','156','0','0','Jianyang Shi','JNY');
INSERT INTO `on_region` VALUES ('1597','350801','市辖区','157','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1598','350802','新罗区','157','0','0','Xinluo Qu','XNL');
INSERT INTO `on_region` VALUES ('1599','350821','长汀县','157','0','0','Changting Xian','CTG');
INSERT INTO `on_region` VALUES ('1600','350822','永定县','157','0','0','Yongding Xian','YDI');
INSERT INTO `on_region` VALUES ('1601','350823','上杭县','157','0','0','Shanghang Xian','SHF');
INSERT INTO `on_region` VALUES ('1602','350824','武平县','157','0','0','Wuping Xian','WPG');
INSERT INTO `on_region` VALUES ('1603','350825','连城县','157','0','0','Liancheng Xian','LCF');
INSERT INTO `on_region` VALUES ('1604','350881','漳平市','157','0','0','Zhangping Xian','ZGP');
INSERT INTO `on_region` VALUES ('1605','350901','市辖区','158','0','0','1','2');
INSERT INTO `on_region` VALUES ('1606','350902','蕉城区','158','0','0','Jiaocheng Qu','2');
INSERT INTO `on_region` VALUES ('1607','350921','霞浦县','158','0','0','Xiapu Xian','2');
INSERT INTO `on_region` VALUES ('1608','350922','古田县','158','0','0','Gutian Xian','2');
INSERT INTO `on_region` VALUES ('1609','350923','屏南县','158','0','0','Pingnan Xian','2');
INSERT INTO `on_region` VALUES ('1610','350924','寿宁县','158','0','0','Shouning Xian','2');
INSERT INTO `on_region` VALUES ('1611','350925','周宁县','158','0','0','Zhouning Xian','2');
INSERT INTO `on_region` VALUES ('1612','350926','柘荣县','158','0','0','Zherong Xian','2');
INSERT INTO `on_region` VALUES ('1613','350981','福安市','158','0','0','Fu,an Shi','2');
INSERT INTO `on_region` VALUES ('1614','350982','福鼎市','158','0','0','Fuding Shi','2');
INSERT INTO `on_region` VALUES ('1615','360101','市辖区','159','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1616','360102','东湖区','159','0','0','Donghu Qu','DHU');
INSERT INTO `on_region` VALUES ('1617','360103','西湖区','159','0','0','Xihu Qu ','XHQ');
INSERT INTO `on_region` VALUES ('1618','360104','青云谱区','159','0','0','Qingyunpu Qu','QYP');
INSERT INTO `on_region` VALUES ('1619','360105','湾里区','159','0','0','Wanli Qu','WLI');
INSERT INTO `on_region` VALUES ('1620','360111','青山湖区','159','0','0','Qingshanhu Qu','2');
INSERT INTO `on_region` VALUES ('1621','360121','南昌县','159','0','0','Nanchang Xian','NCA');
INSERT INTO `on_region` VALUES ('1622','360122','新建县','159','0','0','Xinjian Xian','XJN');
INSERT INTO `on_region` VALUES ('1623','360123','安义县','159','0','0','Anyi Xian','AYI');
INSERT INTO `on_region` VALUES ('1624','360124','进贤县','159','0','0','Jinxian Xian','JXX');
INSERT INTO `on_region` VALUES ('1625','360201','市辖区','160','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1626','360202','昌江区','160','0','0','Changjiang Qu','CJG');
INSERT INTO `on_region` VALUES ('1627','360203','珠山区','160','0','0','Zhushan Qu','ZSJ');
INSERT INTO `on_region` VALUES ('1628','360222','浮梁县','160','0','0','Fuliang Xian','FLX');
INSERT INTO `on_region` VALUES ('1629','360281','乐平市','160','0','0','Leping Shi','LEP');
INSERT INTO `on_region` VALUES ('1630','360301','市辖区','161','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1631','360302','安源区','161','0','0','Anyuan Qu','AYQ');
INSERT INTO `on_region` VALUES ('1632','360313','湘东区','161','0','0','Xiangdong Qu','XDG');
INSERT INTO `on_region` VALUES ('1633','360321','莲花县','161','0','0','Lianhua Xian','LHG');
INSERT INTO `on_region` VALUES ('1634','360322','上栗县','161','0','0','Shangli Xian','SLI');
INSERT INTO `on_region` VALUES ('1635','360323','芦溪县','161','0','0','Lixi Xian','LXP');
INSERT INTO `on_region` VALUES ('1636','360401','市辖区','162','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1637','360402','庐山区','162','0','0','Lushan Qu','LSV');
INSERT INTO `on_region` VALUES ('1638','360403','浔阳区','162','0','0','Xunyang Qu','XYC');
INSERT INTO `on_region` VALUES ('1639','360421','九江县','162','0','0','Jiujiang Xian','JUJ');
INSERT INTO `on_region` VALUES ('1640','360423','武宁县','162','0','0','Wuning Xian','WUN');
INSERT INTO `on_region` VALUES ('1641','360424','修水县','162','0','0','Xiushui Xian','XSG');
INSERT INTO `on_region` VALUES ('1642','360425','永修县','162','0','0','Yongxiu Xian','YOX');
INSERT INTO `on_region` VALUES ('1643','360426','德安县','162','0','0','De,an Xian','DEA');
INSERT INTO `on_region` VALUES ('1644','360427','星子县','162','0','0','Xingzi Xian','XZI');
INSERT INTO `on_region` VALUES ('1645','360428','都昌县','162','0','0','Duchang Xian','DUC');
INSERT INTO `on_region` VALUES ('1646','360429','湖口县','162','0','0','Hukou Xian','HUK');
INSERT INTO `on_region` VALUES ('1647','360430','彭泽县','162','0','0','Pengze Xian','PZE');
INSERT INTO `on_region` VALUES ('1648','360481','瑞昌市','162','0','0','Ruichang Shi','RCG');
INSERT INTO `on_region` VALUES ('1649','360501','市辖区','163','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1650','360502','渝水区','163','0','0','Yushui Qu','YSR');
INSERT INTO `on_region` VALUES ('1651','360521','分宜县','163','0','0','Fenyi Xian','FYI');
INSERT INTO `on_region` VALUES ('1652','360601','市辖区','164','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1653','360602','月湖区','164','0','0','Yuehu Qu','YHY');
INSERT INTO `on_region` VALUES ('1654','360622','余江县','164','0','0','Yujiang Xian','YUJ');
INSERT INTO `on_region` VALUES ('1655','360681','贵溪市','164','0','0','Guixi Shi','GXS');
INSERT INTO `on_region` VALUES ('1656','360701','市辖区','165','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1657','360702','章贡区','165','0','0','Zhanggong Qu','ZGG');
INSERT INTO `on_region` VALUES ('1658','360721','赣县','165','0','0','Gan Xian','GXN');
INSERT INTO `on_region` VALUES ('1659','360722','信丰县','165','0','0','Xinfeng Xian ','XNF');
INSERT INTO `on_region` VALUES ('1660','360723','大余县','165','0','0','Dayu Xian','DYX');
INSERT INTO `on_region` VALUES ('1661','360724','上犹县','165','0','0','Shangyou Xian','SYO');
INSERT INTO `on_region` VALUES ('1662','360725','崇义县','165','0','0','Chongyi Xian','CYX');
INSERT INTO `on_region` VALUES ('1663','360726','安远县','165','0','0','Anyuan Xian','AYN');
INSERT INTO `on_region` VALUES ('1664','360727','龙南县','165','0','0','Longnan Xian','LNX');
INSERT INTO `on_region` VALUES ('1665','360728','定南县','165','0','0','Dingnan Xian','DNN');
INSERT INTO `on_region` VALUES ('1666','360729','全南县','165','0','0','Quannan Xian','QNN');
INSERT INTO `on_region` VALUES ('1667','360730','宁都县','165','0','0','Ningdu Xian','NDU');
INSERT INTO `on_region` VALUES ('1668','360731','于都县','165','0','0','Yudu Xian','YUD');
INSERT INTO `on_region` VALUES ('1669','360732','兴国县','165','0','0','Xingguo Xian','XGG');
INSERT INTO `on_region` VALUES ('1670','360733','会昌县','165','0','0','Huichang Xian','HIC');
INSERT INTO `on_region` VALUES ('1671','360734','寻乌县','165','0','0','Xunwu Xian','XNW');
INSERT INTO `on_region` VALUES ('1672','360735','石城县','165','0','0','Shicheng Xian','SIC');
INSERT INTO `on_region` VALUES ('1673','360781','瑞金市','165','0','0','Ruijin Shi','RJS');
INSERT INTO `on_region` VALUES ('1674','360782','南康市','165','0','0','Nankang Shi','NNK');
INSERT INTO `on_region` VALUES ('1675','360801','市辖区','166','0','0','1','2');
INSERT INTO `on_region` VALUES ('1676','360802','吉州区','166','0','0','Jizhou Qu','2');
INSERT INTO `on_region` VALUES ('1677','360803','青原区','166','0','0','Qingyuan Qu','2');
INSERT INTO `on_region` VALUES ('1678','360821','吉安县','166','0','0','Ji,an Xian','2');
INSERT INTO `on_region` VALUES ('1679','360822','吉水县','166','0','0','Jishui Xian','2');
INSERT INTO `on_region` VALUES ('1680','360823','峡江县','166','0','0','Xiajiang Xian','2');
INSERT INTO `on_region` VALUES ('1681','360824','新干县','166','0','0','Xingan Xian','2');
INSERT INTO `on_region` VALUES ('1682','360825','永丰县','166','0','0','Yongfeng Xian','2');
INSERT INTO `on_region` VALUES ('1683','360826','泰和县','166','0','0','Taihe Xian','2');
INSERT INTO `on_region` VALUES ('1684','360827','遂川县','166','0','0','Suichuan Xian','2');
INSERT INTO `on_region` VALUES ('1685','360828','万安县','166','0','0','Wan,an Xian','2');
INSERT INTO `on_region` VALUES ('1686','360829','安福县','166','0','0','Anfu Xian','2');
INSERT INTO `on_region` VALUES ('1687','360830','永新县','166','0','0','Yongxin Xian ','2');
INSERT INTO `on_region` VALUES ('1688','360881','井冈山市','166','0','0','Jinggangshan Shi','2');
INSERT INTO `on_region` VALUES ('1689','360901','市辖区','167','0','0','1','2');
INSERT INTO `on_region` VALUES ('1690','360902','袁州区','167','0','0','Yuanzhou Qu','2');
INSERT INTO `on_region` VALUES ('1691','360921','奉新县','167','0','0','Fengxin Xian','2');
INSERT INTO `on_region` VALUES ('1692','360922','万载县','167','0','0','Wanzai Xian','2');
INSERT INTO `on_region` VALUES ('1693','360923','上高县','167','0','0','Shanggao Xian','2');
INSERT INTO `on_region` VALUES ('1694','360924','宜丰县','167','0','0','Yifeng Xian','2');
INSERT INTO `on_region` VALUES ('1695','360925','靖安县','167','0','0','Jing,an Xian','2');
INSERT INTO `on_region` VALUES ('1696','360926','铜鼓县','167','0','0','Tonggu Xian','2');
INSERT INTO `on_region` VALUES ('1697','360981','丰城市','167','0','0','Fengcheng Shi','2');
INSERT INTO `on_region` VALUES ('1698','360982','樟树市','167','0','0','Zhangshu Shi','2');
INSERT INTO `on_region` VALUES ('1699','360983','高安市','167','0','0','Gao,an Shi','2');
INSERT INTO `on_region` VALUES ('1700','361001','市辖区','168','0','0','1','2');
INSERT INTO `on_region` VALUES ('1701','361002','临川区','168','0','0','Linchuan Qu','2');
INSERT INTO `on_region` VALUES ('1702','361021','南城县','168','0','0','Nancheng Xian','2');
INSERT INTO `on_region` VALUES ('1703','361022','黎川县','168','0','0','Lichuan Xian','2');
INSERT INTO `on_region` VALUES ('1704','361023','南丰县','168','0','0','Nanfeng Xian','2');
INSERT INTO `on_region` VALUES ('1705','361024','崇仁县','168','0','0','Chongren Xian','2');
INSERT INTO `on_region` VALUES ('1706','361025','乐安县','168','0','0','Le,an Xian','2');
INSERT INTO `on_region` VALUES ('1707','361026','宜黄县','168','0','0','Yihuang Xian','2');
INSERT INTO `on_region` VALUES ('1708','361027','金溪县','168','0','0','Jinxi Xian','2');
INSERT INTO `on_region` VALUES ('1709','361028','资溪县','168','0','0','Zixi Xian','2');
INSERT INTO `on_region` VALUES ('1710','361029','东乡县','168','0','0','Dongxiang Xian','2');
INSERT INTO `on_region` VALUES ('1711','361030','广昌县','168','0','0','Guangchang Xian','2');
INSERT INTO `on_region` VALUES ('1712','361101','市辖区','169','0','0','1','2');
INSERT INTO `on_region` VALUES ('1713','361102','信州区','169','0','0','Xinzhou Qu','XZQ');
INSERT INTO `on_region` VALUES ('1714','361121','上饶县','169','0','0','Shangrao Xian ','2');
INSERT INTO `on_region` VALUES ('1715','361122','广丰县','169','0','0','Guangfeng Xian','2');
INSERT INTO `on_region` VALUES ('1716','361123','玉山县','169','0','0','Yushan Xian','2');
INSERT INTO `on_region` VALUES ('1717','361124','铅山县','169','0','0','Qianshan Xian','2');
INSERT INTO `on_region` VALUES ('1718','361125','横峰县','169','0','0','Hengfeng Xian','2');
INSERT INTO `on_region` VALUES ('1719','361126','弋阳县','169','0','0','Yiyang Xian','2');
INSERT INTO `on_region` VALUES ('1720','361127','余干县','169','0','0','Yugan Xian','2');
INSERT INTO `on_region` VALUES ('1721','361128','鄱阳县','169','0','0','Poyang Xian','PYX');
INSERT INTO `on_region` VALUES ('1722','361129','万年县','169','0','0','Wannian Xian','2');
INSERT INTO `on_region` VALUES ('1723','361130','婺源县','169','0','0','Wuyuan Xian','2');
INSERT INTO `on_region` VALUES ('1724','361181','德兴市','169','0','0','Dexing Shi','2');
INSERT INTO `on_region` VALUES ('1725','370101','市辖区','170','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1726','370102','历下区','170','0','0','Lixia Qu','LXQ');
INSERT INTO `on_region` VALUES ('1727','370101','市中区','170','0','0','Shizhong Qu','SZQ');
INSERT INTO `on_region` VALUES ('1728','370104','槐荫区','170','0','0','Huaiyin Qu','HYF');
INSERT INTO `on_region` VALUES ('1729','370105','天桥区','170','0','0','Tianqiao Qu','TQQ');
INSERT INTO `on_region` VALUES ('1730','370112','历城区','170','0','0','Licheng Qu','LCZ');
INSERT INTO `on_region` VALUES ('1731','370113','长清区','170','0','0','Changqing Qu','2');
INSERT INTO `on_region` VALUES ('1732','370124','平阴县','170','0','0','Pingyin Xian','PYL');
INSERT INTO `on_region` VALUES ('1733','370125','济阳县','170','0','0','Jiyang Xian','JYL');
INSERT INTO `on_region` VALUES ('1734','370126','商河县','170','0','0','Shanghe Xian','SGH');
INSERT INTO `on_region` VALUES ('1735','370181','章丘市','170','0','0','Zhangqiu Shi','ZQS');
INSERT INTO `on_region` VALUES ('1736','370201','市辖区','171','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1737','370202','市南区','171','0','0','Shinan Qu','SNQ');
INSERT INTO `on_region` VALUES ('1738','370203','市北区','171','0','0','Shibei Qu','SBQ');
INSERT INTO `on_region` VALUES ('1739','370205','四方区','171','0','0','Sifang Qu','SFQ');
INSERT INTO `on_region` VALUES ('1740','370211','黄岛区','171','0','0','Huangdao Qu','HDO');
INSERT INTO `on_region` VALUES ('1741','370212','崂山区','171','0','0','Laoshan Qu','LQD');
INSERT INTO `on_region` VALUES ('1742','370213','李沧区','171','0','0','Licang Qu','LCT');
INSERT INTO `on_region` VALUES ('1743','370214','城阳区','171','0','0','Chengyang Qu','CEY');
INSERT INTO `on_region` VALUES ('1744','370281','胶州市','171','0','0','Jiaozhou Shi','JZS');
INSERT INTO `on_region` VALUES ('1745','370282','即墨市','171','0','0','Jimo Shi','JMO');
INSERT INTO `on_region` VALUES ('1746','370283','平度市','171','0','0','Pingdu Shi','PDU');
INSERT INTO `on_region` VALUES ('1747','370284','胶南市','171','0','0','Jiaonan Shi','JNS');
INSERT INTO `on_region` VALUES ('1748','370285','莱西市','171','0','0','Laixi Shi','LXE');
INSERT INTO `on_region` VALUES ('1749','370301','市辖区','172','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1750','370302','淄川区','172','0','0','Zichuan Qu','ZCQ');
INSERT INTO `on_region` VALUES ('1751','370303','张店区','172','0','0','Zhangdian Qu','ZDQ');
INSERT INTO `on_region` VALUES ('1752','370304','博山区','172','0','0','Boshan Qu','BSZ');
INSERT INTO `on_region` VALUES ('1753','370305','临淄区','172','0','0','Linzi Qu','LZQ');
INSERT INTO `on_region` VALUES ('1754','370306','周村区','172','0','0','Zhoucun Qu','ZCN');
INSERT INTO `on_region` VALUES ('1755','370321','桓台县','172','0','0','Huantai Xian','HTL');
INSERT INTO `on_region` VALUES ('1756','370322','高青县','172','0','0','Gaoqing Xian','GQG');
INSERT INTO `on_region` VALUES ('1757','370323','沂源县','172','0','0','Yiyuan Xian','YIY');
INSERT INTO `on_region` VALUES ('1758','370401','市辖区','173','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1759','370402','市中区','173','0','0','Shizhong Qu','SZZ');
INSERT INTO `on_region` VALUES ('1760','370403','薛城区','173','0','0','Xuecheng Qu','XEC');
INSERT INTO `on_region` VALUES ('1761','370404','峄城区','173','0','0','Yicheng Qu','YZZ');
INSERT INTO `on_region` VALUES ('1762','370405','台儿庄区','173','0','0','Tai,erzhuang Qu','TEZ');
INSERT INTO `on_region` VALUES ('1763','370406','山亭区','173','0','0','Shanting Qu','STG');
INSERT INTO `on_region` VALUES ('1764','370481','滕州市','173','0','0','Tengzhou Shi','TZO');
INSERT INTO `on_region` VALUES ('1765','370501','市辖区','174','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1766','370502','东营区','174','0','0','Dongying Qu','DYQ');
INSERT INTO `on_region` VALUES ('1767','370503','河口区','174','0','0','Hekou Qu','HKO');
INSERT INTO `on_region` VALUES ('1768','370521','垦利县','174','0','0','Kenli Xian','KLI');
INSERT INTO `on_region` VALUES ('1769','370522','利津县','174','0','0','Lijin Xian','LJN');
INSERT INTO `on_region` VALUES ('1770','370523','广饶县','174','0','0','Guangrao Xian ','GRO');
INSERT INTO `on_region` VALUES ('1771','370601','市辖区','175','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1772','370602','芝罘区','175','0','0','Zhifu Qu','ZFQ');
INSERT INTO `on_region` VALUES ('1773','370611','福山区','175','0','0','Fushan Qu','FUS');
INSERT INTO `on_region` VALUES ('1774','370612','牟平区','175','0','0','Muping Qu','MPQ');
INSERT INTO `on_region` VALUES ('1775','370613','莱山区','175','0','0','Laishan Qu','LYT');
INSERT INTO `on_region` VALUES ('1776','370634','长岛县','175','0','0','Changdao Xian','CDO');
INSERT INTO `on_region` VALUES ('1777','370681','龙口市','175','0','0','Longkou Shi','LKU');
INSERT INTO `on_region` VALUES ('1778','370682','莱阳市','175','0','0','Laiyang Shi','LYD');
INSERT INTO `on_region` VALUES ('1779','370683','莱州市','175','0','0','Laizhou Shi','LZG');
INSERT INTO `on_region` VALUES ('1780','370684','蓬莱市','175','0','0','Penglai Shi','PLI');
INSERT INTO `on_region` VALUES ('1781','370685','招远市','175','0','0','Zhaoyuan Shi','ZYL');
INSERT INTO `on_region` VALUES ('1782','370686','栖霞市','175','0','0','Qixia Shi','QXS');
INSERT INTO `on_region` VALUES ('1783','370687','海阳市','175','0','0','Haiyang Shi','HYL');
INSERT INTO `on_region` VALUES ('1784','370701','市辖区','176','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1785','370702','潍城区','176','0','0','Weicheng Qu','WCG');
INSERT INTO `on_region` VALUES ('1786','370703','寒亭区','176','0','0','Hanting Qu','HNT');
INSERT INTO `on_region` VALUES ('1787','370704','坊子区','176','0','0','Fangzi Qu','FZQ');
INSERT INTO `on_region` VALUES ('1788','370705','奎文区','176','0','0','Kuiwen Qu','KWN');
INSERT INTO `on_region` VALUES ('1789','370724','临朐县','176','0','0','Linqu Xian','LNQ');
INSERT INTO `on_region` VALUES ('1790','370725','昌乐县','176','0','0','Changle Xian','CLX');
INSERT INTO `on_region` VALUES ('1791','370781','青州市','176','0','0','Qingzhou Shi','QGZ');
INSERT INTO `on_region` VALUES ('1792','370782','诸城市','176','0','0','Zhucheng Shi','ZCL');
INSERT INTO `on_region` VALUES ('1793','370783','寿光市','176','0','0','Shouguang Shi','SGG');
INSERT INTO `on_region` VALUES ('1794','370784','安丘市','176','0','0','Anqiu Shi','AQU');
INSERT INTO `on_region` VALUES ('1795','370785','高密市','176','0','0','Gaomi Shi','GMI');
INSERT INTO `on_region` VALUES ('1796','370786','昌邑市','176','0','0','Changyi Shi','CYL');
INSERT INTO `on_region` VALUES ('1797','370801','市辖区','177','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1798','370802','市中区','177','0','0','Shizhong Qu','SZU');
INSERT INTO `on_region` VALUES ('1799','370811','任城区','177','0','0','Rencheng Qu','RCQ');
INSERT INTO `on_region` VALUES ('1800','370826','微山县','177','0','0','Weishan Xian','WSA');
INSERT INTO `on_region` VALUES ('1801','370827','鱼台县','177','0','0','Yutai Xian','YTL');
INSERT INTO `on_region` VALUES ('1802','370828','金乡县','177','0','0','Jinxiang Xian','JXG');
INSERT INTO `on_region` VALUES ('1803','370829','嘉祥县','177','0','0','Jiaxiang Xian','JXP');
INSERT INTO `on_region` VALUES ('1804','370830','汶上县','177','0','0','Wenshang Xian','WNS');
INSERT INTO `on_region` VALUES ('1805','370831','泗水县','177','0','0','Sishui Xian','SSH');
INSERT INTO `on_region` VALUES ('1806','370832','梁山县','177','0','0','Liangshan Xian','LSN');
INSERT INTO `on_region` VALUES ('1807','370881','曲阜市','177','0','0','Qufu Shi','QFU');
INSERT INTO `on_region` VALUES ('1808','370882','兖州市','177','0','0','Yanzhou Shi','YZL');
INSERT INTO `on_region` VALUES ('1809','370883','邹城市','177','0','0','Zoucheng Shi','ZCG');
INSERT INTO `on_region` VALUES ('1810','370901','市辖区','178','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1811','370902','泰山区','178','0','0','Taishan Qu','TSQ');
INSERT INTO `on_region` VALUES ('1812','370911','岱岳区','178','0','0','Daiyue Qu','2');
INSERT INTO `on_region` VALUES ('1813','370921','宁阳县','178','0','0','Ningyang Xian','NGY');
INSERT INTO `on_region` VALUES ('1814','370923','东平县','178','0','0','Dongping Xian','DPG');
INSERT INTO `on_region` VALUES ('1815','370982','新泰市','178','0','0','Xintai Shi','XTA');
INSERT INTO `on_region` VALUES ('1816','370983','肥城市','178','0','0','Feicheng Shi','FEC');
INSERT INTO `on_region` VALUES ('1817','371001','市辖区','179','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1818','371002','环翠区','179','0','0','Huancui Qu','HNC');
INSERT INTO `on_region` VALUES ('1819','371081','文登市','179','0','0','Wendeng Shi','WDS');
INSERT INTO `on_region` VALUES ('1820','371082','荣成市','179','0','0','Rongcheng Shi','2');
INSERT INTO `on_region` VALUES ('1821','371083','乳山市','179','0','0','Rushan Shi','RSN');
INSERT INTO `on_region` VALUES ('1822','371101','市辖区','180','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1823','371102','东港区','180','0','0','Donggang Qu','DGR');
INSERT INTO `on_region` VALUES ('1824','371103','岚山区','180','0','0','Lanshan Qu','2');
INSERT INTO `on_region` VALUES ('1825','371121','五莲县','180','0','0','Wulian Xian','WLN');
INSERT INTO `on_region` VALUES ('1826','371122','莒县','180','0','0','Ju Xian','JUX');
INSERT INTO `on_region` VALUES ('1827','371201','市辖区','181','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1828','371202','莱城区','181','0','0','Laicheng Qu','LAC');
INSERT INTO `on_region` VALUES ('1829','371203','钢城区','181','0','0','Gangcheng Qu','GCQ');
INSERT INTO `on_region` VALUES ('1830','371301','市辖区','182','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1831','371302','兰山区','182','0','0','Lanshan Qu','LLS');
INSERT INTO `on_region` VALUES ('1832','371311','罗庄区','182','0','0','Luozhuang Qu','LZU');
INSERT INTO `on_region` VALUES ('1833','371301','河东区','182','0','0','Hedong Qu','2');
INSERT INTO `on_region` VALUES ('1834','371321','沂南县','182','0','0','Yinan Xian','YNN');
INSERT INTO `on_region` VALUES ('1835','371322','郯城县','182','0','0','Tancheng Xian','TCE');
INSERT INTO `on_region` VALUES ('1836','371323','沂水县','182','0','0','Yishui Xian','YIS');
INSERT INTO `on_region` VALUES ('1837','371324','苍山县','182','0','0','Cangshan Xian','CSH');
INSERT INTO `on_region` VALUES ('1838','371325','费县','182','0','0','Fei Xian','FEI');
INSERT INTO `on_region` VALUES ('1839','371326','平邑县','182','0','0','Pingyi Xian','PYI');
INSERT INTO `on_region` VALUES ('1840','371327','莒南县','182','0','0','Junan Xian','JNB');
INSERT INTO `on_region` VALUES ('1841','371328','蒙阴县','182','0','0','Mengyin Xian','MYL');
INSERT INTO `on_region` VALUES ('1842','371329','临沭县','182','0','0','Linshu Xian','LSP');
INSERT INTO `on_region` VALUES ('1843','371401','市辖区','183','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1844','371402','德城区','183','0','0','Decheng Qu','DCD');
INSERT INTO `on_region` VALUES ('1845','371421','陵县','183','0','0','Ling Xian','LXL');
INSERT INTO `on_region` VALUES ('1846','371422','宁津县','183','0','0','Ningjin Xian','NGJ');
INSERT INTO `on_region` VALUES ('1847','371423','庆云县','183','0','0','Qingyun Xian','QYL');
INSERT INTO `on_region` VALUES ('1848','371424','临邑县','183','0','0','Linyi xian','LYM');
INSERT INTO `on_region` VALUES ('1849','371425','齐河县','183','0','0','Qihe Xian','QIH');
INSERT INTO `on_region` VALUES ('1850','371426','平原县','183','0','0','Pingyuan Xian','PYN');
INSERT INTO `on_region` VALUES ('1851','371427','夏津县','183','0','0','Xiajin Xian','XAJ');
INSERT INTO `on_region` VALUES ('1852','371428','武城县','183','0','0','Wucheng Xian','WUC');
INSERT INTO `on_region` VALUES ('1853','371481','乐陵市','183','0','0','Leling Shi','LEL');
INSERT INTO `on_region` VALUES ('1854','371482','禹城市','183','0','0','Yucheng Shi','YCL');
INSERT INTO `on_region` VALUES ('1855','371501','市辖区','184','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1856','371502','东昌府区','184','0','0','Dongchangfu Qu','DCF');
INSERT INTO `on_region` VALUES ('1857','371521','阳谷县','184','0','0','Yanggu Xian ','YGU');
INSERT INTO `on_region` VALUES ('1858','371522','莘县','184','0','0','Shen Xian','SHN');
INSERT INTO `on_region` VALUES ('1859','371523','茌平县','184','0','0','Chiping Xian ','CPG');
INSERT INTO `on_region` VALUES ('1860','371524','东阿县','184','0','0','Dong,e Xian','DGE');
INSERT INTO `on_region` VALUES ('1861','371525','冠县','184','0','0','Guan Xian','GXL');
INSERT INTO `on_region` VALUES ('1862','371526','高唐县','184','0','0','Gaotang Xian','GTG');
INSERT INTO `on_region` VALUES ('1863','371581','临清市','184','0','0','Linqing Xian','LQS');
INSERT INTO `on_region` VALUES ('1864','371601','市辖区','185','0','0','1','2');
INSERT INTO `on_region` VALUES ('1865','371602','滨城区','185','0','0','Bincheng Qu','2');
INSERT INTO `on_region` VALUES ('1866','371621','惠民县','185','0','0','Huimin Xian','2');
INSERT INTO `on_region` VALUES ('1867','371622','阳信县','185','0','0','Yangxin Xian','2');
INSERT INTO `on_region` VALUES ('1868','371623','无棣县','185','0','0','Wudi Xian','2');
INSERT INTO `on_region` VALUES ('1869','371624','沾化县','185','0','0','Zhanhua Xian','2');
INSERT INTO `on_region` VALUES ('1870','371625','博兴县','185','0','0','Boxing Xian','2');
INSERT INTO `on_region` VALUES ('1871','371626','邹平县','185','0','0','Zouping Xian','2');
INSERT INTO `on_region` VALUES ('1873','371702','牡丹区','186','0','0','Mudan Qu','2');
INSERT INTO `on_region` VALUES ('1874','371721','曹县','186','0','0','Cao Xian','2');
INSERT INTO `on_region` VALUES ('1875','371722','单县','186','0','0','Shan Xian','2');
INSERT INTO `on_region` VALUES ('1876','371723','成武县','186','0','0','Chengwu Xian','2');
INSERT INTO `on_region` VALUES ('1877','371724','巨野县','186','0','0','Juye Xian','2');
INSERT INTO `on_region` VALUES ('1878','371725','郓城县','186','0','0','Yuncheng Xian','2');
INSERT INTO `on_region` VALUES ('1879','371726','鄄城县','186','0','0','Juancheng Xian','2');
INSERT INTO `on_region` VALUES ('1880','371727','定陶县','186','0','0','Dingtao Xian','2');
INSERT INTO `on_region` VALUES ('1881','371728','东明县','186','0','0','Dongming Xian','2');
INSERT INTO `on_region` VALUES ('1882','410101','市辖区','187','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1883','410102','中原区','187','0','0','Zhongyuan Qu','ZYQ');
INSERT INTO `on_region` VALUES ('1884','410103','二七区','187','0','0','Erqi Qu','EQQ');
INSERT INTO `on_region` VALUES ('1885','410104','管城回族区','187','0','0','Guancheng Huizu Qu','GCH');
INSERT INTO `on_region` VALUES ('1886','410105','金水区','187','0','0','Jinshui Qu','JSU');
INSERT INTO `on_region` VALUES ('1887','410106','上街区','187','0','0','Shangjie Qu','SJE');
INSERT INTO `on_region` VALUES ('1888','410108','惠济区','187','0','0','Mangshan Qu','2');
INSERT INTO `on_region` VALUES ('1889','410122','中牟县','187','0','0','Zhongmou Xian','ZMO');
INSERT INTO `on_region` VALUES ('1890','410181','巩义市','187','0','0','Gongyi Shi','GYI');
INSERT INTO `on_region` VALUES ('1891','410182','荥阳市','187','0','0','Xingyang Shi','XYK');
INSERT INTO `on_region` VALUES ('1892','410183','新密市','187','0','0','Xinmi Shi','XMI');
INSERT INTO `on_region` VALUES ('1893','410184','新郑市','187','0','0','Xinzheng Shi','XZG');
INSERT INTO `on_region` VALUES ('1894','410185','登封市','187','0','0','Dengfeng Shi','2');
INSERT INTO `on_region` VALUES ('1895','410201','市辖区','188','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1896','410202','龙亭区','188','0','0','Longting Qu','LTK');
INSERT INTO `on_region` VALUES ('1897','410203','顺河回族区','188','0','0','Shunhe Huizu Qu','SHR');
INSERT INTO `on_region` VALUES ('1898','410204','鼓楼区','188','0','0','Gulou Qu','GLK');
INSERT INTO `on_region` VALUES ('1899','410205','禹王台区','188','0','0','Yuwangtai Qu','2');
INSERT INTO `on_region` VALUES ('1900','410211','金明区','188','0','0','Jinming Qu','2');
INSERT INTO `on_region` VALUES ('1901','410221','杞县','188','0','0','Qi Xian','QIX');
INSERT INTO `on_region` VALUES ('1902','410222','通许县','188','0','0','Tongxu Xian','TXY');
INSERT INTO `on_region` VALUES ('1903','410223','尉氏县','188','0','0','Weishi Xian','WSI');
INSERT INTO `on_region` VALUES ('1904','410224','开封县','188','0','0','Kaifeng Xian','KFX');
INSERT INTO `on_region` VALUES ('1905','410225','兰考县','188','0','0','Lankao Xian','LKA');
INSERT INTO `on_region` VALUES ('1906','410301','市辖区','189','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1907','410302','老城区','189','0','0','Laocheng Qu','LLY');
INSERT INTO `on_region` VALUES ('1908','410303','西工区','189','0','0','Xigong Qu','XGL');
INSERT INTO `on_region` VALUES ('1909','410304','瀍河回族区','189','0','0','Chanhehuizu Qu','2');
INSERT INTO `on_region` VALUES ('1910','410305','涧西区','189','0','0','Jianxi Qu','JXL');
INSERT INTO `on_region` VALUES ('1911','410306','吉利区','189','0','0','Jili Qu','JLL');
INSERT INTO `on_region` VALUES ('1912','410311','洛龙区','189','0','0','Luolong Qu','2');
INSERT INTO `on_region` VALUES ('1913','410322','孟津县','189','0','0','Mengjin Xian','MGJ');
INSERT INTO `on_region` VALUES ('1914','410323','新安县','189','0','0','Xin,an Xian','XAX');
INSERT INTO `on_region` VALUES ('1915','410324','栾川县','189','0','0','Luanchuan Xian','LCK');
INSERT INTO `on_region` VALUES ('1916','410325','嵩县','189','0','0','Song Xian','SON');
INSERT INTO `on_region` VALUES ('1917','410326','汝阳县','189','0','0','Ruyang Xian','RUY');
INSERT INTO `on_region` VALUES ('1918','410327','宜阳县','189','0','0','Yiyang Xian','YYY');
INSERT INTO `on_region` VALUES ('1919','410328','洛宁县','189','0','0','Luoning Xian','LNI');
INSERT INTO `on_region` VALUES ('1920','410329','伊川县','189','0','0','Yichuan Xian','YCZ');
INSERT INTO `on_region` VALUES ('1921','410381','偃师市','189','0','0','Yanshi Shi','YST');
INSERT INTO `on_region` VALUES ('1922','410401','市辖区','190','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1923','410402','新华区','190','0','0','Xinhua Qu','XHP');
INSERT INTO `on_region` VALUES ('1924','410403','卫东区','190','0','0','Weidong Qu','WDG');
INSERT INTO `on_region` VALUES ('1925','410404','石龙区','190','0','0','Shilong Qu','SIL');
INSERT INTO `on_region` VALUES ('1926','410411','湛河区','190','0','0','Zhanhe Qu','ZHQ');
INSERT INTO `on_region` VALUES ('1927','410421','宝丰县','190','0','0','Baofeng Xian','BFG');
INSERT INTO `on_region` VALUES ('1928','410422','叶县','190','0','0','Ye Xian','YEX');
INSERT INTO `on_region` VALUES ('1929','410423','鲁山县','190','0','0','Lushan Xian','LUS');
INSERT INTO `on_region` VALUES ('1930','410425','郏县','190','0','0','Jia Xian','JXY');
INSERT INTO `on_region` VALUES ('1931','410481','舞钢市','190','0','0','Wugang Shi','WGY');
INSERT INTO `on_region` VALUES ('1932','410482','汝州市','190','0','0','Ruzhou Shi','RZO');
INSERT INTO `on_region` VALUES ('1933','410501','市辖区','191','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1934','410502','文峰区','191','0','0','Wenfeng Qu','WFQ');
INSERT INTO `on_region` VALUES ('1935','410503','北关区','191','0','0','Beiguan Qu','BGQ');
INSERT INTO `on_region` VALUES ('1936','410505','殷都区','191','0','0','Yindu Qu','2');
INSERT INTO `on_region` VALUES ('1937','410506','龙安区','191','0','0','Longan Qu','2');
INSERT INTO `on_region` VALUES ('1938','410522','安阳县','191','0','0','Anyang Xian','AYX');
INSERT INTO `on_region` VALUES ('1939','410523','汤阴县','191','0','0','Tangyin Xian','TYI');
INSERT INTO `on_region` VALUES ('1940','410526','滑县','191','0','0','Hua Xian','HUA');
INSERT INTO `on_region` VALUES ('1941','410527','内黄县','191','0','0','Neihuang Xian','NHG');
INSERT INTO `on_region` VALUES ('1942','410581','林州市','191','0','0','Linzhou Shi','LZY');
INSERT INTO `on_region` VALUES ('1943','410601','市辖区','192','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1944','410602','鹤山区','192','0','0','Heshan Qu','HSF');
INSERT INTO `on_region` VALUES ('1945','410603','山城区','192','0','0','Shancheng Qu','SCB');
INSERT INTO `on_region` VALUES ('1946','410611','淇滨区','192','0','0','Qibin Qu','2');
INSERT INTO `on_region` VALUES ('1947','410621','浚县','192','0','0','Xun Xian','XUX');
INSERT INTO `on_region` VALUES ('1948','410622','淇县','192','0','0','Qi Xian','QXY');
INSERT INTO `on_region` VALUES ('1949','410701','市辖区','193','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1950','410702','红旗区','193','0','0','Hongqi Qu','HQQ');
INSERT INTO `on_region` VALUES ('1951','410703','卫滨区','193','0','0','Weibin Qu','2');
INSERT INTO `on_region` VALUES ('1952','410704','凤泉区','193','0','0','Fengquan Qu','2');
INSERT INTO `on_region` VALUES ('1953','410711','牧野区','193','0','0','Muye Qu','2');
INSERT INTO `on_region` VALUES ('1954','410721','新乡县','193','0','0','Xinxiang Xian','XXX');
INSERT INTO `on_region` VALUES ('1955','410724','获嘉县','193','0','0','Huojia Xian','HOJ');
INSERT INTO `on_region` VALUES ('1956','410725','原阳县','193','0','0','Yuanyang Xian','YYA');
INSERT INTO `on_region` VALUES ('1957','410726','延津县','193','0','0','Yanjin Xian','YJN');
INSERT INTO `on_region` VALUES ('1958','410727','封丘县','193','0','0','Fengqiu Xian','FQU');
INSERT INTO `on_region` VALUES ('1959','410728','长垣县','193','0','0','Changyuan Xian','CYU');
INSERT INTO `on_region` VALUES ('1960','410781','卫辉市','193','0','0','Weihui Shi','WHS');
INSERT INTO `on_region` VALUES ('1961','410782','辉县市','193','0','0','Huixian Shi','HXS');
INSERT INTO `on_region` VALUES ('1962','410801','市辖区','194','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1963','410802','解放区','194','0','0','Jiefang Qu','JFQ');
INSERT INTO `on_region` VALUES ('1964','410803','中站区','194','0','0','Zhongzhan Qu','ZZQ');
INSERT INTO `on_region` VALUES ('1965','410804','马村区','194','0','0','Macun Qu','MCQ');
INSERT INTO `on_region` VALUES ('1966','410811','山阳区','194','0','0','Shanyang Qu','SYC');
INSERT INTO `on_region` VALUES ('1967','410821','修武县','194','0','0','Xiuwu Xian','XUW');
INSERT INTO `on_region` VALUES ('1968','410822','博爱县','194','0','0','Bo,ai Xian','BOA');
INSERT INTO `on_region` VALUES ('1969','410823','武陟县','194','0','0','Wuzhi Xian','WZI');
INSERT INTO `on_region` VALUES ('1970','410825','温县','194','0','0','Wen Xian','WEN');
INSERT INTO `on_region` VALUES ('1971','419001','济源市','194','0','0','Jiyuan Shi','2');
INSERT INTO `on_region` VALUES ('1972','410882','沁阳市','194','0','0','Qinyang Shi','QYS');
INSERT INTO `on_region` VALUES ('1973','410883','孟州市','194','0','0','Mengzhou Shi','MZO');
INSERT INTO `on_region` VALUES ('1974','410901','市辖区','195','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1975','410902','华龙区','195','0','0','Hualong Qu','2');
INSERT INTO `on_region` VALUES ('1976','410922','清丰县','195','0','0','Qingfeng Xian','QFG');
INSERT INTO `on_region` VALUES ('1977','410923','南乐县','195','0','0','Nanle Xian','NLE');
INSERT INTO `on_region` VALUES ('1978','410926','范县','195','0','0','Fan Xian','FAX');
INSERT INTO `on_region` VALUES ('1979','410927','台前县','195','0','0','Taiqian Xian','TQN');
INSERT INTO `on_region` VALUES ('1980','410928','濮阳县','195','0','0','Puyang Xian','PUY');
INSERT INTO `on_region` VALUES ('1981','411001','市辖区','196','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1982','411002','魏都区','196','0','0','Weidu Qu','WED');
INSERT INTO `on_region` VALUES ('1983','411023','许昌县','196','0','0','Xuchang Xian','XUC');
INSERT INTO `on_region` VALUES ('1984','411024','鄢陵县','196','0','0','Yanling Xian','YLY');
INSERT INTO `on_region` VALUES ('1985','411025','襄城县','196','0','0','Xiangcheng Xian','XAC');
INSERT INTO `on_region` VALUES ('1986','411081','禹州市','196','0','0','Yuzhou Shi','YUZ');
INSERT INTO `on_region` VALUES ('1987','411082','长葛市','196','0','0','Changge Shi','CGE');
INSERT INTO `on_region` VALUES ('1988','411101','市辖区','197','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1989','411102','源汇区','197','0','0','Yuanhui Qu','YHI');
INSERT INTO `on_region` VALUES ('1990','411103','郾城区','197','0','0','Yancheng Qu','2');
INSERT INTO `on_region` VALUES ('1991','411104','召陵区','197','0','0','Zhaoling Qu','2');
INSERT INTO `on_region` VALUES ('1992','411121','舞阳县','197','0','0','Wuyang Xian','WYG');
INSERT INTO `on_region` VALUES ('1993','411122','临颍县','197','0','0','Linying Xian','LNY');
INSERT INTO `on_region` VALUES ('1994','411201','市辖区','198','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('1995','411202','湖滨区','198','0','0','Hubin Qu','HBI');
INSERT INTO `on_region` VALUES ('1996','411221','渑池县','198','0','0','Mianchi Xian','MCI');
INSERT INTO `on_region` VALUES ('1997','411222','陕县','198','0','0','Shan Xian','SHX');
INSERT INTO `on_region` VALUES ('1998','411224','卢氏县','198','0','0','Lushi Xian','LUU');
INSERT INTO `on_region` VALUES ('1999','411281','义马市','198','0','0','Yima Shi','YMA');
INSERT INTO `on_region` VALUES ('2000','411282','灵宝市','198','0','0','Lingbao Shi','LBS');
INSERT INTO `on_region` VALUES ('2001','411301','市辖区','199','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2002','411302','宛城区','199','0','0','Wancheng Qu','WCN');
INSERT INTO `on_region` VALUES ('2003','411303','卧龙区','199','0','0','Wolong Qu','WOL');
INSERT INTO `on_region` VALUES ('2004','411321','南召县','199','0','0','Nanzhao Xian','NZO');
INSERT INTO `on_region` VALUES ('2005','411322','方城县','199','0','0','Fangcheng Xian','FCX');
INSERT INTO `on_region` VALUES ('2006','411323','西峡县','199','0','0','Xixia Xian','XXY');
INSERT INTO `on_region` VALUES ('2007','411324','镇平县','199','0','0','Zhenping Xian','ZPX');
INSERT INTO `on_region` VALUES ('2008','411325','内乡县','199','0','0','Neixiang Xian','NXG');
INSERT INTO `on_region` VALUES ('2009','411326','淅川县','199','0','0','Xichuan Xian','XCY');
INSERT INTO `on_region` VALUES ('2010','411327','社旗县','199','0','0','Sheqi Xian','SEQ');
INSERT INTO `on_region` VALUES ('2011','411328','唐河县','199','0','0','Tanghe Xian','TGH');
INSERT INTO `on_region` VALUES ('2012','411329','新野县','199','0','0','Xinye Xian','XYE');
INSERT INTO `on_region` VALUES ('2013','411330','桐柏县','199','0','0','Tongbai Xian','TBX');
INSERT INTO `on_region` VALUES ('2014','411381','邓州市','199','0','0','Dengzhou Shi','DGZ');
INSERT INTO `on_region` VALUES ('2015','411401','市辖区','200','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2016','411402','梁园区','200','0','0','Liangyuan Qu','LYY');
INSERT INTO `on_region` VALUES ('2017','411403','睢阳区','200','0','0','Suiyang Qu','SYA');
INSERT INTO `on_region` VALUES ('2018','411421','民权县','200','0','0','Minquan Xian','MQY');
INSERT INTO `on_region` VALUES ('2019','411422','睢县','200','0','0','Sui Xian','SUI');
INSERT INTO `on_region` VALUES ('2020','411423','宁陵县','200','0','0','Ningling Xian','NGL');
INSERT INTO `on_region` VALUES ('2021','411424','柘城县','200','0','0','Zhecheng Xian','ZHC');
INSERT INTO `on_region` VALUES ('2022','411425','虞城县','200','0','0','Yucheng Xian','YUC');
INSERT INTO `on_region` VALUES ('2023','411426','夏邑县','200','0','0','Xiayi Xian','XAY');
INSERT INTO `on_region` VALUES ('2024','411481','永城市','200','0','0','Yongcheng Shi','YOC');
INSERT INTO `on_region` VALUES ('2025','411501','市辖区','201','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2026','411502','浉河区','201','0','0','Shihe Qu','SHU');
INSERT INTO `on_region` VALUES ('2027','411503','平桥区','201','0','0','Pingqiao Qu','PQQ');
INSERT INTO `on_region` VALUES ('2028','411521','罗山县','201','0','0','Luoshan Xian','LSE');
INSERT INTO `on_region` VALUES ('2029','411522','光山县','201','0','0','Guangshan Xian','GSX');
INSERT INTO `on_region` VALUES ('2030','411523','新县','201','0','0','Xin Xian','XXI');
INSERT INTO `on_region` VALUES ('2031','411524','商城县','201','0','0','Shangcheng Xian','SCX');
INSERT INTO `on_region` VALUES ('2032','411525','固始县','201','0','0','Gushi Xian','GSI');
INSERT INTO `on_region` VALUES ('2033','411526','潢川县','201','0','0','Huangchuan Xian','HCU');
INSERT INTO `on_region` VALUES ('2034','411527','淮滨县','201','0','0','Huaibin Xian','HBN');
INSERT INTO `on_region` VALUES ('2035','411528','息县','201','0','0','Xi Xian','XIX');
INSERT INTO `on_region` VALUES ('2036','411601','市辖区','202','0','0','1','2');
INSERT INTO `on_region` VALUES ('2037','411602','川汇区','202','0','0','Chuanhui Qu','2');
INSERT INTO `on_region` VALUES ('2038','411621','扶沟县','202','0','0','Fugou Xian','2');
INSERT INTO `on_region` VALUES ('2039','411622','西华县','202','0','0','Xihua Xian','2');
INSERT INTO `on_region` VALUES ('2040','411623','商水县','202','0','0','Shangshui Xian','2');
INSERT INTO `on_region` VALUES ('2041','411624','沈丘县','202','0','0','Shenqiu Xian','2');
INSERT INTO `on_region` VALUES ('2042','411625','郸城县','202','0','0','Dancheng Xian','2');
INSERT INTO `on_region` VALUES ('2043','411626','淮阳县','202','0','0','Huaiyang Xian','2');
INSERT INTO `on_region` VALUES ('2044','411627','太康县','202','0','0','Taikang Xian','2');
INSERT INTO `on_region` VALUES ('2045','411628','鹿邑县','202','0','0','Luyi Xian','2');
INSERT INTO `on_region` VALUES ('2046','411681','项城市','202','0','0','Xiangcheng Shi','2');
INSERT INTO `on_region` VALUES ('2047','411701','市辖区','203','0','0','1','2');
INSERT INTO `on_region` VALUES ('2048','411702','驿城区','203','0','0','Yicheng Qu','2');
INSERT INTO `on_region` VALUES ('2049','411721','西平县','203','0','0','Xiping Xian','2');
INSERT INTO `on_region` VALUES ('2050','411722','上蔡县','203','0','0','Shangcai Xian','2');
INSERT INTO `on_region` VALUES ('2051','411723','平舆县','203','0','0','Pingyu Xian','2');
INSERT INTO `on_region` VALUES ('2052','411724','正阳县','203','0','0','Zhengyang Xian','2');
INSERT INTO `on_region` VALUES ('2053','411725','确山县','203','0','0','Queshan Xian','2');
INSERT INTO `on_region` VALUES ('2054','411726','泌阳县','203','0','0','Biyang Xian','2');
INSERT INTO `on_region` VALUES ('2055','411727','汝南县','203','0','0','Runan Xian','2');
INSERT INTO `on_region` VALUES ('2056','411728','遂平县','203','0','0','Suiping Xian','2');
INSERT INTO `on_region` VALUES ('2057','411729','新蔡县','203','0','0','Xincai Xian','2');
INSERT INTO `on_region` VALUES ('2058','420101','市辖区','204','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2059','420102','江岸区','204','0','0','Jiang,an Qu','JAA');
INSERT INTO `on_region` VALUES ('2060','420103','江汉区','204','0','0','Jianghan Qu','JHN');
INSERT INTO `on_region` VALUES ('2061','420104','硚口区','204','0','0','Qiaokou Qu','QKQ');
INSERT INTO `on_region` VALUES ('2062','420105','汉阳区','204','0','0','Hanyang Qu','HYA');
INSERT INTO `on_region` VALUES ('2063','420106','武昌区','204','0','0','Wuchang Qu','WCQ');
INSERT INTO `on_region` VALUES ('2064','420107','青山区','204','0','0','Qingshan Qu','QSN');
INSERT INTO `on_region` VALUES ('2065','420111','洪山区','204','0','0','Hongshan Qu','HSQ');
INSERT INTO `on_region` VALUES ('2066','420112','东西湖区','204','0','0','Dongxihu Qu','DXH');
INSERT INTO `on_region` VALUES ('2067','420113','汉南区','204','0','0','Hannan Qu','HNQ');
INSERT INTO `on_region` VALUES ('2068','420114','蔡甸区','204','0','0','Caidian Qu','CDN');
INSERT INTO `on_region` VALUES ('2069','420115','江夏区','204','0','0','Jiangxia Qu','JXQ');
INSERT INTO `on_region` VALUES ('2070','420116','黄陂区','204','0','0','Huangpi Qu','HPI');
INSERT INTO `on_region` VALUES ('2071','420117','新洲区','204','0','0','Xinzhou Qu','XNZ');
INSERT INTO `on_region` VALUES ('2072','420201','市辖区','205','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2073','420202','黄石港区','205','0','0','Huangshigang Qu','HSG');
INSERT INTO `on_region` VALUES ('2074','420203','西塞山区','205','0','0','Xisaishan Qu','2');
INSERT INTO `on_region` VALUES ('2075','420204','下陆区','205','0','0','Xialu Qu','XAL');
INSERT INTO `on_region` VALUES ('2076','420205','铁山区','205','0','0','Tieshan Qu','TSH');
INSERT INTO `on_region` VALUES ('2077','420222','阳新县','205','0','0','Yangxin Xian','YXE');
INSERT INTO `on_region` VALUES ('2078','420281','大冶市','205','0','0','Daye Shi','DYE');
INSERT INTO `on_region` VALUES ('2079','420301','市辖区','206','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2080','420302','茅箭区','206','0','0','Maojian Qu','MJN');
INSERT INTO `on_region` VALUES ('2081','420303','张湾区','206','0','0','Zhangwan Qu','ZWQ');
INSERT INTO `on_region` VALUES ('2082','420321','郧县','206','0','0','Yun Xian','YUN');
INSERT INTO `on_region` VALUES ('2083','420322','郧西县','206','0','0','Yunxi Xian','YNX');
INSERT INTO `on_region` VALUES ('2084','420323','竹山县','206','0','0','Zhushan Xian','ZHS');
INSERT INTO `on_region` VALUES ('2085','420324','竹溪县','206','0','0','Zhuxi Xian','ZXX');
INSERT INTO `on_region` VALUES ('2086','420325','房县','206','0','0','Fang Xian','FAG');
INSERT INTO `on_region` VALUES ('2087','420381','丹江口市','206','0','0','Danjiangkou Shi','DJK');
INSERT INTO `on_region` VALUES ('2088','420501','市辖区','207','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2089','420502','西陵区','207','0','0','Xiling Qu','XLQ');
INSERT INTO `on_region` VALUES ('2090','420503','伍家岗区','207','0','0','Wujiagang Qu','WJG');
INSERT INTO `on_region` VALUES ('2091','420504','点军区','207','0','0','Dianjun Qu','DJN');
INSERT INTO `on_region` VALUES ('2092','420505','猇亭区','207','0','0','Xiaoting Qu','XTQ');
INSERT INTO `on_region` VALUES ('2093','420506','夷陵区','207','0','0','Yiling Qu','2');
INSERT INTO `on_region` VALUES ('2094','420525','远安县','207','0','0','Yuan,an Xian','YAX');
INSERT INTO `on_region` VALUES ('2095','420526','兴山县','207','0','0','Xingshan Xian','XSX');
INSERT INTO `on_region` VALUES ('2096','420527','秭归县','207','0','0','Zigui Xian','ZGI');
INSERT INTO `on_region` VALUES ('2097','420528','长阳土家族自治县','207','0','0','Changyang Tujiazu Zizhixian','CYA');
INSERT INTO `on_region` VALUES ('2098','420529','五峰土家族自治县','207','0','0','Wufeng Tujiazu Zizhixian','WFG');
INSERT INTO `on_region` VALUES ('2099','420581','宜都市','207','0','0','Yidu Shi','YID');
INSERT INTO `on_region` VALUES ('2100','420582','当阳市','207','0','0','Dangyang Shi','DYS');
INSERT INTO `on_region` VALUES ('2101','420583','枝江市','207','0','0','Zhijiang Shi','ZIJ');
INSERT INTO `on_region` VALUES ('2102','420601','市辖区','208','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2103','420602','襄城区','208','0','0','Xiangcheng Qu','XXF');
INSERT INTO `on_region` VALUES ('2104','420606','樊城区','208','0','0','Fancheng Qu','FNC');
INSERT INTO `on_region` VALUES ('2105','420607','襄阳区','208','0','0','Xiangyang Qu','2');
INSERT INTO `on_region` VALUES ('2106','420624','南漳县','208','0','0','Nanzhang Xian','NZH');
INSERT INTO `on_region` VALUES ('2107','420625','谷城县','208','0','0','Gucheng Xian','GUC');
INSERT INTO `on_region` VALUES ('2108','420626','保康县','208','0','0','Baokang Xian','BKG');
INSERT INTO `on_region` VALUES ('2109','420682','老河口市','208','0','0','Laohekou Shi','LHK');
INSERT INTO `on_region` VALUES ('2110','420683','枣阳市','208','0','0','Zaoyang Shi','ZOY');
INSERT INTO `on_region` VALUES ('2111','420684','宜城市','208','0','0','Yicheng Shi','YCW');
INSERT INTO `on_region` VALUES ('2112','420701','市辖区','209','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2113','420702','梁子湖区','209','0','0','Liangzihu Qu','LZI');
INSERT INTO `on_region` VALUES ('2114','420703','华容区','209','0','0','Huarong Qu','HRQ');
INSERT INTO `on_region` VALUES ('2115','420704','鄂城区','209','0','0','Echeng Qu','ECQ');
INSERT INTO `on_region` VALUES ('2116','420801','市辖区','210','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2117','420802','东宝区','210','0','0','Dongbao Qu','DBQ');
INSERT INTO `on_region` VALUES ('2118','420804','掇刀区','210','0','0','Duodao Qu','2');
INSERT INTO `on_region` VALUES ('2119','420821','京山县','210','0','0','Jingshan Xian','JSA');
INSERT INTO `on_region` VALUES ('2120','420822','沙洋县','210','0','0','Shayang Xian','SYF');
INSERT INTO `on_region` VALUES ('2121','420881','钟祥市','210','0','0','Zhongxiang Shi','2');
INSERT INTO `on_region` VALUES ('2122','420901','市辖区','211','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2123','420902','孝南区','211','0','0','Xiaonan Qu','XNA');
INSERT INTO `on_region` VALUES ('2124','420921','孝昌县','211','0','0','Xiaochang Xian','XOC');
INSERT INTO `on_region` VALUES ('2125','420922','大悟县','211','0','0','Dawu Xian','DWU');
INSERT INTO `on_region` VALUES ('2126','420923','云梦县','211','0','0','Yunmeng Xian','YMX');
INSERT INTO `on_region` VALUES ('2127','420981','应城市','211','0','0','Yingcheng Shi','YCG');
INSERT INTO `on_region` VALUES ('2128','420982','安陆市','211','0','0','Anlu Shi','ALU');
INSERT INTO `on_region` VALUES ('2129','420984','汉川市','211','0','0','Hanchuan Shi','HCH');
INSERT INTO `on_region` VALUES ('2130','421001','市辖区','212','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2131','421002','沙市区','212','0','0','Shashi Qu','SSJ');
INSERT INTO `on_region` VALUES ('2132','421003','荆州区','212','0','0','Jingzhou Qu','JZQ');
INSERT INTO `on_region` VALUES ('2133','421022','公安县','212','0','0','Gong,an Xian','GGA');
INSERT INTO `on_region` VALUES ('2134','421023','监利县','212','0','0','Jianli Xian','JLI');
INSERT INTO `on_region` VALUES ('2135','421024','江陵县','212','0','0','Jiangling Xian','JLX');
INSERT INTO `on_region` VALUES ('2136','421081','石首市','212','0','0','Shishou Shi','SSO');
INSERT INTO `on_region` VALUES ('2137','421083','洪湖市','212','0','0','Honghu Shi','HHU');
INSERT INTO `on_region` VALUES ('2138','421087','松滋市','212','0','0','Songzi Shi','SZF');
INSERT INTO `on_region` VALUES ('2139','421101','市辖区','213','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2140','421102','黄州区','213','0','0','Huangzhou Qu','HZC');
INSERT INTO `on_region` VALUES ('2141','421121','团风县','213','0','0','Tuanfeng Xian','TFG');
INSERT INTO `on_region` VALUES ('2142','421122','红安县','213','0','0','Hong,an Xian','HGA');
INSERT INTO `on_region` VALUES ('2143','421123','罗田县','213','0','0','Luotian Xian','LTE');
INSERT INTO `on_region` VALUES ('2144','421124','英山县','213','0','0','Yingshan Xian','YSE');
INSERT INTO `on_region` VALUES ('2145','421125','浠水县','213','0','0','Xishui Xian','XSE');
INSERT INTO `on_region` VALUES ('2146','421126','蕲春县','213','0','0','Qichun Xian','QCN');
INSERT INTO `on_region` VALUES ('2147','421127','黄梅县','213','0','0','Huangmei Xian','HGM');
INSERT INTO `on_region` VALUES ('2148','421181','麻城市','213','0','0','Macheng Shi','MCS');
INSERT INTO `on_region` VALUES ('2149','421182','武穴市','213','0','0','Wuxue Shi','WXE');
INSERT INTO `on_region` VALUES ('2150','421201','市辖区','214','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2151','421202','咸安区','214','0','0','Xian,an Qu','XAN');
INSERT INTO `on_region` VALUES ('2152','421221','嘉鱼县','214','0','0','Jiayu Xian','JYX');
INSERT INTO `on_region` VALUES ('2153','421222','通城县','214','0','0','Tongcheng Xian','TCX');
INSERT INTO `on_region` VALUES ('2154','421223','崇阳县','214','0','0','Chongyang Xian','CGY');
INSERT INTO `on_region` VALUES ('2155','421224','通山县','214','0','0','Tongshan Xian','TSA');
INSERT INTO `on_region` VALUES ('2156','421281','赤壁市','214','0','0','Chibi Shi','CBI');
INSERT INTO `on_region` VALUES ('2157','421301','市辖区','215','0','0','1','2');
INSERT INTO `on_region` VALUES ('2158','421303','曾都区','215','0','0','Zengdu Qu','2');
INSERT INTO `on_region` VALUES ('2159','421381','广水市','215','0','0','Guangshui Shi','2');
INSERT INTO `on_region` VALUES ('2160','422801','恩施市','216','0','0','Enshi Shi','ESS');
INSERT INTO `on_region` VALUES ('2161','422802','利川市','216','0','0','Lichuan Shi','LCE');
INSERT INTO `on_region` VALUES ('2162','422822','建始县','216','0','0','Jianshi Xian','JSE');
INSERT INTO `on_region` VALUES ('2163','422823','巴东县','216','0','0','Badong Xian','BDG');
INSERT INTO `on_region` VALUES ('2164','422825','宣恩县','216','0','0','Xuan,en Xian','XEN');
INSERT INTO `on_region` VALUES ('2165','422826','咸丰县','216','0','0','Xianfeng Xian','XFG');
INSERT INTO `on_region` VALUES ('2166','422827','来凤县','216','0','0','Laifeng Xian','LFG');
INSERT INTO `on_region` VALUES ('2167','422828','鹤峰县','216','0','0','Hefeng Xian','HEF');
INSERT INTO `on_region` VALUES ('2168','429004','仙桃市','217','0','0','Xiantao Shi','XNT');
INSERT INTO `on_region` VALUES ('2169','429005','潜江市','217','0','0','Qianjiang Shi','QNJ');
INSERT INTO `on_region` VALUES ('2170','429006','天门市','217','0','0','Tianmen Shi','TMS');
INSERT INTO `on_region` VALUES ('2171','429021','神农架林区','217','0','0','Shennongjia Linqu','SNJ');
INSERT INTO `on_region` VALUES ('2172','430101','市辖区','218','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2173','430102','芙蓉区','218','0','0','Furong Qu','FRQ');
INSERT INTO `on_region` VALUES ('2174','430103','天心区','218','0','0','Tianxin Qu','TXQ');
INSERT INTO `on_region` VALUES ('2175','430104','岳麓区','218','0','0','Yuelu Qu','YLU');
INSERT INTO `on_region` VALUES ('2176','430105','开福区','218','0','0','Kaifu Qu','KFQ');
INSERT INTO `on_region` VALUES ('2177','430111','雨花区','218','0','0','Yuhua Qu','YHA');
INSERT INTO `on_region` VALUES ('2178','430121','长沙县','218','0','0','Changsha Xian','CSA');
INSERT INTO `on_region` VALUES ('2179','430122','望城县','218','0','0','Wangcheng Xian','WCH');
INSERT INTO `on_region` VALUES ('2180','430124','宁乡县','218','0','0','Ningxiang Xian','NXX');
INSERT INTO `on_region` VALUES ('2181','430181','浏阳市','218','0','0','Liuyang Shi','LYS');
INSERT INTO `on_region` VALUES ('2182','430201','市辖区','219','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2183','430202','荷塘区','219','0','0','Hetang Qu','HTZ');
INSERT INTO `on_region` VALUES ('2184','430203','芦淞区','219','0','0','Lusong Qu','LZZ');
INSERT INTO `on_region` VALUES ('2185','430204','石峰区','219','0','0','Shifeng Qu','SFG');
INSERT INTO `on_region` VALUES ('2186','430211','天元区','219','0','0','Tianyuan Qu','TYQ');
INSERT INTO `on_region` VALUES ('2187','430221','株洲县','219','0','0','Zhuzhou Xian','ZZX');
INSERT INTO `on_region` VALUES ('2188','430223','攸县','219','0','0','You Xian','YOU');
INSERT INTO `on_region` VALUES ('2189','430224','茶陵县','219','0','0','Chaling Xian','CAL');
INSERT INTO `on_region` VALUES ('2190','430225','炎陵县','219','0','0','Yanling Xian','YLX');
INSERT INTO `on_region` VALUES ('2191','430281','醴陵市','219','0','0','Liling Shi','LIL');
INSERT INTO `on_region` VALUES ('2192','430301','市辖区','220','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2193','430302','雨湖区','220','0','0','Yuhu Qu','YHU');
INSERT INTO `on_region` VALUES ('2194','430304','岳塘区','220','0','0','Yuetang Qu','YTG');
INSERT INTO `on_region` VALUES ('2195','430321','湘潭县','220','0','0','Xiangtan Qu','XTX');
INSERT INTO `on_region` VALUES ('2196','430381','湘乡市','220','0','0','Xiangxiang Shi','XXG');
INSERT INTO `on_region` VALUES ('2197','430382','韶山市','220','0','0','Shaoshan Shi','SSN');
INSERT INTO `on_region` VALUES ('2198','430401','市辖区','221','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2199','430405','珠晖区','221','0','0','Zhuhui Qu','2');
INSERT INTO `on_region` VALUES ('2200','430406','雁峰区','221','0','0','Yanfeng Qu','2');
INSERT INTO `on_region` VALUES ('2201','430407','石鼓区','221','0','0','Shigu Qu','2');
INSERT INTO `on_region` VALUES ('2202','430408','蒸湘区','221','0','0','Zhengxiang Qu','2');
INSERT INTO `on_region` VALUES ('2203','430412','南岳区','221','0','0','Nanyue Qu','NYQ');
INSERT INTO `on_region` VALUES ('2204','430421','衡阳县','221','0','0','Hengyang Xian','HYO');
INSERT INTO `on_region` VALUES ('2205','430422','衡南县','221','0','0','Hengnan Xian','HNX');
INSERT INTO `on_region` VALUES ('2206','430423','衡山县','221','0','0','Hengshan Xian','HSH');
INSERT INTO `on_region` VALUES ('2207','430424','衡东县','221','0','0','Hengdong Xian','HED');
INSERT INTO `on_region` VALUES ('2208','430426','祁东县','221','0','0','Qidong Xian','QDX');
INSERT INTO `on_region` VALUES ('2209','430481','耒阳市','221','0','0','Leiyang Shi','LEY');
INSERT INTO `on_region` VALUES ('2210','430482','常宁市','221','0','0','Changning Shi','CNS');
INSERT INTO `on_region` VALUES ('2211','430501','市辖区','222','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2212','430502','双清区','222','0','0','Shuangqing Qu','SGQ');
INSERT INTO `on_region` VALUES ('2213','430503','大祥区','222','0','0','Daxiang Qu','DXS');
INSERT INTO `on_region` VALUES ('2214','430511','北塔区','222','0','0','Beita Qu','BET');
INSERT INTO `on_region` VALUES ('2215','430521','邵东县','222','0','0','Shaodong Xian','SDG');
INSERT INTO `on_region` VALUES ('2216','430522','新邵县','222','0','0','Xinshao Xian','XSO');
INSERT INTO `on_region` VALUES ('2217','430523','邵阳县','222','0','0','Shaoyang Xian','SYW');
INSERT INTO `on_region` VALUES ('2218','430524','隆回县','222','0','0','Longhui Xian','LGH');
INSERT INTO `on_region` VALUES ('2219','430525','洞口县','222','0','0','Dongkou Xian','DGK');
INSERT INTO `on_region` VALUES ('2220','430527','绥宁县','222','0','0','Suining Xian','SNX');
INSERT INTO `on_region` VALUES ('2221','430528','新宁县','222','0','0','Xinning Xian','XNI');
INSERT INTO `on_region` VALUES ('2222','430529','城步苗族自治县','222','0','0','Chengbu Miaozu Zizhixian','CBU');
INSERT INTO `on_region` VALUES ('2223','430581','武冈市','222','0','0','Wugang Shi','WGS');
INSERT INTO `on_region` VALUES ('2224','430601','市辖区','223','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2225','430602','岳阳楼区','223','0','0','Yueyanglou Qu','YYL');
INSERT INTO `on_region` VALUES ('2226','430603','云溪区','223','0','0','Yunxi Qu','YXI');
INSERT INTO `on_region` VALUES ('2227','430611','君山区','223','0','0','Junshan Qu','JUS');
INSERT INTO `on_region` VALUES ('2228','430621','岳阳县','223','0','0','Yueyang Xian','YYX');
INSERT INTO `on_region` VALUES ('2229','430623','华容县','223','0','0','Huarong Xian','HRG');
INSERT INTO `on_region` VALUES ('2230','430624','湘阴县','223','0','0','Xiangyin Xian','XYN');
INSERT INTO `on_region` VALUES ('2231','430626','平江县','223','0','0','Pingjiang Xian','PJH');
INSERT INTO `on_region` VALUES ('2232','430681','汨罗市','223','0','0','Miluo Shi','MLU');
INSERT INTO `on_region` VALUES ('2233','430682','临湘市','223','0','0','Linxiang Shi','LXY');
INSERT INTO `on_region` VALUES ('2234','430701','市辖区','224','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2235','430702','武陵区','224','0','0','Wuling Qu','WLQ');
INSERT INTO `on_region` VALUES ('2236','430703','鼎城区','224','0','0','Dingcheng Qu','DCE');
INSERT INTO `on_region` VALUES ('2237','430721','安乡县','224','0','0','Anxiang Xian','AXG');
INSERT INTO `on_region` VALUES ('2238','430722','汉寿县','224','0','0','Hanshou Xian','HSO');
INSERT INTO `on_region` VALUES ('2239','430723','澧县','224','0','0','Li Xian','LXX');
INSERT INTO `on_region` VALUES ('2240','430724','临澧县','224','0','0','Linli Xian','LNL');
INSERT INTO `on_region` VALUES ('2241','430725','桃源县','224','0','0','Taoyuan Xian','TOY');
INSERT INTO `on_region` VALUES ('2242','430726','石门县','224','0','0','Shimen Xian','SHM');
INSERT INTO `on_region` VALUES ('2243','430781','津市市','224','0','0','Jinshi Shi','JSS');
INSERT INTO `on_region` VALUES ('2244','430801','市辖区','225','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2245','430802','永定区','225','0','0','Yongding Qu','YDQ');
INSERT INTO `on_region` VALUES ('2246','430811','武陵源区','225','0','0','Wulingyuan Qu','WLY');
INSERT INTO `on_region` VALUES ('2247','430821','慈利县','225','0','0','Cili Xian','CLI');
INSERT INTO `on_region` VALUES ('2248','430822','桑植县','225','0','0','Sangzhi Xian','SZT');
INSERT INTO `on_region` VALUES ('2249','430901','市辖区','226','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2250','430902','资阳区','226','0','0','Ziyang Qu','ZYC');
INSERT INTO `on_region` VALUES ('2251','430903','赫山区','226','0','0','Heshan Qu','HSY');
INSERT INTO `on_region` VALUES ('2252','430921','南县','226','0','0','Nan Xian','NXN');
INSERT INTO `on_region` VALUES ('2253','430922','桃江县','226','0','0','Taojiang Xian','TJG');
INSERT INTO `on_region` VALUES ('2254','430923','安化县','226','0','0','Anhua Xian','ANH');
INSERT INTO `on_region` VALUES ('2255','430981','沅江市','226','0','0','Yuanjiang Shi','YJS');
INSERT INTO `on_region` VALUES ('2256','431001','市辖区','227','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2257','431002','北湖区','227','0','0','Beihu Qu','BHQ');
INSERT INTO `on_region` VALUES ('2258','431003','苏仙区','227','0','0','Suxian Qu','2');
INSERT INTO `on_region` VALUES ('2259','431021','桂阳县','227','0','0','Guiyang Xian','GYX');
INSERT INTO `on_region` VALUES ('2260','431022','宜章县','227','0','0','yizhang Xian','YZA');
INSERT INTO `on_region` VALUES ('2261','431023','永兴县','227','0','0','Yongxing Xian','YXX');
INSERT INTO `on_region` VALUES ('2262','431024','嘉禾县','227','0','0','Jiahe Xian','JAH');
INSERT INTO `on_region` VALUES ('2263','431025','临武县','227','0','0','Linwu Xian','LWX');
INSERT INTO `on_region` VALUES ('2264','431026','汝城县','227','0','0','Rucheng Xian','RCE');
INSERT INTO `on_region` VALUES ('2265','431027','桂东县','227','0','0','Guidong Xian','GDO');
INSERT INTO `on_region` VALUES ('2266','431028','安仁县','227','0','0','Anren Xian','ARN');
INSERT INTO `on_region` VALUES ('2267','431081','资兴市','227','0','0','Zixing Shi','ZXG');
INSERT INTO `on_region` VALUES ('2268','431101','市辖区','228','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2270','431103','冷水滩区','228','0','0','Lengshuitan Qu','LST');
INSERT INTO `on_region` VALUES ('2271','431121','祁阳县','228','0','0','Qiyang Xian','QJY');
INSERT INTO `on_region` VALUES ('2272','431122','东安县','228','0','0','Dong,an Xian','DOA');
INSERT INTO `on_region` VALUES ('2273','431123','双牌县','228','0','0','Shuangpai Xian','SPA');
INSERT INTO `on_region` VALUES ('2274','431124','道县','228','0','0','Dao Xian','DAO');
INSERT INTO `on_region` VALUES ('2275','431125','江永县','228','0','0','Jiangyong Xian','JYD');
INSERT INTO `on_region` VALUES ('2276','431126','宁远县','228','0','0','Ningyuan Xian','NYN');
INSERT INTO `on_region` VALUES ('2277','431127','蓝山县','228','0','0','Lanshan Xian','LNS');
INSERT INTO `on_region` VALUES ('2278','431128','新田县','228','0','0','Xintian Xian','XTN');
INSERT INTO `on_region` VALUES ('2279','431129','江华瑶族自治县','228','0','0','Jianghua Yaozu Zizhixian','JHX');
INSERT INTO `on_region` VALUES ('2280','431201','市辖区','229','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2281','431202','鹤城区','229','0','0','Hecheng Qu','HCG');
INSERT INTO `on_region` VALUES ('2282','431221','中方县','229','0','0','Zhongfang Xian','ZFX');
INSERT INTO `on_region` VALUES ('2283','431222','沅陵县','229','0','0','Yuanling Xian','YNL');
INSERT INTO `on_region` VALUES ('2284','431223','辰溪县','229','0','0','Chenxi Xian','CXX');
INSERT INTO `on_region` VALUES ('2285','431224','溆浦县','229','0','0','Xupu Xian','XUP');
INSERT INTO `on_region` VALUES ('2286','431225','会同县','229','0','0','Huitong Xian','HTG');
INSERT INTO `on_region` VALUES ('2287','431226','麻阳苗族自治县','229','0','0','Mayang Miaozu Zizhixian','MYX');
INSERT INTO `on_region` VALUES ('2288','431227','新晃侗族自治县','229','0','0','Xinhuang Dongzu Zizhixian','XHD');
INSERT INTO `on_region` VALUES ('2289','431228','芷江侗族自治县','229','0','0','Zhijiang Dongzu Zizhixian','ZJX');
INSERT INTO `on_region` VALUES ('2290','431229','靖州苗族侗族自治县','229','0','0','Jingzhou Miaozu Dongzu Zizhixian','JZO');
INSERT INTO `on_region` VALUES ('2291','431230','通道侗族自治县','229','0','0','Tongdao Dongzu Zizhixian','TDD');
INSERT INTO `on_region` VALUES ('2292','431281','洪江市','229','0','0','Hongjiang Shi','HGJ');
INSERT INTO `on_region` VALUES ('2293','431301','市辖区','230','0','0','1','2');
INSERT INTO `on_region` VALUES ('2294','431302','娄星区','230','0','0','Louxing Qu','2');
INSERT INTO `on_region` VALUES ('2295','431321','双峰县','230','0','0','Shuangfeng Xian','2');
INSERT INTO `on_region` VALUES ('2296','431322','新化县','230','0','0','Xinhua Xian','2');
INSERT INTO `on_region` VALUES ('2297','431381','冷水江市','230','0','0','Lengshuijiang Shi','2');
INSERT INTO `on_region` VALUES ('2298','431382','涟源市','230','0','0','Lianyuan Shi','2');
INSERT INTO `on_region` VALUES ('2299','433101','吉首市','231','0','0','Jishou Shi','JSO');
INSERT INTO `on_region` VALUES ('2300','433122','泸溪县','231','0','0','Luxi Xian','LXW');
INSERT INTO `on_region` VALUES ('2301','433123','凤凰县','231','0','0','Fenghuang Xian','FHX');
INSERT INTO `on_region` VALUES ('2302','433124','花垣县','231','0','0','Huayuan Xian','HYH');
INSERT INTO `on_region` VALUES ('2303','433125','保靖县','231','0','0','Baojing Xian','BJG');
INSERT INTO `on_region` VALUES ('2304','433126','古丈县','231','0','0','Guzhang Xian','GZG');
INSERT INTO `on_region` VALUES ('2305','433127','永顺县','231','0','0','Yongshun Xian','YSF');
INSERT INTO `on_region` VALUES ('2306','433130','龙山县','231','0','0','Longshan Xian','LSR');
INSERT INTO `on_region` VALUES ('2307','440101','市辖区','232','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2308','440115','南沙区','232','0','0','Nansha Qu','2');
INSERT INTO `on_region` VALUES ('2309','440103','荔湾区','232','0','0','Liwan Qu','LWQ');
INSERT INTO `on_region` VALUES ('2310','440104','越秀区','232','0','0','Yuexiu Qu','YXU');
INSERT INTO `on_region` VALUES ('2311','440105','海珠区','232','0','0','Haizhu Qu','HZU');
INSERT INTO `on_region` VALUES ('2312','440106','天河区','232','0','0','Tianhe Qu','THQ');
INSERT INTO `on_region` VALUES ('2313','440116','萝岗区','232','0','0','Luogang Qu','2');
INSERT INTO `on_region` VALUES ('2314','440111','白云区','232','0','0','Baiyun Qu','BYN');
INSERT INTO `on_region` VALUES ('2315','440112','黄埔区','232','0','0','Huangpu Qu','HPU');
INSERT INTO `on_region` VALUES ('2316','440113','番禺区','232','0','0','Panyu Qu','PNY');
INSERT INTO `on_region` VALUES ('2317','440114','花都区','232','0','0','Huadu Qu','HDU');
INSERT INTO `on_region` VALUES ('2318','440183','增城市','232','0','0','Zengcheng Shi','ZEC');
INSERT INTO `on_region` VALUES ('2319','440184','从化市','232','0','0','Conghua Shi','CNH');
INSERT INTO `on_region` VALUES ('2320','440201','市辖区','233','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2321','440203','武江区','233','0','0','Wujiang Qu','WJQ');
INSERT INTO `on_region` VALUES ('2322','440204','浈江区','233','0','0','Zhenjiang Qu','ZJQ');
INSERT INTO `on_region` VALUES ('2323','440205','曲江区','233','0','0','Qujiang Qu','2');
INSERT INTO `on_region` VALUES ('2324','440222','始兴县','233','0','0','Shixing Xian','SXX');
INSERT INTO `on_region` VALUES ('2325','440224','仁化县','233','0','0','Renhua Xian','RHA');
INSERT INTO `on_region` VALUES ('2326','440229','翁源县','233','0','0','Wengyuan Xian','WYN');
INSERT INTO `on_region` VALUES ('2327','440232','乳源瑶族自治县','233','0','0','Ruyuan Yaozu Zizhixian','RYN');
INSERT INTO `on_region` VALUES ('2328','440233','新丰县','233','0','0','Xinfeng Xian','XFY');
INSERT INTO `on_region` VALUES ('2329','440281','乐昌市','233','0','0','Lechang Shi','LEC');
INSERT INTO `on_region` VALUES ('2330','440282','南雄市','233','0','0','Nanxiong Shi','NXS');
INSERT INTO `on_region` VALUES ('2331','440301','市辖区','234','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2332','440303','罗湖区','234','0','0','Luohu Qu','LHQ');
INSERT INTO `on_region` VALUES ('2333','440304','福田区','234','0','0','Futian Qu','FTN');
INSERT INTO `on_region` VALUES ('2334','440305','南山区','234','0','0','Nanshan Qu','NSN');
INSERT INTO `on_region` VALUES ('2335','440306','宝安区','234','0','0','Bao,an Qu','BAQ');
INSERT INTO `on_region` VALUES ('2336','440307','龙岗区','234','0','0','Longgang Qu','LGG');
INSERT INTO `on_region` VALUES ('2337','440308','盐田区','234','0','0','Yan Tian Qu','YTQ');
INSERT INTO `on_region` VALUES ('2338','440401','市辖区','235','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2339','440402','香洲区','235','0','0','Xiangzhou Qu','XZQ');
INSERT INTO `on_region` VALUES ('2340','440403','斗门区','235','0','0','Doumen Qu','DOU');
INSERT INTO `on_region` VALUES ('2341','440404','金湾区','235','0','0','Jinwan Qu','JW Q');
INSERT INTO `on_region` VALUES ('2342','440501','市辖区','236','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2343','440507','龙湖区','236','0','0','Longhu Qu','LHH');
INSERT INTO `on_region` VALUES ('2344','440511','金平区','236','0','0','Jinping Qu','JPQ');
INSERT INTO `on_region` VALUES ('2345','440512','濠江区','236','0','0','Haojiang Qu','HJ Q');
INSERT INTO `on_region` VALUES ('2346','440513','潮阳区','236','0','0','Chaoyang  Qu','CHY');
INSERT INTO `on_region` VALUES ('2347','440514','潮南区','236','0','0','Chaonan Qu','CN Q');
INSERT INTO `on_region` VALUES ('2348','440515','澄海区','236','0','0','Chenghai QU','CHS');
INSERT INTO `on_region` VALUES ('2349','440523','南澳县','236','0','0','Nan,ao Xian','NAN');
INSERT INTO `on_region` VALUES ('2350','440601','市辖区','237','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2351','440604','禅城区','237','0','0','Chancheng Qu','CC Q');
INSERT INTO `on_region` VALUES ('2352','440605','南海区','237','0','0','Nanhai Shi','NAH');
INSERT INTO `on_region` VALUES ('2353','440606','顺德区','237','0','0','Shunde Shi','SUD');
INSERT INTO `on_region` VALUES ('2354','440607','三水区','237','0','0','Sanshui Shi','SJQ');
INSERT INTO `on_region` VALUES ('2355','440608','高明区','237','0','0','Gaoming Shi','GOM');
INSERT INTO `on_region` VALUES ('2356','440701','市辖区','238','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2357','440703','蓬江区','238','0','0','Pengjiang Qu','PJJ');
INSERT INTO `on_region` VALUES ('2358','440704','江海区','238','0','0','Jianghai Qu','JHI');
INSERT INTO `on_region` VALUES ('2359','440705','新会区','238','0','0','Xinhui Shi','XIN');
INSERT INTO `on_region` VALUES ('2360','440781','台山市','238','0','0','Taishan Shi','TSS');
INSERT INTO `on_region` VALUES ('2361','440783','开平市','238','0','0','Kaiping Shi','KPS');
INSERT INTO `on_region` VALUES ('2362','440784','鹤山市','238','0','0','Heshan Shi','HES');
INSERT INTO `on_region` VALUES ('2363','440785','恩平市','238','0','0','Enping Shi','ENP');
INSERT INTO `on_region` VALUES ('2364','440801','市辖区','239','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2365','440802','赤坎区','239','0','0','Chikan Qu','CKQ');
INSERT INTO `on_region` VALUES ('2366','440803','霞山区','239','0','0','Xiashan Qu','XAS');
INSERT INTO `on_region` VALUES ('2367','440804','坡头区','239','0','0','Potou Qu','PTU');
INSERT INTO `on_region` VALUES ('2368','440811','麻章区','239','0','0','Mazhang Qu','MZQ');
INSERT INTO `on_region` VALUES ('2369','440823','遂溪县','239','0','0','Suixi Xian','SXI');
INSERT INTO `on_region` VALUES ('2370','440825','徐闻县','239','0','0','Xuwen Xian','XWN');
INSERT INTO `on_region` VALUES ('2371','440881','廉江市','239','0','0','Lianjiang Shi','LJS');
INSERT INTO `on_region` VALUES ('2372','440882','雷州市','239','0','0','Leizhou Shi','LEZ');
INSERT INTO `on_region` VALUES ('2373','440883','吴川市','239','0','0','Wuchuan Shi','WCS');
INSERT INTO `on_region` VALUES ('2374','440901','市辖区','240','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2375','440902','茂南区','240','0','0','Maonan Qu','MNQ');
INSERT INTO `on_region` VALUES ('2376','440903','茂港区','240','0','0','Maogang Qu','MGQ');
INSERT INTO `on_region` VALUES ('2377','440923','电白县','240','0','0','Dianbai Xian','DBI');
INSERT INTO `on_region` VALUES ('2378','440981','高州市','240','0','0','Gaozhou Shi','GZO');
INSERT INTO `on_region` VALUES ('2379','440982','化州市','240','0','0','Huazhou Shi','HZY');
INSERT INTO `on_region` VALUES ('2380','440983','信宜市','240','0','0','Xinyi Shi','XYY');
INSERT INTO `on_region` VALUES ('2381','441201','市辖区','241','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2382','441202','端州区','241','0','0','Duanzhou Qu','DZQ');
INSERT INTO `on_region` VALUES ('2383','441203','鼎湖区','241','0','0','Dinghu Qu','DGH');
INSERT INTO `on_region` VALUES ('2384','441223','广宁县','241','0','0','Guangning Xian','GNG');
INSERT INTO `on_region` VALUES ('2385','441224','怀集县','241','0','0','Huaiji Xian','HJX');
INSERT INTO `on_region` VALUES ('2386','441225','封开县','241','0','0','Fengkai Xian','FKX');
INSERT INTO `on_region` VALUES ('2387','441226','德庆县','241','0','0','Deqing Xian','DQY');
INSERT INTO `on_region` VALUES ('2388','441283','高要市','241','0','0','Gaoyao Xian','GYY');
INSERT INTO `on_region` VALUES ('2389','441284','四会市','241','0','0','Sihui Shi','SHI');
INSERT INTO `on_region` VALUES ('2390','441301','市辖区','242','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2391','441302','惠城区','242','0','0','Huicheng Qu','HCQ');
INSERT INTO `on_region` VALUES ('2392','441303','惠阳区','242','0','0','Huiyang Shi','HUY');
INSERT INTO `on_region` VALUES ('2393','441322','博罗县','242','0','0','Boluo Xian','BOL');
INSERT INTO `on_region` VALUES ('2394','441323','惠东县','242','0','0','Huidong Xian','HID');
INSERT INTO `on_region` VALUES ('2395','441324','龙门县','242','0','0','Longmen Xian','LMN');
INSERT INTO `on_region` VALUES ('2396','441401','市辖区','243','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2397','441402','梅江区','243','0','0','Meijiang Qu','MJQ');
INSERT INTO `on_region` VALUES ('2398','441421','梅县','243','0','0','Mei Xian','MEX');
INSERT INTO `on_region` VALUES ('2399','441422','大埔县','243','0','0','Dabu Xian','DBX');
INSERT INTO `on_region` VALUES ('2400','441423','丰顺县','243','0','0','Fengshun Xian','FES');
INSERT INTO `on_region` VALUES ('2401','441424','五华县','243','0','0','Wuhua Xian','WHY');
INSERT INTO `on_region` VALUES ('2402','441426','平远县','243','0','0','Pingyuan Xian','PYY');
INSERT INTO `on_region` VALUES ('2403','441427','蕉岭县','243','0','0','Jiaoling Xian','JOL');
INSERT INTO `on_region` VALUES ('2404','441481','兴宁市','243','0','0','Xingning Shi','XNG');
INSERT INTO `on_region` VALUES ('2405','441501','市辖区','244','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2406','441502','城区','244','0','0','Chengqu','CQS');
INSERT INTO `on_region` VALUES ('2407','441521','海丰县','244','0','0','Haifeng Xian','HIF');
INSERT INTO `on_region` VALUES ('2408','441523','陆河县','244','0','0','Luhe Xian','LHY');
INSERT INTO `on_region` VALUES ('2409','441581','陆丰市','244','0','0','Lufeng Shi','LUF');
INSERT INTO `on_region` VALUES ('2410','441601','市辖区','245','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2411','441602','源城区','245','0','0','Yuancheng Qu','YCQ');
INSERT INTO `on_region` VALUES ('2412','441621','紫金县','245','0','0','Zijin Xian','ZJY');
INSERT INTO `on_region` VALUES ('2413','441622','龙川县','245','0','0','Longchuan Xian','LCY');
INSERT INTO `on_region` VALUES ('2414','441623','连平县','245','0','0','Lianping Xian','LNP');
INSERT INTO `on_region` VALUES ('2415','441624','和平县','245','0','0','Heping Xian','HPY');
INSERT INTO `on_region` VALUES ('2416','441625','东源县','245','0','0','Dongyuan Xian','DYN');
INSERT INTO `on_region` VALUES ('2417','441701','市辖区','246','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2418','441702','江城区','246','0','0','Jiangcheng Qu','JCQ');
INSERT INTO `on_region` VALUES ('2419','441721','阳西县','246','0','0','Yangxi Xian','YXY');
INSERT INTO `on_region` VALUES ('2420','441723','阳东县','246','0','0','Yangdong Xian','YGD');
INSERT INTO `on_region` VALUES ('2421','441781','阳春市','246','0','0','Yangchun Shi','YCU');
INSERT INTO `on_region` VALUES ('2422','441801','市辖区','247','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2423','441802','清城区','247','0','0','Qingcheng Qu','QCQ');
INSERT INTO `on_region` VALUES ('2424','441821','佛冈县','247','0','0','Fogang Xian','FGY');
INSERT INTO `on_region` VALUES ('2425','441823','阳山县','247','0','0','Yangshan Xian','YSN');
INSERT INTO `on_region` VALUES ('2426','441825','连山壮族瑶族自治县','247','0','0','Lianshan Zhuangzu Yaozu Zizhixian','LSZ');
INSERT INTO `on_region` VALUES ('2427','441826','连南瑶族自治县','247','0','0','Liannanyaozuzizhi Qu','2');
INSERT INTO `on_region` VALUES ('2428','441827','清新县','247','0','0','Qingxin Xian','QGX');
INSERT INTO `on_region` VALUES ('2429','441881','英德市','247','0','0','Yingde Shi','YDS');
INSERT INTO `on_region` VALUES ('2430','441882','连州市','247','0','0','Lianzhou Shi','LZO');
INSERT INTO `on_region` VALUES ('2431','445101','市辖区','250','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2432','445102','湘桥区','250','0','0','Xiangqiao Qu','XQO');
INSERT INTO `on_region` VALUES ('2433','445121','潮安县','250','0','0','Chao,an Xian','CAY');
INSERT INTO `on_region` VALUES ('2434','445122','饶平县','250','0','0','Raoping Xian','RPG');
INSERT INTO `on_region` VALUES ('2435','445201','市辖区','251','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2436','445202','榕城区','251','0','0','Rongcheng Qu','RCH');
INSERT INTO `on_region` VALUES ('2437','445221','揭东县','251','0','0','Jiedong Xian','JDX');
INSERT INTO `on_region` VALUES ('2438','445222','揭西县','251','0','0','Jiexi Xian','JEX');
INSERT INTO `on_region` VALUES ('2439','445224','惠来县','251','0','0','Huilai Xian','HLY');
INSERT INTO `on_region` VALUES ('2440','445281','普宁市','251','0','0','Puning Shi','PNG');
INSERT INTO `on_region` VALUES ('2441','445301','市辖区','252','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2442','445302','云城区','252','0','0','Yuncheng Qu','YYF');
INSERT INTO `on_region` VALUES ('2443','445321','新兴县','252','0','0','Xinxing Xian','XNX');
INSERT INTO `on_region` VALUES ('2444','445322','郁南县','252','0','0','Yunan Xian','YNK');
INSERT INTO `on_region` VALUES ('2445','445323','云安县','252','0','0','Yun,an Xian','YUA');
INSERT INTO `on_region` VALUES ('2446','445381','罗定市','252','0','0','Luoding Shi','LUO');
INSERT INTO `on_region` VALUES ('2447','450101','市辖区','253','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2448','450102','兴宁区','253','0','0','Xingning Qu','XNE');
INSERT INTO `on_region` VALUES ('2449','450103','青秀区','253','0','0','Qingxiu Qu','2');
INSERT INTO `on_region` VALUES ('2450','450105','江南区','253','0','0','Jiangnan Qu','JNA');
INSERT INTO `on_region` VALUES ('2451','450107','西乡塘区','253','0','0','Xixiangtang Qu','2');
INSERT INTO `on_region` VALUES ('2452','450108','良庆区','253','0','0','Liangqing Qu','2');
INSERT INTO `on_region` VALUES ('2453','450109','邕宁区','253','0','0','Yongning Qu','2');
INSERT INTO `on_region` VALUES ('2454','450122','武鸣县','253','0','0','Wuming Xian','WMG');
INSERT INTO `on_region` VALUES ('2455','450123','隆安县','253','0','0','Long,an Xian','2');
INSERT INTO `on_region` VALUES ('2456','450124','马山县','253','0','0','Mashan Xian','2');
INSERT INTO `on_region` VALUES ('2457','450125','上林县','253','0','0','Shanglin Xian','2');
INSERT INTO `on_region` VALUES ('2458','450126','宾阳县','253','0','0','Binyang Xian','2');
INSERT INTO `on_region` VALUES ('2459','450127','横县','253','0','0','Heng Xian','2');
INSERT INTO `on_region` VALUES ('2460','450201','市辖区','254','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2461','450202','城中区','254','0','0','Chengzhong Qu','CZG');
INSERT INTO `on_region` VALUES ('2462','450203','鱼峰区','254','0','0','Yufeng Qu','YFQ');
INSERT INTO `on_region` VALUES ('2463','450204','柳南区','254','0','0','Liunan Qu','LNU');
INSERT INTO `on_region` VALUES ('2464','450205','柳北区','254','0','0','Liubei Qu','LBE');
INSERT INTO `on_region` VALUES ('2465','450221','柳江县','254','0','0','Liujiang Xian','LUJ');
INSERT INTO `on_region` VALUES ('2466','450222','柳城县','254','0','0','Liucheng Xian','LCB');
INSERT INTO `on_region` VALUES ('2467','450223','鹿寨县','254','0','0','Luzhai Xian','2');
INSERT INTO `on_region` VALUES ('2468','450224','融安县','254','0','0','Rong,an Xian','2');
INSERT INTO `on_region` VALUES ('2469','450225','融水苗族自治县','254','0','0','Rongshui Miaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2470','450226','三江侗族自治县','254','0','0','Sanjiang Dongzu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2471','450301','市辖区','255','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2472','450302','秀峰区','255','0','0','Xiufeng Qu','XUF');
INSERT INTO `on_region` VALUES ('2473','450303','叠彩区','255','0','0','Diecai Qu','DCA');
INSERT INTO `on_region` VALUES ('2474','450304','象山区','255','0','0','Xiangshan Qu','XSK');
INSERT INTO `on_region` VALUES ('2475','450305','七星区','255','0','0','Qixing Qu','QXG');
INSERT INTO `on_region` VALUES ('2476','450311','雁山区','255','0','0','Yanshan Qu','YSA');
INSERT INTO `on_region` VALUES ('2477','450321','阳朔县','255','0','0','Yangshuo Xian','YSO');
INSERT INTO `on_region` VALUES ('2478','450322','临桂县','255','0','0','Lingui Xian','LGI');
INSERT INTO `on_region` VALUES ('2479','450323','灵川县','255','0','0','Lingchuan Xian','LCU');
INSERT INTO `on_region` VALUES ('2480','450324','全州县','255','0','0','Quanzhou Xian','QZO');
INSERT INTO `on_region` VALUES ('2481','450325','兴安县','255','0','0','Xing,an Xian','XAG');
INSERT INTO `on_region` VALUES ('2482','450326','永福县','255','0','0','Yongfu Xian','YFU');
INSERT INTO `on_region` VALUES ('2483','450327','灌阳县','255','0','0','Guanyang Xian','GNY');
INSERT INTO `on_region` VALUES ('2484','450328','龙胜各族自治县','255','0','0','Longsheng Gezu Zizhixian','LSG');
INSERT INTO `on_region` VALUES ('2485','450329','资源县','255','0','0','Ziyuan Xian','ZYU');
INSERT INTO `on_region` VALUES ('2486','450330','平乐县','255','0','0','Pingle Xian','PLE');
INSERT INTO `on_region` VALUES ('2487','450331','荔蒲县','255','0','0','Lipu Xian','2');
INSERT INTO `on_region` VALUES ('2488','450332','恭城瑶族自治县','255','0','0','Gongcheng Yaozu Zizhixian','GGC');
INSERT INTO `on_region` VALUES ('2489','450401','市辖区','256','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2490','450403','万秀区','256','0','0','Wanxiu Qu','WXQ');
INSERT INTO `on_region` VALUES ('2491','450404','蝶山区','256','0','0','Dieshan Qu','DES');
INSERT INTO `on_region` VALUES ('2492','450405','长洲区','256','0','0','Changzhou Qu','2');
INSERT INTO `on_region` VALUES ('2493','450421','苍梧县','256','0','0','Cangwu Xian','CAW');
INSERT INTO `on_region` VALUES ('2494','450422','藤县','256','0','0','Teng Xian','2');
INSERT INTO `on_region` VALUES ('2495','450423','蒙山县','256','0','0','Mengshan Xian','MSA');
INSERT INTO `on_region` VALUES ('2496','450481','岑溪市','256','0','0','Cenxi Shi','CEX');
INSERT INTO `on_region` VALUES ('2497','450501','市辖区','257','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2498','450502','海城区','257','0','0','Haicheng Qu','HCB');
INSERT INTO `on_region` VALUES ('2499','450503','银海区','257','0','0','Yinhai Qu','YHB');
INSERT INTO `on_region` VALUES ('2500','450512','铁山港区','257','0','0','Tieshangangqu ','TSG');
INSERT INTO `on_region` VALUES ('2501','450521','合浦县','257','0','0','Hepu Xian','HPX');
INSERT INTO `on_region` VALUES ('2502','450601','市辖区','258','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2503','450602','港口区','258','0','0','Gangkou Qu','GKQ');
INSERT INTO `on_region` VALUES ('2504','450603','防城区','258','0','0','Fangcheng Qu','FCQ');
INSERT INTO `on_region` VALUES ('2505','450621','上思县','258','0','0','Shangsi Xian','SGS');
INSERT INTO `on_region` VALUES ('2506','450681','东兴市','258','0','0','Dongxing Shi','DOX');
INSERT INTO `on_region` VALUES ('2507','450701','市辖区','259','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2508','450702','钦南区','259','0','0','Qinnan Qu','QNQ');
INSERT INTO `on_region` VALUES ('2509','450703','钦北区','259','0','0','Qinbei Qu','QBQ');
INSERT INTO `on_region` VALUES ('2510','450721','灵山县','259','0','0','Lingshan Xian','LSB');
INSERT INTO `on_region` VALUES ('2511','450722','浦北县','259','0','0','Pubei Xian','PBE');
INSERT INTO `on_region` VALUES ('2512','450801','市辖区','260','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2513','450802','港北区','260','0','0','Gangbei Qu','GBE');
INSERT INTO `on_region` VALUES ('2514','450803','港南区','260','0','0','Gangnan Qu','GNQ');
INSERT INTO `on_region` VALUES ('2515','450804','覃塘区','260','0','0','Tantang Qu','2');
INSERT INTO `on_region` VALUES ('2516','450821','平南县','260','0','0','Pingnan Xian','PNN');
INSERT INTO `on_region` VALUES ('2517','450881','桂平市','260','0','0','Guiping Shi','GPS');
INSERT INTO `on_region` VALUES ('2518','450901','市辖区','261','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2519','450902','玉州区','261','0','0','Yuzhou Qu','YZO');
INSERT INTO `on_region` VALUES ('2520','450921','容县','261','0','0','Rong Xian','ROG');
INSERT INTO `on_region` VALUES ('2521','450922','陆川县','261','0','0','Luchuan Xian','LCJ');
INSERT INTO `on_region` VALUES ('2522','450923','博白县','261','0','0','Bobai Xian','BBA');
INSERT INTO `on_region` VALUES ('2523','450924','兴业县','261','0','0','Xingye Xian','XGY');
INSERT INTO `on_region` VALUES ('2524','450981','北流市','261','0','0','Beiliu Shi','BLS');
INSERT INTO `on_region` VALUES ('2525','451001','市辖区','262','0','0','1','2');
INSERT INTO `on_region` VALUES ('2526','451002','右江区','262','0','0','Youjiang Qu','2');
INSERT INTO `on_region` VALUES ('2527','451021','田阳县','262','0','0','Tianyang Xian','2');
INSERT INTO `on_region` VALUES ('2528','451022','田东县','262','0','0','Tiandong Xian','2');
INSERT INTO `on_region` VALUES ('2529','451023','平果县','262','0','0','Pingguo Xian','2');
INSERT INTO `on_region` VALUES ('2530','451024','德保县','262','0','0','Debao Xian','2');
INSERT INTO `on_region` VALUES ('2531','451025','靖西县','262','0','0','Jingxi Xian','2');
INSERT INTO `on_region` VALUES ('2532','451026','那坡县','262','0','0','Napo Xian','2');
INSERT INTO `on_region` VALUES ('2533','451027','凌云县','262','0','0','Lingyun Xian','2');
INSERT INTO `on_region` VALUES ('2534','451028','乐业县','262','0','0','Leye Xian','2');
INSERT INTO `on_region` VALUES ('2535','451029','田林县','262','0','0','Tianlin Xian','2');
INSERT INTO `on_region` VALUES ('2536','451030','西林县','262','0','0','Xilin Xian','2');
INSERT INTO `on_region` VALUES ('2537','451031','隆林各族自治县','262','0','0','Longlin Gezu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2538','451101','市辖区','263','0','0','1','2');
INSERT INTO `on_region` VALUES ('2539','451102','八步区','263','0','0','Babu Qu','2');
INSERT INTO `on_region` VALUES ('2540','451121','昭平县','263','0','0','Zhaoping Xian','2');
INSERT INTO `on_region` VALUES ('2541','451122','钟山县','263','0','0','Zhongshan Xian','2');
INSERT INTO `on_region` VALUES ('2542','451123','富川瑶族自治县','263','0','0','Fuchuan Yaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2543','451201','市辖区','264','0','0','1','2');
INSERT INTO `on_region` VALUES ('2544','451202','金城江区','264','0','0','Jinchengjiang Qu','2');
INSERT INTO `on_region` VALUES ('2545','451221','南丹县','264','0','0','Nandan Xian','2');
INSERT INTO `on_region` VALUES ('2546','451222','天峨县','264','0','0','Tian,e Xian','2');
INSERT INTO `on_region` VALUES ('2547','451223','凤山县','264','0','0','Fengshan Xian','2');
INSERT INTO `on_region` VALUES ('2548','451224','东兰县','264','0','0','Donglan Xian','2');
INSERT INTO `on_region` VALUES ('2549','451225','罗城仫佬族自治县','264','0','0','Luocheng Mulaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2550','451226','环江毛南族自治县','264','0','0','Huanjiang Maonanzu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2551','451227','巴马瑶族自治县','264','0','0','Bama Yaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2552','451228','都安瑶族自治县','264','0','0','Du,an Yaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2553','451229','大化瑶族自治县','264','0','0','Dahua Yaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2554','451281','宜州市','264','0','0','Yizhou Shi','2');
INSERT INTO `on_region` VALUES ('2555','451301','市辖区','265','0','0','1','2');
INSERT INTO `on_region` VALUES ('2556','451302','兴宾区','265','0','0','Xingbin Qu','2');
INSERT INTO `on_region` VALUES ('2557','451321','忻城县','265','0','0','Xincheng Xian','2');
INSERT INTO `on_region` VALUES ('2558','451322','象州县','265','0','0','Xiangzhou Xian','2');
INSERT INTO `on_region` VALUES ('2559','451323','武宣县','265','0','0','Wuxuan Xian','2');
INSERT INTO `on_region` VALUES ('2560','451324','金秀瑶族自治县','265','0','0','Jinxiu Yaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2561','451381','合山市','265','0','0','Heshan Shi','2');
INSERT INTO `on_region` VALUES ('2562','451401','市辖区','266','0','0','1','2');
INSERT INTO `on_region` VALUES ('2563','451402','江洲区','266','0','0','Jiangzhou Qu','2');
INSERT INTO `on_region` VALUES ('2564','451421','扶绥县','266','0','0','Fusui Xian','2');
INSERT INTO `on_region` VALUES ('2565','451422','宁明县','266','0','0','Ningming Xian','2');
INSERT INTO `on_region` VALUES ('2566','451423','龙州县','266','0','0','Longzhou Xian','2');
INSERT INTO `on_region` VALUES ('2567','451424','大新县','266','0','0','Daxin Xian','2');
INSERT INTO `on_region` VALUES ('2568','451425','天等县','266','0','0','Tiandeng Xian','2');
INSERT INTO `on_region` VALUES ('2569','451481','凭祥市','266','0','0','Pingxiang Shi','2');
INSERT INTO `on_region` VALUES ('2570','460101','市辖区','267','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2571','460105','秀英区','267','0','0','Xiuying Qu','XYH');
INSERT INTO `on_region` VALUES ('2572','460106','龙华区','267','0','0','LongHua Qu','LH');
INSERT INTO `on_region` VALUES ('2573','460107','琼山区','267','0','0','QiongShan Qu','QS');
INSERT INTO `on_region` VALUES ('2574','460108','美兰区','267','0','0','MeiLan Qu','ML');
INSERT INTO `on_region` VALUES ('2575','460201','市辖区','268','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2576','469001','五指山市','269','0','0','Wuzhishan Qu','2');
INSERT INTO `on_region` VALUES ('2577','469002','琼海市','269','0','0','Qionghai Shi','2');
INSERT INTO `on_region` VALUES ('2578','469003','儋州市','269','0','0','Danzhou Shi','2');
INSERT INTO `on_region` VALUES ('2579','469005','文昌市','269','0','0','Wenchang Shi','2');
INSERT INTO `on_region` VALUES ('2580','469006','万宁市','269','0','0','Wanning Shi','2');
INSERT INTO `on_region` VALUES ('2581','469007','东方市','269','0','0','Dongfang Shi','2');
INSERT INTO `on_region` VALUES ('2582','469021','定安县','269','0','0','Ding,an Xian','2');
INSERT INTO `on_region` VALUES ('2583','469022','屯昌县','269','0','0','Tunchang Xian','2');
INSERT INTO `on_region` VALUES ('2584','469023','澄迈县','269','0','0','Chengmai Xian','2');
INSERT INTO `on_region` VALUES ('2585','469024','临高县','269','0','0','Lingao Xian','2');
INSERT INTO `on_region` VALUES ('2586','469025','白沙黎族自治县','269','0','0','Baisha Lizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2587','469026','昌江黎族自治县','269','0','0','Changjiang Lizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2588','469027','乐东黎族自治县','269','0','0','Ledong Lizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2589','469028','陵水黎族自治县','269','0','0','Lingshui Lizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2590','469029','保亭黎族苗族自治县','269','0','0','Baoting Lizu Miaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2591','469030','琼中黎族苗族自治县','269','0','0','Qiongzhong Lizu Miaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2592','469031','西沙群岛','269','0','0','Xisha Qundao','2');
INSERT INTO `on_region` VALUES ('2593','469032','南沙群岛','269','0','0','Nansha Qundao','2');
INSERT INTO `on_region` VALUES ('2594','469033','中沙群岛的岛礁及其海域','269','0','0','Zhongsha Qundao de Daojiao Jiqi Haiyu','2');
INSERT INTO `on_region` VALUES ('2595','500101','万州区','270','0','0','Wanzhou Qu','WZO ');
INSERT INTO `on_region` VALUES ('2596','500102','涪陵区','270','0','0','Fuling Qu','FLG');
INSERT INTO `on_region` VALUES ('2597','500103','渝中区','270','0','0','Yuzhong Qu','YZQ');
INSERT INTO `on_region` VALUES ('2598','500104','大渡口区','270','0','0','Dadukou Qu','DDK');
INSERT INTO `on_region` VALUES ('2599','500105','江北区','270','0','0','Jiangbei Qu','JBE');
INSERT INTO `on_region` VALUES ('2600','500106','沙坪坝区','270','0','0','Shapingba Qu','SPB');
INSERT INTO `on_region` VALUES ('2601','500107','九龙坡区','270','0','0','Jiulongpo Qu','JLP');
INSERT INTO `on_region` VALUES ('2602','500108','南岸区','270','0','0','Nan,an Qu','NAQ');
INSERT INTO `on_region` VALUES ('2603','500109','北碚区','270','0','0','Beibei Qu','BBE');
INSERT INTO `on_region` VALUES ('2604','500110','万盛区','270','0','0','Wansheng Qu','WSQ');
INSERT INTO `on_region` VALUES ('2605','500111','双桥区','270','0','0','Shuangqiao Qu','SQQ');
INSERT INTO `on_region` VALUES ('2606','500112','渝北区','270','0','0','Yubei Qu','YBE');
INSERT INTO `on_region` VALUES ('2607','500113','巴南区','270','0','0','Banan Qu','BNN');
INSERT INTO `on_region` VALUES ('2608','500114','黔江区','270','0','0','Qianjiang Qu','2');
INSERT INTO `on_region` VALUES ('2609','500115','长寿区','270','0','0','Changshou Qu','2');
INSERT INTO `on_region` VALUES ('2610','500222','綦江县','271','0','0','Qijiang Xian','QJG');
INSERT INTO `on_region` VALUES ('2611','500223','潼南县','271','0','0','Tongnan Xian','TNN');
INSERT INTO `on_region` VALUES ('2612','500224','铜梁县','271','0','0','Tongliang Xian','TGL');
INSERT INTO `on_region` VALUES ('2613','500225','大足县','271','0','0','Dazu Xian','DZX');
INSERT INTO `on_region` VALUES ('2614','500226','荣昌县','271','0','0','Rongchang Xian','RGC');
INSERT INTO `on_region` VALUES ('2615','500227','璧山县','271','0','0','Bishan Xian','BSY');
INSERT INTO `on_region` VALUES ('2616','500228','梁平县','271','0','0','Liangping Xian','LGP');
INSERT INTO `on_region` VALUES ('2617','500229','城口县','271','0','0','Chengkou Xian','CKO');
INSERT INTO `on_region` VALUES ('2618','500230','丰都县','271','0','0','Fengdu Xian','FDU');
INSERT INTO `on_region` VALUES ('2619','500231','垫江县','271','0','0','Dianjiang Xian','DJG');
INSERT INTO `on_region` VALUES ('2620','500232','武隆县','271','0','0','Wulong Xian','WLG');
INSERT INTO `on_region` VALUES ('2621','500233','忠县','271','0','0','Zhong Xian','ZHX');
INSERT INTO `on_region` VALUES ('2622','500234','开县','271','0','0','Kai Xian','KAI');
INSERT INTO `on_region` VALUES ('2623','500235','云阳县','271','0','0','Yunyang Xian','YNY');
INSERT INTO `on_region` VALUES ('2624','500236','奉节县','271','0','0','Fengjie Xian','FJE');
INSERT INTO `on_region` VALUES ('2625','500237','巫山县','271','0','0','Wushan Xian','WSN');
INSERT INTO `on_region` VALUES ('2626','500238','巫溪县','271','0','0','Wuxi Xian','WXX');
INSERT INTO `on_region` VALUES ('2627','500240','石柱土家族自治县','271','0','0','Shizhu Tujiazu Zizhixian','SZY');
INSERT INTO `on_region` VALUES ('2628','500241','秀山土家族苗族自治县','271','0','0','Xiushan Tujiazu Miaozu Zizhixian','XUS');
INSERT INTO `on_region` VALUES ('2629','500242','酉阳土家族苗族自治县','271','0','0','Youyang Tujiazu Miaozu Zizhixian','YUY');
INSERT INTO `on_region` VALUES ('2630','500243','彭水苗族土家族自治县','271','0','0','Pengshui Miaozu Tujiazu Zizhixian','PSU');
INSERT INTO `on_region` VALUES ('2631','500116','江津区','272','0','0','Jiangjin Shi','2');
INSERT INTO `on_region` VALUES ('2632','500117','合川区','272','0','0','Hechuan Shi','2');
INSERT INTO `on_region` VALUES ('2633','500118','永川区','272','0','0','Yongchuan Shi','2');
INSERT INTO `on_region` VALUES ('2634','500119','南川区','272','0','0','Nanchuan Shi','2');
INSERT INTO `on_region` VALUES ('2635','510101','市辖区','273','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2636','510104','锦江区','273','0','0','Jinjiang Qu','JJQ');
INSERT INTO `on_region` VALUES ('2637','510105','青羊区','273','0','0','Qingyang Qu','QYQ');
INSERT INTO `on_region` VALUES ('2638','510106','金牛区','273','0','0','Jinniu Qu','JNU');
INSERT INTO `on_region` VALUES ('2639','510107','武侯区','273','0','0','Wuhou Qu','WHQ');
INSERT INTO `on_region` VALUES ('2640','510108','成华区','273','0','0','Chenghua Qu','CHQ');
INSERT INTO `on_region` VALUES ('2641','510112','龙泉驿区','273','0','0','Longquanyi Qu','LQY');
INSERT INTO `on_region` VALUES ('2642','510113','青白江区','273','0','0','Qingbaijiang Qu','QBJ');
INSERT INTO `on_region` VALUES ('2643','510114','新都区','273','0','0','Xindu Qu','2');
INSERT INTO `on_region` VALUES ('2644','510115','温江区','273','0','0','Wenjiang Qu','2');
INSERT INTO `on_region` VALUES ('2645','510121','金堂县','273','0','0','Jintang Xian','JNT');
INSERT INTO `on_region` VALUES ('2646','510122','双流县','273','0','0','Shuangliu Xian','SLU');
INSERT INTO `on_region` VALUES ('2647','510124','郫县','273','0','0','Pi Xian','PIX');
INSERT INTO `on_region` VALUES ('2648','510129','大邑县','273','0','0','Dayi Xian','DYI');
INSERT INTO `on_region` VALUES ('2649','510131','蒲江县','273','0','0','Pujiang Xian','PJX');
INSERT INTO `on_region` VALUES ('2650','510132','新津县','273','0','0','Xinjin Xian','XJC');
INSERT INTO `on_region` VALUES ('2651','510181','都江堰市','273','0','0','Dujiangyan Shi','DJY');
INSERT INTO `on_region` VALUES ('2652','510182','彭州市','273','0','0','Pengzhou Shi','PZS');
INSERT INTO `on_region` VALUES ('2653','510183','邛崃市','273','0','0','Qionglai Shi','QLA');
INSERT INTO `on_region` VALUES ('2654','510184','崇州市','273','0','0','Chongzhou Shi','CZO');
INSERT INTO `on_region` VALUES ('2655','510301','市辖区','274','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2656','510302','自流井区','274','0','0','Ziliujing Qu','ZLJ');
INSERT INTO `on_region` VALUES ('2657','510303','贡井区','274','0','0','Gongjing Qu','2');
INSERT INTO `on_region` VALUES ('2658','510304','大安区','274','0','0','Da,an Qu','DAQ');
INSERT INTO `on_region` VALUES ('2659','510311','沿滩区','274','0','0','Yantan Qu','YTN');
INSERT INTO `on_region` VALUES ('2660','510321','荣县','274','0','0','Rong Xian','RGX');
INSERT INTO `on_region` VALUES ('2661','510322','富顺县','274','0','0','Fushun Xian','FSH');
INSERT INTO `on_region` VALUES ('2662','510401','市辖区','275','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2663','510402','东区','275','0','0','Dong Qu','DQP');
INSERT INTO `on_region` VALUES ('2664','510403','西区','275','0','0','Xi Qu','XIQ');
INSERT INTO `on_region` VALUES ('2665','510411','仁和区','275','0','0','Renhe Qu','RHQ');
INSERT INTO `on_region` VALUES ('2666','510421','米易县','275','0','0','Miyi Xian','MIY');
INSERT INTO `on_region` VALUES ('2667','510422','盐边县','275','0','0','Yanbian Xian','YBN');
INSERT INTO `on_region` VALUES ('2668','510501','市辖区','276','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2669','510502','江阳区','276','0','0','Jiangyang Qu','JYB');
INSERT INTO `on_region` VALUES ('2670','510503','纳溪区','276','0','0','Naxi Qu','NXI');
INSERT INTO `on_region` VALUES ('2671','510504','龙马潭区','276','0','0','Longmatan Qu','LMT');
INSERT INTO `on_region` VALUES ('2672','510521','泸县','276','0','0','Lu Xian','LUX');
INSERT INTO `on_region` VALUES ('2673','510522','合江县','276','0','0','Hejiang Xian','HEJ');
INSERT INTO `on_region` VALUES ('2674','510524','叙永县','276','0','0','Xuyong Xian','XYO');
INSERT INTO `on_region` VALUES ('2675','510525','古蔺县','276','0','0','Gulin Xian','GUL');
INSERT INTO `on_region` VALUES ('2676','510601','市辖区','277','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2677','510603','旌阳区','277','0','0','Jingyang Qu','JYF');
INSERT INTO `on_region` VALUES ('2678','510623','中江县','277','0','0','Zhongjiang Xian','ZGJ');
INSERT INTO `on_region` VALUES ('2679','510626','罗江县','277','0','0','Luojiang Xian','LOJ');
INSERT INTO `on_region` VALUES ('2680','510681','广汉市','277','0','0','Guanghan Shi','GHN');
INSERT INTO `on_region` VALUES ('2681','510682','什邡市','277','0','0','Shifang Shi','SFS');
INSERT INTO `on_region` VALUES ('2682','510683','绵竹市','277','0','0','Jinzhou Shi','MZU');
INSERT INTO `on_region` VALUES ('2683','510701','市辖区','278','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2684','510703','涪城区','278','0','0','Fucheng Qu','FCM');
INSERT INTO `on_region` VALUES ('2685','510704','游仙区','278','0','0','Youxian Qu','YXM');
INSERT INTO `on_region` VALUES ('2686','510722','三台县','278','0','0','Santai Xian','SNT');
INSERT INTO `on_region` VALUES ('2687','510723','盐亭县','278','0','0','Yanting Xian','YTC');
INSERT INTO `on_region` VALUES ('2688','510724','安县','278','0','0','An Xian','AXN');
INSERT INTO `on_region` VALUES ('2689','510725','梓潼县','278','0','0','Zitong Xian','ZTG');
INSERT INTO `on_region` VALUES ('2690','510726','北川羌族自治县','278','0','0','Beichuanqiangzuzizhi Qu','2');
INSERT INTO `on_region` VALUES ('2691','510727','平武县','278','0','0','Pingwu Xian','PWU');
INSERT INTO `on_region` VALUES ('2692','510781','江油市','278','0','0','Jiangyou Shi','JYO');
INSERT INTO `on_region` VALUES ('2693','510801','市辖区','279','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2694','511002','市中区','279','0','0','Shizhong Qu','SZM');
INSERT INTO `on_region` VALUES ('2695','510811','元坝区','279','0','0','Yuanba Qu','YBQ');
INSERT INTO `on_region` VALUES ('2696','510812','朝天区','279','0','0','Chaotian Qu','CTN');
INSERT INTO `on_region` VALUES ('2697','510821','旺苍县','279','0','0','Wangcang Xian','WGC');
INSERT INTO `on_region` VALUES ('2698','510822','青川县','279','0','0','Qingchuan Xian','QCX');
INSERT INTO `on_region` VALUES ('2699','510823','剑阁县','279','0','0','Jiange Xian','JGE');
INSERT INTO `on_region` VALUES ('2700','510824','苍溪县','279','0','0','Cangxi Xian','CXC');
INSERT INTO `on_region` VALUES ('2701','510901','市辖区','280','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2702','510903','船山区','280','0','0','Chuanshan Qu','2');
INSERT INTO `on_region` VALUES ('2703','510904','安居区','280','0','0','Anju Qu','2');
INSERT INTO `on_region` VALUES ('2704','510921','蓬溪县','280','0','0','Pengxi Xian','PXI');
INSERT INTO `on_region` VALUES ('2705','510922','射洪县','280','0','0','Shehong Xian','SHE');
INSERT INTO `on_region` VALUES ('2706','510923','大英县','280','0','0','Daying Xian','DAY');
INSERT INTO `on_region` VALUES ('2707','511001','市辖区','281','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2708','511002','市中区','281','0','0','Shizhong Qu','SZM');
INSERT INTO `on_region` VALUES ('2709','511011','东兴区','281','0','0','Dongxing Qu','DXQ');
INSERT INTO `on_region` VALUES ('2710','511024','威远县','281','0','0','Weiyuan Xian','WYU');
INSERT INTO `on_region` VALUES ('2711','511025','资中县','281','0','0','Zizhong Xian','ZZC');
INSERT INTO `on_region` VALUES ('2712','511028','隆昌县','281','0','0','Longchang Xian','LCC');
INSERT INTO `on_region` VALUES ('2713','511101','市辖区','282','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2714','511102','市中区','282','0','0','Shizhong Qu','SZP');
INSERT INTO `on_region` VALUES ('2715','511111','沙湾区','282','0','0','Shawan Qu','SWN');
INSERT INTO `on_region` VALUES ('2716','511112','五通桥区','282','0','0','Wutongqiao Qu','WTQ');
INSERT INTO `on_region` VALUES ('2717','511113','金口河区','282','0','0','Jinkouhe Qu','JKH');
INSERT INTO `on_region` VALUES ('2718','511123','犍为县','282','0','0','Qianwei Xian','QWE');
INSERT INTO `on_region` VALUES ('2719','511124','井研县','282','0','0','Jingyan Xian','JYA');
INSERT INTO `on_region` VALUES ('2720','511126','夹江县','282','0','0','Jiajiang Xian','JJC');
INSERT INTO `on_region` VALUES ('2721','511129','沐川县','282','0','0','Muchuan Xian','MCH');
INSERT INTO `on_region` VALUES ('2722','511132','峨边彝族自治县','282','0','0','Ebian Yizu Zizhixian','EBN');
INSERT INTO `on_region` VALUES ('2723','511133','马边彝族自治县','282','0','0','Mabian Yizu Zizhixian','MBN');
INSERT INTO `on_region` VALUES ('2724','511181','峨眉山市','282','0','0','Emeishan Shi','EMS');
INSERT INTO `on_region` VALUES ('2725','511301','市辖区','283','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2726','511302','顺庆区','283','0','0','Shunqing Xian','SQG');
INSERT INTO `on_region` VALUES ('2727','511303','高坪区','283','0','0','Gaoping Qu','GPQ');
INSERT INTO `on_region` VALUES ('2728','511304','嘉陵区','283','0','0','Jialing Qu','JLG');
INSERT INTO `on_region` VALUES ('2729','511321','南部县','283','0','0','Nanbu Xian','NBU');
INSERT INTO `on_region` VALUES ('2730','511322','营山县','283','0','0','Yingshan Xian','YGS');
INSERT INTO `on_region` VALUES ('2731','511323','蓬安县','283','0','0','Peng,an Xian','PGA');
INSERT INTO `on_region` VALUES ('2732','511324','仪陇县','283','0','0','Yilong Xian','YLC');
INSERT INTO `on_region` VALUES ('2733','511325','西充县','283','0','0','Xichong Xian','XCO');
INSERT INTO `on_region` VALUES ('2734','511381','阆中市','283','0','0','Langzhong Shi','LZJ');
INSERT INTO `on_region` VALUES ('2735','511401','市辖区','284','0','0','1','2');
INSERT INTO `on_region` VALUES ('2736','511402','东坡区','284','0','0','Dongpo Qu','2');
INSERT INTO `on_region` VALUES ('2737','511421','仁寿县','284','0','0','Renshou Xian','2');
INSERT INTO `on_region` VALUES ('2738','511422','彭山县','284','0','0','Pengshan Xian','2');
INSERT INTO `on_region` VALUES ('2739','511423','洪雅县','284','0','0','Hongya Xian','2');
INSERT INTO `on_region` VALUES ('2740','511424','丹棱县','284','0','0','Danling Xian','2');
INSERT INTO `on_region` VALUES ('2741','511425','青神县','284','0','0','Qingshen Xian','2');
INSERT INTO `on_region` VALUES ('2742','511501','市辖区','285','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2743','511502','翠屏区','285','0','0','Cuiping Qu','CPQ');
INSERT INTO `on_region` VALUES ('2744','511521','宜宾县','285','0','0','Yibin Xian','YBX');
INSERT INTO `on_region` VALUES ('2745','511522','南溪县','285','0','0','Nanxi Xian','NNX');
INSERT INTO `on_region` VALUES ('2746','511523','江安县','285','0','0','Jiang,an Xian','JAC');
INSERT INTO `on_region` VALUES ('2747','511524','长宁县','285','0','0','Changning Xian','CNX');
INSERT INTO `on_region` VALUES ('2748','511525','高县','285','0','0','Gao Xian','GAO');
INSERT INTO `on_region` VALUES ('2749','511526','珙县','285','0','0','Gong Xian','GOG');
INSERT INTO `on_region` VALUES ('2750','511527','筠连县','285','0','0','Junlian Xian','JNL');
INSERT INTO `on_region` VALUES ('2751','511528','兴文县','285','0','0','Xingwen Xian','XWC');
INSERT INTO `on_region` VALUES ('2752','511529','屏山县','285','0','0','Pingshan Xian','PSC');
INSERT INTO `on_region` VALUES ('2753','511601','市辖区','286','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2754','511602','广安区','286','0','0','Guang,an Qu','GAQ');
INSERT INTO `on_region` VALUES ('2755','511621','岳池县','286','0','0','Yuechi Xian','YCC');
INSERT INTO `on_region` VALUES ('2756','511622','武胜县','286','0','0','Wusheng Xian','WSG');
INSERT INTO `on_region` VALUES ('2757','511623','邻水县','286','0','0','Linshui Xian','LSH');
INSERT INTO `on_region` VALUES ('2759','511701','市辖区','287','0','0','1','2');
INSERT INTO `on_region` VALUES ('2760','511702','通川区','287','0','0','Tongchuan Qu','2');
INSERT INTO `on_region` VALUES ('2761','511721','达县','287','0','0','Da Xian','2');
INSERT INTO `on_region` VALUES ('2762','511722','宣汉县','287','0','0','Xuanhan Xian','2');
INSERT INTO `on_region` VALUES ('2763','511723','开江县','287','0','0','Kaijiang Xian','2');
INSERT INTO `on_region` VALUES ('2764','511724','大竹县','287','0','0','Dazhu Xian','2');
INSERT INTO `on_region` VALUES ('2765','511725','渠县','287','0','0','Qu Xian','2');
INSERT INTO `on_region` VALUES ('2766','511781','万源市','287','0','0','Wanyuan Shi','2');
INSERT INTO `on_region` VALUES ('2767','511801','市辖区','288','0','0','1','2');
INSERT INTO `on_region` VALUES ('2768','511802','雨城区','288','0','0','Yucheg Qu','2');
INSERT INTO `on_region` VALUES ('2769','511821','名山县','288','0','0','Mingshan Xian','2');
INSERT INTO `on_region` VALUES ('2770','511822','荥经县','288','0','0','Yingjing Xian','2');
INSERT INTO `on_region` VALUES ('2771','511823','汉源县','288','0','0','Hanyuan Xian','2');
INSERT INTO `on_region` VALUES ('2772','511824','石棉县','288','0','0','Shimian Xian','2');
INSERT INTO `on_region` VALUES ('2773','511825','天全县','288','0','0','Tianquan Xian','2');
INSERT INTO `on_region` VALUES ('2774','511826','芦山县','288','0','0','Lushan Xian','2');
INSERT INTO `on_region` VALUES ('2775','511827','宝兴县','288','0','0','Baoxing Xian','2');
INSERT INTO `on_region` VALUES ('2776','511901','市辖区','289','0','0','1','2');
INSERT INTO `on_region` VALUES ('2777','511902','巴州区','289','0','0','Bazhou Qu','2');
INSERT INTO `on_region` VALUES ('2778','511921','通江县','289','0','0','Tongjiang Xian','2');
INSERT INTO `on_region` VALUES ('2779','511922','南江县','289','0','0','Nanjiang Xian','2');
INSERT INTO `on_region` VALUES ('2780','511923','平昌县','289','0','0','Pingchang Xian','2');
INSERT INTO `on_region` VALUES ('2781','512001','市辖区','290','0','0','1','2');
INSERT INTO `on_region` VALUES ('2782','512002','雁江区','290','0','0','Yanjiang Qu','2');
INSERT INTO `on_region` VALUES ('2783','512021','安岳县','290','0','0','Anyue Xian','2');
INSERT INTO `on_region` VALUES ('2784','512022','乐至县','290','0','0','Lezhi Xian','2');
INSERT INTO `on_region` VALUES ('2785','512081','简阳市','290','0','0','Jianyang Shi','2');
INSERT INTO `on_region` VALUES ('2786','513221','汶川县','291','0','0','Wenchuan Xian','WNC');
INSERT INTO `on_region` VALUES ('2787','513222','理县','291','0','0','Li Xian','LXC');
INSERT INTO `on_region` VALUES ('2788','513223','茂县','291','0','0','Mao Xian','MAO');
INSERT INTO `on_region` VALUES ('2789','513224','松潘县','291','0','0','Songpan Xian','SOP');
INSERT INTO `on_region` VALUES ('2790','513225','九寨沟县','291','0','0','Jiuzhaigou Xian','JZG');
INSERT INTO `on_region` VALUES ('2791','513226','金川县','291','0','0','Jinchuan Xian','JCH');
INSERT INTO `on_region` VALUES ('2792','513227','小金县','291','0','0','Xiaojin Xian','XJX');
INSERT INTO `on_region` VALUES ('2793','513228','黑水县','291','0','0','Heishui Xian','HIS');
INSERT INTO `on_region` VALUES ('2794','513229','马尔康县','291','0','0','Barkam Xian','BAK');
INSERT INTO `on_region` VALUES ('2795','513230','壤塘县','291','0','0','Zamtang Xian','ZAM');
INSERT INTO `on_region` VALUES ('2796','513231','阿坝县','291','0','0','Aba(Ngawa) Xian','ABX');
INSERT INTO `on_region` VALUES ('2797','513232','若尔盖县','291','0','0','ZoigeXian','ZOI');
INSERT INTO `on_region` VALUES ('2798','513233','红原县','291','0','0','Hongyuan Xian','HOY');
INSERT INTO `on_region` VALUES ('2799','513321','康定县','292','0','0','Kangding(Dardo) Xian','KDX');
INSERT INTO `on_region` VALUES ('2800','513322','泸定县','292','0','0','Luding(Jagsamka) Xian','LUD');
INSERT INTO `on_region` VALUES ('2801','513323','丹巴县','292','0','0','Danba(Rongzhag) Xian','DBA');
INSERT INTO `on_region` VALUES ('2802','513324','九龙县','292','0','0','Jiulong(Gyaisi) Xian','JLC');
INSERT INTO `on_region` VALUES ('2803','513325','雅江县','292','0','0','Yajiang(Nyagquka) Xian','YAJ');
INSERT INTO `on_region` VALUES ('2804','513326','道孚县','292','0','0','Dawu Xian','DAW');
INSERT INTO `on_region` VALUES ('2805','513327','炉霍县','292','0','0','Luhuo(Zhaggo) Xian','LUH');
INSERT INTO `on_region` VALUES ('2806','513328','甘孜县','292','0','0','Garze Xian','GRZ');
INSERT INTO `on_region` VALUES ('2807','513329','新龙县','292','0','0','Xinlong(Nyagrong) Xian','XLG');
INSERT INTO `on_region` VALUES ('2808','513330','德格县','292','0','0','DegeXian','DEG');
INSERT INTO `on_region` VALUES ('2809','513331','白玉县','292','0','0','Baiyu Xian','BYC');
INSERT INTO `on_region` VALUES ('2810','513332','石渠县','292','0','0','Serxv Xian','SER');
INSERT INTO `on_region` VALUES ('2811','513333','色达县','292','0','0','Sertar Xian','STX');
INSERT INTO `on_region` VALUES ('2812','513334','理塘县','292','0','0','Litang Xian','LIT');
INSERT INTO `on_region` VALUES ('2813','513335','巴塘县','292','0','0','Batang Xian','BTC');
INSERT INTO `on_region` VALUES ('2814','513336','乡城县','292','0','0','Xiangcheng(Qagcheng) Xian','XCC');
INSERT INTO `on_region` VALUES ('2815','513337','稻城县','292','0','0','Daocheng(Dabba) Xian','DCX');
INSERT INTO `on_region` VALUES ('2816','513338','得荣县','292','0','0','Derong Xian','DER');
INSERT INTO `on_region` VALUES ('2817','513401','西昌市','293','0','0','Xichang Shi','XCA');
INSERT INTO `on_region` VALUES ('2818','513422','木里藏族自治县','293','0','0','Muli Zangzu Zizhixian','MLI');
INSERT INTO `on_region` VALUES ('2819','513423','盐源县','293','0','0','Yanyuan Xian','YYU');
INSERT INTO `on_region` VALUES ('2820','513424','德昌县','293','0','0','Dechang Xian','DEC');
INSERT INTO `on_region` VALUES ('2821','513425','会理县','293','0','0','Huili Xian','HLI');
INSERT INTO `on_region` VALUES ('2822','513426','会东县','293','0','0','Huidong Xian','HDG');
INSERT INTO `on_region` VALUES ('2823','513427','宁南县','293','0','0','Ningnan Xian','NIN');
INSERT INTO `on_region` VALUES ('2824','513428','普格县','293','0','0','Puge Xian','PGE');
INSERT INTO `on_region` VALUES ('2825','513429','布拖县','293','0','0','Butuo Xian','BTO');
INSERT INTO `on_region` VALUES ('2826','513430','金阳县','293','0','0','Jinyang Xian','JYW');
INSERT INTO `on_region` VALUES ('2827','513431','昭觉县','293','0','0','Zhaojue Xian','ZJE');
INSERT INTO `on_region` VALUES ('2828','513432','喜德县','293','0','0','Xide Xian','XDE');
INSERT INTO `on_region` VALUES ('2829','513433','冕宁县','293','0','0','Mianning Xian','MNG');
INSERT INTO `on_region` VALUES ('2830','513434','越西县','293','0','0','Yuexi Xian','YXC');
INSERT INTO `on_region` VALUES ('2831','513435','甘洛县','293','0','0','Ganluo Xian','GLO');
INSERT INTO `on_region` VALUES ('2832','513436','美姑县','293','0','0','Meigu Xian','MEG');
INSERT INTO `on_region` VALUES ('2833','513437','雷波县','293','0','0','Leibo Xian','LBX');
INSERT INTO `on_region` VALUES ('2834','520101','市辖区','294','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2835','520102','南明区','294','0','0','Nanming Qu','NMQ');
INSERT INTO `on_region` VALUES ('2836','520103','云岩区','294','0','0','Yunyan Qu','YYQ');
INSERT INTO `on_region` VALUES ('2837','520111','花溪区','294','0','0','Huaxi Qu','HXI');
INSERT INTO `on_region` VALUES ('2838','520112','乌当区','294','0','0','Wudang Qu','WDQ');
INSERT INTO `on_region` VALUES ('2839','520113','白云区','294','0','0','Baiyun Qu','BYU');
INSERT INTO `on_region` VALUES ('2840','520114','小河区','294','0','0','Xiaohe Qu','2');
INSERT INTO `on_region` VALUES ('2841','520121','开阳县','294','0','0','Kaiyang Xian','KYG');
INSERT INTO `on_region` VALUES ('2842','520122','息烽县','294','0','0','Xifeng Xian','XFX');
INSERT INTO `on_region` VALUES ('2843','520123','修文县','294','0','0','Xiuwen Xian','XWX');
INSERT INTO `on_region` VALUES ('2844','520181','清镇市','294','0','0','Qingzhen Shi','QZN');
INSERT INTO `on_region` VALUES ('2845','520201','钟山区','295','0','0','Zhongshan Qu','ZSQ');
INSERT INTO `on_region` VALUES ('2846','520203','六枝特区','295','0','0','Liuzhi Tequ','LZT');
INSERT INTO `on_region` VALUES ('2847','520221','水城县','295','0','0','Shuicheng Xian','SUC');
INSERT INTO `on_region` VALUES ('2848','520222','盘县','295','0','0','Pan Xian','2');
INSERT INTO `on_region` VALUES ('2849','520301','市辖区','296','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2850','520302','红花岗区','296','0','0','Honghuagang Qu','HHG');
INSERT INTO `on_region` VALUES ('2851','520303','汇川区','296','0','0','Huichuan Qu','2');
INSERT INTO `on_region` VALUES ('2852','520321','遵义县','296','0','0','Zunyi Xian','ZYI');
INSERT INTO `on_region` VALUES ('2853','520322','桐梓县','296','0','0','Tongzi Xian','TZI');
INSERT INTO `on_region` VALUES ('2854','520323','绥阳县','296','0','0','Suiyang Xian','SUY');
INSERT INTO `on_region` VALUES ('2855','520324','正安县','296','0','0','Zhengan Xan','2');
INSERT INTO `on_region` VALUES ('2856','520325','道真仡佬族苗族自治县','296','0','0','Daozhen Gelaozu Miaozu Zizhixian','DZN');
INSERT INTO `on_region` VALUES ('2857','520326','务川仡佬族苗族自治县','296','0','0','Wuchuan Gelaozu Miaozu Zizhixian','WCU');
INSERT INTO `on_region` VALUES ('2858','520327','凤冈县','296','0','0','Fenggang Xian','FGG');
INSERT INTO `on_region` VALUES ('2859','520328','湄潭县','296','0','0','Meitan Xian','MTN');
INSERT INTO `on_region` VALUES ('2860','520329','余庆县','296','0','0','Yuqing Xian','YUQ');
INSERT INTO `on_region` VALUES ('2861','520330','习水县','296','0','0','Xishui Xian','XSI');
INSERT INTO `on_region` VALUES ('2862','520381','赤水市','296','0','0','Chishui Shi','CSS');
INSERT INTO `on_region` VALUES ('2863','520382','仁怀市','296','0','0','Renhuai Shi','RHS');
INSERT INTO `on_region` VALUES ('2864','520401','市辖区','297','0','0','1','2');
INSERT INTO `on_region` VALUES ('2865','520402','西秀区','297','0','0','Xixiu Qu','2');
INSERT INTO `on_region` VALUES ('2866','520421','平坝县','297','0','0','Pingba Xian','2');
INSERT INTO `on_region` VALUES ('2867','520422','普定县','297','0','0','Puding Xian','2');
INSERT INTO `on_region` VALUES ('2868','520423','镇宁布依族苗族自治县','297','0','0','Zhenning Buyeizu Miaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2869','520424','关岭布依族苗族自治县','297','0','0','Guanling Buyeizu Miaozu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2870','520425','紫云苗族布依族自治县','297','0','0','Ziyun Miaozu Buyeizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2871','522201','铜仁市','298','0','0','Tongren Shi','TRS');
INSERT INTO `on_region` VALUES ('2872','522222','江口县','298','0','0','Jiangkou Xian','JGK');
INSERT INTO `on_region` VALUES ('2873','522223','玉屏侗族自治县','298','0','0','Yuping Dongzu Zizhixian','YPG');
INSERT INTO `on_region` VALUES ('2874','522224','石阡县','298','0','0','Shiqian Xian','SQI');
INSERT INTO `on_region` VALUES ('2875','522225','思南县','298','0','0','Sinan Xian','SNA');
INSERT INTO `on_region` VALUES ('2876','522226','印江土家族苗族自治县','298','0','0','Yinjiang Tujiazu Miaozu Zizhixian','YJY');
INSERT INTO `on_region` VALUES ('2877','522227','德江县','298','0','0','Dejiang Xian','DEJ');
INSERT INTO `on_region` VALUES ('2878','522228','沿河土家族自治县','298','0','0','Yanhe Tujiazu Zizhixian','YHE');
INSERT INTO `on_region` VALUES ('2879','522229','松桃苗族自治县','298','0','0','Songtao Miaozu Zizhixian','STM');
INSERT INTO `on_region` VALUES ('2880','522230','万山特区','298','0','0','Wanshan Tequ','WAS');
INSERT INTO `on_region` VALUES ('2881','522301','兴义市','299','0','0','Xingyi Shi','XYI');
INSERT INTO `on_region` VALUES ('2882','522322','兴仁县','299','0','0','Xingren Xian','XRN');
INSERT INTO `on_region` VALUES ('2883','522323','普安县','299','0','0','Pu,an Xian','PUA');
INSERT INTO `on_region` VALUES ('2884','522324','晴隆县','299','0','0','Qinglong Xian','QLG');
INSERT INTO `on_region` VALUES ('2885','522325','贞丰县','299','0','0','Zhenfeng Xian','ZFG');
INSERT INTO `on_region` VALUES ('2886','522326','望谟县','299','0','0','Wangmo Xian','WMO');
INSERT INTO `on_region` VALUES ('2887','522327','册亨县','299','0','0','Ceheng Xian','CEH');
INSERT INTO `on_region` VALUES ('2888','522328','安龙县','299','0','0','Anlong Xian','ALG');
INSERT INTO `on_region` VALUES ('2889','522401','毕节市','300','0','0','Bijie Shi','BJE');
INSERT INTO `on_region` VALUES ('2890','522422','大方县','300','0','0','Dafang Xian','DAF');
INSERT INTO `on_region` VALUES ('2891','522423','黔西县','300','0','0','Qianxi Xian','QNX');
INSERT INTO `on_region` VALUES ('2892','522424','金沙县','300','0','0','Jinsha Xian','JSX');
INSERT INTO `on_region` VALUES ('2893','522425','织金县','300','0','0','Zhijin Xian','ZJN');
INSERT INTO `on_region` VALUES ('2894','522426','纳雍县','300','0','0','Nayong Xian','NYG');
INSERT INTO `on_region` VALUES ('2895','522427','威宁彝族回族苗族自治县','300','0','0','Weining Yizu Huizu Miaozu Zizhixian','WNG');
INSERT INTO `on_region` VALUES ('2896','522428','赫章县','300','0','0','Hezhang Xian','HZA');
INSERT INTO `on_region` VALUES ('2897','522601','凯里市','301','0','0','Kaili Shi','KLS');
INSERT INTO `on_region` VALUES ('2898','522622','黄平县','301','0','0','Huangping Xian','HPN');
INSERT INTO `on_region` VALUES ('2899','522623','施秉县','301','0','0','Shibing Xian','SBG');
INSERT INTO `on_region` VALUES ('2900','522624','三穗县','301','0','0','Sansui Xian','SAS');
INSERT INTO `on_region` VALUES ('2901','522625','镇远县','301','0','0','Zhenyuan Xian','ZYX');
INSERT INTO `on_region` VALUES ('2902','522626','岑巩县','301','0','0','Cengong Xian','CGX');
INSERT INTO `on_region` VALUES ('2903','522627','天柱县','301','0','0','Tianzhu Xian','TZU');
INSERT INTO `on_region` VALUES ('2904','522628','锦屏县','301','0','0','Jinping Xian','JPX');
INSERT INTO `on_region` VALUES ('2905','522629','剑河县','301','0','0','Jianhe Xian','JHE');
INSERT INTO `on_region` VALUES ('2906','522630','台江县','301','0','0','Taijiang Xian','TJX');
INSERT INTO `on_region` VALUES ('2907','522631','黎平县','301','0','0','Liping Xian','LIP');
INSERT INTO `on_region` VALUES ('2908','522632','榕江县','301','0','0','Rongjiang Xian','RJG');
INSERT INTO `on_region` VALUES ('2909','522633','从江县','301','0','0','Congjiang Xian','COJ');
INSERT INTO `on_region` VALUES ('2910','522634','雷山县','301','0','0','Leishan Xian','LSA');
INSERT INTO `on_region` VALUES ('2911','522635','麻江县','301','0','0','Majiang Xian','MAJ');
INSERT INTO `on_region` VALUES ('2912','522636','丹寨县','301','0','0','Danzhai Xian','DZH');
INSERT INTO `on_region` VALUES ('2913','522701','都匀市','302','0','0','Duyun Shi','DUY');
INSERT INTO `on_region` VALUES ('2914','522702','福泉市','302','0','0','Fuquan Shi','FQN');
INSERT INTO `on_region` VALUES ('2915','522722','荔波县','302','0','0','Libo Xian','LBO');
INSERT INTO `on_region` VALUES ('2916','522723','贵定县','302','0','0','Guiding Xian','GDG');
INSERT INTO `on_region` VALUES ('2917','522725','瓮安县','302','0','0','Weng,an Xian','WGA');
INSERT INTO `on_region` VALUES ('2918','522726','独山县','302','0','0','Dushan Xian','DSX');
INSERT INTO `on_region` VALUES ('2919','522727','平塘县','302','0','0','Pingtang Xian','PTG');
INSERT INTO `on_region` VALUES ('2920','522728','罗甸县','302','0','0','Luodian Xian','LOD');
INSERT INTO `on_region` VALUES ('2921','522729','长顺县','302','0','0','Changshun Xian','CSU');
INSERT INTO `on_region` VALUES ('2922','522730','龙里县','302','0','0','Longli Xian','LLI');
INSERT INTO `on_region` VALUES ('2923','522731','惠水县','302','0','0','Huishui Xian','HUS');
INSERT INTO `on_region` VALUES ('2924','522732','三都水族自治县','302','0','0','Sandu Suizu Zizhixian','SDU');
INSERT INTO `on_region` VALUES ('2925','530101','市辖区','303','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2926','530102','五华区','303','0','0','Wuhua Qu','WHA');
INSERT INTO `on_region` VALUES ('2927','530103','盘龙区','303','0','0','Panlong Qu','PLQ');
INSERT INTO `on_region` VALUES ('2928','530111','官渡区','303','0','0','Guandu Qu','GDU');
INSERT INTO `on_region` VALUES ('2929','530112','西山区','303','0','0','Xishan Qu','XSN');
INSERT INTO `on_region` VALUES ('2930','530113','东川区','303','0','0','Dongchuan Qu','DCU');
INSERT INTO `on_region` VALUES ('2931','530121','呈贡县','303','0','0','Chenggong Xian','CGD');
INSERT INTO `on_region` VALUES ('2932','530122','晋宁县','303','0','0','Jinning Xian','JND');
INSERT INTO `on_region` VALUES ('2933','530124','富民县','303','0','0','Fumin Xian','FMN');
INSERT INTO `on_region` VALUES ('2934','530125','宜良县','303','0','0','Yiliang Xian','YIL');
INSERT INTO `on_region` VALUES ('2935','530126','石林彝族自治县','303','0','0','Shilin Yizu Zizhixian','SLY');
INSERT INTO `on_region` VALUES ('2936','530127','嵩明县','303','0','0','Songming Xian','SMI');
INSERT INTO `on_region` VALUES ('2937','530128','禄劝彝族苗族自治县','303','0','0','Luchuan Yizu Miaozu Zizhixian','LUC');
INSERT INTO `on_region` VALUES ('2938','530129','寻甸回族彝族自治县','303','0','0','Xundian Huizu Yizu Zizhixian','XDN');
INSERT INTO `on_region` VALUES ('2939','530181','安宁市','303','0','0','Anning Shi','ANG');
INSERT INTO `on_region` VALUES ('2940','530301','市辖区','304','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2941','530302','麒麟区','304','0','0','Qilin Xian','QLQ');
INSERT INTO `on_region` VALUES ('2942','530321','马龙县','304','0','0','Malong Xian','MLO');
INSERT INTO `on_region` VALUES ('2943','530322','陆良县','304','0','0','Luliang Xian','LLX');
INSERT INTO `on_region` VALUES ('2944','530323','师宗县','304','0','0','Shizong Xian','SZD');
INSERT INTO `on_region` VALUES ('2945','530324','罗平县','304','0','0','Luoping Xian','LPX');
INSERT INTO `on_region` VALUES ('2946','530325','富源县','304','0','0','Fuyuan Xian','FYD');
INSERT INTO `on_region` VALUES ('2947','530326','会泽县','304','0','0','Huize Xian','HUZ');
INSERT INTO `on_region` VALUES ('2948','530328','沾益县','304','0','0','Zhanyi Xian','ZYD');
INSERT INTO `on_region` VALUES ('2949','530381','宣威市','304','0','0','Xuanwei Shi','XWS');
INSERT INTO `on_region` VALUES ('2950','530401','市辖区','305','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('2951','530402','红塔区','305','0','0','Hongta Qu','HTA');
INSERT INTO `on_region` VALUES ('2952','530421','江川县','305','0','0','Jiangchuan Xian','JGC');
INSERT INTO `on_region` VALUES ('2953','530422','澄江县','305','0','0','Chengjiang Xian','CGJ');
INSERT INTO `on_region` VALUES ('2954','530423','通海县','305','0','0','Tonghai Xian','THI');
INSERT INTO `on_region` VALUES ('2955','530424','华宁县','305','0','0','Huaning Xian','HND');
INSERT INTO `on_region` VALUES ('2956','530425','易门县','305','0','0','Yimen Xian','YMD');
INSERT INTO `on_region` VALUES ('2957','530426','峨山彝族自治县','305','0','0','Eshan Yizu Zizhixian','ESN');
INSERT INTO `on_region` VALUES ('2958','530427','新平彝族傣族自治县','305','0','0','Xinping Yizu Daizu Zizhixian','XNP');
INSERT INTO `on_region` VALUES ('2959','530428','元江哈尼族彝族傣族自治县','305','0','0','Yuanjiang Hanizu Yizu Daizu Zizhixian','YJA');
INSERT INTO `on_region` VALUES ('2960','530501','市辖区','306','0','0','1','2');
INSERT INTO `on_region` VALUES ('2961','530502','隆阳区','306','0','0','Longyang Qu','2');
INSERT INTO `on_region` VALUES ('2962','530521','施甸县','306','0','0','Shidian Xian','2');
INSERT INTO `on_region` VALUES ('2963','530522','腾冲县','306','0','0','Tengchong Xian','2');
INSERT INTO `on_region` VALUES ('2964','530523','龙陵县','306','0','0','Longling Xian','2');
INSERT INTO `on_region` VALUES ('2965','530524','昌宁县','306','0','0','Changning Xian','2');
INSERT INTO `on_region` VALUES ('2966','530601','市辖区','307','0','0','1','2');
INSERT INTO `on_region` VALUES ('2967','530602','昭阳区','307','0','0','Zhaoyang Qu','2');
INSERT INTO `on_region` VALUES ('2968','530621','鲁甸县','307','0','0','Ludian Xian','2');
INSERT INTO `on_region` VALUES ('2969','530622','巧家县','307','0','0','Qiaojia Xian','2');
INSERT INTO `on_region` VALUES ('2970','530623','盐津县','307','0','0','Yanjin Xian','2');
INSERT INTO `on_region` VALUES ('2971','530624','大关县','307','0','0','Daguan Xian','2');
INSERT INTO `on_region` VALUES ('2972','530625','永善县','307','0','0','Yongshan Xian','2');
INSERT INTO `on_region` VALUES ('2973','530626','绥江县','307','0','0','Suijiang Xian','2');
INSERT INTO `on_region` VALUES ('2974','530627','镇雄县','307','0','0','Zhenxiong Xian','2');
INSERT INTO `on_region` VALUES ('2975','530628','彝良县','307','0','0','Yiliang Xian','2');
INSERT INTO `on_region` VALUES ('2976','530629','威信县','307','0','0','Weixin Xian','2');
INSERT INTO `on_region` VALUES ('2977','530630','水富县','307','0','0','Shuifu Xian ','2');
INSERT INTO `on_region` VALUES ('2978','530701','市辖区','308','0','0','1','2');
INSERT INTO `on_region` VALUES ('2979','530702','古城区','308','0','0','Gucheng Qu','2');
INSERT INTO `on_region` VALUES ('2980','530721','玉龙纳西族自治县','308','0','0','Yulongnaxizuzizhi Xian','2');
INSERT INTO `on_region` VALUES ('2981','530722','永胜县','308','0','0','Yongsheng Xian','2');
INSERT INTO `on_region` VALUES ('2982','530723','华坪县','308','0','0','Huaping Xian','2');
INSERT INTO `on_region` VALUES ('2983','530724','宁蒗彝族自治县','308','0','0','Ninglang Yizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2984','530801','市辖区','309','0','0','1','2');
INSERT INTO `on_region` VALUES ('2985','530802','思茅区','309','0','0','Simao Qu','2');
INSERT INTO `on_region` VALUES ('2986','530821','宁洱哈尼族彝族自治县','309','0','0','Pu,er Hanizu Yizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2987','530822','墨江哈尼族自治县','309','0','0','Mojiang Hanizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2988','530823','景东彝族自治县','309','0','0','Jingdong Yizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2989','530824','景谷傣族彝族自治县','309','0','0','Jinggu Daizu Yizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2990','530825','镇沅彝族哈尼族拉祜族自治县','309','0','0','Zhenyuan Yizu Hanizu Lahuzu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2991','530826','江城哈尼族彝族自治县','309','0','0','Jiangcheng Hanizu Yizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2992','530827','孟连傣族拉祜族佤族自治县','309','0','0','Menglian Daizu Lahuzu Vazu Zizixian','2');
INSERT INTO `on_region` VALUES ('2993','530828','澜沧拉祜族自治县','309','0','0','Lancang Lahuzu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2994','530829','西盟佤族自治县','309','0','0','Ximeng Vazu Zizhixian','2');
INSERT INTO `on_region` VALUES ('2995','530901','市辖区','310','0','0','1','2');
INSERT INTO `on_region` VALUES ('2996','530902','临翔区','310','0','0','Linxiang Qu','2');
INSERT INTO `on_region` VALUES ('2997','530921','凤庆县','310','0','0','Fengqing Xian','2');
INSERT INTO `on_region` VALUES ('2998','530922','云县','310','0','0','Yun Xian','2');
INSERT INTO `on_region` VALUES ('2999','530923','永德县','310','0','0','Yongde Xian','2');
INSERT INTO `on_region` VALUES ('3000','530924','镇康县','310','0','0','Zhenkang Xian','2');
INSERT INTO `on_region` VALUES ('3001','530925','双江拉祜族佤族布朗族傣族自治县','310','0','0','Shuangjiang Lahuzu Vazu Bulangzu Daizu Zizhixian','2');
INSERT INTO `on_region` VALUES ('3002','530926','耿马傣族佤族自治县','310','0','0','Gengma Daizu Vazu Zizhixian','2');
INSERT INTO `on_region` VALUES ('3003','530927','沧源佤族自治县','310','0','0','Cangyuan Vazu Zizhixian','2');
INSERT INTO `on_region` VALUES ('3004','532301','楚雄市','311','0','0','Chuxiong Shi','CXS');
INSERT INTO `on_region` VALUES ('3005','532322','双柏县','311','0','0','Shuangbai Xian','SBA');
INSERT INTO `on_region` VALUES ('3006','532323','牟定县','311','0','0','Mouding Xian','MDI');
INSERT INTO `on_region` VALUES ('3007','532324','南华县','311','0','0','Nanhua Xian','NHA');
INSERT INTO `on_region` VALUES ('3008','532325','姚安县','311','0','0','Yao,an Xian','YOA');
INSERT INTO `on_region` VALUES ('3009','532326','大姚县','311','0','0','Dayao Xian','DYO');
INSERT INTO `on_region` VALUES ('3010','532327','永仁县','311','0','0','Yongren Xian','YRN');
INSERT INTO `on_region` VALUES ('3011','532328','元谋县','311','0','0','Yuanmou Xian','YMO');
INSERT INTO `on_region` VALUES ('3012','532329','武定县','311','0','0','Wuding Xian','WDX');
INSERT INTO `on_region` VALUES ('3013','532331','禄丰县','311','0','0','Lufeng Xian','LFX');
INSERT INTO `on_region` VALUES ('3014','532501','个旧市','312','0','0','Gejiu Shi','GJU');
INSERT INTO `on_region` VALUES ('3015','532502','开远市','312','0','0','Kaiyuan Shi','KYD');
INSERT INTO `on_region` VALUES ('3016','532503','蒙自市','312','0','0','Mengzi Xian','2');
INSERT INTO `on_region` VALUES ('3017','532523','屏边苗族自治县','312','0','0','Pingbian Miaozu Zizhixian','PBN');
INSERT INTO `on_region` VALUES ('3018','532524','建水县','312','0','0','Jianshui Xian','JSD');
INSERT INTO `on_region` VALUES ('3019','532525','石屏县','312','0','0','Shiping Xian','SPG');
INSERT INTO `on_region` VALUES ('3020','532526','弥勒县','312','0','0','Mile Xian','MIL');
INSERT INTO `on_region` VALUES ('3021','532527','泸西县','312','0','0','Luxi Xian','LXD');
INSERT INTO `on_region` VALUES ('3022','532528','元阳县','312','0','0','Yuanyang Xian','YYD');
INSERT INTO `on_region` VALUES ('3023','532529','红河县','312','0','0','Honghe Xian','HHX');
INSERT INTO `on_region` VALUES ('3024','532530','金平苗族瑶族傣族自治县','312','0','0','Jinping Miaozu Yaozu Daizu Zizhixian','JNP');
INSERT INTO `on_region` VALUES ('3025','532531','绿春县','312','0','0','Lvchun Xian','LCX');
INSERT INTO `on_region` VALUES ('3026','532532','河口瑶族自治县','312','0','0','Hekou Yaozu Zizhixian','HKM');
INSERT INTO `on_region` VALUES ('3027','532621','文山县','313','0','0','Wenshan Xian','WES');
INSERT INTO `on_region` VALUES ('3028','532622','砚山县','313','0','0','Yanshan Xian','YSD');
INSERT INTO `on_region` VALUES ('3029','532623','西畴县','313','0','0','Xichou Xian','XIC');
INSERT INTO `on_region` VALUES ('3030','532624','麻栗坡县','313','0','0','Malipo Xian','MLP');
INSERT INTO `on_region` VALUES ('3031','532625','马关县','313','0','0','Maguan Xian','MGN');
INSERT INTO `on_region` VALUES ('3032','532626','丘北县','313','0','0','Qiubei Xian','QBE');
INSERT INTO `on_region` VALUES ('3033','532627','广南县','313','0','0','Guangnan Xian','GGN');
INSERT INTO `on_region` VALUES ('3034','532628','富宁县','313','0','0','Funing Xian','FND');
INSERT INTO `on_region` VALUES ('3035','532801','景洪市','314','0','0','Jinghong Shi','JHG');
INSERT INTO `on_region` VALUES ('3036','532822','勐海县','314','0','0','Menghai Xian','MHI');
INSERT INTO `on_region` VALUES ('3037','532823','勐腊县','314','0','0','Mengla Xian','MLA');
INSERT INTO `on_region` VALUES ('3038','532901','大理市','315','0','0','Dali Shi','DLS');
INSERT INTO `on_region` VALUES ('3039','532922','漾濞彝族自治县','315','0','0','Yangbi Yizu Zizhixian','YGB');
INSERT INTO `on_region` VALUES ('3040','532923','祥云县','315','0','0','Xiangyun Xian','XYD');
INSERT INTO `on_region` VALUES ('3041','532924','宾川县','315','0','0','Binchuan Xian','BCD');
INSERT INTO `on_region` VALUES ('3042','532925','弥渡县','315','0','0','Midu Xian','MDU');
INSERT INTO `on_region` VALUES ('3043','532926','南涧彝族自治县','315','0','0','Nanjian Yizu Zizhixian','NNJ');
INSERT INTO `on_region` VALUES ('3044','532927','巍山彝族回族自治县','315','0','0','Weishan Yizu Huizu Zizhixian','WSY');
INSERT INTO `on_region` VALUES ('3045','532928','永平县','315','0','0','Yongping Xian','YPX');
INSERT INTO `on_region` VALUES ('3046','532929','云龙县','315','0','0','Yunlong Xian','YLO');
INSERT INTO `on_region` VALUES ('3047','532930','洱源县','315','0','0','Eryuan Xian','EYN');
INSERT INTO `on_region` VALUES ('3048','532931','剑川县','315','0','0','Jianchuan Xian','JIC');
INSERT INTO `on_region` VALUES ('3049','532932','鹤庆县','315','0','0','Heqing Xian','HQG');
INSERT INTO `on_region` VALUES ('3050','533102','瑞丽市','316','0','0','Ruili Shi','RUI');
INSERT INTO `on_region` VALUES ('3051','533103','芒市','316','0','0','Luxi Shi','2');
INSERT INTO `on_region` VALUES ('3052','533122','梁河县','316','0','0','Lianghe Xian','LHD');
INSERT INTO `on_region` VALUES ('3053','533123','盈江县','316','0','0','Yingjiang Xian','YGJ');
INSERT INTO `on_region` VALUES ('3054','533124','陇川县','316','0','0','Longchuan Xian','LCN');
INSERT INTO `on_region` VALUES ('3055','533321','泸水县','317','0','0','Lushui Xian','LSX');
INSERT INTO `on_region` VALUES ('3056','533323','福贡县','317','0','0','Fugong Xian','FGO');
INSERT INTO `on_region` VALUES ('3057','533324','贡山独龙族怒族自治县','317','0','0','Gongshan Dulongzu Nuzu Zizhixian','GSN');
INSERT INTO `on_region` VALUES ('3058','533325','兰坪白族普米族自治县','317','0','0','Lanping Baizu Pumizu Zizhixian','LPG');
INSERT INTO `on_region` VALUES ('3059','533421','香格里拉县','318','0','0','Xianggelila Xian','2');
INSERT INTO `on_region` VALUES ('3060','533422','德钦县','318','0','0','Deqen Xian','DQN');
INSERT INTO `on_region` VALUES ('3061','533423','维西傈僳族自治县','318','0','0','Weixi Lisuzu Zizhixian','WXI');
INSERT INTO `on_region` VALUES ('3062','540101','市辖区','319','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3063','540102','城关区','319','0','0','Chengguang Qu','CGN');
INSERT INTO `on_region` VALUES ('3064','540121','林周县','319','0','0','Lhvnzhub Xian','LZB');
INSERT INTO `on_region` VALUES ('3065','540122','当雄县','319','0','0','Damxung Xian','DAM');
INSERT INTO `on_region` VALUES ('3066','540123','尼木县','319','0','0','Nyemo Xian','NYE');
INSERT INTO `on_region` VALUES ('3067','540124','曲水县','319','0','0','Qvxv Xian','QUX');
INSERT INTO `on_region` VALUES ('3068','540125','堆龙德庆县','319','0','0','Doilungdeqen Xian','DOI');
INSERT INTO `on_region` VALUES ('3069','540126','达孜县','319','0','0','Dagze Xian','DAG');
INSERT INTO `on_region` VALUES ('3070','540127','墨竹工卡县','319','0','0','Maizhokunggar Xian','MAI');
INSERT INTO `on_region` VALUES ('3071','542121','昌都县','320','0','0','Qamdo Xian','QAX');
INSERT INTO `on_region` VALUES ('3072','542122','江达县','320','0','0','Jomda Xian','JOM');
INSERT INTO `on_region` VALUES ('3073','542123','贡觉县','320','0','0','Konjo Xian','KON');
INSERT INTO `on_region` VALUES ('3074','542124','类乌齐县','320','0','0','Riwoqe Xian','RIW');
INSERT INTO `on_region` VALUES ('3075','542125','丁青县','320','0','0','Dengqen Xian','DEN');
INSERT INTO `on_region` VALUES ('3076','542126','察雅县','320','0','0','Chagyab Xian','CHA');
INSERT INTO `on_region` VALUES ('3077','542127','八宿县','320','0','0','Baxoi Xian','BAX');
INSERT INTO `on_region` VALUES ('3078','542128','左贡县','320','0','0','Zogang Xian','ZOX');
INSERT INTO `on_region` VALUES ('3079','542129','芒康县','320','0','0','Mangkam Xian','MAN');
INSERT INTO `on_region` VALUES ('3080','542132','洛隆县','320','0','0','Lhorong Xian','LHO');
INSERT INTO `on_region` VALUES ('3081','542133','边坝县','320','0','0','Banbar Xian','BAN');
INSERT INTO `on_region` VALUES ('3082','542221','乃东县','321','0','0','Nedong Xian','NED');
INSERT INTO `on_region` VALUES ('3083','542222','扎囊县','321','0','0','Chanang(Chatang) Xian','CNG');
INSERT INTO `on_region` VALUES ('3084','542223','贡嘎县','321','0','0','Gonggar Xian','GON');
INSERT INTO `on_region` VALUES ('3085','542224','桑日县','321','0','0','Sangri Xian','SRI');
INSERT INTO `on_region` VALUES ('3086','542225','琼结县','321','0','0','Qonggyai Xian','QON');
INSERT INTO `on_region` VALUES ('3087','542226','曲松县','321','0','0','Qusum Xian','QUS');
INSERT INTO `on_region` VALUES ('3088','542227','措美县','321','0','0','Comai Xian','COM');
INSERT INTO `on_region` VALUES ('3089','542228','洛扎县','321','0','0','Lhozhag Xian','LHX');
INSERT INTO `on_region` VALUES ('3090','542229','加查县','321','0','0','Gyaca Xian','GYA');
INSERT INTO `on_region` VALUES ('3091','542231','隆子县','321','0','0','Lhvnze Xian','LHZ');
INSERT INTO `on_region` VALUES ('3092','542232','错那县','321','0','0','Cona Xian','CON');
INSERT INTO `on_region` VALUES ('3093','542233','浪卡子县','321','0','0','Nagarze Xian','NAX');
INSERT INTO `on_region` VALUES ('3094','542301','日喀则市','322','0','0','Xigaze Shi','XIG');
INSERT INTO `on_region` VALUES ('3095','542322','南木林县','322','0','0','Namling Xian','NAM');
INSERT INTO `on_region` VALUES ('3096','542323','江孜县','322','0','0','Gyangze Xian','GYZ');
INSERT INTO `on_region` VALUES ('3097','542324','定日县','322','0','0','Tingri Xian','TIN');
INSERT INTO `on_region` VALUES ('3098','542325','萨迦县','322','0','0','Sa,gya Xian','SGX');
INSERT INTO `on_region` VALUES ('3099','542326','拉孜县','322','0','0','Lhaze Xian','LAZ');
INSERT INTO `on_region` VALUES ('3100','542327','昂仁县','322','0','0','Ngamring Xian','NGA');
INSERT INTO `on_region` VALUES ('3101','542328','谢通门县','322','0','0','Xaitongmoin Xian','XTM');
INSERT INTO `on_region` VALUES ('3102','542329','白朗县','322','0','0','Bainang Xian','BAI');
INSERT INTO `on_region` VALUES ('3103','542330','仁布县','322','0','0','Rinbung Xian','RIN');
INSERT INTO `on_region` VALUES ('3104','542331','康马县','322','0','0','Kangmar Xian','KAN');
INSERT INTO `on_region` VALUES ('3105','542332','定结县','322','0','0','Dinggye Xian','DIN');
INSERT INTO `on_region` VALUES ('3106','542333','仲巴县','322','0','0','Zhongba Xian','ZHB');
INSERT INTO `on_region` VALUES ('3107','542334','亚东县','322','0','0','Yadong(Chomo) Xian','YDZ');
INSERT INTO `on_region` VALUES ('3108','542335','吉隆县','322','0','0','Gyirong Xian','GIR');
INSERT INTO `on_region` VALUES ('3109','542336','聂拉木县','322','0','0','Nyalam Xian','NYA');
INSERT INTO `on_region` VALUES ('3110','542337','萨嘎县','322','0','0','Saga Xian','SAG');
INSERT INTO `on_region` VALUES ('3111','542338','岗巴县','322','0','0','Gamba Xian','GAM');
INSERT INTO `on_region` VALUES ('3112','542421','那曲县','323','0','0','Nagqu Xian','NAG');
INSERT INTO `on_region` VALUES ('3113','542422','嘉黎县','323','0','0','Lhari Xian','LHR');
INSERT INTO `on_region` VALUES ('3114','542423','比如县','323','0','0','Biru Xian','BRU');
INSERT INTO `on_region` VALUES ('3115','542424','聂荣县','323','0','0','Nyainrong Xian','NRO');
INSERT INTO `on_region` VALUES ('3116','542425','安多县','323','0','0','Amdo Xian','AMD');
INSERT INTO `on_region` VALUES ('3117','542426','申扎县','323','0','0','Xainza Xian','XZX');
INSERT INTO `on_region` VALUES ('3118','542427','索县','323','0','0','Sog Xian','SOG');
INSERT INTO `on_region` VALUES ('3119','542428','班戈县','323','0','0','Bangoin Xian','BGX');
INSERT INTO `on_region` VALUES ('3120','542429','巴青县','323','0','0','Baqen Xian','BQE');
INSERT INTO `on_region` VALUES ('3121','542430','尼玛县','323','0','0','Nyima Xian','NYX');
INSERT INTO `on_region` VALUES ('3122','542521','普兰县','324','0','0','Burang Xian','BUR');
INSERT INTO `on_region` VALUES ('3123','542522','札达县','324','0','0','Zanda Xian','ZAN');
INSERT INTO `on_region` VALUES ('3124','542523','噶尔县','324','0','0','Gar Xian','GAR');
INSERT INTO `on_region` VALUES ('3125','542524','日土县','324','0','0','Rutog Xian','RUT');
INSERT INTO `on_region` VALUES ('3126','542525','革吉县','324','0','0','Ge,gyai Xian','GEG');
INSERT INTO `on_region` VALUES ('3127','542526','改则县','324','0','0','Gerze Xian','GER');
INSERT INTO `on_region` VALUES ('3128','542527','措勤县','324','0','0','Coqen Xian','COQ');
INSERT INTO `on_region` VALUES ('3129','542621','林芝县','325','0','0','Nyingchi Xian','NYI');
INSERT INTO `on_region` VALUES ('3130','542622','工布江达县','325','0','0','Gongbo,gyamda Xian','GOX');
INSERT INTO `on_region` VALUES ('3131','542623','米林县','325','0','0','Mainling Xian','MAX');
INSERT INTO `on_region` VALUES ('3132','542624','墨脱县','325','0','0','Metog Xian','MET');
INSERT INTO `on_region` VALUES ('3133','542625','波密县','325','0','0','Bomi(Bowo) Xian','BMI');
INSERT INTO `on_region` VALUES ('3134','542626','察隅县','325','0','0','Zayv Xian','ZAY');
INSERT INTO `on_region` VALUES ('3135','542627','朗县','325','0','0','Nang Xian','NGX');
INSERT INTO `on_region` VALUES ('3136','610101','市辖区','326','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3137','610102','新城区','326','0','0','Xincheng Qu','XCK');
INSERT INTO `on_region` VALUES ('3138','610103','碑林区','326','0','0','Beilin Qu','BLQ');
INSERT INTO `on_region` VALUES ('3139','610104','莲湖区','326','0','0','Lianhu Qu','LHU');
INSERT INTO `on_region` VALUES ('3140','610111','灞桥区','326','0','0','Baqiao Qu','BQQ');
INSERT INTO `on_region` VALUES ('3141','610112','未央区','326','0','0','Weiyang Qu','2');
INSERT INTO `on_region` VALUES ('3142','610113','雁塔区','326','0','0','Yanta Qu','YTA');
INSERT INTO `on_region` VALUES ('3143','610114','阎良区','326','0','0','Yanliang Qu','YLQ');
INSERT INTO `on_region` VALUES ('3144','610115','临潼区','326','0','0','Lintong Qu','LTG');
INSERT INTO `on_region` VALUES ('3145','610116','长安区','326','0','0','Changan Qu','2');
INSERT INTO `on_region` VALUES ('3146','610122','蓝田县','326','0','0','Lantian Xian','LNT');
INSERT INTO `on_region` VALUES ('3147','610124','周至县','326','0','0','Zhouzhi Xian','ZOZ');
INSERT INTO `on_region` VALUES ('3148','610125','户县','326','0','0','Hu Xian','HUX');
INSERT INTO `on_region` VALUES ('3149','610126','高陵县','326','0','0','Gaoling Xian','GLS');
INSERT INTO `on_region` VALUES ('3150','610201','市辖区','327','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3151','610202','王益区','327','0','0','Wangyi Qu','2');
INSERT INTO `on_region` VALUES ('3152','610203','印台区','327','0','0','Yintai Qu','2');
INSERT INTO `on_region` VALUES ('3153','610204','耀州区','327','0','0','Yaozhou Qu','2');
INSERT INTO `on_region` VALUES ('3154','610222','宜君县','327','0','0','Yijun Xian','YJU');
INSERT INTO `on_region` VALUES ('3155','610301','市辖区','328','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3156','610302','渭滨区','328','0','0','Weibin Qu','WBQ');
INSERT INTO `on_region` VALUES ('3157','610303','金台区','328','0','0','Jintai Qu','JTQ');
INSERT INTO `on_region` VALUES ('3158','610304','陈仓区','328','0','0','Chencang Qu','2');
INSERT INTO `on_region` VALUES ('3159','610322','凤翔县','328','0','0','Fengxiang Xian','FXG');
INSERT INTO `on_region` VALUES ('3160','610323','岐山县','328','0','0','Qishan Xian','QIS');
INSERT INTO `on_region` VALUES ('3161','610324','扶风县','328','0','0','Fufeng Xian','FFG');
INSERT INTO `on_region` VALUES ('3162','610326','眉县','328','0','0','Mei Xian','MEI');
INSERT INTO `on_region` VALUES ('3163','610327','陇县','328','0','0','Long Xian','LON');
INSERT INTO `on_region` VALUES ('3164','610328','千阳县','328','0','0','Qianyang Xian','QNY');
INSERT INTO `on_region` VALUES ('3165','610329','麟游县','328','0','0','Linyou Xian','LYP');
INSERT INTO `on_region` VALUES ('3166','610330','凤县','328','0','0','Feng Xian','FEG');
INSERT INTO `on_region` VALUES ('3167','610331','太白县','328','0','0','Taibai Xian','TBA');
INSERT INTO `on_region` VALUES ('3168','610401','市辖区','329','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3169','610402','秦都区','329','0','0','Qindu Qu','QDU');
INSERT INTO `on_region` VALUES ('3170','610403','杨陵区','329','0','0','Yangling Qu','YGL');
INSERT INTO `on_region` VALUES ('3171','610404','渭城区','329','0','0','Weicheng Qu','WIC');
INSERT INTO `on_region` VALUES ('3172','610422','三原县','329','0','0','Sanyuan Xian','SYN');
INSERT INTO `on_region` VALUES ('3173','610423','泾阳县','329','0','0','Jingyang Xian','JGY');
INSERT INTO `on_region` VALUES ('3174','610424','乾县','329','0','0','Qian Xian','QIA');
INSERT INTO `on_region` VALUES ('3175','610425','礼泉县','329','0','0','Liquan Xian','LIQ');
INSERT INTO `on_region` VALUES ('3176','610426','永寿县','329','0','0','Yongshou Xian','YSH');
INSERT INTO `on_region` VALUES ('3177','610427','彬县','329','0','0','Bin Xian','BIX');
INSERT INTO `on_region` VALUES ('3178','610428','长武县','329','0','0','Changwu Xian','CWU');
INSERT INTO `on_region` VALUES ('3179','610429','旬邑县','329','0','0','Xunyi Xian','XNY');
INSERT INTO `on_region` VALUES ('3180','610430','淳化县','329','0','0','Chunhua Xian','CHU');
INSERT INTO `on_region` VALUES ('3181','610431','武功县','329','0','0','Wugong Xian','WGG');
INSERT INTO `on_region` VALUES ('3182','610481','兴平市','329','0','0','Xingping Shi','XPG');
INSERT INTO `on_region` VALUES ('3183','610501','市辖区','330','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3184','610502','临渭区','330','0','0','Linwei Qu','LWE');
INSERT INTO `on_region` VALUES ('3185','610521','华县','330','0','0','Hua Xian','HXN');
INSERT INTO `on_region` VALUES ('3186','610522','潼关县','330','0','0','Tongguan Xian','TGN');
INSERT INTO `on_region` VALUES ('3187','610523','大荔县','330','0','0','Dali Xian','DAL');
INSERT INTO `on_region` VALUES ('3188','610524','合阳县','330','0','0','Heyang Xian','HYK');
INSERT INTO `on_region` VALUES ('3189','610525','澄城县','330','0','0','Chengcheng Xian','CCG');
INSERT INTO `on_region` VALUES ('3190','610526','蒲城县','330','0','0','Pucheng Xian','PUC');
INSERT INTO `on_region` VALUES ('3191','610527','白水县','330','0','0','Baishui Xian','BSU');
INSERT INTO `on_region` VALUES ('3192','610528','富平县','330','0','0','Fuping Xian','FPX');
INSERT INTO `on_region` VALUES ('3193','610581','韩城市','330','0','0','Hancheng Shi','HCE');
INSERT INTO `on_region` VALUES ('3194','610582','华阴市','330','0','0','Huayin Shi','HYI');
INSERT INTO `on_region` VALUES ('3195','610601','市辖区','331','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3196','610602','宝塔区','331','0','0','Baota Qu','BTA');
INSERT INTO `on_region` VALUES ('3197','610621','延长县','331','0','0','Yanchang Xian','YCA');
INSERT INTO `on_region` VALUES ('3198','610622','延川县','331','0','0','Yanchuan Xian','YCT');
INSERT INTO `on_region` VALUES ('3199','610623','子长县','331','0','0','Zichang Xian','ZCA');
INSERT INTO `on_region` VALUES ('3200','610624','安塞县','331','0','0','Ansai Xian','ANS');
INSERT INTO `on_region` VALUES ('3201','610625','志丹县','331','0','0','Zhidan Xian','ZDN');
INSERT INTO `on_region` VALUES ('3202','610626','吴起县','331','0','0','Wuqi Xian','2');
INSERT INTO `on_region` VALUES ('3203','610627','甘泉县','331','0','0','Ganquan Xian','GQN');
INSERT INTO `on_region` VALUES ('3204','610628','富县','331','0','0','Fu Xian','FUX');
INSERT INTO `on_region` VALUES ('3205','610629','洛川县','331','0','0','Luochuan Xian','LCW');
INSERT INTO `on_region` VALUES ('3206','610630','宜川县','331','0','0','Yichuan Xian','YIC');
INSERT INTO `on_region` VALUES ('3207','610631','黄龙县','331','0','0','Huanglong Xian','HGL');
INSERT INTO `on_region` VALUES ('3208','610632','黄陵县','331','0','0','Huangling Xian','HLG');
INSERT INTO `on_region` VALUES ('3209','610701','市辖区','332','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3210','610702','汉台区','332','0','0','Hantai Qu','HTQ');
INSERT INTO `on_region` VALUES ('3211','610721','南郑县','332','0','0','Nanzheng Xian','NZG');
INSERT INTO `on_region` VALUES ('3212','610722','城固县','332','0','0','Chenggu Xian','CGU');
INSERT INTO `on_region` VALUES ('3213','610723','洋县','332','0','0','Yang Xian','YGX');
INSERT INTO `on_region` VALUES ('3214','610724','西乡县','332','0','0','Xixiang Xian','XXA');
INSERT INTO `on_region` VALUES ('3215','610725','勉县','332','0','0','Mian Xian','MIA');
INSERT INTO `on_region` VALUES ('3216','610726','宁强县','332','0','0','Ningqiang Xian','NQG');
INSERT INTO `on_region` VALUES ('3217','610727','略阳县','332','0','0','Lueyang Xian','LYC');
INSERT INTO `on_region` VALUES ('3218','610728','镇巴县','332','0','0','Zhenba Xian','ZBA');
INSERT INTO `on_region` VALUES ('3219','610729','留坝县','332','0','0','Liuba Xian','LBA');
INSERT INTO `on_region` VALUES ('3220','610730','佛坪县','332','0','0','Foping Xian','FPG');
INSERT INTO `on_region` VALUES ('3221','610801','市辖区','333','0','0','1','2');
INSERT INTO `on_region` VALUES ('3222','610802','榆阳区','333','0','0','Yuyang Qu','2');
INSERT INTO `on_region` VALUES ('3223','610821','神木县','333','0','0','Shenmu Xian','2');
INSERT INTO `on_region` VALUES ('3224','610822','府谷县','333','0','0','Fugu Xian','2');
INSERT INTO `on_region` VALUES ('3225','610823','横山县','333','0','0','Hengshan Xian','2');
INSERT INTO `on_region` VALUES ('3226','610824','靖边县','333','0','0','Jingbian Xian','2');
INSERT INTO `on_region` VALUES ('3227','610825','定边县','333','0','0','Dingbian Xian','2');
INSERT INTO `on_region` VALUES ('3228','610826','绥德县','333','0','0','Suide Xian','2');
INSERT INTO `on_region` VALUES ('3229','610827','米脂县','333','0','0','Mizhi Xian','2');
INSERT INTO `on_region` VALUES ('3230','610828','佳县','333','0','0','Jia Xian','2');
INSERT INTO `on_region` VALUES ('3231','610829','吴堡县','333','0','0','Wubu Xian','2');
INSERT INTO `on_region` VALUES ('3232','610830','清涧县','333','0','0','Qingjian Xian','2');
INSERT INTO `on_region` VALUES ('3233','610831','子洲县','333','0','0','Zizhou Xian','2');
INSERT INTO `on_region` VALUES ('3234','610901','市辖区','334','0','0','1','2');
INSERT INTO `on_region` VALUES ('3235','610902','汉滨区','334','0','0','Hanbin Qu','2');
INSERT INTO `on_region` VALUES ('3236','610921','汉阴县','334','0','0','Hanyin Xian','2');
INSERT INTO `on_region` VALUES ('3237','610922','石泉县','334','0','0','Shiquan Xian','2');
INSERT INTO `on_region` VALUES ('3238','610923','宁陕县','334','0','0','Ningshan Xian','2');
INSERT INTO `on_region` VALUES ('3239','610924','紫阳县','334','0','0','Ziyang Xian','2');
INSERT INTO `on_region` VALUES ('3240','610925','岚皋县','334','0','0','Langao Xian','2');
INSERT INTO `on_region` VALUES ('3241','610926','平利县','334','0','0','Pingli Xian','2');
INSERT INTO `on_region` VALUES ('3242','610927','镇坪县','334','0','0','Zhenping Xian','2');
INSERT INTO `on_region` VALUES ('3243','610928','旬阳县','334','0','0','Xunyang Xian','2');
INSERT INTO `on_region` VALUES ('3244','610929','白河县','334','0','0','Baihe Xian','2');
INSERT INTO `on_region` VALUES ('3245','611001','市辖区','335','0','0','1','2');
INSERT INTO `on_region` VALUES ('3246','611002','商州区','335','0','0','Shangzhou Qu','2');
INSERT INTO `on_region` VALUES ('3247','611021','洛南县','335','0','0','Luonan Xian','2');
INSERT INTO `on_region` VALUES ('3248','611022','丹凤县','335','0','0','Danfeng Xian','2');
INSERT INTO `on_region` VALUES ('3249','611023','商南县','335','0','0','Shangnan Xian','2');
INSERT INTO `on_region` VALUES ('3250','611024','山阳县','335','0','0','Shanyang Xian','2');
INSERT INTO `on_region` VALUES ('3251','611025','镇安县','335','0','0','Zhen,an Xian','2');
INSERT INTO `on_region` VALUES ('3252','611026','柞水县','335','0','0','Zhashui Xian','2');
INSERT INTO `on_region` VALUES ('3253','620101','市辖区','336','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3254','620102','城关区','336','0','0','Chengguan Qu','CLZ');
INSERT INTO `on_region` VALUES ('3255','620103','七里河区','336','0','0','Qilihe Qu','QLH');
INSERT INTO `on_region` VALUES ('3256','620104','西固区','336','0','0','Xigu Qu','XGU');
INSERT INTO `on_region` VALUES ('3257','620105','安宁区','336','0','0','Anning Qu','ANQ');
INSERT INTO `on_region` VALUES ('3258','620111','红古区','336','0','0','Honggu Qu','HOG');
INSERT INTO `on_region` VALUES ('3259','620121','永登县','336','0','0','Yongdeng Xian','YDG');
INSERT INTO `on_region` VALUES ('3260','620122','皋兰县','336','0','0','Gaolan Xian','GAL');
INSERT INTO `on_region` VALUES ('3261','620123','榆中县','336','0','0','Yuzhong Xian','YZX');
INSERT INTO `on_region` VALUES ('3262','620201','市辖区','337','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3263','620301','市辖区','338','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3264','620302','金川区','338','0','0','Jinchuan Qu','JCU');
INSERT INTO `on_region` VALUES ('3265','620321','永昌县','338','0','0','Yongchang Xian','YCF');
INSERT INTO `on_region` VALUES ('3266','620401','市辖区','339','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3267','620402','白银区','339','0','0','Baiyin Qu','BYB');
INSERT INTO `on_region` VALUES ('3268','620403','平川区','339','0','0','Pingchuan Qu','PCQ');
INSERT INTO `on_region` VALUES ('3269','620421','靖远县','339','0','0','Jingyuan Xian','JYH');
INSERT INTO `on_region` VALUES ('3270','620422','会宁县','339','0','0','Huining xian','HNI');
INSERT INTO `on_region` VALUES ('3271','620423','景泰县','339','0','0','Jingtai Xian','JGT');
INSERT INTO `on_region` VALUES ('3272','620501','市辖区','340','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3274','620502','秦州区','340','0','0','Beidao Qu','2');
INSERT INTO `on_region` VALUES ('3275','620521','清水县','340','0','0','Qingshui Xian','QSG');
INSERT INTO `on_region` VALUES ('3276','620522','秦安县','340','0','0','Qin,an Xian','QNA');
INSERT INTO `on_region` VALUES ('3277','620523','甘谷县','340','0','0','Gangu Xian','GGU');
INSERT INTO `on_region` VALUES ('3278','620524','武山县','340','0','0','Wushan Xian','WSX');
INSERT INTO `on_region` VALUES ('3279','620525','张家川回族自治县','340','0','0','Zhangjiachuan Huizu Zizhixian','ZJC');
INSERT INTO `on_region` VALUES ('3280','620601','市辖区','341','0','0','1','2');
INSERT INTO `on_region` VALUES ('3281','620602','凉州区','341','0','0','Liangzhou Qu','2');
INSERT INTO `on_region` VALUES ('3282','620621','民勤县','341','0','0','Minqin Xian','2');
INSERT INTO `on_region` VALUES ('3283','620622','古浪县','341','0','0','Gulang Xian','2');
INSERT INTO `on_region` VALUES ('3284','620623','天祝藏族自治县','341','0','0','Tianzhu Zangzu Zizhixian','2');
INSERT INTO `on_region` VALUES ('3285','620701','市辖区','342','0','0','1','2');
INSERT INTO `on_region` VALUES ('3286','620702','甘州区','342','0','0','Ganzhou Qu','2');
INSERT INTO `on_region` VALUES ('3287','620721','肃南裕固族自治县','342','0','0','Sunan Yugurzu Zizhixian','2');
INSERT INTO `on_region` VALUES ('3288','620722','民乐县','342','0','0','Minle Xian','2');
INSERT INTO `on_region` VALUES ('3289','620723','临泽县','342','0','0','Linze Xian','2');
INSERT INTO `on_region` VALUES ('3290','620724','高台县','342','0','0','Gaotai Xian','2');
INSERT INTO `on_region` VALUES ('3291','620725','山丹县','342','0','0','Shandan Xian','2');
INSERT INTO `on_region` VALUES ('3292','620801','市辖区','343','0','0','1','2');
INSERT INTO `on_region` VALUES ('3293','620802','崆峒区','343','0','0','Kongdong Qu','2');
INSERT INTO `on_region` VALUES ('3294','620821','泾川县','343','0','0','Jingchuan Xian','2');
INSERT INTO `on_region` VALUES ('3295','620822','灵台县','343','0','0','Lingtai Xian','2');
INSERT INTO `on_region` VALUES ('3296','620823','崇信县','343','0','0','Chongxin Xian','2');
INSERT INTO `on_region` VALUES ('3297','620824','华亭县','343','0','0','Huating Xian','2');
INSERT INTO `on_region` VALUES ('3298','620825','庄浪县','343','0','0','Zhuanglang Xian','2');
INSERT INTO `on_region` VALUES ('3299','620826','静宁县','343','0','0','Jingning Xian','2');
INSERT INTO `on_region` VALUES ('3300','620901','市辖区','344','0','0','1','2');
INSERT INTO `on_region` VALUES ('3301','620902','肃州区','344','0','0','Suzhou Qu','2');
INSERT INTO `on_region` VALUES ('3302','620921','金塔县','344','0','0','Jinta Xian','2');
INSERT INTO `on_region` VALUES ('3304','620923','肃北蒙古族自治县','344','0','0','Subei Monguzu Zizhixian','2');
INSERT INTO `on_region` VALUES ('3305','620924','阿克塞哈萨克族自治县','344','0','0','Aksay Kazakzu Zizhixian','2');
INSERT INTO `on_region` VALUES ('3306','620981','玉门市','344','0','0','Yumen Shi','2');
INSERT INTO `on_region` VALUES ('3307','620982','敦煌市','344','0','0','Dunhuang Shi','2');
INSERT INTO `on_region` VALUES ('3308','621001','市辖区','345','0','0','1','2');
INSERT INTO `on_region` VALUES ('3309','621002','西峰区','345','0','0','Xifeng Qu','2');
INSERT INTO `on_region` VALUES ('3310','621021','庆城县','345','0','0','Qingcheng Xian','2');
INSERT INTO `on_region` VALUES ('3311','621022','环县','345','0','0','Huan Xian','2');
INSERT INTO `on_region` VALUES ('3312','621023','华池县','345','0','0','Huachi Xian','2');
INSERT INTO `on_region` VALUES ('3313','621024','合水县','345','0','0','Heshui Xian','2');
INSERT INTO `on_region` VALUES ('3314','621025','正宁县','345','0','0','Zhengning Xian','2');
INSERT INTO `on_region` VALUES ('3315','621026','宁县','345','0','0','Ning Xian','2');
INSERT INTO `on_region` VALUES ('3316','621027','镇原县','345','0','0','Zhenyuan Xian','2');
INSERT INTO `on_region` VALUES ('3317','621101','市辖区','346','0','0','1','2');
INSERT INTO `on_region` VALUES ('3318','621102','安定区','346','0','0','Anding Qu','2');
INSERT INTO `on_region` VALUES ('3319','621121','通渭县','346','0','0','Tongwei Xian','2');
INSERT INTO `on_region` VALUES ('3320','621122','陇西县','346','0','0','Longxi Xian','2');
INSERT INTO `on_region` VALUES ('3321','621123','渭源县','346','0','0','Weiyuan Xian','2');
INSERT INTO `on_region` VALUES ('3322','621124','临洮县','346','0','0','Lintao Xian','2');
INSERT INTO `on_region` VALUES ('3323','621125','漳县','346','0','0','Zhang Xian','2');
INSERT INTO `on_region` VALUES ('3324','621126','岷县','346','0','0','Min Xian','2');
INSERT INTO `on_region` VALUES ('3325','621201','市辖区','347','0','0','1','2');
INSERT INTO `on_region` VALUES ('3326','621202','武都区','347','0','0','Wudu Qu','2');
INSERT INTO `on_region` VALUES ('3327','621221','成县','347','0','0','Cheng Xian','2');
INSERT INTO `on_region` VALUES ('3328','621222','文县','347','0','0','Wen Xian','2');
INSERT INTO `on_region` VALUES ('3329','621223','宕昌县','347','0','0','Dangchang Xian','2');
INSERT INTO `on_region` VALUES ('3330','621224','康县','347','0','0','Kang Xian','2');
INSERT INTO `on_region` VALUES ('3331','621225','西和县','347','0','0','Xihe Xian','2');
INSERT INTO `on_region` VALUES ('3332','621226','礼县','347','0','0','Li Xian','2');
INSERT INTO `on_region` VALUES ('3333','621227','徽县','347','0','0','Hui Xian','2');
INSERT INTO `on_region` VALUES ('3334','621228','两当县','347','0','0','Liangdang Xian','2');
INSERT INTO `on_region` VALUES ('3335','622901','临夏市','348','0','0','Linxia Shi','LXR');
INSERT INTO `on_region` VALUES ('3336','622921','临夏县','348','0','0','Linxia Xian','LXF');
INSERT INTO `on_region` VALUES ('3337','622922','康乐县','348','0','0','Kangle Xian','KLE');
INSERT INTO `on_region` VALUES ('3338','622923','永靖县','348','0','0','Yongjing Xian','YJG');
INSERT INTO `on_region` VALUES ('3339','622924','广河县','348','0','0','Guanghe Xian','GHX');
INSERT INTO `on_region` VALUES ('3340','622925','和政县','348','0','0','Hezheng Xian','HZG');
INSERT INTO `on_region` VALUES ('3341','622926','东乡族自治县','348','0','0','Dongxiangzu Zizhixian','DXZ');
INSERT INTO `on_region` VALUES ('3342','622927','积石山保安族东乡族撒拉族自治县','348','0','0','Jishishan Bonanzu Dongxiangzu Salarzu Zizhixian','JSN');
INSERT INTO `on_region` VALUES ('3343','623001','合作市','349','0','0','Hezuo Shi','HEZ');
INSERT INTO `on_region` VALUES ('3344','623021','临潭县','349','0','0','Lintan Xian','LTN');
INSERT INTO `on_region` VALUES ('3345','623022','卓尼县','349','0','0','Jone','JON');
INSERT INTO `on_region` VALUES ('3346','623023','舟曲县','349','0','0','Zhugqu Xian','ZQU');
INSERT INTO `on_region` VALUES ('3347','623024','迭部县','349','0','0','Tewo Xian','TEW');
INSERT INTO `on_region` VALUES ('3348','623025','玛曲县','349','0','0','Maqu Xian','MQU');
INSERT INTO `on_region` VALUES ('3349','623026','碌曲县','349','0','0','Luqu Xian','LQU');
INSERT INTO `on_region` VALUES ('3350','623027','夏河县','349','0','0','Xiahe Xian','XHN');
INSERT INTO `on_region` VALUES ('3351','630101','市辖区','350','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3352','630102','城东区','350','0','0','Chengdong Qu','CDQ');
INSERT INTO `on_region` VALUES ('3353','630103','城中区','350','0','0','Chengzhong Qu','CZQ');
INSERT INTO `on_region` VALUES ('3354','630104','城西区','350','0','0','Chengxi Qu','CXQ');
INSERT INTO `on_region` VALUES ('3355','630105','城北区','350','0','0','Chengbei Qu','CBE');
INSERT INTO `on_region` VALUES ('3356','630121','大通回族土族自治县','350','0','0','Datong Huizu Tuzu Zizhixian','DAT');
INSERT INTO `on_region` VALUES ('3357','630122','湟中县','350','0','0','Huangzhong Xian','2');
INSERT INTO `on_region` VALUES ('3358','630123','湟源县','350','0','0','Huangyuan Xian','2');
INSERT INTO `on_region` VALUES ('3359','632121','平安县','351','0','0','Ping,an Xian','PAN');
INSERT INTO `on_region` VALUES ('3360','632122','民和回族土族自治县','351','0','0','Minhe Huizu Tuzu Zizhixian','MHE');
INSERT INTO `on_region` VALUES ('3361','632123','乐都县','351','0','0','Ledu Xian','LDU');
INSERT INTO `on_region` VALUES ('3362','632126','互助土族自治县','351','0','0','Huzhu Tuzu Zizhixian','HZT');
INSERT INTO `on_region` VALUES ('3363','632127','化隆回族自治县','351','0','0','Hualong Huizu Zizhixian','HLO');
INSERT INTO `on_region` VALUES ('3364','632128','循化撒拉族自治县','351','0','0','Xunhua Salazu Zizhixian','XUH');
INSERT INTO `on_region` VALUES ('3365','632221','门源回族自治县','352','0','0','Menyuan Huizu Zizhixian','MYU');
INSERT INTO `on_region` VALUES ('3366','632222','祁连县','352','0','0','Qilian Xian','QLN');
INSERT INTO `on_region` VALUES ('3367','632223','海晏县','352','0','0','Haiyan Xian','HIY');
INSERT INTO `on_region` VALUES ('3368','632224','刚察县','352','0','0','Gangca Xian','GAN');
INSERT INTO `on_region` VALUES ('3369','632321','同仁县','353','0','0','Tongren Xian','TRN');
INSERT INTO `on_region` VALUES ('3370','632322','尖扎县','353','0','0','Jainca Xian','JAI');
INSERT INTO `on_region` VALUES ('3371','632323','泽库县','353','0','0','Zekog Xian','ZEK');
INSERT INTO `on_region` VALUES ('3372','632324','河南蒙古族自治县','353','0','0','Henan Mongolzu Zizhixian','HNM');
INSERT INTO `on_region` VALUES ('3373','632521','共和县','354','0','0','Gonghe Xian','GHE');
INSERT INTO `on_region` VALUES ('3374','632522','同德县','354','0','0','Tongde Xian','TDX');
INSERT INTO `on_region` VALUES ('3375','632523','贵德县','354','0','0','Guide Xian','GID');
INSERT INTO `on_region` VALUES ('3376','632524','兴海县','354','0','0','Xinghai Xian','XHA');
INSERT INTO `on_region` VALUES ('3377','632525','贵南县','354','0','0','Guinan Xian','GNN');
INSERT INTO `on_region` VALUES ('3378','632621','玛沁县','355','0','0','Maqen Xian','MAQ');
INSERT INTO `on_region` VALUES ('3379','632622','班玛县','355','0','0','Baima Xian','BMX');
INSERT INTO `on_region` VALUES ('3380','632623','甘德县','355','0','0','Gade Xian','GAD');
INSERT INTO `on_region` VALUES ('3381','632624','达日县','355','0','0','Tarlag Xian','TAR');
INSERT INTO `on_region` VALUES ('3382','632625','久治县','355','0','0','Jigzhi Xian','JUZ');
INSERT INTO `on_region` VALUES ('3383','632626','玛多县','355','0','0','Madoi Xian','MAD');
INSERT INTO `on_region` VALUES ('3384','632721','玉树县','356','0','0','Yushu Xian','YSK');
INSERT INTO `on_region` VALUES ('3385','632722','杂多县','356','0','0','Zadoi Xian','ZAD');
INSERT INTO `on_region` VALUES ('3386','632723','称多县','356','0','0','Chindu Xian','CHI');
INSERT INTO `on_region` VALUES ('3387','632724','治多县','356','0','0','Zhidoi Xian','ZHI');
INSERT INTO `on_region` VALUES ('3388','632725','囊谦县','356','0','0','Nangqen Xian','NQN');
INSERT INTO `on_region` VALUES ('3389','632726','曲麻莱县','356','0','0','Qumarleb Xian','QUM');
INSERT INTO `on_region` VALUES ('3390','632801','格尔木市','357','0','0','Golmud Shi','GOS');
INSERT INTO `on_region` VALUES ('3391','632802','德令哈市','357','0','0','Delhi Shi','DEL');
INSERT INTO `on_region` VALUES ('3392','632821','乌兰县','357','0','0','Ulan Xian','ULA');
INSERT INTO `on_region` VALUES ('3393','632822','都兰县','357','0','0','Dulan Xian','DUL');
INSERT INTO `on_region` VALUES ('3394','632823','天峻县','357','0','0','Tianjun Xian','TJN');
INSERT INTO `on_region` VALUES ('3395','640101','市辖区','358','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3396','640104','兴庆区','358','0','0','Xingqing Qu','2');
INSERT INTO `on_region` VALUES ('3397','640105','西夏区','358','0','0','Xixia Qu','2');
INSERT INTO `on_region` VALUES ('3398','640106','金凤区','358','0','0','Jinfeng Qu','2');
INSERT INTO `on_region` VALUES ('3399','640121','永宁县','358','0','0','Yongning Xian','YGN');
INSERT INTO `on_region` VALUES ('3400','640122','贺兰县','358','0','0','Helan Xian','HLN');
INSERT INTO `on_region` VALUES ('3401','640181','灵武市','358','0','0','Lingwu Shi','2');
INSERT INTO `on_region` VALUES ('3402','640201','市辖区','359','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3403','640202','大武口区','359','0','0','Dawukou Qu','DWK');
INSERT INTO `on_region` VALUES ('3404','640205','惠农区','359','0','0','Huinong Qu','2');
INSERT INTO `on_region` VALUES ('3405','640221','平罗县','359','0','0','Pingluo Xian','PLO');
INSERT INTO `on_region` VALUES ('3406','640301','市辖区','360','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3407','640302','利通区','360','0','0','Litong Qu','LTW');
INSERT INTO `on_region` VALUES ('3408','640323','盐池县','360','0','0','Yanchi Xian','YCY');
INSERT INTO `on_region` VALUES ('3409','640324','同心县','360','0','0','Tongxin Xian','TGX');
INSERT INTO `on_region` VALUES ('3410','640381','青铜峡市','360','0','0','Qingtongxia Xian','QTX');
INSERT INTO `on_region` VALUES ('3411','640401','市辖区','361','0','0','1','2');
INSERT INTO `on_region` VALUES ('3412','640402','原州区','361','0','0','Yuanzhou Qu','2');
INSERT INTO `on_region` VALUES ('3413','640422','西吉县','361','0','0','Xiji Xian','2');
INSERT INTO `on_region` VALUES ('3414','640423','隆德县','361','0','0','Longde Xian','2');
INSERT INTO `on_region` VALUES ('3415','640424','泾源县','361','0','0','Jingyuan Xian','2');
INSERT INTO `on_region` VALUES ('3416','640425','彭阳县','361','0','0','Pengyang Xian','2');
INSERT INTO `on_region` VALUES ('3417','640501','市辖区','362','0','0','1','2');
INSERT INTO `on_region` VALUES ('3418','640502','沙坡头区','362','0','0','Shapotou Qu','2');
INSERT INTO `on_region` VALUES ('3419','640521','中宁县','362','0','0','Zhongning Xian','2');
INSERT INTO `on_region` VALUES ('3420','640522','海原县','362','0','0','Haiyuan Xian','2');
INSERT INTO `on_region` VALUES ('3421','650101','市辖区','363','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3422','650102','天山区','363','0','0','Tianshan Qu','TSL');
INSERT INTO `on_region` VALUES ('3423','650103','沙依巴克区','363','0','0','Saybag Qu','SAY');
INSERT INTO `on_region` VALUES ('3424','650104','新市区','363','0','0','Xinshi Qu','XSU');
INSERT INTO `on_region` VALUES ('3425','650105','水磨沟区','363','0','0','Shuimogou Qu','SMG');
INSERT INTO `on_region` VALUES ('3426','650106','头屯河区','363','0','0','Toutunhe Qu','TTH');
INSERT INTO `on_region` VALUES ('3427','650107','达坂城区','363','0','0','Dabancheng Qu','2');
INSERT INTO `on_region` VALUES ('3428','650109','米东区','363','0','0','Midong Qu','2');
INSERT INTO `on_region` VALUES ('3429','650121','乌鲁木齐县','363','0','0','Urumqi Xian','URX');
INSERT INTO `on_region` VALUES ('3430','650201','市辖区','364','0','0','Shixiaqu','2');
INSERT INTO `on_region` VALUES ('3431','650202','独山子区','364','0','0','Dushanzi Qu','DSZ');
INSERT INTO `on_region` VALUES ('3432','650203','克拉玛依区','364','0','0','Karamay Qu','KRQ');
INSERT INTO `on_region` VALUES ('3433','650204','白碱滩区','364','0','0','Baijiantan Qu','BJT');
INSERT INTO `on_region` VALUES ('3434','650205','乌尔禾区','364','0','0','Orku Qu','ORK');
INSERT INTO `on_region` VALUES ('3435','652101','吐鲁番市','365','0','0','Turpan Shi','TUR');
INSERT INTO `on_region` VALUES ('3436','652122','鄯善县','365','0','0','Shanshan(piqan) Xian','SSX');
INSERT INTO `on_region` VALUES ('3437','652123','托克逊县','365','0','0','Toksun Xian','TOK');
INSERT INTO `on_region` VALUES ('3438','652201','哈密市','366','0','0','Hami(kumul) Shi','HAM');
INSERT INTO `on_region` VALUES ('3439','652222','巴里坤哈萨克自治县','366','0','0','Barkol Kazak Zizhixian','BAR');
INSERT INTO `on_region` VALUES ('3440','652223','伊吾县','366','0','0','Yiwu(Araturuk) Xian','YWX');
INSERT INTO `on_region` VALUES ('3441','652301','昌吉市','367','0','0','Changji Shi','CJS');
INSERT INTO `on_region` VALUES ('3442','652302','阜康市','367','0','0','Fukang Shi','FKG');
INSERT INTO `on_region` VALUES ('3444','652323','呼图壁县','367','0','0','Hutubi Xian','HTB');
INSERT INTO `on_region` VALUES ('3445','652324','玛纳斯县','367','0','0','Manas Xian','MAS');
INSERT INTO `on_region` VALUES ('3446','652325','奇台县','367','0','0','Qitai Xian','QTA');
INSERT INTO `on_region` VALUES ('3447','652327','吉木萨尔县','367','0','0','Jimsar Xian','JIM');
INSERT INTO `on_region` VALUES ('3448','652328','木垒哈萨克自治县','367','0','0','Mori Kazak Zizhixian','MOR');
INSERT INTO `on_region` VALUES ('3449','652701','博乐市','368','0','0','Bole(Bortala) Shi','BLE');
INSERT INTO `on_region` VALUES ('3450','652722','精河县','368','0','0','Jinghe(Jing) Xian','JGH');
INSERT INTO `on_region` VALUES ('3451','652723','温泉县','368','0','0','Wenquan(Arixang) Xian','WNQ');
INSERT INTO `on_region` VALUES ('3452','652801','库尔勒市','369','0','0','Korla Shi','KOR');
INSERT INTO `on_region` VALUES ('3453','652822','轮台县','369','0','0','Luntai(Bugur) Xian','LTX');
INSERT INTO `on_region` VALUES ('3454','652823','尉犁县','369','0','0','Yuli(Lopnur) Xian','YLI');
INSERT INTO `on_region` VALUES ('3455','652824','若羌县','369','0','0','Ruoqiang(Qakilik) Xian','RQG');
INSERT INTO `on_region` VALUES ('3456','652825','且末县','369','0','0','Qiemo(Qarqan) Xian','QMO');
INSERT INTO `on_region` VALUES ('3457','652826','焉耆回族自治县','369','0','0','Yanqi Huizu Zizhixian','YQI');
INSERT INTO `on_region` VALUES ('3458','652827','和静县','369','0','0','Hejing Xian','HJG');
INSERT INTO `on_region` VALUES ('3459','652828','和硕县','369','0','0','Hoxud Xian','HOX');
INSERT INTO `on_region` VALUES ('3460','652829','博湖县','369','0','0','Bohu(Bagrax) Xian','BHU');
INSERT INTO `on_region` VALUES ('3461','652901','阿克苏市','370','0','0','Aksu Shi','AKS');
INSERT INTO `on_region` VALUES ('3462','652922','温宿县','370','0','0','Wensu Xian','WSU');
INSERT INTO `on_region` VALUES ('3463','652923','库车县','370','0','0','Kuqa Xian','KUQ');
INSERT INTO `on_region` VALUES ('3464','652924','沙雅县','370','0','0','Xayar Xian','XYR');
INSERT INTO `on_region` VALUES ('3465','652925','新和县','370','0','0','Xinhe(Toksu) Xian','XHT');
INSERT INTO `on_region` VALUES ('3466','652926','拜城县','370','0','0','Baicheng(Bay) Xian','BCG');
INSERT INTO `on_region` VALUES ('3467','652927','乌什县','370','0','0','Wushi(Uqturpan) Xian','WSH');
INSERT INTO `on_region` VALUES ('3468','652928','阿瓦提县','370','0','0','Awat Xian','AWA');
INSERT INTO `on_region` VALUES ('3469','652929','柯坪县','370','0','0','Kalpin Xian','KAL');
INSERT INTO `on_region` VALUES ('3470','653001','阿图什市','371','0','0','Artux Shi','ART');
INSERT INTO `on_region` VALUES ('3471','653022','阿克陶县','371','0','0','Akto Xian','AKT');
INSERT INTO `on_region` VALUES ('3472','653023','阿合奇县','371','0','0','Akqi Xian','AKQ');
INSERT INTO `on_region` VALUES ('3473','653024','乌恰县','371','0','0','Wuqia(Ulugqat) Xian','WQA');
INSERT INTO `on_region` VALUES ('3474','653101','喀什市','372','0','0','Kashi (Kaxgar) Shi','KHG');
INSERT INTO `on_region` VALUES ('3475','653121','疏附县','372','0','0','Shufu Xian','SFU');
INSERT INTO `on_region` VALUES ('3476','653122','疏勒县','372','0','0','Shule Xian','SHL');
INSERT INTO `on_region` VALUES ('3477','653123','英吉沙县','372','0','0','Yengisar Xian','YEN');
INSERT INTO `on_region` VALUES ('3478','653124','泽普县','372','0','0','Zepu(Poskam) Xian','ZEP');
INSERT INTO `on_region` VALUES ('3479','653125','莎车县','372','0','0','Shache(Yarkant) Xian','SHC');
INSERT INTO `on_region` VALUES ('3480','653126','叶城县','372','0','0','Yecheng(Kargilik) Xian','YEC');
INSERT INTO `on_region` VALUES ('3481','653127','麦盖提县','372','0','0','Markit Xian','MAR');
INSERT INTO `on_region` VALUES ('3482','653128','岳普湖县','372','0','0','Yopurga Xian','YOP');
INSERT INTO `on_region` VALUES ('3483','653129','伽师县','372','0','0','Jiashi(Payzawat) Xian','JSI');
INSERT INTO `on_region` VALUES ('3484','653130','巴楚县','372','0','0','Bachu(Maralbexi) Xian','BCX');
INSERT INTO `on_region` VALUES ('3485','653131','塔什库尔干塔吉克自治县','372','0','0','Taxkorgan Tajik Zizhixian','TXK');
INSERT INTO `on_region` VALUES ('3486','653201','和田市','373','0','0','Hotan Shi','HTS');
INSERT INTO `on_region` VALUES ('3487','653221','和田县','373','0','0','Hotan Xian','HOT');
INSERT INTO `on_region` VALUES ('3488','653222','墨玉县','373','0','0','Moyu(Karakax) Xian','MOY');
INSERT INTO `on_region` VALUES ('3489','653223','皮山县','373','0','0','Pishan(Guma) Xian','PSA');
INSERT INTO `on_region` VALUES ('3490','653224','洛浦县','373','0','0','Lop Xian','LOP');
INSERT INTO `on_region` VALUES ('3491','653225','策勒县','373','0','0','Qira Xian','QIR');
INSERT INTO `on_region` VALUES ('3492','653226','于田县','373','0','0','Yutian(Keriya) Xian','YUT');
INSERT INTO `on_region` VALUES ('3493','653227','民丰县','373','0','0','Minfeng(Niya) Xian','MFG');
INSERT INTO `on_region` VALUES ('3494','654002','伊宁市','374','0','0','Yining(Gulja) Shi','2');
INSERT INTO `on_region` VALUES ('3495','654003','奎屯市','374','0','0','Kuytun Shi','2');
INSERT INTO `on_region` VALUES ('3496','654021','伊宁县','374','0','0','Yining(Gulja) Xian','2');
INSERT INTO `on_region` VALUES ('3497','654022','察布查尔锡伯自治县','374','0','0','Qapqal Xibe Zizhixian','2');
INSERT INTO `on_region` VALUES ('3498','654023','霍城县','374','0','0','Huocheng Xin','2');
INSERT INTO `on_region` VALUES ('3499','654024','巩留县','374','0','0','Gongliu(Tokkuztara) Xian','2');
INSERT INTO `on_region` VALUES ('3500','654025','新源县','374','0','0','Xinyuan(Kunes) Xian','2');
INSERT INTO `on_region` VALUES ('3501','654026','昭苏县','374','0','0','Zhaosu(Mongolkure) Xian','2');
INSERT INTO `on_region` VALUES ('3502','654027','特克斯县','374','0','0','Tekes Xian','2');
INSERT INTO `on_region` VALUES ('3503','654028','尼勒克县','374','0','0','Nilka Xian','2');
INSERT INTO `on_region` VALUES ('3504','654201','塔城市','375','0','0','Tacheng(Qoqek) Shi','TCS');
INSERT INTO `on_region` VALUES ('3505','654202','乌苏市','375','0','0','Usu Shi','USU');
INSERT INTO `on_region` VALUES ('3506','654221','额敏县','375','0','0','Emin(Dorbiljin) Xian','EMN');
INSERT INTO `on_region` VALUES ('3507','654223','沙湾县','375','0','0','Shawan Xian','SWX');
INSERT INTO `on_region` VALUES ('3508','654224','托里县','375','0','0','Toli Xian','TLI');
INSERT INTO `on_region` VALUES ('3509','654225','裕民县','375','0','0','Yumin(Qagantokay) Xian','YMN');
INSERT INTO `on_region` VALUES ('3510','654226','和布克赛尔蒙古自治县','375','0','0','Hebukesaiermengguzizhi Xian','2');
INSERT INTO `on_region` VALUES ('3511','654301','阿勒泰市','376','0','0','Altay Shi','ALT');
INSERT INTO `on_region` VALUES ('3512','654321','布尔津县','376','0','0','Burqin Xian','BUX');
INSERT INTO `on_region` VALUES ('3513','654322','富蕴县','376','0','0','Fuyun(Koktokay) Xian','FYN');
INSERT INTO `on_region` VALUES ('3514','654323','福海县','376','0','0','Fuhai(Burultokay) Xian','FHI');
INSERT INTO `on_region` VALUES ('3515','654324','哈巴河县','376','0','0','Habahe(Kaba) Xian','HBH');
INSERT INTO `on_region` VALUES ('3516','654325','青河县','376','0','0','Qinghe(Qinggil) Xian','QHX');
INSERT INTO `on_region` VALUES ('3517','654326','吉木乃县','376','0','0','Jeminay Xian','JEM');
INSERT INTO `on_region` VALUES ('3518','659001','石河子市','377','0','0','Shihezi Shi','SHZ');
INSERT INTO `on_region` VALUES ('3519','659002','阿拉尔市','377','0','0','Alaer Shi','2');
INSERT INTO `on_region` VALUES ('3520','659003','图木舒克市','377','0','0','Tumushuke Shi','2');
INSERT INTO `on_region` VALUES ('3521','659004','五家渠市','377','0','0','Wujiaqu Shi','2');
INSERT INTO `on_region` VALUES ('4000','620503','麦积区','340','0','0','Maiji Qu','2');
INSERT INTO `on_region` VALUES ('4001','500116','江津区','270','0','0','Jiangjin Qu','2');
INSERT INTO `on_region` VALUES ('4002','500117','合川区','270','0','0','Hechuan Qu','2');
INSERT INTO `on_region` VALUES ('4003','500118','永川区','270','0','0','Yongchuan Qu','2');
INSERT INTO `on_region` VALUES ('4004','500119','南川区','270','0','0','Nanchuan Qu','2');
INSERT INTO `on_region` VALUES ('4006','340221','芜湖县','1412','0','0','Wuhu Xian','WHX');
INSERT INTO `on_region` VALUES ('4100','232701','加格达奇区','106','0','0','Jiagedaqi Qu','2');
INSERT INTO `on_region` VALUES ('4101','232702','松岭区','106','0','0','Songling Qu','2');
INSERT INTO `on_region` VALUES ('4102','232703','新林区','106','0','0','Xinlin Qu','2');
INSERT INTO `on_region` VALUES ('4103','232704','呼中区','106','0','0','Huzhong Qu','2');
INSERT INTO `on_region` VALUES ('4200','330402','南湖区','125','0','0','Nanhu Qu','2');
INSERT INTO `on_region` VALUES ('4300','360482','共青城市','162','0','0','Gongqingcheng Shi','2');
INSERT INTO `on_region` VALUES ('4400','640303','红寺堡区','360','0','0','Hongsibao Qu','2');
INSERT INTO `on_region` VALUES ('4500','620922','瓜州县','344','0','0','Guazhou Xian','2');
INSERT INTO `on_region` VALUES ('4600','421321','随县','215','0','0','Sui Xian','2');
INSERT INTO `on_region` VALUES ('4700','431102','零陵区','228','0','0','Lingling Qu','2');
INSERT INTO `on_region` VALUES ('4800','451119','平桂管理区','263','0','0','Pingguiguanli Qu','2');
INSERT INTO `on_region` VALUES ('4900','510802','利州区','279','0','0','Lizhou Qu','2');
INSERT INTO `on_region` VALUES ('5000','511681','华蓥市','286','0','0','Huaying Shi','HYC');


# 数据库表：on_role 数据信息
INSERT INTO `on_role` VALUES ('1','超级管理员','0','1','系统内置超级管理员组，不受权限分配账号限制');
INSERT INTO `on_role` VALUES ('2','管理员','1','1','拥有系统仅此于超级管理员的权限');
INSERT INTO `on_role` VALUES ('3','领导','1','1','拥有所有操作的读权限，无增加、删除、修改的权限');
INSERT INTO `on_role` VALUES ('4','测试组','1','1','测试');


# 数据库表：on_role_user 数据信息
INSERT INTO `on_role_user` VALUES ('3','4');
INSERT INTO `on_role_user` VALUES ('3','5');
INSERT INTO `on_role_user` VALUES ('2','6');
INSERT INTO `on_role_user` VALUES ('2','7');
INSERT INTO `on_role_user` VALUES ('3','8');
INSERT INTO `on_role_user` VALUES ('2','9');
INSERT INTO `on_role_user` VALUES ('2','10');


# 数据库表：on_scheduled 数据信息
INSERT INTO `on_scheduled` VALUES ('25','1','ing','0');


# 数据库表：on_seller_pledge 数据信息
INSERT INTO `on_seller_pledge` VALUES ('1','1','0','every','300.00','0.00','1481165864','1');
INSERT INTO `on_seller_pledge` VALUES ('2','1','1','every','300.00','0.00','1481165922','0');
INSERT INTO `on_seller_pledge` VALUES ('5','1','4','every','300.00','0.00','1481250319','0');
INSERT INTO `on_seller_pledge` VALUES ('3','1','2','every','300.00','0.00','1481166127','0');
INSERT INTO `on_seller_pledge` VALUES ('4','1','3','every','300.00','0.00','1481166827','0');
INSERT INTO `on_seller_pledge` VALUES ('6','1','5','every','300.00','0.00','1481252528','0');
INSERT INTO `on_seller_pledge` VALUES ('8','1','7','every','300.00','0.00','1481593382','0');
INSERT INTO `on_seller_pledge` VALUES ('7','1','6','every','300.00','0.00','1481252732','1');
INSERT INTO `on_seller_pledge` VALUES ('9','1','8','every','300.00','0.00','1481593524','0');
INSERT INTO `on_seller_pledge` VALUES ('10','1','9','every','300.00','0.00','1481593582','0');
INSERT INTO `on_seller_pledge` VALUES ('11','1','10','every','300.00','0.00','1481794743','0');
INSERT INTO `on_seller_pledge` VALUES ('12','1','11','every','300.00','0.00','1481794821','0');
INSERT INTO `on_seller_pledge` VALUES ('16','1','15','every','300.00','0.00','1481940375','0');
INSERT INTO `on_seller_pledge` VALUES ('13','1','12','every','300.00','0.00','1481794943','0');
INSERT INTO `on_seller_pledge` VALUES ('14','1','13','every','300.00','0.00','1481795853','1');
INSERT INTO `on_seller_pledge` VALUES ('15','1','14','every','300.00','0.00','1481795946','0');
INSERT INTO `on_seller_pledge` VALUES ('17','522','16','every','0.00','300.00','1482312443','0');
INSERT INTO `on_seller_pledge` VALUES ('18','1','25','every','300.00','0.00','1483607602','0');


# 数据库表：on_share 数据信息


# 数据库表：on_special_auction 数据信息
INSERT INTO `on_special_auction` VALUES ('1','专场拍卖测试001','','','啊sd卡浪费就阿卡sd卡龙卷风啦','1482760440','1482760800','0','100','6','1');
INSERT INTO `on_special_auction` VALUES ('2','卡拉胶sd卡浪费骄傲卡拉斯蒂芬将','','','啥地方噶是的发生的发送到','1483415220','1483501620','0','100','0','1');
INSERT INTO `on_special_auction` VALUES ('3','垃圾sd卡浪费骄傲卡拉斯蒂芬卡','','','卡拉萨将地方考虑骄傲sd卡浪费就','2017','2017','0','100','0','1');
INSERT INTO `on_special_auction` VALUES ('4','就看哈将快递费哈酒卡水电费','','','捐卡水电费将卡号','1483416300','1483589100','0','10','0','1');
INSERT INTO `on_special_auction` VALUES ('5','了卡机sd卡了解疯狂啦几点睡','','','卡辣椒水的咖啡机阿喀琉斯点','1483416480','1484971680','0','200','0','1');
INSERT INTO `on_special_auction` VALUES ('6','卡拉圣诞节快乐飞捐卡','','','啊水井坊卡拉圣诞节','1483676100','1484885760','0','100','1','1');


# 数据库表：on_verify_email 数据信息
INSERT INTO `on_verify_email` VALUES ('1772703372@qq.com','vakuu','1482287050','1482373450');


# 数据库表：on_verify_mobile 数据信息


# 数据库表：on_weiurl 数据信息
INSERT INTO `on_weiurl` VALUES ('1','auction','18','0','http://192.168.1.238//Home/Auction/details/pid/18.html','卡拉斯交电费卢卡斯交电费卡拉斯的','会计师的发生的痕迹咖啡哈快睡觉地方很近卡萨帝','Goods/20161213/max_584f520ee0568.jpg','Goods/20161213/max_584f520ee0568.jpg','0','0','0');
INSERT INTO `on_weiurl` VALUES ('2','auction','19','0','http://192.168.1.238//Home/Auction/details/pid/19.html','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','克拉就是快乐的骄傲收到了','Goods/20161209/max_584a1e8f51158.jpg','Goods/20161209/max_584a1e8f51158.jpg','0','0','0');
INSERT INTO `on_weiurl` VALUES ('3','auction','20','0','http://192.168.1.238//Home/Auction/details/pid/20.html','卡就死掉了咖啡将拉克丝的','绿卡就死掉了咖啡将阿里水电费将奥迪','Goods/20161213/max_584f5280062dd.jpg','Goods/20161213/max_584f5280062dd.jpg','0','0','0');
INSERT INTO `on_weiurl` VALUES ('4','auction','21','0','http://192.168.1.238//Home/Auction/details/pid/21.html','卡拉斯的减肥卡拉萨将地方考虑将阿里sd卡','辣椒水考虑打飞机卡拉胶三大类咖啡机考虑','Goods/20161208/max_5848cfd391e74.jpg','Goods/20161208/max_5848cfd391e74.jpg','0','0','0');
INSERT INTO `on_weiurl` VALUES ('5','auction','22','0','http://192.168.1.238//Home/Auction/details/pid/22.html','卡拉斯经典款浪费骄傲sd卡浪费','卢卡斯将对方考虑将阿斯顿了咖啡机啊','Goods/20161208/max_5848cc0604ddf.jpg','Goods/20161208/max_5848cc0604ddf.jpg','0','0','0');
INSERT INTO `on_weiurl` VALUES ('6','auction','23','0','http://192.168.1.238//Home/Auction/details/pid/23.html','克拉的肌肤看见了快递劫匪','克拉斯记得付款垃圾速度开了房间阿里斯顿','Goods/20161209/max_584a1f5d5c819.jpg','Goods/20161209/max_584a1f5d5c819.jpg','0','0','0');
INSERT INTO `on_weiurl` VALUES ('7','auction','24','0','http://192.168.1.238//Home/Auction/details/pid/24.html','了空间按快了速度激发垃圾似的','啊时间到了福建按快了速度激发','Goods/20161209/max_584a15f897748.jpg','Goods/20161209/max_584a15f897748.jpg','0','0','0');
