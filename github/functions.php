<?php

function format_date($date,$long_format=TRUE){

	if($date=='')
		return '';

	$formatter = MONTH_FORMATTER.' '.DAY_FORMATTER;

	if(!$long_format)
		return  date($formatter,strtotime($date));

	$long_formatter = YEAR_FORMATTER.' '.$formatter;
	$date = date($long_formatter,strtotime($date));

	return '<a href="'.LINK.'?date='.urlencode($date).'">'.$date.'</a>';

}


function format_data_as_table($data,$columns){

	if(count($data)==0)
		return; ?>

	<table class="table table-striped">
		<thead>
			<tr> <?php

				foreach($columns as $column){ ?>

					<th><?=$column?></th><?php

				} ?>

			</tr>
		</thead>
		<tbody> <?php

		foreach($data as $result){ ?>

			<tr> <?php

				foreach($columns as $key => $value){ ?>

					<td><?=$result[$key]?></td> <?php

				} ?>
				</tr> <?php

		} ?>

		</tbody>
	</table> <?php

}

function referrers_parser($data){

	$columns = [
		'referrer' => 'Referrer',
		'count'    => 'Count',
		'uniques'  => 'Uniques',
	];

	format_data_as_table($data,$columns);


}

function paths_parser($data){

	$columns = [
		'path' => 'Path',
		'title'    => 'Title',
		'count'  => 'count',
		'uniques'  => 'uniques',
	];

	format_data_as_table($data,$columns);

}


function format_data_as_chart($data,$data_key,$chart_labels){

	static $chart_id = 0;
	$chart_id++;

	$labels = [];
	$count_data = [];
	$uniques_data = [];

	foreach($data[$data_key] as $record){
		$labels[] = format_date($record['timestamp'],FALSE);
		$count_data[] = $record['count'];
		$uniques_data[] = $record['uniques'];
	} ?>

	<p>Count: <?=$data['count']?></p>
	<p>Uniques: <?=$data['uniques']?></p>
	<canvas id="chart_<?=$chart_id?>_1" width="1000" height="300"></canvas>
	<canvas id="chart_<?=$chart_id?>_2" width="1000" height="300"></canvas>
	<script>
		create_chart($('#chart_<?=$chart_id?>_1'),'<?=$chart_labels[0]?>',JSON.parse('<?=json_encode($labels)?>'),JSON.parse('<?=json_encode($count_data)?>'));
		create_chart($('#chart_<?=$chart_id?>_2'),'<?=$chart_labels[0]?>',JSON.parse('<?=json_encode($labels)?>'),JSON.parse('<?=json_encode($uniques_data)?>'));
	</script> <?php

}

function views_per_day_parser($data){

	format_data_as_chart($data,'views',['Views per day','Unique views per day']);

}

function views_per_week_parser($data){

	format_data_as_chart($data,'views',['Views per week','Unique views per week']);

}

function clones_per_day_parser($data){

	format_data_as_chart($data,'clones',['Clones per week','Unique clones per week']);

}

function clones_per_week_parser($data){

	format_data_as_chart($data,'clones',['Clones per week','Unique clones per week']);

}


function releases_parser($data){

	if(count($data)==0)
		return; ?>

	<table class="table table-striped">
		<thead>
			<tr>

				<th>Name</th>
				<th>Date created</th>
				<th>Date published</th>
				<th>Author</th>
				<th>Assets</th>
				<th>Download count</th>

			</tr>
		</thead>
		<tbody> <?php

		foreach($data as $result){ ?>

			<tr>

					<td><a href="<?=$result['name']?>" target="_blank"><?=$result['name']?></a></td>
					<td><?=format_date($result['created_at'])?></td>
					<td><?=format_date($result['published_at'])?></td>
					<td><a href="<?=$result['author']['html_url']?>" target="_blank"><?=$result['author']['login']?></a></td> <?php

				$first_asset = TRUE;
				foreach($result['assets'] as $asset){

					if(!$first_asset)
						echo '</tr><tr><td></td><td></td><td></td><td></td>'; ?>

					<td><a href="<?=$asset['url']?>" target="_blank"><?=$asset['name']?></a></td>
					<td><?=$asset['download_count']?></td> <?php

					$first_asset = FALSE;

				} ?>

				</tr> <?php

		} ?>

		</tbody>
	</table> <?php

}