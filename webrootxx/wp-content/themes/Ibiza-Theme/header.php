<!doctype html>
<?php $is_home  = is_front_page(); ?>
<html class="no-js"  <?php language_attributes(); ?>>

    <head>
        <meta charset="utf-8">

        <!-- Force IE to use the latest rendering engine available -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <?php wp_head(); 
        $cookieStr      = $_COOKIE['sec'];
        parse_str($cookieStr, $output);        
        ?>
        <!-- Drop Google Analytics here -->
        <!-- end analytics -->
        <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-584565b16fa56454"></script>
        <script>var api_location    = "<?php global $ibiza_api; echo $ibiza_api::api_location; ?>";</script>
        <script>
            var basket_url          = "<?php echo  $ibiza_api::api_location . '/ProductCatalog.api/api/legacy/securebasket/' .  $_SERVER['REMOTE_ADDR']  .'/'  .  $output['ci']  .'/'  . $output['sk']; ?>";
            var basket_update_url   = "<?php echo  $ibiza_api::api_location . '/ProductCatalog.api/api/legacy/basketitemquantitysecure/{basketId}/'  .  $output['ci']  .'/{quantity}/'  . $output['sk']; ?>";
        </script>
        
    </head>

    <!-- Uncomment this line if using the Off-Canvas Menu --> 

    <body <?php body_class(); ?> >

        <!--        <div class="header" style="margin: 0px;  overflow: hidden;">
        
                </div>-->

        <div class="off-canvas-wrapper">

            <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

                <?php get_template_part('parts/content', 'offcanvas'); ?>
                <?php get_template_part('parts/content', 'offcanvas_left'); ?>

                <div class="off-canvas-content" data-off-canvas-content>
                    <div class="fullwidth site-top-bar">
                        <div class="row">

                            <div class="large-4 medium-4  columns small-12 text-center medium-text-left">
                                <!--<p class="font-small rating-text">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/stars.png" />
                                    <span class="show-for-medium">Rated excellent by our customers</span>
                                    <span  class="show-for-small-only">Excellent</span>
                                </p>-->&nbsp;
                            </div>


                            <div class="large-4 medium-4 columns text-center show-for-medium">
                                <strong class="slogan"><?php bloginfo('description');  ?></strong>
                            </div>  

                       


                            <div class="large-4 medium-4 columns panel  clearfix">

                                <ul class="menu right show-for-medium">

                                    <?php if ( _LOGGED_IN ):?>
                                    
                                    <li class="account-link-con"  class="show-for-large-only">
                                        <a class="font-small  account"  href="https://secure.<?php echo $_SERVER['SERVER_NAME']; ?>/account.aspx?_ga=1.111643779.624630137.1465816634">&nbsp;<span class="show-for-large">My Account</span></a>
                                            
                                            <div  class="sp-box show-for-large">

                                                <div class="header-tri"></div>

                                                <div id="my-account" style="height:auto;width:240px;background:#fff;border:15px solid #eaece7;text-align: center;padding:12px 15px" class="row">

                                                    
                                                    <?php
                                                    
                                                    $str =  $_COOKIE['nsec'];
                                                    parse_str($str);                                                    
                                                    
                                                    ?>
                                                    


                                                    <div class="large-12">
                                                        <h2 style="color:#000">Welcome Back<br /><?php echo ucwords( sanitize($fn) ); ?></h2>
                                                        <a href="https://secure.<?php echo $_SERVER['SERVER_NAME']; ?>/account.aspx?_ga=1.111643779.624630137.1465816634" class="upper" id="my-account-button">My Account</a>
                                                        <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>?logout=1" class="upper" id="signout-button">Sign Out</a>
                                                    </div>


                                                </div>


                                            </div>                                            
                                            
                                            
                                            
                                        </li>

                                    <?php else: ?>

                                        <li  class="show-for-large">
                                            <a class="font-small account"   href="https://secure.<?php echo $_SERVER['SERVER_NAME']; ?>/login.aspx?_ga=1.246909059.624630137.1465816634">Login / Register </a>
                                        </li>

                                    <?php endif; ?>

                                    <li class="separator show-for-large">|</li>

                                    <li class="show-for-medium">
                                        <a class="font-small tel-number" href="tel:0800 6444 655">&nbsp;<span  class="show-for-large">0800 6444 655</span></a>
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
                        <div class="row" id="channels" style="large-12-xtra" style="text-align: center;">

                            <div class="small-4 columns tv-channel-con text-center medium-text-left">

                                <p>Free Beginner, Intermediate &amp; Advanced Tutorials</p>

                            </div>
                            <div class="small-4 columns  tv-channel-con text-center medium-text-left" style="border-left:1px solid #000;border-right:1px solid #000;">

                                <p>Buy Online - Standard Delivery Only &pound;2.99</p>

                            </div>
                            <div class="small-4 columns  tv-channel-con text-center medium-text-left">

                                <p>Watch Online or Available on <img alt="Freeview Icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/Image_FreeviewLogo.png" style="position: relative; bottom: 3px;" /> Channel 78 </p>

                            </div>

                        </div>
                    </div>