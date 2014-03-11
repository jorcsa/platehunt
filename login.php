<?php /*

	Template Name: Submit

*/  get_header(); ?>
        
        
        
        
	<?php
    
        //////////////////////////////////////////////////////
        //// IF USER IS LOGGED IN LOAD USER PANEL
        //////////////////////////////////////////////////////
        if(is_user_logged_in()) {
            
            /// GET USER PANEL
        	get_template_part('includes/spots/user-panel');
            
        }
    
        //////////////////////////////////////////////////////
        //// IF NOT DISPLAY OUR LOGIN AND REGISTRATION FORM
        //////////////////////////////////////////////////////
		else {
			
			//// GETS LOGIN AND REGISTRATION FORM
			get_template_part('includes/spots/markup', 'login');
			
		}
    
    ?>

	
<!-- /FOOTER STARTS/ -->
<?php get_footer(); ?>