<?php
/**
 * A registry for meta data.
 */
final class WP_Meta_Manager {
	/**
	 * Registered meta of the post meta type (including pages and CPTs).
	 */
	public $post = array(
		'all' => array()
	);

	public $options = array(
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
		if ( ! property_exists( $this, $meta_object->meta_type ) ) {
			echo 'That content type does not exist';
		}
		if ( $meta_object->meta_subtype ) {
			$this->{$meta_object->meta_type}[$meta_object->meta_subtype][] = $meta_object;
		} else {
			$this->{$meta_object->meta_type}['all'][] = $meta_object;
		}
	}

	public function get_registered_meta( $args ) {
		if ( $args['meta_subtype']) {
			return $this->{$args['meta_type']}[$args['meta_subtype']];
		} else {
			return $this->{$args['meta_type']}['all'];
		}
	}
}

/**
 * register_meta() checks whether the key is protected meta, which checks if
 * it leads with an underscore and then filters it. This will add a __return_false
 * callback to the meta key's auth filter if it is protected.
 *
 * The auth filter is run within the map_meta_cap function for add_post_meta.
 * If the user is not authorized, map_meta_cap adds the add_post_meta capability
 * to the required capabilities, which the user must have.
 */
