<?php 
	/**
	 * Delete folder
	 * @param   $dirname [folder cần xóa]
	 */
	function delete_folder($dirname) 
	{
		$dir_handle = "";
	    if (is_dir($dirname)){
	        $dir_handle = opendir($dirname);
	    }
		if (!$dir_handle){
		    return false;
		}
		while($file = readdir($dir_handle)) {
		    if ($file != "." && $file != ".."){
	            if (!is_dir($dirname."/".$file)){
	                unlink($dirname."/".$file);
	            } else{
	                delete_folder($dirname.'/'.$file);
	            }
		    }   
		 }
		 closedir($dir_handle);
		 rmdir($dirname);
		 return true;
	}

	/**
	 * Delete multi folder
	 * @param  array  $data [các folder cần xóa]
	 * @param  string $path [dường dẫn tới nơi chứa folder cần xóa]
	 */
	function delete_multi_folder($data = array(),$path)
	{
		if($data) {
			foreach ($data as $value) {
				delete_folder($path.$value);
			}
		}
	}
 ?>