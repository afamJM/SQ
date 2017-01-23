<?php get_header();
$thisPageTitle = get_the_title();
?>
<div class="full-width-bg">
    <div class="row">
        <main id="main" class="large-12 columns" role="main" >
    	<div class="large-12 columns">
            <ul class="breadcrumbs show-for-medium">
                <li><a href="<?php get_template_directory_uri(); ?>" title="Home page link">Home</a></li>
                <li class="current">Designers</li>
            </ul>
            <div class="back-house small-12 column show-for-small-only no-padding">
                <div class="back-button" onclick="window.history.back();">&lt; BACK</div>                    
            </div>
    	</div>

    	<?php dynamic_sidebar('designers-blurb'); ?>

        <div class="large-2 columns">
			<div class="product-list-container hide-for-medium-down">
		    	<div class="category-list sidebar large-text-left text-center category-page">
		    		<ul>
			    		<?php $loop = new WP_Query( array( 'post_type' => 'designers', 'posts_per_page' => -1 ) ); ?>
						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<li>
							<a href="<?php echo get_permalink(); ?>"  title="Page link">
								<?php echo get_the_title(); ?>
							</a>
						</li>
						<?php endwhile; wp_reset_query(); ?>
					</ul>
		    	</div>
			</div>
    	</div>

		<article id="post-<?php the_ID(); ?>" class="large-10 columns" role="article" itemscope itemtype="http://schema.org/BlogPosting">
		    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		    	<div class="designers-icon-wrap no-padding-right large-3 medium-4 small-6 columns <?php if (($wp_query->current_post +1) == ($wp_query->post_count)) echo 'end'; ?>">
			    	<section class="designers-icon" itemprop="articleBody">
			    		<a href="<?php echo the_permalink(); ?>"  title="Page link">
				    		<div class="designers-icon-inner">
								<?php the_post_thumbnail('full'); ?>
								<p><?php the_title(); ?></p>
							</div>
						</a>
					</section> <!-- end article section -->
				</div>

		    <?php endwhile; else : ?>
		   		<?php get_template_part( 'parts/content', 'missing' ); ?>
		    <?php endif; ?>
		</article>


		</main> <!-- end #main -->

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>