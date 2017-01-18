<?php get_header();
$thisPageTitle = get_the_title();
?>
<div class="full-width-bg">
    <div class="row">
        <main id="main" class="large-12 medium-12 columns" role="main" >
    	<div class="large-12 medium-12 columns">
    			<ul class="breadcrumbs show-for-medium">
	                <li><a href="<?php get_template_directory_uri(); ?>">Home</a></li>
	                <li><a href="<?php get_template_directory_uri(); ?>/designers">Designers</a></li>
	                <li class="current"><a href="<?php get_template_directory_uri(); ?>/designers/<?php echo $post->post_name; ?>"><?php echo the_title(); ?></a></li>
                </ul>
                <div class="back-house small-12 column show-for-small-only no-padding"><div class="back-button" onclick="window.history.back();">&lt; BACK</div></div>
    	</div>

        <div class="large-2 medium-2 columns">
			<div class="product-list-container hide-for-small-only">
		    	<div class="category-list sidebar large-text-left text-center category-page">
		    		<ul>
			    		<?php $loop = new WP_Query( array( 'post_type' => 'designers', 'posts_per_page' => -1 ) ); ?>
						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<li <?php if(get_the_title() == $thisPageTitle) print 'class="designer-arrow"'; ?>>
							<a href="<?php echo get_permalink(); ?>">
								<?php echo get_the_title(); ?>
							</a>
						</li>
						<?php endwhile; wp_reset_query(); ?>
					</ul>
		    	</div>
			</div>
    	</div>

		
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	    	<?php get_template_part( 'parts/loop', 'designer' ); ?>
	    <?php endwhile; else : ?>
	   		<?php get_template_part( 'parts/content', 'missing' ); ?>
	    <?php endif; ?>


		</main> <!-- end #main -->

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>