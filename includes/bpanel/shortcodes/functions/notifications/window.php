<?php

	////////////////////////////////////////////////
	// LET'S START LOADING OUR WORDPRESS STUFF
	include_once('../../../../../../../../wp-load.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert Notification/Alert Box</title>
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/includes/bpanel/shortcodes/css/shortcodes_admin.css" media="screen" />
    
    <script type="text/javascript">
		
		
		//// INSERTS OUR SHORTCODE
		function insertShortcode() {
			
			//// IF IT'S THE NOTIFICATION BOX
			if(jQuery('#tabs > li.current').text() == 'Notification Box') {
			
				// OUR FIELD VARS
				var f_text = jQuery('#text-not');
				var f_color = jQuery('#color');
				
				//// STARTS OUR SHORTCODE
				var short = '[notification';
				
				//// OUR COLOR FIELD
				if(f_color.val() != 'default') {short += ' color="'+f_color.children('option:selected').val()+'"'; }
				
				//// OUR CONTENT AND CLOSES THE SHORTCODE
				short += ']'+f_text.val()+'[/notification]';
				
				//// INSERTS IN THE EDITOR
				if(window.tinyMCE) {
					
					window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, short);
					//Peforms a clean up of the current editor HTML. 
					//tinyMCEPopup.editor.execCommand('mceCleanup');
					//Repaints the editor. Sometimes the browser has graphic glitches. 
					tinyMCEPopup.editor.execCommand('mceRepaint');
					tinyMCEPopup.close();
				
				}
				
			} else {
				
				//// IF IT'S THE ALERT BOX	
			
				// OUR FIELD VARS
				var f_text = jQuery('#text-alert');
				var f_type = jQuery('#type');
				
				//// STARTS OUR SHORTCODE
				var short = '[alert_box';
				
				//// OUR COLOR FIELD
				short += ' type="'+f_type.children('option:selected').val()+'"';
				
				//// OUR CONTENT AND CLOSES THE SHORTCODE
				short += ']'+f_text.val()+'[/alert_box]';
				
				//// INSERTS IN THE EDITOR
				if(window.tinyMCE) {
					
					window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, short);
					//Peforms a clean up of the current editor HTML. 
					//tinyMCEPopup.editor.execCommand('mceCleanup');
					//Repaints the editor. Sometimes the browser has graphic glitches. 
					tinyMCEPopup.editor.execCommand('mceRepaint');
					tinyMCEPopup.close();
				
				}
				
			}
			
			return;
			
		}
	
		jQuery(document).ready(function() {
			
			// INITIALLY SELECTED CONTENT
			selectedContent = tinyMCE.activeEditor.selection.getContent();
			
			// IF WE CLICK OUTSIDE WE CLOSE
			jQuery('#mceModalBlocker').click(function() { tinyMCEPopup.close(); });
			
			// OUR FIELD VARS
			var textArea = jQuery('#text-not');
			var textArea2 = jQuery('#text-alert');
			
			// INITAL STATES
			textArea.val(selectedContent);
			textArea2.val(selectedContent);
			
			// TABS
			if(jQuery('#tabs').length > 0) {
				
				var tabsCont = jQuery('#tabs');
				var tabbedCont = jQuery('#tabbed');
				tabsCont.children('li:first').addClass('current');
				tabbedCont.children('li:first').addClass('current').show();
				
				tabsCont.children('li').click(function() {
					
					if(jQuery(this).attr('class') != 'current') {
					
						var itemClicked = jQuery(this).index();
						tabsCont.children('li.current').removeClass('current');
						jQuery(this).addClass('current');
						
						tabbedCont.children('li.current').removeClass('current').hide();
						tabbedCont.children('li:eq('+itemClicked+')').addClass('current').show();
					
					}
					
				});
				
			}
			
		});
	
	</script>
    
</head>

<body>
    
    <ul id="tabs">
    
        <li>Notification Box</li>
        <li>Alert Box</li>
        
    </ul>
    
    <ul id="tabbed">
    
    	<li>
    
            <div style="float: left; width: 100%; padding: 10px 0;">
        
                <div class="column-left">
                
                    <div class="fieldset">
                    
                        <label for="text-not">Notification Text</label>
                        <textarea id="text-not" name="text-not" cols="" rows="9"></textarea>
                        <em class="desc">The text that goes inside your notification box.<br />
                        Accepts shortcodes.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-left/ -->
            
                <div class="column-right">
                
                    <div class="fieldset">
                    
                        <label for="color">Color</label>
                        <select id="color">
                        
                            <option value="default">Default Color</option>
                            <option value="classic">Classic</option>
                            <option value="dark">Dark</option>
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
                        <em class="desc">Your notification BG color.<br />
                        Use default to use the theme's default color.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-right/ -->
                
            </div>
        
        </li>
    
    	<li>
    
            <div style="float: left; width: 100%; padding: 10px 0;">
        
                <div class="column-left">
                
                    <div class="fieldset">
                    
                        <label for="text-alert">Alert Box Text</label>
                        <textarea id="text-alert" name="text-alert" cols="" rows="9"></textarea>
                        <em class="desc">The text that goes inside your alert box.<br />
                        Accepts shortcodes.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-left/ -->
            
                <div class="column-right">
                
                    <div class="fieldset">
                    
                        <label for="type">Alert Type</label>
                        <select id="type">
                        
                            <option value="">None (White)</option>
                            <option value="success">Success (Green)</option>
                            <option value="error">Error (Red)</option>
                            <option value="attention">Attention (Yellow)</option>
                            <option value="info">Info (Blue)</option>
                        
                        </select>
                        <em class="desc">The type of alert box.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-right/ -->
                
            </div>
        
        </li>
        
    </ul>
            
    <div class="divider"></div>
        
    <div class="fieldset">
    
        <input type="button" value="Close" class="button white" style="float: left;" onclick="tinyMCEPopup.close();" />
        <input type="button" value="Insert" class="button blue" style="float: right;" onclick="insertShortcode();" />
        
    </div>

</body>