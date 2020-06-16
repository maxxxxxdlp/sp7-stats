<?php

//define('DEVELOPMENT',TRUE);

# You can have different constant's values for your development and production servers
# You can modify the code to read the value for `DEVELOPMENT` constant from some other file
if($_SERVER['HTTP_HOST']=='biwebdbtest.nhm.ku.edu')
	define('DEVELOPMENT',FALSE);
else
	define('DEVELOPMENT',TRUE);

if(DEVELOPMENT){ # these settings would be used during development

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

}
else { # these settings would be used during production

	define('LINK', 'http://biwebdbtest.nhm.ku.edu/sp7-stats/');
	define('FILES_LOCATION','/home/anhalt/sp7-stats-logs/');
	define('WORKING_LOCATION','/home/sp7-stats/tmp/');

}