<?php
/*
  Template Name: Products List
 */

global $ibiza_api;

$join_str           = array();
$cat                = $ibiza_api->get_product_list_category(  get_query_var('the_id') );
$sort               = $ibiza_api->get_product_list_sort_options();
$ignore_query_strs  = $ibiza_api->get_product_list_ignored_query_strings();
$page_sizes         = $ibiza_api->get_product_list_pages_sizes();
$jsonPath           = $ibiza_api->get_product_list_api_url( $cat );
$facets             = $ibiza_api->get_product_list_facets( $jsonPath , $cat );
$range              = $ibiza_api->get_product_list_price_range();
$catss              = $ibiza_api->get_product_list_top_level_categorys( $cat );
$facetsOb           = $ibiza_api->get_product_list_facets_object();
// most follow after above as get_product_list_top_level_categorys set whether or not it is top level
$top_level          = $ibiza_api->is_top_level;
$filter_cat_str     = "ejs.TermFilter('_category', '" . $cat ."')";
$title              = $ibiza_api->get_product_list_title( get_query_var('products') );
$index              = 'product';
$page_type          = 'products';
$jsonStr            = '{"query":{"query_string":{"query":"'. $cat.'","lenient":true,"fields":["_category"],"default_operator":"AND"}}}';
$segments           = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$col_size           = '10';
if( $segments[0] == 'how-to-guides'  ){
    $ibiza_api->title = 'Projects &amp; Guides';
    $index              = 'howto';
    $cat_title          = 'Learn';
    $sort               =  array();
    $top_level          = false;
    $page_type          = "How to's";
    $col_size           = '12';
    $productsJSON       = getSslPage( $ibiza_api::$end_points['howto_elastic'] .  "_search?from=0&size=1"  );
    
}else{
    $productsJSON       = getSslPage( $ibiza_api::$end_points['product_elastic'] .  "_search?from=0&size=1&source="  . urlencode( $jsonStr ) );
}






if( json_decode( $productsJSON  )->hits->total <=0 && $top_level==false){
    
    header('Location: /no-results' );
    
}


if($cat==0){
    $filter_cat_str     = '';
}


$breadcrumbs        = breacdcrumbs('cat-' . $cat  );
$cat_title          = $ibiza_api->cat_data->title;



if( $_GET['q'] ){

    unset($breadcrumbs['']);
    $breadcrumbs[]  = '<li>Search - ' . (string) htmlentities( $_GET['q'] ) . '</li>';
}






get_header(); ?>

