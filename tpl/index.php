<?php if (get('kom') == 'haslo_zmienione'): ?>
	<div class="success">Hasło zostało zmienione</div>
<?php elseif (get('kom') == 'haslo_zresetowane'): ?>
	<div class="success">Hasło zostało zresetowane. Nowe hasło zostało wysłane na twój adres e-mail.</div>
<?php endif ?>

<div id="main">
	<div id="left">
		<div id="lights" class="lights<?php echo $T['swiatlo'] ?>">
			<a href="?swiatlo=1" id="s1">Piękna</a>
			<a href="?swiatlo=2" id="s2">Prawdy</a>
			<a href="?swiatlo=3" id="s3">Siły</a>
			<a href="?swiatlo=4" id="s4">Miłości</a>
			<img src="img/notext/s<?php echo $T['swiatlo'] ?>.png" width="300" height="300" />
		</div>
		<div id="light_content">
		<div id="light_desc">
			<?php if($T['swiatlo'] == 1): ?>
				<strong>Pierwsze Światło jest światłem Piękna:</strong>
				<em>Zachowaj czystość siebie i miejsca, w którym żyjesz.</em>
				<em>Znaj i szanuj swoje ciało, jest bowiem siedzibą Twego Ducha.</em>
				<em>Bądź przyjacielem wszystkich nieszkodliwych stworzeń.</em>
				<em>Chroń drzewa i kwiaty oraz bądź gotów na walkę z pożarem w lesie i w mieście.</em>
				<p>Czyny tego Światła ukierunkowane są na sprawniść fizyczną, umiejętności sportowe, podróżnicze, kondycyjne.</p>
			<?php elseif($T['swiatlo'] == 2): ?>
				<strong>Drugie Światło jest światłem Prawdy:</strong>
				<em>Słowo honoru jest święte.</em>
				<em>Graj uczciwie. Nieuczciwa gra jest zdradą.</em>
				<em>Bądź pokorny. Czcij Wielkiego Ducha i respektuj wiarę innych.</em>
				<p>Czynt tego Światła ukierunkowane są na wiedzę i umiejętności umysłowe: znajomość dziedziny nauk przyrodniczych i humanistycznych, umiejętności porozuimewania się.</p>
			<?php elseif($T['swiatlo'] == 3): ?>
				<strong>Trzecie Światło jest światłem Siły:</strong>
				<em>Bądź odważny. Odwaga należt do najwspanialszych cnót.</em>
				<em>Milcz, kiedy mówią starsi i okazuj im szacunek również w inny sposób.</em>
				<em>Bądź posłuszny. Posłuszeństwo jest podstawowym obowiązkiem na drodze leśnej mądrości.</em>
				<p>Czyny tego Światła ukierunkowane są na uczucie, wyobraźnię, zmysł estetyczny, sztykę, zręczność, wytwarzanie różnych wyrobów, posiadanie różnych umiejętności, realizowanie działań artystycznych.</p>
			<?php elseif($T['swiatlo'] == 4): ?>
				<strong>Czwarte Światło jest światłem Miłości:</strong>
				<em>Bądź uprzejmy. Codziennie rób chociaż jeden dobry uczynek.</em>
				<em>Chętnie pomagaj innym. Pełnij swoje obowiązki.</em>
				<em>Bądź dobrej myśli. Ciesz się z tego, że żyjesz.</em>
				<p>Czyny tego Światła ukierunkowane są na służbę i pomoc (służba innym, drużynie, środowisku życia).</p>
			<?php endif ?>
		</div>
		<div class="czyny_list">
		<?php $result = $czyny->get_light($T['swiatlo']) ?>
		<?php $kategoria = '' ?>
		<?php while($czyn = $result->fetchArray()): ?>
			<?php if ($kategoria != $czyn['kategoria']): ?>
				<h1><?php echo $czyn['kategoria'] ?></h1>
				<?php $kategoria = $czyn['kategoria'] ?>
			<?php endif ?>
			<h2><?php echo $czyn['nazwa'] ?></h2>
			<div class="row">
				<div class="cell">
					<img src="img/p<?php echo $czyn['poziom'] ?>.png" width="50" height="50" />
				</div>
				<div class="cell">
					<p><?php echo nl2br($czyn['opis']) ?></p>
					<p>
						<strong>Zdobywcy: </strong>
						<?php $zdobywcy = $czyny_harcerze->get($czyn['id']); ?>
						<?php while($zdobywca = $zdobywcy->fetchArray()): ?>
							<?php echo $zdobywca['pseudonim'] ?>,
						<?php endwhile ?>
						<?php if (login_user_is_admin()): ?>
							<a href="?action=czyny_harcerze&czyn=<?php echo $czyn['id'] ?>
							&swiatlo=<?php echo $czyn['swiatlo'] ?>">Przyznaj czyn</a>
						<?php endif ?>
					</p>
				</div>
			</div>
		<?php endwhile ?>
		</div>
		<?php if (login_user_is_admin()): ?>
			<a href="?action=czyny&swiatlo=<?php echo $T['swiatlo'] ?>">Zarządzaj czynami</a>
			<a href="?action=kategorie&swiatlo=<?php echo $T['swiatlo'] ?>">Zarządzaj kategoriami</a>
		<?php endif ?>
		</div>
	</div>
	<div id="right">
		<h1>Moje czyny</h1>
		<?php if (!isset($_SESSION['login_row'])): ?>
			<p><a href="?action=zaloguj">Zaloguj</a> aby przejrzeć swoje czyny.</p>
		<?php else: ?>
<div class="czyny_list">
		<?php $result = $czyny_harcerze->get_harcerz($_SESSION['login_row']['id']) ?>
		<?php while($czyn = $result->fetchArray()): ?>
			<h2><?php echo $czyn['nazwa'] ?>
				<?php if ($czyn['swiatlo'] == 1) echo '(Światło piękna)' ?>
				<?php if ($czyn['swiatlo'] == 2) echo '(Światło prawdy)' ?>
				<?php if ($czyn['swiatlo'] == 3) echo '(Światło siły)' ?>
				<?php if ($czyn['swiatlo'] == 4) echo '(Światło miłości)' ?>
			</h2>
			<div class="row">
				<div class="cell">
					<img src="img/p<?php echo $czyn['poziom'] ?>.png" width="50" height="50" />
				</div>
				<div class="cell">
					<p><?php echo nl2br($czyn['opis']) ?></p>
					<p><strong>Data przyznania:</strong> <?php echo $czyn['data_przyznania'] ?></p>
					<p><?php echo nl2br($czyn['uwagi']) ?></p>
				</div>
			</div>
			
		<?php endwhile ?>
		</div>
		<?php endif ?>
	</div>
</div>
