<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class CassController extends Jos_Controller
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
			$objCass          = new Admin_Model_Cass();
			$this->view->cass = $objCass->getCass();
			$this->view->layout();
		}
		public function insertAction()
		{
			$objClass             = new Admin_Model_Class();
			$this->view->class    = $objClass->getOrderBy();
			$objCategory          = new Admin_Model_Category();
			$this->view->category = $objCategory->getCate();
			if(Jos::isPost()){
				$params = Jos::getParams();
				if($this->_checkData($params)){
					$class    = $objClass->getInfoClass($params['class']);
					$category = $objCategory->getInfo($params['category']);
					$dataInsert = array(
									'class_id'   =>$params['class'],
									'class_name' =>$class['class_name'],
									'cate_id'    =>$params['category'],
									'cate_name'  =>$category['cate_name']
						);
					$objCass = new Admin_Model_Cass();
					// Check data input with data in database
					$check  = $objCass->checkInput($params['class'],$params['category']);
					if($check > 0) {
						$this->view->error = "Class or category unable !!!";
					} else {
						$objCass->insertCass($dataInsert);
						redirect('admin/cass');
					}
				}
			}
			$this->view->layout();
		}

		public function editAction()
		{
			$params = Jos::getParams();
			$id     = $params['id'];
			$objCass = new Admin_Model_Cass();
			$this->view->cass = $objCass->getInfo($id);
			$objClass             = new Admin_Model_Class();
			$this->view->class    = $objClass->getOrderBy();
			$objCategory          = new Admin_Model_Category();
			$this->view->category = $objCategory->getOrderBy();
			if(Jos::isPost()){
				$params = Jos::getParams();
				if($this->_checkData($params)){
					$class    = $objClass->getInfoClass($params['class']);
					$category = $objCategory->getInfo($params['category']);
					$dataUpdate = array(
									'class_id'   =>$params['class'],
									'class_name' =>$class['class_name'],
									'cate_id'    =>$params['category'],
									'cate_name'  =>$category['cate_name']
								);
					// Check data input with data in database
					$check  = $objCass->checkInput($params['class'],$params['category']);
					if($check > 0) {
						$this->view->error = "Class or category unable !!!";
					} else {
						$objCass->updateCass($dataUpdate,$id);
						redirect('admin/cass');
					}
				}
			}
			$this->view->layout();

		}

		public function deleteAction()
		{
			$cass    = Jos::getParams();
			$idArr   = $cass['id'];
			$objCass = new Admin_Model_Cass();
			$objCass->deleteCass($idArr);
			redirect('admin/cass');
		}
		/**
		 * [_checkData description]
		 * @param  [type] $params [description]
		 * @return [type]         [description]
		 */
		private function _checkData($params)
		{
			$flag = true;
			if(Jos::isNull($params['class'])){
				$flag = false;
				$this->view->errorClass = "Please select class !!!";
			}
			if(Jos::isNull($params['category'])){
				$flag = false;
				$this->view->errorCategory = "Please select category !!!";
			}
			return $flag;
		}
	}
 ?>