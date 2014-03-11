		<div id="footer">
        
        	<div class="wrapper">
            
            	<?php
				
					////////////////////////////////////////
					//// GES OUR MARKUP
					get_template_part('includes/footer/markup');
				
				?>
            
            	<div class="clear"></div>
                <!-- /.clear/ -->
            
            </div>
            <!-- /#content .wwapper/ -->
        
        </div>
        <!-- /#content/ -->
        
        <div id="copyright" class="full-block">
        
        	<div class="wrapper">
            
            	<div class="left"><p><?php echo str_replace('%%year%%', date('Y'), ddp('copyright_left')); ?></p></div>
                <!-- /.left/ -->
            
            	<div class="right"><?php echo ddp('copyright_right'); ?></div>
                <!-- /.left/ -->
            
            	<div class="clear"></div>
                <!-- /.clear/ -->
            
            </div>
            <!-- /.wrapper/ -->
        
        </div>
        <!-- /#copyright;/ -->
        
        <!-- /WPFOOTER STARTS/ -->
		<?php wp_footer(); ?>
        <!-- /WP FOOTER ENDS/ -->
    
    </body>
    <!-- BODY ENDS -->

</html>