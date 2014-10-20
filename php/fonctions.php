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


	function getRecentQuestions($nb = 3) {

		global $dbh;
		$sql = "SELECT quest.id AS id, quest.titre AS titre, quest.user_id AS user_id, quest.scorequest AS scorequest, quest.vues AS vues, quest.dateCreated AS dateCreated, quest.dateModified AS dateModified, rep.dateModified, utilisateur.score 
				FROM quest
				LEFT JOIN rep ON rep.quest_id = quest.id
				JOIN utilisateur ON quest.user_id = utilisateur.id
				WHERE quest.published = :published
				LIMIT :nbQuestions";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":published", 1);
		$stmt->bindValue(":nbQuestions", $nb);
		$stmt->execute();
		$questions = $stmt->fetchAll();

		return $questions;

	}


	function getNbReponsesByIdQuestion($quest_id) {
		global $dbh;
		$sql = "SELECT COUNT(id) FROM rep
				WHERE quest_id = :quest_id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":quest_id", $quest_id);
		$stmt->execute();
		$nbRep = $stmt->fetchColumn();

		return $nbRep;
	}


	function isThereTheGoodAnswer($quest_id) {
		global $dbh;
		$sql = "SELECT best FROM rep
				WHERE quest_id = :quest_id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":quest_id", $quest_id);
		$stmt->execute();
		$verify = $stmt->fetch();

		if ($verify['best'] == 1) {
			return true;		
		}
		return false;
	}


	function getTagsByIdQuestion($quest_id) {
		global $dbh;
		$sql = "SELECT tag.tagname AS tagname, tag.id AS id
				FROM tag
				JOIN tag_quest ON tag_quest.tag_id = tag.id
				WHERE tag_quest.quest_id = :quest_id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":quest_id", $quest_id);
		$stmt->execute();
		$tags = $stmt->fetchAll();

		return $tags;		
	}



	function dateFr($date) {

		$dateFr = date('d-m-Y', strtotime($date));
		return $dateFr;
	}


			// Fonction qui vérifie si un tag existe déjà dans la BDD
	function tagExists($tag) {
		$result = false;

		global $dbh;
		$sql = "SELECT COUNT(tagname) AS nbtag
				FROM tag
				WHERE tagname = :tagname";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":tagname", $tag);
		$stmt->execute();
		$nb_tag = $stmt->fetch();

		if ($nb_tag['nbtag'] != 0) {
			$result = true;
		}
		return $result;
	}


			// Fonction 
	function getIdExistantTag($tagname) {

		global $dbh;
		$sql = "SELECT tagname, id FROM tag
				WHERE tagname = :tagname";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":tagname", $tagname);
		$stmt->execute();
		$tag = $stmt->fetch();

		return $tag["id"];
	}


	function insertTag_quest($id_tag, $id_question) {

		global $dbh;
		$sql = "INSERT INTO tag_quest (tag_id, quest_id)
				VALUES (:tag_id, :quest_id)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(":tag_id", $id_tag);
		$stmt->bindValue(":quest_id", $id_question);
		$stmt->execute();

	}