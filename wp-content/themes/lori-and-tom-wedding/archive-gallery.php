<?php 
	if(!is_user_logged_in()) {
	    wp_redirect(esc_url(site_url('/'))); //change this to load the homepage for logged in users
	    exit;
	  }
  	get_header(); 
    get_template_part('template-parts/content', 'navigation');

	?>
  <div class="content-wrapper">

<div class="sign-up-form-container upload-form-container">
  <h2>Add Photos</h2>
  <form id="uploadForm" class="upload-form" method="post" enctype="multipart/form-data" name="front_end_upload" onload="document.getElementById("uploadForm").reset();">
    <label for="gallery-file-upload" class="file-upload-custom">
      <i class="fa fa-cloud-upload"></i> Choose Photos
    </label>
    <br>
    <input id="gallery-file-upload" type="file" name="kv_multiple_attachments[]"  multiple="multiple" autocomplete="off ">
    <input type="submit" name="Upload" >
  </form>

</div>

 <?php
//Upload multiple photos logic

if( 'POST' == $_SERVER['REQUEST_METHOD']  ) {
if ( $_FILES ) { 
    $files = $_FILES["kv_multiple_attachments"];
    if (count($files['name']) > 15) {
      die('<div class="error-msg">Sorry, You can only upload 15 files <br>
          <label for="gallery-file-upload" class="file-reupload-btn">Reselect files</label>
        </div>');
    }
    foreach ($files['name'] as $key => $value) {      
        if ($files['name'][$key]) { 
          $file = array( 
            'name' => $files['name'][$key],
            'type' => $files['type'][$key], 
            'tmp_name' => $files['tmp_name'][$key], 
            'error' => $files['error'][$key],
            'size' => $files['size'][$key]
          ); 
          $_FILES = array ("kv_multiple_attachments" => $file); 
          foreach ($_FILES as $file => $array) {        
            $newupload = kv_handle_attachment($file,$pid); 
          } 
        } 
              } 

    }
}

?>
  <h2>Your Photos</h2>

<div class="gallery-container">
<?php 
//Get gallery images URL
$query_images_args = array(
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'posts_per_page' => - 1,
    'author' => get_current_user_id()
);

$query_images = new WP_Query( $query_images_args );

$images = array();
foreach ( $query_images->posts as $image ) {
    array_push($images, array(wp_get_attachment_url( $image->ID ), $image->ID));

}


foreach ($images as $image){
  ?>
    <div class="gallery-image-thumb" data-id="<?php echo $image[1]; ?>" style="background-image: url(<?php echo $image[0]; ?>)">
      <div class="gallery-thumb-overlay">
        <span class="delete-image"><i class="fa fa-times"></i>Delete</span>
      </div>
    </div>
  <?php
} ?>
</div>

<h2>All Photos</h2>
<?php
  get_template_part('template-parts/content', 'gallery');

 get_footer(); ?>
<script>

 (function() {
document.getElementById("uploadForm").reset();
})();
</script>
