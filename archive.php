<?php get_header(); ?>

	<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h2>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h2>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2>Archive for <?php the_time('F, Y'); ?></h2>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2>Archive for <?php the_time('Y'); ?></h2>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h2>Author Archive</h2>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2>Blog Archives</h2>
	<?php } ?>

		<?php if (show_posts_nav()) : ?>
		<nav>
			<ul>
				<li><?php next_posts_link(__('&laquo; Articles plus anciens', 'dc_theme')) ?></li>
				<li><?php previous_posts_link(__('Articles plus récents &raquo;', 'dc_theme')) ?></li>
			</ul>
		</nav>
		<?php endif; ?>

		<?php while (have_posts()) : the_post(); ?>
			
		<article <?php post_class() ?>>
		
			<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<time datetime="<?php the_time('Y-m-d') ?>" pubdate><?php the_time('l, F jS, Y') ?></time>
			
			<?php the_content() ?>
			
			<footer><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link(__('Aucun commentaire &#187;', 'dc_theme'), __('1 Commentaire &#187;', 'dc_theme'), __('% Commentaires &#187;', 'dc_theme')); ?></footer>
		
		</article>

		<?php endwhile; ?>

		<?php if (show_posts_nav()) : ?>
		<nav>
			<ul>
				<li><?php next_posts_link(__('&laquo; Articles plus anciens', 'dc_theme')) ?></li>
				<li><?php previous_posts_link(__('Articles plus récents &raquo;', 'dc_theme')) ?></li>
			</ul>
		</nav>
		<?php endif; ?>

	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf(__("<h2>Il n'y a pas encore d'articles dans la catégorie %s.</h2>", 'dc_theme'), single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			_e("<h2>Il n'existe aucun article correspondant à cette date.</h2>", 'dc_theme');
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf(__("<h2>Il n'y a pas encore d'articles écrit par %s.</h2>", 'dc_theme'), $userdata->display_name);
		} else {
			_e("<h2>Aucun article trouvé.</h2>", 'dc_theme');
		}
		get_search_form();

	endif;
?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>