<?php

	if (empty($_GET['id_rep'])){
		goHome();
		die("manque id_rep");
	}
	$id_rep = $_GET['id_rep'];

	global $dbh;
	$sql = "UPDATE rep
			SET best = :best
			WHERE id = :id";
	$stmt = $dbh->prepare( $sql );
	$stmt->bindValue(":best", 1,  PDO::PARAM_INT);
	$stmt->bindValue(":id", $id_rep);
	$stmt->execute();	

	die("ok");