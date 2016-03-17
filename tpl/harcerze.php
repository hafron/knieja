<?php if(error('harcerze_delete_has_czyny')): ?>
	<div class="error">Nie możesz usunąć harcerza dopóki posiada on jakieś czyny.</div>
<?php endif ?>
<?php if (get('kom') == 'haslo_zmienione'): ?>
	<div class="success">Hasło zostało zmienione</div>
<?php endif ?>

<div class="form_table">
<h1>Zarządzanie harcerzami</h1>

<table>
<tr>
	<th>Pseudonim</th>
	<th>Adres e-mail</th>
	<th>Uprawnienia</th>
	<th>Czyny</th>
</tr>
<?php $result = $harcerze->get_users_list(); ?>
<?php while($harcerz = $result->fetchArray()): ?>
<tr>
	<td><?php echo $harcerz['pseudonim'] ?></td>
	<td><?php echo $harcerz['email'] ?></td>
	<td>
		<?php if ($harcerz['uprawnienia'] == 0): ?>
			Administraotr
		<?php else: ?>
			Standardowe
		<?endif ?>
	</td>
	<td>
		<?php $result2 = $czyny_harcerze->get_harcerz($harcerz['id']) ?>
		<ul>
		<?php while($czyn = $result2->fetchArray()): ?>
			<li><a href="?action=czyny&swiatlo=<?php echo $czyn['swiatlo'] ?>&hacerz=<?php echo $harcerz['id'] ?>"><?php echo $czyn['nazwa'] ?></a></li>
		<?php endwhile ?>
			<li><a href="?action=czyny_harcerze&harcerz=<?php echo $harcerz['id'] ?>">Przyznaj czyn</a></li>
		</ul>
	</td>
	<td>
		<a href="?action=harcerze&do=edytuj&id=<?php echo $harcerz['id'] ?>">
			Edytuj
		</a>
		<a href="?action=harcerze&do=zmien_haslo&id=<?php echo $harcerz['id'] ?>">
			Zmień hasło
		</a>
		<?php if (get('zapytaj_usun') == $harcerz['id']): ?>
			<a href="?action=harcerze&do=usun&id=<?php echo $harcerz['id'] ?>">
				Potwierdź usunięcie
			</a>
		<?php else: ?>
			<a href="?action=harcerze&zapytaj_usun=<?php echo $harcerz['id'] ?>">
				Usuń
			</a>
		<? endif ?>
	</td>
</tr>
<? endwhile ?>
</table>
<?php if(error('users_user_exists')): ?>
	<div class="error">Harcerz o pseudominie: "<strong><?php echo value('pseudonim') ?></strong>" istnieje już w bazie.</div>
<?php endif ?>
<?php if(error('users_no_pseudonim')): ?>
	<div class="error">Podaj pseudonim harcerza.</div>
<?php endif ?>
<?php if(error('users_no_haslo')): ?>
	<div class="error">Hasło nie może być puste.</div>
<?php endif ?>
<?php if(error('users_no_email')): ?>
	<div class="error">Podaj adres e-mail.</div>
<?php endif ?>
<?php if(error('users_email_invalid')): ?>
	<div class="error">Podaj poprawny adres e-mail.</div>
<?php endif ?>


<?php if (get('do') == 'zmien_haslo' || get('do') == 'popraw_haslo'): ?>
	<form action="?action=harcerze&do=popraw_haslo&id=<?php echo get('id') ?>" method="post">
	<div class="form">
		<div class="row"><div class="cell">
	
			<div class="fields">
				<div class="row">
					<div class="cell">
						<label for="haslo">Nowe hasło dla <?php echo $harcerze->pseudonim(get('id')) ?>:</label>
					</div>
					<div class="cell">
						<input id="haslo" name="haslo" type="password" value="<?php echo value('haslo') ?>"/>
					</div>
				</div>
			</div>
	
		</div></div>
		<div class="row"><div class="cell">
			<input type="submit" value="Popraw" /> <a href="?action=harcerze" class="cancel">Anuluj</a>
		</div></div>
	</div>
	</form>
<?php else: ?>
	<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
		<form action="?action=harcerze&do=zapisz&id=<?php echo get('id') ?>" method="post">
	<?php else: ?>
		<form action="?action=harcerze" method="post">
	<?php endif ?>
	<div class="form">
		<div class="row"><div class="cell">
			<div class="fields">
			<div class="row">
				<div class="cell"><label for="pseudonim">Pseudonim:</label></div>
				<div class="cell"><input id="pseudonim" name="pseudonim" type="text" value="<?php echo value('pseudonim') ?>" /></div>
			</div>
				<?php if (get('do') != 'edytuj' && get('do') != 'zapisz'): ?>
				<div class="row">
					<div class="cell"><label for="haslo">Hasło:</label></div>
					<div class="cell"><input id="haslo" name="haslo" type="password" value="<?php echo value('haslo') ?>"/></div>
				</div>
				<?php endif ?>

			<div class="row">
				<div class="cell"><label for="email">Adres e-mail:</label></div>
				<div class="cell"><input id="email" name="email" type="text" value="<?php echo value('email') ?>"/></div>
			</div>
			<div class="row">
				<div class="cell"><label for="uprawnienia">Uprawnienia:</label></div>
				<div class="cell"><select id="uprawnienia" name="uprawnienia">
					<option value="0" <?php if(value('uprawnienia') == '0') echo 'selected' ?>>Administrator</option>
					<option value="5" <?php if(value('uprawnienia') == '5') echo 'selected' ?>>Standardowe</option>
				</select></div>
			</div>
			</div>
		</div></div>
		<div class="row"><div class="cell">
			<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
				<input type="submit" value="Popraw" />
			<?php else: ?>
				<input type="submit" value="Dodaj" />
			<?php endif ?>
			<a href="?action=harcerze" class="cancel">Anuluj</a>
		</div></div>
	</div>
	</form>
<?php endif ?>
</div>
