<?php

function identify_data_for_user_agent_string($user_agent_string){

	$os = '';
	$browser = '';


	$os_simple_needles = [
		'Windows NT 10.0'=>'Windows 10',
		'Windows NT 6.3'=>'Windows 8.1',
		'Windows NT 6.2'=>'Windows 7',
		'Windows NT 6.0'=>'Windows Vista',
		'Windows NT 5.1'=>'Windows XP',
		'Windows'=>'Windows',
		'Mac OS X 10_15'=>'Mac OS X Catalina',
		'Mac OS X 10_14'=>'Mac OS X Mojave',
		'Mac OS X 10_13'=>'Mac OS X High Sierra',
		'Mac OS X 10_12'=>'Mac OS X Sierra',
		'Mac OS X 10_11'=>'Mac OS X El Capitan',
		'Mac OS X 10_10'=>'Mac OS X Yosemite',
		'Mac OS X 10_9'=>'Mac OS X Mavericks',
		'Mac OS X 10_8'=>'Mac OS X Mountain Lion',
		'CrOS'=>'Chrome OS',
		'Ubuntu; Linux x86_64'=>'Ubuntu x64',
		'Linux x86_64'=>'Linux x64',
	];

	$os_complex_needles = [
		'Android'=>'/Android \d/',
		'iPhone OS'=>'/iPhone OS \d+/',
		'Mac OS X'=>'/Mac OS X [\d_]+/',
	];

	foreach($os_simple_needles as $needle => $result)
		if(strpos($user_agent_string,$needle)!==FALSE){
			$os = $result;
			break;
		}

	if($os=='')
		foreach($os_complex_needles as $needle => $regex)
			if(strpos($user_agent_string,$needle)!==FALSE){
				preg_match($regex,$user_agent_string,$matches);

				if(count($matches)!=0){
					$os = $matches[0];
					break;
				}
			}

	if($os=='')
		$os = DEFAULT_OS;


	$browser_simple_needles = [
		'Trident/7.0'=>'Internet Explorer 11',
	];

	$browser_complex_needles = [
		'Version'=>['/Version\/([\d]+)/','Safari $1'],
		'Firefox'=>['/Firefox\/(\d+)/','Firefox $1'],
		'MSIE'=>['/MSIE \d+.0/','Internet Explorer$1'],
		'SamsungBrowser'=>['/SamsungBrowser\/(\d+)/','Samsung Browser $1'],
		'Edg'=>['/Edge?\/(\d+)/','Microsoft Edge $1'],
		'Chrom'=>['/Chrome\/(\d+)[\d\.]+ Mobile/','Chrome Mobile $1'],
		'Chrome'=>['/Chrome\/(\d+)/','Chrome $1'],
	];

	foreach($browser_simple_needles as $needle => $result)
		if(strpos($user_agent_string,$needle)!==FALSE){
			$browser = $result;
			break;
		}

	if($browser=='')
		foreach($browser_complex_needles as $needle => $regex)
			if(strpos($user_agent_string,$needle)!==FALSE){

				if(is_array($regex)){
					preg_match($regex[0],$user_agent_string,$matches);
					if(count($matches)!=0){
						$browser = preg_replace($regex[0],$regex[1],$matches)[0];
						break;
					}
				}
				else {
					preg_match($regex,$user_agent_string,$matches);

					if(count($matches)!=0){
						$browser = $matches[0];
						break;
					}
				}

			}

	if($browser=='')
		$browser = DEFAULT_BROWSER;


	return [$browser,$os];
}


function get_data_for_user_agent_string($user_agent_string=''){

	static $curl=NULL;
	static $data=FALSE;

	if($user_agent_string=='SAVE_DATA'){
		file_put_contents(WORKING_LOCATION.'persistent/user_agent_strings.json',json_encode($data));
		return TRUE;
	}

	if($data === FALSE){//fetch data if did not do so yet

		$file = WORKING_LOCATION.'persistent/user_agent_strings.json';
		$data = [];
		if(file_exists($file))
			$data = json_decode(file_get_contents(WORKING_LOCATION.'persistent/user_agent_strings.json'),true);

		if(!$data)
			$data = [];

	}

	if(array_key_exists($user_agent_string,$data))//return fetched data if matches the requested user agent string
		return $data[$user_agent_string];

	$data[$user_agent_string] = identify_data_for_user_agent_string($user_agent_string);

	return $data[$user_agent_string];

}