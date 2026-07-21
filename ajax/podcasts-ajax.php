<?php 
    add_action('wp_ajax_load_more_podcasts', 'load_more_podcasts_ajax');
    add_action('wp_ajax_nopriv_load_more_podcasts', 'load_more_podcasts_ajax');

    function load_more_podcasts_ajax() {

        $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

        $args = array(
            'post_type'      => 'podcasts',
            'posts_per_page' => 6,
            'offset'         => $offset,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
        );

        $posts = new WP_Query($args);

        ob_start();

        render_podcasts_list($posts);

        $html = ob_get_clean();

        $total_posts = wp_count_posts('podcasts')->publish;

        wp_send_json_success(array(
            'html'  => $html,
            'count' => $posts->post_count,
            'total' => intval($total_posts),
        ));
    }

    
    // Enqueue the JavaScript file for AJAX functionality
    function enqueue_podcast_scripts() {
        wp_enqueue_script(
            'podcast-ajax',
            get_template_directory_uri() . '/ajax/js/podcasts-ajax.js',
            array('jquery'),
            null,
            true
        );
        wp_localize_script(
            'podcast-ajax',
            'podcast_ajax',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
            )
        );
    }

    add_action('wp_enqueue_scripts', 'enqueue_podcast_scripts');
?>