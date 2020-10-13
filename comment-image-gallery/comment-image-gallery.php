<?php
/**
 * Plugin Name:     Comment Image Gallery
 * Plugin URI:      https://livinghealthywithchocolate.com/
 * Description:     Display comment images in gallery
 * Author:          Adriana Harlan
 * Author URI:      https://livinghealthywithchocolate.com/
 * Text Domain:     comment-image-gallery
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Comment_Image_Gallery
 *
 */

defined( 'ABSPATH' ) || die();
define( 'CIG_URL', plugin_dir_url( __FILE__ ) );
define( 'CIG_PATH', plugin_dir_path( __FILE__ ) );

add_image_size( 'cig-image', 500, 500 );

require_once CIG_PATH . 'inc/class-plugin-settings.php';
require_once CIG_PATH . 'inc/class-gallery.php';
require_once CIG_PATH . 'inc/class-comment-images.php';

// Enqueue scripts
add_action( 'wp_enqueue_scripts', 'Chocolate\Gallery::enqueue' );

// Output image gallery markup after recipe, before related recipes
add_action( 'genesis_after_entry_content', 'cig_comment_form_gallery', 5 );
function cig_comment_form_gallery() {

	if ( ! is_singular( 'post' ) ) {
		return;
	}
	// Instantiate new Gallery
	$gallery  = new Chocolate\Gallery();
	$settings = get_option( 'comment_img_settings' );
	// Output (#) images
	$gallery->output( $settings['comment_num_images'] );
}

// Clear transients when new comments are added
add_action( 'wp_insert_comment', 'cig_clear_transients', 20, 2 );
function cig_clear_transients( $id, $comment ) {

	global $wpdb;
	$sql     = "SELECT `comment_post_ID` from {$wpdb->comments} WHERE `comment_ID` = %d";
	$post_id = $wpdb->get_var( $wpdb->prepare( $sql, $id ) );
	delete_transient( 'cig-' . $post_id );
}

register_activation_hook( __FILE__, 'cig_activation' );
function cig_activation() {

	$defaults = [ 'comment_num_images' => 5, 'image_cache_time' => 12 ];
	update_option( 'comment_img_settings', $defaults );
}

add_filter( 'http_request_args', 'cig_prevent_update', 5, 2 );
/**
 * Exclude this plugin from WordPress repo update checks
 *
 * Just in case a plugin with the same name gets added to the repo
 *
 * @param array  $r   Array of HTTP request arguments (array of plugins to check for updates)
 * @param string $url Request URL
 *
 * @return mixed
 * @since 1.0.0
 *
 */
function cig_prevent_update( $r, $url ) {

	if ( 0 !== strpos( $url, 'https://api.wordpress.org/plugins/update-check/1.1/' ) ) {
		return $r; // Request not for plugin updates, keep things moving along.
	}

	$a = plugin_basename( CIG_PATH . 'comment-image-gallery.php' );

	// Decode args into array of plugins
	$plugins = json_decode( $r['body']['plugins'], true );
	// Remove our plugin from array
	unset( $plugins['plugins'][ plugin_basename( CIG_PATH . '/comment-image-gallery.php' ) ] );
	// Return things the way we found them, except for our plugin
	$r['body']['plugins'] = json_encode( $plugins );

	return $r;
}
