SET FOREIGN_KEY_CHECKS=0;

TRUNCATE role;
INSERT INTO `role` VALUES ('1', 'admin', 'Administrative user, has access to everything.');
INSERT INTO `role` VALUES ('2', 'user', 'Login privileges, granted after account confirmation');

SET FOREIGN_KEY_CHECKS=1;