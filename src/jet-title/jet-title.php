<?php 
namespace Aerolinea\Blocks\JetTitle;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/jet-title', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
    global $post;
    $title = $attributes['title'].' '.$post->post_title;
    // $title = $attributes['title'];
    $is_h1 = $attributes['tag'] == 'h1' ? true : false
  ?>
   
  <?php if($is_h1):?>
    <h1 class="jet__title"><?php echo $title; ?></h1>
  <?php else: ?>
    <h2 class="jet__title h2"><?php echo $title; ?></h2>
  <?php endif;?>
  <?php
  /* END HTML OUTPUT */

  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
  // return $attributes['title'];
  // return 'totle';
}