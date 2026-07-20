<?php
/**
 * Add custom font-weight formats to the WordPress WYSIWYG Editor
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
    ));

    return $init_array;
}
add_filter('tiny_mce_before_init', 'custom_tinymce_font_weight_formats');

function custom_tinymce_buttons($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons', 'custom_tinymce_buttons');







?>