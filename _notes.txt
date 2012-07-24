Basé sur Starkers HTML5
http://nathanstaines.com/archive/starkers-html5

COMPREND:
- Jquery
- timthumb
- Un reset CSS HTML5
- HTML5 shiv pour le support des balises HTML5 sur les vieilles version d'IE
- konami code (general.js)
- fix ie permettant d'utiliser la console en js sans tout faire planter
- une page d'options (voir plus bas)
- feuille de style pour l'éditeur tinymce (css/tinymce.css)
- images à la une activées par défaut

PAGE D'OPTIONS
Une page d'options générales pour le thème.
Activée par défaut avec les options pour modifier :
- favicon
- code google analytics
- mode maintenance => si activé, le site est accessible uniquement aux utilisateurs connectés, la page de maintenance affichée pour les autres se situe à la racine (maintenance.php)
Il est possible d'ajouter d'autres options sur le fichier theme-options.php, tout les types de champs possibles sont en exemple dans le fichier theme-options-sample.php
Pour l'utilisation en front, les données sont récuperables via get_option (fonction native):
	$options = get_option('dc_theme_options');
	echo $options['nom_option'];

AJOUT DE FICHIER JS/CSS
Pour ajouter des fichiers js ou css, merci de le faire dans le fichier functions.php

MULTILANGUE
Le thème est prêt pour l'ajout d'une langue grâce à l'utilisation des fonctions de traductions de wordpress (_e et autres), merci de continuer à utiliser ces fonctions en cas d'ajout de texte en dur.


---------------------------------


Modernizr n'est plus intégré car rarement utilisé, sa fonction de support du HTML5 sous IE est remplacée par le script HTML5 shiv, pour le reste, je laisse les infos là dessous à titre informatif.

MODERNIZR
Modernizr se compose de plusieurs modules: il permet le support du HTML5 sur IE, il ajoute des classes sur la balise body en fonction du support des fonctionnalités HTML5 et CSS3 et il créé un objet js global Modernizr contenant le résultat des tests de support des fonctionnalités HTML5 et CSS3.
Par exemple, pour détecter le support de la géolocatisation HTML5, il suffit de faire un test js comme ceci:
	if(Modernizr.geolocation)
Dans la version intégré par défaut sur ce thème, le seul module intégré est HTML5 shim (support HTML5 pour IE), la détection des fonctionnalités via l'objet Modernizr (qui ajouteras aussi les classes sur le body) est à configurer selon les besoins via cette page:
	http://www.modernizr.com/download/
Remplacer ensuite le fichier js/modernizr.js par celui créé.
Pour la liste des booléens créés et les autres fonctionnalités de Modernizr, voir la doc
	http://www.modernizr.com/docs/