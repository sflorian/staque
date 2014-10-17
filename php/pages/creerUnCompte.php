<?php 
	

/************************************************************************
*                       FORMULAIRE CREER COMPTE                         *
*************************************************************************/
		// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$errors = array(
		"nom" => "",
		"pseudo" => "",
		"email" => "",
		"password" => "",
		"metier" => "",
		"lien" => ""
	);
	$validate = "";

		// variables des attributs "value" du formulaire
	$prenom = "";
	$nom = "";
	$pseudo = "";
	$email = "";
	$password = "";
	$password2 = "";
	$pays = "";
	$langue = "";
	$metier = "";
	$lien = "";

		// Variable booléenne de formulaire soumis
	$Sent = false;

		// Est-ce que le formulaire a été soumis ?
	if (!empty($_POST)) {

		$prenom = trim( strip_tags( $_POST["prenom"] ) );
		$nom = trim( strip_tags( $_POST["nom"] ) );
		$pseudo = trim( strip_tags( $_POST["pseudo"] ) );
		$email = trim( strip_tags( $_POST["email"] ) );
		$password = $_POST["password"];
		$password2 = $_POST["password2"];
		$pays = trim( strip_tags( $_POST["pays"] ) ); //to do
		$langue = trim( strip_tags( $_POST["langue"] ) ); //to do
		$metier = trim( strip_tags( $_POST["metier"] ) ); //to do
		$lien = trim( strip_tags( $_POST["lien"] ) );

		/*_________________ Début de la validation ____________________*/

		// ---------------- PRENOM - NOM ----------------
		if(empty($prenom)) {
			$errors['nom'] = "Votre prénom ?";
		}
		// taille maximale du prénom
		else if(strlen($prenom) > 50) {
			$errors['nom'] = "Votre prénom est trop long !";
		}

		if(empty($nom)) {
			$errors['nom'] = "Votre nom ?";
		}
		// taille minimale du nom
		else if(strlen($nom) < 2) {
			$errors['nom'] = "Votre nom est court !";
		}
		// taille maximale du nom
		else if(strlen($nom) > 100) {
			$errors['nom'] = "Votre nom est trop long !";
		}

		// ---------------- PSEUDO ----------------
		if(empty($pseudo)) {
			$errors['pseudo'] = "Votre pseudo ?";
		}
		else if(strlen($pseudo) > 50) {
			$errors['pseudo'] = "Votre pseudo est trop long !";
		}			
		// S'agit-il bien d'un nouveau pseudo ?
		else if (pseudoExists($pseudo)) {
			$errors['pseudo'] = "Ce pseudo existe déjà !";
		}

		// ---------------- MAIL ----------------
		if (empty($email)) {
			$errors['email'] = "Votre email ?";
		}
		else if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$errors['email'] = "Votre email n'est pas valide !";
		}
		// S'agit-il d'un nouvel utilisateur ?
		else if (emailExists($email)) {
			$errors['email'] = "Votre email existe déjà dans notre base de données !";
		}

		// ---------------- PASSWORD ----------------
		if(empty($password)) {
			$errors['password'] = "Choisissez un mot de passe SVP !";
		}
		// taille minimale du mot de passe
		else if(strlen($password) < 6) {
			$errors['password'] = "Votre mot de passe doit contenir au minimum 6 caractères";
		}
		// 2eme saisie mot de passe ?
		else if(empty($password2)) {
			$errors['password'] = "Confirmez votre mot de passe !";
		}
		// Vérification password
		else if($password != $password2) {
			$errors['password'] = "Vos mots de passe ne correspondent pas !";
		}

		// ---------------- METIER ----------------
		if(empty($metier)) {
			$errors['metier'] = "Choisissez un métier SVP !";
		}

		// ---------------- LIEN ----------------
		if(!empty($lien)) {
			if(!preg_match("#^http://www\.[a-zA-Z0-9_-]+\.[a-zA-Z]+$#", $lien)) {
				$errors['lien'] = "Votre url n'est pas au bon format (http://www.votre-url.domain) !";
			}
		}

		//print_r($errors);
		//die();

		/*__________________ Fin de la validation ____________________*/

		// si le formulaire est valide, 
		if (empty($errors)) {
			echo 'ok';
			die();

			// Traitement country
			if (empty($country)) {
				$country = "Undefined";
			}

			// Traitement password
			$salt = randomString();

			$hashedPassword = hashPassword($password, $salt);

			$token = randomString();


			/*__________________ Gestion NEW USERS ____________________*/

				// Connexion à la base
			//include("../db.php");
			global $dbh;
				// requete SQL 
			$sql = "INSERT INTO customer (username, email, country, password, dateRegistered, dateModified, salt, token)
					VALUES (:username, :email, :country, :password, NOW(), NOW(), :salt, :token)";
			$stmt = $dbh->prepare( $sql ); 
			$stmt->bindValue(":username", $username);
			$stmt->bindValue(":email", $email);
			$stmt->bindValue(":country", $country);
			$stmt->bindValue(":password", $hashedPassword);
			$stmt->bindValue(":salt", $salt);
			$stmt->bindValue(":token", $token);
			$stmt->execute();

			$Sent = true;
			$validate = "Registration successful!";
			// On connecte directement le nouvel utilisateur dans la SESSION
			$user = array(
				"username"    => $username,
				"email" => $email,
				"country" => $country,
				"password" => $hashedPassword,
				"salt" => $salt,
				"toekn" => $token
			);
			$_SESSION['userFound'] = true;
			$_SESSION['user'] = $user;
			goUpload();
		}

	} // fin du if formulaire soumis ?


