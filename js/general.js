jQuery('document').ready(function($){

	// empeche ie de planter à chaque console
	if (typeof console != "object") {
		var console = {
			'log':function(){}
		};
	}
	
	console.log('hop');
	
	// konami code
	if ( window.addEventListener ) {
		var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";
		window.addEventListener("keydown", function(e){
			kkeys.push( e.keyCode );
			if ( kkeys.toString().indexOf( konami ) >= 0 ){
				
				// KONAMI CODE ACTIVÉ!
				alert('KONAMI CODE ACTIVÉ!');
				
				kkeys = [];
			}
		}, true);
	}

});