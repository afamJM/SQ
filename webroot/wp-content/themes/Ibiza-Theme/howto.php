<?php

global $ibiza_api;
$product_type           = sanitize( $_GET['type'] );
$response               = $ibiza_api->get_howto(get_query_var('the_id'));
$core['name']           = 1;
$core['category']       = 1;
$core['image']          = 1;
$core['steps']          = 1;
$core['products']       = 1;
$core['images']         = 1;
$core['subtitle']       = 1;
$core['introduction']   = 1;
$core['_category']      = 1;

if( isset( $_GET['json'] ) ){
    echo json_encode( $response );
    die;
}

?>

<?php get_header(); ?>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.elevateZoom-3.0.8.min.js"></script>
<div class="full">
    <div class="row columns">
        <nav aria-label="You are here:" role="navigation">

            <ul class="breadcrumbs">

                <?php echo  implode( '' , breacdcrumbs( 'cat-' . (int)$response->data->category[0]  ) ) ; ?>

                <li>
                    <span class="show-for-sr">Current: </span> <?php echo $response->data->name; ?>
                </li>

            </ul>
        </nav>
    </div>
</div>

<div id="result">
    <div class="row" id="howto_main">

        <div class="small-12 medium-12 large-8 columns right">
            <h3 id="product_name"><?php echo $response->data->name; ?></h3>
            <!--<div class="top-meta meta-price">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pound-icon.png" />
                <span class="icon_text">&pound;75 - 100</span>
            </div>-->
            <div class="top-meta meta-level">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/level-icon.png" />
                <span class="icon_text"><?php echo( $response->data->level[0] ); ?></span>
            </div>
            <div id="how-to-desc-con"> 
                <div id="how-to-desc">
                    <h5><?php echo  $response->data->subtitle ?></h5>
                    <p  id="product_description"><?php echo $response->data->introduction; ?></p>
                </div>
            </div>
            
            <div style="clear:both;margin:10px 0" class="show-for-xlarge">
                <div class="addthis_inline_share_toolbox"></div>
            </div>            
        </div>
                
                
        <div class="small-12 medium-12 columns large-4" id="how-to-image-con">
            <div class="swiper-container-howto-main">
                
                <div class="swiper-wrapper">
                    <?php foreach( $response->data->image as $image ): ?>
                    <div class="swiper-slide">
                        <a href="<?php echo $image->url; ?>" rel="groups" class="th various"><img src="<?php echo $image->url; ?>" /></a>
                    </div>
                    <?php endforeach; ?>   
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>                 
                
        <div class="small-12 medium-12 columns large-4"  id="how-to-desc-mobile">
            
            
        </div>
                
    </div>
     
    <div>&nbsp;</div>  
        <div class="row">
        
        <div class="small-12 large-4 columns">                    
            
            
            
            <?php 
                                
            if($response->data->type!='Guide'): ?>
            
            <ul class="tabs" data-tabs id="howto-tabs">
                <li class="tabs-title is-active"><a href="#panel1" aria-selected="true"><span>What you will need</span></a><div class="tri"></div></li>
                
                <?php if( strlen( (string)$response->data->note ) >0  ): ?>
                
                <li class="tabs-title notes"><a href="#panel2"><span>Notes</span></a><div class="tri"></div></li>
                
                <?php endif; ?>
            </ul>

            <div class="tabs-content" data-tabs-content="howto-tabs">
                <div class="tabs-panel is-active" id="panel1">
                    
                        <?php 
                            foreach($response->data->products as $key => $productGroups):  
                        ?>
                        
                    <div>
                       
                        <h3><?php echo $productGroups->title; ?></h3>
                        
                        <?php foreach($productGroups->productgroup as $product): 
                            
                             echo '<p class="arrow">'. $product->title .'</p>';
                            
                            if(!isset($productsInArr[$product->productcode]) ){
                                
                            $productsInArr[$product->productcode]       = $rst = $ibiza_api->get_product( $product->productcode );
                            $productsInArrSchema[$product->productcode]  = $schema =  $ibiza_api->get_product_schema($rst[0]->{'$schema'});                                
                                
                            }else{
                                $rst    = $productsInArr[$product->productcode];
                                $schema =  $productsInArrSchema[$product->productcode];
                            }
                            

                            
                            
                            
                            ?>
                        
                            <div class="required-products row sq-border" id="product-<?php echo $product->product;?>">
                                
                                <div class="product-meta">
                                    <div class="product-image  small-3 medium-3 large-3 columns"><img src="<?php echo $rst[0]->data->images[0]->url;?>"/></div>
                                    <div class="product-info  small-9 medium-9  large-9  columns hidden">
                                        
                                        <p class="product-title"><a  data-prod-id="product-<?php echo $product->productcode ?>"  data-toggle="off-canvas-left" aria-expanded="false" aria-controls="off-canvas" class="product-link" href="/p/<?php echo $product->productcode ?>" class="howto_products" ><?php echo $rst[0]->data->name; ?></a></p>
                                        <p class="product-price"><?php print $rst[0]->data->price; ?></p>
                                        
                                        <?php if( $rst[0]->quantity > 0 ): ?>
                                        
                                        <button id="add-basket" class="button large expanded" type="button"  style="background: rgb(229, 111, 99) none repeat scroll 0% 0%; color: rgb(255, 255, 255); border: 0px none; text-transform: uppercase; font-size: 12px; padding: 4px 16px;" 
                                                data-product-id="<?php echo $rst[0]->data->legacycode; ?>"
                                                data-product-code="<?php $rst[0]->data->productcode; ?>"
                                                data-product-image="<?php echo $rst[0]->data->images[0]->url; ?>"
                                                data-product-name="<?php echo $rst[0]->data->name; ?>" 
                                                data-product-pice="<?php echo number_format($rst[0]->data->price, 2); ?>">Add to basket</button>                                        
                                        
                                        <br />              
                                        
                                        <?php endif; ?>
                                        <a data-prod-id="product-<?php echo $product->productcode ?>" data-toggle="off-canvas-left" aria-expanded="false" aria-controls="off-canvas" class="product-link" href="/p/<?php echo $product->productcode ?>" class="howto_products" >More Info</a>
                                        
                                    </div>
                                </div>
                                
                                <div style="display:none;" id="product-<?php echo $product->productcode ?>">
                                    
                                    <a href="#" class="brand-bg">X Close</a>
                                    
                                    <h2 class="product-title"><?php echo $rst[0]->data->name; ?></h2>
                                    <p>Product Code: <strong><?php echo $product->productcode ?></strong></p>
                                    <p class="product-price">&pound;<?php print $rst[0]->data->price; ?></p>
                                    
                                    <div class="swiper-container-howto-main">
                                        <div class="swiper-wrapper">
                                        <?php foreach($rst[0]->data->images as $image): ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo $image->url;?>" alt="" style="width:100%" />
                                            </div>
                                        <?php endforeach; ?>
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>                                        
                                    </div>
                                    <?php if( $rst[0]->quantity > 0 ): ?>
                                    <button id="add-basket" class="button large expanded" type="button"  style="background: rgb(229, 111, 99) none repeat scroll 0% 0%; color: rgb(255, 255, 255); border: 0px none; text-transform: uppercase; font-size: 12px; padding: 4px 16px;" 
                                            data-product-id="<?php echo $rst[0]->data->legacycode; ?>"
                                            data-product-code="<?php $rst[0]->data->productcode; ?>"
                                            data-product-image="<?php echo $rst[0]->data->images[0]->url; ?>"
                                            data-product-name="<?php echo $rst[0]->data->name; ?>" 
                                            data-product-pice="<?php echo number_format($rst[0]->data->price, 2); ?>">Add to basket</button>     
                                
                                <?php endif; ?>
                                <ul class="tabs" data-tabs id="<?php echo $product->productcode; ?>-tabs">
                                    <li class="tabs-title is-active columns small-6 text-center"><a href="#<?php echo $product->productcode; ?>-panel1" aria-selected="true"><span>Description</span></a><div class="tri"></div></li>
                                    <li class="tabs-title columns small-6 text-center "><a href="#<?php echo $product->productcode; ?>-panel2"><span>Specifications</span></a><div class="tri"></div></li>
                                </ul>

                                <div class="tabs-content" data-tabs-content="<?php echo $product->productcode; ?>-tabs">
                                    <div class="tabs-panel is-active" id="<?php echo $product->productcode; ?>-panel1">
                                        <p  id="product_description"><?php echo nl2br($rst[0]->data->description); ?></p>
                                    </div>
                                    <div class="tabs-panel" id="<?php echo $product->productcode; ?>-panel2">
                                        <div class="row medium-up-12 large-up-12">
                                            <div class="column">

                                                <?php foreach ($schema->properties as $key => $property): ?>
                                                    <?php if (!isset($core[$key]) && isset($response->$key) && $response->$key && $property->title): ?>

                                                        <div class="medium-6 large-6 columns attr_template">
                                                            <p><?php echo $property->title; ?></p>
                                                        </div>


                                                        <div class="medium-6 large-6 columns attr_template">
                                                            <p><?php echo $property->prepend . $response->$key . $property->append; ?></p>
                                                        </div>         

                                                    <?php endif; ?>   
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                            </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                    
                    
                </div>
                <div class="tabs-panel" id="panel2">
                    <div class="row medium-up-12 large-up-12 column">
                        <p>
                            <?php echo $response->data->note; ?>
                        </p>
                    </div>
                </div>
            </div>            
            
            <?php else: ?>
            
            <h2 class="title">Related Guides</h2>
            
            <ul class="related-guides">
                
                <li><a>Test</a></li>
                
            </ul>
            
            <?php endif; ?>
            
            <form>
            <fieldset>
                <legend><span>Email Newsletter Sign Up</span></legend>
                    
                <p>As well as hearing about all the latest news &amp; offers from The Sewing Quarter, you’ll also receive, tips, guides and projects.</p>
