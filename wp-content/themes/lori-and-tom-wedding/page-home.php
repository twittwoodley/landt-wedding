<?php
if(!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/'))); //change this to load the homepage for logged in users
    exit;
  }
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
						<h2><?php echo $remaining; ?><br><span>Days to go</span></h2>
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

$query_images = new WP_Query( $query_images_args );
include(locate_template('template-parts/content-gallery.php'));
get_footer(); 
?>
