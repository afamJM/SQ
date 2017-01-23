<?php
global $ibiza_api;
?>

<?php get_header(); ?>
<div class="full-width-bg">
    <div class="row">
        <!-- Thumbnails -->
        <main id="main" class="large-12" role="main" >

            <section class="row" id="second-band">



                <article class="large-6 category-boxes catLargeRight columns">
                    <div id="sticky-posts-16" class="widget widget_ultimate_posts">
                        <div class="upw-posts hfeed category_widget">
                            <div>
                                <div class=" large-12 small-12 columns">
                                    <article class="post-26859 featured_categories type-featured_categories status-publish has-post-thumbnail hentry category-c1 category-featured-products" style="    height: 100%;background-size:cover;background-image:url(http://ibiza.dev/wp-content/uploads/2016/08/ImgHpCat_Embroidery.png); border: 1px solid #ddd;
                                             padding: 17px;">
                                        <header>
                                            <h4 class="entry-title"><a href="/how-to-guides/guides/56">Guides</a></h4>
                                        </header>
                                        <footer>
                                        </footer>
                                    </article>
                                </div>
                            </div>

                        </div>

                    </div>
                </article>   


                <article class="large-6 category-boxes catLargeRight columns">
                    <div id="sticky-posts-16" class="widget widget_ultimate_posts">
                        <div class="upw-posts hfeed category_widget">
                            <div>
                                <div class=" large-12 small-12 columns">
                                    <article class="post-26859 featured_categories type-featured_categories status-publish has-post-thumbnail hentry category-c1 category-featured-products" style="    height: 100%;background-size:cover;background-image:url(http://ibiza.dev/wp-content/uploads/2016/08/ImgHpCat_Embroidery.png); border: 1px solid #ddd;
                                             padding: 17px;">
                                        <header>
                                            <h4 class="entry-title"><a href="/how-to-guides/projects/56">Projects</a></h4>
                                        </header>
                                        <footer>
                                        </footer>
                                    </article>
                                </div>
                            </div>

                        </div>

                    </div>
                </article>      



                <div class="clear"></div>


            </section>

            <section class="row">
                <article class="large-12 columns no-padding">
                    <?php dynamic_sidebar('featured-howtos'); ?>
                </article>
            </section>

            <!-- End Thumbnails -->
        </main>
    </div>
</div>
<?php get_footer(); ?>
<script type="text/javascript">
    // Height matching code
    function heightMatcher(A, B) {
        jQuery(B).height('auto');
        jQuery(B).height(jQuery(B).height());/*This line stops decimal points*/
        jQuery(A).height(jQuery(B).height());
    }
    ;
    jQuery(document).ready(function () {
        jQuery('.height-as-width').height((jQuery('.height-as-width').width()) * 0.9);
        setTimeout(function () {
            heightMatcher('.catLarge', '.catLargeRight');
            jQuery('.catLarge').find('*:not(h4)').css('height', '100%');
        }, 300);
    });
    jQuery(window).resize(function () {
        jQuery('.height-as-width').height((jQuery('.height-as-width').width()) * 0.9);
        heightMatcher('.catLarge', '.catLargeRight');
        //Put a minimum screen size in here where it is all reset to auto
    });
</script>
