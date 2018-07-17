<?php 

//the below is commented out to stop redirection during development period. Uncomment when front-page.php is complete

if(is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/home'))); //change this to load the homepage for logged in users
    exit;
  }
get_header(); ?>
	<div class="site-container">
		<div class="sign-up-form-container">
			<?php 
			wp_login_form();
			?>
			<p>Haven't got an account? Sign up <a href="<?php echo wp_registration_url(); ?> ">here!</a></p>
		</div>
	<?php 
	get_footer(); ?>