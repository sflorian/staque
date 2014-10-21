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

		// Initialisation des variables
		// contiendra nos éventuels messages d'erreur de validation du formulaire
	$errors = array(
		"photo" => "",
	);
	$validate = "";

	// variables des attributs "value" du formulaire
	$filename = "";



	if (!empty($_FILES)) {

		$accepted = array("image/jpeg", "image/jpg", "image/gif", "image/png");

		$tmp_name = $_FILES['image']['tmp_name'];

		// Vérifier le type du fichier uploadé
		//getimagesize($tmp_name);

		// Retourne le type mime
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
		$mime = finfo_file($finfo, $tmp_name);
		finfo_close($finfo);

		// Semble mieux pour des images de récupérer l'extension sur le mime et non sur le nom !
		// Mais ne fonctionne pas pour tout : ex mime JS est javascript alors que l'extension est .js
		$parts = explode(".", $_FILES['image']['name']);
		$extension = end($parts);

		// uniqid() donne une chaîne hexadécimale unique
		$filename = uniqid() . "." . $extension;


		// Le déplace dans notre sous-dossier upload si mime reconnu
		if (in_array($mime, $accepted)) {
			//move_uploaded_file($tmp_name, $destination);

			// Manipulation de l'image
			// avec SimpleImage
			require("SimpleImage.php");
			$img = new abeautifulsite\SimpleImage($tmp_name);
			$img->thumbnail(128,128)->save("../img/uploads/profil128/" . $filename);
			$img->thumbnail(32,32)->save("../img/uploads/profil32/" . $filename);
			updateImageProfil($id, $filename);
		}
	}
	else {
		$errors['photo'] = "Veuillez ajouter une photo d'abord";
	}
		
	

?>
	
	<main>
		<form enctype="multipart/form-data" method="POST">
			<div>
				<label for="image">Sélectionnez l'image que vous souhaitez utiliser en tant que photo de profil :</label><br />
				<input type="file" name="image" id="image"/>
			</div>
			<input type="submit" value="Ajouter la photo de profil"/>
		</form>
	</main>

