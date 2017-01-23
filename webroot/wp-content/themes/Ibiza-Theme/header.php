<?php
global $ibiza_api;
$haspromoBanner = false;
delete_transient();
delete_site_transient();
if ( !isset($_COOKIE['nsec']) && !isset($_COOKIE['ann']) ) {

    $cookieVal = time() . date('dmYhis');
    setcookie('ann', $cookieVal, time() + 3600, '/', '.' . $_SERVER['SERVER_NAME']);
} else if( isset($_COOKIE['ann']) ){
    $cookieVal = $_COOKIE['ann'];
}else {

    $cookieVal = urldecode($_COOKIE['ann']);
    $cookieStr = $_COOKIE['nsec'];
    parse_str($cookieStr);
}


$the_cache = 'promotional_banner';
$cb = function($the_cache) {

    global $wpdb;

    $banner_meta = array();

    $args = array(
        'post_type' => 'promotional_banner',
        'order' => 'ASC',
        'post_status ' => 'publish'
    );

    $the_query = new WP_Query($args);
    
    if ($the_query->have_posts()) :
        
       
        $rowArr = array();
        while ($the_query->have_posts()) :
         
            $the_query->the_post();

            $myrows = $wpdb->get_results('SELECT * FROM wp_postmeta AS w1  
                                            WHERE post_id IN ( ' . get_the_ID() . ' ) AND 
                                            ( meta_key = "_cs-start-date" OR 
                                            meta_key = "_cs-expire-date" OR meta_key = "_cs-enable-schedule" )');

            if (is_array($myrows)) {

                foreach ($myrows as $row) {

                    $rowArr[$row->post_id][$row->meta_key] = $row->meta_value;
                }
                $start_time = $rowArr[get_the_ID()]['_cs-start-date'];
                $end_time   = $rowArr[get_the_ID()]['_cs-expire-date'];

                if (time() > $start_time && time() < $end_time) {
                    
                    $banner_meta['end_time']                    = $end_time;
                    $banner_meta['banner_content']              = get_the_content();
                    $banner_meta['banner_title']                = get_the_title();
                    $banner_meta['menu_banner_url']             = get_post_meta(get_the_ID(), 'menu_banner_url', '');
                    $banner_meta['banner_background_colour']    = get_post_meta(get_the_ID(), 'banner_background_colour', '#f38a76');
                }
            }
            // can only be one
            break;
        endwhile;
    endif;

    
    
    $args = array(
        'post_type' => 'menu_banner',
        'order' => 'ASC',
        'post_status ' => 'publish'
    );

    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();
            $menu_banner = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->the_post()), 'single-post-thumbnail');
            $menu_banner_url = get_post_meta(get_the_ID(), 'menu_banner_url', true);
        endwhile;
    endif;
    wp_reset_query();    
    
    
    $banner_meta['menu_banner']     = $menu_banner;
    $banner_meta['menu_banner_url'] = $menu_banner_url;
    
    
    create_cache($the_cache, $banner_meta);
    return $banner_meta;
};


$banner_meta = get_cache($the_cache, $cb);
//remove_cache($the_cache, $cb);

?><!doctype html>
<?php $is_home = is_front_page(); ?>
<html class="no-js"  <?php language_attributes(); ?>>

    <head>
        <meta charset="utf-8">
        <!-- Force IE to use the latest rendering engine available -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta class="foundation-mq">
        <!-- If Site Icon isn't set in customizer -->
        <?php if (!function_exists('has_site_icon') || !has_site_icon()) { ?>
            <!-- Icons & Favicons -->
            <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
            <link href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-touch.png" rel="apple-touch-icon" />
            <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-60x60.png">
            <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-152x152.png">
            <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-180x180.png">
            <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/assets/images/android-icon-192x192.png">
            <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon-96x96.png">
            <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon-16x16.png">
            <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/images/manifest.json">
            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/images/ms-icon-144x144.png">
            <meta name="theme-color" content="#ffffff">            
            <!--[if IE]>
                    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
            <![endif]-->
            <meta name="msapplication-TileColor" content="#f01d4f">
            <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/images/win8-tile-icon.png">
            <meta name="theme-color" content="#121212">
        <?php } ?>

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>

        <!-- Drop Google Analytics here -->
        <script type="text/javascript">
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function ()
                {
                    (i[r].q = i[r].q || []).push(arguments)
                }

                , i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-85186561-2', 'auto');
            ga('send', 'pageview');
        </script>        
        <!-- end analytics -->


        <script type="text/javascript">

            var end_points = {};
<?php foreach ($ibiza_api::$end_points as $key => $endpoint): ?>
                end_points.<?php echo $key ?> = '<?php echo $endpoint; ?>';
<?php endforeach; ?>
            var api_location = "<?php global $ibiza_api;
echo $ibiza_api::api_location;
?>";
            var api_url = "<?php echo API; ?>";
<?php
if (_LOGGED_IN):

    $cookieStr = $_COOKIE['sec'];
    parse_str($cookieStr, $output);
    ?>
                var basket_url = "<?php echo $ibiza_api::$end_points['securebasket'] . $_SERVER['REMOTE_ADDR'] . '/' . $output['ci'] . '/' . $output['sk']; ?>";
                var basket_update_url = "<?php echo $ibiza_api::$end_points['basketitemquantitysecure'] . '/{basketId}/' . $output['ci'] . '/{quantity}/' . $output['sk']; ?>";
    <?php
