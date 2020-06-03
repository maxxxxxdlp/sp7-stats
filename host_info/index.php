<?php

const JS = 'host_info';

require_once('../components/menu.php');


if(!array_key_exists('ip',$_GET))
	header('Location: '.LINK);

$ip_address = $_GET['ip'];

//$files
$per_day = [];
$per_month = [];
$per_year = [];

if(isset($current_file) && $current_file==0)
	$files = glob(UNZIP_LOCATION.'ips/*.json');
else
	$files = [UNZIP_LOCATION.'ips/'.substr($current_file,0,-3).'json'];

array_reverse($files);


foreach($files as $file){

	$data = file_get_contents($file);
	$data = json_decode($data,true);

	foreach($data as $ips => $dates){

		if($ips != $ip_address)
			continue;

		foreach($dates as $unix){

			$month = date('F',$unix);
			$day = date('j D',$unix);
			$year = date('Y',$unix);


			if(!array_key_exists($year,$per_day))
				$per_day[$year] = [];

			if(!array_key_exists($month,$per_day[$year]))
				$per_day[$year][$month] = [];

			if(!array_key_exists($day,$per_day[$year][$month]))
				$per_day[$year][$month][$day] = 1;
			else
				$per_day[$year][$month][$day]++;


			if(!array_key_exists($year,$per_month))
				$per_month[$year] = [];

			if(!array_key_exists($month,$per_month[$year]))
				$per_month[$year][$month] = 1;
			else
				$per_month[$year][$month]++;

			if(!array_key_exists($year,$per_year))
				$per_year[$year] = 1;
			else
				$per_year[$year]++;

		}

	}

}


$ip_data = json_decode(file_get_contents("http://ip-api.com/json/".$ip_address."?fields=country,regionName,city,org,reverse"),true);

$column_mapping = [
		'ip' => 'IP Address',
		'country' => 'Country',
		'regionName' => 'Region Name',
		'city' => 'City',
		'org' => 'Organization',
		'reverse' => 'Domain name',
]; ?>

<table class="table table-striped">

	<thead>

		<tr>

			<th>IP Address</th>
			<th><?=$ip_address?></th>

		</tr>

	</thead>

	<tbody> <?php

		foreach($ip_data as $key => $value){ ?>

			<tr>
				<td><?=$column_mapping[$key]?></td>
				<td><?=$value?></td>
			</tr> <?php

		} ?>

	</tbody>

</table>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
<label>
	<select
			id="year_select"
			class="form-control"></select>
</label>
<label>
	<select
			id="month_select"
			class="form-control"></select>
</label>
<canvas id="years_chart" width="1000" height="300"></canvas>
<canvas id="months_chart" width="1000" height="300"></canvas>
<canvas id="days_chart" width="1000" height="300"></canvas>
<script>
	let days = JSON.parse('<?=json_encode($per_day)?>');
	let months = JSON.parse('<?=json_encode($per_month)?>');
	let years = JSON.parse('<?=json_encode($per_year)?>');
</script>

<?php

footer();