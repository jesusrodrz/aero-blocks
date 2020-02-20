<?php 
namespace Aerolinea\Blocks\SectionParallax;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/section-parallax', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));

  
}

function render_dynamic_block($attributes,$content) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
    $has_image = is_int($attributes['image']['id']) ? true: false;
    $url = $has_image ? 'url('.$attributes['image']['url'].')' : 'transparent';
    $bgDark = $attributes['options']['background'] === 'dark' ?  'dark' : '';
    $main = $attributes['options']['main'] ?  'default-width' : '';
    $radius = $attributes['options']['borderRadius'] ?  'radius' : '';
    // var_dump($attributes['options']);
  ?>
    <section class="section-parallax <?php echo $bgDark . ' '. $main . ' ' .$radius; ?>" style="--url-image:<?php echo $url?>" >
      
      <?php 
        echo $content;
      ?>
      
    </section>
  <?php
  /* END HTML OUTPUT */

  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
  // return $attributes['title'];
  // return 'totle';
}