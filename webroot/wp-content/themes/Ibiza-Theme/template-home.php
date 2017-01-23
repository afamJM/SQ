<?php
/*
  Template Name: Home Template
 */
?><?php get_header(); ?>

<div id="content">
    
    <div id="operationLogInfo"></div>
    
    <div id="inner-content" class="home-inner-content row">

        <?php if (is_front_page()): ?>

            <main id="main" class="large-6 medium-12 columns main" role="main">

            <?php else: ?>

                <main id="main" class="large-6 medium-12 columns" role="main" >

            <?php endif; ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
                        <!-- To see additional archive styles, visit the /parts directory -->
                        <?php get_template_part('parts/loop', 'archive'); ?>
                
                    <?php endwhile; ?>	

                    <?php joints_page_navi(); ?>
                
                <?php else : ?>
                
                    <?php get_template_part('parts/content', 'missing'); ?>
                
                <?php endif; ?>
                
                        <!-- Temp style -->
                        
                <div id="dvVideoHolderHome" class="light-background">

                    
                </div>
                        
                        
                        <!-- temp inline as design not final -->
                <div class="text-center tv-options-1 small-12 show-for-medium-up hide-for-small-only" id="tv-options">
                    <div class="large-6 small-6 columns option-1">
                        <a href="/watch/" class="upper" title="Watch online page link"><span class="icon"></span>Watch and buy online</a>
                    </div>
                    <div class="large-6 small-6 columns option-2">
                        <a href="tv-schedule/" class="upper" title="Programme guide page"><span class="icon"></span>Programme guide</a>
                    </div>
                </div> 

                <div class="text-center tv-options-2 medium-12 small-12 column show-for-small-only" id="tv-options">
                    <div class="medium-6 small-6 columns  option-1">
                        
                        <div class="block">
                            <div class="centered">
                        
                                <a href="/tv-schedule/" class="upper" title="TV schedule page"><span class="icon"></span>View the TV Schedule</a>
                        
                            </div>
                        </div>
                    </div>
                        
                    <div class="medium-6 small-6 columns  option-2">
                        
                        <div class="block">
                            <div class="centered">
                        
                                <a href="/tv-schedule/" class="upper" title="View all products from Today"><span class="icon"></span>View all products from Today</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </main> <!-- end #main -->
            
            <?php if (is_active_sidebar('homepagebelowmaincontent_left1')) : ?>
                <div class="large-6 medium-12 columns">
                    <?php dynamic_sidebar('homepagebelowmaincontent_left1'); ?>
                </div>

            <?php endif; ?>

    </div> <!-- end #inner-content -->
    
</div> <!-- end #content -->


<div   class="fullwidth full">

    <section class="row columns" id="second-band">

        <?php if (is_active_sidebar('homepagebelowmaincontent')) : ?>
        <div class="text-center">
                <?php dynamic_sidebar('homepagebelowmaincontent'); ?>
        </div>
        <?php endif; ?>
    

        <?php if (is_active_sidebar('homepagebelowmaincontent_left2')) : ?>

        <article class="learning__item box3--getting-started mobile-half tablet-and-up-half desktop-quarter large-6 columns">

            <?php dynamic_sidebar('homepagebelowmaincontent_left2'); ?>

        </article>          

        <?php endif; ?>     


        <?php if (is_active_sidebar('homepagebelowmaincontent_right')) : ?>

        <article class="learning__item box1--videos mobile-full tablet-and-up-half ">

            <?php dynamic_sidebar('homepagebelowmaincontent_right'); ?>

        </article>         

        <?php endif; ?>  

        <!-- 4 by 2 section -->
        <?php if (is_active_sidebar('homepagebelowmaincontent_4by2')) : ?>

        <article class="learning__item box1--videos mobile-full tablet-and-up-half ">

            <?php dynamic_sidebar('homepagebelowmaincontent_4by2'); ?>

        </article>         

        <?php endif; ?> 

        <div class="clear"></div>
        
        
        <?php if (is_active_sidebar('homepagebelowmaincontent_full')) : ?>

        <article class="large-12">

            <?php dynamic_sidebar('homepagebelowmaincontent_full'); ?>

        </article>

        <?php endif; ?>


        <?php if (is_active_sidebar('homepagebelowmaincontent_full')) : ?>

        <article class="large-12">

            <?php dynamic_sidebar('homepagebelowmaincontent_full'); ?>

        </article>

        <?php endif; ?>          
        

    </section>        

</div>



<section class="row" id="third-band">

    <?php if (is_active_sidebar('homepagebelowmaincontent_full2')) : ?>

    <article class="">

        <?php dynamic_sidebar('homepagebelowmaincontent_full2'); ?>

    </article>

    <?php endif; ?>

</section>




<?php         wp_enqueue_script('video-js',  'http://www.jewellerymaker.com/global/js/vendor/plugins/flowplayer/flowplayer.min.js', array('jquery'), '', true); ?>
<?php         wp_enqueue_script('video1-js',   'http://www.jewellerymaker.com/global/js/vendor/plugins/hls/hls.min.js', array('jquery'), '', true); ?>
<?php         wp_enqueue_script('video2-js', get_template_directory_uri() . '/assets/js//video.js', array('jquery'), '', true); ?>
        
        <script type="text/javascript">
    function resizeSlider(){

        if (jQuery(window).width() > 1006) {


            jQuery('.swiper-slide').each(function(){
                jQuery(this).height(jQuery('#main').height());
            });
        }
    };

    jQuery(function () {

        
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
         resizeSlider();
         
    });
    jQuery(window).resize(function(){
        resizeSlider();
    });


</script>

<?php get_footer(); ?>
