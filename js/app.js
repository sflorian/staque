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
		if( $("#formAjouteComment").length ) {
			$("#formAjouteComment").remove()
		}
		$(".popup").append(x).fadeIn()
	},

	fermer: function() {
		console.log("popup.fermer")
		$(".popup").fadeOut({
			duration: 2000,
			complete: function() {
				$(".popup").remove()
				// rechargement de la page
				location.reload()
				/*$.ajax({
					url: window.location.href,
					success: function(server_response) {
						console.log($(server_response).find("#mainQuestionDetails"))
						//$("#mainQuestionDetails").html($(server_response).find("#mainQuestionDetails").html())
					}
				})*/
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

comment = {

	ajoute: function() {

		console.log("comment.ajoute")
		//var urlBack = $("#mainQuestionDetails > .hidden").html()
		//console.log("urlBack = " +urlBack)

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
			comment.url = "?page=ajouteComment&id="+id_quest+"&foreign_table="+foreign_table   //+"&urlback="+urlBack
		}
		if (foreign_table == "reponse") {
			comment.url = "?page=ajouteComment&id="+id_quest+"&foreign_table="+foreign_table+"&id_rep="+id_rep   //+"&urlback="+urlBack
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
		$("#reponseDetails .votePlus").on("click", vote.ajoute)
		$("#reponseDetails .voteMoins").on("click", vote.enleve)

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