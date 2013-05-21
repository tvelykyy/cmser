/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50531
Source Host           : localhost:3306
Source Database       : cmser

Target Server Type    : MYSQL
Target Server Version : 50531
File Encoding         : 65001

Date: 2013-05-21 23:02:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for page
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Represent unique page identifier',
  `url` varchar(200) NOT NULL COMMENT 'Represents page''s full URL.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page
-- ----------------------------
INSERT INTO `page` VALUES ('1', '/news/ukraine');
INSERT INTO `page` VALUES ('2', '/news/poland');

-- ----------------------------
-- Table structure for page_field
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
-- Table structure for page_page_field
-- ----------------------------
DROP TABLE IF EXISTS `page_page_field`;
CREATE TABLE `page_page_field` (
  `page_id` bigint(20) unsigned NOT NULL COMMENT 'Represent page identifier.',
  `page_block_id` bigint(20) unsigned NOT NULL COMMENT 'Represents page''s block identifier',
  `page_block_content` blob NOT NULL COMMENT 'Reprents page block content for specific page.',
  UNIQUE KEY `page_id_page_block_id` (`page_id`,`page_block_id`) USING BTREE COMMENT 'Page and page block combination should be unique.',
  KEY `page_block_id` (`page_block_id`),
  CONSTRAINT `page_block_id` FOREIGN KEY (`page_block_id`) REFERENCES `page_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `page_id` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table represents mapping between page block and specific page.';

-- ----------------------------
-- Records of page_page_field
-- ----------------------------
INSERT INTO `page_page_field` VALUES ('1', '1', 0x54686973206973207061676520636F6E74656E7420636F6E7461696E656420696E20434F4E54454E5420626C6F636B2E);
