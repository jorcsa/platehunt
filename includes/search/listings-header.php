<?php

	$is_header_map = get_listings_header_type();

	////// IF WE ARE USING A MAP FOR OUR LISTING HEADER
	if($is_header_map == 'on') {
		
		get_template_part('includes/search/listings', 'header-map');
		
	} else {
		
		get_template_part('includes/search/listings', 'header-standard');
		
	}

?>

	
    <script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			//// THIS FUNCTION WILL HANDLE WHENEVER THE USER IS PUSHING BACK OR FORWARD
			jQuery('#main-content')._sf_load_results_pop_state();
			
			<?php if(ddp('future_notification')) : //// IF USERS CAN SIGN UP FOR NOTIFICATIONS ?>
			jQuery('.notify-me')._sf_open_user_notification();
			<?php endif; ?>
			
		});
	
	</script>