    <?php
/*
  Template Name: Products List
 */
 
global $ibiza_api;

$search             = sanitize_text_field( $_GET['q'] );
$jsonStr            = '{"query":{"query_string":{"query":"*'. $search.'*","lenient":true,"fields":["name"],"default_operator":"AND"}}}';
$productsJSON       = getSslPage( $ibiza_api::$end_points['product_elastic']    .  "_search?from=0&size=1&source="  . urlencode( $jsonStr ) );
$howtoJSON          = getSslPage( $ibiza_api::$end_points['howto_elastic']      .  "_search?from=0&size=1&source="  . urlencode( $jsonStr ) );
$productsResults    = json_decode($productsJSON);
$howtoResults       = json_decode($howtoJSON);
$howToTotal         = $howtoResults->hits->total;
$productTotal       = $productsResults->hits->total;
$resultTotal        = ($howToTotal + $productTotal);

if( $productsResults->hits->total <=0 && $howtoResults->hits->total>0 && $_GET['type']!='howto')
{
    header('Location: /search/?q=' . $search . '&type=howto' );
}else if( $productsResults->hits->total <=0 && $howtoResults->hits->total<=0 ){
    header('Location: /no-results' );
}

$segments           = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
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
$search_type        = $_GET['type'];
if($cat==0){
    $filter_cat_str     = '';
}

$breadcrumbs        = breacdcrumbs('cat-' . $cat  );
$cat_title          = $ibiza_api->cat_data->title;

$col_size           = '10';
if( $search ){
    
    unset($breadcrumbs['']);
    $breadcrumbs[]  = '<li>Search - ' . $search . '</li>';
}


$class1      = 'active';                     
$class2      = '';                        
                        

if( $search_type == 'howto'  ){
    $index              = 'howto';
    $cat_title          = $cat_title;
    $sort               =  array();
    $col_size           = '12';
    $class2             = 'active';
    $class1             = '';   
}
                        


?>

<?php get_header(); ?>

    <div id="loading_container">
    </div>

    <div id="loading_container2">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/plus.gif" alt="Plus sign icon" title="Plus sign icon" />
    </div>


<div id="content" class="search-page" ng-controller="IndexController" ng-app="ibiza"  eui-index="'<?php echo $index; ?>'"  <?php echo  $filter_cat_str ? 'eui-filter="ejs.BoolFilter().must('. $filter_cat_str.')"' : '' ; ?>  ng-model='querystring'  eui-enabled='true' <?php  echo $search ?  'eui-query="ejs.QueryStringQuery(\'' . $search .'*\').lenient(true).fields(\'name\').defaultOperator(\'AND\')"' : ''; ?>>

    
    
    <!-- Side Bar -->
    <div class="medium-12" id="inner_content">

        <div class="columns  row">
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
                        <a <?php /* href="<?php echo '/' . $previousSegments; ?>" */?> class="previous-segement upper" title="Go back to the previous page">< Back</a>
                    </ul>
                </nav>


                <div class="row">
                    <div class="small-12 small-centered  text-center">
                        <h2>Search Result</h2>

                        <div class="search-container-results block-el">
                            <?php require 'parts/search-area.php'; ?>
                            <p class="text-center">See below <span id="results_count"><?php echo $resultTotal;; ?></span> result<?php echo ($resultTotal>1||$resultTotal==0)?'s':''; ?> for '<span><strong><?php print (string) htmlentities( $_GET['q'] ); ?></strong></span>'</p>
                        </div>                    
                    </div>
                </div>
                
            </div>

