<?php

		// Vérification qu'on a bien un id sinon ACCUEIL
	if (empty($_GET['id']) && $_GET['id'] != 0) { 
		goHome();
	}
	
		// récupère le paramètre d'url "id"
	$id = $_GET['id'];

	$question = getQuestionById($id);
	$tags = getTagsByIdQuestion($id);
	$questionComments = getCommentsByIdQuestion($id);
	$reponses = getReponsesByIdQuestion($id);
	//$reponseComments = getCommentsByIdReponse($rep_id);

?>	


		<main id="mainQuestionDetails">

			<h1 class="borderBottom"><?= $question["titre"]; ?></h1>

			<div id="questionDetails">
				<div class="left sidebar">
					<div class="votePlus">+</div>
					<div calss="scorequest"><?= $question["scorequest"];?></div>
					<div class="voteMoins">-</div>
					<div>favoris</div>
				</div>
				<div class="left details">
					<div><?= $question["contenu"];?></div>
					<div class="tag left">
							<?php 
							foreach ($tags as $tag) { ?>
								<a href="?page=questionParTag&amp;id=<?= $tag['id']; ?>"><span class='tagname'><?= $tag['tagname'] ?></span></a>
							<?php } ?>
					</div>
					<div class="commentaire"></div>
				</div>
			</div>


		</main>