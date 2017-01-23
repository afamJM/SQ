<?php

global $ibiza_api;
?>
                            


            <!-- Thumbnails -->
            <main id="main" class="large-10 product-category-page columns" role="main" >

                <section class="row" id="second-band">

                    <?php if (is_active_sidebar('pop-cat-blocks') ) : ?>

                    <article class="small-12 category-boxes catLargeRight columns">

                        <?php dynamic_sidebar('pop-cat-blocks'); ?>

                    </article>                 

                    <?php endif; ?>

                    <div class="clear"></div>
      
                </section>

                <section class="row the-prod-slider">
                    <article class="large-12 columns no-padding">
                        <?php dynamic_sidebar('featured-products'); ?>
                    </article>
                </section>

                <!-- End Thumbnails -->
            </main>
    <script type="text/javascript">
    //Shareef don't like it
    function moveTheSidebar(){
        if(jQuery(window).width() <= 1023){
            jQuery('.category-list').insertAfter('#main');
            jQuery('.the-prod-slider').insertAfter('.category-list');
        }else{
            jQuery('.category-list').insertBefore('#main');
            jQuery('.the-prod-slider').insertAfter('#second-band');
        }
    }
    // Height matching code
    function heightMatcher(A,B){
        jQuery(B).height('auto');
        jQuery(B).height(jQuery(B).height());/*This line stops decimal points*/
        jQuery(A).height(jQuery(B).height());
    };
    jQuery(document).ready(function(){
        jQuery('.height-as-width').height((jQuery('.height-as-width').width())*0.9);
        setTimeout(function(){
            //heightMatcher('.catLarge','.catLargeRight');
            jQuery('.catLarge').find('*:not(h4)').css('height','100%');
        }, 300);
        moveTheSidebar();
    });
    jQuery(window).resize(function(){
        jQuery('.height-as-width').height((jQuery('.height-as-width').width())*0.9);
        //heightMatcher('.catLarge','.catLargeRight');
        //Put a minimum screen size in here where it is all reset to auto
        moveTheSidebar();
    });
    </script>
    