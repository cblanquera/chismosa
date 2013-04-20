<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Context IO contacts
 *
 * @package    Eden
 * @category   context
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Context_Contact extends Eden_Context_Base {
	/* Constants
	-------------------------------*/
	const URL_CONTACT			= 'https://api.context.io/2.0/accounts/%s/contacts';
	const URL_CONTACT_DETAIL	= 'https://api.context.io/2.0/accounts/%s/contacts/%s';
	const URL_CONTACT_FILES		= 'https://api.context.io/2.0/accounts/%s/files';
	const URL_CONTACT_MESSAGES	= 'https://api.context.io/2.0/accounts/%s/messages';
	const URL_CONTACT_THREADS	= 'https://api.context.io/2.0/accounts/%s/threads';

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
	 * Search for contact
	 *
	 * @param string Search word
	 * @return this
	 */
	public function search($query) {
		//Argument 1 must be an integer
		Eden_Context_Error::i()->argument(1, 'string');	
		
		$this->_query['search'] = $query;

		return $this;
	}

	/**
	 * Returns list of contact
	 *
	 * @param string|integer Unique id of an account accessible
	 * @param integer The maximum number of results to return
	 * @param integer Start the list at this offset
	 * @return array
	 */
	public function getList($id, $limit = 0, $offset = 0) {
		//Argument testing
		Eden_Context_Error::i()
			->argument(1, 'int')	//Argument 1 must be an integer
			->argument(2, 'int')	//Argument 2 must be an integer
			->argument(3, 'int');	//Argument 3 must be an integer
		
		$this->_query['limit'] 	= $limit;
		$this->_query['offset'] = $offset;

		return $this->_getResponse(sprintf(self::URL_CONTACT, $id), $this->_query);
	}
	
	/**
	 * Return detail information of email on contact
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getDetail($id, $email) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')	//Argument 1 must be an string
			->argument(2, 'email');	//Argument 2 must be an email
		
		return $this->_getResponse(sprintf(self::URL_CONTACT_DETAIL, $id, $email));
	}

	/**
	 * Returns the latest attachments exchanged with one or more email addresses. 
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @param integer 
	 * @param integer
	 * @return array
	 */
	public function getContactsFiles($id, $email, $limit = 0, $offset = 0) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')	//Argument 1 must be an string
			->argument(2, 'email')	//Argument 2 must be an email
			->argument(3, 'int')	//Argument 3 must be an integer
			->argument(4, 'int');	//Argument 4 must be an integer
		
		$this->_query['limit'] 	= $limit;
		$this->_query['offset'] = $offset;

		return $this->_getResponse(sprintf(self::URL_CONTACT_FILES, $id, $email));
	}

	/**
	 * Returns the latest email messages exchanged with one or more email addresses 
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @param integer 
	 * @param integer 
	 * @return array
	 */
	public function getContactsMessages($id, $email, $limit = 0, $offset = 0) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')	//Argument 1 must be an string
			->argument(2, 'email')	//Argument 2 must be an email
			->argument(3, 'int')	//Argument 3 must be an integer
			->argument(4, 'int');	//Argument 4 must be an integer
		
		$this->_query['limit'] 	= $limit;
		$this->_query['offset'] = $offset;

		return $this->_getResponse(sprintf(self::URL_CONTACT_MESSAGES, $id, $email));
	}

	/**
	 * Returns the latest email threads exchanged with one or more email addresses 
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @param integer 
	 * @param integer 
	 * @return array
	 */
	public function getContactsThreads($id, $email, $limit = 0, $offset = 0) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')	//Argument 1 must be an string
			->argument(2, 'email')	//Argument 2 must be an email
			->argument(3, 'int')	//Argument 3 must be an integer
			->argument(4, 'int');	//Argument 4 must be an integer
		
		$this->_query['limit'] 	= $limit;
		$this->_query['offset'] = $offset;

		return $this->_getResponse(sprintf(self::URL_CONTACT_THREADS, $id, $email));
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}