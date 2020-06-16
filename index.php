<?php

require_once('components/menu.php');

$target_dir = WORKING_LOCATION.'institutions/';
$target_extension = '.json';
$files = glob($target_dir.'*'.$target_extension);
$files = array_reverse($files);

if(array_key_exists('file_1',$_GET) && file_exists($target_dir.$_GET['file_1'].$target_extension) && strlen($_GET['file_1'])===5 && is_numeric($_GET['file_1']))
	$first_day = intval($_GET['file_1']);
else
	$first_day = FALSE;

if(array_key_exists('file_2',$_GET) && file_exists($target_dir.$_GET['file_2'].$target_extension) && strlen($_GET['file_2'])===5 && is_numeric($_GET['file_2']))
	$last_day = intval($_GET['file_2']);
else
	$last_day = FALSE;

$first_unix_begin = NULL;
$result_1 = '';
$result_2 = '';
$institutions = [];


foreach($files as $file){

	$unix_time = explode('/', $file);
	$unix_time = end($unix_time);
	$unix_time = explode('.', $unix_time);
	$unix_time = intval($unix_time[0]);

	$selected_1_append = '';
	$selected_2_append = '';

	if(!$first_unix_begin)
		$first_unix_begin = $unix_time;

	if(!$first_day)
		$first_day = $unix_time;

	if(!$last_day)
		$last_day = $unix_time;

	if($first_day>$last_day)
		[$first_day,$last_day] = [$last_day,$first_day];

	if($unix_time == $first_day)
		$selected_1_append = 'selected';

	if($unix_time == $last_day)
		$selected_2_append = 'selected';

	if($unix_time >= $first_day && $unix_time <= $last_day){

		$data = json_decode(file_get_contents($file),TRUE);
		$institutions = array_merge_recursive($institutions,$data);

	}

	$human_time = unix_time_to_human_time($unix_time);

	$result_1 .= '<option value="'.$unix_time.'" '.$selected_1_append.'>' . $human_time . '</option>';
	$result_2 .= '<option value="'.$unix_time.'" '.$selected_2_append.'>' . $human_time . '</option>';

}

foreach($institutions as &$disciplines)

	foreach($disciplines as &$collections)

		foreach($collections as &$collection){

			if(is_array($collection['count']))
				$collection['count'] = array_sum($collection['count']);

			$cols = ['sp7_version','sp6_version','isa_number','ip_address','browser','os'];
			foreach($cols as $col)
				$collection[$col] = array_unique($collection[$col]);

		} ?>

Show results from
<label class="mb-4">
	<select
		id="show_data_begin"
		class="form-control"><?=$result_1?></select>
</label>
 till
<label class="mb-4">
	<select
			id="show_data_end"
			class="form-control"><?=$result_2?></select>
</label><br> <?php

$view = MAIN_PAGE_OUTPUT_FORMAT;
if(array_key_exists('view',$_GET))
	$view = $_GET['view'];

if($view!=='11' && $view !=='00'){ ?>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb"> <?php
			if($view=='0'){?>
				<li class="breadcrumb-item active" aria-current="page">Show as list</li>
				<li class="breadcrumb-item"><a href="<?=LINK?>?file1=<?=$first_day?>&file2=<?=$last_day?>&view=1">Show as table</a></li> <?php
			}
			elseif($view=='1'){?>
				<li class="breadcrumb-item"><a href="<?=LINK?>?file1=<?=$first_day?>&file2=<?=$last_day?>&view=0">Show as list</a></li>
				<li class="breadcrumb-item active" aria-current="page">Show as table</li> <?php
			} ?>
		</ol>
	</nav> <?php
}

require_once('static/html/search_form.html'); ?>
<script src="<?=LINK?>static/js/stats.js"></script>
<script>
	const search_callback = update_stats;
</script>
<div id="stats" class="alert alert-info"></div> <?php

