<?php


	/*function getRecentQuestions($nb) {

		global $dbh;
		$sql = "SELECT quest.id AS id, 
						quest.titre AS titre, 
						quest.user_id AS user_id, 
						quest.scorequest AS scorequest, 
						quest.vues AS vues, 
						quest.dateCreated AS dateCreated, 
						quest.dateModified AS dateModified, 
						rep.dateModified AS repDateModified, 
						utilisateur.score AS utilisateurScore, 
						utilisateur.pseudo AS utilisateurPseudo 
				FROM quest
				LEFT JOIN rep ON rep.quest_id = quest.id
				JOIN utilisateur ON quest.user_id = utilisateur.id
				WHERE quest.published = 1
				ORDER BY quest.dateModified DESC
				LIMIT :nbQuestions";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":nbQuestions", $nb,  PDO::PARAM_INT); // pdo 3eme param pour integer au lieu de string 
		$stmt->execute();
		$questions = $stmt->fetchAll();

		return $questions;
	}*/


	function getDateLastAnswerByIdQuestion($id) {
		global $dbh;
		$sql = "SELECT dateModified FROM rep
				WHERE quest_id = :id AND published = 1
				ORDER BY dateModified DESC";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$reponses = $stmt->fetchAll();

		return $reponses[0]['dateModified'];
	}

	function getTags() {

		global $dbh;
		$sql = "SELECT id, tagname FROM tag
				ORDER BY tagname DESC";
		$stmt = $dbh->prepare( $sql );  
		$stmt->execute();
		$tags = $stmt->fetchAll();

		return $tags;

	}

	function nbQuestByTag() {

		global $dbh;
		$sql = "SELECT COUNT(tag_quest.tag_id) 
		AS tagCounter, tag.id, tag.tagname 
		FROM tag 
		LEFT JOIN tag_quest ON tag_quest.tag_id = tag.id
		GROUP BY tag_quest.tag_id
		ORDER BY tagname DESC;";
		$stmt = $dbh->prepare( $sql );  
		$stmt->execute();
		$tags = $stmt->fetchAll();

		return $tags;
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
				WHERE id = :id
				AND quest.published = 1";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$question = $stmt->fetch();

		return $question;			
	}
		// QUADRUPLE JOINTURE, RESPECT !
	function getQuestionByTags($tag_id) {
		global $dbh;
		$sql = "SELECT
				quest.id AS id, 
				quest.titre AS titre, 
				quest.user_id AS user_id, 
				quest.scorequest AS scorequest, 
				quest.vues AS vues, 
				quest.dateCreated AS dateCreated, 
				quest.dateModified AS dateModified, 
				rep.dateModified AS repDateModified, 
				utilisateur.score AS utilisateurScore, 
				utilisateur.pseudo AS utilisateurPseudo 
				
				FROM quest
				LEFT JOIN tag_quest ON tag_quest.quest_id = quest.id
				LEFT JOIN tag ON tag_quest.tag_id = tag.id
				LEFT JOIN utilisateur ON utilisateur.id = quest.user_id
				LEFT JOIN rep ON rep.quest_id = quest.id
				WHERE tag.id = :tag_id
				AND quest.published = 1
				ORDER BY quest.id DESC";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":tag_id", $tag_id);
		$stmt->execute();
		$question = $stmt->fetchAll();

		return $question;			
	}

	function updateScoreUserAfterQuestion($id_utilisateur) {
		// récupère le score de l'utilisateur
		global $dbh;
		$sql = "SELECT score FROM utilisateur
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id_utilisateur);
		$stmt->execute();
		$score = $stmt->fetch();

		$score = $score['score'] + 2;

		// met à jour le score de l'utilisateur
		$sql = "UPDATE utilisateur
				SET score = :score
				WHERE id = :id";
		$stmt = $dbh->prepare( $sql );
		$stmt->bindValue(":score", $score);
		$stmt->bindValue(":id", $id_utilisateur);
		$stmt->execute();		
	}

