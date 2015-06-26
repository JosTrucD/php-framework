<?php 
	class Jos_View
	{
		public function layout()
		{
			global $route;

			$url = isset($_GET['url']) && $_GET['url'] != null ? $_GET['url'] : "";
			if(array_key_exists($url, $route)) {
				$url = $route[$url];
			}
			if($url);
			$urlArr = explode('/', $url);
			// Get module
			$module = isset($urlArr[0]) && $urlArr[0] != null ? rtrim($urlArr[0]) : "";
			// Get controller
			$controller = isset($urlArr[1]) && $urlArr[1] != null ? rtrim($urlArr[1]) : "index";
			//Get action
			$action = isset($urlArr[2]) && $urlArr[2] != null ? rtrim($urlArr[2]) : "index";
			// Load view
			$pathView = MODULE_PATH.$module.'/views/script/'.$module.'/'.$controller.'/'.$action.'.phtml';
			if(file_exists($pathView)){
				require_once($pathView);
			} else {
				setTemplate('404');
				die();
			}
		}
	}
 ?>