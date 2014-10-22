<?php

	if (empty($_GET['id'])){
		//goBack(?$_SERVER['QUERY_STRING']);
		die("manque id_question");
	}

	$id_quest = $_GET['id'];

	if (empty($_GET['foreign_table'])){
		//goBack(?$_SERVER['QUERY_STRING']);
		die("manque foreign_table");
	}

	$foreign_table = $_GET['foreign_table'];

	if ($foreign_table == "question") {
		$foreign_id = $id_quest;
	}

	if ($foreign_table == "reponse") {
		if (empty($_GET['id_rep'])){
			//goBack(?$_SERVER['QUERY_STRING']);
			die("manque id_rep");
		}
		$id_rep = $_GET['id_rep'];
		$foreign_id = $id_rep;
	}

/************************************************************************
*                         FORMULAIRE ESPACE CLIENT                      *
*************************************************************************/
	// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$error = array(
		"comment" => "",
		"submit" => ""
	);
	$validate = "";

		// variables des attributs "value" du formulaire
	$comment = "";

		// variable utilisateur 

	if (empty($_SESSION['utilisateur'])){
		$error['submit'] = "Connectez-vous !";
	}

	$id_utilisateur = "";
	if (!empty($_SESSION['utilisateur'])) {
		$id_utilisateur = $_SESSION['utilisateur']["id"];
	}

	$formIsValid = true;



	//echo "id_quest = " . $id_quest . " foregin_table = " . $foreign_table . " id_utilisateur = " . $id_utilisateur;
	//echo "id_quest = " . $id_quest . " foregin_table = " . $foreign_table . "id_rep = " . $id_rep . " id_utilisateur = " . $id_utilisateur;
	//die();

	// si le formulaire a été soumis...
	if (!empty($_POST) && $id_utilisateur) {

		// récupère les données dans nos variables
		$comment = trim( strip_tags( $_POST["comment"] ) );

		/*_________________ Début de la validation ____________________*/

		// ---------------- Comment ----------------
		if (empty($comment)) {
			$error['comment'] = "Votre commentaire ?";
			$formIsValid = false;
		}
		/*__________________ Fin de la validation ____________________*/
		
		// si le formulaire est valide
		if ($formIsValid) {

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

				$validate = "Votre commentaire est posté !";
				//die();
			
			}

		}


	} // fin du if formulaire soumis ?

?>


		<main id="mainAjouteComment" class="containerCompte">
			<form action="?<?= $_SERVER['QUERY_STRING']; ?>" id="formAjouteComment" method="POST" novalidate>
				<div class="ajouteComment">
					<div class="titreComment">Votre commentaire</div>
					<!-- <input type="text" name="comment" id="comment" placeHolder="Votre commentaire ?" value="< ?php echo $comment; ?>"/> -->
					<div><textarea name="comment" id="comment"><?= $comment;?></textarea></div>
					<div>
						<input type="submit" id="submitComment" value="Poster !"/>
						<span class="errors"><?= $error['comment']; ?><span>
						<span class="errors"><?= $error['submit']; ?><span>
						<span class="validates"><?= $validate; ?><span>
					</p>
				</div>
			</form>
		</main>