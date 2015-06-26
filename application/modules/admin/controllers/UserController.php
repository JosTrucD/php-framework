<?php 
	/**
	* @author JosT
	* @date   2014
	*/
	class UserController extends Jos_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			if(!$_SESSION['name']){
				redirect('admin/login');
			}
		}
		public function indexAction()
		{
			$objUser = new Admin_Model_User();
			$this->view->user = $objUser->getOrderBy();
			$this->view->layout();
		}
		public function insertAction()
		{
			$this->view->layout();
		}
		public function deleteAction()
		{

		}
	}
 ?>