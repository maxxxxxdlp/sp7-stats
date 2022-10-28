<?php

global $github_username;
global $github_token;

require_once('../components/header.php');
require_once('../components/menu.php');


// TODO: update this
require_once(GITHUB_TOKEN_LOCATION);
if(!isset($github_username) && !isset($github_token))
	exit('No github username or token provided');

if(count(ALLOWED_REPOSITORIES)==0)
	exit('No repositories set in `ALLOWED_REPOSITORIES`');

$repository = ALLOWED_REPOSITORIES[0];
if(array_key_exists('repository',$_GET) && in_array($_GET['repository'],ALLOWED_REPOSITORIES))
	$repository = $_GET['repository']; ?>

Select repository:
<label>
	<select
			id="repository"
			class="form-control"> <?php

		foreach(ALLOWED_REPOSITORIES as $allowed_repository){

			$selected = '';
			if($allowed_repository == $repository)
				$selected = ' selected'; ?>

			<option value="<?=$allowed_repository?>" <?=$selected?>><?=$allowed_repository?></option> <?php

		} ?>

	</select>
</label> <?php


require_once('config.php');
require_once('functions.php');
require_once('../components/charts.php');
require_once('../components/paginator.php');


$page = 1;
if(array_key_exists('paginator',$_GET) &&
   array_key_exists($_GET['paginator'],$graphs) &&
   array_key_exists('page',$_GET) &&
   is_numeric($_GET['page']) &&
   $_GET['page']>1){

	$page = $_GET['page'];
	$graphs[$_GET['paginator']]['page']=$page;

}


if(!file_exists($target_dir)){//create $target_dir if does not exist and delete

	mkdir($target_dir,0777,$recursive=TRUE);

	if(!file_exists($target_dir))
		exit('Unable to create directory '.$target_dir.'. Please check your config and permissions');

}


$refresh_data = '';
if(array_key_exists('refresh_data', $_GET))
	$refresh_data = $_GET['refresh_data'];

if($refresh_data==='true'){//delete everything from that folder
	$files = glob($target_dir.'*.*');
	$files_count = count($files);

	foreach($files as $file)
		if(is_file($file))
			unlink($file);

	$files = glob($target_dir.'*.*');

	if(count($files) != 0)
		foreach($files as $file)
			exit('Failed to delete '.$target_dir.$file);
}

$target_file = $target_dir.'timestamp.txt';

if(!file_exists($target_file)){
	$refresh_data = 'true';
	echo '<div id="alert"></div>';
}
else {

	$timestamp = file_get_contents($target_file);

	$message_append = '';
	$class_append = 'info';

	if(time() - $timestamp > SHOW_DATA_OUT_OF_DATE_WARNING_AFTER){
		$message_append = 'You should probably refresh data now.';
		$class_append = 'warning';
	} ?>

	<div
		id="alert"
		class="alert alert-<?= $class_append ?>">
		Data was last refreshed <?= unix_time_to_human_time($timestamp) ?>. <?= $message_append ?>
	</div> <?php

} ?>

<br><br>
<div class="container-fluid" style="padding:0">
	<div class="row"> <?php

		function request_data($url,$target_dir,$target_file,$page){

			global $github_username;
			global $github_token;

			$original_url = $url;
			$original_file_name = $target_file;

			$recursive = $page!==FALSE;
			if($recursive){

				$url .= $page;

				$target_file = explode('.',$target_file);
				$target_file[count($target_file)-2] .= '_'.$page;
				$target_file = implode('.',$target_file);

			}

			$cURLConnection = curl_init($url);
			curl_setopt($cURLConnection,
			            CURLOPT_HTTPHEADER,
			            [
				            'User-Agent: ' . $github_username,
			            ]
			);
			curl_setopt($cURLConnection, CURLOPT_USERPWD, $github_username . ':' . $github_token);
			curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, TRUE);

			$api_response = curl_exec($cURLConnection);
			//$api_response = '{"test":"test"}';
			if($page===10)//force stop after 10 pages
				$api_response='{}';

			curl_close($cURLConnection);

			$data = json_decode($api_response, TRUE);

			if(!is_array($data))
				exit('Failed to get a valid response from ' . $url . ': ' . $api_response);

			if(count($data)==0 && $recursive)
				return file_put_contents($original_file_name,$page-1);

			file_put_contents($target_file, $api_response);

			if(!file_exists($target_file))
				exit('Failed to create a file: ' . $target_file);

			if($recursive)
				request_data($original_url,$target_dir,$original_file_name,$page+1);

			return $data;

		}

		$data_refreshed = FALSE;
		foreach($graphs as $graph_name => $graph_data){

			$target_file = $target_dir . $graph_name . $target_file_extension;
			$total_pages = 0;

			if(!array_key_exists('page',$graph_data))
				$graph_data['page'] = FALSE;

			if($refresh_data || !file_exists($target_file)){

				$url = $base_url . $graph_data['request_url'];

				$data = request_data($url,$target_dir,$target_file,$graph_data['page']);

				$data_refreshed = TRUE;

			}

			else {

				$file_data = file_get_contents($target_file);

				if($graph_data['page']!==FALSE){
					$total_pages = $file_data;

					if($total_pages=='')
						continue;

					$target_file = explode('.',$target_file);
					$target_file[count($target_file)-2] .= '_'.$page;
					$target_file = implode('.',$target_file);
					$file_data = file_get_contents($target_file);
				}

				$data = json_decode($file_data, TRUE);
				if(!is_array($data))
					exit('Failed to parse the content of '.$target_file.': ' . $file_data);

			} ?>

			<div class="col-12 col-xl-6 mb-5">

				<h2><?=$graph_data['title']?></h2>
				<p><?=$graph_data['description']?></p><?php

				$function_name = $graph_name.'_parser';
				$function_name($data); // run the parser function
				if($total_pages!=0)
					paginator(LINK.'github/?repository='.$repository.'&paginator='.$graph_name.'&page=',$page,$total_pages); ?>

			</div> <?php

		}

		if($data_refreshed){

			file_put_contents($target_dir.'timestamp.txt',time()); ?>

			<script>

				$('#alert')[0].outerHTML = '<div class="alert alert-success">Successfully refreshed data</div>';
				window.history.pushState('', "Specify 7 Stats", '?repository=<?=$repository?>');

			</script> <?php

		} ?>

	</div>
</div>

<script>

	const active_menu = 4;
	const link = '<?=LINK?>github/?repository=';
	const repository = '<?=$repository?>';

</script>
<script src="<?=LINK?>static/js/github<?=JS?>" defer></script>