<?php
/**
 * Front Page Template
 */

get_header();
?>

    <?php
        $hero_banner = get_field('hero_banner');
        if ($hero_banner) :
            $total_slides = count($hero_banner);
            ?>
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators mb-4 ms-4 justify-content-start">
                    <?php foreach ($hero_banner as $index => $post) : ?>
                        <button
                            type="button"
                            data-bs-target="#heroCarousel"
                            data-bs-slide-to="<?php echo esc_attr($index); ?>"
                            class="<?php echo $index === 0 ? 'active' : ''; ?>"
                            <?php echo $index === 0 ? 'aria-current="true"' : ''; ?>
                            aria-label="Slide <?php echo esc_attr($index + 1); ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner">
                    <?php foreach ($hero_banner as $post) :
                        setup_postdata($post);
                        $title = $post->post_title;
                        $content = $post->post_excerpt;
                        $topic = get_the_terms($post->ID, 'topic');
                        $author = get_the_author_meta('display_name', $post->post_author);
                        $link = get_permalink($post->ID);
                        $tags = get_the_terms($post->ID, 'post_tag');
                        if (has_post_thumbnail($post->ID)) {
                            $image = get_the_post_thumbnail_url($post->ID, 'full');
                        } else {
                            $image = get_template_directory_uri() . '/assets/images/placeholder.png';
                        }
                        ?>
                        <div class="carousel-item <?php echo ($post === reset($hero_banner)) ? 'active' : ''; ?>">
                            <div class="container-fluid p-0">
                                <div class="row g-0">
                                    <div class="col-lg-6 order-2 order-lg-1 bg-light d-flex align-items-center">
                                        <div class="banner-content p-5 mx-lg-5">
                                            <?php if ($topic) : ?>
                                                <span class="text-uppercase category_color ls-2 mb-3 d-block small"><?php echo esc_html($topic[0]->name); ?></span>
                                            <?php endif; ?>
                                            <h1 class="display-4 fw-bold mb-4 text-dark title-hover-effect"><?php echo esc_html($title); ?></h1>
                                            <?php if ($content) : ?>
                                                <p class="lead mb-4 text-muted"><?php echo esc_html($content); ?></p>
                                            <?php endif; ?>
                                            <p class="fw-bold small mb-0 author"><?php echo esc_html($author); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 order-1 order-lg-2">
                                        <div class="banner-image">
                                            <img src="<?php echo esc_url($image); ?>" class="d-block w-100 h-100 object-fit-cover" alt="<?php echo esc_attr($title); ?>" />
                                            <?php if ($tags) : ?>
                                                <span class="badge bg-dark rounded-0 position-absolute bottom-0 start-0 m-0 px-3 py-2 text-uppercase small ls-1">
                                                    <?php echo esc_html($tags[0]->name); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <?php
            wp_reset_postdata();
        endif;
    ?>

    <?php
        $show_hide_latest_featured_articles = get_field('show_hide_latest_featured_articles');
        if ($show_hide_latest_featured_articles) :
    ?>
        <section class="section-padding background-light-green">
            <div class="container">
                <div class="row">
                    <?php 
                        $latest_article = get_field('latest_article');
                        if($latest_article) :
                            $title = $latest_article['title'];
                            $articles_number = $latest_article['articles_number'];
                            if($articles_number > 0) :
                                if($articles_number >= 6) {
                                    $first_box = 6;
                                    $second_box = $articles_number - $first_box;
                                } else {
                                    $first_box = $articles_number;
                                    $second_box = 0;
                                } 
                                ?>
                                <div class="col-lg-8">
                                    <?php
                                        if($title) :
                                            echo '<h3 class="fw-bold mb-4 title-hover-effect">' . esc_html($title) . '</h3>';
                                        endif;
                                    ?>
                                    <div class="row g-4 mb-5">
                                        <?php
                                            $latestargs = array(
                                                'post_type' => 'post',
                                                'posts_per_page' => $first_box,
                                                'orderby' => 'date',
                                                'order' => 'DESC',
                                                'post_status' => 'publish',
                                            );
                                            $latest_posts = new WP_Query($latestargs);
                                            if($latest_posts->have_posts()) :
                                                while($latest_posts->have_posts()) : $latest_posts->the_post();
                                                    $post_id = get_the_ID();
                                                    $post_title = get_the_title();
                                                    $post_excerpt = get_the_excerpt();
                                                    $post_permalink = get_permalink();
                                                    $topic = get_the_terms($post_id, 'topic');
                                                    ?>
                                                    <div class="col-md-4">
                                                        <div class="card border-0 h-100">
                                                            <div class="overflow-hidden mb-3">
                                                                <?php
                                                                    if(has_post_thumbnail()) {
                                                                        $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                                                    } else {
                                                                        $post_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.png';
                                                                    }
                                                                ?>
                                                                <img src="<?php echo esc_url($post_thumbnail); ?>" class="box-image img-fluid w-100 img-hover-effect" alt="<?php echo esc_attr($post_title); ?>" loading="lazy">
                                                            </div>
                                                            <div class="card-body px-3 py-0">
                                                                <?php if($topic) : ?>
                                                                    <span class="text-uppercase small category_color mb-2 d-block ls-1"><?php echo esc_html($topic[0]->name); ?></span>
                                                                <?php endif; ?>
                                                                <h4 class="card-title fw-bold h5 mb-3">
                                                                    <a href="<?php echo esc_url($post_permalink); ?>" class="text-dark text-decoration-none title-hover-effect"><?php echo esc_html($post_title); ?></a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                endwhile;
                                                wp_reset_postdata();
                                            endif;
                                        ?>  
                                    </div>
                                    <?php if($second_box > 0) : ?>
                                        <div class="row g-4">
                                            <?php
                                                $featuredargs = array(
                                                    'post_type' => 'post',
                                                    'offset' => $first_box,
                                                    'posts_per_page' => $second_box,
                                                    'orderby' => 'date',
                                                    'order' => 'DESC',
                                                    'post_status' => 'publish',
                                                );
                                                $featured_posts = new WP_Query($featuredargs);
                                                if ($featured_posts->have_posts()) :
                                                    while ($featured_posts->have_posts()) : $featured_posts->the_post();
                                                        $post_permalink = get_permalink();
                                                        $post_title = get_the_title();
                                                        $post_excerpt = get_the_excerpt();
                                                        $topic = get_the_terms(get_the_ID(), 'topic');
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="d-flex gap-3 align-items-start">
                                                                <?php
                                                                    if(has_post_thumbnail()) {
                                                                        $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                                                    } else {
                                                                        $post_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.png';
                                                                    }
                                                                ?>
                                                                <img src="<?php echo esc_url($post_thumbnail); ?>" class="img-fluid img-hover-effect"
                                                                    style="width: 100px; height: 70px; object-fit: cover;" alt="<?php echo esc_attr($post_title); ?>">
                                                                <div>
                                                                    <?php if($topic) : ?>
                                                                        <span class="text-uppercase small category_color mb-1 d-block" style="font-size: 0.7rem;"><?php echo esc_html($topic[0]->name); ?></span>
                                                                    <?php endif; ?>
                                                                    <h4 class="fw-bold mb-0">
                                                                        <a href="<?php echo esc_url($post_permalink); ?>" class="text-dark text-decoration-none title-hover-effect">
                                                                            <?php echo esc_html($post_title); ?>
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    endwhile;
                                                    wp_reset_postdata();
                                                endif;
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php 
                            endif;
                        endif; 
                    ?>
                    <div class="col-lg-4 mt-5 mt-lg-0">
                        <?php
                            $featured_article = get_field('featured_article');
                            if($featured_article) :
                                $title = $featured_article['title'];
                                $choose_articles = $featured_article['choose_articles'];
                                if($choose_articles) :
                                    ?>
                                    <h3 class="fw-bold mb-4 title-hover-effect"><?php echo esc_html($title); ?></h3>
                                    <div class="mb-5">
                                        <ul class="list-unstyled">
                                            <?php foreach ($choose_articles as $index => $post) :
                                                setup_postdata($post);
                                                $post_title = get_the_title();
                                                $post_permalink = get_permalink();
                                                ?>
                                                <li class="d-flex gap-3 mb-3 border-bottom pb-3">
                                                    <span class="must-read-number"><?php echo esc_html($index + 1); ?></span>
                                                    <a href="<?php echo esc_url($post_permalink); ?>" target="_self" 
                                                        class="text-dark text-decoration-none fw-bold pt-1 title-hover-effect"><?php echo esc_html($post_title); ?></a>
                                                </li>
                                            <?php endforeach; wp_reset_postdata(); ?>
                                        </ul>
                                    </div>
                                    <?php
                                endif;
                            endif;
                        ?>
                        <?php
                            $newsletter_box = get_field('newsletter_box');
                            if($newsletter_box) :
                                $icon = $newsletter_box['icon'];
                                $content = $newsletter_box['content'];
                                $cta = $newsletter_box['cta'];
                                if ( $icon || $content || $cta ) :
                                    ?>
                                    <div class="newsletter-box-sidebar p-4 bg-light">
                                        <?php if($icon) : ?>
                                            <div class="newsletter-circle-logo">
                                                <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                                            </div>
                                        <?php endif; ?>
                                        <?php if($content) : ?>
                                            <h5 class="fw-bold mb-3 title-hover-effect"><?php echo esc_html($content); ?></h5>
                                        <?php endif; ?>
                                        <?php if($cta) : ?>
                                            <a href="<?php echo esc_url($cta['url']); ?>" target="<?php echo esc_attr($cta['target']); ?>" class="btn btn-news rounded-pill px-4 py-2 fw-bold text-uppercase small">
                                                <?php echo esc_html($cta['title']); ?> <i class="far fa-envelope ms-2"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <?php 
                                endif; 
                            endif; 
                        ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
        $article_carousel_title = get_field('article_carousel_title');
        $article_carousel_number = get_field('article_carousel_number');
        $article_carousel_category = get_field('article_carousel_category'); 
        if ($article_carousel_category) :
            ?>
            <section class="our-news-digest mb-5">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                        <?php 
                            if($article_carousel_title) :
                                echo'<div>
                                        <span class="our-digest-icon text-danger"><i class="far fa-comments"
                                                style="color: var(--color-accent-red);"></i></span>
                                        <h4 class="our-digest-title h5 mb-0">' . esc_html($article_carousel_title) . '</h4>
                                    </div>';
                            endif;
                        ?>
                        <div class="d-flex gap-2">
                            <button class="our-scroll-btn" id="ourScrollLeft"><i class="fas fa-chevron-left"></i></button>
                            <button class="our-scroll-btn" id="ourScrollRight"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="our-digest-scroll-container">
                        <div class="our-digest-scroll" id="ourDigestScroll">
                            <?php
                                $number = $article_carousel_number ? $article_carousel_number : 6;
                                $digestargs = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $number,
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                    'post_status' => 'publish',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'category',
                                            'field'    => 'term_id',
                                            'terms'    => $article_carousel_category,
                                        ),
                                    ),
                                ); 
                                $digest_posts = new WP_Query($digestargs); 
                                if ($digest_posts->have_posts()) :
                                    while ($digest_posts->have_posts()) : $digest_posts->the_post();
                                        $post_title = get_the_title(); 
                                        $post_permalink = get_permalink();
                                        $topic = get_the_terms(get_the_ID(), 'topic');
                                        ?>
                                        <div class="our-digest-card">
                                            <span class="our-card-category"><?php echo esc_html($topic[0]->name); ?></span>
                                            <h4 class="our-card-title"><a href="<?php echo esc_url($post_permalink); ?>"
                                                    class="text-decoration-none text-dark title-hover-effect"><?php echo esc_html($post_title); ?></a></h4>
                                            <span class="our-card-date"><?php echo get_the_date(); ?></span>
                                        </div>
                                        <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                            ?>
                        </div>
                        <div class="our-digest-fade"></div>
                    </div>
                </div>
            </section>
            <?php
        endif;
    ?>

    <?php
        $article_topic_title = get_field('article_topic_title');
        $article_topic_number = get_field('article_topic_number');
        if($article_topic_number) {
            $article_topic_number = $article_topic_number;
        } else {
            $article_topic_number = 5;
        }
        $article_topic = get_field('article_topic'); 
        if ($article_topic) :
            ?>
                <section class="section-padding pt-0">
                    <div class="container">
                        <?php
                            if($article_topic_title) :
                                echo '<div class="mb-4"><h3 class="fw-bold title-hover-effect">' . esc_html($article_topic_title) . '</h3></div>';
                            endif;
                        ?>
                        <div class="row mb-5">
                            <?php 
                                $topicaargs = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => 1,
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                    'post_status' => 'publish',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'topic',
                                            'field'    => 'term_id',
                                            'terms'    => $article_topic,
                                        ),
                                    ),
                                ); 
                                $topic_posts = new WP_Query($topicaargs); 
                                if ($topic_posts->have_posts()) :
                                    while ($topic_posts->have_posts()) : $topic_posts->the_post();
                                        $post_title = get_the_title();
                                        $post_permalink = get_permalink();
                                        $post_excerpt = get_the_excerpt();
                                        $topic = get_the_terms(get_the_ID(), 'topic');
                                        if (has_post_thumbnail($post->ID)) {
                                            $image = get_the_post_thumbnail_url($post->ID, 'full');
                                        } else {
                                            $image = get_template_directory_uri() . '/assets/images/placeholder.png';
                                        }
                                        ?>
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 rounded-1 img-hover-effect"
                                                alt="<?php echo esc_attr($post_title); ?>" loading="lazy">
                                        </div>
                                        <div class="col-lg-6 d-flex flex-column justify-content-center">
                                            <?php if($topic) : ?>
                                                <div class="mb-2"><span class="text-uppercase small category_color"><?php echo esc_html($topic[0]->name); ?></span></div>
                                            <?php endif; ?>
                                            <h2 class="display-6 fw-bold mb-3"><a href="<?php echo esc_url($post_permalink); ?>"
                                                    class="text-dark text-decoration-none title-hover-effect"><?php echo esc_html($post_title); ?></a></h2>
                                            <p class="text-muted mb-3"><?php echo esc_html($post_excerpt); ?></p>
                                        </div>
                                        <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                            ?>
                        </div>
                        <?php  if($article_topic_number > 1) : ?>
                            <div class="row g-4">
                                <?php 
                                    $topicotherargs = array(
                                        'post_type' => 'post',
                                        'posts_per_page' => $article_topic_number - 1,
                                        'offset' => 1,
                                        'orderby' => 'date',
                                        'order' => 'DESC',
                                        'post_status' => 'publish',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'topic',
                                                'field'    => 'term_id',
                                                'terms'    => $article_topic,
                                            ),
                                        ),
                                    ); 
                                    $topic_other_posts = new WP_Query($topicotherargs);
                                    if ($topic_other_posts->have_posts()) :
                                        while ($topic_other_posts->have_posts()) : $topic_other_posts->the_post();
                                            $post_title = get_the_title();
                                            $post_permalink = get_permalink();
                                            $post_excerpt = get_the_excerpt();
                                            $topic = get_the_terms(get_the_ID(), 'topic');
                                            if (has_post_thumbnail(get_the_ID())) {
                                                $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                            } else {
                                                $image = get_template_directory_uri() . '/assets/images/placeholder.png';
                                            }
                                            ?>                                
                                            <div class="col-lg-3 col-md-6">
                                                <div class="mb-3">
                                                    <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 rounded-1 img-hover-effect" alt="<?php echo esc_attr($post_title); ?>">
                                                </div>
                                                <?php if($topic) : ?>
                                                    <span class="text-uppercase small d-block mb-2 category_color"><?php echo esc_html($topic[0]->name); ?></span>
                                                <?php endif; ?>
                                                <h4 class="h5 fw-bold mb-2"><a href="<?php echo esc_url($post_permalink); ?>" class="text-dark text-decoration-none title-hover-effect"><?php echo esc_html($post_title); ?></a></h4>
                                                <p class="text-muted"><?php echo esc_html($post_excerpt); ?></p>
                                            </div>
                                            <?php
                                        endwhile;
                                        wp_reset_postdata();
                                    endif;
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php
        endif;
    ?>

    <?php
        $photo_essay_show_hide = get_field('photo_essay_show_hide');
        if ($photo_essay_show_hide) :
            $photo_essay_title = get_field('photo_essay_title');
            $photo_essay_number = get_field('photo_essay_number');
            if($photo_essay_number) {
                $photo_essay_number = $photo_essay_number;
            } else {
                $photo_essay_number = 5;
            }
            ?>
            <section class="section-padding mt-5 mb-5 photo-essay-section">
                <div class="container">
                    <?php if($photo_essay_title) : ?>
                        <div class="mb-4">
                            <h3 class="fw-bold title-hover-effect"><?php echo esc_html($photo_essay_title); ?></h3>
                        </div>
                    <?php endif; ?>
                    <div class="row g-4 mb-5 flex-nowrap-mobile" id="photoEssayTabs">
                        <?php 
                            $photonavargs = array(
                                'post_type' => 'photo-essays',
                                'posts_per_page' => $photo_essay_number,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'post_status' => 'publish',
                            ); 
                            $photonav_posts = new WP_Query($photonavargs);
                            if ($photonav_posts->have_posts()) :
                                while ($photonav_posts->have_posts()) : $photonav_posts->the_post();
                                    $post_title = get_the_title();
                                    $post_excerpt = get_the_excerpt();
                                    ?>
                                    <div class="col-lg col-md-6">
                                        <div class="strategy-tab <?php echo esc_attr($photonav_posts->current_post === 0 ? 'active' : ''); ?>" data-slide="<?php echo esc_attr($photonav_posts->current_post); ?>">
                                            <h4><?php echo esc_attr($post_title); ?></h4>
                                            <p><?php echo esc_html(wp_trim_words($post_excerpt, 9, '...')); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                        ?>
                    </div>
                    <div class="photo-essay-container position-relative">
                        <button class="essay-arrow essay-prev" id="essayPrev"><i class="fas fa-chevron-left"></i></button>
                        <button class="essay-arrow essay-next" id="essayNext"><i class="fas fa-chevron-right"></i></button>
                        <div class="photo-essay-scroll d-flex" id="photoEssayScroll">
                            <?php 
                                $photoargs = array(
                                    'post_type' => 'photo-essays',
                                    'posts_per_page' => $photo_essay_number,
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                    'post_status' => 'publish',
                                ); 
                                $photo_posts = new WP_Query($photoargs);
                                if ($photo_posts->have_posts()) :
                                    while ($photo_posts->have_posts()) : $photo_posts->the_post();
                                        $post_title = get_the_title();
                                        $post_content = wp_trim_words(get_the_content(), 10, '...');
                                        if (has_post_thumbnail(get_the_ID())) {
                                            $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        } else {
                                            $image = get_template_directory_uri() . '/assets/images/placeholder.png';
                                        }
                                        ?>
                                        <div class="photo-essay-slide">
                                            <div class="strategy-content-box p-0 overflow-hidden h-100">
                                                <div class="row g-0 align-items-center h-100">
                                                    <div class="col-lg-7 position-relative h-100">
                                                        <img src="<?php echo esc_url($image); ?>"
                                                            class="img-fluid h-100 object-fit-cover img-hover-effect"
                                                            alt="<?php echo esc_attr($post_title); ?>" loading="lazy">
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="p-5">
                                                            <h3 class="fw-bold mb-3 title-hover-effect"><?php echo esc_html($post_title); ?></h3>
                                                            <p class="mb-4 lead"><?php echo $post_content; ?></p>
                                                            <a href="<?php the_permalink(); ?>" class="read-story-link">Read The Story <i
                                                                    class="fas fa-chevron-right ms-1 small"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php 
        endif; 
    ?>

    <?php
        $random_show_hide = get_field('random_show_hide');
        if ($random_show_hide) :
            $random_cta = get_field('random_cta'); 
            $random_number = get_field('random_number');
            if($random_number) {
                $random_number = $random_number;
            } else {
                $random_number = 12;
            }
            ?>
            <section class="section-padding">
                <div class="container">
                    <div class="row">
                        <?php
                            $latestargs = array(
                                'post_type' => 'post',
                                'posts_per_page' => $random_number,
                                'orderby' => 'rand',
                                'post_status' => 'publish',
                            );
                            $latest_posts = new WP_Query($latestargs);
                            if($latest_posts->have_posts()) :
                                while($latest_posts->have_posts()) : $latest_posts->the_post();
                                    $post_id = get_the_ID();
                                    $post_title = get_the_title();
                                    $post_excerpt = get_the_excerpt();
                                    $post_permalink = get_permalink();
                                    $topic = get_the_terms($post_id, 'topic');
                                    ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                        <div class="card border-0">
                                            <?php
                                                if(has_post_thumbnail()) {
                                                    $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                                } else {
                                                    $post_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.png';
                                                }
                                            ?>
                                            <div class="article-card mb-3">
                                                <img src="<?php echo esc_url($post_thumbnail); ?>" class="img-hover-effect box-image" alt="<?php echo esc_attr($post_title); ?>" loading="lazy">
                                            </div>
                                            <div class="card-body px-3 py-0">
                                                <?php if($topic) : ?>
                                                    <span class="text-uppercase small category_color mb-2 d-block ls-1"><?php echo esc_html($topic[0]->name); ?></span>
                                                <?php endif; ?>
                                                <h4 class="card-title fw-bold h5 mb-3">
                                                    <a href="<?php echo esc_url($post_permalink); ?>" class="text-dark text-decoration-none title-hover-effect"><?php echo esc_html($post_title); ?></a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                        ?>  
                        <?php if($random_cta) : ?>
                            <div class="text-center">
                                <a href="<?php echo esc_url($random_cta['url']); ?>" target="<?php echo esc_attr($random_cta['target']); ?>"  class="btn btn-outline-dark rounded-pill px-4 py-2 mt-5" style="font-size: 0.9rem; letter-spacing: 1px;">
                                    <?php echo esc_html($random_cta['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <?php
        endif;
    ?>

    <?php 
        $podcast_show_hide = get_field('podcast_show_hide');
        if ($podcast_show_hide) :
            $podcast_carousel_title = get_field('podcast_carousel_title');
            $podcast_number = get_field('podcast_number');
            if($podcast_number) {
                $podcast_number = $podcast_number;
            } else {
                $podcast_number = 6;
            }
            ?>
            <section class="our-news-digest mb-5">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                        <?php 
                            if($podcast_carousel_title) :
                                echo'<div class="d-flex align-items-center gap-2">
                                        <span class="our-digest-icon text-muted"><i class="fas fa-podcast"></i></span>
                                        <h4 class="our-digest-title h5 mb-0 fw-bold">' . esc_html($podcast_carousel_title) . '</h4>
                                    </div>';
                            endif;
                        ?>
                        <div class="d-flex gap-2">
                            <button class="our-scroll-btn" id="podcastScrollLeft"><i class="fas fa-chevron-left"></i></button>
                            <button class="our-scroll-btn" id="podcastScrollRight"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="our-digest-scroll-container">
                        <div class="our-digest-scroll" id="podcastScroll">
                            <?php 
                                $podcastsargs = array(
                                    'post_type' => 'podcasts',
                                    'posts_per_page' => $podcast_number,
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                    'post_status' => 'publish',
                                ); 
                                $podcast_posts = new WP_Query($podcastsargs);
                                if ($podcast_posts->have_posts()) :
                                    while ($podcast_posts->have_posts()) : $podcast_posts->the_post();
                                        $post_title = get_the_title();
                                        $topic = get_the_terms(get_the_ID(), 'topic');
                                        if (has_post_thumbnail(get_the_ID())) {
                                            $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        } else {
                                            $image = get_template_directory_uri() . '/assets/images/icon.png';
                                        }
                                        ?>
                                        <div class="podcast-card">
                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($post_title); ?>" class="podcast-img img-hover-effect" loading="lazy">
                                            <div class="podcast-content">
                                                <?php if($topic) : ?>
                                                    <span class="our-card-category"><?php echo esc_html($topic[0]->name); ?></span>
                                                <?php endif; ?>
                                                <h4 class="our-card-title">
                                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark title-hover-effect">
                                                        <?php echo esc_html($post_title); ?>
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                        <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                            ?>  
                        </div>
                        <!-- Fade Overlay -->
                        <div class="our-digest-fade"></div>
                    </div>
                </div>
            </section>
            <?php
        endif;
    ?>

    <?php 
        $choose_topics = get_field('choose_topics');
        if ($choose_topics) :
            $topics_title = get_field('topics_title');
            $topics_subtitle = get_field('topics_subtitle');
            ?>
            <section class="section-padding bg-light-v2">
                <div class="container">
                    <div class="text-center mb-5">
                        <?php if($topics_title) : ?>
                            <h2 class="fw-bold display-5"><?php echo esc_html($topics_title); ?></h2>
                            <div class="mx-auto" style="width: 60px; height: 4px; background: var(--color-primary); border-radius: 10px; margin-bottom: 20px;"></div>
                        <?php endif; ?>
                        <?php if($topics_subtitle) : ?>
                            <p class="text-muted lead"><?php echo esc_html($topics_subtitle); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="row g-4 justify-content-center">
                        <?php 
                            foreach($choose_topics as $topic) :
                                $topic_name = $topic->name;
                                $topic_link = get_term_link($topic);
                                $topic_icon = get_field('icon', 'topic_' . $topic->term_id);
                                ?>
                                <div class="col-6 col-md-4 col-lg-3">
                                    <a href="<?php echo esc_url($topic_link); ?>" class="topic-card-v2 card-green">
                                        <div class="spotlight-glow"></div>
                                        <?php if($topic_icon) : ?>
                                            <img src="<?php echo esc_url($topic_icon['url']); ?>" alt="<?php echo esc_attr($topic_name); ?>" class="topic-icon-v2">
                                        <?php endif; ?>
                                        <h6 class="topic-title-v2"><?php echo esc_html($topic_name); ?></h6>
                                    </a>
                                </div>
                                <?php
                            endforeach;
                        ?>
                    </div>
                </div>
            </section>
            <?php
        endif;
    ?>

<?php get_footer(); ?>