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
				WHERE quest_id = :id AND published = 1";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$reponses = $stmt->fetchAll();

		return $reponses;			
	}