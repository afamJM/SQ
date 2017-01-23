<?php
include_once('IbizaCategoriesPullPlugin_LifeCycle.php');

define('TOP_NODE', 'categories');
define('PARENT_MENU_ID', '32');
define('HOW_TO_PARENT_MENU_ID', '23935');

class IbizaCategoriesPullPlugin_Plugin extends IbizaCategoriesPullPlugin_LifeCycle {

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
        return 'Ibiza Categories Pull Plugin';
    }

    protected function getMainPluginFileName() {
        return 'ibiza-categories-pull-plugin.php';
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

        
        if(is_admin() ){
        
            if ( isset( $_GET['refresh_ibiza_menu'] ) && $_GET['refresh_ibiza_menu'] == 1) {

                add_action('init', array(&$this, 'do_menu'));
                header('Location: /wp-admin/nav-menus.php');
            }

            if ($_GET['promoted_menu'] == 1) {

                add_action('init', array(&$this, 'promoted_menu'));
            }

            if ($_GET['promote_menu'] == 1 || $_GET['promote_menu'] == 2) {

                add_action('init', array(&$this, 'promote_menu'));
            }

            global $pagenow;

            if ($pagenow == 'nav-menus.php') {

                wp_enqueue_script('menurefresh-js', get_template_directory_uri() . '/assets/js/admin-scripts.js', array('jquery'), '', true);
                wp_enqueue_script('jquery.popupoverlay-js', get_template_directory_uri() . '/vendor/jquery-popup-overlay/jquery.popupoverlay.js', array('jquery'), '', true);
            }
        }
    }

    /**
     * 
     * @return type
     */
    function get_json() {
        global $ibiza_api;

        $jsonPath = $ibiza_api::api . '/ProductCatalog.Api/categorytree';  //get_template_directory() . '/assets/json/menu.json';




        $cats = json_decode(getSslPage($jsonPath));



        return $cats[0]->{TOP_NODE};
    }

    /**
     * 
     * @param type $menu_id
     * @param type $new_menu_id
     * @param type $title
     * @param type $menu_position
     * @param type $parent_menu_id
     * @param type $menu_type
     * @return type
     */
    function update_menu($menu_id, $new_menu_id, $title, $menu_position = 0, $parent_menu_id = PARENT_MENU_ID, $menu_type = 'custom', $page_link = 'product-list', $db_id = 0) {

        static $i = 0;

        if ($page_link != 'product-list') {
            $i = 1;
        }

        if ($i == 1) {
            $page_link = 'how-to-guides';
        }

        return wp_update_nav_menu_item($menu_id, $db_id, array(
            'menu-item-parent-id' => $parent_menu_id,
            'menu-item-db-id' => $db_id,
            'menu-item-position' => $menu_position,
            'menu-item-object' => 'page',
            'menu-item-type' => $menu_type,
            'menu-item-status' => 'publish',
            'menu-item-url' => '/' . $page_link . '/' . sanitize_title_with_dashes($title) . '/' . $new_menu_id,
            'menu-item-title' => $title,
        ));
    }

    /**
     * 
     * @param type $data
     * @param type $menu_id
     * @param type $parent_id
     */
    function add_menu($data, $menu_id, $parent_id = 0) {

        foreach ($data as $key1 => $dataIn) {

            if ($dataIn->title == 'How To Guides') {

                update_post_meta(HOW_TO_PARENT_MENU_ID, 'cat-' . $dataIn->id, json_encode($dataIn));
                $parent_id = HOW_TO_PARENT_MENU_ID;
                if (count($dataIn->nodes) > 0) {

                    $this->add_menu($dataIn->nodes, $menu_id, HOW_TO_PARENT_MENU_ID);
                }
            } else {


                if ($dataIn->title == 'Shop') {
                    update_post_meta(PARENT_MENU_ID, 'cat-' . $dataIn->id, json_encode($dataIn));
                    $this->add_menu($dataIn->nodes, $menu_id, $child_menu_id);
                } else {


                    global $wpdb;

                    if ($parent_id == HOW_TO_PARENT_MENU_ID) {
                        $page_link = 'how-to-guides';
                    } else {
                        $page_link = 'product-list';
                    }

                    $meta_key = 'cat-' . $dataIn->id;
                    $value = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s LIMIT 1", $meta_key));
                    ;
                    $db_id = 0;

                    // check if menu is in our data
                    if (isset($this->data[$value])) {
                        $child_menu_id = $db_id = $value;
                        $order = $this->data[$value];
                        unset($this->data[$value]);
                        $this->update_menu($menu_id, $dataIn->id, $dataIn->title, $order, $parent_id, 'custom', $page_link, $db_id);
                    } else {
                        $child_menu_id = $this->update_menu($menu_id, $dataIn->id, $dataIn->title, $key1, $parent_id, 'custom', $page_link, $db_id);
                    }






                    $dataIn->description = str_replace(array("\r\n", "\r", "\n"), "<br />", $dataIn->description);
                    //update_post_meta($child_menu_id, 'cat-' . $dataIn->id, '1');
                    update_post_meta($child_menu_id, 'cat-' . $dataIn->id, wp_json_encode($dataIn, JSON_UNESCAPED_UNICODE));
                    // 1 has now use, ignore
                    if (count($dataIn->nodes) > 0) {

                        $this->add_menu($dataIn->nodes, $menu_id, $child_menu_id);
                    }
                }
            }
        }
    }

    function promote_menu() {

        $promote = '';

        if ($_GET['promoted'] == 1) {
            $promote = 1;
        }

        $col_to_update = 'post_content';

        if ($_GET['promote_menu'] == '2') {
            $col_to_update = 'post_excerpt';
        }

        // Update post 37
        $my_post = array(
            'ID' => (int) $_GET['menu_id'],
            $col_to_update => $promote,
        );

        // Update the post into the database
        wp_update_post($my_post);
    }

    function promoted_menu() {


        $menu_item = get_post($_GET['menu_id']);
        ?>
        <div id="popupz">
            <style>

                .popup_content {
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                    display: none;
                    margin: 1em;
                }
                .popup_content {
                    background-color: #f5f5f5;
                    border: 1px solid #e3e3e3;
                    border-radius: 4px;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
                    margin-bottom: 20px;
                    min-height: 20px;
                    padding: 19px;
                }
            </style>

            <div id="my_popup">
                <!-- Add an optional button to close the popup -->



                <label>Promote category on category page</label>
        <?php if ($menu_item->post_content == 1): ?>
                    <input id="promote_cat_cat" type="checkbox" value="<?php echo $menu_item->ID; ?>" name="" checked="checked" />
        <?php else: ?>
                    <input id="promote_cat_cat" type="checkbox" value="<?php echo $menu_item->ID; ?>" name="" />
        <?php endif; ?>     
                <br />
                <label>Promote category on landing page</label>
        <?php if ($menu_item->post_excerpt == 1): ?>
                    <input id="promote_cat_landing" type="checkbox" value="<?php echo $menu_item->ID; ?>" name="" checked="checked" />
        <?php else: ?>
                    <input id="promote_cat_landing" type="checkbox" value="<?php echo $menu_item->ID; ?>" name="" />
        <?php endif; ?>
                <button class="my_popup_close">Close</button>

            </div>
            <script>
                jQuery(document).ready(function () {

                    jQuery('#my_popup').popup({autoopen: true, background: false, detach: true, onclose: function () {


                            jQuery('#popupz,#my_popup_wrapper').remove();

                        }});

                });
            </script>
        </div>
        <?php
        die;
    }

    /**
     * 
     */
    function do_menu() {








//                return wp_update_nav_menu_item('Main', 33959, array(
//            'menu-item-parent-id' => 0,
//            'menu-item-db-id'   => 33959 , 
//            'menu-item-position' => 0,
//            'menu-item-object' => 'page',
//            'menu-item-type' => 'custom',
//            'menu-item-status' => 'publish',
//            'menu-item-url' => '#'  ,
//            'menu-item-title' => 'updated',
//        ));



        $jsonData = $this->get_json();

        $data = array();



       // ob_start();
     //   print_r($cats);




        wp_nav_menu(array(
            'echo' => false,
            'fallback_cb' => false, // Fallback function (see below)
            'walker' => $a = new Topbar1_Menu_Walker($data),
            'menu' => '2',
        ));


        $this->data = $a->data;
        $menuname = 'Main';
        $menu_exists = wp_get_nav_menu_object($menuname);
        $menu_id = $menu_exists->term_id;



        if ($menu_exists) {
            $this->add_menu($jsonData, $menu_id, $parent_id = PARENT_MENU_ID);
        }




//        $stringData = print_r($this->data ,true);
//     
//        update_option( 'logs', $stringData, false );
//        die;        

        if ($this->data) {

            foreach ($this->data as $key => $data) {

                wp_delete_post($key, true);
            }
        }
        // delete any menus thats have been removed



//        $out2 = ob_get_contents();
//
//        ob_end_clean();
//        $myFile = "testFiles.txt";
//        $fh = fopen($myFile, 'w') or die("can't open file");
//        $stringData = $out2;
//        fwrite($fh, $stringData);
//        fclose($fh);
    }

    public $data;

}

/**
 * 
 */
class Topbar1_Menu_Walker extends Walker_Nav_Menu {

    public $sub_menu_arr = array();
    public $data;

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {


        if ($item->menu_item_parent == PARENT_MENU_ID OR $item->menu_item_parent == HOW_TO_PARENT_MENU_ID OR in_array($item->menu_item_parent, $this->sub_menu_arr)) {
            $this->sub_menu_arr[$item->ID] = $item->ID;

            $this->data[$item->ID] = $item->menu_order;

            wp_delete_post($item->ID, true);
        }
    }

}
