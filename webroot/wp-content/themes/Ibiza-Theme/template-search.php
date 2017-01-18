<?php
/*
  Template Name: Products List
 */

global $ibiza_api;
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

if($cat==0){
    $filter_cat_str     = '';
}

$breadcrumbs        = breacdcrumbs('cat-' . $cat  );
$cat_title          = $ibiza_api->cat_data->title;
$search             = sanitize_text_field( $_GET['q'] );
$col_size           = '10';
if( $search ){
    
    unset($breadcrumbs['']);
    $breadcrumbs[]  = '<li>Search - ' . $search . '</li>';
}

if( $segments[1] == 'h'  ){
    $index              = 'howto';
    $cat_title          = $cat_title;
    $sort               =  array();
    $col_size           = '12';
}

?>

<?php get_header(); ?>

<div id="content"   ng-controller="IndexController" ng-app="ibiza"  eui-index="'<?php echo $index; ?>'"  <?php echo  $filter_cat_str ? 'eui-filter="ejs.BoolFilter().must('. $filter_cat_str.')"' : '' ; ?>  ng-model='querystring'  eui-enabled='true' <?php  echo $search ?  'eui-query="ejs.QueryStringQuery(\'' . $search .'*\').lenient(true).fields(\'name\').defaultOperator(\'AND\')"' : ''; ?>>
 
    <?php if($top_level==false): ?>

    <div id="loading_container"   style="overflow: hidden; left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;background: #fff none repeat scroll 0% 0%; height: 100%; z-index: 99999; position: absolute; width: 100%; " class="">



    </div>

    <div id="loading_container2"  style="overflow: hidden; left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;background: white none repeat scroll 0% 0%; height: 100%; z-index: 99999; position: absolute; width: 100%; " class="">


    <img src="https://d13yacurqjgara.cloudfront.net/users/1275/screenshots/1198509/plus.gif" style="margin: 0px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100px;">

    </div>

    <?php endif; ?>
    

    
    
    
    <!-- Side Bar -->
    <div class="medium-12 ">

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
                        <a href="<?php echo '/' . $previousSegments; ?>" class="previous-segement">< BACK</a>
                    </ul>
                </nav>
                <div class="row">
                    <div class="small-12 small-centered  text-center">
                        <h2 style="color:#00bcb4 ">Search Result</h2>

                        <div class="search-container" style="display: block;">
                            <form method="get" action="/search/p" class="small-8 large-4  column small-centered large-centered">
                                <div>
                                    <img src="http://ibiza.dev/wp-content/themes/Ibiza-Theme/assets/images/search-icon.png" title="" alt="" class="">
                                    <input title="Search for:" value="<?php print $search; ?>" name="q" class="search-field typeahead  tt-hint" style="background: transparent none repeat scroll 0% 0%;" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" type="search">
                                   
                                </div>
                            </form>
                            <p class="text-center">See below <span id="results_count"></span> results for '<span><strong><?php print (string) htmlentities( $_GET['q'] ); ?></strong></span>'</p>
                        </div>                    
                    </div>
                </div>
                
            </div>

            <p class="show-for-small-only">Read More</p>
        </div>
    </div>

    
   <?php
   
   $class1      = '';                     
   $class2      = '';                        
   if( isset( $segments[1] ) && $segments[1] =='p' ){
       $class1      = 'active';     
   }else{
       $class2      = 'active';
   }
   
   ?>
    
    
    
    
    
    <div class="product-list-container columns">
        
        
        
        
        
        <div class="row column  show-for-large search-page-select">

            <div class="columns large-1 text-right"  >
                <a href="/search/p?q=<?php echo $search; ?>" class="<?php echo $class1 ?>">Products <span id="products-count"></span></a>
            </div>
            <div class="columns large-1 text-center"  style="padding:0;">
            <img src="/wp-content/themes/Ibiza-Theme/assets/images/line.png" />
              </div>
            <div class="columns large-2 text-left end">
                <a href="/search/h?q=<?php echo $search; ?>" class="<?php echo $class2 ?>">Projects & Guides <span id="howto-count"></span></a>
            </div>



        </div>        
        
        <div id="inner-content-product-list" class="row" <?php echo $filter_cat_str1;?>>
          
            
            
           
            <?php if (is_active_sidebar('homepagebelowmaincontent_4by2')) : ?>
            <div id="second-band" style="display:none;">
                <article class="learning__item box1--videos mobile-full tablet-and-up-half ">

                    <?php dynamic_sidebar('homepagebelowmaincontent_4by2'); ?>

                </article>         
             </div>
            <?php endif; ?> 
            
            
            
                <?php /* if($index=='howto'): ?>
                <div id="side-facets">

                      <h3>Search</h3>

                      <eui-searchboxx>
                          <p onclick="toggleFacets(jQuery(this).parent());">></p>
                      </eui-searchboxx>
                </div>
                <?php endif;*/ 
                ?>

                <?php if( $index=='product'): ?>
                <div class="sidebar columns large-2 large-text-left text-center <?php print $top_level == true ? 'category-page small-12' : 'product-page show-for-large' ; ?>" role="complementary">

                    <p class="show-for-large"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_RefineResults_Black.png" /> Refine Results:</p>
                    <div class="applied-filters">
                        <p class="bold">Applied Filters:</p>
                        <ul class="add_facets"></ul>
                        <button id="reset-filter" aria-expanded="false" aria-haspopup="true" data-yeti-box="example-dropdown2" data-is-focus="false" aria-controls="example-dropdown2" class="button" style="vertical-align: top"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_Productlist_ResetFilters.png" /> RESET ALL</button>
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
                    <eui-range display="'<?php echo ucwords( $facet->displayname ); ?>'" field="'<?php echo $facet->name; ?>.raw'"  min="'<?php echo $the_the_range->start ?>'"  max="'<?php echo $the_the_range->end ?>'"   size="10"></eui-range>

                    <?php endforeach;?>
                    <?php

                        break;
                        default:
                    ?>
                    <hr>
                    <eui-checklist  display="'<?php echo ucwords( $facet->displayname ); ?>'" field="'<?php echo $facet->name; ?>.raw'" size="10"><p onclick="toggleFacets(jQuery(this).parent());">toggle</p></eui-checklist> <!-- ACTION: change to field to use as facet -->
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
            
            
            <?php else: ?>
            
            <?php require( get_template_directory() .  '/parts/products-product.php'  );  ?>
            
            
            
            <?php endif; ?>
            <!-- Content end -->
            
  
        </div>
    </div>
