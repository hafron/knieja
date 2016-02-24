<?php
function value($value) {
	if (isset($_POST) && isset($_POST[$value]))
		return $_POST[$value];
	return '';
}

function clear_values() {
	$_POST = array();
}

function error($value) {
	global $ERRORS;
	
	if (isset($ERRORS) && isset($ERRORS[$value]))
		return true;
	return false;	
}

function login_user_is_admin() {
	if (!isset($_SESSION['login_row']))
		return false;
		
	if ($_SESSION['login_row']['uprawnienia'] == 0)
		return true;
	
	return false;
}
