<?php
/*
  Template Name: Product Page
 */


global $ibiza_api;

$core = $ibiza_api->get_core_attributes();
$rst = $ibiza_api->get_product(get_query_var('products'));
$response = $rst[0]->data;
$schema = $ibiza_api->get_product_schema($rst[0]->{'$schema'});

if ((!$_COOKIE['nsec']) && (!$_COOKIE['ann'])) {
    setcookie('ann', $_SERVER['REMOTE_ADDR'] . '.' . date('d.m.Y.h.i.s'), time() + 3600, '/', '.' . $_SERVER['SERVER_NAME']);
}

/**
 * Handle a JSON request
 */
if (isset($_GET['json'])) {
    echo json_encode($response);
    die;
}

/**
 * Handle a bundle request
 */
if (isset($_GET['bundle'])) {
    return require('product-bundle.php');
}
$breadcrumbs = breacdcrumbs('cat-' . (int) $response->category[0], 'post', 'publish', $response->name);

wp_enqueue_script('elevatezoom-js', get_template_directory_uri() . '/assets/js/jquery.elevateZoom-3.0.8.min.js', array('jquery'), '', true);

get_header();
?>

<div class="full show-for-medium">
    <div class="row">
        <nav aria-label="You are here:" role="navigation" class="columns">

            <ul class="breadcrumbs">

                <?php echo implode('', $breadcrumbs); ?>

            </ul>
        </nav>
    </div>
</div>
<div id="result">
    <div class="row" id="prodcut_main">


        <div class="medium-12 large-6 columns" id="prodcut_main_inner">
            <div class="text-center  large-12 medium-10 hide-for-small-only  n-l-p columns" id="product_image_container">


                <?php if (isset($response->images[0]->url)): ?>
                    <a href="<?php echo $response->images[0]->url; ?>" id="zoom" class="text-center" title="Show the larger image">
                        <img id="zoom_01" data-zoom-image="<?php echo $response->images[0]->url; ?>" src="<?php echo $response->images[0]->url; ?>" alt="Image" title="Image"  />
                    </a>
                <?php else: ?>
                    <img src="/wp-content/themes/Ibiza-Theme/assets/images/no-product-image-350x250.png" title="No Photo" alt="No Photo" />
                <?php endif; ?>
                <span class="enlarge">&#128269; click image to enlarge</span>
            </div>
            <!--            <div class="clear">&nbsp;</div>-->
            <div class="medium-2 large-12 columns small-12 n-l-p n-r-p" id="product_images_container">


                <!-- Slider main container -->
                <div class="swiper-container-products">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">

                        <?php
                        if ($response->images):
                            foreach ($response->images as $i => $image):
                                ?>

                                <div class="swiper-slide">

                                    <a  rel="group"  class="gallery" href="<?php echo $image->url; ?>"
                                        title="Click to show image"
                                        data-zoom-image="<?php echo $image->url; ?>"  
                                        data-image="<?php echo $image->url; ?>">                        
                                        <img data-zoom-image="<?php echo $image->url; ?>" src="<?php echo $image->url; ?>"  alt="Thumb Product Image"   title="Thumb Product Image"  />
                                    </a>

                                </div>

                            <?php endforeach; ?>
<?php endif; ?>

                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                </div>

            </div>
            <div  class="clear add-this">
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox"></div>
            </div>

        </div>
        <div class="medium-12 large-6 columns">

            <div id="title-area"  class="column">
                <h3 id="product_name"><?php echo $response->name; ?></h3>
<!--                <p><img src="/wp-content/themes/Ibiza-Theme/assets/images/stars-product-page.png"> Write the first Review </p>-->
                <p>Product code: <strong><span id="product_code" class="strong"><?php print get_query_var('products'); ?></span></strong></p>
            </div>

            <div class="row column product-meta-con product_controls">
                <div class="product-meta1">

                    
                    <div class="small-4 medium-3 <?php echo (strlen(number_format($response->price, 2)) == 4 ? 'large-3' : 'large-4'); ?> columns">
                        <h4 id="product_price"><?php echo $schema->properties->price->prepend ?><?php echo number_format($response->price, 2); ?> </h4>                        
                    </div>

