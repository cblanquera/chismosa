<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * 2checkout base 
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_2checkout_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const ACCOUNT = 'sid';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_headers		= array();
	protected $_meta		= array();
	protected $_query		= array();
	protected $_username 	= null;
	protected $_password 	= null;
	protected $_accountId 	= null;
	protected $_mode 		= null;
	protected $_redirect 	= null;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta() {
	
		return $this->_meta;
	}
	
	/**
	 * Check if the response is xml
	 *
	 * @param string|array|object|null
	 * @return bollean
	 */
	public function isXml($xml) {
		//argument 1 must be a string, array,  object or null
		Eden_Google_Error::i()->argument(1, 'string', 'array', 'object', 'null');
		
		if(is_array($xml) || is_null($xml)) {
			return false;
		}
		libxml_use_internal_errors( true );
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML($xml);
		$errors = libxml_get_errors();
		
		return empty($errors);
	}
	
	/**
	 * Check if the response is json format
	 *
	 * @param string
	 * @return boolean
	 */
	public function isJson($string) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
 		json_decode($string);
 		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _accessKey($array) {
		
		foreach($array as $key => $val) {
			// if value is array
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			//if value in null
			if($val == NULL || empty($val)) {
				//remove it from query
				unset($array[$key]);
			}
		}
		return $array;
	}
	
	protected function _getUrl($url, array $query = array()) {
		
		$query[self::ACCOUNT] = $this->_accountId;
		$query['x_receipt_link_url']  = $this->_redirect;
		
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		
		return $url.'?'.http_build_query($query);	
	}
	
	protected function _getResponse($url, array $query = array()) {

		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//build url query
		$url = $url.'?'.http_build_query($query);
		//set curl
		$curl =  Eden_Curl::i()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setUserPwd($this->_username.':'.$this->_password)
			->setTimeout(60);
		//get response from curl
		$response = $curl->getResponse();
		//get curl infomation
		$this->_meta['url']			= $url;
		$this->_meta['query']		= $query;
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['response']	= $response;
		
		//reset protected variables
		unset($this->_query); 
		
		//check if response is in xml format
		if($this->isXml($response)) {
			//if it is xml, convert it to array
			return $response =  simplexml_load_string($response);
		}
		
		//check if response is in json format
		if($this->isJson($response)) { 
			//else it is in json format, convert it to array
			return $response = json_decode($response, true);
		}
	}
	
	protected function _post($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
	
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setUserPwd($this->_username.':'.$this->_password)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($this->_headers);
		//get response form curl
		$response = $curl->getResponse();		
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		$this->_meta['query'] 			= $query;
		
		//reset protected variables
		unset($this->_query);
		
		//check if response is in json format
		if($this->isJson($response)) {
			//else it is in json format, covert it to array
			return $response = json_decode($response, true);
		}
		//check if response is in xml format
		if($this->isXml($response)) {
			//if it is xml, convert it to array
			return $response =  simplexml_load_string($response);
		} 
		//if it is a normal response
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}