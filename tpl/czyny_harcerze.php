
<?php if(error('czyny_delete_zdobywcy_exists')): ?>
	<div class="error">Nie można usunąć czynu, który posiada przypisanych zdobywców.</div>
<?php endif ?>
<div class="form_table">
<h1>Przyznawanie czynów</h1>

<div class="filters">
<form action="" method="get">
<div class="form">
	<input type="hidden" name="action" value="czyny_harcerze" />
	<input type="hidden" name="czyn" value="<?php echo get('czyn') ?>" />
	
	<label for="swiatlo">Światło:</label>
	<select id="swiatlo" name="swiatlo">
		<option value="" <?php if(get('swiatlo') == '-1') echo 'selected' ?>>-- wszystkie --</option>
		<option value="1" <?php if(get('swiatlo') == '1') echo 'selected' ?>>Światło piękna</option>
		<option value="2" <?php if(get('swiatlo') == '2') echo 'selected' ?>>Światło prawdy</option>
		<option value="3" <?php if(get('swiatlo') == '3') echo 'selected' ?>>Światło siły</option>
		<option value="4" <?php if(get('swiatlo') == '4') echo 'selected' ?>>Światło miłości</option>
	</select>
	<label for="harcerz">Zdobywca:</label>
	<select id="harcerz" name="harcerz">
		<option value="" <?php if(get('harcerz') == '') echo 'selected' ?>>-- dowolny --</option>
		<?php $result = $harcerze->get_users_list(); ?>
		<?php while($harcerz = $result->fetchArray()): ?>
			<option <?php if(get('harcerz') == $harcerz['id']) echo 'selected' ?>
			value="<?php echo $harcerz['id'] ?>"><?php echo $harcerz['pseudonim'] ?></option>
		<? endwhile ?>
	</select>
	<input type="submit" value="Filtruj" />
	
</div>
</form>
</div>

<table>
<tr>
	<th>Zdobywca</th>
	<th>Poziom czynu</th>
	<th>Światło</th>
	<th>Kategoria</th>
	<th>Nazwa czynu</th>
	<th>Data przyznania</th>
	<th>Osoba przyznająca</th>
	<th>Uwagi</th>
</tr>
<?php $result = $czyny_harcerze->get_all(get('swiatlo'), get('harcerz')); ?>
<?php while($czyn_harcerz = $result->fetchArray()): ?>
<tr>
	<td><?php echo $czyn_harcerz['harcerz'] ?></td>
	<td><img src="img/p<?php echo $czyn_harcerz['poziom'] ?>.png" width="50" height="50" /></td>
	<td><a href="?action=czyny&swiatlo=<?php echo $czyn_harcerz['swiatlo'] ?>">
		<?php if ($czyn_harcerz['swiatlo'] == 1) echo 'Światło piękna' ?>
		<?php if ($czyn_harcerz['swiatlo'] == 2) echo 'Światło prawdy' ?>
		<?php if ($czyn_harcerz['swiatlo'] == 3) echo 'Światło siły' ?>
		<?php if ($czyn_harcerz['swiatlo'] == 4) echo 'Światło miłości' ?>
		</a>
	</td>
	<td><a href="?action=czyny&swiatlo=<?php echo $czyn_harcerz['swiatlo'] ?>"><?php echo $czyn_harcerz['kategoria_nazwa'] ?></td>
	<td><a href="?action=czyny&swiatlo=<?php echo $czyn_harcerz['swiatlo'] ?>"><?php echo $czyn_harcerz['nazwa'] ?></a></td>
	<td><?php echo $czyn_harcerz['data_przyznania'] ?></td>
	<td><?php echo $czyn_harcerz['osoba_przyznajaca'] ?></td>
	<td><?php echo nl2br($czyn_harcerz['uwagi']) ?></td>
	<td>
		<a href="?action=czyny_harcerze&do=edytuj&id=<?php echo $czyn_harcerz['id'] ?>">
			Edytuj
		</a>
		<?php if (get('zapytaj_usun') == $czyn_harcerz['id']): ?>
			<a href="?action=czyny_harcerze&swiatlo=<?php echo get('swiatlo') ?>&harcerz=<?php echo get('harcerz') ?>&do=usun&id=<?php echo $czyn_harcerz['id'] ?>">
				Potwierdź usunięcie
			</a>
		<?php else: ?>
			<a href="?action=czyny_harcerze&swiatlo=<?php echo get('swiatlo') ?>&harcerz=<?php echo get('harcerz') ?>&zapytaj_usun=<?php echo $czyn_harcerz['id'] ?>">
				Usuń
			</a>
		<? endif ?>
	</td>
