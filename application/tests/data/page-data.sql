SET FOREIGN_KEY_CHECKS=0;

TRUNCATE page;
INSERT INTO `page` VALUES ('1', '0', '/', '1');
INSERT INTO `page` VALUES ('2', '1', '/news', '1');
INSERT INTO `page` VALUES ('3', '1', '/stories', '1');
INSERT INTO `page` VALUES ('4', '1', '/contacts', '1');

SET FOREIGN_KEY_CHECKS=1;