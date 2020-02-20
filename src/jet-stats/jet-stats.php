<?php 
namespace Aerolinea\Blocks\JetStats;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/jet-stats', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
    $stats = $attributes['stats'];
    if(is_array($stats)){
      ?>
        <section <?php echo $id; ?> class="jet-stats">
          <?php
            
            foreach ($stats as $i => $stat) {
              ?>
                <div class="jet-stat">
                  <div class="jet-stat__icon"><i class="<?php echo $stat['icon'] ?>"></i></div>
                  <div class="jet-stat__text"><?php echo $stat['text'] ?></div>
                </div>
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