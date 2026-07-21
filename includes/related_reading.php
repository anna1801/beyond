<?php 
function related_reading_shortcode() {
    $current_post_id = get_the_ID();
    //$categories = wp_get_post_categories($current_post_id);
    // if (empty($categories)) {
    //     return '';
    // }
    $topics =  wp_get_post_terms($current_post_id,'topic',
                    array(
                        'fields' => 'ids',
                    )
                );
    $related_query = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'post__not_in'   => array($current_post_id),
        //'category__in'   => $categories,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'topic',
                'field'    => 'term_id',
                'terms'    => $topics,
            ),
        ),
    ));
    if (!$related_query->have_posts()) {
        return '';
    }
    $output = '<div class="inline-related-section">';
    $output .= '<button class="slider-nav-btn slider-prev" id="relatedPrev"><i class="fas fa-chevron-left"></i></button>';
    $output .= '<button class="slider-nav-btn slider-next" id="relatedNext"><i class="fas fa-chevron-right"></i></button>';
    $output .= '<div class="related-reading-slider-container">';
    $output .= '<div class="related-reading-wrapper" id="relatedReadingSlider">';
    while ($related_query->have_posts()) : $related_query->the_post();
        if(has_post_thumbnail()) {
            $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
        } else {
            $post_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.png';
        }
        $output .= '<div class="inline-related-box">';
        $output .= '<img src="' . esc_url($post_thumbnail) . '" alt="' . get_the_title() . '">';
        $output .= '<div>';
        $output .= '<span class="inline-related-label">Related reading</span>';
        $output .= '<h4 class="h6 mb-2">';
        $output .= '<a href="' . get_the_permalink() . '" class="text-dark text-decoration-none fw-bold title-hover-effect">' . get_the_title() . '</a>';
        $output .= '</h4>';
        $output .= '</div>';
        $output .= '</div>';
    endwhile;
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    wp_reset_postdata();
    return $output;
}

add_shortcode('related_reading', 'related_reading_shortcode');