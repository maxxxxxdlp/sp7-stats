<?php

require_once('header.php');


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


$misc_file_path = WORKING_LOCATION.'misc.json';

if(!file_exists($misc_file_path)) // file does not exists because data was not refreshed yet
	header('Location: '.LINK.'refresh_data/');

$misc = json_decode(file_get_contents($misc_file_path),true);

$message_append = '';
$class_append = 'info';

if(time()-$misc['timestamp']>SHOW_DATA_OUT_OF_DATE_WARNING_AFTER){
	$message_append = 'You should probably refresh data now.';
	$class_append = 'warning';
} ?>


<div id="last_refresh_alert" class="alert alert-<?=$class_append?>" data-refresh_date="<?=$misc['timestamp']?>">
	Data was last refreshed <?=unix_time_to_human_time($misc['timestamp'],FALSE)?>.
	There are <?=$misc['total_lines']?> records total. <?=$message_append?>
</div>

<div class="btn-group" id="menu">
	<a
		href="<?=LINK?>refresh_data"
		class="btn btn-success"
		id="refresh"
		target="_blank">Refresh Data</a>
	<a href="<?=LINK?>" class="btn btn-info">Main Page</a>
	<a href="<?=LINK?>institutions/" class="btn btn-info">Show All Institutions</a>
</div>

<script>
	const SHOW_DATA_OUT_OF_DATE_WARNING_AFTER = <?=SHOW_DATA_OUT_OF_DATE_WARNING_AFTER?>;
</script><br><br> <?php

if($misc['timestamp']==0){
	header('Location: '.LINK.'refresh_data/');
	exit();
}