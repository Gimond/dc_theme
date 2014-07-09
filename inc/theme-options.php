<?php
function myactivationfunction($oldname, $oldtheme=false) {
	update_option('dc_theme_options', array(
		'analytics' => '',
		'favicon' => '',
		'maintenance' => '1',
		'bugherd_front' => '0',
		'bugherd_admin' => '0',
		'cle_bugherd' => '',
		'cache_menu' => array()
	));

	// $input['analytics']))
	// 				$input['analytics'] = '';

	// 			// favicon
	// 		    if ($_FILES['favicon']['size'] > 0) {
	// 		        $overrides = array('test_form' => false);
	// 		        $file = wp_handle_upload($_FILES['favicon'], $overrides);
	// 		        $input['favicon'] = $file['url'];
	// 		    }
	// 			else{
	// 				$options = get_option('dc_theme_options');
	// 				$input['favicon'] = $options['favicon'];
	// 			}

	// 			// maintenance
	// 			if (isset( $input['maintenance']))
	// 				$input['maintenance'] = 1;
	// 			else
	// 				$input['maintenance'] = 0;
	// 		}

	// 		if ($input['onglet_dc_options'] == 'bugherd'){
	// 			// bugherd
	// 			if (isset($input['bugherd_front']))
	// 				$input['bugherd_front'] = 1;
	// 			else
	// 				$input['bugherd_front'] = 0;
	// 			if (isset( $input['bugherd_admin']))
	// 				$input['bugherd_admin'] = 1;
	// 			else
	// 				$input['bugherd_admin'] = 0;

	// 			if (!isset( $input['cle_bugherd']))
	// 				$input['cle_bugherd'] = '';
}
add_action("after_switch_theme", "myactivationfunction", 10 ,  2);


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
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' options', 'dc_theme' ) . "</h2>";

		// notice "sauvegardé""
		if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options sauvegardées', 'dc_theme' ); ?></strong></p></div>
		<?php endif;

		// onglets
		$tabs = array( 'general' => 'Général', 'bugherd' => 'Bugherd', 'menu' => 'Menu' );
		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
		if (!isset($current))
			$current = 'general';
		foreach( $tabs as $tab => $name ){
		    $class = ( $tab == $current ) ? ' nav-tab-active' : '';
		    echo "<a class='nav-tab$class' data-onglet='$tab' href='#$tab'>$name</a>";

		}
		echo '</h2>';

		$options = get_option( 'dc_theme_options' );
		?>

		<form class='onglet_dc_options' id='onglet_dc_options_general' method="post" enctype="multipart/form-data" action="options.php">

			<?php settings_fields( 'dc_theme_options_set' ); ?>
			<input type="hidden" name="onglet_dc_options" value="general">

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
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Enregistrer les options', 'dc_theme' ); ?>" />
			</p>
		</form>

		<form class='onglet_dc_options' id='onglet_dc_options_bugherd' method="post" enctype="multipart/form-data" action="options.php">

			<?php settings_fields( 'dc_theme_options_set' ); ?>
			<input type="hidden" name="onglet_dc_options" value="bugherd">

			<table class="form-table">
				<!-- Bugherd -->
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

		<form class='onglet_dc_options' id='onglet_dc_options_menu' method="post" enctype="multipart/form-data" action="options.php">

			<?php settings_fields( 'dc_theme_options_set' ); ?>
			<input type="hidden" name="onglet_dc_options" value="menu">

			<table class="form-table">
				<!-- Menu d'admin -->
				<tr valign="top"><th scope="row"><?php _e( 'Masquer les menu suivants', 'dc_theme' ); ?></th>
					<td>
						<?php
						// menus classiques
						$menus = array(
							"Articles" => "edit.php",
							"Médias" => "upload.php",
							"Pages" => "edit.php?post_type=page",
							"Commentaires" => "edit-comments.php",
							"Apparence" => "themes.php",
							"Extensions" => "plugins.php",
							"Utilisateurs" => "users.php",
							"Outils" => "tools.php",
							"Réglages" => "options-general.php"
						);

						// custom post types
						$args = array(
							'public'   => true,
   							'_builtin' => false
   						);
						$output = 'objects';
						$post_types = get_post_types( $args, $output );
						foreach ($post_types as $post_type) {
							if ($post_type->rewrite['slug'])
								$menus[$post_type->labels->menu_name] = "edit.php?post_type=".$post_type->rewrite['slug'];
						}

						// advanced custom fields
						if (function_exists('get_field'))
							$menus["ACF"] = "edit.php?post_type=acf";

						foreach($menus as $key => $value){
							echo "<input type='checkbox' id='dc_theme_options[cache_menu]' name='dc_theme_options[cache_menu][]'";
							if ($options['cache_menu'] && in_array($value, $options['cache_menu'])) echo " checked='checked'";
							echo " value='".$value."' /> ".$key."<br />";
						}
						?>
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
	debug($input);
	$options = get_option('dc_theme_options');
	if (!$options)
		$options = array();

	if (isset($input['onglet_dc_options'])){
		if ($input['onglet_dc_options'] == 'general'){
			// analytics
			if (!isset($input['analytics']))
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
		}

		if ($input['onglet_dc_options'] == 'bugherd'){
			// bugherd
			if (isset($input['bugherd_front']))
				$input['bugherd_front'] = 1;
			else
				$input['bugherd_front'] = 0;
			if (isset( $input['bugherd_admin']))
				$input['bugherd_admin'] = 1;
			else
				$input['bugherd_admin'] = 0;

			if (!isset( $input['cle_bugherd']))
				$input['cle_bugherd'] = '';
		}

		if ($input['onglet_dc_options'] == 'menu'){
			// echo "hop";
			// $input['bugherd_front'] = 1;
			// die();
		}
	}
	return array_merge($options, $input);
}

// CSS
add_action('admin_head', 'css_dc_theme_options');
function css_dc_theme_options(){
	?>
	<style type="text/css">
		.onglet_dc_options{
			display: none;
		}
		#onglet_dc_options_general{
			display: block;
		}
	</style>

	<script>
		jQuery(document).ready(function($){
			$('.nav-tab').click(function(){
				var onglet = $(this).data('onglet');
				$('.onglet_dc_options').hide();
				$('#onglet_dc_options_'+onglet).show();

				$('.nav-tab').removeClass('nav-tab-active');
				$(this).addClass('nav-tab-active');
			});
		});
	</script>
	<?php
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/