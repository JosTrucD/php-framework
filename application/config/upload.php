<?php 
	/**
	 * [upload file]
	 * @param $source [Đường dẫn nơi chứa file upload]
	 * @param $folder [Tên thư mục sẽ tạo khi upload]
	 */
	function upload($source,$folder)
	{
		$flag = true;
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != null){
			// Check folder
			// Create folder
			if(!is_dir($source.$folder)){
				mkdir($source.$folder, 0770);
			} else {
				delete_folder($source.$folder);
				mkdir($source.$folder, 0770);
			}
			$path     = $source.$folder."/";
			$image    = $_FILES['image']['name'];
			$tmp_name = $_FILES['image']['tmp_name'];
			// Check type file image
			$type = substr($_FILES['image']['type'], 6);
			if($type == "png" || $type == "jpeg" || $type == "jpg"){
				move_uploaded_file($tmp_name, $path.$image);
			} else {
				$flag = false;
				die("Type $type not support !!!");
			}
		} else {
			$flag = false;
		}
		return $flag;
	}
	/**
	 * [upload multi file]
	 * @param $source [Đường dẫn nơi chứa file upload]
	 * @param $folder [Tên thư mục sẽ tạo khi upload]
	 */
	function upload_multi_file($source,$folder)
	{
		$flag = true;
		if(isset($_FILES['images']['name']) && $_FILES['images']['name'] != null){
			// Check folder
			// Create folder
			if(!is_dir($source.$folder)){
				mkdir($source.$folder, 0770);
			} else {
				delete_folder($source.$folder);
				mkdir($source.$folder, 0770);
			}
			// Check type file image
			foreach ($_FILES['images']['type'] as $key => $value) {
				$type = substr($value, 6);
				if($type == "png" || $type == "jpeg" || $type == "jpg"){
					//Loop through each file
					for ($i=0; $i < count($_FILES['images']['name']) ; $i++) { 
						$tmpPath = $_FILES['images']['tmp_name'][$i];
						$images    = $_FILES['images']['name'][$i];
						if ($tmpPath != null) {
							$path     = $source.$folder."/";
							move_uploaded_file($tmpPath, $path.$images);
						}
					}
				} else {
					$flag = false;
					die("Type $type not support !!!");
				}
			}
		} else {
			$flag = false;
		}
		return $flag;
	}
 ?>