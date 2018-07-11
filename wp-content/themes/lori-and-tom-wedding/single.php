<?php get_header(); 
  while (have_posts()) {
  	the_post();
  	the_title();
	the_content();
	echo get_field('photo_upload');
	}?>

	<form method="post" action="options.php">
    <input type="file" name="my_image_upload" id="my_image_upload"  multiple="false" />
    <input type="hidden" name="post_id" id="post_id" value="55" />
    <?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
    <input id="submit_my_image_upload" name="submit_my_image_upload" type="submit" value="Upload" />
 </form>

 <?php
 get_footer(); ?>