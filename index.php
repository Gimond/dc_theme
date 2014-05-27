<?php get_header(); ?>

<i class='glyphicon glyphicon-bell'></i>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<article <?php post_class() ?>>

		<h3 id="post-<?php the_ID(); ?>">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Lien permanent vers ', 'dc_theme'); ?><?php the_title_attribute(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>
		<time datetime="<?php the_time('Y-m-d') ?>" pubdate><?php the_time('l, F jS, Y') ?></time>

		<?php the_content() ?>

		<footer><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link(__('Aucun commentaire &#187;', 'dc_theme'), __('1 Commentaire &#187;', 'dc_theme'), __('% Commentaires &#187;', 'dc_theme')); ?></footer>

	</article>

<?php endwhile; else: ?>

	<p><?php _e("<h2>Aucun article trouvé.</h2>", 'dc_theme'); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>