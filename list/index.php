<?php

$origin_link = 'list/';
$menu_link = 3;

require_once('../components/menu.php');
require_once('../components/file_picker.php');

$columns = ['IP Address','Date','SP7','SP6','Institution','Discipline','Collection','Isa Number','Browser','OS'];

if(!isset($current_file))
	exit(); ?>

<table class="table table-striped">
	<thead>
		<tr>

			<th>Record</th> <?php

			foreach(COLUMNS as $column)
				if($column=='User Agent')
					echo '<th>Browser</th><th>OS</th>';
				else
					echo '<th>' . $column . '</th>'; ?>

		</tr>
	</thead>
	<tbody> <?php

		$line_number=1;
		foreach($files as $file){


			$data = file_get_contents($file);
			$data = explode("\n",$data);

			foreach($data as $line){

				if($line == '')
					continue;

				$line_data = explode("\t",$line);

				echo '<tr>
					<td>'.$line_number.'</td>';

				$count = count($line_data);
				for($i=0;$i<$count;$i++){


					if($columns[$i]=='IP Address')
						echo '<td><a href="'.LINK.'ip_info?ip='.$line_data[$i] . '" target="_blank">' . $line_data[$i] . '</a></td>';

					elseif($columns[$i]=='Date')
						echo '<td>'.unix_time_to_human_time($line_data[$i]).'</td>';

					elseif($columns[$i]=='Collection')
						echo '<td><a href="'.LINK.'institution/?institution='.$line_data[$i-2].'&discipline'.$line_data[$i-1].'&collection'.$line_data[$i].'">'.urldecode($collection).'</a></td>';

					else
						echo '<td>'.$line_data[$i].'</td>';


				}


				echo '</tr>';

				$line_number++;

			}


		} ?>

	</tbody>
</table>