<?php
// images à la une
add_theme_support( 'post-thumbnails' );

// flux
add_theme_support( 'automatic-feed-links' );

// TRADUCTION
add_action( 'after_setup_theme', 'theme_textdomain_setup' );
function theme_textdomain_setup() {
	load_theme_textdomain('dc_theme', get_template_directory().'/lang');
}

// LIMITE LE JOURNAL DE MODIFICATIONS DE POSTS A 5 VERSIONS
add_filter( 'wp_revisions_to_keep', 'custom_post_revisions', 10, 2 );
function custom_post_revisions( $num, $post ) {
    return 5;
}

// DESACTIVE LES MISES A JOUR AUTOMATIQUES
add_filter( 'auto_update_core', '__return_false' );

// PAGE D'OPTIONS
require_once ( get_template_directory() . '/inc/theme-options.php' );

// TICKETS BUGHERD
function init_bugherd(){
	$options = get_option( 'dc_theme_options' );
	if ($options['bugherd_front'] && $options['cle_bugherd'] != ''){
		?>
		<script type='text/javascript'>
		(function (d, t) {
		  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
		  bh.type = 'text/javascript';
		  bh.src = '//www.bugherd.com/sidebarv2.js?apikey=<?php echo $options['cle_bugherd'] ?>';
		  s.parentNode.insertBefore(bh, s);
		  })(document, 'script');
		</script>
		<?php
	}
}
add_action('wp_head', 'init_bugherd');

function init_bugherd_admin(){
	$options = get_option( 'dc_theme_options' );
	if ($options['bugherd_admin'] && $options['cle_bugherd'] != ''){
		?>
		<script type='text/javascript'>
		(function (d, t) {
		  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
		  bh.type = 'text/javascript';
		  bh.src = '//www.bugherd.com/sidebarv2.js?apikey=<?php echo $options['cle_bugherd'] ?>';
		  s.parentNode.insertBefore(bh, s);
		  })(document, 'script');
		</script>
		<?php
	}
}
add_action('admin_head', 'init_bugherd_admin');

// VARIABLE AJAX JS
function admin_ajax_js(){
	?>
	<script type="text/javascript">
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
	<?php
}
add_action('wp_head', 'admin_ajax_js');

//IS FUTURE IP
function is_future_ip(){
	if ($_SERVER['REMOTE_ADDR'] == "78.243.123.149" || $_SERVER['REMOTE_ADDR'] == "193.248.157.137")
		return true;
	else
		return false;
}
function is_local(){
	if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1")
		return true;
	else
		return false;
}

// VRAI ADMIN
// Cette fonction est testée pour afficher des infos ou activer des outils d'administration, notamment la personnalisation du menu, le mode maintenance, la console js ou encore la fonction php debug()
function is_vrai_admin(){
	return (is_future_ip() || is_local());
}

// DESACTIVE L'EDITION DE FICHIER VIA LE BACK
define('DISALLOW_FILE_EDIT', true);

// PAGE ATTENTE
// Pour passer outre la page de maintenance, il faut remplir une des conditions suivante :
// - être un "vrai admin" (voir la fonction ci-dessus)
// - être connecté
// - avoir une session "preview". Cette session est initialisée en visitant l'url du site suivie de ?preview=1
function load_page_wait() {
	$options = get_option('dc_theme_options');
	$isLoginPage = strpos($_SERVER['REQUEST_URI'], "wp-login.php") !== false;
	$adminPage = strpos($_SERVER['REQUEST_URI'], "wp-admin") !== false;
	if($options['maintenance'] && !is_user_logged_in() && !$isLoginPage && !$adminPage && !is_vrai_admin() && !isset($_SESSION['preview'])) {
		if (isset($_GET['preview'])){
			session_start();
			$_SESSION['preview'] = true;
			header("location:".home_url());
		}
		require(TEMPLATEPATH.'/maintenance.php');
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

// désactive les notif de mises à jour
add_action('admin_menu','wphidenag');
function wphidenag() {
	if (!is_vrai_admin())
		remove_action( 'admin_notices', 'update_nag', 3 );
}

// messages d'avertissement admin
add_action( 'admin_notices', 'my_admin_notice' );
function my_admin_notice(){
	$message = "";

	// moteurs de recherche bloqués
   	$blog_public = get_option('blog_public');
   	if ($blog_public == 0)
   		echo '<div class="error"><p><a href="'.admin_url('options-reading.php').'">Attention, les moteurs de recherche sont bloqués !</a></p></div>';

	// plugin SEO
   	if (!is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php') && !is_plugin_active('wordpress-seo/wp-seo.php'))
   		echo '<div class="error"><p><a href="'.admin_url('plugin-install.php?tab=favorites&user=dr-factory').'">Attention, aucun plugin de référencement n\'est installé !</a></p></div>';

   	// analytics
   	$options = get_option('dc_theme_options');
   	if ($options['analytics'] == "")
   		echo '<div class="error"><p><a href="'.admin_url('admin.php?page=theme_options').'">Attention, Google Analytics n\'est pas configuré !</a></p></div>';
}

// desactive la console pour les non future
if (!is_vrai_admin()){
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

// On vire les metabox inutiles sur le tableau de bord (admin)
function wptutsplus_remove_dashboard_widgets() {
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
    // remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'wptutsplus_remove_dashboard_widgets' );
remove_action('welcome_panel', 'wp_welcome_panel');

/* SUPPRIMER BARRE ADMIN */
// function my_function_admin_bar(){
//     return false;
// }
// add_filter('show_admin_bar' ,'my_function_admin_bar');

/* PERSONNALISATION DU MENU ADMIN */
// bouton sur la barre pour switcher entre les menus
function custom_bouton_menu($wp_admin_bar){
	global $current_user;
	get_currentuserinfo();
	$preview_menu = get_user_meta($current_user->ID, 'preview_menu', true);
	if ($preview_menu){
		$args = array(
			'id' => 'voir-menu-autres',
			'title' => 'Voir le menu d\'admin comme un vrai admin',
			'href' => admin_url('?preview_menu=0')
		);
	}
	else{
		$args = array(
			'id' => 'voir-menu-autres',
			'title' => 'Voir le menu d\'admin comme la populace',
			'href' => admin_url('?preview_menu=1')
		);
	}

	$wp_admin_bar->add_node($args);
}
if (is_vrai_admin())
	add_action('admin_bar_menu', 'custom_bouton_menu', 50);

// planquage des menus
function menu_admin_dc_theme(){
	$options = get_option( 'dc_theme_options' );
	if ($options['cache_menu']){

		global $current_user;
		get_currentuserinfo();
		if (isset($_GET['preview_menu'])){
			update_user_meta($current_user->ID, 'preview_menu', $_GET['preview_menu']);
		}
		$preview_menu = get_user_meta($current_user->ID, 'preview_menu', true);

		if (!is_vrai_admin() || $preview_menu){
			foreach ($options['cache_menu'] as $menu_slug) {
				remove_menu_page($menu_slug);
			}
			remove_menu_page('theme_options');
		}
	}
}
add_action('admin_menu', 'menu_admin_dc_theme', 999);


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

// Feuille de style éditeur tinymce
add_editor_style('css/tinymce.css');