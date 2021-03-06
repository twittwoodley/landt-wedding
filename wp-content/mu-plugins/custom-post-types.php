<?php
function custom_post_types() {
	//Gallery post type
		register_post_type('gallery', array(
		'capability_type' => 'gallery',
		'map_meta_cap' => true,
		'show_in_rest' => true,
		'has_archive' => true,
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

	//Like post type
		register_post_type('like', array(
		'supports' => array('title'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
			'name' => 'Likes',
			'add_new_item' => 'Add New Like',
			'edit_item' => 'Edit Like',
			'all_items' => 'All Likes',
			'singular_name' => 'Like'
		),
		'menu_icon' => 'dashicons-heart'
	));

	//Question post type
		register_post_type('question', array(
		'supports' => array('title', 'editor', 'page-attributes'),
		'map_meta_cap' => true,
		'capability_type' => 'Question',
		'public' => true,
		'hierarchical' => true,
		'show_in_rest' => true,
		'show_ui' => true,
		'labels' => array(
			'name' => 'Questions',
			'add_new_item' => 'Add New Question',
			'edit_item' => 'Edit Question',
			'all_items' => 'All Questions',
			'singular_name' => 'Question'
		),
		'menu_icon' => 'dashicons-format-status'
	));

	//Song post type
		register_post_type('song', array(
		'supports' => array('title'),
		'map_meta_cap' => true,
		'has_archive' => true,
		'capability_type' => 'Song',
		'public' => true,
		'show_in_rest' => true,
		'show_ui' => true,
		'labels' => array(
			'name' => 'Songs',
			'add_new_item' => 'Add New Song',
			'edit_item' => 'Edit Song',
			'all_items' => 'All Songs',
			'singular_name' => 'Song'
		),
		'menu_icon' => 'dashicons-format-audio'
	));


}

add_action('init', 'custom_post_types');
