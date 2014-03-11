(function($){ 

    $.fn.extend({
		
		ddSelectReplace: function() {
			
			//main vars
			var selectCont = this;
			var mainCont = this.parent();
			
			//hides select
			selectCont.css({ display: 'block', opacity: 0 });
			
			//sets up the HTML
			selectCont.wrap(function() {
				
				return '<span></span>';
				
			});
			
			var spanCont = mainCont.children('span');
			
			// adds the selected value
			var initialSelect = selectCont.children('option:selected').text();
			spanCont.append('<span>'+initialSelect+'</span>');
			
			//when suer changes it
			selectCont.change(function() {
				
				// new selecte ditem
				var newSelected = selectCont.children('option:selected').text();
				spanCont.children('span').text(newSelected);
				
			});
			
		},
		
		updateDDSelectReplace: function() {
			
			//main vars
			var selectCont = this;
			var mainCont = this.parent();
				
				// new selecte ditem
			var newSelected = selectCont.children('option:selected').text();
			mainCont.children('span').text(newSelected);
			
		},
		
		openInsider: function() {
			
			var mainCont = this;
			var insider = mainCont.siblings('.insider');
			if(insider.is(':visible')) {
				
				insider.hide();
				
			} else { insider.show(); }
			
		},
		
		valueChangeLabel: function() {
			
			var label = this.val();
			var header = this.parent().siblings('.head').children('.title');
			
			header.text(label);
			
		},
		
		valueChangeLabel2: function() {
			
			var label = this.val();
			var header = this.parent().parent().siblings('.head').children('.title');
			
			header.text(label);
			
		},
		
		updateLatitudeLongitude: function() {
			
			var theAddress = this;
			var lat = theAddress.parent().find('.value_latitude');
			var lng = theAddress.parent().find('.value_longitude');
			
			var geocoder = new google.maps.Geocoder();
			var latLng = geocoder.geocode({
				
				address: theAddress.val()
				
			}, function(results, status) {
				
				/// IF WE HAVE A RESULT
				if(status == google.maps.GeocoderStatus.OK) {
					
					theLat = results[0].geometry.location.lat();
					theLng = results[0].geometry.location.lng();
					
					lat.val(theLat);
					lng.val(theLng);
					jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();
					jQuery('#dependent-values-wrapper ul').refreshDependentInput();
					
				} else {
					
					alert('Could not find the latitude and longitude for the address '+the_address);
					
				}
				
			});
			
		},
		
		addNewDropDownValue: function(theContainer, theInput) {
			
			var mainCont = this.parent();
			var theCont = jQuery('#'+theContainer);
			var input = theCont.children('input:first');
			
			/// values
			var label = mainCont.find('.value_name');
			var latitude = mainCont.find('.value_latitude');
			var longitude = mainCont.find('.value_longitude');
			var zoom = mainCont.find('.value_zoom');
			var radius = mainCont.find('.value_radius');
			
			//// LETS CREARE A RANDOM ID FOR THIS ITEM
			var randomId = generateRandomId();
			
			//// MAKES SURE THERE IS NO ID LIKE THIS YET
			if(theCont.find('ul li.item-id-'+randomId).length > 0) { alert('An error occurred. Please try again. Error code 213'); return false; }
			
			//// CREATES THE MARKUP
			var markup = '<li class="item-id-'+randomId+'">'+
			'<div class="head" onclick="jQuery(this).openInsider();">'+
			'<span class="title">'+label.val()+'</span>'+
			'<span class="arrow"></span>'+
			'</div>'+
			'<div class="insider" style="display: none;">'+
			'<label>Label</label>'+
			'<input type="text" class="widefat value_name" value="'+label.val()+'" onblur="jQuery(this).valueChangeLabel();  jQuery(\'#dropdown-values-wrapper ul\').refreshDropDownInput();" />'+
			'<em style="margin: 10px 0 0; display: block;">Label of your dropdown</em>'+
			'<div class="clear"></div><div class="bDivider"></div>'+
			'<label>Location Address</label>'+
			'<input type="text" class="widefat value_address" value="" onblur="jQuery(this).updateLatitudeLongitude();  jQuery(\'#dropdown-values-wrapper ul\').refreshDropDownInput();" />'+
			'<em style="margin: 5px 0 0; display: block;">Only used in case the options "Change Location" is enabled.</em>'+
			'<br /><br />'+
			'<div class="one-third"><label>Latitude</label><input type="text" class="widefat value_latitude" value="'+latitude.val()+'" /><em style="margin: 5px 0 0; display: block;">Automatically gotten from address input or get it from<a href="#http://itouchmap.com/latlong.html" target="_blank">here</a>.</em></div>'+
			'<div class="one-third"><label>Latitude</label><input type="text" class="widefat value_longitude" value="'+longitude.val()+'" /><em style="margin: 5px 0 0; display: block;">Automatically gotten from address input or get it from<a href="#http://itouchmap.com/latlong.html" target="_blank">here</a>.</em></div>'+
			'<div class="one-third last"><label>Zoom Level</label><input type="text" class="widefat value_zoom" value="'+zoom.val()+'" /><em style="margin: 5px 0 0; display: block;">Value between 1 and 20 for your zoom. Leave blank to not change zoom</em></div>'+
			'<div class="clear"></div> <div class="bDivider"></div>'+
			'<label>Radius</label><input type="text" class="widefat value_radius" value="'+radius.val()+'" /><em style="margin: 5px 0 0; display: block;">Set a radius in distance_type for when the user selects this location, we will filter based on this radius. Leave blank to disable and filter by search field only</em>' +
			'<div class="clear"></div> <div class="bDivider"></div><div class="clear"></div>';
			
			//// LETS CHECK FOR WPML FIELDS
			if(jQuery('#dropdown-values-add-new input.value_name_wpml').length > 0) {
				
				jQuery('#dropdown-values-add-new input.value_name_wpml').each(function() {
					
					var langLabel = jQuery(this).parent().children('label').html();
					console.log(langLabel);
					markup += '<label>'+langLabel+'</label>';
					
					var languageCode = jQuery(this).attr('data-lang');
					
					markup += '<input type="text" class="widefat value_name_wpml value_name_wpml_'+languageCode+'" data-lang="'+languageCode+'" value="'+jQuery(this).val()+'" onblur="jQuery(\'#dropdown-values-wrapper ul\').refreshDropDownInput();" />';
					
					markup += '<div class="bDivider"></div><div class="clear"></div>';
					
				});
				
				console.log(markup);
				
			}
			
			markup += '<input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeDropDownValue();" />' +
			'<div class="clear"></div>';
			
			//// APPENDS IT TO THE UL
			theCont.children('ul').append(markup);
			
			label.val('').focus();
			latitude.val('');
			longitude.val('');
			zoom.val('');
			radius.val('');
							
			jQuery('#'+theContainer+' ul').sortable({
				
				handle: jQuery('#dropdown-values-wrapper li .head'),
				items: '> li',
				stop: function(event, ui) {
					
					/// RETURN FALSE FOR SHOWING THE CONTENT
					jQuery('#'+theContainer+' ul').refreshDropDownInput();
					
				}
				
			});
			
			jQuery('#'+theContainer+' ul').refreshDropDownInput();
			
		},
		
		removeDropDownValue: function() {
			
			//// REMOVES ITEM
			jQuery(this).parent().parent().slideUp(300, function() {
				
				jQuery(this).remove();
				jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();
				
			});
			
		},
		
		refreshDropDownInput: function() {
			
			var ulCont = this;
			var theInput = ulCont.siblings('input:first');
			
			//// IF LENGTH IS 0
			if(ulCont.children('li').length > 0) {
			
				//// OUR ARRAY
				var theArr = {};
				
				//// LETS GO THROUGH EACH LI
				ulCont.children('li').each(function(i, obj) {
					
					//// THE ID
					var theID = jQuery(this).attr('class').split('-');
					theArr[i] = {};
					theArr[i]['id'] = theID[2];
					
					/// THE LABEL
					var theLabel = jQuery(this).find('input.value_name').val();
					theArr[i]['label'] = theLabel;
					
					/// ADDRESS
					var theAddress = jQuery(this).find('input.value_address').val();
					theArr[i]['address'] = theAddress;
					
					/// LATITUDE
					var theLat = jQuery(this).find('input.value_latitude').val();
					theArr[i]['latitude'] = theLat;
					
					/// LONGITUDE
					var theLng = jQuery(this).find('input.value_longitude').val();
					theArr[i]['longitude'] = theLng;
					
					/// ZOOM
					var theZoom = jQuery(this).find('input.value_zoom').val();
					theArr[i]['zoom'] = theZoom;
					
					/// RADIUS
					var theRadius = jQuery(this).find('input.value_radius').val();
					theArr[i]['radius'] = theRadius;
					
					//// CHECKS FOR ANY WPML VALUES
					if(jQuery(this).find('input.value_name_wpml').length > 0) { theArr[i]['wpml'] = {}; }
					jQuery(this).find('input.value_name_wpml').each(function() {
						
						/// GETS THIS LANGUAGE CODE
						var langCode = jQuery(this).attr('data-lang');
						
						theArr[i]['wpml'][langCode] = jQuery(this).val();
						
					});
					
				});
				
				//// WE NEED TO SERIALIZE OUR INPUT
				var theValue = JSON.stringify(theArr);
			
			} else { var theValue = ''; }
			
			//// ADDS IT TO OUR INPUT
			theInput.val(theValue);
		},
		
		addNewSelectValue: function(theContainer, theInput) {
			
			var mainCont = this.parent();
			var theCont = jQuery('#'+theContainer);
			var input = theCont.children('input:first');
			
			/// values
			var value = mainCont.find('.value_name');
			
			//// LETS CREARE A RANDOM ID FOR THIS ITEM
			var randomId = jQuery('#'+theContainer+' ul > li').length;
			
			//// MAKES SURE THERE IS NO ID LIKE THIS YET
			if(theCont.find('ul li.item-id-'+randomId).length > 0) { alert('An error occurred. Please try again. Error code 213'); return false; }
			
			//// CREATES THE MARKUP
			var markup = '<li class="item-id-'+randomId+'">'+
			'<div class="head" onclick="jQuery(this).openInsider();">'+
			'<span class="title">'+value.val()+'</span>'+
			'<span class="arrow"></span>'+
			'</div>'+
			'<div class="insider" style="display: none;">'+
			'<label>Label</label>'+
			'<input type="text" class="widefat value_name" value="'+value.val()+'" onblur="jQuery(this).valueChangeLabel();  jQuery(\'#dropdown-values-wrapper ul\').refreshSelectInput();" />'+
			'<em style="margin: 10px 0 0; display: block;">Label of your value</em>'+
			'<div class="clear"></div> <div class="bDivider"><div class="clear"></div>' +
			'<br><input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeSelectValue();" />' +
			'<div class="clear"></div>';
			
			//// APPENDS IT TO THE UL
			theCont.children('ul').append(markup);
			
			value.val('').focus();
							
			jQuery('#'+theContainer+' ul').sortable({
				
				handle: jQuery('#dropdown-values-wrapper li .head'),
				items: '> li',
				stop: function(event, ui) {
					
					/// RETURN FALSE FOR SHOWING THE CONTENT
					jQuery('#'+theContainer+' ul').refreshSelectInput();
					
				}
				
			});
			
			jQuery('#'+theContainer+' ul').refreshSelectInput();
			
		},
		
		removeSelectValue: function() {
			
			//// REMOVES ITEM
			jQuery(this).parent().parent().parent().slideUp(300, function() {
				
				jQuery(this).remove();
				jQuery('#dropdown-values-wrapper ul').refreshSelectInput();
				
			});
			
		},
		
		refreshSelectInput: function() {
			
			var ulCont = this;
			var theInput = ulCont.siblings('input:first');
			
			//// IF LENGTH IS 0
			if(ulCont.children('li').length > 0) {
			
				//// OUR ARRAY
				var theArr = {};
				
				//// LETS GO THROUGH EACH LI
				ulCont.children('li').each(function(i, obj) {
					
					//// THE ID
					var theID = i;
					jQuery(this).attr('id', 'item-id-'+theID).attr('class', 'item-id-'+theID);
					theArr[i] = {};
					theArr[i]['id'] = theID[2];
					
					/// THE LABEL
					var theLabel = jQuery(this).find('input.value_name').val();
					theArr[i]['label'] = theLabel;
					
				});
				
				//// WE NEED TO SERIALIZE OUR INPUT
				var theValue = JSON.stringify(theArr);
			
			} else { var theValue = ''; }
			
			//// ADDS IT TO OUR INPUT
			theInput.val(theValue);
		},
		
		addNewMinValValue: function(theContainer, theInput) {
			
			var mainCont = this.parent();
			var theCont = jQuery('#'+theContainer);
			var input = theCont.children('input:first');
			
			/// values
			var label = mainCont.find('.value_name');
			var value = mainCont.find('.value_value');
			
			//// CHECKS INTEGER
			if(isNaN(value.val())) { alert('Please insert a number for your value or leave blank. Characters are not accepted.'); return false; }
			
			//// LETS CREARE A RANDOM ID FOR THIS ITEM
			var randomId = generateRandomId();
			
			//// MAKES SURE THERE IS NO ID LIKE THIS YET
			if(theCont.find('ul li.item-id-'+randomId).length > 0) { alert('An error occurred. Please try again. Error code 213'); return false; }
			
			//// CREATES THE MARKUP
			var markup = '<li class="item-id-'+randomId+'">'+
			'<div class="head" onclick="jQuery(this).openInsider();">'+
			'<span class="title">'+label.val()+'</span>'+
			'<span class="arrow"></span>'+
			'</div>'+
			'<div class="insider" style="display: none;">'+
			'<div class="one-half"><label>Label</label>'+
			'<input type="text" class="widefat value_name" value="'+label.val()+'" onblur="jQuery(this).valueChangeLabel2();  jQuery(\'#dropdown-values-wrapper ul\').refreshMinValInput();" />'+
			'<em style="margin: 10px 0 0; display: block;">Label of your dropdown</em></div>'+
			'<div class="one-half last"><label>Value (Integer)</label>'+
			'<input type="number" class="widefat value_value" value="'+value.val()+'" />'+
			'<em style="margin: 5px 0 0; display: block;">This is your minimum value. This must be an integer (a number). Leave Blank to not include</em></div>' +
			'<div class="clear"></div> <div class="bDivider"></div>';
			
			//// LETS CHECK FOR WPML FIELDS
			if(jQuery('#minval-values-add-new input.value_name_wpml').length > 0) {
				
				jQuery('#minval-values-add-new input.value_name_wpml').each(function() {
					
					var langLabel = jQuery(this).parent().children('label').html();
					console.log(langLabel);
					markup += '<label>'+langLabel+'</label>';
					
					var languageCode = jQuery(this).attr('data-lang');
					
					markup += '<input type="text" class="widefat value_name_wpml value_name_wpml_'+languageCode+'" data-lang="'+languageCode+'" value="'+jQuery(this).val()+'" />';
					
					markup += '<div class="bDivider"></div><div class="clear"></div>';
					
				});
				
			}
			
			markup += '<input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeDropDownValue();" />' +
			'<div class="clear"></div>';
			
			//// APPENDS IT TO THE UL
			theCont.children('ul').append(markup);
			
			label.val('').focus();
			value.val('');
							
			jQuery('#'+theContainer+' ul').sortable({
				
				handle: jQuery('#min_val-values-wrapper li .head'),
				items: '> li',
				stop: function(event, ui) {
					
					/// RETURN FALSE FOR SHOWING THE CONTENT
					jQuery('#'+theContainer+' ul').refreshMinValInput();
					
				}
				
			});
			
			jQuery('#'+theContainer+' ul').refreshMinValInput();
			
		},
		
		refreshMinValInput: function() {
			
			var ulCont = this;
			var theInput = ulCont.siblings('input:first');
			
			//// IF LENGTH IS 0
			if(ulCont.children('li').length > 0) {
			
				//// OUR ARRAY
				var theArr = {};
				
				//// LETS GO THROUGH EACH LI
				ulCont.children('li').each(function(i, obj) {
					
					//// THE ID
					var theID = jQuery(this).attr('class').split('-');
					theArr[i] = {};
					theArr[i]['id'] = theID[2];
					
					/// THE LABEL
					var theLabel = jQuery(this).find('input.value_name').val();
					theArr[i]['label'] = theLabel;
					
					/// THE VALUE
					var theAddress = jQuery(this).find('input.value_value').val();
					theArr[i]['value'] = theAddress;
					
					//// CHECKS FOR ANY WPML VALUES
					if(jQuery(this).find('input.value_name_wpml').length > 0) { theArr[i]['wpml'] = {}; }
					jQuery(this).find('input.value_name_wpml').each(function() {
						
						/// GETS THIS LANGUAGE CODE
						var langCode = jQuery(this).attr('data-lang');
						
						theArr[i]['wpml'][langCode] = jQuery(this).val();
						
					});
					
				});
				
				//// WE NEED TO SERIALIZE OUR INPUT
				var theValue = JSON.stringify(theArr);
			
			} else { var theValue = ''; }
			
			//// ADDS IT TO OUR INPUT
			theInput.val(theValue);
		},
		
		removeMinValue: function() {
			
			//// REMOVES ITEM
			jQuery(this).parent().parent().slideUp(300, function() {
				
				jQuery(this).remove();
				jQuery('#min_val-values-wrapper ul').refreshMinValInput();
				
			});
			
		},
		
		addNewMaxValValue: function(theContainer, theInput) {
			
			var mainCont = this.parent();
			var theCont = jQuery('#'+theContainer);
			var input = theCont.children('input:first');
			
			/// values
			var label = mainCont.find('.value_name');
			var value = mainCont.find('.value_value');
			
			//// CHECKS INTEGER
			if(isNaN(value.val())) { alert('Please insert a number for your value or leave blank. Characters are not accepted.'); return false; }
			
			//// LETS CREARE A RANDOM ID FOR THIS ITEM
			var randomId = generateRandomId();
			
			//// MAKES SURE THERE IS NO ID LIKE THIS YET
			if(theCont.find('ul li.item-id-'+randomId).length > 0) { alert('An error occurred. Please try again. Error code 213'); return false; }
			
			//// CREATES THE MARKUP
			var markup = '<li class="item-id-'+randomId+'">'+
			'<div class="head" onclick="jQuery(this).openInsider();">'+
			'<span class="title">'+label.val()+'</span>'+
			'<span class="arrow"></span>'+
			'</div>'+
			'<div class="insider" style="display: none;">'+
			'<div class="one-half"><label>Label</label>'+
			'<input type="text" class="widefat value_name" value="'+label.val()+'" onblur="jQuery(this).valueChangeLabel2();  jQuery(\'#dropdown-values-wrapper ul\').refreshMaxValInput();" />'+
			'<em style="margin: 10px 0 0; display: block;">Label of your dropdown</em></div>'+
			'<div class="one-half last"><label>Value (Integer)</label>'+
			'<input type="number" class="widefat value_value" value="'+value.val()+'" />'+
			'<em style="margin: 5px 0 0; display: block;">This is your maximum value. This must be an integer (a number). Leave Blank to not include</em></div>' +
			'<div class="clear"></div> <div class="bDivider"></div>';
			
			//// LETS CHECK FOR WPML FIELDS
			if(jQuery('#maxval-values-add-new input.value_name_wpml').length > 0) {
				
				jQuery('#maxval-values-add-new input.value_name_wpml').each(function() {
					
					var langLabel = jQuery(this).parent().children('label').html();
					console.log(langLabel);
					markup += '<label>'+langLabel+'</label>';
					
					var languageCode = jQuery(this).attr('data-lang');
					
					markup += '<input type="text" class="widefat value_name_wpml value_name_wpml_'+languageCode+'" data-lang="'+languageCode+'" value="'+jQuery(this).val()+'" />';
					
					markup += '<div class="bDivider"></div><div class="clear"></div>';
					
				});
				
			}
			
			markup += '<input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeDropDownValue();" />' +
			'<div class="clear"></div>';
			
			//// APPENDS IT TO THE UL
			theCont.children('ul').append(markup);
			
			label.val('').focus();
			value.val('');
							
			jQuery('#'+theContainer+' ul').sortable({
				
				handle: jQuery('#max_val-values-wrapper li .head'),
				items: '> li',
				stop: function(event, ui) {
					
					/// RETURN FALSE FOR SHOWING THE CONTENT
					jQuery('#'+theContainer+' ul').refreshMaxValInput();
					
				}
				
			});
			
			jQuery('#'+theContainer+' ul').refreshMaxValInput();
			
		},
		
		refreshMaxValInput: function() {
			
			var ulCont = this;
			var theInput = ulCont.siblings('input:first');
			
			//// IF LENGTH IS 0
			if(ulCont.children('li').length > 0) {
			
				//// OUR ARRAY
				var theArr = {};
				
				//// LETS GO THROUGH EACH LI
				ulCont.children('li').each(function(i, obj) {
					
					//// THE ID
					var theID = jQuery(this).attr('class').split('-');
					theArr[i] = {};
					theArr[i]['id'] = theID[2];
					
					/// THE LABEL
					var theLabel = jQuery(this).find('input.value_name').val();
					theArr[i]['label'] = theLabel;
					
					/// THE VALUE
					var theAddress = jQuery(this).find('input.value_value').val();
					theArr[i]['value'] = theAddress;
					
					//// CHECKS FOR ANY WPML VALUES
					if(jQuery(this).find('input.value_name_wpml').length > 0) { theArr[i]['wpml'] = {}; }
					jQuery(this).find('input.value_name_wpml').each(function() {
						
						/// GETS THIS LANGUAGE CODE
						var langCode = jQuery(this).attr('data-lang');
						
						theArr[i]['wpml'][langCode] = jQuery(this).val();
						
					});
					
				});
				
				//// WE NEED TO SERIALIZE OUR INPUT
				var theValue = JSON.stringify(theArr);
			
			} else { var theValue = ''; }
			
			//// ADDS IT TO OUR INPUT
			theInput.val(theValue);
		},
		
		removeMaxValue: function() {
			
			//// REMOVES ITEM
			jQuery(this).parent().parent().slideUp(300, function() {
				
				jQuery(this).remove();
				jQuery('#max_val-values-wrapper ul').refreshMaxValInput();
				
			});
			
		},
		
		addNewDependentValue: function(theContainer, theInput) {
			
			var mainCont = this.parent();
			var theCont = jQuery('#'+theContainer);
			var input = theCont.children('input:first');
			
			/// values
			var label = mainCont.find('.value_name');
			var parent = mainCont.find('select > option:selected').val();
			var latitude = mainCont.find('.value_latitude');
			var longitude = mainCont.find('.value_longitude');
			var zoom = mainCont.find('.value_zoom');
			var radius = mainCont.find('.value_radius');
			
			//// LETS CREARE A RANDOM ID FOR THIS ITEM
			var randomId = generateRandomId();
			
			//// MAKES SURE THERE IS NO ID LIKE THIS YET
			if(theCont.find('ul ul li.item-id-'+randomId).length > 0) { alert('An error occurred. Please try again. Error code 213'); return false; }
			
			//// CREATES THE MARKUP
			var markup = '<li class="item-id-'+randomId+'">'+
			'<div class="head" onclick="jQuery(this).openInsider();">'+
			'<span class="title">'+label.val()+'</span>'+
			'<span class="arrow"></span>'+
			'</div>'+
			'<div class="insider" style="display: none;">'+
			'<label>Label</label>'+
			'<input type="text" class="widefat value_name" value="'+label.val()+'" onblur="jQuery(this).valueChangeLabel();  jQuery(\'#dependent-values-wrapper ul\').refreshDependentInput();" />'+
			'<em style="margin: 10px 0 0; display: block;">Label of your dropdown</em>'+
			'<div class="clear"></div><div class="bDivider"></div>'+
			'<label>Location Address</label>'+
			'<input type="text" class="widefat value_address" value="" onblur="jQuery(this).updateLatitudeLongitude(); jQuery(\'#dependent-values-wrapper > ul\').refreshDependentInput();" />'+
			'<em style="margin: 5px 0 0; display: block;">Only used in case the options "Change Location" is enabled.</em>'+
			'<br /><br />'+
			'<div class="one-third"><label>Latitude</label><input type="text" class="widefat value_latitude" value="'+latitude.val()+'" /><em style="margin: 5px 0 0; display: block;">Automatically gotten from address input or get it from<a href="#http://itouchmap.com/latlong.html" target="_blank">here</a>.</em></div>'+
			'<div class="one-third"><label>Latitude</label><input type="text" class="widefat value_longitude" value="'+longitude.val()+'" /><em style="margin: 5px 0 0; display: block;">Automatically gotten from address input or get it from<a href="#http://itouchmap.com/latlong.html" target="_blank">here</a>.</em></div>'+
			'<div class="one-third last"><label>Zoom Level</label><input type="text" class="widefat value_zoom" value="'+zoom.val()+'" /><em style="margin: 5px 0 0; display: block;">Value between 1 and 20 for your zoom. Leave blank to not change zoom.</em></div>'+
			'<div class="clear"></div> <div class="bDivider"></div>' +
			'<label>Radius</label><input type="text" class="widefat value_radius" value="'+radius.val()+'" /><em style="margin: 5px 0 0; display: block;">Set a radius in distance_type for when the user selects this location, we will filter based on this radius. Leave blank to disable and filter by search field only</em>' +
			'<div class="clear"></div> <div class="bDivider"></div><div class="clear"></div>';
			
			//// LETS CHECK FOR WPML FIELDS
			if(jQuery('#dependent-values-add-new input.value_name_wpml').length > 0) {
				
				jQuery('#dependent-values-add-new input.value_name_wpml').each(function() {
					
					var langLabel = jQuery(this).parent().children('label').html();
					console.log(langLabel);
					markup += '<label>'+langLabel+'</label>';
					
					var languageCode = jQuery(this).attr('data-lang');
					
					markup += '<input type="text" class="widefat value_name_wpml value_name_wpml_'+languageCode+'" data-lang="'+languageCode+'" value="'+jQuery(this).val()+'" />';
					
					markup += '<div class="bDivider"></div><div class="clear"></div>';
					
				});
				
			}
			
			markup += '<input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeDependentValue();" />' +
			'<div class="clear"></div>';
			
			//// APPENDS IT TO THE UL
			theCont.find('ul > li#parent-'+parent+' ul').append(markup);
			
			label.val('').focus();
			latitude.val('');
			longitude.val('');
			zoom.val('');
			radius.val('');
			
			jQuery('#dependent-values-wrapper ul ul').sortable({
											
				handle: jQuery('#dependent-values-wrapper ul ul .head'),
				items: '> li',
				connectWith: '.dependent-connect',
				stop: function(ui, event) {
					
					jQuery('#dependent-values-wrapper > ul').refreshDependentInput();
					
				}
				
			});
			
			jQuery('#dependent-values-wrapper > ul').refreshDependentInput();
			
		},
		
		refreshDependentInput: function() {
			
			var ulCont = this;
			var theInput = ulCont.siblings('input:first');
			
			//// IF LENGTH IS 0
			if(ulCont.find('ul li').length > 0) {
			
				//// OUR ARRAY
				var theArr = {};
				
				//// LETS GO THROUGH EACH UL PARENT
				ulCont.find('> li > ul').each(function(i, obj) {
					
					//// CREATES THIS PARENTS OBJECT
					var theID = jQuery(this).parent().attr('id').split('-');
					theArr[theID[1]] = {};
					
					
					//// NOW LET'S GO THROUGH EACH LI UNDER THIS PARENT
					jQuery(this).children('li').each(function(_i, obj) {
						
						//// CREATES A NEW OBJECT FOR THIS ITEM
						var _theID = jQuery(this).attr('class').split('-');
						theArr[theID[1]][_i] = {};
						theArr[theID[1]][_i]['id'] = _theID[2];
					
						/// THE LABEL
						var theLabel = jQuery(this).find('input.value_name').val();
						theArr[theID[1]][_i]['label'] = theLabel;
						
						/// ADDRESS
						var theAddress = jQuery(this).find('input.value_address').val();
						theArr[theID[1]][_i]['address'] = theAddress;
						
						/// LATITUDE
						var theLat = jQuery(this).find('input.value_latitude').val();
						theArr[theID[1]][_i]['latitude'] = theLat;
						
						/// LONGITUDE
						var theLng = jQuery(this).find('input.value_longitude').val();
						theArr[theID[1]][_i]['longitude'] = theLng;
						
						/// ZOOM
						var theZoom = jQuery(this).find('input.value_zoom').val();
						theArr[theID[1]][_i]['zoom'] = theZoom;
						
						/// Radius
						var theRadius = jQuery(this).find('input.value_radius').val();
						theArr[theID[1]][_i]['radius'] = theRadius;
					
						//// CHECKS FOR ANY WPML VALUES
						if(jQuery(this).find('input.value_name_wpml').length > 0) { theArr[theID[1]][_i]['wpml'] = {}; }
						jQuery(this).find('input.value_name_wpml').each(function() {
							
							/// GETS THIS LANGUAGE CODE
							var langCode = jQuery(this).attr('data-lang');
							
							theArr[theID[1]][_i]['wpml'][langCode] = jQuery(this).val();
							
						});
						
						console.log(theArr);
						
					});
					
					
				});
				
				//// WE NEED TO SERIALIZE OUR INPUT
				var theValue = JSON.stringify(theArr);
			
			} else { var theValue = ''; }
			
			console.log(theArr);
			
			//// ADDS IT TO OUR INPUT
			theInput.val(theValue);
			
		},
		
		removeDependentValue: function() {
			
			//// REMOVES ITEM
			jQuery(this).parent().parent().slideUp(300, function() {
				
				jQuery(this).remove();
				jQuery('#dependent-values-wrapper ul').refreshDependentInput();
				
			});
			
		},
		
		removeThisFormField: function(){
			
			//// SLIDE UP MAIN CONTAINER
			jQuery(this).parent().parent().slideUp(300, function() {
				
				jQuery(this).remove();
			
				jQuery('#the_form').refreshFormFields();
				
			});
			
		},
		
		refreshFormFields: function() {
			
			var mainCont = jQuery('#the-form');
			
			var theInput = jQuery('#form_fields_input');
			
			var theArr = {};
			
			//// LETS GO THROUGH EACH LI
			mainCont.children('li').each(function(i, obj){
				
				//// CREATES AN OBJECT FOR THIS COLUMNS
				theArr[i] = {};
				
				//// LETS GO THROUGH EACH FIELD ITEM IN THIS LI
				jQuery(this).find('ul:first > li').each(function(_i, obj) {
						
					//// CREATES A NEW OBJECT FOR THIS ITEM
					theArr[i][_i] = {};
					
					//// FIELD TYPE
					var fieldType = jQuery(this).find('input[name="field_type"]').val();
					theArr[i][_i]['type'] = fieldType;
					
					//// FIELD NAME
					var fieldName = jQuery(this).find('.title').text();
					theArr[i][_i]['title'] = fieldName;
					
					//// IF NOT DIVIDER OR COLUMNS AD THE LABEL
					if(fieldType != 'divider' && fieldType != 'close_column' && fieldType != 'open_column') {
						
						//// FIELD TYPE
						var theLabel = jQuery(this).find('input.field_label').val();
						theArr[i][_i]['label'] = theLabel;
						
					}
					
					//// THE ID
					var theID = jQuery(this).find('input[name="the_id"]').val();
					theArr[i][_i]['id'] = theID;
					
					//// THE SLUG
					var theSlug = jQuery(this).find('input[name="the_slug"]').val();
					theArr[i][_i]['slug'] = theSlug;
					
					//// CHECKS FOR ANY WPML VALUES
					if(jQuery(this).find('input.value_name_wpml').length > 0) { theArr[i][_i]['wpml'] = {}; }
					jQuery(this).find('input.value_name_wpml').each(function() {
						
						/// GETS THIS LANGUAGE CODE
						var langCode = jQuery(this).attr('data-lang');
						
						theArr[i][_i]['wpml'][langCode] = jQuery(this).val();
						
					});
					
					//// NOW WE NEED TO CHECK FOR THE FIELD IF
					if(jQuery(this).find('input[name="field_if_id"]').length > 0) {
						
						var fieldIf = {};
						
						fieldIf['id'] = jQuery(this).find('input[name="field_if_id"]').val();
						
						if(jQuery(this).find('select[name="field_if_values"]').length > 0) {
							
							var theValues = new Array();
							
							 jQuery(this).find('select[name="field_if_values"] option:selected').each(function() {
								 
								 theValues.push(jQuery(this).val());
								 
							 });
							 
							 //// CHECKS FOR THE ANY FIELD
							 if(jQuery(this).find('input[name="field_if_values_any"]').length > 0) {
								 
							 	//// ADDS THE ALL VALUE TO THE ARRAY
								if(jQuery(this).find('input[name="field_if_values_any"]').is(':checked')) { theValues.push('all'); }	 
								 
							 }
							 
							 fieldIf['values'] = theValues;
							
						}
						
						theArr[i][_i]['field_if'] = fieldIf;
						
					}
					
				});
				
			});
				
			//// WE NEED TO SERIALIZE OUR INPUT
			var theValue = JSON.stringify(theArr);
			
			theInput.val(theValue);
			
		},
		
		insertSpotSubmissionFile: function(parent, input_field_refresh) {
			
			/// vars
			var buttonCont = this;
			var mainCont = this.parent();
			var ulCont = jQuery('#'+parent+' ul');
			mainCont.find('.updated').remove();
			
			/// values
			var label = mainCont.find('input.value_label');
			var desc = mainCont.find('input.value_desc');
			var file_name = mainCont.find('.filename').text();
			var file_id = mainCont.find('.filename input');
			
			
			///// IF ANY ERRORS
			if(file_id.val() == '') {
				
				alert('Please Upload a file');
				return false;
				
			}
			
			///// IF ANY ERRORS
			if(label.val() == '') {
				
				alert('Please provide a title for your file.');
				return false;
				
			}
			
			ulCont.find('li.clone').clone().appendTo(ulCont);
			var liCont = ulCont.find('li:last');
			liCont.removeClass('clone').show();
			
			
			///// UPDATES THINGS
			liCont.find('.insider > p:first > a').attr('href', '#').text(file_name);
			liCont.find('.head .title').text(label.val());
			liCont.find('input.value_label').val(label.val());
			liCont.find('input.value_desc').val(desc.val());
			liCont.find('input.value_ID').val(file_id.val());
			
			ulCont.sortable({
											
				handle: ulCont.find('> li .head'),
				items: '> li',
				stop: function(event, ui) {
					
					/// RETURN FALSE FOR SHOWING THE CONTENT
					ulCont.spotSubmissionFieldFileRefresh(input_field_refresh);
					
				}
				
			});
			
			//// REFRESH INPUT
			ulCont.spotSubmissionFieldFileRefresh(input_field_refresh);
			
			//// FOCUS IN THE TOP FIELD AND ERASES BOTH
			label.val('');
			desc.val('');
			file_id.val('');
			file_name.text('');
			label.focus();
			
		},
		
		removeSubmissionFieldFile: function(ulCont, inputField) {
			
			var thisCont = this;
			thisCont.parent().parent().slideUp(200, function() {
				
				jQuery(this).remove();
				jQuery('#'+ulCont).spotSubmissionFieldFileRefresh(inputField);
				
				
			});
			
		},
		
		spotSubmissionFieldFileRefresh: function(inputField) {
			
			var ulCont = this;
			var theInput = jQuery('#'+inputField);
			
			//// GOES THROUGH EACH LI AND ADDS IT TO THE ARRAY
			var theArr = {};
			ulCont.children('li:not(.clone)').each(function(i, obj) {
				
				theArr[i] = {};
				
				//// LABEL
				var title = jQuery(this).find('input.value_label').val();
				theArr[i]['title'] = title;
				
				//// VALUE
				var desc = jQuery(this).find('input.value_desc').val();
				theArr[i]['desc'] = desc;
				
				//// ID
				var id = jQuery(this).find('input.value_ID').val();
				theArr[i]['ID'] = id;
				
				//// size
				var size = jQuery(this).find('input.value_size').val();
				theArr[i]['size'] = size;
				
			});
			
			//// WE NEED TO SERIALIZE OUR INPUT
			var theValue = JSON.stringify(theArr);
			
			console.log(theValue);
			
			theInput.val(theValue);
			
		},
		
		insertSpotCustomField: function() {
			
			/// vars
			var buttonCont = this;
			var mainCont = this.parent();
			var ulCont = jQuery('#_sf_custom_fields_wrapper ul');
			mainCont.find('.updated').remove();
			
			/// values
			var label = mainCont.find('input.value_label');
			var value = mainCont.find('input.value_value');
			
			//// IF NO LABEL
			if(label.val() != '') {
			
			//// GENERATES OUR MARKUP
			var markup = '<li><div class="head" onclick="jQuery(this).openInsider();">'+
					  '<span class="title">'+label.val()+'</span>'+
					  '<span class="arrow"></span></div>'+
					  '<div class="insider" style="display: none;">'+
                      '<div class="one-half"><label>Label</label>'+
                      '<input type="text" class="widefat value_label" value="'+label.val()+'" onblur="jQuery(this).valueChangeLabel2(); jQuery(\'#_sf_custom_fields_wrapper ul\').spotCustomFieldRefresh();" />'+
                      '<em style="margin: 10px 0 0; display: block;">Label of your Custom Field</em></div>'+
                      '<div class="one-half last"><label>Value</label>'+
                      '<input type="text" class="widefat value_value" value="'+escape(value.val())+'" />'+
                      '<em style="margin: 10px 0 0; display: block;">Your value. This is displayed in the fron end. HTML accepted</em></div>'+
    				  '<div class="clear"></div><div class="bDivider"></div><input type="button" class="button" value="Remove Value" onclick="jQuery(this).remvoeCustomField();" /><div class="clear"></div></div></li>';
					  
			ulCont.append(markup);
			
			//// UNESCAPES HTML
			ulCont.find('li:last input').each(function() { jQuery(this).val(unescape(jQuery(this).val())); });
						
			jQuery('#_sf_custom_fields_wrapper ul').sortable({
				
				handle: jQuery('#_sf_custom_fields_wrapper li .head'),
				items: '> li',
				stop: function(event, ui) {
					
					/// RETURN FALSE FOR SHOWING THE CONTENT
					jQuery('#_sf_custom_fields_wrapper ul').spotCustomFieldRefresh();
					
				}
				
			});
			
			//// REFRESH INPUT
			jQuery('#_sf_custom_fields_wrapper ul').spotCustomFieldRefresh();
			
			//// FOCUS IN THE TOP FIELD AND ERASES BOTH
			mainCont.find('input.value_label').val('').focus();
			mainCont.find('input.value_value').val('');
			
					  
			} else {
				
				buttonCont.before('<div class="updated">Please insert a label</siv>');
				
			}
			
		},
		
		spotCustomFieldRefresh: function() {
			
			var ulCont = this;
			var theInput = jQuery('#_sf_custom_fields');
			
			//// GOES THROUGH EACH LI AND ADDS IT TO THE ARRAY
			var theArr = {};
			ulCont.children('li').each(function(i, obj) {
				
				theArr[i] = {};
				
				//// LABEL
				var label = jQuery(this).find('input.value_label').val();
				theArr[i]['label'] = label;
				
				//// VALUE
				var value = jQuery(this).find('input.value_value').val();
				theArr[i]['value'] = value;
				
			});
			
			//// WE NEED TO SERIALIZE OUR INPUT
			var theValue = JSON.stringify(theArr);
			
			theInput.val(theValue);
			
		},
		
		removeCustomField: function() {
			
			var thisCont = this;
			thisCont.parent().parent().slideUp(200, function() {
				
				jQuery(this).remove();
				jQuery('#_sf_custom_fields_wrapper ul').spotCustomFieldRefresh();
				
				
			});
			
		},
		
		removeFromGallery: function() {
			
			jQuery(this).parent().fadeOut(200, function() {
				
				jQuery(this).remove();
				jQuery(this).parent().refreshSpotGallery();
				
			});
			
		},
		
		refreshSpotGallery: function() {
			
			//// MAKES UP ARRAY
			var ulCont = this;
			var theInput = jQuery('input#_sf_gallery_images');
			var theArr = {};
			
			ulCont.children('li').each(function(i, obj) {
				
				theArr[i] = jQuery(this).find('input[name="image_id"]').val();
				
			});
			
			//// STRINGIFY AND ADDS TO THE INPUT
			var theValue = JSON.stringify(theArr);
			theInput.val(theValue);
			
                                
			jQuery('#_sf_gallery ul._sf_images').sortable({
				
				items: '> li',
				stop: function(event, ui) {
					
					jQuery('#_sf_gallery ul._sf_images').refreshSpotGallery();
					
				}
				
			});
			
		},
		
		_sf_load_if_field: function(post_id) {
			
			var ulCont = this;
			
			//// HIDES ul Cont
			ulCont.hide();
			
			//// CREATES A NEW MARKUP FOR OUR IF FIELD
			ulCont.after('<div class="the-if-field"><span class="spinner" style="display: block; margin-left: 45%; margin-top: 5%; float: left;"></span></div>');
			
			//// LOADS THE MARKUP VIA AJAX
			jQuery.ajax({
				
				url: 				ajaxurl,
				type: 				'post',
				dataType: 			'html',
				data: {
					
					action: 		'_sf_form_load_if_field',
					field_id:		post_id
					
				},
				success: function(data) {
					
					//// IF NO DATA SOMETHING WENT WRONG
					if(data == '') {
						
						alert('Could not load the field dropped. Please make sure the field you have dropped is a dropdown, minimum value or maximum value.');
						ulCont.siblings('.the-if-field').remove();
						ulCont.show();
						
					} else {
					
						var ifCont = ulCont.siblings('.the-if-field');
						ifCont.find('spinner').remove();
						
						ifCont.html(data);
						
						//// APPENDS A REFRESH EVENT TO THE NEW FIELD
						ifCont.find('select, input').change(function() {
							
							jQuery('#the_form').refreshFormFields();
							
						});
						
							jQuery('#the_form').refreshFormFields();
						
					}
					
				}
				
			});
			
		},
		
		remove_this_if_field: function() {
			
			var button = this;
			var mainCont = this.parent().parent();
			
			//// REMOVES IT
			mainCont.siblings('ul').show();
			mainCont.remove();
			
			//// REFRESHES THE FORM
			jQuery('#the_form').refreshFormFields();
			
		},
		
		_sf_add_attachemnt_to_gallery: function() {
			
			var attachment = this;
			var attachment_id = attachment.find('img').attr('title');
			var attachment_image = attachment.find('img').attr('src');
			
			 jQuery('#_sf_gallery > ul').append('<li><input type="hidden" name="image_id" value="'+attachment_id+'"><img src="'+attachment_image+'" alt="" /><span class="remove" onclick="jQuery(this).removeFromGallery();"><i class="icon-trash"></i></span></li>');
			 
			 jQuery('#_sf_gallery ul._sf_images').refreshSpotGallery();
			
		}
		
	});
	
})(jQuery);


