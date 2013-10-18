<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
		_e('Merci de ne pas charger cette page directement.', 'dc_theme');
		die();
	}

	if ( post_password_required() ) { ?>
		<p class="alert"><?php _e('Cet article est protégé par un mot de passe. Merci de rentrer le mot de passe pour voir les commentaires.', 'dc_theme'); ?></p>
	<?php
		return;
	}
?>

	<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments">
	<?php 
	comments_number(__('Aucun commentaire', 'dc_theme'), __('Un commentaire', 'dc_theme'), __('% commentaires', 'dc_theme') );
	print(' ');
	_e('pour', 'dc_theme');
	?> &#8220;<?php the_title(); ?>&#8221;</h3>

	<?php previous_comments_link() ?> <?php next_comments_link() ?>

	<!-- View functions.php for comment markup -->
	<?php wp_list_comments('callback=html5_comment&end-callback=close_comment'); ?>

	<?php previous_comments_link() ?> <?php next_comments_link() ?>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Les commentaires sont fermés.', 'dc_theme'); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

	<h3 id="respond"><?php comment_form_title(__('Écrire un commentaire', 'dc_theme'), __('Répondre à %s', 'dc_theme')); ?></h3>

	<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p>
	<?php
	printf(__('Vous devez être connecté pour %1$sécrire%2$s un commentaire.', 'dc_theme'), '<a href="'.wp_login_url(get_permalink()).'">', '</a>');
	?>
	</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>

		<p><?php _e('Connecté en tant que', 'dc_theme'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Déconnexion', 'dc_theme') ?>"><?php _e('Déconnexion', 'dc_theme') ?> &raquo;</a></p>

		<?php else : ?>

		<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" <?php if ($req) _e("required", 'dc_theme'); ?> />
		<label for="author"><?php _e('Nom', 'dc_theme'); ?> <?php if ($req) echo "(required)"; ?></label></p>

		<p><input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" <?php if ($req) echo "required"; ?> />
		<label for="email"><?php _e('Mail (ne sera pas publié)', 'dc_theme'); ?> <?php if ($req) _e("(required)", 'dc_theme'); ?></label></p>

		<p><input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" />
		<label for="url"><?php _e('Site web', 'dc_theme'); ?></label></p>

		<?php endif; ?>

		<!--<p><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></p>-->

		<textarea name="comment" id="comment" cols="100%" rows="10" required></textarea>

		<button type="submit" name="submit" id="send"><?php _e('Poster le commentaire', 'dc_theme') ?></button>
		
		<?php comment_id_fields(); ?>
		
		<?php do_action('comment_form', $post->ID); ?>

	</form>

	<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>