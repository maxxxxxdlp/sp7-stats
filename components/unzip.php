<?php

global $file_count;
global $target_dir;

$target_dir = WORKING_LOCATION.'unzipped/';
prepare_dir($target_dir);


function handle_gz($file_name){

	global $file_count;
	global $target_dir;

	$out_file_name = str_replace('.gz', '', $file_name);

	$data = gzdecode(file_get_contents(FILES_LOCATION.$file_name));

	if (!$data){
		alert('danger', 'Error: Could not unzip <i>' . $file_name . '</i> file. Please check your config and permissions</div>');
		return;
	}

	if(VERBOSE)
		alert('secondary', $file_name.' was successfully unzipped to '.$out_file_name.'</div>');

	file_put_contents($target_dir.$out_file_name,$data);

	$file_count++;

}


function handle_log($file_name){

	global $file_count;
	global $target_dir;

	copy(FILES_LOCATION.$file_name,$target_dir.$file_name);

	if(!file_exists($target_dir.$file_name)){
		alert('danger','Unable to copy <i>'.$file_name.'</i> from <b>'.FILES_LOCATION.'</b> to <b>'.$target_dir.'</b>');
		return;
	}

	if(VERBOSE)
		alert('secondary','<i>'.$file_name.'</i> was successfully copied to <b>'.FILES_LOCATION.'</b> to <b>'.$target_dir.'</b>');

	$file_count++;

}


$file_count = 0;
foreach(scandir(FILES_LOCATION) as $file_name){ // Go over each file and unzip if needed

	if($file_name == '.' || $file_name == '..')
		continue;

	if(strpos($file_name,'.gz') !== FALSE)
		handle_gz($file_name);

	elseif(strpos($file_name,'.log') !== FALSE)
		handle_log($file_name);

}

if($file_count==0)
	alert('danger','There were 0 log and gz files in <b>'.FILES_LOCATION.'</b>. Please make sure `FILES_LOCATION` points to a correct directory');
elseif(VERBOSE)
	alert('secondary','There were '.$file_count.' log and gz files in <b>'.FILES_LOCATION.'</b>');