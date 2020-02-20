<?php 
namespace Aerolinea\Blocks\SectionJetTypes;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/section-jet-types', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));

  
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
  ?>
    <section class="section-jet-types"> 
    <?php 
          $terms = get_terms( 'abs_types');
          if( count($terms) > 0 ) :
            foreach ($terms as $key => $term):
              
              $post = get_posts(array(
                'post_type' => 'abs_jets',
                'numberposts' => 1,
                'tax_query' => array(
                  array(
                    'taxonomy' => 'abs_types',
                    'field' => 'slug', 
                    'terms' => $term->slug
                  )
                )
              ));
             
              $blocks = \parse_blocks($post[0]->post_content);
              $ID_image = $blocks[0]["attrs"]['id'];
              $imageURL = wp_get_attachment_url( $ID_image );
              $term_link = get_term_link( $term );
              ?>
                <a class="jet-type" href="<?php echo $term_link?>">
                  <img class="jet-type__img" src="<?php echo $imageURL?>" alt="<?php echo $term->name?>" />
                  <div class="jet-type__container">
                    <h3 class="jet-type__title"><?php _e('Alquiler de jets','aero-blocks');?> <?php echo $term->name?></h3>
                  </div>
                </a>
              <?php 
            endforeach;
          endif; 
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