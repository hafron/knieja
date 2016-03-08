<?php

if (!login_user_is_admin()) {
	$action = 'brak_uprawnien';
	return;
}

if (count($_POST) > 0) {
	if (get('do') == 'zapisz') {
		$harcerze->update(get('id'), value('pseudonim'), value('email'), value('uprawnienia'));
	} elseif (get('do') == 'popraw_haslo') {
		$harcerze->change_password(get('id'), value('haslo'));
		if (count($ERRORS) == 0)
			header("Location: ?action=harcerze");
	} else {
		$harcerze->create_user(value('pseudonim'), value('haslo'), value('email'), value('uprawnienia'));
	}
	if (count($ERRORS) == 0) {
		clear_values();
	}
}


switch (get('do')) {
case 'edytuj':
	$harcerz = $harcerze->get_one(get('id'));
	foreach ($harcerz as $k => $v)
		set_value($k, $v);
break;
case 'usun':
	$harcerz->delete(get('id'));
break;
}

?>
