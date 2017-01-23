<?php


include_once('IbizaTvProducts_LifeCycle.php');

class IbizaTvProducts_Plugin extends IbizaTvProducts_LifeCycle {

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
        return 'Ibiza TV Products';
    }

    protected function getMainPluginFileName() {
        return 'ibiza-tv-products.php';
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
        
 



        
        add_action('widgets_init',  array( $this,  'wpb_load_widget' ) );
        
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

    }


    function wpb_load_widget() {
        
        register_widget('IbizaTvProductsPlugin_Widget');
    }

    
}


// Creating the widget 
class IbizaTvProductsPlugin_Widget extends WP_Widget {

    function __construct() {
        
        parent::__construct(
            // Base ID of your widget
            'wpb_tv_product_widget',
            // Widget name will appear in UI
            __('Ibiza TV Product Widget', 'wpb_widget_tv_product'),
            // Widget description
            array('description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_tv_product'),)
        );
        
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {
        global $ibiza_api;
        
        if ( is_front_page() ) {
         //   wp_enqueue_script('my-script', plugins_url('/js/tv-products.js', __FILE__));
         //  wp_enqueue_style('my-style', plugins_url('/css/tv-products.css', __FILE__));
            
        }         
        
        $title = apply_filters('widget_title', $instance['title']);
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        ?>

        <div class="tv-products">
             <!--built using Javascript--> 
            <?php for ($i = 0; $i < 4; $i++) { 
            if ($i === 0) { ?>
                <div id="triangle" class=""></div>
                <div id="triangle-outter" class=""></div>
            <?php } ?>
            <div id="product_<?php echo $i; ?>" class="tv-product">
                <div class="row">
                    <div class="column large-3 small-3">
                        <img id="productImg_<?php echo $i; ?>" src=""/>
                    </div>
                    <div  class="column large-9 small-9">
                        <p id="productName_<?php echo $i; ?>"><a href=""></a></p>
                        <p id="productPrice_<?php echo $i; ?>"></p>
                        <button style="background: #00B109" data-toggle="example-dropdown2" type="button" class="button" class="add-basket" aria-controls="example-dropdown2" data-is-focus="false" data-yeti-box="example-dropdown2" aria-haspopup="true" aria-expanded="false">Add to basket</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
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
