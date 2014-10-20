<?php

	if (!empty($_FILES)) {

		$accepted = array("image/jpeg", "image/jpg", "image/gif", "image/png");

		$tmp_name = $_FILES['image']['tmp_name'];

		// Vérifier le type du fichier uploadé
		//getimagesize($tmp_name);

		// Retourne le type mime
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
		$mime = finfo_file($finfo, $tmp_name);
		finfo_close($finfo);
		//echo $mime; 

		// Semble mieux pour des images de récupérer l'extension sur le mime et non sur le nom !
		// Mais ne fonctionne pas pour tout : ex mime JS est javascript alors que l'extension est .js
		$parts = explode(".", $_FILES['image']['name']);
		$extension = end($parts);

		//$parts = explode("/", $mime);
		//$extension = end($parts);

		// uniqid() donne une chaîne hexadécimale unique
		$filename = uniqid() . "." . $extension;

		$destination = "img/uploads/" . $filename;	
		echo $destination;
		die();	

		// Le déplace dans notre sous-dossier upload si mime reconnu
		if (in_array($mime, $accepted)) {
			move_uploaded_file($tmp_name, $destination);

			// Manipulation de l'image
			// avec SimpleImage
			require("SimpleImage.php");
			$img = new abeautifulsite\SimpleImage($destination);
			$img->text('IMAGES@MCB', 'AdobeArabic-Regular.otf', 32, '#000', 'top', 0, 20)->save("img/uploads/copyright/" . $filename);
			$img->thumbnail(300,300)->save("img/uploads/thumbs/" . $filename);
			$img->best_fit(500, 500)->save("img/uploads/resize500/" . $filename);
			$img->desaturate()->sepia()->save("img/uploads/blackandwhite/" . $filename);
		}
	}

?>
	
	<main>
		<form enctype="multipart/form-data" method="POST">
			<div>
				<label for="image">Image de votre profil ?</label><br />
				<input type="file" name="image" id="image"/>
			</div>
			<input type="submit" value="UPLOAD"/>
		</form>
	</main>

