<?php


class WP_Option {

	/**
	 * @param [type] $options [description]
	 */
	function __construct( $options ) {
		$this->key = $options['key'];
		$this->data_type = $options['data_type'];

		if ( isset( $options['sanitize_callback'] ) && is_callable( $options['sanitize_callback'] ) ) {
			add_filter( "sanitize_{$this->meta_type}_meta_{$this->key}", $options['sanitize_callback'], 10, 3 );
		}
	}

	function get() {
		get_option( $this->key );
	}

	/**
	 * @todo think through and bring in multidimensional logic.
	 * @param [type] $value [description]
	 */
	function set( $value ) {
		update_option( $this->key, $value );
	}
}
