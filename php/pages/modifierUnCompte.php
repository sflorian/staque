<?php 
	
if(empty($_GET['id'])) {
		goHome();
	}

	if(!userIsLogged()){
		forbidden();
	}

	if($_SESSION["utilisateur"]["id"] != $_GET["id"]){
		forbidden();
	}


	$id = $_GET['id'];
	$utilisateur = getUserById($id);

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
		"pays" => "",
		"langue" => "",
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
	$code = "";
	$langue = "";
	$metier = "";
	$lien = "";

		// Variable booléenne de formulaire soumis
	$Sent = false;
	$formIsValid = true;

	$ps = getPaysLangue();
	//echo '<pre>';
	//print_r($ps);
	//echo '</pre>';
	//die();





		// Est-ce que le formulaire a été soumis ?
	if (!empty($_POST)) {

		$prenom = trim( strip_tags( $_POST["prenom"] ) );
		$nom = trim( strip_tags( $_POST["nom"] ) );
		/*$pseudo = trim( strip_tags( $_POST["pseudo"] ) );*/
		/*$email = trim( strip_tags( $_POST["email"] ) );*/
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
			$formIsValid = false;
		}
		// taille maximale du prénom
		else if(strlen($prenom) > 50) {
			$errors['nom'] = "Votre prénom est trop long !";
			$formIsValid = false;
		}

		if(empty($nom)) {
			$errors['nom'] = "Votre nom ?";
			$formIsValid = false;
		}
		// taille minimale du nom
		else if(strlen($nom) < 2) {
			$errors['nom'] = "Votre nom est court !";
			$formIsValid = false;
		}
		// taille maximale du nom
		else if(strlen($nom) > 100) {
			$errors['nom'] = "Votre nom est trop long !";
			$formIsValid = false;
		}

		// A CORRIGER PLUS TARD, SI CORRECTION, NE PAS OUBLIER DE DECOMMENTER TOUT LES CHAMPS PSEUDO ET EMAIL

		// ---------------- PSEUDO ----------------
		/*if(empty($pseudo)) {
			$errors['pseudo'] = "Votre pseudo ?";
			$formIsValid = false;
		}
		else if(strlen($pseudo) > 50) {
			$errors['pseudo'] = "Votre pseudo est trop long !";
			$formIsValid = false;
		}	*/		
		// S'agit-il bien d'un nouveau pseudo ?
		/*else if (pseudoExists($pseudo)) {
			$errors['pseudo'] = "Ce pseudo existe déjà !";
			$formIsValid = false;
		}*/

		// ---------------- MAIL ----------------
		/*if (empty($email)) {
			$errors['email'] = "Votre email ?";
			$formIsValid = false;
		}
		else if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$errors['email'] = "Votre email n'est pas valide !";
			$formIsValid = false;
		}*/
		// S'agit-il d'un nouvel utilisateur ?
		/*else if (emailExists($email)) {
			$errors['email'] = "Votre email existe déjà dans notre base de données !";
			$formIsValid = false;
		}*/

		// ---------------- PASSWORD ----------------
		if(empty($password)) {
			$errors['password'] = "Choisissez un mot de passe SVP !";
			$formIsValid = false;
		}
		// taille minimale du mot de passe
		else if(strlen($password) < 6) {
			$errors['password'] = "Votre mot de passe doit contenir au minimum 6 caractères";
			$formIsValid = false;
		}
		// 2eme saisie mot de passe ?
		else if(empty($password2)) {
			$errors['password'] = "Confirmez votre mot de passe !";
			$formIsValid = false;
		}
		// Vérification password
		else if($password != $password2) {
			$errors['password'] = "Vos mots de passe ne correspondent pas !";
			$formIsValid = false;
		}

		// ---------------- PAYS ----------------
		if(empty($pays)) {
			$errors['pays'] = "Choisissez un pays SVP !";
			$formIsValid = false;
		}
		/*elseif(!preg_match("#^[a-zA-Z-]+$#", $pays)) {
			$errors['pays'] = "Votre pays n'est pas valide !";
		}*/

		// ---------------- LANGUE ----------------
		if(empty($langue)) {
			$errors['langue'] = "Choisissez une langue SVP !";
			$formIsValid = false;
		}
		/*elseif(!preg_match("#^[a-zA-Z-]+$#", $langue)) {
			$errors['langue'] = "Votre langue n'est pas valide !";
		}*/

		// ---------------- METIER ----------------
		if(empty($metier)) {
			$errors['metier'] = "Choisissez un métier SVP !";
			$formIsValid = false;
		}

		// ---------------- LIEN ----------------
		if(!empty($lien)) {
			if(!preg_match("#^http://www\.[a-zA-Z0-9_-]+\.[a-zA-Z]+$#", $lien)) {
				$errors['lien'] = "Mauvais format d'url (http://www.votre-url.domain) !";
				$formIsValid = false;
			}
		}

		//print_r($errors);
		//die();

		/*__________________ Fin de la validation ____________________*/

		// si le formulaire est valide,
		if ($formIsValid) {

			// Traitement password
			$salt = randomString();

			$hashedPassword = hashPassword($password, $salt);

			$token = randomString();


			/*__________________ Gestion NEW USERS ____________________*/

				//A REMETTRE SI CORRECTION

					/*pseudo       = :pseudo,*/ 
					/*email        = :email, */




				// Connexion à la base
			global $dbh;
			$sql = "UPDATE utilisateur 
					SET 
					nom          = :nom, 
					prenom       = :prenom, 
					password     = :password, 
					salt         = :salt, 
					token        = :token, 
					pays         = :pays, 
					langue       = :langue, 
					metier       = :metier, 
					lien         = :lien, 
					dateModified = NOW(), 
					published    = :published
					WHERE id = :id";
			$stmt = $dbh->prepare( $sql ); 
			/*$stmt->bindValue(":pseudo", $pseudo);*/
			$stmt->bindValue(":nom", $nom);
			$stmt->bindValue(":prenom", $prenom);
			/*$stmt->bindValue(":email", $email);*/
			$stmt->bindValue(":password", $hashedPassword);
			$stmt->bindValue(":salt", $salt);
			$stmt->bindValue(":token", $token);
			$stmt->bindValue(":pays", $pays);
			$stmt->bindValue(":langue", $langue);
			$stmt->bindValue(":metier", $metier);
			$stmt->bindValue(":lien", $lien);
			$stmt->bindValue(":published", 1);
			$stmt->bindValue(":id", $id);
			$stmt->execute();

			$Sent = true;
			$validate = " Compte modifié!";
			// On connecte directement le nouvel utilisateur dans la SESSION


			//A VERIFIER
			/*$lastId = $dbh->lastInsertId();
			$utilisateur = getUserById($lastId);

			connectUser($utilisateur);*/
			//goUpload();
		}

	} // fin du if formulaire soumis ?


