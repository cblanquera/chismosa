<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Context oauth
 *
 * @package    Eden
 * @category   context
 * @author     Christian Symon Buenavista sbuenavista@@openovate.com
 */
class Eden_Context_Auth extends Eden_Class {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 		= 'https://api.context.io/2.0/accounts'; 
	const AUTHORIZE_URL		= 'https://api.twitter.com/oauth/authorize';
	const ACCESS_URL		= 'https://api.twitter.com/oauth/access_token';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key 	= NULL;
	protected $_secret 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($key, $secret) {
		//argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_key 	= $key;
		$this->_secret 	= $secret;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the access token 
	 * 
	 * @param string the response key; from the url usually
	 * @param string the request secret; from getRequestToken() usually
	 * @return string the response verifier; from the url usually
	 */
	public function getAccessToken($token, $secret, $verifier) {
		//argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		return Eden_Oauth::i()
			->consumer(
				self::ACCESS_URL, 
				$this->_key, 
				$this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setToken($token, $secret)
			->setVerifier($verifier)
			->setSignatureToHmacSha1()
			->getQueryResponse();
	}
	
	/**
	 * Return a request token
	 * 
	 * @return string
	 */
	public function getRequestToken() {
		return Eden_Oauth::i()
			->consumer(
				self::REQUEST_URL, 
				$this->_key, 
				$this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setSignatureToHmacSha1()
			->getQueryResponse();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}