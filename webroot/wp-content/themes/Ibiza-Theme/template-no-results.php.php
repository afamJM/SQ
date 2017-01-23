<?php
/*
  Template Name: No Results
 */
 ?>
<?php
global $ibiza_api;

get_header(); ?>

<div id="content" class="search-page">

    <div class="results-container">
       <div><h2>Error 404 - Page Not Found</h2></div>
       <div>The page you are looking for could not be found. Use the search bar or the links below to help find what you are looking for.</div>
       <div class="search-container-results block-el">
            <?php require 'parts/search-area.php'; ?>
        </div>
    </div>
    <div class="product-list-container columns">

        <div id="inner-content-product-list" class="row" <?php echo $filter_cat_str1;?>>
           
            <?php if (is_active_sidebar('homepagebelowmaincontent_4by2')) : ?>
            <div id="second-band" <?php echo $resultTotal>0? ' class="hidden"' : '' ; ?>>
                <article class="learning__item box1--videos mobile-full tablet-and-up-half ">

                    <?php dynamic_sidebar('homepagebelowmaincontent_4by2'); ?>

                </article>         
            </div>
            <?php endif; ?> 

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
