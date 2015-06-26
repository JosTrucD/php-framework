<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class Admin_Model_Cass extends Jos_Model
	{
		protected $_table   = "tbl_category_class";
		protected $_primary = "id"; 

		function __construct()
		{
			parent::__construct();

		}
		public function listCass($start="",$limit="")
		{
			$this->limit($limit,$start);
			return $this->getAll($this->_table);	
		}

		public function insertCass($data)
		{
			$this->insert($data,$this->_table);
		}

		public function updateCass($data,$id)
		{
			$this->where(array($this->_primary=>$id));
			$this->update($data,$this->_table);
		}

		public function getCass()
		{
			return $this->getAll($this->_table);
		}

		public function getInfo($id)
		{
			$this->where(array($this->_primary=>$id));
			return $this->getOnce($this->_table);
		}
		
		public function deleteCass($idArr = array())
		{
			$this->where_in($this->_primary,$idArr);
			$this->delete($this->_table);
		}
		
		/**
		 * [checkInput description]
		 * @param  [type] $input [description]
		 * @return [type]        [description]
		 */
		public function checkInput($class,$category)
		{
			$this->where(array("cate_id"=>$category,"class_id"=>$class));
			return $this->totalRecord($this->_table);
		}
	}
 ?>