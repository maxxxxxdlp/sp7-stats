<label class="mb-4">
	<select
		id="show_data_for"
		class="form-control"
		multiple> <?php

		$files = glob(WORKING_LOCATION.'tsv/*.tsv');

		if(array_key_exists('file',$_GET) && file_exists(WORKING_LOCATION.'tsv/'.$_GET['file']))
			$current_file = $_GET['file'];
		else
			$current_file = FALSE;

		$first_unix_begin = NULL;

		foreach($files as $file){

			$file = explode('/',$file);
			$file = $file[count($file)-1];
			$unix_times = explode('.',$file)[0];
			$unix_begin = explode('_',$unix_times);
			$unix_begin = unix_time_to_human_time($unix_times[0]);

			$selected_append = '';

			if(!$first_unix_begin)
				$first_unix_begin = $unix_begin;

			if(!$current_file)
				$current_file = $file;

			if($file==$current_file)
				$selected_append = 'selected'; ?>

			<option value="<?=$file?>" <?=$selected_append?>><?=$unix_begin?></option> <?php

		} ?>

	</select>
</label><br>

<script src="../static/js/menu.js"></script>

<script>
	const file_less_link = '<?=LINK.$origin_link?>';
</script>  <?php

if(intval(time()/86400)-$first_unix_begin>SHOW_DATA_OUT_OF_DATE_WARNING_AFTER){ ?>
	<script>
		$('#last_refresh_alert')[0].outerHTML += '<div class="alert alert-danger">We have not received any new log files since <?=unix_time_to_human_time($first_unix_begin)?>. Make sure `FILES_LOCATION` is set correctly to your Nginx\'s log directory</div>';
	</script> <?php
}

$files = [WORKING_LOCATION.'tsv/'.$current_file];