<?php

include_once('IbizaPostTypePlugin_LifeCycle.php');

class IbizaPostTypePlugin_Plugin extends IbizaPostTypePlugin_LifeCycle {

    /**
     * See: http://plugin.michael-simpson.com/?page_id=31
     * @return array of option meta data.
     */
    public function getOptionMetaData() {
        //  http://plugin.michael-simpson.com/?page_id=31
        return array(
            //'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
            'ATextInput' => array(__('Enter in some text', 'my-awesome-plugin')),
            'AmAwesome' => array(__('I like this awesome plugin', 'my-awesome-plugin'), 'false', 'true'),
            'CanDoSomething' => array(__('Which user role can do something', 'my-awesome-plugin'),
                'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber', 'Anyone')
        );
    }

//    protected function getOptionValueI18nString($optionValue) {
//        $i18nValue = parent::getOptionValueI18nString($optionValue);
//        return $i18nValue;
//    }

    protected function initOptions() {
        $options = $this->getOptionMetaData();
        if (!empty($options)) {
            foreach ($options as $key => $arr) {
                if (is_array($arr) && count($arr > 1)) {
                    $this->addOption($key, $arr[1]);
                }
            }
        }
    }

    public function getPluginDisplayName() {
        return 'Ibiza Post Type Plugin';
    }

    protected function getMainPluginFileName() {
        return 'ibiza-post-type-plugin.php';
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
        //            `id` INTEGER NOT NULL");
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }

    /**
     * Perform actions when upgrading from version X to version Y
     * See: http://plugin.michael-simpson.com/?page_id=35
     * @return void
     */
    public function upgrade() {
        
    }

    
    function my_dashboard_setup_function() {
        //add_meta_box( 'my_dashboard_widget', 'My Widget Name', array( &$this,  'my_dashboard_widget_function' ) , 'dashboard', 'home_product', 'high' );
        add_meta_box( 'ContentScheduler_sectionid1', 
                __( 'Product Details', 
                'contentscheduler' ), 
                array($this, 'my_dashboard_widget_function'), 
                'home_product' , 'side' );   

        add_meta_box( 'ContentScheduler_sectionid2', 
                __( 'Product Details', 
                'contentscheduler' ), 
                array($this, 'my_dashboard_widget_function_howtos'), 
                'howtos' , 'side' );

        add_meta_box( 'ContentScheduler_sectionid3', 
                __( 'Category Details', 
                'contentscheduler' ), 
                array($this, 'my_dashboard_widget_function_categorys'), 
                'featured_categories' , 'side' );
        
    }
    
    
    function my_dashboard_widget_function_howtos(){
        global $ibiza_api;
        // widget content goes here
        ?>
        
        <div id="product_name"><p></p></div>
        <div id="product_image"><p></p></div>
        
        <?php $this->type_ahead_js('howto');?>
        <script>
        
        
        function getHowTo()
        {
            if(jQuery('#title').val().length>0)
            jQuery.getJSON("<?php echo $ibiza_api::api_location ?>/ProductCatalog.Api/api/document/" + jQuery('#title').val()   , function( dataIn ) {
                var items = [];
                //console.log( dataIn.data.name );
                jQuery( '#product_name p' ).text( dataIn.data.name  );
                jQuery( '#product_price p' ).text( dataIn.data.price );
                jQuery( '#product_image p' ).html( '<img style="width:100%" src="' + dataIn.data['image'] + '" />' );
            });            
            
        }
        
        jQuery( document ).ready(function( $ ) {
            
            getHowTo();
            
            jQuery( "#title" ).keyup(function() {
                
                if( jQuery(this).val().length>3 ){
                    
                    getHowTo();
                    

                    
                }
            });
        
        });        
        
        
        </script>
        <?php
    }     
    
    
    
