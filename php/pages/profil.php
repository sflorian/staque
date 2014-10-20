		<main id="mainPoserQuestion">
			<container>
				<h1><?= '$pseudo';?></h1>

				<div>
					<div id="containerPhoto" class="left">
						<img src="../img/uploads/8-mile-2002.jpg<?php // '$photo';?>" id="profilePic">
						<a href="#score"><?= '$score';?><br>score</a>
					</div>
					<div id="containerInfo" class="left">
						<div class="labelOfLabel">bio
							<div class="infoLabel">site : <?= '$lien';?></div>
							<div class="infoLabel">pays : <?= '$pays';?></div>
							<div class="infoLabel">age : <?= '$age';?></div>
						</div>
						
						<div class="labelOfLabel">visites
							<div class="infoLabel">date d'inscription : <?= '$dateCreated';?></div>
							<div class="infoLabel">dernière visite : <?= '$dateLogged';?></div>
						</div class="labelOfLabel">
						
						<div class="labelOfLabel">statistiques
							<div class="infoLabel">vues du profil</div>
						</div>
						
						<div class="labelOfLabel">privé
							<div class="infoLabel">email : <?= '$email';?></div>
							<div class="infoLabel">nom et prénom : <span><?= '$prenom';?> <?='$nom';?></div>
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
		
