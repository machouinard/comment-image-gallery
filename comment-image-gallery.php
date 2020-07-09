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
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'cig-style', CIG_URL . 'assets/css/cig.css', [], $css_ver );
}

//add_action( 'wpdiscuz_comment_form_before', 'cig_comment_form_gallery', 11 );
add_action( 'genesis_after_entry_content', 'cig_comment_form_gallery', 5 );
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

	$comment_ratings = WP_PLUGIN_DIR . '/wp-recipe-maker/templates/public/comment-rating.php';
	if ( ! file_exists( $comment_ratings ) ) {
		$comment_ratings = false;
	}

	echo '<h3 class="related-title">Reader\'s Images</h3>';

	?>
<!--	Start Intro Gallery Div-->
	<div id="intro-gallery" class="related-posts">
		<ul class="related-list">
		<?php
		$x = 1;
		$more = count( $images ) - 5;
		foreach( $intro_images as $id => $image ) {
			$span = '';
			if ( 1 === $x && 5 < count($images) ) {
				$span = '<span>+' . $more . '</span>';
			}
			$x++;
			foreach( $image['src'] as $id => $img ) {
				$thumb = <<<THMB
<li class="intro-image-container">
<a data-link="gi-{$id}" class="intro" href="#">
	{$img['related']}
</a>
{$span}
</li>

THMB;

				echo $thumb;


			}

		}
		?>
	</ul>
	</div>
<!--	End Intro Gallery Div-->
<!--Gallery Link-->
	<p><a class="link" href="#" data-featherlight="#display-gallery">Gallery</a></p>
<!--End Gallery Link-->
	<?php

	echo '<div id="main-gallery-container">'; // Start Main Gallery Container
	echo '<div id="main-gallery">';  // Start Main Gallery
	$x = 1;
	foreach( $images as $comment_id => $image ) {
		foreach( $image['src'] as $id => $img ) {
			$related = $img['related'];
			$display = $img['display'];
			$rating = $image['rating'];
			$stars = '';
			if ( $comment_ratings && "0" != $rating ) {
				ob_start();
				include( $comment_ratings );
				$stars = ob_get_contents();
				ob_clean();
			}
			$div = <<<ITEM
			<div class="gallery-item">
				<a class="main" data-link="gi-{$id}" id="gi-{$id}" href="#mgi-{$id}">
					<div class="thumb-holder">{$related}</div>
				</a>
				<div class="mgi-wrapper">
					<div id="mgi-{$id}" class="mgi">
						<div class="mgi-image">{$display}</div>
						<div class="mgi-text">
							{$stars}
							<p class="cig-author"><a href="#comment-{$comment_id}">{$image['date']}</a> by {$image['author']}</p>
							<p>{$image['comment']}</p>
						</div>
					</div>
				</div>
			</div>
ITEM;

			echo $div;
		}

	}
	echo '</div></div>';// End Main Gallery, Main Gallery Container
	?>
	<div id="display-gallery-container">
		<!--		<div id="main-gallery" data-featherlight-gallery data-featherlight-filter="a.main">-->
		<div id="display-gallery">

			<?php
			foreach( $images as $comment_id => $image ) {
				foreach ( $image['src'] as $id => $img ) {
					$related = $img['related'];
					$div = <<<ITEM
			<div class="gallery-item">
				<a class="intro" data-link="gi-{$id}" id="gi-{$id}" href="#mgi-{$id}">
					<div class="thumb-holder">{$img['related']}</div>
				</a>

			</div>
ITEM;
				}
				echo $div;
			}
			?>

		</div>
	</div>
	<?php
}


