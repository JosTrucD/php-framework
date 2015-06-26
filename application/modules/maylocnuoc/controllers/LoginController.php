<?php 
	/**
	* 
	*/
	class LoginController extends Jos_Controller
	{
		
		function __construct()
		{
			parent::__construct();
		}
		public function indexAction()
		{
			$this->view->layout();
		}
	}
 ?>