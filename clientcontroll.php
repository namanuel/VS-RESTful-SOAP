<?php
require("mqtt/phpMQTT.php");
require("mqtt/config.php");
/**
 * @service clientcontroll
 */
class clientcontroll{
	/**
	 * The WSDL URI
	 *
	 * @var string
	 */
	public static $_WsdlUri='http://localhost/WeatherService/soapserver.php?WSDL';
	/**
	 * The PHP SoapClient object
	 *
	 * @var object
	 */
	public static $_Server=null;

	/**
	 * Send a SOAP request to the server
	 *
	 * @param string $method The method name
	 * @param array $param The parameters
	 * @return mixed The server response
	 */
	public static function _Call($method,$param){
		if(is_null(self::$_Server))
			self::$_Server=new SoapClient(self::$_WsdlUri);
		return self::$_Server->__soapCall($method,$param);
	}
    /**
     * Current Temperature
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_temperature
     */
    public function get_current_temperature($api_key,$ts,$plz){
        return self::_Call('get_current_temperature',Array(
            $api_key,
            $ts,
            $plz
        ));
    }
    /**
     * Current Weather State
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return string current_state
     */
    public function get_current_weather_state($api_key,$ts,$plz){
        return self::_Call('get_current_weather_state',Array(
            $api_key,
            $ts,
            $plz
        ));
    }

    /**
     * Current Temperature min
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_temperature_min
     */
    public function get_current_temperature_min($api_key,$ts,$plz){
        return self::_Call('get_current_temperature_min',Array(
            $api_key,
            $ts,
            $plz
        ));
    }

    /**
     * Current Temperature max
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_temperature_max
     */
    public function get_current_temperature_max($api_key,$ts,$plz){
        return self::_Call('get_current_temperature_max',Array(
            $api_key,
            $ts,
            $plz
        ));
    }

    /**
     * Current Wind Speed
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_wind_speed
     */
    public function get_current_wind_speed($api_key,$ts,$plz){
        return self::_Call('get_current_wind_speed',Array(
            $api_key,
            $ts,
            $plz
        ));
    }

    /**
     * Current Wind Direction
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_wind_direction
     */
    public function get_current_wind_direction($api_key,$ts,$plz){
        return self::_Call('get_current_wind_direction',Array(
            $api_key,
            $ts,
            $plz
        ));
    }
    /**
     * Current Wind Direction
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_wind_direction
     */
    public function get_weather_forecast($api_key,$ts,$plz){
        return self::_Call('get_weather_forecast',Array(
            $api_key,
            $ts,
            $plz
        ));
    }

}
$api_key = "CEVIKMEDICKENAGELBESTE";
$plz = 1010;
$client = new clientcontroll();

echo "<H1>SOAP Wetter Service</H1>";

echo "<h3>Wetter Heute im ".$plz."</h3>";

echo "Aktuelle Temperatur: ".$client->get_current_temperature($api_key,time(),$plz)."°C"."<br>";

echo "Aktuelles Wetter: ".$client->get_current_weather_state($api_key,time(),$plz)."<br>";

echo "Aktuelle Temperatur min: ".$client->get_current_temperature_min($api_key,time(),$plz)."°C"."<br>";

echo "Aktuelle Temperatur max: ".$client->get_current_temperature_max($api_key,time(),$plz)."°C"."<br>";

echo "Aktuelle Windgeschwindigkeit: ".$client->get_current_wind_speed($api_key,time(),$plz)."km/h"."<br>";

echo "Aktuelle Windrichtung: ".$client->get_current_wind_direction($api_key,time(),$plz)."°"."<br>";

echo "<h3> 7 Tage Vorhersage: </h3><br>";



// Publishen der Windgeschwindigkeit mit Hilfe von MQTT
$message = $client->get_current_wind_speed($api_key,time(),$plz)."km/h";
//MQTT client id to use for the device. "" will generate a client id automatically
$mqtt = new bluerhinos\phpMQTT($server, $port, "ClientID".rand());

if ($mqtt->connect(true,NULL,$username,$password)) {
    $mqtt->publish("lights/light1/lumen",$message, 0);
    $mqtt->close();
}else{
    echo "Fail or time out
";
}



//echo $client->get_weather_forecast($api_key,time(),$plz);
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
      <!-- Autorefresh alle 60s -->
      <meta http-equiv="refresh" content="60">
    <title>SmartHomies</title>
  </head>
  <body>


  </div>
  </body>
</html>


