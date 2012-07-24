<?php
/**
 * @package WordPress
 * @subpackage Starkers HTML5
 */

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php previous_post_link('&laquo; %link') ?> <?php next_post_link('%link &raquo;') ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
			<h2><?php the_title(); ?></h2>
			
			<?php the_content('<p>'.__('Lire la suite &raquo;', 'dc_theme').'</p>'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php the_tags(__('<p>Catégories: ', 'dc_theme'), ', ', '</p>'); ?>
			
			<footer>	
				<?php _e('Cet article a été publié le ', 'dc_theme'); ?>
				<time datetime="<?php the_time('Y-m-d') ?>" pubdate>
					<?php
					the_time('l j F Y');
					_e(' à ', 'dc_theme');
					the_time('G\hi');
					?>
				</time>.<br />
				
				<?php
				// affichage des CATEGORIES
				/*
				_e('Il a été classé dans: ', 'dc_theme');
				the_category(', ');
				print('.<br />');
				*/
				
				
				// Abonnement au FLUX RSS des commentaires
				// _e('Vous pouvez vous abonner aux réponses de cet articles via le flux ', 'dc_theme');
				// post_comments_feed_link('RSS 2.0');
				
				
				// Indique si les COMMENTAIRES ET TRACKBACKS sont ouvets (relativement inutile)
				/*
				if ( comments_open() && pings_open() ) {
					// Both Comments and Pings are open
					printf(__('Vous pouvez %1$slaisser un commentaire%2$s ou %3$sfaire un trackbak%4$s depuis votre site.', 'dc_theme'), '<a href="#respond">', '</a>', '<a href="'.trackback_url().'" rel="trackback">', '</a>');
				} elseif ( !comments_open() && pings_open() ) {
					// Only Pings are Open
					printf(__('Les commentaires sont fermés mais vous pouvez %1$sfaire un trackbak%2$s depuis votre site.', 'dc_theme'), '<a href="'.trackback_url().'" rel="trackback">', '</a>');
				} elseif ( comments_open() && !pings_open() ) {
					// Comments are open, Pings are not
					printf(__('Vous pouvez %1$slaisser un commentaire%2$s. Les trackbacks sont fermés pour le moment.', 'dc_theme'), '<a href="#respond">', '</a>');
				} elseif ( !comments_open() && !pings_open() ) {
					// Neither Comments, nor Pings are open
					_e('Les commentaires et les trackbacks sont fermés pour le moment.', 'dc_theme');
				}
				*/
				edit_post_link(__('Modifier cet article', 'dc_theme'),'','.'); 
				?>
			
			</footer>
			
			<?php comments_template(); ?>
			
		</article>

	<?php endwhile; else: ?>

		<p><?php _e('Aucun article ne correspond à ces critères.', 'dc_theme'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>