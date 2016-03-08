<h1>Zarządzanie kategoriami</h1>
<?php if(error('kategorie_delete_czyny_exists')): ?>
	<div class="error">Nie można usunąć kategori, która posiada przpisane czyny.</div>
<?php endif ?>
<table>
<tr>
	<th>Nazwa</th>
	<th>Światło</th>
	<th>Czyny</th>
</tr>
<?php $result = $kategorie->get_all(); ?>
<?php while($kategoria = $result->fetchArray()): ?>
<tr>
	<td><?php echo $kategoria['nazwa'] ?></td>
	<td><?php echo $kategoria['swiatlo'] ?></td>
	<td>
		<?php $czyny_res = $czyny->get($kategoria['id']); ?>
		<?php while($czyn = $czyny_res->fetchArray()): ?>
			<?php echo $czyn['nazwa'] ?>
		<?php endwhile ?>
	</td>
	<td>
		<a href="?action=kategorie&do=edytuj&id=<?php echo $kategoria['id'] ?>">
			Edytuj
		</a>
		<a href="?action=kategorie&do=usun&id=<?php echo $kategoria['id'] ?>">
			Usuń
		</a>
	</td>
</tr>
<? endwhile ?>
</table>

<?php if (get('do') == 'edytuj'): ?>
	<form action="?action=kategorie&do=zapisz&id=<?php echo get('id') ?>" method="post">
<?php else: ?>
	<form action="?action=kategorie" method="post">
<?php endif ?>
	<label for="nazwa">Nazwa:</label>
	<input id="nazwa" name="nazwa" type="text" value="<?php echo value('nazwa') ?>" />
	<label for="swiatlo">Światło:</label>
	<select id="swiatlo" name="swiatlo">
		<option value="1">Światło piękna</option>
		<option value="2">Światło prawdy</option>
		<option value="3">Światło siły</option>
		<option value="4">Światło miłości</option>
	</select>
	
	<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
		<input type="submit" value="Popraw" />
	<?php else: ?>
		<input type="submit" value="Dodaj" />
	<?php endif ?>
</form>
