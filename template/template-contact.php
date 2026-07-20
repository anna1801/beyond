<?php
/**
 * Template Name: Contact Page
 */
get_header();
?>
    <?php
        $hero_title = get_field('hero_title');
        $hero_content = get_field('hero_content');
        if ($hero_title || $hero_content) : 
            ?>
            <section class="contact-header">
                <div class="container text-center">
                    <?php if ($hero_title) : ?>
                        <h1 class="display-4 fw-bold mb-3"><?php echo esc_html($hero_title); ?></h1>
                    <?php endif; ?>
                    <?php if ($hero_content) : ?>
                        <p class="lead text-muted mx-auto" style="max-width: 700px;"><?php echo esc_html($hero_content); ?></p>
                    <?php endif; ?>
                </div>
            </section>
            <?php 
        endif; 
    ?>

    <section class="contact-section">
        <div class="container">
            <div class="row g-5">
                <?php
                    $form_title = get_field('form_title');
                    $form_shortcode = get_field('form_shortcode');
                    if ($form_shortcode) :
                        echo '<div class="col-lg-7">';
                            if($form_title) :
                                echo '<h3 class="fw-bold mb-4">' . esc_html($form_title) . '</h3>';
                            endif;
                            echo '<div class="bg-white p-4 rounded-3 shadow-sm">';
                                echo do_shortcode($form_shortcode);
                            echo '</div>';
                        echo '</div>';
                    endif;
                ?>
                <div class="col-lg-5">
                    <div class="contact-info-card">
                        <?php
                            if(have_rows('address')) :
                                $location_title = get_field('location_title');
                                if($location_title) :
                                    echo '<h4 class="fw-bold mb-4">' . esc_html($location_title) . '</h4>';
                                endif;
                                while(have_rows('address')) : the_row();
                                    $location_name = get_sub_field('location_name');
                                    $address = get_sub_field('address');
                                    if($location_name && $address) :
                                        echo '<div class="d-flex mb-4">';
                                            echo '<div class="office-icon"><i class="fas fa-location-dot"></i></div>';
                                            echo '<div>';
                                                echo '<h6 class="fw-bold mb-1">' . esc_html($location_name) . '</h6>';
                                                echo '<p class="text-muted mb-0">' . esc_html($address) . '</p>';
                                            echo '</div>';
                                        echo '</div>';
                                    endif;
                                endwhile;
                                echo '<hr class="my-4">';
                            endif;
                        ?>
                        
                        <?php
                            if(have_rows('contacts')) :
                                $contacts_title = get_field('contacts_title');
                                if($contacts_title) :
                                    echo '<h4 class="fw-bold mb-4">' . esc_html($contacts_title) . '</h4>';
                                endif;
                                while(have_rows('contacts')) : the_row();
                                    $label = get_sub_field('label');
                                    $type = get_sub_field('type');
                                    $value = get_sub_field('value');
                                    if($label && $value) :
                                        echo '<div class="mb-4">';
                                            echo '<h6 class="fw-bold mb-1" style="margin-right: 5px;">' . esc_html($label) . '</h6>';
                                            if($type === 'email') :
                                                echo '<a href="mailto:' . esc_attr($value) . '" class="text-success text-decoration-none">' . esc_html($value) . '</a>';
                                            elseif($type === 'phone') :
                                                echo '<a href="tel:' . esc_attr($value) . '" class="text-success text-decoration-none">' . esc_html($value) . '</a>';
                                            endif;
                                        echo '</div>';
                                    endif;
                                endwhile;
                                echo '<hr class="my-4">';
                            endif;
                        ?>

                        <?php
                            if(have_rows('social_links')) : 
                                $social_title = get_field('social_title');
                                if($social_title) :
                                    echo '<h4 class="fw-bold mb-4">' . esc_html($social_title) . '</h4>';
                                endif;
                                echo '<div class="d-flex gap-3 social-links">';
                                    while(have_rows('social_links')) : the_row();
                                        $icon = get_sub_field('icon');
                                        $link = get_sub_field('link');
                                        if($icon && $link) :
                                            echo '<a href="' . esc_url($link) . '" target="_blank" class="btn btn-outline-success rounded-circle p-2"
                                                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i
                                                    class="fab fa-' . esc_attr($icon) . '"></i></a>';
                                        endif;
                                    endwhile;
                                echo '</div>';
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>