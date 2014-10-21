<?php



		// Fonction qui redirige vers l'accueil
	function goHome($message) {
		header("Location: ?page=accueil" . $message);
		die(); 
	}


		// Fonction qui redirige vers la page de chargement photo profil
	function goUpload() {
		header("Location: upload.php");
		die(); 
	}

