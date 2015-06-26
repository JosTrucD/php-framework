<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	* 
	* $route['hoc-php'] = "module/controller/action"
	*/
	class Jos_Autoload 
	{
		
		public function __construct()
		{	
			global $route;

			$url = isset($_GET['url']) ? $_GET['url'] : "";
			if(array_key_exists($url, $route)) {
				$url = $route[$url];
			}
			if($url){
				$urlArr     = explode('/', $url);
				// Get module
				$module     = isset($urlArr[0]) && $urlArr[0] != null 
						  	 ? rtrim($urlArr[0],"/") : "";
				// Get controller
				$controller = isset($urlArr[1]) && $urlArr[1] != null 
							 ? rtrim($urlArr[1],"/") : "index";
				// Get action			  
				$action     = isset($urlArr[2]) && $urlArr[2] != null 
							 ? rtrim($urlArr[2],"/") : "index";
				
				$controllerName = $controller."Controller";
				$actionName     = $action."Action";

				// Load controller
				$pathController = MODULE_PATH.$module."/controllers/".ucfirst($controllerName).".php";
				
				if(file_exists($pathController)) {
					require_once($pathController);
					$objController = new $controllerName;
					if(method_exists($controllerName,$actionName)) {
						$objController->$actionName();
					} else{
						setTemplate('404');
						die();
					}
					
				} else {
					setTemplate('404');
					die();
				}  
			}
		}
	}
 ?>