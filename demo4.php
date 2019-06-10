<?php

// A quick and dirty SOAP server example

ini_set('soap.wsdl_cache_enabled',0);	// Disable caching in PHP
$PhpWsdlAutoRun=true;					// With this global variable PhpWsdl will autorun in quick mode, too
require_once('class.phpwsdl.php');

// In quick mode you can specify the class filename(s) of your webservice 
// optional parameter, if required.
PhpWsdl::RunQuickMode();// -> Don't waste my time - just run!

class SoapDemo{
    static public $API_KEY = "hallo_123";
    public $PLZ = 1010;
    /**
     * Say hello to...
     *
     * @param string $name A name
     * @return string Response
     */
    public function getMessage()
    {
        return 'Hello,World!';
    }
    /**
     * Say hello to...
     *
     * @param string $name A name
     * @return string Response
     */
    public function SayHello($name){
        $name=utf8_decode($name);
        if($name=='')
            $name='unknown';
        return utf8_encode('Hello '.$name.'!');
    }
    /**
     * Say hello to...
     *
     * @param string $name A name
     * @return string Response
     */
    public function addNumbers($num1,$num2)
    {
        return $num1+$num2;
    }

    /**
     * Say hello to...
     *
     * @param string $api_key is our Security solver :D
     * @param int $plz our Location
     * @param int $ts our TimeStamp
     * @return string Response
     */
    public function get_current_temperature($api_key, $plz, $ts){

        //abfrage
        if(time()-$ts <= 600) {
            return "istok";

        }else{
            return "nichtok";
        }
        if (strcmp(self::$API_KEY, $api_key) == 0) {
            //$current_temperature = mt_rand(10, 40);
            return "OK";
            //$current_temperature;
        } else {
            return "neinneinneinnein!!!!!";
        }

//weatherforecast
        //array zurückgeben
    }
//self eigene klasse
//this im eigenen objekt
}
