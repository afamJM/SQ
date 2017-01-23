<?php
include_once('IbizaSearchPlugin_LifeCycle.php');

class IbizaSearchPlugin_Plugin extends IbizaSearchPlugin_LifeCycle {

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
        return 'Ibiza Search Plugin';
    }

    protected function getMainPluginFileName() {
        return 'ibiza-search-plugin.php';
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

    public function addActionsAndFilters() {

        // Add options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        //add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));
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
        
        add_action('widgets_init', 'wpb_load_widget');
    }

}

// Creating the widget 
class IbizaSearchPlugin_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
// Base ID of your widget
                'wpb_widget',
// Widget name will appear in UI
                __('WPBeginner Widget', 'wpb_widget_domain'),
// Widget description
                array('description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain'),)
        );
    }

// Creating widget front-end
// This is where the action happens
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
// before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
        ?>
        <div class="search-container">
            <div class="large-12  column">
                    <form method="get" action="/search/p" class="small-11 large-4 column  small-centered">
                        <div>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/search-icon.png" title="" alt="" class="" />
                            <input type="search" title="Search for:" name="q" value="" placeholder="Search" class="search-field typeahead " />
                            <input type="submit" class="hide" />
                        </div>
                    </form>
                
                    <div id="search-cancel" class="small-1 large-4 column">
                        &nbsp;<span class="show-for-large">CANCEL</span>
                    </div>
                </div>                
                
            </div>

        </div>



        <script src="/wp-content/themes/Ibiza-Theme/vendor/typeahead.js/dist/typeahead.bundle.js"></script>
        <script src="/wp-content/themes/Ibiza-Theme/vendor/hogan.js/web/builds/3.0.2/hogan-3.0.2.common.js"></script>        
        
        <?php
        
        /*
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
            $template_categories   = '\'<p style="background:white;padding:20px;clear:left"><img style="float:left;margin-right:10px;" width="75px" src="\'+ data._source.image +\'"/><strong>\' + data._source.name + \'</strong></p>\'';
            $callback = 'jQuery(\'#title\').val( datum._source.id );getCat();';                    
            break;        
        
        */
        
