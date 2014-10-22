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
				display: "block",
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
		if( $("#formAjouteComment").length ) {
			$("#formAjouteComment").remove()
		}
		$(".popup").append(x).fadeIn()
	},

	fermer: function() {
		console.log("popup.fermer")
		$(".popup").fadeOut({
			duration: 1500,
			complete: function() {
				$(".popup").remove()
				// rechargement de la page
				location.reload()
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

		var reponse = $(this).parent().parent()
		console.log("reponse = " +reponse)
		var id_rep =reponse.find(".hidden").html()
		console.log("id_rep = " +id_rep)
		var score =reponse.find(".scorerep").html()
		console.log("score = " +score)

		var id_rep = 1
		vote.url = "?page=verifVote&id_rep="+id_rep
		$.ajax({
			url: vote.url, 
			success: function(server_response) {
				popup.afficher($(server_response).find("#formVote"))
				console.log("succès requête ajax dans fonction comment.vote")
			},
			error: function() {
				console.log("erreur dans fonction comment.vote")
			}

		})
		console.log("apres lancement ajax dans fonction comment.vote")
		// Prevent Default
		return false
	},

	enleve: function() {
		console.log("vote.enleve")
		console.log(this)
		

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
		$(document).on("click", "#reponseDetails .voteMoins", vote.enleve)

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