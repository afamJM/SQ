<?php 
/*
  Template Name: SQ Generic Template
 */



get_header();
$thisPageTitle = get_the_title();

$nav_menu_items = wp_get_nav_menu_items( 'Main'  , array( 'post_status' => 'publish,draft' ) );

 
function get_nav_menu_item_children( $parent_id, $nav_menu_items, $depth = true ) {
    
    $nav_menu_item_list = array();
    
    foreach ( (array) $nav_menu_items as $nav_menu_item ) {
        if ( $nav_menu_item->menu_item_parent == $parent_id ) {
            $nav_menu_item_list[] = $nav_menu_item;
            if ( $depth ) {
                if ( $children = get_nav_menu_item_children( $nav_menu_item->ID, $nav_menu_items ) ){
                    
                    $nav_menu_item_list = array_merge( $nav_menu_item_list, $children );
                
                    
                }
            }
        }
    }
    
    return $nav_menu_item_list;
}

 


?>
<div class="full-width-bg">
    <div class="row">
        <main id="main" class="large-12 medium-12 columns" role="main" >
    	<div class="large-12 medium-12 columns">
            <ul class="breadcrumbs show-for-medium">
                <li><a href="/" title="Home page">Home</a></li>
                <li class="current"><a <?php /*href="<?php get_template_directory_uri(); ?>/designers/<?php echo $post->post_name; ?>"*/ ?> title="<?php echo the_title(); ?> page"><?php echo the_title(); ?></a></li>
            </ul>
            <div class="back-house small-12 column show-for-small-only no-padding"><div class="back-button upper" onclick="window.history.back();">&lt; Back</div></div>
    	</div>

        <div class="large-2 medium-12 columns">
			<div class="product-list-container hide-for-small-only">
		    	<div class="category-list sidebar large-text-left text-center category-page">
                            <ul>
                            <?php $menus =  get_nav_menu_item_children(  26896 , $nav_menu_items ); ?>
                                <?php foreach ( $menus as $menu  ):    ?>
                                <li <?php if($menu->title == $thisPageTitle) print 'class="designer-arrow"'; ?>>
                                    <a href="<?php echo $menu->url; ?>" title="<?php echo  $menu->title; ?> page">
                                                <?php echo  $menu->title; ?>
                                        </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
		    	</div>
			</div>
    	</div>

		
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	    	<?php get_template_part( 'parts/loop', 'sq-generic' ); ?>
	    <?php endwhile; else : ?>
	   		<?php get_template_part( 'parts/content', 'missing' ); ?>
	    <?php endif; ?>


		</main> <!-- end #main -->

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>