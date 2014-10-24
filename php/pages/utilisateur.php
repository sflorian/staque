<?php

	$utilisateurs = getUsers();

?>

<main id="mainUtilisateur">
	<div id="utilisateur">
		<?php foreach ($utilisateurs as $utilisateur): ?>
			<div class="utilisateur">
				<div class="left">
					<img src="../img/uploads/profil128/<?= $utilisateur['photo']; ?>" class="photo"/>
				</div>
				<div class="left">
					<a href="?page=profil&amp;id=<?= $utilisateur['id']; ?>" class="lienProfil"><?= $utilisateur['pseudo'];?></a>
					<p>Score =  <strong><?= $utilisateur['score']; ?></strong></p>
					<p>Questions posées =  <strong><?= getNbQuestionByIdUser($utilisateur['id']); ?></strong></p>
					<p>Réponses postées =  <strong><?= getNbReponseByIdUser($utilisateur['id']); ?></strong></p>
					<p>Nb commentaires =  <strong><?= getNbCommentByIdUser($utilisateur['id']); ?></strong></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</main>