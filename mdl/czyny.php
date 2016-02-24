<?php

include_once "db.php";

class Czyny extends DB {
	function __construct() {
		parent::__construct();
		$createq = "CREATE TABLE IF NOT EXISTS czyny (
				id INTEGER PRIMARY KEY,
				nazwa TEXT NOT NULL,
				poziom INTEGER NOT NULL,
				bm TEXT NULL,
				bw TEXT NULL,
				kategoria INTEGER NOT NULL)";
		$this->query($createq);
	}
	
	function get($kategoria) {
		$kategoria = (int)$kategoria;
		return $this->query("SELECT id, nazwa, poziom, bm, bw FROM czyny WHERE kategoria=$kategoria");
	}
	
	function add($nazwa, $poziom, $bm, $bw, $kategoria) {
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
		$bm = $this->escape($bm);
		$bw = $this->escape($bw);
		$kategoria = (int)$kategoria;
		$this->query("INSERT INTO czyny(nazwa, poziom, bm, bw, kategoria) VALUES ($nazwa, $poziom, $bm, $bw, $kategoria)");
	}
}
