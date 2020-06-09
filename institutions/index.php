<?php

const MENU_BUTTON = 4;
const USE_FILES = FALSE;
require_once('../components/menu.php');

$file_path = WORKING_LOCATION.'institutions.json';

if(!file_exists($file_path))
	exit('File does not exist');

$institutions = json_decode(file_get_contents($file_path),true);

echo '<ol>';
foreach($institutions as $institution => $disciplines){

	echo '<li>'.urldecode($institution).'<ul>';

	foreach($disciplines as $discipline => $collections){

		echo '<li>'.urldecode($discipline).'<ul>';

		foreach($collections as $collection => $count)
			echo '<li><a href="'.get_link_for_custom_get(['institution'=>$institution,'discipline'=>$discipline,'collection'=>$collection,'file'=>'','referrer'=>$real_link],FALSE,LINK.'/institution/?').'">'.urldecode($collection).'</a> ['.$count.']</li>';

		echo '</ul></li>';

	}

	echo '</ul></li>';

}
echo '</ol>';


footer();