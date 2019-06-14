<?php

$url = "http://35.238.84.142/api/blinds/";


$ch = curl_init($url.$_GET["id"]);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77')
);

curl_exec($ch);
header('Location: ' . $_SERVER['HTTP_REFERER']);
