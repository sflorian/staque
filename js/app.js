/************************
 * 	 	Modules			*
 ************************/

popup = {

	// Création de la popup
	init: function() {
		console.log("popup.init")

		// Je crée une popup
		this.overlay = $("<div>", {
			css: {
				position: "absolute",
				top: "20%",
				left: "10%",
				backgroundColor: "#000",
				padding: 50,
				display: "none",
				height: 400,
				width: 600,
				zIndex: 1
			}
		})

		// Je passe mon formulaire en position relative
		$("#questionDetails").css({position: "relative"})

		// J'ajoute au DOM
		$("#questionDetails").append( this.overlay )

	},

	// Ajouter un contenu
	affiche: function(x) {
		// J'ajoute le contenu puis j'affiche
		this.overlay.append(x).fadeIn()
	}

}

vote = {

	ajoute: function() {
		console.log("vote.ajoute")
		if ()

	}
}


/************************
 * 	 Objet principal 	*
 ************************/

app = {

	init: function() {

		console.log("app.init")

	},

	chargement: function(){

		console.log("app.chargement")

		// Charger la popup
		popup.init()

		/* ******** On pose des écouteurs ********** */
		$("#questionDetails").find(".votePlus").on("click", vote.ajoute)
	}

}



/*************************
 * 	Chargement du DOM 	 *
 *	= chargement du html *
 *************************/

$(function() {
	console.log("chargement du dom")
	app.init()
})


/****************************
 * 	Chargement de la page	*
 *	= chargement des assets	*
 ****************************/

$(window).load(function() {
	console.log("chargement de la page")
	app.chargement()
});