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

add_image_size( 'cig-image', 800, 800 );

require_once CIG_PATH . 'inc/class-comment-images.php';

add_action( 'wp_enqueue_scripts', 'cig_scripts' );
function cig_scripts() {
	$ver = filemtime( CIG_PATH . 'assets/js/main.js' );
	$css_ver = filemtime( CIG_PATH . 'assets/css/cig.css' );
	wp_enqueue_script( 'cig-fljs', CIG_URL . 'assets/js/featherlight.min.js', [], '1.7.14', true );
	wp_enqueue_script( 'cig-flgjs', CIG_URL . 'assets/js/featherlight.gallery.min.js', [], '1.7.14', true );
	wp_enqueue_script( 'cig-js', CIG_URL . 'assets/js/main.js', ['jquery', 'cig-fljs'], $ver, true );
	wp_enqueue_script( 'cig-flswipe', '//cdnjs.cloudflare.com/ajax/libs/detect_swipe/2.1.1/jquery.detect_swipe.min.js', [], '2.1.1', true );
	wp_enqueue_style( 'cig-flcss', CIG_URL . 'assets/css/featherlight.min.css', [], '1.7.14' );
	wp_enqueue_style( 'cig-flgcss', CIG_URL . 'assets/css/featherlight.gallery.min.css', [], '1.7.14' );
	wp_enqueue_style( 'cig-style', CIG_URL . 'assets/css/cig.css', [], $css_ver );
}

add_action( 'wpdiscuz_comment_form_before', 'cig_comment_form_gallery', 11 );
function cig_comment_form_gallery() {

	$choco = \Chocolate\chocoloate_images();
	// Get all comment images.
	$images = $choco->get_images();
	// Bail if no images found.
	if ( ! $images ) {
		return;
	}
	// Get
	$intro_images = $choco->first_four();

	global $_wp_additional_image_sizes;

	?>
<!--	Start Intro Gallery Div-->
	<div id="intro-gallery">
		<?php
		$x = 1;
		$span = '';
		foreach( $intro_images as $id => $image ) {
			if ( count( $intro_images ) === $x ) {
				$span = '<span>' . count( $images ) . '</span>';
			}
			$thumb = <<<THMB
<a data-link="gi-{$x}" class="intro" href="#">
	{$image['src']['related'][0]}
</a>

THMB;
			?>
			<div class="intro-image-container">
				<?php
				echo $thumb;
				echo $span;
			?>
			</div>

			<?php

			$x++;
		}
		?>
	</div>
<!--	End Intro Gallery Div-->
<!--Gallery Link-->
	<p><a class="cig-link" href="#cig-gallery" >Gallery</a> </p>
<!--End Gallery Link-->
	<?php

	echo '<div id="main-gallery-container">'; // Start Main Gallery Container
	echo '<div id="main-gallery">';  // Start Main Gallery
	$x = 1;
	foreach( $images as $comment_id => $image ) {

	}
	echo '</div></div>';// End Main Gallery, Main Gallery Container
}


