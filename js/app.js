/************************
 * 	 	Modules			*
 ************************/

popup = {

	// Création de la popup
	init: function(where) {
		console.log("popup.init")
		// Je crée une popup
		this.overlay = $("<div>", {
			css: {
				position: "absolute",
				top: "0",
				left: "0",
				backgroundColor: "#000",
				display: "none",
				width: "90%",
				zIndex: 1
			}
		})
		this.overlay.addClass("popup")

		// Je crée la croix de fermeture de la popup
		this.ferme = $("<div>", {
			css: {
				backgroundImage: "url(../img/apparences/croix_fermeture.png)",
				backgroundRepeat: "no-repeat",
				backgroundPosition: "0 0",
				cursor: "pointer",
				float: "right",
				height: "20px",
				width: "20px"
			}
		})

		this.ferme.addClass("fermeture")


		// Je passe ma div reponseDetails en position relative
		where.css({position: "relative"})

		// J'ajoute au DOM
		$(this.overlay).append( this.ferme )
		where.append( this.overlay )

		// On écoute le click sur croix fermeture
		$(this.ferme).on("click", this.fermer)

	},

	// Ajouter un contenu et affiche
	afficher: function(x) {
		$(".popup").append(x).fadeIn()
	},

	fermer: function() {
		console.log("popup.fermer")
		$(".popup").fadeOut({
			complete: function() {
				$(".popup").remove()
			}
		})
	}

}

vote = {

	ajoute: function() {
		console.log("vote.ajoute")
		console.log(this)

	},

	enleve: function() {
		console.log("vote.enleve")
		console.log(this)
		

	}

}

/*commentQ = {

	ajoute: function(e) {
		e.preventDefault()

		console.log("commentQ.ajoute")
		
		// Charger la popup
		var where = $("#questionDetails .ajoutComment").parent()
		console.log("div where popup = " +where)
		popup.init(where)

		// Quelle question ?
		var id_quest = where.parent().find(".hidden").html()
		console.log("id_quest = " +id_quest)

		var url = "?page=ajouteComment&id="+id_quest+"&foreign_table=question"
		console.log("url = " +url)

		$.ajax({
			url: url, 
			success: function(server_response) {
				popup.afficher($(server_response).find("#formAjouteComment"))
				//popup.fermer()
				console.log("succès requête ajax dans fonction commentQ.ajoute")
			},
			error: function() {
				console.log("erreur dans fonction commentQ.ajoute")
			}
		})
		console.log("apres lancement ajax dans fonction commentQ.ajoute")
		// Prevent Default
		return false
	}

}

commentR = {

	ajoute: function(e) {
		e.preventDefault()

		console.log("commentR.ajoute")

		// Charger la popup
		var where = $(this).parent()
		console.log("div where popup = " +where)
		popup.init(where)

		// Quelle question ?
		var id_quest = where.parent().find(".hidden").html()
		console.log("id_quest = " +id_quest)

		// Quelle reponse ?
		var id_rep = where.parent().find(".hidden").html()
		console.log("id_rep = " +id_rep)

		var url = "?page=ajouteComment&id="+id_quest+"&foreign_table=reponse&id_rep="+id_rep
		console.log("url = " +url)

		$.ajax({
			url: url, 
			success: function(server_response) {
				popup.afficher($(server_response).find("#formAjouteComment"))
				//popup.fermer()
				console.log("succès requête ajax dans fonction commentR.ajoute")
			},
			error: function() {
				console.log("erreur dans fonction commentR.ajoute")
			}

		})

		console.log("apres lancement ajax dans fonction commentR.ajoute")

		// Prevent Default
		return false

	}

}*/


comment = {

	ajoute: function(e) {
		e.preventDefault()

		console.log("comment.ajoute")

		// Charger la popup
		var where = $(this).parent()
		console.log("div where popup = " +where.html())
		popup.init(where)

		// Quelle question ? Quelle réponse ?
		if (where.parent().attr("id") == "questionDetails") {
			console.log(where.parent().attr("id"))
			var foreign_table = "question"
			// Quelle question ?
			var id_quest = where.parent().find(".hidden").html()
			console.log("id_quest = " +id_quest)
			// Quelle reponse ?
			//var id_rep = where.parent().parent().find(".reponseDetails").html().find(".hidden").html()
			//console.log("id_rep = " +id_rep)
		}
		if (where.parent().attr("class") == "reponse") {
			console.log(where.parent().attr("class"))
			var foreign_table = "reponse"
			// Quelle question ?
			var divquest = where.parent().parent().parent().find("#questionDetails")
			console.log("divquest = " +divquest)
			var id_quest = divquest.find(".hidden").html() 
			console.log("id_quest = " +id_quest)
			// Quelle reponse ?
			var id_rep = where.parent().find(".hidden").html()
			console.log("id_rep = " +id_rep)
		}
		
		if (foreign_table == "question") {
			var url = "?page=ajouteComment&id="+id_quest+"&foreign_table="+foreign_table
		}if (foreign_table == "reponse") {
			var url = "?page=ajouteComment&id="+id_quest+"&foreign_table="+foreign_table+"&id_rep="+id_rep
		}
		console.log("url = " +url)

		$.ajax({
			url: url, 
			success: function(server_response) {
				popup.afficher($(server_response).find("#formAjouteComment"))
				//popup.fermer()
				console.log("succès requête ajax dans fonction comment.ajoute")
			},
			error: function() {
				console.log("erreur dans fonction comment.ajoute")
			}

		})

		console.log("apres lancement ajax dans fonction comment.ajoute")

		// Prevent Default
		return false

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

		/* ******** On pose des écouteurs ********** */
		//$("#questionDetails .ajoutComment").on("click", commentQ.ajoute)
		//$(document).on("click", "#comment", commentQ.ajoute)
		$(document).on("click", ".ajoutComment", comment.ajoute)
		$(document).on("submit", "#submitComment", comment.ajoute)
		$("#reponseDetails .votePlus").on("click", vote.ajoute)
		$("#reponseDetails .voteMoins").on("click", vote.enleve)
		//$("#reponseDetails").on("click", ".ajoutCommentR", commentR.ajoute)

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