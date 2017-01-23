<?php
/*
  Template Name: Today's Products
 */


global $ibiza_api;

$todaysProducts = json_decode( getSslPage( $ibiza_api::$end_points['todaysproducts'] ));
?>

<?php get_header(); ?>

<div id="content" class="full">
    <div class="row">
        
        <div class="large-12 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs show-for-medium">
                    <li><a href="/" title="Home page">Home page </a></li>
                    <li><a <?php /* href="/tv-schedule/"*/ ?> title="Products From Today's Show">Products From Today's Show</a></li>
                </ul>
                <ul class="breadcrumbs show-for-small-only">
                    <a href="/" class="previous-segement upper" title="Go back to the homepage">&lt; Back</a>
                </ul>
            </nav>  

            <h3 class="hide-for-medium-down">Products From Today's Show</h3>
        </div>          

        <section id="dvDayShowProducts">
            <!--Built using Javascript-->
        </section>
    </div>
</div>




<?php get_footer(); ?>