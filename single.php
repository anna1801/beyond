<!-- single post / article page -->
<?php get_header(); ?>  

<?php 
    $title = get_the_title();
    $id = get_the_ID();
    $topic = get_the_terms($id, 'topic');
    $excerpt = get_the_excerpt();
    $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $thumbnail_id = get_post_thumbnail_id();
    $caption = wp_get_attachment_caption($thumbnail_id);
    $published_date = get_the_date('F j, Y');
    $author_id = get_post_field('post_author', get_the_ID());
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_bio = get_the_author_meta('description', $author_id);
    $author_picture = get_field('profile_picture', 'user_' . $author_id);
?>

<section class="article-header-section">
    <div class="container-fluid px-lg-5">
        <div class="article-container animate-fade-up">
            <?php if($topic) : ?>
                <span class="article-category"><?php echo esc_html($topic[0]->name); ?></span>
            <?php endif; ?>
            <h1 class="article-title fw-bold title-hover-effect"><?php echo esc_html($title); ?></h1>
            <?php if($excerpt) : ?>
                <p class="lead-text"><?php echo esc_html($excerpt); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if(has_post_thumbnail()) : ?>
    <section class="mb-5">
        <div class="container-fluid p-0 animate-fade-up delay-1">
            <img src="<?php echo esc_url($post_thumbnail); ?>" alt="<?php echo esc_attr($title); ?>" class="img-fluid w-100" style="max-height: 700px; object-fit: cover;">
            <?php if($caption) : ?>
                <div class="container"> <p class="small text-muted mt-2"><?php echo esc_html($caption); ?></p> </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<article class="container-fluid px-lg-5 mb-5">
    <div class="article-container animate-fade-up delay-2">
        <div class="sticky-sidebar">
            <div class="sticky-sidebar-inner">
                <div class="sidebar-container">
                    <button class="sidebar-icon-btn" title="Share">
                        <i class="fas fa-share-alt"></i>
                    </button>
                    <div class="social-rollout">
                        <span class="rollout-title">Share this article</span>
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
                <div class="sidebar-container">
                    <button class="sidebar-icon-btn" title="Republish">
                        <i class="fab fa-creative-commons"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="article-meta mb-4">
            <?php if($author_picture) : ?>
                <img src="<?php echo esc_url($author_picture); ?>" alt="<?php echo esc_attr($author_name); ?>" class="rounded-circle author-img">
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri() . '/assets/images/author.svg'; ?>" alt="<?php echo esc_attr($author_name); ?>" class="rounded-circle author-img">
            <?php endif; ?>
            <div>
                <p class="mb-0 fw-bold"><?php echo esc_html($author_name); ?></p>
                <p class="mb-0 small text-muted"><?php echo esc_html($published_date); ?></p>
            </div>
        </div>
        <div class="article-body-content">

            <?php the_content(); ?>

            <div class="author-bio-card">
                <?php if($author_picture) : ?>
                    <img src="<?php echo esc_url($author_picture); ?>" alt="<?php echo esc_attr($author_name); ?>" class="author-avatar">
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/author.svg'; ?>" alt="<?php echo esc_attr($author_name); ?>" class="author-avatar">
                <?php endif; ?>
                <div>
                    <h5 class="fw-bold mb-2"><?php echo esc_html($author_name); ?></h5>
                    <p class="small mb-0 text-muted"><?php echo esc_html($author_bio); ?></p>
                </div>
            </div>
            <div class="share-section d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3">
                    <?php
                        $post_title = get_the_title();
                        $post_url   = get_permalink();
                    ?>
                    <a href="javascript:void(0)" onclick="shareNews('facebook')" class="text-dark"
                        title="Share on Facebook"><i class="fab fa-facebook-square"></i></a>
                    <a href="javascript:void(0)" onclick="shareNews('instagram')" class="text-dark"
                        title="Share on Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="javascript:void(0)" onclick="shareNews('x')" class="text-dark"
                        title="Share on X"><i class="fab fa-x-twitter"></i></a>
                    <a href="javascript:void(0)" onclick="shareNews('linkedin')" class="text-dark"
                        title="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="javascript:void(0)" onclick="shareNews('whatsapp')" class="text-dark"
                        title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="javascript:void(0)" onclick="shareNews('telegram')" class="text-dark"
                        title="Share on Telegram"><i class="fab fa-telegram"></i></a>
                    <a href="mailto:?subject=<?php echo $post_title; ?>&body=Check out this Article: <?php echo $post_url; ?>"
                        class="text-dark" title="Email this essay"><i class="fa fa-envelope"></i></a>
                    <a href="javascript:void(0)" onclick="copyNewsLink()" class="text-dark" title="Copy Link"><i
                            class="fas fa-link"></i></a>
                </div> 
                <?php 
                    $article_file = get_field('article_file');
                    if($article_file) :
                ?>
                    <a href="<?php echo esc_url($article_file); ?>" class="btn btn-outline-dark btn-sm rounded-pill px-3" target="_blank" rel="noopener noreferrer" download>Download PDF <i class="fas fa-file-pdf ms-1"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>

<section class="further-reading-section animate-fade-up delay-3">
    <div class="container">
        <h3 class="section-title-sm">Further reading</h3>
        <div class="row g-4">
            <?php
                $furtherargs = array(
                    'post_type' => 'post',
                    'posts_per_page' => 4,
                    'orderby' => 'rand',
                    'post_status' => 'publish',
                    'post__not_in'   => array(get_the_ID()),
                );
                $further_posts = new WP_Query($furtherargs);
                if($further_posts->have_posts()) :
                    while($further_posts->have_posts()) : $further_posts->the_post();
                        $post_id = get_the_ID();
                        $post_title = get_the_title();
                        $post_excerpt = get_the_excerpt();
                        $post_permalink = get_permalink();
                        $topic = get_the_terms($post_id, 'topic');
                        ?>
                        <div class="col-md-3">
                            <div class="card border-0 bg-transparent h-100">
                                <div class="overflow-hidden mb-3">
                                    <?php
                                        if(has_post_thumbnail()) {
                                            $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        } else {
                                            $post_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.png';
                                        }
                                    ?>
                                    <img src="<?php echo esc_url($post_thumbnail); ?>" class="img-fluid w-100 img-hover-effect" alt="<?php echo esc_attr($post_title); ?>">
                                </div>
                                <?php if($topic) : ?> 
                                    <span class="text-uppercase small category_color ls-1 d-block mb-1"><?php echo esc_html($topic[0]->name); ?></span>
                                <?php endif; ?>
                                <h4 class="h6 fw-bold mb-0"><a href="<?php echo esc_url($post_permalink); ?>" class="text-dark text-decoration-none title-hover-effect"><?php echo esc_attr($post_title); ?></a></h4>
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
        <button class="btn btn-outline-dark rounded-pill px-5 py-2 text-uppercase ls-1">Load More</button>
    </div>
</section>

<?php get_footer(); ?>