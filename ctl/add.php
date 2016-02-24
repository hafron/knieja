<?php

if (!login_user_is_admin()) {
	$action = 'no_permission';
	return;
}

if (count($_POST) > 0) {
	$czyny->add(value('nazwa'), value('poziom'), value('bm'), value('bw'), value('kategoria'));
	if (count($ERRORS) == 0) {
		clear_values();
	}
}

