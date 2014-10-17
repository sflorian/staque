<?php


/************************************************************************
*                         FORMULAIRE ESPACE CLIENT                      *
*************************************************************************/
	// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$errors = array();
	$logerror = "";

		// variables des attributs "value" du formulaire
	$nameEmail = "";
	$password = "";

		// variable utilisateur trouvé
	$_SESSION['userFound'] = false;



	//$users = getUsers();

		


	// si le formulaire a été soumis...
	if (!empty($_POST)) {

		// récupère les données dans nos variables
		$nameEmail = trim( strip_tags( $_POST["nameEmail"] ) );
		$password  = $_POST["password"];

		/*_________________ Début de la validation ____________________*/
		// ---------------- EMAIL OR NOM ----------------
		if (empty($nameEmail)) {
			$errors[] = "Please provide your username or your email!";
		}

		// ---------------- PASSWORD ----------------
		elseif (empty($password)) {
			$errors[] = "Please provide your password!";
		}
		/*__________________ Fin de la validation ____________________*/
		
		// si le formulaire est valide
		if (empty($errors)) {

			// vérifier si l'email existe et si le mot de passe correspond
			/*foreach ($users as $user) {

				// Traitement du mot de passe
				$salt = $user['salt'];
				$hashedPassword = hashPassword($password, $salt);


				// si l'email ou le nom correspond à ceux de notre liste
				if ($nameEmail == $user['email'] || $nameEmail == $user['username']) {
					// si le mdp correspond aussi !
					if ($hashedPassword == $user['password']) {
						// bingo
						$userFound = true;
						// Conservation en mémoire sur mon serveur de la valeur de cette variable
						$_SESSION['userFound'] = true;
						$nameLogin = $user['username'];
						$validLog = "Welcome " . $nameLogin;
						$logerror = "";
						break;
					} 
					else {
						$logerror = "Wrong password!";
						break;
					}
				} 
				else if($nameEmail != $user['email'] && $nameEmail != $user['username']) {
					$logerror = "Unknown username or email!";
				}
			}*/

			$user = getUserByNameOrEmail($nameEmail);
				// Si l'utilisateur existe
			if ($user) {
				// Traitement du mot de passe
				$salt = $user['salt'];
				$hashedPassword = hashPassword($password, $salt);

				if ($hashedPassword == $user['password']) {
					// bingo
					// Conservation en mémoire sur mon serveur de la valeur de cette variable
					$_SESSION['userFound'] = true;
					$_SESSION['user'] = $user;
					gohome();
				} 
				else {
					$logerror = "Wrong password!";
				}				
			}
			// Si l'utilisateur n'existe pas
			else {
				$logerror = "Unknown username or email!";
			}

		}


	} // fin du if formulaire soumis ?

?>