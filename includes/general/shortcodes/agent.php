<?php


	
	//// OUR HOOK
	add_shortcode('agent', 'btoa_show_agent');
	
	
	//// OUR FUNCTION
	function btoa_show_agent($atts, $content = null) {
		
		//global $post;
		
		extract(shortcode_atts(array(
		
			'name' => '',
		
		), $atts));
		
		//// IF WE HAVE A NAME AND ITS FOUND
		if($agent = get_page_by_title($name, 'OBJECT', 'agent')) {
			
			$output = '<div class="agent">';
			
			$featured = getFeaturedImage($agent->ID);
			
			$output .= '<div class="one-fifth"><img src="'.ddTimthumb($featured[0], 300).'" title="'.$agent->post_title.'" alt="'.$agent->post_title.'" /></div>';
			
			$output .= '<div class="three-fifths"><h3>'.$agent->post_title.'</h3>'.apply_filters('the_content', $agent->post_content).'</div>';
			
			$output .= '<div class="one-fifth last">';
			
			if(get_post_meta($agent->ID, 'position', true)) { $output .= '<h4>'.get_post_meta($agent->ID, 'position', true).'</h4>'; }
			
			if(get_post_meta($agent->ID, 'phone', true)) { $output .= '<p><strong>'.__('Phone:', 'btoa').'</strong><br>'.get_post_meta($agent->ID, 'phone', true).'</p>'; }
			
			if(get_post_meta($agent->ID, 'email', true)) { $output .= '<p><strong>'.__('Email:', 'btoa').'</strong><br>'.get_post_meta($agent->ID, 'email', true).'</p>'; }
			
			$output .= '</div><div class="clear"></div>';
			
			$output .= '</div>';
			
		}
		
		
		//// returns the output
		return $output;
		
	}


?>