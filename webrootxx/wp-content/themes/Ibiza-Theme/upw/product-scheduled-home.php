<?php
/**
 * Custom ultimate posts widget template
 *
 * @version     2.0.0
 */

$image          = '';
$cats           =  explode( ',' ,  $instance['cats'] ) ;
//$is_scheduled   = false;
//
//
//foreach( $cats as $cat ){
//    
//    if( get_cat_name( $cat ) == 'Scheduled' ){
//        
//        $is_scheduled = true;
//        
//    }
//    
//}

$slider             = 1;
$container_class    = 'products_widget';
$row_class          = ' large-6 columns';
$swiper_data        = '';
if( $slider == 1 ){
    $swiper_data        = ' class="swiper-wrapper" style="box-sizing:border-box;" ';
    $container_class    = 'swiper-container-scheduled-home swiper large-6';
    $row_class          = 'swiper-slide ';
}


$ids = array();

while ($upw_query->have_posts()) : $upw_query->the_post();

    $ids[] = $post->ID;

endwhile;



if( count( $ids ) >0 )
{
    global $wpdb;

    $myrows = $wpdb->get_results(  'SELECT * FROM wp_postmeta AS w1  
                        WHERE post_id IN ( ' . implode( ',' , $ids ) . ' ) AND ( meta_key = "_cs-start-date" OR meta_key = "_cs-expire-date" OR meta_key = "_cs-enable-schedule" )
                        ');

    foreach($myrows as $row)
    {

        $rowArr[ $row->post_id ][ $row->meta_key ] = $row->meta_value;

    }
}
/**
 * @todo Move to a model inside of a plugin
 */


?>

<?php if ($instance['before_posts']) : ?>
  <div class="upw-before">
    <?php echo wpautop($instance['before_posts']); ?>
  </div>
<?php endif; ?>

<div class="upw-posts hfeed <?php echo $container_class; ?>">
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div> 
    <div class="swiper-pagination"></div>        
    
  <?php if ($upw_query->have_posts()) : ?>
    <div<?php echo $swiper_data;?>>
      <?php while ($upw_query->have_posts()) : $upw_query->the_post(); ?>
        
        
        <?php
        
        $skip = false;
        if( (isset( $rowArr[$post->ID]['_cs-expire-date'] ) && isset( $rowArr[$post->ID]['_cs-start-date'] ) ) && $rowArr[$post->ID]['_cs-enable-schedule'] == 'Enable'  ){


            if( time() > $rowArr[$post->ID]['_cs-start-date'] && time() < $rowArr[$post->ID]['_cs-expire-date']) {

            }else{
                
                $skip   = true;
                
            }
            
        }else{
            
            $skip   = true;
            
        }

        if( $skip == 1){
            continue;
        }
        
        ?>
        
        
        <?php $current_post = ($post->ID == $current_post_id && is_single()) ? 'active' : '';   ;?>
        
    
        
    
        <?php $product =  get_product_by_mongo_product_code( $post->post_title ) ;  ?>
        <div class="<?php echo $row_class; ?>">
        
    
        <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>              
              <article <?php post_class($current_post); ?>  style="background:url(<?php the_post_thumbnail_url($instance['thumb_size']); ?>); border: 1px solid #ddd;
    padding: 17px;" >
        <?php else:?>
            <article <?php post_class($current_post); ?>>
        <?php endif; ?>    
    
        

          <header>



            <?php if (get_the_title() && $instance['show_title']) : ?>
              <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark">
                  <?php the_title(); ?>
                </a>
              </h4>
            <?php endif; ?>

            <?php if ($instance['show_date'] || $instance['show_author'] || $instance['show_comments']) : ?>

              <div class="entry-meta">

                <?php if ($instance['show_date']) : ?>
                  <time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_time($instance['date_format']); ?></time>
                <?php endif; ?>

                <?php if ($instance['show_date'] && $instance['show_author']) : ?>
                  <span class="sep"><?php _e('|', 'upw'); ?></span>
                <?php endif; ?>

                <?php if ($instance['show_author']) : ?>
                  <span class="author vcard">
                    <?php echo __('By', 'upw'); ?>
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn">
                      <?php echo get_the_author(); ?>
                    </a>
                  </span>
                <?php endif; ?>

                <?php if ($instance['show_author'] && $instance['show_comments']) : ?>
                  <span class="sep"><?php _e('|', 'upw'); ?></span>
                <?php endif; ?>

                <?php if ($instance['show_comments']) : ?>
                  <a class="comments" href="<?php comments_link(); ?>">
                    <?php comments_number(__('No comments', 'upw'), __('One comment', 'upw'), __('% comments', 'upw')); ?>
                  </a>
                <?php endif; ?>

              </div>

            <?php endif; ?>

          </header>

          <?php if ($instance['show_excerpt']) : ?>
            <div class="entry-summary">
              <p>
                <?php echo get_the_excerpt(); ?>
                <?php if ($instance['show_readmore']) : ?>
                  <a href="<?php the_permalink(); ?>" class="more-link"><?php echo $instance['excerpt_readmore']; ?></a>
                <?php endif; ?>
              </p>
            </div>
          <?php elseif ($instance['show_content']) : ?>
            <div class="entry-content">
              <?php the_content() ?>
            </div>
          <?php endif; ?>

        
                
                
          <?php // product specfic info  ?>
                <a href="/p/<?php echo $product->data->productcode;?>/"><img src="<?php echo $product->data->images[0]->url; ?>" alt="" /></a>
                <p><a href="/p/<?php echo $product->data->productcode;?>/"><?php echo  $product->data->name; ?></a></p>
                <p>&pound;<?php echo number_format( $product->data->price , 2 ); ?></p>
                <p><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span> Read Reviews (15)</p>
          <footer>

            <?php
            $categories = get_the_term_list($post->ID, 'category', '', ', ');
            if ($instance['show_cats'] && $categories) :
            ?>
              <div class="entry-categories">
                <strong class="entry-cats-label"><?php _e('Posted in', 'upw'); ?>:</strong>
                <span class="entry-cats-list"><?php echo $categories; ?></span>
              </div>
            <?php endif; ?>

            <?php
            $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');
            if ($instance['show_tags'] && $tags) :
            ?>
              <div class="entry-tags">
                <strong class="entry-tags-label"><?php _e('Tagged', 'upw'); ?>:</strong>
                <span class="entry-tags-list"><?php echo $tags; ?></span>
              </div>
            <?php endif; ?>

            <?php if ($custom_fields) : ?>
              <?php $custom_field_name = explode(',', $custom_fields); ?>
              <div class="entry-custom-fields">
                <?php foreach ($custom_field_name as $name) :
                  $name = trim($name);
                  $custom_field_values = get_post_meta($post->ID, $name, true);
                  if ($custom_field_values) : ?>
                    <div class="custom-field custom-field-<?php echo $name; ?>">
                      <?php
                      if (!is_array($custom_field_values)) {
                        echo $custom_field_values;
                      } else {
                        $last_value = end($custom_field_values);
                        foreach ($custom_field_values as $value) {
                          echo $value;
                          if ($value != $last_value) echo ', ';
                        }
                      }
                      ?>
                    </div>
                  <?php endif;
                endforeach; ?>
              </div>
            <?php endif; ?>

          </footer>

        </article>
    </div>
      <?php endwhile; ?>
              </div>
  <?php else : ?>

    <p class="upw-not-found">
      <?php _e('No posts found.', 'upw'); ?>
    </p>

  <?php endif; ?>

</div>

<?php if ($instance['after_posts']) : ?>
  <div class="upw-after">
    <?php echo wpautop($instance['after_posts']); ?>
  </div>
<?php endif; ?>

<script>

jQuery(document).ready(function () {
    //initialize swiper when document ready  
    var mySwiper = new Swiper('.swiper-container-scheduled-home', {
        // Optional parameters
        loop                : false ,
        pagination          : '.swiper-pagination',
        paginationClickable : true ,
        slidesPerView       : 4 ,
        nextButton : '.swiper-button-next',
        prevButton : '.swiper-button-prev'
    });
    
});


</script>