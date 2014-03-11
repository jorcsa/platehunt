<?php

	
	
	//REGISTER OUR MAIN BAR MENUS
	add_action( 'init', 'register_main_bar_menus' );
	
	function register_main_bar_menus() {
		
		//// MAIN MENU
		register_nav_menu('main_bar_menu', 'Main Bar Menu');
		
	}
	
	
	
?>