<?php 
	/**
	* @author JosT
	* @date   2014-12-02
	 */
	ob_start();
	require_once('application/config/config.php');
	require_once('application/config/routes.php');
	require_once('application/config/upload.php');
	require_once('application/config/delete_folder.php');
	require_once(LIB_PATH.'Jos/Jos.php');
	require_once(APP_PATH.'help/myhelper.php');
	$objLoad = new Jos_Autoload();
 ?>
