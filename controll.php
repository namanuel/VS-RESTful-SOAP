<?php
$wsdlurl = "http://localhost:9002/WeatherService?wsdl";

$client=new SoapClient($wsdlurl);
/*
//require './lib/nusoap-master/src/nusoap.php';
$api_key_w = "hallo_123";
$api_key_weather_forecast ="03DA61ACBDF5509E3A686BC07252C3C5A71552E1A348FBAD6FB4FBA149E2E64B";
$plz = 1010;
$wsdlurl = "http://localhost:9002/WeatherService?wsdl";

$client=new SoapClient($wsdlurl);

$currentWeather = $client->getCurrentWeather("hallo_123");
echo "Current Weather: ";
print_r($currentWeather);
echo "<br>";

$weatherforecast = $client->getWeatherforecast();
echo "Weather Forecast: ";
print_r($weatherforecast);




*/