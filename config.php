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
define('USERSTACK_API_KEY_LOCATION','/home/ec2-user/data/Sp7-stats/userstack.com_api.key');//SET TO FALSE TO IGNORE THIS API

# this api is not yet used
#define('IPSTACK_API_KEY_LOCATION','/home/ec2-user/data/Sp7-stats/ipstack.com_api.key');//SET TO FALSE TO IGNORE THIS API


define('LOG_IPS',TRUE);
define('BLOCK_EXTERNAL_IPS',FALSE);
define('WHITELIST_IP_LOCATION','/home/ec2-user/data/whitelist_ip_list.txt');
define('BLOCKED_IPS_LOG_LOCATION','/home/ec2-user/data/blocked_ip_list.txt');
define('IPS_LOG_LOCATION','/home/ec2-user/data/ip_list.txt');


define('SHOW_DATA_OUT_OF_DATE_WARNING_AFTER','86400');
define('SPLIT_DATA',1000);

define('DELETE_LOG_FILES_IN_UNZIP_LOCATION',TRUE);//deletes .log files in `UNZIP_LOCATION` after they are no longer needed. This can save some space if your machine is low on memory
define('VERBOSE',FALSE);

define('DEFAULT_BROWSER','');//value to be used if failed to extract the browser from the User Agent String
define('DEFAULT_OS','');     //value to be used if failed to extract the os      from the User Agent String

//https://www.php.net/manual/en/function.date.php
define('YEAR_FORMATTER','Y');
define('MONTH_FORMATTER','F');
define('DAY_FORMATTER','J D');

const HTTP_CODES_TO_ACCEPT = [
	'204',//empty response
];

//const LINKS_TO_CAPTURE = [
//	'/capture?',
//];

define('COLUMNS',['IP Address','Date','SP7','SP6','Institution','Discipline','Collection','Isa Number','Browser','OS']);