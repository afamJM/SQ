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
        
    
        <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>              
              <article <?php post_class($current_post); ?>>
        <?php else:?>
            <article <?php post_class($current_post); ?>>
        <?php endif; ?>    
    
            <div class="large-2 columns">
                  <img src="<?php the_post_thumbnail_url($instance['thumb_size']); ?>"  alt="Image" title="Image"  />
            </div>  

            <header  class="large-10 columns">



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

          

          <?php if ($instance['show_excerpt']) : ?>
            <div class="entry-summary">
              <p>
                <?php echo get_the_excerpt(); ?>
                <?php if ($instance['show_readmore']) : ?> <br />
                <a href="<?php the_permalink(); ?>" class="more-link" title=".."><?php echo $instance['excerpt_readmore']; ?></a>
                <?php endif; ?>
              </p>
            </div>
          <?php elseif ($instance['show_content']) : ?>
            <div class="entry-content">
              <?php the_content() ?>
            </div>
          <?php endif; ?>
            </header>
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