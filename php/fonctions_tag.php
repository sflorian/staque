<?php



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