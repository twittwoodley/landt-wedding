<?php

require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/delete-image.php');

function files_and_scripts() {
	wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Qwigley'); //Google Font
	wp_enqueue_style('font-awesome', '//use.fontawesome.com/releases/v5.0.13/css/all.css'); //Font Awesome
	wp_enqueue_style('university_main_styles', get_stylesheet_uri());
	wp_enqueue_script('main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
	 wp_localize_script('main-js', 'themeData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}

add_action('wp_enqueue_scripts',  'files_and_scripts');

function kv_handle_attachment($file_handler,$post_id,$set_thu=false) {
	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload( $file_handler, $post_id );

         // If you want to set a featured image frmo your uploads. 
	if ($set_thu) set_post_thumbnail($post_id, $attach_id);
	return $attach_id;
	unset($attach_id);
	$attach_id = array();
	return  print_r($attach_id);
}

function remove_admin_login_header() { //Removes Admin Header Bar
    remove_action('wp_head', '_admin_bar_bump_cb');
}

add_action('get_header', 'remove_admin_login_header');

show_admin_bar( false );