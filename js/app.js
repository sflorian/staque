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
		$(document).on("click", ".nonFermeture", this.fermer)

	},

	// Ajouter un contenu et affiche
	afficher: function(x) {
		if( $("#formAjouteComment").length ) {
			$("#formAjouteComment").remove()
		}
		if( $("#formVote").length ) {
			$("#formVote").remove()
		}
		$(".popup").append(x).fadeIn()
	},

	fermer: function() {
		console.log("popup.fermer")
		$(".popup").fadeOut({
			duration: 1500,
			complete: function() {
				// rechargement de la page
				if( $(".validates").html() != "" ) { /* != */
					location.reload()
					/*var urlBack = window.location.href
					urlBack = "?" +urlBack.split('?')[1]
					console.log("urlBack = " +urlBack)
					$.ajax({
						url: urlBack, 
						success: function(server_response) {
							var retour = $(server_response).find("#mainQuestionDetails").html()
							console.log("retour = " +retour)
							$("#mainQuestionDetails").html("").append(retour)
							console.log("succès requête ajax dans fonction popup.fermer")
						},
						error: function() {
							console.log("erreur dans fonction popup.fermer")
						}
					})
					console.log("apres lancement ajax dans fonction popup.fermer")
					// Prevent Default
					return false*/
				}
				$(".popup").remove()
			}
		})
	}

}

comment = {

	ajoute: function() {

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
			comment.url = "?page=ajouteComment&id="+id_quest+"&foreign_table="+foreign_table   
		}
		if (foreign_table == "reponse") {
			comment.url = "?page=ajouteComment&id="+id_quest+"&foreign_table="+foreign_table+"&id_rep="+id_rep   
		}
		console.log("url = " +comment.url)

		$.ajax({
			url: comment.url, 
			success: function(server_response) {
				popup.afficher($(server_response).find("#formAjouteComment"))
				console.log("succès requête ajax dans fonction comment.ajoute")
			},
			error: function() {
				console.log("erreur dans fonction comment.ajoute")
			}

		})
		console.log("apres lancement ajax dans fonction comment.ajoute")
		// Prevent Default
		return false

	},

	check : function() {
		// Traitement des infos du formulaire
		var commentaire = $("#comment").val()

		$.ajax({
			type: "POST",
			//url: "",
			url: comment.url, 
			data: {comment: commentaire},
			success: function(server_response) {
				popup.afficher($(server_response).find("#formAjouteComment"))
				if ( $(".validates").html() != "" ) {
					popup.fermer()
				}
				console.log("succès requête ajax dans fonction comment.check")
			},
			error: function() {
				console.log("erreur dans fonction comment.check")
			}

		})
		console.log("apres lancement ajax dans fonction comment.check")
		// Prevent Default
		return false
	},

}

