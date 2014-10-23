<?php


	function getNbReponsesByIdQuestion($quest_id) {
		global $dbh;
		$sql = "SELECT COUNT(id) FROM rep
				WHERE quest_id = :quest_id AND published = 1";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":quest_id", $quest_id);
		$stmt->execute();
		$nbRep = $stmt->fetchColumn();

		return $nbRep;
	}

	function getReponsesByIdQuestion($id) {
		global $dbh;
		$sql = "SELECT * FROM rep
				WHERE quest_id = :id AND published = 1
				/*ORDER BY best ASC*/
				ORDER BY scoreRep, best DESC";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$reponses = $stmt->fetchAll();

		return $reponses;			
	}

	function updateScoreUserAfterAnswer($id_utilisateur) {
		// récupère le score de l'utilisateur
		global $dbh;
		$sql = "SELECT score FROM utilisateur
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id_utilisateur);
		$stmt->execute();
		$score = $stmt->fetch();

		$score = $score['score'] + 4;

		// met à jour le score de l'utilisateur
		$sql = "UPDATE utilisateur
				SET score = :score
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );
		$stmt->bindValue(":score", $score);
		$stmt->bindValue(":id", $id_utilisateur);
		$stmt->execute();	
	}

	function userVoteOnHisAnswer($id_utilisateur, $id_rep) {
		global $dbh;
		$sql = "SELECT user_id FROM rep
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id_rep);
		$stmt->execute();
		$rep = $stmt->fetch();

		if ($rep['user_id'] == $id_utilisateur) {
			return true;		
		}
		return false;
	}

	function hasAlreadyVoted($id_utilisateur, $id_rep) {
		global $dbh;
		$sql = "SELECT user_id FROM hasvoted
				WHERE reponse_id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id_rep);
		$stmt->execute();
		$hasVoted = $stmt->fetch();

		if ($hasVoted['user_id'] == $id_utilisateur) {
			return true;		
		}
		return false;	
	}

	function updateScoreRep($id_rep, $point) {
		// récupère le score de la réponse
		global $dbh;
		$sql = "SELECT scoreRep FROM rep
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id_rep);
		$stmt->execute();
		$score = $stmt->fetch();

		if ($point == "plus") {
			$score = $score['scoreRep'] + 1;
		}
		if ($point == "moins") {
			$score = $score['scoreRep'] - 1;
		}

		// met à jour le score de la réponse
		$sql = "UPDATE rep
				SET scoreRep = :score
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );
		$stmt->bindValue(":score", $score);
		$stmt->bindValue(":id", $id_rep);
		$stmt->execute();		
	}

	function malusScoreUser($id_utilisateur) {
		// récupère le score de l'utilisateur
		global $dbh;
		$sql = "SELECT score FROM utilisateur
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id_utilisateur);
		$stmt->execute();
		$score = $stmt->fetch();

		$score = $score['score'] - 1;

		// met à jour le score de l'utilisateur
		$sql = "UPDATE utilisateur
				SET score = :score
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );
		$stmt->bindValue(":score", $score);
		$stmt->bindValue(":id", $id_utilisateur);
		$stmt->execute();			
	}

	function getIdUserByIdRep($id_rep) {
		global $dbh;
		$sql = "SELECT user_id FROM rep
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id_rep);
		$stmt->execute();
		$user = $stmt->fetch();	

		return $user['user_id'];	
	}

	function updateScoreOwnerAnswer($idOwnerAnswer, $point) {
		// récupère le score de l'utilisateur
		global $dbh;
		$sql = "SELECT score FROM utilisateur
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $idOwnerAnswer);
		$stmt->execute();
		$score = $stmt->fetch();

		if ($point == "plus") {
			$score = $score['score'] + 5;
		}
		if ($point == "moins") {
			$score = $score['score'] - 5;
		}

		// met à jour le score de l'utilisateur
		$sql = "UPDATE utilisateur
				SET score = :score
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );
		$stmt->bindValue(":score", $score);
		$stmt->bindValue(":id", $idOwnerAnswer);
		$stmt->execute();	
	}

	function insertIntoHasvoted($id_utilisateur, $id_rep) {
		global $dbh;
		$sql = "INSERT INTO hasvoted (user_id, reponse_id)
				VALUES (:user_id, :reponse_id)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(":user_id", $id_utilisateur);
		$stmt->bindValue(":reponse_id", $id_rep);
		$stmt->execute();		
	}