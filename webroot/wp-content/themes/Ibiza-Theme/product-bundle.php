<?php
/*
  Template Name: Product Page
 */


global $ibiza_api;

$core                   = $ibiza_api->get_core_attributes();
$rst                    = $ibiza_api->get_product(get_query_var('products'));
$response               = $rst[0]->data;
$schema                 = $ibiza_api->get_product_schema( $rst[0]->{'$schema'});


?>




<div id="result">
    <div class="row" id="prodcut_main">
        
        <h4 id="product_name"><?php echo $response->name; ?></h4>
        
        <hr />
        
        <div class="medium-6 columns">

            <img id="zoom_01"   data-zoom-image="<?php echo $response->images[0]->url; ?>" src="<?php echo $response->images[0]->url; ?>">

        </div>
        <div class="medium-6 columns">

           

            <h4 id="product_price"><?php echo $schema->properties->price->prepend ?><?php echo number_format( $response->price , 2); ?> </h4>

            <p  id="product_description"><?php echo $response->description; ?></p>



            <?php //print_r( $schema->properties );die; ?>

            <?php foreach($schema->properties as $key => $property): ?>
            <?php   if( !isset( $core[$key] ) && isset($response->$key) && $response->$key && $property->title ): ?>

            <div class="medium-6 large-6 columns attr_template">
                <p><?php echo $property->title; ?></p>
            </div>


            <div class="medium-6 large-6 columns attr_template">
                <p><?php echo $property->prepend .  $response->$key . $property->append; ?></p>
            </div>         



            <?php endif; ?>   
            <?php endforeach; ?>

            
            <?php if( $_GET['bundle']==2 ): ?>
            add to basket
            <?php endif;?>

        </div>
    </div>
</div>

    



<?php //get_footer(); ?>