<?php
/*
  Template Name: TV Schedule
 */

global $ibiza_api;

$join_str   = array();
$data       = @json_decode( file_get_contents($ibiza_api::api_location . '/ProductCatalog.api/api/legacy/tvschedule/82' ) );


get_header(); ?>

<div id="content" style="background:#fff;">
    
    
    
    
    
    
    <div class="row" id="inner-content">
        
        
        <div class="large-12 columns">
        <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs show-for-medium">
                    <li><a href="/">Home page </a></li>
                    <li><a href="/tv-schedule/">Programme Guide</a></li>
                </ul>
                <ul class="breadcrumbs show-for-small-only">
                        <a href="/product-list/fabric/" class="previous-segement">&lt; BACK</a>
                </ul>
        </nav>        
        </div>        
        
        
        <div class="large-6 columns">
            <h2><img src="/wp-content/themes/Ibiza-Theme/assets/images/tv-icon.png" alt="" style="height:33px;" /> Programme Guide</h2>
            <p>Find out what's coming up on the sewing Quarter TV show</p>
        </div>
        
        <div class="large-6 columns text-right">
            <a href="/watch"><img src="/wp-content/themes/Ibiza-Theme/assets/images/watch-online-icon.png" alt="" style="height:55px;margin-top: 15px;" /></a>
        </div>
        
        <main role="main" class="large-12 medium-12 columns" id="main" >
            
            <section itemprop="articleBody" class="entry-content"  style='padding:30px;margin:35px 0 70px 0;background:rgba(0, 0, 0, 0) url("/wp-content/themes/Ibiza-Theme/assets/images/bg.png") repeat scroll 0 0'>
                
                <div class="swiper-container-tv-schedule" style="padding:30px 0px 30px 20px;position: relative;overflow: hidden; background:rgba(255,255,255,0.75);">
                    
                    <div class="columns small-4 n-l-p">
                        <a href="" class="brand-bg upper" style="margin: 0">&lsaquo; Today</a>
                    </div>
                        
                    
                    
                    <div class="swiper-button-prev small-1 columns " style="position: static;margin:0 "></div>
                    
                    <div class="columns small-3 text-center">&nbsp;</div>

                    
                    <div class="swiper-button-next  small-1 columns " style="position: static;margin:0  "></div>
                     
                    <div style="clear:Both;"></div>
                    <div>
                        <div class="columns small-3 n-r-p n-l-p">Time</div>
                        <div class="columns small-3 n-r-p n-l-p">Show</div>
                        <div class="columns small-6 n-r-p n-l-p">Synopsis</div> 
                    </div>
                    <div class="columns small-12" >
                    <hr />
                    </div>
                    <div class="swiper-wrapper">
                        
                    
                        
                <?php 
                
                
                
                
                foreach( $data as $tv ){
                    
                    
                    $shows[  date( 'd-my-', strtotime( $tv->fromDate ) ) ][] = $tv;
                    
                    
                }
                
                if(isset($shows)):
                    foreach( $shows as $day=>$tvs ): 
                    
                        //print_r($tvs);die;
                    
                ?>
                        <div class="swiper-slide" >
                            <div class="columns small-3 text-center" style="top:-1000px;position:absolute;line-height:28px"><?php print( date( 'l', strtotime( $day ) ) ); ?><br /><?php print( date( 'm', strtotime( $day ) ) ); ?><sup><?php print( date( 'S', strtotime( $day ) ) ); ?></sup> <?php print( date( 'Y', strtotime( $day ) ) ); ?></div>
                            <?php 
                            
                            foreach( $tvs as $d ): ?>
                            <div class="row tv-schedule-con" style="margin-bottom:10px;margin-left: 0">
                                <div class="columns small-3 n-r-p n-l-p"><?php echo  date( 'H:i' , strtotime( $d->fromDate) ) ?> - <?php echo  date( 'H:i' , strtotime( $d->toDate) ) ?></div>
                                <div class="columns small-3 n-r-p n-l-p"><?php print_r($d->title);  ?></div>
                                <div class="columns small-6 n-r-p n-l-p"><p style="width:80%"><?php print_r($d->synopsis); ?></p></div>  
                            </div>
                            <?php endforeach; ?>
                        </div>                
                <?php endforeach; 
                endif; ?>
                </div> 
                </div>
            </section>
            
        </main>

        
        
        <div class="columns small-6 large-3">
            
            <img src="/wp-content/themes/Ibiza-Theme/assets/images/featured-tv-1.png" />
            
        </div>

        
        
        <div class="columns small-6 large-3">
            
            <img src="/wp-content/themes/Ibiza-Theme/assets/images/featured-tv-2.png" />
            
            
        </div>

        
        
        <div class="columns small-6 large-3">
            
            
            <img src="/wp-content/themes/Ibiza-Theme/assets/images/featured-tv-3.png" />
            
        </div>

        
        
        <div class="columns small-6 large-3">
            
            
            <img src="/wp-content/themes/Ibiza-Theme/assets/images/featured-tv-4.png" />
            
        </div>
        

    </div>
</div>

    <script>
    
    /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var mySwiperTvS = null;

 



jQuery( document ).ready(function() {
    
    
    
    //initialize swiper when document ready  
    mySwiperTvS = new Swiper('.swiper-container-tv-schedule', {
        nextButton : '.swiper-button-next',
        prevButton : '.swiper-button-prev',
    });    
    
     
    
});
    
    
    </script>
    
    <?php get_footer(); ?>
