<?php
/**
 * Plugin Name: Motomotus Portfolio
 * Description: A portfolio plugin that mimics the Motomotus work page with dynamic grid, video previews, and smooth animations.
 * Version: 1.1.2
 * Author: Gemini CLI
 * Text Domain: motomotus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
if ( ! defined( 'MOTOMOTUS_VERSION' ) ) {
    define( 'MOTOMOTUS_VERSION', '1.1.2' );
}
if ( ! defined( 'MOTOMOTUS_PATH' ) ) {
    define( 'MOTOMOTUS_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'MOTOMOTUS_URL' ) ) {
    define( 'MOTOMOTUS_URL', plugin_dir_url( __FILE__ ) );
}

// Include required files safely
$includes = array(
    'includes/cpt.php',
    'includes/meta-boxes.php',
    'includes/shortcode.php',
    'includes/admin-ui.php',
);

foreach ( $includes as $file ) {
    if ( file_exists( MOTOMOTUS_PATH . $file ) ) {
        require_once MOTOMOTUS_PATH . $file;
    }
}

// Activation Hook: Flush rewrite rules
register_activation_hook( __FILE__, 'motomotus_plugin_activation' );
if ( ! function_exists( 'motomotus_plugin_activation' ) ) {
    function motomotus_plugin_activation() {
        if ( function_exists( 'motomotus_register_cpt' ) ) {
            motomotus_register_cpt();
        }
        flush_rewrite_rules( false );
    }
}

// Setup: Image sizes & other init tasks
add_action( 'init', 'motomotus_portfolio_init' );
if ( ! function_exists( 'motomotus_portfolio_init' ) ) {
    function motomotus_portfolio_init() {
        add_image_size( 'motomotus-thumb', 800, 450, true );
    }
}

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'motomotus_enqueue_assets' );
if ( ! function_exists( 'motomotus_enqueue_assets' ) ) {
    function motomotus_enqueue_assets() {
        wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true );
        wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array( 'gsap' ), '3.12.2', true );
        
        wp_enqueue_style( 'motomotus-style', MOTOMOTUS_URL . 'assets/css/style.css', array(), MOTOMOTUS_VERSION );
        wp_enqueue_script( 'motomotus-script', MOTOMOTUS_URL . 'assets/js/main.js', array( 'gsap' ), MOTOMOTUS_VERSION, true );

        wp_localize_script( 'motomotus-script', 'motomotusData', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' )
        ));
    }
}
