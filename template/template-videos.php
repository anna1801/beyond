<?php
/**
 * Template Name: Videos Page
 */
get_header();
?>

    <?php 
        $hero_title = get_field('hero_title');
        $hero_content = get_field('hero_content');
        if($hero_title || $hero_content): ?>
            <section class="video-page-hero text-center">
                <div class="container">
                    <?php if($hero_title): ?>
                        <h1 class="display-4 fw-bold mb-3"><?php echo esc_html($hero_title); ?></h1>
                    <?php endif; ?>
                    <?php if($hero_content): ?>
                        <p class="lead text-muted mx-auto" style="max-width: 700px;"><?php echo esc_html($hero_content); ?></p>
                    <?php endif; ?>
                </div>
            </section>
            <?php 
        endif; 
    ?>

    <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
            ?>
            <section class="secetion-padding">
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </section>
            <?php
            endwhile;
        endif;
    ?>

    <?php if ( have_rows('videos') ) : ?>
        <section class="video-gallery-section">
            <div class="container">
                <div class="row" id="videoGrid">
                    <?php 
                        while ( have_rows('videos') ) : the_row(); 
                            $caption = get_sub_field('caption');
                            $youtube_video_id = get_sub_field('youtube_video_id');
                            $featured_image = get_sub_field('featured_image');
                            if($youtube_video_id) :
                                ?> 
                                <div class="col-lg-4 col-md-6">
                                    <div class="video-card">
                                        <div class="image-box">
                                            <figure class="image"> 
                                                <a href="https://www.youtube.com/watch?v=<?php echo esc_attr($youtube_video_id); ?>" data-fancybox="video-gallery"
                                                    class="lightbox-image text-decoration-none"><i class="fas fa-play"></i></a>
                                                <?php 

                                                    if($featured_image) {
                                                        echo '<img src="' . esc_url($featured_image['url']) . '" alt="' . esc_attr($featured_image['alt']) . '">';

                                                    } else {
                                                        echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png' . '" alt="Placeholder">';
                                                    }
                                                ?>
                                                <div class="play-overlay"><i class="fas fa-play"></i></div>
                                            </figure>
                                        </div>
                                        <?php if($caption) : ?>
                                            <div class="lower-content">
                                                <h4><a href="https://www.youtube.com/watch?v=<?php echo esc_attr($youtube_video_id); ?>" data-fancybox="video-gallery"
                                                        class="lightbox-image"><?php echo esc_html($caption); ?></a>
                                                </h4>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>  
                                <?php 
                            endif;
                        endwhile; 
                    ?>
                </div>
                <nav aria-label="Video pagination" class="mt-5">
                    <ul class="pagination justify-content-center" id="paginationNav"></ul>
                </nav>
            </div>
        </section>
    <?php endif; ?>

<?php get_footer(); ?>