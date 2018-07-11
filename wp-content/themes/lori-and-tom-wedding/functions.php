<?php

require get_theme_file_path('/inc/photo-upload-route.php');

function files_and_scripts() {
	wp_enqueue_style('university_main_styles', get_stylesheet_uri());
	wp_enqueue_script('main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
	 wp_localize_script('main-js', 'themeData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}

add_action('wp_enqueue_scripts',  'files_and_scripts');