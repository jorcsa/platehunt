<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('pricetable', 'ddshort_pricetable');
	add_shortcode('pricetable_column', 'ddshort_pricetable_column');
	add_shortcode('pricetable_features', 'ddshort_pricetable_features');
	
	//Our Funciton
	function ddshort_pricetable($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'columns' => '4'
		
		), $atts));
		
		if($columns == 3) { $class = 'one-third'; }
		if($columns == 4) { $class = 'one-fourth'; }
		if($columns == 5) { $class = 'one-fifth'; }
		if($columns == 6) { $class = 'one-sixth'; }
		
		$return = '<div class="ddpricing '.$class.'">';
		
		$return .= do_shortcode($content);
		
		$return .= '</div>';
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_pricetable_column($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
		'category' => '',
		'special' => '',
		'price' => '',
		'symbol' => '$',
		'cents' => '00',
		'message' => '',
		'link' => '#',
		'button' => 'Purchase it',
		
		), $atts));
		
		////STARTS OUR OUTPUT
		$output = '<div class="ddpricing-col';
		
		////CHECK IF ITS SPECIAL
		if($special != '') { $output .= ' ddpricing-special'; }
		
		//// CLOSES DIV
		$output .= '">';
		
		$output .= '<div class="ddpricing-head">';
		
		////CATEGORY
		if($category != '') { $output .= '<span class="ddpricing-cat">'.$category.'</span>'; }
		
		//// PRICES
		$output .= '<span class="ddpricing-price">
            
            	<span class="ddpricing-price-symbol">'.$symbol.'</span>
                '.$price.'
                <span class="ddpricing-price-cents">,'.$cents.'</span>
            
            </span>';
			
		//// MESSAGE
		if($message != '') { $output .= '<span class="ddpricing-message">'.$message.'</span>'; }
		
		////PRICE BODY
		$output .= '
            
            <span class="ddpricing-arrow"></span>
        
        </div>
        <!-- /pricing head/ -->
        
        <div class="ddpricing-body">';
		
		//// BODY CONTENT
		$output .= do_shortcode($content);
		
		//// CLOSES CONTENT AND STARTS BUTTON
		$output .= '</div>
        <!-- /pricing body/ -->
        
        <a href="'.$link.'" class="ddpricing-button">'.$button.'</a>
    
    </div>
    <!-- /column/ -->';

		//// SHOWS OUTPUT
		return $output;
		
	}
	
	//Our Funciton
	function ddshort_pricetable_features($atts, $content = null) {
		
		return '<ul>'.$content.'</ul>';
		
	}

?>