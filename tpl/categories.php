<h1>Zarządzanie kategoriami</h1>

<table>
<tr>
	<th>Nazwa</th>
	<th>Światło</th>
</tr>
<?php $result = $kategorie->get_all(); ?>
<?php while($kategoria = $result->fetchArray()): ?>
<tr>
	<th><?php echo $kategoria['nazwa'] ?></th>
	<th><?php echo $kategoria['swiatlo'] ?></th>
</tr>
<? endwhile ?>
</table>

<form action="?action=categories" method="post">
	<label for="nazwa">Nazwa:</label>
	<input id="nazwa" name="nazwa" type="text" value="<?php echo value('nazwa') ?>" />
	<label for="swiatlo">Światło:</label>
	<select id="swiatlo" name="swiatlo">
		<option value="1">Światło piękna</option>
		<option value="2">Światło prawdy</option>
		<option value="3">Światło siły</option>
		<option value="4">Światło miłości</option>
	</select>
	
	<input type="submit" value="Dodaj" />
</form>
