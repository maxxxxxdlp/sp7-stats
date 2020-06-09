<?php

require_once('components/menu.php');

if(!isset($current_file))
	exit();

$json_file = str_replace('tsv','json',$current_file);
$file_path = UNZIP_LOCATION.'institutions/';

if(!file_exists($file_path.$json_file))
	exit('File does not exist');

$institutions = json_decode(file_get_contents($file_path.$json_file),true);

echo '<ol>';
foreach($institutions as $institution => $disciplines){

	echo '<li><a href="' . get_link_for_custom_get(['Institution' => $institution, 'Discipline' => '', 'Collection' => ''], FALSE, LINK . '/institutions/') . '">'.urldecode($institution).'</a><ul>';

	foreach($disciplines as $discipline => $collections){

		echo '<li><a href="'.get_link_for_custom_get(['Institution'=>$institution,'Discipline'=>$discipline,'Collection'=>'',FALSE,LINK.'/institutions/']).'">'.urldecode($discipline).'</a><ul>';

		foreach($collections as $collection => $data){
			echo '<li>
				<a href="'.get_link_for_custom_get(['Institution'=>$institution,'Discipline'=>$discipline,'Collection'=>$collection,FALSE,LINK.'/institutions/']).'">'.urldecode($collection).'</a>
				<br>Specify 7 versions: '.implode(', ',$data['sp7_version']).'
				<br>Specify 6 versions: '.implode(', ',$data['sp6_version']);

			if(count($data['isa_number'])>0)
				echo '<br>ISA Numbers: '.implode(', ',$data['isa_number']);

			echo '<br>IP Addresses:<ul>';

			foreach($data['ip_address'] as $ip_address)
				echo '<li><a href="'.LINK.'ip_info?ip='.$ip_address. '" target="_blank">'.$ip_address.'</a></li>';

			echo '</ul>
				<br>Browsers:<ul>';

				foreach($data['browser'] as $browser)
					echo '<li>'.$browser.'</li>';

				echo '</ul>
				<br>Operating Systems:<ul>';

				foreach($data['os'] as $os)
					echo '<li>'.$os.'</li>';

				echo '</ul></li>';

		}

		echo '</ul></li>';

	}

	echo '</ul></li>';

}
echo '</ol>';


footer();