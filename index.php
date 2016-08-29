<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<title>Księga Orlich Piór - 1 NGDH Knieja</title>
<link rel="stylesheet" type="text/css" href="zero.css" />
<link rel="stylesheet" type="text/css" href="screen.css" />
</head>
<body>
<?php
session_start();
$ERRORS = array();
include "helper.php";
include_once "mdl/harcerze.php";
$harcerze = new Harcerze();
include_once "mdl/czyny.php";
$czyny = new Czyny();
include_once "mdl/kategorie.php";
$kategorie = new Kategorie();
include_once "mdl/czyny_harcerze.php";
$czyny_harcerze = new Czyny_Harcerze();
?>


<div id="belka">
<?php if (session_login_row() != -1): ?>
	Czuwaj <strong><?php echo $_SESSION['login_row']['pseudonim'] ?></strong>! | 
<?php endif ?>

<a href="?action=index">Strona główna</a> | 

<?php if (session_login_row() != -1): ?>
	<?php if (login_user_is_admin()): ?>
		<a href="?action=harcerze">Zarządzaj harcerzami</a> | 
	<?php endif ?>
	<a href="?action=zmien_haslo">Zmień hasło</a> | 
	<a href="?action=wyloguj">Wyloguj</a>
<?php else: ?>
	<a href="?action=zaloguj">Zaloguj</a>
<?php endif ?> |
    <a href="?action=ksiega_pdf">Księga Czynów PDF</a>
</div>


<div id="content">
<?php
$action = 'index';
if (isset($_GET['action']) && preg_match('/^[[:alnum:]_]*$/ui', $_GET['action']) && file_exists("ctl/$_GET[action].php"))
	$action = $_GET['action'];

//tablica globalna dostępna dla template
$T = array();
$ctl = function() {
	global $ERRORS, $T, $action, $harcerze, $czyny, $kategorie, $czyny_harcerze;
	include "ctl/$action.php";
};
$ctl();

//start page rendering
ob_flush();
if (file_exists("tpl/$action.php"))
	include "tpl/$action.php";

?>
</div>
</body>
</html>