    function my_dashboard_widget_function_categorys() {
        // widget content goes here
        global $ibiza_api;
        ?>
        
        <div id="category_name"><p></p></div>
        <div id="category_image"><p></p></div>
        
        <?php $this->type_ahead_js('cat'); ?>
        
        <script>
        function getCat() {
            jQuery.getJSON("<?php echo $ibiza_api::api_location ?>/ProductCatalog.Api/api/category/categoryId/" + jQuery('#title').val()   , function( dataIn ) {
                console.log(dataIn[0]);
                var items = [];
                    jQuery( '#category_name p' ).text( dataIn[0].title);
                    jQuery( '#category_image p' ).html( '<img style="width:100%" src="' + dataIn[0]._source.image + '" />' );
            });
        }
        
        jQuery( document ).ready(function( $ ) {
            getCat();
            jQuery( "#title" ).keyup(function() {
                if( jQuery(this).val().length>0 ){
                    getCat();
                }
            });
        });
        </script>
        <?php
    }

    function my_dashboard_widget_function_featured_products() {
        // widget content goes here
        global $ibiza_api;
        ?>
        
        <div id="category_name"><p></p></div>
        <div id="category_image"><p></p></div>
        
        <?php $this->type_ahead_js('cat'); ?>
        
        <script>
        function getCat() {
            jQuery.getJSON("<?php echo $ibiza_api::api_location ?>/ProductCatalog.Api/api/category/categoryId/" + jQuery('#title').val()   , function( dataIn ) {
                console.log(dataIn[0]);
                var items = [];
                    jQuery( '#category_name p' ).text( dataIn[0].title);
                    jQuery( '#category_image p' ).html( '<img style="width:100%" src="' + dataIn[0]._source.image + '" />' );
            });
        }
        
        jQuery( document ).ready(function( $ ) {
            getCat();
            jQuery( "#title" ).keyup(function() {
                if( jQuery(this).val().length>0 ){
                    getCat();
                }
            });
        });
        </script>
        <?php
    }
         
    
    
    
    function my_dashboard_widget_function() {
        global $ibiza_api;
        // widget content goes here
        ?>
        
        <div id="product_image"><p></p></div>
        <div id="product_name"><p></p></div>
        <div id="product_price"><p></p></div>
        
        <?php $this->type_ahead_js('product'); ?>
        
        <script>
        
        
        function getProduct()
        {
            
            jQuery.getJSON("<?php echo $ibiza_api::api_location ?>/ProductCatalog.Api/api/document/data.productcode/" + jQuery('#title').val()   , function( dataIn ) {
                var items = [];
                 
                jQuery( '#product_name p' ).text( dataIn[0]['data'].name );
                jQuery( '#product_price p' ).text( '£' + dataIn[0]['data'].price );
                jQuery( '#product_image p' ).html( '<img style="width:100%" src="' + dataIn[0]['data']['images']['0']['url'] + '" />' );
            });            
            
        }
        
        jQuery( document ).ready(function( $ ) {
            
            getProduct();
            
            jQuery( "#title" ).keyup(function() {
                
                if( jQuery(this).val().length>3 ){
                    
                    getProduct();
                    

                    
                }
            });

        });        
        
        </script>
        <?php
    }     
    
    public function addActionsAndFilters() {

        // Add options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        //add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));
        //
        //
        add_action( 'admin_menu', array(&$this,  'my_dashboard_setup_function' ) );

        // Hooking up our function to theme setup
        add_action( 'init',array(&$this, 'create_posttype') );        
        
       
        
        // Example adding a script & style just for the options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        //        if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
        //            wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
        //            wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        }
        // Add Actions & Filters
        // http://plugin.michael-simpson.com/?page_id=37
        // Adding scripts & styles to all pages
        // Examples:
        //        wp_enqueue_script('jquery');
        //        wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
        // Register short codes
        // http://plugin.michael-simpson.com/?page_id=39
        // Register AJAX hooks
        // http://plugin.michael-simpson.com/?page_id=41
            
        ((isset($_REQUEST['post_type'])) ? $post_type = $_REQUEST['post_type'] : null);
        if ($post_type !== 'page' && $post_type !== 'designers' && $post_type !== 'home') {
            add_filter( 'manage_edit-' . $post_type . '_columns', array($this, 'column_header' ));
            add_action( 'manage_' . $post_type . '_posts_custom_column', array($this, 'column_content'), 10, 2);
            add_filter( 'manage_edit-' . $post_type . '_sortable_columns', array($this,'column_sortable'));
            add_filter( 'request', array($this,'column_sorted'));
        }
    }

