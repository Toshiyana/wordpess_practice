<?php

/**
 * yanapu functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package yanapu
 */

add_shortcode('date', function() {
	return date('Y年 n月 j日 H:i:s');
});

add_shortcode('sum', function($atts) {
	//引数を与えなかった時のためのデフォルト値
	$atts = shortcode_atts([
		'x' => 0,
		'y' => 0
	], $atts, 'sum');

	return $atts['x'] + $atts['y'];
});

 // 「投稿」というメニューの名前を「技術メモ」に変更
 function Change_menulabel() {
	global $menu;
	global $submenu;
	$name = '技術メモ';
	$menu[5][0] = $name;
	$submenu['edit.php'][5][0] = $name.'一覧';
}
add_action( 'admin_menu', 'Change_menulabel' );

function Change_objectlabel() {
	global $wp_post_types;
	$name = '技術メモ';
	$labels = &$wp_post_types['post']->labels;
	$labels->name = $name;
	$labels->singular_name = $name;
	$labels->search_items = $name.'を検索';
	$labels->not_found = $name.'が見つかりませんでした';
	$labels->not_found_in_trash = 'ゴミ箱に'.$name.'は見つかりませんでした';
}
add_action( 'admin_menu', 'Change_objectlabel' );


 // カスタム投稿ページ（日記）の追加
add_action('init', function () {
	register_post_type('diary', [
		'label' => '日記',
		'public' => true,
		'menu_position' => 5, //サイドバーにおける位置
		'menu_icon' => 'dashicons-book-alt', //icon画像
		'supports' => ['thumbnail', 'title', 'editor', 'custom-fields'], //アイキャッチ画像の追加設定
		'has_archive' => true, //カスタム投稿ページで一覧リストの表示設定
		'show_in_rest' => true,
	]);
	register_taxonomy('category_diary', 'diary', [
		'label' => 'カテゴリー',
		'hierarchical' => true, //階層構造にするときはtrue（カテゴリー）
		'show_in_rest' => true,
	]);
	register_taxonomy('tag_diary', 'diary', [
		'label' => 'タグ',
		'hierarchical' => false, //並列にするにはfalse(タグ)
		'show_in_rest' => true,
	]);
});

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('yanapu_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function yanapu_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on yanapu, use a find and replace
		 * to change 'yanapu' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('yanapu', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'yanapu'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'yanapu_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'yanapu_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function yanapu_content_width()
{
	$GLOBALS['content_width'] = apply_filters('yanapu_content_width', 640);
}
add_action('after_setup_theme', 'yanapu_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function yanapu_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'yanapu'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'yanapu'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'yanapu_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function yanapu_scripts()
{
	wp_enqueue_style('yanapu-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('yanapu-style', 'rtl', 'replace');

	wp_enqueue_script('yanapu-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'yanapu_scripts');

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
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}
