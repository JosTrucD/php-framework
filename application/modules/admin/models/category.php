<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class Admin_Model_Category extends Jos_Model
	{
		protected $_table   = "tbl_categories";
		protected $_primary = "cate_id";
		protected $_name    = "cate_name";
		
		function __construct()
		{
			parent::__construct();
		}
		public function listCate($start="",$limit="")
		{
			$this->limit($limit,$start);
			return $this->getAll($this->_table);	
		}

		public function insertCate($data)
		{
			$this->insert($data,$this->_table);
		}

		public function updateCate($data,$id)
		{
			$this->where(array($this->_primary=>$id));
			$this->update($data,$this->_table);
		}

		public function getCate()
		{
			return $this->getAll($this->_table);
		}

		public function getInfo($id)
		{
			$this->where(array($this->_primary=>$id));
			return $this->getOnce($this->_table);
		}

		public function checkInput($input)
		{
			$this->where(array($this->_name=>$input));
			return $this->totalRecord($this->_table);
		}
		
		public function deleteCate($idArr = array())
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