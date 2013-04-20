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
class Eden_2checkout_Create extends Eden_2checkout_Base {
	/* Constants
	-------------------------------*/
	const URL_CREATE = 'https://www.2checkout.com/api/products/create_product';
	
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
	 * Create Product
	 *
	 * @return array
	 */
	public function create($name, $price, $description = null) {
		//argument testing
		Eden_2checkout_Error::i()
			->argument(1, 'string')				//Argument 1 must be as string
			->argument(2, 'string', 'int')		//Argument 2 must be as string or integer
			->argument(3, 'string', 'null');	//Argument 3 must be as string or null
		
		$this->_query['name']  		 = $name;
		$this->_query['price'] 		 = $price;
		$this->_query['description'] = $description;
		
		return $this->_post(self::URL_CREATE, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}