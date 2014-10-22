<?php
	




/************************************************************************
*                         FORMULAIRE ESPACE CLIENT                      *
*************************************************************************/
	// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$error = array(
		"titre" => "",
		"contenu" => "",
		"tags" => "",
		"submit" => ""
	);

	if (empty($_SESSION['utilisateur'])){
		$error['submit'] = "Connectez-vous non?!";
	}

	$id_utilisateur = "";
	if (!empty($_SESSION['utilisateur'])) {
		$id_utilisateur = $_SESSION['utilisateur']["id"];
	}
	
	// variables des attributs "value" du formulaire
	$titre = "";
	$contenu = "";
	$tags = "";

	// variable utilisateur trouvé
	$formIsValid = true;

	// si le formulaire a été soumis...
	if (!empty($_POST) && $id_utilisateur ) {

		// récupère les données dans nos variables
		$titre = trim( strip_tags( $_POST["titre"] ) );
		$contenu = $_POST["contenu"];
		$tags = trim( strip_tags( $_POST["tags"]) );

		/*_________________ Début de la validation ____________________*/

		// ---------------- TITRE ----------------
		if (empty($titre)) {
			$error['titre'] = "Résumez votre question";
			$formIsValid = false;
		}
		// ---------------- CONTENU ----------------
		if (empty($contenu)) {
			$error['contenu'] = "Il faudrait peut-être poser votre question non?";
			$formIsValid = false;
		}

		// ---------------- TAGS ----------------
		if (empty($tags)) {
			$error['tags'] = "De quoi la question parle-t-elle?";
			$formIsValid = false;
		}
		if (!empty($tags)) {
			$arraytags = explode(",", $tags);
			if (count($arraytags)>5) {
				$error['tags'] = "Maximum 5 tags !";
				$formIsValid = false;
			}
		}
		/*__________________ Fin de la validation ____________________*/
		
		// si le formulaire est valide
		if ($formIsValid) {
			for($i = 0; $i<count($arraytags); $i++) {
				$arraytags[$i] = trim($arraytags[$i]);
				if ($arraytags[$i] == "") {
					unset($arraytags[$i]);
					$arraytags = array_values($arraytags);
				}
			}

			// Connexion à la base
			global $dbh;
			$sql = "INSERT INTO quest (titre, contenu, user_id, scorequest, vues, dateCreated, dateModified, published)
					VALUES (:titre, :contenu, :user_id, :scorequest, :vues, NOW(), NOW(), :published)";
			$stmt = $dbh->prepare( $sql ); 
			$stmt->bindValue(":titre", $titre);
			$stmt->bindValue(":contenu", $contenu);
			$stmt->bindValue(":user_id", $id_utilisateur);
			$stmt->bindValue(":scorequest", 0, PDO::PARAM_INT);
			$stmt->bindValue(":vues", 0, PDO::PARAM_INT);
			$stmt->bindValue(":published", 1, PDO::PARAM_INT);
			$stmt->execute();

			$id_question = $dbh->lastInsertId();

			$sql = "INSERT INTO tag (tagname, dateCreated)
					VALUES (:tagname, NOW())";
			$stmt = $dbh->prepare($sql);
			foreach ($arraytags as $tag) {
				if (!tagExists($tag)) {
					$stmt->bindValue(":tagname", $tag);
					if($stmt->execute()) {
						$id_tag = $dbh->lastInsertId();
						insertTag_quest($id_tag, $id_question);
					}
				}
				elseif(tagExists($tag)) {
					$id_tag = getIdExistantTag($tag);
					insertTag_quest($id_tag, $id_question);
				}
			}

			goHome();

		}


	} // fin du if formulaire soumis ?

?>






















		<main id="mainPoserQuestion">
			<h1 class="borderBottom">La question que tout le monde se pose :</h1>
			<form action="?page=poserQuestion" id="formPoserQuestion" method="POST" novalidate>
				<div>
					<input type="text" name="titre" id="titreQuestion" placeholder="Titre clair de votre question" value="<?= $titre;?>">
					<span class="errors"><?= $error['titre']?></span>
				</div>
				<div>
					<label for="contenuQuestion">Votre question :</label>
					<textarea name="contenu" id="contenuQuestion" class="editeur"><?= $contenu;?></textarea>
					<span class="errors"><?= $error['contenu']?></span>
				</div>
				<div>
					<input type="text" name="tags" id="tagsQuestion" placeholder="Ecrivez ici vos tags en les séparant par des virgules (minimum 1 tag, maximum 5 tags)" value="<?= $tags;?>">
					<span class="errors"><?= $error['tags']?></span>
				</div>
				<input type="submit" id="submitPoserQuestion" value="Posez votre question">
				<span class="errors"><?= $error['submit']?></span>
			</form>
		</main>