?>



		<main id="mainModifCompte" class="containerModifCompte"> 
			<form action="?page=modifierUnCompte&id=<?= $id; ?>" id="formModifUnCompte" method="POST" novalidate>
				<!-- <input type="text" visibility="hidden" name="form_creerUnCompte" /> -->
				<div class="modifFormTitre">Modifier son compte dans la statrice
</div>
				<div>
					<input type="text" name="prenom" id="prenomModif" placeHolder="Prénom" value="<?= $prenom; ?>"/>
					<input type="text" name="nom" id="nomModif" placeHolder="Nom" value="<?= $nom; ?>"/>
					<span class="errors"><?= $errors['nom']; ?><span>
				</div>
				<!-- <div>
					<input type="text" name="pseudo" id="pseudoModif" placeHolder="Pseudo" value="PHP A REMETTRE"/>
					<span class="errors">PHP A REMETTRE<span>
				</div> -->
				<!-- <div>
					<input type="text" name="email" id="emailModif" placeHolder="Email" value="PHP A REMETTRE"/>
					<span class="errors">PHP A REMETTRE<span>
				</div> -->
				<div>
					<input type="password" name="password" id="passwordModif" placeHolder="Mot de passe"/>
				</div>
				<div>
					<input type="password" name="password2" id="password2Modif" placeHolder="Confirmer mot de passe"/>
					<span class="errors"><?= $errors['password']; ?><span>
				</div>
				<!-- <div>
					<input type="text" name="pays" id="paysModif" placeHolder="Pays" value="< ?php echo $pays; ?>"/>
					<span class="errors">< ?= $errors['pays']; ?><span>
				</div> -->
				<div>
					<select name="pays" id="paysModif">
						<option value="">Pays</option>
						<?php foreach ($ps as $p): ?>
						<option value="<?= $p['pays']; ?>" <?php if($pays == $p['pays']): ?> selected="selected"<?php $code = $p['code']; endif ?>><?= $p['pays']; ?></option>
						<?php endforeach ?>
					</select>
					<span class="errors"><?= $errors['pays']; ?><span>
				</div>
				<!-- <div>
					<input type="text" name="langue" id="langueModif" placeHolder="Langue" value="< ?php echo $langue; ?>"/>
					<span class="errors">< ?= $errors['langue']; ?><span>
				</div> -->
				<div>
					<select name="langue" id="langueModif">
						<option value="">Langue</option>
						<?php foreach ($ps as $p): ?>
						<option value="<?= $p['langue']; ?>" <?php if($langue == $p['langue']): ?> selected="selected"<?php endif ?>><?= $p['langue']; ?></option>  <!-- $code == $p['code'] -->
						<?php endforeach ?>
					</select>
					<span class="errors"><?= $errors['langue']; ?><span>
				</div>
				<div>
					<input type="text" name="metier" id="metierModif" placeHolder="Métier" value="<?php echo $metier; ?>"/>
					<span class="errors"><?= $errors['metier']; ?><span>
				</div>
				<div>
					<input type="text" name="lien" id="lienModif" placeHolder="Une url personnelle ?" value="<?php echo $lien; ?>"/>
					<span class="errors"><?= $errors['lien']; ?><span>
				</div>
				<div>
					<input type="submit" value="Modifier votre compte" id="submitModif"/>
					<span class="validates"><?= $validate; ?><span>
				</div>
			</form>
		</main>

