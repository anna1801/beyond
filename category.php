<?php get_header(); ?>

    <div class="category-header">
        <div class="container">
            <div class="d-flex align-items-center mb-4">
                <span class="category-icon"><i class="far fa-comment-dots"></i></span>
                <h1 class="h3 mb-0 fw-bold"><?php single_cat_title(); ?></h1>
            </div>
        </div>
    </div>

    <div class="container term-box">
        <?php if (have_posts()) : ?>

            <?php $post_count = 0; ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php
                    $post_title = get_the_title(); 
                    $post_permalink = get_permalink();
                    $topic = get_the_terms(get_the_ID(), 'topic');
                    $post_excerpt = get_the_excerpt();
                    if (has_post_thumbnail($post->ID)) {
                        $image = get_the_post_thumbnail_url($post->ID, 'full');
                    } else {
                        $image = get_template_directory_uri() . '/assets/images/placeholder.png';
                    }
                ?>

                <?php if ($post_count === 0) : ?>
                    <section class="mb-5">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-7">
                                <div class="overflow-hidden">
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($post_title); ?>" class="img-fluid w-100 img-hover-effect">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <?php if($topic): ?>
                                    <span class="text-uppercase small category_color ls-1 fw-bold mb-2 d-block"><?php echo esc_html($topic[0]->name); ?></span>
                                <?php endif; ?>
                                <h2 class="featured-story-title fw-bold mb-3 title-hover-effect">
                                    <?php echo esc_html($post_title); ?>
                                </h2>
                                <p class="article-excerpt">
                                    <?php echo esc_html(wp_trim_words($post_excerpt, 25, '...')); ?>
                                </p>
                                <a href="<?php echo esc_url($post_permalink); ?>" class="text-decoration-none fw-bold text-dark small">
                                    READ MORE <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </section>

                    <section class="section-padding pt-0">
                        <div class="row g-4" id="category-posts">
                
                <?php else : ?>
                
                            <div class="col-md-3">
                                <div class="card border-0">
                                    <div class="overflow-hidden mb-1">
                                        <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 img-hover-effect" alt="<?php echo esc_attr($post_title); ?>">
                                    </div>
                                    <?php if($topic): ?>
                                        <span class="text-uppercase small category_color ls-1 d-block mb-0 p-2"><?php echo esc_html($topic[0]->name); ?></span>
                                    <?php endif; ?>
                                    <h4 class="h6 fw-bold mb-0 p-2">
                                        <a href="<?php echo esc_url($post_permalink); ?>" class="text-dark text-decoration-none title-hover-effect">
                                            <?php echo esc_html($post_title); ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        
                <?php endif; ?>

                <?php $post_count++; ?>

            <?php endwhile; ?>

                        </div>
                    </section>

            <?php /* the_posts_pagination(); */ ?>

        <?php else : ?>
            <div class="section-padding mb-5 text-center">
                <p>No articles are available at the moment.</p>
            </div>
        <?php endif; ?>

        <?php
            $total_posts = $wp_query->found_posts;
            $initial_posts = 9;
        ?>

        <?php if ($total_posts > $initial_posts) : ?>

            <div class="text-center mb-5">
                <button
                    id="load-more-posts"
                    class="btn btn-outline-dark rounded-pill px-5 py-2 text-uppercase ls-1"
                    data-offset="9"
                    data-total="<?php echo esc_attr($total_posts); ?>"
                    data-term-id="<?php echo esc_attr(get_queried_object_id()); ?>"
                    data-taxonomy="<?php echo esc_attr(get_queried_object()->taxonomy ?? 'category'); ?>" >
                    Load More
                </button>
            </div>

        <?php endif; ?>

    </div>

<?php get_footer(); ?>