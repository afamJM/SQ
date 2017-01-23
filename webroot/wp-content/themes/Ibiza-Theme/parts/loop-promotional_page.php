<?php if(is_front_page())return; ?>
<article id="post-<?php the_ID(); ?>" class="small-12 columns" role="article" itemscope itemtype="http://schema.org/BlogPosting">
					
    <section class="large-12 medium-12" itemprop="articleBody">
		
		<div class="designer-content large-12 medium-12 columns">
                        <h2><?php the_title(); ?></h2>
                        <?php the_excerpt(); ?>
		</div>
	</section>
</article>
<div class="fullwidth">
	<div class="designer-content large-12 medium-12 columns">
		<ul class="tabs" id="promotions-tabs" data-tabs>
			<?php 
				
				$tabarray = array();

				$meta_tab1 = get_post_meta( $post->ID , 'promo_tab_1');
				if(isset($meta_tab1[0]) && !empty($meta_tab1[0])){
					$content = array();
					$content['tab'] = $meta_tab1[0];
					$meta_content1 = get_post_meta( $post->ID , 'promo_tabContent_1');
					$meta_image1 = get_post_meta( $post->ID , 'promo_tabImage_1');
					$meta_link1 = get_post_meta( $post->ID , 'promo_tablink_1');
					$meta_linklabel1 = get_post_meta( $post->ID , 'promo_tablinklabel_1');
					$content['content'] = $meta_content1[0];
					$content['image'] = $meta_image1[0];
					$content['link'] = $meta_link1[0];
					$content['linklabel'] = $meta_linklabel1[0];

					$tabarray[] = $content;
				}

	        	$meta_tab2 = get_post_meta( $post->ID , 'promo_tab_2');
	        	if(isset($meta_tab2[0]) && !empty($meta_tab2[0])){
					$content = array();
					$content['tab'] = $meta_tab2[0];
					$meta_content2 = get_post_meta( $post->ID , 'promo_tabContent_2');  
        			$meta_image2 = get_post_meta( $post->ID , 'promo_tabImage_2'); 
        			$meta_link2 = get_post_meta( $post->ID , 'promo_tablink_2');
					$meta_linklabel2 = get_post_meta( $post->ID , 'promo_tablinklabel_2');
        			$content['content'] = $meta_content2[0];
					$content['image'] = $meta_image2[0]; 
					$content['link'] = $meta_link2[0];
					$content['linklabel'] = $meta_linklabel2[0];

					$tabarray[] = $content;
				}
	        	$meta_tab3 = get_post_meta( $post->ID , 'promo_tab_3');
	        	if(isset($meta_tab3[0]) && !empty($meta_tab3[0])){
					$content = array();
					$content['tab'] = $meta_tab3[0];
					$meta_content3 = get_post_meta( $post->ID , 'promo_tabContent_3');  
       				$meta_image3 = get_post_meta( $post->ID , 'promo_tabImage_3'); 
       				$meta_link3 = get_post_meta( $post->ID , 'promo_tablink_3');
					$meta_linklabel3 = get_post_meta( $post->ID , 'promo_tablinklabel_3');
       				$content['content'] = $meta_content3[0];
					$content['image']= $meta_image3[0];
					$content['link'] = $meta_link3[0];
					$content['linklabel'] = $meta_linklabel3[0];

					$tabarray[] = $content;
				}
				 
				for ($i = 0; $i < count($tabarray); $i++) { 
					if(strrpos($tabarray[$i]['tab'], "://") )
					{	
						//$size = getimagesize($tabarray[$i]);
						/*style="width:<?php echo $size[0] . "px"?>; height:<?php echo ($size[1]/2) . "px"?>;object-position: 0 <?php echo -($size[1]/2) . "px"?>"*/
			?>
	
		  				<li class="tabs-title<?php echo ($i == 0 ? " is-active" : ""); ?>" ><a href="#panel<?php echo $i ?>"><img  src="<?php echo $tabarray[$i]['tab']; ?>" /></a></li>
		  			<?php
		  				}else{
		  			?>
		  				<li class="tabs-title<?php echo ($i == 0 ? " is-active" : ""); ?>"><a href="#panel<?php echo $i ?>"><?php echo $tabarray[$i]['tab']; ?></a></li>
		  	<?php
		  			}
		  		}
		  	?>
		  	
		</ul>
	</div>
</div>
<article id="post-<?php the_ID(); ?>" class="small-12 columns" role="article" itemscope itemtype="http://schema.org/BlogPosting">
					
    <section class="large-12 medium-12" itemprop="articleBody">
		<div class="tabs-content" id="promotions-tabs-content" data-tabs-content="promotions-tabs">
				<?php
					for ($i = 0; $i < count($tabarray); $i++) { 	
				?>
				<div class="tabs-panel is-active" id="panel<?php echo $i ?>">

					<div class="designer-slider large-6 medium-12 columns">
						<?php echo $tabarray[$i]['content'];?>  
						<?php
							if(isset($tabarray[$i]['linklabel']) && !empty($tabarray[$i]['linklabel'])){
						?>
						<div class="upw-after">
							<a href="" class="layout-button"><?php echo $tabarray[$i]['linklabel'];?></a>
						</div>   
						<?php
							}
						?>          
					</div>
					<div class="designer-slider large-6 medium-12 columns" id="promotionImagePage">
						<?php
							if(isset($tabarray[$i]['image']) && !empty($tabarray[$i]['image'])){
						?>
							<img src="<?php echo $tabarray[$i]['image']; ?>" />
						<?php
							}
						?>
					</div>
				</div>
			<?php
				}
			?>
			
		</div> 

	</section> <!-- end article section -->
													
</article> <!-- end article -->
<script>
	jQuery( document ).ready(function() {
    	jQuery(".tabs").foundation();
    });
    
</script>