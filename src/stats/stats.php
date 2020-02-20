<?php 
namespace Aerolinea\Blocks\stats;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/stats', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
    $stats = $attributes['stats'];
    
  ?>
    <section <?php echo $id; ?> class="stats">
      <?php
        foreach ($stats as $i => $stat) {
          ?>
            <div class="stat">
              <p class="stat__number"><?php echo $stat['number'] ?></p>
              <div class="stat__text"><?php echo $stat['text'] ?></div>
            </div>
          <?php
        }
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