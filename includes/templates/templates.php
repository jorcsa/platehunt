<?php
/**
 * This file is hooked to our functions.php file. it adds all the functions to our hooks throughout the theme
 *
 * @author BTOA
 * @version 1.35.3
 */
 
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!is_admin() || defined('DOING_AJAX')) {
	
	/// STARTS OUR FUNCTIONS TO BE ADDED AS HOOKS
	
	if (!function_exists('sf_template_registration_form')) {
	
		/**
		 * Shows our registration form in login page
		 *
		 * @access public
		 * @return void
		 */
		function sf_template_registration_form() {
			get_template_part('includes/templates/spots/markup-login-user-registration');
		}
	}
	
}
 	
 
?>