
		<main id="mainacceuil">

			<!-- DEBUT DE LA BOUCLE -->
			<?php 
				//foreach ($questions as $question) {
			?>


			<container class="question" >
				<div class="left compteur">
					<div class="left votes">
						<span class="count"><?php echo $retourbdd["votes"]; ?></span>
						<br>Votes
					</div>
					<div class="left reponses">
						<span class="count"><?php echo $retourbdd["rep"]; ?></span>
						<br>Réponses
					</div>
					<div class="left vues">
						<span class="count"><?php echo $retourbdd["vues"]; ?></span>
						<br>Vues
					</div>
				</div>
				<div class="titrequest">
					<div><?php echo $retourbdd["titre"]; ?></div>
					<div class="tag">
						<div class="left">
							<?php 
							//foreach ($tags as $tag){
							//	echo "<span class='tagname'>" . $tag["tagname"] . "</span>";
							//}
							?>
						</div>
						<div class="right">action temps <a href="profil"><?php echo $retourbdd["pseudo"];?></a> <?php echo $retourbdd["score"]; ?></div>
					</div>
				</div>
				<div class="clear"></div>
			
			</container>

			<!-- FIN DE LA BOUCLE -->
			<?php
			//}
			?>

 

		</main>