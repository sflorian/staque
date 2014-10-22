<?php

	if (empty($_GET['id_rep'])){
		//goBack($url);
		goHome();
		die("manque id_rep");
	}
	$id_rep = $_GET['id_rep'];


/************************************************************************
*                                FORMULAIRE                             *
*************************************************************************/
	// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$error = array(
		"submit" => ""
	);
	$validate = "";

		// variable utilisateur 

	if (empty($_SESSION['utilisateur'])){
		$error['submit'] = "Connectez-vous !";
	}

	$id_utilisateur = "";
	if (!empty($_SESSION['utilisateur'])) {
		$id_utilisateur = $_SESSION['utilisateur']["id"];
	}







	// si le formulaire a été soumis...
	if (!empty($_POST) && $id_utilisateur) {

		$utilisateur = getUserById($id_utilisateur);
		
			// Si l'utilisateur existe
		if ($utilisateur) {

			// Connexion à la base
			global $dbh;
			$sql = "INSERT INTO comment (foreign_id, foreign_table, user_id, contenu, dateCreated, dateModified, published)
					VALUES (:foreign_id, :foreign_table, :user_id, :contenu, NOW(), NOW(), :published)";
			$stmt = $dbh->prepare( $sql ); 
			$stmt->bindValue(":foreign_id", $foreign_id);
			$stmt->bindValue(":foreign_table", $foreign_table);
			$stmt->bindValue(":user_id", $id_utilisateur);
			$stmt->bindValue(":contenu", $comment);
			$stmt->bindValue(":published", 1);
			//$stmt->execute();

			$validate = "Votre vote a été pris en compte !";
			//goBack($url);
			//goHome();
			//die();
		
		}

		


	} // fin du if formulaire soumis ?

?>


		<main id="mainAjouteComment" class="containerCompte">
			<form action="?<?= $_SERVER['QUERY_STRING']; ?>" id="formVote" method="POST" novalidate>  <!-- < ?= $_SERVER['QUERY_STRING']; ?> -->
				<div class="ajouteVote">
					<div>
						<span class="titreVote">Etes-vous sûrs de faire ce vote ?</span>
						<input type="submit" id="submitVote" value="OUI"/>
						<span class="errors"><?= $error['submit']; ?></span>
						<span class="validates"><?= $validate; ?></span>
					</div>
				</div>
			</form>
		</main>