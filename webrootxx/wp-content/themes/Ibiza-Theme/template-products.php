<?php
/*
  Template Name: Products List Landing Page
 */


global $ibiza_api;
//32 is shop catgeory
$cat                = $ibiza_api->get_product_list_category(  get_query_var('the_id') );
$catss              = $ibiza_api->get_product_list_top_level_categorys( 131 , 32 );
$title              = $ibiza_api->get_product_list_title( get_query_var('products') );
$cat_title          = $ibiza_api->cat_data->title; 

?>

<?php get_header(); ?>

<div id="content" class="product-list-container"  >
    

    <!-- Side Bar -->
    <div class="row">
         
        <div class="columns">
        <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs show-for-medium">
                    <li><a href="/">Home page </a></li>
                    <li><a href="/products-list">Shop</a></li></li>                    
                </ul>
                <ul class="breadcrumbs show-for-small-only">
                        <a href="/product-list/fabric/" class="previous-segement">&lt; BACK</a>
                </ul>
        </nav>        
        </div>
        
        <div class="category-list sidebar columns large-2 large-text-left text-center category-page small-12" role="complementary">
            
            <h3>Products Categories</h3>
            
           <ul>
            
            <?php foreach($catss as $cat): ?>
            
                <li><a href="<?php echo $cat->url; ?>"><?php echo $cat->post_title; ?></a></li>
            
            <?php endforeach; ?>
            
                
            </ul>
        </div>



        <!-- End Side Bar -->

        
        <!-- Thumbnails -->
        <main id="main" class="large-9 medium-12 small-12 columns" role="main" >

            <div class="row">

                <div class="columns" >
<!--                    <img src="<?php echo $ibiza_api->cat_data->bannerimage; ?>" style="width:100%" />-->
                    
                    <h3><?php echo ucwords( $cat_title );    ?></h3>
                    
                    
                    
                    
                    <?php if($ibiza_api->cat_data->description): ?>
                    <?php echo nl2br( $ibiza_api->cat_data->description);?>                   
                    <?php else:?>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <?php endif; ?>
                    
                    <hr />
                    
                    
                
                
                
              
                
                <?php 
                
                $i      = 0;
                $total  = 0;
                
                foreach($catss as $cat){
                    if( $cat->post_content==1 ){
                        $total++;
                    }
                }
                    
                ?>                
                
                <?php $i = 0;?>
                
                    <div class="swiper-container-howto-cats" style="  margin: 0 auto;  overflow: hidden;    position: relative; z-index: 1;">
                <!-- Additional required wrapper -->
                
                
                            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
                    <div class="swiper-wrapper">
                        
                
                
                <?php foreach($ibiza_api->all_cats as $cat):  ?>
                
                  
                    <?php if( $cat->post_excerpt==1 ):?>
                    
                    <?php $seg = explode( '/',$cat->url);  ?>
                
                    <?php $cat_data     =  get_post_meta( $cat->ID ) ; 
                          $cat_data_ob  =  json_decode( $cat_data['cat-' . $seg[3] ][0] );
                    ?>
                
                <div class="large-3 medium-3 columns padded-column box swiper-slide<?php echo  $i == ( $total - 1) ? ' end ' : '' ; ?>">
                    <img src="<?php echo $cat_data_ob->image?$cat_data_ob->image:'http://johnlewis.scene7.com/is/image/JohnLewis/electricals_area_img4_120315?$opacity-blur$'; ?>" />
                    <a href="<?php print $cat->url; ?>">
                    <span class="caption fade-caption">
			<h3><?php echo $cat->post_title;?></h3>
			<p><?php echo $cat_data_ob->intro ? $cat_data_ob->intro :'nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.'; ?></p>
                    </span>                    
                    </a>
                </div>
                
                
                <?php $i++;?>   
                    <?php endif; ?>
                
                <?php endforeach; ?>
                
                
                        
                        
                        
            </div>
                    </div>
                    
                    <?php if (is_active_sidebar('products')) : ?>

                        <div>

                            <?php //dynamic_sidebar('products'); ?>

                        </div>         

                    <?php endif; ?>  
                    
                </div>
            </div>
        

        </main>
        
    </div>
</div>

                
<script>

jQuery(document).ready(function () {
    //initialize swiper when document ready  
    var mySwiper = new Swiper('.swiper-container-howto-cats', {
        // Optional parameters
        loop                : false ,
        pagination          : '.swiper-pagination',
        paginationClickable : true ,
        slidesPerView       : 5 ,
        nextButton : '.swiper-button-next',
        prevButton : '.swiper-button-prev'
    });
    
});


</script>
                
<?php get_footer(); ?>
