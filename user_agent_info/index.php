<?php

require_once('../components/header.php');


if(!array_key_exists('user_agent',$_GET))
	header('Location: '.LINK);

$user_agent = urldecode($_GET['user_agent']);

$user_agent_data = json_decode(file_get_contents(LINK.'components/compile_user_agent_strings.php?user_agent='.urlencode($user_agent)),TRUE);
if(!is_array($user_agent_data) || count($user_agent_data)<2 || $user_agent_data[1]==''){
	$browser = 'Browser';
	$os = 'OS';
}
else {
	$browser = $user_agent_data[0];
	$os = $user_agent_data[1];
}

?>

<table class="table table-striped">

	<thead>

		<tr>

			<th>User Agent</th>
			<th><?=$user_agent?></th>

		</tr>

	</thead>

	<tbody>

		<tr>
			<td>Browser</td>
			<td><?=$browser?></td>
		</tr>
		<tr>
			<td>OS</td>
			<td><?=$os?></td>
		</tr>

	</tbody>

</table>

<?php footer();