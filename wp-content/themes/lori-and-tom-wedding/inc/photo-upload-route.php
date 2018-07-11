<?php

add_action('rest_api_init', 'weddingPhotoUpload');

function weddingPhotoUpload() {
	register_rest_route('wedding/v1', 'userPhotos', array(
		'methods' => WP_REST_SERVER::READABLE,
		'callback' => 'getPhotos'
	));
}

function getPhotos($data) {
		$photoQuery = new WP_Query(array(
			'post_type' => 'post',
/*			'author' => get_current_user_id(),
*/		));
}
