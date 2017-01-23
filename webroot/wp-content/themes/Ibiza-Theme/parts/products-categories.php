<?php

global $ibiza_api;

 

?>
                            

            <!-- Thumbnails -->
            <main id="main" class="large-10 product-category-page columns" role="main" >

                <section id="second-band">
                    
                    
                    <?php
                    
                    
                    
                    foreach ($catss as $cat):

                        $seg                    = explode('/', $cat->url);
                        $cat_data               = get_post_meta($cat->ID);
                        $cat_data_ob            = json_decode($cat_data['cat-' . $seg[3]][0]);
                        $cat_data_arr[$cat->ID] = $cat_data_ob;                        
                        $end = $count>=$total_cats?'end':''; 
                    ?>
                        <div class=" large-3 small-6 columns home-cats <?php echo $end;?>">
                            <article class="post-26859 featured_categories type-featured_categories status-publish has-post-thumbnail hentry category-c1 category-featured-products" style="background-size:cover;background-image:url(<?php echo $cat_data_ob->image; ?>);">
                                <header>
                                    <h4 class="entry-title"><a href="<?php echo $cat->url; ?>" title="<?php echo $cat->title; ?> page"><?php echo $cat->title; ?></a></h4>
                                </header>
                            </article>
                        </div>                    
                    <?php endforeach; ?>
                    
                    
                    <?php if (is_active_sidebar('pop-cat-blocks') ) : ?>
                    <article class="small-12 category-boxes catLargeRight columns">

                        <?php dynamic_sidebar('pop-cat-blocks'); ?>

                    </article>                 

                    <?php endif; ?>

                    <div class="clear"></div>
      
                </section>

                <section class="the-prod-slider">
                    <article class="large-12 columns no-padding">
                        <?php dynamic_sidebar('featured-products'); ?>
                    </article>
                </section>

                <!-- End Thumbnails -->
            </main>
<?php                 
wp_add_inline_script( 'site-js',"
    //Shareef don't like it, damn straight
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
    });");
    ?>
    </script>
    