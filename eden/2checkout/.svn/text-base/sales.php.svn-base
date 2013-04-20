<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * 2Checkout
 *
 * @package    Eden
 * @category   2checkout
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_2checkout_Sales extends Eden_2checkout_Base {
	/* Constants
	-------------------------------*/
	const URL_SALES = 'https://www.2checkout.com/api/sales/detail_sale';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($username, $password) {
		//argument test
		Eden_2checkout_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		$this->_username 	= $username; 
		$this->_password 	= $password;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Purchase product
	 *
	 * @return url
	 */
	public function getDetail($invoiceId) {
		
		$this->_query['invoice_id'] = $invoiceId;
		
		return $this->_getResponse(self::URL_SALES, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}