<h1>Zarządzanie harcerzami</h1>

<?php if(error('users_user_exists')): ?>
	<div class="error">Harcerz o pseudominie: "<strong><?php echo value('pseudonim') ?></strong>" istnieje już w bazie.</div>
<?php endif ?>

<table>
<tr>
	<th>Pseudonim</th>
	<th>Email</th>
	<th>Uprawnienia</th>
</tr>
<?php $result = $harcerze->get_users_list(); ?>
<?php while($harcerz = $result->fetchArray()): ?>
<tr>
	<td><?php echo $harcerz['pseudonim'] ?></td>
	<td><?php echo $harcerz['email'] ?></td>
	<td><?php echo $harcerz['uprawnienia'] ?></td>
	<td>
		<a href="?action=harcerze&do=edytuj&id=<?php echo $harcerz['id'] ?>">
			Edytuj
		</a>
		<a href="?action=harcerze&do=zmien_haslo&id=<?php echo $harcerz['id'] ?>">
			Zmień hasło
		</a>
		<a href="?action=harcerze&do=usun&id=<?php echo $harcerz['id'] ?>">
			Usuń
		</a>
	</td>
</tr>
<? endwhile ?>
</table>
<?php if (get('do') == 'zmien_haslo' || get('do') == 'popraw_haslo'): ?>
	<form action="?action=harcerze&do=popraw_haslo&id=<?php echo get('id') ?>" method="post">
		<label for="haslo">Hasło:</label>
		<input id="haslo" name="haslo" type="password" value="<?php echo value('haslo') ?>"/>
		<input type="submit" value="Popraw" />
	</form>
<?php else: ?>
	<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
		<form action="?action=harcerze&do=zapisz&id=<?php echo get('id') ?>" method="post">
	<?php else: ?>
		<form action="?action=harcerze" method="post">
	<?php endif ?>
		<label for="pseudonim">Pseudonim:</label>
		<input id="pseudonim" name="pseudonim" type="text" value="<?php echo value('pseudonim') ?>" />
		<?php if (get('do') != 'edytuj' && get('do') != 'zapisz'): ?>
			<label for="haslo">Hasło:</label>
			<input id="haslo" name="haslo" type="password" value="<?php echo value('haslo') ?>"/>
		<?php endif ?>
		<label for="email">Email:</label>
		<input id="email" name="email" type="text" value="<?php echo value('email') ?>"/>
		<label for="uprawnienia">Uprawnienia:</label>
		<select id="uprawnienia" name="uprawnienia">
			<option value="0" <?php if(value('uprawnienia') == '0') echo 'selected' ?>>Administrator</option>
			<option value="5" <?php if(value('uprawnienia') == '5') echo 'selected' ?>>Standardowe</option>
		</select>
	
		<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
			<input type="submit" value="Popraw" />
		<?php else: ?>
			<input type="submit" value="Dodaj" />
		<?php endif ?>
	</form>
<?php endif ?>

