<?php

$no_gui_separator = "<br>\n";

$no_gui = array_key_exists('no_gui',$_GET);
if($no_gui)
	define('NO_HEAD',TRUE);

const CSS = 'refresh_data';


require_once('../components/header.php');


$error = FALSE;

function alert($status,$message){

	global $no_gui;

	if($status=='error'){
		global $error;
		$error = TRUE;
	}

	if($no_gui){
		global $no_gui_separator;
		echo ucfirst($status).' : '.$message.$no_gui_separator;
	}
	else
		echo '<div class="alert alert-'.$status.'">'.$message.'</div>';

}

function prepare_dir($dir){

	if(!file_exists($dir)){

		mkdir($dir);

		if(!file_exists($dir)){
			alert('error','Unable to create directory <i>'.$dir.'</i>. Please check your config and permissions');
			exit();
		}

	} // Create target directory
	else { // Delete everything from that directory if not empty

		$files = glob($dir.'*.*');
		$files_count = count($files);

		foreach($files as $file)
			if(is_file($file))
				unlink($file);

		$files = glob($dir.'*.*');

		if(count($files) == 0){
			if($files_count==0)
				alert('info','<i>'.$dir.'</i> is already empty. No files deleted');
			else
				alert('info','Successfully deleted <b>'.$files_count.'</b> files from <i>'.$dir.'</i>');
		}
		else
			foreach($files as $file)
				alert('error','Failed to delete <b>'.$dir.$file.'</b>');

	}

}


require_file('../components/unzip.php');
require_file('../components/get_raw_data.php');
require_file('../components/compile_data.php');


if($error)
	alert('warning','There were some errors. Please review the messages above');
else {
	file_put_contents(UNZIP_LOCATION.'misc.json',json_encode(['timestamp'=>time()]));
	alert('primary','Success!');

	if(!$no_gui)
		alert('info','<a href="'.LINK.'">Click here to go back to main page</a>');

}

if(!$no_gui)
	footer();