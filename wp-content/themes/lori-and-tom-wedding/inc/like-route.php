<?php

add_action('rest_api_init', 'galleryLikeRoutes');

function galleryLikeRoutes() {
	register_rest_route('wedding/v1', 'managelike', array(
			'methods' => 'POST',
			'callback' => 'createLike'
		));

	register_rest_route('wedding/v1', 'managelike', array(
			'methods' => 'DELETE',
			'callback' => 'deleteLike'
		));
}


function createLike($data) {
	if(is_user_logged_in()) {

	$photo = sanitize_text_field($data['photoId']);

	$existQuery = new WP_Query (array(
		'author' => get_current_user_id(),
		'post_type' => 'like',
		 'meta_query' => array(
		 	array(
		 		'key' => 'liked_photo_id',
		 		'compare' => '=',
		 		'value' => $photo
		 		)
		 	)
	));

	if($existQuery->found_posts == 0) {
		return wp_insert_post(array(
			'post_type' => 'like',
			'post_status' => 'publish',
			'post_title' => 'Our Post Like v2',
			'meta_input' => array(
				'liked_photo_id' => $photo
			)
		));

	} 

	} else {
		die("Only logged in users can like photos");
	}

}

function deleteLike($data) {
	$likeId = sanitize_text_field($data['like']);
	if(get_current_user_id() == get_post_field('post_author', $likeId) AND
		get_post_type($likeId) == 'like') {
			wp_delete_post($likeId, true);
			return 'Like deleted';
	} else {
		die('You do not have permussion to delete that like');
	}
}