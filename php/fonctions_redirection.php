<?php



		// Fonction qui redirige vers l'accueil
	function goHome($message = "") {
		header("Location: ?page=accueil" . $message);
		die(); 
	}


		// Fonction qui redirige vers la page de chargement photo profil
	function goUpload() {
		header("Location: ?page=modifierUnePhoto");
		die(); 
	}

	function goProfil($id) {
		header("Location: ?page=profil&id=" . $id);
		die(); 
	}


		// Fonction qui redirige vers l'accueil si l'utilisateur veut accéder à une page sensible sans être connecté
	function forbidden(){
		$interdit = true;
		$url = "?page=accueil";
		header('refresh:5; url='.$url);
		die("VOUS N'AVEZ PAS LE DROIT D'ACCÉDER À CETTE PAGE SANS ÊTRE CONNECTÉ À CE COMPTE!<br>VOUS SEREZ REDIRIGÉ VERS LA PAGE D'ACCUEIL DANS 5 SECONDES.");
	}


		// Fonction qui redirige vers l'url
	function goBack($url) {
		header("Location: $url");
		die(); 
	}