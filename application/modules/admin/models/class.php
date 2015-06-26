<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class Admin_Model_Class extends Jos_Model
	{
		protected $_table   = "tbl_class";
		protected $_primary = "class_id";
		protected $_name    = "class_name";
		
		function __construct()
		{
			parent::__construct();
		}
		public function listClass($start="",$limit="")
		{
			$this->limit($limit,$start);
			return $this->getAll($this->_table);	
		}

		public function insertClass($data)
		{
			$this->insert($data,$this->_table);
		}

		public function editClass($data,$id)
		{
			$this->where(array($this->_primary=>$id));
			$this->update($data,$this->_table);
		}

		public function getClass()
		{
			return $this->getAll($this->_table);
		}

		public function getInfoClass($id)
		{
			$this->where(array($this->_primary=>$id));
			return $this->getOnce($this->_table);
		}
		
		public function deleteClass($idArr = array())
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
		
		/**
		 * [checkInput description]
		 * @param  [type] $input [description]
		 * @return [type]        [description]
		 */
		public function checkInput($input)
		{
			$this->where(array($this->_name=>$input));
			return $this->totalRecord($this->_table);
		}
	}
?>