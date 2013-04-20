<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon Simple Queue Service (SQS) Batch
 *
 * @package    Eden
 * @category   amazon
 * @author     Mark Angelo M. Barcelona barcelonamarkangelo@gmail.com
 */
class Eden_Amazon_Sqs_Batch extends Eden_Amazon_Sqs_Base {
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
	 * Set an identifier that you assign to the message and a message body. Requests that are part of 
	 * the same call to SendMessageBatch cannot have the same identifier.
	 *
	 * @param string Any identifier that you assign to the message
	 * @param string The message to send
	 * @param int|null From 0 to 900 (maximum 15 minutes).
	 * @return this
	 */
	public function setMessage($id, $messageBody, $delaySeconds = NULL) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')			//argument 1 must be a string
			->argument(2, 'string')			//argument 2 must be a string
			->argument(3, 'int', 'null');	//argument 3 must be a integer or null
		
		$this->_query['SendMessageBatchRequestEntry_Id']
			[isset($this->_query['SendMessageBatchRequestEntry_Id'])?
			count($this->_query['SendMessageBatchRequestEntry_Id'])+1:1] = $id;
		
		$this->_query['SendMessageBatchRequestEntry_MessageBody']
			[isset($this->_query['SendMessageBatchRequestEntry_MessageBody'])?
			count($this->_query['SendMessageBatchRequestEntry_MessageBody'])+1:1] = $messageBody;
		
		$this->_query['SendMessageBatchRequestEntry_DelaySeconds']
			[isset($this->_query['SendMessageBatchRequestEntry_DelaySeconds'])?
			count($this->_query['SendMessageBatchRequestEntry_DelaySeconds'])+1:1] = $delaySeconds;
		
		return $this;
	}
	
	/**
	 * Set id and receiptHandle 
	 *
	 * @param string An identifier that you assign to the message. Requests that are part 
	 * of the same call to DeleteMessageBatch cannot have the same identifier.
	 * @param string The receipt handle that is associated with the message that you want 
	 * to delete. This parameter is returned by the ReceiveMessage action.
	 * @return this
	 */
	public function setDeleteReceiptHandle($id, $receiptHandle) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')			//argument 1 must be a string
			->argument(2, 'string');		//argument 2 must be a string
		
		$this->_query['DeleteMessageBatchRequestEntry_Id']
			[isset($this->_query['DeleteMessageBatchRequestEntry_Id'])?
			count($this->_query['DeleteMessageBatchRequestEntry_Id'])+1:1] = $id;
		
		$this->_query['DeleteMessageBatchRequestEntry_ReceiptHandle']
			[isset($this->_query['DeleteMessageBatchRequestEntry_ReceiptHandle'])?
			count($this->_query['DeleteMessageBatchRequestEntry_ReceiptHandle'])+1:1] = $receiptHandle;
		
		return $this;
	}
	
	/**
	 * Set an identifier that you assign to the message and a message body. Requests that are part of 
	 * the same call to SendMessageBatch cannot have the same identifier.
	 *
	 * @param string An identifier that you assign to the request. 
	 * @param string The receipt handle associated with the message that has the visibility
	 * timeout that you want to change. This parameter is returned by the ReceiveMessage action.
	 * @param int|null From 0 to 43200 (maximum 12 hours).
	 * @return this
	 */
	public function setChangeMessageReceiptHandle($id, $receiptHandle, $visibilityTimeout = NULL) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')			//argument 1 must be a string
			->argument(2, 'string')			//argument 2 must be a string
			->argument(3, 'int', 'null');	//argument 3 must be a integer or null
		
		$this->_query['ChangeMessageVisibilityBatchRequestEntry_Id']
			[isset($this->_query['ChangeMessageVisibilityBatchRequestEntry_Id'])?
			count($this->_query['ChangeMessageVisibilityBatchRequestEntry_Id'])+1:1] = $id;
		
		$this->_query['ChangeMessageVisibilityBatchRequestEntry_ReceiptHandle']
			[isset($this->_query['ChangeMessageVisibilityBatchRequestEntry_ReceiptHandle'])?
			count($this->_query['ChangeMessageVisibilityBatchRequestEntry_ReceiptHandle'])+1:1] = $messageBody;
		
		$this->_query['ChangeMessageVisibilityBatchRequestEntry_VisibilityTimeout']
			[isset($this->_query['ChangeMessageVisibilityBatchRequestEntry_VisibilityTimeout'])?
			count($this->_query['ChangeMessageVisibilityBatchRequestEntry_VisibilityTimeout'])+1:1] = $visibilityTimeout;
		
		return $this;
	}
	
	/**
	 * Delivers up to ten messages to the specified queue.
	 *
	 * @param string The queue url
	 * @return array
	 */
	 public function sendMessageBatch($queueUrl) {
		 //argument 1 must be a string
		 Eden_Amazon_Error::i()->argument(1, 'string');
		 
		 $this->_query['Action'] = 'SendMessageBatch';
		 
		 return $this->_getResponse($queueUrl, $this->_query);  
	}
	
	/**
	 * Deletes a batch of messages  
	 *
	 * @param string The queue url.
	 * @return array
	 */
	 public function deleteMessageBatch($queueUrl) {
		 //argument 1 must be a string
		 Eden_Amazon_Error::i()->argument(1, 'string');
		 
		 $this->_query['Action'] = 'DeleteMessageBatch';
		 
		 return $this->_getResponse($queueUrl, $this->_query); 
	}
	
	/**
	 * The ChangeMessageVisibilityBatch action is a batch version of the ChangeMessageVisibility 
	 * action. You can send up to 10 ChangeMessageVisibility requests with each 
	 * ChangeMessageVisibilityBatch action. 
	 *
	 * @param string The queue url.
	 * @return array
	 */
	 public function changeMessageVisibilityBatch($queueUrl) {
		 //argument 1 must be a string
		 Eden_Amazon_Error::i()->argument(1, 'string');
		 
		 $this->_query['Action'] = 'ChangeMessageVisibilityBatch';
		 
		 return $this->_getResponse($queueUrl, $this->_query); 
	}
	
	/* Protected Methods
    -------------------------------*/
    /* Private Methods
    -------------------------------*/	
}