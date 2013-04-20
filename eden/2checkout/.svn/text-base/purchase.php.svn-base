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
class Eden_2checkout_Purchase extends Eden_2checkout_Base {
	/* Constants
	-------------------------------*/
	const URL_PURCHASE = 'https://www.2checkout.com/checkout/purchase';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_count = 0;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($accountId, $redirect, $mode = '2CO') {
		//argument test
		Eden_2checkout_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		$this->_accountId 	= $accountId; 
		$this->_mode 		= $mode; 
		$this->_redirect 	= $redirect;
	}
	/* Public Methods
	-------------------------------*/
	/**
	 * Purchase product
	 *
	 * @param string
	 * @param string|integer
	 * @param string
	 * @return this
	 */
	public function setItems($name, $price, $type = 'product') {
		//argument testing
		Eden_2checkout_Error::i()
			->argument(1, 'string')				//Argument 1 must be as string
			->argument(2, 'string', 'int')		//Argument 2 must be as string or integer
			->argument(3, 'string');			//Argument 3 must be as string
			
		$this->_query['li_'.$this->_count.'_type']  = $type;	
		$this->_query['li_'.$this->_count.'_name']  = $name;	
		$this->_query['li_'.$this->_count.'_price'] = $price;
		
		$this->_count++;
		
		return $this;
	}
	
	/**
	 * Purchase product
	 *
	 * @param string
	 * @param string|integer
	 * @return this
	 */
	public function setProduct($id, $quantity) {
		//argument testing
		Eden_2checkout_Error::i()
			->argument(1, 'string')				//Argument 1 must be as string
			->argument(2, 'string', 'int');		//Argument 2 must be as string or integer
			
		$this->_query['quantity']   = $quantity;
		$this->_query['product_id'] = $id;
		
		return $this;
	}
	
	/**
	 * Purchase product
	 *
	 * @return url
	 */
	public function purchase() {
	
		return $this->_getUrl(self::URL_PURCHASE, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}