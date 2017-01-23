<?php
/**
 * Custom ultimate posts widget template
 *
 * @version     2.0.0
 */

$image = '';

?>

<?php if ($instance['before_posts']) : ?>
  <div class="upw-before">
    <?php echo wpautop($instance['before_posts']); ?>
  </div>
<?php endif; ?>


<div class="upw-posts hfeed row">

  <?php if ($upw_query->have_posts()) : ?>

      <?php while ($upw_query->have_posts()) : $upw_query->the_post(); ?>
        
    
        <?php $current_post = ($post->ID == $current_post_id && is_single()) ? 'active' : '';   ;?>
        
        <div class="columns small-12 medium-6 large-3">
            <img src="<?php the_post_thumbnail_url($instance['thumb_size']); ?>" alt="Image" title="Image" />
        </div>  
    <div class="show-small-only clear">&nbsp;</div>
      <?php endwhile; ?>

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