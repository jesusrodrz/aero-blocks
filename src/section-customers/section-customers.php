<?php 
namespace Aerolinea\Blocks\SectionCustomers;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/section-customers', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));

  
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
  ?>
    <section class="section-customers"> 
    <?php 
          $_posts = new \WP_Query( array(
            'post_type'         => 'abs_customers',
            'posts_per_page'    => 15, //important for a PHP memory limit warning
            
          ));
          // var_dump($_posts);
          if( $_posts->have_posts() ) :
            while ( $_posts->have_posts() ) : $_posts->the_post();
          // if( $_posts ) :
          //   while ( $_posts ):
              // var_dump(parse_blocks($post->post_content));
              $blocks = \parse_blocks(get_the_content());
              $ID_image = $blocks[0]["attrs"]['logo']['id'];
              $alt = get_the_title();
              $imageURL = wp_get_attachment_url( $ID_image );
              $id = 'customer-'. get_the_ID();
              // get_the_content();
              // var_dump($imageURL);
              ?>
                <button class="section-customer" data-id="<?php echo $id ?>"><img class="section-customer__img" src="<?php echo $imageURL ?>" alt="<?php echo $alt ?>"></button>
                <?php the_content();?>
              <?php 
            endwhile;
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