<?php
add_action('wp_ajax_load_more_topic_posts', 'load_more_topic_posts');
add_action('wp_ajax_nopriv_load_more_topic_posts', 'load_more_topic_posts');

function load_more_topic_posts() {

    $offset   = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $term_id  = isset($_POST['term_id']) ? intval($_POST['term_id']) : 0;
    $taxonomy = isset($_POST['taxonomy']) ? sanitize_key($_POST['taxonomy']) : '';

    if (!$term_id || !$taxonomy) {
        wp_die();
    }


    $query = new WP_Query(array(
        'post_type'      => array('post', 'podcasts'),
        'posts_per_page' => 8,
        'offset'         => $offset,
        'post_status'    => 'publish',

        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
    ));

    if ($query->have_posts()) {

        while ($query->have_posts()) {

            $query->the_post();

            $post_title     = get_the_title();
            $post_permalink = get_permalink();
            $topic          = get_the_terms(get_the_ID(), 'topic');

            $image = has_post_thumbnail()
                ? get_the_post_thumbnail_url(get_the_ID(), 'full')
                : get_template_directory_uri() . '/assets/images/placeholder.png';

                $total_posts = $query->found_posts; 
            ?>

            <div class="col-md-3">
                <div class="card border-0">
                    <div class="overflow-hidden mb-1">
                        <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 img-hover-effect" alt="<?php echo esc_attr($post_title); ?>">
                    </div>
                    <?php if($topic): ?>
                        <span class="text-uppercase small category_color ls-1 d-block mb-0 p-2"><?php echo esc_html($topic[0]->name); ?></span>
                    <?php endif; ?>
                    <h4 class="h6 fw-bold mb-0 p-2">
                        <a href="<?php echo esc_url($post_permalink); ?>" class="text-dark text-decoration-none title-hover-effect">
                            <?php echo esc_html($post_title); ?>
                        </a>
                    </h4>
                </div>
            </div>

            <?php
        }

    } else {

        echo '<div class="section-padding mb-5 text-center">
                <p>No articles are available at the moment.</p>
            </div>';

    }

    wp_reset_postdata();

    wp_die();
}

function theme_enqueue_load_more_scripts() {

    wp_enqueue_script(
        'load-more-topics',
        get_template_directory_uri() . '/ajax/js/category-ajax.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script(
        'load-more-topics',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
        )
    );

}

add_action('wp_enqueue_scripts', 'theme_enqueue_load_more_scripts');