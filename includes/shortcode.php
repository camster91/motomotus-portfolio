<?php
/**
 * Shortcode to display the Motomotus Work Grid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'motomotus_work', 'motomotus_work_shortcode' );
function motomotus_work_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'posts_per_page' => -1,
        'category' => '',
    ), $atts );

    $args = array(
        'post_type'      => 'motomotus_work',
        'posts_per_page' => (int) $atts['posts_per_page'],
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'work_category',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $atts['category'] ),
            ),
        );
    }

    $query = new WP_Query( $args );

    ob_start();
    ?>
    <div class="motomotus-container">
        <!-- Filter Menu -->
        <div class="motomotus-filters">
            <button class="filter-btn active" data-filter="all"><?php _e( 'All', 'motomotus' ); ?></button>
            <?php
            $terms = get_terms( array( 'taxonomy' => 'work_category', 'hide_empty' => true ) );
            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                foreach ( $terms as $term ) {
                    echo '<button class="filter-btn" data-filter="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</button>';
                }
            }
            ?>
        </div>

        <!-- Grid -->
        <div class="motomotus-grid">
            <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
                $agency = get_post_meta( get_the_ID(), '_motomotus_agency', true );
                $preview_video = get_post_meta( get_the_ID(), '_motomotus_preview_video', true );
                $main_video = get_post_meta( get_the_ID(), '_motomotus_main_video', true );
                $caption = get_post_meta( get_the_ID(), '_motomotus_caption', true );
                $thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'motomotus-thumb' );
                
                $categories = wp_get_post_terms( get_the_ID(), 'work_category', array( 'fields' => 'slugs' ) );
                $cat_class = '';
                if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
                    $cat_class = implode( ' ', array_map( 'sanitize_html_class', $categories ) );
                }
            ?>
                <div class="motomotus-item <?php echo esc_attr( $cat_class ); ?>" 
                     data-video="<?php echo esc_url( $main_video ); ?>"
                     data-caption="<?php echo esc_attr( $caption ); ?>">
                    <div class="motomotus-item-inner">
                        <div class="motomotus-media">
                            <?php if ( $thumbnail ) : ?>
                                <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title_attribute(); ?>" class="motomotus-thumb">
                            <?php endif; ?>
                            <?php if ( $preview_video ) : ?>
                                <video class="motomotus-preview-video" muted loop playsinline preload="none">
                                    <source src="<?php echo esc_url( $preview_video ); ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                        </div>
                        <div class="motomotus-info">
                            <h3 class="motomotus-title"><?php the_title(); ?></h3>
                            <?php if ( $agency ) : ?>
                                <p class="motomotus-agency"><?php echo esc_html( $agency ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); else : ?>
                <p><?php _e( 'No work items found.', 'motomotus' ); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="motomotus-modal" id="motomotus-video-modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="modal-close">&times;</button>
            <div class="video-container"></div>
            <div class="modal-caption"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
