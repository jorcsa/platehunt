<?php
/**
 * This file is has all the hooks we use throughout the theme
 *
 * @author BTOA
 * @version 1.35.3
 */
 
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!is_admin() || defined('DOING_AJAX')) {
	
	//// LETS GET OUR FUNCTIONS BEFORE CALLING OUR HOOKS
	include_once(locate_template('includes/templates/templates.php'));

	/**
	 * Registration Form in Login Page
	 *
	 * @see templates/spots/markup-login-user-registration.php
	 */
	add_action('sf_login_user_registration', 'sf_template_registration_form', 10);
	
	//add_action('init', 'sf_template_registration_form_add');
	//function sf_template_registration_form_add() { add_action('sf_login_user_registration', 'sf_template_registration_form', 10); }
	
}
 	
 
?>