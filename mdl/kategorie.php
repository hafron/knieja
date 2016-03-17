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
	
	function get($swiatlo='') {
		$where = '';
		if ($swiatlo != '') {
			$swiatlo = (int)$swiatlo;

			if ($swiatlo >= 1 && $swiatlo <= 4)
				$where = "WHERE swiatlo=$swiatlo";
		}

		return $this->query("SELECT id, swiatlo, nazwa FROM kategorie $where ORDER BY swiatlo, nazwa");
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
		
		$nazwa = trim($nazwa);
		$swiatlo = (int)$swiatlo;
		
		if ($nazwa == '')
			$ERRORS['kategorie_nazwa_not_empty'] = '';
		if ($swiatlo < 1 || $swiatlo > 4)
			$ERRORS['kategorie_swiatlo_1_4'] = '';

		if (count($ERRORS) > 0)
			return;
		
		$nazwa = $this->escape($nazwa);
		$this->query("INSERT INTO kategorie(nazwa, swiatlo) VALUES ($nazwa, $swiatlo)");
	}
	
	function update($id, $nazwa, $swiatlo) {
		global $ERRORS;
		if (!login_user_is_admin())
			return;
			
		$nazwa = trim($nazwa);
		$swiatlo = (int)$swiatlo;
		
		if ($nazwa == '')
			$ERRORS['kategorie_nazwa_not_empty'] = '';
		if ($swiatlo < 1 || $swiatlo > 4)
			$ERRORS['kategorie_swiatlo_1_4'] = '';

		if (count($ERRORS) > 0)
			return;
	
		$id = (int)$id;
		$nazwa = $this->escape($nazwa);
		$this->query("UPDATE kategorie SET nazwa=$nazwa, swiatlo=$swiatlo WHERE id=$id");
	}
	
	function delete($id) {
		global $ERRORS, $czyny;
		if (!login_user_is_admin())
			return;
		$id = (int)$id;
		if ($czyny->count_get($id) > 0) {
			$ERRORS['kategorie_delete_czyny_exists'] = '';
			return;
		}
		$this->query("DELETE FROM kategorie WHERE id=$id");
	}
}
