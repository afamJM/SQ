         
        
        <main id="main" class="large-<?php echo $col_size; ?> medium-12 small-12 columns" role="main" >
                <div class="row">
                        <?php if($top_level == false): ?>

                        <div class="small-6 top-bar-left float-left hide-for-large columns">
                            <ul class="menu">
                                <!-- <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li> -->
                                <li class="refine-results"><a data-toggle="off-canvas-left" aria-expanded="false" aria-controls="off-canvas"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_RefineResults_Black.png" />Refine Results</a></li>
                            </ul>
                        </div>

                        <div class="large-3 medium-6 small-6 columns">

                            <?php if( count( $sort ) ): ?>
                            <select id="sort_order" data-id="sort">

                                <?php foreach( $sort as $key => $sort_opt ): ?>

                                <option value="<?php echo $key; ?>" ><?php echo $sort_opt; ?></option>

                                <?php endforeach; ?>

                            </select>
                            <?php endif; ?>
                            
                        </div>


                        <div class="large-4 columns small-12 small-text-center">
                            <p>Showing {{indexVM.pageSize * indexVM.page - indexVM.pageSize + 1}} - {{min(indexVM.pageSize * indexVM.page, indexVM.results.hits.total)}} of {{indexVM.results.hits.total}} <?php echo $page_type; ?></p>
                            <!--<select ng-model="indexVM.pageSize" id="count" data-id="the_count">-->
                                <?php
//                                foreach( $page_sizes as $key => $page_size ):
//                                $selected == 'selected="selected"';
//                                if( isset( $_GET['count'] ) &&  $_GET['count'] == $$page_size ){
//                                    $selected == 'selected="selected"';
//                                }
                                ?>
                                <!--<option value="<?php // echo $page_size; ?>"  <?php // echo $selected;?>><?php // echo $page_size; ?></option>-->
                                <?php // endforeach; ?>
                            </select>
                        </div>

                        <div class="large-4 small-12 columns">
<!--                            <eui-simple-paging></eui-simple-paging>-->
                            
                            <div ng-controller="PaginationDemoCtrl" class="paging-container">
                                {{setPageTotal(indexVM.results.hits.total)}}
<!--                                <pagination total-items="totalItems" page="currentPage" on-select-page="pageChanged(page)" items-per-page="itemsPerPage"  max-size="maxSize" class="pagination-sm" boundary-links="false" rotate="false" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></pagination>-->
                                <div class="paging-info">
                                    <pager total-items="totalItems" page="currentPage"  num-pages="numPages" previous-text="Icon_WhiteArrowPrev.png" next-text="Icon_WhiteArrowNext.png" ></pager>
                                    <span class="paging-meta">Page {{currentPage}} of {{numPages}}</span>
                                </div>
                            </div>                            
                            
                            
                        </div>
                        <?php endif; ?>
                    </div>
                    <hr class="show-for-large">

                    <?php if($top_level == false): ?>



                    <div class="large-3 medium-4 small-6 columns" ng-repeat="doc in indexVM.results.hits.hits"  ng-class="!$last ? '' : 'end'">



                        <div class="panel"  ng-if="doc._index=='product'" >
                            <a href="/p/{{doc._source.productcode}}/{{doc._source['_friendly-uri-suffix']}}"><img src="{{doc._source.images[0].url}}" alt="{{doc._source.name}} image" /></a>
                            <h5><a href="/p/{{doc._source.productcode}}/{{doc._source['_friendly-uri-suffix']}}">{{doc._source.name}}</a></h5>
                            <h6><strong>&pound;{{ doc._source.price | number : 2}} </strong></h6>
