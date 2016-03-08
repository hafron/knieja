<?php

if (!login_user_is_admin()) {
	$action = 'brak_uprawnien';
	return;
}

if (count($_POST) > 0) {
	if (get('do') == 'zapisz') {
		$kategorie->update(get('id'), value('nazwa'), value('swiatlo'));
	} else {
		$kategorie->add(value('nazwa'), value('swiatlo'));
	}
	
	if (count($ERRORS) == 0) {
		clear_values();
	}
}

switch (get('do')) {
case 'edytuj':
	$kategoria = $kategorie->get_one(get('id'));
	foreach ($kategoria as $k => $v)
		set_value($k, $v);
break;
case 'usun':
	$kategorie->delete(get('id'));
break;
}
