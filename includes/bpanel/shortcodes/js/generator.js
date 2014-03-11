(function($){ 

    $.fn.extend({
		
		bPanelShortcodeType: function() {
			
			/// main vars 
			var mainCont = this;
			var selectedShort = mainCont.children('option:selected').val();
			
			//// HIDES ANY OTHER TYPES
			jQuery('.shortcode-shortcode').hide();
			jQuery('.shortcode-shortcode-specific').hide();
			
			//// SHOW OUR TYPE
			jQuery('#'+selectedShort).show();
			
			
		},
		
		bPanelShortcodeShortcode: function() {
			
			//main vars
			var mainCont = this;
			var selectedShort = mainCont.children('option:selected').val();
			
			//// HIDES OTHER SHORTCODES
			jQuery('.shortcode-shortcode-specific').hide();
			
			//// SHOW OUR TYPE
			jQuery('#'+selectedShort+', #shortcodes-insert').show();
			
		},
		
		bpanelGeneratorInsertShortcode: function() {
			
			// mai nvars
			var maincont = jQuery('.shortcode-builder-wrapper');
			
			/// LET'S FIND OUT THE SHORTCODE OPEN
			jQuery('.shortcode-shortcode-specific').each(function() {
				
				////IF IT'S THE OPENED ONE
				if(jQuery(this).css('display') == 'block') {
					
					var thisShortCont = jQuery(this);
					
					/// OUR SHORTCODE TYPE
					var thisShortType = thisShortCont.attr('class').split(' ');
					thisShortType = thisShortType[3].split('-');
					thisShortType = thisShortType[1];
					
					/// OUR SHORTCODE NAME
					var thisShortName = thisShortCont.attr('class').split(' ');
					thisShortName = thisShortName[2].split('-');
					thisShortName = thisShortName[1];
					
					//// IF IT'S A SIMPLE SHORTCODE
					if(thisShortType == 'simple') {
						
						//// LET'S LOOP OUR FIELDS AND BUILD OUR SHORTCODE
						var shortText = '['+thisShortName;
						thisShortCont.children('.shortcode-fields').children('.shortcode-fields-field').each(function() {
							
							/// FIELD NAME
							var thisFieldName = jQuery(this).children('.shortcode-name').text();
							
							/// IF IT'S A TEXTAREA
							if(jQuery(this).attr('class').indexOf('textarea') != -1) {
								
								shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('textarea').val()+'"';
								
							} else if(jQuery(this).attr('class').indexOf('text') != -1) {
							  //// IF IT'SA TEXT FIELD	
								
								shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('input').val()+'"';
								
							} else if(jQuery(this).attr('class').indexOf('image') != -1) {
							  //// IF IT'SA TEXT FIELD	
								
								shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('input').val()+'"';
								
							} else if(jQuery(this).attr('class').indexOf('icons') != -1) {
							  //// IF IT'SA TEXT FIELD
								
								shortText += ' '+thisFieldName+'="'+jQuery(this).find('input').val()+'"';
								
							} else if(jQuery(this).attr('class').indexOf('select') != -1) {
							  //// IF IT'SA TEXT FIELD
								
								shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('select').children('option:selected').val()+'"';
								
							} else if(jQuery(this).attr('class').indexOf('hidden') != -1) {
							  //// IF IT'SA TEXT FIELD	
								
								shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('input').val()+'"';
								
							} else if(jQuery(this).attr('class').indexOf('check') != -1) {
							  //// IF IT'SA TEXT FIELD	
								
								if(jQuery(this).children('.shortcode-field-input').children('input').is(':checked')) {
									
									shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-value').text()+'"';
									
								}
								
							} else if(jQuery(this).attr('class').indexOf('info') != -1) {
								
								
								
							}
							
							
						});
							
						shortText += ']';
						send_to_editor(shortText);
						
					} else if(thisShortType == 'wrapped') {
						
						//// LET'S LOOP OUR FIELDS AND BUILD OUR SHORTCODE
						var shortText = '['+thisShortName;
						var wrapped = '';
						var wrapperImage = '';
						thisShortCont.children('.shortcode-fields').children('.shortcode-fields-field').each(function() {
							
							/// FIELD NAME
							var thisFieldName = jQuery(this).children('.shortcode-name').text();
							
							if(thisFieldName == 'wrapped' && jQuery(this).children('.shortcode-image').length > 0) { wrapperImage = true; }
							
							/// IF IT'S A TEXTAREA
							if(jQuery(this).attr('class').indexOf('textarea') != -1) {
								
								if(thisFieldName != 'wrapped') { shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('textarea').val()+'"'; }
								else { wrapped = jQuery(this).children('.shortcode-field-input').children('textarea').val(); }
								
							} else if(jQuery(this).attr('class').indexOf('text') != -1) {
							  //// IF IT'SA TEXT FIELD	
								
								if(thisFieldName != 'wrapped') { shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('input').val()+'"';}
								else { wrapped = jQuery(this).children('.shortcode-field-input').children('input').val(); }
								
							} else if(jQuery(this).attr('class').indexOf('select') != -1) {
							  //// IF IT'SA TEXT FIELD
								
								if(thisFieldName != 'wrapped') { shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('select').children('option:selected').val()+'"';}
								else { wrapped = jQuery(this).children('.shortcode-field-input').children('select').children('option:selected').val(); }
								
							} else if(jQuery(this).attr('class').indexOf('hidden') != -1) {
							  //// IF IT'SA TEXT FIELD	
								
								if(thisFieldName != 'wrapped') { shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-field-input').children('input').val()+'"';}
								else { wrapped = jQuery(this).children('.shortcode-field-input').children('input').val(); }
								
							} else if(jQuery(this).attr('class').indexOf('check') != -1) {
							  //// IF IT'SA TEXT FIELD	
								
								if(jQuery(this).children('.shortcode-field-input').children('input').is(':checked')) {
									
									if(thisFieldName != 'wrapped') { shortText += ' '+thisFieldName+'="'+jQuery(this).children('.shortcode-value').text()+'"';}
									else { wrapped = jQuery(this).children('.shortcode-value').text(); }
									
								}
								
							}
							
						});
						
						/// CLOSE SHORTCODE
						if(wrapperImage === true) { wrapped = '<img src="'+wrapped+'" alt="" />'; }
						shortText += ']'+wrapped+'[/'+thisShortName+']';
						
						//// PUT WRAPPED AND THEN CLOSE IT
						send_to_editor(shortText);
						
					}
					
				}
				
			});
			
		}
		
	});
	
})(jQuery);