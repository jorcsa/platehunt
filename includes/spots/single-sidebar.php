<?php do_action('single_spot_before_contact', get_the_ID(), 'before_contact'); ?>

<?php

	///////////////////////////////////////////////////////
	//// GETS SIDEBAR ENQUIRY FORM
	///////////////////////////////////////////////////////
	
	get_template_part('includes/spots/single', 'contact-form');
	
	///////////////////////////////////////////////////////

?>

<?php do_action('single_spot_after_contact', get_the_ID(), 'after_contact'); ?>