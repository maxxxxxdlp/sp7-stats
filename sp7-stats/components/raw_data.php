<?php

global $total_lines;
global $first_time;
global $last_time;
global $fetched_user_agent_strings_count;


// Example input:
// 174.221.128.140 - - [24/May/2020:09:36:13 -0400] "GET /capture?version=v7.2.0-227-g47813e2&dbVersion=6.7.03&institution=University+of+Texas+at+Austin&discipline=NPL+collections&collection=NPL+collections&isaNumber= HTTP/1.1" 204 3071 "http://specify.npl.tacc.utexas.edu/" "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1 Safari/605.1.15"
// 64.189.134.67 - - [06/Feb/2023:03:58:17 +0000] "GET /capture?version=edge&dbVersion=6.8.02&institution=University+of+Kansas+Biodiversity+Institute&institutionGUID=77ff1bff-af23-4647-b5d1-9d3c414fd003&discipline=Ichthyology&collection=KUFishvoucher&collectionGUID=3f55b3fa-292d-4170-bd46-66dca41d7f05&isaNumber=null HTTP/1.1" 204 5400 "https://sp7demofish.specifycloud.org/" "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36"
function extract_data(&$file_data){

	global $total_lines;
	global $first_time;
	global $last_time;

	$file_data = explode("\n",$file_data);
	$data = [];

	$time = 0;
	$temp_first_time = 0;
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
		$time = strtotime(substr($line,0,$part_end));//24/May/2020:09:36:13 -0400
		$date = intval($time/86400);//returns the number of days after 01.01.1970

		if($temp_first_time==0 && $time!=0)
			$temp_first_time=$time;

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

		$url = urldecode(substr($url,strlen('/capture?')));
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

		//DOMAIN
		$needle = '"';
		$part_end = strpos($line,$needle);//3074
		$line = substr($line,$part_end+strlen($needle));
		$needle = '" "';
		$part_end = strpos($line,$needle);//http://specify.npl.tacc.utexas.edu/
		$line_data['domain'] = substr($line,0,$part_end);
		$line = substr($line,$part_end+strlen($needle));

		$part_end = strpos($line_data['domain'],'/');//extract domain from the string
		if($part_end!==FALSE){

			$part_end+=2;
			$line_data['domain'] = substr($line_data['domain'],$part_end);

			$part_end = strpos($line_data['domain'],'/');
			if($part_end!==FALSE)
				$line_data['domain'] = substr($line_data['domain'],0,$part_end);

		}

		if(substr($line_data['domain'],0,4)==='www.')
			$line_data['domain'] = substr($line_data['domain'],4);

		$port_begin = strpos($line_data['domain'],':');
		if($port_begin!==FALSE)
			$line_data['domain'] = substr($line_data['domain'],0,$port_begin);

		foreach(DOMAINS_TO_EXCLUDE as $domain)
			if(str_contains($line_data['domain'],$domain))
		    continue 2;

		//USER AGENT
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


	if($last_time==0 || $time>$last_time)
		$last_time = $time;

	if($first_time==FALSE || $first_time>$temp_first_time)
		$first_time = $temp_first_time;

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