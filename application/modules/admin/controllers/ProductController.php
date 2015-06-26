<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/ 
	class ProductController extends Jos_Controller
	{	
		function __construct()
		{
			parent::__construct();
			if(!$_SESSION['name']){
				redirect('admin/login');
			}
		}
		/**
		 * Get list product
		 */
		public function indexAction()
		{
			$objProduct = new Admin_Model_Product();
			$this->view->product = $objProduct->getOrderBy();
			$this->view->layout();
		}
		/**
		 * Insert product
		 */
		public function insertAction()
		{
			$objCategory = new Admin_Model_Category();
			$this->view->category = $objCategory->getOrderBy();
			if  (Jos::isPost()) {
				$params = Jos::getParams();
				if ($this->_check($params)) {
					$objProduct = new Admin_Model_Product();
					// Chech data input with database
					$check = $objProduct->checkInput($params['name']);
					if($check > 0){
						$this->view->errorName = "Tên sản phẩm đã tồn tại hoặc không đúng !!!";
					}else {
						$dataInsert = array(
										'pro_name'             => $params['name'],
										'pro_price'            => $params['price'],
										'pro_status'           => $params['status'],
										'pro_information'      => $params['information'],
										'pro_rewrite'          => $params['rewrite'],
										'pro_title'            => $params['title'],
										'pro_url_rewrite'      => $params['url_rewrite'],
										'pro_meta_keyword'     => $params['keyword'],
										'pro_meta_description' => $params['meta_description'],
										'pro_date'             => date('d-m-Y')
											);
						$objProduct->insertProduct($dataInsert);
						// Lấy ra sản phẩm có name = $params['name'] vừa thêm vào.
						$product = $objProduct->getName($params['name']);
						// Insert category product
						if (@$params['category']) {
							$objCatePro = new Admin_Model_CatePro();
							foreach ($params['category'] as $valueCate) {
								$insertCatePro[] = array(
													'cate_id' => $valueCate,
													'pro_id'  => $product['pro_id']
									);
							}
							for ($i=0; $i < count($insertCatePro); $i++) { 
								$objCatePro->insertCatePro($insertCatePro[$i]);
							}
						}
						// Upload ảnh đại diện sản phẩm.
						if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != null){
							upload("uploads/products/",$product['pro_id']);
							$avata = $_FILES['image']['name'];

							$dataUpdate = array(
											'pro_name'             => $params['name'],
											'pro_price'            => $params['price'],
											'pro_status'           => $params['status'],
											'pro_information'      => $params['information'],
											'pro_rewrite'          => $params['rewrite'],
											'pro_title'            => $params['title'],
											'pro_url_rewrite'      => $params['url_rewrite'],
											'pro_meta_keyword'     => $params['keyword'],
											'pro_meta_description' => $params['meta_description'],
										    'pro_image'            => $avata
								);
							$objProduct->updateProduct($dataUpdate,$product['pro_id']);
						}
						// Upload ảnh sản phẩm
						if ($_FILES['images']['name'][0] !=null) {
							upload_multi_file("uploads/products/images/",$product['pro_id']);
							$images = $_FILES['images']['name'];
							$objImage = new Admin_Model_Image();
							foreach ($images as $valueImages) {
								$insertImage[] = array(
													'pro_id' => $product['pro_id'],		
													'image' => $valueImages		
									); 
							}
							for ($i=0; $i < count($insertImage); $i++) { 
								$objImage->insertImage($insertImage[$i]);
							}
						}
						redirect('admin/product');
					}
				}
			}
			$this->view->layout();
		}

		public function editAction()
		{
			$params = Jos::getParams();
			$id     = $params['id'];
			// Lấy sản phẩm cần sửa
			$objProduct = new Admin_Model_Product();
			$this->view->product = $objProduct->getInfo($id);
			// Get category checked
			$objCatePro = new Admin_Model_CatePro();
			$this->view->catePro = $objCatePro->getPro($id);
			// Get categories
			$objCategory = new Admin_Model_Category();
			$this->view->category = $objCategory->getOrderBy();
			// Get images product
			$objImage = new Admin_Model_Image();
			$this->view->image = $objImage->getPro($id);

			if(Jos::isPost()){
				if($this->_check($params)){
					// Upload ảnh đại diện sản phẩm.
					if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != null){
						upload("uploads/products/",$id);
						$avata = $_FILES['image']['name'];

						$dataUpdate = array(
										'pro_name'             => $params['name'],
										'pro_price'            => $params['price'],
										'pro_status'           => $params['status'],
										'pro_information'      => $params['information'],
										'pro_rewrite'          => $params['rewrite'],
										'pro_title'            => $params['title'],
										'pro_url_rewrite'      => $params['url_rewrite'],
										'pro_meta_keyword'     => $params['keyword'],
										'pro_meta_description' => $params['meta_description'],
										'pro_date'             => date('d-m-Y')
									    'pro_image'            => $avata
									);
					} else {
						$dataUpdate = array(
										'pro_name'             => $params['name'],
										'pro_price'            => $params['price'],
										'pro_status'           => $params['status'],
										'pro_information'      => $params['information'],
										'pro_rewrite'          => $params['rewrite'],
										'pro_title'            => $params['title'],
										'pro_url_rewrite'      => $params['url_rewrite'],
										'pro_meta_keyword'     => $params['keyword'],
										'pro_meta_description' => $params['meta_description'],
										'pro_date'             => date('d-m-Y')
									);
					}
					$objProduct->updateProduct($dataUpdate,$id);
					// Update category product
					if (@$params['category']) {
						if ($this->view->catePro) {
							$cateProArr = array();
							foreach ($this->view->catePro as $valueCatePro) {
								$cateProArr[] = $valueCatePro['id'];
							}
							$objCatePro->deleteCatePro($cateProArr);
							foreach ($params['category'] as $valueCate) {
								$insertCatePro[] = array(
													'cate_id' => $valueCate,
													'pro_id'  => $id
									);
							}
							for ($i=0; $i < count($insertCatePro); $i++) { 
								$objCatePro->insertCatePro($insertCatePro[$i]);
							}
						} else {
							foreach ($params['category'] as $valueCate) {
								$insertCatePro[] = array(
													'cate_id' => $valueCate,
													'pro_id'  => $id
									);
							}
							for ($i=0; $i < count($insertCatePro); $i++) { 
								$objCatePro->insertCatePro($insertCatePro[$i]);
							}
						}
					}
					redirect('admin/product');
				}
			}
			$this->view->layout();
		}

		public function deleteAction()
		{
			if(Jos::isPost()){
				$params = Jos::getParams();
				$id = $params['id'];
				$objProduct = new Admin_Model_Product();
				// Delete product
				$objProduct->deleteProduct($id);
				// Delete multi folder
				delete_multi_folder($id,"uploads/products/");
			}
			redirect('admin/product');

		}

		/**
		 * [checkData description]
		 * @param  [type] $params [description]
		 * @return [type]         [description]
		 */
		private function _check($params)
		{
			$flag = true;
			if(Jos::isNull($params['name'])){
				$flag = false;
				$this->view->errorName = "Tên sản phẩm không được bỏ trống !!!";
			}
			if(Jos::isNull($params['title'])){
				$flag = false;
				$this->view->errorTitle = "Chưa có tiêu đề !!!";
			}
			if(Jos::isNull($params['meta_description'])){
				$flag = false;
				$this->view->errorMetaDescription = "Thiếu mô tả thẻ meta !!!";
			}
			if(Jos::isNull($params['keyword'])){
				$flag = false;
				$this->view->errorKeyword = "Chưa có từ khóa thẻ meta !!!";
			}
			if(Jos::isNull($params['url_rewrite'])){
				$flag = false;
				$this->view->errorUrl = "Thiếu viết lại đường dẫn !!!";
			}
			if(Jos::isNull($params['price'])){
				$flag = false;
				$this->view->errorPrice = "Chưa nhập giá sản phẩm !!!";
			}
			if(Jos::isNull($params['information'])){
				$flag = false;
				$this->view->errorInformation = "Thiếu thông tin sản phẩm !!!";
			}
			if(Jos::isNull($params['rewrite'])){
				$flag = false;
				$this->view->errorRewrite = "Chưa có bài viết cho sản phẩm !!!";
			}
			return $flag;
		}
	}
 ?>