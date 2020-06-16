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
	$css_ver = filemtime( CIG_PATH . 'assets/css/cig.css' );
	wp_enqueue_script( 'cig-fljs', CIG_URL . 'assets/js/featherlight.min.js', [], '1.7.14', true );
	wp_enqueue_script( 'cig-flgjs', CIG_URL . 'assets/js/featherlight.gallery.min.js', [], '1.7.14', true );
	wp_enqueue_script( 'cig-js', CIG_URL . 'assets/js/main.js', ['jquery', 'cig-fljs'], $ver, true );
	wp_enqueue_style( 'cig-flcss', CIG_URL . 'assets/css/featherlight.min.css', [], '1.7.14' );
	wp_enqueue_style( 'cig-flgcss', CIG_URL . 'assets/css/featherlight.gallery.min.css', [], '1.7.14' );
	wp_enqueue_style( 'cig-style', CIG_URL . 'assets/css/cig.css', [], $css_ver );
}

add_action( 'wpdiscuz_comment_form_before', 'cig_comment_form_gallery', 11 );
function cig_comment_form_gallery() {

	$choco = \Chocolate\chocoloate_images();

	$images = $choco->get_images();

	if ( ! $images ) {
		return;
	}

	$first_four = $choco->first_four();

	global $_wp_additional_image_sizes;

	echo '<div id="cig-gallery">';
	foreach( $images as $comment_id => $image ) {
		?>
		<div class="cig-image">
		<?php
		foreach ( $image['src'] as $img ) {
			echo '<a href="#cig-' . intval( $comment_id ) . '" data-featherlight>' . $img['square'][0] . '</a>';
			?>
			<div class="cig-modal" id="cig-<?php echo intval( $comment_id ); ?>">
				<div class="cig-modal-int" data-featherlight-gallery>
					<div class="cig-modal-image"><?php echo $img['orig'][0]; ?></div>
					<div class="cig-modal-comment">
						<p>By <?php echo $image['author']; ?> on <?php echo $image['date']; ?></p>
						<?php echo $image['comment']; ?>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		</div>
		<?php
	}
	echo '</div>';
}
