<?php
/*
Plugin Name: Meta Data Models
Description: Data models for core meta object
Version:     0.1
*/

require( 'class-wp-meta-manager.php');
require( 'class-wp-post-meta.php');

$manager = new WP_Meta_Manager();

// Should support post meta as an array of separate entries, or stuffed into
// one entry. Is this essentially unique vs. many? Need use cases.
//
// Need to support "related_posts" stored one in each post meta row, or
// "related_posts" stored as an array in one row (or multiple!).
$related_posts_meta = new WP_Meta( array(
	'meta_type' => 'post',
	'key' => 'related_posts',
	'data_type' => array(
		'type' => 'array',
		'items' => array(
			'type' => 'number'
		),
		'minItems' => 0,
		'maxItems' => 3
	),
	// Whether the data should be stored in a single row, or stored in separate rows.
	'single_row' => false
) );
$manager->register( $related_posts_meta );

// $x = $manager->get_registered_meta(array( 'content_type' => 'post' ) );

// echo '<PRE>';
// $value = $glerf_meta->get( 1 );
// unset( $value[2]);
// $value[1] = 'test!';
// $value[2] = 'test';
// var_dump( $value );die;
// $glerf_meta->set( 1, $value );
// die;
