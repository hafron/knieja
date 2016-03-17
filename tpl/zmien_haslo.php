<?php if(error('change_password_no_empty')): ?>
	<div class="error">Nowe hasło nie może być puste.</div>
<?php elseif(error('change_password_not_match')): ?>
	<div class="error">Podałeś dwa różne hasła. Podaj dwa razy to samo hasło.</div>
<?php endif ?>

<div class="form_table from_table_login">
	<form action="?action=zmien_haslo" method="post">
		<div class="form login_form">
		<div class="row"><div class="cell">
			<div class="fields">
					<div class="row">
						<div class="cell">
							<label for="haslo">Nowe hasło:</label>
						</div>
						<div class="cell">
							<input id="haslo" name="haslo" type="password" value="<?php echo value('pseudonim') ?>" />
						</div>
					</div>
					<div class="row">
						<div class="cell">
							<label for="haslo_powt">Powtórz nowe hasło:</label>
						</div>			
						<div class="cell">
							<input id="haslo_powt" name="haslo_powt" type="password" />
						</div>
					</div>
			
			</div>
		</div></div>
		<div class="row"><div class="cell">
			<input type="submit" value="Zmień hasło" /> <a href="?action=index" class="cancel">Anuluj</a>
		</div></div>
	</div>
	</form>
</div>
