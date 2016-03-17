<?php if(error('login_user_no_exists')): ?>
	<div class="error">Użytkownik o pseudonimie: "<strong><?php echo value('pseudonim') ?></strong>" nie istnieje w bazie.</div>
<?php elseif(error('login_wrong_password')): ?>
	<div class="error">Podałeś niepoprawne hasło.</div>
<?php endif ?>

<div class="form_table from_table_login">
		<form action="?action=zaloguj" method="post">
		<div class="form login_form">
		<div class="row"><div class="cell">
			<div class="fields">
				<div class="row">
					<div class="cell">
						<label for="pseudonim">Pseudonim:</label>
					</div>
					<div class="cell">
						<input id="pseudonim" name="pseudonim" type="text" value="<?php echo value('pseudonim') ?>" />
					</div>
				</div>
				<div class="row">
					<div class="cell">
						<label for="haslo">Hasło:</label>
					</div>			
					<div class="cell">
						<input id="haslo" name="haslo" type="password" />
					</div>
				</div>
			</div>
		</div></div>
		<div class="row"><div class="cell">
			<input type="submit" value="Zaloguj" />
		</div></div>
		</div>
		</form>
</div>
