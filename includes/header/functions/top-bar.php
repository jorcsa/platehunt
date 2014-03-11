<?php
	
	
	
	
	class menu_mobile_walker extends Walker_Nav_Menu
	{
		  function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
		  {
			  
			   global $wp_query;
	
			   if($depth != 0)
			   {
						 $description = $append = $prepend = "";
			   }
				
				if($depth > 0) {
					$title = '&mdash; '.$args->link_before.apply_filters( 'the_title', $item->title, $item->ID );
				} else {
					$title = $args->link_before.apply_filters( 'the_title', $item->title, $item->ID );
				}
				
				$item_output = '<option value="'.esc_attr( $item->url).'">'.$title.'</option>';
				
	
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
				
				}
	}
	
	
	
?>