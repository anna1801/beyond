</main>
<?php wp_footer(); ?>
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <?php
                        $footer_logo = get_field('footer_logo', 'option');
                        if ($footer_logo) :
                            echo '<img src="' . esc_url($footer_logo['url']) . '" alt="' . esc_attr($footer_logo['alt']) . '" class="mb-4" style="height: 40px; filter: brightness(0) invert(1);">';
                        endif;
                        
                        echo '<br>';

                        $footer_about = get_field('footer_about', 'option');
                        if ($footer_about) :
                            echo '<div class="footer-about">' . $footer_about . '</div>';
                        endif;

                        if ( have_rows('social_links', 'option') ) : 
                            echo '<div class="d-flex gap-3 social-links">';
                                while ( have_rows('social_links', 'option') ) : the_row(); 
                                    $icon = get_sub_field('icon');
                                    $link = get_sub_field('link');
                                    echo '<a href="' . esc_url($link) . '" title="' . esc_attr($icon) . '" target="_blank"><i class="fab fa-' . esc_attr($icon) . ' fa-lg"></i></a>';
                                endwhile; 
                            echo '</div>';
                        endif; 
                    ?>
                </div>
                <?php custom_footer_menu( 'footer-menu' ); ?> 
            </div>
            <div class="border-top border-secondary mt-5 pt-4">
                <div class="row align-items-center">
                    <div class="col-md-6 ">
                        <?php 
                            $copyright_text = get_field('copyright_text', 'option');
                            if ($copyright_text) :
                                echo '<p class="small mb-0">' . $copyright_text . '</p>';
                            endif;
                        ?>
                    </div>
                    <div class="col-md-6 text-md-end text-center mt-3 mt-md-0">
                        <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'footer-bottom-menu',
                                    'container'      => false,
                                    'fallback_cb'    => false,
                                    'menu_class'     => 'list-inline mb-0',
                                    'depth'          => 2,
                                    'walker'         => new Custom_Footer_Bottom_Nav_Walker(),
                                )
                            );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>