<?php
use PHPUnit\Framework\TestCase;

/**
 * 
 */
class ProductsListTest extends TestCase
{


    public function setUp() 
    {
        
        $_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__) . "/../";
        require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/ibiza-api/IbizaApi_Plugin.php');
      
    }


    public function tearDown() 
    {
        
        unset($_SERVER['DOCUMENT_ROOT']);
      
    }    
    
    public function testGetProductListTitle()
    {
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('string', $ibiza_api->get_product_list_title('Hello World') );
    }
    
    
    public function testGetProductListCategory()
    {        
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('int', $ibiza_api->get_product_list_category( '1' ) );        
    }
    
    public function testGetProductListSortOptions()
    {
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('array', $ibiza_api->get_product_list_sort_options() );            
    }
    
    public function testGetProductListIgnoredQueryStrings()
    {
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('array', $ibiza_api->get_product_list_ignored_query_strings() );            
    }
    
    public function testGetProductListPagesSizes()
    {
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('array', $ibiza_api->get_product_list_pages_sizes() );            
    }
    
    public function testGetProductListApiUrl()
    {
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('string', $ibiza_api->get_product_list_api_url(0) );            
    }

    public function testGetProductListFacets() 
    {
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('array', $ibiza_api->get_product_list_facets('') );  
    }
    

    public function testGetProductListPriceRange() 
    {
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('object', $ibiza_api->get_product_list_price_range('') );  
    }
    

    public function testGetProductListFacetsObject() 
    {
        $ibiza_api = new IbizaApi_Plugin();
        $this->assertInternalType('object', $ibiza_api->get_product_list_facets_object() );  
    }
    //
    public function testCanBeNegated()
    {

        $this->assertEquals(-1,  -1 );
    }

    // ...
}
