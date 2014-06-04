<?php
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

// ICONES
// à choper ici => http://melchoyce.github.io/dashicons/
function cpt_icons() {
    ?>
    <style type="text/css" media="screen">
		/* PROJETS */
        #adminmenu .menu-icon-projet div.wp-menu-image:before {
          content: '\f174';
        }
    </style>
	<?php
}
add_action( 'admin_head', 'cpt_icons' );