//        $url_products           =  '/ProductCatalog.Api/api/elastic/product/_search?from=0&size=53&q=name:*%QUERY*';
//        $url_howto              =  '/ProductCatalog.Api/api/elastic/howto/_search?from=0&size=5&q=name:*%QUERY*';
        
        
        
        $url_products           =  '/ProductCatalog.Api/api/elastic/product/_search?from=0&size=5&source=%QUERY';
        $url_howto              =  '/ProductCatalog.Api/api/elastic/howto/_search?from=0&size=5&source=%QUERY';        
        
        
        $url_categories         = '/?cat_search=*%QUERY*';
        
        $template_products      = '\'<p style="background:white;padding:5px;clear:left"><strong>\' + data._source.name + \'</strong> - \' + data._source.productcode + \'</p>\'';
        $template_categories    = '\'<p style="background:white;padding:5px;clear:left"><strong>\' + data._source.name + \'</strong></p>\'';
        $template_howto         = '\'<p style="background:white;padding:5px;clear:left"><strong>\' + data._source.name + \'</strong> - \' + data._id + \'</p>\'';
        
        $callabck_product       = 'window.location.href = \'/p/\' + datum._source.productcode;';
        $callabck_howto         = 'window.location.href = \'/h/\' + datum._id;';
        $callabck_category      = 'window.location.href = \'http://\' + datum._url;';
        
        ?>
        
        <script>
            
            
            
            
            jQuery( document ).ready(function() {
                
                jQuery('#search-cancel').click(function(){
                    jQuery('.search-link').first().click();
                    jQuery('#tri' ,".header-container").hide().remove();
                });
                
            });            
            
            
            var cats_engine = new Bloodhound({  
               datumTokenizer: function(hits) {

                   return Bloodhound.tokenizers.whitespace(hits.hits);
               },

               queryTokenizer: Bloodhound.tokenizers.whitespace,
               remote: {
                    wildcard: '%QUERY',
                    url: "<?php echo $url_categories; ?>",                
                    filter: function(response) {   

                      return response.hits.hits;
                    }
               }
             });

            var product_engine = new Bloodhound({  
               datumTokenizer: function(hits) {

                   return Bloodhound.tokenizers.whitespace(hits.hits);
               },

               queryTokenizer: Bloodhound.tokenizers.whitespace,
               remote: {
                     wildcard: '%QUERY',
                     url: api_location + "<?php echo $url_products; ?>",
                    replace: function(url, query) {
                        var jsonStr = '{"query":{"query_string":{"query":"*' + query + '*","lenient":true,"fields":["name"],"default_operator":"AND"}}}';
                        return url.replace('%QUERY', jsonStr ).replace('%CID', jQuery(this).attr('id'));
                        
                    },                       
                     filter: function(response) {   

                       return response.hits.hits;
                     }
               }
             });

            var howto_engine = new Bloodhound({  
               datumTokenizer: function(hits) {

                   return Bloodhound.tokenizers.whitespace(hits.hits);
               },

               queryTokenizer: Bloodhound.tokenizers.whitespace,
               remote: {
                     wildcard: '%QUERY',
                     url: api_location+ "<?php echo $url_howto; ?>",
                    replace: function(url, query) {
                        var jsonStr = '{"query":{"query_string":{"query":"*' + query + '*","lenient":true,"fields":["name"],"default_operator":"AND"}}}';
                        return url.replace('%QUERY', jsonStr ).replace('%CID', jQuery(this).attr('id'));
                        
                    },                        
                     filter: function(response) {   

                       return response.hits.hits;
                     }
               }
             });
             
             
             
             
             // initialize the bloodhound suggestion engine
             cats_engine.initialize();
             product_engine.initialize();
             howto_engine.initialize();
             
             // instantiate the typeahead UI
             jQuery('.typeahead').typeahead(
                 { 
                     hint        : true,
                     highlight   : true,
                     minLength   : 4
                 }, 
                 {
                 name: 'products',
                 displayKey: function(hits) {

                     return ;hits._source.name;        

                 },
                 source: product_engine.ttAdapter(),
                 limit : 4,
                 templates: {
                     header : '<h5>Products</h5>',
                     footer : '<p><a href="/search/p?q=' + jQuery('.search-field').first().val() +  '&p=1">View all</a></p>',
                     suggestion: function (data) {
                         
                         return <?php echo $template_products; ?>;
                     }
                 }                
             }, 
                 {
                 name: 'categories',
                 displayKey: function(hits) {

                     return ;//hits._source.name;        

                 },
                 source: cats_engine.ttAdapter(),
                 limit : 4,
                 templates: {
                     header : '<h5>Categories</h5>',
                     
                     suggestion: function (data) {
                         
                         return <?php echo $template_categories; ?>;
                     }
                 }                
             }, 
                 {
                 name: 'howto',
                 displayKey: function(hits) {

                     return;// hits._source.name;        

                 },
                 source: howto_engine.ttAdapter(),
                 limit : 4,
                 templates: {
                     header : '<h5>How To Guides</h5>',
                     footer : '<p><a href="/search/?q=' + jQuery('.search-field').first().val() +  '&p=0">View all</a></p>',
                     suggestion: function (data) {
                         
                         return <?php echo $template_howto; ?>;
                     }
                 }                
             }
             

            );     

            jQuery('.typeahead').bind('typeahead:selected', function(obj, datum, name) {      

               
                switch( datum._type )
                {
                   
                    case 'product':
                        
                        <?php echo $callabck_product; ?>
                        break;
                    case 'howto':
                        <?php echo $callabck_howto; ?>
                        break;
                    case 'category':
                        <?php echo $callabck_category; ?>
                        break;
                     
                }
                 
                 <?php // echo $callback; ?>
                         
                     
                         
             });            
                    
        </script>     







        <?php
        echo $args['after_widget'];
    }

// Widget Backend 
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'wpb_widget_domain');
        }
// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        
        
        
        
        
        
   
        
        
        
        
        
        
        <?php
    }

// Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function wpb_load_widget() {
    register_widget('IbizaSearchPlugin_Widget');
}



