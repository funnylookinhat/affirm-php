<?php

namespace Affirm;

class AffirmException extends \Exception {}
class AffirmRequestException extends \Exception {}

class Resource {
	
	private static $_initialized = FALSE;

	private static $_publicKey,
				   $_privateKey,
				   $_productKey;

	protected static $_baseUrl = "https://api.affirm.com/api/v2";

	public static function init($publicKey, $privateKey, $productKey, $baseUrl = NULL)
	{
		if( self::$_initialized )
			throw new AffirmException("Cannot be initialized twice.");

		if( $baseUrl )
			self::$_baseUrl = $baseUrl;

		if( substr(self::$_baseUrl, -1) == "/" )
			self::$_baseUrl = substr(self::$_baseUrl, 0, -1);

		self::$_publicKey = $publicKey;
		self::$_privateKey = $privateKey;
		self::$_productKey = $productKey;
	}

	protected static function _sendGet($endpoint)
	{
		if( ! self::$_initialized )
			throw new AffirmException("Not initialized.");
		
		$response = \Httpful\Request::get(self::$_baseUrl.'/'.$endpoint)
			->authenticateWith(self::$_publicKey, self::$_privateKey)
			->sendsJson()
			->expectsJson()
			->send();

		if( isset($response->body->status_code) &&
			in_array(substr($response->body->status_code,0,1), array('4','5')) )
			throw new AffirmRequestException($response->body->message);

		return $response->body;
	}

	protected static function _sendPost($endpoint, $data)
	{
		if( ! self::$_initialized )
			throw new AffirmException("Not initialized.");
		
		$response = \Httpful\Request::post(self::$_baseUrl.'/'.$endpoint)
			->authenticateWith(self::$_publicKey, self::$_privateKey)
			->sendsJson()
			->expectsJson()
			->body(json_encode($data))
			->send();

		if( isset($response->body->status_code) &&
			in_array(substr($response->body->status_code,0,1), array('4','5')) )
			throw new AffirmRequestException($response->body->message);

		return $response->body;
	}

}