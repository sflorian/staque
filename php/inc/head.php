<body>
	<header>
		<section id="sectionHeader">
			<a href="index.php" class="left" id="statrix"><h1>< STATRIX ></h1></a>
			<div id="menu">
				<ul>
					<li><form action="index.php" method="GET"><input type="hidden" name="page" value="recherche"><input type="text" name="motsclefs" id="inputrecherche" placeholder="Recherche" size="10" class="autocomplete" /></form>
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
						<li <?php if($_GET["page"] == "accueil" || $_GET["page"] == "questionDetails") {echo 'class="active"';} ?>><a href="?page=accueil">Questions</a></li>
						<li <?php if($_GET["page"] == "tag" || $_GET["page"] == "questionParTag") {echo 'class="active"';} ?>><a href="?page=tag">Tags</a></li>
						<li <?php if($_GET["page"] == "utilisateur" || $_GET["page"] == "creerUnCompte" || $_GET["page"] == "connexion" || $_GET["page"] == "profil" || $_GET["page"] == "modifierUnePhoto") {echo 'class="active"';} ?>><a href="?page=utilisateur">Utilisateurs</a></li>
						<!-- <li><a href="?page=accueil">Badges</a></li> -->
						<li <?php if($_GET["page"] == "poserQuestion") {echo 'class="active"';} ?>><a href="?page=poserQuestion">Poser une question</a></li>
				</div>
			</section>
		</nav>
	</header>