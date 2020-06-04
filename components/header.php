<?php

function require_file($require){

	require_once(dirname(__FILE__).'/'.$require);

}

function footer(){

	require_file('footer.php');

}

require_file('../config.php');

if(LOG_IPS)
	require_file('ip_access.php');


error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

if(defined('TIMEZONE'))
	date_default_timezone_set(TIMEZONE);
else
	date_default_timezone_set('America/Chicago');

if(!defined('NO_HEAD')){

?><!-- Developed by Specify Software (https://www.sustain.specifysoftware.org/) -->
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<title>Specify 7 Stats</title>
	<meta
			name="viewport"
			content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta
			name="author"
			content="Specify Software">
	<meta
			name="theme-color"
			content="#145a8d"/>
	<meta
			name="robots"
			content="noindex,nofollow">
	<meta
			name="apple-mobile-web-app-title"
			content="Specify 7 Stats">
	<meta
			name="application-name"
			content="Specify 7 Stats">
	<meta
			name="description"
			content="Specify 7 Stats">
	<link
			rel="icon"
			type="image/png"
			sizes="150x150"
			href="https://sp7demofish.specifycloud.org/static/img/fav_icon.png">
	<link
			rel="stylesheet"
			href="<?=LINK?>static/css/main.css"><?php

	if(defined('CSS')) { ?>
		<link
			rel="stylesheet"
			href="<?=LINK?>static/css/<?=CSS?>.css"> <?php
	}

	if(!defined('BOOTSTRAP') || BOOTSTRAP == TRUE){ ?>
		<link
				rel="stylesheet"
				href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"
				integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw="
				crossorigin="anonymous"/> <?php
	}

	if(defined('JQUERY') && JQUERY == TRUE){ ?>
		<script
				src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"
				integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
				crossorigin="anonymous"></script> <?php
	}

	if(defined('JS')){ ?>
		<script src="<?=LINK?>static/js/<?=JS?>.js"></script> <?php
	}

	if(defined('MENU_JS')){ ?>
		<script src="<?=LINK?>static/js/menu.js"></script> <?php
	} ?>

</head>
<body class="mb-4"> <?php

}