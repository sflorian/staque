<?php

	session_start();
	include("db.php");
	include("fonctions_connexion.php");
	include("fonctions_redirection.php");
	include("fonctions_question.php");
	include("fonctions_tag.php");
	include("fonctions_utiles.php");
	include("fonctions_reponse.php");
	include("fonctions_comment.php");

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
		goHome();
	}



	include("inc/footer.php");
	include("inc/script.php");