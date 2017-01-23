<!-- By default, this menu will use off-canvas for small
         and a topbar for medium-up -->





<div class="rows">




    <div class="menu large-4 columns show-for-large">

        <div class="top-bar" id="top-bar-menu">
            <?php joints_top_nav(); ?>
        </div>        

    </div>


    <div class="small-2 medium-4  hide-for-large columns medium-top-margin-push small-top-margin-push">
        <a data-toggle="off-canvas"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu.png" title="" alt="" /></a>
    </div> 


    <div class="small-2 show-for-small-only columns small-top-margin-push">
        <a href="tel:0121"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/telephone-icon.png" title="" alt="" /></a>
    </div>    

    <div class="menu large-4 small-4 columns text-center">
        <a href="<?php echo home_url(); ?>" class="show-for-small-only"><img id="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/mobile-logo.jpg" alt="<?php bloginfo('name'); ?>"  ></a>
        <a href="<?php echo home_url(); ?>" class="show-for-medium"><img id="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" alt="<?php bloginfo('name'); ?>"  ></a>
    </div>
    <div class="large-2  small-1  medium-push-2 columns small-top-margin-push large-push-1 medium-right-align">
        <div class="header-container hc1">
            <a href="#" class="search-link"><span class="show-for-large">Search</span></a>
        </div>
    </div>
    <div class="large-2 small-1 small-pull-1 medium-push-0 large-push-0  columns small-top-margin-push medium-right-align">
        <?php if (is_active_sidebar('searchbar')) : ?>
            <div class="header-container hc2">
                <a href="https://secure.<?php echo $_SERVER['SERVER_NAME']; ?>/basket.aspx" class="upper  basket-link"><span class="show-for-large">Basket</span><span id="basket-count">1</span>   </a>




                <div  class="sp-box" style="display: block;top:49px;display:none;">
                    <div id="my-basket" style="height:320px;width:390px;background:#fff;border:15px solid #eaece7;text-align: left;padding:12px 15px" class="row">
                        <div class="small-12 columns">
                            <h2 style="color:#000">Item added to your basket</h2>
                        </div>
                        <div class="columns small-4">
                            <img src="" class="my-basket-image" style="height: 70px; background: black none repeat scroll 0% 0%; width:70px; overflow: hidden;" />
                        </div>
                        <div class="columns small-8" >
                            <p class="my-basket-prdocut-name">Some test Content</p>
                            <p class="my-basket-price">&pound16.00</p>
                        </div>

                        <div class="large-12 columns text-center" style="clear:left">
                            <a href="https://secure.<?php echo $_SERVER['SERVER_NAME']; ?>/basket.aspx" class="upper  my-basket-link"><span class="show-for-large">Basket</span></a>
                        </div>                    
                    </div>
                </div>               

                <div id="basket-con" class="text-center">

                    <form class="row columns" >

                        <div class="basket-data" style="background: url( /wp-content/themes/Ibiza-Theme/assets/images/border.png);">
                            
                            <div class="column small-12 basket-item" id="basket-item" data-basket-product-basketid="">
                            
                                <div class="columns small-3 n-l-p">

                                    <div class="basket-item-image">
                                        <a href="#" class="basket-remove-item"></a>
                                        <img src="" class="basket-product-image" />
                                    </div>

                                </div>

                                <div class="columns small-9 text-left n-l-p" >

                                    <div class="text-left small-12">
                                        <p class="basket-product-title"></p>
                                    </div>

                                    <div class="small-4 columns" style="padding:0">
                                        <p  class="basket-product-price"></p>

                                        <div class="small-2 medium-2 large-3 columns increment">
                                            <a href="#" class="remove_quantity">-</a>
                                        </div>

                                        <div class="small-6 medium-6 large-6 columns" style="padding:0;">
                                            <input type="text" class="quantity" value="1">
                                        </div>

                                        <div class="small-2 medium-2 large-3 columns increment end">
                                            <a href="#"  class="add_quantity">+</a>
                                        </div>                            

                                    </div>
                                    <div class="small-4 columns sub-total">
                                        <p>Sub Total:</p>
                                        <p  class="basket-product-total"></p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div style="clear:both">&nbsp;</div>

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

                            <a href="https://secure.<?php echo $_SERVER['SERVER_NAME']; ?>/basket.aspx" class="small-12 go-basket">Go To Basket</a>
                        </div>
                    </div>


                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div style="clear:both"></div>

