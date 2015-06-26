<?php 
	/**
	* @author JosT
	* @date   Oct 2014
	*/
	class Admin_Model_User extends Jos_Model
	{
		protected $_table   = "tbl_user";
		protected $_primary = "id";
		protected $_name    = "name";
		
		public function listUser($start="",$limit="")
		{
			$this->limit($limit,$start);
			return $this->getAll($this->_table);	
		}
		
		public function getInfoUser($id)
		{
			$this->where(array("id"=>$id));
			return $this->getOnce($this->_table);
		}
		
		public function insertUser($data)
		{
			$this->insert($data,$this->_table);
		}
		
		public function editUser($data,$id)
		{
			$this->where(array("id"=>$id));
			$this->update($data,$this->_table);
		}
		/**
		*	Delete user	
		 */
		public function deleteUser($idArr= array())
		{
			$this->where_in($this->_primary,$idArr);
			$this->delete($this->_table);
		}
		/**
		 * Get total records
		 */
		public function getTotal()
		{
			return $this->totalRecord($this->_table);
		}
		/**
		 * Check Login Form
		 */
		public function checkLogin($username,$password)
		{
			$whereArr = array(
							"name"=>$username,
							"password"=>md5($password)
						);
			$this->where($whereArr);
			return $this->totalRecord($this->_table);
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
