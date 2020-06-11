<?php

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
			echo '<li><a href="'.LINK.'institution/?institution='.$institution.'&discipline'.$discipline.'&collection'.$collection.'">'.urldecode($collection).'</a> ['.$count.']</li>';

		echo '</ul></li>';

	}

	echo '</ul></li>';

}
echo '</ol>';