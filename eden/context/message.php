<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Context IO Messages
 *
 * @package    Eden
 * @category   context
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Context_Message extends Eden_Context_Base {
	/* Constants
	-------------------------------*/
	const URL_MESSAGES			= 'https://api.context.io/2.0/accounts/%s/messages';
	const URL_MESSAGES_DETAIL	= 'https://api.context.io/2.0/accounts/%s/messages/%s';
	const URL_MESSAGES_BODY		= 'https://api.context.io/2.0/accounts/%s/messages/%s/body';
	const URL_MESSAGES_FLAG		= 'https://api.context.io/2.0/accounts/%s/messages/%s/flags';
	const URL_MESSAGES_FOLDER	= 'https://api.context.io/2.0/accounts/%s/messages/%s/folders';
	const URL_MESSAGES_HEADER	= 'https://api.context.io/2.0/accounts/%s/messages/%s/headers';
	const URL_MESSAGES_SOURCE	= 'https://api.context.io/2.0/accounts/%s/messages/%s/source';
	const URL_MESSAGES_THREAD	= 'https://api.context.io/2.0/accounts/%s/messages/%s/thread';
	
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
	 * Filter Messages
	 *
	 * @param string Valid values are: subject, email, to, from, cc, bcc
	 * date_before, date_after, indexed_before, indexed_after
	 * @param string filter value
	 * @return this
	 */
	public function filterBy($filterName, $filterValue) {
		//Argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be an integer
			->argument(2, 'string');	//Argument 2 must be an integer

		$this->_query[$filterName] = $filterValue;
		
		return $this;
	}

	/**
	 * Set mailbox
	 *
	 * @param string Mailbox name
	 * @return this
	 */
	public function setMailbox($mailbox) {
		//Argument 1 must be an string
		Eden_Context_Error::i()->argument(1, 'string');		

		$this->_query['folder'] = $mailbox;
		
		return $this;
	}

	/**
	 * Include message bodies in the result.
	 *
	 * @param string Set to get only body parts of a given MIME-type(ex: text/html)
	 * @return this
	 */
	public function includeBody($bodyType = null) {
		//Argument 1 must be an string or null
		Eden_Context_Error::i()->argument(1, 'string', 'null');		

		$this->_query['include_body'] 	= 1;
		$this->_query['body_type'] 		= $bodyType;
		
		return $this;
	}

	/**
	 * Include message flags in the result.
	 *
	 * @return this
	 */
	public function includeFlag() {

		$this->_query['include_flags'] 	= 1;
		
		return $this;
	}

	/**
	 * Include message headers in the result.
	 *
	 * @param bool If set to true, the headers are also included but as a raw unparsed string
	 * @return this
	 */
	public function includeHeader($raw = false) {
		//Argument 1 must be an boolean
		Eden_Context_Error::i()->argument(1, 'bool');		

		if($raw) {
			$this->_query['include_headers'] = 'raw';	
		} else {
			$this->_query['include_headers'] = 1;
		}
		
		return $this;
	}

	/**
	 * Returns list of files
	 *
	 * @param string|integer Unique id of an account accessible
	 * @param bool sort bu ascending
	 * @param integer The maximum number of results to return
	 * @param integer Start the list at this offset
	 * @return array
	 */
	public function getList($id, $ascending = true ,$limit = 0, $offset = 0) {
		//Argument testing
		Eden_Context_Error::i()
			->argument(1, 'int', 'string')	//Argument 1 must be an integer or string
			->argument(2, 'bool')			//Argument 2 must be an boolena
			->argument(3, 'int')			//Argument 3 must be an integer
			->argument(4, 'int');			//Argument 4 must be an integer
		
		if($ascending) { 
			$this->_query['sort_order'] = 'asc';
		} else { 
			$this->_query['sort_order'] = 'desc';
		}

		$this->_query['limit'] 		= $limit;
		$this->_query['offset'] 	= $offset;


		return $this->_getResponse(sprintf(self::URL_MESSAGES, $id), $this->_query);
	}
	
	/**
	 * Returns detail information of the message
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @param string|null  set to get only body parts of a given MIME-type(ex: text/html)
	 * @return array
	 */
	public function getDetail($id, $messageId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be an string
			->argument(2, 'string')		//Argument 2 must be an string
			->argument(3, 'string');	//Argument 3 must be an string or null
		
		return $this->_getResponse(sprintf(self::URL_MESSAGES_DETAIL, $id, $messageId), $this->_query);
	}

	/**
	 * Move a message
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @param string Mailbox name you want to move the message
	 * @return array
	 */
	public function moveMessage($id, $messageId, $mailboxToMove) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be an string
			->argument(2, 'string')		//Argument 2 must be an string
			->argument(3, 'string');	//Argument 3 must be an string

		$this->_query['dst_folder'] = $mailboxToMove;
		$this->_query['move'] 		= 1;
		
		return $this->_post(sprintf(self::URL_MESSAGES_DETAIL, $id, $messageId), $this->_query);
	}

	/**
	 * Copy a message
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @param string Mailbox name you want to copy the message
	 * @return array
	 */
	public function copyMessage($id, $messageId, $mailboxToCopy) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be an string
			->argument(2, 'string')		//Argument 2 must be an string
			->argument(3, 'string');	//Argument 3 must be an string

		$this->_query['dst_folder'] = $mailboxToCopy;;
		
		return $this->_post(sprintf(self::URL_MESSAGES_DETAIL, $id, $messageId), $this->_query);
	}

	/**
	 * Delete a message
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function deleteMessage($id, $messageId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be an string
			->argument(2, 'string');		//Argument 2 must be an string

		return $this->_delete(sprintf(self::URL_MESSAGES_DETAIL, $id, $messageId));
	}

	/**
	 * Return message body
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @param boolean
	 * @return array
	 */
	public function getMessageBody($id, $messageId, $html = true) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')	//Argument 1 must be a string
			->argument(2, 'string')	//Argument 2 must be a string
			->argument(3, 'bool');	//Argument 3 must be a boolean

		if($html) {
			$this->_query['type'] = 'text/html';
		} else {
			$this->_query['type'] = 'text/plain';	
		}

		return $this->_getResponse(sprintf(self::URL_MESSAGES_BODY, $id, $messageId), $this->_query);
	}

	/**
	 * Return message flag
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getMessageFlag($id, $messageId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
	
		return $this->_getResponse(sprintf(self::URL_MESSAGES_FLAG, $id, $messageId));
	}

	/**
	 * Set message flag
	 *
	 * @param string|integer Unique id of an account
	 * @param string
	 * @param string|null Valid values are: seen. answered, flagged, 
	 * deleted, draft  
	 * @return array
	 */
	public function setMessageFlag($id, $messageId, $flag = null) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')			//Argument 2 must be a string
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null
		
		if(!is_null($flag)) {
			$this->_query[$flag] = 1;
		}

		return $this->_post(sprintf(self::URL_MESSAGES_FLAG, $id, $messageId), $this->_query);
	}

	/**
	 * Return message folder
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getMessageFolder($id, $messageId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
	
		return $this->_getResponse(sprintf(self::URL_MESSAGES_FOLDER, $id, $messageId));
	}

	/**
	 * Return message header
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getMessageHeader($id, $messageId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
	
		return $this->_getResponse(sprintf(self::URL_MESSAGES_HEADER, $id, $messageId));
	}

	/**
	 * Return message source
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getMessageSource($id, $messageId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
	
		return $this->_getResponse(sprintf(self::URL_MESSAGES_SOURCE, $id, $messageId));
	}

	/**
	 * Return message thread
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getMessageThread($id, $messageId, $limit, $offset) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'int')		//Argument 3 must be a integer
			->argument(4, 'in');		//Argument 4 must be a integer
		
		$this->_query['limit'] = $limit;
		$this->_query['offset'] = $offset;

		return $this->_getResponse(sprintf(self::URL_MESSAGES_THREAD, $id, $messageId), $this->_query);
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}