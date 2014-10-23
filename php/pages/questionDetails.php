<?php

		// Vérification qu'on a bien un id sinon ACCUEIL

	if (empty($_GET['id']) || $_GET['id'] == 0) { 
		goHome();
	}
	
		// récupère le paramètre d'url "id"
	$id = $_GET['id'];

	$action = "";
	$temps = "";

	$question = getQuestionById($id);
	$tags = getTagsByIdQuestion($id);
	$questionComments = getCommentsByIdQuestion($id);
	$nbReponses = getNbReponsesByIdQuestion($id);
	$reponses = getReponsesByIdQuestion($id);



/************************************************************************
*                         FORMULAIRE ESPACE CLIENT                      *
*************************************************************************/
	// Initialisation des variables
	$error = array(
		"contenu" => "",
		"submit" => ""
	);
	$validate = "";

	if (!userIsLogged()){
		$error['submit'] = "Connectez-vous SVP !";
	}

	$id_utilisateur = "";
	if (userIsLogged()) {
		$id_utilisateur = $_SESSION['utilisateur']['id'];
	}
	
	// variables des attributs "value" du formulaire
	$contenu = "";
	$formIsValid = true;

	// si le formulaire a été soumis...
	if (!empty($_POST) && $id_utilisateur ) {

		// récupère les données dans nos variables
		$contenu = $_POST["contenu"];

		/*_________________ Début de la validation ____________________*/

		// ---------------- CONTENU ----------------
		if (empty($contenu)) {
			$error['contenu'] = "Il faudrait peut-être taper votre réponse...";
			$formIsValid = false;
		}
		/*__________________ Fin de la validation ____________________*/
		
		// si le formulaire est valide
		if ($formIsValid) {

			// Connexion à la base
			global $dbh;
			$sql = "INSERT INTO rep (quest_id, user_id, contenu, scoreRep, dateCreated, dateModified, published, best)
					VALUES (:quest_id, :user_id, :contenu, :scoreRep, NOW(), NOW(), :published, :best)";
			$stmt = $dbh->prepare( $sql ); 
			$stmt->bindValue(":quest_id", $id);
			$stmt->bindValue(":contenu", $contenu);
			$stmt->bindValue(":user_id", $id_utilisateur);
			$stmt->bindValue(":scoreRep", 0,  PDO::PARAM_INT);
			$stmt->bindValue(":published", 1,  PDO::PARAM_INT);
			$stmt->bindValue(":best", 0,  PDO::PARAM_INT);
			$stmt->execute();

			updateScoreUserAfterAnswer($id_utilisateur);

			$validate = "Réponse postée !";

			// TO DO = recharger le contenu de la page...
			$url = "?" .$_SERVER['QUERY_STRING'] ."&message=reponsePostee";
			goBack($url);

		}


	} // fin du if formulaire soumis ?


