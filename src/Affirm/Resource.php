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
	}

	protected static function _sendGet($endpoint)
	{
		$response = \Httpful\Request::get(self::$_baseUrl.'/'.$endpoint)
			->authenticateWith(self::$_publicKey, self::$_privateKey)
			->sendsJson()
			->expectsJson()
			->send();

		if( isset($response->body->error) )
			throw new AffirmRequestException($response->body->error->message);

		return $response->body;
	}

	protected static function _sendPost($endpoint, $data)
	{
		$response = \Httpful\Request::post(self::$_baseUrl.'/'.$endpoint)
			->authenticateWith(self::$_publicKey, self::$_privateKey)
			->sendsJson()
			->expectsJson()
			->body(json_encode($data))
			->send();

		if( isset($response->body->error) )
			throw new AffirmRequestException($response->body->error->message);

		return $response->body;
	}

}