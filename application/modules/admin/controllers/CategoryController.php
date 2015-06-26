<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class CategoryController extends Jos_Controller
	{
		protected $objCategory;

		public function __construct()
		{
			parent::__construct();
			if(!$_SESSION['name']){
				redirect('admin/login');
			}
			$this->objCategory = new Admin_Model_Category();

		}
		public function indexAction()
		{
			$this->view->category = $this->objCategory->getCate();
			$this->view->layout();
		}
		/**
		 * Insert Category
		 */
		public function insertAction()
		{
			if(Jos::isPost()){
				$params = Jos::getParams();
				if($this->checkData($params)){
					$dataInsert = array(
									'cate_name'        => $params['name'],
									'cate_title'       => $params['title'],
									'cate_metakeyword' => $params['keyword'],
									'cate_status'      => $params['status'],
									'cate_rewrite'     => $params['rewrite']
						);
					$objCategory = new Admin_Model_Category();
					$check       = $objCategory->checkInput($params['name']);
					if($check > 0){
						$this->view->errorCateName = "Category unable !!!";
					} else {
						$objCategory->insertCate($dataInsert);
						redirect('admin/category');
					}
				}
			}
			$this->view->layout();
		}
		/**
		 * Edit Category
		 */
		public function editAction()
		{
			$category = Jos::getParams();
			$id       = $category['id'];
			$objCategory              = new Admin_Model_Category();
			$this->view->infoCategory = $objCategory->getInfo($id);
			if(Jos::isPost()){
				$params = Jos::getParams();
				if($this->checkData($params)){
					$dataUpdate = array(
									'cate_name'        => $params['name'],
									'cate_title'       => $params['title'],
									'cate_metakeyword' => $params['keyword'],
									'cate_status'      => $params['status'],
									'cate_rewrite'     => $params['rewrite']
						);
					$objCategory->updateCate($dataUpdate,$id);
					redirect('admin/category');
				}
			}
			$this->view->layout();
		}
		/**
		 * Delete Category
		 */
		public function deleteAction()
		{
			$category    = Jos::getParams();
			$idArr       = $category['id'];
			$objCategory = new Admin_Model_Category();
			$objCategory->deleteCate($idArr);
			redirect('admin/category');
		}
		/**
		 * Check Data
		 */
		private function checkData($params)
		{
			$flag = true;
			if(Jos::isNull($params['name'])){
				$flag = false;
				$this->view->errorCateName = "Please enter category name !!!";
			}
			if(Jos::isNull($params['title'])){
				$flag = false;
				$this->view->errorCateTitle = "Please enter category title !!!";
			}
			if(Jos::isNull($params['keyword'])){
				$flag = false;
				$this->view->errorCateKeyword = "Please enter category meta keyword !!!";
			}
			if(Jos::isNull($params['rewrite'])){
				$flag = false;
				$this->view->errorCateRewrite = "Please enter category rewrite !!!";
			}
			return $flag;
		}
	}
?>