?>

<?php include("inc/top.php"); ?>

	<body>	
<!-- 		<header id="header" class="fond">
			<nav id="nav">
				<div id="Menu" class="container">
					<ul id="navListe">
						<li><a href="../php/index.php">HOME</a></li>
					</ul>
				</div>
				<div id="reglog" class="session">
				< ?php if(!empty($_SESSION['user'])) {
					echo "Hey " . $_SESSION['user']['username'];
				} ?>
				</div>
			</nav>
		</header> -->

		<main id="main" class="container"> 
			<form action="?page=creerUnCompte" id="formCreerUnCompte" method="POST" novalidate>
				<!-- <input type="text" visibility="hidden" name="form_creerUnCompte" /> -->
				<div class="formTitre">CREER UN COMPTE ff</div>
				<div>
					<input type="text" name="prenom" id="prenom" placeHolder="Prénom" value="<?php echo $prenom; ?>"/>
					<input type="text" name="nom" id="nom" placeHolder="Nom" value="<?php echo $nom; ?>"/>
					<span class="errors"><?= $errors['nom']; ?><span>
				</div>
				<div>
					<input type="text" name="pseudo" id="pseudo" placeHolder="Pseudo" value="<?php echo $pseudo; ?>"/>
					<span class="errors"><?= $errors['pseudo']; ?><span>
				</div>
				<div>
					<input type="text" name="email" id="email" placeHolder="Email" value="<?php echo $email; ?>"/>
					<span class="errors"><?= $errors['email']; ?><span>
				</div>
				<div>
					<input type="password" name="password" id="password" placeHolder="Mot de passe"/>
				</div>
				<div>
					<input type="password" name="password2" id="password2" placeHolder="Confirmer mot de passe"/>
					<span class="errors"><?= $errors['password']; ?><span>
				</div>
				<div>
					<input type="text" name="pays" id="pays" placeHolder="Pays" value="<?php echo $pays; ?>"/>
				</div>
				<div>
					<input type="text" name="langue" id="langue" placeHolder="Langue" value="<?php echo $langue; ?>"/>
				</div>
				<div>
					<input type="text" name="metier" id="metier" placeHolder="Métier" value="<?php echo $metier; ?>"/>
					<span class="errors"><?= $errors['metier']; ?><span>
				</div>
				<div>
					<input type="text" name="lien" id="lien" placeHolder="Une url personnelle ?" value="<?php echo $lien; ?>"/>
					<span class="errors"><?= $errors['lien']; ?><span>
				</div>
				<div>
					<input type="submit" value="Créer votre compte" id="submitCreer"/>
					<span class="validates"><?= $validate; ?><span>
				</div>
			</form>
		</main>
	</body>
</html>