<!--                            <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>-->
                        </div>

                        <div class="panel"  ng-if="doc._index=='howto'" >
                            <a href="/h/{{doc._id}}/{{doc._source.name}}"><img src="{{doc._source.image[0].url}}" /></a>
                            <h5 style="height:auto;"><a href="/h/{{doc._id}}/{{doc._source.name}}">{{doc._source.name}}</a></h5>
                            <h6><strong>Level - {{doc._source.level[0]}}</strong></h6>
                        </div>

                    </div>


                <?php else: ?>

                     

                    <?php endif; ?>        
                </section>
                <?php
                    $i      = 0;
                    $total  = 0;

                    foreach($catss as $cat){
                        if( $cat->post_content==1 ){
                            $total++;
                        }
                    }

                    ?>

                    <?php $i = 0;?>




                    <?php foreach($catss as $cat):  ?>


                        <?php if( $cat->post_content==1 ):?>

                        <?php $q_s= parse_url($cat->url); $out; ?>

                        <?php parse_str( $q_s['query'] ,$out ) ;  ?>
                        <?php $cat_data     =  get_post_meta( $cat->ID ) ;
                              $cat_data_ob  =  json_decode( $cat_data['cat-' . $out['cat']][0] );

                        ?>

                    <div class="large-3 medium-3 columns padded-column box <?php echo  $i == ( $total - 1) ? ' end ' : '' ; ?>">
                        <a href="<?php print $cat->url; ?>">
                        <span class="caption fade-caption">
                            <h3><?php echo $cat->post_title;?></h3>
                            <p><?php echo $cat_data_ob->intro ? $cat_data_ob->intro :'nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.'; ?></p>
                        </span>
                        </a>
                    </div>


                    <?php $i++;?>
                        <?php endif; ?>

                    <?php endforeach; ?>

                <!-- End Thumbnails -->
                
                <div class="large-12 columns text-center">
                    <ul class="pager" data-id="pager"> 
                        <li><pagination  total-items="totalItems" page="currentPage"  num-pages="numPages"     rotate="false" previous-text="Icon_WhiteArrowPrev.png" next-text="Icon_WhiteArrowNext.png"></pagination></li>
                    </ul>
                </div>
            </main>

<!-- Footer -->
<script src="<?php echo get_template_directory_uri(); ?>/vendor/angular/angular.min.js" type='text/javascript'></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/purl.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/vendor/elasticsearch/elasticsearch.angular.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/elastic/new/elastic.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/elastic/new/elasticui.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/elastic/new/paging.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/elastic/new/app.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/vendor/history.js/scripts/compressed/history.adapter.jquery.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/vendor/history.js/scripts/compressed/history.js"></script>

<script>
var started             = 0;
var query_str_arr       = {};
var state_change        = 0;
var indexVm             = {};
var searchables         = '';
<?php

function add_quotes( $string ) {
  $ret = "\'" . $string . "\'";
  return   $ret;
}

if(count($facetsOb[0]->searchables)):

$facetsOb[0]->searchables = array_map( 'add_quotes', $facetsOb[0]->searchables);

?>

searchables         = '<?php print  implode( ',' , $facetsOb[0]->searchables  ); ?>';
<?php
endif;
//// quick fix to monitor the state -1 is when state have been changed, and we want to prevent another state being puished
// State 1 is when someone click a facet and the state has been pushed, on this case there is a state event, we reset state back to default of 0?>

function setSort( sortIn )
{

    var sort = parseInt( sortIn );

    switch( sort ) {

        case 1:
            indexVm.sort = ejs.Sort('price').order('acs') ;
            break;
        case 2:
            indexVm.sort = ejs.Sort('price').order('desc') ;
            break;
        default:
            indexVm.sort = null;
            //
    }

}

function setPage( pageIn )
{
        console.log('here')
    var page        = parseInt( pageIn );
    indexVm.page    = null;

    if( page ) {

        indexVm.page = page ;
        console.log(indexVm.page);

    }

}


function fadeContainerIn()
{
    jQuery('#loading_container').fadeIn();
}

function elastic_callback(body, updateOnlyIfCountChanged) {


    // add page to query as it may have updated
    // only a ever single value, so remove then readd new value

    jQuery('#loading_container').fadeOut( function(){

        /// app must run once after out first call back, to add and facets from the query string
        if( started == 0 ){



            //jQuery('#loading_container').stop().animate({opacity:'100'});
            app();
            started = 1;




        }else{

            // pager needs to run every time we hit the callback, incase it has changed
            /*if(  typeof  query_str_arr == "undefined"  &&  query_str_arr['pager'][0] == indexVm.page ){

                return;

            }

            if( query_str_arr['pager'] ){

                removeQueryString( 'pager' , query_str_arr['pager'][0] );

            }

            addQueryString( 'pager' , indexVm.page );
            state_change    = 1;

            push_state( null , query_str_arr );
            <?php /**
             * @todo make sure double reload is not causing any bugs
             */
            ?>*/
            jQuery('#loading_container2').fadeOut( function(){



                setTimeout(function(){


                    jQuery( 'ul.nav-list' ).each(function( index ) {

                        if( jQuery( this ).children('li.ng-scope').length<=0 ){

                            jQuery( this ).parent().hide();
                        }else{
                            jQuery( this ).parent().show();
                        }

                    });

                }, 150);



            });

            setTimeout(function(){  addMobileMenu(); }, 750);
            /**
             * @todo need more reliable way, as this will not work for slow connections
             */
        }

    });



}


