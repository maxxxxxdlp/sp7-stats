<?php

const JQUERY = TRUE;
const MENU_JS = TRUE;

require_once('header.php');

$real_link = LINK.substr($_SERVER['REQUEST_URI'],1);



function get_link_for_custom_get($GET,$trailing_symbol=FALSE){

	static $get_less_link='';

	if($get_less_link == ''){
		$get_less_link = $_SERVER['PHP_SELF'];
		$get_less_link = str_replace('index.php', '', $get_less_link);
		$get_less_link = substr($get_less_link, 1);
		$get_less_link = LINK . $get_less_link . '?';
	}

	$link = $get_less_link;

	foreach($GET as $key => $value)
		if($value=='')
			continue;
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


$misc_file_path = UNZIP_LOCATION.'misc.json';

if(!file_exists($misc_file_path)){ // file does not exists because data was not refreshed yet

	header('Location: '.LINK.'refresh_data/?referrer='.$real_link);
	exit();

}

$misc = json_decode(file_get_contents($misc_file_path),true);



function unix_time_to_human_time($time){

	$time_passed = time()-$time;
	$result = '';

	if($time_passed<60)
		$result = $time_passed.' seconds ago';

	elseif($time_passed<3600)
		$result = intval($time_passed/60).' minutes ago';

	elseif($time_passed<86400)
		$result = intval($time_passed/3600).' hours ago';

	else
		$result = intval($time_passed/86400).' days ago';

	return preg_replace('/(1 \w+)s( ago)/','$1$2',$result);

}


$info_message = 'Data was last refreshed '.unix_time_to_human_time($misc['timestamp']).'.';
$info_message_level = 'info';
if(time() - $misc['timestamp'] > SHOW_DATA_OUT_OF_DATE_WARNING_AFTER){
	$info_message .= ' You should probably refresh data now';
	$info_message_level = 'warning';
}
echo '<div class="alert alert-'.$info_message_level.'">'.$info_message.'</div>';


$files = glob(UNZIP_LOCATION.'tsv/*.tsv'); ?>

	<a
		href="refresh_data/"
		class="btn btn-success"
		id="refresh"
		target="_blank">Refresh Data</a><br><br>

	<label>
	<select
		id="show_data_for"
		class="form-control">

		<option name="0">Show data for entire period</option> <?php

		if(array_key_exists('file',$_GET) && file_exists(UNZIP_LOCATION.'tsv/'.$_GET['file']))
			$current_file = $_GET['file'];
		else
			$current_file = 0;

		foreach($files as $file){

			$file = explode('/',$file);
			$file = $file[count($file)-1];
			$unix_times = explode('.',$file)[0];
			$unix_times = explode('_',$unix_times);
			$unix_begin = unix_time_to_human_time($unix_times[0]);
			$unix_end = unix_time_to_human_time($unix_times[1]);

			$selected_append = '';

			if($file==$current_file)
				$selected_append = 'selected'; ?>

			<option name="<?=$file?>" <?=$selected_append?>><?=$unix_begin?> - <?=$unix_end?></option> <?php

		} ?>

	</select>
</label><br>

	<script>
	const current_file = '<?=$current_file?>';
	const link = '<?=$real_link?>';
	const file_less_link = '<?=$file_less_link?>';
</script>  <?php

if($current_file==0)
	$files = glob(UNZIP_LOCATION.'tsv/*.tsv');
else
	$files = [UNZIP_LOCATION.'tsv/'.$current_file];


if(!$reverse)
	$files = array_reverse($files);