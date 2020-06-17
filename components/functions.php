<?php

function require_file($require){

	require_once(dirname(__FILE__).'/'.$require);

}


function unix_time_to_human_time($time,$use_days=TRUE){

	if($use_days)
		$time *= 86400;

	$time_passed = time()-$time;

	if($time_passed<60)
		$result = $time_passed.' seconds ago';

	elseif($time_passed<3600)
		$result = intval($time_passed/60).' minutes ago';

	elseif($time_passed<86400)
		$result = intval($time_passed/3600).' hours ago';

	else
		$result = intval($time_passed/86400).' days ago';

	return preg_replace('/^(1 \w+)s( ago)/','$1$2',$result);

}