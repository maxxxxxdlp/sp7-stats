<?php

# Whether to print error messages and warnings
define('DEVELOPMENT',FALSE);

# Address the website would be served on
define('LINK', 'http://localhost:80/');

# Location to the place where all of your access.log files are located.
# Make sure the web server has read permissions to all the files in this folder.
define('FILES_LOCATION','/Users/maxpatiiuk/Downloads/Sp7-stats/');

# Set this to an empty folder. This would be the destination for all uncompressed
# access.log and other files created in the process.
# Make sure the web server has write permissions to this folder.
# **Warning!** All of the files present in this directory would be deleted.
define('WORKING_LOCATION','/Users/maxpatiiuk/Downloads/Sp7-stats/files/');

# File that stores $github_username and $github_token for GitHub API to work
define('GITHUB_TOKEN_LOCATION','/Users/maxpatiiuk/Downloads/Sp7-stats/github_tokens.php');