</tr>
<? endwhile ?>
</table>

<?php if(error('czyny_harcerze_data_not_empty')): ?>
	<div class="error">Data przyznania nie może być pusta.</div>
<?php endif ?>

<?php if(error('czyny_harcerze_data_invalid')): ?>
	<div class="error">Podaj poprawną datę przyznania.</div>
<?php endif ?>

<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
	<form action="?action=czyny_harcerze&swiatlo=<?php echo get('swiatlo') ?>&harcerz=<?php echo get('harcerz') ?>&do=zapisz&id=<?php echo get('id') ?>" method="post">
<?php else: ?>
	<form action="?action=czyny_harcerze&swiatlo=<?php echo get('swiatlo') ?>&harcerz=<?php echo get('harcerz') ?> " method="post">
<?php endif ?>
	<div class="form">
	<div class="row"><div class="cell">
	<div class="fields">
		<div class="row">
			<div class="cell"><label for="harcerz">Zdobywca:</label></div>
			<div class="cell"><select id="harcerz" name="harcerz">
				<?php $result = $harcerze->get_users_list(); ?>
				<?php while($harcerz = $result->fetchArray()): ?>
					<option <?php if(value('harcerz') == $harcerz['id']) echo 'selected' ?>
					value="<?php echo $harcerz['id'] ?>"><?php echo $harcerz['pseudonim'] ?></option>
				<? endwhile ?>
			</select></div>
		</div>
		<div class="row">
			<div class="cell"><label for="opis">Światło:</label></div>
			<div class="cell">
				<strong>
				<?php if (get('swiatlo') == '') echo '-- wszystkie --' ?>
				<?php if (get('swiatlo') == 1) echo 'Światło piękna' ?>
				<?php if (get('swiatlo') == 2) echo 'Światło prawdy' ?>
				<?php if (get('swiatlo') == 3) echo 'Światło siły' ?>
				<?php if (get('swiatlo') == 4) echo 'Światło miłości' ?>
				</strong>
			</div>
		</div>
		<div class="row">
			<div class="cell"><label for="czyn">Czyn:</label></div>
			<div class="cell"><select id="czyn" name="czyn">
				<?php $result = $czyny->get_all(get('swiatlo')); ?>
				<?php while($czyn = $result->fetchArray()): ?>
					<option <?php if(value('czyn') == $czyn['id']) echo 'selected' ?>
					value="<?php echo $czyn['id'] ?>"><?php echo $czyn['nazwa'] ?> - <?php echo $czyn['poziom'] ?></option>
				<? endwhile ?>
			</select></div>
		</div>
		
		<div class="row">
			<div class="cell"><label for="data_przyznania">Data przyznania:</label></div>
			<div class="cell"><input id="data_przyznania" name="data_przyznania" type="text" value="<?php echo value('data_przyznania') ?>" /></div>
		</div>
	
		<div class="row">
			<div class="cell"><label for="osoba_przyznajaca">Osoba przyznająca:</label></div>
			<div class="cell"><select id="osoba_przyznajaca" name="osoba_przyznajaca">
				<?php $result = $harcerze->get_users_list(); ?>
				<?php while($harcerz = $result->fetchArray()): ?>
					<option <?php if(value('osoba_przyznajaca') == $harcerz['id']) echo 'selected' ?>
					value="<?php echo $harcerz['id'] ?>"><?php echo $harcerz['pseudonim'] ?></option>
				<? endwhile ?>
			</select></div>
		</div>
		
		<div class="row">
			<div class="cell"><label for="uwagi">Uwagi:</label></div>
			<div class="cell"><textarea name="uwagi"><?php echo value('uwagi') ?></textarea></div>
		</div>

	<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
		<input type="submit" value="Popraw" />
	<?php else: ?>
		<input type="submit" value="Dodaj" />
	<?php endif ?>
	<a href="?action=kategorie" class="cancel">Anuluj</a>
	</div>
</form>

</div>
