<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Authorize.net Server Integration Method 
 *
 * @package    Eden
 * @category   authorize.net
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Authorizenet_Server extends Eden_Authorizenet_Base{
	/* Constants
	-------------------------------*/
	const LIVE_URL	= 'https://secure.authorize.net/gateway/transact.dll';
    const TEST_URL	= 'https://test.authorize.net/gateway/transact.dll';
	const VERSION	= '3.1';
	const SUBMIT	= 'Submit Payment';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_amount		= NULL;
	protected $_description	= NULL;
	protected $_login		= NULL;
	protected $_fingerprint	= NULL;
	protected $_time		= NULL;
	protected $_sequence	= NULL;
	protected $_action 		= NULL;
	protected $_test		= false;
	protected $_version		= self::VERSION;
	protected $_submit 		= self::SUBMIT;
	protected $_url			= self::TEST_URL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Provides a secure hosted payment form.
	 *
	 * @return this
	 */
	public function getResponse() {
		//if it is in live mode
		if($this->_isLive) {
			$this->_url = self::LIVE_URL;
		} 
		
		//make a xml template
		$query = Eden_Template::i()
			->set('login', $this->_apiLogin)
			->set('fingerprint', $this->_getFingerprint($this->_amount))
			->set('amount', $this->_amount)
			->set('description', $this->_description)
			->set('time', $this->_time)
			->set('sequence', $this->_sequence)
			->set('action', $this->_url)
			->set('version', $this->_version)
			->set('test', $this->_test?'true':false)
			->set('submit', $this->_submit)
			->parsePHP(dirname(__FILE__).'/template/confirm.php');
		
		return $query;
	}
	
	/**
	 * Set the amount of the item  
	 *
	 * @param *integer|float Amount of the item
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Paypal_Error::i()->argument(1, 'int', 'float');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * Set the value of the submit button
	 *
	 * @param string
	 * @return this
	 */
	public function setButton($text) {
		//Argument 1 must be as string
		Eden_Authorizenet_Error::i()->argument(1, 'string');
		
		$this->_submit = $text;
		return $this;
	}
	
	/**
	 * Set item description 
	 *
	 * @param *string Short description of the item	
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_description = $description;
		return $this;
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
