<?php


# Address the website would be served on
define('LINK', 'https://sp7.maxxxxxdlp.ml/');

# Location to the place where all of your access.log files are located.
# Make sure the web server has read permissions to all the files in this folder.
define('FILES_LOCATION','/home/ec2-user/data/Sp7-stats/');

# Set this to an empty folder. This would be the destination for all uncompressed
# access.log and other files created in the process.
# Make sure the web server has write permissions to this folder.
# **Warning!** All of the files present in this directory would be deleted.
define('WORKING_LOCATION','/home/ec2-user/data/Sp7-stats/files/');



# Set a list of IPs that should be excluded from the reports
const IPS_TO_EXCLUDE = [
	'129.237.229.',
	'129.237.201.',
	'24.143.45.91',
	'195.26.95.208',
	'24.124.121.150',
	'24.143.33.129',
	'24.143.39.179',
	'24.143.45.91',
	'24.143.60.228',
	'99.184.64.68',
	'129.237.92.172',
	'129.237.183.',
	'172.58.139.',
	'172.58.142.',
];

# Set a list of Institution Names to exclude
const INSTITUTIONS_TO_EXCLUDE = [
	'University of Kansas Biodiversity Institute',
	'KU Biodiversity Institute',
	'1',
];



# If data was not refreshed for this much time, the user would get a reminder to refresh data
# Also, if no new records were coming after this much time, an error message would be shown
define('SHOW_DATA_OUT_OF_DATE_WARNING_AFTER',86400);//one day



# FOR DEBUG ONLY
# This will show success actions for most actions performed while the data refresh is running
define('VERBOSE',FALSE);



# Specifies the value to be used if failed to extract the browser from the User-Agent String
define('DEFAULT_BROWSER','');

# Specifies the value to be used if failed to extract the os from the User-Agent String
define('DEFAULT_OS','');



# Formatting for years, months and days when showing the usage statistics for a particular institution
# See more at https://www.php.net/manual/en/function.date.php
define('YEAR_FORMATTER','Y');
define('MONTH_FORMATTER','F');
define('DAY_FORMATTER','j D');



# Specifies how to display the results on the main page
# These values can be overwritten by supplying $_GET['view'] (e.x. ?view=00)
# 0  - Shows list view by default. Table view is also available
# 1  - Shows table view by default. List view is also available
# 00 - Shows list only. Table view is not available
# 11 - Shows table view only. List view is not available
define('MAIN_PAGE_OUTPUT_FORMAT','0');