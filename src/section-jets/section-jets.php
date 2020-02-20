<?php 
namespace Aerolinea\Blocks\SectionJets;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/section-jets', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));

  
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
  
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $_posts = new \WP_Query( array(
      'post_type'         => 'abs_jets',
      'paged' => $paged
    ));
    if( $_posts->have_posts() ) :
    ?>
      <section class="section-jets"> 
    <?php 
      while ( $_posts->have_posts() ) : $_posts->the_post();
        $blocks = \parse_blocks(get_the_content());
        $ID_image = $blocks[0]["attrs"]['id'];
        $imageURL = wp_get_attachment_url( $ID_image );
        ?>
          <article class="jet-item">
              <img class="jet-item__img" src="<?php echo $imageURL ?>" alt="">
              <h2 class="jet-item__title"><?php echo get_the_title(); ?></h2>  
              <a class="jet-item__link" href="<?php echo get_permalink() ?>" target="_blank" rel="noopener noreferrer"><?php _e('Ver Jet Privado','aero-blocks'); ?></a>
          </article>
        <?php 
      endwhile;
    ?>
      </section>
    <?php
      $links = paginate_links(array(
        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'total'        => $_posts->max_num_pages,
        'current'      => max( 1, get_query_var( 'paged' ) ),
        'format'       => '?paged=%#%',
        'show_all'     => false,
        'type'         => 'plain',
        'end_size'     => 2,
        'mid_size'     => 1,
        'prev_next'    => true,
        // 'prev_text'    => sprintf( '<i></i> %1$s', __( 'Anterior', 'aero-blocks' ) ),
        'prev_text'    => '<i class="i-arrow-left2"></i>',
        // 'next_text'    => sprintf( '%1$s <i></i>', __( 'Siguiente', 'aero-blocks' ) ),
        'next_text'    => '<i class="i-arrow-right2"></i>',
        'add_args'     => false,
        'add_fragment' => '',
      ));
    ?>
    <nav class="nav-jets"><?php echo $links;?></nav>
    <?php
    endif; 
      
  /* END HTML OUTPUT */

  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
  // return $attributes['title'];
  // return 'totle';
}