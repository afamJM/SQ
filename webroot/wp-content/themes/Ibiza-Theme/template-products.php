<?php
/*
  Template Name: Products List Landing Page
 */


global $ibiza_api;
//32 is shop catgeory
$cat = $ibiza_api->get_product_list_category(get_query_var('the_id'));
$catss = $ibiza_api->get_product_list_top_level_categorys(131, 32);
$title = $ibiza_api->get_product_list_title(get_query_var('products'));
$cat_title = $ibiza_api->cat_data->title;
?>

<?php get_header(); ?>


<div id="content">

    <div class="medium-12" id="inner_content">

        <div class="columns row">
            <div class="cat-desc">
                <nav aria-label="You are here:" role="navigation">
                    <ul class="breadcrumbs show-for-medium">
                        <li><a href="/" title="Home page link">Home page </a></li>
                        <li><a  <?php /*href="/products-list"*/?> title="Shop page link">Shop</a></li></li>                    
                    </ul>
                    <ul class="breadcrumbs show-for-small-only">
                        <a href="/" class="previous-segement" title="Go back to the previous page">&lt; BACK</a>
                    </ul>
                </nav>        


                <h3><?php echo ucwords($cat_title); ?></h3>




                <?php if ($ibiza_api->cat_data->description): ?>
                    <?php echo nl2br($ibiza_api->cat_data->description); ?>                   
                <?php else: ?>
                <?php endif; ?>        
            </div>
        </div>
    </div>

    <!-- Side Bar -->
    <div class="product-list-container columns">
        <div id="inner-content-product-list" class="row" <?php echo $filter_cat_str1; ?>>
            <div class="category-list category-page sidebar columns large-2 large-text-left text-center  small-12" role="complementary">
                <ul>
                    <?php $count = 1;$total_cats = count( $catss ); ?>
                    <?php foreach ($catss as $key=>$cat): ?>
                    
                    <?php $end = $count>=$total_cats?'end':''; ?>
                    
                    <li class="item-<?php echo $count ?> <?php echo $end;?>"><a href="<?php echo $cat->url; ?>" title="<?php echo $cat->post_title; ?> page"><?php echo $cat->post_title; ?></a></li>
                    <?php ++$count; ?>
                    <?php endforeach; ?>
                        
                </ul>
            </div>



            <!-- End Side Bar -->


            <!-- Thumbnails -->
            <main id="main" class="large-10 medium-12 small-12 columns" role="main" >





                <div id="second-band" class="second-band-shop-page show-for-large">
                    
                    <h4>Product Categories</h4>
                    
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
                </div>


            </main>



            <?php
            $i = 0;
            $total = 0;

            foreach ($catss as $cat) {
                if ($cat->post_content == 1) {
                    $total++;
                }
            }
            ?>                

            <?php
            $i = 0;
            foreach ($ibiza_api->all_cats as $cat):


                $cat_data_ob = $cat_data_arr[$cat->ID];

                if ($cat->post_excerpt == 1):
                    ?>



                    <div class="large-3 medium-3 columns padded-column box">
                        <img src="<?php echo $cat_data_ob->image ? $cat_data_ob->image : ''; ?>" alt="Main page image" title="Main page image" />
                        <a href="<?php print $cat->url; ?>" title="..">
                            <span class="caption fade-caption">
                                <h3><?php echo $cat->post_title; ?></h3>
                                <p><?php echo $cat_data_ob->intro ? $cat_data_ob->intro : ''; ?></p>
                            </span>                    
                        </a>
                    </div>


                    <?php $i++; ?>   
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>

    jQuery(document).ready(function () {
        //initialize swiper when document ready  
        var mySwiper = new Swiper('.swiper-container-howto-cats', {
            // Optional parameters
            loop: false,
            pagination: '.swiper-pagination',
            paginationClickable: true,
            slidesPerView: 5,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev'
        });

    });


</script>

<?php get_footer(); ?>
