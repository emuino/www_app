<?php

namespace emuino;

require_once __DIR__ . "/vendor/autoload.php";

class WWWLoginApp {
	
	protected $message;

	public function __construct() {
		session_start();
		if(!$this->checkAuth()) {
			sleep(3);
			$this->login();
		} else {
			$this->routing();
		}
	}
	
	protected function checkAuth() {
		return isset($_SESSION['uid']) && $_SESSION['uid'] ? $_SESSION['uid'] : false;
	}
	
	protected function login() {
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['func'] == 'login') {
			$this->doLogin();
		}
		if(!$this->checkAuth()) {
			$this->showLogin();
		} else {
			$this->routing();
		}
	}
	
	protected function doLogin() {
		// todo create a correct check for it!
		if($_POST['usr'] == 'admin' && $_POST['pwd'] == 'admin1') {
			$_SESSION['uid'] = 1;
		} else {
			session_destroy();
			$this->message = 'Login faild!';
		}
	}
	
	protected function showLogin() {
		echo '<form method="post" action="">'.
				'<input type="hidden" name="func" value="login">'.
				'<div>'.$this->message.'</div>'.
				'<input type="text" name="usr" placeholder="Name">'.
				'<input type="password" name="pwd" placeholder="Password">'.
				'<input type="submit" value="Login">'.
			'</form>'.
			'<a href="#">Forgot password</a> '.
			'<a href="#">Registry</a>';
	}
	
	protected function routing() {
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['func'] == 'logout') {
			session_destroy();
			$this->message = 'Logged out';
			$this->showLogin();
		} else {
			echo '<form method="post" action="">'.
					'<input type="hidden" name="func" value="logout">'.
					'<input type="submit" value="Logout">'.
				'</form>';
			echo '[routing here..]';
		}
	}
	
}

new WWWLoginApp();