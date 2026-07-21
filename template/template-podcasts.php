<?php
/**
 * Template Name: Podcasts Archive Page
 */
get_header();
?>

<section class="category-header">
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <span class="category-icon text-success"><i class="fas fa-podcast"></i></span>
            <?php
                $hero_title = get_field('hero_title');
                if($hero_title) {
                    $title = $hero_title;
                } else {
                    $title = get_the_title();
                }
            ?>
            <h1 class="h3 mb-0 fw-bold no-ls"><?php echo esc_html($title); ?></h1>
        </div>
        <?php
            $hero_content = get_field('hero_content');
            if($hero_content) :
                echo '<p class="lead text-muted max-w-750">' . esc_html($hero_content) . '</p>';
            endif;
        ?>
        <?php the_content(); ?>
    </div>
</section>

<section class="section-padding pt-0">
    <div class="container">
        <h3 class="fw-bold mb-4 border-bottom pb-2">Recent Episodes</h3>
        <div id="podcast-list" class="row g-4" data-offset="6">
            <?php
                $args = array(
                    'post_type' => 'podcasts',
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_status' => 'publish',
                );
                $posts = new WP_Query($args);

                render_podcasts_list($posts);
            ?> 
        </div>
        <div class="text-center mt-5">
            <button id="load-more-podcasts" class="btn btn-outline-success rounded-pill px-5 py-2 text-uppercase ls-1" data-offset="6">Load More Episodes</button>
        </div>
    </div>
</section>

<?php get_footer(); ?>