<?php 
	/**
	 * @author Jos T
	 * @date   Oct 2014
	 */

	class Jos_Model extends Jos_Db_Database
	{
		protected $_select = "*";
		protected $_where; 
		protected $_limit;
		protected $_order;
		
		public function __construct()
		{
			$this->connect();
		}
		protected function select($column = "")
		{
			if($column == "")
			{
				return false;
			}
			
			$this->_select = $column;	
		}
	    protected function getSelect()
	    {
	    	return $this->_select;
	    }
	    
	    /*
	     * Set Where
	     */
	    protected function where($where = array())
	    {
	    	$string = "";
	    	foreach($where as $key=>$value){
	    		$string .= $key." = "."'".$value ."'"." AND ";
	    	}
	    	$string = trim($string);
	    	$newString = substr($string,0,-3);
	    	$this->_where = "WHERE $newString"; 
	    } 

	    protected function getWhere()
	    {
	    	return $this->_where;
	    } 
	    /**
	     *  Get Where In
	     */
	    protected function where_in($column="",$arr = array())
	    {
	    	if(is_null($arr)) return false;
	    	$stringId = implode(",", $arr);
	    	$this->where_in = "WHERE $column IN({$stringId})"; 
	    }  
		/**
		 * Get order by
		 */
		protected function orderBy($column,$orderBy = "")
		{
			if($orderBy != null){
				$this->_order = "ORDER BY $column $orderBy";
			} else {
				$this->_order = "ORDER BY $column";
			}
		}
	    /**
	     *  Limit
	     */
	    protected function limit($limit,$start="")
	    {
	    	if($limit == "")
	    	{
	    		return false;
	    	}
	    	if($start != "")
	    	{
	    		$this->_limit = "LIMIT $start,$limit";
	    	}else{
	    		$this->_limit = "LIMIT $limit";
	    	}
	    	
	    }
	    
	    protected function getLimit()
	    {
	    	return $this->_limit;
	    }
	    
		public function getAll($table_name = "")
		{
			
			if($table_name == "" ) { return false; }
			$sql = "SELECT {$this->getSelect()} FROM $table_name {$this->_order} {$this->getWhere()} {$this->getLimit()}";
			$this->query($sql);
			return $this->fetchAll();
		}
		
		public function getOnce($table_name = "")
		{
			
			if($table_name == "" ) { return false; }
			$sql = "SELECT {$this->getSelect()} FROM $table_name {$this->getWhere()} {$this->getLimit()}";echo "<br>";		
			$this->query($sql);
			return $this->fetch();
		}
		
		public function insert($data,$table)
		{
			$columnArr = array_keys($data);
			$valueArr = array_values($data);
			foreach($valueArr as $key=>$val)
			{
				$valueArr[$key] = "'".$val."'";
			}
		    $column = implode(",",$columnArr);
			$value = implode(",",$valueArr);
			echo $sql = trim("INSERT INTO $table($column) VALUES($value)");
			$this->query($sql);
		}
		public function update($data,$table)
		{
			
			
			foreach($data as $key=>$val){
				$data[$key] = $key. "=". "'".$val."'";
			}
			
			$setColumn = implode(",",$data);
			
			$sql = "UPDATE $table SET		
					$setColumn
					{$this->getWhere()}";
			$this->query($sql);
			
		}
		
		public function delete($table_name = "")
		{
			if($table_name == "") return false;
			$sql = "DELETE  FROM {$table_name} {$this->getWhere()} {$this->where_in}";
			$this->query($sql);
		}
		
		public function totalRecord($table_name)
		{
			$sql = "SELECT {$this->getSelect()} FROM $table_name {$this->getWhere()} {$this->getLimit()}";
			$this->query($sql);
			return $this->numRows();
		}
}