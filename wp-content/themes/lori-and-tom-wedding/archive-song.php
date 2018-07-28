<?php 
	if(!is_user_logged_in()) {
	    wp_redirect(esc_url(site_url('/'))); //change this to load the homepage for logged in users
	    exit;
	  }
  	get_header(); 
    get_template_part('template-parts/content', 'navigation');
	?>
  <div class="content-wrapper">

	<?php
    $songsWithLikes = array();

    


	while(have_posts()) {
		the_post();
		$songLike = new WP_Query(array(
			'post_type' => 'like',
			'meta_query' => array(
                  array(
                  'key' => 'liked_photo_id',
                  'compare' => '=',
                  'value' => get_the_ID()
                  )
                )
		));
		//1234 in array push is where the like count will go
		array_push($songsWithLikes, array(get_the_title(), get_field('song_artist'), $songLike->found_posts, get_the_ID()));
		

		}

	function cmp($songsWithLikesB, $songsWithLikes) {
			if ($songsWithLikes[2]== $songsWithLikesB[2]) {
        		return 0;
    		}
    		return ($songsWithLikes[2] < $songsWithLikesB[2]) ? -1 : 1;
		}
		usort($songsWithLikes, "cmp");
	print_r($songsWithLikes);
?>
	<ul>
<?php
	foreach($songsWithLikes as $song) {
		$existStatus = 'no';

					if(is_user_logged_in()) {
						$existQuery = new WP_Query (array(
						'author' => get_current_user_id(),
						'post_type' => 'like',
						 'meta_query' => array(
						 	array(
						 		'key' => 'liked_photo_id',
						 		'compare' => '=',
						 		'value' => $song[3]
						 		)
						 	)
					));

					if ($existQuery->found_posts) {
						$existStatus = 'yes';
					}
					}

	?>
		<li>
			<h2><?php echo $song[0]; ?> by <?php echo $song[1]; ?></h2>	
			<div style="border:2px solid green;" class="like-box" data-like="<?php echo $existQuery->posts[0]->ID; ?>" data-photoID="<?php echo $song[3]; ?>" data-exists="<?php echo $existStatus ?>">
				<i title="Like" class="far fa-heart heart-empty" aria-hidden="true"></i>
				<i title="Unlike" class="fas fa-heart heart-filled" aria-hidden="true"></i>
				<span class="like-count"><?php echo $song[2] ?></span>
			</div>
		</li>
	<?php }
	?>
	</ul>


<?php get_footer(); ?>