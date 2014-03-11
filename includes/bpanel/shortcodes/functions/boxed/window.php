<?php

	////////////////////////////////////////////////
	// LET'S START LOADING OUR WORDPRESS STUFF
	include_once('../../../../../../../../wp-load.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert a Boxed Content</title>
    
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
			var f_title = jQuery('#title');
			var f_text = jQuery('#text');
			var f_color = jQuery('#color');
			
			//// STARTS OUR SHORTCODE
			var short = '[boxed_content';
			
			//// OUR COLOR FIELD
			if(f_color.val() != 'default') {short += ' color="'+f_color.children('option:selected').val()+'"'; }
			
			//// OUR Title FIELD
			if(f_title.val() != '') { short += ' title="'+f_title.val()+'"'; } else { short += ' title="Box Title"'; }
			
			//// OUR CONTENT AND CLOSES THE SHORTCODE
			short += ']'+f_text.val()+'[/boxed_content]';
			
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
            
                <label for="title">Boxed Title</label>
                <input id="title" value="" type="text" />
                <em class="desc">Title of your boxed content</em>
            
            </div>
            
            <div class="divider"></div>
        
            <div class="fieldset">
            
                <label for="color">Color</label>
                <select id="color">
                
                    <option value="default">Default Color</option>
                    <option value="dark">Dark</option>
                    <option value="classic">Classic</option>
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
                <em class="desc">Your boxed content color.</em>
            
            </div>
            
        </div>
        <!-- /column-left/ -->
    
    	<div class="column-right">
        
            <div class="fieldset">
            
                <label for="text">Text Content</label>
                <textarea id="text" rows="7"></textarea>
                <em class="desc">The text that shows inside your boxed content.<br />
                Accepts Shortcodes</em>
            
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