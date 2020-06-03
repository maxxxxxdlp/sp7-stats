<?php

/*
 *
 * CONSTANTS (should be defined before including this file):
 * CSS - links a specified CSS file from the 'css' folder (extension not required)
 * JQUERY - whether to include jQuery (bool)(default = FALSE)
 * BOOTSTRAP - whether to include Bootstrap (bool)(default = TRUE)
 * TIMEZONE - specifies the timezone to use (default = 'UTC)
 * NO_HEAD - stops outputting the <head> tag (bool)(default = FALSE)
 * MENU_JS - whether to include `menu.js`. FALSE by default. Is set to TRUE inside of `menu.php`
 *
 * */

define('LINK', 'https://sp7.maxxxxxdlp.ml/');


define('FILES_LOCATION','/home/ec2-user/data/Sp7-stats/');
define('UNZIP_LOCATION','/home/ec2-user/data/Sp7-stats/unzipped/');


define('LOG_IPS',TRUE);
define('BLOCK_EXTERNAL_IPS',FALSE);
define('WHITELIST_IP_LOCATION','/home/ec2-user/data/whitelist_ip_list.txt');
define('BLOCKED_IPS_LOG_LOCATION','/home/ec2-user/data/blocked_ip_list.txt');
define('IPS_LOG_LOCATION','/home/ec2-user/data/ip_list.txt');


define('SHOW_DATA_OUT_OF_DATE_WARNING_AFTER','86400');
define('SPLIT_DATA',200);

const HTTP_CODES_TO_EXCLUDE = [
	'204',

];

define('COLUMNS',['IP','Date','URL','User Agent']);