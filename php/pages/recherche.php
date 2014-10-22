<?php
		
		// Vérification qu'on a bien une recherche sinon ACCUEIL
	if (empty($_GET['motsclefs'])){ 
		goHome();
	}
	
		// récupère le paramètre d'url "id"
	$recherche = $_GET["motsclefs"];
	$resultRecherche = recherche($recherche);

?>


		<main id="mainQuestionParTag">

			<div id="listeQuestionParTag" >
				<h1 class="borderBottom tag">Les questions résultants de votre recherche : <?= $recherche;?></h1>
				<?php if ($resultRecherche) {foreach ($resultRecherche as $question): ?>
				<div class="question">
					<div class="left compteur">
						<a href="?page=questionDetails&amp;id=<?= $question['id']; ?>">
							<div class="left votes">
								<span class="count"><?= $question['scorequest']; ?></span>
								<!-- <span class="count">5</span>   -->
								<br>Votes
							</div>
						</a>
						<?php 
							$arrayTags = getTagsByIdQuestion($question['id']);
							//print_r($arrayTags);
							$nbReponses = getNbReponsesByIdQuestion($question['id']); 
							if (isThereTheGoodAnswer($question['id'])) {
								$theone = true;
							}
						?>
						<a href="?page=questionDetails&amp;id=<?= $question['id']; ?>">
							<div class="left reponses <?php if ($nbReponses > 0) { echo 'repondu'; if ($theone == true) { echo ' theone'; } } ?>">
								<span class="count"><?= getNbReponsesByIdQuestion($question['id']); ?></span>
								<!-- <span class="count">0</span>  -->
								<br>Réponses
							</div>
						</a>
						<a href="?page=questionDetails&amp;id=<?= $question['id']; ?>">
							<div class="left vues">
								<span class="count"><?= $question['vues']; ?></span>
								<!-- <span class="count">0</span>   -->
								<br>Vues
							</div>
						</a>
					</div>
					<div class="left detailquest">
						<div class="titrequestion"><a href="?page=questionDetails&amp;id=<?= $question['id']; ?>"><?= $question["titre"]; ?></a></div>
						<!-- <div class="titrequestion"><a href="">Titre question</a></div>   --> 
						<div class="tag left">
							<?php 
							foreach ($arrayTags as $tag) { ?>
								<a href="?page=questionParTag&id=<?= $tag['id']; ?>&tagname=<?= $tag['tagname'] ?>"><span class='tagname'><?= $tag['tagname'] ?></span></a>
							<?php } ?>
							<!-- <a href=""><span class='tagname'>tag1</span></a>
							<a href=""><span class='tagname'>tag2</span></a>
							<a href=""><span class='tagname'>tag3</span></a> -->
						</div>
						<div class="right">
							<?php 
								if ($question['repDateModified']) {
									$action = "répondue";
									$temps = dateFr($question['repDateModified']);
								}
								elseif ($question['dateModified'] != $question['dateCreated']) {
									$action = "modifiée";
									$temps = dateFr($question['dateModified']);
								}
								elseif ($question['dateModified'] == $question['dateCreated']) {
									$action = "posée";
									$temps = dateFr($question['dateCreated']);
								}
								echo '<span class="actiontemps">' .$action . " - " . $temps . " </span>";
							?> 
							<a href="?page=profil&amp;id=<?= $question['user_id']; ?>" class="lienProfil"><?= $question["utilisateurPseudo"];?></a>
							<?= $question['utilisateurScore']; ?>
						</div>
						<!-- <div class="right">action temps <a href="?page=profil" class="lienProfil">Pseudo</a> score_user</div> -->
					</div>
				</div>
				<?php endforeach; }	 ?>
			</div>

		</main>