<?php

	class add_DDShortsTabbed_button {
	
		var $pluginname = "ddshorts_tabbed";
		
		function add_DDShortsTabbed_button()  {
			
			// Modify the version when tinyMCE plugins are changed.
			add_filter('tiny_mce_version', array(&$this, 'change_tinymce_version') );
			
			// init process for button control
			add_action('init', array (&$this, 'addShortTabbed') );
			
		}
	
		function addShortTabbed() {
		
			// Don't bother doing this stuff if the current user lacks permissions
			if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
			
			// Add only in Rich Editor mode
			if ( get_user_option('rich_editing') == 'true') {
			 
				// add the button for wp2.5 in a new way
				add_filter("mce_external_plugins", array(&$this, "add_DDShortsTabbed_plugin" ), 5);
				add_filter('mce_buttons', array(&$this, 'register_DDShortsTabbed_button' ), 5);
				
			}
		}
		
		// used to insert button in wordpress 2.5x editor
		function register_DDShortsTabbed_button($buttons) {
		
			array_push($buttons, "", $this->pluginname );
			return $buttons;
			
		}
		
		// Load the TinyMCE plugin : (wp2.5)
		function add_DDShortsTabbed_plugin($plugin_array) {    
		
			$plugin_array[$this->pluginname] =  get_template_directory_uri().'/includes/bpanel/shortcodes/functions/tabbed/tabbed.js';
			return $plugin_array;
			
		}
		
		function change_tinymce_version($version) {
			return ++$version;
		}
		
	}

	// Call it now
	$tinymce_button = new add_DDShortsTabbed_button ();


?>