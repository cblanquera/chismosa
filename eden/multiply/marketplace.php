<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Multiply Inbox
 *
 * @package    Eden
 * @category   multiply
 * @author     Robinel A. Alinas binel_alinas@yahoo.com
 */
class Eden_Multiply_MarketPlace extends Eden_Multiply_Base {
	/* Constants
	-------------------------------*/
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
	

	/* Public Methods
	-------------------------------*/
	/**
	 * Get top marketplace listings and featured sellers
	 *
	 * @return array
	 */
	public function marketList() {
		return $this->_getResponse(sprintf(self::URL_GET_MARKETPLACE, $this->_domain), $this->_query);
	}
	
	/**
	 * Get a list of marketplace categories
	 *
	 * @return array
	 */
	public function getCategories() {
		return $this->_getResponse(sprintf(self::URL_GET_CATEGORIES, $this->_domain), $this->_query);
	}

	/**
	 * Get a list of product listings
	 *
	 * @param string
	 * @param integer
	 * @return array
	 */
	public function getProductsList($id, $itemPage=NULL) {
		
		Eden_Multiply_Error::i()
			->argument(1, 'string')	//Argument 1 must be string
			->argument(2, 'int');	//Argument 2 must be an integer
			
		$this->_query['category_id']	= $id;
		$this->_query['items_per_page']	= $itemPage;
		return $this->_getResponse(sprintf(self::URL_GET_PRODUCTS, $this->_domain), $this->_query);
	}
	
	/**
	 * Get a list of shops
	 *
	 * @param string
	 * @return array
	 */
	public function shop($id) {
		//Argument 1 must be string
		Eden_Multiply_Error::i()->argument(1, 'string');	
			
		$this->_query['category_id']	= $id;
		return $this->_post(sprintf(self::URL_GET_SHOP, $this->_domain), $this->_query);
	}
	
	/**
	 * View the current user's shopping cart
	 *
	 * @return array
	 */
	public function cart() {
		return $this->_getResponse(sprintf(self::URL_CART, $this->_domain), $this->_query);
	}
	
	/**
	 * Access Multipy's FAQ
	 *
	 * @return array
	 */
	public function getFaq() {
		return $this->_getResponse(sprintf(self::URL_GET_FAQ, $this->_domain));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}