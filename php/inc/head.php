<body>
	<header>
		<section id="sectionHeader">
			<div class="left">
				<img src="img/logo/<!-- IMAGE DU LOGO -->" id="logo">
			</div>
			<div id="menu">
				<ul>
					<li><input type="text" name="recherche" id="inputrecherche" placeholder="Recherche" size="10" maxlength="8" />
						<img src="../img/barre_Recherche/Search.png" id="recherche"></li>
					<?php if(!userIsLogged()) { ?>
					<li class="boutonMenu"><a href="?page=connexion">Connexion</a></li>
					<li class="boutonMenu"><a href="?page=creerUnCompte">Nouveau ?</a></li>
					<?php } ?>
					<?php if(userIsLogged()) { ?>
						<li class="boutonMenu"><a href="?page=deconnexion">Déconnexion</a></li>
					<?php } ?>
					<li class="session">
						<?php if(userIsLogged()) {
							echo "Bonjour " . $_SESSION['utilisateur']['pseudo'];
						} ?>
					</li>
				</ul>	
			</div>
		</section>
	</header>
	<nav>
		<section>
			<div class="right">
				<ul>
					<li><a href="<!-- Lien de l'onglet 1 -->"></a>Questions</li>
					<li><a href="<!-- Lien de l'onglet 2 -->"></a>Tags</li>
					<li><a href="<!-- Lien de l'onglet 3 -->"></a>Utilisateurs</li>
					<li><a href="<!-- Lien de l'onglet 4 -->"></a>Badges</li>
					<li><a href="<!-- Lien de l'onglet 5 -->"></a>Poser une question</li>
				</ul>
			</div>
		</section>
	</nav>
