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
class Eden_Google_Smtp extends Eden_Mail_Smtp {
	/* Constants
	-------------------------------*/	
	const HOST = 'ssl://smtp.gmail.com';
	const PORT = 465;
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_token 	= NULL;
	
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

		$this->_boundary[] = md5(time().'1');
		$this->_boundary[] = md5(time().'2');
	}
	
	/* Public Methods
	-------------------------------*/
	 
	public function connect($timeout = self::TIMEOUT, $test = false) {
		Eden_Mail_Error::i()
			->argument(1, 'int')
			->argument(2, 'bool');
			
		if($this->_socket) {
			return $this;
		}
		
		$errno  =  0;
        $errstr = '';
		
		// $this->_socket = @stream_socket_client($host.':'.$this->_port, $errno, $errstr, $timeout);
		$this->_socket = @fsockopen(self::HOST, self::PORT, $errno, $errstr, $timeout);
		
		if (!$this->_socket) {
			//throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($this->_host.':'.$this->_port)
				->trigger();
        }

		if(!$this->_call('EHLO '.$_SERVER['HTTP_HOST'])) {
			$this->disconnect();
            //throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($this->_host.':'.$this->_port)
				->trigger();
		}

		if($test) {
			$this->disconnect();
			return $this;
		}
		
		$token = base64_encode("user=".$this->_username."\1auth=Bearer ".$this->_token."\1\1");

		//login
		if(!$this->_call('AUTH XOAUTH2 ' . $token)){
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i(Eden_Mail_Error::LOGIN_ERROR)->trigger();
		} else {
			//it does not work without this
			$this->_receive();
		}

		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
}