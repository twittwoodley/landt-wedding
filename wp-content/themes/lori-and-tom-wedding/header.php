<?php
//the below is commented out to stop redirection during development period. Uncomment when front-page.php is complete

if(!is_user_logged_in()) {
    wp_redirect(esc_url(wp_login_url())); //change this to load the homepage for logged in users
    exit;
  }?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
