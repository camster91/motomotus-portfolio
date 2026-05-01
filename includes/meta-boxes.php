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
		'Work Details',
		'motomotus_work_meta_box_html',
		'motomotus_work',
		'normal',
		'default'
	);
}

function motomotus_work_meta_box_html( $post ) {
	$agency       = get_post_meta( $post->ID, '_motomotus_agency', true );
	$preview_video = get_post_meta( $post->ID, '_motomotus_preview_video', true );
	$main_video    = get_post_meta( $post->ID, '_motomotus_main_video', true );
	$caption       = get_post_meta( $post->ID, '_motomotus_caption', true );

    // Security Nonce
    wp_nonce_field( 'motomotus_save_work_meta', 'motomotus_work_nonce' );
	?>
	<div class="motomotus-meta-row" style="margin-bottom: 15px;">
		<label for="motomotus_agency"><strong>Agency/Client Name:</strong></label><br>
		<input type="text" name="motomotus_agency" id="motomotus_agency" value="<?php echo esc_attr( $agency ); ?>" style="width: 100%;">
	</div>
	<div class="motomotus-meta-row" style="margin-bottom: 15px;">
		<label for="motomotus_preview_video"><strong>Hover Preview Video URL (MP4 recommended):</strong></label><br>
		<input type="text" name="motomotus_preview_video" id="motomotus_preview_video" value="<?php echo esc_attr( $preview_video ); ?>" style="width: 100%;">
		<p class="description">This video will play on hover in the grid (muted, looped).</p>
	</div>
	<div class="motomotus-meta-row" style="margin-bottom: 15px;">
		<label for="motomotus_main_video"><strong>Main Video URL (YouTube, Vimeo, or MP4):</strong></label><br>
		<input type="text" name="motomotus_main_video" id="motomotus_main_video" value="<?php echo esc_attr( $main_video ); ?>" style="width: 100%;">
		<p class="description">The full video that opens when the item is clicked.</p>
	</div>
	<div class="motomotus-meta-row" style="margin-bottom: 15px;">
		<label for="motomotus_caption"><strong>Popup Caption / Description:</strong></label><br>
		<textarea name="motomotus_caption" id="motomotus_caption" rows="4" style="width: 100%;"><?php echo esc_textarea( $caption ); ?></textarea>
		<p class="description">Text that appears below the video in the popup modal.</p>
	</div>
	<?php
}

add_action( 'save_post', 'motomotus_save_work_meta' );
function motomotus_save_work_meta( $post_id ) {
    // Check if nonce is set.
    if ( ! isset( $_POST['motomotus_work_nonce'] ) ) {
        return;
    }
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['motomotus_work_nonce'], 'motomotus_save_work_meta' ) ) {
        return;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

	if ( array_key_exists( 'motomotus_agency', $_POST ) ) {
		update_post_meta( $post_id, '_motomotus_agency', sanitize_text_field( $_POST['motomotus_agency'] ) );
	}
	if ( array_key_exists( 'motomotus_preview_video', $_POST ) ) {
		update_post_meta( $post_id, '_motomotus_preview_video', esc_url_raw( $_POST['motomotus_preview_video'] ) );
	}
	if ( array_key_exists( 'motomotus_main_video', $_POST ) ) {
		update_post_meta( $post_id, '_motomotus_main_video', esc_url_raw( $_POST['motomotus_main_video'] ) );
	}
	if ( array_key_exists( 'motomotus_caption', $_POST ) ) {
		update_post_meta( $post_id, '_motomotus_caption', wp_kses_post( $_POST['motomotus_caption'] ) );
	}
}
