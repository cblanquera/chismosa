<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
 
require_once dirname(__FILE__).'/eden.php';

/**
 * The starting point of every application call. If you are only
 * using the framework you can rename this function to whatever you
 * like.
 *
 */
function assets() {
	$class = Assets::i();
	if(func_num_args() == 0) {
		return $class;
	}
	
	$args = func_get_args();
	return $class->__invoke($args);
}

/**
 * Defines the starting point of every site call.
 * Starts laying out how classes and methods are handled.
 *
 * @package    Eden
 * @category   site
 */
class Assets extends Eden {
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
		return self::_getSingleton(__CLASS__);
	}
	
	public function __construct() {
		parent::__construct();
		$this->setLoader();
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * returns the response
	 *
	 * @param EdenRegistry|null the request object
	 * @return string
	 */
	public function getResponse(Eden_Registry $request = NULL) {
		//get assets
		$path = $_SERVER['REQUEST_URI'];
		if(strpos($path, '?') !== false) {
			list($path, $tmp) = explode('?', $path, 2);
		}
		
		$path = '/'.substr($path, 7);
		$root = realpath(dirname(__FILE__));
		$file 	= $this->Eden_File($root.$path);
		$ext 	= $file->getExtension();
		
		//do not accept php, phtml
		if(in_array($ext, array('php', 'phtml')) || !$file->isFile()) {
			header("HTTP/1.0 404 Not Found");
			return 'We cannot find your file.';
		}
		
		switch($ext) {
			case 'css':
				$mime = 'text/css';
				break;
			case 'js':
				$mime = 'text/javascript';
				break;
			case 'png':
				$mime = 'image/png';
				break;
			case 'gif':
				$mime = 'image/gif';
				break;
			case 'jpg':
			case 'jpeg':
				$mime = 'image/jpeg';
				break;
			case 'woff':
				$mime = 'application/x-font-woff';
				break;
			case 'eot':
				$mime = 'application/vnd.ms-fontobject';
				break;
			case 'ttf':
			case 'otf':
				$mime = 'application/octet-stream';
				break;
			case 'svg':
				$mime = 'image/svg+xml';
				break;
			default: 
				$mime = $file->getMime();
				break;
		}
		
		header('Content-Type: '.$mime);
		
		return $file->getContent();
	}
	
	/**
	 * Starts filters. Filters will handle when to run.
	 *
	 * @param string|array handlers
	 * @return Eden_Application
	 */
	public function setFilters() {
		$config 	= dirname(__FILE__).'/config';
		$filters 	= include($config.'/filters.php');
		
		//for each handler as class
		foreach($filters as $class) {
			//try to
			try {
				//instantiate the class
				$this->$class($this);
			//when there's an error do nothing
			} catch(Exception $e){}
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
