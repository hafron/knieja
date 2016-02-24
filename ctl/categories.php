<?php

if (!login_user_is_admin()) {
	$action = 'no_permission';
	return;
}

if (count($_POST) > 0) {
	$kategorie->add(value('nazwa'), value('swiatlo'));
	if (count($ERRORS) == 0) {
		clear_values();
	}
}

