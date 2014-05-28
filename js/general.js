jQuery('document').ready(function ($) {

	// konami code
	if ( window.addEventListener ) {
		var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";
		window.addEventListener("keydown", function(e){
			kkeys.push( e.keyCode );
			if ( kkeys.toString().indexOf( konami ) >= 0 ){

				$('img').each(function(index, el) {
					$(this).attr('src', template_url+'/images/sainty.jpg').mouseenter(function() {
						if (!$(this).data('hey')){
							$(this).data('hey', true);
							$(this).attr('src', template_url+'/images/sainty_hey.jpg');
							var sainty = $(this);
							setTimeout(function(){
								sainty.attr('src', template_url+'/images/sainty.jpg');
								sainty.data('hey', false);
							}, 200);
						}
					});
				});

				kkeys = [];
			}
		}, true);
	}

});