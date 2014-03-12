<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'dc_theme_options_set', 'dc_theme_options', 'dc_theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_menu_page( __( 'Options', 'dc_theme' ), __( 'Options', 'dc_theme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' options', 'dc_theme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options sauvegardées', 'dc_theme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" enctype="multipart/form-data" action="options.php">
			<?php settings_fields( 'dc_theme_options_set' ); ?>
			<?php $options = get_option( 'dc_theme_options' ); ?>

			<table class="form-table">

				<!-- Favicon -->
				<tr valign="top"><th scope="row"><?php _e( 'Favicon', 'dc_theme' ); ?></th>
					<td>
						<input id="favicon" name="favicon" type="file" />
						<label class="description" for="favicon"><img height='16' src='<?php echo $options['favicon'] ?>' /> (.ico de préférence)</label>
					</td>
				</tr>

				<!-- Google Analytics -->
				<tr valign="top"><th scope="row"><?php _e( 'Code google analytics', 'dc_theme' ); ?></th>
					<td>
						<textarea id="dc_theme_options[analytics]" class="large-text" cols="50" rows="10" name="dc_theme_options[analytics]"><?php echo esc_textarea($options['analytics']); ?></textarea>
					</td>
				</tr>

				<!-- Maintenance -->
				<tr valign="top"><th scope="row"><?php _e( 'Site en maintenance', 'dc_theme' ); ?></th>
					<td>
						<input type='checkbox' id="dc_theme_options[maintenance]" name="dc_theme_options[maintenance]" <?php if ($options['maintenance']) echo "checked='checked'"; ?> />
					</td>
				</tr>

				<!-- Bugherd -->
				<tr valign="top"><th colspan='2' scope="row"><h3><?php _e( 'Bugherd', 'dc_theme' ); ?></h3></th></tr>
				<tr valign="top"><th scope="row"><?php _e( 'Activer Bugherd sur le front', 'dc_theme' ); ?></th>
					<td>
						<input type='checkbox' id="dc_theme_options[bugherd_front]" name="dc_theme_options[bugherd_front]" <?php if ($options['bugherd_front']) echo "checked='checked'"; ?> />
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Activer Bugherd sur le back', 'dc_theme' ); ?></th>
					<td>
						<input type='checkbox' id="dc_theme_options[bugherd_admin]" name="dc_theme_options[bugherd_admin]" <?php if ($options['bugherd_admin']) echo "checked='checked'"; ?> />
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Clé Bugherd', 'dc_theme' ); ?></th>
					<td>
						<input style='width:300px;' type='text' id="dc_theme_options[cle_bugherd]" name="dc_theme_options[cle_bugherd]" value="<?php if ($options['cle_bugherd']) echo $options['cle_bugherd']; ?>" />
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Enregistrer les options', 'dc_theme' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function dc_theme_options_validate($input){

	// analytics
	if (!isset( $input['analytics']))
		$input['analytics'] = '';

	// favicon
    if ($_FILES['favicon']['size'] > 0) {
        $overrides = array('test_form' => false);
        $file = wp_handle_upload($_FILES['favicon'], $overrides);
        $input['favicon'] = $file['url'];
    }
	else{
		$options = get_option('dc_theme_options');
		$input['favicon'] = $options['favicon'];
	}

	// maintenance
	if (isset( $input['maintenance']))
		$input['maintenance'] = 1;
	else
		$input['maintenance'] = 0;

	// bugherd
	if (isset( $input['bugherd_front']))
		$input['bugherd_front'] = 1;
	else
		$input['bugherd_front'] = 0;
	if (isset( $input['bugherd_admin']))
		$input['bugherd_admin'] = 1;
	else
		$input['bugherd_admin'] = 0;
	if (!isset( $input['cle_bugherd']))
		$input['cle_bugherd'] = '';

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/