<?php
function value($value) {
	if (isset($_POST) && isset($_POST[$value]))
		return $_POST[$value];
	return '';
}

function set_value($name, $value) {
	$_POST[$name] = $value;
}

function clear_values() {
	$_POST = array();
}

function get($value) {
	if (isset($_GET) && isset($_GET[$value]))
		return $_GET[$value];
	return '';
}

function error($value) {
	global $ERRORS;
	
	if (isset($ERRORS) && isset($ERRORS[$value]))
		return true;
	return false;	
}

function set_error($name) {
	global $ERRORS;
	$ERRORS[$name] = '';
}

function login_user_is_admin() {
	if (!isset($_SESSION['login_row']))
		return false;
		
	if ($_SESSION['login_row']['uprawnienia'] == 0)
		return true;
	
	return false;
}

function session_login_row() {
	if (!isset($_SESSION['login_row']))
		return -1;
	return $_SESSION['login_row'];
}
