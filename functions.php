<?php
// images à la une
add_theme_support( 'post-thumbnails' );

// flux
add_theme_support( 'automatic-feed-links' );

function dc_scripts_styles() {
	// AJOUT DES SCRIPTS
	// paramètres => ('string:identifiant_unique', 'string:url', 'array:dépendances')
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script('jquery');
	wp_enqueue_script('general', get_template_directory_uri().'/js/general.js', array('jquery'));

	// AJOUT DES STYLES
	wp_enqueue_style('reset', get_template_directory_uri().'/css/reset.css');
	wp_enqueue_style('style', get_template_directory_uri().'/css/style.css', array('reset'));
}
add_action('wp_enqueue_scripts', 'dc_scripts_styles');

// PAGE D'OPTIONS
require_once ( get_template_directory() . '/theme-options.php' );

// PAGE ATTENTE
function load_page_wait() {
	$options = get_option('dc_theme_options');
	$isLoginPage = strpos($_SERVER['REQUEST_URI'], "wp-login.php") !== false;
	$adminPage = strpos($_SERVER['REQUEST_URI'], "wp-admin") !== false;
	if($options['maintenance'] && !is_user_logged_in() && !$isLoginPage && !$adminPage) {
		include('maintenance.php');
		exit();
	}
}
add_action('init','load_page_wait');

// FAVICON
function dc_favicon() {
	$options = get_option('dc_theme_options');
	if ($options['favicon'] != ""){
		echo '<link rel="shortcut icon" href="'.$options['favicon'].'" type="image/vnd.microsoft.icon"/>';
		echo '<link rel="icon" href="'.$options['favicon'].'" type="image/x-ico"/>';
	}
}
add_action('wp_head', 'dc_favicon');

// GOOGLE ANALYTICS
function add_google_analytics() {
	$options = get_option('dc_theme_options');
	if ($options['analytics'] != "")
		echo $options['analytics'];
}
add_action('wp_footer', 'add_google_analytics');

// DEBUG
function debug($var){
	if (is_user_logged_in()){
		global $current_user;
		if ($current_user->ID == 1){
			echo "<pre style='position:relative;z-index:300;color:red'>";
			var_dump($var);
			echo "</pre>";
		}
	}
}

// messages d'avertissement admin
add_action( 'admin_notices', 'my_admin_notice' );
function my_admin_notice(){
	$message = "";

	// moteurs de recherche bloqués
   	$blog_public = get_option('blog_public');
   	if ($blog_public == 0)
   		$message.= "les moteurs de recherche sont bloqués, ";

	// plugin SEO
   	if (!is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php') && !is_plugin_active('wordpress-seo/wp-seo.php'))
   		$message.= "aucun plugin de référencement n'est installé, ";

   	if ($message != "")
    echo '<div class="error"><p>Attention, '.substr($message, 0, -2).' !</p></div>';
}

// desactive la console pour les non connectés
if (!is_user_logged_in()){
	add_action("wp_head", "desactive_console");
	function desactive_console(){
		?>
		<script type="text/javascript">
			var console = {
				log: function(){}
			}
		</script>
		<?php
	}
}

// affichage des widgets
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h1 class="widgettitle">',
		'after_title' => '</h1>',
	));
}

/* SUPPRIMER BARRE ADMIN */
function my_function_admin_bar(){
    return false;
}
add_filter('show_admin_bar' ,'my_function_admin_bar');

// détection du nombre de pages pour afficher ou non la navigation
// renvoie true si plus de 1 page
function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}

// Affichage des commentaires
function html5_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

      <header class="comment-author vcard">
         <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>

         <?php printf(__('<cite class="fn">%s</cite> <span class="says">dit:</span>', 'dc_theme'), get_comment_author_link()) ?>

      </header>

      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Votre commentaire est en attente de validation.', 'dc_theme') ?></em>
      <?php endif; ?>

      <div class="comment-meta commentmetadata"><time datetime="<?php the_time('Y-m-d') ?>" pubdate><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s à %2$s', 'dc_theme'), get_comment_date(),  get_comment_time('G\hi')) ?></a></time><?php edit_comment_link(__('(Modifier)', 'dc_theme'),'  ','') ?></div>

      <?php comment_text() ?>

      <div class="reply"> <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?> </div>
<?php
}

// Changes the trailing </li> into a trailing </article>
function close_comment() {?>
	</article>
<?php
}

// on modifie le screenshot.png à l'activation du thème ou à la modification du nom du site
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php") {
	update_screenshot();
}
add_filter ('pre_update_option_blogname','update_screenshot');

function update_screenshot($title = ""){
	if (extension_loaded('gd') && function_exists('gd_info')) {
		$file = get_template_directory_uri().'/screenshot_base.png';
		$image = imagecreatefrompng($file);

		// couleur texte
		$color = "5E4121";
		$rouge = hexdec('0x' . $color{0} . $color{1});
		$vert = hexdec('0x' . $color{2} . $color{3});
		$bleu = hexdec('0x' . $color{4} . $color{5});
		$couleur = imagecolorallocate($image, $rouge, $vert, $bleu);

		// position texte
		$font = 5;
		if ($title == "")
			$title = get_bloginfo('name');
		$font_width = ImageFontWidth($font);
		$text_width = $font_width * strlen($title);
		$position_center = ceil((300 - $text_width) / 2);

		imagestring($image, $font, $position_center, 180, $title, $couleur);

		$theme_dir = get_template_directory_uri();
		$theme_dir = explode('/', $theme_dir);
		$theme_dir = end($theme_dir);
		imagepng($image, '../wp-content/themes/'.$theme_dir.'/screenshot.png', 0);

		return $title;
	}
}

// Feuille de style éditeur tinymce
add_editor_style('css/tinymce.css');

?>