<?php if ($response->quantity > 0): ?>
                    <div class="small-6 medium-2 <?php echo (strlen(number_format($response->price, 2)) == 4 ? 'large-3' : 'large-3'); ?> columns">

                            <div class="small-3 medium-3 large-3 columns increment">
                                <a href="#" id="remove_quantity" title="Click to reduce quantiy">-</a>
                            </div>

                            <div class="small-4 medium-5 large-4 columns no-padding">
                                <input type="text" id="quantity" value="1">
                            </div>

                            <div class="small-3 medium-3 large-3 columns increment end">
                                <a href="#"  id="add_quantity"  title="Click to increase quantiy">+</a>
                            </div>
                    </div>                    

                        <div class="small-12 show-for-small-only columns">&nbsp</div>

                        <div class="small-6 medium-4 large-2 columns text-center">
                            <p class="in-stock">
                                <span class="icon"></span>
                                In Stock</p>
                        </div>

                        <div class="small-6 medium-3 large-3 columns  right">
                            
                            <div class="small-9 medium-7 large-9 columns right">
                                <p class="shipping-costs">Delivery From Only &pound;2.99</p>
                            </div>                            
                            
                            <div class="small-3 medium-3 large-3  columns right delivery">
                                <span class="icon"></span>
                            </div>

                        </div>

                        <div class="small-12">
                            <button  class="add-to-basket add-basket button large expanded" type="button"
                                     data-product-id="<?php echo $response->legacycode; ?>"
                                     data-product-code="<?php print get_query_var('products'); ?>"
                                     data-product-image="<?php echo $response->images[0]->url; ?>"
                                     data-product-name="<?php echo $response->name; ?>" 
                                     data-product-pice="<?php echo number_format($response->price, 2); ?>">Add to basket</button>
                        </div>

<?php else: ?>

                        <div class="small-4 medium-6 large-4 columns text-center">

                            <p class="no-stock-text"><span class="icon"></span>Out of stock</p>

                        </div>

                        <div class="small-4 medium-3 large-4 columns">

                            &nbsp;

                        </div>

                        <div class="small-12">
                            <button class="add-to-basket add-basket button large expanded no-stock" disabled="disabled" type="button">Add to basket</button>                    
                        </div>
<?php endif; ?>
                </div>
            </div>

            <div class="clear">&nbsp;</div>

            <div class="large-8 medium-12 columns tabber hide-for-large-up">
                <div class="large-12 no-padding tab-house">
                    <div data-tabbed="desc" class="tabber-tab active">Description <div class="down-arrow"></div></div>
                    <div data-tabbed="spec" class="tabber-tab">Specifications <div class="down-arrow"></div></div>
                    <div class="clear"></div>
                </div>
                <div class="tabber-content active" data-content="desc">
                    <p  id="product_description"><?php echo nl2br($response->description); ?></p>
                </div>
                <div class="tabber-content" data-content="spec">
                    <div class="spec-house large-6 medium-12 small-12 columns">
                        <?php foreach ($schema->properties as $key => $property): ?>
    <?php if (!isset($core[$key]) && isset($response->$key) && $response->$key && $property->title): ?>
                                <div class="small-6 columns attr_template">
                                    <p><?php echo $property->title; ?></p>
                                </div>
                                <div class="small-6 columns attr_template">
                                    <p><?php echo $property->prepend . $response->$key . $property->append; ?></p>
                                </div>         
                            <?php endif; ?>   
<?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="columns large-12 hide-for-medium-down">

                <div class="row medium-up-12 large-up-12">
                    <h2>Description</h2>
                    <p  id="product_description"><?php echo nl2br($response->description); ?></p>
                </div>

                <div class="row medium-up-12 large-up-12">
                    <h2>Specifications</h2>

                    <?php foreach ($schema->properties as $key => $property): ?>
    <?php if (!isset($core[$key]) && isset($response->$key) && $response->$key && $property->title): ?>

                            <div class="small-6 columns attr_template">
                                <p><?php echo $property->title; ?></p>
                            </div>


                            <div class="small-6 columns attr_template">
                                <p><?php echo $property->prepend . $response->$key . $property->append; ?></p>
                            </div>         



    <?php endif; ?>   


<?php endforeach; ?>
                </div>
                <!--                </div>-->
            </div>






