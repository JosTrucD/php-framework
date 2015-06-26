<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/ 
	class LoginController extends Jos_Controller
	{
		public function indexAction()
		{
			$params = Jos::getParams();
			if(Jos::isPost()) {
				if($this->checkForm($params)) {
					$objUser = new Admin_Model_User();
					$username = $params['name'];
					$password = $params['password'];
					$check = $objUser->checkLogin($username, $password);
					if($check > 0) {
						$_SESSION['name'] = $username;
						redirect('admin/home');
					} else {
						$this->view->errorLogin = "User ID or Password error !!!";
					}
				}
			}
			$this->view->layout();
		}
		private function checkForm($params = array())
		{
			$flag = true;
			if(!isset($params['name']) || $params['name'] == null){
				$this->view->errorName = "Name not null !!!";
				$flag = false;
			} else if(strlen($params['name']) < 3){
				$this->view->errorName = "Username not be less than three characters !!!";
				$flag = false;
			}
			if(!isset($params['password']) || $params['password'] == null){
				$this->view->errorPassword = "Password not null !!!";
				$flag = false;
			}
			return $flag;
		}	
		public function logoutAction()
		{
			session_destroy();
			redirect("admin/login");
		}
	}
 ?>