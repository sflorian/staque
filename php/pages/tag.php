<?php	

	$tags = nbQuestByTag();
	
?>
		<main id="mainTags">

			<div id="listeTags" >
				<h1 class="borderBottom">Tags</h1>
				<div id="tagcontain">
					<div class"tag">
						<?php 
							foreach ($tags as $tag) { ?>
								<a href="?page=questionParTag&id=<?= $tag['id']; ?>&tagname=<?= $tag['tagname'] ?>"><span class='tagname'><?= $tag['tagname'] ?> : <?= $tag["tagCounter"];?></span></a>
						<?php } ?>
					</div>
				</div>
			</div>

		</main>