vote = {

	ajoute: function() {
		console.log("vote.ajoute")

		// Charger la popup
		var where = $(this).parent().parent().find(".details")
		popup.init(where)
		$(".popup").css({width: "490px"})

		var reponse = $(this).parent().parent()
		console.log("reponse = " +reponse)
		var id_rep =reponse.find(".hidden").html()
		console.log("id_rep = " +id_rep)
		var score =reponse.find(".scorerep").html()
		console.log("score = " +score)
		var point = "plus"
		console.log("point = " +point)

		vote.url = "?page=verifVote&id_rep="+id_rep+"&point="+point
		$.ajax({
			url: vote.url, 
			success: function(server_response) {
				popup.afficher($(server_response).find("#formVote"))
				console.log("succès requête ajax dans fonction vote.ajoute")
			},
			error: function() {
				console.log("erreur dans fonction vote.ajoute")
			}

		})
		console.log("apres lancement ajax dans fonction vote.ajoute")
		// Prevent Default
		return false
	},

	check: function() {
		// Traitement des infos du formulaire
		var ok = $("#hidden").val()

		$.ajax({
			type: "POST",
			url: vote.url, 
			data: {hidden: ok},
			success: function(server_response) {
				popup.afficher($(server_response).find("#formVote"))
				if ( $(".validates").html() != "" ) {
					popup.fermer()
				}
				console.log("succès requête ajax dans fonction vote.check")
			},
			error: function() {
				console.log("erreur dans fonction vote.check")
			}

		})
		console.log("apres lancement ajax dans fonction vote.check")
		// Prevent Default
		return false
	},

	enleve: function() {
		console.log("vote.enleve")

		// Charger la popup
		var where = $(this).parent().parent().find(".details")
		popup.init(where)
		$(".popup").css({width: "490px"})

		var reponse = $(this).parent().parent()
		console.log("reponse = " +reponse)
		var id_rep =reponse.find(".hidden").html()
		console.log("id_rep = " +id_rep)
		var score =reponse.find(".scorerep").html()
		console.log("score = " +score)
		var point = "moins"
		console.log("point = " +point)

		vote.url = "?page=verifVote&id_rep="+id_rep+"&point="+point
		$.ajax({
			url: vote.url, 
			success: function(server_response) {
				popup.afficher($(server_response).find("#formVote"))
				console.log("succès requête ajax dans fonction vote.enleve")
			},
			error: function() {
				console.log("erreur dans fonction vote.enleve")
			}

		})
		console.log("apres lancement ajax dans fonction vote.enleve")
		// Prevent Default
		return false		
	}

}

best = {

	init: function(where) {
		console.log("best.init")

		// Je crée la popup
		this.popjs = $("<div>", {
			css: {
				position: "absolute",
				top: "150px",
				left: "0",
				backgroundColor: "#000",
				display: "block",
				width: "100%",
				zIndex: 1
			},
			addClass: "popupjs"
		})
		//this.popjs.addClass("popupjs")

		// Je crée une div question : 
		this.divjs = $("<div>", {
			css: {
				color: "#fff"
			},
			html: "BEST?"
		})
		// Je crée les boutons oui et non
		this.ouijs = $("<div>", {
			css: {
				background: "#505E5E",
				border: "2px outset buttonface",
				borderRadius: "5px",
				color: "#fff",
				cursor: "pointer",
				fontSize: "0.8em",
				margin: "5px 12px",
				padding: "2px"
			},
			html: "OUI",
			addClass: "boutOUI"
		})
		this.nonjs = $("<div>", {
			css: {
				background: "#505E5E",
				border: "2px outset buttonface",
				borderRadius: "5px",
				color: "#fff",
				cursor: "pointer",
				fontSize: "0.8em",
				margin: "5px 12px",
				padding: "2px"
			},
			html: "NON",
			addClass: "boutNON"
		})

		// Je passe ma div reponseDetails en position relative
		where.css({position: "relative"})

		// J'ajoute au DOM
		$(this.popjs).append( this.divjs )
		$(this.popjs).append( this.ouijs )
		$(this.popjs).append( this.nonjs )
		where.append( this.popjs )

		// On écoute le click sur croix fermeture
		$(this.ouijs).on("click", this.check)
		$(this.nonjs).on("click", this.fermer)

	},

	confirme: function() {
		console.log("best.confirme")

		// Charger la popup en JS !
		this.where = $(this).parent()
		console.log("where div = " +where)
		best.init(where)


	},

	check: function() {
		console.log("best.check")

		var id_rep = best.where.parent().find(".hidden").html()
		console.log("id_rep = " +id_rep)

	},

	fermer: function() {
		console.log("best.fermer")
		$(".popupjs").fadeOut({
			duration: 1500,
			complete: function() {
				$(".popjs").remove()
			}
		})		
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
		$(document).on("click", ".ajoutComment", comment.ajoute)
		$(document).on("submit", "#formAjouteComment", comment.check)
		$(document).on("click", "#reponseDetails .votePlus", vote.ajoute)
		$(document).on("submit", "#formVote", vote.check)
		$(document).on("click", "#reponseDetails .voteMoins", vote.enleve)
		$(document).on("click", "#reponseDetails .favoris", best.confirme)

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