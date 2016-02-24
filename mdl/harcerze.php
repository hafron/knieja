<?php

include_once "db.php";

class Harcerze extends DB {
	function __construct() {
		parent::__construct();
		$createq = "CREATE TABLE IF NOT EXISTS harcerze (
				pseudonim TEXT PRIMARY KEY,
				haslo TEXT NOT NULL,
				email TEXT NULL,
				uprawnienia INTEGER NOT NULL DEFAULT 5)";
		$this->query($createq);
	}
	
	function login($pseudonim, $haslo) {
		global $ERRORS;
		$pseudonim = $this->escape($pseudonim);
		
		$login_row = $this->querySingle("SELECT pseudonim, haslo, email, uprawnienia FROM harcerze WHERE pseudonim=$pseudonim");
		if (empty($login_row)) {
			$ERRORS['login_user_no_exists'] = '';
			return NULL;
		} elseif (!password_verify($haslo, $login_row['haslo'])) {
			$ERRORS['login_wrong_password'] = '';
			return NULL;
		}
		unset($login_row['haslo']);
		return $login_row;
	}
	
	function create_user($pseudonim, $haslo, $email='', $uprawnienia=1) {
		global $ERRORS;
		
		if (!login_user_is_admin())
			return;
		$pseudonim = $this->escape($pseudonim);
		$haslo = $this->escape(password_hash($haslo, PASSWORD_DEFAULT));
		$email = $this->escape($email);
		$uprawnienia = (int)$uprawnienia;
		
		$login_row = $this->querySingle("SELECT pseudonim FROM harcerze WHERE pseudonim=$pseudonim");
		
		if (!empty($login_row)) {
			$ERRORS['users_user_exists'] = '';
			return;
		}
		
		$this->query("INSERT INTO harcerze(pseudonim, haslo, email, uprawnienia) VALUES ($pseudonim, $haslo, $email, $uprawnienia)");
	}
	
	function get_users_list() {
		return $this->query("SELECT pseudonim, haslo, email, uprawnienia FROM harcerze");
	}
}
