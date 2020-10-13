<?php

namespace Chocolate;

class Images {

	private $instance = false;
	private $images = [];

	public function __construct() {
		// Empty
	}

	public function init() {

		if ( ! $this->instance ) {
			$this->instance = new Images();
		}

		return $this->instance;
	}

	/**
	 * Return comment images
	 *
	 * Uses Transients API
	 *
	 * @return array|bool
	 * @since 1.0.0
	 *
	 */
	public function get_images() {

		global $post;

		if ( ! $post ) {
			return [];
		}



		// If transient not found, go dig up all the comment images.
		if ( ! $this->images = get_transient( 'cig-' . $post->ID ) ) {

			$comments = get_comments( [ 'post_id' => $post->ID ] );
			$images   = [];

			if ( empty( $comments ) ) {
				set_transient( 'cig-' . $post->ID, $images );

				return false;
			}

			foreach ( $comments as $comment ) {

				// Exclude images in responses by Adriana TODO: confirm with Adriana
				if ( 'Adriana' == $comment->comment_author ) {
					continue;
				}

				$rating      = get_comment_meta( $comment->comment_ID,
					'wprm-comment-rating',
					true );
				$attachments = get_comment_meta( $comment->comment_ID, 'wmu_attachments', true );

				if ( $attachments ) {
					if ( isset( $attachments['images'] ) ) {
						$date = date( 'M j, Y', strtotime( $comment->comment_date ) );

						$images[ $comment->comment_ID ]['comment'] = $comment->comment_content;
						$images[ $comment->comment_ID ]['author']  = $comment->comment_author;
						$images[ $comment->comment_ID ]['date']    = $date;
						$images[ $comment->comment_ID ]['rating']  = $rating;
						foreach ( $attachments['images'] as $attach_id ) {
							$images[ $comment->comment_ID ]['src'][ $attach_id ]['related'] = wp_get_attachment_image( $attach_id,
								'related' );
							$images[ $comment->comment_ID ]['src'][ $attach_id ]['display'] = wp_get_attachment_image( $attach_id,
								'cig-image' );
						}
					}
				}
			}

			$this->images = $images;

			// Save image array as transient.  No expiration since this key is deleted when new comments are added.
			set_transient( 'cig-' . $post->ID, $images );
		}

		return empty( $this->images ) ? false : $this->images;
	}

	/**
	 * Return up to first (5) images
	 *
	 * @param int $num
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	public function intro_images( $count ) {

		return array_slice( $this->images, 0, (int) $count, true );
	}

}

/**
 * Expose namespaced class and its methods
 *
 * @return Images
 * @since 1.0.0
 *
 */
function chocoloate_images() {

	$images = new Images();

	return $images->init();
}