<!--            <p class="show-for-small-only">Read More</p>-->
        </div>
    </div>

    
  
    
    
    
    
    
    <div class="product-list-container columns">
        
        
        
        
        <?php if( $resultTotal > 0 ): ?>
        <div class="row column  show-for-large search-page-select">

            <div class="columns large-1 text-right">
                
                <?php if( $productTotal >0 ): ?>
                <a href="/search/?q=<?php echo $search; ?>&type=product" class="<?php echo $class1 ?>" title="Products search page">Products <span id="products-count">(<?php echo  $productTotal; ?>)</span></a>
                
                <?php else:?>
                
                <span class="<?php echo $class1 ?>">Products <span id="howto-count">(<?php echo $productTotal; ?>)</span></span>
                
                <?php endif; ?>                
                
                
                
                
            </div>
            
            <div class="columns large-1 text-center no-padding" style="padding:0">
                <img src="/wp-content/themes/Ibiza-Theme/assets/images/line.png" alt="Line image" title="Line image" />
            </div>
            
            <div class="columns large-2 text-left end">
                <?php if( $howToTotal >0 ): ?>
                <a href="/search/?q=<?php echo $search; ?>&type=howto" class="<?php echo $class2 ?>"  title="How to guides search page">Projects & Guides <span id="howto-count">(<?php echo $howToTotal; ?>)</span></a>
                
                <?php else:?>
                
                <span class="<?php echo $class2 ?>">Projects & Guides <span id="howto-count">(<?php echo $howToTotal; ?>)</span></span>
                
                <?php endif; ?>
            </div>



        </div>        
        <?php endif; ?>
        <div id="inner-content-product-list" class="row" <?php echo $filter_cat_str1;?>>
          
            
            
           
            <?php if (is_active_sidebar('homepagebelowmaincontent_4by2')) : ?>
            <div id="second-band" <?php echo $resultTotal>0? ' class="hidden"' : '' ; ?>>
                <article class="learning__item box1--videos mobile-full tablet-and-up-half ">

                    <?php dynamic_sidebar('homepagebelowmaincontent_4by2'); ?>

                </article>         
            </div>
            <?php endif; ?> 
            
     

                <?php if( $index=='product' && $resultTotal>0): ?>
                <div class="sidebar columns large-2 large-text-left text-center <?php print $top_level == true ? 'category-page small-12' : 'product-page show-for-large' ; ?>" role="complementary">

                    <p class="show-for-large"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_RefineResults_Black.png" alt="Refine results image" title="Refine results image" /> Refine Results:</p>
                    <div class="applied-filters">
                        <p class="bold">Applied Filters:</p>
                        <ul class="add_facets"></ul>
                        <button id="reset-filter" aria-expanded="false" aria-haspopup="true"  data-is-focus="false"  class="signup-submit button upper" ><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_Productlist_ResetFilters.png" alt="Reset all icon" title="Reset all icon" /> Reset All</button>
                    </div>




                <div id="side-facets">
                    <?php
                    if(count($facets))
                    foreach( $facets as $facet ):

                    ?>


                    <?php

                    switch ( $facet->name ):
                        case 'price':
                    ?>
                    <h3><?php echo ucwords( $facet->displayname ); ?></h3>

                    <?php foreach($range->ranges as $the_the_range):  ?>
                    
                    <div  eui-or-filter="true" eui-filter-self="false">
                    <eui-range eui-filter-self="false" display="'<?php echo ucwords( $facet->displayname ); ?>'" field="'<?php echo $facet->name; ?>.raw'"  min="'<?php echo $the_the_range->start ?>'"  max="'<?php echo $the_the_range->end ?>'"   size="10"></eui-range>
                    </div>
                    <?php endforeach;?>
                    <?php

                        break;
                        default:
                    ?>
                    <hr>
                      <div eui-or-filter eui-filter-self="false" >
                    <eui-checklist  display="'<?php echo ucwords( $facet->displayname ); ?>'" field="'<?php echo $facet->name; ?>.raw'" size="10"><p onclick="toggleFacets(jQuery(this).parent());">toggle</p></eui-checklist> <!-- ACTION: change to field to use as facet -->
                      </div>
                    <?php
                        endswitch;
                    ?>

                    <?php endforeach; ?>

                </div>


                <?php endif; ?>
            </div>



            <!-- End Side Bar -->
            
            
            <!-- Content start  -->
            
            
            
            <?php if( $top_level ): ?>
            
             <?php  require( get_template_directory() .  '/parts/products-categories.php'  );  ;// get_template_part('parts/products', 'categories'); ?>
            
            
            <?php elseif( $resultTotal>0  ): ?>
            
            <?php require( get_template_directory() .  '/parts/products-product.php'  );  ?>
            
            
            
            <?php endif; ?>
            <!-- Content end -->
            
  
        </div>
    </div>
</div>
    
<section class="row <?php echo $resultTotal>0?' hidden':''; ?>" id="third-band" >

        <?php if (is_active_sidebar('homepagebelowmaincontent_full2')) : ?>

        <article class="">

            <?php dynamic_sidebar('homepagebelowmaincontent_full2'); ?>

        </article>

        <?php endif; ?>

</section>




<?php get_footer(); ?>
