
<form action="?action=add" method="post">
	<label for="nazwa">Nazwa:</label>
	<input id="nazwa" name="nazwa" type="text" value="<?php echo value('nazwa') ?>" />
	<label for="poziom">Poziom:</label>
	<select id="poziom" name="poziom">
		<option value="1">Podstawowy</option>
		<option value="2">Zaawansowany</option>
		<option value="3">Mistrzowski</option>
	</select>
	<label for="bm">Bractwo małych:</label>
	<textarea name="bm"></textarea>
	<label for="bm">Bractwo wielkich:</label>
	<textarea name="bw"></textarea>
	
	<select id="kategoria" name="kategoria">
		<?php $result = $kategorie->get_all(); ?>
		<?php while($kategoria = $result->fetchArray()): ?>
			<option value="<?php echo $kategoria['id'] ?>"><?php echo $kategoria['nazwa'] ?></option>
		<? endwhile ?>
	</select>
	<input type="submit" value="Dodaj" />
</form>
