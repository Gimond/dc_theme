<?php
/**
 * @package WordPress
 * @subpackage Starkers HTML5
 */

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
			<h2><?php the_title(); ?></h2>
			
			<?php the_content(__('<p>Lire la suite &raquo;</p>', 'dc_theme')); ?>
			<?php wp_link_pages(array('before' => __('<p>Pages: ', 'dc_theme'), 'after' => '</p>', 'next_or_number' => 'number')); ?>
			
			<?php edit_post_link(__('Modifier cette page.', 'dc_theme'), '<p>', '</p>'); ?>
			
		</article>
		
		<?php endwhile; endif; ?>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>