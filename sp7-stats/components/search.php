<?php

$search_query = '';
if(array_key_exists('search',$_GET))
	$search_query = urldecode($_GET['search']); ?>

<label class="form-inline" id="search">
	<input class="form-control mr-sm-2" type="text" placeholder="Search query" value="<?=$search_query?>">
</label>
<script src="<?=LINK?>static/js/search<?=JS?>" defer></script>