<div id="content"   ng-controller="IndexController" ng-app="ibiza"  eui-index="'<?php echo $index; ?>'"  <?php echo  $filter_cat_str ? 'eui-filter="ejs.BoolFilter().must('. $filter_cat_str.')"' : '' ; ?>  ng-model='querystring'  eui-enabled='true' <?php  echo $_GET['q'] ?  'eui-query="ejs.QueryStringQuery(\'' . $_GET['q'] .'*\').lenient(true).fields(\'name\')"' : ''; ?>>
 
    <?php if($top_level==false): ?>

    <div id="loading_container">
    </div>

    <div id="loading_container2">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/plus.gif" alt="Plus sign icon" title="Plus sign icon" />
    </div>

    <?php endif; ?>
    
    <!-- Side Bar -->
    <div class="medium-12" id="inner_content">

        <div class="columns row">
            <div class="cat-desc">
                <nav aria-label="You are here:" role="navigation">
                    <ul class="breadcrumbs show-for-medium">
                        <?php echo implode('', $breadcrumbs); ?>
                    </ul>
                    <ul class="breadcrumbs show-for-small-only">
                        <?php
                        for ($i = 0; $i < count($segments) - 1 ;$i++) {
                            $previousSegments .= $segments[$i] . '/';
                        } ?>
                        <a href="<?php echo '/' . $previousSegments; ?>" class="previous-segement upper" title="Go back to the previous page">< Back</a>
                    </ul>
                </nav>
                <?php if($ibiza_api->cat_data->bannerimage):?>
                    <div class="show-for-large category-banner">
                        <img  class="fullwidth-only" src="<?php echo $ibiza_api->cat_data->bannerimage; ?>" alt="Sewing Quarter banner image" title="Sewing Quarter banner image" />
                    </div>
                <?php endif; ?>

                <h3><?php echo ucwords($cat_title); ?></h3>

                <?php if($ibiza_api->cat_data->description): ?>
                    <h2><?php echo $ibiza_api->title; ?></h2>
                    <?php echo nl2br( $ibiza_api->cat_data->description);?>                   
                <?php else:?>
                    <h2><?php echo $ibiza_api->title; ?></h2>
                <?php endif; ?>
            </div>

            <p class="show-for-small-only">Read More</p>
        </div>
    </div>

    <div class="product-list-container columns">
        <div id="inner-content-product-list" class="row" <?php echo $filter_cat_str1;?>>
            
            
 
            
            
            <div class="category-list sidebar columns large-2 large-text-left text-center <?php print $top_level == true ? 'category-page small-12' : 'product-page show-for-large' ; ?>" role="complementary">

                <?php if($top_level == false && $index=='product'): ?>


                <p class="show-for-large"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_RefineResults_Black.png" alt="Refine results icon" title="Refine results icon" /> Refine Results:</p>
                <div class="applied-filters">
                    <p class="bold">Applied Filters:</p>
                    <ul class="add_facets"></ul>
                    <button id="reset-filter" aria-expanded="false" aria-haspopup="true"  data-is-focus="false"   class="signup-submit button upper"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_Productlist_ResetFilters.png"  alt="Reset all icon" title="Reset all icon" /> Reset All</button>
                </div>

                <div id="side-facets">
                    <?php
                    if(count($facets))
                    foreach( $facets as $facet ):

                    switch ( $facet->name ):
                        case 'price':
                    ?>
                    <h3><?php echo ucwords( $facet->displayname ); ?></h3>

                    <?php foreach($range->ranges as $the_the_range):  ?>
                    <div eui-or-filter>
                    <eui-range display="'<?php echo ucwords( $facet->displayname ); ?>'" field="'<?php echo $facet->name; ?>.raw'"  min="'<?php echo $the_the_range->start ?>'"  max="'<?php echo $the_the_range->end ?>'"   size="50"></eui-range>
                    </div>
                    <?php endforeach;?>
                    <?php

                        break;
                        default:
                    ?>
                    <hr>
                    <div eui-or-filter>
                    <eui-checklist  display="'<?php echo ucwords( $facet->displayname ); ?>'" field="'<?php echo $facet->name; ?>.raw'" size="50"><p onclick="toggleFacets(jQuery(this).parent());">toggle</p></eui-checklist> <!-- ACTION: change to field to use as facet -->
                    </div>
                    <?php
                        endswitch;
                    ?>

                    <?php endforeach; ?>

                </div>

                <?php elseif($top_level==true): ?>

                <ul>

                <?php foreach($catss as $cat): ?>

                    <li><a href="<?php echo $cat->url; ?>" title="<?php echo $cat->post_title; ?> page"><?php echo $cat->post_title; ?></a></li>

                <?php endforeach; ?>


                </ul>

                <?php endif; ?>
            </div>



            <!-- End Side Bar -->
            
            
            <!-- Content start  -->
            
            
            
            <?php if( $top_level ): ?>
            
             <?php  require( get_template_directory() .  '/parts/products-categories.php'  );  ;// get_template_part('parts/products', 'categories'); ?>
            
            
            <?php else: ?>
            
            <?php require( get_template_directory() .  '/parts/products-product.php'  );  ?>
            
            
            
            <?php endif; ?>
            <!-- Content end -->
            
  
        </div>
    </div>
</div>
    
</div>

<?php get_footer(); ?>
