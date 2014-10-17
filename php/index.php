<?php

	session_start();
	include("db.php");
	include("requetes.php");
	include("fonctions.php");

	$page = "home";
	if (!empty($_GET['page'])) {
		$page = $_GET['page'];
	}

	// Toujours nommer mes fichiers comme la page
	$path = "pages/".$page.".php";
	if (file_exists($path)) {
		include($path);
	}
	else {
		die("404");
	}