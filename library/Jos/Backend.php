<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class Jos_Backend extends Jos_Controller
	{
		public function __construct()
		{
			parent::__construct();
			if(!isset($_SESSION['name'])) {
				redirect('admin/login');
			}
		}
	}
?>