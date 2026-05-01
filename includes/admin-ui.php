<?php
/**
 * Admin UI enhancements for Motomotus Work
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add columns to the Work list
add_filter( 'manage_motomotus_work_posts_columns', 'motomotus_set_custom_edit_work_columns' );
function motomotus_set_custom_edit_work_columns( $columns ) {
    $new_columns = array();
    foreach($columns as $key => $value) {
        if($key == 'title') {
            $new_columns['thumbnail'] = __( 'Thumbnail' );
            $new_columns[$key] = $value;
            $new_columns['agency'] = __( 'Agency/Client' );
        } else {
            $new_columns[$key] = $value;
        }
    }
    return $new_columns;
}

// Populate the columns
add_action( 'manage_motomotus_work_posts_custom_column', 'motomotus_custom_work_column', 10, 2 );
function motomotus_custom_work_column( $column, $post_id ) {
    switch ( $column ) {
        case 'thumbnail':
            echo get_the_post_thumbnail( $post_id, array( 80, 80 ) );
            break;
        case 'agency':
            echo esc_html( get_post_meta( $post_id, '_motomotus_agency', true ) );
            break;
    }
}

// Make the list sortable by menu_order by default in admin
add_action( 'pre_get_posts', 'motomotus_admin_sort_work' );
function motomotus_admin_sort_work( $query ) {
    if ( is_admin() && $query->is_main_query() && $query->get( 'post_type' ) === 'motomotus_work' ) {
        if ( ! $query->get( 'orderby' ) ) {
            $query->set( 'orderby', 'menu_order' );
            $query->set( 'order', 'ASC' );
        }
    }
}

// Add Quick Edit support for Menu Order (standard WP behavior, just ensuring it's visible)
add_filter( 'page_attributes_dropdown_pages_args', 'motomotus_enable_menu_order_for_work', 10, 2 );
function motomotus_enable_menu_order_for_work( $dropdown_args, $post ) {
    if ( $post->post_type === 'motomotus_work' ) {
        // This is usually handled by 'supports' => array('page-attributes')
    }
    return $dropdown_args;
}
