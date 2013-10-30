Basé sur Starkers HTML5
http://nathanstaines.com/archive/starkers-html5

### COMPREND ###
* Jquery
* timthumb
* Un reset CSS HTML5
* HTML5 shiv pour le support des balises HTML5 sur les vieilles version d'IE
* konami code (general.js)
* désactivation des console.log pour les utilisateurs non connectés
* une fonction de debug php affichant un var_dump du paramètre dans une balise pre uniquement visible pour les utilisateurs connectés
* une page d'options (voir plus bas)
* feuille de style pour l'éditeur tinymce (css/tinymce.css)
* images à la une activées par défaut

## PAGE D'OPTIONS ##
Une page d'options générales pour le thème.
Activée par défaut avec les options pour modifier :
* favicon
* code google analytics
* mode maintenance => si activé, le site est accessible uniquement aux utilisateurs connectés, la page de maintenance affichée pour les autres se situe à la racine (maintenance.php)
Il est possible d'ajouter d'autres options sur le fichier theme-options.php, tout les types de champs possibles sont en exemple dans le fichier theme-options-sample.php
Pour l'utilisation en front, les données sont récuperables via get_option (fonction native):
	$options = get_option('dc_theme_options');
	echo $options['nom_option'];

## AJOUT DE FICHIER JS/CSS ##
Pour ajouter des fichiers js ou css, merci de le faire dans le fichier functions.php

## MULTILANGUE ##
Le thème est prêt pour l'ajout d'une langue grâce à l'utilisation des fonctions de traductions de wordpress (_e et autres), merci de continuer à utiliser ces fonctions en cas d'ajout de texte en dur.