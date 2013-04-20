<?php //-->
/*
 * This file is part a custom application package.
 */
 
require_once dirname(__FILE__).'/eden.php';

/**
 * The starting point of every application call. If you are only
 * using the framework you can rename this function to whatever you
 * like.
 *
 */
function front() {
	$class = Front::i();
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
class Front extends Eden {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_database 	= NULL;
	protected $_cache		= NULL;
	protected $_registry	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function __toString() {
		try {
			$response = (string) $this->registry()->get('response');
		} catch(Exception $e) {
			Eden_Error_Event::i()->exceptionHandler($e);
			$response = '';
		}
		
		return $response;
	}
	
	public function __construct() {
		parent::__construct();
		$this->_root = dirname(__FILE__);
		
		$this->setLoader();
		
		$this->_registry = Eden_Registry::i();
	}
	
	/* Bootstrap Methods
	-------------------------------*/
	/**
	 * Sets up the default database connection
	 *
	 * @return this
	 */
	public function setDatabases() {
		$databases 	= $this->config('databases');
		
		foreach($databases as $key => $info) {	
			//connect to the data as described in the config
			switch($info['type']) {
				case 'postgre':
					$database = Eden_Postgre::i(
						$info['host'], 
						$info['name'], 
						$info['user'], 
						$info['pass']);
					break;
				case 'mysql':
					$database = Eden_Mysql::i(
						$info['host'], 
						$info['name'], 
						$info['user'], 
						$info['pass']);
					break;
				case 'sqlite':
					$database = Eden_Sqlite::i($info['file']);
					break;
			}
			
			$this->registry()->set('database', $key, $database);
			
			if($info['default']) {
				$this->_database = $database;
			}
		}
		
		return $this;
	}
	
	/**
	 * Lets the framework handle exceptions.
	 * This is useful in the case that you 
	 * use this framework on a server with
	 * no xdebug installed.
	 *
	 * @param string|null the error type to report
	 * @param bool|null true will turn debug on
	 * @return this
	 */
	public function setDebug($reporting = NULL, $default = NULL) {
		Eden_Error::i()->argument(1, 'int', 'null')->argument(2, 'bool', 'null');
		
		Eden_Loader::i()
			->load('Eden_Template')
			->Eden_Error_Event()
			->when(!is_null($reporting), 1)
			->setReporting($reporting)
			->when($default === true, 4)
			->setErrorHandler()
			->setExceptionHandler()
			->listen('error', $this, 'error')
			->listen('exception', $this, 'error')
			->when($default === false, 4)
			->releaseErrorHandler()
			->releaseExceptionHandler()
			->unlisten('error', $this, 'error')
			->unlisten('exception', $this, 'error');
		
		return $this;
	}
	
	/**
	 * Starts filters. Filters will handle when to run.
	 *
	 * @param string|array handlers
	 * @return Eden_Application
	 */
	public function setFilters() {
		$filters 	= $this->config('filters');
		
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
	
	/**
	 * Sets the application absolute paths
	 * for later referencing
	 * 
	 * @return this
	 */
	public function setPaths() {
		$this->registry()
			->set('path', 'root', 		$this->_root)
			->set('path', 'module', 	$this->_root.'/module')
			->set('path', 'config', 	$this->_root.'/config')
			->set('path', 'theme', 		$this->_root.'/theme')
			->set('path', 'page', 		$this->_root.'/front/page')
			->set('path', 'library', 	$this->_root.'/library')
			->set('path', 'web', 		$this->_root.'/web');
		
		return $this;
	}
	
	/**
	 * Sets request
	 *
	 * @return this
	 */
	public function setRequest() {
		$path = $_SERVER['REQUEST_URI'];
		if(strpos($path, '?') !== false) {
			list($path, $tmp) = explode('?', $path, 2);
		}
		
		$array 		= explode('/',  $path);
		$pages 		= $this->config('pages');
		$variables 	= array();
		
		$page = NULL;
		foreach($pages as $pattern => $class) {
			$regex = '#'.str_replace('*', '.*', $pattern).'#';
			if(preg_match($regex, $path) && strlen($pattern) >= strlen($page)) {
				$page 		= $class;
				$variables 	= $this->_getVariables($path, $pattern);
			}
		}
		
		if(!$page) { 
			$buffer = $array;
			
			while(count($buffer) > 1) {
				$parts = ucwords(implode(' ', $buffer)); 
				$class = 'Front_Page'.str_replace(' ', '_', $parts);
				if(class_exists($class)) {
					$page = $class;
					break;
				}
				
				$variable = array_pop($buffer);
				array_unshift($variables, $variable);
			}
		}
		
		$path = array(
			'string' 	=> $path, 
			'array' 	=> $array,
			'variables'	=> $variables);
		
		//set the request
		$this->registry()
			->set('server', $_SERVER)
			->set('cookie', $_COOKIE)
			->set('get', $_GET)
			->set('post', $_POST)
			->set('files', $_FILES)
			->set('request', $path)
			->set('page', $page);
		
		return $this;
	}
	
	/**
	 * Sets response
	 *
	 * @param EdenRegistry|null the request object
	 * @return this
	 */
	public function setResponse($default) {
		$page = $this->registry()->get('page');
		
		if(!$page || !class_exists($page)) {
			$page = $default;
		}
		
		//set the response data
		$response = $this->$page();
		
		$this->registry()->set('response', $response);
		
		return $this;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the default database instance
	 *
	 * @return Eden_Database_Abstract
	 */
	public function database($key = NULL) {
		if(is_null($key)) {
			//return the default database
			return $this->_database;
		}
		
		return $this->registry()->get('database', $key);
	}
	
	/**
	 * Returns the current Registry
	 *
	 * @return Eden_Registry
	 */
	public function registry() {
		return $this->_registry;
	}
	
	/**
	 * Returns or saves the config 
	 * data given the key
	 *
	 * @param string
	 * @return array
	 */
	public function config($key, array $data = NULL) {
		$path = $this->path('config');
		$file = $this->Eden_File($path.'/'.$key.'.php');
		if(is_array($data)) {
			$file->setData($data);
			return $this;
		}
		
		if(!file_exists($file)) {
			return array();
		}
		
		return $file->getData();
	}
	
	/**
	 * Returns the absolute path 
	 * given the key
	 *
	 * @param string
	 * @return string
	 */
	public function path($key) {
		return $this->registry()->get('path', $key);
	}
	
	/**
	 * Outputs anything
	 *
	 * @param *variable any data
	 * @return Eden_Tool
	 */
	public function output($variable) {
		$this->Eden_Debug()->output($variable);
		return $this;
	}
	
	/**
	 * Returns the template loaded with specified data
	 *
	 * @param array
	 * @return Eden_Template
	 */
	public function template($file, array $data = array()) {
		Front_Error::i()->argument(1, 'string');
		return Eden_Template::i()->set($data)->parsePhp($file);
	}
	
	/**
	 * Error trigger output
	 *
	 * @return void
	 */
	public function error($error, $event, $type, $level, 
		$class, $file, $line, $message, $trace, $offset) {
		$history = array();
		for(; isset($trace[$offset]); $offset++) {
			$row = $trace[$offset];
			 
			//lets formulate the method
			$method = $row['function'].'()';
			if(isset($row['class'])) {
				$method = $row['class'].'->'.$method;
			}
			 
			$rowLine = isset($row['line']) ? $row['line'] : 'N/A';
			$rowFile = isset($row['file']) ? $row['file'] : 'Virtual Call';
			 
			//add to history
			$history[] = array($method, $rowFile, $rowLine);
		}
		 
		echo Eden_Template::i()
			->set('history', $history)
			->set('type', $type)
			->set('level', $level)
			->set('class', $class)
			->set('file', $file)
			->set('line', $line)
			->set('message', $message)
			->parsePhp(dirname(__FILE__).'/front/error.phtml');
	}
	
	/**
	 * Returns the time passed relative to now
	 *
	 * @param string|int
	 * @param string
	 * @return string
	 */
	public function since($time, $format = 'F d, Y g:ia') {
		if(is_string($time)) {
			$time = strtotime($time);
		}
		
		$time = time() - $time; // to get the time since that moment
	
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);
	
		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
		}
		
		return 'now';
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getVariables($path, $pattern) {
		$variables 			= array();
		
		//if the request path equals /
		if($path == '/') {
			//there would be no page variables
			return array();
		}
		
		//get the arrays
		$pathArray 		= explode('/', $path);
		$patternArray 	= explode('/', $pattern);
		
		//we do not need the first path because
		// /page/1 is [null,page,1] in an array
		array_shift($pathArray);
		array_shift($patternArray);
		
		//for each request path
		foreach($pathArray as $i => $value) {
			//if the page path is not set, is null or is '%'
			if(!isset($patternArray[$i]) 
				|| trim($patternArray[$i]) == NULL 
				|| $patternArray[$i] == '*') {
				//then we can assume it's a variable
				$variables[] = $pathArray[$i];
			}
		}
		
		return $variables;
	}
	
	/* Private Methods
	-------------------------------*/
}
