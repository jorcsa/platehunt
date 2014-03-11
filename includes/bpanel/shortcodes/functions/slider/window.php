<?php

	////////////////////////////////////////////////
	// LET'S START LOADING OUR WORDPRESS STUFF
	include_once('../../../../../../../../wp-load.php');
	require_once('../../../../../includes/bpanel/bpanel-ajax-upload.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Insert Image Slider / Slides</title>
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo home_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/ddpanel/js/ajaxupload.js"></script>
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/includes/bpanel/shortcodes/css/shortcodes_admin.css" media="screen" />
    
    <script type="text/javascript">
		
		
		//// INSERTS OUR SHORTCODE
		function insertShortcode() {
			
			var short = '';
			
			//// IF IT'S THE NOTIFICATION BOX
			if(jQuery('#tabs > li.current').text() == 'Main Slider') {
			
				// OUR FIELD VARS
				var f_width = jQuery('#width').val();
				var f_height = jQuery('#height').val();
				var f_thumbnails = jQuery('#thumbnails');
				var f_autoslide = jQuery('#autoslide').val();
				
				//// STARTS OUR SHORTCODE
				short += '[image_slider';
				
				//// WIDTH
				if(f_width != '') { short += ' width="'+f_width+'"'; }
				else { short += ' width="900"'; }
				
				//// HEIGHT
				if(f_height != '') { short += ' height="'+f_height+'"'; }
				else { short += ' height="300"'; }
				
				//// THUMBS
				short += ' thumbnails="'+f_thumbnails.children('option:selected').val()+'"';
				
				//// AUTOSLIDE
				if(f_autoslide != '') { short += ' autoslide="'+f_autoslide+'"'; }
				
				//// CLOSES
				short += ']<br><br>';
				
			}
			
				//// NOW WE MAKE UP OUR SLIDE ITEM CONTENT
			
				// OUR FIELD VARS
				var f_image = jQuery('#image').val();
				var f_title = jQuery('#title').val();
				var f_description = jQuery('#description').val();
				var f_link = jQuery('#link').val();
				var f_type = jQuery('#type');
				var f_slide_width = jQuery('#slide_width').val();
				var f_slide_height = jQuery('#slide_height').val();
				
				//// STARTS LSIDE ITEM
				short += '[slide_item';
				
				//// TITLE AND DESC
				if(f_title != '') { short += ' title="'+f_title+'"'; }
				if(f_description != '') { short += ' description="'+f_description+'"'; }
				
				//// TYPE AND LINK
				if(f_link != '') { short += ' link ="'+f_link+'"'; }
				else { short += ' link ="#"'; }
				
				short += ' type="'+f_type.children('option:selected').val()+'"';
				
				//// WIDTH
				if(f_slide_width != '') { short += ' width="'+f_slide_width+'"'; }
				
				//// HEIGHT
				if(f_slide_height != '') { short += ' height="'+f_slide_height+'"'; }
				
				//// CLOSES IT
				short += ']<br>'+f_image+'<br>[/slide_item]';
				
			if(jQuery('#tabs > li.current').text() == 'Main Slider') {
				
				//closes image_slider tag
				short += '<br><br>[/image_slider]';	
				
			}
				
				
				
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
    
        <li>Main Slider</li>
        <li>Individual Slide</li>
        
    </ul>
    
    <ul id="tabbed">
    
    	<li>
        
        	<p style="padding: 0 10px; color: #666;"><em><strong>Note</strong>: Inserting the shortcode from this tab will insert the main slider shortcode ([image_slider]) as well as a slide_item from the other tab.<br />
            To insert just one individual slide, use the other tab and click the button from that tab.</em></p>
            
            <div class="divider"></div>
    
            <div style="float: left; width: 100%; padding: 10px 0;">
        
                <div class="column-left">
                
                    <div class="fieldset">
                    
                        <label for="width">Slider Width</label>
                        <input type="text" id="width" value="" />
                        <em class="desc">Width of your slider in pixels. Use only numbers.<br />
                        This is the total width of your slider.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="height">Slider Height</label>
                        <input type="text" id="height" value="" />
                        <em class="desc">Height of your slider in pixels. Use only numbers.<br />
                        This is the total height of your slider.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-left/ -->
            
                <div class="column-right">
                
                    <div class="fieldset">
                    
                        <label for="thumbnails">Thumbnails Selector</label>
                        <select id="thumbnails">
                        
                            <option value="true">True</option>
                            <option value="false">False</option>
                        
                        </select>
                        <em class="desc">Whether to show the thumbnails slider or not.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="autoslide">Auto Slide Delay</label>
                        <input type="text" id="autoslide" value="" />
                        <em class="desc">Insert here the delay in miliseconds for your autoslide.<br />
                        Leave blank to disable autoslide.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-right/ -->
                
            </div>
                
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p><br />
        
        </li>
    
    	<li>
    
            <div style="float: left; width: 100%; padding: 10px 0;">
        
                <div class="column-left">
        
                    <p style=" padding: 0 15px; color: #666;"><em><strong>Note</strong>: Inserting the shortcode from this tab will only insert one individual [slide_item] shortcode. If you haven't inserted the main image_slider shortcode, please click the Insert button from the previous tab.</em></p>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="image">Full Size Image Url</label>
                        <input type="text" id="image" value="" />
                        <em class="desc">Insert the URL of your full image. Thumbnails are generated automatically from this image.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="title">Slide Title <em>(Optional)</em></label>
                        <input type="text" id="title" value="" />
                        <em class="desc">The title of your slide appears ath the bottom left of your full size image.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="description">Slide Description <em>(Optional)</em></label>
                        <input type="text" id="description" value="" />
                        <em class="desc">Description of your slide. This shows at the bottom left under your title in a smaller size.</em>
                    
                    </div>
                    
                </div>
                <!-- /column-left/ -->
            
                <div class="column-right">
                
                    <div class="fieldset">
                    
                        <label for="type">Link Type</label>
                        <select id="type">
                        
                            <option value="lightbox">Lightbox</option>
                            <option value="link">Link</option>
                        
                        </select>
                        <em class="desc">Whether to open the link you have typed in a lightbox (for full size images) or in a new page (images, page, websites etc).</em>
                        
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="link">Link</label>
                        <input type="text" id="link" value="" />
                        <em class="desc">The URL where your slide will lead to. If you don't want your slide to go lead anywhere use #</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="slide_width">Width <em>(Optional)</em></label>
                        <input type="text" id="slide_width" value="" />
                        <em class="desc">An optional width in case you want to use timthumb to crop your image. Needs Height to be set as well.</em>
                    
                    </div>
                    
                    <div class="divider"></div>
                
                    <div class="fieldset">
                    
                        <label for="slide_height">Height <em>(Optional)</em></label>
                        <input type="text" id="slide_height" value="" />
                        <em class="desc">An optional height in case you want to use timthumb to crop your image. Needs Width to be set as well.</em>
                    
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