?>	


		<main id="mainQuestionDetails">

			<div id="questionDetails">
				<div class="hidden"><?= $question["id"];?></div>
				<h1 class="borderBottom"><?= $question["titre"]; ?></h1>
				<div class="left sidebar">
					<div class="votePlus"></div>
					<div class="scorequest"><?= $question["scorequest"];?></div>
					<div class="voteMoins"></div>
					<div class="favoris">fav</div>
				</div>
				<div class="left details">
					<div><?= $question["contenu"];?></div>
					<div class="tag">
							<?php 
							foreach ($tags as $tag) { ?>
								<a href="?page=questionParTag&id=<?= $tag['id']; ?>&tagname=<?= $tag['tagname'] ?>"><span class='tagname'><?= $tag['tagname'] ?></span></a>
							<?php } ?>
					</div>
					<div class="who right">
						<?php 
							$utilisateur = getUserById($question['user_id']);
							if ($question['dateModified'] != $question['dateCreated']) {
								$action = "modifiée";
								$temps = dateFr($question['dateModified']);
							}
							elseif ($question['dateModified'] == $question['dateCreated']) {
								$action = "posée";
								$temps = dateFr($question['dateCreated']);
							}
							echo '<div class="actiontemps">' .$action . " - " . $temps . " </div>";
						?>
						<div>
							<a href="?page=profil&amp;id=<?= $question['user_id']; ?>" class="lienProfil"><?= $utilisateur['pseudo'];?></a>
							<span> <?= $utilisateur['score']; ?></span>
						</div>
					</div>
					<div class="clear"></div>
					<div class="zoneComment">
					<?php if ($questionComments): ?>
						<div class="borderTop"></div>
						<?php foreach ($questionComments as $questionComment): ?>
						<div class="comment">
							<?php $utilisateur = getUserById($questionComment['user_id']); ?>
							<span><?= $questionComment['contenu'] ?></span>
							<a href="?page=profil&amp;id=<?= $questionComment['user_id']; ?>" class="lienProfil"><?= $utilisateur['pseudo'];?></a>
							<?php 
								if ($questionComment['dateModified'] != $questionComment['dateCreated']) {
									$temps = dateFr($questionComment['dateModified']);
								}
								elseif ($questionComment['dateModified'] == $questionComment['dateCreated']) {
									$temps = dateFr($questionComment['dateCreated']);
								}
								echo '<span class="actiontemps">' . $temps . " </span>";
							?>
						</div>
						<?php endforeach; ?>
						<!-- <div class="borderTop"></div>
						<div class="comment">Commentaire 1</div>
						<div class="comment">Commentaire 2</div> -->
					<?php endif; ?>
					</div>
				</div>
				<div class="boutonComment">
					<div class="left ajoutComment">Ajouter un commentaire</div>
				</div>
			</div>
			<div class="clear"></div>

			<?php if($reponses): ?>
			<div id="reponseDetails">
				<?php if($nbReponses == 1): ?><h1 class="borderBottom"><?= $nbReponses; ?> Réponse</h1><?php endif; ?>
				<?php if($nbReponses > 1): ?><h1 class="borderBottom"><?= $nbReponses; ?> Réponses</h1><?php endif; ?>

				<?php foreach ($reponses as $reponse): ?>
				<div class="reponse">
					<div class="hidden"><?= $reponse["id"];?></div>
					<div class="left sidebar">
						<div class="votePlus"></div>
						<div class="scorerep"><?= $reponse["scoreRep"];?></div>
						<div class="voteMoins"></div>
						<?php 
							$thereisonebest = false;
							if (isThereTheGoodAnswer($question['id'])) {
								$thereisonebest = true;
							}
							$classFav = "favoris0";
							if ($reponse["best"] == 1) {
								$classFav = "favoris1";
							}
							if ($id_utilisateur == $question['user_id'] && $reponse["best"] == 0 && !$thereisonebest) {
								$classFav = "favoris2";
							}
						?>
						<div class="<?= $classFav; ?>"></div>
					</div>
					<div class="left details">
						<div><?= $reponse["contenu"];?></div>
						<div class="who right">
							<?php 
								$utilisateur = getUserById($reponse['user_id']);
								if ($reponse['dateModified'] != $reponse['dateCreated']) {
									$action = "modifiée";
									$temps = dateFr($reponse['dateModified']);
								}
								elseif ($reponse['dateModified'] == $reponse['dateCreated']) {
									$action = "posée";
									$temps = dateFr($reponse['dateCreated']);
								}
								echo '<div class="actiontemps">' .$action . " - " . $temps . " </div>";
							?>
							<div>
								<a href="?page=profil&amp;id=<?= $reponse['user_id']; ?>" class="lienProfil"><?= $utilisateur['pseudo'];?></a>
								<span> <?= $utilisateur['score']; ?></span>
							</div>
						</div>
						<div class="clear"></div>
						<?php $reponseComments = getCommentsByIdReponse($reponse['id']); ?>
						<div class="zoneComment">
						<?php if ($reponseComments): ?>
							<div class="borderTop"></div>
							<?php foreach ($reponseComments as $reponseComment): ?>
							<div class="comment">
								<?php $utilisateur = getUserById($reponseComment['user_id']); ?>
								<span><?= $reponseComment['contenu'] ?></span>
								<a href="?page=profil&amp;id=<?= $reponseComment['user_id']; ?>" class="lienProfil"><?= $utilisateur['pseudo'];?></a>
								<?php 
									if ($reponseComment['dateModified'] != $reponseComment['dateCreated']) {
										$temps = dateFr($reponseComment['dateModified']);
									}
									elseif ($reponseComment['dateModified'] == $reponseComment['dateCreated']) {
										$temps = dateFr($reponseComment['dateCreated']);
									}
									echo '<span class="actiontemps">' . $temps . " </span>";
								?>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>
						</div>
					</div>
					<div class="boutonComment">
						<div class="left ajoutComment">Ajouter un commentaire</div>
					</div>
					<div class="clear borderBottomReponse"></div>
				</div>
				<?php endforeach; ?>
			</div>
			<!-- <div class="clear"></div> -->
			<!-- <div id="saut" class="borderBottom"></div> -->
			<?php endif; ?>

			<div id="votreReponse">
				<h1>Votre réponse</h1>
				<form action="?<?= $_SERVER['QUERY_STRING']; ?>" id="formReponse" method="POST" novalidate>
					<div>
						<textarea name="contenu" id="contenuReponse" class="editeur"><?= $contenu;?></textarea>
						<span class="errors"><?= $error['contenu']?></span>
					</div>
					<div>
						<input type="submit" id="submitReponse" value="Postez votre réponse">
						<span class="errors"><?= $error['submit']?></span>
						<span class="validates"><?= $validate; ?><span>
					</div>
				</form>
			</div>

			<div id="remarques">
				<p>Il n'y a pas la réponse que vous cherchiez ? Regardez les autres questions taguées 
				<span class="tag">
					<?php 
					foreach ($tags as $tag) { ?>
						<a href="?page=questionParTag&id=<?= $tag['id']; ?>&tagname=<?= $tag['tagname']; ?>"><span class='tagname'><?= $tag['tagname'] ?></span></a>
					<?php } ?>
				</span>
				ou <a href="?page=poserQuestion">posez vous-même votre question</a>.</p>
			</div>

		</main>