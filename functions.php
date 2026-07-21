<?php
if ( ! defined( '_S_VERSION' ) ) {
  define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'theme_setup' ) ) :
  function theme_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
  }
endif;
add_action( 'after_setup_theme', 'theme_setup' );

/* Register menu */
  function register_my_menu() {
    register_nav_menu('header-menu',__( 'Header Menu' ));
    register_nav_menu('header-top-menu',__( 'Header Top Menu' ));
    register_nav_menu('footer-menu',__( 'Footer menu' ));
    register_nav_menu('footer-bottom-menu',__( 'Footer Bottom menu' ));
  }
  add_action( 'init', 'register_my_menu' );

//Disable Gutenburg Editor
  add_filter('use_block_editor_for_post', '__return_false', 10);

// support SVG
  function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
  add_filter('upload_mimes', 'cc_mime_types');

  function cc_check_filetype_and_ext($data, $file, $filename, $mimes) {
      $filetype = wp_check_filetype($filename, $mimes);
      if ($filetype['ext'] === 'svg') {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
      }
      return $data;
  }
  add_filter(
      'wp_check_filetype_and_ext',
      'cc_check_filetype_and_ext',
      10,
      4
  );

/* Convert to WEBP URL*/
  function webpUrl($url) {
    if($url && strpos($url, 'uploads') !== false){
      $url = str_replace("uploads","uploads-webpc/uploads", $url);
      $url = $url . '.webp';
    }
    return $url;
  }

/* Enqueue scripts and styles.*/
function theme_scripts() {
  // css
    wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_enqueue_style( 'bootstrap-css',get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '5.3.3' );
    wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css', array(), '1.0' );
    wp_enqueue_style( 'style-css', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0' );
    wp_enqueue_style( 'custom-css', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0' );
    wp_style_add_data( 'theme-style', 'rtl', 'replace' );
  // js
    wp_enqueue_script( 'bootstrap-js',get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js',array('jquery'), '5.3.3', true );
    wp_enqueue_script( 'fancybox-js',get_template_directory_uri() . '/assets/js/jquery.fancybox.js',array('jquery'), _S_VERSION, true );
    wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'video-js', get_template_directory_uri() . '/assets/js/video-pagination.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/assets/js/custom.js', array(), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

// Disable automatic <p> and <br> tags in Contact Form 7 forms
add_filter('wpcf7_autop_or_not', '__return_false');

// custom functions
  require get_template_directory() . '/includes/custom.php';
  require get_template_directory() . '/includes/admin.php';
  require get_template_directory() . '/includes/nav_walker.php';
  require get_template_directory() . '/includes/related_reading.php'; 
  require get_template_directory() . '/includes/podcasts_list.php'; 

// Ajax 
  require get_template_directory() . '/ajax/podcasts-ajax.php';  

?>