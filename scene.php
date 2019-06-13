<?php
$url="http://35.238.84.142/api/scenes/".$_GET["scene_id"];

$request_headers = array();
$request_headers[] = 'x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77';

// Request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($ch);

curl_close($ch);

header('Location: ' . $_SERVER['HTTP_REFERER']);