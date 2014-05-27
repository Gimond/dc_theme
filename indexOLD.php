<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<script src="js/jquery-1.5.js"></script>
<script>
$(document).ready(function() {
    /*** REDIMENSIONNEMENT ***/
	repositionner();
	
	$(window).resize(function() {
		repositionner();
	});
});

function repositionner(){
	widthEcran = $(window).width();
	heightEcran = $(window).height();
	
	//GESTION DES TITRES
	topWait = heightEcran/2 - 135;
	leftWait = widthEcran/2 - 280;
	$('#wait').css('top',topWait+'px');
	$('#wait').css('left',leftWait+'px');
}
</script>
</head>

<body style="background-color:#9f042e; margin:0;">
<div style="width:100%; height:30px; background:url('img/fond-header.jpg') repeat-x top left;"></div>
<div id="wait" style="position:absolute;"><img src="img/wait.png" /></div>
<div style="width:100%; height:30px; background:url('img/fond-footer.jpg') repeat-x top left; position:fixed; bottom:0px; left:0px;"></div>
</body>
</html>