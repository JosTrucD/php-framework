<?php 
	/**
	* 
	*/
	class HomeController extends Jos_Controller
	{
		
		function __construct()
		{
			parent::__construct();
		}

		public function indexAction()
		{
			$objSlider  = new Admin_Model_Slider();
			$this->view->data['title']  = "Đại lý máy lọc nước | Cung cấp các loại máy lọc nước"; 
			$this->view->data['slider'] = $objSlider->listSlider(0,4);
			$objProduct = new Admin_Model_Product();
			$this->view->data['product'] = $objProduct->listProduct(0,9);
			$this->view->layout();
		}

		public function detailAction()
		{
			$params = Jos::getParams();
			$objProduct = new Admin_Model_Product();
			$this->view->data['product'] = $objProduct->getInfo($params['id']);
			$this->view->data['title']   = $this->view->data['product']['pro_title'];
			$objSlider = new Admin_Model_Slider();
			$this->view->data['slider']  = $objSlider->listSlider(0,4);
			$this->view->layout();
		}
	}
 ?>