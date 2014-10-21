<?php


	function getRecentQuestions($nb = 3) {

		global $dbh;
		$sql = "SELECT quest.id AS id, quest.titre AS titre, quest.user_id AS user_id, quest.scorequest AS scorequest, quest.vues AS vues, quest.dateCreated AS dateCreated, quest.dateModified AS dateModified, rep.dateModified AS repDateModified, utilisateur.score AS utilisateurScore, utilisateur.pseudo AS utilisateurPseudo 
				FROM quest
				LEFT JOIN rep ON rep.quest_id = quest.id
				JOIN utilisateur ON quest.user_id = utilisateur.id
				WHERE quest.published = 1
				LIMIT :nbQuestions";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":nbQuestions", $nb,  PDO::PARAM_INT); // pdo 3eme param pour integer au lieu de string 
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


	function getQuestionById($id) {
		global $dbh;
		$sql = "SELECT * FROM quest
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$question = $stmt->fetch();

		return $question;			
	}

