<?php
	

	$numPerPage = 2;
	$p = 1;
	
	if (!empty($_GET['p'])){
		$p = $_GET['p'];
	}

	//le nombre de villes à NE PAS récupérer dans la requête
	$offset = ($p-1)*$numPerPage;

	$direction = "DESC";
	if (!empty($_GET['dir'])){
		if ($_GET['dir'] === "asc"){
			$direction = "ASC";
		} 
	}


	$sql = "SELECT 
			quest.id AS id, 
			quest.vues AS vues, 
			quest.titre AS titre, 
			quest.user_id AS user_id, 
			quest.scorequest AS scorequest, 
			quest.dateModified AS dateModified, 
			quest.dateCreated AS 	dateCreated, 
			rep.dateModified AS repDateModified, 
			utilisateur.score AS utilisateurScore, 
			utilisateur.pseudo AS utilisateurPseudo 
			FROM quest
			LEFT JOIN rep ON rep.quest_id = quest.id
			JOIN utilisateur ON quest.user_id = utilisateur.id
			WHERE quest.published = 1
			ORDER BY dateCreated $direction 
			LIMIT :offset,$numPerPage";

	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
	$stmt->execute();
	$questions = $stmt->fetchAll();

	//récupère le nombre total de questions dans la bdd
	$sql = "SELECT COUNT(*) FROM quest
			WHERE quest.published = 1";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$totalNumber = $stmt->fetchColumn();
	$totalPages = ceil($totalNumber / $numPerPage); //arrondit vers le haut

	// Initialisation des variables
	$nbReponses = 0;
	$theone = false;

	$action = "";
	$temps = "";


?>