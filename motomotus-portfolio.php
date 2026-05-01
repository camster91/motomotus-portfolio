<?php
/**
 * Plugin Name: Motomotus Portfolio
 * Description: A portfolio plugin that mimics the Motomotus work page with dynamic grid, video previews, and smooth animations.
 * Version: 1.0.0
 * Author: Gemini CLI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
define( 'MOTOMOTUS_VERSION', '1.1.0' ); // Incremented version
define( 'MOTOMOTUS_PATH', plugin_dir_path( __FILE__ ) );
define( 'MOTOMOTUS_URL', plugin_dir_url( __FILE__ ) );

// Include required files
require_once MOTOMOTUS_PATH . 'includes/cpt.php';
require_once MOTOMOTUS_PATH . 'includes/meta-boxes.php';
require_once MOTOMOTUS_PATH . 'includes/shortcode.php';
require_once MOTOMOTUS_PATH . 'includes/admin-ui.php';

// Activation Hook: Flush rewrite rules
register_activation_hook( __FILE__, 'motomotus_plugin_activation' );
function motomotus_plugin_activation() {
    motomotus_register_cpt(); // Ensure CPT is registered first
    flush_rewrite_rules();
}

// Setup: Image sizes
add_action( 'after_setup_theme', 'motomotus_setup' );
function motomotus_setup() {
    add_image_size( 'motomotus-thumb', 800, 450, true ); // Hard crop to 16:9
}

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'motomotus_enqueue_assets' );
function motomotus_enqueue_assets() {
    // Only load assets if the shortcode is present on the page (basic check)
    // For a more robust check, you'd use has_shortcode(), but that requires the global $post.
    // We'll load them for now but ensure they are versioned.

	// GSAP for animations
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true );
	wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array( 'gsap' ), '3.12.2', true );
	
	// Custom assets
	wp_enqueue_style( 'motomotus-style', MOTOMOTUS_URL . 'assets/css/style.css', array(), MOTOMOTUS_VERSION );
	wp_enqueue_script( 'motomotus-script', MOTOMOTUS_URL . 'assets/js/main.js', array( 'gsap' ), MOTOMOTUS_VERSION, true );

    // Localize for AJAX or other needs
    wp_localize_script( 'motomotus-script', 'motomotusData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' )
    ));
}
