<?php
/**
 * Register Custom Post Type: Work
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'motomotus_register_cpt' );
function motomotus_register_cpt() {
	$labels = array(
		'name'               => _x( 'Works', 'post type general name' ),
		'singular_name'      => _x( 'Work', 'post type singular name' ),
		'menu_name'          => _x( 'Motomotus Work', 'admin menu' ),
		'name_admin_bar'     => _x( 'Work', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', 'work' ),
		'add_new_item'       => __( 'Add New Work' ),
		'new_item'           => __( 'New Work' ),
		'edit_item'          => __( 'Edit Work' ),
		'view_item'          => __( 'View Work' ),
		'all_items'          => __( 'All Works' ),
		'search_items'       => __( 'Search Works' ),
		'parent_item_colon'  => __( 'Parent Works:' ),
		'not_found'          => __( 'No works found.' ),
		'not_found_in_trash' => __( 'No works found in Trash.' ),
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
		'supports'           => array( 'title', 'thumbnail', 'page-attributes' ), // page-attributes for sorting
		'menu_icon'          => 'dashicons-portfolio',
	);

	register_post_type( 'motomotus_work', $args );

    // Register Taxonomy for Categories (Filter)
    register_taxonomy( 'work_category', 'motomotus_work', array(
        'label'        => __( 'Categories' ),
        'rewrite'      => array( 'slug' => 'work-category' ),
        'hierarchical' => true,
        'show_admin_column' => true,
    ));
}
