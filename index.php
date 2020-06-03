<?php

require_once('components/menu.php'); ?>

<table class="table table-striped">
	<thead>
		<tr>

			<th>Record</th> <?php

			foreach(COLUMNS as $column)
				if($column=='IP')
					echo '<th><a href="'.$reverse_sort_link.'" title="Click to reverse">' . $column . '</a></th>';
				else
					echo '<th>' . $column . '</th>'; ?>

		</tr>
	</thead>
	<tbody> <?php


		$ips_link_part = '';
		if(array_key_exists('file',$_GET))
			$ips_link_part = '&file='.$_GET['file'];

		$line_number=1;
		foreach($files as $file){


			$data = file_get_contents($file);
			$data = explode("\n",$data);

			if($reverse)
				$data = array_reverse($data);

			foreach($data as $line){

				if($line == '')
					continue;

				$line_data = array_merge([$line_number],explode("\t",$line));

				echo '<tr>';

				$count = count($line_data);
				for($i=0;$i<$count;$i++){

					if($i==1)
						echo '<td><a href="'.LINK.'host_info?ip='.$line_data[$i].$ips_link_part.'">'.$line_data[$i].'</a></td>';
					elseif($i==2)
						echo '<td>'.unix_time_to_human_time($line_data[$i]).'</td>';
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