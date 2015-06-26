<?php 
	/**
	* @author JosT
	* $date   Oct 2014
	*/
	class SliderController extends Jos_Controller
	{
		protected $objSlider;

		function __construct()
		{
			parent::__construct();
			if(!$_SESSION['name']){
				redirect('admin/login');
			}
			$this->objSlider = new Admin_Model_Slider();
		}

		public function indexAction()
		{
			$this->view->slider = $this->objSlider->listSlider();
			$this->view->layout();
		}
		public function insertAction()
		{
			if(Jos::isPost()){
				$params = Jos::getParams();
				if($this->_check($params)){
					$objSlider = new Admin_Model_Slider();
					// Check data input with data in database
					$check = $objSlider->checkInput($params['name']);
					if($check > 0){
						$this->view->errorName = "Name unable !!!";
					} else {
						$dataInsert = array(
										'name'        => $params['name'],
										'title'       => $params['title'],
										'status'      => $params['status'],
										'description' => $params['description'],
										'rewrite'     => $params['rewrite']
								);
						$objSlider->insertSlider($dataInsert);
						// Upload file
						if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != null){
							$data = $objSlider->getName($params['name']);
							// Get folder name 
							$folder = $data['id'];
							$this->_upload($folder);
							$image = $_FILES['image']['name'];

							$dataUpdate = array(
										'name'        => $params['name'],
										'title'       => $params['title'],
										'status'      => $params['status'],
										'description' => $params['description'],
										'rewrite'     => $params['rewrite'],
										'images'      => $image
									);
							$objSlider->updateSlider($dataUpdate, $folder);
						}
						redirect('admin/slider');
					}
				}
			}
			$this->view->layout();
		}

		public function editAction()
		{
			$params    = Jos::getParams();
			$id        = $params['id'];
			$objSlider = new Admin_Model_Slider();
			$this->view->slider = $objSlider->getInfo($id);

			if(Jos::isPost()){
				$params = Jos::getParams();
				if($this->_check($params)){
					// Upload file
					if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != null){
						$this->_upload($id);
						$image = $_FILES['image']['name'];

						$dataUpdate = array(
										'name'        => $params['name'],
										'title'       => $params['title'],
										'status'      => $params['status'],
										'description' => $params['description'],
										'rewrite'     => $params['rewrite'],
										'images'      => $image
								);
					} else {
						$dataUpdate = array(
										'name'        => $params['name'],
										'title'       => $params['title'],
										'status'      => $params['status'],
										'description' => $params['description'],
										'rewrite'     => $params['rewrite']
								);

					}
					$objSlider->updateSlider($dataUpdate, $id);
					redirect('admin/slider');
				}
			}
			$this->view->layout();
		}

		public function deleteAction()
		{
			if(Jos::isPost()){
				$params = Jos::getParams();
				$id = $params['id'];
				// Delete row
				$objSlider = new Admin_Model_Slider();
				$objSlider->deleteSlider($id);
				// Delete folder
				delete_multi_folder($id,"uploads/slider/");
			}
			redirect('admin/slider');
		}
		/**
		 * [_check description]
		 * @param  [type] $params [description]
		 * @return [type]         [description]
		 */
		private function _check($params)
		{
			$flag = true;
			if(Jos::isNull($params['name'])){
				$flag = false;
				$this->view->errorName = "Name not null !!!";
			}
			if(Jos::isNull($params['title'])){
				$flag = false;
				$this->view->errorTitle = "Title not null !!!";
			}
			if(Jos::isNull($params['description'])){
				$flag = false;
				$this->view->errorDescription = "Description not null !!!";
			}
			if(Jos::isNull($params['rewrite'])){
				$flag = false;
				$this->view->errorRewrite = "Rewrite not null !!!";
			}
			return $flag;
		}
		/**
		 * [_upload description]
		 * @param  string $folder [Tên thư mục sẽ tạo upload]
		 * @return [type]         [description]
		 */
		private function _upload($folder = "")
		{
			$flag = true;
			if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != null){
				// Check folder
				// Create folder
				if(!is_dir("uploads/slider/".$folder)){
					mkdir("uploads/slider/".$folder, 0770);
				} else {
					delete_folder("uploads/slider/".$folder);
					mkdir("uploads/slider/".$folder, 0770);
				}
				$path     = "uploads/slider/".$folder."/";
				$image    = $_FILES['image']['name'];
				$tmp_name = $_FILES['image']['tmp_name'];
				// Check type file image
				$type = substr($_FILES['image']['type'], 6);
				if($type == "png" || $type == "jpeg" || $type == "jpg"){
					move_uploaded_file($tmp_name, $path.$image);
				} else {
					$flag = false;
					$this->view->errorImage = "Type file not support !!!";
				}
			} else {
				$flag = false;
			}
			return $flag;
		}
	}
 ?>