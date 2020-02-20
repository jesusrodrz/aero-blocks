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
  <div class="jets-container">
    <div class="jets-container__content">
      <?php 
        if ( have_posts() ) {
          while ( have_posts() ) {
            the_post();
            the_content();
          }

        }
      ?>
    </div>
    <aside class="jets-container__sidebar">
      <h3><?php _e('Contáctanos','aero-blocks'); ?></h3>
      <p><?php _e('Llamanos y una de nuestras asesoras lo atenderá con la mejor disposición, brindándole una información personalizada ','aero-blocks'); ?></p>
      <div class="llamanos">
        <a href="tel:+51996172084" class="llamada_activo link"> <i class="i-mobile"></i>996 172 084</a>
        <a class="link" href="tel:+51012535426"> <i class="i-phone"></i>(01) 253 5426</a>
        <a class="link" href="mailto:Comercial@aerolineasantander.com"> <i class="i-mail2"></i>Comercial@aerolineasantander.com</a>
      </div>
      <h3><?php _e('Jets privados recomendados','aero-blocks'); ?></h3>
      <div class="recomendados">

        <?php 
        // global $langOK;
          $_posts = new WP_Query( array(
            'post_type'         => 'abs_jets',
            'posts_per_page'    => 15,
            'tax_query'         => array(
              array(
                'taxonomy' => 'abs_category',
                'field'    => 'slug',
                'terms'     => 'recomendado',
                'operator' => 'IN' 
              )
            )
          )); 
          if( $_posts->have_posts() ) :
            while ( $_posts->have_posts() ) : $_posts->the_post();

              $blocks = parse_blocks($post->post_content);
              $ID_image = $blocks[0]["attrs"]['id'];
              $imageURL = wp_get_attachment_url( $ID_image );
              $stat = $blocks[8]["attrs"]['stat'];
              // var_dump($blocks);
              ?>
                <a class="recomendados__item" target="_blank" href="<?php echo get_permalink() ?>">
                    <img src="<?php echo $imageURL ?>" alt="">
                    <h3><?php echo get_the_title(); ?></h3>  
                    <p><i class="<?php echo $stat['icon']; ?>"></i><?php echo $stat['text']; ?></p>
                </a>
              <?php 
            endwhile;
          endif; 
        ?>
      </div>

    </aside>
  </div>
<?php 

get_footer();
