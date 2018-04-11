/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : tp5

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 11/04/2018 10:32:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tp_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin`  (
  `admin_id` int(10) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `admin_pwd` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `role_id` int(11) NOT NULL COMMENT '角度ID',
  PRIMARY KEY (`admin_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_admin_function
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_function`;
CREATE TABLE `tp_admin_function`  (
  `function_id` int(11) NOT NULL AUTO_INCREMENT,
  `function_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '栏目名',
  `controller` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类',
  `function` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '方法',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '父ID',
  `is_show` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0隐藏1为显示',
  PRIMARY KEY (`function_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_admin_function
-- ----------------------------
INSERT INTO `tp_admin_function` VALUES (1, '用户管理', '', '', 0, 0);
INSERT INTO `tp_admin_function` VALUES (2, '新增用户', 'Admin', 'add', 1, 0);
INSERT INTO `tp_admin_function` VALUES (3, '用户列表', 'Admin', 'index', 1, 0);
INSERT INTO `tp_admin_function` VALUES (4, '系统管理', '', '', 0, 0);
INSERT INTO `tp_admin_function` VALUES (5, '新增角色', 'Admin', 'add_role', 4, 0);
INSERT INTO `tp_admin_function` VALUES (6, '角色列表', 'Admin', 'role', 4, 0);

-- ----------------------------
-- Table structure for tp_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_role`;
CREATE TABLE `tp_admin_role`  (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名',
  `role_function_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限ID集合',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_admin_role
-- ----------------------------
INSERT INTO `tp_admin_role` VALUES (1, '系统管理员', '');

SET FOREIGN_KEY_CHECKS = 1;
