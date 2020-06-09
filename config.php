<?php


# Address the website would be served on
define('LINK', 'https://sp7.maxxxxxdlp.ml/');



# Location to the place where all of your access.log files are located.
# Make sure the webserver has read permissions to all the files in this folder.
define('FILES_LOCATION','/home/ec2-user/data/Sp7-stats/');

# Set this to an empty folder. This would be the destination for all uncompressed
# access.log and other files created in the process.
# Make sure the webserver has write permissions to this folder.
# **Warning!** All of the files present in this directory would be deleted.
define('WORKING_LOCATION','/home/ec2-user/data/Sp7-stats/files/');



# Whether to log user IPs
define('LOG_IPS',TRUE);

# Whether to block external ips
define('BLOCK_EXTERNAL_IPS',FALSE);

# Location of a text file that contains a list of IPs that are whitelisted
# IPs should be separated by a new line
define('WHITELIST_IP_LOCATION','/home/ec2-user/data/whitelist_ip_list.txt');

# Location of a text file that would contain a non-distinct list of IPs that were denied access to your site
# IPs would be separated by a new line
define('BLOCKED_IPS_LOG_LOCATION','/home/ec2-user/data/blocked_ip_list.txt');

# Location of a text file that would contain a non-distinct list of IPs that were allowed access to your site
# IPs would be separated by a new line
define('IPS_LOG_LOCATION','/home/ec2-user/data/ip_list.txt');



# If data was not refreshed for this much time, the user would get a reminder to refresh data
# Also, if no new records were coming after this much time, an error message would be shown
define('SHOW_DATA_OUT_OF_DATE_WARNING_AFTER',86400);//one day

# How many records to store in one file before splitting
# Bigger values decrease performance
# Adjust it based on how much traffic you are getting
define('SPLIT_DATA',1000);



# FOR DEBUG ONLY
# This will show success actions for most actions performed while the data refresh is running
define('VERBOSE',FALSE);



# Specifies the value to be used if failed to extract the browser from the User-Agent String
define('DEFAULT_BROWSER','');

# Specifies the value to be used if failed to extract the os      from the User-Agent String
define('DEFAULT_OS','');



# Formatting for years, months and days when showing the usage statistics for a particular institution
# https://www.php.net/manual/en/function.date.php
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



# FOR DEVELOPMENT

# You can define the following constants before including the header.php or menu.php files
# This would allow you to customize various options
#
# CSS       - links a specified CSS file from the 'css' folder (extension not required) (e.x. main)
# JS        - links a specified JS  file from the 'js'  folder (extension not required) (e.x. institutions)
# BOOTSTRAP - whether to include Bootstrap (bool)(default = TRUE )
# JQUERY    - whether to include jQuery    (bool)(default = FALSE)
# NO_HEAD   - does not output the <html>, <head> tags and their content (bool)(default = FALSE)
# MENU_JS   - whether to include `menu.js`. FALSE by default. Is set to TRUE inside of `menu.php`
