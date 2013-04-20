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
class Eden_Context_Folder extends Eden_Context_Base {
	/* Constants
	-------------------------------*/
	const URL_FOLDERS = 'https://api.context.io/2.0/accounts/%s/sources/%s/folders';
	const URL_FOLDER  = 'https://api.context.io/2.0/accounts/%s/sources/%s/folders/%s';
	const URL_FOLDER_MESSAGES  = 'https://api.context.io/2.0/accounts/%s/sources/%s/folders/%s/messages';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
    protected $_label   = 0;
    protected $_id      = null;

	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}

    public function __construct($consumerKey, $consumerSecret, $id) {
        //argument test
        Eden_Twitter_Error::i()
            ->argument(1, 'string')		//Argument 1 must be a string
            ->argument(2, 'string')	//Argument 2 must be a string
            ->argument(3, 'string');	//Argument 2 must be a string

        $this->_consumerKey 	= $consumerKey;
        $this->_consumerSecret 	= $consumerSecret;
        $this->_id 	= $id;
    }

	/* Public Methods
	-------------------------------*/ 
	/**
	 * Returns email folder
	 *
	 * @param string
	 * @param integer|string
	 * @return array
	 */
	public function getFolders() {
		return $this->_getResponse(sprintf(self::URL_FOLDERS, $this->_id, $this->_label));
	}

    public function getFolder($folder) {
        //Argument testing
        Eden_Context_Error::i()
            ->argument(1, 'string');			//Argument 1 must be an String

        $url = sprintf(self::URL_FOLDER, $this->_id, $this->_label, $folder);

        return $this->_getResponse($url, $this->_query);
    }

    public function includeExtendedCounts() {
        $this->_query['include_extended_counts'] = 1;

        return $this;
    }

    public function getMessages($folder, $ascending = true ,$limit = 0, $offset = 0) {
        //Argument testing
        Eden_Context_Error::i()
            ->argument(1, 'string')	        //Argument 1 must be a string
            ->argument(2, 'bool')			//Argument 2 must be a boolean
            ->argument(3, 'int')			//Argument 3 must be an integer
            ->argument(4, 'int');			//Argument 4 must be an integer

        if($ascending) {
            $this->_query['sort_order'] = 'asc';
        } else {
            $this->_query['sort_order'] = 'desc';
        }

        $this->_query['limit'] 		= $limit;
        $this->_query['offset'] 	= $offset;

        $url = sprintf(self::URL_FOLDER_MESSAGES, $this->_id, $this->_label, $folder);

        return $this->_getResponse($url, $this->_query);
    }

    public function setLabel($label) {
        //Argument testing
        Eden_Context_Error::i()
            ->argument(1, 'string', 'int'); //Argument 1 must be a string or integer

        $this->_label = $label;

        return $this;
    }

    public function setId($id) {
        //Argument testing
        Eden_Context_Error::i()
            ->argument(1, 'string'); //Argument 1 must be a string

        $this->_id = $id;

        return $this;
    }

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}