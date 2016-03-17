<?php if(error('czyny_delete_zdobywcy_exists')): ?>
	<div class="error">Nie można usunąć czynu, który posiada przypisanych zdobywców.</div>
<?php endif ?>

<div class="form_table">
<h1>Zarządzanie czynami</h1>
<div class="filters">
<form action="" method="get">
<div class="form">
	<input type="hidden" name="action" value="czyny" />
	
	<label for="swiatlo">Światło:</label>
	<select id="swiatlo" name="swiatlo">
		<option value="" <?php if(get('swiatlo') == '') echo 'selected' ?>>-- wszystkie --</option>
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
	<th>Nazwa</th>
	<th>Poziom</th>
	<th>Światło</th>
	<th>Kategoria</th>
	<th>Opis</th>
	<th>Zdobywcy</th>
</tr>
<?php $result = $czyny->get_light(get('swiatlo'), get('harcerz')) ?>
<?php while($czyn = $result->fetchArray()): ?>
<tr>
	<td><?php echo $czyn['nazwa'] ?></td>
	<td><img src="img/p<?php echo $czyn['poziom'] ?>.png" width="50" height="50" /></td>
	<td>
		<?php if ($czyn['swiatlo'] == 1) echo 'Światło piękna' ?>
		<?php if ($czyn['swiatlo'] == 2) echo 'Światło prawdy' ?>
		<?php if ($czyn['swiatlo'] == 3) echo 'Światło siły' ?>
		<?php if ($czyn['swiatlo'] == 4) echo 'Światło miłości' ?>
	</td>
	<td><?php echo $czyn['kategoria'] ?></td>
	<td><?php echo nl2br($czyn['opis']) ?></td>
	<td>
		<ul>
		<?php $zdobywcy = $czyny_harcerze->get($czyn['id']); ?>
		<?php while($zdobywca = $zdobywcy->fetchArray()): ?>
			<li><?php echo $zdobywca['pseudonim'] ?> (<?php echo $zdobywca['data_przyznania'] ?>)</li>
		<?php endwhile ?>
			<li><a href="?action=czyny_harcerze&czyn=<?php echo $czyn['id'] ?>&swiatlo=<?php echo $czyn['swiatlo'] ?>">Przyznaj czyn</a></li>
		</ul>
	</td>
	<td>
		<a href="?action=czyny&swiatlo=<?php echo get('swiatlo') ?>&do=edytuj&id=<?php echo $czyn['id'] ?>">
			Edytuj
		</a>
		<?php if (get('zapytaj_usun') == $czyn['id']): ?>
			<a href="?action=czyny&swiatlo=<?php echo get('swiatlo') ?>&harcerz=<?php echo get('harcerz') ?>&do=usun&id=<?php echo $czyn['id'] ?>">
				Potwierdź usunięcie
			</a>
		<?php else: ?>
			<a href="?action=czyny&swiatlo=<?php echo get('swiatlo') ?>&harcerz=<?php echo get('harcerz') ?>&zapytaj_usun=<?php echo $czyn['id'] ?>">
				Usuń
			</a>
		<? endif ?>
	</td>
</tr>
<? endwhile ?>
</table>

<?php if(error('czyny_nazwa_not_empty')): ?>
	<div class="error">Podaj nazwę czynu.</div>
<?php endif ?>
<?php if(error('czyny_opis_not_empty')): ?>
	<div class="error">Podaj opis czynu.</div>
<?php endif ?>

<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
	<form action="?action=czyny&swiatlo=<?php echo get('swiatlo') ?>&do=zapisz&id=<?php echo get('id') ?>" method="post">
<?php else: ?>
	<form action="?action=czyny&swiatlo=<?php echo get('swiatlo') ?>" method="post">
<?php endif ?>
	<div class="form">
	
	<div class="row"><div class="cell">
	
	<div class="fields">
		<div class="row">
			<div class="cell"><label for="nazwa">Nazwa:</label></div>
			<div class="cell"><input id="nazwa" name="nazwa" type="text" value="<?php echo value('nazwa') ?>" /></div>
		</div>	
		<div class="row">
			<div class="cell"><label for="poziom">Poziom:</label></div>
			<div class="cell"><select id="poziom" name="poziom">
				<option value="1" <?php if(value('poziom') == '1') echo 'selected' ?>>Podstawowy</option>
				<option value="2" <?php if(value('poziom') == '2') echo 'selected' ?>>Zaawansowany</option>
				<option value="3" <?php if(value('poziom') == '3') echo 'selected' ?>>Mistrzowski</option>
			</select></div>
		</div>	
		<div class="row">
			<div class="cell"><label for="opis">Opis:</label></div>
			<div class="cell"><textarea name="opis"><?php echo value('opis') ?></textarea></div>
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
			<div class="cell"><label for="kategoria">Kategoria:</label></div>
			<div class="cell"><select id="kategoria" name="kategoria">
				<?php $result = $kategorie->get(get('swiatlo')); ?>
				<?php while($kategoria = $result->fetchArray()): ?>
					<option <?php if(value('kategoria') == $kategoria['id']) echo 'selected' ?>
					value="<?php echo $kategoria['id'] ?>"><?php echo $kategoria['nazwa'] ?></option>
				<? endwhile ?>
			</select> <a href="?action=kategorie&swiatlo=<?php echo get('swiatlo') ?>">Dodaj kategorię</a></div>
		</div>
	</div>
	
	</div></div>
	
	<div class="row"><div class="cell">
		<?php if (get('do') == 'edytuj' || get('do') == 'zapisz'): ?>
			<input type="submit" value="Popraw" />
		<?php else: ?>
			<input type="submit" value="Dodaj" />
		<?php endif ?>
		<a href="?action=czyny&swiatlo=<?php echo get('swiatlo') ?>" class="cancel">Anuluj</a>
	</div></div>
	</div>
</form>
</div>
