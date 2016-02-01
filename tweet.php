<?php

if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

// Twitter
$consumerKey = "xxxxxxxxxx";
$consumerSecret = "xxxxxxxxxx";
$accessToken = "xxxxxxxxxx";
$accessTokenSecret = "xxxxxxxxxx";

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

// Get data
$contents = file_get_contents('tweet.csv');
$_rows = explode("\n", $contents);
$rows = array();
foreach ($_rows as $row) {
    if (!$row) {
        continue;
    }
    $rows[] = $row;
}

$key = array_rand($rows);

$val = explode(',', $rows[$key]);

// Create message
$message = "【" . $val[0] . "】";
for ($i=1; $i<count($val); $i++) {
    $message .= $val[$i];
}
$message .= ' #高校野球 #甲子園';

unset($rows[$key]);

// Save data
if ($rows) {
    file_put_contents('tweet.csv', implode("\n", $rows));
} else {
    copy('csv/koshien.csv', 'tweet.csv');
}

// Post
$statuses = $connection->post("statuses/update", array("status" => $message));

var_dump($statuses);
