<?php

require_once('../components/header.php');

$no_gui_separator = "<br>\n";

$error = FALSE;

function alert($status,$message){

	global $no_gui;

	if($no_gui){
		global $no_gui_separator;
		echo ucfirst($status).' : '.$message.$no_gui_separator;
	}
	else
		echo '<div class="alert alert-'.$status.'">'.$message.'</div>';

	if($status=='danger'){
		global $error;
		$error = TRUE;
		exit();
	}

}

function prepare_dir($dir,$delete_files=TRUE){

	if(!file_exists($dir)){

		mkdir($dir);

		if(!file_exists($dir))
			alert('danger','Unable to create directory <i>'.$dir.'</i>. Please check your config and permissions');
		elseif(VERBOSE)
			alert('secondary','Directory <i>'.$dir.'</i> was created successfully');

	} // Create target directory
	elseif($delete_files) { // Delete everything from that directory if not empty

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
				alert('info','Deleted <b>'.$files_count.'</b> files from <i>'.$dir.'</i>');
		}
		else
			foreach($files as $file)
				alert('danger','Failed to delete <b>'.$dir.$file.'</b>');

	}

}

$total_lines = FALSE;



//unzip all files
require_once('../components/unzip.php');

//include compile_institutions function
require_once('../components/institutions.php');

//prepare to fetch information about user agent strings
require_once('../components/user_agent_strings.php');

//parse each file, run compile_institutions on them and run get_data_for_user_agent_string
require_once('../components/raw_data.php');

//validate result of compilation and save institutions
compile_institutions_end();


if($error)
	alert('warning','There were some errors. Please review the messages above');
else {

	$misc_file_data = [
		'timestamp'=>time()
	];

	if($total_lines !== FALSE)
		$misc_file_data['total_lines'] = $total_lines;

	file_put_contents(WORKING_LOCATION.'misc.json',json_encode($misc_file_data));
	alert('success','Success!');

}