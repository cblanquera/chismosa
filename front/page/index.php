<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Index extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Chismosa.ph';
	protected $_class = 'home';
	protected $_template = '/index.phtml';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		if(!empty($_POST)) {
			if(!isset($_SESSION['fb_user'])) {
				header('Location: /login');
				exit;	
			}
			
			//get user
			
			//save to database
			
		}
		
		//get posts
			
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/*
			$user = front()
				->database()
				->getModel('user', 'user_facebook', $_SESSION['fb_user']);
			
			//save to database
			
			front()
				->database()->model()
				->setPostDetail($_POST['message'])
				->setPostUser($user['user_id'])
				->setPostCreated(time())
				->setPostUpdated(time())
				->formatTime('post_created')
				->formatTime('post_updated')
				->save('post');
				
		$this->_body['rows'] = front()
			->database()
			->search('post')
			->innerJoinOn('user', 'post_user=user_id')
			->sortByPostCreated('DESC')
			->getRows();
*/