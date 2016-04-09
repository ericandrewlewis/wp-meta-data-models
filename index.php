<?php
/*
Plugin Name: Meta Data Models
Description: Data models for core meta object
Version:     0.1
*/
require( 'class-wp-meta-manager.php');
require( 'class-wp-post-meta.php');

$manager = new WP_Meta_Manager();

// Define related posts meta, which allows an integer in a separate
// meta row, and supports up to three rows.
$related_posts_meta = new WP_Post_Meta( array(
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
) );
$manager->register( $related_posts_meta );
// This would set two separate meta rows one for each integer.
// $related_posts_meta->set( 1, array( 123, 457 ) );


// Define review meta, which would shove reviews into an array
// stored inside a single meta field.
$review_meta = new WP_Post_Meta( array(
	'meta_type' => 'post',
	'key' => 'review',
	'data_type' => array(
		'type' => 'array',
		'items' => array(
			'type' => 'array',
			'items' => array(
				'type' => 'object',
				'properties' => array(
					'reviewer_name' => array(
						'type' => 'string'
					),
					'review' => array(
						'type' => 'string'
					)
				)
			)
		),
		// No minimum or maximum.
		// 'minItems' => 0,
		'maxItems' => 1
	),
) );
$manager->register( $review_meta );

// This would set one meta row with multiple reviews in an array.
// $review_meta->set( 1,
// 	// The post meta row
// 	array(
// 		// The array of reviews
// 		array(
// 			// A review
// 			array(
// 				'reviewer_name' => 'jim',
// 				'review' => 'it was horrible'
// 			),
// 			array(
// 				'reviewer_name' => 'job',
// 				'review' => 'pretty chill experience'
// 			)
// 		),
// 	)
// );
