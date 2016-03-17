
<?php if(error('kategorie_delete_czyny_exists')): ?>
	<div class="error">Nie można usunąć kategori, która posiada przpisane czyny.</div>
<?php endif ?>

<div class="form_table">
<h1>Zarządzanie kategoriami</h1>

<div class="filters">
<div class="form">
<form action="" method="get">
	<input type="hidden" name="action" value="kategorie" />
	<label for="swiatlo">Światło:</label>
	<select id="swiatlo" name="swiatlo">
		<option value="" <?php if(get('swiatlo') == '') echo 'selected' ?>>-- wszystkie --</option>
		<option value="1" <?php if(get('swiatlo') == '1') echo 'selected' ?>>Światło piękna</option>
		<option value="2" <?php if(get('swiatlo') == '2') echo 'selected' ?>>Światło prawdy</option>
		<option value="3" <?php if(get('swiatlo') == '3') echo 'selected' ?>>Światło siły</option>
		<option value="4" <?php if(get('swiatlo') == '4') echo 'selected' ?>>Światło miłości</option>
	</select>
	<input type="submit" value="Filtruj" />
	</div>
</form>
</div>
<table>
<tr>
	<th>Nazwa</th>
	<th>Swiatlo</th>
	<th>Czyny</th>
</tr>
<?php $result = $kategorie->get(get('swiatlo')); ?>
<?php while($kategoria = $result->fetchArray()): ?>
<tr>
	<td><?php echo $kategoria['nazwa'] ?></td>
	<td>
		<?php if ($kategoria['swiatlo'] == 1) echo 'Światło piękna' ?>
		<?php if ($kategoria['swiatlo'] == 2) echo 'Światło prawdy' ?>
		<?php if ($kategoria['swiatlo'] == 3) echo 'Światło siły' ?>
		<?php if ($kategoria['swiatlo'] == 4) echo 'Światło miłości' ?>
	</td>
	<td>
		<?php $czyny_res = $czyny->get($kategoria['id']); ?>
		<ul>
		<?php while($czyn = $czyny_res->fetchArray()): ?>
			<li><a href="?action=czyny&swiatlo=<?php echo get('swiatlo') ?>"><?php echo $czyn['nazwa'] ?></a></li>
		<?php endwhile ?>
		<li><a href="?action=czyny&swiatlo=<?php echo get('swiatlo') ?>&kategoria=<?php echo $kategoria['id'] ?>">Dodaj czyn</a></li>
		</ul>
	</td>
	<td>
		<a href="?action=kategorie&swiatlo=<?php echo get('swiatlo') ?>&do=edytuj&id=<?php echo $kategoria['id'] ?>">
			Edytuj
		</a>
		<?php if (get('zapytaj_usun') == $kategoria['id']): ?>
			<a href="?action=kategorie&swiatlo=<?php echo get('swiatlo') ?>&do=usun&id=<?php echo $kategoria['id'] ?>">
				Potwierdź usunięcie
			</a>
		<?php else: ?>
			<a href="?action=kategorie&swiatlo=<?php echo get('swiatlo') ?>&zapytaj_usun=<?php echo $kategoria['id'] ?>">
				Usuń
			</a>
		<? endif ?>
	</td>
</tr>
<? endwhile ?>
</table>

<?php if(error('kategorie_nazwa_not_empty')): ?>
	<div class="error">Nazwa kategorii nie może być pusta.</div>
<?php endif ?>

<?php if (get('do') == 'edytuj'): ?>
	<form action="?action=kategorie&swiatlo=<?php echo get('swiatlo') ?>&do=zapisz&id=<?php echo get('id') ?>" method="post">
<?php else: ?>
	<form action="?action=kategorie&swiatlo=<?php echo get('swiatlo') ?>" method="post">
<?php endif ?>
	<div class="form">
	<div class="row"><div class="cell">
	<div class="fields">
		<div class="row">
		<div class="cell"><label for="nazwa">Nazwa:</label></div>
		<div class="cell"><input id="nazwa" name="nazwa" type="text" value="<?php echo value('nazwa') ?>" /></div>
		</div>
		
		<div class="row">
		<div class="cell"><label for="swiatlo">Światło:</label></div>
		<div class="cell"><select id="swiatlo" name="swiatlo">
			<?php if(value('swiatlo') == ''): ?>
				<option value="1" <?php if(get('swiatlo') == '1') echo 'selected' ?>>Światło piękna</option>
				<option value="2" <?php if(get('swiatlo') == '2') echo 'selected' ?>>Światło prawdy</option>
				<option value="3" <?php if(get('swiatlo') == '3') echo 'selected' ?>>Światło siły</option>
				<option value="4" <?php if(get('swiatlo') == '4') echo 'selected' ?>>Światło miłości</option>
			<?php else: ?>
				<option value="1" <?php if(value('swiatlo') == '1') echo 'selected' ?>>Światło piękna</option>
				<option value="2" <?php if(value('swiatlo') == '2') echo 'selected' ?>>Światło prawdy</option>
				<option value="3" <?php if(value('swiatlo') == '3') echo 'selected' ?>>Światło siły</option>
				<option value="4" <?php if(value('swiatlo') == '4') echo 'selected' ?>>Światło miłości</option>
			<?php endif ?>
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
		<a href="?action=kategorie" class="cancel">Anuluj</a>
	</div></div>
	</div>
</form>
</div>