function addSelectedFilter( changedEl , selectedFacet )
{

    var elSelectedFacet =  '<li data-idx="'+ jQuery( changedEl ).attr('data-id') +'"> <span class="remove-filter">' + selectedFacet + '</span></li>';

    jQuery( elSelectedFacet ).appendTo( '.add_facets' );

    jQuery( document ).on( "click", 'li[data-idx="'+ jQuery( changedEl ).attr('data-id') +'"]', function() {

        jQuery('#inner-content-product-list input[data-id="'+ jQuery( changedEl ).attr('data-id') +'"]').click();

    });

}


function app()
{

    console.log( 'App started' );
    var ignore          = new Array();
    var shouldRefresh   = false; // should refresh if something is updated baseed on query string, iideally need a way to only search once everything is set up, temp solution
    var hasQueryParam   = false;
    var count           = jQuery.url().param('count');
    var pager           = jQuery.url().param('pager');
    var sort            = jQuery.url().param('sort');

    if ( undefined !=  count ) {

        indexVm.pageSize  = count;
        jQuery('#count option[value="' + pager + '"]').attr("selected" , "selected" );
        // do a UI update
        shouldRefresh     = true;
        addQueryString( 'count' ,count );

    }

    if ( undefined !=  pager ) {

        setPage( pager );
        shouldRefresh     = true;
        addQueryString( 'pager' , pager );
    }

    if ( undefined !=  sort ) {

        setSort( sort );
        jQuery('#sort_order').val( sort );
        // do a UI update
        shouldRefresh     = true;
        addQueryString( 'sort' , sort );
    }

    // if a facet is selected, should refresh can change to false, as adding facets will do the refresh for us
    // add out q string params we should ignore

    <?php foreach( $ignore_query_strs as $query_str ): ?>ignore.push( '<?php echo $query_str; ?>' );
    <?php endforeach; ?>

    console.log( 'Ignore the following' );
    console.log( ignore );

    // move to functon
    // rebuild query string

    console.log( 'Start rebuild' );
    for( var data in jQuery.url().param() )
    {

        var params   = jQuery.url().param( data ).split(',');

        if( jQuery.inArray(  data ,  ignore  ) == -1 ){

            shouldRefresh       = false;
            hasQueryParam       = true;
            //  no need to refresh
            for( var param in params )
            {
                // set check boxes in ui
                state_change = -1; // prevent state from changing
                jQuery('[data-id="the_value_' + data + '.raw_'+  params[param] + '"]').trigger("click");

            }
        }
    }

    console.log( 'End rebuild' );

    if( shouldRefresh ){

        indexVm.refresh( true );
        console.log( 'Refresh results' );
    }else{

        if(hasQueryParam==false)
        {
            jQuery('#loading_container2').fadeOut();
        }
    }
    //
    console.log( 'Complete' );

}

function push_state( changedEl , query_str_arr )
{
    var protocol    = jQuery.url().attr('protocol');
    var url         = jQuery.url().attr('host');
    var directory   = jQuery.url().attr('directory');
    var q           = jQuery.url().param('q');
    var cat         = jQuery.url().param('cat');
    var title       = jQuery.url().param('title');

    if(q){
        History.pushState({state: jQuery( changedEl ).attr('data-id')  }, "State 1",  protocol + '://' + url +  directory  +  '?q=' + q + '&' + toQueryString(query_str_arr, '') );
    }else{
        History.pushState({state: jQuery( changedEl ).attr('data-id')  }, "State 1",  protocol + '://' + url +  directory  +  '?' + toQueryString(query_str_arr, '') );
    }

}

function addQueryString( field , value ){

    if(query_str_arr[field]){

        query_str_arr[field].push(value);

    }else{

        query_str_arr[field] = Array(1).fill(value);

    }

}

function removeQueryString( field , value ){

    if( jQuery.inArray(  value , query_str_arr[field] ) != -1 ){

        query_str_arr[field].splice( jQuery.inArray(value, query_str_arr[field] ), 1 );

    }

}

function toQueryString(obj, prefix) {

    var str = [], k, v;
    for(var p in obj) {
        if (!obj.hasOwnProperty(p)) {continue;} // skip things from the prototype


        if( obj[p].length >0 ){

            str.push( p + '=' + obj[p].join(",") );
            console.log(str);
        }
    }

    return str.join("&");
}

function addMobileMenu()
{

    jQuery('#off-canvas-left .sidebar').remove();
    var sideBar = jQuery('.sidebar').clone(false,false);
    jQuery(sideBar).appendTo('#off-canvas-left');
    jQuery('.show-for-large' , '#off-canvas-left').removeClass('show-for-large');
    jQuery('.sidebar').show();

    jQuery('#off-canvas-left input').click( function(){

       jQuery('#inner-content-product-list input[data-id="'+ jQuery( this ).attr('data-id') +'"]').click();

    });
}

