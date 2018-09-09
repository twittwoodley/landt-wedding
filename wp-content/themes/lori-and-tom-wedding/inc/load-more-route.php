<?php
add_action('rest_api_init', 'imageRouteInit');

function imageRouteInit() {
  register_rest_route('gallery/v1', 'images', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'imageResults'
  ));
}

function imageResults($data) {

	//Get gallery images URL
	$finalImages = array();
	$query_images_args = array(
	    'post_type'      => 'attachment',
	    'post_mime_type' => 'image',
	    'post_status'    => 'inherit',
	    'posts_per_page' => -1,
	);
	$query_images = new WP_Query( $query_images_args );

	$images = array();

	//Get like Count
	foreach ( $query_images->posts as $image ) {
		$imagelike = new WP_Query(array(
				'post_type' => 'like',
				'meta_query' => array(
	                  array(
	                  'key' => 'liked_photo_id',
	                  'compare' => '=',
	                  'value' => $image->ID
	                  )
	                )
			));

	$existStatus = 'no';
		$user = $data['current_user'];
			$existQuery = new WP_Query (array(
			'author' => $user,
			'post_type' => 'like',
			 'meta_query' => array(
			 	array(
			 		'key' => 'liked_photo_id',
			 		'compare' => '=',
			 		'value' => $image->ID
			 		)
			 	)
		));

		if ($existQuery->found_posts) {
			$existStatus = 'yes';
		}

	    array_push($images, array(
	    	"urlFullSize" => wp_get_attachment_image_src( $image->ID, 'full')[0],
	    	"imageID" => $image->ID, 
	    	"author" => get_the_author_meta('display_name' ,$image->post_author), 
	    	"urlMeduimSize" => wp_get_attachment_image_src( $image->ID, 'galleryThumb')[0], 
	    	"likeCount" => $imagelike->found_posts,
	    	"likeID" => $existQuery->posts[0]->ID,
	    	"existStatus" => $existStatus,
	    	"currentUser" => $data['current_user'],
	    	"maxPosts" => $query_images->found_posts
	    	)
	    );
	}
	function cmp($imagesB, $images) {
      	if ($images['likeCount']== $imagesB['likeCount']) {
            return 0;
        }
        return ($images[4] < $imagesB[4]) ? -1 : 1;
    }
    usort($images, "cmp");
	
	$imageCount = $data['image_count'] + 8;
	$slicedImages = array_slice($images, $imageCount, 8);
	return $slicedImages;
}
?>