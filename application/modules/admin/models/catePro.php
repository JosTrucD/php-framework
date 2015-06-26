<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class Admin_Model_CatePro extends Jos_Model
	{
		protected $_table   = "tbl_category_product";
		protected $_primary = "id";
		protected $_name    = "cate_name";
		protected $_product = "pro_id";
		
		function __construct()
		{
			parent::__construct();
		}
		public function listCatePro($start="",$limit="")
		{
			$this->limit($limit,$start);
			return $this->getAll($this->_table);	
		}

		public function insertCatePro($data)
		{
			$this->insert($data,$this->_table);
		}

		public function updateCatePro($data,$id)
		{
			$this->where(array($this->_primary=>$id));
			$this->update($data,$this->_table);
		}

		public function deleteCatePro($idArr = array())
		{
			$idString = implode(",",$idArr);
			$sql = "DELETE FROM {$this->_table} WHERE {$this->_primary} IN($idString)";
			$this->query($sql);
		}

		public function getPro($id)
		{
			$this->where(array($this->_product=>$id));
			return $this->getAll($this->_table);
		}

		public function getInfo($id)
		{
			$this->where(array($this->_primary=>$id));
			return $this->getOnce($this->_table);
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