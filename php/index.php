<?php

	session_start();
	include("db.php");
	include("fonctions.php");

	$page = "home";
	if (!empty($_GET['page'])) {
		$page = $_GET['page'];
	}

	include("inc/top.php");
	include("inc/head.php");

	// Toujours nommer mes fichiers comme la page
	$path = "pages/".$page.".php";
	if (file_exists($path)) {
		include($path);
	}
	else {
		die("404");
	}


	include("inc/footer.php");
	include("inc/script.php");