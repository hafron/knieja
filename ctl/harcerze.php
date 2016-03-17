<?php

if (!login_user_is_admin()) {
	$action = 'brak_uprawnien';
	return;
}

if (count($_POST) > 0) {
	if (get('do') == 'zapisz') {
		$harcerze->update(get('id'), value('pseudonim'), value('email'), value('uprawnienia'));
		if (count($ERRORS) == 0)
			header('Location: ?action=harcerze');

	} elseif (get('do') == 'popraw_haslo') {
		$harcerze->change_password(value('haslo'), get('id'));
		if (count($ERRORS) == 0)
			header("Location: ?action=harcerze&kom=haslo_zmienione");
	} else {
		$harcerze->create_user(value('pseudonim'), value('haslo'), value('email'), value('uprawnienia'));
	}
	
	if (count($ERRORS) == 0)
		clear_values();
}


switch (get('do')) {
case 'edytuj':
	$harcerz = $harcerze->get_one(get('id'));
	foreach ($harcerz as $k => $v)
		set_value($k, $v);
break;
case 'usun':
	$harcerze->delete(get('id'));
break;
}

?>
