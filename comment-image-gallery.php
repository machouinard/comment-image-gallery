<?php
/**
 * Plugin Name:     Comment Image Gallery
 * Plugin URI:      /desserts/paleo-chocolate-cake-grain-gluten-dairy-free-3341/
 * Description:     Display comment images in gallery
 * Author:          Adriana
 * Author URI:      https://livinghealthywithchocolate.com
 * Text Domain:     comment-image-gallery
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Comment_Image_Gallery
 *
 */

defined( 'ABSPATH' ) || die();

if ( ! defined( 'CIG_URL' ) ) {
	define( 'CIG_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'CIG_PATH' ) ) {
	define( 'CIG_PATH', plugin_dir_path( __FILE__ ) );
}

add_image_size( 'cig-image', 500, 500 );

require_once CIG_PATH . 'inc/class-gallery.php';
require_once CIG_PATH . 'inc/class-comment-images.php';

add_action( 'wp_enqueue_scripts', 'cig_scripts' );
function cig_scripts() {

	$ver     = filemtime( CIG_PATH . 'assets/js/main.js' );
	$css_ver = filemtime( CIG_PATH . 'assets/css/cig.css' );
	wp_enqueue_script( 'cig-fljs', CIG_URL . 'assets/js/featherlight.min.js', [], '1.7.14', true );
	wp_enqueue_script( 'cig-flgjs',
		CIG_URL . 'assets/js/featherlight.gallery.min.js',
		[],
		'1.7.14',
		true );
	wp_enqueue_script( 'cig-js',
		CIG_URL . 'assets/js/main.js',
		[ 'jquery', 'cig-fljs' ],
		$ver,
		true );
	wp_enqueue_script( 'cig-flswipe',
		'//cdnjs.cloudflare.com/ajax/libs/detect_swipe/2.1.1/jquery.detect_swipe.min.js',
		[],
		'2.1.1',
		true );
	wp_enqueue_style( 'cig-flcss', CIG_URL . 'assets/css/featherlight.min.css', [], '1.7.14' );
	wp_enqueue_style( 'cig-flgcss',
		CIG_URL . 'assets/css/featherlight.gallery.min.css',
		[],
		'1.7.14' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'cig-style', CIG_URL . 'assets/css/cig.css', [], $css_ver );
}

// Output image gallery markup after recipe, before related recipes
add_action( 'genesis_after_entry_content', 'cig_comment_form_gallery', 5 );
function cig_comment_form_gallery() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	$gallery = new Chocolate\Gallery();
	$gallery->output();
}

// Clear transients when new comments are added
add_action( 'wp_insert_comment', 'cig_clear_transients', 20, 2 );
function cig_clear_transients( $id, $comment ) {
	global $wpdb;
	$sql = "SELECT `comment_post_ID` from {$wpdb->comments} WHERE `comment_ID` = %d";
	$post_id = $wpdb->get_var( $wpdb->prepare( $sql, $id ) );
	delete_transient( 'cig-' . $post_id );
}

