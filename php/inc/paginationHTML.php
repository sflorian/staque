	<?php //lien vers la première page ?>
	<a href="?page=accueil&p=1&dir=<?php echo strtolower($direction); ?>" id="premierepage"><<</a>

	<?php //lien vers la page précédente ?>
	<?php if ($p > 1){ ?>
	<a href="?page=accueil&p=<?php echo $p - 1; ?>&dir=<?php echo strtolower($direction); ?>" id="pageprec"><</a>
	<?php } ?>
	
	<?php //affiche 5 liens vers les pages précédentes, 5 vers les suivantes
		
		for($i = ($p-5); $i < ($p+5); $i++){
			if ($i < 1 || $i > $totalPages){ continue; } //n'affiche pas le lien aux extrémités
			echo '<a href="?page=accueil&dir=' . strtolower($direction) . '&p=' . $i . '" class="numpage">' . $i . '</a> ';
		}
	?>

	<?php //lien vers la page précédente ?>
	<?php if ($p < $totalPages){ ?>
	<a href="?page=accueil&p=<?php echo $p + 1; ?>&dir=<?php echo strtolower($direction); ?> "id="pagesuiv">></a>
	<?php } ?>
	
	<?php //lien vers la dernière page ?>
	<a href="?page=accueil&p=<?php echo $totalPages; ?>&dir=<?php echo strtolower($direction); ?>" id="dernierepage">>></a>