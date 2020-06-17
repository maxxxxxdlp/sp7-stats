<?php

$target_dir = WORKING_LOCATION . 'github/' . $repository . '/';
$target_file_extension = '.json';
$base_url = 'https://api.github.com/repos/specify/' . $repository . '/';
$graphs = [
		'referrers'       => [
			'request_url' => 'traffic/popular/referrers',
			'title'       => 'Referrers',
			'description' => 'Top 10 referrers over the last 14 days',
		],
		'paths'           => [
			'request_url' => 'traffic/popular/paths',
			'title'       => 'Popular paths',
			'description' => 'Top 10 most popular paths over the last 14 days',
		],
		'views_per_day'   => [
			'request_url' => 'traffic/views?per=day',
			'title'       => 'Views per day',
			'description' => 'Get the total number of views per day for the last 14 days',
		],
		'views_per_week'  => [
			'request_url' => 'traffic/views?per=week',
			'title'       => 'Views per week',
			'description' => 'Get the total number of views per week for the last 14 days',
		],
		'clones_per_day'  => [
			'request_url' => 'traffic/clones?per=day',
			'title'       => 'Clones per day',
			'description' => 'Get the total number of clones per day for the last 14 days',
		],
		'clones_per_week' => [
			'request_url' => 'traffic/clones?per=week',
			'title'       => 'Clones per week',
			'description' => 'Get the total number of clones per week for the last 14 days',
		],
	'releases' => [
		'request_url' => 'releases?page=',
		'title'       => 'Popularity of releases',
		'description' => 'Stats on popularity of releases',
		'page'        => 1,
	],
];