<?php
/**
 * Display for jets custom post type
 *
 * @package Aerolinea_Blocks
 *
 * @since 1.0.0
 */

get_header();
?>
<?php 
  
  if ( have_posts() ) {
    while ( have_posts() ) {
      the_post();
      // the_title();
      the_content();
    }

  }
?>
<?php 

get_footer();
