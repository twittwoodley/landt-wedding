<?php get_header(); 
  while (have_posts()) {
  	the_post();
  	the_title();
	the_content();
	}

require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );


  ?>

  <div>
    <h2>Add Photos</h2>
    <input class="photo-input" placeholder="Test text">
    <span class="photo-upload">Upload</span>
  </div>

 <?php
 get_footer(); ?>