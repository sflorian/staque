<?php

	if(!empty($_GET['id'])) {
		$id = $_GET['id'];
	$sql = "SELECT * FROM utilisateur
			WHERE id = :id";
	$stmt = $dbh->prepare( $sql ); 
	$stmt->bindValue(":id", $id);
	$stmt->execute();
	$utilisateur = $stmt->fetch();
	}
?>






		<main id="mainPoserQuestion">
			<container>
				<h1><?= $utilisateur['pseudo'];?></h1>

				<div>
					<div id="containerPhoto" class="left">
						<img src="../img/uploads/<?= $utilisateur['photo'];?>" id="profilePic">
						<a href="#score"><?= $utilisateur['score'];?><br>score</a>
					</div>
					<div id="containerInfo" class="left">
						<div class="labelOfLabel">bio
							<div class="infoLabel">langue : <?= $utilisateur['langue'];?></div>
							<div class="infoLabel">pays : <?= $utilisateur['pays'];?></div>
							<div class="infoLabel">langue : <?= $utilisateur['metier'];?></div>
							<div class="infoLabel">site : <?= $utilisateur['lien'];?></div>
						</div>
						
						<div class="labelOfLabel">visites
							<div class="infoLabel">date d'inscription : <?= dateFr($utilisateur['dateCreated']);?></div>
							<div class="infoLabel">dernière visite : <?= dateFr($utilisateur['dateLogged']);?></div>
						</div class="labelOfLabel">
						
						<!-- <div class="labelOfLabel">statistiques
							<div class="infoLabel">vues du profil</div>
						</div> -->
						
						<div class="labelOfLabel">privé
							<div class="infoLabel">email : <?= $utilisateur['email'];?></div>
							<div class="infoLabel">nom et prénom : <span><?= $utilisateur['prenom'];?> <?=$utilisateur['nom'];?></div>
						</div>

					</div>
					
				</div>

				<div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>

			</container>
			<container>
			
			<!-- STATS AVEC LIENS VERS LES QUESTIONS ETC -->

			</container>

		</main>
		
