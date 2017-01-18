<?php

// Theme support options
require_once(get_template_directory() . '/assets/functions/theme-support.php');

// WP Head and other cleanup functions
require_once(get_template_directory() . '/assets/functions/cleanup.php');

// Register scripts and stylesheets
require_once(get_template_directory() . '/assets/functions/enqueue-scripts.php');

// Register custom menus and menu walkers
require_once(get_template_directory() . '/assets/functions/menu.php');

// Register sidebars/widget areas
require_once(get_template_directory() . '/assets/functions/sidebar.php');

// Makes WordPress comments suck less
require_once(get_template_directory() . '/assets/functions/comments.php');

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory() . '/assets/functions/page-navi.php');

// Adds support for multiple languages
require_once(get_template_directory() . '/assets/translation/translation.php');

// Remove 4.2 Emoji Support
// require_once(get_template_directory().'/assets/functions/disable-emoji.php'); 
// Adds site styles to the WordPress editor
//require_once(get_template_directory().'/assets/functions/editor-styles.php'); 
// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/assets/functions/related-posts.php'); 
// Use this as a template for custom post types
// require_once(get_template_directory().'/assets/functions/custom-post-type.php');
// Customize the WordPress login menu
// require_once(get_template_directory().'/assets/functions/login.php'); 
// Customize the WordPress admin
// require_once(get_template_directory().'/assets/functions/admin.php'); 



add_action('init', 'wpse71305_register_types');

/**
 * 
 */
function wpse71305_register_types() {

    //You'll need to register the country taxonomy here too.
    //Add 'country' tag.
    add_rewrite_tag('%products%', '([^&/]+)');
    add_rewrite_tag('%howto%', '([^&/]+)');
    add_rewrite_tag('%search%', '([^&/]+)');
    add_rewrite_tag('%the_id%', '([^&/]+)');
    add_rewrite_tag('%cat%', '([^&/]+)');

    //Register hotel post type with %country$ tag
    $args = array(
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'p/%products%',
            'with_front' => false,
            'feed' => true,
            'pages' => true
        )
    );
    register_post_type('product', $args);

    //Register hotel post type with %country$ tag
    $args = array(
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'h/%the_id%/%howto%',
            'with_front' => false,
            'feed' => true,
            'pages' => true
        )
    );
    register_post_type('howto', $args);



    //Register hotel post type with %country$ tag
    $args = array(
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'product-list/%cat%/%the_id%',
            'with_front' => false,
            'feed' => true,
            'pages' => true
        )
    );
    register_post_type('product-list', $args);



    //Register hotel post type with %country$ tag
    $args = array(
        'has_archive' => false,
        'rewrite' => array(
            'slug' => 'search/%search%',
            'with_front' => false,
            'feed' => false,
            'pages' => false,
        ),
        'query_var' => 'search',
        'publicly_queryable' => true,
        'public' => true,
        'hierarchical' => false,
    );
    register_post_type('search', $args);



    //Register hotel post type with %country$ tag
    $args = array(
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'how-to-guides/%cat%/%the_id%',
            'with_front' => false,
            'feed' => true,
            'pages' => true
        )
    );
    register_post_type('how-to-guides', $args);
}

add_filter('template_include', 'so_13997743_custom_template');

/**
 * 
 * @param string $template
 * @return string
 */
function so_13997743_custom_template($template) {

    $hasProduct = get_query_var('products');



    $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));


    if (isset($segments[0]) && !empty($segments[0]))
        switch ($segments[0]) {

            case 'p':
                $template = plugin_dir_path(__FILE__) . 'product.php';
                break;
            case 'h':
                $template = plugin_dir_path(__FILE__) . 'howto.php';
                break;
            default:
                
                if( ( $segments[0] == 'search' && (isset($segments[1]) || isset($_GET['q']) ) ) ){
                    $template = plugin_dir_path(__FILE__) . 'template-search.php';
                }
                
                if ( ( $segments[0] == 'product-list' && (isset($segments[1]) || isset($_GET['q']) ) ) || ($segments[0] == 'how-to-guides' && isset($segments[1]) )) {
                    $template = plugin_dir_path(__FILE__) . 'template-products-list.php';
                }
                

                if( $segments[0] ==  'how-to-guides' && isset($segments[1]) && isset($segments[2])  ){
                    $template = plugin_dir_path(__FILE__) . 'template-howto.php';        
                }else if( $segments[0] ==  'how-to-guides' ){
                    $template = plugin_dir_path(__FILE__) . 'template-howto-categories.php';        
                }
        }


    return $template;
}

