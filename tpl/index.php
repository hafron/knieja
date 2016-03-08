<div id="main">
	<div id="left">
		<?php if (login_user_is_admin()): ?>
			<a href="?action=czyny">Dodaj nowy czyn</a>
		<?php endif ?>
	</div>
	<div id="right">
		<h1>Moje czyny</h1>
		<?php if (!isset($_SESSION['login_row'])): ?>
			<a href="?action=zaloguj">Zaloguj</a> aby przejrzeć swoje czyny.
		<?php endif ?>
		<?php if (isset($_SESSION['login_row'])): ?>
			<a href="?action=wyloguj">Wyloguj</a>
		<?php endif ?>
	</div>
</div>
