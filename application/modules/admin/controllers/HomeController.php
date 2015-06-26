<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class HomeController extends Jos_Controller
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
			$this->view->layout();
		}
	}
 ?>