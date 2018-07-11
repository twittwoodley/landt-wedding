<?php get_header(); 
  while (have_posts()) {
  	the_post();
  	the_title();
	the_content();
	}
/*
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );*/


  ?>

<!-- <div>
  <h2>Add Photos</h2>
  <form  method="post" enctype="multipart/form-data">
    <input class="photo-input" placeholder="Test text">
    <input class="photo-select" type="file" name="Image">
    <span class="photo-upload">Upload</span>  
  </form>

</div> -->
<form id="featured_upload" method="post" action="#" enctype="multipart/form-data">
  <input type="file" name="my_image_upload" id="my_image_upload"  multiple="false" />
  <input type="hidden" name="post_id" id="post_id" value="55" />
  <?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
  <input id="submit_my_image_upload" name="submit_my_image_upload" type="submit" value="Upload" />
</form>

 <?php

 get_footer(); ?>