function generateRandomId() {
	
	var numLow = 1;
	var numHigh = 5000;
	var adjustedHigh = (parseFloat(numHigh) - parseFloat(numLow)) + 1;
	var numRand = Math.floor(Math.random()*adjustedHigh) + parseFloat(numLow);
	return numRand;
	
}

function sortTheForm() {
	
	
	jQuery('select[name="field_if_values"], input[name="field_if_values_any"]').change(function() {
		
		jQuery('#the_form').refreshFormFields();
		
	});
	
		
	jQuery('#the-fields li').draggable({
		
		connectToSortable: "#the-form li ul, .field-if",
		revert: "invalid",
		helper: 'clone',
		cursorAt: {
			
			left: 120,
			top: 12
			
		},
		start: function(event, ui) {
			
			//// MAKES IT SAME WIDTH AS THE FORM ELEMENT
			var theWidth = jQuery('#the-form ul').width();
			jQuery('#the-fields .ui-draggable-dragging').css({ width: theWidth-20, height: '17px' });
			
		}
		
	});
	
	jQuery('#the-form ul').sortable({
		
		handle: jQuery('#the-form .head'),
		items: '> li',
		connectWith: '#the-form ul',
		receive: function(event, ui) {
			
			var targetEl = this;
			
			if(jQuery(targetEl).attr('class').indexOf('field-if') != -1) {
				
				jQuery('#the-form ul').sortable('cancel');
				
				if(jQuery('#the-form .ui-draggable').length > 0) {
				
					////REMOVES THE ELEMENT WE JUST DROPPED AND REBUILD THE MARKUP
					var the_index = jQuery('#the-form .ui-draggable').index();
					var _the_ul_index = jQuery('#the-form .ui-draggable').parent().parent().attr('class').split('-');
					var the_ul_index = _the_ul_index[2];
					
					jQuery('#the-form .ui-draggable').remove();
					
					//// GETS OUR FIELD PROPERTIES
					var theHtml = jQuery(ui.helper.context.outerHTML);
					var theId = theHtml.find('.the_id').text();
				
				} else {
					
					//// GETS OUR FIELD PROPERTIES
					var theHtml = jQuery(ui.item.context.outerHTML);
					var theId = theHtml.find('input[name="the_id"]').val();
					
				}
				
				//// NOW LET'S HIDE THIS UL AND LOAD OUR NEW IF AREA
				jQuery(targetEl)._sf_load_if_field(theId);
				
			} else {
			
				//// IF WAS A DRAGGABLE
				if(ui.helper != null) {
					
				
					////REMOVES THE ELEMENT WE JUST DROPPED AND REBUILD THE MARKUP
					var the_index = jQuery('#the-form .ui-draggable').index();
					var _the_ul_index = jQuery('#the-form .ui-draggable').parent().parent().attr('class').split('-');
					var the_ul_index = _the_ul_index[2];
					
					jQuery('#the-form .ui-draggable').remove();
					
					//// GETS OUR FIELD PROPERTIES
					var theHtml = jQuery(ui.helper.context.outerHTML);
					
					var theLabel = theHtml.find('h4').text();
					var theId = theHtml.find('.the_id').text();
					var theSlug = theHtml.find('.the_slug').text();
					var icon = theHtml.find('.icon').html();
					var the_type = theHtml.find('.the_type').text();
					
					var markup = '<li class="field-id-'+theId+'">'+
								'<div class="head" onclick="jQuery(this).openInsider(); jQuery(\'#the_form\').refreshFormFields();">'+
								'<span class="title">'+icon+''+theLabel+'</span>'+
								'<span class="arrow"></span>'+
								'</div><div class="insider" style="display: none;">';
								
					//// IF THE ID IS 0
					if(parseInt(theId) == 0) {
						
					markup += '<div class="bDivider" style="margin: 10px 0;"></div>';
						
					} else {
						
					markup += '<label>Label</label>'+
								'<input type="text" class="widefat field_label" value="'+theLabel+'" onblur="jQuery(this).refreshFormFields();" />' +
								'<div class="bDivider" style="margin: 10px 0;"></div>';
								
					
					//// CHECKS FOR WPML LABELS
					if(theHtml.find('.the_lang_code').length > 0) {
						
						theHtml.find('.the_lang_code').each(function() {
							
							//// ADDS THIS TO THE MARKUP
							markup += '<label>'+theHtml.find('.the_lang_label_'+jQuery(this).text()).html()+'</label>'+
										'<input type="text" class="widefat value_name_wpml value_name_wpml_'+jQuery(this).text()+'" data-lang="'+jQuery(this).text()+'" value="" onblur="jQuery(this).refreshFormFields();" />' +
										'<div class="bDivider" style="margin: 10px 0;"></div>';
							
						});
						
					}
								
								
					markup += '<label>Only show this field if:</label><ul class="field-if"><li class="no-item">Drop field here</li></ul>';
						
					}
								
					markup += '<input type="button" class="button" value="Remove Field" onclick="jQuery(this).removeThisFormField();" />'+
								'<input type="hidden" name="field_type" value="'+the_type+'" /><input type="hidden" name="the_id" value="'+theId+'" /><input type="hidden" name="the_slug" value="'+theSlug+'" /></div></li>';
								
					//// IF THERE'S NO ITEMS YET
					if(jQuery('#the-form > li.col-index-'+the_ul_index+' > ul > li').length < 1) {
						
						jQuery('#the-form > li.col-index-'+the_ul_index+' > ul').html(markup);
						
					} else {
								
						//// ADDS THE MARKUP
						jQuery('#the-form > li.col-index-'+the_ul_index+' > ul > li:eq('+(the_index-1)+')').after(markup);
						
					}
				
				}
				
			}
			
			sortTheForm();
			
		},
		stop: function(event, ui) {
			
			jQuery('#the_form').refreshFormFields();
			
		}
		
	});
	
}

