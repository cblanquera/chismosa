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
class Eden_Multiply_UserContent extends Eden_Multiply_Base {
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
	 * Return the current user photos
	 *
	 * @return array
	 */
	public function photos() {
		$this->_query['type']	= 'photos';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}
	
	/**
	 * Return the current user videos
	 *
	 * @return array
	 */
	public function videos() {
		$this->_query['type']	= 'video';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}
	
	/**
	 * Return the current user music
	 *
	 * @return array
	 */
	public function music() {
		$this->_query['type']	= 'music';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}

	/**
	 * Return the current user calendar
	 *
	 * @return array
	 */
	public function calendar() {
		$this->_query['type']	= 'calendar';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}

	/**
	 * Return the current user reviews
	 *
	 * @return array
	 */
	public function reviews() {
		$this->_query['type']	= 'reviews';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}

	/**
	 * Return the current user links
	 *
	 * @return array
	 */
	public function links() {
		$this->_query['type']	= 'links';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}

	/**
	 * Return the current user market
	 *
	 * @return array
	 */
	public function market() {
		$this->_query['type']	= 'market';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}

	/**
	 * Return the current user recipes
	 *
	 * @return array
	 */
	public function recipes() {
		$this->_query['type']	= 'recipes';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}

	/**
	 * Return the current user notes
	 *
	 * @return array
	 */
	public function notes() {
		$this->_query['type']	= 'notes';
		return $this->_getResponse(sprintf(self::URL_USERCONTENT, $this->_domain), $this->_query);
	}
	
	/**
	 * Check if a photo or video exists in user's Media Locker
	 *
	 * @param string
	 * @param integer
	 * @return array
	 */
	public function checkMedia($album=NULL, $size=NULL) {
		Eden_Multiply_Error::i()
			->argument(1, 'string')	//Argument 1 must be string
			->argument(2, 'int');	//Argument 2 must be an integer
			
		$this->_query['base64_md5']	= $album;
		$this->_query['file_size']	= $size;
		return $this->_getResponse(sprintf(self::URL_EXISTS, $this->_domain), $this->_query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/	 
}



