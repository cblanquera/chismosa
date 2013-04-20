<?php //-->
if($_SERVER['REQUEST_URI'] == '/assets' 
	|| strpos($_SERVER['REQUEST_URI'], '/assets/') === 0
	|| strpos($_SERVER['REQUEST_URI'], '/assets?') === 0) {
	require('assets.php');
} else { 
	require('front.php'); 
}