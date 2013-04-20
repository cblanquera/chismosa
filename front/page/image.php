<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Image extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Eden';
	protected $_class = 'home';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$id = front()->registry()->get('request', 'variables', 0);
		
		if(!is_numeric($id)) {
			header("Status: 404 Not Found");
			return 'We cannot find your image.';
		}
		
		$user = front()
			->database()
			->getRow('user', 'user_id', $id);
		
		if(!$user) {
			header("Status: 404 Not Found");
			return 'We cannot find your image.';
		}
		
		$user = file_get_contents($user['user_image']);
		
		header('Content-Type: image/jpg');
		
		return (string) eden('image', $user, 'jpg', false)
			->invert()
			->invert(true)
			->negative();
		
		
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
