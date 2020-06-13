<?php

global $total_lines;
global $fetched_user_agent_strings_count;


$total_lines = 0;


//174.221.128.140 - - [24/May/2020:09:36:13 -0400] "GET /capture?version=v7.2.0-227-g47813e2&dbVersion=6.7.03&institution=University+of+Texas+at+Austin&discipline=NPL+collections&collection=NPL+collections&isaNumber= HTTP/1.1" 204 3071 "http://specify.npl.tacc.utexas.edu/" "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1 Safari/605.1.15"
function extract_data(&$file_data){

	global $total_lines;

	$file_data = explode("\n",$file_data);
	$data = [];

	foreach($file_data as $line){

		$line_data = [];

		//IP
		$needle = ' - - ';
		$part_end = strpos($line,$needle);
		$line_data['ip'] = substr($line,0,$part_end);//174.221.128.140
		$line = substr($line,$part_end+strlen($needle)+1);
		if($line_data['ip'] == '')
			continue;

		$fount_ip = FALSE;
		foreach(IPS_TO_EXCLUDE as $ip)
			if(strpos($line_data['ip'],$ip)!==FALSE){
				$fount_ip=TRUE;
				break;
			}
		if($fount_ip)
			continue;

		//DATE
		$needle = ']';
		$part_end = strpos($line,$needle);
		$date = strtotime(substr($line,0,$part_end));//24/May/2020:09:36:13 -0400
		$date = intval($date/86400);//returns the number of days after 01.01.1970

		$line = substr($line,$part_end+strlen($needle)+2);

		if(substr($line,0,3)=='GET')
			$line = substr($line,3+1);
		elseif(substr($line,0,4)=='POST')
			$line = substr($line,4+1);

		//URL
		$needle = ' ';
		$part_end = strpos($line,$needle);
		$url = substr($line,0,$part_end);///capture
		$line = substr($line,$part_end+strlen($needle));

		if(substr($url,0,strlen('/capture?'))!=='/capture?')
			continue;

		$url = substr($url,strlen('/capture?'));
		$url = explode('&',$url);

		foreach($url as $param){

			$param = explode('=',$param);
			$line_data[$param[0]] = $param[1];

		}

		if(in_array(urldecode($line_data['institution']),INSTITUTIONS_TO_EXCLUDE))
			continue;


		//HTTP CODE
		$needle = ' ';
		$part_end = strpos($line,$needle);//HTTP/1.1"
		$line = substr($line,$part_end+strlen($needle));
		$needle = ' ';
		$part_end = strpos($line,$needle);
		$http_code = substr($line,0,$part_end);//204
		$line = substr($line,$part_end+strlen($needle)+1);

		if($http_code!=204)
			continue;

		//USER AGENT
		$needle = '"';
		$part_end = strpos($line,$needle);//3074
		$line = substr($line,$part_end+strlen($needle));
		$needle = '" "';
		$part_end = strpos($line,$needle);//http://specify.npl.tacc.utexas.edu/
		$line = substr($line,$part_end+strlen($needle));
		$needle = '"';
		$part_end = strpos($line,$needle);
		$user_agent_string = substr($line,0,$part_end);//Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1 Safari/605.1.15
		$user_agent_string = get_data_for_user_agent_string($user_agent_string);

		if(is_array($user_agent_string) && $user_agent_string[1]!=''){
			$line_data['browser'] = $user_agent_string[0];
			$line_data['os'] = $user_agent_string[1];
		}
		else {
			$line_data['browser'] = DEFAULT_BROWSER;
			$line_data['os'] = DEFAULT_OS;
		}


		//add data to array
		if(!array_key_exists($date,$data))
			$data[$date] = [];
		$data[$date][] = $line_data;

		$total_lines++;

	}

	foreach($data as $date => $file_data)
		compile_institutions($file_data, $date);


}


function finish_data_extraction(){

	global $total_lines;
	global $fetched_user_agent_strings_count;

	if($total_lines==0)
		alert('danger','There were <b>0</b> records matching your filters. Please change your filters or change a pointer to a different directory');
	else
		alert('info','Extracted <b>'.$total_lines.'</b> rows of data');


	get_data_for_user_agent_string('CLOSE_CURL');
	get_data_for_user_agent_string('SAVE_DATA');
	if($fetched_user_agent_strings_count>0)
		alert('info','Fetched data about '.$fetched_user_agent_strings_count.' user agent strings');
	elseif(VERBOSE)
		alert('secondary','Did not fetch data any new user agent strings');

}