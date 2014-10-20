<?php

	//$questions = getRecentQuestions(1);

	//foreach ($questions as $question) {
	//	$nbReponses = getNbReponsesByIdQuestion($question['id']);
	//	$arrayTags = getTagsByIdQuestion($question['id']);
	//}

?>
		<main id="mainacceuil">
			<div id="listeQuestion" >
				<h1>Questions</h1>
				<!-- < ?php foreach ($questions as $question): ?> -->
				<div class="question">
					<div class="left compteur">
						<div class="left votes">
							<!-- <span class="count">< ?= $question['scorequest']; ?></span> -->
							<span class="count">5</span>  
							<br>Votes
						</div>
						<?php 
							/*$nbReponses = getNbReponsesByIdQuestion($question['id']); 
							$theone = false;
							if (isThereTheGoodAnswer($question['id'])) {
								$theone = true;
							}*/
						?>
						<div class="left reponses <?php if (1==1) { echo 'repondu'; if (1 == 1) { echo 'theone'; } } ?>">
							<!-- <span class="count">< ?php echo getNbReponsesByIdQuestion($question['id']); ?></span> -->
							<span class="count">0</span> 
							<br>Réponses
						</div>
						<div class="left vues">
							<!-- <span class="count">< ?php echo $question['vues']; ?></span> -->
							<span class="count">0</span>  
							<br>Vues
						</div>
					</div>
					<div class="left detailquest">
						<!-- <div>< ?= $question["titre"]; ?></div> -->
						<div class="titrequestion">Titre question</div>   
						<div class="tag left">
							<?php 
							//$arrayTags = getTagsByIdQuestion($question['id']);
							//foreach ($arrayTags as $tag){
							//	echo "<a href=""><span class='tagname'>" . $tag["tagname"] . "</span></a>";
							//}
							?>
							<a href=""><span class='tagname'>tag1</span></a>
							<a href=""><span class='tagname'>tag2</span></a>
							<a href=""><span class='tagname'>tag3</span></a>
						</div>
						<!-- <div class="right">action temps <a href="?page=profil&amp;id=< ?= $question['user_id']; ?>">< ?php echo $question["pseudo"];?></a> < ?php echo $question["score"]; ?></div> -->
						<div class="right">action temps <a href="?page=profil">Pseudo</a> score_user</div>
					</div>
					<!-- <div class="clear"></div> -->
				</div>
				<!-- < ?php endforeach; ?> -->
			</div>

			<!-- FIN DE LA BOUCLE -->
			<?php
			//}
			?>

 

		</main>