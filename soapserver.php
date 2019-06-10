<?php

// A quick and dirty SOAP server example

ini_set('soap.wsdl_cache_enabled',0);	// Disable caching in PHP
$PhpWsdlAutoRun=true;					// With this global variable PhpWsdl will autorun in quick mode, too
require_once('class.phpwsdl.php');

// In quick mode you can specify the class filename(s) of your webservice 
// optional parameter, if required.
PhpWsdl::RunQuickMode();// -> Don't waste my time - just run!

class WeatherServer{
    static public $API_KEY = "CEVIKMEDICKENAGELBESTE";
    static public $PLZ = 1010;
    /**
     * Current Temperature
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_temperature
     */
    public function get_current_temperature($api_key,$ts, $plz )
    {
        if (strcmp(self::$API_KEY, $api_key) == 0) {
            if (time() - $ts <= 600) {
                $current_temperature = mt_rand(0, 30);
                return $current_temperature;
            } else {
                return "go away";
            }
        } else {
            return "go away";
        }
    }
    /**
     * Current Weather State
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return string current_state
     */
    public function get_current_weather_state($api_key,$ts, $plz )
    {

        if (strcmp(self::$API_KEY, $api_key) == 0) {
            if (time() - $ts <= 600) {
                if($this->get_current_temperature(self::$API_KEY,time(),self::$PLZ)>10){
                    $state = array("Regen", "Bewoelkt", "Sonnig", "Hagel");
                    $current_state = $state[array_rand($state)];
                }else{
                    $current_state = "Schnee";
                }

                return $current_state;
            } else {
                return "go away";
            }
        } else {
            return "go away";
        }
    }
    /**
     * Current Temperature min
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_temperature_min
     */
    public function get_current_temperature_min($api_key,$ts, $plz )
    {

        if (strcmp(self::$API_KEY, $api_key) == 0) {
            if (time() - $ts <= 600) {
                $current_temperature_min = $this->get_current_temperature(self::$API_KEY,time(),self::$PLZ)- mt_rand(0, 5);
                return $current_temperature_min;
            } else {
                return "go away";
            }
        } else {
            return "go away";
        }
    }

    /**
     * Current Temperature max
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_temperature_max
     */
    public function get_current_temperature_max($api_key,$ts, $plz )
    {

        if (strcmp(self::$API_KEY, $api_key) == 0) {
            if (time() - $ts <= 600) {
                $current_temperature_max  = $this->get_current_temperature(self::$API_KEY,time(),self::$PLZ)+ mt_rand(0, 5);
                return $current_temperature_max;
            } else {
                return "go away";
            }
        } else {
            return "go away";
        }
    }
    /**
     * Current Wind Speed
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_wind_speed
     */
    public function get_current_wind_speed($api_key,$ts, $plz )
    {

        if (strcmp(self::$API_KEY, $api_key) == 0) {
            if (time() - $ts <= 600) {
                $current_wind_speed = mt_rand(0, 200);
                return $current_wind_speed;
            } else {
                return "go away";
            }
        } else {
            return "go away";
        }
    }
    /**
     * Current Wind Direction
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return int current_wind_direction
     */
    public function get_current_wind_direction($api_key,$ts, $plz )
    {

        if (strcmp(self::$API_KEY, $api_key) == 0) {
            if (time() - $ts <= 600) {
                $current_wind_direction = mt_rand(0, 360);
                return $current_wind_direction;
            } else {
                return "go away";
            }
        } else {
            return "go away";
        }
    }
    /**
     * Current Wind Direction
     *
     * @param string $api_key for the security
     * @param int $ts our TimeStamp
     * @param int $plz our Location
     * @return array
     */
    public function get_weather_forecast($api_key,$ts, $plz )
    {

        if (strcmp(self::$API_KEY, $api_key) == 0) {

            if (time() - $ts <= 600) {
               /* for ($x =0;$x<=6;$x++){
                    $forecast = array(
                        [$x] => array([current_temperature]=>$current_temperature = mt_rand(0,30),
                            //[current_state]=>$current_state,
                            [current_temperature_min]=>$current_temperature_min = $current_temperature - mt_rand(0, 5),
                            [current_temperature_max]=>$current_temperature_max  = $current_temperature + mt_rand(0, 5),
                            [current_wind_speed]=>$current_wind_speed = mt_rand(0, 200),
                            [current_wind_direction]=>$current_wind_direction = mt_rand(0, 360))
                    );
                }*/

                return array([current_temperature]=>$current_temperature = mt_rand(0,30),
                    //[current_state]=>$current_state,
                    [current_temperature_min]=>$current_temperature_min = $current_temperature - mt_rand(0, 5),
                    [current_temperature_max]=>$current_temperature_max  = $current_temperature + mt_rand(0, 5),
                    [current_wind_speed]=>$current_wind_speed = mt_rand(0, 200),
                    [current_wind_direction]=>$current_wind_direction = mt_rand(0, 360));
            } else {
                return "go away";
            }
        } else {
            return "go away";
        }
    }

//weatherforecast
    //array zurückgeben

//self eigene klasse
//this im eigenen objekt
}
