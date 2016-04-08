<?php

class WP_Meta {

	/**
	 * The meta's content type. e.g. 'post' or 'comment'.
	 */
	public $content_type = null;

	/**
	 * The meta's content subtype, if the content type supports subtype.
	 * e.g. 'page' is a subtype of the post type content type.
	 */
	public $content_subtype = null;

	/**
	 * The meta's data type, expressed as a JSON Schema type.
	 */
	public $data_type = null;

	function __construct( $options ) {
		$this->content_type = $options['content_type'];
		$this->key = $options['key'];
		$this->data_type = $options['data_type'];
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
		// get_post_meta( $id, $this->key );
	}

	/**
	 * Can this do some default sanitization based on the JSON schema type?
	 * @return [type] [description]
	 */
	function sanitize() {}

	function authorize() { return true; }
}
