<?php

include_once "db.php";

class Czyny_Harcerze extends DB {
	function __construct() {
		parent::__construct();
		$createq = "CREATE TABLE IF NOT EXISTS czyny_harcerze (
				id INTEGER PRIMARY KEY,
				czyn INTEGER NOT NULL,
				harcerz INTEGER NOT NULL,
				data_przyznania TEXT NOT NULL,
				osoba_przyznajaca INTEGER NOT NULL,
				uwagi TEXT NOT NULL)";
		$this->query($createq);
	}
	
	function get($czyn) {
		$czyn = (int)$czyn;
		return $this->query("SELECT harcerz, data_przyznania FROM czyny_harcerze WHERE czyn=$czyn");
	}
	
	function count_get($czyn) {
		$czyn = (int)$czyn;
		$result = $this->querySingle("SELECT COUNT(*) AS num_rows FROM czyny_harcerze WHERE czyn=$czyn");
		return $result['num_rows'];
	}
	
	function get_all() {
		return $this->query("SELECT czyny_harcerze.id, h1.pseudonim AS harcerz, czyny.poziom, czyny.nazwa, data_przyznania,
					h2.pseudonim AS osoba_przyznajaca, uwagi
				FROM czyny_harcerze JOIN czyny ON czyny_harcerze.czyn = czyny.id
					JOIN harcerze h1 ON czyny_harcerze.harcerz = h1.id
					JOIN harcerze h2 ON czyny_harcerze.osoba_przyznajaca = h2.id");
	}
	
	function get_one($id) {
		$id = (int)$id;
		return $this->querySingle("SELECT id, czyn, harcerz, data_przyznania, osoba_przyznajaca, uwagi FROM czyny_harcerze WHERE id=$id");
	}
	
	function add($harcerz, $czyn, $data_przyznania, $osoba_przyznajaca, $uwagi) {
		global $ERRORS;
		if (!login_user_is_admin())
			return;
		$harcerz = (int)$harcerz;
		$czyn = (int)$czyn;
		$data_przyznania = $this->escape($data_przyznania);
		$osoba_przyznajaca = (int)$osoba_przyznajaca;
		$uwagi = $this->escape($uwagi);
		
		$this->query("INSERT INTO czyny_harcerze(harcerz, czyn, data_przyznania, osoba_przyznajaca, uwagi) VALUES ($harcerz, $czyn, $data_przyznania, $osoba_przyznajaca, $uwagi)");
	}
	
	function update($id, $harcerz, $czyn, $data_przyznania, $osoba_przyznajaca, $uwagi) {
		global $ERRORS, $kategorie;
		if (!login_user_is_admin())
			return;
		$id = (int)$id;
		$harcerz = (int)$harcerz;
		$czyn = (int)$czyn;
		$data_przyznania = $this->escape($data_przyznania);
		$osoba_przyznajaca = (int)$osoba_przyznajaca;
		$uwagi = $this->escape($uwagi);
		
		$this->query("UPDATE czyny_harcerze SET harcerz=$harcerz, czyn=$czyn, data_przyznania=$data_przyznania,
				osoba_przyznajaca=$osoba_przyznajaca, uwagi=$uwagi WHERE id=$id");
	}
	
	function delete($id) {
		global $ERRORS;
		if (!login_user_is_admin())
			return;
			
		$id = (int)$id;
		$this->query("DELETE FROM czyny_harcerze WHERE id=$id");
	}
}
