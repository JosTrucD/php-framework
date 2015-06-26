<?php 
	/**
	 * @author JosT
	 * @date   Oct 2014
	 */
	class Jos_Controller
	{
		public function __construct()
		{
			session_start();
			$this->view = new Jos_View();
		}
	}
 ?>