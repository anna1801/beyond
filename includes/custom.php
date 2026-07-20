<?php
// Disable Gutenberg for multiple custom templates
add_filter( 'use_block_editor_for_post', function( $use_block_editor, $post ) {

    if ( ! $post ) {
        return $use_block_editor;
    }

    if (
        $post->post_type === 'page' &&
        (int) $post->ID === (int) get_option( 'page_on_front' )
    ) {
        return false;
    }

    $custom_templates = array(
        'templates/landing-page.php',
    );

    if (
        $post->post_type === 'page' &&
        in_array(
            get_page_template_slug( $post->ID ),
            $custom_templates,
            true
        )
    ) {
        return false;
    }

    return $use_block_editor;

}, 10, 2 );





?>