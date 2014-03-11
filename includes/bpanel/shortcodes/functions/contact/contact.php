<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR PORTFOLIO
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('contact_form', 'ddshort_contact_form');
	
	//Our Funciton
	function ddshort_contact_form($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'to' => get_option('admin_email')
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$output = '<div class="ddcontact_form">';
		
		//// OUR FORM
		$output .= '<form action="'.get_template_directory_uri().'/includes/bpanel/shortcodes/functions/contact/mail.php" method="post" class="ddContactForm">
		
			<p class="contactName">
			
				<label for="contactName">'.__('Name:', 'DDShortcode_Contact').'</label>
				<input type="text" value="" id="contactName" name="contactName" class="medium" />
			
			</p>
		
			<p class="contactEmail">
			
				<label for="contactEmail">'.__('Email:', 'DDShortcode_Contact').'</label>
				<input type="text" value="" id="contactEmail" name="contactEmail" class="medium" />
			
			</p>
		
			<p class="contactMessage">
			
				<label for="contactMessage">'.__('Message:', 'DDShortcode_Contact').'</label>
				<textarea name="contactMessage" id="contactMessage" cols="" rows="4"></textarea>
			
			</p>
		
			<p class="emailTo hidden">
			
				<input type="text" value="'.$to.'" id="emailTo" name="emailTo" class="medium" />
			
			</p>
			
			<p><input type="submit" class="button-primary" value="'.__('Submit', 'DDShortcode_Contact').'" id="contactSubmit" /></p>
		
		</form>';
		
		//// HIDDEN THANK YOU MESSAGE
		$output .= '<div class="ddcontact_thankyou hidden">'.do_shortcode($content).'</div>';
		
		//// ERROR FIELD
		$output .= do_shortcode('[notification color="red"][/notification]');
		
		//// CLOSES THE OUTPUT
		$output .= '</div>';
		
		//// RETURNS OUTPUT
		return $output;
		
	}
	
	include('tinyMCE.php');

?>