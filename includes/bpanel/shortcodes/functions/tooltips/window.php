<?php

	////////////////////////////////////////////////
	// LET'S START LOADING OUR WORDPRESS STUFF
	include_once('../../../../../../../../wp-load.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert a Tooltip</title>
    
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
			var f_position = jQuery('#position');
			var f_width = jQuery('#width');
			var f_fixed = jQuery('#fixed');
			var f_color = jQuery('#color');
			var f_text = jQuery('#text');
			var f_text_tooltip = jQuery('#text_tooltip');
			var f_width_tooltip = jQuery('#width_tooltip');
			
			//// STARTS OUR SHORTCODE
			var short = '[tooltip';
			
			//// TOOLTIP
			short += ' position="'+f_position.children('option:selected').val()+'"';
			
			//// WIDTH
			if(f_width.val() != '') { short += ' width="'+f_width.val()+'"'; }
			
			//// OUR TRIGGER
			short += "]	<p>"+f_text.val()+'</p>';
			
			//// tooltip content
			short += '	[tooltip_content color="'+f_color.children('option:selected').val()+'" fixed="'+f_fixed.children('option:selected').val()+'"';
			
			//// width
			if(f_width_tooltip.val() != '') { short += ' width="'+f_width_tooltip.val()+'"'; }
			
			//// toltip content
			short += "]"+f_text_tooltip.val()+'';
			
			//// closes it
			short += '     [/tooltip_content]<br>[/tooltip]';
			
			
			
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
            
                <label for="position">Tooltip Position</label>
                <select id="position">
                
                    <option value="top">Top</option>
                    <option value="bottom">Bottom</option>
                    <option value="left">Left</option>
                    <option value="right">Right</option>
                
                </select>
                <em class="desc">Position of your tooltip in relation to the tooltip trigger.</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="width">Trigger Width</label>
                <input id="width" value="" type="text" />
                <em class="desc">The width in pixels or % of your trigger.<br />This is automatic but if using boxes that need a specific width use this field.<br />
                i.e. When using a toggle as the trigger, use a 100% width to make sure your toggle occupies the whole space.</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="fixed">Fixed</label>
                <select id="fixed">
                
                    <option value="false">False</option>
                    <option value="true">True</option>
                
                </select>
                <em class="desc">Choose whether the tooltip should disappear on mouse out or to stay open.</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="color">Color</label>
                <select id="color">
                
                    <option value="default">Default Color</option>
                    <option value="grey">Grey</option>
                    <option value="blue">Blue</option>
                    <option value="light-blue">Light Blue</option>
                    <option value="dark-blue">Dark Blue</option>
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
                <em class="desc">Your tooltip color.</em>
            
            </div>
            
        </div>
        <!-- /column-left/ -->
    
    	<div class="column-right">
        
            <div class="fieldset">
            
                <label for="text">Tooltip Trigger</label>
                <textarea id="text" rows="6"></textarea>
                <em class="desc">This is what when it's hovered will trigger the tooltip.<br />
                Accepts Shortcodes</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="text_tooltip">Tooltip Content</label>
                <textarea id="text_tooltip" rows="6"></textarea>
                <em class="desc">This is what will show inside your tooltip.<br />
                Accepts Shortcodes</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="width_tooltip">Tooltip Width</label>
                <input id="width_tooltip" value="" type="text" />
                <em class="desc">Your tooltip width. This is not your trigger, this is your coloured box width.<br />
                 Leave blank to adjust automatically.</em>
            
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