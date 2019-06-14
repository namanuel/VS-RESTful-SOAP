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
}

$api_key = "CEVIKMEDICKENAGELBESTE";
$client = new clientcontroll();

$speed=$client->get_current_wind_speed($api_key,time(),$plz);
echo $speed."\n";

if ($speed >= 70){
	$url = "http://35.238.84.142/api/blinds";
	$data = array("status" => "0");
	$data_string = json_encode($data);

	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string),
			'x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77')
				);

	echo curl_exec($ch);
}