    function column_header() {
        $columns  = array(
            'cb' => '<input type="checkbox"/>',
            'name' => 'Name',
            'title' => 'Id',
            'schedule' => 'Schedule',
            'schedule_date' => 'Schedule Date',
            'date' => __('Date')
        );
        return $columns;
    }
    
    function column_content($column_name, $post_id) {
        global $post;
        
        switch ($column_name) {
            case 'name':
                global $ibiza_api;
                $itemCode = get_post($post_id);
                
                if ($_REQUEST['post_type'] === 'home_product') {
                    $product = $ibiza_api->get_product($itemCode->post_title);
                    echo ($product[0]->data->name ? $product[0]->data->name : '');
                } else if ($_REQUEST['post_type'] === 'howtos') {
                    $howto = $ibiza_api->get_howto($itemCode->post_title);
                    echo ($howto->data->name ? $howto->data->name : '');
                } elseif ($_REQUEST['post_type'] === 'featured_categories') {
                    $category = $ibiza_api->get_category($itemCode->post_title);
                    echo ($category[0]->title ? $category[0]->title : '');
                }
                break;
            case 'schedule':
                $post = get_post_meta($post_id);
                
                if ($post['_cs-enable-schedule'][0]) {
                    if ($post['_cs-enable-schedule'][0] === 'Enable') {
                        if (date("d-M-Y") > gmdate("d-M-Y", $post['_cs-expire-date'][0])) {
                            echo 'Expired';
                        } else {
                            echo 'Scheduled';
                        }
                    } else {
                        echo 'Not Scheduled';
                    }
                } else {
                    echo 'N/A';
                }
                break;
            case 'schedule_date';
                $post = get_post_meta($post_id);
                if ($post['_cs-start-date'][0] && $post['_cs-expire-date'][0]) {
                    echo gmdate("H:i:s \ d-M-Y", $post['_cs-start-date'][0]) . ' - ' . gmdate("H:i:s \ d-M-Y", $post['_cs-expire-date'][0]);
                } else {
                    echo 'N/A';
                }
                break;
        }
    }
    
    function column_sortable($columns) {
        $columns['schedule_date'] = 'Schedule Date';   
        return $columns;
    }
    
    function column_sorted($vars) {
	if (isset($vars['post_type'])) {
            if (isset($vars['orderby']) && $vars['orderby'] === 'schedule_date') {
                $vars = array_merge(
                    $vars,
                    array(
                        'meta_key' => 'schedule_date',
                        'orderby' => 'meta_value'
                    )
                );
            }
	}
	return $vars;
    }
    
