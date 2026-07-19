<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="site-header fixed-top">
        <div class="top-bar py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-7">
                        <?php
                            $header_mail = get_field('header_mail', 'option');
                            if ($header_mail) :
                                echo '<a href="mailto:' . esc_attr($header_mail) . '" class="text-decoration-none small fw-bold text-dark" target="_self">';
                                echo '<i class="fas fa-envelope me-2 text-success"></i>' . esc_html($header_mail);
                                echo '</a>';
                            endif;
                        ?>
                    </div>
                    <div class="col-5 text-end">
                        <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'header-top-menu',
                                    'container'      => false,
                                    'fallback_cb'    => false,
                                    'items_wrap'     => '%3$s',
                                    'depth'          => 1,
                                    'walker'         => new Custom_header_top_Nav_Walker(),
                                )
                            );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <?php
                    $header_logo = get_field('header_logo', 'option');
                    if ($header_logo) :
                        echo '<a class="navbar-brand" href="' . esc_url(home_url('/')) . '" target="_self">';
                        echo '<img src="' . esc_url($header_logo['url']) . '" alt="' . esc_attr($header_logo['alt']) . '" class="img-fluid" style="max-height: 50px;">';
                        echo '</a>';
                    else :
                        echo '<a class="navbar-brand" href="' . esc_url(home_url('/')) . '" target="_self">' . get_bloginfo('name') . '</a>';
                    endif;
                ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'header-menu',
                                'container'      => false,
                                'fallback_cb'    => false,
                                'menu_class'       => 'navbar-nav mx-auto mb-2 mb-lg-0',
                                'depth'          => 2,
                                'walker'         => new Custom_Header_Nav_Walker(),
                            )
                        );
                    ?>
                    <?php 
                        $header_cta = get_field('header_cta', 'option');
                        if ($header_cta) :
                            echo '<div class="d-flex mt-3 mb-4 mt-lg-0 mb-lg-0">';
                            echo '<a href="' . esc_url($header_cta['url']) . '" class="btn btn-newsletter w-100 w-lg-auto" target="' . esc_attr($header_cta['target']) . '">';
                            echo esc_html($header_cta['title']);
                            echo '</a>';
                            echo '</div>';
                        endif;
                    ?>
                </div>
            </div>
        </nav>
    </header>
    <main>