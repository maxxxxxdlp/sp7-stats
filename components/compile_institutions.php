<?php

global $ips;
global $institutions2;
global $institutions3;
global $institutions_dir;
global $institutions2_dir;


$institutions_dir = UNZIP_LOCATION.'institutions/';//contains some data about the institutions in each file (used on the main page)
prepare_dir($institutions_dir);
$institutions_dir = UNZIP_LOCATION.'institutions2/';//contains all of the data about each institution (used on the institutions page)
prepare_dir($institutions2_dir);


$institutions2 = [];
$institutions3 = [];//contains brief data about all institutions

$file_count = 0;

//tsv_file_name.json >
// - institution_name_urlencoded
//   - discipline_name_urlencoded
//     - collection_name_urlencoded
//       - sp7_version
//         - sorted distinct array
//       - sp6_version
//         - sorted distinct array
//       - isa_number
//         - sorted distinct array
//       - ip_address
//         - distinct array
//       - browser
//         - distinct array
//       - os
//         - distinct array
//       - year
//         - month
//           - day
//             - number_of_visits

$ips = [];

function compile_institutions($lines_data, $file_name){

	global $file_count;
	global $ips;
	global $institutions2;
	global $institutions3;
	global $institutions_dir;


	$result_data = [];

	foreach($lines_data as $line_data){

		$ip_address = $line_data['ip'];
		$unix_time = $line_data['date'];
		$sp7_version = $line_data['version'];
		$sp6_version = $line_data['dbVersion'];
		$institution = $line_data['institution'];
		$discipline = $line_data['discipline'];
		$collection = $line_data['collection'];
		$isa_number = $line_data['isaNumber'];
		$browser = $line_data['browser'];
		$os = $line_data['os'];

		//institution
		if(!array_key_exists($institution, $result_data))
			$result_data[$institution] = [];

		//discipline
		if(!array_key_exists($discipline, $result_data[$institution]))
			$result_data[$institution][$discipline] = [];

		//collection
		if(!array_key_exists($collection, $result_data[$institution][$discipline]))
			$result_data[$institution][$discipline][$collection] = [];

		//sp7
		if(!array_key_exists('sp7_version', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['sp7_version'] = [];

		//if(array_search($sp7_version,$result_data[$institution][$discipline][$collection]['sp7_version']) === FALSE)
		$result_data[$institution][$discipline][$collection]['sp7_version'][] = $sp7_version;

		//sp6
		if(!array_key_exists('sp6_version', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['sp6_version'] = [];

		//if(array_search($sp6_version,$result_data[$institution][$discipline][$collection]['sp6_version']) === FALSE)
		$result_data[$institution][$discipline][$collection]['sp6_version'][] = $sp6_version;

		//isa_number
		if(!array_key_exists('isa_number', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['isa_number'] = [];

		if($isa_number != ''/* && array_search($isa_number,$result_data[$institution][$discipline][$collection]['isa_number']) === FALSE*/)
			$result_data[$institution][$discipline][$collection]['isa_number'][] = $isa_number;

		//ip_address
		if(!array_key_exists('ip_address', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['ip_address'] = [];

		//if(array_search($ip_address,$result_data[$institution][$discipline][$collection]['ip_address']) === FALSE)
		$result_data[$institution][$discipline][$collection]['ip_address'][] = $ip_address;

		//browser
		if(!array_key_exists('browser', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['browser'] = [];

		//if(array_search($browser,$result_data[$institution][$discipline][$collection]['browser']) === FALSE)
		$result_data[$institution][$discipline][$collection]['browser'][] = $browser;

		//os
		if(!array_key_exists('os', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['os'] = [];

		//if(array_search($os,$result_data[$institution][$discipline][$collection]['os']) === FALSE)
		$result_data[$institution][$discipline][$collection]['os'][] = $os;


		$year = date(YEAR_FORMATTER, $unix_time);
		if(!array_key_exists('year', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['year'] = [];

		if(!array_key_exists($year, $result_data[$institution][$discipline][$collection]['year']))
			$result_data[$institution][$discipline][$collection]['year'][$year] = [];

		//month
		$month = date(MONTH_FORMATTER, $unix_time);
		if(!array_key_exists('month', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['month'] = [];

		if(!array_key_exists($month, $result_data[$institution][$discipline][$collection]['month']))
			$result_data[$institution][$discipline][$collection]['month'][$month] = [];

		//day
		$day = date(MONTH_FORMATTER, $unix_time);
		if(!array_key_exists('day', $result_data[$institution][$discipline][$collection]))
			$result_data[$institution][$discipline][$collection]['day'] = [];

		if(!array_key_exists($day, $result_data[$institution][$discipline][$collection]['day']))
			$result_data[$institution][$discipline][$collection]['day'][$day] = 1;
		else
			$result_data[$institution][$discipline][$collection]['day'][$day]++;


	}

	foreach($result_data as $institution => &$discipline_data){//add data to institutions2 and institutions3

		if(!array_key_exists($institution,$institutions2))
			$institutions2[$institution] = [];

		if(!array_key_exists($institution,$institutions3))
			$institutions3[$institution] = [];

		foreach($discipline_data as $discipline => &$collection_data){

			if(!array_key_exists($discipline,$institutions2[$institution]))
				$institutions2[$institution][$discipline] = [];

			if(!array_key_exists($discipline,$institutions3[$institution]))
				$institutions3[$institution][$discipline] = [];

			foreach($collection_data as $collection => &$data){

				if(!array_key_exists($collection,$institutions2[$institution][$discipline]))
					$institutions2[$institution][$discipline][$collection] = [];

				if(!array_key_exists($collection,$institutions3[$institution][$discipline]))
					$institutions3[$institution][$discipline][$collection] = 1;
				else
					$institutions3[$institution][$discipline][$collection]++;


				//sort arrays and make them distinct

				//sp7_version
				$data['sp7_version'] = array_unique($data['sp7_version']);
				natsort($data['sp7_version']);

				//sp6_version
				$data['sp6_version'] = array_unique($data['sp6_version']);
				natsort($data['sp6_version']);

				//isa_number
				$data['isa_number'] = array_unique($data['isa_number']);
				natsort($data['isa_number']);

				//ip_address
				$data['ip_address'] = array_unique($data['ip_address']);
				$ips = array_merge($ips, $data['ip_address']);

				//browser
				$data['browser'] = array_unique($data['browser']);

				//os
				$data['os'] = array_unique($data['os']);


				//move year,month,day usage data from institutions to institutions2

				foreach($data['year'] as $year => $month_data){

					if(!array_key_exists($year,$institutions2[$institution][$discipline][$collection]))
						$institutions2[$institution][$discipline][$collection][$year] = [];

					foreach($month_data as $month => $day_data){

						if(!array_key_exists($month,$institutions2[$institution][$discipline][$collection][$year]))
							$institutions2[$institution][$discipline][$collection][$year][$month] = [];

						foreach($day_data as $day => $count)
							if(!array_key_exists($day,$institutions2[$institution][$discipline][$collection][$year][$month]))
								$institutions2[$institution][$discipline][$collection][$year][$month][$day] = $count;

					}

				}

				unset($data['year']);

			}

		}

	}


	$file_name = $institutions_dir.$file_name.'.json';
	file_put_contents($file_name,json_encode($result_data));

	if(!file_exists($file_name))
		alert('danger','Failed to create <i>'.$file_name.'</i>');
	elseif(VERBOSE)
		alert('secondary','<i>'.$file_name.'</i> was successfully created');

	$file_count++;

}


function compile_institutions_end(){

	global $file_count;
	global $institutions2;
	global $institutions3;
	global $institutions2_dir;


	$institutions_count = count($institutions2);
	if($institutions_count>0)
		alert('info','Extracted information about '.$institutions_count.' institutions from '.$file_count.' files');

	$i=0;
	$institutions4 = [];//list of institutions and their IDs
	foreach($institutions2 as $institution => $institution_data){

		$institutions4[$i]=$institution;
		file_put_contents($institutions2_dir.$i.'.json',json_encode($institution_data));
		$i++;

	}

	file_put_contents(UNZIP_LOCATION.'institutions_ids.json',json_encode($institutions4));
	file_put_contents(UNZIP_LOCATION.'institutions.json',json_encode($institutions3));

}