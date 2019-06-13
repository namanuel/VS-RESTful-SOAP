<?php
/**
 * @service clientcontroll
 */
class clientcontroll{
	/**
	 * The WSDL URI
	 *
	 * @var string
	 */
	public static $_WsdlUri='http://soapservercmn.azurewebsites.net/soapserver.php?WSDL';
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
     * @throws SoapFault
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
     * @throws SoapFault
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
     * @throws SoapFault
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
     * @throws SoapFault
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
     * @throws SoapFault
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
     * @throws SoapFault
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
     * @throws SoapFault
     */
    public function get_current_wind_direction($api_key,$ts,$plz){
        return self::_Call('get_current_wind_direction',Array(
            $api_key,
            $ts,
            $plz
        ));
    }

    /**
     * 7 Day Weather Forecast
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return array
     * @throws SoapFault
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
$i = 0;

echo "<H1>SOAP Weather Service</H1>";

echo "<h3>Weather today in ".$plz."</h3>";

echo "Current temperature: ".$client->get_current_temperature($api_key,time(),$plz)."°C"."<br>";

echo "Current weather: ".$client->get_current_weather_state($api_key,time(),$plz)."<br>";

echo "Current temperature min: ".$client->get_current_temperature_min($api_key,time(),$plz)."°C"."<br>";

echo "Current temperature max: ".$client->get_current_temperature_max($api_key,time(),$plz)."°C"."<br>";

echo "Current wind speed: ".$client->get_current_wind_speed($api_key,time(),$plz)." km/h"."<br>";

echo "Current wind direction: ".$client->get_current_wind_direction($api_key,time(),$plz)."°"."<br>";

echo "<hr/>";

echo "<h3> 7 Day weather-forecast: </h3>";

//echo print_r($client->get_weather_forecast($api_key,time(),$plz))."<br>";
foreach ($client->get_weather_forecast($api_key,time(),$plz) as $nextday){

    if($i==0){
        echo "<h4>"."Tomorrow"."</h4><br>";
        $i++;
    }elseif ($i==1){
        echo "<h4>"."The day after Tomorrow"."</h4><br>";
        $i++;
    }elseif ($i==2){
        echo "<h4>"."Third Day"."</h4><br>";
        $i++;
    }elseif ($i==3){
        echo "<h4>"."Fourth Day"."</h4><br>";
        $i++;
    }elseif ($i==4){
        echo "<h4>"."Fifth Day"."</h4><br>";
        $i++;
    }elseif ($i==5){
        echo "<h4>"."Sixth Day"."</h4><br>";
        $i++;
    }elseif ($i==6){
        echo "<h4>"."Seventh Day"."</h4><br>";
        $i++;
    }
    echo "Current temperature: ".$nextday['current_temperature']."°C"."<br>";

    echo "Current weather: ".$nextday['current_state']."<br>";

    echo "Current temperature min: ".$nextday['current_temperature_min']."°C"."<br>";

    echo "Current temperature max: ".$nextday['current_temperature_max']."°C"."<br>";

    echo "Current wind speed: ".$nextday['current_wind_speed']." km/h"."<br>";

    echo "Current wind direction: ".$nextday['current_wind_direction']."°"."<br>";
    echo "<hr />";

}