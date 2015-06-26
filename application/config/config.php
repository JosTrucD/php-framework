<?php 
	/**
	* @author JosT
	* @date   Dec 2014
	 */
	define('BASE_URL'   , 'http://maylocnuoc/');
	define('APP_PATH'   , 'application/');
	define('MODULE_PATH', 'application/modules/');
	define('LIB_PATH'   , 'library/');
	define('ADMIN_PATH' , BASE_URL.'public/admin/');
	define('TEM_PATH'   , 'application/template/');

	define('HOSTNAME'   , 'localhost');
	define('USERNAME'   , 'root');
	define('PASSWORD'   , '');
	define('DBNAME'     , 'maylocnuoc');

	/**
	 *  Function autoload
	 */
	function __autoload($url)
	{	
		global $route;
		$urlParams = isset($_GET['url']) ? $_GET['url'] : "";

		if(array_key_exists($urlParams, $route)) {
				$urlParams = $route[$urlParams];			
		}
		if($urlParams)
		$urlArr = explode("/", $urlParams);
		
		$module = isset($urlArr[0]) && $urlArr[0] != null 
				  	? rtrim($urlArr[0],"/") : "";
		
		// Load library

		$urlNew = LIB_PATH.str_replace("_","/",$url);
		$urlNew = $urlNew.".php";
		if(file_exists($urlNew)) {
			require_once($urlNew);
		}
		
		// Load model
		$modelPath = MODULE_PATH. str_replace("model","models",str_replace("_","/",strtolower($url))).".php";
		if(file_exists($modelPath)) {
			require_once($modelPath);
		}
	}

	/**
	 * setTemplate
	 * return $data
	 */
	function setTemplate($path = "",$data = array()) {
		if($path){
			require_once TEM_PATH.$path.".phtml";
		} 
		if($data) return $data;
	}
	/**
	 * View Array
	 */
	function debug($data = array()) {
	 	echo "<pre>";
	 	print_r($data);
	 	echo "</pre>";
	}
	/**
	 * Redirect to Page 
	 */
	function redirect($path = "")
	{
		if(!$path){
			 return false;
		} else {
			header("location:".BASE_URL."$path");
		}  
	}
	/**
	 * set timezone
	 */
	date_default_timezone_set('Asia/Ho_Chi_Minh');
 ?>