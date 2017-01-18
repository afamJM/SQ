<?php if(is_front_page())return; ?>
<article id="post-<?php the_ID(); ?>" class="large-10 medium-12 columns" role="article" itemscope itemtype="http://schema.org/BlogPosting">
					
    <section class="large-12 medium-12" itemprop="articleBody">

            <div class="row designer-bottom">
                    <div class="designer-content small-12 columns">
                        <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </div>
            </div>

	</section> <!-- end article section -->
													
</article> <!-- end article -->