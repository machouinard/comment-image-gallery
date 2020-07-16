<?php

namespace Chocolate;

class Gallery {

	protected $images;
	protected $choco;
	public $count = 5;

	public function __construct() {

		$this->choco = \Chocolate\chocoloate_images();
		// Get all comment images.
		$this->images = $this->choco->get_images();
	}

	public function output( $count = 5 ) {

		$this->count = (int)$count;

		// Bail if no images found.
		if ( ! $this->images ) {
			return;
		}
		// Get first [$this->count] images for immediate display.
		$intro_images = $this->choco->intro_images( $this->count);

		?>
		<!--	Start Intro Gallery Div-->
		<div id="intro-gallery" class="related-posts">
			<h3 class="related-title">Reader's Recipe Photos</h3>
			<ul class="related-list">
				<?php
				$more = count( $this->images ) - $this->count;
				$x    = 1;
				foreach ( $intro_images as $id => $image ) {
					$span = '';
					if ( 1 === $x && $this->count < count( $this->images ) ) {
						$span = '<span>+' . $more . '</span>';
					}
					$x ++;
					foreach ( $image['src'] as $id => $img ) {
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
			<p class="below-gallery-links">
				<a class="add-photo-link" href="#comments" alt="add photo link">Add your photo</a>
			<?php if ( $this->count < count( $this->images ) ): ?>
				<span class="link-sep">|&nbsp;</span>
				<a class="link" href="#" data-featherlight="#display-gallery">See <?php echo (int) count($this->images) - $this->count; ?> more</a>
			<?php endif; ?>
			</p>
			<!--End Gallery Link-->
		<?php

		// Borrow wp-recipe-maker ratings output
		$comment_ratings = WP_PLUGIN_DIR . '/wp-recipe-maker/templates/public/comment-rating.php';
		if ( ! file_exists( $comment_ratings ) ) {
			$comment_ratings = false;
		}

		echo '<div id="main-gallery-container">'; // Start Main Gallery Container
		echo '<div id="main-gallery">';  // Start Main Gallery
		$x = 1;
		foreach ( $this->images as $comment_id => $image ) {
			foreach ( $image['src'] as $id => $img ) {
				$related = $img['related'];
				$display = $img['display'];
				$rating  = $image['rating'];
				$stars   = '';
				if ( $comment_ratings && "0" != $rating ) {
					ob_start();
					include( $comment_ratings );
					$stars = ob_get_clean();
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
							<p class="cig-author">by <a href="#comment-{$comment_id}">{$image['author']}</a> on {$image['date']}</p>
							{$stars}
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
		<!--		"Shadow" gallery - getting featherlightGallery to work inside a featherlight modal was troublesome with the next/prev links --->
		<!--		When these thumbs are clicked we grab the ID from the data-link and trigger a click on the the main featherlightGallery-->
		<!--		Something to do with binding the gallery - next/prev only worked correctly the first time the gallery was called-->
		<div id="display-gallery-container">
			<div id="display-gallery">

				<?php
				foreach ( $this->images as $comment_id => $image ) {
					foreach ( $image['src'] as $id => $img ) {
						$related = $img['related'];
						$div     = <<<ITEM
			<div class="gallery-item">
				<a class="intro" data-link="gi-{$id}" href="#mgi-{$id}">
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

	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public static function enqueue() {

		// Only enqueue on single posts
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		$ver     = filemtime( CIG_PATH . 'assets/js/main.js' );
		$css_ver = filemtime( CIG_PATH . 'assets/css/cig.css' );
		wp_enqueue_script( 'cig-fljs',
			CIG_URL . 'assets/js/featherlight.min.js',
			[],
			'1.7.14',
			true );
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

}
