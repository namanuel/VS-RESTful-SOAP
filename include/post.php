<?php
$data = array("name" => "bad");
$data_string = json_encode($data);

$ch = curl_init('http://35.238.84.142/api/lights');

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string),
        'x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77')
);

echo curl_exec($ch);