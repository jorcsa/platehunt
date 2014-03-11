<?php

	//// OUR VARIABLE
	$page_sidebar = get_post_meta($post->ID, 'page_sidebar', true);
	$layout = ddp('sidebar_default');

?>

<script type="text/javascript" charset="utf-8">

	jQuery(document).ready(function() {
		
		jQuery('#page_sidebar').ddSelectReplace();
		
		jQuery('#page_sidebar').change(function() {
			
			if(jQuery(this).children('option:selected').text() == '(add new custom sidebar)') {
			
				jQuery('#add_custom_sidebar').show();
				jQuery(this).children('option:selected').removeAttr('selected');
				jQuery(this).children('option:first').attr('selected', 'selected');
				jQuery(this).updateDDSelectReplace();
			
			}
			
		});
		
		//WHEN USER CLICKS TO ADD A SIDEBAR
		jQuery('#add_custom_sidebar_button').click(function() {
			
			var buttonCont = jQuery(this);
			
			//empty all errors
			buttonCont.parent().parent().children('.ddError').remove();
			
			//gets the input value
			var newSidebarName = jQuery('#new_sidebar_name').val();
			
			// If it's empty
			if(newSidebarName == '') {
				
				buttonCont.parent().before('<p class="ddError">Please enter a name for your sidebar.</p>');
				buttonCont.parent().parent().children('.ddError').css({ display: 'none' }).fadeIn(300);
				
			} else {
			
				//disbales it
				buttonCont.attr('disabled', 'disabled');
				
				//adds the loading gif
				buttonCont.before('<span class="loading-gif"></span>');
				buttonCont.siblings('.loading-gif').css({ display: 'none' }).fadeIn(300);
				
				// LET'S PROCESS THE REQUEST
				jQuery.ajax({
					
					type: 		'POST',
					url: 		'<?php echo get_template_directory_uri().'/includes/backend/php/add-sidebar.php'; ?>',
					dataType: 	'json',
					data: {
					
						sidebar_name: newSidebarName
						
					},
					success: function(data) {
						
						// IF THERE'S NO ERRORS
						if(data.error == false) {
							
							/// SLIDES ALL UP
							buttonCont.parent().parent().slideUp(200);
							
							//removes loading and puts button back to normal
							buttonCont.removeAttr('disabled').siblings('.loading-gif').fadeOut(200, function() { jQuery(this).remove(); });
							
							// gets the current options so we can add the new option
							var optionArr = new Array();
							var i = 1;
							buttonCont.parent().parent().parent().children('.select-metabox').children('span').children('select').children('option:last').before('<option value="'+data.sidebar_name+'" selected="selected">'+data.sidebar_name+'</option>');
							
							//updates the items
							buttonCont.parent().parent().parent().children('.select-metabox').children('span').children('select').updateDDSelectReplace();
							
							
						} else {
							
							//removes loading and puts button back to normal
							buttonCont.removeAttr('disabled').siblings('.loading-gif').fadeOut(200, function() { jQuery(this).remove(); });
							
							//shows the error message
							buttonCont.parent().before('<p class="ddError">'+data.error_msg+'</p>');
							buttonCont.parent().parent().children('.ddError').css({ display: 'none' }).fadeIn(300);
							
						}
						
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						
						
					}
					
					
				})
				
			}
			
		});
		
	});

</script>

<style type="text/css">

	<?php
	
		if(ddp('page_show_custom') != 'on') {
			
			//// CHECK USER ROLE
			if(!current_user_can('delete_users')) {
				
				echo '#five_page_sidebar_meta { display: none; }';
				
			}
			
		}
	
	?>

</style>


<p class="select-metabox">

	<!-- <label for="post_shadow">Post Shadow</label> -->
    <select name="page_sidebar" id="page_sidebar">
    
    	<option value="Default"<?php if($layout == 'Default') { echo ' selected="selected"'; } ?>><?php _e('Default Template Sidebar', 'ultrasharp'); ?></option>
        <?php
		
			//// DISPLAY OUR CUSTOM SIDEBARS
			$sidebars = get_option('dd_custom_sidebars');
			foreach($sidebars as $sidebar) {
				
				//// OPENS OUR OPTION
				echo '<option value="'.$sidebar.'"';
				
				//// IF IT's THE SELECTED SIDEBAR
				if($page_sidebar == $sidebar) { echo ' selected="selected"'; }
				
				//// CLOSES OUR OPTION
				echo '>'.$sidebar.'</option>';
				
			}
		
		?>
    	<option><?php _e('(add new custom sidebar)', 'ultrasharp'); ?></option>
    
    </select>

</p>

<div id="add_custom_sidebar" style="display: none;">

	<div class="metaboxDivider" style="margin-top: 14px;"></div>

	<p><input type="text" name="new_sidebar_name" id="new_sidebar_name" value="Sidebar Name" class="widefat add_sidebar" onclick="if(jQuery(this).val() == 'Sidebar Name') { jQuery(this).val(''); }" /></p>
    
    <p style="text-align: right;"><input type="button" class="button" value="add sidebar" id="add_custom_sidebar_button" /></p>
    
</div>
<!-- /ADD CUSTOM SIDEBAR/ -->