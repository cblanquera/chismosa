<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Login extends Front_Page {
	/* Constants
	-------------------------------*/
	const KEY 		= '475008209211480';
	const SECRET 	= '66cbf3afe9c6386bee27253489fb42eb';
	const REDIRECT	= 'http://phpsummit.project.dev/login';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Chismosa.ph';
	protected $_class = 'home';
	protected $_template = '/login.phtml';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		//get auth
		$auth = eden('facebook')->auth(self::KEY, self::SECRET, self::REDIRECT);
		 
		//if no code and no session
		if(!isset($_GET['code']) && !isset($_SESSION['fb_token'])) {
			//redirect to login
			$login = $auth->getLoginUrl();
			 
			header('Location: '.$login);
			exit;
		}
		 
		//Code is returned back from facebook
		if(isset($_GET['code'])) {
			//save it to session
			$access = $auth->getAccess($_GET['code']);
			$_SESSION['fb_token'] = $access['access_token'];
			
			//get user from facebook
			
			//get picture from facebook
			
			//save to database
		}
		
		header('Location: /');
		exit;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/*
			$info = eden('facebook')
				->graph($_SESSION['fb_token'])
				->getUser();
				
			$image = eden('facebook')
				->graph($_SESSION['fb_token'])
				->getPictureUrl();	
			
			front()
				->database()
				->getModel('user', 'user_facebook', $_SESSION['fb_token'])
				->setUserClue(substr($info['name'], 0, 1).'***'.substr($info['name'], -1, 1))
				->setUserImage($image)
				->setUserFacebook($info['id'])
				->setUserCreated(time())
				->setUserUpdated(time())
				->formatTime('user_created')
				->formatTime('user_updated')
				->save('user');
*/