<?php if ($response->items): ?>

                <p>In this bundle.</p>
                <ul class="inline-list row">
    <?php foreach ($response->items as $item): ?>


                        <li class="medium-6 large-6 columns attr_template">
                            <a  rel="groups"   href="/p/<?php echo $item->productcode; ?>?bundle=1" class="product_bundle various" title="Show this product">
                                <?php
                                $pItem = $ibiza_api->get_product($item->productcode);


                                if (!$pItem[0]->data->images[0]->url) {
                                    $pItem[0]->data->images[0]->url = 'https://s3.amazonaws.com/images.seroundtable.com/out-of-stock-1395144988.png';
                                }

                                echo '<img width="50" src="' . $pItem[0]->data->images[0]->url . '"    alt="Image"   title="Image" />';
                                echo '<br /><span>' . $pItem[0]->data->name . '</span>'
                                ?>
                            </a>
                        </li>




                <?php endforeach; ?>
                </ul>
<?php endif; ?>

        </div>

    </div>
</div>
<!-- Footer -->


<div  class="hidden" id="attr_template">
    <div class="medium-6 large-6 columns attr_template attr_key">
        <p></p>
    </div>
    <div class="medium-6 large-6 columns attr_template attr_value">
        <p></p>
    </div>
</div>

<script type="text/javascript">

    function creatSwiper()
    {

        if (mySwiper_products) {
            mySwiper_products.destroy(true, true);
        }

        var dir = 'horizontal';
        var ah = true;
        var spv = 7;

        if (jQuery(window).width() > 620 && jQuery(window).width() < 1006) {

            dir = 'vertical';
            ah = false;

        }

        if (jQuery(window).width() < 630) {

            spv = 1;
        }

        mySwiper_products = new Swiper('.swiper-container-products', {
            // Optional parameters
            loop: false,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            slidesPerView: spv,
            direction: dir,
            autoHeight: ah
        });

    }

    function find_product(data_in)
    {

        var product = null

        jQuery.each(data_in, function (key, val) {

            if (val.id == currentProductId) {

                product = val;
                return false;
            }

        });

        return product;

    }


    function update_product(el)
    {
        var product_name = 'product-name'; // not needed! jQuery( this ).attr( 'data-name' );

        var product_id = jQuery(el).attr('data-id');

        var url = "/p/" + product_id + "/" + product_name + '/?json=1';

        jQuery.ajax({
            dataType: 'json',
            url: url
        }).done(function (data) {
            mySwiper_products.removeAllSlides();

            for (var image in  data.images) {

                var image_link_el_start = '<a title="Show this image" data-image="' + data.images[image].url + '" data-zoom-image="' + data.images[image].url + '" href="' + data.images[image].url + '" class="gallery">';
                var image_link_el_end = '</a>';
                mySwiper_products.appendSlide('<div class="swiper-slide">' + image_link_el_start + '<img src="' + data.images[image].url + '"  alt="Image"   title="Image" />' + image_link_el_end + '</div>');

            }

            jQuery('.columns .attr_template').remove();

            for (var d in  data) {

                console.log(data[d]);

                if (jQuery.inArray(d, core) == -1 && data[d] && schema[d]) {


                    var el = jQuery('#attr_template').clone();


                    jQuery('.attr_key p', el).text(schema[d].title);
                    jQuery('.attr_value p', el).text(schema[d].prepend + data[d] + schema[d].append);

                    jQuery('#panel2 .column').before(el.html());
                }



            }

            jQuery('.zoomContainer').remove();

            zoomImage.removeData('elevateZoom');
            // Reinitialize EZ

            jQuery('#product_code').text(data.productcode);
            jQuery('#product_name').text(data.name);
            jQuery('#product_description').text(data.description);
            jQuery('#product_price').text('<?php echo $schema->properties->price->prepend ?>' + data.price.toFixed(2));
            jQuery('#zoom').attr('href', data.images[0].url);

            // Remove old instance od EZ
            jQuery('.zoomContainer').remove();
            zoomImage.removeData('elevateZoom');
            // Update source for images
            zoomImage.attr('src', data.images[0].url);
            zoomImage.data('zoom-image', data.images[0].url);
            // Reinitialize EZ
            zoomImage.elevateZoom(zoomConfig);


        });
    }

    function update_current_dimension_text(el, dimension)
    {
        jQuery('#current_' + jQuery(el).parent().attr('id')).text(dimension);
    }

    function render_dimension(data, d1, d2)
    {

        jQuery('.dimension').removeClass('current');
        jQuery('.dimension').hide();

        jQuery.each(data, function (key, val) {

            jQuery('[data-dimension="' + key + '"]').show();
            // all dimenion one should show
            var topDKey = key;


            if (typeof val != 'object') {


                jQuery('[data-dimension="' + key + '"]').attr('data-id', val);
                // for 1d only, as we the data we need
            }


            if (key == d1) {

                var current_d1_el = jQuery('[data-dimension="' + d1 + '"]');

                current_d1_el.addClass('current');

                update_current_dimension_text(current_d1_el, key);







                if (typeof val == 'object') {
                    /// 2d array onoly

                    var i = 0;
                    jQuery.each(val, function (key, val) {
                        if (key == d2) {

                            jQuery('[data-dimension="' + d2 + '"]').addClass('current');
                            update_current_dimension_text(jQuery('[data-dimension="' + d2 + '"]'), key);
                        }

                        if (i == 0) {

                            jQuery('[data-dimension="' + topDKey + '"]').attr('data-id', val);
                            // set the lvl1 d to the first levl 2 value
                        }

                        jQuery('[data-dimension="' + key + '"]').attr('data-id', val);
                        jQuery('[data-dimension="' + key + '"]').show();
                        // show d2 based on the current selected d1

                        i++;

                    });
                }
            }

        });
    }



    var currentProductId = '<?php echo get_query_var('products'); ?>';
    var zoomConfig = {cursor: 'crosshair', responsive: true, zoomType: "inner", };
    var image = jQuery('.gallery');
    var zoomImage = jQuery('img#zoom_01');
    var core = [];
    var schema = {};
    var variants = {};
    var current_product = null;
    var f_dimension1 = null; // final;
    var f_dimension2 = null; // final;   
    var mySwiper_products = null;

