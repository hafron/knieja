<?php
class DB {
	private $db;
	
	function __construct() {
		$this->db = new SQLite3('data/baza.sqlite');
	}
	
	private function error_query($query, $single=false) {
		global $ERRORS;
		
		if (isset($ERRORS['sqlite']))
			return NULL;
		
		if ($single)
			$r = $this->db->querySingle($query, true);
		else
			$r = $this->db->query($query);
		
		if ($r === FALSE) {
			$ERRORS['sqlite'] = "SQLite error(".$this->db->lastErrorCode()."): ". $this->db->lastErrorMsg()."\nQuery: $query";
			return NULL;
		}
		return $r;
	}
	
	function query($query) {
		return $this->error_query($query);
	}
	
	function querySingle($query) {
		return $this->error_query($query, true);
	}
	
	function escape($str) {
		return "'".$this->db->escapeString($str)."'";
	}
}
