<?php get_header(); ?> 

<?php 
    $title = get_the_title();
    $id = get_the_ID();
    $topic = get_the_terms($id, 'topic');
    $excerpt = get_the_excerpt();
?>

<section class="article-header-section">
    <div class="container-fluid px-lg-5">
        <div class="article-container animate-fade-up">
            <?php if($topic) : ?>
                <span class="article-category"><?php echo esc_html($topic[0]->name); ?></span>
            <?php endif; ?>
            <h1 class="article-title fw-bold title-hover-effect"><?php echo esc_html($title); ?></h1>
            <?php if($excerpt) : ?>
                <p class="lead"><?php echo esc_html($excerpt); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<article class="container-fluid px-lg-5 mb-5">
    <div class="article-container animate-fade-up delay-2">
        <div class="sticky-sidebar">
            <div class="sticky-sidebar-inner">
                <div class="sidebar-container">
                    <button class="sidebar-icon-btn" title="Share">
                        <i class="fas fa-share-alt"></i>
                    </button>
                    <div class="social-rollout">
                        <span class="rollout-title">Share this episode</span>
                        <div class="rollout-icons">
                            <a href="javascript:void(0)" onclick="shareNews('facebook')" title="Facebook"><i
                                    class="fab fa-facebook-square"></i></a>
                            <a href="javascript:void(0)" onclick="shareNews('instagram')" title="Instagram"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="javascript:void(0)" onclick="shareNews('linkedin')" title="LinkedIn"><i
                                    class="fab fa-linkedin"></i></a>
                            <a href="javascript:void(0)" onclick="shareNews('x')" title="X"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a href="javascript:void(0)" onclick="shareNews('whatsapp')" title="WhatsApp"><i
                                    class="fab fa-whatsapp"></i></a>
                            <a href="javascript:void(0)" onclick="shareNews('telegram')" title="Telegram"><i
                                    class="fab fa-telegram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-container">
                    <button class="sidebar-icon-btn" onclick="copyNewsLink()" title="Copy Link">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="article-body-content">
            <div class="lead">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</article>

<section class="further-reading-section animate-fade-up delay-3">
    <div class="container">
        <h3 class="section-title-sm">Related Episodes</h3>
        <div class="row g-4">
            <?php
                $args = array(
                    'post_type' => 'podcasts',
                    'posts_per_page' => 4,
                    'orderby' => 'rand',
                    'post_status' => 'publish',
                    'post__not_in'   => array(get_the_ID()),
                );
                $related_posts = new WP_Query($args);
                if($related_posts->have_posts()) :
                    while($related_posts->have_posts()) : $related_posts->the_post();
                        $post_id = get_the_ID();
                        $post_title = get_the_title();
                        $post_excerpt = get_the_excerpt();
                        $post_permalink = get_permalink();
                        $topic = get_the_terms($post_id, 'topic');
                        ?>
                        <div class="col-md-3">
                            <div class="card border-0 bg-transparent h-100">
                                <div class="overflow-hidden mb-3 position-relative rounded shadow-sm">
                                    <?php
                                        if(has_post_thumbnail()) {
                                            $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        } else {
                                            $post_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.png';
                                        }
                                    ?>
                                    <img src="<?php echo esc_url($post_thumbnail); ?>" class="img-fluid w-100 img-hover-effect" alt="<?php echo esc_attr($post_title); ?>">
                                </div>
                                <span class="text-uppercase small category_color ls-1 d-block mb-1"><?php echo esc_html($topic[0]->name); ?></span>
                                <h4 class="h6 fw-bold mb-0"><a href="<?php echo esc_url($post_permalink); ?>"
                                        class="text-dark text-decoration-none title-hover-effect"><?php echo esc_html($post_title); ?></a></h4>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
            ?> 
        </div>
    </div>
    <div class="text-center mt-5">
        <a href="podcast-category.html"
            class="btn btn-outline-dark rounded-pill px-5 py-2 text-uppercase ls-1">All Episodes</a>
    </div>
</section>

<?php get_footer(); ?>