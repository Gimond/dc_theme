<?php
require_once('inc/init_dc_theme.php');

function dc_scripts_styles() {
	// AJOUT DES SCRIPTS
	// paramètres => ('string:identifiant_unique', 'string:url', 'array:dépendances')
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script('jquery');
	wp_enqueue_script('general', get_template_directory_uri().'/js/general.js', array('jquery'));

	// AJOUT DES STYLES
	//wp_enqueue_style('reset', get_template_directory_uri().'/css/reset.css');
	wp_enqueue_style('style', get_template_directory_uri().'/css/styles.css');
}
add_action('wp_enqueue_scripts', 'dc_scripts_styles');

