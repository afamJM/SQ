<?php

include_once('IbizaApi_LifeCycle.php');

class IbizaApi_Plugin extends IbizaApi_LifeCycle {

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
        return 'Product Catalogue';
    }

    protected function getMainPluginFileName() {
        return 'product-catalogue.php';
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

    
    public function map($n){
        
        
        return array_combine( explode('|-|',$n->keys) , explode('|-|',  $n->values) );
        
    }
    
    public function addActionsAndFilters() {

        // Add options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));


        if (isset($_GET['logout'])) {
           
            if (isset($_SERVER['HTTP_COOKIE'])) {
                
               
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach ($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    
                    setcookie($name, '', -1);
                    setcookie($name, '', -1, '/', '.'. str_replace( 'www.' ,'', $_SERVER['SERVER_NAME']) );
                }
            }
            
            
            header('Location: /');
            die;
        }
        
        
        if( isset( $_GET['cat_search'] )  ){
            
            global $wpdb;
            $wpdb->get_results( 'SET SESSION group_concat_max_len = 1000000;' );
            $rst =  $wpdb->get_results('SELECT * , GROUP_CONCAT( pm.meta_key SEPARATOR "|-|" ) as `keys`, 
                   GROUP_CONCAT( pm.meta_value SEPARATOR "|-|" ) AS `values` 
                   FROM wp_posts AS p INNER JOIN wp_postmeta AS pm ON p.ID =pm.post_id  
                   WHERE (p.post_type = "nav_menu_item" AND p.post_title LIKE "%'. $this->sanitize($_GET['cat_search'] ) .'%" ) OR pm.meta_key="cat-' . $this->sanitize($_GET['cat_search'] ) . '" 
                      GROUP BY pm.post_id'   );

            $data_set  =  array_map( array(&$this,'map') , $rst);
            $i= 0;
            foreach ($data_set as $data){
                
                $data_x                     =  array_map( 'json_decode' , $data);
                $data_x['_menu_item_url']   = $data['_menu_item_url'];
                // we only need cat-* field and this is json, also menu url;)
                
                
                foreach($data_x as $key=> $d){
                    

                    
                    if(is_object($d)){
                       
                        
                        $final_data['hits']['hits'][$i]['_source']['image']     = $d->image?$d->image:'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
                        $final_data['hits']['hits'][$i]['_source']['name']      = $d->title;
                        $final_data['hits']['hits'][$i]['_source']['id']        = str_replace( 'cat-' , '',  $key );
                        $final_data['hits']['hits'][$i]['_type']                = 'category'; 
                        
                    }
                    if($key == '_menu_item_url'){
                        $final_data['hits']['hits'][$i]['_url']                 = $_SERVER['HTTP_HOST'] . $d; 
                    }
                    
                }
                
                ++$i;
            }
            
            echo json_encode($final_data);
            
            die;
        }


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
    }

    // start product catalogue function 

    /**
     * start class variables
     */
    const api_location = API_URL;
    const api = API;

    public $top_level_category = array('32', '23935');

    const wp_menu_id = '2';

    /*
    private $end_points = array('product_list' => '/api/category/categoryId/',
        'price_range' => '/api/pricerange/range/',
        'product' => '/api/document/data.productcode/',
        'howto' => '/api/document/',
        'product_schema' => '/productcatalog.api/api/schema/title/',    
    */
    
    
    public static  $end_points             = 
            //nonsecurebasket 
        array(     
            
                'price_range'              => ENV == 'prod' ? API . '/pricerange/range/'             :  API . '/pricerange/range/',
                'categorytree'              => ENV == 'prod' ? API . '/categorytree/'                :  API . '/categorytree/',
                'product_list'              => ENV == 'prod' ? API .  '/category/categoryId/'        :  API . '/category/categoryId/',
                'category'                  => ENV == 'prod' ? API .  '/category/categoryId/'        :  API . '/category/categoryId/',
                'mongo'                     => ENV == 'prod' ? API .  '/document/'                   :  API . '/document/',
                'product'                   => ENV == 'prod' ? API .  '/document/data.productcode/'  :  API . '/document/data.productcode/',
                'elastic'                   => ENV == 'prod' ? API .  '/elastic/'                    :  API . '/elastic/',                            
                'product_elastic'           => ENV == 'prod' ? API .  '/elastic/product/'            :  API . '/elastic/product/',                
                'howto'                     => ENV == 'prod' ? API .  '/document/'                   :  API . '/document/',
                'howto_elastic'             => ENV == 'prod' ? API .  '/elastic/howto/'              :  API . '/elastic/howto/',
                'product_schema'            => ENV == 'prod' ? API .  '/schema/title/'               :  API . '/schema/title/',
                'variantgroup'              => ENV == 'prod' ? API .  '/variantgroup/variants.id'    :  API . '/variantgroup/variants.id',
                'signalr'                   => ENV == 'prod' ? API .  '/signalr'                     :  API . '/signalr/',    
                'signalr_hubs'              => ENV == 'prod' ? API .  '/signalr/hubs'                        :  API . '/signalr/hubs',
                'securebasket'              => ENV == 'prod' ? API_LEG .  '/legacy/securebasket/'                :  API_LEG . '/legacy/securebasket/',
                'nonsecurebasket'           => ENV == 'prod' ? API_LEG .  '/legacy/nonsecurebasket'              :  API_LEG . '/legacy/nonsecurebasket/',
                'basketitemquantitysecure'  => ENV == 'prod' ? API_LEG .  '/legacy/basketitemquantitysecure'     :  API_LEG . '/legacy/basketitemquantitysecure/',
                'message'                   => ENV == 'prod' ? API_LEG .  '/legacy/message'                      :  API_LEG . '/legacy/message',
                'auction'                   => ENV == 'prod' ? API_LEG .  '/legacy/auction'                      :  API_LEG . '/legacy/auction/',
                'productCatalog_web'        => ENV == 'prod' ? API .  '/ProductCatalog.Web'                             :  API . '/ProductCatalog.Web',
                'tvschedule'                => ENV == 'prod' ? API_LEG .  '/legacy/tvschedule'                :  API_LEG . '/legacy/tvschedule',
                'todaysproducts'            => ENV == 'prod' ? API_LEG .  '/legacy/todaysproducts/'              :  API_LEG . '/legacy/todaysproducts/',
                'login_page'                => ENV == 'prod' ?    'http://secure.sewingquarter.com/login.aspx?_ga=1.246909059.624630137.1465816634'              :   'https://secure.ibiza.com.dev/login.aspx?_ga=1.246909059.624630137.1465816634',
                'secure_site'               => ENV == 'prod' ?    'http://secure.sewingquarter.com/'              :  'https://secure.ibiza.com.dev',
            );
    
    public  $is_top_level           = false;
    private $sort                   = array(0 => 'Sort By', 1 => 'Price (Low - High)', 2 => 'Price (High - Low)');
    private $page_sizes             = 48;
//    private $page_sizes = array(1, 5, 12, 20, 50, 100, 200);
    private $ignore_query_strs      = array('cat', 'title', 'count', 'sort', 'pager', 'q');
    private $facetsOb               = null;
    private $sub_cats               = array();
    public  $all_cats               = array();

    /**
     * end class variables
     */

    public function __construct() 
    {
    
         
        
    }




    /**
     * 
     * @return string
     */
    public function get_product_list_title($title) {

        // make it safe, method found in fucntions.php
        $title = $this->sanitize($title);

        // other custom stuff, as requested
        if (isset($_GET['q'])) {

            if (stripos($_GET['q'], 'how') !== false) {
                $title = 'How To';
            } else {
                $title = 'Products';
            }
        }

        return $title;
    }

    /**
     * 
     * @return int
     */
    public function get_product_list_category($cat) {

        // make it safe, method found in fucntions.php
        $category = $this->sanitize($cat);

        return (int) $category;
    }

    /**
     * 
     * @return string
     */
    public function get_product_list_api_url($category) {

        return  $this::$end_points['product_list'] . (int) $category;
    }

    /**
     * 
     * @return Array
     */
    public function get_product_list_sort_options() {

        return $this->sort;
    }

    /**
     * 
     * @return Array
     */
    public function get_product_list_ignored_query_strings() {

        return $this->ignore_query_strs;
    }

    /**
     * 
     * @return Array
     */
    public function get_product_list_pages_sizes() {

        return $this->page_sizes;
    }

    /**
     * 
     * @global type $wpdb
     * @param type $cat
     * @return type
     */
    public function get_product_list_top_level_categorys($cat, $id = 0) {

        
        
        if ($cat) {

            global $wpdb;
            $r = $wpdb->get_results($wpdb->prepare("
            SELECT p.id , pm.meta_value FROM {$wpdb->postmeta} pm
            LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = '%s' 
            AND pm.meta_value !=  'null' 
            AND pm.meta_value !=  '' 
            LIMIT 1
            ", 'cat-' . $cat));



            $catss = array();
            $this->cat_data = json_decode($r[0]->meta_value);

            if (!$id) {

                $id = $r[0]->id;
            }
        }


        $items = wp_get_nav_menu_items($this::wp_menu_id);
        //print_r($items);die;
        foreach ($items as $item) {

            if ($item->ID == $id && in_array($item->menu_item_parent, $this->top_level_category)) {
                $this->is_top_level = true;
            }

            if ($item->menu_item_parent == $id) {
                $this->sub_cats[] = $item->ID;
                $this->all_cats[$item->post_title] = (object) $item;
                $catss[$item->post_title] = (object) $item;
            }

            if (in_array($item->menu_item_parent, $this->sub_cats)) {
                $this->sub_cats[] = $item->ID;

                $this->all_cats[$item->post_name] = (object) $item;
            }
        }
        // run again to pick up any missed categorys
        foreach ($items as $item) {

            if (in_array($item->menu_item_parent, $this->sub_cats)) {
                $this->sub_cats[] = $item->ID;

                $this->all_cats[$item->post_name] = (object) $item;
            }
        }

        //print_r($this->sub_cats)

        ksort($catss);

        return $catss;
    }

    /**
     * 
     * @param type $jsonPath
     * @return array
     */
    public function get_product_list_facets($jsonPath, $cat = 0) {

        $facetsJSON = getSslPage( $jsonPath  );
        // remove suppression on production
        $this->facetsOb = json_decode($facetsJSON);


        if (!$this->facetsOb || $cat == 0) {
            $facets = $this->facetsOb[0]->allfacets;
            ;
        } else {
            $facets = $this->facetsOb[0]->commonfacets;
        }

        return $facets;
    }

    /**
     * 
     * @return type
     */
    public function get_product_list_price_range() {

        $rangePath  = $this::$end_points['price_range'] . '0/20000';
        $rangeJSON  = getSslPage($rangePath);
        $range      = json_decode($rangeJSON);

        return $range;
    }

    /**
     * 
     * @return Object
     */
    public function get_product_list_facets_object() {
        return $this->facetsOb;
    }

    // start product page

    /**
     *
     * @var array 
     */
    private $core_atrributes = array('name' => 1,
        'description' => 1,
        'productcode' => 1,
        'legacycode' => 1,
        'price' => 1,
        'images' => 1,
        'review' => 1,
        'category' => 1,
        '_mongo' => 1,
        '_schema' => 1,
        '_category' => 1,
        'items' => 1);

    /**
     * Retrieve a product from MongoDB using a product code
     * @param type $product_code
     * @return object
     */
    public function get_product($product_code) {

        $json_contents = getSslPage( $this::$end_points['product'] . strtoupper($this->sanitize($product_code)) );
        $rst = json_decode($json_contents);

        return $rst;
    }

    /**
     * Retrieve a product from MongoDB using a product code
     * @param type $product_code
     * @return object
     */
    public function get_howto($id) {

        //echo $this::$end_points['howto'] . $this->sanitize($id);die;
        
        $json_contents = getSslPage(  $this::$end_points['howto'] . $this->sanitize($id) );
        $rst = json_decode($json_contents);

        return $rst;
    }
    
    /**
     * Retrieve a product from MongoDB using a product code
     * @param type $product_code
     * @return object
     */
    public function get_category($id) {
        
        $json_contents  = getSslPage( $this::$end_points['product_list'] . $this->sanitize($id) );
        $rst            = json_decode($json_contents);

        return $rst;
    }

    /**
     * Retrieve a product from MongoDB using a product code
     * @param type $product_code
     * @return object
     */
    public function get_product_schema($schema) {

        $json_contents = getSslPage( $this::$end_points['product_schema'] . $schema);

        $rst = json_decode($json_contents);
        return $rst;
    }

    public function get_core_attributes() {
        return $this->core_atrributes;
    }

    // end product page
    // end product catalogue function


    public function get_current_and_previous_tv_products() {

        $json_contents = getSslPage( 'http://legacyapi.localdev/Api/todaysproducts/0/1/49' );

        $rst = json_decode($json_contents);

        return $rst;
    }

    public function get_tv_schedule() {

        $json_contents = getSslPage( 'http://legacyapi.localdev/Api/todaysproducts/0/1/49');

        $rst = json_decode($json_contents);

        return $rst;
    }

    /**
     * 
     */
    function sanitize($string, $force_lowercase = true, $anal = false) {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<" , ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
                (function_exists('mb_strtolower')) ?
                        mb_strtolower($clean, 'UTF-8') :
                        strtolower($clean) :
                $clean;
    }

}

//print_r( new IbizaApi_Plugin() );