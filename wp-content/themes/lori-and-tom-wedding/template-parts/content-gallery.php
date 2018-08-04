<div class="gallery-container">
<?php 
//Get gallery images URL


$images = array();
foreach ( $query_images->posts as $image ) {
	//$author = get_the_author($image->ID);
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

    array_push($images, array(wp_get_attachment_image_src( $image->ID, 'galleryThumb')[0], $image->ID, get_the_author_meta('display_name' ,$image->post_author), wp_get_attachment_image_src( $image->ID, 'full')[0], $imagelike->found_posts));
}

//Like count is added to $images!!!!! That took a long time to figure out! It can be accessed by $image[4]. 
//I need to work out how to use it in array_sort before the below foreach loop. 

function cmp($imagesB, $images) {
      if ($images[4]== $imagesB[4]) {
            return 0;
        }
        return ($images[4] < $imagesB[4]) ? -1 : 1;
    }
    usort($images, "cmp");

foreach ($images as $image){ ?>
		<div class="gallery-image-thumb" style="background-image: url(<?php echo $image[0]; ?>)">
			<div class="gallery-thumb-overlay">
				<div class="overlay-info-top">
					<h4 class="photographer-name">Uploaded by <?php echo $image[2]; ?></h4>
					<a title="Enlarge" class="image-enlarge-link" href="<?php echo $image[3]; ?>" data-lightbox="roadtrip"><img src="<?php echo get_theme_file_uri('images/enlarge.png'); ?>"></a>
				</div>
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
				<div class="overlay-info-bottom">
					<div class="like-box" data-like="<?php echo $existQuery->posts[0]->ID; ?>" data-photoID="<?php echo $image[1]; ?>" data-exists="<?php echo $existStatus ?>">
						<i title="Like" class="far fa-heart heart-empty" aria-hidden="true"></i>
						<i title="Unlike" class="fas fa-heart heart-filled" aria-hidden="true"></i>
						<span class="like-count"><?php echo $likeCount->found_posts ?></span>
					</div>
					<a class="image-download-link" title="Download" href="<?php echo $image[3]?>" download><i class="fa fa-download"></i></a>
				</div>
			</div>
		</div>
	<?php
	if ($i++ == 7) break;
} 

?>

</div>