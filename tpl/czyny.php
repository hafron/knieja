<h1>Zarządzanie czynami</h1>
<?php if(error('czyny_delete_zdobywcy_exists')): ?>
	<div class="error">Nie można usunąć czynu, który posiada przypisanych zdobywców.</div>
<?php endif ?>
<table>
<tr>
	<th>Nazwa</th>
	<th>Poziom</th>
	<th>Światło</th>
	<th>Kategoria</th>
	<th>Opis</th>
	<th>Zdobywcy(pseudonim + data)</th>
</tr>
<?php $result = $czyny->get_all(); ?>
<?php while($czyn = $result->fetchArray()): ?>
<tr>
	<td><?php echo $czyn['nazwa'] ?></td>
	<td><?php echo $czyn['poziom'] ?></td>
	<td><?php echo $czyn['swiatlo'] ?></td>
	<td><?php echo $czyn['kategoria'] ?></td>
	<td><?php echo $czyn['opis'] ?></td>
	<td>
		<?php $zdobywcy = $czyny_harcerze->get($czyn['id']); ?>
		<?php while($zdobywca = $zdobywcy->fetchArray()): ?>
			<?php echo $zdobywca['harcerz'] ?> (<?php echo $zdobywca['data_przyznania'] ?>)
		<?php endwhile ?>
	</td>
	<td>
		<a href="?action=czyny&do=edytuj&id=<?php echo $czyn['id'] ?>">
			Edytuj
		</a>
		<a href="?action=czyny&do=usun&id=<?php echo $czyn['id'] ?>">
			Usuń
		</a>
	</td>
</tr>
<? endwhile ?>
</table>

<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
	<form action="?action=czyny&do=zapisz&id=<?php echo get('id') ?>" method="post">
<?php else: ?>
	<form action="?action=czyny" method="post">
<?php endif ?>
	<label for="nazwa">Nazwa:</label>
	<input id="nazwa" name="nazwa" type="text" value="<?php echo value('nazwa') ?>" />
	<label for="poziom">Poziom:</label>
	<select id="poziom" name="poziom">
		<option value="1" <?php if(value('poziom') == '1') echo 'selected' ?>>Podstawowy</option>
		<option value="2" <?php if(value('poziom') == '2') echo 'selected' ?>>Zaawansowany</option>
		<option value="3" <?php if(value('poziom') == '3') echo 'selected' ?>>Mistrzowski</option>
	</select>
	<label for="opis">Opis:</label>
	<textarea name="opis"><?php echo value('opis') ?></textarea>
	
	<select id="kategoria" name="kategoria">
		<?php $result = $kategorie->get_all(); ?>
		<?php while($kategoria = $result->fetchArray()): ?>
			<option <?php if(value('kategoria') == $kategoria['id']) echo 'selected' ?>
			value="<?php echo $kategoria['id'] ?>"><?php echo $kategoria['nazwa'] ?></option>
		<? endwhile ?>
	</select>
	<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
		<input type="submit" value="Popraw" />
	<?php else: ?>
		<input type="submit" value="Dodaj" />
	<?php endif ?>
</form>
