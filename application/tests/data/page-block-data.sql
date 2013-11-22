SET FOREIGN_KEY_CHECKS=0;

TRUNCATE page_block;
INSERT INTO `page_block` VALUES ('1', '1', 'This is page content [[Model_Page.get_all_pages_uri.2?above=0&less=3]] contained in CONTENT block.');
INSERT INTO `page_block` VALUES ('2', '1', 'This is news page.');
INSERT INTO `page_block` VALUES ('2', '2', 'This is news page title.');
INSERT INTO `page_block` VALUES ('2', '3', 'This is news page footer.');

SET FOREIGN_KEY_CHECKS=1;