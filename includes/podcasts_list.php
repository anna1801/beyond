<?php
    function render_podcasts_list($posts) { 
        if($posts->have_posts()) :
            while($posts->have_posts()) : $posts->the_post();
                $post_id = get_the_ID();
                $post_title = get_the_title();
                $post_excerpt = get_the_excerpt();
                $post_permalink = get_permalink();
                $topic = get_the_terms($post_id, 'topic');
                ?>
                <div class="col-md-4 box-item">
                    <div class="card podcast-archive-card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="podcast-card-img-wrap position-relative overflow-hidden">
                            <?php
                                if(has_post_thumbnail()) {
                                    $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                } else {
                                    $post_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.png';
                                }
                            ?>
                            <img src="<?php echo esc_url($post_thumbnail); ?>" class="w-100 object-fit-cover" alt="<?php echo esc_attr($post_title); ?>">
                            <a href="<?php echo esc_url($post_permalink); ?>"
                                class="archive-play-btn-overlay d-flex align-items-center justify-content-center text-white text-decoration-none">
                            </a>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <?php if($topic) : ?>
                                <span class="text-uppercase small text-success fw-bold ls-1 mb-2 d-block"><?php echo esc_html($topic[0]->name); ?></span>
                            <?php endif; ?>
                            <h4 class="card-title fw-bold h5 mb-3">
                                <a href="<?php echo esc_url($post_permalink); ?>"
                                    class="text-dark text-decoration-none title-hover-effect"><?php echo esc_html($post_title); ?></a>
                            </h4>
                            <p class="card-text text-muted small mb-4 flex-grow-1">
                                <?php echo esc_html(wp_trim_words($post_excerpt, 15, '...')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        endif;
    }
?>