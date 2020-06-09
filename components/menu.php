<?php

const JQUERY = TRUE;
const MENU_JS = TRUE;

require_once('header.php');

$real_link = LINK.substr($_SERVER['REQUEST_URI'],1);



function get_link_for_custom_get($GET,$trailing_symbol=FALSE,$origin_link=NULL,$url_encode=FALSE){

	static $get_less_link='';

	if($get_less_link == ''){

		$get_less_link = $_SERVER['PHP_SELF'];
		$get_less_link = str_replace('index.php', '', $get_less_link);
		$get_less_link = substr($get_less_link, 1);
		$get_less_link = LINK . $get_less_link . '?';

	}

	if($origin_link)
		$link = $origin_link;
	else
		$link = $get_less_link;

	foreach($GET as $key => $value)
		if($value=='')
			continue;
		else if($url_encode)
			$link .= $key . '=' . urlencode($value) . '&';
		else
			$link .= $key . '=' . $value . '&';

	foreach($_GET as $key => $value)
		if(array_key_exists($key,$GET))
			continue;
		else
			$link .= $key . '=' . $value . '&';

	if(!$trailing_symbol)
		$link = substr($link, 0, -1);

	return $link;

}

$file_less_link = get_link_for_custom_get(['file'=>''],TRUE);

$reverse = false;
if(array_key_exists('reverse',$_GET))
	$reverse = $_GET['reverse']=='true';
$reverse_reverse_string = !$reverse ? 'true' : 'false';
$reverse_sort_link = get_link_for_custom_get(['reverse'=>$reverse_reverse_string]);


$misc_file_path = WORKING_LOCATION.'misc.json';

if(!file_exists($misc_file_path)){ // file does not exists because data was not refreshed yet

	header('Location: '.LINK.'refresh_data/?referrer='.$real_link);
	exit();

}

$misc = json_decode(file_get_contents($misc_file_path),true);


function unix_time_to_human_time($time){

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


$info_message = 'Data was last refreshed '.unix_time_to_human_time($misc['timestamp']).'.';
$info_message_level = 'info';

if(array_key_exists('total_lines',$misc))
	$info_message .= ' There are '.$misc['total_lines'].' records total';

if(time() - $misc['timestamp'] > SHOW_DATA_OUT_OF_DATE_WARNING_AFTER){
	$info_message .= ' You should probably refresh data now';
	$info_message_level = 'warning';
}
echo '<div id="last_refresh_alert" class="alert alert-'.$info_message_level.'">'.$info_message.'</div>';



$files = glob(WORKING_LOCATION.'tsv/*.tsv');
$files = array_reverse($files); ?>

<div class="btn-group" id="menu">
	<a
		href="<?=LINK?>refresh_data/?referrer=<?=$real_link?>"
		class="btn btn-success"
		id="refresh"
		target="_blank">Refresh Data</a>
	<a href="<?=LINK?>" class="btn btn-info">Main Page</a>
	<a href="<?=LINK?>list/" class="btn btn-info">Show Raw Data</a>
	<a href="<?=LINK?>institutions/" class="btn btn-info">Show All Institutions</a>
</div>
<script> <?php
	if(defined('MENU_BUTTON'))
		echo 'const menu_button = '.MENU_BUTTON.';'; ?>
</script><br><br> <?php

if($misc['total_lines']==0){
	footer();
	exit();
}

if(!defined('USE_FILES') || USE_FILES){ ?>
	<label class="mb-4">
		<select
			id="show_data_for"
			class="form-control"> <?php

			if(array_key_exists('file',$_GET) && file_exists(WORKING_LOCATION.'tsv/'.$_GET['file']))
				$current_file = $_GET['file'];
			else
				$current_file = FALSE;

			$first_unix_begin = NULL;

			foreach($files as $file){

				$file = explode('/',$file);
				$file = $file[count($file)-1];
				$unix_times = explode('.',$file)[0];
				$unix_times = explode('_',$unix_times);
				$unix_begin = unix_time_to_human_time($unix_times[0]);
				$unix_end = unix_time_to_human_time($unix_times[1]);

				$selected_append = '';

				if(!$first_unix_begin)
					$first_unix_begin = $unix_begin;

				if(!$current_file)
					$current_file = $file;

				if($file==$current_file)
					$selected_append = 'selected'; ?>

				<option value="<?=$file?>" <?=$selected_append?>><?=$unix_begin?> - <?=$unix_end?></option> <?php

			} ?>

		</select>
	</label><br>

	<script>
		const current_file = '<?=$current_file?>';//the value of $_GET['file']
		const link = '<?=$real_link?>';//the URL of this page
		const file_less_link = '<?=$file_less_link?>';//the URL of this page without $_GET['file']
		const link_const = '<?=LINK?>';//the LINK const from PHP
	</script>  <?php

	if(strtotime($first_unix_begin)>SHOW_DATA_OUT_OF_DATE_WARNING_AFTER && $info_message_level=='info'){ ?>
		<script>
			$('#last_refresh_alert')[0].outerHTML += '<div class="alert alert-danger">We have not received any new log files since <?=$first_unix_begin?>. Make sure `FILES_LOCATION` is set correctly to your Nginx\'s log directory</div>';
		</script> <?php
	}

	$files = [WORKING_LOCATION.'tsv/'.$current_file];

	if(!$reverse)
		$files = array_reverse($files);

}