<?php
/**
 * @package WordPress
 * @subpackage Starkers HTML5
 */
 
?>
	<aside>
		<ul>
		<?php 	/* Widgetized sidebar, if you have the plugin installed. */
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			sidebar par défaut
		<?php endif; ?>
		</ul>
	</aside>