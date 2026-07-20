<?php
/**
 * Template Name: About Page
 */
get_header();
?>

    <?php 
        $hero_title = get_field('hero_title');
        $hero_content = get_field('hero_content');
        if($hero_title || $hero_content): ?>
            <section class="about-hero">
                <div class="container">
                    <div class="row items-center justify-content-center text-center">
                        <div class="col-lg-8">
                            <?php if($hero_title): ?>
                                <h1 class="display-3 fw-bold mb-4"><?php echo esc_html($hero_title); ?></h1>
                            <?php endif; ?>
                            <?php if($hero_content): ?>
                                <p class="mission-statement mb-0"><?php echo esc_html($hero_content); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php 
        endif; 
    ?>

    <?php if ( have_rows('features') ) : ?>
        <section class="about-section">
            <div class="container">
                <div class="row g-5">
                    <?php
                        while ( have_rows('features') ) : the_row(); 
                            $icon_svg = get_sub_field('icon_svg');
                            $title = get_sub_field('title');
                            $content = get_sub_field('content');
                            echo '<div class="col-md-4">';
                                echo '<div class="approach-icon">';
                                    if($icon_svg) :
                                        echo '<img src="' . esc_url($icon_svg['url']) . '" alt="' . esc_attr($icon_svg['alt']) . '">';
                                    endif;
                                echo '</div>';
                                if($title) :
                                    echo '<h3 class="fw-bold">' . esc_html($title) . '</h3>';
                                endif;
                                if($content) :
                                    echo '<p>' . esc_html($content) . '</p>';
                                endif;
                            echo '</div>';
                        endwhile; 
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
        $about_title = get_field('about_title');
        $about_content = get_field('about_content');
        $about_cta = get_field('about_cta');

        $funders_title = get_field('funders_title');
        $funders_content = get_field('funders_content');

        if($about_title || $about_content || $funders_title || $funders_content || have_rows('organizations')): 
            ?>
            <section class="about-section bg-light">
                <div class="container">
                    <div class="row align-items-center">
                        <?php if($about_title || $about_content) : ?>
                            <div class="col-lg-6">
                                <?php if($about_title) : ?>
                                    <h2 class="display-5 fw-bold mb-4"><?php echo esc_html($about_title); ?></h2>
                                <?php endif; ?>
                                <?php echo $about_content; ?>
                                <?php if($about_cta) : ?>
                                <div class="mt-4">
                                    <a href="<?php echo esc_url($about_cta['url']); ?>" target="<?php echo esc_attr($about_cta['target']); ?>" class="btn btn-news rounded-pill px-4"><?php echo esc_html($about_cta['title']); ?></a>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-lg-6 mt-5 mt-lg-0">
                            <div class="p-5 bg-white rounded-4 shadow-sm">
                                <?php if($funders_title) : ?>
                                    <h4 class="fw-bold mb-3"><?php echo esc_html($funders_title); ?></h4>
                                <?php endif; ?>
                                <?php if($funders_content) : ?>
                                    <p class="small text-muted mb-4"><?php echo esc_html($funders_content); ?></p>
                                <?php endif; ?>
                                <?php 
                                    if ( have_rows('organizations') ) : 
                                        echo '<ul class="list-unstyled mb-0">';
                                            while ( have_rows('organizations') ) : the_row(); 
                                                $name = get_sub_field('name');
                                                echo '<li class="mb-2"><i class="fas fa-check text-success me-2"></i>' . esc_html($name) . '</li>';
                                            endwhile; 
                                        echo '</ul>';
                                    endif; 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php 
        endif; 
    ?>

    <?php if ( have_rows('team') ) : ?>
        <section class="about-section">
            <div class="container">
                <?php
                    $team_title = get_field('team_title');
                    if($team_title) :
                        echo '<h2 class="display-5 fw-bold mb-5 text-center">' . esc_html($team_title) . '</h2>';
                    endif;
                ?>
                <div class="row">
                    <?php while ( have_rows('team') ) : the_row(); ?>
                        <?php
                            $name = get_sub_field('name');
                            $position = get_sub_field('position');
                        ?>
                        <div class="col-md-4 col-lg-3">
                            <div class="team-card text-center">
                                <div class="team-img"></div>
                                <?php 
                                    if($name) :
                                        echo '<h5 class="fw-bold mb-1">' . esc_html($name) . '</h5>';
                                    endif;
                                    if($position) :
                                        echo '<p class="small text-muted">' . esc_html($position) . '</p>';
                                    endif;
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php get_footer(); ?>