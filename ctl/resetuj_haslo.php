<?php


if (count($_POST) > 0) {
	if ($harcerze->harcerz_exists(value('pseudonim'))) {
		$harcerz = $harcerze->get_one_by_pseudonim(value('pseudonim'));
		$haslo = $harcerze->reset_password($harcerz['id']);
		
		my_mail($harcerz['email'], 'Hasło zresetowane',
		"Hasło do twojego konta zostało zresetwane. Twoje nowe hasło to: $haslo");
		
		header("Location: ?action=index&kom=haslo_zresetowane");
	} else {
		$ERRORS['login_user_no_exists'] = '';
	}
}
