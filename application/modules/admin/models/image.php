<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class Admin_Model_Image extends Jos_Model
	{
		protected $_table   = "tbl_image_product";
		protected $_primary = "id";
		protected $_name    = "pro_id";
		
		function __construct()
		{
			parent::__construct();
		}
		public function listImage($start="",$limit="")
		{
			$this->limit($limit,$start);
			return $this->getAll($this->_table);	
		}

		public function insertImage($data)
		{
			$this->insert($data,$this->_table);
		}

		public function updateImage($data,$id)
		{
			$this->where(array($this->_primary=>$id));
			$this->update($data,$this->_table);
		}

		public function getPro($id)
		{
			$this->where(array($this->_name=>$id));
			return $this->getAll($this->_table);
		}

		public function getInfo($id)
		{
			$this->where(array($this->_primary=>$id));
			return $this->getOnce($this->_table);
		}
		
		public function deleteImage($idArr = array())
		{
			$this->where_in($this->_primary,$idArr);
			$this->delete($this->_table);
		}
		/**
		 * [getOrderBy description]
		 * @return [type] [description]
		 */
		public function getOrderBy()
		{
			$this->orderBy($this->_name);
			return $this->getAll($this->_table);
		}
	}
?>