<?php

if (count($_POST) > 0) {
	$harcerze->create_user(value('pseudonim'), value('haslo'), value('email'), value('uprawnienia'));
	if (count($ERRORS) == 0) {
		clear_values();
	}
}

?>
