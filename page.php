<!-- WordPress default template for pages -->
<?php get_header(); ?>    

    <section class="container policy-container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <?php
                    $hero_title = get_field('hero_title');
                    if($hero_title) {
                        $title = $hero_title;
                    } else {
                        $title = get_the_title();
                    }
                ?>
                <h1 class="display-4 fw-bold mb-4"><?php echo esc_html($title); ?></h1>
                <div class="policy-content">
                    <?php
                        $hero_content = get_field('hero_content');
                        if($hero_content) :
                            echo '<p class="lead">' . esc_html($hero_content) . '</p>';
                        endif;
                    ?>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>