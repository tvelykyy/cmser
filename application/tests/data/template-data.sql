SET FOREIGN_KEY_CHECKS=0;

TRUNCATE template;
INSERT INTO `template` VALUES ('1', 'Main Template', 'index.html');
INSERT INTO `template` VALUES ('2', 'Uris', 'snippet/uris.html');

SET FOREIGN_KEY_CHECKS=1;