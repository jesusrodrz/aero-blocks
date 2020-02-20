<?php
/**
 * Plugin Name: aerolinea-blocks — CGB Gutenberg Block Plugin
 * Plugin URI: https://github.com/ahmadawais/create-guten-block/
 * Description: aerolinea-blocks — is a Gutenberg plugin created via create-guten-block.
 * Author: mrahmadawais, maedahbatool
 * Author URI: https://AhmadAwais.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: aero-blocks
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



global $langOK,$lanPath;
// register text domain
function register_aero_blocks_text_init() {
	$plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages'; /* Relative to WP_PLUGIN_DIR */
	global $langOK,$lanPath;
	$lanPath = $plugin_rel_path;
    $langOK = load_plugin_textdomain( 'aero-blocks', false, $plugin_rel_path );
	// var_dump(load_plugin_textdomain( 'aero-blocks', false, $plugin_rel_path ));
}
add_action('plugins_loaded', 'register_aero_blocks_text_init');

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

