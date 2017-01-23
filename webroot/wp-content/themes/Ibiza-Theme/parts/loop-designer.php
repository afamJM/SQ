<?php if(is_front_page())return; ?>
<article id="post-<?php the_ID(); ?>" class="large-10 medium-10 columns" role="article" itemscope itemtype="http://schema.org/BlogPosting">
					
    <section class="large-12 medium-12 columns" itemprop="articleBody">

	    <div class="designer-top row">
	    	<div class="designer-top-inner">
				<div class="large-4 medium-4 columns no-padding">
					<?php the_post_thumbnail('full'); ?>
				</div>
				<div class="large-8 medium-8 columns">
			    	<header class="article-header">	
						<h1 class="header-black entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
				    </header> <!-- end article header -->
					<p><?php echo get_the_excerpt(); ?></p>
				</div>
			</div>
		</div>

		<div class="row designer-bottom">
			<div class="designer-content large-6 medium-6 columns">
				<?php the_content(); ?>
			</div>
			<div class="designer-slider large-6 medium-6 columns">
				<div class="swiper-container-designer">

					    <!-- Additional required wrapper -->
					    <div class="swiper-wrapper">
                                            <?php 
                                               if( class_exists('Dynamic_Featured_Image') ) {
                                                   global $dynamic_featured_image;
                                                   $featured_images = $dynamic_featured_image->get_featured_images();
                                                   for ($i=0; $i < count($featured_images); $i++) { 
                                                ?>
                                                <div class="swiper-slide">
                                                    <img src="<?php echo $featured_images[$i]['full'] ?>" alt="Designer Photo" title="Designer Photo" />
                                                </div>
                                                <?php
                                                   }
                                               }
                                            ?>
                                            </div>
					    <!-- If we need pagination -->
					    <div class="swiper-pagination"></div>

					    <!-- If we need navigation buttons -->
					    <div class="swiper-button-prev"></div>
					    <div class="swiper-button-next"></div>

				</div>
			</div>
		</div>
        
                <?php 
                
                wp_add_inline_script( 'site-js', 			
                                        "jQuery(document).ready(function () {   
                                            var mySwiper = new Swiper('.swiper-container-designer', {
                                                // Optional parameters
                                            loop                : true ,
                                            pagination          : '.swiper-pagination',
                                            paginationClickable : true ,
                                            slidesPerView       : 1 ,
                                            nextButton : '.swiper-button-next',
                                            prevButton : '.swiper-button-prev'
                                            });
                                        });"  , 'after'
                                    );
                ?>

	</section> <!-- end article section -->
													
</article> <!-- end article -->