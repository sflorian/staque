<?php

	if(!empty($_GET['id'])) {
		$id = $_GET['id'];
	}


?>	


		<main id="mainQuestionDetails">

			<h1><?php echo $retourbdd["titre"]; ?></h1>

			<container id="questioncadre">
				<div class="left">
					<div>+</div>
					<div><?php echo $retourbdd["score"];?></div>
					<div>-</div>
					<div>favoris</div>
				</div>
				<div class="left">
					<div><?php echo $retourbdd["contenu"];?></div>
				</div>
					<div class="tag">
						<div class="left">
							<?php 
							//foreach ($tags as $tag){
							//	echo "<span class='tagname'>" . $tag["tagname"] . "</span>";
							//}
							?>
						</div>
					</div>
					//PROFIL
					<div class="right">
						<div></div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				<div id="commentaire"></div>
			</container>
			<container>
				<?php 
				foreach ($commentaires as $commentaire) {
				?>
				
				<div class="left">
					<div>+</div>
					<div><?php echo $retourbdd["score"];?></div>
					<div>-</div>
					<div>favoris</div>
				</div>
				<div class="left">
					<div><?php echo $retourbdd["contenu"];?></div>
				</div>
					<div class="tag">
						<div class="left">
							<?php 
							//foreach ($tags as $tag){
							//	echo "<span class='tagname'>" . $tag["tagname"] . "</span>";
							//}
							?>
						</div>
					</div>
					//PROFIL
					<div class="right">
						<div></div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				<div class="commentaire"></div>
				
				<?php
				}
				?>
			</container>
<!-- A TERMINER !!!!!!!!!!!!!!!!!!!!!!! -->

		</main>