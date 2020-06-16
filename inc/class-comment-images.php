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

	public function get_images( ) {
		global $post;

		if ( ! $post || ! is_singular( 'post' ) || 'post' !== $post->post_type ) {
			return [];
		}

		$comments = get_comments( [ 'post_id' => $post->ID ] );
		$images = [];
		foreach( $comments as $comment ) {

			$attachments = get_comment_meta( $comment->comment_ID, 'wmu_attachments', true );
			if ( $attachments ) {
				if ( isset( $attachments['images'] ) ) {
					$date = date( 'M j, Y', strtotime( $comment->comment_date ) );
					$images[ $comment->comment_ID ]['comment'] = $comment->comment_content;
					$images[ $comment->comment_ID ]['author'] = $comment->comment_author;
					$images[ $comment->comment_ID ]['date'] = $date;
					foreach( $attachments['images'] as $attach_id ) {
						$images[ $comment->comment_ID ]['src'][] = wp_get_attachment_image( $attach_id );
					}
				}
			}
		}

		$this->images = $images;

		return empty( $this->images ) ? false : true;
	}

	public function first_four() {

		return array_slice( $this->images, 0, 4, true );
	}

}

function chocoloate_images() {
	$images = new Images();
	return $images->init();
}
