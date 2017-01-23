<div class="off-canvas position-left" id="off-canvas" data-off-canvas data-position="left">
    <div id="off-canvas-menu-content">
        <a href="#">#</a>
	<?php  
            $the_cache  = 'joints_off_canvas_nav';
            $cb         =      function($the_cache)
            {           
                ob_start();
                joints_off_canvas_nav();
                $cache_joints_top_nav = ob_get_contents();
                ob_end_clean();   

                create_cache(  $the_cache  ,$cache_joints_top_nav);
                return $cache_joints_top_nav;
            };            
            
            
            $cache_joints_top_nav = get_cache( $the_cache , $cb );
            print $cache_joints_top_nav;        
            //remove_cache(  $the_cache  );
        
        ?>
    </div>
    <div id="off-canvas-content">
        
    </div>
    
</div>