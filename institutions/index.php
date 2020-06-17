<?php

require_once('../components/heading.php');
require_once('../static/html/search_form.html'); ?>

<script src="<?=LINK?>static/js/stats.js"></script>
<script>
	const search_mode = 'list';
	const link = '<?=LINK?>institutions/?';
	const search_callback = update_stats;
	const active_menu = 3;
</script> <?php

$file_path = WORKING_LOCATION.'institutions.json';

if(!file_exists($file_path))
	exit('File does not exist');

$institutions = json_decode(file_get_contents($file_path),true);

$times = 0;
if(array_key_exists('hide',$_GET) && is_numeric($_GET['hide']) && $_GET['hide']>0)
	$times = intval($_GET['hide']);

if($times!=0)
	foreach($institutions as $institution => &$disciplines){

		foreach($disciplines as $discipline => &$collections){

			foreach($collections as $collection => $count)
				if($count<$times)
					unset($collections[$collection]);

			if(count($collections)==0)
				unset($disciplines[$discipline]);

		}

		if(count($disciplines)==0)
			unset($institutions[$institution]);

	} ?>

<br>
<label>
	Hide collections that reported fewer than
	<input type="number" id="count" value="<?=$times?>">
	times
</label><br><br>
<div id="stats" class="alert alert-info"></div>
<ol> <?php

$institutions_count = count($institutions);
$disciplines_count = 0;
$collections_count = 0;
$reports_count = 0;
foreach($institutions as $institution => $disciplines){

	echo '<li>'.urldecode($institution).'<ul>';

	foreach($disciplines as $discipline => $collections){

		echo '<li>'.urldecode($discipline).'<ul>';

		foreach($collections as $collection => $count){
			echo '<li data-reports_count="'.$count.'"><a href="' . LINK . 'institution/?institution=' . $institution . '&discipline=' . $discipline . '&collection=' . $collection . '">' . urldecode($collection) . '</a> [' . $count . ']</li>';

			$collections_count++;
			$reports_count+=$count;
		}

		echo '</ul></li>';

		$disciplines_count++;

	}

	echo '</ul></li>';

} ?>

</ol>
<script>
	const institution_count = '<?=$institutions_count?>';
	const discipline_count = '<?=$disciplines_count?>';
	const collection_count = '<?=$collections_count?>';
	const report_count = '<?=$reports_count?>';
</script>