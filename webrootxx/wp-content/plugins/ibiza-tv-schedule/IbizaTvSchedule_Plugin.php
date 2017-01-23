<?php


include_once('IbizaTvSchedule_LifeCycle.php');

class IbizaTvSchedule_Plugin extends IbizaTvSchedule_LifeCycle {

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
        return 'Ibiza TV Schedule';
    }

    protected function getMainPluginFileName() {
        return 'ibiza-tv-schedule.php';
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

        add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));
        add_action('widgets_init', array( $this , 'wp_tv_schedule_load_widget' ) );
    }

    
    // Class wpb_widget ends here
    // Register and load the widget
    function wp_tv_schedule_load_widget() {
        register_widget('IbizaTvSchedule_Widget');
    }

    
    

}



// Creating the widget 
class IbizaTvSchedule_Widget extends WP_Widget {
    
    function __construct() {
        
        parent::__construct(
            // Base ID of your widget
            'wpb_widget_tv_schedule_widget',
            // Widget name will appear in UI
            __('Tv Schedule Widget', 'wpb_tv_schedule_widget'),
            // Widget description
            array('description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain'),)
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {
        global $ibiza_api;
        
        $data = json_decode( file_get_contents($ibiza_api::api_location . '/ProductCatalog.api/api/legacy/tvschedule/89/fulls' ) );
        
        if( !isset( $data[0] ) )
        {
            return array();
        }
        
        
        $title = apply_filters('widget_title', $instance['title']);
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        ?>
        <ol>

            <?php foreach($data[0]->schedule as $key=>$d): ?>
            
            <?php if( $key  ==3 ){
                break;
            } ?>
            
            <li><h5><?php echo( $d->title );  ?></h5><p><?php echo $d->synopsis?></p></li>
            
            <?php endforeach; ?>
        </ol>

        <p><a href="/tv-schedule/">View more</a></p>

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

