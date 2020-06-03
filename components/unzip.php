<?php

prepare_dir(UNZIP_LOCATION);


function handle_gz($file_name){

	global $alert;

	$out_file_name = str_replace('.gz', '', $file_name);

	$data = gzdecode(file_get_contents(FILES_LOCATION.$file_name));

	if (!$data)
		alert('danger', 'Error: Could not unzip <i>' . $file_name . '</i> file. Please check your config and permissions</div>');
	else
		alert('success',$file_name.' was successfully unzipped to '.$out_file_name.'</div>');

	file_put_contents(UNZIP_LOCATION.$out_file_name,$data);

}


function handle_log($file_name){

	global $alert;

	copy(FILES_LOCATION.$file_name,UNZIP_LOCATION.$file_name);

	if(file_exists(UNZIP_LOCATION.$file_name))
		alert('success','<i>'.$file_name.'</i> was successfully copied to <b>'.FILES_LOCATION.'</b> to <b>'.UNZIP_LOCATION.'</b>');
	else
		alert('error','Unable to copy <i>'.$file_name.'</i> from <b>'.FILES_LOCATION.'</b> to <b>'.UNZIP_LOCATION.'</b>');

}


foreach(scandir(FILES_LOCATION) as $file_name){ // Go over each file and unzip if needed

	if($file_name == '.' || $file_name == '..')
		continue;

	if(strpos($file_name,'.gz') !== FALSE)
		handle_gz($file_name);

	elseif(strpos($file_name,'.log') !== FALSE)
		handle_log($file_name);

}