<!-- WordPress default template for pages -->
<?php get_header(); ?> 

    <?php
        if ( is_front_page() ) {
            //get_template_part('template/hero-front-page');  // Hero Banner - Front page
        } else {
            //get_template_part('template/hero-inner-page');  // Hero Banner - Inner page
        }
    ?>

    <?php 
        //if( have_rows('template_blocks') ):
           // while( have_rows('template_blocks') ): the_row(); 
               // get_template_part('template/flexible/' . get_row_layout());
           // endwhile; 
       // endif; 
    ?>

    <?php// get_template_part('template/cta_consultation'); ?>

<?php get_footer(); ?>