/**
 * jQuery Masonry v2.1.08
 * A dynamic layout plugin for jQuery
 * The flip-side of CSS Floats
 * http://masonry.desandro.com
 *
 * Licensed under the MIT license.
 * Copyright 2012 David DeSandro
 */
(function(e,t,n){"use strict";var r=t.event,i;r.special.smartresize={setup:function(){t(this).bind("resize",r.special.smartresize.handler)},teardown:function(){t(this).unbind("resize",r.special.smartresize.handler)},handler:function(e,t){var n=this,s=arguments;e.type="smartresize",i&&clearTimeout(i),i=setTimeout(function(){r.dispatch.apply(n,s)},t==="execAsap"?0:100)}},t.fn.smartresize=function(e){return e?this.bind("smartresize",e):this.trigger("smartresize",["execAsap"])},t.Mason=function(e,n){this.element=t(n),this._create(e),this._init()},t.Mason.settings={isResizable:!0,isAnimated:!1,animationOptions:{queue:!1,duration:500},gutterWidth:0,isRTL:!1,isFitWidth:!1,containerStyle:{position:"relative"}},t.Mason.prototype={_filterFindBricks:function(e){var t=this.options.itemSelector;return t?e.filter(t).add(e.find(t)):e},_getBricks:function(e){var t=this._filterFindBricks(e).css({position:"absolute"}).addClass("masonry-brick");return t},_create:function(n){this.options=t.extend(!0,{},t.Mason.settings,n),this.styleQueue=[];var r=this.element[0].style;this.originalStyle={height:r.height||""};var i=this.options.containerStyle;for(var s in i)this.originalStyle[s]=r[s]||"";this.element.css(i),this.horizontalDirection=this.options.isRTL?"right":"left";var o=this.element.css("padding-"+this.horizontalDirection),u=this.element.css("padding-top");this.offset={x:o?parseInt(o,10):0,y:u?parseInt(u,10):0},this.isFluid=this.options.columnWidth&&typeof this.options.columnWidth=="function";var a=this;setTimeout(function(){a.element.addClass("masonry")},0),this.options.isResizable&&t(e).bind("smartresize.masonry",function(){a.resize()}),this.reloadItems()},_init:function(e){this._getColumns(),this._reLayout(e)},option:function(e,n){t.isPlainObject(e)&&(this.options=t.extend(!0,this.options,e))},layout:function(e,t){for(var n=0,r=e.length;n<r;n++)this._placeBrick(e[n]);var i={};i.height=Math.max.apply(Math,this.colYs);if(this.options.isFitWidth){var s=0;n=this.cols;while(--n){if(this.colYs[n]!==0)break;s++}i.width=(this.cols-s)*this.columnWidth-this.options.gutterWidth}this.styleQueue.push({$el:this.element,style:i});var o=this.isLaidOut?this.options.isAnimated?"animate":"css":"css",u=this.options.animationOptions,a;for(n=0,r=this.styleQueue.length;n<r;n++)a=this.styleQueue[n],a.$el[o](a.style,u);this.styleQueue=[],t&&t.call(e),this.isLaidOut=!0},_getColumns:function(){var e=this.options.isFitWidth?this.element.parent():this.element,t=e.width();this.columnWidth=this.isFluid?this.options.columnWidth(t):this.options.columnWidth||this.$bricks.outerWidth(!0)||t,this.columnWidth+=this.options.gutterWidth,this.cols=Math.floor((t+this.options.gutterWidth)/this.columnWidth),this.cols=Math.max(this.cols,1)},_placeBrick:function(e){var n=t(e),r,i,s,o,u;r=Math.ceil(n.outerWidth(!0)/this.columnWidth),r=Math.min(r,this.cols);if(r===1)s=this.colYs;else{i=this.cols+1-r,s=[];for(u=0;u<i;u++)o=this.colYs.slice(u,u+r),s[u]=Math.max.apply(Math,o)}var a=Math.min.apply(Math,s),f=0;for(var l=0,c=s.length;l<c;l++)if(s[l]===a){f=l;break}var h={top:a+this.offset.y};h[this.horizontalDirection]=this.columnWidth*f+this.offset.x,this.styleQueue.push({$el:n,style:h});var p=a+n.outerHeight(!0),d=this.cols+1-c;for(l=0;l<d;l++)this.colYs[f+l]=p},resize:function(){var e=this.cols;this._getColumns(),(this.isFluid||this.cols!==e)&&this._reLayout()},_reLayout:function(e){var t=this.cols;this.colYs=[];while(t--)this.colYs.push(0);this.layout(this.$bricks,e)},reloadItems:function(){this.$bricks=this._getBricks(this.element.children())},reload:function(e){this.reloadItems(),this._init(e)},appended:function(e,t,n){if(t){this._filterFindBricks(e).css({top:this.element.height()});var r=this;setTimeout(function(){r._appended(e,n)},1)}else this._appended(e,n)},_appended:function(e,t){var n=this._getBricks(e);this.$bricks=this.$bricks.add(n),this.layout(n,t)},remove:function(e){this.$bricks=this.$bricks.not(e),e.remove()},destroy:function(){this.$bricks.removeClass("masonry-brick").each(function(){this.style.position="",this.style.top="",this.style.left=""});var n=this.element[0].style;for(var r in this.originalStyle)n[r]=this.originalStyle[r];this.element.unbind(".masonry").removeClass("masonry").removeData("masonry"),t(e).unbind(".masonry")}},t.fn.imagesLoaded=function(e){function u(){e.call(n,r)}function a(e){var n=e.target;n.src!==s&&t.inArray(n,o)===-1&&(o.push(n),--i<=0&&(setTimeout(u),r.unbind(".imagesLoaded",a)))}var n=this,r=n.find("img").add(n.filter("img")),i=r.length,s="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",o=[];return i||u(),r.bind("load.imagesLoaded error.imagesLoaded",a).each(function(){var e=this.src;this.src=s,this.src=e}),n};var s=function(t){e.console&&e.console.error(t)};t.fn.masonry=function(e){if(typeof e=="string"){var n=Array.prototype.slice.call(arguments,1);this.each(function(){var r=t.data(this,"masonry");if(!r){s("cannot call methods on masonry prior to initialization; attempted to call method '"+e+"'");return}if(!t.isFunction(r[e])||e.charAt(0)==="_"){s("no such method '"+e+"' for masonry instance");return}r[e].apply(r,n)})}else this.each(function(){var n=t.data(this,"masonry");n?(n.option(e||{}),n._init()):t.data(this,"masonry",new t.Mason(e,this))});return this}})(window,jQuery);





