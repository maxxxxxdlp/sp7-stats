<?php

require_once('../components/menu.php');


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
$data = $data[$discipline][$collection]; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<label>
	<select
			id="year_select"
			class="form-control"><?php

			foreach(array_keys($data[0]) as $year)
				echo '<option value="'.$year.'">'.$year.'</option>'; ?>

		</select>
</label>
<label>
	<select
			id="month_select"
			class="form-control"></select>
</label>
<canvas id="months_chart" width="1000" height="300"></canvas>
<canvas id="days_chart" width="1000" height="300"></canvas>
<script>
	let days = JSON.parse('<?=json_encode($data[1])?>');
	let months = JSON.parse('<?=json_encode($data[0])?>');
</script>
<script src="../static/js/institution.js"></script>