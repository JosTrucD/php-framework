<?php 
	/**
	 * Function Recursive
	 * @author  JosT
	 * @date   Oct 2014
	 */
	// Sort recursive
	function buildArr($data, $columnName, $parentValue = 0)
	{
		recursive($data, $columnName, $parentValue, 1, $resultArr);
		return $resultArr;
	}
	/**
	 * [recursive description]
	 * @author JosT
	 */
	function recursive($data,$columnName = "",$parentValue = 0, $lever = 1,&$resultArr)
	{
		if(count($data) > 0){
			foreach ($data as $key => $value) {
				if($value['cate_parent'] == $parentValue){
					$value['lever'] = $lever;
					$resultArr[] = $value;
					$newParent = $value['cate_id'];
					unset($data[$key]);
					recursive($data,$columnName,$newParent,$lever+1,$resultArr);
				}
			}
		}
	}
?>