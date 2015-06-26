<?php
class Jos_Db_Database
{
	protected $connect;
	protected $result;
	
	public function connect()
	{
		$this->connect = mysql_connect(HOSTNAME,USERNAME,PASSWORD) or die("Server Disconnect !!!");
		mysql_select_db(DBNAME,$this->connect);
		mysql_query("set names 'utf8'");
	}
	
	public function query($sql)
	{
		if(!$this->connect)
		{
			die("Server Disconnect ".__METHOD__);
		}
		$this->result = mysql_query($sql);
	}
	
	public function numRows()
	{
		if(!$this->result) 
		{
			die("Not Query ".__METHOD__);
		}
		return mysql_num_rows($this->result);
	}
	
	public function fetch()
	{
		if(!$this->result) 
		{
			die("Not Query ".__METHOD__);
		}
		return mysql_fetch_assoc($this->result);
	}
	
	public function fetchAll()
	{
		if(!$this->result) 
		{
			die("Not Query ".__METHOD__);
		}
		$data = array();
		while($row = mysql_fetch_assoc($this->result)) {
			$data[] = $row;
		}
		return $data;
	}
}