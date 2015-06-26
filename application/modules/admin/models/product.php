<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/ 
	class Admin_Model_Product extends Jos_Model
	{
		const TABLE         = "tbl_products";
		protected $_name    = "pro_name";
		protected $_primary = "pro_id";

		function __construct()
		{
			parent::__construct();
		}
		public function listProduct($start="",$limit="")
		{
			$this->limit($limit,$start);
			return $this->getAll(self::TABLE);	
		}

		public function insertProduct($data)
		{
			$this->insert($data,self::TABLE);
		}

		public function updateProduct($data,$id)
		{
			$this->where(array($this->_primary=>$id));
			$this->update($data,self::TABLE);
		}

		public function getProduct()
		{
			return $this->getAll(self::TABLE);
		}

		public function getInfo($id)
		{
			$this->where(array($this->_primary=>$id));
			return $this->getOnce(self::TABLE);
		}

		public function getName($data)
		{
			$this->where(array($this->_name=>$data));
			return $this->getOnce(self::TABLE);
		}
		
		public function deleteProduct($idArr = array())
		{
			$this->where_in($this->_primary,$idArr);
			$this->delete(self::TABLE);
		}
		/**
		 * [getOrderBy description]
		 * @return [type] [description]
		 */
		public function getOrderBy()
		{
			$this->orderBy($this->_name);
			return $this->getAll(self::TABLE);
		}
		
		/**
		 * [checkInput description]
		 * @param  [type] $input [description]
		 * @return [type]        [description]
		 */
		public function checkInput($input)
		{
			$this->where(array($this->_name=>$input));
			return $this->totalRecord(self::TABLE);
		}
	}
 ?>