<?php foreach ($core as $attr => $value): ?>

        core.push('<?php echo $attr ?>');

<?php endforeach; ?>


<?php foreach ($schema->properties as $key => $property): ?>

    <?php if (!isset($core[$key])): ?>

            schema['<?php echo $key ?>'] = {'append': '<?php echo $property->append; ?>', 'prepend': '<?php echo $property->prepend; ?>', title: '<?php echo $property->title; ?>'};

    <?php endif; ?>
<?php endforeach; ?>



    jQuery(document).ready(function () {

        initTabs()
        jQuery(document).on("click", '#add_quantity', function (e) {
            e.preventDefault();
            jQuery('#quantity').val(parseInt(jQuery('#quantity').val()) + 1);

        });


        jQuery(document).on("click", '#remove_quantity', function (e) {
            
            e.preventDefault();
            
            if (parseInt(jQuery('#quantity').val()) <= 1) {
                return;
            }

            jQuery('#quantity').val(parseInt(jQuery('#quantity').val()) - 1);



        });

        creatSwiper();
        jQuery(".various").fancybox({
            maxWidth: 800,
            maxHeight: 600,
            fitToView: false,
            width: '70%',
            height: '70%',
            autoSize: false,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none',
            type: 'ajax',
            nextEffect: 'none',
            prevEffect: 'none'
        });


        jQuery.getJSON('<?php echo $ibiza_api::$end_points['variantgroup'] . get_query_var('products'); ?>', function (data) {


            if (!data) {
                return;
            }

            data = data[0];
            var el = jQuery('<div/>');
            variants = data;
            //console.log( el );

            //console.log( data[0] );
            if (typeof data != 'undefined') {
                jQuery.each(data.dimensions, function (key, val) {


                    var dimension_id = 'dimension_' + val.name.replace(' ', '_').toLowerCase();
                    var lvl = key + 1;

                    el.append('<p class="lvl' + lvl + '_text">' + val.name + ' : <span id="current_' + dimension_id + '" ></span></p>');
                    el.append('<ul id="' + dimension_id + '" class="inline-list row">');



                    jQuery.each(val.members, function (key, val) {


                        var d_display = val.name;

                        if (val.image.length > 0) {

                            d_display = '<img src="' + val.image + '"  alt="Option Image"   title="Option Image"  />';

                        }


                        jQuery('ul#' + dimension_id, el).append('<li class="dimension lvl' + lvl + '" data-dimension="' + val.name + '">' + d_display + '</li>');

                    });

                    el.append('</ul>');

                });

                jQuery('#panel1').parent().after(el);

                current_product = find_product(data.variants);
                f_dimension1 = null; // final;
                f_dimension2 = null; // final;

                //console.log( data );

                jQuery.each(data.transformedVariants, function (key, val) {

                    var dimension1 = key;

                    // create seperate method for 1d and 2d



                    if (typeof val === 'object') {


                        jQuery.each(val, function (key, val) {

                            var dimension2 = key;

                            if (val == currentProductId) {

                                f_dimension1 = dimension1;
                                f_dimension2 = dimension2;
                                return false;

                            }

                        });

                        render_dimension(variants.transformedVariants, f_dimension1, f_dimension2);

                    } else {



                        if (val == currentProductId) {
                            console.log(variants.transformedVariants);
                            f_dimension1 = dimension1;
                            f_dimension2 = '';

                            render_dimension(variants.transformedVariants, f_dimension1, f_dimension2);

                        }


                    }

                });


            }
        });





        jQuery(window).resize(function () {


            initTabs()
            jQuery("#zoom").attr('href', jQuery(this).data('image'));
            jQuery('.zoomContainer').remove();
            zoomImage.removeData('elevateZoom');
            // Update source for images
            zoomImage.attr('src', jQuery(this).data('image'));
            zoomImage.data('zoom-image', jQuery(this).data('zoom-image'));
            // Reinitialize EZ
            zoomImage.elevateZoom(zoomConfig);

            creatSwiper();

            //initialize swiper when document ready  

            //




        });


        jQuery(document).on("click", ".dimension", function () {

            var dimension = jQuery(this).attr('data-dimension');

            if (jQuery(this).hasClass('lvl1')) {

                f_dimension1 = dimension;
                dimension = '';

            } else {
                f_dimension2 = dimension;
            }

            render_dimension(variants.transformedVariants, f_dimension1, f_dimension2);

            if (!dimension) {

                jQuery('.lvl2').removeClass('current');
                jQuery('.lvl2_text span').text('');

            }

            update_product(this);

        });



        //Tabber
        function initTabs() {
            jQuery('.tabber').each(function () {
                var papa = jQuery(this);
                if (papa.find('.tab-house').is(':visible')) {
                    papa.addClass('is-active');
                    papa.find('[data-tabbed]').off('click');//clear any old listeners
                    papa.find('[data-tabbed]').on('click', function () {
                        papa.find('.tabber-content.active').removeClass('active');
                        papa.find('.tabber-tab.active').removeClass('active');
                        jQuery('[data-content=' + jQuery(this).data('tabbed') + ']').addClass('active');
                        jQuery('[data-tabbed=' + jQuery(this).data('tabbed') + ']').addClass('active');
                        papa.addClass('active');
                    });
                } else {
                    papa.removeClass('is-active');
                }
                ;
            });
        }
        ;






        jQuery("#zoom").click(function () {

            var fancy = [];
            var index = 0;
            var curHref = jQuery(this).attr('href');

            jQuery(".gallery").each(function (indexIn) {


                if (jQuery(this).attr('href') == curHref) {
                    index = indexIn;
                }


                fancy.push({
                    href: jQuery(this).attr('href'),
                    //title : '2nd title'
                });
            });

            jQuery.fancybox.open(fancy, {
                padding: 0,
                index: index,
                nextEffect: 'none',
                prevEffect: 'none'
            });

            return false;

        });

        jQuery("#zoom_01").elevateZoom(zoomConfig);


        jQuery(document).on("click", '.gallery', function (e) {


            //image.on('click', function(e){
            e.preventDefault();
            // Remove old instance od EZ
            jQuery("#zoom").attr('href', jQuery(this).data('image'));
            jQuery('.zoomContainer').remove();
            zoomImage.removeData('elevateZoom');
            // Update source for images
            zoomImage.attr('src', jQuery(this).data('image'));
            zoomImage.data('zoom-image', jQuery(this).data('zoom-image'));
            // Reinitialize EZ
            zoomImage.elevateZoom(zoomConfig);


        });


    });

</script>


<?php get_footer(); ?>