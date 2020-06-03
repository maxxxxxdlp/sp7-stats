<?php

const JS = 'index';
const CSS = 'index';
const JQUERY = TRUE;

require_once('components/header.php');


$misc_file_path = UNZIP_LOCATION.'misc.json';
if(!file_exists($misc_file_path)){ // file does not exists because data was not refreshed yet

	header('Location: '.LINK.'refresh_data/');
	exit();

}

$misc = json_decode(file_get_contents($misc_file_path),true);


function unix_time_to_human_time($time){

	$time_passed = time()-$time;

	if($time_passed<60)
		return $time_passed.' seconds ago';

	if($time_passed<3600)
		return intval($time_passed/60).' minutes ago';

	if($time_passed<86400)
		return intval($time_passed/3600).' hours ago';

	return intval($time_passed/86400).' days ago';

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
	const link = '<?=LINK?>';
</script>  <?php

if($current_file==0)
	$files = glob(UNZIP_LOCATION.'tsv/*.tsv');
else
	$files = [UNZIP_LOCATION.'tsv/'.$current_file];

?>

<table class="table table-striped">
	<thead>
		<tr>

			<th>Record</th> <?php

			foreach(COLUMNS as $column)
				echo '<th>'.$column.'</th>'; ?>

		</tr>
	</thead>
	<tbody> <?php

		$line_number=1;
		foreach($files as $file){


			$data = file_get_contents($file);
			$data = explode("\n",$data);

			foreach($data as $line){

				$line_data = array_merge([$line_number],explode("\t",$line));

				echo '<tr>';

				$count = count($line_data);
				for($i=0;$i<$count;$i++)
					if($i==2)
						echo '<td>'.unix_time_to_human_time($line_data[$i]).'</td>';
					else
						echo '<td>'.$line_data[$i].'</td>';

				echo '</tr>';

				$line_number++;

			}


		} ?>

	</tbody>
</table> <?php


footer();