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
}
$client = new SoapDemoSoapClient();

echo $client->SayHello("Guenther");