/**
 * 
 * @global type $wpdb
 * @param type $key
 * @param type $type
 * @param type $status
 * @return type
 */
function get_meta_values($key = '', $type = 'post', $status = 'publish') {

    global $wpdb;

    if (empty($key)) {
        return;
    }

    $r = $wpdb->get_col($wpdb->prepare("
        SELECT p.post_parent FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND pm.meta_value !=  'null' 
        AND pm.meta_value !=  '' 
        LIMIT 1
    ", $key, $status));

    return $r;
}

/**
 * 
 * @global type $wpdb
 * @param type $menu_id
 * @param type $type
 * @param type $status
 * @return array
 */
function breacdcrumbs($menu_id, $type = 'post', $status = 'publish', $page = '') {

    global $wpdb;

    $r = $wpdb->get_col($wpdb->prepare("
        SELECT p.id FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND pm.meta_value !=  'null' 
        AND pm.meta_value !=  '' 
        LIMIT 1
    ", $menu_id, $status));

    return array_reverse(crumb($r[0], $status, array(), $page));
}

/**
 * 
 * @global type $wpdb
 * @param type $id
 * @param string $status
 * @param type $output_arr
 * @return string
 */
function crumb($id, $status = 'publish', $output_arr = array(), $page = '') {

    global $wpdb;

    $myrows = $wpdb->get_results(
            $wpdb->prepare($q = "
        SELECT p.post_title,  pm.meta_value AS pid,  pmm.* FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        LEFT JOIN {$wpdb->postmeta} pmm ON p.ID = pm.post_id AND pmm.meta_key  = '_menu_item_url' AND pmm.post_id ='%s'
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND pm.post_id =  '%s' 
        LIMIT 1", $id, '_menu_item_menu_item_parent', $status, $id)
    );

    /**
     * Point to note! Quuery joins the current menu item link to save to another query
     * Done by obatining the current menus link, it also retrieves the parent of the current level
     * To pass on to the self return if is !=0 ie the highest level
     */
    if ($myrows[0]->pid != 0) {

        static $i;
        $class = '';

        if ($i == 0) {
            $class = 'class="current"';
        }

        if ($page != '') {
            $output_arr[] = '<li ' . $class . '><a href="#">' . $page . '</a></li>';
            $class = '';
        }


        $output_arr[] = '<li ' . $class . '><a href="' . $myrows[0]->meta_value . '">' . $myrows[0]->post_title . '</a></li>';

        $i++;
        return crumb($myrows[0]->pid, $status = 'publish', $output_arr);
        // return self call to get next level up
    } else {

        // temp wire how to guides, will need updating
        if ($id == '23935') {
            // how to id
            $url = '/how-to-guides';
            $title = 'How to guides';
        } else if ($id == '32') {
            $url = '/products-list';
            $title = 'Shop';
        } else {
            $url = $myrows[0]->meta_value;
            $title = $myrows[0]->post_title;
        }

        $output_arr[$myrows[0]->post_title] = '<li><a href="' . $url . '">' . $title . '</a></li>';
        $output_arr[] = '<li><a href="/">Home page </a></li>';

        return $output_arr;
        // top level add homepage link
    }

    return $output_arr;
}

function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                    mb_strtolower($clean, 'UTF-8') :
                    strtolower($clean) :
            $clean;
}

function get_product_by_mongo_product_code($product_code) {
    global $ibiza_api;
    return reset(json_decode(file_get_contents($ibiza_api::api_location . '/ProductCatalog.Api/api/document/data.productcode/' . $product_code)));
}

function get_product_by_mongo_id($mongo_id) {
    global $ibiza_api;
    $data = @json_decode(file_get_contents($ibiza_api::api_location . '/ProductCatalog.Api/api/document/' . $mongo_id));

    return $data;



    return reset(json_decode(file_get_contents($ibiza_api::api_location . '/ProductCatalog.Api/api/document/' . $mongo_id)));
}
