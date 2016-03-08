<?php

if (!login_user_is_admin()) {
	$action = 'brak_uprawnien';
	return;
}

if (count($_POST) > 0) {
	if (get('do') == 'zapisz') {
		$czyny_harcerze->update(get('id'), value('harcerz'), value('czyn'), value('data'), value('osoba_przyznajaca'),
					value('uwagi'));
	} else {
		$czyny_harcerze->add(value('harcerz'), value('czyn'), value('data'), value('osoba_przyznajaca'), value('uwagi'));
	}
	if (count($ERRORS) == 0) {
		clear_values();
	}
}

switch (get('do')) {
case 'edytuj':
	$czyn_harcerz = $czyny_harcerze->get_one(get('id'));
	foreach ($czyn_harcerz as $k => $v)
		set_value($k, $v);
break;
case 'usun':
	$czyny_harcerze->delete(get('id'));
break;
}
