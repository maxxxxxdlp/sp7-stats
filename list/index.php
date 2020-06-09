<?php

global $user_agent;
require_once('../components/menu.php');

if(!isset($current_file))
	exit(); ?>

<table class="table table-striped">
	<thead>
		<tr>

			<th>Record</th> <?php

			foreach(COLUMNS as $column)
				if($column=='Date')
					echo '<th><a href="'.$reverse_sort_link.'" title="Click to reverse">' . $column . '</a></th>';
				elseif($column=='User Agent')
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

			if($reverse)
				$data = array_reverse($data);

			foreach($data as $line){

				if($line == '')
					continue;

				$line_data = explode("\t",$line);

				echo '<tr>
					<td>'.$line_number.'</td>';

				$count = count($line_data);
				for($i=0;$i<$count;$i++){


					if(COLUMNS[$i]=='IP')
						echo '<td><a href="'.LINK.'ip_info?ip='.$line_data[$i] . '" target="_blank">' . $line_data[$i] . '</a></td>';

					elseif(COLUMNS[$i]=='Date')
						echo '<td>'.unix_time_to_human_time($line_data[$i]).'</td>';

					elseif(COLUMNS[$i]=='Institution')
						echo '<td><a href="' . get_link_for_custom_get(['Institution' => $line_data[$i], 'Discipline' => '', 'Collection' => ''], FALSE, LINK . '/institutions/') . '">' . urldecode($line_data[$i]) . '</a></td>';

					elseif(COLUMNS[$i]=='Discipline')
						echo '<td><a href="'.get_link_for_custom_get(['Institution'=>$line_data[$i-1],'Discipline'=>$line_data[$i],'Collection'=>'',FALSE,LINK.'/institutions/']).'">'.urldecode($line_data[$i]).'</a></td>';

					elseif(COLUMNS[$i]=='Collection')
						echo '<td><a href="'.get_link_for_custom_get(['Institution'=>$line_data[$i-2],'Discipline'=>$line_data[$i-1],'Collection'=>$line_data[$i-1],FALSE,LINK.'/institutions/']).'">'.urldecode($line_data[$i]).'</a></td>';

					else
						echo '<td>'.$line_data[$i].'</td>';


				}


				echo '</tr>';

				$line_number++;

			}


		} ?>

	</tbody>
</table> <?php


footer();