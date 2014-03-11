<?php

	///////////////////////////////////////////
	///////////////////////////////////////////
	//// THIS FILE HANDLES OUR SHORTCODES
	//// FUNCTIONS AND STYLES
	//// DVP. BY GUILHERME SALUM - DDSTUDIOS
	//// DO NOT DISTRIBUTE, MODIFY OR REUSE
	///////////////////////////////////////////
	///////////////////////////////////////////
	
	
	
	////////////////////////////////////
	// LOADS OUR JS SCRIPT
	////////////////////////////////////
	
	//init hook
	add_action('init', 'ddShortIncludeJs');
	
	//our include js function
	function ddShortIncludeJs() {
		
		if(!is_admin()) {
			
			//shortcodes.js
			wp_register_script('ddshortcodes', get_template_directory_uri().'/includes/bpanel/shortcodes/js/shortcodes.js');
			
			//HTML5 VIDEO & AUDIO
			wp_register_script('ddshortcodes_audiovideo', get_template_directory_uri().'/includes/bpanel/shortcodes/js/audioandvideo/mediaelement-and-player.min.js');
			
			//HTML5 VIDEO & AUDIO
			wp_register_script('dd_prettyPhoto', get_template_directory_uri().'/includes/bpanel/shortcodes/js/prettyPhoto/jquery.prettyPhoto.js');
			
			//Enqueue our script
			wp_enqueue_script('jquery');
			wp_enqueue_script('ddshortcodes');
			wp_enqueue_script('ddshortcodes_audiovideo');
			wp_enqueue_script('dd_prettyPhoto');
			
		}
		
	}
		
			//////////////////////////////////////////////////
			//// TYPOGRAPHY OPTIONS
			//get_template_part('includes/general/typography/functions');
	
	
	
	////////////////////////////////////
	// LOADS OUR CSS FILES
	////////////////////////////////////
	
	add_action('wp_enqueue_scripts', 'ddShortIncludeCss');
	
	function ddShortIncludeCss() {
		
		//// MAIN STYLE.CSS
		wp_register_style('btoa_shortcodes',  get_template_directory_uri().'/includes/bpanel/shortcodes/css/shortcodes.css', array(), '20130402', 'all');
		
		//// RESPONSIVE
		wp_register_style('prettyPhoto',  get_template_directory_uri().'/includes/bpanel/shortcodes/css/prettyPhoto.css', array(), '20130402', 'all');
		
		//// LET'S ENQUEUE IT
		wp_enqueue_style('btoa_shortcodes');
		wp_enqueue_style('prettyPhoto');
		
	}
	
	
	
	////////////////////////////////////
	// OUR jQUERY ACTIVATORS
	////////////////////////////////////
	
	//Let's now include our .css file
	add_action('wp_head', 'ddShortIncludeJsActivators');
	
	//let's include the necessary file
	function ddShortIncludeJsActivators() {
		
		//builds our CSS tag
		$output = "
		<script type=\"text/javascript\">
		
			jQuery(document).ready(function() {
				
				jQuery('#menu').btoaDropdown();
				
				jQuery('select').each(function() { if(jQuery(this).attr('multiple') != 'multiple') { jQuery(this).replaceSelect(); } });
				
				jQuery('input[type=checkbox]:not(._sf_switch_input)').each(function() { jQuery(this).replaceCheckbox(); });
				
				jQuery('input[type=radio]').each(function() { jQuery(this).replaceRadio(); });
				
				jQuery('.toggled > h6, .notification, .boxed > h6').ddFadeOnHover(.85);
				jQuery('.blog-widget-post a img').ddFadeOnHover(.8);
				jQuery('.button, .big-button').ddFadeOnHover(.9);
				jQuery('.ddflickr_widget li').ddFadeOthersOnHover(.6);
				jQuery('.dribbble-shots li').ddFadeOthersOnHover(.8);
				
				//// PRELOAD IMAGES
				jQuery('.imagePreload').each( function() { jQuery(this).ddImagePreload(); });
				
				//// IMAGE SLIDERS
				jQuery('.dd-image-slider').each( function() { jQuery(this).ddImageSlider(); });
				
				//// TABBED CONTENT
				jQuery('.dd-tab').each( function() { jQuery(this).ddTabs(); });
				
				//// TABBED CONTENT
				jQuery('.ddpricing').each( function() { jQuery(this).ddPricing(); });
				
				//// SLOGAN SLIDER
				jQuery('.ddslogan_slider').each( function() { jQuery(this).ddSloganSlider(); });
				
				//// CONTACT FORM
				jQuery('.ddcontact_form').each( function() { jQuery(this).ddContact(); });
				
				jQuery(\"a[rel^='prettyPhoto'], a[rel^='lightbox']\").prettyPhoto({
					
					theme: 'timeless',
					show_title: false,
					social_tools: ''
					
				});
				
				// IMAGE HOVER
				jQuery('.image-hover').each(function() { jQuery(this).ddImageHover('.55'); });
				
			});
			
			jQuery(window).load(function() {
				
				jQuery('.tooltip').each(function() { jQuery(this).ddTooltip(); });
				
			});
		
		</script>";
		
		echo $output;
		
	}
	
	
	
	////////////////////////////////////
	// NOW OUR SHORTCODES
	////////////////////////////////////
	
	//COLUMN TEMPLATE
	include('functions/columns/columns.php');
	
	//ROUNDED BUTTONS
	include('functions/buttons/buttons.php');
	
	//NOTIFICATIONS
	include('functions/notifications/notifications.php');
	
	//NOTIFICATIONS
	include('functions/boxed/boxed.php');
	
	//TOGGLE
	include('functions/toggle/toggle.php');
	
	//TOOLTIPS
	include('functions/tooltips/tooltips.php');
	
	//TOGGLE
	include('functions/tabs/tabs.php');
	
	//TOOLTIPS
	include('functions/frames/frames.php');
	
	//IMAGE SLIDER
	include('functions/slider/slider.php');
	
	//IMAGE SLIDER
	include('functions/icons/icons.php');
	
	//AUDIO & VIDEO
	include('functions/audioandvideo/audioandvideo.php');
	
	//SHARE
	include('functions/share/share.php');
	
	//LISTS
	include('functions/lists/lists.php');
	
	//PRICE TABLE
	include('functions/pricing/pricing.php');
	
	//TABLES
	include('functions/tables/tables.php');
	
	//Contact
	include('functions/contact/contact.php');
	
	//Contact
	include('functions/widgets/widgets.php');
	
	//TYPE
	include('functions/type/type.php');
	
	//GENERATOR
	include('functions/generator/functions.php');
	
	//GENERATOR
	include('functions/show_spots/show_spots.php');

?>