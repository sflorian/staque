<?php

	if (empty($_GET['id_rep'])){
		//goBack($url);
		goHome();
		die("manque id_rep");
	}
	$id_rep = $_GET['id_rep'];

	if (empty($_GET['point'])){
		//goBack($url);
		goHome();
		die("manque point");
	}
	$point = $_GET['point'];

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

	//if (empty($_SESSION['utilisateur'])){
	//	$error['submit'] = "Connectez-vous !";
	//}

	$id_utilisateur = "";
	if (userIsLogged()) {
		$id_utilisateur = $_SESSION['utilisateur']["id"];
	}
	else {
		$error['submit'] = "Connectez-vous !";
	}

	// On vérifie que l'utilisateur n'a pas déjà voté pour cette réponse !
	if ( hasAlreadyVoted($id_utilisateur, $id_rep) ) {
		$error['submit'] = "Vous avez déjà voté pour cette réponse !";
		//goBack($url);
		//goHome();
		//die("déjà voté");
	}

	// On vérifie que l'utilisateur ne vote pas pour sa propre réponse
	if ( userVoteOnHisAnswer($id_utilisateur, $id_rep) ) {
		$error['submit'] = "Vous ne pouvez voter pour votre propre réponse !";
		//goBack($url);
		//goHome();
		//die("déjà voté");
	}




	// si le formulaire a été soumis et que tout est ok (hasVoted et pas sa propre rep)
	if (!empty($_POST) && empty($error['submit'])) {


		//$utilisateur = getUserById($id_utilisateur);
		
			// Si l'utilisateur existe
		//if ($utilisateur) {

			// Update score de la réponse (+/- 1) ATTENTION si -1 enlève aussi -1 au voteur !
			updateScoreRep($id_rep, $point);
			if ($point == "moins") {
				malusScoreUser($id_utilisateur);
			}

			// Update le score du proprio de la réponse ! (+/- 5)
			$idOwnerAnswer = getIdUserByIdRep($id_rep, $point);
			updateScoreOwnerAnswer($idOwnerAnswer);

			// Insertion dans hasVoted
			insertIntoHasvoted($id_utilisateur, $id_rep);


			$validate = "Votre vote a été pris en compte !";
			//goBack($url);
			//goHome();
			//die();
		
		//}

		


	} // fin du if formulaire soumis ?

?>


		<main id="mainAjouteComment" class="containerCompte">
			<form action="?<?= $_SERVER['QUERY_STRING']; ?>" id="formVote" method="POST" novalidate>  <!-- < ?= $_SERVER['QUERY_STRING']; ?> -->
				<div class="ajouteVote">
					<div>
						<input type="hidden" name="hidden" id="hidden" value="ok"/>
						<span class="titreVote">Etes-vous sûr(e) de faire ce vote ?</span>
						<input type="submit" id="submitVote" value="OUI"/>
						<span class="nonFermeture">NON</span>
					</div>
					<div>
						<span class="errors"><?= $error['submit']; ?></span>
						<span class="validates"><?= $validate; ?></span>
					</div>
				</div>
			</form>
		</main>