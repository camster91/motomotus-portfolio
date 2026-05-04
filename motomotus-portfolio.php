<?php
/**
 * Plugin Name: Motomotus Portfolio
 * Description: A high-performance portfolio showcase plugin that replicates the minimalist aesthetic and smooth interactions of the Motomotus "Work" page.
 * Version: 1.1.3
 * Author: Gemini CLI
 * Text Domain: motomotus
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
if ( ! defined( 'MOTOMOTUS_VERSION' ) ) {
    define( 'MOTOMOTUS_VERSION', '1.1.3' );
}
if ( ! defined( 'MOTOMOTUS_PATH' ) ) {
    define( 'MOTOMOTUS_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'MOTOMOTUS_URL' ) ) {
    define( 'MOTOMOTUS_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Load Dependencies
 */
require_once MOTOMOTUS_PATH . 'includes/cpt.php';
require_once MOTOMOTUS_PATH . 'includes/meta-boxes.php';
require_once MOTOMOTUS_PATH . 'includes/shortcode.php';
require_once MOTOMOTUS_PATH . 'includes/admin-ui.php';

/**
 * Plugin Activation logic
 */
register_activation_hook( __FILE__, 'motomotus_plugin_activate' );
function motomotus_plugin_activate() {
    // Explicitly call registration so rewrite rules have something to flush
    if ( function_exists( 'motomotus_register_cpt' ) ) {
        motomotus_register_cpt();
    }
    flush_rewrite_rules();
}

/**
 * Global Init Tasks
 */
add_action( 'init', 'motomotus_global_init' );
function motomotus_global_init() {
    add_image_size( 'motomotus-thumb', 800, 450, true );
}

/**
 * Enqueue Assets
 */
add_action( 'wp_enqueue_scripts', 'motomotus_load_frontend_assets' );
function motomotus_load_frontend_assets() {
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true );
	wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array( 'gsap' ), '3.12.2', true );
	
	wp_enqueue_style( 'motomotus-style', MOTOMOTUS_URL . 'assets/css/style.css', array(), MOTOMOTUS_VERSION );
	wp_enqueue_script( 'motomotus-script', MOTOMOTUS_URL . 'assets/js/main.js', array( 'gsap' ), MOTOMOTUS_VERSION, true );
}
