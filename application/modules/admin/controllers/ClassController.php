<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class ClassController extends Jos_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			if(!$_SESSION['name']){
				redirect('admin/login');
			}
		}
		/**
		 * [indexAction description]
		 * @return [type] [description]
		 */
		public function indexAction()
		{
			$objClass = new Admin_Model_Class();
			$this->view->class = $objClass->getOrderBy();
			$this->view->layout();
		}
		/**
		 * [insertAction description]
		 * @return [type] [description]
		 */
		public function insertAction()
		{
			$objClass = new Admin_Model_Class();
			if(Jos::isPost()){
				$params = Jos::getParams();
				// check data input
				if($this->checkData($params)){
					$dataInsert = array(
									'class_name'    => $params['name'],
									'class_rewrite' => $params['rewrite'],
									'class_status'  => $params['status']
						);
					// Check data input with data in database
					$check = $objClass->checkInput($params['name']);
					if($check > 0){
						$this->view->errorName = "Class unable !!!";
					} else {
						$objClass->insertClass($dataInsert);
						redirect('admin/class');
					}
				}
			}
			$this->view->layout();
		}
		/**
		 * [editAction description]
		 * @return [type] [description]
		 */
		public function editAction()
		{
			$objClass = new Admin_Model_Class();
			$class = Jos::getParams();
			$id = $class['id'];
			$this->view->infoClass = $objClass->getInfoClass($id);
			if(Jos::isPost()){
				$params = Jos::getParams();
				// check data input
				if($this->checkData($params)){
					$dataUpdate = array(
									'class_name'    => $params['name'],
									'class_rewrite' => $params['rewrite'],
									'class_status'  => $params['status']
						);
					// Check data input with data in database
					$check = $objClass->checkInput($params['name']);
					if($check > 0){
						$this->view->errorName = "Class unable !!!";
					} else {
						$objClass->editClass($dataUpdate,$id);
						redirect('admin/class');
					}
				}
			}
			$this->view->layout();
		}

		public function deleteAction()
		{
			$class = Jos::getParams();
			$idArr = $class['id'];
			$objClass = new Admin_Model_Class();
			$objClass->deleteClass($idArr);
			redirect('admin/class');
		}
		/**
		 * [checkData description]
		 * @param  [type] $params [description]
		 * @return [type]         [description]
		 */
		private function checkData($params)
		{
			$flag = true;
			if(Jos::isNull($params['name'])){
				$flag = false;
				$this->view->errorName = "Please enter class name !!!";
			}
			if(Jos::isNull($params['rewrite'])){
				$flag = false;
				$this->view->errorRewrite = "Please enter class rewrite !!!";
			}
			return $flag;
		}
	}
 ?>