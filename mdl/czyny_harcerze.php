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
		return $this->query("SELECT pseudonim, harcerz, data_przyznania
					FROM czyny_harcerze JOIN harcerze ON harcerz = harcerze.id WHERE czyn=$czyn");
	}
	
	function count_get($czyn) {
		$czyn = (int)$czyn;
		$result = $this->querySingle("SELECT COUNT(*) AS num_rows FROM czyny_harcerze WHERE czyn=$czyn");
		return $result['num_rows'];
	}
	
	function get_all($swiatlo='', $harcerz='') {
		$where = '';
		if ($swiatlo != '') {
			$swiatlo = (int)$swiatlo;
			$where = "WHERE kategorie.swiatlo = $swiatlo";
		}
		if ($harcerz != '') {
			$harcerz = (int)$harcerz;
			if ($where != '')
				$where .= ' AND ';
			else
				$where = 'WHERE ';
			$where .= "czyny_harcerze.harcerz = $harcerz";
		}
		
		return $this->query("SELECT czyny_harcerze.id, h1.pseudonim AS harcerz, czyny.poziom, czyny.nazwa, data_przyznania,
					h2.pseudonim AS osoba_przyznajaca, uwagi, swiatlo, kategorie.nazwa as kategoria_nazwa
				FROM czyny_harcerze JOIN czyny ON czyny_harcerze.czyn = czyny.id
					JOIN harcerze h1 ON czyny_harcerze.harcerz = h1.id
					JOIN harcerze h2 ON czyny_harcerze.osoba_przyznajaca = h2.id
					JOIN kategorie ON czyny.kategoria = kategorie.id
					$where
					ORDER BY kategorie.swiatlo, czyny.kategoria, czyny.nazwa");
	}
	
	function get_harcerz($harcerz) {
		$harcerz = (int)$harcerz;
		return $this->query("SELECT data_przyznania, uwagi, czyny.nazwa, czyny.poziom, czyny.opis, czyny.kategoria, kategorie.swiatlo
					FROM czyny_harcerze
						JOIN harcerze ON harcerz = harcerze.id
						JOIN czyny ON czyn = czyny.id
						JOIN kategorie ON czyny.kategoria = kategorie.id
					WHERE harcerz=$harcerz
					ORDER BY data_przyznania DESC");
	} 
	
	function count_get_harcerz($harcerz) {
		$harcerz = (int)$harcerz;
		$result = $this->querySingle("SELECT COUNT(*) AS num_rows FROM czyny_harcerze WHERE harcerz=$harcerz");
		return $result['num_rows'];
	}
	
	function get_one($id) {
		$id = (int)$id;
		return $this->querySingle("SELECT id, czyn, harcerz, data_przyznania, osoba_przyznajaca, uwagi FROM czyny_harcerze WHERE id=$id");
	}
	
	function add($harcerz, $czyn, $data_przyznania, $osoba_przyznajaca, $uwagi) {
		global $ERRORS;
		if (!login_user_is_admin())
			return;
		
		$data_przyznania = trim($data_przyznania);
		if ($data_przyznania == '')
			$ERRORS['czyny_harcerze_data_not_empty'] = '';
		elseif(($unix_data_przyznania = strtotime($data_przyznania)) === FALSE) 
			$ERRORS['czyny_harcerze_data_invalid'] = '';
		
		if (count($ERRORS) > 0)
			return;
		
		$data_przyznania = date('Y-m-d', $unix_data_przyznania);
		
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
			
		$data_przyznania = trim($data_przyznania);
		if ($data_przyznania == '')
			$ERRORS['czyny_harcerze_data_not_empty'] = '';
		elseif(($unix_data_przyznania = strtotime($data_przyznania)) === FALSE) 
			$ERRORS['czyny_harcerze_data_invalid'] = '';
			
		if (count($ERRORS) > 0)
			return;
		
		$data_przyznania = date('Y-m-d', $unix_data_przyznania);
		
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
