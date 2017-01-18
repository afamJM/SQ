<?php

// Register menus
register_nav_menus(
        array(
            'main-nav' => __('The Main Menu', 'jointswp'), // Main nav in header
            'footer-links-1' => __('Footer Links 1', 'jointswp'), // Secondary nav in footer
            'footer-links-2' => __('Footer Links 2', 'jointswp'), // Secondary nav in footer
            'footer-links-3' => __('Footer Links 3', 'jointswp') // Secondary nav in footer
        )
);

// The Top Menu
function joints_top_nav() {
    wp_nav_menu(array(
        'container' => false, // Remove nav container
        'menu_class' => ' menu', // Adding custom nav class
        //'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="">%3$s</ul>',
        'theme_location' => 'main-nav', // Where it's located in the theme
        'depth' => 5, // Limit the depth of the nav
        'fallback_cb' => false, // Fallback function (see below)
        'walker' => new Topbar_Menu_Walker() ,
         
    ));
}

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class Topbar_Menu_Walker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = Array()) {
        $indent = str_repeat("\t", $depth);
        
        $rowClass = '';
        
        if($depth == 0){
           $rowClass  = ' ';
        }
        
        $output .= "\n$indent<ul class=\"menus$rowClass\" id=\"lev-$depth\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = Array()) {

        parent::end_lvl($output, $depth , $args );
        
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

        $zeroDepth = false;

        if ($depth === 0) {
            $zeroDepth = true;
        }

        if ($depth === 1) {
            $item->classes[] = '';
        }

        parent::start_el($output, $item, $depth, $args, $id);

        if ($zeroDepth) {

            $output = $output . '<div class="ibiza-menu">';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {




        if ($depth === 0) {
            $output =   $output . '</div>';
        }
        parent::end_el($output, $item, $depth, $args, $id);
        

    }

}

// The Off Canvas Menu
function joints_off_canvas_nav() {
    wp_nav_menu(array(
        'container' => false, // Remove nav container
        'menu_class' => 'vertical menu', // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
        'theme_location' => 'main-nav', // Where it's located in the theme
        'depth' => 5, // Limit the depth of the nav
        'fallback_cb' => false, // Fallback function (see below)
        'walker' => new Off_Canvas_Menu_Walker()
    ));
}

class Off_Canvas_Menu_Walker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = Array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"vertical menu\">\n";
    }

}

// The Footer Menu
function joints_footer_links1() {
    wp_nav_menu(array(
        'container' => 'false', // Remove nav container
        'menu' => __('Footer Links 1', 'jointswp'), // Nav name
        'menu_class' => 'menu', // Adding custom nav class
        'theme_location' => 'footer-links-1', // Where it's located in the theme
        'depth' => 0, // Limit the depth of the nav
        'fallback_cb' => ''         // Fallback function
    ));
}

// The Footer Menu
function joints_footer_links2() {
    wp_nav_menu(array(
        'container' => 'false', // Remove nav container
        'menu' => __('Footer Links 2', 'jointswp'), // Nav name
        'menu_class' => 'menu', // Adding custom nav class
        'theme_location' => 'footer-links-2', // Where it's located in the theme
        'depth' => 0, // Limit the depth of the nav
        'fallback_cb' => ''         // Fallback function
    ));
}


// The Footer Menu
function joints_footer_links3() {
    wp_nav_menu(array(
        'container' => 'false', // Remove nav container
        'menu' => __('Footer Links 3', 'jointswp'), // Nav name
        'menu_class' => 'menu', // Adding custom nav class
        'theme_location' => 'footer-links-3', // Where it's located in the theme
        'depth' => 0, // Limit the depth of the nav
        'fallback_cb' => ''         // Fallback function
    ));
}

/* End Footer Menu */

// Header Fallback Menu
function joints_main_nav_fallback() {
    wp_page_menu(array(
        'show_home' => true,
        'menu_class' => '', // Adding custom nav class
        'include' => '',
        'exclude' => '',
        'echo' => true,
        'link_before' => '', // Before each link
        'link_after' => ''                             // After each link
    ));
}

// Footer Fallback Menu
function joints_footer_links_fallback() {
    /* You can put a default here if you like */
}

// Add Foundation active class to menu
function required_active_nav_class($classes, $item) {
    if ($item->current == 1 || $item->current_item_ancestor == true) {
        $classes[] = 'active';
    }
    return $classes;
}

add_filter('nav_menu_css_class', 'required_active_nav_class', 10, 2);
