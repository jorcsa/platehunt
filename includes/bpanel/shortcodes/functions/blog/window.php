<?php
	
	
	$curUrl = $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
	$myUrl = explode('/', $curUrl);
	$remove = count($myUrl)-8;
	$root = 'http://';
	for($i = 0; $i < $remove; $i++) {
		$root .= $myUrl[$i].'/';
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Insert Contact Form</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo $root; ?>wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $root; ?>wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $root; ?>wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $root; ?>wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
	}
	
	function insertShortcode() {
		
		var tagtext;
		var selectedContent = tinyMCE.activeEditor.selection.getContent();
		var lists_bt = document.getElementById('lists_panel');
		
		// who is active ?
		if (lists_bt.className.indexOf('current') != -1) {
			
			var category = document.getElementById('category').value;
			var count = document.getElementById('count').value;
			var columns = document.getElementById('columns').value;
			var read_more = document.getElementById('read_more').value;
			var desc_len = document.getElementById('desc_len').value;
			var thumb = document.getElementById('thumb').value;
			var thumb_width = document.getElementById('thumb_width').value;
			var thumb_height = document.getElementById('thumb_height').value;
			
				tagtext = '[latest_blog';
				
				if(category != '') { tagtext += ' category="'+category+'"'; } else { tagtext += ' category="all"'; }
				
				if(count != '') { tagtext += ' count="'+count+'"'; }
				
				if(columns != '') { tagtext += ' columns="'+columns+'"'; }
				
				if(thumb != '') { tagtext += ' thumb="'+thumb+'"'; } else { tagtext += ' thumb="true"'; }
				
				if(thumb_width != '') { tagtext += ' thumb_width="'+thumb_width+'"'; }
				
				if(thumb_height != '') { tagtext += ' thumb_height="'+thumb_height+'"'; }
				
				if(read_more != '') { tagtext += ' read_more="'+read_more+'"'; } else { tagtext += ' read_more=""'; }
				
				if(desc_len != '') { tagtext += ' desc_len="'+desc_len+'"'; }
				
				tagtext += '] ';
				
		}
	
		
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
	</script>
	<base target="_self" />
    
	<style type="text/css">
	
    label span { color: #f00; }
	
    </style>
    
</head>
<body onload="init();">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="DDShortcodes" action="#">
	<div class="tabs">
		<ul>
			<li id="lists_tab" class="current"><span><a href="javascript:mcTabs.displayTab('lists_tab','lists_panel');" onmousedown="return false;">Contact Form</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper" style="height: 640px;">
    
		<!-- small panel -->
		<div id="lists_panel" class="panel current" style="height: 640px;">
        
        <fieldset style="padding-left: 15px;">
        
            <legend>Options:</legend>
            
            <br />
        
            <table border="0" cellpadding="4" cellspacing="0">
            
                 <tr>
                 
                    <td nowrap="nowrap"><label for="category">Category:</label></td>
                    
                    <td>
                    
                        <input type="text" name="category" id="category" style="width: 230px" />
                    
                    </td>
                    
                  </tr>
                  
              </table>
                        
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 63px;">Category to get your posts from</em><br />
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 63px;">Leave blank to show all.</em>
            <br /><br />
        
            <table border="0" cellpadding="4" cellspacing="0">
            
                 <tr>
                 
                    <td nowrap="nowrap"><label for="count">Posts no:</label></td>
                    
                    <td>
                    
                        &nbsp;<input type="text" name="count" id="count" style="width: 230px" />
                    
                    </td>
                    
                  </tr>
                  
              </table>
                        
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 63px;">Number of posts to display.</em><br />
            <br /><br />
        
            <table border="0" cellpadding="4" cellspacing="0">
            
                 <tr>
                 
                    <td nowrap="nowrap"><label for="columns">Columns:</label></td>
                    
                    <td>
                    
                        &nbsp;<select name="columns" id="columns" style="width: 230px">
                        
                        	<option value="4">4 Columns</option>
                        	<option value="2">2 Columns</option>
                        	<option value="3">3 Columns</option>
                        	<option value="5">5 Columns</option>
                        	<option value="6">6 Columns</option>
                        
                        </select>
                    
                    </td>
                    
                  </tr>
                  
              </table>
                        
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 63px;">Number of columns. Fits to width.</em><br />
            <br />
        
            <table border="0" cellpadding="4" cellspacing="0">
            
                 <tr>
                 
                    <td nowrap="nowrap"><label for="read_more">Read More:</label></td>
                    
                    <td>
                    
                        <input type="text" name="read_more" id="read_more" style="width: 222px" />
                    
                    </td>
                    
                  </tr>
                  
              </table>
                        
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 68px;">Read More Text. Blank to not show.</em><br />
            <br /><br />
        
            <table border="0" cellpadding="4" cellspacing="0">
            
                 <tr>
                 
                    <td nowrap="nowrap"><label for="desc_len">Content:</label></td>
                    
                    <td>
                    
                        &nbsp;<input type="text" name="desc_len" id="desc_len" style="width: 230px" />
                    
                    </td>
                    
                  </tr>
                  
              </table>
                        
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 63px;">After how many words to cut. Recomm. 20</em><br />
            <br /><br />
        
        </fieldset>
        
        <br /><br />
        
        <fieldset style="padding-left: 15px;">
        
            <legend>Thumbnail:</legend>
            
            <br />
        
            <table border="0" cellpadding="4" cellspacing="0">
            
                 <tr>
                 
                    <td nowrap="nowrap"><label for="thumb">Thumbnail:</label></td>
                    
                    <td>
                    
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="thumb" id="thumb" style="width: 200px">
                        
                        	<option value="true">Show Thumbnail</option>
                        	<option value="false">Do Not Show</option>
                        
                        </select>
                    
                    </td>
                    
                  </tr>
                  
              </table>
                        
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 93px;">Number of posts to display.</em><br />
            <br /><br />
        
            <table border="0" cellpadding="4" cellspacing="0">
            
                 <tr>
                 
                    <td nowrap="nowrap"><label for="thumb_width">Thumb Width:</label></td>
                    
                    <td>
                    
                        &nbsp;&nbsp;<input type="text" name="thumb_width" id="thumb_width" style="width: 200px" />
                    
                    </td>
                    
                  </tr>
                  
              </table>
                        
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 93px;">Thumbnail Width. Leave blank if unsure.</em><br />
            <br /><br />
        
            <table border="0" cellpadding="4" cellspacing="0">
            
                 <tr>
                 
                    <td nowrap="nowrap"><label for="thumb_height">Thumb Height:</label></td>
                    
                    <td>
                    
                        &nbsp;&nbsp;<input type="text" name="thumb_height" id="thumb_height" style="width: 200px" />
                    
                    </td>
                    
                  </tr>
                  
              </table>
                        
            <em style="font-size: 9px; color: #999999; padding: 5px 0 0 93px;">Thumbnail Height. Leave blank if unsure.</em><br />
            <br /><br />
            
            </fieldset>
            
		</div>
		<!-- end small panel -->
		
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onclick="insertShortcode();" />
		</div>
	</div>
</form>
</body>
</html>
<?php

?>