    function create_posttype() {

        register_post_type('home', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                // let's now add all the options for this post type
                array('labels' => array(
                'name' => __('Home Widgets', 'jointswp'), /* This is the Title of the Group */
                'singular_name' => __('Home', 'jointswp'), /* This is the individual type */
                'all_items' => __('All Home Page Content', 'jointswp'), /* the all items menu item */
                'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
                'add_new_item' => __('Add New Custom Type', 'jointswp'), /* Add New Display Title */
                'edit' => __('Edit', 'jointswp'), /* Edit Dialog */
                'edit_item' => __('Edit Post Types', 'jointswp'), /* Edit Display Title */
                'new_item' => __('New Post Type', 'jointswp'), /* New Display Title */
                'view_item' => __('View Post Type', 'jointswp'), /* View Display Title */
                'search_items' => __('Search Post Type', 'jointswp'), /* Search Custom Type Title */
                'not_found' => __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
                'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
            'description' => __('This is the example custom post type', 'jointswp'), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon' => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
            'rewrite' => array('slug' => 'home', 'with_front' => true), /* you can specify its url slug */
            'capability_type' => 'post',
            'hierarchical' => false,
            'taxonomies' => array('category'),
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array('title', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'taxonomies')
                ) /* end of options */
        ); /* end of register post type */
    

        register_post_type('home_product', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                // let's now add all the options for this post type
                array('labels' => array(
                'name' => __('Products', 'jointswp'), /* This is the Title of the Group */
                'singular_name' => __('Product', 'jointswp'), /* This is the individual type */
                'all_items' => __('All Products', 'jointswp'), /* the all items menu item */
                'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
                'add_new_item' => __('Add New Product Content', 'jointswp'), /* Add New Display Title */
                'edit' => __('Edit', 'jointswp'), /* Edit Dialog */
                'edit_item' => __('Edit Product Content', 'jointswp'), /* Edit Display Title */
                'new_item' => __('New Product', 'jointswp'), /* New Display Title */
                'view_item' => __('View Products', 'jointswp'), /* View Display Title */
                'search_items' => __('Search Products', 'jointswp'), /* Search Custom Type Title */
                'not_found' => __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
                'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
            'description'           => __('This is the example custom post type', 'jointswp'), /* Custom Type Description */
            'public'                => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'               => true,
            'query_var'             => true,
            'menu_position'         => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon'             => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
            'rewrite'               => array('slug' => 'site', 'with_front' => false), /* you can specify its url slug */
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'taxonomies'            => array('category'),
            /* the next one is important, it tells what's enabled in the post editor */
            'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'taxonomies')
                ) /* end of options */
        ); /* end of register post type */
        
        
    

        register_post_type('howtos', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                // let's now add all the options for this post type
                array('labels' => array(
                'name' => __('How to Guides', 'jointswp'), /* This is the Title of the Group */
                'singular_name' => __('How to Guides', 'jointswp'), /* This is the individual type */
                'all_items' => __('All How to Guides', 'jointswp'), /* the all items menu item */
                'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
                'add_new_item' => __('Add New How to Guides', 'jointswp'), /* Add New Display Title */
                'edit' => __('Edit', 'jointswp'), /* Edit Dialog */
                'edit_item' => __('Edit Post Types', 'jointswp'), /* Edit Display Title */
                'new_item' => __('New Post Type', 'jointswp'), /* New Display Title */
                'view_item' => __('View Post Type', 'jointswp'), /* View Display Title */
                'search_items' => __('Search Post Type', 'jointswp'), /* Search Custom Type Title */
                'not_found' => __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
                'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
            'description'           => __('This is the example custom post type', 'jointswp'), /* Custom Type Description */
            'public'                => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'               => true,
            'query_var'             => true,
            'menu_position'         => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon'             => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
            'rewrite'               => array('slug' => 'site', 'with_front' => false), /* you can specify its url slug */
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'taxonomies'            => array('category'),
            /* the next one is important, it tells what's enabled in the post editor */
            'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'taxonomies')
                ) /* end of options */
        ); /* end of register post type */
        
       
        
        
    

        register_post_type('featured_categories', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                // let's now add all the options for this post type
                array('labels' => array(
                'name' => __('Featured Categories', 'jointswp'), /* This is the Title of the Group */
                'singular_name' => __('Featured Categories', 'jointswp'), /* This is the individual type */
                'all_items' => __('All Featured Categories', 'jointswp'), /* the all items menu item */
                'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
                'add_new_item' => __('Add New How to Guides', 'jointswp'), /* Add New Display Title */
                'edit' => __('Edit', 'jointswp'), /* Edit Dialog */
                'edit_item' => __('Edit Featured Categories', 'jointswp'), /* Edit Display Title */
                'new_item' => __('New Featured Categories', 'jointswp'), /* New Display Title */
                'view_item' => __('View Featured Categories', 'jointswp'), /* View Display Title */
                'search_items' => __('Search Featured Categories', 'jointswp'), /* Search Custom Type Title */
                'not_found' => __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
                'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
            'description'           => __('This is the example custom post type', 'jointswp'), /* Custom Type Description */
            'public'                => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'               => true,
            'query_var'             => true,
            'menu_position'         => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon'             => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
            'rewrite'               => array('slug' => 'site', 'with_front' => false), /* you can specify its url slug */
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'taxonomies'            => array('category'),
            /* the next one is important, it tells what's enabled in the post editor */
            'supports'              => array('title', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'taxonomies')
                ) /* end of options */
        ); /* end of register post type */




        
        
        register_post_type('featured_products', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                // let's now add all the options for this post type
                array('labels' => array(
                'name' => __('Featured Products', 'jointswp'), /* This is the Title of the Group */
                'singular_name' => __('Featured Products', 'jointswp'), /* This is the individual type */
                'all_items' => __('All Featured Products', 'jointswp'), /* the all items menu item */
                'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
                'add_new_item' => __('Add New How to Guides', 'jointswp'), /* Add New Display Title */
                'edit' => __('Edit', 'jointswp'), /* Edit Dialog */
                'edit_item' => __('Edit Featured Products', 'jointswp'), /* Edit Display Title */
                'new_item' => __('New Featured Products', 'jointswp'), /* New Display Title */
                'view_item' => __('View Featured Products', 'jointswp'), /* View Display Title */
                'search_items' => __('Search Featured Products', 'jointswp'), /* Search Custom Type Title */
                'not_found' => __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
                'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
            'description'           => __('This is the example custom post type', 'jointswp'), /* Custom Type Description */
            'public'                => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'               => true,
            'query_var'             => true,
            'menu_position'         => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon'             => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
            'rewrite'               => array('slug' => 'site', 'with_front' => false), /* you can specify its url slug */
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'taxonomies'            => array('category'),
            /* the next one is important, it tells what's enabled in the post editor */
            'supports'              => array('title', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'taxonomies')
                ) /* end of options */
        ); /* end of register post type */    






        register_post_type('howtos', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                // let's now add all the options for this post type
                array('labels' => array(
                'name' => __('How to Guides Widget', 'jointswp'), /* This is the Title of the Group */
                'singular_name' => __('How to Guides', 'jointswp'), /* This is the individual type */
                'all_items' => __('All How to Guides', 'jointswp'), /* the all items menu item */
                'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
                'add_new_item' => __('Add New How to Guides', 'jointswp'), /* Add New Display Title */
                'edit' => __('Edit', 'jointswp'), /* Edit Dialog */
                'edit_item' => __('Edit Post Types', 'jointswp'), /* Edit Display Title */
                'new_item' => __('New Post Type', 'jointswp'), /* New Display Title */
                'view_item' => __('View Post Type', 'jointswp'), /* View Display Title */
                'search_items' => __('Search Post Type', 'jointswp'), /* Search Custom Type Title */
                'not_found' => __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
                'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
            'description'           => __('This is the example custom post type', 'jointswp'), /* Custom Type Description */
            'public'                => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'               => true,
            'query_var'             => true,
            'menu_position'         => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon'             => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
            'rewrite'               => array('slug' => 'site', 'with_front' => false), /* you can specify its url slug */
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'taxonomies'            => array('category'),
            /* the next one is important, it tells what's enabled in the post editor */
            'supports'              => array('title', 'editor',  'thumbnail', 'custom-fields', 'revisions', 'taxonomies')
                ) /* end of options */
        ); /* end of register post type */
        
       
        
        
    

        register_post_type('designers', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                // let's now add all the options for this post type
                array('labels' => array(
                'name' => __('Designers', 'jointswp'), /* This is the Title of the Group */
                'singular_name' => __('Designers', 'jointswp'), /* This is the individual type */
                'all_items' => __('All Designers', 'jointswp'), /* the all items menu item */
                'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
                'add_new_item' => __('Add New Designers', 'jointswp'), /* Add New Display Title */
                'edit' => __('Edit', 'jointswp'), /* Edit Dialog */
                'edit_item' => __('Edit Presenter', 'jointswp'), /* Edit Display Title */
                'new_item' => __('New Presenter', 'jointswp'), /* New Display Title */
                'view_item' => __('View Designers', 'jointswp'), /* View Display Title */
                'search_items' => __('Search Designers', 'jointswp'), /* Search Custom Type Title */
                'not_found' => __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
                'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
            'description'           => __('This is the example custom post type', 'jointswp'), /* Custom Type Description */
            'public'                => true,
            'has_archive'           => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'               => true,
            'query_var'             => true,
            'menu_position'         => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon'             => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
            'rewrite'               => array('slug' => 'designers', 'with_front' => false), /* you can specify its url slug */
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'taxonomies'            => array('category'),
            /* the next one is important, it tells what's enabled in the post editor */
            'supports'              => array('title', 'excerpt', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'taxonomies')
                ) /* end of options */
        ); /* end of register post type */
        
        
//        add_meta_box( 'ContentScheduler_sectionid', 
//                __( 'Content Scheduler', 
//                'contentscheduler' ), 
//                array($this, 'ContentScheduler_custom_box_fn'), 
//                'home_product' );
//        
//    }

}



        // b. Print / draw the box callback
        function ContentScheduler_custom_box_fn()
        {
            // need $post in global scope so we can get id?
            global $post;
            // Use nonce for verification
            wp_nonce_field( 'content_scheduler_values', 'ContentScheduler_noncename' );
            // Get the current value, if there is one
            $the_data = get_post_meta( $post->ID, '_cs-enable-schedule', true );
            $the_data = ( empty( $the_data ) ? 'Disable' : $the_data );
            // Checkbox for scheduling this Post / Page, or ignoring
            $items = array( "Disable", "Enable");
            foreach( $items as $item)
            {
                $checked = ( $the_data == $item ) ? ' checked="checked" ' : '';
                echo "<label><input ".$checked." value='$item' name='_cs-enable-schedule' id='cs-enable-schedule' type='radio' /> $item</label>  ";
            } // end foreach
            echo "<br />\n<br />\n";
            // Field for datetime of expiration
            // TODO datetime conversion
            // should be unix timestamp at this point, in UTC
            // for display, we need to convert this to local time and then format
            
            // datestring is the original human-readable form
            // $datestring = ( get_post_meta( $post->ID, '_cs-expire-date', true) );
            // timestamp should just be a unix timestamp
            $timestamp = ( get_post_meta( $post->ID, '_cs-expire-date', true) );
            if( !empty( $timestamp ) ) {
                // we need to convert that into human readable so we can put it into our field
                $datestring = DateUtilities::getReadableDateFromTimestamp( $timestamp );
            } else {
                $datestring = '';
            }
            // Should we check for format of the date string? (not doing that presently)
            echo '<label for="cs-expire-date">' . __("Expiration date and hour", 'contentscheduler' ) . '</label><br />';
            echo '<input type="text" id="cs-expire-date" name="_cs-expire-date" value="'.$datestring.'" size="25" />';
            echo '<br />Input date and time in any valid Date and Time format.';
        }

        // c. Save data from the box callback
        function ContentScheduler_save_postdata_fn( $post_id )
        {
            // verify this came from our screen and with proper authorization,
            // because save_post can be triggered at other times
            if( !empty( $_POST['ContentScheduler_noncename'] ) )
            {
                if ( !wp_verify_nonce( $_POST['ContentScheduler_noncename'], 'content_scheduler_values' ))
                {
                    return $post_id;
                }
            }
            else
            {
                return $post_id;
            }
            // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
            // to do anything
            if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            {
                return $post_id;
            }
            // Check permissions, whether we're editing a Page or a Post
            if ( 'page' == $_POST['post_type'] )
            {
                if ( !current_user_can( 'edit_page', $post_id ) )
                return $post_id;
            }
            else
            {
                if ( !current_user_can( 'edit_post', $post_id ) )
                return $post_id;
            }
            
            // OK, we're authenticated: we need to find and save the data
            // First, let's make sure we'll do date operations in the right timezone for this blog
            // $this->setup_timezone();
            // Checkbox for "enable scheduling"
            $enabled = ( empty( $_POST['_cs-enable-schedule'] ) ? 'Disable' : $_POST['_cs-enable-schedule'] );
            // Value should be either 'Enable' or 'Disable'; otherwise something is screwy
            if( $enabled != 'Enable' AND $enabled != 'Disable' )
            {
                // $enabled is something we don't expect
                // let's make it empty
                $enabled = 'Disable';
                // Now we're done with this function?
                return false;
            }
            // Textbox for "expiration date"
            $dateString = $_POST['_cs-expire-date'];            
            $offsetHours = 0;
            // if it is empty then set it to tomorrow
            // we just want to pass an offset into getTimestampFromReadableDate since that is where our DateTime is made
            if( empty( $dateString ) ) {
                // set it to now + 24 hours
                $offsetHours = 24;
            }
            // TODO handle datemath if field reads "default"
            if( trim( strtolower( $dateString ) ) == 'default' )
            {
                // get the default value from the database
                $default_expiration_array = $this->options['exp-default'];
                if( !empty( $default_expiration_array ) )
                {
                    $default_hours = $default_expiration_array['def-hours'];
                    $default_days = $default_expiration_array['def-days'];
                    $default_weeks = $default_expiration_array['def-weeks'];
                }
                else
                {
                    $default_hours = '0';
                    $default_days = '0';
                    $default_weeks = '0';
                }
            
                // we need to move weeks into days and days into hours
                $default_hours += ( $default_weeks * 7 + $default_days ) * 24 * 60 * 60;
                
                // if it is valid, get the published or scheduled datetime, add the default to it, and set it as the $date
                if ( !empty( $_POST['save'] ) )
                {
                    if( $_POST['save'] == 'Update' )
                    {
                        $publish_date = $_POST['aa'] . '-' . $_POST['mm'] . '-' . $_POST['jj'] . ' ' . $_POST['hh'] . ':' . $_POST['mn'] . ':' . $_POST['ss'];
                    }
                    else
                    {
                        $publish_date = $_POST['post_date'];
                    }
                    // convert publish_date string into unix timestamp
                    $publish_date = DateUtilities::getTimestampFromReadableDate( $publish_date );
                }
                else
                {
                    $publish_date = time(); // current unix timestamp
                    // no conversion from string needed
                }
                
                // time to add our default
                // we need $publish_date to be in unix timestamp format, like time()
                $expiration_date = $publish_date + $default_hours * 60 * 60;
                $_POST['_cs-expire-date'] = $expiration_date;
            }
            else
            {
                $expiration_date = DateUtilities::getTimestampFromReadableDate( $dateString, $offsetHours );
            }
            // We probably need to store the date differently,
            // and handle timezone situation
            update_post_meta( $post_id, '_cs-enable-schedule', $enabled );
            update_post_meta( $post_id, '_cs-expire-date', $expiration_date );
            return true;
        }
        
        
        public function type_ahead_js($type)
        {
            
            switch($type)
            {
                
                case 'product':
                    $url    = 'https://search-ibiza-zionowpdl7rywcwhx7jyiyni7e.eu-west-1.es.amazonaws.com/product/_search?from=0&size=53&q=name:*%QUERY*';
                    $desc   = 'Search the product cat to feature an item on the front end, you can schedule it, so the product will show at a set time.';
                    $title  = 'Ibiza Product Search';
                    $template   = '\'<p style="background:white;padding:20px;clear:left"><img style="float:left;margin-right:10px;" width="75px" src="\'+ data._source.images[0].url +\'"/><strong>\' + data._source.name + \'</strong> - \' + data._source.productcode + \'</p>\'';
                    $callback = 'jQuery(\'#title\').val( datum._source.productcode );getProduct();';
                    break;
                case 'howto':
                    $url    = 'https://search-ibiza-zionowpdl7rywcwhx7jyiyni7e.eu-west-1.es.amazonaws.com/howto/_search?from=0&size=5&q=name:*%QUERY*';
                    $desc   = 'Search the how to guides cat to feature an item on the front end, you can schedule it, so the product will show at a set time.';
                    $template   = '\'<p style="background:white;padding:20px;clear:left"><img style="float:left;margin-right:10px;" width="75px" src="\'+ data._source.image +\'"/><strong>\' + data._source.name + \'</strong> - \' + data._id + \'</p>\'';
                    $title  = 'Ibiza How to Search';
                    $callback = 'jQuery(\'#title\').val( datum._id );getHowTo();';
                    break;
                case 'cat':
                    $url    = '/?cat_search=*%QUERY*';
                    $desc   = 'Search the categories to feature an item on the front end, you can schedule it, so the product will show at a set time.';
                    $title  = 'Ibiza Category Search';
                    $template   = '\'<p style="background:white;padding:20px;clear:left"><img style="float:left;margin-right:10px;" width="75px" src="\'+ data._source.image +\'"/><strong>\' + data._source.name + \'</strong></p>\'';
                    $callback = 'jQuery(\'#title\').val( datum._source.id );getCat();';                    
                    break;
                    
            }
            
            
            ?>
        
        <div class="container">
            <h1><?php echo $title;?></h1>
            <p><?php echo $desc; ?></p>
                <form action="#">
                    <div class="form-group">
                            <label for="location-1">Search</label>
                            <input id="location-1" type="text" class="form-control typeahead" placeholder="Cannes" data-provide="typeahead" autocomplete="off">
                    </div>
                </form>
<!--                <h3>Ressources</h3>
                <ul>
                  <li><a href="">GeoNames Search Webservice</a> (API Documentation)</li>
                  <li><a href="http://getbootstrap.com">Twitter Bootstrap</a></li>
                  <li><a href="http://twitter.github.io/typeahead.js/">Twitter typeahead.js</a></li>
                  <li><a href="http://twitter.github.io/hogan.js/">Twitter Hogan.js JavaScript templating</a></li>
                </ul>-->
        </div>
        
        
        <?php // wp_enqueue_script('typeahead',  '/wp-content/themes/Ibiza-Theme/vendor/typeahead.js/dist/typeahead.bundle.js' ); ?>
        <?php // wp_enqueue_script('script2',  '/wp-content/themes/Ibiza-Theme/vendor/hogan.js/web/builds/3.0.2/hogan-3.0.2.common.js' ); ?>
        
        <style>
         .tt-menu{  
            left: -200px!important;
            position: absolute;
            width: 350px;
            border: 1px solid #ccc;
            background: white;
         }
        </style>
        
        <script src="/wp-content/themes/Ibiza-Theme/vendor/typeahead.js/dist/typeahead.bundle.js"></script>
        <script src="/wp-content/themes/Ibiza-Theme/vendor/hogan.js/web/builds/3.0.2/hogan-3.0.2.common.js"></script>        
        
        
        
        <script>
            var items = new Bloodhound({  
               datumTokenizer: function(hits) {

                   return Bloodhound.tokenizers.whitespace(hits.hits);
               },

               queryTokenizer: Bloodhound.tokenizers.whitespace,
               remote: {
                     wildcard: '%QUERY',
                     url: "<?php echo $url; ?>",
                     filter: function(response) {   

                       return response.hits.hits;
                     }
               }
             });

             // initialize the bloodhound suggestion engine
             items.initialize();

             // instantiate the typeahead UI
             jQuery('.typeahead').typeahead(
                 { 
                     hint        : true,
                     highlight   : true,
                     minLength   : 1
                 }, 
                 {
                 name: 'hits',
                 displayKey: function(hits) {

                     return hits._source.name;        

                 },
                 source: items.ttAdapter(),
                 templates: {
                     suggestion: function (data) {
                         
                         return <?php echo $template; ?>;
                     }
                 }                
             });     


             jQuery('.typeahead').bind('typeahead:selected', function(obj, datum, name) {      
                 
                 <?php echo $callback; ?>
                         
                jQuery("#title").stop().css("background-color", "#FFFF9C")
                    .animate({ backgroundColor: "#FFFFFF"}, 1500);                         
                         
             });            
                    
        </script>
        
            <?php
            
            
        }
        

}