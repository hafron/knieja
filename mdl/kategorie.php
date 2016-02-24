<?php

include_once "db.php";

class Kategorie extends DB {
	function __construct() {
		parent::__construct();
		$createq = "CREATE TABLE IF NOT EXISTS kategorie (
				id INTEGER PRIMARY KEY,
				nazwa TEXT NOT NULL,
				swiatlo INTEGER NOT NULL)";
		$this->query($createq);
	}
	
	function get($swiatlo) {
		$swiatlo = (int)$swiatlo;
		return $this->query("SELECT id, nazwa FROM kategorie WHERE swiatlo=$swiatlo");
	}
	
	function get_all() {
		return $this->query("SELECT id, nazwa, swiatlo FROM kategorie");
	}
	
	function get_one($id) {
		$id = (int)$id;
		return $this->querySingle("SELECT id, nazwa, swiatlo FROM kategorie WHERE id=$id");
	}
	
	function add($nazwa, $swiatlo) {
		global $ERRORS;
		if (!login_user_is_admin())
			return;
		$nazwa = $this->escape($nazwa);
		$swiatlo = (int)$swiatlo;
		$this->query("INSERT INTO kategorie(nazwa, swiatlo) VALUES ($nazwa, $swiatlo)");
	}
}
