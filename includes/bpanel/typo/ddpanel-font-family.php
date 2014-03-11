<?php
	
	//starts our output
	$output .= '
	
		<div class="ddpanel-fonts">
                                        
			<div class="ddpanel-block ddblock-select" id="block-'.($i+1).'">
			
				<label for="ddp_heading_styling">Font Styling:</label>
				
				<div class="ddpanel-select">
				
					<span class="ddPanel-button"></span>
					<span class="current-select"></span>
					
					<ul>
					
						<li>Cufon</li>
					
						<li>Google Fonts</li>
					
						<li>Font-Family</li>
					
						<li>Use Default</li>
					
					</ul>
				
				</div>
				<!-- /.ddpanel-select/ -->
				
				<input type="hidden" id="ddp_heading_styling" name="ddp_heading_styling" value="'.ddp('heading_styling').'">
				<span class="help"></span>
				<span class="help-text">Choose the type of font styling to be used on your heading text.</span>
			
			</div>
                                        
			<div class="ddpanel-block ddblock-upload ddpanel-font-cufon" id="block-'.($i+2).'">
			
				<label for="ddp_heading_cufon">Cufon Font Uploader:</label>
				<input type="text" class="ddpanel-upload" id="ddp_heading_cufon" value="'.ddp('heading_cufon').'" name="ddp_heading_cufon" />
				<input type="button" id="uploadFont" class="ddpanel-upload-font" value="" />
				<span class="help"></span>
				<span class="help-text">Uploadd your cufon .js font. If you don\'t have one, please generate one <a href="http://cufon.shoqolate.com/">here</a>.</span>
			
			</div>
                                        
			<div class="ddpanel-block ddblock-text ddpanel-font-cufon" id="block-'.($i+3).'">
			
				<label for="ddp_heading_cufon_adv">Advanced Cufon Settings:</label>
				<textarea id="ddp_heading_cufon_adv" name="ddp_heading_cufon_adv" class="ddpanel-textarea" rows="" cols="">'.ddp('heading_cufon_adv').'</textarea>
				<span class="help"></span>
				<span class="help-text">Insert here the jQuery activator for Cufon. If nothing is set, vufon will be applied to all heading tags.<br>Visit <a href="http://github.com/sorccu/cufon/wikis">Cufon Documentation</a> for more info</span>
			
			</div>
                                        
			<div class="ddpanel-block ddblock-select ddpanel-font-google" id="block-'.($i+4).'">
			
				<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.ddp('heading_google').'" id="googleFont">
			
				<label for="ddp_heading_google">Google Font Name:</label>
				
				<input type="text" id="ddp_heading_google" name="ddp_heading_google" class="ddpanel-input" value="'.ddp('heading_google').'" style="font-size: 18px; font-family: \''.ddp('heading_google').'\';" onchange="googleFontInput(jQuery(this));">
				<span class="help"></span>
				<span class="help-text">Type in the name of the google font that you desire. For a list of fonts please <a href="http://code.google.com/webfonts">visit this website.</a></span>
			
			</div>
                                        
			<div class="ddpanel-block ddblock-text ddpanel-font-family" id="block-'.($i+5).'">
			
				<label for="ddp_heading_font_family">Font-Family:</label>
				
				<div class="ddpanel-select ddpanel-font-family-select">
				
					<span class="ddPanel-button"></span>
					<span class="current-select"></span>
					
					<ul>
					
						<li>\'Century Gothic\', Helvetica, Arial, sans-serif</li>
					
						<li>Arial, Helvetica, sans-serif</li>
					
						<li>Verdana, Geneva, sans-serif</li>
					
						<li>Georgia, \'Times New Roman\', Times, serif</li>
					
						<li>Tahoma, Geneva, sans-serif</li>
					
						<li>\'Trebuchet MS\', Arial, Helvetica, sans-serif</li>
					
						<li>\'Times New Roman\', Times, serif</li>
					
						<li>\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif</li>
					
						<li class="custom-font-family">Custom</li>
					
					</ul>
				
				</div>
				<!-- /.ddpanel-select/ -->
				
				<input type="hidden" class="ddpanel-input" id="ddp_heading_font_family" value="'.ddp('heading_font_family').'" name="ddp_heading_font_family" />
				<span class="help"></span>
				<span class="help-text">Font family of your headings.</span>
			
			</div>
		
			<div class="ddpanel-block ddblock-input ddpanel-font-family-custom" id="block-'.($i+6).'">
			
				<label for="ddp_heading_font_custom">Custom Font-Family</label>
				<input type="text" class="ddpanel-input" id="ddp_heading_custom" value="'.ddp('heading_custom').'" name="ddp_heading_custom" />
				<span class="help"></span>
				<span class="help-text">Type in your custom font-family.</span>
			
			</div>
			
		</div>
	';
	
	$i++;
	$i++;
	$i++;
	$i++;
	$i++;
	$i++;

?>