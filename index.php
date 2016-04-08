<?php
/*
Plugin Name: Meta Data Models
Description: Data models for core meta object
Version:     0.1
*/

require( 'class-wp-meta-manager.php');
require( 'class-wp-post-meta.php');

$manager = new WP_Meta_Manager();

$manager->register( new WP_Meta( array(
	'content_type' => 'post',
	'key' => 'Favorite band',
	'data_type' => 'string'
) ) );
$x = $manager->get_registered_meta(array( 'content_type' => 'post' ) );
