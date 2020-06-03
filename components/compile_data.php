<?php

$files = glob(UNZIP_LOCATION.'tsv/*.tsv');

$files_target_dir = UNZIP_LOCATION.'ips/';
prepare_dir($files_target_dir);


foreach($files as $file){

	$dates = [];

	$file_data = file_get_contents($file);
	$file_data = explode("\n", $file_data);

	foreach($file_data as $line){

		$line_data = explode("\t",$line);

		if(!array_key_exists(0,$line_data) || !array_key_exists(1,$line_data))
			continue;

		$ip_address = $line_data[0];
		$unix_time = $line_data[1];

		if(!array_key_exists($ip_address,$dates))
			$dates[$ip_address] = [$unix_time];
		else
			$dates[$ip_address][] = $unix_time;

	}

	$file = explode('/',$file);
	$file = $file[count($file)-1];
	$file = explode('.',$file)[0];

	file_put_contents(UNZIP_LOCATION.'ips/'.$file.'.json',json_encode($dates));

	if(file_exists(UNZIP_LOCATION.'ips/'.$file.'.json'))
		alert('success','<i>'.UNZIP_LOCATION.'ips/'.$file.'.json</i> was successfully created');
	else
		alert('error','Failed to create <i>'.UNZIP_LOCATION.'ips/'.$file.'.json</i>');


}