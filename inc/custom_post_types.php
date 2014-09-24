<?php
// le paramètre "menu_icon" est le nom de l'icône
// Toutes les icônes avec leur noms sont ici => http://melchoyce.github.io/dashicons/
function create_post_type() {
	// PROJETS
	register_post_type( 'projet',
		array(
			'labels' => array(
				'name' => __( 'Projets' ),
				'singular_name' => __( 'Projet' )
			),
		'public' => true,
		'has_archive' => true,
		'hierarchical' => true,
		'menu_icon' => '',
		'supports' => array('title','editor','thumbnail', 'comments')
		)
	);
	register_taxonomy(
		'categorie',
		'projet',
		array(
			'label' => __("Catégorie"),
			'rewrite' => array( 'slug' => 'categorie' ),
			'hierarchical' => true,
		)
	);
}
add_action( 'init', 'create_post_type' );