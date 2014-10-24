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
		header('refresh:10; url='.$url);
		echo "<div id='lamatrice'></div><img id='morpheus' src='../img/matrix/morpheus.png'/><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		include('inc/footer.php');
		include('inc/script.php');
		die(); 
	}

		// Fonction qui redirige vers l'url
	function goBack($url) {
		header("Location: $url");
		die(); 
	}