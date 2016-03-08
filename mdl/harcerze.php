<?php

include_once "db.php";

class Harcerze extends DB {
	function __construct() {
		parent::__construct();
		$createq = "CREATE TABLE IF NOT EXISTS harcerze (
				id INTEGER PRIMARY KEY,
				pseudonim TEXT NOT NULL,
				haslo TEXT NOT NULL,
				email TEXT NULL,
				uprawnienia INTEGER NOT NULL DEFAULT 5)";
		$this->query($createq);
	}
	
	function login($pseudonim, $haslo) {
		global $ERRORS;
		$pseudonim = $this->escape($pseudonim);
		
		$login_row = $this->querySingle("SELECT id, pseudonim, haslo, email, uprawnienia FROM harcerze WHERE pseudonim=$pseudonim");
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
	
	function update($id, $pseudonim, $email='', $uprawnienia=1) {
		global $ERRORS;
		if (!login_user_is_admin())
			return;
		
		$id = (int)$id;
		$pseudonim_escaped = $this->escape($pseudonim);
		$email = $this->escape($email);
		$uprawnienia = (int)$uprawnienia;
		
		$login_row = $this->querySingle("SELECT pseudonim FROM harcerze WHERE id=$id");
		$new_login_row = $this->querySingle("SELECT pseudonim FROM harcerze WHERE pseudonim=$pseudonim_escaped");
		
		//tylkow w przypadku zmiany pseudonimu sprawdzamy, czy nie ma powtórek
		if ($login_row['pseudonim'] != $pseudonim && !empty($new_login_row)) {
			$ERRORS['users_user_exists'] = '';
			return;
		}
		
		$this->query("UPDATE harcerze SET pseudonim=$pseudonim_escaped, email=$email, uprawnienia=$uprawnienia WHERE id=$id");
	}
	
	function change_password($id, $haslo) {
		$id = (int)$id;
		//hasło może być zmienione przez samego użytkownika
		$login_row = session_login_row();
		if (!login_user_is_admin() && $login_row['id'] != $id)
			return;
		
		$haslo = $this->escape(password_hash($haslo, PASSWORD_DEFAULT));
		$this->query("UPDATE harcerze SET haslo=$haslo WHERE id=$id");
	}
	
	function get_one($id) {
		return $this->querySingle("SELECT id, pseudonim, email, uprawnienia FROM harcerze WHERE id=$id");
	}
	
	function get_users_list() {
		return $this->query("SELECT id, pseudonim, email, uprawnienia FROM harcerze");
	}
}