<!--                
                <input class="large-5 column" name="first_name" placeholder="First name" />


                <input class="large-5 large-push-1 column" name="last_name" placeholder="Last name" />-->

                <input class="large-11 column" name="email" placeholder="Email Address" />
                    
                
                <input type="submit" value="Submit" class="submit" />
                
            </fieldset>
            </form>
        </div>
        
        <div class="small-12  large-8 columns  steps-out-most">
            <div class="steps-outter">
            <div class="row steps-inner">
            <?php ///print_r( $response->data->image ); ?>
                <!-- Slider main container -->
                    <!-- Additional required wrapper -->
                    
                    <?php $i =0; ?>
                    
                    <?php foreach( $response->data->steps  as $key=> $steproups ): ?>
                    <div class="step-info">
                        <div class="large-12 " >
                           <h5><?php echo $steproups->title ?></h5>
                        </div>
                    </div>
                        <?php foreach( $steproups->stepgroup  as $key_inner=> $step ): ?>
                    
                    
                        <?php   $i++;  ?>
                    
                    <div class="large-12" style="overflow: hidden;">
                        
                        <div class="step-info">
                            <div class="large-1 small-1 columns" style="padding: 0">
                                <?php if( $step->step ): ?>
                                <span style="display: inline-block; background: #00bcb4; height: 25px; width: 25px; border-radius: 15px; text-align: center; line-height: 23px; color: rgb(255, 255, 255);"><?php echo $step->step ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="large-11 small-11 columns step-desc-detail">
                                <h5><?php echo $step->title ?></h5>
                                <p style="font-size:12px;"><?php echo $step->description; ?></p>                        
                            </div>
                        </div>
                        
                        <div style="clear:both"></div>
                        
                        <?php if( count($step->image ) ): ?>
                        <div class="columns small-12 medium-11 large-12 step-group-images">
                            
                            
                            
                            <?php 
                            $col = 12;
                            switch ( count($step->image) )
                            {
                                case 1:
                                    $col = 12;
                                    break;
                                case 2:
                                    $col = 6;
                                    break;
                                case 3:
                                    $col = 4;
                                    break;
                                case 4:
                                    $col = 3;
                                    break;
                                default:
                                    $col = 2;
                                    break;
                            }
                            ?>
                            <div class="swiper-container-howto-steps swiper" >
                                <div class="swiper-wrapper">
                                <?php foreach($step->image as $image):   ?>
                                    <div class="medium-<?php echo $col; ?> large-<?php echo $col; ?> columns" style="padding:0 2px 0 0">
                                        
