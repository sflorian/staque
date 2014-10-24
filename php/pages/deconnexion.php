<?php

	session_start();
	// Je détruis la variable de session
	session_destroy();
	// détruit le cookie
	setcookie("PHPSESSID", "", 0);
	// on détruit la variable
	unset($_SESSION);
	// Je réoriente sur la page d'accueil
	header("Location: index.php");
	die("<span id='green'>VOUS SORTEZ DE LA MATRICE</span>");