<?php

	////////////////////////////////////////////////
	// LET'S START LOADING OUR WORDPRESS STUFF
	include_once('../../../../../../../../wp-load.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert Button</title>
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/includes/bpanel/shortcodes/css/shortcodes_admin.css" media="screen" />
    
    <script type="text/javascript">
		
		
		//// INSERTS OUR SHORTCODE
		function insertShortcode() {
			
			// OUR FIELD VARS
			var f_text = jQuery('#text');
			var f_link = jQuery('#link');
			var f_color = jQuery('#color');
			var f_type = jQuery('#type');
			var f_target = jQuery('#target');
			var f_description = jQuery('#description');
			
			//// STARTS OUR SHORTCODE
			var short = '[button';
			
			//// OUR LINK FIELD
			if(f_link.val() != '') { short += ' link="'+f_link.val()+'"'; }
			else { short += ' link="#"'; }
			
			//// OUR COLOR FIELD
			if(f_color.val() != 'default') {short += ' color="'+f_color.children('option:selected').val()+'"'; }
			
			//// OUR TYPE FIELD
			if(f_type.val() == 'big-button') { short += ' type="'+f_type.children('option:selected').val()+'"'; }
			
			//// OUR DESCRIPTION FIELD
			if(f_type.children('option:selected').val() == 'big-button' && f_description.val() != '') { short += ' type="'+f_description.val()+'"'; }
			
			//// TARGET
			if(f_target.children('option:selected').val() != 'normal') { short += ' target="_blank"'; }
			
			//// OUR CONTENT AND CLOSES THE SHORTCODE
			short += ']'+f_text.val()+'[/button]';
			
			//// INSERTS IN THE EDITOR
			if(window.tinyMCE) {
				
				window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, short);
				//Peforms a clean up of the current editor HTML. 
				//tinyMCEPopup.editor.execCommand('mceCleanup');
				//Repaints the editor. Sometimes the browser has graphic glitches. 
				tinyMCEPopup.editor.execCommand('mceRepaint');
				tinyMCEPopup.close();
			
			}
			
			return;
			
		}
	
		jQuery(document).ready(function() {
			
			// INITIALLY SELECTED CONTENT
			selectedContent = tinyMCE.activeEditor.selection.getContent();
			
			// IF WE CLICK OUTSIDE WE CLOSE
			jQuery('#mceModalBlocker').click(function() { tinyMCEPopup.close(); });
			
			// OUR FIELD VARS
			var text = jQuery('#text');
			
			// INITAL STATES
			text.val(selectedContent);
			
		});
	
	</script>
    
</head>

<body>
    
    <div style="float: left; width: 100%; padding: 10px 0;">

        <div class="column-left">
        
            <div class="fieldset">
            
                <label for="text">Button Text</label>
                <input id="text" value="" type="text" />
                <em class="desc">The text of your button</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="link">Link</label>
                <input id="link" value="" type="text" />
                <em class="desc">The address your button links to.</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="color">Color</label>
                <select id="color">
                
                    <option value="default">Default Color</option>
                    <option value="grey">Grey</option>
                    <option value="blue">Blue</option>
                    <option value="light-blue">Light Blue</option>
                    <option value="dark-blue">Light Blue</option>
                    <option value="red">Red</option>
                    <option value="deep-red">Dark Red</option>
                    <option value="pink">Pink</option>
                    <option value="light-pink">Light Pink</option>
                    <option value="hot-pink">Hot Pink</option>
                    <option value="orange">Orange</option>
                    <option value="light-orange">Light Orange</option>
                    <option value="yellow">Yellow</option>
                    <option value="light-green">Light Green</option>
                    <option value="deep-green">Deep Green</option>
                    <option value="green">Green</option>
                    <option value="cream">Cream</option>
                    <option value="chocolate">Chocolate</option>
                    <option value="brown">Brown</option>
                    <option value="black">Black</option>
                    <option value="aqua">Aqua</option>
                    <option value="gold">Gold</option>
                    <option value="white">White</option>
                
                </select>
                <em class="desc">Your button color.<br />
                Use default to use the theme's default color.</em>
            
            </div>
            
        </div>
        <!-- /column-left/ -->
    
    	<div class="column-right">
        
            <div class="fieldset">
            
                <label for="type">Type</label>
                <select id="type">
                
                    <option value="normal">Normal</option>
                    <option value="big-button">Big (Description Optional)</option>
                
                </select>
                <em class="desc">Your button type.</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="description">Description (Big Button Only)</label>
                <input id="description" value="" type="text" />
                <em class="desc">Button Description in case you are using the Big Button.<br />
                Optional</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="target">Target</label>
                <select id="target">
                
                    <option value="normal">None (Opens in same window)</option>
                    <option value="_blank">_blank (Opens in new window)</option>
                
                </select>
                <em class="desc">Your button target.</em>
            
            </div>
            
        </div>
        <!-- /column-right/ -->
        
    </div>
            
    <div class="divider"></div>

    <div class="fieldset">
    
        <input type="button" value="Close" class="button white" style="float: left;" onclick="tinyMCEPopup.close();" />
        <input type="button" value="Insert" class="button blue" style="float: right;" onclick="insertShortcode();" />
        
    </div>

</body>