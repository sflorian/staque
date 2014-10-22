<body>
	<header>
		<section id="sectionHeader">
			<div class="left">
				<img src="../img/apparences/logo.png" id="logo">
			</div>
			<div id="menu">
				<ul>
					<li><input type="text" name="recherche" id="inputrecherche" placeholder="Recherche" size="10" maxlength="8" />
						<img src="../img/apparences/Search.png" id="recherche"></li>
					<?php if(!userIsLogged()) { ?>
					<li class="boutonMenu"><a href="?page=connexion">Connexion</a></li>
					<li class="boutonMenu"><a href="?page=creerUnCompte">Nouveau ?</a></li>
					<?php } ?>
					<?php if(userIsLogged()) { ?>
						<li class="boutonMenu"><a href="?page=deconnexion">Déconnexion</a></li>
					<?php } ?>
					<li class="session">
						<?php if(userIsLogged()) {
							echo '<a href="?page=profil&id=' . $_SESSION['utilisateur']['id'] . '">Bonjour ' . $_SESSION['utilisateur']['pseudo'] . "</a>";
						} ?>
					</li>
				</ul>	
			</div>
		</section>
		<nav id="nav">
			<section id="sectionNav">
				<div id="listeNav" class="right">
						<li <?php if($_SERVER['QUERY_STRING']== "page=accueil") {echo 'class="active"';} ?>><a href="?page=accueil">Questions</a></li>
						<li <?php if($_SERVER['QUERY_STRING']== "page=tag") {echo 'class="active"';} ?>><a href="?page=tag">Tags</a></li>
						<li><a href="?page=accueil">Utilisateurs</a></li>
						<li><a href="?page=accueil">Badges</a></li>
						<li <?php if($_SERVER['QUERY_STRING']== "page=poserQuestion") {echo 'class="active"';} ?>><a href="?page=poserQuestion">Poser une question</a></li>
				</div>
			</section>
		</nav>
	</header>

