<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon SQS
 *
 * @package    Eden
 * @category   amazon
 * @author     
 */
class Eden_Amazon_Sqs_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const AMAZON_SQS_HOST 		= 'sqs.ap-southeast-1.amazonaws.com';
	const ACCESS_KEY_ID 		= 'AWSAccessKeyId';	 
	const VERSION				= 'Version';
	const SIGNATURE				= 'Signature';
	const SIGNATURE_VERSION		= 'SignatureVersion';
	const SIGNATURE_METHOD		= 'SignatureMethod';
	const TIMESTAMP				= 'Timestamp';
	
	const VERSION_DATE 			= '2012-11-05';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query 		= array();
	protected $_response 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($amazonKey, $amazonSecret) {
		//Argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(1, 'string');	//argument 2 must be a string
			
		$this->_amazonKey		= $amazonKey;
		$this->_amazonSecret	= $amazonSecret;	
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	protected function _isXml($xml) {
		Eden_Amazon_Error::i()->argument(1, 'scalar', 'array', 'object', 'null');
		
		if(is_bool($xml) || is_array($xml) || is_null($xml)) {
			return false;
		}
		
		libxml_use_internal_errors( true );
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML($xml);
		$errors = libxml_get_errors();
		
		return empty($errors);
	}
	
	protected function _generateSignature($host, $query) {	
		// Write the signature
		$signature = "GET\n";
		$signature .= "$host\n";
		$signature .= "/\n";
		//sort query
		ksort($query);
		$first = true;
		//generate a hash signature
		foreach($query as $key => $value) {
			$signature .= (!$first ? '&' : '') . rawurlencode($key) . '=' . rawurlencode($value);
			$first = false;
		}
		
		//genarate signature by encoding the access secret to the signature hash
		$signature = hash_hmac('sha256', $signature, $this->_amazonSecret, true);
		$signature = base64_encode($signature);
		
		return $signature;
	}
	
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
	
	protected function _formatQuery($rawQuery) {
		foreach($rawQuery as $key => $value) {
			//if value is still in array
			if(is_array($value)) {
				//foreach value
				foreach($value as $k => $v) {
					$keyValue = explode('_', $key);
					if(!empty($keyValue[1])) {
						$name =  rawurlencode($keyValue[0].'.'.$k.'.'.$keyValue[1]);
					} else {
						$name =  rawurlencode($keyValue[0].'.'.$k);
					}
					//put key key name with k integer if they set multiple value
					$query[str_replace("%7E", "~", $name)] = str_replace("%7E", "~", rawurlencode($v));
				}
			//else it is a simple array only	
			} else {
				//format array to query
				$query[str_replace("%7E", "~", rawurlencode($key))] = str_replace("%7E", "~", rawurlencode($value));
			}
		} 
		return $query;
	}
	
	protected function _getResponse($host, $rawQuery) { 
		//prevent sending null values
		$rawQuery = $this->_accessKey($rawQuery); 
		//sort the raw query
		ksort($rawQuery);
		//format array query
		$query = $this->_formatQuery($rawQuery); 
		// Build out the variables
		$domain = "https://$host/";
		
		//set parameters for generating request
		$query[self::ACCESS_KEY_ID] 	= $this->_amazonKey; 
		$query[self::VERSION] 			= self::VERSION_DATE;
		$query[self::TIMESTAMP] 		= date('c');
		$query[self::SIGNATURE_METHOD]	= 'HmacSHA256';
		$query[self::SIGNATURE_VERSION] = 2; 
		//create a request signature for security access
		$query[self::SIGNATURE] 		= $this->_generateSignature($host, $query);
		//build a http query
		$url = $domain.'?'.http_build_query($query);  
		//set curl
		$curl =  Eden_Curl::i()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60);
			
		//get response from curl
		$response = $curl->getResponse();
		
		//if result is in xml format 
		if($this->_isXml($response)) {
			//convert it to array
			$response = json_decode(json_encode((array) simplexml_load_string($response)), 1);
		}
		
		//if there is no response
		//there must be a error
		if(empty($response)) {
			//show error
			$this->_response = $curl->getMeta();
		//else it is success
		} else {
			//show response
			$this->_response = $response;
		}
		
		//get curl infomation
		$this->_meta['url']			= $url;
		$this->_meta['query']		= $query;
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['response']	= $this->_response;
		
		return $this->_response;
	}
	
	/* Private Methods
	-------------------------------*/
}