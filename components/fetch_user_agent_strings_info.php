<?php

if(USERSTACK_API_KEY_LOCATION===FALSE)
	alert('info','Ignored userstack.com api because `USERSTACK_API_KEY_LOCATION` is set to FALSE');

elseif(!file_exists(USERSTACK_API_KEY_LOCATION))
	alert('danger','Failed to find the api key for userstack.com. Make sure `USERSTACK_API_KEY_LOCATION` is set correctly. Set it to FALSE to ignore this check');

else {

	//$user_agent_strings = array_unique($user_agent_strings);

	$file = UNZIP_LOCATION.'persistent/user_agent_strings.json';

	$result = [];
	if(file_exists($file))
		$result = json_decode(file_get_contents(UNZIP_LOCATION.'persistent/user_agent_strings.json'),true);

	if(!$result)
		$result = [];

	/*
{
  "browser":{
    "name":"Chrome",
    "version":"84.0.4147.30",
    "version_major":"84",
    "engine":"WebKit\/Blink"
  },
  "os":{
    "name":"macOS 10.15 Catalina",
    "code":"macos_10_15",
    "url":"https:\/\/en.wikipedia.org\/wiki\/MacOS_Catalina",
    "family":"macOS",
    "family_code":"macos",
    "family_vendor":"Apple Inc.",
    "icon":"https:\/\/assets.userstack.com\/icon\/os\/macosx.png",
    "icon_large":"https:\/\/assets.userstack.com\/icon\/os\/macosx_big.png"
  },
  "device":{  //edit the $request_url to start getting the device information
    "is_mobile_device":false,
    "type":"desktop",
    "brand":"Apple",
    "brand_code":"apple",
    "brand_url":"https:\/\/www.apple.com\/",
    "name":"Mac"
  }
}
	 * */



	//global $user_agent_strings;

	function get_data_for_user_agent_string($user_agent_string='',$action=''){

		static $request_url='';
		static $curl=NULL;
		static $data=FALSE;


		if($user_agent_string==''){//handle closing curl connection and saving data

			if($action=='CLOSE_CURL' && $curl!=NULL){
				curl_close($curl);
				return TRUE;
			}

			elseif($action=='SAVE_DATA'){
				file_put_contents(UNZIP_LOCATION.'persistent/user_agent_strings.json',json_encode($data));
				return TRUE;
			}

		}


		if(!defined('USERSTACK_API_KEY_LOCATION'))//get constants from config if not defined
			require_once('../config.php');


		if(!file_exists(USERSTACK_API_KEY_LOCATION)){//report warning if key does not exist
			alert('warning','Key does not exist at '.USERSTACK_API_KEY_LOCATION.'. Please check the value of USERSTACK_API_KEY_LOCATION constant');
			return FALSE;
		}


		if($data === FALSE){//fetch data if did not do so yey

			$file = UNZIP_LOCATION.'persistent/user_agent_strings.json';
			$data = [];
			if(file_exists($file))
				$data = json_decode(file_get_contents(UNZIP_LOCATION.'persistent/user_agent_strings.json'),true);

			if(!$data)
				$data = [];

		}


		if(array_key_exists($user_agent_string,$data))//return fetched data if matches the requested user agent string
			return $data[$user_agent_string];


		if($request_url===''){//build request URL if needed
			$api_key = trim(file_get_contents(USERSTACK_API_KEY_LOCATION));
			$request_url = 'http://api.userstack.com/detect?fields=browser,os&access_key='.$api_key;
		}


		if($curl == NULL)//initialize curl if needed
			$curl = curl_init();

		curl_setopt($curl,CURLOPT_URL, $request_url.'&ua='.urlencode($user_agent_string));

		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);

		$response = json_decode($response,true);
		$curl_error = curl_error($curl);

		if($curl_error!=''){//report curl error if present
			alert('warning', 'Failed to get data about the following User Agent string from userstack.com: ' . $user_agent_string . '<br>Error message: ' . $curl_error);
			return FALSE;
		}

		$browser = $response['browser']['name'].' '.$response['browser']['version_major'];
		$os = $response['os']['name'];

		if(VERBOSE)
			alert('secondary','Successfully received User Agent string data from userstack.com for: '.$user_agent_string);

		if($action=='SAVE_DATA')
			get_data_for_user_agent_string('','SAVE_DATA');

		if($action=='CLOSE_CURL')
			get_data_for_user_agent_string('','CLOSE_CURL');

		return [$browser,$os];

	}

}