<?php

function site_scripts() {

    global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
    global $ibiza_api;


    // Register main stylesheet
    wp_enqueue_style('site-css', get_template_directory_uri() . '/assets/css/style.css', array(), '', 'all');

    // Register main swiper stylesheet
    wp_enqueue_style('swiper-css', get_template_directory_uri() . '/vendor/Swiper/dist/css/swiper.min.css', array(), '', 'all');

    // Register main swiper stylesheet
    wp_enqueue_style('fancy-css', get_template_directory_uri() . '/vendor/fancybox/source/jquery.fancybox.css', array(), '', 'all');

    //JS Start

    if (ENV == 'prod') {

        wp_enqueue_script('signalr-js', get_template_directory_uri() . '/vendor/signalr/jquery.signalR.min.js', array('jquery'), '', true);
        wp_enqueue_script('hub-js',  $ibiza_api::$end_points['signalr_hubs']  , array(), '', true);
        wp_enqueue_script('site-js', get_template_directory_uri() . '/assets/prod/main-dist.js', array('jquery'), '', true);
        
    } else {

        // Load What-Input files in footer
        wp_enqueue_script('what-input', get_template_directory_uri() . '/vendor/what-input/dist/what-input.min.js', array(), '', true);

        // Adding Foundation scripts file in the footer
        wp_enqueue_script('foundation-js', get_template_directory_uri() . '/assets/js/foundation.js', array('jquery'), '6.2', true);

        // Adding swiper scripts file in the footer
        wp_enqueue_script('swiper-js', get_template_directory_uri() . '/vendor/Swiper/dist/js/swiper.jquery.min.js', array('jquery'), '', true);

        //
        wp_enqueue_script('push-js', get_template_directory_uri() . '/vendor/push.js/push.js', array(), '', true);

        // Adding swiper scripts file in the footer
        wp_enqueue_script('fancybox-js', get_template_directory_uri() . '/vendor/fancybox/source/jquery.fancybox.js', array('jquery'), '', true);

        //
        wp_enqueue_script('enquire-js', get_template_directory_uri() . '/vendor/enquire/dist/enquire.min.js', array(), '', true);

        //
        wp_enqueue_script('signalr-js', get_template_directory_uri() . '/vendor/signalr/jquery.signalR.min.js', array('jquery'), '', true);

        //
        wp_enqueue_script('masonry-js', get_template_directory_uri() . '/vendor/masonry/dist/masonry.pkgd.js', array('jquery'), '', true);

        //
        wp_enqueue_script('bloodhound-js',   get_template_directory_uri() .'/vendor/typeahead.js/dist/typeahead.bundle.js' , array('jquery'), '', true);
        wp_enqueue_script('hogan-js',   get_template_directory_uri() .'/vendor/hogan.js/web/builds/3.0.2/hogan-3.0.2.common.js' , array('jquery'), '', true);

             
        
        //
        wp_enqueue_script('site-js', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '', true);

        
        
        // Comment reply script for threaded comments
        if (is_singular() AND comments_open() AND ( get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

add_action('wp_enqueue_scripts', 'site_scripts', 999);
