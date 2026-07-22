<?php
/**
 * Add custom font-weight and button formats to the WordPress WYSIWYG Editor
 */
function custom_tinymce_font_weight_formats($init_array) {

    $init_array['style_formats'] = json_encode(array(
        array(
            'title' => 'Font Weight',
            'items' => array(
                array(
                    'title'    => 'Light (300)',
                    'inline'   => 'span',
                    'styles'   => array(
                        'font-weight' => '300',
                    ),
                ),
                array(
                    'title'    => 'Regular (400)',
                    'inline'   => 'span',
                    'styles'   => array(
                        'font-weight' => '400',
                    ),
                ),
                array(
                    'title'    => 'Medium (500)',
                    'inline'   => 'span',
                    'styles'   => array(
                        'font-weight' => '500',
                    ),
                ),
                array(
                    'title'    => 'Semi Bold (600)',
                    'inline'   => 'span',
                    'styles'   => array(
                        'font-weight' => '600',
                    ),
                ),
                array(
                    'title'    => 'Bold (700)',
                    'inline'   => 'span',
                    'styles'   => array(
                        'font-weight' => '700',
                    ),
                ),
                array(
                    'title'    => 'Extra Bold (800)',
                    'inline'   => 'span',
                    'styles'   => array(
                        'font-weight' => '800',
                    ),
                ),
            ),
        ),

        array(
            'title' => 'Button',
            'items' => array(
                array(
                    'title'   => 'Default Button',
                    'selector' => 'a',
                    'classes' => 'btn btn-news rounded-pill px-4 py-2 fw-bold text-uppercase small',
                ),
            ),
        ),

    ));

    return $init_array;
}
add_filter('tiny_mce_before_init', 'custom_tinymce_font_weight_formats');

function custom_tinymce_buttons($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons', 'custom_tinymce_buttons');

// Related reading shortcode for tinymce editor
function custom_tinymce_shortcode($buttons) {
    $buttons[] = 'related_reading_button';
    return $buttons;
}
add_filter('mce_buttons', 'custom_tinymce_shortcode');
function custom_tinymce_plugins($plugin_array) {

    $plugin_array['related_reading'] =
        get_template_directory_uri() . '/assets/js/admin.js'; 

    return $plugin_array;
}
add_filter('mce_external_plugins', 'custom_tinymce_plugins');

// hide default user profile picture in admin 
function hide_avatar_for_author() {
    ?>
    <style>
        .user-profile-picture {
            display: none !important;
        }
    </style>
    <?php
}
add_action( 'admin_head', 'hide_avatar_for_author' );


//Allow a page template to be used only once.
function restrict_page_templates_to_one_page( $templates ) {

    $restricted_templates = array(
        'template/template-about.php',
        'template/template-contact.php',
        'template/template-podcasts.php',
        'template/template-videos.php',
    );

    foreach ( $restricted_templates as $template_file ) {

        $used_pages = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => 1,
            'post__not_in'   => array( get_the_ID() ),
            'meta_key'       => '_wp_page_template',
            'meta_value'     => $template_file,
            'fields'         => 'ids',
        ) );

        if ( ! empty( $used_pages ) ) {
            unset( $templates[ $template_file ] );
        }
    }

    return $templates;
}

add_filter( 'theme_page_templates', 'restrict_page_templates_to_one_page');


?>