<?php
/*
  Template Name: Auction Template
 */

//enqueue header
wp_enqueue_script('angular-js', get_template_directory_uri() . '/vendor/angular/angular.min.js', array('jquery'), '', false);
wp_enqueue_script('angular-ui-swiper-js', get_template_directory_uri() . '/assets/js/angular-ui-swiper.min.js', array('angular-js'), '', false);

//enqueue footer
wp_enqueue_script('video-js',  'http://www.jewellerymaker.com/global/js/vendor/plugins/flowplayer/flowplayer.min.js', array('jquery'), '', true); 
wp_enqueue_script('video1-js',   'http://www.jewellerymaker.com/global/js/vendor/plugins/hls/hls.min.js', array('jquery'), '', true);
wp_enqueue_script('video2-js', get_template_directory_uri() . '/assets/js//video.js', array('jquery'), '', true); 
wp_enqueue_script('auction-page-js', get_template_directory_uri().'/assets/js/auction-page.js', array('jquery'), '', true);
wp_enqueue_script('auction-app-js', get_template_directory_uri().'/assets/js/app-auction.js', array('angular-js', 'auction-page-js'), '', true);

get_header(); ?>

<div id="content">
    <div id="operationLogInfo"></div>
    
    <div id="inner-content" class="home-inner-content row" ng-controller="AuctionPage" ng-app="ibiza-auction">

        <main class="large-12 columns auction-page" role="main">

            <div class="row header-row">
                <div class="large-12 columns">
                    <div class="large-12 columns white-house">
                        <div class="small-12 column show-for-small-only no-padding"><div class="back-button" onclick="window.history.back();">&lt; BACK</div></div>
                        <ul class="breadcrumbs show-for-medium">
                            <li><a href="<?php get_template_directory_uri(); ?>" title="Home page link">Home</a></li>
                            <li class="current"><a <?php /*href="<?php get_template_directory_uri(); ?>"*/?> title="Watch Online Link">Watch</a></li>
                        </ul>
                        <h2 class="auction-title"><?php the_title(); ?></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <div class="large-8 columns tv-wrap">
                        <div id="dvVideoHolderLive" class="dark-background">
                                                 <img src="<?php echo get_template_directory_uri(); ?>/assets/images/stream.jpg" alt="Auction page icon" title="Auction page icon" />

                        </div>
                        <div class="show-for-large row no-padding columns auction-on-next-large white-house" ng-cloak vertilize-container>
                            <div class="medium-6 no-padding columns on-now-box" vertilize>
                                <div class="large-3 columns no-padding on-now"><p>On Now</p></div>
                                <div class="large-9 columns">
                                    <h4>{{onNow.fromTo}}</h4>
                                    <p>
                                        <strong>{{onNow.title}}</strong> {{onNow.synopsis}}
                                        <span ng-hide="onNow.fromTo || onNow.title || onNow.synopsis">We're having problems connecting to the TV schedule.</span>
                                    </p>
                                </div>
                            </div>
                            <div class="medium-6 no-padding columns on-now-box" data-sizeref="1" vertilize>
                                <div class="large-3 columns no-padding on-now"><p>On Next</p></div>
                                <div class="large-9 columns">
                                    <h4>{{onNext.fromTo}}</h4>
                                    <p>
                                        <strong>{{onNext.title}}</strong> {{onNext.synopsis}}
                                        <span ng-hide="onNow.fromTo || onNow.title || onNow.synopsis">We're having problems connecting to the TV schedule.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="large-4 medium-8 columns auction-buy-panel custom-breakpoint-full white-house" ng-cloak itemscope itemtype ="http://schema.org/Product">
                        <div class="small-12 column">
                            <div class="triangle"></div>
                            <div class="aution-buy-pointer"></div>
                            <div class="row title-row">
                                <div class="large-12 columns">
                                    <h2 itemprop="name" ng-show="productData.data.name">{{productData.data.name}}</h2>
                                    <p class="product-code" ng-show="productData.data.productcode">Product Code: <span>{{productData.data.productcode}}</span></p>
                                </div>
                            </div>
                            <div class="row price-qty-row">
                                <div class="large-8 medium-8 small-6 columns no-padding-left" ng-init="productData.data.quantity = 1"><!-- the ng-init is to stop 'SoldOut' showing initially-->
                                    <h4 ng-if="productData.data.quantity">£{{productData.auction.price}}</h4>
                                    <span ng-if="productData.data.quantity == 0"><img class="sold-out"  src="<?php echo get_template_directory_uri()?>/assets/images/red-cross.svg"  alt="Red cross image"   title="Red cross  image" /> Sold Out</span>
                                </div>
                                <div class="large-4 medium-4 small-5 columns qty no-padding" ng-if="isLoggedIn == 'true'">
                                    <div class="clickBlock" ng-if="!productData.data.quantity"></div>
                                    <div class="quantity-sq top-qty">
                                        <input id="quantity" class="primary" type="number" min="1" max="{{$parent.productData.data.quantity}}" value="{{$parent.productData.data.quantity < hiddenVal ? $parent.productData.data.quantity : hiddenVal }}">
                                        <input type="number"  class="hiddenVal hidden" ng-model="hiddenVal">
                                    </div>
                                </div>
                            </div>
                            <div class="row buy-panel-buttons">
                                    <div class="clickBlock" ng-if="!productData.data.quantity && isLoggedIn == 'true'"></div>
                                    <div class="large-12 columns" ng-if="isLoggedIn == 'true' && productData.auction.variant && 1 == 0"><!-- Remove '&& 1 == 0' when variants are being added back in -->
                                        <label for="main-variant">{{productData.auction.variant}}</label>
                                        <select id="main-variant" ng-model="$parent.mainItemAuctionLegacyId" convert-to-number>
                                            <option ng-repeat="variants in productData.auction.variation" value="{{variants.legacycode}}">{{variants.option}}</option>
                                        </select>
                                    </div>
                                    <div class="large-12 columns" ng-if="isLoggedIn == 'true'">
                                        <div id="main-item-IDs" data-auction-id="{{productData.auction.id}}" data-legacy-id="{{mainItemAuctionLegacyId}}"  class="hidden"></div>
                                        <input type="button" value="ADD TO BASKET" class="add-to-basket" />
                                    </div>
                                    <div class="hideOnLogin small-12 columns" ng-if="isLoggedIn != 'true'">
                                        <div class="small-12 columns login-correction no-padding">
                                            <!--
                                            <input ng-click="pollForLogin()" type="button" value="LOGIN TO BUY" class="login-to-buy login-window-popup" id="inline" href="#data" />-->
                                            <a href="<?php echo $ibiza_api::$end_points['login_page']; ?>" title="Login link">
                                                <input type="button" value="LOGIN TO BUY" class="login-to-buy login-window-popup" id="inline" href="<?php echo $ibiza_api::$end_points['login_page']; ?>" />
                                            </a>
                                        </div>
                                        <div class="small-12 columns login-correction">
                                            <p class="create-account">or <a href="<?php echo $ibiza_api::$end_points['login_page']; ?>" title="Create account">Create an account</a></p>
                                        </div>

                                        <!--login window
                                        <div class="hidden">
                                            <div id="data">
                                                <iframe src="http://secure.ibiza.com.uat/login.aspx" style="border: 0px none;  height: 485px;  width: 400px; max-width: 100%; max-height: 100%;"></iframe>
                                            </div>
                                        </div>-->
                                    </div>
                            </div>
                            <div class="row product-gallery">
                                <div class="large-12 columns">
                                    <div class="large-12 columns hide-for-large-up no-padding" ng-show="productData.data.images">
                                        <section class="swipe">
                                            <swiper class="thumb-swipe-main-mob">
                                                <slides>
                                                    <slide ng-repeat="pics in productData.data.images">
                                                        <a id="single_image" ng-show="mainPhoto" href="{{pics.url}}" class="main-photo-wrap" title="Show image">
                                                            <div class="main-photo columns" style="background-image: url('{{pics.url}}');" itemprop="image"><span class="enlarge">&#128269; click image to enlarge</span></div>
                                                        </a>
                                                    </slide>
                                                </slides>
                                            </swiper>
                                            <pagination class="pagination-outer"></pagination>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </section>
                                    </div>

                                    <a id="single_image" ng-show="mainPhoto" href="{{mainPhoto}}" class="main-photo-wrap large-9 columns hide-for-medium-down" title="Show image">
                                        <div class="main-photo columns" style="background-image: url('{{mainPhoto}}');"><span class="enlarge">&#128269; click image to enlarge</span></div>
                                    </a>

                                    <div class="large-3 columns thumb-photos-house hide-for-medium-down" ng-show="productData.data.images">
                                        <section class="swipe">
                                            <swiper class="thumb-swipe-main" direction="vertical" slides-per-view="3">
                                                <slides>
                                                    <slide ng-repeat="pics in productData.data.images">
                                                        <div class="prodThumb" ng-click="changeMainPhoto(pics.url)" style="background-image: url({{pics.url}});"></div>
                                                    </slide>
                                                </slides>
                                            </swiper>
                                                <div class="swiper-button-next circularButtonDown"></div>
                                                <div class="swiper-button-prev circularButtonUp"></div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                            <div class="row part-sell" ng-if="partSell">
                                <div class="small-12 columns"><div class="small-12 columns dotted-border"></div></div>
                                <div class="small-12 columns">
                                    <h4>Related Product</h4>
                                </div>
                                <div ng-click="changeOffCanvas('$scope.partSell')" class="pointer">
                                    <div class="small-4 columns part-sell-img">
                                        <img src="{{partSell.data.images[0].url}}" alt="{{partSell.data.images[0].alttext}}" title="Main Auction Photo" />
                                    </div>
                                    <div class="small-8 columns part-sell-text">
                                        <p>{{partSell.data.name}}</p>
                                        <p class="part-sell-price">£{{partSell.auction.price}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-for-large custom-breakpoint-full medium-4 columns" ng-cloak>
                        <div class="medium-12 no-padding columns auction-on-next-small">
                                <div class="medium-12 no-padding columns">
                                    <div class="large-12 medium-12 small-4 columns on-now-small"><p class="no-margin">On Now</p></div>
                                    <div class="medium-12 small-8 columns">
                                        <h4>{{onNow.fromTo}}</h4>
                                    <p>
                                        <strong>{{onNow.title}}</strong> {{onNow.synopsis}}
                                        <span ng-hide="onNow.fromTo || onNow.title || onNow.synopsis">We're having problems connecting to the TV schedule.</span>
                                    </p>
                                    </div>
                                </div>
                                <div class="medium-12 no-padding columns" ng-hide="onNext.title == 'Close' && onNow.title == 'Close'">
                                    <div class="large-12 medium-12 small-4 columns on-now-small">
                                        <p class="no-margin">On Next</p>
                                    </div>
                                    <div class="medium-12 small-8 columns">
                                        <h4>{{onNext.fromTo}}</h4>
                                        <p>
                                            <strong>{{onNext.title}}</strong> {{onNext.synopsis}}
                                            <span ng-hide="onNow.fromTo || onNow.title || onNow.synopsis">We're having problems connecting to the TV schedule.</span>
                                        </p>
                                    </div>
                                </div>   
                        </div>
                        <div class="medium-12 no-padding columns message-the-studio-small">
                            <div class="medium-12 columns" ng-if="isLoggedIn == 'true'">
                                <form ng-submit="mtsSubmit()">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/message-the-studio.svg" alt="Message the studio image" title="Message to studio image" />
                                    <h3>Message The Studio</h3>
                                    <?php
                                        if(_LOGGED_IN):
                                        $cookieStr = $_COOKIE['sec'];
                                        parse_str($cookieStr, $output); 
                                        echo('<input type="number" class="hide" ng-model="mtsFormData.mtsCustomerId" ng-init="mtsFormData.mtsCustomerId = '.$output['ci'].'" />');
                                        endif;
                                    ?>
                                    <textarea ng-model="mtsFormData.mtsTextarea" maxlength="500"></textarea>
                                    <label class="anon" for="send-message"><input ng-model="mtsFormData.mtsAnon" ng-init="mtsFormData.mtsAnon = false" type="checkbox" name="anon" /> Send Anonymously</label>
                                    <input class="button green-submit-button" type="submit" value="SEND MESSAGE" name="send-message">
                                </form>
                            </div>
                            <div class="medium-12 columns" ng-if="isLoggedIn != 'true'">
                                <img src="<?php echo get_template_directory_uri()?>/assets/images/message-the-studio.svg" alt="Message the studio image" title="Message to studio image" />
                                <h3>Message The Studio</h3>
                                <p>Got questions or just want to get involved?</p>
                                <p>
                                    <a href="<?php echo $ibiza_api::$end_points['login_page']; ?>" title="Login page">Login</a>
                                    <br />or<br />
                                    <a href="<?php echo $ibiza_api::$end_points['login_page']; ?>" title="Create an account">Create an account</a>
                                </p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <div class="description-wrap" ng-cloak>
                        <div class="large-4 show-for-large columns">
                            <div class="message-the-studio-large" ng-if="isLoggedIn == 'true'">
                                    <form ng-submit="mtsSubmit()">
                                        <img src="<?php echo get_template_directory_uri()?>/assets/images/message-the-studio.svg" alt="Message the studio image" title="Message to studio image" />
                                        <h3>Message The Studio</h3>
                                        <?php
                                            if(_LOGGED_IN):
                                            $cookieStr = $_COOKIE['sec'];
                                            parse_str($cookieStr, $output); 
                                            echo('<input type="number" class="hide" ng-model="mtsFormData.mtsCustomerId" ng-init="mtsFormData.mtsCustomerId = '.$output['ci'].'" />');
                                            endif;
                                        ?>
                                        <textarea ng-model="mtsFormData.mtsTextarea" maxlength="500"></textarea>
                                        <label class="anon" for="send-message"><input ng-model="mtsFormData.mtsAnon" ng-init="mtsFormData.mtsAnon = false" type="checkbox" name="anon" /> Send Anonymously</label>
                                        <input class="button green-submit-button" type="submit" value="SEND MESSAGE" name="send-message">
                                    </form>
                            </div>
                            <div class="message-the-studio-large" ng-if="isLoggedIn != 'true'">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/message-the-studio.svg" alt="Message the studio image" title="Message to studio image" />
                                    <h3>Message The Studio</h3>
                                    <p>Got questions or just want to get involved?
                                        <br />
                                        <a href="<?php echo $ibiza_api::$end_points['login_page']; ?>" title="Login page">Login</a> or <a href="<?php echo $ibiza_api::$end_points['login_page']; ?>" title="Create an account page">Create an account</a>
                                    </p>
                            </div>
                        </div>
                        <div class="large-8 medium-12 columns auction-description tabber">
                            <p ng-show="productData.data.name">More information about {{productData.data.name}}</p>
                            <div class="large-12 no-padding tab-house">
                                <div data-tabbed="desc" class="tabber-tab active" itemprop="disambiguatingDescription">Description <div class="down-arrow"></div></div>
                                <div data-tabbed="spec" class="tabber-tab">Specifications <div class="down-arrow"></div></div>
                                <div class="clear"></div>
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

            <div class="row todays-items-row column">
                <div class="white-house tabber">
                    <div class="white-panel left"></div>
                    <div class="white-panel right"></div>

                    <div class="row hide-for-large tab-house">
                        <div class="medium-12 columns">
                            <div class="medium-6 small-6 columns tabber-tab lower active" data-tabbed="ant">Products From Today's Show</div>
                            <div class="medium-6 small-6 columns tabber-tab lower" data-tabbed="dec">Programme Guide</div>
                        </div>
                    </div>

                    <div class="large-8 columns tabber-content active" data-content="ant" ng-cloak>
                        <h3 class="hide-for-medium-down">Products From Today's Show</h3>
                        <p ng-show="todaysProductsData.data.length == 0" ng-cloak>Please wait, products from today's show will appear here shortly.</p>
                        <div class="row todays-product-row" vertilize-container>
                            <div ng-repeat="item in todaysProductsData.data" class="large-3 medium-4 small-6 columns todays-product" ng-class="{'end':$last}" vertilize>
                                <a ng-click="changeOffCanvas('$scope.todaysProductsData.data['+$index+']')" title="..">
                                    <img src="{{item.data.images[0].url}}" alt="Image" title="Image" />
                                    <p class="title">
                                        {{item.data.name}}
                                    </p>
                                </a>
                                <span class="price" ng-if="item.data.quantity">£{{item.auction.price}}</span>
                                <span ng-if="item.data.quantity == 0"><img class="sold-out" src="<?php echo get_template_directory_uri()?>/assets/images/red-cross.svg" alt="Sold out image"  title="Sold out image" /> Sold Out</span>
                            </div>
                        </div>
                    </div>

                    <div class="large-4 columns tabber-content" data-content="dec">
                        <div class="programme-guide">
                            <?php
                                $response   = getSslPage( $ibiza_api::$end_points['tvschedule'] );
                                $join_str   = array();
                                $data       = json_decode($response);
                            ?>
                            <div class="programme-guide-title">
                                <img src="<?php echo get_template_directory_uri()?>/assets/images/Icon_AuctionPage_ProgrammeGuide.svg"  alt="Programme guide image"  title="Programme guide image" />
                                <h3 class="hide-for-medium-down">Programme Guide</h3>
                            </div>

                            <div class="small-12 columns swiper-container-tv-schedule-con">
                                <div class="swiper-container-tv-schedule">
                                    <div class="small-12 no-padding programme-guide-switcher">
                                        <div class="small-2 columns no-padding">
                                            <div class="swiper-button-prev"></div>
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
                                                        <h4 class="hide"><?php print_r($tvs[0]->fromDate); ?></h4>
                                                        <small class="hide"><?php print_r($tvs[0]->fromDate); ?></small>
                                                    </div>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                        <div class="small-2 columns no-padding">
                                            <div class="swiper-button-next"></div>
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
                                            <div class="swiper-slide">
                                                <?php 
                                                foreach( $tvs as $d ): ?>
                                                <div class="programme-guide-slot">
                                                    <div class="show-time"><?php echo  date( 'H:i' , strtotime( $d->fromDate) ) ?> - <?php echo  date( 'H:i' , strtotime( $d->toDate) ) ?></div>
                                                    <div class="show-title"><?php print_r($d->title);  ?></div>
                                                    <a class="show-details upper">Details</a>
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

                        <div class="newsletter hide-for-medium-down">
                            <div class="small-12 columns">
                                <div class="header-area">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/Icon_Email_SignUp.svg" alt="Email Icon" title="Email Icon" />
                                    <h3>Email Newsletter Sign Up</h3>
                                </div>
                                <p>Stay up to date with news of upcoming shows highlighting different themes, exclusive offers, guest designers and special products.</p>
                                <label for="emailSignup">Email Address</label>
                                <input class="emailSignup" type="text"   placeholder="yourname@emailaddress.co.uk" /><button aria-expanded="false" aria-haspopup="true"   data-is-focus="false"    class="signup-submit button"  type="submit">Submit</button>
                            </div>
                        </div>
                    </div>

                    <div class="small-12 columns hide-for-large">
                        <div class="newsletter">
                            <div class="small-12 columns">
                                <div class="header-area">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/Icon_Email_SignUp.svg"  alt="Email Icon" title="Email Icon" />
                                    <h3>Email Newsletter Sign Up</h3>
                                </div>
                                <p>Stay up to date with news of upcoming shows highlighting different themes, exclusive offers, guest designers and special products.</p>
                                <label for="emailSignup">Email Address</label>
                                <input class="emailSignup" type="text"   placeholder="yourname@emailaddress.co.uk" /><button aria-expanded="false" aria-haspopup="true"  data-is-focus="false"   class="signup-submit button"  type="submit">Submit</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </main> <!-- end #main -->

<!--- TODAYS ITEMS OFF CANVAS AREA -->
<div class="aoc-darken-body"></div>
<div class="large-4 medium-10 small-12 large-offset-4 columns auction-off-canvas" ng-cloak>
    <div class="small-12">
        <div class="back-button aoc-cancel">X Cancel</div>
        <h2>{{titleOC}}</h2>
        <p class="product-code" ng-show="productcodeOC">Product Code: <span>{{productcodeOC}}</span></p>
        <div ng-if="maxQtyOC" class="price-qty-row">
            <h4>£{{priceOC}}</h4>
        </div>
        <span ng-if="maxQtyOC == 0" class="aoc-sold-out"><img class="sold-out-image" src="<?php echo get_template_directory_uri()?>/assets/images/red-cross.svg"   alt="Red cross image" title="Red cross image" /> Sold Out</span>

        <section class="swipe" ng-show="allPhotos">
            <swiper instance="swiperOC" observe-parents="true" observer="true" class="thumb-swipe-main-mob">
                <slides>
                    <slide ng-repeat="pics in allPhotos">
                        <a id="single_image" ng-show="{{pics.url}}" href="{{pics.url}}" class="main-photo-wrap large-12 medium-8 columns" title="Show image">
                            <div class="main-photo columns" style="background-image: url('{{pics.url}}');"><span class="enlarge">&#128269; click image to enlarge</span></div>
                        </a>
                    </slide>
                </slides>
            </swiper>
            <pagination class="pagination-outer"></pagination>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </section>

        <div class="small-12 columns qty no-padding quantity-sq-wrap" ng-if="isLoggedIn == 'true'">
            <div class="clickBlock" ng-if="!$parent.maxQtyOC"></div>
            <div class="quantity-sq top-qty">
                <input class="primary" type="number" min="1" max="{{$parent.maxQtyOC}}" value="{{$parent.maxQtyOC < AOChiddenVal ? $parent.maxQtyOC : AOChiddenVal }}">
                <input type="number"   class="hiddenVal hidden" ng-model="AOChiddenVal">
            </div>
        </div>

        <!-- Are there variants in the todays products list?
        <div class="large-12 columns" ng-if="isLoggedIn == 'true' && productData.auction.variant">
            <label for="main-variant">{{productData.auction.variant}}</label>
            <select id="main-variant" ng-model="$parent.prodDetailOC" convert-to-number>
                <option ng-repeat="variants in productData.auction.variation" value="{{variants.legacycode}}">{{variants.option}}</option>
            </select>
        </div> -->

        <div class="small-12 columns no-padding" ng-if="isLoggedIn == 'true'">
            <div class="clickBlock" ng-if="!$parent.maxQtyOC && isLoggedIn == 'true'"></div>
            <div class="addToBasketVars" data-productPrice = "{{priceOC}}" data-productName = "{{titleOC}}" data-productDetailID = "{{prodDetailOC}}" data-auctionID = "{{auctionIdOC}}" data-productCode = "{{productcodeOC}}" data-quantity = "{{qtyOC}}" data-image_url = "{{mainPhotoOC}}"></div>
            <input type="button" value="ADD TO BASKET" class="add-to-basket" />
        </div>
        <div class="hideOnLogin small-12 columns relative" ng-if="isLoggedIn != 'true'">
            <div class="small-12 columns no-padding">
                <!--<input ng-click="pollForLogin" type="button" value="LOGIN TO BUY" class="login-to-buy login-window-popup" id="inline" href="#data" />-->
                <a href="<?php echo $ibiza_api::$end_points['login_page']; ?>" title="Login page">
                    <input type="button" value="LOGIN TO BUY" class="login-to-buy login-window-popup" id="inline" href="<?php echo $ibiza_api::$end_points['login_page']; ?>" />
                </a>
            </div>
            <div class="small-12 columns no-padding-right">
                <p class="create-account">or <a href="<?php echo $ibiza_api::$end_points['login_page']; ?>" title="Create an account page">Create an account</a></p>
            </div>

            <!--login window
            <div class="hidden">
                <div id="data">
                    <iframe src="http://secure.ibiza.com.uat/login.aspx" style="border: 0px none;  height: 485px;  width: 400px; max-width: 100%; max-height: 100%;"></iframe>
                </div>
            </div>-->
        </div>
        <div class="small-12 columns auction-description tabber no-padding" ng-show="productDataSpec || descOC">
            <div class="large-12 no-padding tab-house">
                <div data-tabbed="descOC" class="tabber-tab active">Description <div class="down-arrow"></div></div>
                <div data-tabbed="specOC" class="tabber-tab">Specifications <div class="down-arrow"></div></div>
                <div class="clear"></div>
            </div>
            <div class="tabber-content active" data-content="descOC">
                <p>{{descOC}}</p>
            </div>
            <div class="tabber-content" data-content="specOC">
                <div class="spec-house small-12 columns" ng-repeat="spec in productDataSpec">
                    <div class="spec-name small-6 columns">{{spec.name}}:</div>
                    <div class="spec-value small-6 columns">{{spec.value}}</div>
                </div>
            </div>
        </div>
    </div>    
</div>
<!--- TODAYS ITEMS OFF CANVAS AREA END -->
 
</div> <!-- end #content -->

<!-- add to basket -->
<script type="text/javascript">
jQuery(function () {
    
    
    
    
            
            if (jQuery('[id$="dvVideoHolderLive"]').length > 0) {
                jQuery('[id$="dvVideoHolderLive"]').Video({
                    container: 'dvVideoHolderLive',
                    channel: 'JEWELLERYMAKER',
                    autoStart: true,
                    width: '100%',
                    height: '100%',
                    edge: '',
                    events: {
                        'onReady': function (event) {
                            if (!Modernizr.generatedcontent) {
                                jQuery('<div id="sizer"></div>').insertAfter('#dvVideoHolderLive_player'); // fallback to sizer if browser doesnt support :before pseudo el 
                            }
                        }
                    }
                });
            }    
    
    
    
    jQuery(document).on('click', '.add-to-basket', function() {
        var isOffCanvas = false;
        
        if(jQuery(this).siblings('.addToBasketVars').length){
            var productPrice        = jQuery(this).siblings('.addToBasketVars').attr('data-productPrice');
            var productName         = jQuery(this).siblings('.addToBasketVars').attr('data-productName');
            var productDetailID     = jQuery(this).siblings('.addToBasketVars').attr('data-productDetailID');
            var auctionID           = jQuery(this).siblings('.addToBasketVars').attr('data-auctionID');
            var productCode         = jQuery(this).siblings('.addToBasketVars').attr('data-productCode');
            var quantity            = jQuery(this).siblings('.addToBasketVars').attr('data-quantity');
            var image_url           = jQuery(this).siblings('.addToBasketVars').attr('data-image_url');
            isOffCanvas = true;
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
            if(isOffCanvas){
                //close off canvas
                jQuery('.aoc-darken-body').trigger('click');
                jQuery("html, body").animate({ scrollTop: 0 }, "100");
            }
            //jQuery('#basket-total').text('£' + data.basketTotal.toFixed(2));
            //jQuery('#basket-description').text(data.description);
        });            
    });

   jQuery('.add-basket').click( function( e ){

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
});
</script>


<?php get_footer(); ?>