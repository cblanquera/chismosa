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
class Eden_Multiply_Post extends Eden_Multiply_Base {
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
	 * Read the inbox
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function editAlbum($type, $key, $subject, $body, $tags = 'csv', $acl = 'everyone', $replies = '0/1',
					$orders = '1/1', $messageBoard = '1/1', $cpFacebook = 1, $cpTwitter = 1, $save = NULL) {
		Eden_Multiply_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string')		//Argument 2 must be string
			->argument(3, 'string')		//Argument 3 must be string
			->argument(4, 'string');	//Argument 4 must be string
			
		$this->_query['type']				= $type;
		$this->_query['item_key']			= $key;
		$this->_query['subject']			= $subject;
		$this->_query['body']				= $body;
		$this->_query['tags']				= $tags;
		$this->_query['acl']				= $acl;
		$this->_query['no_replies']			= $replies;
		$this->_query['no_orders']			= $orders;
		$this->_query['no_message_board']	= $messageBoard;
		$this->_query['cp_facebook']		= $cpFacebook;
		$this->_query['cp_twitter']			= $cpTwitter;
		$this->_query['save']				= $save;
		
		return $this->_post(sprintf(self::URL_POST, $this->_domain), $this->_query);
	}
	
	/**
	 * Read the inbox
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param bool
	 * @return array
	 */
	public function postPhotos($key, $photo, $subject, $body, $media = false) {
		Eden_Multiply_Error::i()
			->argument(1, 'string')	//Argument 1 must be string
			->argument(2, 'string')	//Argument 2 must be string
			->argument(3, 'string')	//Argument 3 must be string
			->argument(4, 'string')	//Argument 4 must be string
			->argument(5, 'bool');	//Argument 5 must be an boolean
		
		$this->_query['type']				= 'photos';	
		$this->_query['item_key']			= $key;
		$this->_query['photoN']				= $photo;
		$this->_query['photoN_subject']		= $subject;
		$this->_query['photoN_body']		= $body;
		$this->_query['to_media_locker']	= $media;
		
		return $this->_post(sprintf(self::URL_POST, $this->_domain), $this->_query);
	}
	
	/**
	 * Read the inbox
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function postVideo($id, $video, $subject, $body) {
		Eden_Multiply_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string')		//Argument 2 must be string
			->argument(3, 'string')		//Argument 3 must be string
			->argument(4, 'string');	//Argument 4 must be string
		
		$this->_query['type']		= 'video';
		$this->_query['video_id']	= $id;
		$this->_query['video']		= $video;
		$this->_query['subject']	= $subject;
		$this->_query['body']		= $body;
		
		return $this->_post(sprintf(self::URL_POST, $this->_domain), $this->_query);
	}
	
	/**
	 * Post Notes
	 *
	 * @param string
	 * @return array
	 */
	public function postNotes($subject) {
		//Argument 1 must be string
		Eden_Multiply_Error::i()->argument(1, 'string');	
		
		$this->_query['type']		= 'notes';
		$this->_query['subject']	= $subject;
		
		return $this->_post(sprintf(self::URL_POST, $this->_domain), $this->_query);
	}
	
	/**
	 * Post Notes
	 *
	 * @param string
	 * @return array
	 */
	public function postJournal($subject) {
		//Argument 1 must be string
		Eden_Multiply_Error::i()->argument(1, 'string');	
		
		$this->_query['type']		= 'journal';
		$this->_query['subject']	= $subject;
		
		return $this->_post(sprintf(self::URL_POST, $this->_domain), $this->_query);
	}
	
	/**
	 * Post a reply
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function postReply($key, $body) {
		Eden_Multiply_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		$this->_query['item_key']	= $key;
		$this->_query['body']		= $body;
		
		return $this->_post(sprintf(self::URL_REPLY, $this->_domain), $this->_query);
	}
	
	/**
	 * Get a user's profile
	 *
	 * @return array
	 */
	public function getProfile() {
		return $this->_getResponse(sprintf(self::URL_USER_PROFILE, $this->_domain), $this->_query);
	}
	
	/**
	 * Read the inbox
	 *
	 * @param string
	 * @param integer
	 * @return array
	 */
	public function getInbox($filter, $start = 0) {
		Eden_Multiply_Error::i()
			->argument(1, 'string')	//Argument 1 must be string
			->argument(2, 'int');	//Argument 2 must be an integer
			
		$this->_query['filter']	= $filter;
		$this->_query['start']	= $start;
		
		return $this->_getResponse(sprintf(self::URL_READ_INBOX, $this->_domain), $this->_query);
	}
	
	/**
	 * Get inbox filters
	 *
	 * @return array
	 */
	public function getFilter() {
		return $this->_getResponse(sprintf(self::URL_FILTER_INBOX, $this->_domain));
	}
	
	/**
	 * Get a list of contacts
	 *
	 * @return array
	 */
	public function getContacts() {
		return $this->_getResponse(sprintf(self::URL_GET_CONTACTS, $this->_domain), $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/	 
}



