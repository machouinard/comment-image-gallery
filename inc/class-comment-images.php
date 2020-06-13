<?php
namespace Chocolate;

class Images {

	private $instance = false;

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
			return false;
		}

		$comments = get_comments( [ 'post_id' => $post->ID ] );
		$images = [];
		foreach( $comments as $comment ) {

			$attachments = get_comment_meta( $comment->comment_ID, 'wmu_attachments', true );
			if ( $attachments ) {
				if ( isset( $attachments['images'] ) ) {
					foreach( $attachments['images'] as $attach_id ) {
						$images[ $comment->comment_ID ][] = wp_get_attachment_image( $attach_id );
					}
				}
			}
		}

		return $images;
	}

}

function chocoloate_images() {
	$images = new Images();
	return $images->init();
}
