<?php


	
	function dateFr($date) {

		$dateFr = date('d-m-Y H:i:s', strtotime($date));
		return $dateFr;
	}

	function recherche($recherche) {
		global $dbh;
		$sql = "SELECT 
				quest.id AS id,
				tag.id AS tag_id,
				quest.vues AS vues,
				quest.titre AS titre,
				tag.tagname AS tagname,
				quest.user_id AS user_id,
				quest.scorequest AS scorequest,
				tag_quest.quest_id AS repquest,
				quest.dateCreated AS dateCreated,
				quest.dateModified AS dateModified,
				rep.dateModified AS repDateModified,
				utilisateur.score AS utilisateurScore,
				utilisateur.pseudo AS utilisateurPseudo 
				FROM quest
				LEFT JOIN utilisateur ON utilisateur.id = quest.user_id
				LEFT JOIN tag_quest ON tag_quest.quest_id = quest.id
				LEFT JOIN tag ON tag_quest.tag_id = tag.id
				LEFT JOIN rep ON rep.quest_id = quest.id
				WHERE quest.titre LIKE :recherche 
				OR quest.contenu LIKE :recherche 
				OR utilisateur.pseudo LIKE :recherche 
				OR tag.tagname LIKE :recherche
				ORDER BY id DESC";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":recherche", '%' . $recherche . '%');
		$stmt->execute();
		$question = $stmt->fetchAll();

		return $question;			
	}