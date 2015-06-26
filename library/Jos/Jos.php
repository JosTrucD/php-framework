<?php 
	/**
	* @author JosT
	* $date   Oct 2014
	*/
	final class Jos
	{
		static function getParams()
		{
			$params = $_REQUEST;
			$paramsEnd = array();
			
			if(isset($params['url']) && $params['url'] != null) {
				$paramsArr  = explode("/",$params['url']);
				
				$newParrams = array();
				if(!is_null($paramsArr)) {
					$newParrams['module']     = $paramsArr[0];
					$newParrams['controller'] = $paramsArr[1];
					$newParrams['action'] 	  = isset($paramsArr[2])  ? $paramsArr[2] : "index";
					$newParrams['id'] 	      = isset($paramsArr[3])  ? $paramsArr[3] : "";

					$paramsUrl = array();
					if(count($paramsArr) >= 3 ) {
						for($i=3; $i < count($paramsArr);$i++ ){
							$paramsUrl[] = $paramsArr[$i];
						}
					}
					$evenArr = array();
					$oddArr  = array();
					
					foreach ($paramsUrl as $key=>$val) {
						if($key%2 == 0) {
							$evenArr[] = $val;
						}else {
							$oddArr[] = $val;
						}
					}
					$paramsUrlNew = array();
					if($evenArr != null && $oddArr != null ) {
						foreach ($evenArr as $key=>$val) {
							$paramsUrlNew[$val] = @$oddArr[$key];
						}
					}
					unset($params['url']);
					$paramsEnd = @array_merge($newParrams,$paramsUrlNew,$params);
				}
				return $paramsEnd;
				
			}
		}
		
		
		static function isPost()
		{
			$flag = true;
			if(!$_POST){
				$flag = false;
			}
			return $flag;
		}
		
		
		static function isNull($string="") {
			$flag = true;
			if($string) {
				$flag = false;
			}
			return $flag;
		}
		
		static function isNumber($string) {
			$flag = true;
			if(!is_numeric($string)) {
				$flag = false;
			}
			return $flag;
		}
	}
 ?>