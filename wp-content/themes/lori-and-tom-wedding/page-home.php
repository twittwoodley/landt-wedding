<?php
get_header(); 
get_template_part('template-parts/content', 'navigation');

//days until wedding
$wedding = strtotime('2019-08-17') - time();
$remaining = floor($wedding / 86400);
$remArray = str_split(strval($remaining));
?>

	<div class="content-wrapper">
		<div class="flex-cont-x">
			<div>
				<div class="outer-frame rotate-left">
					<div class="inner-frame rotate-right">
						<div class="kid-photo kid-photo-lori" style="background-image: url(<?php echo get_theme_file_uri('images/lori-photo.jpg') ?>)"></div>
					</div>
				</div>	
			</div>
			<div class="day-count-container" style="background-image: url(<?php echo get_theme_file_uri('images/heart.svg'); ?>)">
				<!-- <i class="far fa-heart heart-background"></i> -->
				<div style="display:flex; flex-direction: column;">
						<h2><?php echo $remaining; ?><br><span>days to go</span></h2>
				</div>
			</div>
			<div>
			
			
				<div class="outer-frame rotate-right">
					<div class="inner-frame rotate-left">
						<div class="kid-photo kid-photo-tom rotate-left" style="background-image: url(<?php echo get_theme_file_uri('images/tom-kid-photo.jpg') ?>)"></div>
					</div>
				</div>
			</div>
		</div>
		<img src="<?php echo get_theme_file_uri('/images/section-break.png'); ?>">
		<div class="title-with-lines">
			<div class="line"></div>
			<h2>Popular Photos</h2>
			<div class="line"></div>
		</div>
<?php
	//get_template_part('template-parts/content', 'gallery');
$query_images_args = array(
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'posts_per_page' => -1,
);

$query_images = new WP_Query( $query_images_args ); ?>
<!-- include(locate_template('template-parts/content-gallery.php')); -->
<div class="gallery-container">
<!-- Get gallery images URL -->

<?php
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

foreach ($images as $image){ 
	$i;
	$i++;
	?>
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
	if ($i == 8) break;
} 	
echo posts_nav_link();
print_r($images);
?>

</div>
<?php
get_footer(); 
?>
