<?php get_header(); ?> 

<?php 
    $title = get_the_title();
    $id = get_the_ID();
    $topic = get_the_terms($id, 'topic');
    $excerpt = get_the_excerpt();
    $published_date = get_the_date('F j, Y');
    $author_id = get_post_field('post_author', get_the_ID());
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_bio = get_the_author_meta('description', $author_id);
    $author_picture = get_field('profile_picture', 'user_' . $author_id);
?>

<section class="article-header-section animate-fade-up">
    <div class="container-fluid px-lg-5">
        <div class="article-container">
            <span class="article-category">Photo Essay</span>
            <h1 class="article-title fw-bold title-hover-effect"><?php echo $title; ?></h1>
        </div>
    </div>
</section>

<article class="container-fluid px-lg-5 mb-5">
    <div class="article-container animate-fade-up delay-1">
        <div class="sticky-sidebar">
            <div class="sticky-sidebar-inner">
                <div class="sidebar-container">
                    <button class="sidebar-icon-btn" title="Share" aria-label="Share this essay">
                        <i class="fas fa-share-alt"></i>
                    </button>
                    <div class="social-rollout">
                        <span class="rollout-title">Share this essay</span>
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
                    <button class="sidebar-icon-btn" onclick="copyNewsLink()" title="Copy Link"
                        aria-label="Copy essay link">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
                <div class="sidebar-container">
                    <button class="sidebar-icon-btn" title="Republish" aria-label="Republish essay">
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
                <p class="mb-0 fw-bold">Photos &amp; Words by <?php echo esc_html($author_name); ?></p>
                <p class="mb-0 small text-muted"><?php echo esc_html($published_date); ?></p>
            </div>
        </div>
        <div class="article-body-content">
            <?php if ( have_rows('gallery') ) : ?>
                <div id="photoEssayInnerCarousel" class="carousel slide carousel-fade photo-essay-inner-carousel" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php while ( have_rows('gallery') ) : the_row(); ?>
                            <button type="button" data-bs-target="#photoEssayInnerCarousel" 
                            data-bs-slide-to="<?php echo get_row_index() - 1; ?>" 
                            class="<?php echo (get_row_index() == 1) ? 'active' : ''; ?>" 
                            aria-current="<?php echo (get_row_index() == 1) ? 'true' : 'false'; ?>" 
                            aria-label="Slide <?php echo get_row_index(); ?>"></button>
                        <?php endwhile; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php while ( have_rows('gallery') ) : the_row(); ?>
                            <?php 
                                $title = get_sub_field('title');
                                $caption = get_sub_field('caption');
                                $image = get_sub_field('image');
                            ?>
                            <div class="carousel-item <?php echo (get_row_index() == 1) ? 'active' : ''; ?>">
                                <?php if($image) : ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" class="d-block w-100" alt="<?php echo esc_attr($image['alt']); ?>">
                                <?php endif; ?>
                                <?php 
                                    if($title || $caption) :
                                        echo '<div class="custom-carousel-caption">';
                                            if($title) :
                                                echo '<h5>' . get_row_index() . ' / ' . esc_html($title) . '</h5>';
                                            endif;
                                            if($caption) :
                                                echo '<p>' . esc_html($caption) . '</p>';
                                            endif;
                                        echo '</div>';
                                    endif;
                                ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <button class="carousel-control-custom-prev" type="button"
                        data-bs-target="#photoEssayInnerCarousel" data-bs-slide="prev" aria-label="Previous image">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-control-custom-next" type="button"
                        data-bs-target="#photoEssayInnerCarousel" data-bs-slide="next" aria-label="Next image">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            <?php endif; ?>
            <div class="mt-5 body-content">
                <?php 
                    while ( have_posts() ) : the_post();
                        the_content();
                    endwhile; 
                ?>
            </div>
            <div class="share-section d-flex justify-content-between align-items-center mt-5">
                <div class="d-flex gap-3">
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
            </div>
        </div>
    </div>
</article>

<?php get_footer(); ?>