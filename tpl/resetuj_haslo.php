<?php if(error('login_user_no_exists')): ?>
	<div class="error">Użytkownik o pseudonimie: "<strong><?php echo value('pseudonim') ?></strong>" nie istnieje w bazie.</div>
<?php endif ?>

<div class="form_table from_table_login">
		<form action="?action=resetuj_haslo" method="post">
		<div class="form login_form">
		<div class="row"><div class="cell">
			<div class="fields">
				<div class="row">
					<div class="cell">
						<label for="pseudonim">Pseudonim:</label>
					</div>
					<div class="cell">
						<input id="pseudonim" name="pseudonim" type="text" value="<?php echo value('pseudonim', get('pseudonim')) ?>" />
					</div>
				</div>
			</div>
		</div></div>
		<div class="row"><div class="cell">
			<input type="submit" value="Resetuj hasło" />
		</div></div>
		</div>
		</form>
</div>
