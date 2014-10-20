<?php


/************************************************************************
*                         FORMULAIRE ESPACE CLIENT                      *
*************************************************************************/
	// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$errors = array();
	$validate = "";

		// variables des attributs "value" du formulaire
	$emailOubli = "";

		// variable utilisateur trouvé et validation formulaire
	$_SESSION['utilisateurTrouve'] = false;
	$formIsValid = true;
	$mailSent = false;

	// si le formulaire a été soumis...
	if (!empty($_POST)) {

		// récupère les données dans nos variables
		$emailOubli = trim( strip_tags( $_POST["emailOubli"] ) );

		/*_________________ Début de la validation ____________________*/

		// ---------------- MAIL ----------------
		if (empty($emailOubli)) {
			$errors[] = "Renseignez votre email !";
		}
		else if ( !filter_var($emailOubli, FILTER_VALIDATE_EMAIL) ) {
			$errors[] = "Votre email n'est pas valide!";
		}
		// S'agit-il d'un nouvel utilisateur ?
		else if (!emailExists($emailOubli)) {
			$errors[] = 'Email inconnu<br /> Corrigez le ou SVP<br /><a href="?page=creerUnCompte" class="signup">Créez un compte !</a>';
		}
		/*__________________ Fin de la validation ____________________*/
		
		// si le formulaire est valide
		if ($formIsValid) {
			
			$utilisateur = getUserByEmail($emailOubli);
				// Si l'utilisateur existe

			$email = $utilisateur['email'];
			$prenomNom = $utilisateur['prenom'] . " " . $utilisateur['nom'];
			$token = $utilisateur['token'];
			// envoit le message
			include("../mail.php");                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         


			//$mailSent = true; // fait dans mail.php
			$validate = "Vérifiez vos emails, vous avez reçu des instructions pour réinitialiser votre mot de passe !";
			//goHome();
			
		} // fin des actions si données formulaire valides

	} // fin du if formulaire soumis ?

?>


		<main id="mainMotDePasseOublie" class="containerCompte">
			<form action="?page=motDePasseOublie" id="formMotDePasseOublie" method="POST" novalidate>
				<!-- <input type="text" visibility="hidden" name="form_connexion" /> -->
				<div class="formTitre">Nouveau mot de passe ?</div>
				<div class="center">
					<input type="text" name="emailOubli" id="emailOubli" placeHolder="Votre email ?" value="<?php echo $emailOubli; ?>"/>
					<p class="errors"><?= $error['emailOubli']; ?><p>
				</div>
				<div class="center">
					<input type="submit" id="submitOubli" value="ENVOYER"/>
					<span class="validates"><?= $validate; ?><span>
				</div>
			</form>
		</main>