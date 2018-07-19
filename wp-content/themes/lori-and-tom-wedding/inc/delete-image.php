<?php
add_action('rest_api_init', 'deleteimage');

function deleteimage() {
	register_rest_route('wedding/v1', 'deleteimage', array(
			'methods' => 'DELETE',
			'callback' => 'deletePhoto'
		));
}

function deletePhoto($data) {
	$photoID = sanitize_text_field($data['photoId']);
	if(get_current_user_id() == get_post_field('post_author', $photoID)) {
			wp_delete_post($photoID, true);
			return 'Photo deleted';
	} else {
		die('You do not have permussion to delete that like');
	}
}