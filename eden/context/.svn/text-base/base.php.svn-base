<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Context io base
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon Buenavista sbuenavista@openovate.com
 */
class Eden_Context_Base extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_consumerKey 	= NULL;
	protected $_consumerSecret 	= NULL;
	protected $_accessToken		= NULL;
	protected $_accessSecret	= NULL;
	protected $_signingKey		= NULL;
	protected $_baseString		= NULL;
	protected $_signingParams	= NULL;
	protected $_url				= NULL;
	protected $_authParams 		= NULL;
	protected $_authHeader 		= NULL;
	protected $_headers	 		= NULL;
	protected $_query			= array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($consumerKey, $consumerSecret) {
		//argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		$this->_consumerKey 	= $consumerKey; 
		$this->_consumerSecret 	= $consumerSecret;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		Eden_Twitter_Error::i()->argument(1, 'string', 'null');
		
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
		Eden_Twitter_Error::i()->argument(1, 'string');
		
 		json_decode($string);
 		return (json_last_error() == JSON_ERROR_NONE);
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
	
	protected function _getResponse($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setMethodToGet()
			//->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		//get response from curl
		$response = $rest->getResponse($query);
		
		//reset variables
		unset($this->_query);
		
		$this->_meta = $rest->getMeta();
		
		//check if the response is in json format
		if($this->isJson($response)) { 
			//json encode it
			return json_decode($response, true);
		//else it is a raw query
		} else {
			//return it
			return $response;
		}
	}
	
	protected function _delete($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setMethodToDelete()
			//->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();	

		//get the authorization parameters as an array
		$signature 		= $rest->getSignature($query);
		$authorization 	= $rest->getAuthorization($signature, false);
		$authorization 	= $this->_buildQuery($authorization);
	
		if(is_array($query)) {
			$query 	= $this->_buildQuery($query);
		}

		$headers = array();
		$headers[] = Eden_Oauth_Consumer::POST_HEADER;
		
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
			->setCustomRequest('DELETE')
			->setHeaders($headers);
		
		//get the response
		$response = $curl->getJsonResponse();
		
		//reset variables
		unset($this->_query);
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['authorization'] 	= $authorization;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		return $response;	
	}

	protected function _post($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setMethodToPost()
			//->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		
		//get the authorization parameters as an array
		$signature 		= $rest->getSignature($query);
		$authorization 	= $rest->getAuthorization($signature, false);
		$authorization 	= $this->_buildQuery($authorization);
	
		if(is_array($query)) {
			$query 	= $this->_buildQuery($query);
		}

		$headers = array();
		$headers[] = Eden_Oauth_Consumer::POST_HEADER;
		
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
		$response = $curl->getJsonResponse();
		
		//reset variables
		unset($this->_query);
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['authorization'] 	= $authorization;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}