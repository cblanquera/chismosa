<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon Simple Queue Service (SQS) Message
 *
 * @package    Eden
 * @category   amazon
 * @author     Mark Angelo M. Barcelona barcelonamarkangelo@gmail.com
 */
class Eden_Amazon_Sqs_Message extends Eden_Amazon_Sqs_Base {
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
	 * Changes the visibility timeout of a specified message in a queue to a new value. 
	 * The maximum allowed timeout value you can set the value to is 12 hours. This means 
	 * you can't extend the timeout of a message in an existing queue to more than a total 
	 * visibility timeout of 12 hours.
	 * 
	 * @param string The Queue url
	 * @param string The receipt handle associated with the message whose visibility timeout you want to change.
	 * @param string|integer The new value for the message's visibility timeout (in seconds).
	 * @return array
	 */
	 public function changeVisibility($url, $receipt, $visibility) {
		 //argument testing
		 Eden_Amazon_Error::i()
		 	->argument(1, 'string')			//argument 1 must be a string
		 	->argument(2, 'string')			//argument 2 must be a string
			->argument(3, 'string', 'int');	//argument 3 must be a string or integer
			
		$this->_query['Action']				= 'ChangeMessageVisibility';
		$this->_query['ReceiptHandle']		= $receipt;
		$this->_query['VisibilityTimeout']	= $visibility;
		
		return $this->_getResponse($url, $this->_query); 
	}
	
	/**
	 * retrieves one or more messages from the specified queue. Long poll support is 
	 * enabled by using the WaitTimeSeconds parameter.
	 *
	 * @param string The Queue url
	 * @return array
	 */
	 public function receive($url) {
		//argument 1 must be a string
		 Eden_Amazon_Error::i()->argument(1, 'string');	
		 
		 $this->_query['Action'] = 'ReceiveMessage';
		 
		 return $this->_getResponse($url, $this->_query);  
	}
    
	/**
	 * Deletes the specified message from the specified queue. You specify the message 
	 * by using the message's receipt handle and not the message ID you received when 
	 * you sent the message. Even if the message is locked by another reader due to the 
	 * visibility timeout setting, it is still deleted from the queue. If you leave a 
	 * message in the queue for longer than the queue’s configured retention period , 
	 * SQS automatically deletes it.
	 *
	 * @param string The Queue url
	 * @param string The receipt handle associated with the message you want to delete.
	 * @return array
	 */
	 public function remove($url , $receipt) {
		 //argument testing
		 Eden_Amazon_Error::i()
		 	->argument(1, 'string')		//argument 1 must be a string
		 	->argument(2, 'string');	//argument 2 must be a stirng
		 
		 $this->_query['Action']		= 'DeleteMessage';
		 $this->_query['ReceiptHandle']	= $receipt;
		 
		 return $this->_getResponse($url, $this->_query);  
	}
	
	/**
	 * Delivers a message to the specified queue. The maximum allowed message size is 64 KB.
	 *
	 * @param string The Queue url
	 * @param string The message to send.
	 * @param inetger}null The message to send.
	 * @return array
	 */
	 public function send($url, $message, $delay = NULL) {
		 //argument testing
		 Eden_Amazon_Error::i()
		 	->argument(1, 'string')			//argument 1 must be a string
		 	->argument(2, 'string')			//argument 2 must be a string
		 	->argument(3, 'int', 'null');	//argument 3 must be a integer or null
		 
		 $this->_query['Action']		= 'SendMessage';
		 $this->_query['MessageBody'] 	= $message;
		 $this->_query['DelaySeconds'] 	= $delay;
		 
		 return $this->_getResponse($url, $this->_query); 
	}
	
	/**
	 * The attribute you want to get.
	 *
	 * @param string The name of the attribute Valid values: All, SenderId, SentTimestamp, 
	 * ApproximateReceiveCount, ApproximateFirstReceiveTimestamp
	 * @return this
	 */
	public function setAttribute($name) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		//if the attibute name is not allowed
		if(!in_array($name, array('All', 'SenderId', 'SentTimestamp', 
			'ApproximateReceiveCount', 'ApproximateFirstReceiveTimestamp'))) {
			
			//throw error
			Eden_Amazon_Error::i()
				->setMessage(Eden_Amazon_Error::INVALID_ATTRIBUTES) 
				->addVariable($name)
				->trigger();
		}
		
		$this->_query['AttributeName_']
			[isset($this->_query['AttributeName_'])?
			count($this->_query['AttributeName_'])+1:1] = $name;
		
		return $this;
	}
	
	/**
	 * Maximum number of messages to return. SQS never returns more messages than 
	 * this value but might return fewer. Not necessarily all the messages in the queue 
	 * are returned. For more information, see the preceding note about machine sampling.
	 *
	 * @param string|integer From 1 to 10
	 * @return this
	 */
	public function setRange($range) {
		//argument 1 must be a integer or string
		Eden_Amazon_Error::i()->argument(1, 'int', 'string');		
		
		$this->_query['MaxNumberOfMessages'] = $range;
		
		return $this;
	}
	
	/**
	 * The duration in seconds that the received messages are hidden from subsequent 
	 * retrieve requests after being retrieved by a ReceiveMessage request.
	 *
	 * @param string|integer 0 to 43200 (maximum 12 hours)
	 * @return this
	 */
	public function setVisibility($timeout) {
		//argument 1 must be a integer or string
		Eden_Amazon_Error::i()->argument(1, 'int', 'string');		
		
		$this->_query['VisibilityTimeout'] = $timeout;
		
		return $this;
	}
	
	/**
	 * Long poll support (integer from 1 to 20) - the duration (in seconds) that 
	 * the ReceiveMessage action call will wait until a message is in the queue to 
	 * include in the response, as opposed to returning an empty response if a message 
	 * is not yet available.
	 *
	 * @param string|integer From 0 to 20 (seconds)
	 * @return this
	 */
	public function wait($seconds) {
		//argument 1 must be a integer or string
		Eden_Amazon_Error::i()->argument(1, 'int', 'string');		
		
		$this->_query['WaitTimeSeconds'] = $seconds;
		
		return $this;
	}
	 
	/* Protected Methods
    -------------------------------*/
    /* Private Methods
    -------------------------------*/	
}