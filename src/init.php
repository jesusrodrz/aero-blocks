<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function aerolinea_blocks_cgb_block_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'aerolinea_blocks-cgb-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);
	// Register styles for admin
	wp_register_style(
		'aerolinea_blocks-cgb-admin-style-css', // Handle.
		plugins_url( 'dist/admin.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/admin.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'aerolinea_blocks-cgb-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);
	wp_localize_script('aerolinea_blocks-cgb-block-js', 'pluginData', array(
		'path' => plugins_url() .'/aero-blocks/'
		
	));
	

	// Register block editor styles for backend.
	wp_register_style(
		'aerolinea_blocks-cgb-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'aerolinea_blocks-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'cgb/block-aerolinea-blocks', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'aerolinea_blocks-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'aerolinea_blocks-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'aerolinea_blocks-cgb-block-editor-css',
		)
	);
}

// Hook: Block assets.
add_action( 'init', 'aerolinea_blocks_cgb_block_assets' );


// Block category
function aerolinea_block_category( $categories, $post ) {
	// var_dump($categories);
	return array_merge(
		array(
			array(
				'slug' => 'aerolinea-blocks',
				'title' => __( 'Bloques Aerolinea', 'aerolinea-blocks' ),
				'icon'=> '<i class="i-airplane"></i>',
			),
		),
		$categories
		
	);
}
add_filter( 'block_categories', 'aerolinea_block_category', 10, 2);




function my_block_plugin_scripts() {
	
	// Enqueue block script for frontent
	if(!is_admin()){
	
		$post = get_post(); 
		if ( has_blocks( $post->post_content ) ) {
				$blocks = parse_blocks( $post->post_content );
				foreach ($blocks as $key => $value) {

					$blockName = str_replace('asb/', "", $value['blockName']);
					$blockFilePath = plugin_dir_path( __DIR__ ) . 'dist/'.$blockName.'.js' ;
					
					if(file_exists($blockFilePath)){
						
						$version  = date("ymd-Gis", filemtime( $blockFilePath ));

						wp_enqueue_script( $blockName, plugins_url( '/dist/'.$blockName.'.js', dirname( __FILE__ ) ), array(), $version, true );
					}
				}
		}
	}

}
function load_abs_wp_admin_style(){
	
	wp_enqueue_style( 'aerolinea_blocks-cgb-admin-style-css' );
}
add_action('admin_enqueue_scripts', 'load_abs_wp_admin_style');

// Hook the enqueue functions into the frontend and editor
add_action( 'enqueue_block_assets', 'my_block_plugin_scripts' );


add_action(
	'rest_api_init',
	function () {

		if ( ! function_exists( 'use_block_editor_for_post_type' ) ) {
			require ABSPATH . 'wp-admin/includes/post.php';
		}

		// Surface all Gutenberg blocks in the WordPress REST API
		$post_types = get_post_types_by_support( [ 'editor' ] );
		foreach ( $post_types as $post_type ) {
			if ( use_block_editor_for_post_type( $post_type ) ) {
				register_rest_field(
					$post_type,
					'blocks',
					[
						'get_callback' => function ( array $post ) {
							return parse_blocks( $post['content']['raw'] );
						},
					]
				);
				register_rest_field(
					$post_type,
					'lang',
					[
						'get_callback' => function ( array $post ) {
							// $post_id = $post->ID;
							// var_dump
							// return array_keys($post);
							// return function_exists( 'pll_get_post_language' );
							return pll_get_post_language($post['id']);
						},
					]
				);
			}
		}
	}
);




include __DIR__ . '/section/section.php';
include __DIR__ . '/section-jets/section-jets.php';
include __DIR__ . '/section-customers/section-customers.php';
include __DIR__ . '/section-jet-types/section-jet-types.php';
include __DIR__ . '/section-parallax/section-parallax.php';
include __DIR__ . '/stats/stats.php';
include __DIR__ . '/jet-title/jet-title.php';
include __DIR__ . '/jet-stats/jet-stats.php';
include __DIR__ . '/jet-gallery/jet-gallery.php';
include __DIR__ . '/customers/customers.php';

include __DIR__ . '/includes/post-types.php';