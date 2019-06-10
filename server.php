<?php

// A quick and dirty SOAP server example

ini_set('soap.wsdl_cache_enabled',0);	// Disable caching in PHP
$PhpWsdlAutoRun=true;					// With this global variable PhpWsdl will autorun in quick mode, too
require_once('class.phpwsdl.php');

// In quick mode you can specify the class filename(s) of your webservice
// optional parameter, if required.
//PhpWsdl::RunQuickMode();// -> Don't waste my time - just run!

class Server{
    private $api_key = "hallo_123";
    public function __construct()
    {

    }
    public function get_current_temperature($api_key, $plz, $ts,$unit){
        $id_array = mt_rand(10, 40);
        return $id_array;
    }
    public function get_current_wind_speed($api_key, $plz, $unit){
        $id_array = mt_rand(0, 100);
        return ($id_array);
    }
    public function get_current_wind_direction(){
        $direction = array("Norden", "Sueden", "Osten", "Westen");
        $id_array = $direction[array_rand($direction)];
        return $id_array;
    }
    public function getMessage()
    {
        return 'Hello,World!';
    }

    public function addNumbers($api_key,$num1,$num2)
    {
        return $num1+$num2;
    }
}
$options= array('uri'=>'server.php');
$server=new SoapServer(NULL,$options);
$server->setClass('Server');
$server->handle();


/*
// Initialize the PhpWsdl class
require_once('class.phpwsdl.php');
PhpWsdl::RunQuickMode ( );
//require './lib/nusoap-master/src/nusoap.php';
class Server
{
    private $api_key = "hallo_123";
    public function __construct()
    {

    }
    public function get_current_temperature($api_key, $plz, $ts,$unit){
        $id_array = mt_rand(10, 40);
        return $id_array;
    }
    public function get_current_wind_speed($api_key, $plz, $unit){
        $id_array = mt_rand(0, 100);
        return ($id_array);
    }
    public function get_current_wind_direction(){
        $direction = array("Norden", "Sueden", "Osten", "Westen");
        $id_array = $direction[array_rand($direction)];
        return $id_array;
    }
    public function getMessage()
    {
        return 'Hello,World!';
    }

    public function addNumbers($api_key,$num1,$num2)
    {
        return $num1+$num2;
    }
}
$options= array('uri'=>'server.php');
$server=new SoapServer(NULL,$options);
$server->setClass('Server');
$server->handle();


?>
*/