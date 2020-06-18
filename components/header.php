<?php

require_once(dirname(__FILE__).'/functions.php');
require_file('../config/required.php');
require_file('../config/optional.php');


if(!DEVELOPMENT || SHOW_ERRORS_IN_PRODUCTION){
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 1);
}


function head(){

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
				name="robots"
				content="noindex,nofollow">
		<link
				rel="icon"
				type="image/png"
				sizes="150x150"
				href="https://sp7demofish.specifycloud.org/static/img/fav_icon.png">
		<link
				rel="stylesheet"
				href="<?=LINK?>static/css/main.css">
		<link
				rel="stylesheet"
				href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"
				integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw="
				crossorigin="anonymous"/>
		<script
				src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"
				integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
				crossorigin="anonymous"></script>

	</head>
	<body class="mb-4"> <?php
}

if(!isset($no_gui))
	head();