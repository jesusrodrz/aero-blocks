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
    ?>
      <h1 class="jets-archive-title">Jets <?php echo single_term_title( "", false ); ?></h1>
      <section class="section-jets"> 
    <?php
      while ( have_posts() ) {
        // the_post();
        // the_title();
        // the_content();
        the_post();
          $blocks = parse_blocks(get_the_content());
          $ID_image = $blocks[0]["attrs"]['id'];
          $imageURL = wp_get_attachment_url( $ID_image );
          ?>
            <article class="jet-item">
                <img class="jet-item__img" src="<?php echo $imageURL ?>" alt="">
                <h2 class="jet-item__title"><?php echo get_the_title(); ?></h2>  
                <a class="jet-item__link" href="<?php echo get_permalink() ?>" target="_blank" rel="noopener noreferrer"><?php _e('Ver Jet Privado','aero-blocks'); ?></a>
            </article>
          <?php 
      }
      $links = paginate_links(array(
        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        // 'total'        => $_posts->max_num_pages,
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
      </section>
    <?php
    ?>
    <nav class="nav-jets">
      <?php
        echo $links;
      ?>
    </nav>
    <?php
  }
?>
<?php
get_footer();
