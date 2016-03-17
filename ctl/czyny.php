<?php

if (!login_user_is_admin()) {
	$action = 'brak_uprawnien';
	return;
}

if (count($_POST) > 0) {
	if (get('do') == 'zapisz') {
		$czyny->update(get('id'), value('nazwa'), value('poziom'), value('opis'), value('kategoria'));
	} else {
		$czyny->add(value('nazwa'), value('poziom'), value('opis'), value('kategoria'));
	}
	if (count($ERRORS) == 0) {
		clear_values();
	}
} else {
	set_value('kategoria', get('kategoria'));
}

switch (get('do')) {
case 'edytuj':
	$czyn = $czyny->get_one(get('id'));
	foreach ($czyn as $k => $v)
		set_value($k, $v);
break;
case 'usun':
	$czyny->delete(get('id'));
break;
}
