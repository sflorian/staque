<?php

	function getReponsesByIdQuestion($id) {
		global $dbh;
		$sql = "SELECT * FROM rep
				WHERE quest_id = :id";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$reponses = $stmt->fetchAll();

		return $reponses;			
	}