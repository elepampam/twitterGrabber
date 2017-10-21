<?php 
ini_set('display_errors', 1);
ini_set('max_execution_time', 360);
require 'twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// set key here
$consumerKey = "";
$consumerSecretKey = "";
$accessToken = "";
$accessTokenSecret = "";

$connection = new TwitterOAuth($consumerKey, $consumerSecretKey, $accessToken, $accessTokenSecret);
$params = array(
	'q' => 'react native',
	'count' => 50,
	'since' => '',
	'until' => ''
);
$response = $connection->get("search/tweets", $params);

echo "<pre>";
// print_r($response->statuses);

$results = array();

// it will replace the old csv file, backup if you need it
$csvFile = fopen("responseTweet.csv", "a+");
fputcsv($csvFile, array("no","username","tweet","created_at"));

$count = 1;

foreach ($response->statuses as $tweet) {
	// push to web display
	array_push($results, array(
		"no" => $count,
		"username" => $tweet->user->screen_name,
		"tweet" => $tweet->text,
		"created at" => $tweet->created_at
	));
	// push to csv file
	fputcsv($csvFile, array(
		$count,
		$tweet->user->screen_name,
		$tweet->text,
		$tweet->created_at
	));
	$count++;
}

print_r($results);
fclose($csvFile);

 ?>