</div>
    
<section class="row" id="third-band" style="display:none;">

        <?php if (is_active_sidebar('homepagebelowmaincontent_full2')) : ?>

        <article class="">

            <?php dynamic_sidebar('homepagebelowmaincontent_full2'); ?>

        </article>

        <?php endif; ?>

    </section>

</div>


<script>

var total_hits =0;

 var jsonStr = '{"query":{"query_string":{"query":"*<?php echo $search;?>*","lenient":true,"fields":["name"],"default_operator":"AND"}}}';

jQuery.getJSON( api_location + "/ProductCatalog.Api/api/elastic/product/_search?from=0&size=1&source=" +jsonStr, function( data ) {

    //console.log( data );


    total_hits+= parseInt(  data.hits.total  );
    jQuery('#results_count').text( total_hits );
    jQuery('#products-count').text( '('+ data.hits.total + ')' );
    
    jQuery.getJSON( api_location + "/ProductCatalog.Api/api/elastic/howto/_search?from=0&size=1&source=" +jsonStr, function( data ) {

        total_hits+= parseInt( data.hits.total  );
        jQuery('#results_count').text( total_hits );
        jQuery('#howto-count').text( '(' +  data.hits.total+ ')' );


        if(  total_hits <=0 ){

            jQuery('main,.search-page-select,.sidebar ').hide();
            jQuery('#third-band,#second-band').show();
        }

    });    
    
});





</script>

<?php get_footer(); ?>
