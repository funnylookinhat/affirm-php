<?php

namespace Affirm;

class Charge extends Resource {

	private static $_endpoint = "charges";

	public static function _init()
	{

	}

	/**
	 * Fetch a charge.
	 * @param Array $data Request object with the following:
	 *                     id Required
	 */
	public static function Get($data)
	{
		if( ! isset($data['id']) )
			throw new AffirmException("Missing transaction id.");

		return self::_sendGet(self::$_endpoint.'/'.$data['id']);
	}

	/**
	 * Create a new charge ( Auth Only ) with a checkout token.
	 * @param Array $data Request object with the following:
	 *                     checkout_token 
	 */
	public static function Create($data)
	{
		return self::_sendPost(self::$_endpoint, $data);
	}

	/**
	 * Capture a charge.
	 * @param Array $data Request object with the following:
	 *                     id Required
	 *                     order_id Optional
	 *                     shipping_carrier Optional
	 *                     shipping_confirmation Optional
	 */
	public static function Capture($data)
	{
		if( ! isset($data['id']) )
			throw new AffirmException("Missing transaction id.");

		return self::_sendPost(self::$_endpoint.'/'.$data['id'].'/capture', $data);
	}

	/**
	 * Void a charge.
	 * @param Array $data Request object with the following:
	 *                     id Required
	 */
	public static function Void($data)
	{
		if( ! isset($data['id']) )
			throw new AffirmException("Missing transaction id.");

		return self::_sendPost(self::$_endpoint.'/'.$data['id'].'/void', $data);
	}

	/**
	 * Refund a charge.
	 * @param Array $data Request object with the following:
	 *                     id Required
	 *                     amount Optional
	 */
	public static function Refund($data)
	{
		if( ! isset($data['id']) )
			throw new AffirmException("Missing transaction id.");

		return self::_sendPost(self::$_endpoint.'/'.$data['id'].'/refund', $data);
	}

	/**
	 * Update a charge.
	 * @param Array $data Request object with the following:
	 *                     id Required
	 *                     order_id Optional
	 *                     shipping_carrier Optional
	 *                     shipping_confirmation Optional
	 */
	public static function Update($data)
	{
		if( ! isset($data['id']) )
			throw new AffirmException("Missing transaction id.");

		return self::_sendPost(self::$_endpoint.'/'.$data['id'].'/update', $data);
	}

}