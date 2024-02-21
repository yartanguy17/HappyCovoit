<?php

$method = 'GET';

$options = array(
	'http' => array(
		'ignore_errors'=> TRUE,
		'method' => $method
	)
);
$context = stream_context_create($options);
$response1 = json_decode(file_get_contents('https://happytravel-world.com/analyse-reservation', FALSE, $context), true);
echo $response1 . "\n";
