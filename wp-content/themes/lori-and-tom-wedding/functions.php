<?php

require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/delete-image.php');
require get_theme_file_path('/inc/load-more-route.php');

function files_and_scripts() {
	wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Ubuntu:400,700'); //Google Font
	wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css'); //Font Awesome
	wp_enqueue_style('main_styles', get_stylesheet_uri());
	wp_enqueue_script('main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
	 wp_localize_script('main-js', 'themeData', array(
    'root_url' => get_site_url(),
    'theme_uri' => get_theme_file_uri(),
    'current_user' => get_current_user_id(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}

add_action('wp_enqueue_scripts',  'files_and_scripts');

function themeFeatures() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size('galleryThumb', 400, 260, true);
}

add_action('after_setup_theme', 'themeFeatures');

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

//Customize login screen 
add_filter('login_headerurl', 'ourHeaderURL');

function ourHeaderURL() {
  return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS() {
	wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Asap:400,600|Zeyada'); //Google Font
  	wp_enqueue_style('login-styling', get_theme_file_uri('/css/login.css'), NULL, '1.1');
}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle() {
  return get_bloginfo('name');
}