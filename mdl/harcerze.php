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
		
		$pseudonim = trim($pseudonim);
		$haslo = $haslo;
		$email = trim($email);
		$uprawnienia = (int)$uprawnienia;
		
		if ($pseudonim == '')
			$ERRORS['users_no_pseudonim'] = '';
		if ($haslo == '')
			$ERRORS['users_no_haslo'] = '';
		if ($email == '') 
			$ERRORS['users_no_email'] = '';
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
			$ERRORS['users_email_invalid'] = '';
		if ($uprawnienia != 0 && $uprawnienia != 5)
			$ERRORS['users_uprawnienia_invalid'] = '';
			
		if (count($ERRORS) > 0)
			return;
		
		$pseudonim = $this->escape($pseudonim);
		$haslo = $this->escape(password_hash($haslo, PASSWORD_DEFAULT));
		$email = $this->escape($email);
		
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
		
		$pseudonim = trim($pseudonim);
		$email = trim($email);
		$uprawnienia = (int)$uprawnienia;
		
		if ($email == '') 
			$ERRORS['users_no_email'] = '';
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
			$ERRORS['users_email_invalid'] = '';
		
		if ($uprawnienia != 0 && $uprawnienia != 5)
			$ERRORS['users_uprawnienia_invalid'] = '';
		
		$id = (int)$id;
		$pseudonim_escaped = $this->escape($pseudonim);
		$email = $this->escape($email);
		$uprawnienia = (int)$uprawnienia;
		
		$login_row = $this->querySingle("SELECT pseudonim FROM harcerze WHERE id=$id");
		$new_login_row = $this->querySingle("SELECT pseudonim FROM harcerze WHERE pseudonim=$pseudonim_escaped");
		
		//tylkow w przypadku zmiany pseudonimu sprawdzamy, czy nie ma powtórek
		if ($pseudonim == '')
			$ERRORS['users_no_pseudonim'] = '';
		elseif ($login_row['pseudonim'] != $pseudonim && !empty($new_login_row))
			$ERRORS['users_user_exists'] = '';
					
		if (count($ERRORS) > 0)
			return;
		
		$this->query("UPDATE harcerze SET pseudonim=$pseudonim_escaped, email=$email, uprawnienia=$uprawnienia WHERE id=$id");
	}
	
	function change_password($haslo, $id=-1) {
		global $ERRORS;
		
		$id = (int)$id;
		//hasło może być zmienione przez samego użytkownika
		$login_row = session_login_row();
		if ($login_row == -1)
			return;
			
		if ($id == -1 || !login_user_is_admin())
			$id = $login_row['id'];

		if ($haslo == '') {
			$ERRORS['users_no_haslo'] = '';
			return;
		}
		
		$haslo = $this->escape(password_hash($haslo, PASSWORD_DEFAULT));
		$this->query("UPDATE harcerze SET haslo=$haslo WHERE id=$id");
	}
	
	function delete($id) {
		global $ERRORS, $czyny_harcerze;
		if (!login_user_is_admin())
			return;
		$id = (int)$id;
		if ($czyny_harcerze->count_get_harcerz($id) > 0) {
			$ERRORS['harcerze_delete_has_czyny'] = '';
			return;
		}
		$this->query("DELETE FROM harcerze WHERE id=$id");
	}
	
	function get_one($id) {
		$id = (int)$id;
		return $this->querySingle("SELECT id, pseudonim, email, uprawnienia FROM harcerze WHERE id=$id");
	}
	
	function pseudonim($id) {
		$id = (int)$id;
		$row = $this->querySingle("SELECT pseudonim FROM harcerze WHERE id=$id");
		return $row['pseudonim'];
	}
	
	function get_users_list() {
		return $this->query("SELECT id, pseudonim, email, uprawnienia FROM harcerze");
	}
}
