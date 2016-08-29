<?php
function value($value, $default='') {
	if (isset($_POST) && isset($_POST[$value]))
		return $_POST[$value];
	return $default;
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

function my_mail($to, $subject, $body, $URI='', $contentType = "text/plain") {
	$subject="=?UTF-8?B?".base64_encode($subject)."?="; 
	
	if ($URI == '') {
		$URI = $_SERVER['SERVER_NAME'];
	}

	$headers =  "From: noreply@$URI\r\n";
	$headers .= "Content-Type: $contentType; charset=UTF-8\r\n";
	if ($contentType != "text/plain")
		$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Transfer-Encoding: 8bit\r\n";

	mail($to, $subject, $body, $headers);
}
