<?php

namespace Chocolate;

class Gallery {

	protected $images;
	protected $choco;

	public function __construct() {

		$this->choco = \Chocolate\chocoloate_images();
		// Get all comment images.
		$this->images = $this->choco->get_images();
	}

	public function output() {

		// Bail if no images found.
		if ( ! $this->images ) {
			return;
		}
		// Get first 5 images for immediate display.
		$intro_images = $this->choco->intro_images();

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
				$more = count( $this->images ) - 5;
				$x    = 1;
				foreach ( $intro_images as $id => $image ) {
					$span = '';
					if ( 1 === $x && 5 < count( $this->images ) ) {
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
		<p><a class="link" href="#" data-featherlight="#display-gallery">Gallery</a></p>
		<!--End Gallery Link-->
		<?php

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
			<div id="display-gallery">

				<?php
				foreach ( $this->images as $comment_id => $image ) {
					foreach ( $image['src'] as $id => $img ) {
						$related = $img['related'];
						$div     = <<<ITEM
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

}
