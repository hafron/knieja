<?php

if (session_login_row() == -1) {
	$action = 'brak_uprawnien';
	return;
}

if (count($_POST) > 0) {
	if (value('haslo') == '') {
		set_error('change_password_no_empty');
	} elseif (value('haslo') != value('haslo_powt')) {
		set_error('change_password_not_match');
	} else {
		$harcerze->change_password(value('haslo'));
		header('Location: ?action=index&kom=haslo_zmienione');
	}
}
