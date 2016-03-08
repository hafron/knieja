<?php

include_once "db.php";

class Czyny extends DB {
	function __construct() {
		parent::__construct();
		$createq = "CREATE TABLE IF NOT EXISTS czyny (
				id INTEGER PRIMARY KEY,
				nazwa TEXT NOT NULL,
				poziom INTEGER NOT NULL,
				opis TEXT NOT NULL,
				kategoria INTEGER NOT NULL)";
		$this->query($createq);
	}
	
	function get($kategoria) {
		$kategoria = (int)$kategoria;
		return $this->query("SELECT id, nazwa, poziom, opis FROM czyny WHERE kategoria=$kategoria");
	}
	
	function count_get($kategoria) {
		$kategoria = (int)$kategoria;
		$result = $this->querySingle("SELECT COUNT(*) AS num_rows FROM czyny WHERE kategoria=$kategoria");
		return $result['num_rows'];
	}
	
	function get_all() {
		return $this->query("SELECT czyny.id, czyny.nazwa, czyny.poziom, czyny.kategoria, kategorie.swiatlo, czyny.opis
					FROM czyny JOIN kategorie ON czyny.kategoria = kategorie.id");
	}
	
	function get_one($id) {
		$id = (int)$id;
		return $this->querySingle("SELECT id, nazwa, poziom, opis, kategoria FROM czyny WHERE id=$id");
	}
	
	
	function add($nazwa, $poziom, $opis, $kategoria) {
		global $ERRORS, $kategorie;
		if (!login_user_is_admin())
			return;
		$kategoria = (int)$kategoria;
		$kat_row = $kategorie->get_one($kategoria);
		if (empty($kat_row)) {
			$ERRORS['czyny_add_kategoria_no_exists'] = '';
			return;
		}
		$nazwa = $this->escape($nazwa);
		$poziom = (int)$poziom;
		$opis = $this->escape($opis);
		$kategoria = (int)$kategoria;
		$this->query("INSERT INTO czyny(nazwa, poziom, opis, kategoria) VALUES ($nazwa, $poziom, $opis, $kategoria)");
	}
	
	function update($id, $nazwa, $poziom, $opis, $kategoria) {
		global $ERRORS, $kategorie;
		if (!login_user_is_admin())
			return;
		$id = (int)$id;
		$kategoria = (int)$kategoria;
		$kat_row = $kategorie->get_one($kategoria);
		if (empty($kat_row)) {
			$ERRORS['czyny_add_kategoria_no_exists'] = '';
			return;
		}
		$nazwa = $this->escape($nazwa);
		$poziom = (int)$poziom;
		$opis = $this->escape($opis);
		$kategoria = (int)$kategoria;
		
		$this->query("UPDATE czyny SET nazwa=$nazwa, poziom=$poziom, opis=$opis, kategoria=$kategoria WHERE id=$id");
	}
	
	function delete($id) {
		global $ERRORS, $czyny_harcerze;
		if (!login_user_is_admin())
			return;
		$id = (int)$id;
		if ($czyny_harcerze->count_get($id) > 0) {
			$ERRORS['czyny_delete_zdobywcy_exists'] = '';
			return;
		}
		$this->query("DELETE FROM czyny WHERE id=$id");
	}
}