(function(t,e){if(typeof exports=="object")module.exports=e();else if(typeof define=="function"&&define.amd)define(e);else t.Spinner=e()})(this,function(){"use strict";var t=["webkit","Moz","ms","O"],e={},i;function o(t,e){var i=document.createElement(t||"div"),o;for(o in e)i[o]=e[o];return i}function n(t){for(var e=1,i=arguments.length;e<i;e++)t.appendChild(arguments[e]);return t}var r=function(){var t=o("style",{type:"text/css"});n(document.getElementsByTagName("head")[0],t);return t.sheet||t.styleSheet}();function s(t,o,n,s){var a=["opacity",o,~~(t*100),n,s].join("-"),f=.01+n/s*100,l=Math.max(1-(1-t)/o*(100-f),t),d=i.substring(0,i.indexOf("Animation")).toLowerCase(),u=d&&"-"+d+"-"||"";if(!e[a]){r.insertRule("@"+u+"keyframes "+a+"{"+"0%{opacity:"+l+"}"+f+"%{opacity:"+t+"}"+(f+.01)+"%{opacity:1}"+(f+o)%100+"%{opacity:"+t+"}"+"100%{opacity:"+l+"}"+"}",r.cssRules.length);e[a]=1}return a}function a(e,i){var o=e.style,n,r;if(o[i]!==undefined)return i;i=i.charAt(0).toUpperCase()+i.slice(1);for(r=0;r<t.length;r++){n=t[r]+i;if(o[n]!==undefined)return n}}function f(t,e){for(var i in e)t.style[a(t,i)||i]=e[i];return t}function l(t){for(var e=1;e<arguments.length;e++){var i=arguments[e];for(var o in i)if(t[o]===undefined)t[o]=i[o]}return t}function d(t){var e={x:t.offsetLeft,y:t.offsetTop};while(t=t.offsetParent)e.x+=t.offsetLeft,e.y+=t.offsetTop;return e}var u={lines:12,length:7,width:5,radius:10,rotate:0,corners:1,color:"#000",direction:1,speed:1,trail:100,opacity:1/4,fps:20,zIndex:2e9,className:"spinner",top:"auto",left:"auto",position:"relative"};function p(t){if(typeof this=="undefined")return new p(t);this.opts=l(t||{},p.defaults,u)}p.defaults={};l(p.prototype,{spin:function(t){this.stop();var e=this,n=e.opts,r=e.el=f(o(0,{className:n.className}),{position:n.position,width:0,zIndex:n.zIndex}),s=n.radius+n.length+n.width,a,l;if(t){t.insertBefore(r,t.firstChild||null);l=d(t);a=d(r);f(r,{left:(n.left=="auto"?l.x-a.x+(t.offsetWidth>>1):parseInt(n.left,10)+s)+"px",top:(n.top=="auto"?l.y-a.y+(t.offsetHeight>>1):parseInt(n.top,10)+s)+"px"})}r.setAttribute("role","progressbar");e.lines(r,e.opts);if(!i){var u=0,p=(n.lines-1)*(1-n.direction)/2,c,h=n.fps,m=h/n.speed,y=(1-n.opacity)/(m*n.trail/100),g=m/n.lines;(function v(){u++;for(var t=0;t<n.lines;t++){c=Math.max(1-(u+(n.lines-t)*g)%m*y,n.opacity);e.opacity(r,t*n.direction+p,c,n)}e.timeout=e.el&&setTimeout(v,~~(1e3/h))})()}return e},stop:function(){var t=this.el;if(t){clearTimeout(this.timeout);if(t.parentNode)t.parentNode.removeChild(t);this.el=undefined}return this},lines:function(t,e){var r=0,a=(e.lines-1)*(1-e.direction)/2,l;function d(t,i){return f(o(),{position:"absolute",width:e.length+e.width+"px",height:e.width+"px",background:t,boxShadow:i,transformOrigin:"left",transform:"rotate("+~~(360/e.lines*r+e.rotate)+"deg) translate("+e.radius+"px"+",0)",borderRadius:(e.corners*e.width>>1)+"px"})}for(;r<e.lines;r++){l=f(o(),{position:"absolute",top:1+~(e.width/2)+"px",transform:e.hwaccel?"translate3d(0,0,0)":"",opacity:e.opacity,animation:i&&s(e.opacity,e.trail,a+r*e.direction,e.lines)+" "+1/e.speed+"s linear infinite"});if(e.shadow)n(l,f(d("#000","0 0 4px "+"#000"),{top:2+"px"}));n(t,n(l,d(e.color,"0 0 1px rgba(0,0,0,.1)")))}return t},opacity:function(t,e,i){if(e<t.childNodes.length)t.childNodes[e].style.opacity=i}});function c(){function t(t,e){return o("<"+t+' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">',e)}r.addRule(".spin-vml","behavior:url(#default#VML)");p.prototype.lines=function(e,i){var o=i.length+i.width,r=2*o;function s(){return f(t("group",{coordsize:r+" "+r,coordorigin:-o+" "+-o}),{width:r,height:r})}var a=-(i.width+i.length)*2+"px",l=f(s(),{position:"absolute",top:a,left:a}),d;function u(e,r,a){n(l,n(f(s(),{rotation:360/i.lines*e+"deg",left:~~r}),n(f(t("roundrect",{arcsize:i.corners}),{width:o,height:i.width,left:i.radius,top:-i.width>>1,filter:a}),t("fill",{color:i.color,opacity:i.opacity}),t("stroke",{opacity:0}))))}if(i.shadow)for(d=1;d<=i.lines;d++)u(d,-2,"progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)");for(d=1;d<=i.lines;d++)u(d);return n(e,l)};p.prototype.opacity=function(t,e,i,o){var n=t.firstChild;o=o.shadow&&o.lines||0;if(n&&e+o<n.childNodes.length){n=n.childNodes[e+o];n=n&&n.firstChild;n=n&&n.firstChild;if(n)n.opacity=i}}}var h=f(o("group"),{behavior:"url(#default#VML)"});if(!a(h,"transform")&&h.adj)c();else i=a(h,"animation");return p});






(function(factory) {

  if (typeof exports == 'object') {
    // CommonJS
    factory(require('jquery'), require('spin'))
  }
  else if (typeof define == 'function' && define.amd) {
    // AMD, register as anonymous module
    define(['jquery', 'spin'], factory)
  }
  else {
    // Browser globals
    if (!window.Spinner) throw new Error('Spin.js not present')
    factory(window.jQuery, window.Spinner)
  }

}(function($, Spinner) {

  $.fn.spin = function(opts, color) {

    return this.each(function() {
      var $this = $(this),
        data = $this.data();

      if (data.spinner) {
        data.spinner.stop();
        delete data.spinner;
      }
      if (opts !== false) {
        opts = $.extend(
          { color: color || $this.css('color') },
          $.fn.spin.presets[opts] || opts
        )
        data.spinner = new Spinner(opts).spin(this)
      }
    })
  }

  $.fn.spin.presets = {
    tiny: { lines: 8, length: 2, width: 2, radius: 3 },
    small: { lines: 8, length: 4, width: 3, radius: 5 },
    large: { lines: 10, length: 8, width: 4, radius: 8 }
  }

}));