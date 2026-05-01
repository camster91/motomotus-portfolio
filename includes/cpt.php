<?php
/**
 * Register Custom Post Type: Work
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'motomotus_register_cpt' );
if ( ! function_exists( 'motomotus_register_cpt' ) ) {
    function motomotus_register_cpt() {
        $labels = array(
            'name'               => _x( 'Works', 'post type general name', 'motomotus' ),
            'singular_name'      => _x( 'Work', 'post type singular name', 'motomotus' ),
            'menu_name'          => _x( 'Motomotus Work', 'admin menu', 'motomotus' ),
            'name_admin_bar'     => _x( 'Work', 'add new on admin bar', 'motomotus' ),
            'add_new'            => _x( 'Add New', 'work', 'motomotus' ),
            'add_new_item'       => __( 'Add New Work', 'motomotus' ),
            'new_item'           => __( 'New Work', 'motomotus' ),
            'edit_item'          => __( 'Edit Work', 'motomotus' ),
            'view_item'          => __( 'View Work', 'motomotus' ),
            'all_items'          => __( 'All Works', 'motomotus' ),
            'search_items'       => __( 'Search Works', 'motomotus' ),
            'parent_item_colon'  => __( 'Parent Works:', 'motomotus' ),
            'not_found'          => __( 'No works found.', 'motomotus' ),
            'not_found_in_trash' => __( 'No works found in Trash.', 'motomotus' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'work' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
            'menu_icon'          => 'dashicons-portfolio',
        );

        register_post_type( 'motomotus_work', $args );

        // Register Taxonomy for Categories (Filter)
        register_taxonomy( 'work_category', 'motomotus_work', array(
            'label'        => __( 'Categories', 'motomotus' ),
            'rewrite'      => array( 'slug' => 'work-category' ),
            'hierarchical' => true,
            'show_admin_column' => true,
        ));
    }
}
