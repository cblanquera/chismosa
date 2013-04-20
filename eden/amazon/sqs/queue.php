<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon Simple Queue Service (SQS) Queue
 *
 * @package    Eden
 * @category   amazon
 * @author     Mark Angelo M. Barcelona barcelonamarkangelo@gmail.com
 */
class Eden_Amazon_Sqs_Queue extends Eden_Amazon_Sqs_Base {
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
	 * Creates a new queue.
	 *
	 * @param string The name to use for the queue created.
	 * @return array
	 */
	public function create($name) {
		//Argument 1 mus be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
			
		$this->_query['Action'] 	= 'CreateQueue';
		$this->_query['QueueName'] 	= $name;	
		
		return $this->_getResponse(self::AMAZON_SQS_HOST, $this->_query);
	}
	
	/**
	 * The attribute you want to get.
	 *
	 * @param string The name of the attribute Valid values: All, ApproximateNumberOfMessages, 
	 * ApproximateNumberOfMessagesNotVisible, VisibilityTimeout, CreatedTimestamp, LastModifiedTimestamp, 
	 * Policy, MaximumMessageSize, MessageRetentionPeriod, QueueArn, OldestMessageAge, DelaySeconds, 
	 * ApproximateNumberOfMessagesDelayed
	 * @return array
	 */
	public function getAttribute($name) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		//if the attibute name is not allowed
		if(!in_array($name, array('All', 'ApproximateNumberOfMessages', 'ApproximateNumberOfMessagesNotVisible', 
			'VisibilityTimeout', 'CreatedTimestamp', 'LastModifiedTimestamp', 'Policy', 
			'MaximumMessageSize', 'MessageRetentionPeriod', 'QueueArn', 'OldestMessageAge', 'DelaySeconds',
			'ApproximateNumberOfMessagesDelayed'))) {
			
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
	 * Returns one or all attributes of a queue.
	 *
	 * @param string The queue url
	 * @return array
	 */
	 public function getAttributes($url) {
		 //argument testing
		 Eden_Amazon_Error::i()->argument(1, 'string');
		 
		 $this->_query['Action'] = 'GetQueueAttributes';
		 
		 return $this->_getResponse($url, $this->_query); 
	 }
	
	/**
	 * Lists all queues, or depending on the Queue Prefix given. The maximum number of queues 
	 * that can be returned is 1000. If you specify a value for the optional QueueNamePrefix 
	 * parameter, only queues with a name beginning with the specified value are returned.
	 *
	 * @param string|null String to use for filtering the list results.
	 * @return array
	 */
	 public function getList($prefix = NULL) {
		//Argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['QueueNamePrefix'] 	= $prefix;
		$this->_query['Action']				= 'ListQueues';
		 
		return $this->_getResponse(self::AMAZON_SQS_HOST, $this->_query);		 
	}
	 
	/**
	 * Returns the Uniform Resource Locater (URL) of a queue. This action 
	 * provides a simple way to retrieve the URL of an SQS queue.
	 *
	 * @param string The name of an existing queue.
	 * @param string|null The AWS account ID of the account that created the queue.
	 * @return array
	 */
	 public function getUrl($name, $account = NULL) {
		 //Argument testing
		 Eden_Amazon_Error::i()
		 	->argument(1, 'string')				//Argument 1 must be a string
		 	->argument(2, 'string', 'null');	//Argument 2 must be a string or null
		
		 $this->_query['Action']					= 'GetQueueUrl';
		 $this->_query['QueueName']					= $name;
		 $this->_query['QueueOwnerAWSAccountId'] 	= $account;
		 
		 return $this->_getResponse(self::AMAZON_SQS_HOST, $this->_query);
	}
	
	/**
	 * Deletes the queue specified by the queue URL, regardless of whether 
	 * the queue is empty. If the specified queue does not exist, SQS 
	 * returns a successful response.
	 *
	 * @param string The url of the queue
	 * @return array
	 */
	public function remove($url) {
		//Argument 1 mus be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']  = 'DeleteQueue';
		
		return $this->_getResponse($url, $this->_query);
	}
	 
	 /**
	 * Sets one attribute of a queue per request. When you change a queue's 
	 * attributes, the change can take up to 60 seconds to propagate throughout the SQS system.
	 *
	 * @param string The queue url
	 * @return array
	 */
	 public function setAttribute($url) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
			
		$this->_query['Action'] = 'SetQueueAttributes';	
		
		return $this->_getResponse($url, $this->_query); 
	}
	
	/**
	 * The name and value of the attribute you want to set.
	 *
	 * @param string The name of the attribute Valid Values: DelaySeconds, MaximumMessageSize, 
	 * MessageRetentionPeriod, Policy, ReceiveMessageWaitTimeSeconds, VisibilityTimeout
	 * @param string The value of the attribute name
	 * @return array
	 */
	public function setAttributes($name, $value) {
		//argument testting
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 1 must be a string
		
		//if the attibute name is not allowed
		if(!in_array($name, array('DelaySeconds', 'MaximumMessageSize', 'MessageRetentionPeriod', 'Policy',
			'ReceiveMessageWaitTimeSeconds', 'VisibilityTimeout'))) {
			
			//throw error
			Eden_Amazon_Error::i()
				->setMessage(sprintf(Eden_Amazon_Error::INVALID_ATTRIBUTE, $name)) 
				->addVariable($name)
				->trigger();
		}
		
		$this->_query['Attribute_Name']
			[isset($this->_query['Attribute_Name'])?
			count($this->_query['Attribute_Name'])+1:1] = $name;
		
		$this->_query['Attribute_Value']
			[isset($this->_query['Attribute_Value'])?
			count($this->_query['Attribute_Value'])+1:1] = $value;
			
		return $this;
	}
	
    /* Protected Methods
    -------------------------------*/
    /* Private Methods
    -------------------------------*/	
}