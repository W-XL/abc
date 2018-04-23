/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : english_dictionary

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-04-23 16:50:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tb_admins`
-- ----------------------------
DROP TABLE IF EXISTS `tb_admins`;
CREATE TABLE `tb_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `new_words` varchar(255) DEFAULT NULL,
  `add_time` varchar(20) DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0' COMMENT '0否1是',
  `mobile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_admins
-- ----------------------------
INSERT INTO `tb_admins` VALUES ('1', null, 'e10adc3949ba59abbe56e057f20f883e', null, '1524472293', '0', null);
INSERT INTO `tb_admins` VALUES ('2', '18105022586', 'e10adc3949ba59abbe56e057f20f883e', null, '1524472391', '0', '18105022586');
INSERT INTO `tb_admins` VALUES ('3', '18050956992', 'e10adc3949ba59abbe56e057f20f883e', null, '1524472635', '0', '18050956992');

-- ----------------------------
-- Table structure for `tb_menues`
-- ----------------------------
DROP TABLE IF EXISTS `tb_menues`;
CREATE TABLE `tb_menues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(255) DEFAULT NULL COMMENT '菜单路径',
  `pid` int(11) unsigned DEFAULT NULL COMMENT '菜单父id',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态，默认0可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_menues
-- ----------------------------
INSERT INTO `tb_menues` VALUES ('1', '系统管理', null, '3', '0');
INSERT INTO `tb_menues` VALUES ('2', '菜单管理', 'Menu/index', '1', '0');
INSERT INTO `tb_menues` VALUES ('3', '系统设置', null, '0', '0');
INSERT INTO `tb_menues` VALUES ('4', '事业', '', '0', '0');
INSERT INTO `tb_menues` VALUES ('5', '账户管理', 'Account/index', '1', '0');
INSERT INTO `tb_menues` VALUES ('6', '试卷管理', '', '4', '0');
INSERT INTO `tb_menues` VALUES ('7', '试卷列表', 'Paper/index', '6', '0');
INSERT INTO `tb_menues` VALUES ('8', '试题类型列表', 'Paper/question_type', '6', '0');
INSERT INTO `tb_menues` VALUES ('9', '试题列表', 'Paper/question_list', '6', '0');

-- ----------------------------
-- Table structure for `tb_roles`
-- ----------------------------
DROP TABLE IF EXISTS `tb_roles`;
CREATE TABLE `tb_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '角色名',
  `rules` text COMMENT '权限',
  `des_info` varchar(100) DEFAULT NULL COMMENT '描述信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_roles
-- ----------------------------
INSERT INTO `tb_roles` VALUES ('1', 'admin', '1,2,3,4,5,6,7,8,9', null);
INSERT INTO `tb_roles` VALUES ('2', '学生', null, null);
INSERT INTO `tb_roles` VALUES ('3', '教师', '1,2,3,4,5,6,7,8,9', null);

-- ----------------------------
-- Table structure for `tb_users`
-- ----------------------------
DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(30) DEFAULT NULL COMMENT '账号',
  `pwd` char(32) DEFAULT NULL COMMENT '密码',
  `user_name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `login_time` int(11) unsigned DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  `is_del` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除，默认0正常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_users
-- ----------------------------
INSERT INTO `tb_users` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '1523931811', '127.0.0.1', '0');
INSERT INTO `tb_users` VALUES ('2', 'study', 'e10adc3949ba59abbe56e057f20f883e', '张晓红', null, null, '0');
INSERT INTO `tb_users` VALUES ('4', 'study1', 'e10adc3949ba59abbe56e057f20f883e', 'study1', null, null, '0');
INSERT INTO `tb_users` VALUES ('5', 'study2', 'e10adc3949ba59abbe56e057f20f883e', 'study2', null, null, '0');
INSERT INTO `tb_users` VALUES ('6', 'study3', '33960aa2c4c89bba46feebd41baa4a72', 'study3', null, null, '0');
INSERT INTO `tb_users` VALUES ('7', 'study4', 'ed5e5ddcb587b44d58b68c76ce817516', 'study4', null, null, '0');
INSERT INTO `tb_users` VALUES ('8', 'study5', '722abe8dfae68abde2c23fa20582f72b', 'study5', null, null, '0');
INSERT INTO `tb_users` VALUES ('9', 'study6', 'c9728dc33e3d5a2f55cfa358cd03eec6', 'study6', null, null, '0');
INSERT INTO `tb_users` VALUES ('10', 'study7', '887c427840711265f2d6ff869b45f8bb', 'study7', null, null, '0');
INSERT INTO `tb_users` VALUES ('11', 'study8', '13ab3746ca0634b398a41a4e6fcbd24e', 'study8', null, null, '0');
INSERT INTO `tb_users` VALUES ('12', 'study9', 'a57f4f95c801bc52c8eed94e6ac7d1ce', 'study9', null, null, '0');

-- ----------------------------
-- Table structure for `tb_user_role_access`
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_role_access`;
CREATE TABLE `tb_user_role_access` (
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `role_id` int(11) unsigned DEFAULT NULL COMMENT '角色id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_user_role_access
-- ----------------------------
INSERT INTO `tb_user_role_access` VALUES ('1', '1');
INSERT INTO `tb_user_role_access` VALUES ('2', '2');
INSERT INTO `tb_user_role_access` VALUES ('4', '2');
INSERT INTO `tb_user_role_access` VALUES ('5', '2');
INSERT INTO `tb_user_role_access` VALUES ('6', '2');
INSERT INTO `tb_user_role_access` VALUES ('7', '1');
INSERT INTO `tb_user_role_access` VALUES ('8', '2');
INSERT INTO `tb_user_role_access` VALUES ('9', '2');
INSERT INTO `tb_user_role_access` VALUES ('10', '2');
INSERT INTO `tb_user_role_access` VALUES ('11', '2');
INSERT INTO `tb_user_role_access` VALUES ('12', '2');

-- ----------------------------
-- Table structure for `tb_word_list`
-- ----------------------------
DROP TABLE IF EXISTS `tb_word_list`;
CREATE TABLE `tb_word_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) DEFAULT NULL COMMENT '单词',
  `meaning` varchar(255) DEFAULT NULL COMMENT '意思、解释',
  `add_time` varchar(255) DEFAULT NULL,
  `is_del` tinyint(4) DEFAULT '0' COMMENT '0否 1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_word_list
-- ----------------------------
