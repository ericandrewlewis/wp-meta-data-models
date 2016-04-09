<?php

// Define related posts meta, which allows an integer in a separate
// meta row, and supports up to three rows.
$google_analytics_option = new WP_Option( array(
	'meta_type' => 'option',
	'key' => 'google_analytics_option',
	'data_type' => array(
		'type' => 'string',
	),
) );
$manager->register( $google_analytics_option );
