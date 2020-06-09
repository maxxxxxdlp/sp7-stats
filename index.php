<?php

const MENU_BUTTON = 2;

require_once('components/menu.php');

if(!isset($current_file))
	exit();

$json_file = str_replace('tsv','json',$current_file);
$file_path = WORKING_LOCATION.'institutions/';

if(!file_exists($file_path.$json_file))
	exit('File does not exist');

$institutions = json_decode(file_get_contents($file_path.$json_file),true);

$view = MAIN_PAGE_OUTPUT_FORMAT;
if(array_key_exists('view',$_GET))
	$view = $_GET['view'];

if($view!=='11' && $view !=='00'){ ?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb"> <?php
			if($view=='0'){?>
			<li class="breadcrumb-item active" aria-current="page">Show as list</li>
			<li class="breadcrumb-item"><a href="<?=LINK?>?file=<?=$current_file?>&view=1">Show as table</a></li> <?php
			}
			elseif($view=='1'){?>
				<li class="breadcrumb-item"><a href="<?=LINK?>?file=<?=$current_file?>&view=0">Show as list</a></li>
				<li class="breadcrumb-item active" aria-current="page">Show as table</li> <?php
			} ?>
		</ol>
	</nav> <?php
}

if($view=='0' || $view=='00') {
	echo '<ol>';
	foreach($institutions as $institution => $disciplines){

		echo '<li>' . urldecode($institution) . '<ul>';

		foreach($disciplines as $discipline => $collections){

			echo '<li>' . urldecode($discipline) . '<ul>';

			foreach($collections as $collection => $data){
				echo '<li>
					<a href="'.get_link_for_custom_get(['institution'=>$institution,'discipline'=>$discipline,'collection'=>$collection,'view'=>'','file'=>'','referrer'=>$real_link],FALSE,LINK.'institution/?').'">'.urldecode($collection).'</a> ['.$data['count'].']
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

			}

			echo '</ul></li>';

		}

		echo '</ul></li>';

	}
	echo '</ol>';
}

elseif($view=='1' || $view=='11'){ ?>
	<table class="table">
		<thead>
			<tr>
				<th>Institution</th>
				<th>Discipline</th>
				<th>Collection</th>
				<th>Property</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody> <?php

		$cell_count = 5;
		function to_cell($position,$value=''){

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

			echo str_repeat('<td></td>',$position-$last_cell-1).'<td>'.$value.'</td>';

			$last_cell = $position;

		}

		foreach($institutions as $institution => $disciplines){

			to_cell(1,urldecode($institution));

			foreach($disciplines as $discipline => $collections){

				to_cell(2,urldecode($discipline));

				foreach($collections as $collection => $data){
					to_cell(3,'<a href="'.get_link_for_custom_get(['institution'=>$institution,'discipline'=>$discipline,'collection'=>$collection,'view'=>'','file'=>'','referrer'=>$real_link],FALSE,LINK.'institution/?').'">'.urldecode($collection).'</a> ['.$data['count'].']');
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

				}

			}

		}

		to_cell(0);?>

		</tbody>
	</table> <?php
} ?>

<script>
	const view = '<?=$view?>';
</script><?php


footer();