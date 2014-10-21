<?php

	function getCommentsByIdQuestion($id) {
		global $dbh;
		$sql = "SELECT * FROM comment
				WHERE foreign_id = :id AND foreign_table = :foreign_table";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $id); 
		$stmt->bindValue(":foreign_table", "question");
		$stmt->execute();
		$comments = $stmt->fetchAll();

		return $comments;
	}

	function getCommentsByIdReponse($rep_id) {
		global $dbh;
		$sql = "SELECT * FROM comment
				WHERE foreign_id = :id AND foreign_table = :foreign_table";
		$stmt = $dbh->prepare( $sql );  
		$stmt->bindValue(":id", $rep_id); 
		$stmt->bindValue(":foreign_table", "reponse");
		$stmt->execute();
		$comments = $stmt->fetchAll();

		return $comments;
	}