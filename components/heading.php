<?php

require_once('header.php');


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

<div id="last_refresh_alert" class="alert alert-<?=$class_append?>">
	Data was last refreshed <?=unix_time_to_human_time($misc['timestamp'])?>.<br>
	There are <?=$misc['total_lines']?> records total.<br>
	Your records span from <?=unix_time_to_human_time($misc['first_time'])?> till <?=unix_time_to_human_time($misc['last_time'])?>.<br> <?=$message_append?>
</div>

<script>
	const SHOW_DATA_OUT_OF_DATE_WARNING_AFTER = <?=SHOW_DATA_OUT_OF_DATE_WARNING_AFTER?>;
</script> <?php

require_once('menu.php');

if($misc['timestamp']==0){
	header('Location: '.LINK.'refresh_data/');
	exit();
}