jQuery( document ).ready(function() {

    var qIn = jQuery.url().param('q');

    jQuery(document).on('click', '#side-facets h3', function(e) {
        
        
        if( jQuery(this).text()=='Price' ){
            jQuery( this ).nextAll('eui-range').slideToggle();
        }else{
            jQuery( this ).next().slideToggle();
        }
        
    });


    jQuery('#reset-filter').click( function(){

       jQuery('#inner-content-product-list input:checked').click();

    });

    if(typeof  qIn != 'undefined' )
    {
        jQuery('#s-box').val(  jQuery.url().param('q') );
    }


    jQuery('.top-bar-left a').click( function(){



    });


    jQuery('.top-bar-left a').click( function(){



        addMobileMenu();


    });

    jQuery( '#count' ).change( function(){

        // only a ever single value, so remove then readd new value

        setPage( 1 );


        if( query_str_arr['pager'] ){

            removeQueryString( 'pager' , query_str_arr['pager'][0] );

        }

        addQueryString( 'pager' , 1 );

        // reset back to page 1
        if( query_str_arr['count'] ){

            removeQueryString( 'count' , query_str_arr['count'][0] );

        }

        addQueryString( 'count' , jQuery(this).val() );


        if(state_change!=-1)
        {

            state_change        = 1;
            // reset back to page 1

            push_state( this  , query_str_arr )
        }

    });

    jQuery( '#sort_order' ).change( function(e){




        var sort = jQuery( this ).val();
        setSort( sort );


        // only a ever single value, so remove then readd new value

        if( query_str_arr['sort'] ){

            removeQueryString( 'sort' , query_str_arr['sort'][0] );

        }

        addQueryString( 'sort' , sort );

        // condition added to prevent another state being added when user clicks bnack
        if(state_change!=-1 || e.originalEvent)
        {
            state_change = 1;

            push_state( this  , query_str_arr );

        }

        indexVm.refresh( false );


    });


    jQuery('#disable_filter').click( function(){

        indexVm.sort = ejs.Sort('name').order('acs') ;
        indexVm.refresh( false );

    });

    History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate

        if( state_change == 1 ){
             console.log( 'abort'  )
            state_change = 0;
            <?php // reset the state ?>
            return;
        }
        var State       = History.getStateByIndex( History.getCurrentIndex() -1   ); // Note: We are using History.getState() instead of event.state

        if(typeof State.data.state =='undefined'){
            // if going forward
            State   = State2;
            console.log('Fall back');
        }

        var state_item  = jQuery( '[data-id="' +  State.data.state + '"]' );
        state_change    = -1; <?php // prewvent another state update?>

        //console.log(State)

        switch(State.data.state)
        {
            case 'the_count':

                var v = jQuery.url().param('count');

                if(!v)
                {
                    v= 12; // default value
                }

                jQuery("#count").val( v ).change();
                state_change    = 0;
                break;
            case 'sort':

                var v = jQuery.url().param('sort');

                if(!v)
                {
                    v= 0;
                }

                jQuery("#sort_order").val( v ).change();
                state_change    = 0;
                break;
            default:

                state_item.click();

        }



        // come back to this


    });

    jQuery('#inner-content-product-list').on('change', '.ng-scope input[type="checkbox"]', function(e) {

        console.log( e );
        //fadeContainerIn();

        var field       = jQuery( this ).parents('eui-checklist,eui-range').attr( 'field' ).replace( /\'/g ,'' );
        var value       = jQuery(this).attr('data-id').replace( 'the_value_' + field + '_' ,'' ) ;

        field           = field.replace('.raw','');
        // cleaner url!
        var changedEl   = this;

        console.log( state_change );

        if( jQuery(this).attr('checked') ){

            addQueryString( field , value );

            var selectedFacet   = jQuery(   changedEl )[0].nextSibling.nodeValue;
            selectedFacet       = selectedFacet.substring(0, selectedFacet.lastIndexOf( ' (' )   );
            // removed aggregated data, maybe this should be wrapped in a span, sho we can do via CSS

            addSelectedFilter( changedEl , selectedFacet );

        }else{

            removeQueryString( field , value );
            // remove item from



            jQuery( 'li[data-idx="'+ jQuery( changedEl ).attr('data-id') +'"]' ).remove();

        }

        if( state_change==-1 ){

            state_change    = 0;

        }else{
            state_change    = 1;
            push_state( changedEl , query_str_arr  );

        }
    });
 });

 
</script>