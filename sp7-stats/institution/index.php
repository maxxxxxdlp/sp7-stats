<?php

require_once('../components/heading.php');


if(!array_key_exists('institution',$_GET) || !array_key_exists('discipline',$_GET) || !array_key_exists('collection',$_GET))
	exit('Error: invalid URL');


//fix for browsers automatically encoding/decoding params in the URL
$institution = urlencode(urldecode($_GET['institution']));
$discipline = urlencode(urldecode($_GET['discipline']));
$collection = urlencode(urldecode($_GET['collection']));


$institutions_file = WORKING_LOCATION.'institutions_id.json';
if(!file_exists($institutions_file))
	exit('institution_ids.json does not exits. You should press the `Refresh Data` button');


$institutions = json_decode(file_get_contents($institutions_file),true);
$institution_id = array_search($institution,$institutions);
if($institution_id===FALSE)
	exit('Institution not found');


$institution_file = WORKING_LOCATION.'institutions2/'.$institution_id.'.json';
if(!file_exists($institution_file))
	exit('Failed to find the file with data for this institution. Check your URL or Refresh Data');
$data = json_decode(file_get_contents($institution_file),true);


if(!array_key_exists($discipline,$data))
	exit('Discipline not found');

if(!array_key_exists($collection,$data[$discipline]))
	exit('Collection not found');


echo '<h1>'.urldecode($institution.' > '.$discipline.' > '.$collection).'</h1><br>';
$data = $data[$discipline][$collection];


if(array_key_exists('year',$_GET))
	$chosen_year = urldecode($_GET['year']);
else
	$chosen_year = '';
if(array_key_exists('month',$_GET))
	$chosen_month = urldecode($_GET['month']);
else
	$chosen_month = '';


require_once('../components/charts.php'); ?>


<label>
	<select
		id="year_select"
		class="form-control"><?php

		foreach(array_keys($data[0]) as $year){ ?>

			<option value="<?=$year?>"><?=$year?></option> <?php

		} ?>

	</select>
</label>
<label>
	<select
			id="month_select"
			class="form-control"></select>
</label>
<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-xl-6"><canvas id="months_chart" width="1000" height="300"></canvas></div>
		<div class="col-12 col-xl-6"><canvas id="days_chart" width="1000" height="300"></canvas></div>
	</div>
</div>
<script>
	const days = JSON.parse('<?=json_encode($data[1])?>');
	const months = JSON.parse('<?=json_encode($data[0])?>');
	const link = '<?=LINK?>?date=';
	const chosen_year = '<?=$chosen_year?>';
	let chosen_month = '<?=$chosen_month?>';
</script>
<script src="../static/js/institution<?=JS?>" async></script>