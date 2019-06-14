<?php
$url = "http://35.238.84.142/api/lights/";
$data = array("status"=>"1","brightness" => $_POST['bright']);
$data_string = json_encode($data);


$ch = curl_init($url.$_POST["light_id"]);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string),
        'x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77')
);

curl_exec($ch);

header('Location: ' . $_SERVER['HTTP_REFERER']);