else:
    /**
     * Set ann cookie if you are not logged in and have nsec cookie for the add to basket section
     */
    ?>

                var basket_url = "<?php echo $ibiza_api::$end_points['nonsecurebasket'] . $_SERVER['REMOTE_ADDR'] . '/' . $cookieVal; ?>";

<?php
endif;
?>


        </script>

    </head>

    <body <?php body_class(); ?> >

        <div class="menu_banner hidden">
            <img src="<?php echo  $banner_meta['menu_banner'][0]; ?>" alt="banner Image" title="banner Image" />
        </div>

        <div class="off-canvas-wrapper">

            <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

                <?php get_template_part('parts/content', 'offcanvas'); ?>
                <?php get_template_part('parts/content', 'offcanvas_left'); ?>

                <div class="off-canvas-content" data-off-canvas-content>
                    <div class="fullwidth site-top-bar">
                        <div class="row">

                            <div class="hide-for-small-only large-4 medium-4 columns small-12 text-center medium-text-left medium-text-left">
                                &nbsp;
                            </div>


                            <div class="small-11 large-4 medium-4 columns text-center small-text-left">
                                <h1 class="slogan"><?php bloginfo('description'); ?></h1>
                            </div>  


                            <div class="small-1 medium-4 columns panel clearfix header-contact-large">

                                <ul class="menu right">

                                    <?php if (_LOGGED_IN): ?>

                                        <li class="account-link-con"  class="show-for-large-only">
                                            <a class="font-small  account"  href="<?php echo  $ibiza_api::$end_points['secure_site']  ?>/account.aspx?_ga=1.111643779.624630137.1465816634" title="My account page link">&nbsp;<span class="show-for-large">My Account</span></a>

                                            <div  class="sp-box">

                                                <div class="header-tri"></div>

                                                <div id="my-account"  class="row">


                                                    <div class="large-12">
                                                        <h2 class="dark-header">Welcome Back<br /><?php echo ucwords(sanitize($fn)); ?></h2>
                                                        <a href="<?php echo  $ibiza_api::$end_points['secure_site']  ?>/account.aspx?_ga=1.111643779.624630137.1465816634" class="upper" id="my-account-button"  title="My account page link">My Account</a>
                                                        <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>?logout=1" class="upper" id="signout-button"  title="Sign out link">Sign Out</a>
                                                    </div>


                                                </div>


                                            </div>                                            



                                        </li>

                                    <?php else: ?>

                                        <li  class="show-for-small">
                                            <a class="font-small account"   href="<?php echo  $ibiza_api::$end_points['secure_site']  ?>/login.aspx?_ga=1.246909059.624630137.1465816634" title="Login page link"><span class="show-for-large">Login / Register</span></a>
                                        </li>

                                    <?php endif; ?>

                                    <li class="separator show-for-large">|</li>

                                    <li class="show-for-large">
                                        <a class="font-small tel-number" href="tel:08001124433" title="Sewing Quarter telephone number"><span class="show-for-large">0800 112 4433</span></a>
                                    </li>
                                </ul>                    

                            </div>

                        </div>
                    </div>


                    <div class="fullwidth header-outter">
                        <nav class="header row upper" role="banner">

                            <!-- This navs will be applied to the topbar, above all content 
                                     To see additional nav styles, visit the /parts directory -->
<?php get_template_part('parts/nav', 'offcanvas-topbar'); ?>

                        </nav> <!-- end .header -->
                    </div>


                    <div class="fullwidth">
                        <div>
                            <?php if (is_active_sidebar('searchbar')) : ?>

                                <?php dynamic_sidebar('searchbar'); ?>

<?php endif; ?>
                        </div>                    
                    </div>

                    <div class="show-for-medium upsells">
                        <div class="row text-center" id="channels">

                            <div class="small-4 columns tv-channel-con tv-channel-con1 text-center medium-text-left">
                                <p>Free Beginner, Intermediate and Advanced Tutorials</p>
                            </div>
                            <div class="small-4 columns  tv-channel-con tv-channel-con2 text-center medium-text-left">
                                <p>Shop all day, pay once for delivery - only &pound;2.95* </p>
                            </div>
                            <div class="small-4 columns  tv-channel-con tv-channel-con3 text-center medium-text-left">
                                <p>Watch Online and on <span class="icon freeview"></span> Channel 78, 8am-12pm</p>
                            </div>

                        </div>

                    </div>
<?php if ( isset( $banner_meta['banner_content'] ) ): ?>
                        <div id="promo_banner" class="row">
                            <div class="small-12 text-center columns">
                                <h2 style="background:<?php echo $banner_meta['banner_background_colour']; ?>">
                                    <span>
                                        <a href="<?php echo $banner_meta['menu_banner_url']; ?>" title="Promo link page" class="block-el" ><strong><?php echo $banner_meta['banner_title']; ?></strong> <?php echo $banner_meta['banner_content']; ?></a>
                                        <small>Offer ends <?php echo date('d/m/Y', $banner_meta['end_time']); ?> <a  href="/terms-conditions/">*Terms & Conditions Apply</a></small>
                                    </span>

                                </h2>

                            </div>
                        </div>
<?php endif; ?>