<?php

global $total_lines;

require_once('header.php');


function unix_time_to_human_time($time){

	$days_passed = intval(time()/86400)-$time;

	if($days_passed<1)
		return 'a few hours ago';

	if($days_passed==1)
		return '1 day ago';

	return $days_passed.' days ago';

} ?>


<div id="last_refresh_alert" class="alert" data-refresh_date="<?=$_SERVER['REQUEST_TIME']?>">
	Data was last refreshed <?=unix_time_to_human_time($_SERVER['REQUEST_TIME'])?>.
	There are <?=$total_lines?> records total.
</div>

<div class="btn-group" id="menu">
	<a
		href="<?=LINK?>refresh_data"
		class="btn btn-success"
		id="refresh"
		target="_blank">Refresh Data</a>
	<a href="<?=LINK?>" class="btn btn-info">Main Page</a>
	<a href="<?=LINK?>list/" class="btn btn-info">Show Raw Data</a>
	<a href="<?=LINK?>institutions/" class="btn btn-info">Show All Institutions</a>
</div>

<script>
	const SHOW_DATA_OUT_OF_DATE_WARNING_AFTER = <?=SHOW_DATA_OUT_OF_DATE_WARNING_AFTER?>;
	const menu_button = <?=(isset($menu_link)?$menu_link:0)?>;
</script><br><br>

<script src="../static/js/menu.js"></script><?php

if($total_lines==0){
	header('Location: '.LINK.'refresh_data/');
	exit();
}