<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon sqs factory class
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Amazon_Sqs extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_accessKey		= NULL;
	protected $_accessSecret	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($accessKey, $accessSecret) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$this->_accessKey		= $accessKey;
		$this->_accessSecret	= $accessSecret;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Factory method for amazon sqs batch
	 *
	 * @return Eden_Amazon_Sqs_Batch
	 */
	public function batch() {
		return Eden_Amazon_Sqs_Batch::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon sqs message
	 *
	 * @return Eden_Amazon_Sqs_Message
	 */
	public function message() {
		return Eden_Amazon_Sqs_Message::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon sqs permission
	 *
	 * @return Eden_Amazon_Sqs_Permission
	 */
	public function permission() {
		return Eden_Amazon_Sqs_Permission::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon sqs queue
	 *
	 * @return Eden_Amazon_Sqs_Queue
	 */
	public function queue() {
		return Eden_Amazon_Sqs_Queue::i($this->_accessKey, $this->_accessSecret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
