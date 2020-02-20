<?php 
namespace Aerolinea\Blocks\Customers;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/customers', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
    $imgSrc = $attributes['logo']['url'];
    $imgAlt = $attributes['logo']['title'];
    $title = $attributes['title'];
    $content = $attributes['content'];
    $images = $attributes['images'];
    global $post;
    $id = 'customer-'.$post->ID;
  ?>
    <article class="customer" id="<?php echo $id; ?>">
      <div class="customer__logo-container">
        <img class="customer__logo-img" src="<?php echo $imgSrc; ?>" alt="<?php echo $imgAlt; ?>">
      </div>
      <h2 class="customer__title " ><?php echo $title; ?></h2>
      <div class="customer__content" ><?php echo $content; ?></div>
      <div class="customer__images">
        <?php 
          foreach ($images as $key => $image) {
            ?>
              <img class="customer__image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>">
            <?php
          }
        ?>
      </div>
    </article>
  <?php
  /* END HTML OUTPUT */

  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
  // return $attributes['title'];
  // return 'totle';
}