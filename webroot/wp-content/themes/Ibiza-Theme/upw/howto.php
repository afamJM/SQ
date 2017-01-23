<?php
/**
 * Custom ultimate posts widget template
 *
 * @version     2.0.0
 */

$image              = '';
$cats               = explode( ',' ,  $instance['cats'] ) ;
$slider             = 1;
$container_class    = 'products_widget';
$row_class          = ' large-6 columns';
$swiper_data        = '';
$style= '';
if( $slider == 1 ){
    $swiper_data        = ' class="swiper-wrapper" style="box-sizing:border-box;" ';
    $container_class    = 'swiper-container-howto';
    $row_class          = 'swiper-slide ';
    $style              = 'style="margin: 0 auto;  overflow: hidden;    position: relative; z-index: 1;"';
}




?>

<?php if ($instance['before_posts']) : ?>
  <div class="upw-before">
    <?php echo wpautop($instance['before_posts']); ?>
  </div>
<?php endif; ?>



<div class="upw-posts hfeed <?php echo $container_class; ?>" <?php echo $style; ?>>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div> 
  <?php if ($upw_query->have_posts()) : ?>
    <div<?php echo $swiper_data;?>>
        

        
      <?php while ($upw_query->have_posts()) : $upw_query->the_post(); ?>
        
        

        
        
        <?php $current_post = ($post->ID == $current_post_id && is_single()) ? 'active' : '';   ;?>
        
    
        
    
        <?php $howto =  get_product_by_mongo_id( $post->post_title ) ;  print_r($product); ?>
     <div class="<?php echo $row_class; ?>">
        
    
        <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>              
              <article <?php post_class($current_post.  ' widget-style'); ?>  style="background:url(<?php the_post_thumbnail_url($instance['thumb_size']); ?>);" >
        <?php else:?>
            <article <?php post_class($current_post.  ' widget-style'); ?>>
        <?php endif; ?>    
    
        

          <header>



            <?php if (get_the_title() && $instance['show_title']) : ?>
              <h4 class="entry-title">
                  <a href="<?php the_permalink(); ?>" rel="bookmark" title="..">
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
                      <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn" title="..">
                      <?php echo get_the_author(); ?>
                    </a>
                  </span>
                <?php endif; ?>

                <?php if ($instance['show_author'] && $instance['show_comments']) : ?>
                  <span class="sep"><?php _e('|', 'upw'); ?></span>
                <?php endif; ?>

                <?php if ($instance['show_comments']) : ?>
                  <a class="comments" href="<?php comments_link(); ?>" title="..">
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
                  <a href="<?php the_permalink(); ?>" class="more-link" title=".."><?php echo $instance['excerpt_readmore']; ?></a>
                <?php endif; ?>
              </p>
            </div>
          <?php elseif ($instance['show_content']) : ?>
            <div class="entry-content">
              <?php the_content() ?>
            </div>
          <?php endif; ?>

        
                
                
          <?php // product specfic info  ?>
                
            <div class="large-12 columns">
                <h6><a href="/h/<?php echo $howto->_id;?>/" title="<?php echo  $howto->data->name; ?> page"><?php echo  $howto->data->name; ?></a></h6>
                <p><img src="<?php echo $howto->data->image; ?>" alt="Image" title="Image"  /></p>
            </div>         
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


<?php                 
wp_add_inline_script( 'site-js',"

jQuery(document).ready(function () {
    //initialize swiper when document ready  
    var mySwiper = new Swiper('.swiper-container-howto', {
        // Optional parameters
        loop                : false ,
        pagination          : '.swiper-pagination',
        paginationClickable : true ,
        slidesPerView       : 5 ,
        nextButton : '.swiper-button-next',
        prevButton : '.swiper-button-prev'
    });
    
});

");?>