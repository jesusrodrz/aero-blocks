<?php 
namespace Aerolinea\Blocks\JetGallery;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/jet-gallery', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
    $images = $attributes['imagesData'];
    if(is_array($images )){

      ?>
        <section class="jet-gallery">
          <?php
            foreach ($images as $i => $image) {
              ?>
                <img class="jet-gallery__img" src="<?php echo $image['url'] ?>" alt="<?php echo $image['caption'] ?>">
              <?php
            }
          ?>
        </section>
      <?php
    }
  /* END HTML OUTPUT */

  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
  // return $attributes['title'];
  // return 'totle';
}