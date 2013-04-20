<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon Simple Queue Service (SQS) Permission
 *
 * @package    Eden
 * @category   amazon
 * @author     Mark Angelo M. Barcelona barcelonamarkangelo@gmail.com
 */
class Eden_Amazon_Sqs_Permission extends Eden_Amazon_Sqs_Base {
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
	 * Set the AWS account number and action of the principal who will be given permission
	 *
	 * @param string The AWS account number of the principal who will be given permission. 
	 * @param string The action you want to allow for the specified principal. Valid values: SendMessage, ReceiveMessage
	 * ,DeleteMessage, ChangeMessageVisibility, GetQueueAttributes, GetQueueUrl
	 * @return array
	 */
	public function setPrincipal($awsAccountId, $actionName) {
		//argument testting
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 1 must be a string
		
		//if the attibute name is not allowed
		if(!in_array($actionName, array('SendMessage', 'ReceiveMessage', 'DeleteMessage',
			'ChangeMessageVisibility', 'GetQueueAttributes', 'GetQueueUrl'))) {
			
			//throw error
			Eden_Amazon_Error::i()
				->setMessage(sprintf(Eden_Amazon_Error::INVALID_ACTIONNAME, $actionName)) 
				->addVariable($actionName)
				->trigger();
		}
		
		$this->_query['AWSAccountId_']
			[isset($this->_query['AWSAccountId_'])?
			count($this->_query['AWSAccountId_'])+1:1] = $awsAccountId;
		
		$this->_query['ActionName_']
			[isset($this->_query['ActionName_'])?
			count($this->_query['ActionName_'])+1:1] = $actionName;
			
		return $this;
	}
	
	/**
	 * Adds a permission to a queue for a specific principal. 
	 * This allows for sharing access to the queue.
	 *
	 * @param string The queue url
	 * @param string The unique identification of the permission you're setting.
	 * @return array
	 */
	public function addPermission($queueUrl, $label) {
		//Argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');		//argument 2 must be a string
			
		$this->_query['Action'] 	= 'AddPermission';
		$this->_query['Label']		= $label;	
		
		return $this->_getResponse($queueUrl, $this->_query);
	}
	
	
	/**
	 * Revokes any permissions given 
	 *
	 * @param string The queue url
	 * @param string The unique identification of the permission you're setting.
	 * @return array
	 */
	public function removePermission($queueUrl, $label) {
		//Argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query['Action'] 	= 'RemovePermission';
		$this->_query['Label'] 		= $label;
		
		return $this->_getResponse($queueUrl, $this->_query);
	}
	
    /* Protected Methods
    -------------------------------*/
    /* Private Methods
    -------------------------------*/	
}