<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Context IO Files
 *
 * @package    Eden
 * @category   context
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Context_File extends Eden_Context_Base {
	/* Constants
	-------------------------------*/
	const URL_FILES			= 'https://api.context.io/2.0/accounts/%s/files';
	const URL_FILES_DETAIL	= 'https://api.context.io/2.0/accounts/%s/files/%s';
	const URL_FILES_CONTENT	= 'https://api.context.io/2.0/accounts/%s/files/%s/content';
	const URL_FILES_CHANGES	= 'https://api.context.io/2.0/accounts/%s/files/%s/changes';
	const URL_FILES_INTANCE	= 'https://api.context.io/2.0/accounts/%s/files/%s/changes/%s';
	const URL_FILES_REVISION	= 'https://api.context.io/2.0/accounts/%s/files/%s/revisions';

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
	 * Search file name
	 *
	 * @param string File name
	 * @return this
	 */
	public function search($fileName) {
		//Argument 1 must be an integer
		Eden_Context_Error::i()->argument(1, 'string');	
		
		$this->_query['file_name'] = $fileName;

		return $this;
	}

	/**
	 * Search file name
	 *
	 * @param string Valid values are: email, to, from, cc, bcc
	 * date_before, date_after, indexed_before, indexed_after,
	 * group_by_revisions
	 * @param string File name
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
	 * Returns list of files
	 *
	 * @param string|integer Unique id of an account accessible
	 * @param bool sort bu ascending
	 * @param integer The maximum number of results to return
	 * @param integer Start the list at this offset
	 * @return array
	 */
	public function getList($id, $ascending = true, $limit = 0, $offset = 0) {
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


		return $this->_getResponse(sprintf(self::URL_FILES, $id), $this->_query);
	}
	
	/**
	 * Return detail information of files on contact
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getDetail($id, $fileId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')	//Argument 1 must be an string
			->argument(2, 'string');	//Argument 2 must be an string
		
		return $this->_getResponse(sprintf(self::URL_FILES_DETAIL, $id, $fileId));
	}

	/**
	 * Return listing of files that can be compared with a given file
	 *
	 * @param string|integer Unique id of an account
	 * @param string
	 * @return array
	 */
	public function getChangesList($id, $fileId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')	//Argument 1 must be an string
			->argument(2, 'string');	//Argument 2 must be an string

		return $this->_getResponse(sprintf(self::URL_FILES_CHANGES, $id, $fileId));
	}

    /**
     * Return the content of the file or a link
     *
     * @param string|integer Unique id of an account
     * @param string
     * @return array
     */
    public function getContent($id, $fileId, $asLink = null) {
        //argument testing
        Eden_Context_Error::i()
            ->argument(1, 'string')	//Argument 1 must be an string
            ->argument(2, 'string');	//Argument 2 must be an string

        if($asLink) {
            $this->_query['as_link'] = 1;
        }


        return $this->_getResponse(sprintf(self::URL_FILES_CONTENT, $id, $fileId), $this->_query);
    }

	/**
	 * Return the list of changes made from the oldest of the 
	 * two files to the newest one.
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getChangesInstanceList($id, $id2, $fileId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be an string
			->argument(2, 'string')		//Argument 2 must be an string
			->argument(3, 'string');	//Argument 3 must be an string
		
		return $this->_getResponse(sprintf(self::URL_FILES_INTANCE, $id, $fileId));
	}

	/**
	 * Returns a list of revisions attached to other emails in the 
	 * mailbox for a given file.
	 *
	 * @param string|integer Unique id of an account
	 * @param string 
	 * @return array
	 */
	public function getRevisionListing($id, $fileId) {
		//argument testing
		Eden_Context_Error::i()
			->argument(1, 'string')		//Argument 1 must be an string
			->argument(2, 'string');	//Argument 2 must be an string
		
		return $this->_getResponse(sprintf(self::URL_FILES_REVISION, $id, $fileId));
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}