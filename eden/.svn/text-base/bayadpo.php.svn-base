<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/bayadpo/error.php';
require_once dirname(__FILE__).'/bayadpo/base.php';
require_once dirname(__FILE__).'/bayadpo/order.php';
require_once dirname(__FILE__).'/bayadpo/orderinternal.php';

/**
 * Bayadpo API factory. This is a factory class with 
 * methods that will load up different asiapay classes.
 * Bayadpo classes are organized as described on their 
 * developer site: order and order internal.
 *
 * @package    Eden
 * @category   bayadpo
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Bayadpo extends Eden_Class {
	/* Constants 
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns bayadpo order
	 *
	 * @param *string
	 * @return Eden_Bayadpo_Order
	 */
	public function order($securityKey) {
		//Argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		return Eden_Bayadpo_Order::i($securityKey);
	}
	
	/**
	 * Returns bayadpo order internal
	 *
	 * @param *string
	 * @return Eden_Bayadpo_OrderInternal
	 */
	public function orderInternal($securityKey) {
		//Argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		return Eden_Bayadpo_OrderInternal::i($securityKey);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}