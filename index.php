<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<title>Księga Orlich Piór - 1 NGDH Knieja</title>
<style>
/* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}

</style>
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

$action = 'index';
if (isset($_GET['action']) && preg_match('/^[[:alnum:]_]*$/ui', $_GET['action']) && file_exists("ctl/$_GET[action].php"))
	$action = $_GET['action'];

$ctl = function() {
	global $ERRORS, $action, $harcerze, $czyny, $kategorie;
	include "ctl/$action.php";
};
$ctl();

if (file_exists("tpl/$action.php"))
	include "tpl/$action.php";

?>
</body>
</html>
