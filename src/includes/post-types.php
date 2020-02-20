<?php

function asb_register_jet_post_type(){
  register_post_type('abs_jets',
    array(
        'labels'      => array(
            'name'          => __('Jets', 'aero-blocks'),
            'singular_name' => __('Jet', 'aero-blocks'),
        ),
        'public'      => true,
        'has_archive' => true,
        // 'rewrite'     => array( 'slug' => __( 'jets-privados', 'aero-blocks' )), // my custom slug
        'rewrite'     => array( 'slug' => 'jets-privados'), // my custom slug
        'show_in_rest' => true,
        'menu_position'       => 2,
        'supports' => array('editor','title'),
        'template' => array(
          array( 'core/image', array( ) ),
          array( 'asb/jet-title', 
            array(
              'placeholder' => __('Titulo'),
              'title' => __('Alquiler del jet privado'),
              'tag' => 'h1'
            ) 
          ),
          array( 'core/paragraph', array(
            'placeholder' => __('Descripción del jet'),
          ) ),
          array( 'asb/jet-title', 
            array(
              'placeholder' => __('Titulo'),
              'title' => __('Estadisticas de'),
              'tag' => 'h2'
            ) 
          ),
          array( 'asb/jet-stats', array( ) ),
          array( 'asb/jet-title', 
            array(
              'placeholder' => __('Titulo'),
              'title' => __('Imagenes del jet privado'),
              'tag' => 'h2'
            ) 
          ),
          array( 'asb/jet-gallery', array( ) ),
        ),
        'template_lock '=> 'all'
    )
  );

  // Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'Categorias', 'taxonomy general name' ),
    'singular_name' => _x( 'Categoria', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar categorias' ),
    'popular_items' => __( 'Populares' ),
    'all_items' => __( 'Todos las categorias' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar categoria' ), 
    'update_item' => __( 'Actualizar categoria' ),
    'add_new_item' => __( 'Agregar categoria' ),
    'new_item_name' => __( 'Nueva categoria' ),
    'separate_items_with_commas' => __( 'Separar con comas' ),
    'add_or_remove_items' => __( 'Aregregar o remover' ),
    'choose_from_most_used' => __( 'Elegir de las mas usados' ),
    'menu_name' => __( 'Categoria' ),
  ); 
 
  // Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('abs_category','abs_jets',array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'recomendados' ),
    'show_in_rest'=> true
  ));
  $labels = array(
    'name' => _x( 'Tipos', 'taxonomy general name' ),
    'singular_name' => _x( 'Tipo', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar tipo' ),
    'popular_items' => __( 'Populares' ),
    'all_items' => __( 'Todos los tipos' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar tipo' ), 
    'update_item' => __( 'Actualizar tipo' ),
    'add_new_item' => __( 'Agregar tipo' ),
    'new_item_name' => __( 'Nueva tipo' ),
    'separate_items_with_commas' => __( 'Separar con comas' ),
    'add_or_remove_items' => __( 'Aregregar o remover' ),
    'choose_from_most_used' => __( 'Elegir de las mas usados' ),
    'menu_name' => __( 'Tipos' ),
  ); 
 
  // Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('abs_types','abs_jets',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tipos' ),
    'show_in_rest'=> true
  ));

}
add_action( 'init', 'asb_register_jet_post_type' );
function asb_loadJet( $template ) {
  global $post;
  if ( 'abs_jets' === $post->post_type  ) {
    $post_template = plugin_dir_path( __FILE__ ) . '../templates/jets.php';
    if ( file_exists( $post_template ) ) {
      return $post_template;
    }
  }

  return $template;
}
add_filter( 'single_template', 'asb_loadJet');

add_filter('archive_template', 'register_archive_template_for_abs_jets');

function register_archive_template_for_abs_jets( $template ) {
  global $post;
  if ( 'abs_jets' === $post->post_type  ) {
    
    $post_template = plugin_dir_path( __FILE__ ) . '../templates/jet-archive.php';
    return $post_template;
  }
  return $template;
}


function asb_register_customers_post_type(){
  register_post_type('abs_customers',
    array(
        'labels'      => array(
            'name'          => __('Clientes', 'aero-blocks'),
            'singular_name' => __('Cliente', 'aero-blocks'),
        ),
        'public'      => true,
        'has_archive' => true,
        'menu_icon'           => 'dashicons-buddicons-buddypress-logo',
        // 'rewrite'     => array( 'slug' => __( 'clientes', 'aero-blocks' )), // my custom slug
        'rewrite'     => array( 'slug' => 'clientes'), // my custom slug
        'show_in_rest' => true,
        'menu_position'       => 2,
        'supports' => array('editor','title'),
        'template' => array(
          array( 'asb/customers', array( ) )
        ),
        'template_lock '=> 'all'
    )
  );

}
add_action( 'init', 'asb_register_customers_post_type' );
function asb_loadCustomer( $template ) {
  global $post;
  if ( 'abs_customers' === $post->post_type  ) {
    $post_template = plugin_dir_path( __FILE__ ) . '../templates/customers.php';
    if ( file_exists( $post_template ) ) {
      return $post_template;
    }
  }

  return $template;
}
add_filter( 'single_template', 'asb_loadCustomer');

function set_posts_per_page_for_towns_cpt( $query ) {
  
  // var_dump($query->query);
  // var_dump('aca');
  // var_dump('<br />');
  // var_dump($query->query_vars);
  // var_dump($query->query['abs_types']);
  if ( !is_admin() && ($query->query['post_type'] == 'abs_jets' || $query->query['abs_types']) ) {
    if($query->query_vars['posts_per_page']){
      return;
    }
    $query->set( 'posts_per_page', '12' );
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_for_towns_cpt' );