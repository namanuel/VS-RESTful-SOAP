<?php

$url = "http://35.238.84.142/api/scenes/";


$ch = curl_init($url.$_GET["scene_id"]);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77')
);

curl_exec($ch);
header('Location: ' . $_SERVER['HTTP_REFERER']);







/**
<?php


$ch = curl_init('http://35.238.84.142/api/lights/').$_GET["id"];
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77')
);

$response_body = curl_exec($ch);
**/