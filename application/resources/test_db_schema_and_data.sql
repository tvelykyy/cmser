/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : cmser_test

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2013-11-15 18:35:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `page`
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Represent unique page identifier',
  `parent_id` bigint(20) NOT NULL,
  `uri` varchar(200) NOT NULL COMMENT 'Represents page''s full URL.',
  `template_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page
-- ----------------------------
INSERT INTO `page` VALUES ('1', '0', '/', '1');
INSERT INTO `page` VALUES ('2', '1', '/news', '1');
INSERT INTO `page` VALUES ('3', '1', '/stories', '1');
INSERT INTO `page` VALUES ('4', '1', '/contacts', '1');

-- ----------------------------
-- Table structure for `page_field`
-- ----------------------------
DROP TABLE IF EXISTS `page_field`;
CREATE TABLE `page_field` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Represents page''s field unique identifier.',
  `title` varchar(100) NOT NULL COMMENT 'Represents page''s block title.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_field
-- ----------------------------
INSERT INTO `page_field` VALUES ('1', 'MAIN_CONTENT');
INSERT INTO `page_field` VALUES ('2', 'HEADER');
INSERT INTO `page_field` VALUES ('3', 'FOOTER');

-- ----------------------------
-- Table structure for `page_page_field`
-- ----------------------------
DROP TABLE IF EXISTS `page_page_field`;
CREATE TABLE `page_page_field` (
  `page_id` bigint(20) unsigned NOT NULL COMMENT 'Represent page identifier.',
  `page_field_id` bigint(20) unsigned NOT NULL COMMENT 'Represents page''s block identifier',
  `page_field_content` text NOT NULL COMMENT 'Reprents page block content for specific page.',
  UNIQUE KEY `page_id_page_block_id` (`page_id`,`page_field_id`) USING BTREE COMMENT 'Page and page block combination should be unique.',
  KEY `page_field_id` (`page_field_id`),
  CONSTRAINT `page_field_id` FOREIGN KEY (`page_field_id`) REFERENCES `page_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `page_id` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table represents mapping between page block and specific page.';

-- ----------------------------
-- Records of page_page_field
-- ----------------------------
INSERT INTO `page_page_field` VALUES ('1', '1', 'This is page content [[Model_Page.get_all_pages_uri.2?above=0&less=3]] contained in CONTENT block.');
INSERT INTO `page_page_field` VALUES ('2', '1', 'This is news page.');
INSERT INTO `page_page_field` VALUES ('2', '2', 'This is news page title.');
INSERT INTO `page_page_field` VALUES ('2', '3', 'This is news page footer.');

-- ----------------------------
-- Table structure for `template`
-- ----------------------------
DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
  `id` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `filepath` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of template
-- ----------------------------
INSERT INTO `template` VALUES ('1', 'Main Template', 'index.html');
INSERT INTO `template` VALUES ('2', 'Uris', 'snippet/uris.html');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `email` varchar(127) NOT NULL,
  `password` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `enabled` bit(1) NOT NULL DEFAULT b'0',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `uniq_username` (`username`) USING BTREE,
  UNIQUE KEY `uniq_email` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('dummy@mail.com', '0f0a9a777952ceb5b629ec5a901df612c7bf2cd66a63ef2d80228d5557ca8dca', 'Dummy', '', null);
