<?php


		// Fonction qui redirige vers l'accueil
	function goHome($message) {
		header("Location: ?page=accueil" . $message);
		die(); 
	}


		// Fonction qui récupère pays et langue(s) officielle(s)
	function getPaysLangue() {

		global $dbh;
		$sql = "SELECT country.name AS pays, countrylanguage.language AS langue, country.code AS code
				FROM country 
				JOIN countrylanguage ON countrylanguage.countryCode = country.code 
				WHERE countrylanguage.isOfficial = :param
				GROUP BY country.code
				ORDER BY country.name ASC";  
		$stmt = $dbh->prepare( $sql ); 
		$stmt->bindValue(":param", "T");
		$stmt->execute();
		$ps = $stmt->fetchAll();

		return $ps;
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



		// Fonction qui récupère un utilisateur par ID
	function getUserById($id) {

		global $dbh;

		$sql = "SELECT * FROM utilisateur  
				WHERE id = :id";  
		$stmt = $dbh->prepare( $sql ); 
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$utilisateur = $stmt->fetch();

		return $utilisateur;
	}


		// Fonction qui vérifie connexion ou non
	function userIsLogged() {
		if(!empty($_SESSION['utilisateur'])) {
			return true;
		}
		return false;
	}

		// Fonction qui connect un utilisateur par son ID
	function connectUser($utilisateur) {
		$_SESSION['utilisateurTrouve'] = true;
		$_SESSION['utilisateur'] = $utilisateur;
	}


		// Fonction qui redirige vers l'accueil
	function goUpload() {
		header("Location: upload.php");
		die(); 
	}




		// Fonction qui récupère l'utilisateur par son pseudo ou email
	function getUserByPseudoOrEmail($pseudoEmail) {
		global $dbh;
		$sql = "SELECT *
				FROM utilisateur
				WHERE email = :pseudoEmail OR pseudo = :pseudoEmail";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":pseudoEmail", $pseudoEmail);
		$stmt->execute();
		$utilisateur = $stmt->fetch();

		return $utilisateur;
	}


		// Fonction qui récupère un utilisateur par son email dans la BDD
	function getUserByEmail($email) {
		global $dbh;
		$sql = "SELECT *
				FROM utilisateur
				WHERE email = :email";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":email", $email);
		$stmt->execute();
		$utilisateur = $stmt->fetch();

		return $utilisateur;		
	}




		// Fonction qui vérifie si l'email et le token match dans la BDD
	function foundUser($email, $token) {

		global $dbh;
		$sql = "SELECT *
				FROM utilisateur
				WHERE email = :email AND token = :token";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":email", $email);
		$stmt->bindValue(":token", $token);
		$stmt->execute();
		$foundUser = $stmt->fetch();

		return $foundUser;
	}