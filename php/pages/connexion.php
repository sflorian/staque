<?php


/************************************************************************
*                         FORMULAIRE ESPACE CLIENT                      *
*************************************************************************/
	// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$error = array(
		"pseudoEmail" => "",
		"password" => "",
	);
	$validate = "";

		// variables des attributs "value" du formulaire
	$pseudoEmail = "";
	$password = "";

		// variable utilisateur trouvé
	$_SESSION['utilisateurTrouve'] = false;
	$formIsValid = true;

	// si le formulaire a été soumis...
	if (!empty($_POST)) {

		// récupère les données dans nos variables
		$pseudoEmail = trim( strip_tags( $_POST["pseudoEmail"] ) );
		$password  = $_POST["password"];

		/*_________________ Début de la validation ____________________*/

		// ---------------- EMAIL OR NOM ----------------
		if (empty($pseudoEmail)) {
			$error['pseudoEmail'] = "Renseignez votre pseudo ou email pour rentrer dans la statrice
 !";
			$formIsValid = false;
		}
		// ---------------- PASSWORD ----------------
		elseif (empty($password)) {
			$error['password'] = "Renseignez votre mot de passe pour rentrer dans la statrice
 !";
			$formIsValid = false;
		}
		/*__________________ Fin de la validation ____________________*/
		
		// si le formulaire est valide
		if ($formIsValid) {

			$utilisateur = getUserByPseudoOrEmail($pseudoEmail);
			
				// Si l'utilisateur existe
			if ($utilisateur) {
				// Traitement du mot de passe
				$salt = $utilisateur['salt'];
				$hashedPassword = hashPassword($password, $salt);

				if ($hashedPassword == $utilisateur['password']) {
					// bingo
					// Conservation en mémoire sur mon serveur de la valeur de cette variable
					connectUser($utilisateur);
					goHome();
				} 
				else {
					$error['password'] = "Mot de passe non valide pour rentrer dans la statrice
!";
				}				
			}
			// Si l'utilisateur n'existe pas
			else {
				$error['pseudoEmail'] = "Pseudo ou email inconnu de la statrice
 !";
			}

		}


	} // fin du if formulaire soumis ?

?>


		<main id="mainConnexion" class="containerCompte">
			<form action="?page=connexion" id="formConnexion" method="POST" novalidate>
				<!-- <input type="text" visibility="hidden" name="form_connexion" /> -->
				<div class="formTitre">ENTRER DANS LA statrice
</div>
				<div class="center">
					<input type="text" name="pseudoEmail" id="pseudoEmailConnex" placeHolder="Pseudo ou Email" value="<?php echo $pseudoEmail; ?>"/>
					<p class="errors"><?= $error['pseudoEmail']; ?><p>
				</div>
				<div class="center">
					<input type="password" name="password" placeHolder="Mot de passe" id="passwordConnex" value=""/>
					<p class="errors"><?= $error['password']; ?><p>
				</div>
				<div class="center">
					<input type="submit" id="submitConnex" value="Connexion !"/>
					<span class="validates"><?= $validate; ?><span>
				</div>
				<div class="center" id="oubliConnex"><a href="?page=motDePasseOublie" title="Mot de passe oublié ?">Mot de passe oublié ?</a></div>
			</form>
		</main>