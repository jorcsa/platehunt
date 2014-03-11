<?php

	////////////////////////////////////////////////
	// LET'S START LOADING OUR WORDPRESS STUFF
	include_once('../../../../../../../../wp-load.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert Video or Audio</title>
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/ddpanel/shortcodes/css/shortcodes_admin.css" media="screen" />
    
    <script type="text/javascript">
		
		
		//// INSERTS OUR SHORTCODE
		function insertShortcode() {
			
			//// IF IT'S THE NOTIFICATION BOX
			if(jQuery('#tabs > li.current').text() == 'HTML 5 Video') {
			
				// OUR FIELD VARS
				var f_file = jQuery('#html5_file_url').val();
				var f_poster = jQuery('#html5_poster_url').val();
				var f_width = jQuery('#html5_width').val();
				var f_height = jQuery('#html5_height').val();
				
				//// STARTS OUR SHORTCODE
				short = '[video_html5';
				
				//// video url
				short += ' file="'+f_file+'"';
				
				//// poster url
				if(f_poster != '') { short += ' poster="'+f_poster+'"'; }
				
				//// poster url
				if(f_width != '') { short += ' width="'+f_width+'"'; }
				
				//// poster url
				if(f_height != '') { short += ' height="'+f_height+'"'; }
				
				short += ']';
				
				//// INSERTS IN THE EDITOR
				if(window.tinyMCE) {
					
					window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, short);
					//Peforms a clean up of the current editor HTML. 
					//tinyMCEPopup.editor.execCommand('mceCleanup');
					//Repaints the editor. Sometimes the browser has graphic glitches. 
					tinyMCEPopup.editor.execCommand('mceRepaint');
					tinyMCEPopup.close();
				
				}
				
			} else if(jQuery('#tabs > li.current').text() == 'Video') {
			
				// OUR FIELD VARS
				var f_file = jQuery('#video_id').val();
				var f_type = jQuery('#type').children('option:selected').val();
				var f_width = jQuery('#width').val();
				var f_height = jQuery('#height').val();
				
				//// STARTS OUR SHORTCODE
				short = '[video';
				
				//// video url
				short += ' video_id="'+f_file+'"';
				
				//// video url
				short += ' type="'+f_type+'"';
				
				//// poster url
				if(f_width != '') { short += ' width="'+f_width+'"'; }
				
				//// poster url
				if(f_height != '') { short += ' height="'+f_height+'"'; }
				
				short += ']';
				
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
			
				// OUR FIELD VARS
				var f_file = jQuery('#mp3_file').val();
				
				//// STARTS OUR SHORTCODE
				short = '[audio';
				
				//// video url
				short += ' file="'+f_file+'"';
				
				short += ']';
				
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
    
    	<li>HTML 5 Video</li>
    	<li>Video</li>
    	<li>Audio</li>
        
    </ul>
    
    <ul id="tabbed">
    
    	<li>
    
            <div style="float: left; width: 100%; padding: 10px 0;">
        
                <div class="column-left">
                
                    <div class="fieldset">
                    
                        <label for="html5_file_url">.mp4 File URL</label>
                        <input id="html5_file_url" name="html5_file_url" value="" />
                        <em class="desc">The URL of your .mp4 file. User absolute paths.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="html5_poster_url">Preview Image URL</label>
                        <input id="html5_poster_url" name="html5_poster_url" value="" />
                        <em class="desc">The preview image URL of your video.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-left/ -->
            
                <div class="column-right">
                
                    <div class="fieldset">
                    
                        <label for="html5_width">Video Width</label>
                        <input id="html5_width" name="html5_width" value="" />
                        <em class="desc">Width of your video in pixels.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="html5_height">Video Height</label>
                        <input id="html5_height" name="html5_height" value="" />
                        <em class="desc">Height of your video in pixels.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-right/ -->
                
            </div>
        
        </li>
    
    	<li>
    
            <div style="float: left; width: 100%; padding: 10px 0;">
        
                <div class="column-left">
                
                    <div class="fieldset">
                    
                        <label for="type">Video Type</label>
                        <select name="type" id="type">
                        
                        	<option value="youtube">Youtube</option>
                        	<option value="vimeo">Vimeo</option>
                        	<option value="dailymotion">DailyMotion</option>
                        
                        </select>
                        <em class="desc">The URL of your .mp4 file. User absolute paths.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="video_id">Video ID</label>
                        <input id="video_id" name="video_id" value="" />
                        <em class="desc">Your Video Id. Get this from the video's page URL.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-left/ -->
            
                <div class="column-right">
                
                    <div class="fieldset">
                    
                        <label for="width">Video Width</label>
                        <input id="width" name="width" value="" />
                        <em class="desc">Width of your video in pixels.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="height">Height</label>
                        <input id="height" name="height" value="" />
                        <em class="desc">Height of your video in pixels.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-right/ -->
                
            </div>
        
        </li>
        
        <li>
    
            <div style="float: left; width: 100%; padding: 10px 0;">
            
                <div class="column-right" style="float: left;">
                
                    <div class="fieldset">
                    
                        <label for="mp3_file">.mp3 File URL</label>
                        <input id="mp3_file" name="mp3_file" value="" />
                        <em class="desc">Your audio file URL. Use absolute paths.</em>
                    
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