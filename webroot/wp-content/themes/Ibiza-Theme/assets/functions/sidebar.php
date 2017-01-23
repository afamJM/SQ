<?php
// SIDEBARS AND WIDGETIZED AREAS
function joints_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __('Sidebar 1', 'jointswp'),
		'description' => __('The first (primary) sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'offcanvas',
		'name' => __('Offcanvas', 'jointswp'),
		'description' => __('The offcanvas sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'searchbar',
		'name' => __('Searchbar', 'jointswp'),
		'description' => __('The search area sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'homepagesidebar',
		'name' => __('Homepage sidebar', 'jointswp'),
		'description' => __('The search area sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s  large-4 medium-8 columns">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'homepagebelowmaincontent',
		'name' => __('Homepage panel below content', 'jointswp'),
		'description' => __('The search area sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'homepagebelowmaincontent_left1',
		'name' => __('Homepage panel below content first left', 'jointswp'),
		'description' => __('The search area sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'homepagebelowmaincontent_left2',
		'name' => __('Homepage panel below content second left', 'jointswp'),
		'description' => __('The search area sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'homepagebelowmaincontent_right',
		'name' => __('Homepage panel below content on the right', 'jointswp'),
		'description' => __('The search area sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'homepageleft',
		'name' => __('Homepage panel on the left', 'jointswp'),
		'description' => __('Homepage left sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'howtoguides',
		'name' => __('How to Guides Products', 'jointswp'),
		'description' => __('How to Guides Products.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'products',
		'name' => __('Products Landing Page', 'jointswp'),
		'description' => __('Products Landing Page.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'homepagebelowmaincontent_full',
		'name' => __('Homepage panel below content full', 'jointswp'),
		'description' => __('Homepage panel below content full.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'homepagebelowmaincontent_4by2',
		'name' => __('Homepage panel below content four by two', 'jointswp'),
		'description' => __('The upper four by two blocks on the homepage.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'id' => 'homepagebelowmaincontent_full2',
		'name' => __('Homepage panel below content full second', 'jointswp'),
		'description' => __('Homepage panel below content full second.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'id' => 'presenters',
		'name' => __('Presenters page content', 'jointswp'),
		'description' => __('Presenters page content.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'pop-cat-blocks',
		'name' => __('Popular categories blocks', 'jointswp'),
		'description' => __('The popular categories blocks.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'featured-products',
		'name' => __('Featured Products', 'jointswp'),
		'description' => __('Featured product slider.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'designers-blurb',
		'name' => __('Designers listing page blurb', 'jointswp'),
		'description' => __('The heading and paragraph on /designers', 'jointswp'),
		'before_widget' => '<div class="designers-blurb large-12 columns">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="header-black">',
		'after_title' => '</h2>',
	));


	register_sidebar(array(
		'id' => 'featured-programmes',
		'name' => __('Featured Programmes For Schedule Page', 'jointswp'),
		'description' => __('Featured Programmes For Schedule Page', 'jointswp'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class="column small-12 text-center">',
		'after_title' => '</h2>',
	));

        
        
        
	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __('Sidebar 2', 'jointswp'),
		'description' => __('The second (secondary) sidebar.', 'jointswp'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!