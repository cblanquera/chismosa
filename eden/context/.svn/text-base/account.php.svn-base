<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Context IO Accounts
 *
 * @package    Eden
 * @category   context
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Context_Account extends Eden_Context_Base {
	/* Constants
	-------------------------------*/
	const URL_ACCOUNT_LIST		= 'https://api.context.io/2.0/accounts';
	const URL_ACCOUNT	= 'https://api.context.io/2.0/accounts/%s';
	const URL_DISCOVER 		= 'https://api.context.io/2.0/discovery';
	const URL_SOURCE 		= 'https://api.context.io/2.0/accounts/%s/sources';

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
	 * Filter account listing by email
	 *
	 * @param string
	 * @return this
	 */
	public function filterByEmail($email) {
		//Argument 1 must be an integer
		Eden_Context_Error::i()->argument(1, 'string');	
		
		$this->_query['email'] 	= $email;

		return $this;
	}

	/**
	 * Returns list of account
	 *
	 * @param integer The maximum number of results to return
	 * @param integer Start the list at this offset
	 * @return array
	 */
	public function getList($limit = 0, $offset = 0) {
		//Argument testing
		Eden_Context_Error::i()
			->argument(1, 'int')	//Argument 1 must be an integer
			->argument(2, 'int');	//Argument 2 must be an integer
		
		$this->_query['limit'] 	= $limit;
		$this->_query['offset'] = $offset;

		return $this->_getResponse(self::URL_ACCOUNT_LIST, $this->_query);
	}
	
	/**
	 * Returns list of account
	 *
	 * @param string|integer Unique id of an account 
	 * @return array
	 */
	public function getDetail($id) {
		//Argument 1 must be an string or integer
		Eden_Context_Error::i()->argument(1, 'string', 'int');
		
		return $this->_getResponse(sprintf(self::URL_ACCOUNT, $id));
	}

	/**
	 * Add email account
	 *
	 * @param string Any Email address
	 * @param string|null Any first name
	 * @param string|null Any last name
	 * @return array
	 */
	public function addAccount($email, $fname = NULL, $lname = NULL) {
		//Argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')				//Argument 1 must be an string
			->argument(2, 'string', 'null')		//Argument 2 must be an string or null
			->argument(3, 'string', 'null');	//Argument 3 must be an string or null
		
		$this->_query['email'] 		= $email;
		$this->_query['first_name'] = $fname;
		$this->_query['last_name'] 	= $lname;

		return $this->_post(self::URL_ACCOUNT_LIST, $this->_query);
	}

	/**
	 * Remove a given account
	 *
	 * @param string|integer Unique id of an account
	 * @return array
	 */
	public function removeAccount($id) {
		//Argument 1 must be an string or integer
		Eden_Context_Error::i()->argument(1, 'string', 'int');
		
		return $this->_delete(sprintf(self::URL_ACCOUNT, $id));
	}

	/**
	 * Update a account
	 *
	 * @param string|integer Unique id of an account
	 * @param string
	 * @param string
	 * @return array
	 */
	public function updateAccount($id, $fname = NULL, $lname = NULL) {
		//Argument 1 must be an string or integer
		Eden_Context_Error::i()
			->argument(1, 'string', 'int')		//Argument 1 must be an string or integer
			->argument(2, 'string')			//Argument 2 must be an string 
			->argument(3, 'string');			//Argument 3 must be an string

		$this->_query['first_name'] = $fname;
		$this->_query['last_name'] 	= $lname;
				
		return $this->_put(sprintf(self::URL_ACCOUNT_LIST, $id), $this->_query);
	}

	/**
	 * Check email if exists
	 *
	 * @param email
	 * @return array
	 */
	public function discover($email) {
		//argument testing
		Eden_Context_Error::i()->argument(1, 'email');

		$this->_query['source_type']	= 'IMAP';
		$this->_query['email'] 			= $email;

		return $this->_getResponse(self::URL_DISCOVER, $this->_query);
	}

	/**
	 * Add source
	 *
	 * @param string
	 * @param array
	 * @return array
	 */
	public function addSource($id , $parameter) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')
			->argument(2, 'array');

		return $this->_post(sprintf(self::URL_SOURCE, $id), $parameter);
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}