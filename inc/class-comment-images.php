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
	 * @return array|bool
	 * @since 1.0.0
	 *
	 */
	public function get_images() {

		global $post;

		if ( ! $post || ! is_singular( 'post' ) || 'post' !== $post->post_type ) {
			return [];
		}

		$comments = get_comments( [ 'post_id' => $post->ID ] );
		$images   = [];
		foreach ( $comments as $comment ) {
			if ( 'Adriana' == $comment->comment_author ) {
				continue;
			}

			$rating      = get_comment_meta( $comment->comment_ID, 'wprm-comment-rating', true );
			$attachments = get_comment_meta( $comment->comment_ID, 'wmu_attachments', true );
			if ( $attachments ) {
				if ( isset( $attachments['images'] ) ) {
					$date                                      = date( 'M j, Y',
						strtotime( $comment->comment_date ) );
					$images[ $comment->comment_ID ]['comment'] = $comment->comment_content;
					$images[ $comment->comment_ID ]['author']  = $comment->comment_author;
					$images[ $comment->comment_ID ]['date']    = $date;
					$images[ $comment->comment_ID ]['rating']  = $rating;
					foreach ( $attachments['images'] as $attach_id ) {
						//						$images[ $comment->comment_ID ]['src'][$attach_id]['orig'][] = wp_get_attachment_image_src( $attach_id, 'cig-image' );
						//						$images[ $comment->comment_ID ]['src'][$attach_id]['square'][] = wp_get_attachment_image_src( $attach_id, 'related' );
						$images[ $comment->comment_ID ]['src'][ $attach_id ]['related'] = wp_get_attachment_image( $attach_id,
							[ 150, 150 ] );
						$images[ $comment->comment_ID ]['src'][ $attach_id ]['display'] = wp_get_attachment_image( $attach_id,
							'cig-image' );
					}
				}
			}
		}

		$this->images = $images;

		return empty( $this->images ) ? false : $this->images;
	}

	/**
	 * Return first 5 images
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	public function intro_images() {

		return array_slice( $this->images, 0, 5, true );
	}

}

function chocoloate_images() {

	$images = new Images();

	return $images->init();
}
