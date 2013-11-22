SET FOREIGN_KEY_CHECKS=0;

TRUNCATE user_token;
INSERT INTO `user_token` VALUES ('1', 'dummy@mail.com', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'df4ed7297a2db98cec927647f46505d74ef75f8f', '0', '1385740031');
INSERT INTO `user_token` VALUES ('2', 'dummy-2@mail.com', 'user_agent_2', 'token_2', '0', '1385740031');

SET FOREIGN_KEY_CHECKS=1;