<?php

if (!login_user_is_admin()) {
	$action = 'brak_uprawnien';
	return;
}

if (count($_POST) > 0) {
	if (get('do') == 'zapisz') {
		$czyny_harcerze->update(get('id'), value('harcerz'), value('czyn'), value('data_przyznania'), value('osoba_przyznajaca'),
					value('uwagi'));
		header('Location: ?action=czyny_harcerze&czyn='.value('czyn').'&swiatlo='.get('swiatlo').'&harcerz='.value('harcerz'));
	} else {
		$czyny_harcerze->add(value('harcerz'), value('czyn'), value('data_przyznania'), value('osoba_przyznajaca'), value('uwagi'));
		header('Location: ?action=czyny_harcerze&czyn='.value('czyn').'&swiatlo='.get('swiatlo').'&harcerz='.value('harcerz'));
	}
	if (count($ERRORS) == 0) {
		clear_values();
	}
} else {
	set_value('czyn', get('czyn'));
	set_value('harcerz', get('harcerz'));
	set_value('osoba_przyznajaca', $_SESSION['login_row']['id']);
	set_value('data_przyznania', date('Y-m-d'));
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
