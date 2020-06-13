<?php

global $file_count;

function handle_gz($file_name){

	global $file_count;

	$out_file_name = str_replace('.gz', '', $file_name);

	$data = gzdecode(file_get_contents(FILES_LOCATION.$file_name));

	if (!$data){
		alert('danger', 'Error: Could not unzip <i>' . $file_name . '</i> file. Please check your config and permissions</div>');
		return;
	}

	if(VERBOSE)
		alert('secondary', $file_name.' was successfully unzipped to '.$out_file_name.'</div>');

	extract_data($data);

	$file_count++;

}


function handle_log($file_name){

	global $file_count;

	$data = file_get_contents(FILES_LOCATION.$file_name);
	extract_data($data);

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