<?php

	/////////////////////////////////////////////////
	// LET'S START LOADING OUR WORDPRESS STUFF
	include_once('../../../../../../../../wp-load.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert a Toggle</title>
    
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
			var f_email = jQuery('#email');
			var f_message = jQuery('#thank');
			
			//// STARTS OUR SHORTCODE
			var short = '[contact_form';
			
			if(f_email.val() != '') { short += ' to="'+f_email.val()+'"]'; }
			
			short += f_message.val();
			
			short += '[/contact_form]';
			
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
            
                <label for="thank">Thank You Message</label>
                <textarea id="thank" rows="8"></textarea>
                <em class="desc">The message that appears after the message has been sent. Accepts HTML and shortcodes.<br />
                Accepts Shortcodes</em>
            
            </div>
            
        </div>
        <!-- /column-left/ -->
    
    	<div class="column-right">
        
            <div class="fieldset">
            
                <label for="email">Email address to send message to:</label>
                <input id="email" value="" type="text" />
                <em class="desc">This is the email your message will be sent to. Leave blank to use the wordpress admin's email.</em>
            
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