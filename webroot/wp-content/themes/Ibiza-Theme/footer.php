<?php

    $the_cache = 'footer_link';


    $cb =        function($the_cache){     
        ob_start();
        joints_footer_links1();
        $footer_link['footer1'] = ob_get_contents();
        ob_end_clean();   
 
        ob_start();
        joints_footer_links2();
         $footer_link['footer2'] = ob_get_contents();
        ob_end_clean();   
 
        ob_start();
        joints_footer_links3();
         $footer_link['footer3'] =ob_get_contents();
        ob_end_clean();   

        create_cache(  $the_cache  ,$footer_link);
        return $footer_link; 
    };
    
   
    
    $footer_link = get_cache( $the_cache , $cb );



?>


<div class="row">	
    <div class="small-1 right">
        <div id="back_to_top">
            <div></div>
        </div>
    </div>
</div>
                <footer class="footer" role="contentinfo">
                                        <div id="inner-footer" >
                                            <div class="row">
                                                <div class="large-3 medium-4 columns small-6  show-for-medium">
                                                    <nav role="navigation">
                                                        <?php print $footer_link['footer1']; ?>
                                                    </nav>
                                                </div>
                                                <div class="large-3 medium-4 columns small-6">
                                                    <nav role="navigation">
                                                        <?php print $footer_link['footer2']; ?>
                                                    </nav>
                                                </div>
                                                <div class="large-3 medium-4 columns small-6">
                                                    <nav role="navigation">
                                                        <?php print $footer_link['footer3']; ?>
                                                    </nav>
                                                </div>
                                                <div class="large-3 medium-12 columns commuity">
                                                    <div class="medium-6 large-12 columns n-l-p">
                                                        <label for="emailSignup"><p style="font-size: 1rem;">Sign up to hear about our latest news and special offers</p></label>
                                                        <input name="emailSignup" type="" style="height: 37px" placeholder="yourname@emailaddress.co.uk" /><button aria-expanded="false" aria-haspopup="true" data-yeti-box="example-dropdown2" data-is-focus="false" aria-controls="example-dropdown2" class="button" type="submit">Submit</button>
                                                    </div>
                                                    
                                                    <div class="medium-6 large-12 columns social-icon n-r-p">
                                                        <div class="social">
                                                            <a target="_blank" href="https://www.facebook.com/sewingquarter/"  title="Like us on Facebook"><span class="icon social-icons  facebook-icon"></span></a>
                                                            <a target="_blank" href="https://www.youtube.com/channel/UChlaCS-wEUDdO584gbPk5Rw" title="Watch our YouTube channel"><span class="icon social-icons  youtube-icon"></span></a>
                                                            <a target="_blank" href="https://twitter.com/sewingquarter"   title="Follow us on Twitter"><span class="icon social-icons  twitter-icon"></span></a>
                                                            <a target="_blank" href="https://www.instagram.com/sewingquarter/" title="Follow us on Instagram"><span class="icon social-icons  instagram-icon"></span></a>
                                                            <a target="_blank" href="https://uk.pinterest.com/sewingquarter/" title="Follow us on Pinterest"><span class="icon social-icons  pinterest-icon"></span></a>
                                                        </div>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="large-1 medium-2 columns small-3">
                                                    <a href="http://www.immediate.co.uk/" target="_blank" class="remove-padding-margin"><span class="icon immediate-icon"></span></a>
                                                </div>
                                                <div class="large-6 medium-10 columns large-pull-5 small-9">
                                                    <p class="source-org copyright">&copy;  Immediate Media Company Limited <?php echo date('Y'); ?>.Registered in England No. 5715415 Registered Office:  Vineyard House, 44 Brook Green, Hammersmith, London, W6 7BT</p>
                                                </div>
                                            </div>
                                        </div> <!-- end #inner-footer -->
                                </footer> <!-- end .footer -->
                        </div>  <!-- end .main-content -->
                </div> <!-- end .off-canvas-wrapper-inner -->
        </div> <!-- end .off-canvas-wrapper -->
        <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-584565b16fa56454"></script>
        <?php wp_footer(); ?>

        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <div class="main-nav__backdrop"></div>

    </body>
</html> <!-- end page -->