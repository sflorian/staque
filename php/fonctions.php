<?php


		// Fonction qui redirige vers l'accueil
	function goUpload() {
		header("Location: upload.php");
		die(); 
	}

		// Fonction qui vérifie si un pseudo existe déjà dans la BDD
	function pseudoExists($pseudo) {
		$result = false;

		global $dbh;
		$sql = "SELECT COUNT(pseudo) AS nb
				FROM utilisateur
				WHERE pseudo = :pseudo";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":pseudo", $pseudo);
		$stmt->execute();
		$nb_pseudo = $stmt->fetch();
		if ($nb_pseudo['nb'] != 0) {
			$result = true;
		}
		return $result;
	}


		// Fonction qui vérifie si un email existe déjà dans la BDD
	function emailExists($email) {
		$result = false;

		global $dbh;
		$sql = "SELECT COUNT(email) AS nbe
				FROM utilisateur
				WHERE email = :email";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":email", $email);
		$stmt->execute();
		$nb_email = $stmt->fetch();

		if ($nb_email['nbe'] != 0) {
			$result = true;
		}
		return $result;
	}



		// Fonction qui génère aléatoirement une chaine de caractères (par défaut de 50 caractères)
	function randomString($length = 50) {
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		$string = "";
		for ($i=0; $i<$length;$i++) {
			$num = mt_rand(0, strlen($chars)-1);
			$string .= $chars[$num];
		}
		return $string;
	}



		// Fonction qui hache les mots de passe
	function hashPassword($password, $salt) {
		$pepper = "I2akzodw8xztMnn6RjjTE9x0IQTo91J0yW2NokMFu2pPRTVIuc";
		$hashedPassword = hash('sha512', $password);
		for ($i=0; $i<5000; $i++) {
			$hashedPassword = hash('sha512', $pepper . $password .$salt);
		}
		return $hashedPassword;
	}

