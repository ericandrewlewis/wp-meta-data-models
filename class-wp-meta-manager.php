<?php

final class WP_Meta_Manager {
	/**
	 * Registered meta of the post meta type (including pages and CPTs).
	 */
	public $post = array(
		'all' => array()
	);

	function __construct() {
		$post_types_without_meta = array( 'revision', 'nav_menu_item' );
		foreach ( get_post_types( null, 'names' ) as $post_type ) {
			if ( in_array( $post_type, $post_types_without_meta ) ) {
				continue;
			}
			$this->post[$post_type] = array();
		}
	}

	public function register( $meta_object ) {
		if ( ! property_exists( $this, $meta_object->content_type ) ) {
			echo 'That content type does not exist';
		}
		if ( $meta_object->content_subtype ) {
			$this->{$meta_object->content_type}[$meta_object->content_subtype][] = $meta_object;
		} else {
			$this->{$meta_object->content_type}['all'][] = $meta_object;
		}
	}

	public function get_registered_meta( $args ) {
		if ( $args['content_subtype']) {
			return $this->{$args['content_type']}[$args['content_subtype']];
		} else {
			return $this->{$args['content_type']}['all'];
		}
	}
}
