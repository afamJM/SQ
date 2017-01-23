<?php
include_once('IbizaBannerPlugin_LifeCycle.php');

class IbizaBannerPlugin_Plugin extends IbizaBannerPlugin_LifeCycle {

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
        return 'Ibiza Banner Plugin';
    }

    protected function getMainPluginFileName() {

        return 'ibiza-banner-plugin.php';
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

        //  if( is_admin() ){
        add_action('init', array($this, 'register_post_type_banner'));

        //  }

        add_action('widgets_init', array($this, 'wp_banner_load_widget'));
    }

    function register_post_type_banner() {

        // creating (registering) the custom type 
        register_post_type('banner', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                // let's now add all the options for this post type
                array('labels' => array(
                'name' => __('Banner', 'jointswp'), /* This is the Title of the Group */
                'singular_name' => __('Banner', 'jointswp'), /* This is the individual type */
                'all_items' => __('All Banner Posts', 'jointswp'), /* the all items menu item */
                'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
                'add_new_item' => __('Add New Banner Content', 'jointswp'), /* Add New Display Title */
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
            'menu_position' => 0, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon' => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
            'rewrite' => array('slug' => 'site', 'with_front' => false), /* you can specify its url slug */
            'capability_type' => 'post',
            'hierarchical' => false,
            'taxonomies' => array('category', 'Test'),
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'taxonomies')
                ) /* end of options */
        ); /* end of register post type */
    }

    // Class wpb_widget ends here
    // Register and load the widget
    function wp_banner_load_widget() {
        register_widget('IbizaBanner_Widget');
    }

}

// Creating the widget 
class IbizaBanner_Widget extends WP_Widget {

    function __construct() {

        parent::__construct(
                // Base ID of your widget
                'wpb_widget_banner_widget',
                // Widget name will appear in UI
                __('Banner Widget', 'wpb_banner_widget'),
                // Widget description
                array('description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain'),)
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {


        $the_cache = 'sq_banner';
        $cb = function($the_cache) {
            $query = new WP_Query(array(
                'post_type' => 'banner',
                'post_status' => 'publish'
            ));

            if ($query->have_posts())
                while ($query->have_posts()) {
$query->the_post();
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
                    $mobile_image = '';
                    if (class_exists('Dynamic_Featured_Image')) {
                        global $dynamic_featured_image;
                        $featured_images = $dynamic_featured_image->get_featured_images(get_the_ID());
                        $mobile_image = $featured_images[0]['full'];
                        //print_r($image);
                        //DIE;
                    }
                    $data[] = array('image' => $image[0], 'mobile_image' => $mobile_image , 'url'=>  get_the_excerpt(  ) );
                }

            unset($query);

            create_cache($the_cache, $data);
            return $data;
        };
        $images = get_cache($the_cache, $cb);

        remove_cache($the_cache, $cb);

        wp_enqueue_script('banner', plugins_url('/js/banner.js', __FILE__));
        //wp_enqueue_style('banner', plugins_url('/css/banner.css', __FILE__));        


        $title = apply_filters('widget_title', $instance['title']);
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        ?>

        <div class="swiper-container-banner">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
        <?php
        foreach ($images as $image):

            //$css_class  = get_post_meta( $post->ID,  'css-class'  );
            //$inline_css = get_post_meta( $post->ID,  'inline-css'  );
            ?>
                <div onclick="window.location.href='<?php echo $image['url'] ; ?>'" class="swiper-slide small-12 columns" style="background-image: url('<?php echo $image['image']; ?>');background-size:cover; background-position: center center;">
<!--                        <img class="show-for-medium" src="<?php echo $image['image']; ?>" title="Banner image" alt="Banner image" />-->
                        <!--<img class="show-for-small hide-for-large" src="<?php/* echo $image['mobile_image']; */?>" title="Banner image" alt="Banner image" />-->
                    </div>
                    <?php
                endforeach;
                ?>

            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

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
