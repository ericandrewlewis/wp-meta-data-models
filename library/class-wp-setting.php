<?php


class WP_Setting {

	/**
	 * @param [type] $options [description]
	 */
	function __construct( $options ) {
		$this->key = $options['key'];
		$this->data_type = $options['data_type'];
	}
}
