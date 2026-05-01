<?php
/**
 * Custom Meta Boxes for Work items
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'motomotus_add_work_meta_boxes' );
function motomotus_add_work_meta_boxes() {
	add_meta_box(
		'motomotus_work_details',
		__( 'Work Details', 'motomotus' ),
		'motomotus_work_meta_box_html',
		'motomotus_work',
		'normal',
		'default'
	);
}

function motomotus_work_meta_box_html( $post ) {
    if ( ! is_object( $post ) ) {
        return;
    }

	$agency       = get_post_meta( $post->ID, '_motomotus_agency', true );
	$preview_video = get_post_meta( $post->ID, '_motomotus_preview_video', true );
	$main_video    = get_post_meta( $post->ID, '_motomotus_main_video', true );
	$caption       = get_post_meta( $post->ID, '_motomotus_caption', true );

    wp_nonce_field( 'motomotus_save_meta_action', 'motomotus_meta_nonce' );
	?>
	<div class="motomotus-meta-row" style="margin-bottom: 15px;">
		<label for="motomotus_agency"><strong><?php _e( 'Agency/Client Name:', 'motomotus' ); ?></strong></label><br>
		<input type="text" name="motomotus_agency" id="motomotus_agency" value="<?php echo esc_attr( $agency ); ?>" style="width: 100%;">
	</div>
	<div class="motomotus-meta-row" style="margin-bottom: 15px;">
		<label for="motomotus_preview_video"><strong><?php _e( 'Hover Preview Video URL:', 'motomotus' ); ?></strong></label><br>
		<input type="text" name="motomotus_preview_video" id="motomotus_preview_video" value="<?php echo esc_attr( $preview_video ); ?>" style="width: 100%;">
	</div>
	<div class="motomotus-meta-row" style="margin-bottom: 15px;">
		<label for="motomotus_main_video"><strong><?php _e( 'Main Video URL:', 'motomotus' ); ?></strong></label><br>
		<input type="text" name="motomotus_main_video" id="motomotus_main_video" value="<?php echo esc_attr( $main_video ); ?>" style="width: 100%;">
	</div>
	<div class="motomotus-meta-row">
		<label for="motomotus_caption"><strong><?php _e( 'Popup Caption / Description:', 'motomotus' ); ?></strong></label><br>
		<textarea name="motomotus_caption" id="motomotus_caption" rows="4" style="width: 100%;"><?php echo esc_textarea( $caption ); ?></textarea>
	</div>
	<?php
}

add_action( 'save_post', 'motomotus_save_work_meta_data', 10, 2 );
function motomotus_save_work_meta_data( $post_id, $post ) {
    // Basic verification
    if ( ! is_object( $post ) || ! isset( $post->post_type ) ) {
        return;
    }

    // Post type check
    if ( $post->post_type !== 'motomotus_work' ) {
        return;
    }

    // Nonce check
    if ( ! isset( $_POST['motomotus_meta_nonce'] ) || ! wp_verify_nonce( $_POST['motomotus_meta_nonce'], 'motomotus_save_meta_action' ) ) {
        return;
    }

    // Auth check
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Skip autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

	if ( isset( $_POST['motomotus_agency'] ) ) {
		update_post_meta( $post_id, '_motomotus_agency', sanitize_text_field( $_POST['motomotus_agency'] ) );
	}
	if ( isset( $_POST['motomotus_preview_video'] ) ) {
		update_post_meta( $post_id, '_motomotus_preview_video', esc_url_raw( $_POST['motomotus_preview_video'] ) );
	}
	if ( isset( $_POST['motomotus_main_video'] ) ) {
		update_post_meta( $post_id, '_motomotus_main_video', esc_url_raw( $_POST['motomotus_main_video'] ) );
	}
	if ( isset( $_POST['motomotus_caption'] ) ) {
		update_post_meta( $post_id, '_motomotus_caption', wp_kses_post( $_POST['motomotus_caption'] ) );
	}
}
