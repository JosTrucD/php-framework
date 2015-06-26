<?php
/**
 * @Class: Pagination
 * @Author: Jos T
 */
class Jos_Pagination_Pagination
{
	protected $_limit;
	protected $_start;
	protected $_totalRecord;
	protected $_url;
	protected $_currPage = 1;
	
	public function setLimit($value)
	{
		$this->_limit = $value;
	}
	public function setStart($start)
	{
		$this->_start = $start;
	}
	
	public function setTotalRecord($value)
	{
		$this->_totalRecord = $value;
	}
	
	public function setBaseUrl($value)
	{
		$this->_url = $value;
	}
	
	public function setCurrPage($value)
	{
		$this->_currPage = $value;
	}
	 
	public function createPage()
	{
		$html = "";
		$pages = ceil($this->_totalRecord/$this->_limit);
		if($this->_currPage > 1) {
			$pagePrev = ($this->_currPage - 1); 
			$html.= "<a href='/{$this->_url}/page/$pagePrev'>Prev</a> ";
		}
		for($i = 1; $i<= $pages; $i++) {
			$html.= "<a href='/{$this->_url}/page/{$i}'> ".$i."</a> ";
		}
		if($this->_currPage  < ceil($this->_totalRecord/$this->_limit)) {
			$pageNext = ($this->_currPage + 1); 
			$html.= "<a href='/{$this->_url}/page/$pageNext' >Next</a>";
		}
		return $html;
	}
}