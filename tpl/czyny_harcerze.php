<h1>Przyznawanie czynów</h1>
<?php if(error('czyny_delete_zdobywcy_exists')): ?>
	<div class="error">Nie można usunąć czynu, który posiada przypisanych zdobywców.</div>
<?php endif ?>
<table>
<tr>
	<th>Harcerz</th>
	<th>Poziom czynu</th>
	<th>Nazwa czynu</th>
	<th>Data przyznania</th>
	<th>Osoba przyznająca</th>
	<th>Uwagi</th>
</tr>
<?php $result = $czyny_harcerze->get_all(); ?>
<?php while($czyn_harcerz = $result->fetchArray()): ?>
<tr>
	<td><?php echo $czyn_harcerz['harcerz'] ?></td>
	<td><?php echo $czyn_harcerz['poziom'] ?></td>
	<td><?php echo $czyn_harcerz['nazwa'] ?></td>
	<td><?php echo $czyn_harcerz['data_przyznania'] ?></td>
	<td><?php echo $czyn_harcerz['osoba_przyznajaca'] ?></td>
	<td><?php echo $czyn_harcerz['uwagi'] ?></td>
	<td>
		<a href="?action=czyny_harcerze&do=edytuj&id=<?php echo $czyn_harcerz['id'] ?>">
			Edytuj
		</a>
		<a href="?action=czyny_harcerze&do=usun&id=<?php echo $czyn_harcerz['id'] ?>">
			Usuń
		</a>
	</td>
</tr>
<? endwhile ?>
</table>

<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
	<form action="?action=czyny_harcerze&do=zapisz&id=<?php echo get('id') ?>" method="post">
<?php else: ?>
	<form action="?action=czyny_harcerze " method="post">
<?php endif ?>
	<label for="harcerz">Harcerz:</label>
	<select id="harcerz" name="harcerz">
		<?php $result = $harcerze->get_users_list(); ?>
		<?php while($harcerz = $result->fetchArray()): ?>
			<option <?php if(value('harcerz') == $harcerz['id']) echo 'selected' ?>
			value="<?php echo $harcerz['id'] ?>"><?php echo $harcerz['pseudonim'] ?></option>
		<? endwhile ?>
	</select>
	<label for="czyn">Czyn:</label>
	<select id="czyn" name="czyn">
		<?php $result = $czyny->get_all(); ?>
		<?php while($czyn = $result->fetchArray()): ?>
			<option <?php if(value('czyn') == $czyn['id']) echo 'selected' ?>
			value="<?php echo $czyn['id'] ?>"><?php echo $czyn['nazwa'] ?> - <?php echo $czyn['poziom'] ?></option>
		<? endwhile ?>
	</select>
	
	<label for="data_przyznania">Data przyznania:</label>
	<input id="data_przyznania" name="data_przyznania" type="text" value="<?php echo value('data_przyznania') ?>" />
	
	<label for="osoba_przyznajaca">Osoba przyznająca:</label>
	<select id="osoba_przyznajaca" name="osoba_przyznajaca">
		<?php $result = $harcerze->get_users_list(); ?>
		<?php while($harcerz = $result->fetchArray()): ?>
			<option <?php if(value('osoba_przyznajaca') == $harcerz['id']) echo 'selected' ?>
			value="<?php echo $harcerz['id'] ?>"><?php echo $harcerz['pseudonim'] ?></option>
		<? endwhile ?>
	</select>
	
	<label for="uwagi">Uwagi:</label>
	<textarea name="uwagi"><?php echo value('uwagi') ?></textarea>

	<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
		<input type="submit" value="Popraw" />
	<?php else: ?>
		<input type="submit" value="Dodaj" />
	<?php endif ?>
</form>
