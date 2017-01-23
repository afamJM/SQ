<?php
/*
  Template Name: Today's Products
 */


global $ibiza_api;

$todaysProducts = json_decode(file_get_contents($ibiza_api::api_location . '/ProductCatalog.api/api/legacy/todaysproducts'));
?>

<?php get_header(); ?>

<div id="content" class="full">
    <div class="row">
        
        <div class="large-12 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs show-for-medium">
                    <li><a href="/">Home page </a></li>
                    <li><a href="/tv-schedule/">Products From Today's Show</a></li>
                </ul>
                <ul class="breadcrumbs show-for-small-only">
                    <a href="/product-list/fabric/" class="previous-segement">&lt; BACK</a>
                </ul>
            </nav>  

            <h3 class="hide-for-medium-down">Products From Today's Show</h3>
        </div>          

        <section id="dvDayShowProducts" class="row">
            <!--Built using Javascript-->
        </section>
    </div>
</div>




<?php get_footer(); ?>