if($view=='0' || $view=='00') { ?>

	<script>
		const search_mode = 'list';
	</script>
	<ol> <?php

	$institution_count = count($institutions);
	$discipline_count = 0;
	$collection_count = 0;
	$report_count = 0;
	foreach($institutions as $institution => $disciplines){

		echo '<li>' . urldecode($institution) . '<ul>';

		foreach($disciplines as $discipline => $collections){

			echo '<li>' . urldecode($discipline) . '<ul>';

			foreach($collections as $collection => $data){

				echo '<li data-reports_count="'.$data['count'].'">
					<a href="'.LINK.'institution/?institution='.$institution.'&discipline='.$discipline.'&collection='.$collection.'">'.urldecode($collection).'</a> ['.$data['count'].']
					<br>Specify 7 versions: ' . implode(', ', $data['sp7_version']) . '
					<br>Specify 6 versions: ' . implode(', ', $data['sp6_version']);

				if(count($data['isa_number']) > 0)
					echo '<br>ISA Numbers: ' . implode(', ', $data['isa_number']);

				echo '<br>IP Addresses:<ul>';

				foreach($data['ip_address'] as $ip_address)
					echo '<li><a href="' . LINK . 'ip_info?ip=' . $ip_address . '" target="_blank">' . $ip_address . '</a></li>';

				echo '</ul>
					Browsers:<ul>';

				foreach($data['browser'] as $browser)
					echo '<li>' . $browser . '</li>';

				echo '</ul>
					Operating Systems:<ul>';

				foreach($data['os'] as $os)
					echo '<li>' . $os . '</li>';

				echo '</ul></li><br>';

				$collection_count++;
				$report_count+=$data['count'];

			}

			echo '</ul></li>';

			$discipline_count++;

		}

		echo '</ul></li>';

	}

	echo '</ol>';
}

elseif($view=='1' || $view=='11'){  ?>

	<script>
		const search_mode = 'table';
	</script>

	<table class="table">
		<thead>
			<tr>
				<th>Institution</th>
				<th>Discipline</th>
				<th>Collection</th>
				<th>Property</th>
				<th>Value</th>
			</tr>
		</thead> <?php

		$cell_count = 5;
		function to_cell($position,$value='',$class=''){

			global $cell_count;

			static $last_cell = 0;

			if($position<=$last_cell){
				echo str_repeat('<td></td>',$cell_count-$last_cell).'</tr>';
				$last_cell=0;
			}

			if($value=='')
				return;

			if($last_cell==0)
				echo '<tr>';

			if($class!='')
				$class = ' class="'.$class.'"';

			echo str_repeat('<td></td>',$position-$last_cell-1).'<td'.$class.'>'.$value.'</td>';

			$last_cell = $position;

		}

		$institution_count = count($institutions);
		$discipline_count = 0;
		$collection_count = 0;
		$report_count = 0;
		foreach($institutions as $institution => $disciplines){

			echo '<tbody>';

			to_cell(1,urldecode($institution),'institution');

			foreach($disciplines as $discipline => $collections){

				to_cell(2,urldecode($discipline),'discipline');

				foreach($collections as $collection => $data){
					to_cell(3,'<a data-reports_count="'.$data['count'].'" href="'.LINK.'institution/?institution='.$institution.'&discipline='.$discipline.'&collection='.$collection.'">'.urldecode($collection).'</a> ['.$data['count'].']');
					to_cell(4,'Specify 7 versions');
					to_cell(5,implode(', ',$data['sp7_version']));
					to_cell(4,'Specify 6 versions');
					to_cell(5,implode(', ',$data['sp6_version']));

					if(count($data['isa_number'])>0){
						to_cell(4,'ISA Numbers');
						to_cell(5,implode(', ',$data['isa_number']));
					}


					to_cell(4,'IP Addresses');
					foreach($data['ip_address'] as $ip_address)
						to_cell(5,'<a href="'.LINK.'ip_info?ip='.$ip_address. '" target="_blank">'.$ip_address.'</a>');


					to_cell(4,'Browsers');
					foreach($data['browser'] as $browser)
						to_cell(5,$browser);

					to_cell(4,'Operating Systems');

					foreach($data['os'] as $os)
						to_cell(5,$os);

					$collection_count++;
					$report_count+=$data['count'];

				}

				$discipline_count++;

			}

			echo '</tbody>';

		}

		to_cell(0);

	echo '</table>';

} ?>

<script>

	const link = '<?=LINK?>?view=<?=$view?>&';
	const view = '<?=$view?>'; <?php

	if(time()-$first_unix_begin*86400>SHOW_DATA_OUT_OF_DATE_WARNING_AFTER){ ?>
		$('#last_refresh_alert')[0].outerHTML += '<div class="alert alert-danger">We have not received any new log files since <?=unix_time_to_human_time($first_unix_begin)?>. Make sure `FILES_LOCATION` is set correctly to your Nginx\'s log directory</div>'; <?php
	} ?>

	const institution_count = '<?=$institution_count?>';
	const discipline_count = '<?=$discipline_count?>';
	const collection_count = '<?=$collection_count?>';
	const report_count = '<?=$report_count?>';

</script>
<script src="<?=LINK?>static/js/main.js"></script>