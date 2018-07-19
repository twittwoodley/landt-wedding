<div class="gallery-container">
<?php 
//Get gallery images URL
$query_images_args = array(
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'posts_per_page' => - 1,
);

$query_images = new WP_Query( $query_images_args );

$images = array();
foreach ( $query_images->posts as $image ) {
    array_push($images, array(wp_get_attachment_url( $image->ID ), $image->ID));

}

foreach ($images as $image){
	?>
		<div class="gallery-image-thumb" style="background-image: url(<?php echo $image[0]; ?>)">
			<div class="gallery-thumb-overlay">
				<?php 
					$likeCount = new WP_Query (array(
						'post_type' => 'like',
						 'meta_query' => array(
						 	array(
						 		'key' => 'liked_photo_id',
						 		'compare' => '=',
						 		'value' => $image[1]
						 		)
						 	)
					));

					$existStatus = 'no';

					if(is_user_logged_in()) {
						$existQuery = new WP_Query (array(
						'author' => get_current_user_id(),
						'post_type' => 'like',
						 'meta_query' => array(
						 	array(
						 		'key' => 'liked_photo_id',
						 		'compare' => '=',
						 		'value' => $image[1]
						 		)
						 	)
					));

					if ($existQuery->found_posts) {
						$existStatus = 'yes';
					}
					}

					
				?>

				<div class="like-box" data-like="<?php echo $existQuery->posts[0]->ID; ?>" data-photoID="<?php echo $image[1]; ?>" data-exists="<?php echo $existStatus ?>">
					<i class="far fa-heart heart-empty" aria-hidden="true"></i>
					<i class="fas fa-heart heart-filled" aria-hidden="true"></i>
					<span class="like-count"><?php echo $likeCount->found_posts ?></span>
				</div>
				<a href="<?php echo $image ?>" download><i class="fa fa-download"></i></a>
			</div>
		</div>
	<?php
} 
?>

</div>