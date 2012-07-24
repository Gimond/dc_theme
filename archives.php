<?php
/**
 * @package WordPress
 * @subpackage Starkers HTML5
 */
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<?php get_search_form(); ?>

<h2><?php _e('Archives par mois:', 'dc_theme'); ?></h2>
<ul>
	<?php wp_get_archives('type=monthly'); ?>
</ul>

<h2><?php _e('Archives par catégories:', 'dc_theme'); ?></h2>
<ul>
	 <?php wp_list_categories(); ?>
</ul>

<?php get_sidebar(); ?>

<?php get_footer(); ?>