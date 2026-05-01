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
    if ( ! is_array( $columns ) ) {
        return $columns;
    }
    $new_columns = array();
    foreach($columns as $key => $value) {
        if($key == 'title') {
            $new_columns['thumbnail'] = __( 'Thumbnail', 'motomotus' );
            $new_columns[$key] = $value;
            $new_columns['agency'] = __( 'Agency/Client', 'motomotus' );
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
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, array( 80, 80 ) );
            } else {
                echo '<span class="dashicons dashicons-format-image" style="font-size: 40px; color: #ccc;"></span>';
            }
            break;
        case 'agency':
            $agency = get_post_meta( $post_id, '_motomotus_agency', true );
            echo $agency ? esc_html( $agency ) : '—';
            break;
    }
}

// Make the list sortable by menu_order by default in admin
add_action( 'pre_get_posts', 'motomotus_admin_sort_work' );
function motomotus_admin_sort_work( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    
    if ( $query->get( 'post_type' ) === 'motomotus_work' ) {
        if ( ! $query->get( 'orderby' ) ) {
            $query->set( 'orderby', 'menu_order' );
            $query->set( 'order', 'ASC' );
        }
    }
}

// Add Quick Edit support for Menu Order
add_filter( 'page_attributes_dropdown_pages_args', 'motomotus_enable_menu_order_for_work', 10, 2 );
function motomotus_enable_menu_order_for_work( $dropdown_args, $post ) {
    if ( is_object( $post ) && $post->post_type === 'motomotus_work' ) {
        // This filter is often used to adjust hierarchical dropdowns, 
        // but it's a good place to ensure attributes are supported.
    }
    return $dropdown_args;
}
