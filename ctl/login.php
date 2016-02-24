<?php


if (count($_POST) > 0) {
	$login_row = $harcerze->login(value('pseudonim'), value('haslo'));
	if ($login_row !== NULL) {
		$_SESSION['login_row'] = $login_row;
		header("Location: ?action=index");
	}
}
