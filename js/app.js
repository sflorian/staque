/************************
 * 	 	Modules			*
 ************************/




/************************
 * 	 Objet principal 	*
 ************************/

app = {
	
	/*
	 * Chargement du DOM
	 */
	init: function() {

		console.log("app.init")

	},

	chargement: function(){

		console.log("app.chargement")
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