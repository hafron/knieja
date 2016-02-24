<?php if(error('login_user_no_exists')): ?>
	<div class="error">Użytkownik o pseudonimie: "<strong><?php echo value('pseudonim') ?></strong>" nie istnieje w bazie.</div>
<?php elseif(error('login_wrong_password')): ?>
	<div class="error">Podałeś niepoprawne hasło.</div>
<?php endif ?>

<form action="?action=login" method="post">
	<label for="pseudonim">Pseudonim:</label>
	<input id="pseudonim" name="pseudonim" type="text" value="<?php echo value('pseudonim') ?>" />
	<label for="haslo">Hasło:</label>
	<input id="haslo" name="haslo" type="password" />
	<input type="submit" value="Zaloguj" />
</form>