<!--                                        <a rel="groups" class="th various" href="<?php echo $image->url; ?>"
                                           data-zoom-image="<?php echo $image->url; ?>"  
                                           data-image="<?php echo $image->url; ?>" title="&lt;b&gt;<?php echo $step->title ?>&lt;/b&gt; <?php echo $step->description; ?>">                        -->
                                        <img  src="<?php echo $image->url; ?>" alt="" />
<!--                                        </a>-->
                                    </div>
                                <?php endforeach; ?>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>                            
                            
                            
                        </div>
                        <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                       
                    <?php endforeach; ?>
            
            </div>
        </div>    
    </div>
</div>

</div>

<div style="display:none" id="cool-slide-out">
    <div class="row" >
        <div id="fill-me-up" class="column small-12">
            
        </div>
    </div>
</div>

<script type="text/javascript">
    
    var zoomConfig      = {cursor: 'crosshair', responsive: true ,   zoomType : "inner",}; 
    var image           = jQuery('.elevatezoom-gallery');
    var zoomImage       = jQuery('img#zoom_01');    
    var mySwiperSteps   = null;
    var open = 0;
    jQuery( document ).ready(function() {

    
        jQuery('#panel1-label').click( function(){
            
            jQuery('#panel1 .sq-border').show();
            
        });
    

        enquire.register("screen and (max-width:64em)", {

            match : function() {

                jQuery('#how-to-desc').appendTo('#how-to-desc-mobile');
                
                
                jQuery('.swiper-container-howto-steps .swiper-wrapper > div').addClass('swiper-slide');
                
                mySwiperSteps = new Swiper('.swiper-container-howto-steps', {
                    // Optional parameters
                    slidesPerView: 1,
                    autoHeight: true,
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev'            
                });                
                

            } ,
            
            unmatch : function() {
                jQuery('#how-to-desc').appendTo('#how-to-desc-con');
                console.log(mySwiperSteps); 
                if(mySwiperSteps){
                    console.log('destroy'); 
                    mySwiperSteps[0].destroy(true, true);
                    
                }
                jQuery('.swiper-container-howto-steps .swiper-wrapper > div').removeClass('swiper-slide');
            }
        });    
   
   
        jQuery('.product-link').click( function(e){
            
            
            
            jQuery('#fill-me-up').html('');
            
            e.preventDefault();
            jQuery('#cool-slide-out .row').prependTo('body');
            
            
            var clone = jQuery('#'+jQuery(this).attr('data-prod-id' )).clone();
            clone.fadeIn(  );
            jQuery('#fill-me-up').append( clone );

            open  = 0;
             jQuery('#fill-me-up').fadeIn( function(){
                 
                             var mySwiper = new Swiper('.swiper-container-howto-main', {
                // Optional parameters
                slidesPerView: 1,
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev'            
            });
                 jQuery('.tabs').foundation();
             });
        });
        
        jQuery('body').on('click' , '.off-canvas-wrapper-inner' ,  function(e){
            
            console.log('Hey')
            
            if(open==2){
                // stop it from re running
                return;
            }
            
            if(open==1){
                jQuery('#fill-me-up').fadeOut();
                jQuery('#fill-me-up').css('z-index' , '0');
                open = 2
                // end point;
            }     
            else if(open==0 ){
                 jQuery('div#fill-me-up').css('z-index' , '99999');
                open =1;
                // just started
            }
        });
        
   
        jQuery( ".required-products a" ).each(function( index ) {

            var url = jQuery(this).attr( 'href' ).replace('bundle' , 'json' );
            
            jQuery.getJSON( url , function( data ) {

               console.log(data.images[0].url);
                
                jQuery( '.product-image img' ,  '#product-' + data.productcode ).attr( 'src' , data.images[0].url );
                jQuery( '.product-price' ,  '#product-' + data.productcode ).text( '£' + data.price.toFixed(2) );
                
                
            });


        });
        
        
	jQuery(".various").fancybox({
		maxWidth	: 800   ,
		maxHeight	: 600   ,
		fitToView	: true ,
		width		: '70%' ,
		height		: '100%' ,
		autoSize	: true ,
		closeClick	: false ,
		openEffect	: 'none',
		closeEffect	: 'none',
                type            : 'ajax',
                nextEffect      : 'none',
                prevEffect      : 'none',
                'type'            : 'image' ,
		helpers	: {
			title	: {
				type: 'over'
			},
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}                
	});

	jQuery(".howto_products").fancybox({
		maxWidth	: 800   ,
		maxHeight	: 600   ,
		fitToView	: false ,
		width		: '70%' ,
		height		: '70%' ,
		autoSize	: false ,
		closeClick	: false ,
		openEffect	: 'none',
		closeEffect	: 'none',
                type            : 'ajax',
                nextEffect      : 'none',
                prevEffect      : 'none'           
	});







        var mySwiper = new Swiper('.swiper-container-howto-main', {
            // Optional parameters
            slidesPerView: 1,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev'            
        });



        //initialize swiper when document ready  
        var mySwiper_products = new Swiper('.swiper-container-products', {
            // Optional parameters
            loop: true,
            slidesPerView: 4,
            spaceBetween: 4,
            breakpoints: {
                // when window width is <= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetweenSlides: 10
                },
                // when window width is <= 480px
                480: {
                    slidesPerView: 1,
                    spaceBetweenSlides: 20
                },
                // when window width is <= 640px
                640: {
                    slidesPerView: 1,
                    spaceBetweenSlides: 30
                }

            }
        });



        jQuery('.product_refresh').click( function( e ) { 
            
            e.preventDefault();
            
            var product_name    = jQuery( this ).attr( 'data-name' );
            var product_id      = jQuery( this ).attr( 'data-id' );
            var url             = "/p/" + product_id  + "/" + product_name + '?json=1&type=<?php echo $product_type; ?>';
            
            jQuery.ajax({
                dataType  : 'json' ,
                url: url
            })  .done(function( data ) {
                if ( console && console.log ) {
                    console.log(  data );

                        
                    mySwiper_products.removeAllSlides();
                        
                    for( var image in  data._source.images ){
                        
                        mySwiper_products.appendSlide('<div class="swiper-slide"><img src="'  + data._source.images[image].url  + '" /></div>')
                    }
                    
                        
                    jQuery('.zoomContainer').remove();
                    zoomImage.removeData('elevateZoom');
                    // Reinitialize EZ
                    

                    jQuery('#product_name').text( data._source.name );
                    jQuery('#product_description').text( data._source.description );
                    jQuery('#product_price').text( '<?php echo $schema->properties->price->prepend ?>' + data._source.price.toFixed(2) );
                    jQuery('#zoom').attr('href' , data._source.images[0].url );

                    // Remove old instance od EZ
                    jQuery('.zoomContainer').remove();
                    zoomImage.removeData('elevateZoom');
                    // Update source for images
                    zoomImage.attr('src',  data._source.images[0].url );
                    zoomImage.data('zoom-image',  data._source.images[0].url );
                    // Reinitialize EZ
                    zoomImage.elevateZoom(zoomConfig);
                    
                    
                }
              });
            
        });

        
        jQuery("#zoom").fancybox({
                        fitToView	: true
                });

        jQuery("#zoom_01").elevateZoom( zoomConfig );


        image.on('click', function(e){

            e.preventDefault();
            // Remove old instance od EZ
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

<!-- Footer -->
<?php get_footer(); ?>
