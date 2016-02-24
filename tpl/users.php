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
	<th><?php echo $harcerz['pseudonim'] ?></th>
	<th><?php echo $harcerz['email'] ?></th>
	<th><?php echo $harcerz['uprawnienia'] ?></th>
</tr>
<? endwhile ?>
</table>

<form action="?action=users" method="post">
	<label for="pseudonim">Pseudonim:</label>
	<input id="pseudonim" name="pseudonim" type="text" value="<?php echo value('pseudonim') ?>" />
	<label for="haslo">Hasło:</label>
	<input id="haslo" name="haslo" type="password" value="<?php echo value('haslo') ?>"/>
	<label for="email">Email:</label>
	<input id="email" name="email" type="text" value="<?php echo value('email') ?>"/>
	<label for="uprawnienia">Uprawnienia:</label>
	<select id="uprawnienia" name="uprawnienia">
		<option value="0">Administrator</option>
		<option value="5">Standardowe</option>
	</select>
	
	<input type="submit" value="Dodaj" />
</form>
