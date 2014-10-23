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
	
	$tabTags = getTags();

	// Si c'est de l'ajax !
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		// Toujours nommer mes fichiers comme la page
		$path = "pages/".$page.".php"; // path ajax...
		if (file_exists($path)) {
			include($path);
		}	
		die();	
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