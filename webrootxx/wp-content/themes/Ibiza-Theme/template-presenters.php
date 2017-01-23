<?php
/*
  Template Name: Presenters
 */


global $ibiza_api;


?>

<?php get_header(); ?>

<div id="content">
    <div id="inner-content" class="row">
        
        <main id="main" role="main" >
                    
            <?php if (is_active_sidebar('presenters')) : ?>

                <div  class="large-12 medium-12 small-12 columns">
                    <?php dynamic_sidebar('presenters'); ?>
                </div>         

            <?php endif; ?>  
                    
        </main>
    </div>
</div>

<?php get_footer(); ?>
