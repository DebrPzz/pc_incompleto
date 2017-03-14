<?php 
	require_once('lib/rb.php');
	
	date_default_timezone_set('Europe/Rome');
	
	R::setup('mysql:host=127.0.0.1;dbname=pc','root', 'root');
	R::freeze(TRUE);
	
	$pg=(empty($_REQUEST['p'])) ? 'home' : $_REQUEST['p'];
	$pg='pgs/'.$pg.'.php';
	
?>
<!doctype html>
<html lang="it">
  <head>
    <title>Manutenzione pc</title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" type="text/css" media="all" href="lib/bootstrap/css/bootstrap.min.css" />	
    <link rel="stylesheet" type="text/css" media="all" href="lib/bootstrap/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="lib/fontawesome/css/font-awesome.min.css" />
	
  </head>
  <body>
	<div id="all" class="all">
		<? if (file_exists($pg)) include_once($pg); ?>
	</div>
	<script src="lib/jquery/jquery-3.1.0.min.js"></script>
	<script src="lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="lib/jquery_datatable.js"></script>
  </body>
</html>
