<?php
function custom_post_types() {
	//Gallery post type
		register_post_type('gallery', array(
		'capability_type' => 'gallery',
		'map_meta_cap' => true,
		'show_in_rest' => true,
		'supports' => array('title', 'editor'),
		'public' => true,
		'show_ui' => true,
		'labels' => array(
			'name' => 'Galleries',
			'add_new_item' => 'Add New Gallery',
			'edit_item' => 'Edit Gallery',
			'all_items' => 'All Galleries',
			'singular_name' => 'Gallery'
		),
		'menu_icon' => 'dashicons-welcome-write-blog'
	));
}

add_action('init', 'custom_post_types');
