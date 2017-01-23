<?php
global $ibiza_api;

?>
<!-- By default, this menu will use off-canvas for small
         and a topbar for medium-up -->

<div class="rows">




    <div class="menu large-4 columns show-for-large">

        <div class="top-bar" id="top-bar-menu">
            <?php
            $the_cache = 'joints_top_nav';
            
            
            $cb =        function($the_cache){     
                ob_start();
                
                joints_top_nav();
                $cache_joints_top_nav = ob_get_contents();
                ob_end_clean();   
                create_cache(  $the_cache  ,$cache_joints_top_nav);
                return $cache_joints_top_nav; 
            };
            $cache_joints_top_nav = get_cache( $the_cache , $cb );
            //remove_cache(  $the_cache  );
            print $cache_joints_top_nav;
            
            ?>
        </div>        

    </div>


    <div class="small-2 medium-1  hide-for-large columns medium-top-margin-push small-top-margin-push">
        <a data-toggle="off-canvas" title="Toggle menu"><span class="icon burger-icon"></span></a>
    </div> 


    <div class="small-2 medium-3 hide-for-large  columns small-top-margin-push">
        <a href="tel:08001124433" title="Sewing Quarter telephone number"><span class="icon large-tel-icon"></a>
    </div>    

    <div class="menu large-4 small-4 columns text-center">
        <a href="<?php echo home_url(); ?>" class="show-for-small-only logo-con" title="Home page link"><img id="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/mobile-logo.jpg" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>"  ></a>
        <a href="<?php echo home_url(); ?>" class="show-for-medium logo-con"  title="Home page link"><img id="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>"  ></a>
        
        
<!--                <a href="<?php echo home_url(); ?>" class="show-for-medium logo-con icon"  title="Home page link"><span class=" home-logo"></span></a>-->

        
    </div>
    <div class="large-2  small-2  medium-push-1 columns small-top-margin-push large-push-1 medium-right-align small-text-right">
        <div class="header-container hc1">
            <a href="#" class="search-link" title="Click to open search">
                <span class="outter">
                    <span  class="show-for-large">Search</span>
                </span>
            </a>
        </div>
    </div>
    <div class="large-2 small-2 medium-2 medium-push-0 large-push-0  columns small-top-margin-push medium-right-align small-text-right end">
        <?php if (is_active_sidebar('searchbar')) : ?>
            <div class="header-container hc2">
                <a href="<?php echo  $ibiza_api::$end_points['secure_site']  ?>/basket.aspx" class="upper  basket-link" title="Click to go to your basket"><span class="outter"><span class="show-for-large">Basket</span></span><span id="basket-count">1</span>   </a>




                <div  class="sp-box sp-box1">
                    <div id="my-basket" class="row">
                        
                        <a href="#" class="close_button" title="Close"></a>
                        
                        <div class="small-12 columns">
                            <h2 class="dark-header"></h2>
                        </div>
                        <div class="columns small-4">
                            <img src="" class="my-basket-image"  alt="Basket Photo Image"  title="Basket Photo Image" />
                        </div>
                        <div class="columns small-8" >
                            <p class="my-basket-prdocut-name"></p>
                            <p class="my-basket-price"></p>
                        </div>

                        <div class="large-12 columns text-center clear-left" >
                            <a href="<?php echo  $ibiza_api::$end_points['secure_site']  ?>/basket.aspx" class="upper  my-basket-link" title="Click to view your basket"><span>Basket</span></a>
                        </div>                    
                    </div>
                </div>               

                <div id="basket-con" class="text-center">

                    <form class="row columns" >

                        <div class="basket-data">
                            
                            <div class="column small-12 basket-item" id="basket-item" data-basket-product-basketid="">
                            
                                <div class="columns small-3 n-l-p">

                                    <div class="basket-item-image">
                                        <?php if(_LOGGED_IN): ?>
                                        <a href="#" class="basket-remove-item" title="Click to remove item from basket"></a>
                                        <?php endif;  ?>
                                        <img src="" class="basket-product-image"  alt="Basket Photo Image"  title="Basket Photo Image"  />
                                    </div>

                                </div>

                                <div class="columns small-9 text-left n-l-p" >

                                    <div class="text-left small-12">
                                        <p class="basket-product-title"></p>
                                    </div>

                                    <div class="small-4 columns no-padding">
                                        <p  class="basket-product-price"></p>
                                        <?php if(_LOGGED_IN): ?>

                                        <div class="small-2 medium-2 large-3 columns increment">
                                            <a href="#" class="remove_quantity" title="Reduce basket item quantity">-</a>
                                     
                                        </div>
 
                                        <div class="small-6 medium-6 large-6 columns no-padding">
                                            <input type="text" class="quantity" value="1" />
                                        </div>

                                        <div class="small-2 medium-2 large-3 columns increment end">
                                            <a href="#"  class="add_quantity"  title="Increase basket item quantity">+</a>
                                        </div>         
                                        
                                        <?php else: ?>
                                        
                                        <?php endif; ?>
                                    </div>
                                    <div class="small-4 columns sub-total">
                                        <p>Sub Total:</p>
                                        <p  class="basket-product-total"></p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="clear">&nbsp;</div>

                    </form>

                    <div class="row">

                        <div class="columns large-12">

                            <div class="small-6 columns text-left">
                                <p>Total:</p>
                            </div>

                            <div class="small-6 columns text-right">
                                <p id="basket-total"></p>
                            </div>

                            <div class="small-12 columns text-left">
                                <p>Excl. delivery normally &pound;2.99</p>
                            </div>

                            <a href="<?php echo  $ibiza_api::$end_points['secure_site']  ?>/basket.aspx" class="small-12 go-basket" title="Go To Basket">Go To Basket</a>
                        </div>
                    </div>


                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="clear"></div>

