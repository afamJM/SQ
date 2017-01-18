<?php
/*
  Template Name: Auction Template
 */
?>

<?php get_header(); ?>

<div id="content">
    <div id="operationLogInfo"></div>
    
    <div id="inner-content" class="home-inner-content row" ng-controller="AuctionPage" ng-app="ibiza-auction">

        <main class="large-12 columns auction-page" role="main">

            <div class="row header-row">
                <div class="large-12 columns">
                    <div class="large-12 columns white-house">
                        <div class="small-12 column show-for-small-only no-padding"><div class="back-button">&lt; BACK</div></div>
                        <ul class="breadcrumbs show-for-medium">
                        <li><a href="<?php get_template_directory_uri(); ?>">Home</a></li>
                        <li class="current"><a href="<?php get_template_directory_uri(); ?>">Watch</a></li>
                        </ul>
                        <h1 class="auction-title"><?php the_title(); ?></h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <div class="large-8 columns tv-wrap">
                        <div id="dvVideoHolderHome" style="background-color: #000">
                            <img style="width: 100%; display: none;" src="/global/img/tv-preview.jpg" />
                        </div>
                        <div class="show-for-large row no-padding columns auction-on-next-large white-house">
                            <div class="medium-6 no-padding columns on-now-box">
                                <div class="large-3 columns no-padding on-now">On Now</div>
                                <div class="large-9 columns">
                                    <h4>08:00 - 09:00</h4>
                                    <p>Title of the show and who is the presenter</p>
                                </div>
                            </div>
                            <div class="medium-6 no-padding columns on-now-box">
                                <div class="large-3 columns no-padding on-now">On Next</div>
                                <div class="large-9 columns">
                                    <h4>09:00 - 10:00</h4>
                                    <p>Title of the show and who is the presenter</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="large-4 medium-8 columns auction-buy-panel white-house">
                        <div class="triangle"></div>
                        <div class="aution-buy-pointer"></div>
                        <div class="row title-row">
                            <div class="large-12 columns">
                                <h2>{{productData.data.name}}</h2>
                                <p class="product-code">Product Code: <span>{{productData.data.productcode}}</span></p>
                            </div>
                        </div>
                        <div class="row price-qty-row">
                            <div class="large-8 medium-8 small-6 columns">
                                <h4>£{{productData.auction.price}}</h4>
                            </div>
                            <div class="large-4 medium-4 small-5 columns qty" ng-if="isLoggedIn == 'true'">
                                <div class="small-2 medium-2 large-2 columns increment">
                                    <a href="#" id="remove_quantity">-</a>
                                </div>

                                <div class="small-6 medium-6 large-6 columns" style="padding:0;">
                                    <input type="text" id="quantity" value="1">
                                </div>

                                <div class="small-2 medium-2 large-2 columns increment end">
                                    <a href="#"  id="add_quantity">+</a>
                                </div>
                            </div>
                        </div>
                        <div class="row buy-panel-buttons">
                                <div class="large-12 columns" ng-if="isLoggedIn == 'true' && productData.auction.variant">
                                    <label for="main-variant">{{productData.auction.variant}}</label>
                                    <select id="main-variant" ng-model="$parent.mainItemAuctionLegacyId">
                                        <option ng-repeat="variants in productData.auction.variation" value="{{variants.legacycode}}">{{variants.option}}</option>
                                    </select>
                                    <!-- note: if the auction updates it's possible mainItemAuctionLegacyId might revert to init value while the select still shows a new option.-->
                                </div>
                                <div class="large-12 columns" ng-if="isLoggedIn == 'true'">
                                    <div id="main-item-IDs" data-auction-id="{{productData.auction.id}}" data-legacy-id="{{mainItemAuctionLegacyId}}" style="display: none;"></div>
                                    <input type="button" value="ADD TO BASKET" class="add-to-basket" />
                                </div>
                                <div class="hideOnLogin" ng-if="isLoggedIn != 'true'">
                                    <div class="large-6 medium-6 columns no-padding-right">
                                        <input ng-click="pollForLogin()" type="button" value="LOGIN TO BUY" class="login-to-buy login-window-popup" id="inline" href="#data" />
                                    </div>
                                    <div class="large-6 medium-6 columns">
                                        <p class="create-account">or <a href="#">Create an account</a></p>
                                    </div>

                                    <!--login window-->
                                    <div style="display:none">
                                        <div id="data">
                                            <iframe src="http://secure.ibiza.com.uat/login.aspx" style="border: 0px none;  height: 485px;  width: 400px; max-width: 100%; max-height: 100%;"></iframe>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="row product-gallery">
                            <div class="large-9 columns product-gallery-mob">
                                <div class="medium-2 columns hide-for-large">
                                    <div class="swiper-button-prev" ng-click="changeMainPhotoMobTab('minus')"></div>&nbsp;
                                </div>
                                <a id="single_image" href="{{mainPhoto}}" class="main-photo-wrap large-12 medium-8 columns">
                                    <div class="main-photo columns" style="background-image: url('{{mainPhoto}}');"><span class="enlarge">&#128269; click image to enlarge</span></div>
                                </a>
                                <div class="medium-2 columns hide-for-large-up">
                                    <div class="swiper-button-next" ng-click="changeMainPhotoMobTab('plus')"></div>&nbsp;
                                </div>
                                <div class="medium-12 columns hide-for-large-up mobile-gallery-blobs">
                                    <span ng-repeat="pics in productData.data.images" ng-class="{'highlight':$index == mobileGalleryIndex}"></span>
                                </div>
                            </div>
                            <div class="large-3 columns thumb-photos-house hide-for-medium-down">
                                <div class="thumb-photos">
                                    <ul>
                                        <li ng-repeat="pics in productData.data.images">
                                            <div class="prodThumb" ng-click="changeMainPhoto(pics.url)" style="background-image: url({{pics.url}})"></div>
                                        </li>
                                        <li ng-repeat="pics in productData.data.images">
                                            <div class="prodThumb" ng-click="changeMainPhoto(pics.url)" style="background-image: url({{pics.url}})"></div>
                                        </li>
                                        <li ng-repeat="pics in productData.data.images">
                                            <div class="prodThumb" ng-click="changeMainPhoto(pics.url)" style="background-image: url({{pics.url}})"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="hide-for-large medium-4 columns">
                        <div class="medium-12 no-padding columns auction-on-next-small">
                                <div class="medium-12 no-padding columns">
                                    <div class="large-12 medium-12 small-4 columns on-now-small">On Now</div>
                                    <div class="medium-12 small-8 columns">
                                        <h4>08:00 - 09:00</h4>
                                        <p>Title of the show and who is the presenter</p>
                                    </div>
                                </div>
                                <div class="medium-12 no-padding columns">
                                    <div class="large-12 medium-12 small-4 columns on-now-small">On Next</div>
                                    <div class="medium-12 small-8 columns">
                                        <h4>09:00 - 10:00</h4>
                                        <p>Title of the show and who is the presenter</p>
                                    </div>
                                </div>   
                        </div>
                        <div class="medium-12 no-padding columns message-the-studio-small">
                            <div class="medium-12 columns" ng-if="isLoggedIn == 'true'">
                                    <h3>Message The Studio</h3>
                                    <p>YOU ARE LOGGED IN.</p>
                            </div>
                            <div class="medium-12 columns" ng-if="isLoggedIn != 'true'">
                                <img src="<?php echo get_template_directory_uri()?>/assets/images/message-the-studio.svg" />
                                <h3>Message The Studio</h3>
                                <p>Got questions or just want to get involved?</p>
                                <p>
                                    <a href="#">Login</a>
                                    <br />or<br />
                                    <a href="#">Create an account</a>
                                </p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <div class="description-wrap">
                        <div class="large-4 show-for-large columns">
                            <div class="message-the-studio-large" ng-if="isLoggedIn == 'true'">

                                    <h3>Message The Studio</h3>
                                    <p>YOU ARE LOGGED IN.</p>
                            </div>
                            <div class="message-the-studio-large" ng-if="isLoggedIn != 'true'">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/message-the-studio.svg" />
                                    <h3>Message The Studio</h3>
                                    <p>Got questions or just want to get involved?
                                        <br /><a href="#">Login</a> or <a href="#">Create an account</a>
                                    </p>
                            </div>
                        </div>
                        <div class="large-8 medium-12 columns auction-description tabber">
                            <p>More information about The Sewing Quarter Japanese Veg Dyed Fashion Fabric, Charcoal</p>
                            <div class="large-12 no-padding tab-house">
                                <div data-tabbed="desc" class="tabber-tab active">Description <div class="down-arrow"></div></div>
                                <div data-tabbed="spec" class="tabber-tab">Specifications <div class="down-arrow"></div></div>
                                <div style="clear: both;"></div>
                            </div>
                            <div class="tabber-content active" data-content="desc">
                                <p>{{productData.data.description}}</p>
                            </div>
                            <div class="tabber-content" data-content="spec">
                                <div class="spec-house large-6 medium-6 small-12 columns" ng-repeat="spec in productDataSpec">
                                    <div class="spec-name small-6 columns">{{spec.name}}:</div>
                                    <div class="spec-value small-6 columns">{{spec.value}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row todays-items-row">
                <div class="white-house tabber">
                    <div class="white-panel left"></div>
                    <div class="white-panel right"></div>

                    <div class="row hide-for-large tab-house">
                        <div class="medium-12 columns">
                            <div class="medium-6 small-6 columns tabber-tab lower active" data-tabbed="ant">Products From Today's Show</div>
                            <div class="medium-6 small-6 columns tabber-tab lower" data-tabbed="dec">Programme Guide</div>
                        </div>
                    </div>

                    <div class="large-8 columns tabber-content active" data-content="ant">
                        <h3 class="hide-for-medium-down">Products From Today's Show</h3>
                        <div class="row todays-product-row">
                            <div ng-repeat="item in todaysProductsData.data" class="large-3 medium-4 small-6 columns todays-product" ng-class="{'end':$last}">
                                <a data-toggle="off-canvas-left" aria-expanded="false" aria-controls="off-canvas" class="product-link howto_products auction-off-canvas-button" ng-click="changeOffCanvas($index)">
                                    <img src="{{item.data.images[0].url}}" />
                                    <p class="title">
                                        {{item.data.name}}
                                    </p>
                                </a>
                                <span class="price">£{{item.auction.price}}</span>
                                
                            </div>
                        </div>
                    </div>

                    <div class="large-4 columns tabber-content" data-content="dec">
                        <div class="programme-guide">




                            <?php
                                $join_str   = array();
                                $data       = @json_decode( file_get_contents($ibiza_api::api_location . '/ProductCatalog.api/api/legacy/tvschedule/82' ) );
                            ?>
                            <div class="programme-guide-title">
                                <img src="<?php echo get_template_directory_uri()?>/assets/images/Icon_AuctionPage_ProgrammeGuide.svg" />
                                <h3 class="hide-for-medium-down">Programme Guide</h3>
                            </div>

                            <div class="small-12 columns" style="padding:0 30px 30px 30px;">
                                <div class="swiper-container-tv-schedule" style="position: relative;overflow: hidden; background:rgba(255,255,255,0.75);">
                                    <div class="small-12 no-padding programme-guide-switcher">
                                        <div class="small-2 columns">
                                            <div class="swiper-button-prev" style="position: static;margin:0;"></div>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php
                                            foreach( $data as $tv ){
                                            $shows[  date( 'd-my-', strtotime( $tv->fromDate ) ) ][] = $tv;
                                            }
                                            if(isset($shows)):
                                                $i = 0;
                                                foreach( $shows as $day=>$tvs ):
                                                    $i++;
                                                    ?>
                                                    <div class="pg-day-and-date <?php if($i > 1) echo 'hide'; ?>">
                                                        <h4><?php print_r($tvs[0]->fromDate); ?></h4>
                                                        <small><?php print_r($tvs[0]->fromDate); ?></small>
                                                    </div>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                        <div class="small-2 columns">
                                            <div class="swiper-button-next" style="position: static;margin:0;"></div>
                                        </div>
                                    </div>

                                    <div class="swiper-wrapper"> 
                                        <?php 
                                        foreach( $data as $tv ){
                                            $shows[  date( 'd-my-', strtotime( $tv->fromDate ) ) ][] = $tv;
                                        }
                                        if(isset($shows)):
                                            foreach( $shows as $day=>$tvs ): 
                                        ?>
                                            <div class="swiper-slide" >
                                                <div class="columns small-3 text-center" style="top:-1000px;position:absolute;line-height:28px"><?php print( date( 'l', strtotime( $day ) ) ); ?><br /><?php print( date( 'm', strtotime( $day ) ) ); ?><sup><?php print( date( 'S', strtotime( $day ) ) ); ?></sup> <?php print( date( 'Y', strtotime( $day ) ) ); ?></div>
                                                <?php 
                                                
                                                foreach( $tvs as $d ): ?>
                                                <div class="programme-guide-slot">
                                                    <div class="show-time"><?php echo  date( 'H:i' , strtotime( $d->fromDate) ) ?> - <?php echo  date( 'H:i' , strtotime( $d->toDate) ) ?></div>
                                                    <div class="show-title"><?php print_r($d->title);  ?></div>
                                                    <a class="show-details">DETAILS  &#x2304;</a>
                                                    <div class="show-details-content"><?php print_r($d->synopsis); ?></div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>                
                                        <?php endforeach; 
                                        endif; ?>
                                    </div>
                                </div>
                            </div>




                        </div>

                        <script type="text/javascript">
                            jQuery('.show-details').click(function(){
                                jQuery(this).next('.show-details-content').slideToggle();
                            });

                            var mySwiperTvS = null;
                            jQuery( document ).ready(function() {
                                mySwiperTvS = new Swiper('.swiper-container-tv-schedule', {
                                    nextButton : '.swiper-button-next',
                                    prevButton : '.swiper-button-prev',
                                    onSlideChangeEnd: function(){
                                        jQuery('.pg-day-and-date:not(.hide)').addClass('hide');
                                        jQuery('.pg-day-and-date').eq(jQuery('.swiper-container-tv-schedule .swiper-slide-active').index()).removeClass('hide');

                                    }
                                });
                                jQuery('.pg-day-and-date').each(function(){
                                    var pgDate = new Date(jQuery(this).children('h4').text());
                                    var pgDays = ['Sunday','Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday'];
                                    var pgMonths = ['January','February', 'March', 'April', 'May', 'June', 'July', 'August', 'October', 'November', 'December'];
                                    jQuery(this).children('h4').text(pgDays[pgDate.getDay()]);
                                    jQuery(this).children('small').text(pgDate.getDate() + ' ' + pgMonths[pgDate.getMonth()-1] + ' ' +pgDate.getFullYear());
                                });
                            });
                        </script>

                        <div class="newsletter hide-for-medium-down">
                            <div class="small-12 columns">
                                <div class="header-area">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/Icon_Email_SignUp.svg" />
                                    <h3>Email Newsletter Sign Up</h3>
                                </div>
                                <p>Stay up to date with news of upcoming shows highlighting different themes, exclusive offers, guest designers and special products.</p>
                                <label for="emailSignup">Email Address</label>
                                <input id="emailSignup" type="" style="height: 37px" placeholder="yourname@emailaddress.co.uk" /><button aria-expanded="false" aria-haspopup="true" data-yeti-box="example-dropdown2" data-is-focus="false" aria-controls="example-dropdown2" class="button" type="submit" style="vertical-align: top">Submit</button>
                            </div>
                        </div>
                    </div>

                    <div class="small-12 columns hide-for-large">
                        <div class="newsletter">
                            <div class="small-12 columns">
                                <div class="header-area">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/Icon_Email_SignUp.svg" />
                                    <h3>Email Newsletter Sign Up</h3>
                                </div>
                                <p>Stay up to date with news of upcoming shows highlighting different themes, exclusive offers, guest designers and special products.</p>
                                <label for="emailSignup">Email Address</label>
                                <input id="emailSignup" type="" style="height: 37px" placeholder="yourname@emailaddress.co.uk" /><button aria-expanded="false" aria-haspopup="true" data-yeti-box="example-dropdown2" data-is-focus="false" aria-controls="example-dropdown2" class="button" type="submit" style="vertical-align: top">Submit</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </main> <!-- end #main -->

<!--- TEMP OFF CANVAS AREA -->
<div class="row">
    <div class="large-4 large-offset-4 columns auction-off-canvas">
        <div class="small-12">
            <h2>{{titleOC}}</h2>
            <p class="product-code">Product Code: <span>{{productcodeOC}}</span></p>
            <div class="row price-qty-row">
                <h4>£{{priceOC}}</h4>
            </div>
            <a id="single_image_OC" href="{{mainPhoto}}" class="main-photo-wrap">
                <div class="main-photo columns" style="background-image: url('{{mainPhotoOC}}');"><span class="enlarge">&#128269; click image to enlarge</span></div>
            </a>
            <div class="small-5 columns qty" ng-if="isLoggedIn == 'true'">
                <div class="small-2 medium-2 large-2 columns increment">
                    <a href="#" id="remove_quantity">-</a>
                </div>

                <div class="small-6 medium-6 large-6 columns" style="padding:0;">
                    <input type="number" id="quantity" value="1">
                    <input type="number" name="input" value="1" ng-model="qtyOC"
           min="0" max="99">
                </div>
                <div class="small-2 medium-2 large-2 columns increment end">
                    <a href="#"  id="add_quantity">+</a>
                </div>
            </div>
            <div class="small-12 columns" ng-if="isLoggedIn == 'true'">
                <div class="addToBasketVars" data-productPrice = "{{priceOC}}" data-productName = "{{titleOC}}" data-productDetailID = "{{prodDetailOC}}" data-auctionID = "{{auctionIdOC}}" data-productCode = "{{productcodeOC}}" data-quantity = "{{qtyOC}}" data-image_url = "{{mainPhotoOC}}">{{qtyOC}}</div>
                <input type="button" value="ADD TO BASKET" class="add-to-basket" />
            </div>
            <div class="hideOnLogin" ng-if="isLoggedIn != 'true'">
                <div class="small-12 columns no-padding">
                    <input ng-click="pollForLogin" type="button" value="LOGIN TO BUY" class="login-to-buy login-window-popup" id="inline" href="#data" />
                </div>
                <div class="large-6 medium-6 columns no-padding-right">
                    <p class="create-account">or <a href="#">Create an account</a></p>
                </div>

                <!--login window-->
                <div style="display:none">
                    <div id="data">
                        <iframe src="http://secure.ibiza.com.uat/login.aspx" style="border: 0px none;  height: 485px;  width: 400px; max-width: 100%; max-height: 100%;"></iframe>
                    </div>
                </div>
            </div>
            <div class="small-12 columns auction-description tabber">
                <div class="large-12 no-padding tab-house">
                    <div data-tabbed="descOC" class="tabber-tab active">Description <div class="down-arrow"></div></div>
                    <div data-tabbed="specOC" class="tabber-tab">Specifications <div class="down-arrow"></div></div>
                    <div style="clear: both;"></div>
                </div>
                <div class="tabber-content active" data-content="descOC">
                    <p>{{descOC}}</p>
                </div>
                <div class="tabber-content" data-content="specOC">
                    <p>{{specOC}}</p>
                </div>
            </div>
        </div>    
    </div>
<!--- TEMP OFF CANVAS AREA END -->

    </div> <!-- end #inner-content -->    
    
</div> <!-- end #content -->

<script src="http://www.jewellerymaker.com/global/js/vendor/plugins/flowplayer/flowplayer.min.js"></script>
<script type="text/javascript" src="http://www.jewellerymaker.com/global/js/vendor/plugins/hls/hls.min.js"></script>
<!-- angular -->
<script src="<?php echo get_template_directory_uri(); ?>/vendor/angular/angular.min.js" type='text/javascript'></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/app-auction.js"></script>

<script type="text/javascript" src="//cdn.jewellerymaker.com/global/js/video.js"></script>
<script type="text/javascript">
    function resizeSlider(){
        if(jQuery(window).width() <= 1023){
            jQuery('.swiper-slide').each(function(){
                jQuery(this).height(500);
            });
        }else{
            jQuery('.swiper-slide').each(function(){
                jQuery(this).height('auto');
            });
            jQuery('.swiper-slide').each(function(){
                jQuery(this).height(jQuery(this).parents('#inner-content').height());
            });
        }
    };

    //Tabber
    function initTabs(){
        jQuery('.tabber').each(function(){
            var papa = jQuery(this);
            if(papa.find('.tab-house').is(':visible')){
                papa.addClass('is-active');
                papa.find('[data-tabbed]').off('click');//clear any old listeners
                papa.find('[data-tabbed]').on('click', function(){
                    papa.find('.tabber-content.active').removeClass('active');
                    papa.find('.tabber-tab.active').removeClass('active');
                    jQuery('[data-content='+jQuery(this).data('tabbed')+']').addClass('active');
                    jQuery('[data-tabbed='+jQuery(this).data('tabbed')+']').addClass('active');
                    papa.addClass('active');
                });
            }else{
                papa.removeClass('is-active');
            };
        });
    };

    jQuery(function () {


        jQuery(document).on('click', '.add-to-basket', function() {
            
            if(jQuery(this).parent().find('.addToBasketVars')){
                var productPrice        = jQuery(this).parent().find('.addToBasketVars').data('productPrice');
                var productName         = jQuery(this).parent().find('.addToBasketVars').data('productName');
                var productDetailID     = jQuery(this).parent().find('.addToBasketVars').data('productDetailID');
                var auctionID           = jQuery(this).parent().find('.addToBasketVars').data('auctionID');
                var productCode         = jQuery(this).parent().find('.addToBasketVars').data('productCode');
                var quantity            = jQuery(this).parent().find('.addToBasketVars').data('quantity');
                var image_url           = jQuery(this).parent().find('.addToBasketVars').data('image_url');
            }else{
                var productPrice        = jQuery('.price-qty-row h4').text();
                var productName         = jQuery('.title-row h2').text();
                var productDetailID     = jQuery('#main-item-IDs').attr('data-legacy-id');
                var auctionID           = jQuery('#main-item-IDs').attr('data-auction-id');
                var productCode         = jQuery('.title-row .product-code span').text();
                var quantity            = jQuery('#quantity').val();
                var image_url           = jQuery('#single_image').attr('href');
            }
            
            if( jQuery('#main-variant').length > 0 ){
                
                if( jQuery('#main-variant').val().length<=0 ){
                    return alert('No product selected');
                }
                
                productDetailID = jQuery('#main-variant').val();
                
            }
            
            updateBasket( productName  , productPrice , image_url  );
            
            jQuery.ajax({
                dataType: 'json',
                url: '/proxy.php?auctionID='+ auctionID +'&productCode=' + productCode + '&productDetailID=' + productDetailID + '&quantity=' + quantity
            }).done(function (data) {



                //jQuery('#basket-total').text('£' + data.basketTotal.toFixed(2));
                //jQuery('#basket-description').text(data.description);

            });            
            

        });

        jQuery('.back-button').click(function(){
            window.history.back();
        });

        initTabs();

        jQuery('[id$="dvVideoHolderHome"]').Video({
            container: 'dvVideoHolderHome',
            channel: 'JEWELLERYMAKER',
            autoStart: true,
            controls: false,
            mute: true,
            //quality: 'thumbnail',
            pageIdentifier: 'homepage',
            edge: '',
         });


       jQuery('#add-basket').click( function( e ){

           var quantity    = 1;

           jQuery.ajax({
               dataType  : 'json' ,
               url: 'http://<?php echo $_SERVER['SERVER_NAME']; ?>/proxy.php?auctionID=-1&productCode=<?php echo 'WTTY01'; //$response['_source']['legacyCode']; ?>&productDetailID=<?php echo '361247'; //$response['_source']['product']['productDetailId']; ?>&quantity=' + quantity
           }).done(function( data ) {

               jQuery('#basket-total').text('£' +  data.BasketTotal );
               jQuery('#basket-description').text('£' +  data.Description );                    
               window.location = 'https://secure.<?php echo $_SERVER['SERVER_NAME']; ?>/basket.aspx';

             });
        });

       //hero slider height
        jQuery('.swiper-slide').each(function(){
            resizeSlider();
        });

        jQuery("a#single_image").fancybox({
            padding: 0,
            nextEffect: 'none',
            prevEffect: 'none'
        });

        jQuery("a#single_image_OC").fancybox({
            padding: 0,
            nextEffect: 'none',
            prevEffect: 'none'
        });

        jQuery(".login-window-popup").fancybox({
            padding: 0,
            nextEffect: 'none',
            prevEffect: 'none'
        });

    });

    jQuery(window).resize(function(){
        resizeSlider();
        initTabs();
    });

    angular.element(document).ready(function() {
        setTimeout(function(){
            //product thumb slider
            var house = jQuery('.thumb-photos');
            var ul = jQuery('.thumb-photos ul');
            var li = jQuery('.thumb-photos li');
            var liHi = li.outerHeight();
            var downScrolls = 0;
            var noVisible = 3;
            if(noVisible < li.length){
                house.css({'overflow':'hidden', 'height': (liHi*noVisible)+'px'});
                house.before('<div class="circularButtonUp" style="opacity: 0.35;"></div>');
                house.after('<div class="circularButtonDown"></div>');
                function fadeButtons(){
                    jQuery('.circularButtonUp, .circularButtonDown').css('opacity', '1');
                    if(downScrolls == 0){
                        jQuery('.circularButtonUp').css('opacity', '0.35');
                    }else if(downScrolls == (li.length - noVisible)){
                        jQuery('.circularButtonDown').css('opacity', '0.35');
                    }
                }
                jQuery('.circularButtonUp').click(function(){
                    if(downScrolls > 0){
                        downScrolls --;
                        ul.animate({'margin-top': -(liHi*downScrolls)+'px'}, 200);
                    }
                    fadeButtons();
                });
                jQuery('.circularButtonDown').click(function(){
                    if(downScrolls < (li.length - noVisible)){
                        downScrolls ++;
                        ul.animate({'margin-top': -(liHi*downScrolls)+'px'}, 200);
                    }
                    fadeButtons();
                });
            };
            //jQuery('.main-photo').height(jQuery('.thumb-photos-house').height());
        }, 1000);
    });

var loginInterval;
var userIsLoggedIn = false;

</script>
<?php get_footer(); ?>