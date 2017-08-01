<?php
/**
 * Ronde Vormen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ronde_Vormen
 */

if ( ! function_exists( 'rondevormen_wp_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function rondevormen_wp_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Ronde Vormen, use a find and replace
		 * to change 'rondevormen_wp' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'rondevormen_wp', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'rondevormen_wp' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'rondevormen_wp_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'rondevormen_wp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rondevormen_wp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rondevormen_wp_content_width', 640 );
}
add_action( 'after_setup_theme', 'rondevormen_wp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rondevormen_wp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'rondevormen_wp' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'rondevormen_wp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rondevormen_wp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rondevormen_wp_scripts() {
	wp_enqueue_style( 'rondevormen_wp-style', get_stylesheet_uri() );

	wp_enqueue_script( 'rondevormen_wp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'rondevormen_wp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rondevormen_wp_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Projecten CPT
function custom_post_projecten() {
  $labels = array(
    'name'               => _x( 'Projecten', 'post type general name' ),
    'singular_name'      => _x( 'Project', 'post type singular name' ),
    'add_new'            => _x( 'Nieuw project', 'book' ),
    'add_new_item'       => __( 'Nieuw project' ),
    'edit_item'          => __( 'Bewerk project' ),
    'new_item'           => __( 'Nieuwe project' ),
    'all_items'          => __( 'Alle projecten' ),
    'view_item'          => __( 'Bekijk project' ),
    'search_items'       => __( 'Zoek projecten' ),
    'not_found'          => __( 'Geen projecten gevonden' ),
    'not_found_in_trash' => __( 'Geen projecten gevonden in de prullenbak' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Projecten'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Projecten',
    'public'        => true,
    'menu_position' => 5,
    'menu_icon'     => 'dashicons-calendar-alt',
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'projecten', $args ); 
}
add_action( 'init', 'custom_post_projecten' );

// Projecten CPT - Categories
function my_taxonomies_projecten() {
  $labels = array(
    'name'                => _x( 'Categorieën', 'taxonomy general name' ),
    'singular_name'       => _x( 'Categorie', 'taxonomy singular name' ),
    'search_items'        => __( 'Zoek Categorieën' ),
    'all_items'           => __( 'Alle Categorieën' ),
    'parent_item'         => __( 'Bovenliggende Categorie' ),
    'parent_item_colon'   => __( 'Bovenliggende Categorie:' ),
    'edit_item'           => __( 'Bewerk Categorie' ), 
    'update_item'         => __( 'Categorie bijwerken' ),
    'add_new_item'        => __( 'Nieuwe Categorie' ),
    'new_item_name'       => __( 'Nieuwe Categorie' ),
    'not_found'           => __( 'Geen Categorieën gevonden' ),
    'not_found_in_trash'  => __( 'Geen Categorieën gevonden in de prullenbak' ),
    'menu_name'           => __( 'Categorieën' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'project_categorie', 'projecten', $args );
}
add_action( 'init', 'my_taxonomies_projecten', 0 );

// Advanced Custom Fields - Google Maps API
function my_acf_google_map_api( $api ){
  $api['key'] = 'AIzaSyDtzABdiU2xHXI-Oj3BBM_skH8xePE9NVQ';
  return $api;	
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

// Custom WordPress Footer
function remove_footer_admin () {
  echo '<em>Custom WordPress development door <a href="https://ronde-vormen.nl" target="_blank">Ronde Vormen</a></em>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Add a widget in WordPress Dashboard
function wpc_dashboard_widget_function() {
  // Entering the text between the quotes
  echo "<ul>
  <li>Ontwerp & ontwikkeling: <a target=_blank href=https://ronde-vormen.nl>Ronde Vormen</a></li>
  <li>Contactpersoon: Kaz van Kooten</li>
  <li>E-mail: <a href=mailto:kaz@ronde-vormen.nl>kaz@ronde-vormen.nl</a></li>
  <li>Oplevering: 2017</li>
  </ul>";
}
function wpc_add_dashboard_widgets() {
  wp_add_dashboard_widget('wp_dashboard_widget', 'TITLE GOES HERE', 'wpc_dashboard_widget_function');
}
add_action('wp_dashboard_setup', 'wpc_add_dashboard_widgets' );

// Custom templates for each category
add_filter('single_template', 'check_for_category_single_template');
function check_for_category_single_template( $t ) {
  foreach( (array) get_the_category() as $cat ) { 
    
    if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-{$cat->slug}.php"; 
    if($cat->parent) {
      $cat = get_the_category_by_ID( $cat->parent );
      if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-{$cat->slug}.php";
    }
  } 
  return $t;
}

// Register menu
function main_nav() {
  register_nav_menu('main-navigation',__( 'Main navigation' ));
}
add_action( 'init', 'main_nav' );