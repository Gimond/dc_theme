<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title><?php bloginfo('name') ?> - site en construction</title>

<style>
* {
	margin:0;
	padding:0;
}

header {
	background:url('<?php bloginfo('template_url') ?>/images/maintenance-header.png') repeat-x;
	width:100%;
	height:200px;
	text-align:center;
}


section {
	width:700px;
	display:table;
	margin:auto;
	font-family:calibri;
}

section article {
	margin-top:20px;
	text-align:justify;
}

section article h1 {
	text-align:center;	
	font-size:25px;
}
section aside {
	float:right;	
	width:375px;
	margin-top:20px;
}

section article p {
	float:left;	
	width:300px;	
	margin-top:40px;
}

section article p.end {
	font-size:15px;
	float:left;
	width:300px;
}	

p span {
	font-weight:bold;
	text-align:center;
	font-size:37px;	
}
</style>

</head>

<body>
<header>
	<img src='<?php bloginfo('template_url') ?>/images/maintenance-logo.png' />
</header>

<section>
	<article>
    	<h1>Bienvenue sur le site <?php bloginfo('name') ?></h1>
        <p>Il est actuellement <b>en construction</b>. N'hésitez pas à revenir régulièrement pour voir si il est terminé.</br> </br> </br> </br>    
        <span>A bientot</span> </p>
    </article>	
    <aside>
    	<img src='<?php bloginfo('template_url') ?>/images/maintenance-logo-client.png' alt='logoClient' title='logo client' border=0' width='375'>
    </aside>
</section>
</body>
</html>
