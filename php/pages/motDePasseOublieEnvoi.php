<?php


/************************************************************************
*                       FORMULAIRE ESPACE CLIENT                        *
*************************************************************************/
		// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$errors = array();
	$validate = "";

		// variables des attributs "value" du formulaire
	$email = "";
	if(!empty($_GET['email'])) {
		$email = $_GET['email'];
	}
	$token = "";
	if(!empty($_GET['token'])) {
		$token = $_GET['token'];
	}
	$password = "";
	$password2 = "";

		// Variable booléenne de formulaire soumis
	$Sent = false;

		// Est-ce que le formulaire a été soumis ?
	if (!empty($_POST)) {

		// récupère les paramètres d'url "id" -> fait dans des input type="hidden"
		$password  = $_POST["password"];
		$password2 = $_POST["password2"];

		/*_________________ Début de la validation ____________________*/

		// ---------------- PASSWORD ----------------
		// est-ce que la personne a renseigné son mot de passe ?
		if(empty($password)) {
			$errors[] = "Choisissez un nouveau mot de passe SVP !";
		}
		// taille minimale du mot de passe
		else if(strlen($password) < 6) {
			$errors[] = "Votre mot de passe doit contenir au minimum 6 caractères";
		}
		// 2eme saisie mot de passe ?
		else if(empty($password2)) {
			$errors[] = "Confirmez votre mot de passe !";
		}
		// Vérification password
		else if($password != $password2) {
			$errors[] = "Vos mots de passe ne correspondent pas !";
		}
		/*__________________ Fin de la validation ____________________*/

		// si le formulaire est valide, 
		if (empty($errors)) {		

			// Vérifie que l'email et le token match dans la BDD

			if ($token && $email) {
				$foundUser = foundUser($email, $token);
			}

			if ($foundUser) {

				$salt = $foundUser['salt'];

				// On change dans la BDD pour le nouveau mot de passe !
				// régénérer le token, et penser à changer la DateModified 
				$hashedPassword = hashPassword($password, $salt);
				$newtoken = randomString();

					// Connexion à la base
				global $dbh;

				$sql = "UPDATE utilisateur
						SET password = :password, dateModified = NOW()
						WHERE email = :email AND token = :token";
				$stmt = $dbh->prepare( $sql ); 
				$stmt->bindValue(":email", $email);
				$stmt->bindValue(":token", $token);
				$stmt->bindValue(":password", $hashedPassword);
				//$stmt->execute();
				if ($stmt->execute()) {
					$sql = "UPDATE utilisateur
							SET token = :token, dateModified = NOW()
							WHERE email = :email";
					$stmt = $dbh->prepare( $sql ); 
					$stmt->bindValue(":email", $email);
					$stmt->bindValue(":token", $newtoken);
					//$stmt->execute();
					if ($stmt->execute()) {
						// Logue l'utilisateur qui vient de changer son mot de passe
						connectUser($foundUser);
						goHome('&message=Bravo_mot_de_passe_change');
					}
				}

				$Sent = true;
				$validate = "Mot de passe changé !";


			}
			else {
				$errors[] = "Ce lien a déjà été utilisé et ne fonctionne plus !";
			}


		}

	} // fin du if formulaire soumis ?



?>




		<main id="mainMotDePasseOublieEnvoi" class="containerCompte"> 
			<form action="?<?= $_SERVER['QUERY_STRING']; ?>" id="formMotDePasseEnvoi" method="POST" novalidate>  
				<div class="formTitre">Obtenir un nouveau mot de passe !</div>
				<div class="center">
					<input type="password" name="password" placeHolder="Choisissez votre nouveau mot de passe ?" id="passwordOubli2" />
				</div>
				<div class="center">
					<input type="password" name="password2" placeHolder="Confirmez votre nouveau mot de passe" id="password2Oubli2" />
				</div>
				<div class="center">
					<input type="submit" value="ENREGISTRER" id="submitOubli2"/>
				</div>
				<div class="errors">
					<ul>
					<?php 
						foreach($errors as $error) {
							echo '<li>' . $error . '</li>'; 
						}
					?>
					</ul>
				</div>
				<div class="validates">
					<?php 
						if ($Sent) {
							echo $validate;
						}
					?>
				</div>
			</form>
		</main>