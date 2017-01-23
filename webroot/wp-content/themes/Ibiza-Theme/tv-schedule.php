<?php
/*
  Template Name: TV Schedule
 */

global $ibiza_api;
$join_str = array();
$data = json_decode(getSslPage($ibiza_api::$end_points['tvschedule']));
get_header();
?>

<div id="content" class="light-background">


    <div class="row" id="inner-content">


        <div class="large-12 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs show-for-medium">
                    <li><a href="/"  title="Go back to the homepage">Home page </a></li>
                    <li><a <?php /* href="/tv-schedule/" */ ?> title="Programme guide page">Programme Guide</a></li>
                </ul>
                <ul class="breadcrumbs show-for-small-only">
                    <a href="/" class="previous-segement upper" title="Go back to the homepage">&lt; Back</a>
                </ul>
            </nav>        
        </div>        


        <div class="medium-6 columns">
            <h2><img src="/wp-content/themes/Ibiza-Theme/assets/images/tv-icon.png"  class="tv-icon" alt="Programme guide icon" title="Programme guide icon" /> Programme Guide</h2>
            <p>Find out what's coming up on the sewing Quarter TV show</p>
        </div>

        <div class="medium-6 small-12 columns medium-text-right">
            <a href="/watch"   alt="Watch online page">
                <img src="/wp-content/themes/Ibiza-Theme/assets/images/watch-online-icon.png" class="watch-online"  alt="Watch online icon" title="Watch online icon" />
            </a>
        </div>

        <main role="main" class="large-12 medium-12 columns tv-schedule-main" id="main" >

            <section itemprop="articleBody" class="entry-content">

                <div class="swiper-container-tv-schedule">

                    <div class="columns small-4 n-l-p show-for-medium">
                        <a href="" class="brand-bg upper no-margin" title="Current page">&lsaquo; Today</a>
                    </div>

                    <div class="swiper-button-prev small-1 columns no-margin"></div>

                    <div class="columns small-10 medium-3 text-center">&nbsp;</div>


                    <div class="swiper-button-next  small-1 columns no-margin"></div>

                    <div class="clear show-for-medium">&nbsp;</div>
                    <div class="show-for-medium">
                        <div class="columns small-3 n-r-p n-l-p">Time</div>
                        <div class="columns small-3 n-r-p n-l-p">Show</div>
                        <div class="columns small-6 n-r-p n-l-p">Synopsis</div> 
                    </div>
                    <div class="columns small-12" >
                        <hr class="show-for-medium" />
                    </div>
                    <div class="swiper-wrapper">



                        <?php
                        foreach ($data as $tv) {

                            $shows[date('d-m-Y', strtotime($tv->fromDate))][] = $tv;
                        }

                        if (isset($shows)):
                            foreach ($shows as $day => $tvs):

                                //print_r($tvs);die;
                                ?>
                                <div class="swiper-slide" >
                                    <div class="columns small-1 small-centered text-center schedule-time"><?php print( date('l', strtotime($day))); ?><br /><?php print( date('m', strtotime($day))); ?><sup><?php print( date('S', strtotime($day))); ?></sup> <?php print( date('Y', strtotime($day))); ?></div>
                                <?php foreach ($tvs as $d): ?>
                                        <div class="row tv-schedule-con">
                                            <hr class="show-for-small-only" />
                                            <div class="columns small-12 medium-3  n-r-p n-l-p"><?php echo date('H:i', strtotime($d->fromDate)) ?> - <?php echo date('H:i', strtotime($d->toDate)) ?></div>
                                            <div class="columns small-12 medium-3 n-r-p n-l-p"><?php print_r($d->title); ?></div>
                                            <div class="columns small-12 medium-6 n-r-p n-l-p"><p><?php print_r($d->synopsis); ?></p></div>  
                                        </div>
                                    <?php endforeach; ?>
                                </div>                
                                <?php endforeach;
                            endif;
                            ?>
                    </div> 
                </div>
            </section>
                            <?php if (is_active_sidebar('featured-programmes')) : ?>

                            <?php dynamic_sidebar('featured-programmes'); ?>

<?php endif; ?>   
        </main>






    </div>
</div>

<?php wp_add_inline_script('site-js', "
var mySwiperTvS = null;

 



jQuery( document ).ready(function() {
    
    
    
    //initialize swiper when document ready  
    mySwiperTvS = new Swiper('.swiper-container-tv-schedule', {
        nextButton : '.swiper-button-next',
        prevButton : '.swiper-button-prev',
    });    
    
     
    
});
"); ?>

<?php get_footer(); ?>
