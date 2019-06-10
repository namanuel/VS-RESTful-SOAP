<?php
/**
 * @service SoapDemoSoapClient
 */
class SoapDemoSoapClient{
	/**
	 * The WSDL URI
	 *
	 * @var string
	 */
	public static $_WsdlUri='http://localhost/WeatherService/demo4.php?WSDL';
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
	 * Say hello to...
	 *
	 * @param string $name A name
	 * @return string Response
	 */
	public function SayHello($name){
		return self::_Call('SayHello',Array(
			$name
		));
	}
    /**
     * Say hello to...
     *
     * @param string $api_key is our Security solver :D
     * @param int $plz our Location
     * @param int $ts our TimeStamp
     * @return
     */
    public function get_current_temperature($api_key,$plz,$ts){
        return self::_Call('get_current_temperature',Array(
            $api_key,
            $plz,
            $ts
        ));
    }
}
$client = new SoapDemoSoapClient();

echo $client->SayHello("Guenther");
echo $client->get_current_temperature("OKAY",0,time());


echo time();
