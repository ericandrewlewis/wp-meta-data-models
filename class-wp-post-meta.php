<?php

class WP_Meta {

	/**
	 * The meta's content type. e.g. 'post' or 'comment'.
	 */
	public $meta_type = null;

	/**
	 * The meta's content subtype, if the content type supports subtype.
	 * e.g. 'page' is a subtype of the post type content type.
	 */
	public $meta_subtype = null;

	/**
	 * The meta's data type, expressed as a JSON Schema type.
	 */
	public $data_type = null;

	/**
	 * Whether the metadata should be stored in one row, or separate ones.
	 *
	 * @var bool
	 */
	public $single_row = null;

	function __construct( $options ) {
		$this->meta_type = $options['meta_type'];
		$this->key = $options['key'];
		$this->data_type = $options['data_type'];

		if ( method_exists( $this, 'sanitize' ) ) {
			add_filter( "sanitize_{$this->meta_type}_meta_{$this->key}", array( $this, 'sanitize' ), 10, 3 );
		} else if ( isset( $options['sanitize_callback'] ) && is_callable( $options['sanitize_callback'] ) ) {
				add_filter( "sanitize_{$this->meta_type}_meta_{$this->key}", $options['sanitize_callback'], 10, 3 );
		}

		if ( method_exists( $this, 'authorize' ) ) {
			add_filter( "auth_{$this->meta_type}_meta_{$this->key}", array( $this, 'authorize' ), 10, 6 );
		} else if ( isset( $options['auth_callback'] ) && is_callable( $options['auth_callback'] ) ) {
			add_filter( "auth_{$this->meta_type}_meta_{$this->key}", $options['auth_callback'], 10, 6 );
		}

		$this->single_row = $options['single_row'];
	}

	/**
	 *  Multidimensional stuff in the Customizer seems to be so that you can
	 *  create a WP_Customize_Setting object that binds to a nested value
	 *  within an `option`. Like a widget instance, which is represented
	 *  as an array element in the option `widget_calendar`. I don't
	 *  believe this is necessary for Post Meta.
	 *
	 * How will we handle multiple entries for one key?
	 */
	function get( $id ) {
		return get_post_meta( $id, $this->key );
	}

	/**
	 * Does it even make sense to add a set() function? Is it possible to paper
	 * over the existing setter API of meta data, which is complex? Seems like
	 * we would end up doing a lot of "delete everything then re-add it," which
	 * may not be the worst thing, but...
	 *
	 * @param [type] $id    [description]
	 * @param [type] $value [description]
	 */
	function set( $id, $value ) {
		$current_value = $this->get( $id );

		if ( $this->single_row ) {
			if ( $current_value ) {
				update_post_meta( $id, $this->key, $value, $current_value[0] );
			} else {
				add_post_meta( $id, $this->key, $value );
			}
		} else {
			if ( ! is_array( $value ) ) {
				echo 'Meta value must be an array';
			}
			// Delete rows that are higher than the given.
			// What if multiple rows have the same value? We aren't deleting by an index key,
			// we're deleting by the row's value.
			// e.g. How would you splice a value? e.g. I have related posts 1, 5, 7. I want to delete 5.
			if ( $current_value && sizeof( $current_value ) > sizeof( $value ) ) {
				for ( $index = sizeof( $value ); $index < sizeof( $current_value ); $index++ ) {
					delete_post_meta( $id, $this->key, $current_value[$index] );
				}
			}
			// In case any extra rows were deleted, refresh data.
			$current_value = $this->get( $id );
			foreach ( $value as $index => $_value ) {
				if ( $current_value && isset( $current_value[$index] ) ) {
					update_post_meta( $id, $this->key, $_value, $current_value[$index] );
				} else {
					add_post_meta( $id, $this->key, $_value );
				}
			}
		}
	}

	// Can be defined on subclasses.
	// function sanitize() {}
	// function authorize() {}
}
