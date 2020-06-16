<?php


# Address the website would be served on
//define('LINK', 'https://sp7.maxxxxxdlp.ml/');
define('LINK', 'http://biwebdbtest.nhm.ku.edu/sp7-stats/');

# Location to the place where all of your access.log files are located.
# Make sure the web server has read permissions to all the files in this folder.
//define('FILES_LOCATION','/home/ec2-user/data/Sp7-stats/');
define('FILES_LOCATION','/home/anhalt/sp7-stats-logs/');

# Set this to an empty folder. This would be the destination for all uncompressed
# access.log and other files created in the process.
# Make sure the web server has write permissions to this folder.
# **Warning!** All of the files present in this directory would be deleted.
//define('WORKING_LOCATION','/home/ec2-user/data/Sp7-stats/files/');
define('WORKING_LOCATION','/home/sp7-stats/tmp/');