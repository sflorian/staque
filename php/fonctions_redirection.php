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

		// Fonction qui redirige vers l'accueil si l'utilisateur veut accéder à une page sensible sans être connecté
	/*function forbidden(){
		if(!userIsLogged()){
		$interdit = true;
		die("VOUS N'AVEZ PAS LE DROIT D'ACCÉDER À CETTE PAGE SANS ÊTRE CONNECTÉ!<br>VOUS SEREZ REDIRIGÉ VERS LA PAGE D'ACCUEIL DANS 10 SECONDES.");
		}
	}*/