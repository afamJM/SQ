/**
 * Add a button to the menu to refresh ibiza menu pulling from the api.
 * @param {type} param
 */
jQuery(document).ready(function () {
    if (window.location.href.indexOf("action=edit") <= 0) {
        jQuery( "#save_menu_header" )
        .clone()
        .attr({'id':'refresh_ibiza_menu' , 'value' : 'Refresh Ibiza Menu' })
        .appendTo( ".publishing-action" )
        .click( function(e){

            e.preventDefault();

            if( confirm( 'Are you sure you want to refresh th Ibiza menu, changes will be overwritten.' ) ){
                window.location.href = '/wp-admin/nav-menus.php?refresh_ibiza_menu=1';
            }

        });
    }
    
    
    
    jQuery('<a href=""  class="item-manage submitcancel hide-if-no-js">Manage</a> | ').prependTo( '.menu-item-depth-2 .menu-item-actions,.menu-item-depth-1 .menu-item-actions' );
    
    jQuery('body').on( "click", '.my_popup_close' , function() {
    
        jQuery('#my_popup').popup('hide');
        
    });
    
    
    jQuery( "body" ).on( "change", '#promote_cat_cat' , function() {
         //var a = $(this).val();
         
         var promoted = 0;
         
         if( jQuery(this).is( ':checked' )  ){
             promoted= 1;
         }
         
         
        jQuery.ajax({
          url: "/wp-admin/nav-menus.php?promote_menu=1&menu_id=" + jQuery(this).val() + '&promoted=' + promoted ,
          context: document.body
        }).done(function( data ) {
            
            
            
        });           
         
         
         
    }); 
    
    
    jQuery( "body" ).on( "change", '#promote_cat_landing' , function() {
         //var a = $(this).val();
         
         var promoted = 0;
         
         if( jQuery(this).is( ':checked' )  ){
             promoted= 1;
         }
         
         
        jQuery.ajax({
          url: "/wp-admin/nav-menus.php?promote_menu=2&menu_id=" + jQuery(this).val() + '&promoted=' + promoted ,
          context: document.body
        }).done(function( data ) {
            
            
            
        });           
         
         
         
    });    
    
    
    jQuery('.item-manage').click( function(e){
        
        
        
        var menu_id =jQuery(this).closest('.menu-item').attr('id').replace('menu-item-' ,'');
        
        
        e.preventDefault();
        
        jQuery.ajax({
          url: "/wp-admin/nav-menus.php?promoted_menu=1&menu_id=" + menu_id ,
          context: document.body
        }).done(function( data ) {
            
            jQuery('body').append( data );
            
            
        });        
        
        
    });
    
//menu-item-actions

});
