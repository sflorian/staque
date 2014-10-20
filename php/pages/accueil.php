<?php
	
	// Initialisation des variables
	$nbReponses = 0;
	$theone = false;

	$action = "ACTION";
	$temps = "DATE";


	$questions = getRecentQuestions(1);
	print_r($questions);
	die();

?>
		<main id="mainacceuil">

			<div id="listeQuestion" >
				<h1>Questions</h1>
				<?php if ($questions) {foreach ($questions as $question): ?>
				<div class="question">
					<div class="left compteur">
						<div class="left votes">
							<span class="count"><?= $question['scorequest']; ?></span>
							<!-- <span class="count">5</span>   -->
							<br>Votes
						</div>
						<?php 
							$nbReponses = getNbReponsesByIdQuestion($question['id']); 
							if (isThereTheGoodAnswer($question['id'])) {
								$theone = true;
							}
						?>
						<div class="left reponses <?php if ($nbReponses > 0) { echo 'repondu'; if ($theone == true) { echo ' theone'; } } ?>">
							<span class="count"><?= getNbReponsesByIdQuestion($question['id']); ?></span>
							<!-- <span class="count">0</span>  -->
							<br>Réponses
						</div>
						<div class="left vues">
							<span class="count"><?= $question['vues']; ?></span>
							<!-- <span class="count">0</span>   -->
							<br>Vues
						</div>
					</div>
					<div class="left detailquest">
						<div><a href="?page=questionDetails&amp;id=<?= $question['id']; ?>"><?= $question["titre"]; ?></a></div>
						<!-- <div class="titrequestion"><a href="">Titre question</a></div>   --> 
						<div class="tag left">
							<?php 
							$arrayTags = getTagsByIdQuestion($question['id']);
							foreach ($arrayTags as $tag) { ?>
								<a href="?page=questionParTag&amp;id=<?= $tag['id']; ?>"><span class='tagname'><?= $tag['tagname'] ?></span></a>;
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
								echo $action . " - " . $temps . " - ";
							?> 
							<a href="?page=profil&amp;id=<?= $question['user_id']; ?>" class="lienProfil"><?= $question["pseudo"];?></a>
							<?= $question['utilisateurScore']; ?>
						</div>
						<!-- <div class="right">action temps <a href="?page=profil" class="lienProfil">Pseudo</a> score_user</div> -->
					</div>
				</div>
				<?php endforeach; }	 ?>
			</div>

		</main>