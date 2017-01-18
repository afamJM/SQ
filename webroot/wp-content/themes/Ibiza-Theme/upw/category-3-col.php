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

$slider             = 0;
$container_class    = 'category_widget';
$row_class          = ' large-3 small-6 columns';
$swiper_data        = '';
if( $slider == 1 ){
    $swiper_data        = ' class="swiper-wrapper" style="box-sizing:border-box;" ';
    $container_class    = 'swiper-container';
    $row_class          = 'swiper-slide ';
}


$ids = array();



$ids = array();

while ($upw_query->have_posts()) : $upw_query->the_post();

    $ids1[] = $post->ID;
    $ids2[] = '"cat-' . $post->post_title . '"';
endwhile;


if( count( $ids1 ) >0 )
{
    global $wpdb;

    
    
    
    




    $myrows = $wpdb->get_results(  'SELECT * FROM wp_postmeta AS w1  
                        WHERE post_id IN ( ' . implode( ',' , $ids1 ) . ' ) AND ( meta_key = "_cs-start-date" OR meta_key = "_cs-expire-date" OR meta_key = "_cs-enable-schedule" )
                        ');

    foreach($myrows as $row)
    {

        $rowArr[ $row->post_id ][ $row->meta_key ] = $row->meta_value;

    }
    
    
    
 
    
    
    
    
    $myrows = $wpdb->get_results(  'SELECT * FROM wp_postmeta AS w1 WHERE meta_key IN ( ' . implode( ',' , $ids2 ) . ' )   OR meta_key = "_menu_item_url" ');

    foreach($myrows as $row)
    {

        if( $row->meta_key == '_menu_item_url' ){
             $rowArrs[ $row->post_id ]['url']       =  $row->meta_value;
        }else{
            $data                                   = json_decode( $row->meta_value );
            $rowArrs[ $row->post_id ]['title']      = $data->title;
            $rowArrs[ $row->post_id ]['id']         = $data->id;
            $rowArrs[ $row->post_id ]['image']      = isset($data->image)?$data->image:'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
        }

    }
}

 // tidy data, remove unsed entries

if($rowArrs)
 foreach ($rowArrs as $row)
 {
     
     if( isset($row['id']) ){
        
            $rowArrTitles[$row['id']]['title'] = $row['title'];
            $rowArrTitles[$row['id']]['url'] =  $row['url'];;
            $rowArrTitles[$row['id']]['image'] =  $row['image'];;
    }
 }     

/**
 * @todo Move to a model inside of a plugin api
 */


?>

<?php if ($instance['before_posts']) : ?>
  <div class="upw-before">
    <?php echo wpautop($instance['before_posts']); ?>
  </div>
<?php endif; ?>



<div class="upw-posts hfeed <?php echo $container_class; ?>">

    
  <?php if ($upw_query->have_posts()) : ?>
    <div<?php echo $swiper_data;?>>
      <?php while ($upw_query->have_posts()) : $upw_query->the_post(); ?>
        
        
        <?php

    
        ?>
        
        
        <?php $current_post = ($post->ID == $current_post_id && is_single()) ? 'active' : '';   ;?>
        
    
        
    
        
        <div class="<?php echo $row_class; ?>">
        
            
    
        <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>              
              <article <?php post_class($current_post); ?>  style="    height: 100%;background-size:cover;background:url(<?php the_post_thumbnail_url($instance['thumb_size']); ?>); border: 1px solid #ddd;
    padding: 17px;" >
        <?php else:?>
                  
            <?php 
            
   
            
            ?>
                  
            <article <?php post_class($current_post); ?> style="    height: 100%;background-size:cover;background:url(<?php echo $rowArrTitles[trim(get_the_title())]['image'];; ?>); border: 1px solid #ddd;
    padding: 17px;" >
        <?php endif; ?>    
    
        

          <header>
                
              
              
              
            <?php if (get_the_title() && $instance['show_title']) : ?>
              <h4 class="entry-title"><a href="<?php echo $rowArrTitles[trim(get_the_title())]['url']; ?>"><?php echo $rowArrTitles[trim(get_the_title())]['title']; ?></a></h4>
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