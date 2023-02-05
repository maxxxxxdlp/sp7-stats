<?php

define('DEVELOPMENT',getenv('DEVELOPMENT') == 'TRUE');

define('LINK', getenv('LINK'));

const FILES_LOCATION = '/home/specify/access-logs/';
# Set this to an empty folder. This would be the destination for all uncompressed
# access.log and other files created in the process.
# Make sure the web server has write permissions to this folder.
# **Warning!** All of the files present in this directory would be deleted.
const WORKING_LOCATION = '/home/specify/working-dir/';

define('GITHUB_TOKEN', getenv('GITHUB_TOKEN'));
