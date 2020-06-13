<?php
/**
 * Plugin Name:     Comment Image Gallery
 * Plugin URI:      https://livinghealthywithchocolate.com
 * Description:     Add image gallery from comment images.
 * Author:          Adriana
 * Author URI:      https://livinghealthywithchocolate.com
 * Text Domain:     comment-image-gallery
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Comment_Image_Gallery
 */

defined( 'ABSPATH' ) || die();

if ( ! defined( 'CIG_URL' ) ) {
	define( 'CIG_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'CIG_PATH' ) ) {
	define( 'CIG_PATH', plugin_dir_path( __FILE__ ) );
}

require_once CIG_PATH . 'inc/class-comment-images.php';

add_action( 'wp_enqueue_scripts', 'cig_scripts' );
function cig_scripts() {
	$ver = filemtime( CIG_PATH . 'assets/js/main.js' );
	wp_enqueue_script( 'cig-fljs', CIG_URL . 'assets/js/featherlight.min.js', [], '1.7.14', true );
	wp_enqueue_script( 'cig-js', CIG_URL . 'assets/js/main.js', ['jquery', 'cig-fljs'], $ver, true );
	wp_enqueue_style( 'cig-flcss', CIG_URL . 'assets/css/featherlight.min.css', [], '1.7.14' );
}

add_action( 'wpdiscuz_comment_form_before', 'cig_comment_form_before', 11 );
function cig_comment_form_before() {

	$images = \Chocolate\chocoloate_images()->get_images();

	echo '<div>';
	foreach( $images as $image ) {
		foreach ( $image as $img ) {
			echo $img;
		}
	}
	echo '</div>';
}
