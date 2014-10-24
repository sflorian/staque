<?php
	
	//$url = $_GET['urlback'];
	//die($url);

	if (empty($_GET['id'])){
		//goBack($url);
		goHome();
		die("manque id_question");
	}

	$id_quest = $_GET['id'];

	if (empty($_GET['foreign_table'])){
		//goBack($url);
		goHome();
		die("manque foreign_table");
	}

	$foreign_table = $_GET['foreign_table'];

	if ($foreign_table == "question") {
		$foreign_id = $id_quest;
	}

	if ($foreign_table == "reponse") {
		if (empty($_GET['id_rep'])){
			//goBack($url);
			goHome();
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

	if (!userIsLogged()){
		$error['submit'] = "D'abord, ENTREZ dans la MATRICE !";
	}

	$id_utilisateur = "";
	if (userIsLogged()) {
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
				$stmt->execute();

				// ### 1ère solution, renvoie simplement du html
				$validate = "Votre commentaire est posté !";
				//goBack($url);
				//goHome();
				//die();

				// ### 2ème solution, renvoie une réponse AJAX "ok" et ensuite on fait les actions en js
				//die("ok");

				// ### 3ème solution, renvoie un tableau JSon 
				//$monArray = array ("mesdonnees" => "", "cle2" => "val2");
				//header("Content-type: application/json");
				//echo json_encode($monArray);
			
			}

		}


	} // fin du if formulaire soumis ?

?>


		<main id="mainAjouteComment" class="containerCompte">
			<form action="?<?= $_SERVER['QUERY_STRING']; ?>" id="formAjouteComment" method="POST" novalidate>  <!-- < ?= $_SERVER['QUERY_STRING']; ?> -->
				<div class="ajouteComment">
					<div class="titreComment">Votre commentaire</div>
					<!-- <input type="text" name="comment" id="comment" placeHolder="Votre commentaire ?" value="< ?php echo $comment; ?>"/> -->
					<div><textarea name="comment" id="comment"><?= $comment;?></textarea></div>
					<div>
						<input type="submit" id="submitComment" value="Poster !"/>
						<span class="errors"><?= $error['comment']; ?></span>
						<span class="errors2"><?= $error['submit']; ?></span>
						<span class="validates"><?= $validate; ?></span>
					</div>
				</div>
			</form>
		</main>