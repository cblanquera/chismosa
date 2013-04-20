<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Plus
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Google_Imap extends Eden_Mail_Imap {
	/* Constants
	-------------------------------*/	
	const HOST = 'ssl://imap.gmail.com';
	const PORT = 993;
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_token = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($user, $token) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_username 	= $user;
		$this->_token 	= $token;
	}
	
	/* Public Methods
	-------------------------------*/
	 
	public function connect($timeout = self::TIMEOUT, $test = false) {
		Eden_Mail_Error::i()->argument(1, 'int')->argument(2, 'bool');
		
		if($this->_socket) {
			return $this;
		}
		
		$errno  =  0;
        $errstr = '';
        
		$this->_socket = @fsockopen(self::HOST, self::PORT, $errno, $errstr, $timeout);
        
		if (!$this->_socket) {
			//throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable(self::HOST.':'.self::PORT)
				->trigger();
        }

        if (strpos($this->_getLine(), '* OK') === false) {
			$this->disconnect();
            //throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable(self::HOST.':'.self::PORT)
				->trigger();
        }
		
		if($test) {
			fclose($this->_socket);
            
			$this->_socket = NULL;
			return $this;
		}
		
		$this->_send('CAPABILITY');

		$token = base64_encode("user=".$this->_username."\1auth=Bearer ".$this->_token."\1\1");
		
		//login
		$result = $this->_call('AUTHENTICATE XOAUTH2 ', $token);
		
		//$this->disconnect();
		
		if(!is_array($result) || strpos(implode(' ', $result), 'OK') === false) {
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i(Eden_Mail_Error::LOGIN_ERROR)->trigger();
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/

}