<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Mutipli base
 *
 * @package    Eden
 * @category   multiply
 * @author     Robinel A. Alinas binel_alinas@yahoo.com
 */
class Eden_Multiply_Base extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	const URL_EXISTS			= 'http://%s.multiply.com/api/exists';
	const URL_READ_INBOX		= 'http://%s.multiply.com/api/inbox';
	const URL_FILTER_INBOX		= 'http://%s.multiply.com/api/filters';
	const URL_USER_PROFILE		= 'http://%s.multiply.com/api/profile';
	const URL_GET_CONTACTS		= 'http://%s.multiply.com/api/contacts';
	const URL_CONTACTUS			= 'http://%s.multiply.com/api/contacts_us';
	const URL_GET_FAQ			= 'http://%s.multiply.com/api/faq';
	const URL_GET_ABOUT 		= 'http://%s.multiply.com/api/about';
	const URL_GET_CATEGORIES 	= 'http://%s.multiply.com/api/categories';
	const URL_GET_PRODUCTS 		= 'http://%s.multiply.com/api/productlistings';
	const URL_GET_SHOP 			= 'http://%s.multiply.com/api/shops';
	const URL_CART 				= 'http://%s.multiply.com/api/cart';
	const URL_GET_MARKETPLACE 	= 'http://%s.multiply.com/api/marketplace';
	const URL_USERCONTENT 		= 'http://%s.multiply.com/api/read';
	const URL_REPLY 			= 'http://%s.multiply.com/api/reply';
	const URL_POST 				= 'http://%s.multiply.com/api/post';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_consumerKey = NULL;
	protected $_consumerSecret = NULL;
	protected $_accessToken = NULL;
	protected $_accessSecret = NULL;
	protected $_apiKey = NULL;
	protected $_domain = NULL;
	protected $_userId = NULL;
	protected $_password = NULL;
	
	protected $_query = array();
		
	
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($consumerKey, $consumerSecret, $accessToken, $accessSecret, $domain, $apiKey) {
		Eden_Multiply_Error::i()
			->argument(1, 'string') //Argument 1 must be a string
			->argument(2, 'string') //Argument 2 must be a string
			->argument(3, 'string') //Argument 3 must be a string
			->argument(4, 'string') //Argument 4 must be a string
			->argument(5, 'string') //Argument 5 must be a string
			->argument(6, 'string'); //Argument 6 must be a string
		
		$this->_consumerKey 	= $consumerKey; 
		$this->_consumerSecret 	= $consumerSecret;
		$this->_accessToken 	= $accessToken;
		$this->_accessSecret 	= $accessSecret;
		$this->_domain 			= $domain;
		$this->_apiKey 			= $apiKey; 
		
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	* setCredential with user id and password
	*
	* @param string
	* @param string
	* @return array
	*/
	public function setCredentials($userId, $password) {
		Eden_Multiply_Error::i()
			->argument(1, 'string') //argument 1 must be a string
			->argument(2, 'string'); //argument 2 must be a integer
			
		$this->_userId 		= $userId;
		$this->_password 	= $password;
		
		return $this;
	}
	
	/**
	* Returns the meta of the last call
	* 
	* @param string
	* @return array
	*/
	public function getMeta($key = NULL) {
		Eden_Multiply_Error::i()->argument(1, 'string', 'null');
	
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/**
	* Check if the response is json format
	*
	* @param string
	* @return boolean
	*/
	public function isJson($string) {
		//argument 1 must be a string
		Eden_Multiply_Error::i()->argument(1, 'string');
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	/**
	* Check if the response is xml
	*
	* @param string|array|object|null
	* @return bollean
	*/
	public function isXml($xml) {
		//argument 1 must be a string, array, object or null
		Eden_Amazon_Error::i()->argument(1, 'string', 'array', 'object', 'null');
	
		if(is_array($xml) || is_null($xml)) {
			return false;
		}
		libxml_use_internal_errors( true );
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML($xml);
		$errors = libxml_get_errors();
	
		return empty($errors);
	}

	
	/* Protected Methods
	-------------------------------*/
	
	protected function _accessKey($array) {
		foreach($array as $key => $val) {
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			//if value is null
			if(is_null($val) || empty($val)) {
				unset($array[$key]);
			} else if($val === false) {
				$array[$key] = 0;
			} else if($val === true) { 
				$array[$key] = 1;
			}
		}
	return $array;
	}

	protected function _getResponse($url, $query = array()) {
		
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		
		$query['api_key'] = $this->_apiKey;
		$query['password'] = $this->_password;
		$query['user_id'] = $this->_userId;
		
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setMethodToGet()
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		//get response from curl
		$response = $rest->getResponse($query);
		//reset variables
		unset($this->_query);
		
		$this->_meta = $rest->getMeta(); 
		//if result is in xml format 
		if($this->isXml($response)) {
			//convert it to string
			$response = json_decode(json_encode((array) simplexml_load_string($response)), 1); 
		}
		return $response;	
	}
	
	protected function _post($url, array $query = array()) {
		$query = $this->_accessKey($query);
		$query['api_key'] = $this->_apiKey;
		$query['password'] = $this->_password;
		$query['user_id'] = $this->_userId;
		
		//set headers
		$headers = array();
		$headers[] = Eden_Oauth_Consumer::POST_HEADER;
		//make oauth signature
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setMethodToPost()
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		//get the authorization parameters as an array
		$signature 		= $rest->getSignature($query);
		$authorization 	= $rest->getAuthorization($signature, false);
		$authorization 	= $this->_buildQuery($authorization);
		//if query is in array
		if(is_array($query)) {
			//build a http query
			$query 	= $this->_buildQuery($query);
		}
		//determine the conector
		$connector = NULL;
		
		//if there is no question mark
		if(strpos($url, '?') === false) {
			$connector = '?';
		//if the redirect doesn't end with a question mark
		} else if(substr($url, -1) != '?') {
			$connector = '&';
		}
		//now add the authorization to the url
		$url .= $connector.$authorization;
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($headers);
			
		//get the response
		$response = $curl->getResponse();
		
		//reset variables
		unset($this->_query);
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['authorization'] 	= $authorization;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		print_r($this->_meta);
		
		return $response;
	}
	

	
	/* Private Methods
	-------------------------------*/
}

