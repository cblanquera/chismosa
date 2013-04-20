<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * The base class for any class that defines a view.
 * A view controls how templates are loaded as well as 
 * being the final point where data manipulation can occur.
 *
 * @package    Eden
 */
abstract class Front_Page extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta	= array();
	protected $_head 	= array();
	protected $_body 	= array();
	protected $_foot 	= array();
	
	protected $_title 		= NULL;
	protected $_class 		= NULL;
	protected $_template 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __toString() {
		try {
			$output = $this->render();
		} catch(Exception $e) {
			Eden_Error_Event::i()->exceptionHandler($e);
			return '';
		}
		
		if(is_null($output)) {
			return '';
		}
		
		return $output;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a string rendered version of the output
	 *
	 * @return string
	 */
	abstract public function render();
	
	/* Protected Methods
	-------------------------------*/
	protected function _page() {
		if(isset($_SESSION['fb_user'])) {
			$this->_head['user'] = front()->database()
			->getModel('user', 'user_facebook', $_SESSION['fb_user']);
		}
		
		$this->_head['page'] = $this->_class;
		
		$page = front()->path('page');
		$head = front()->trigger('head')->template($page.'/_head.phtml', $this->_head);
		$body = front()->trigger('body')->template($page.$this->_template, $this->_body);
		$foot = front()->trigger('foot')->template($page.'/_foot.phtml', $this->_foot);
		
		//page
		return front()->template($page.'/_page.phtml', array(
			'meta' 			=> $this->_meta,
			'title'			=> $this->_title,
			'class'			=> $this->_class,
			'head'			=> $head,
			'body'			=> $body,
			'foot'			=> $foot));
	}
	
	/* Private Methods
	-------------------------------*/
}