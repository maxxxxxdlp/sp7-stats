<?php


if($_SERVER['HTTP_HOST']=='localhost'){
	define('DEVELOPMENT',TRUE);
	define('CONFIGURATION','localhost');
}
elseif($_SERVER['HTTP_HOST']=='sp7.maxxxxxdlp.ml'){
	define('DEVELOPMENT',TRUE);
	define('CONFIGURATION','ec2');
}
else {
	define('DEVELOPMENT',FALSE);
	define('CONFIGURATION','production');
}


if(CONFIGURATION==='localhost'){

	# Address the website would be served on
	define('LINK', 'http://localhost:80/');

	# Location to the place where all of your access.log files are located.
	# Make sure the web server has read permissions to all the files in this folder.
	define('FILES_LOCATION','/Users/mambo/Downloads/Sp7-stats/');

	# Set this to an empty folder. This would be the destination for all uncompressed
	# access.log and other files created in the process.
	# Make sure the web server has write permissions to this folder.
	# **Warning!** All of the files present in this directory would be deleted.
	define('WORKING_LOCATION','/Users/mambo/Downloads/Sp7-stats/files/');

	# File that stores $github_username and $github_token for GitHub API to work
	define('GITHUB_TOKEN_LOCATION','/Users/mambo/Downloads/Sp7-stats/github_tokens.php');

}

elseif(CONFIGURATION==='ec2'){

	define('LINK', 'https://sp7.maxxxxxdlp.ml/');

	define('FILES_LOCATION','/home/ec2-user/data/Sp7-stats/');

	define('WORKING_LOCATION','/home/ec2-user/data/Sp7-stats/files/');

	define('GITHUB_TOKEN_LOCATION','/home/ec2-user/data/github_tokens.php');

}
else { # these settings would be used during production

	define('LINK', 'http://biwebdbtest.nhm.ku.edu/sp7-stats/');

	define('FILES_LOCATION','/home/anhalt/sp7-stats-logs/');

	define('WORKING_LOCATION','/home/sp7-stats/tmp/');

	define('GITHUB_TOKEN_LOCATION','/home/sp7-stats/tmp/github_tokens.php');

}