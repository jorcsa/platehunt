(function($){ 

    $.fn.extend({
		
		btoaDropdown: function() {
			
			var mainCont = this;
			
			mainCont.find('li').hoverIntent(function() {
				
				jQuery(this).addClass('hovered').children('ul').slideDown(200);
				
			}, function() {
				
				jQuery(this).removeClass('hovered').children('ul').slideUp(200);
				
			});
			
		},
		
		replaceSelect: function() {
			
			//// vars
			var selCont = this;
			
			//// WRAPS IT AROUND SELECT
			selCont.wrap('<div class="select-replace"></div>');
			var mainCont = selCont.parent();
			var selectedItem = selCont.find('option:selected');
			mainCont.append('<span>'+selectedItem.text()+'</span><i class="icon-sort"></i>');
			var mainContHeight = mainCont.height();
			
			//// MAKES IT OVERLAY THE CONTAINER
			selCont.css({ display: 'block', opacity: 0 });
			
			//// ALSO ADDS OTHER CLASSES TO OUR REPLACE CONTAINER
			var allClass = selCont.attr('class');
			mainCont.addClass(allClass);

			//// WHEN WE CHANGE SELECT
			selCont.change(function() {
				
				//// NEW SELECTED ITEM
				var selectedItem = selCont.find('option:selected');
				mainCont.children('span').text(selectedItem.text());
				
			});
			
		},
		
		replaceCheckbox: function() {
			
			//// vars
			var selCont = this;
			
			//// WRAPS IT AROUND SELECT
			selCont.wrap('<div class="checkbox-replace"></div>');
			var mainCont = selCont.parent();
			mainCont.append('<i class="icon-ok"></i>');
			
			//// IF IT'S CHECKED
			if(selCont.is(':checked')) { mainCont.addClass('checkbox-replace-checked'); }
			
			//// MAKES IT OVERLAY THE CONTAINER
			selCont.css({ display: 'none' });
			
			//// ALSO ADDS OTHER CLASSES TO OUR REPLACE CONTAINER
			var allClass = selCont.attr('class');
			mainCont.addClass(allClass);
			
			//// WHEN WE CLICK THE MAIN CONTAINER
			mainCont.click(function() {
				
				//// IF IT'S CHECKED
				if(jQuery(this).attr('class').indexOf('checked') != -1) {
					
					//// UNCHECKS IT
					jQuery(this).removeClass('checkbox-replace-checked');
					selCont.removeAttr('checked');
					selCont.trigger('change');
					
				} else {
					
					//// UNCHECKS IT
					jQuery(this).addClass('checkbox-replace-checked');
					selCont.attr('checked', 'checked');
					selCont.trigger('change');
					
				}
				
			});
			
		},
		
		replaceRadio: function() {
			
			//// vars
			var selCont = this;
			
			//// WRAPS IT AROUND SELECT
			selCont.wrap('<div class="radio-replace"></div>');
			var mainCont = selCont.parent();
			mainCont.append('<i class="dot"></i>');
			
			//// IF IT'S CHECKED
			if(selCont.is(':checked')) { mainCont.addClass('radio-replace-checked'); }
			
			//// MAKES IT OVERLAY THE CONTAINER
			selCont.css({ display: 'none' });
			
			//// WHEN WE CLICK THE MAIN CONTAINER
			mainCont.click(function() {
				
				//// UNCHECK ALL RADIOS WITH THIS NAME
				var theName = jQuery(this).children('input').attr('name');
				jQuery('input[name="'+theName+'"]').removeAttr('checked').parent().removeClass('radio-replace-checked');
				
				//// IF IT'S CHECKED
				if(jQuery(this).attr('class').indexOf('checked') != -1) {
					
					//// UNCHECKS IT
					jQuery(this).removeClass('radio-replace-checked');
					selCont.removeAttr('checked');
					
				} else {
					
					//// UNCHECKS IT
					jQuery(this).addClass('radio-replace-checked');
					selCont.attr('checked', 'checked');
					
				}
				
			});
			
		},
		
		btoaReloadDependentField: function(sel, this_id, callback) {
			
			var mainCont = this;
			
			//// PUTS A LOADING SIGN ON OUR SELECT
			mainCont.find('option').remove();
			mainCont.siblings('span').html('&nbsp;').spin({ lines: 7, length: 0, width: 4, radius: 4, color: '#333', corners: 1, speed: 2.2});
			
			//// CANCELS ANY QUERIES ALREAYD IN PLACE
			if(typeof dependent_query != 'undefined') { dependent_query.abort(); }
			
			//// IF OUR PARENT IS SET AS 0 VAL WE DONT EVEN NEED TO LOAD THIS VIA AJAX
			if(sel == '' || sel == 0 || !sel || sel == '-') {
				
				mainCont.siblings('span').html('-').spin(false);
				mainCont.append('<option values="0">-</option>');
						
				//// NOW THAT WE HAVE CHANGES OUR VALUES LETS TRIGGER A CHANGE SO WE CAN LOAD OTHER FIELDS
				mainCont.trigger('change');
				
				//// CALLS CALLBACK
				if(typeof callback == 'function') {
					
					callback.call(this);
					
				}
				
				return false;
				
			}
			
			//// DOES AN AJAX CALL TO GET THE DEPENDENT FIELDS BASED ON THE CHOSEN PARENT
			dependent_query = jQuery.ajax({
				
				url: 		sf.ajaxurl,
				type: 		'post',
				dataType: 	'json',
				data: {
					
					action: 		'reload_dependent_fields',
					nonce: 			sf.dependent_fields_nonce,
					parent: 		sel,
					post_id: 		this_id
					
				},
				success: function(data) {
					
					//// IF ANY ERRORS
					if(data.error) {
						
						//// PUTS BACK THE DASH SIGN AND REMOVES THE LOADING SIGN
						mainCont.siblings('span').html('-').spin(false);
						mainCont.append('<option values="0">-</option>');
						
					} else {
						
						//// LOOPS OUR FIELDS
						jQuery.each(data.fields, function(i, obj) {
							
							//// IF ITS OUR FIRST ONE
							if(i === 0) {
								
								mainCont.siblings('span').html(obj.label).spin(false);
								
							}
							
							//// ADDS IT TO OUR SELECT
							mainCont.append('<option value="'+obj.id+'">'+obj.label+'</option>');
							
						});
						
					}
						
					//// NOW THAT WE HAVE CHANGES OUR VALUES LETS TRIGGER A CHANGE SO WE CAN LOAD OTHER FIELDS
					mainCont.trigger('change');
					
					//// CALLS CALLBACK
					if(typeof callback == 'function') {
						
						callback.call(this);
						
					}
					
				}
				
			})
			
		},
		
		btoaLoadGooglePlacesSuggestions: function(default_text, country_code) {
			
			var inputCont = this;
			var ulCont = inputCont.siblings('ul');
			
			var autoCompleteOptions = {
				
				types: ['(regions)']
				
			}
			
			//// IF WE'VE SET A COUNTRY
			if(typeof country_code != 'undefined' && country_code != '') { autoCompleteOptions.componentRestrictions = { country: country_code }; }
			else { country_code = ''; }
			
			var elementId = inputCont.attr('id');
			
			var autocomplete = new google.maps.places.Autocomplete(document.getElementById(elementId), autoCompleteOptions);
			
			///// LETS ADD AN EVENT TO OUR MAP
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				
				//// GETS OUR PLACE
				var place = autocomplete.getPlace();
				var map = jQuery('#slider-map').gmap3('get');
				
				if (!place.geometry) {
					
					
					
				} else {
					
					//// MAKES SURE WE HAVE GEOMETRY
					if(place.geometry) {
						//// IF WE HAVE A VIEWPORT LETS FIT TO BOUNDS
						if(place.geometry.viewport) {
// DAHERO #1667521 STRT
							/// CENTER THE MAP THERE AND FIT IT TO BOUNDS
							if (map.length != 0) map.fitBounds(place.geometry.viewport);
					
							///// NOW WE NEED TO SET OUR TWO LAT AND LNG POINTS SO WE CAN FILTER RESULTS BASED ON THIS SELECTION
							var latRange = place.geometry.viewport.getSouthWest().lat()+'|'+place.geometry.viewport.getNorthEast().lat();
							var lngRange = place.geometry.viewport.getSouthWest().lng()+'|'+place.geometry.viewport.getNorthEast().lng();
							inputCont.parent().siblings('._sf_field_places_lat').val(latRange);
							inputCont.parent().siblings('._sf_field_places_lng').val(lngRange);
							
							jQuery('#search-spots').submit();
						
						} else if (map.length != 0) {
// DAHERO #1667521 STOP							
							//// LET JUST CENTER IT
							map.panTo(place.geometry.location);
							map.setZoom(16);
							
						}
						
					}
					
				}
				
			});
			
			////// WE NEED TO MAKE SURE WE DESTROY WHATEVER LATITUDE AND LONGITUDE THERE IS
			inputCont.attr('autocomplete', 'off').keyup(function(e) {
				
				//// ONLY GO IF USER HAS TYPED AN ALPHABETICAL KEY
				if(	e.which == 32 ||
					e.which == 8 ||
					e.which == 48 ||
					e.which == 49 ||
					e.which == 96 ||
					e.which == 106 ||
					(e.which >= 50 && e.which <= 57) || 
					(e.which >= 65 && e.which <= 90) || 
					(e.which >= 186 && e.which <= 192) || 
					(e.which >= 219 && e.which <= 222)) {
						
					inputCont.parent().siblings('._sf_field_places_lat').val('');
					inputCont.parent().siblings('._sf_field_places_lng').val('');
						
				}
				
			});
			
			inputCont.focusout(function() {
				
				jQuery('#search-spots').submit();
				
			});
			
		},
		
		btoaLoadTagSuggestions: function(default_text) {
			
			var inputCont = this;
			var ulCont = inputCont.siblings('ul');
			
			//// AS USER STARTS TYPING WE CHECK FOR THE CHARACTERS
			inputCont.attr('autocomplete', 'off').keyup(function(e) {
				
				//// ONLY GO IF USER HAS TYPED AN ALPHABETICAL KEY
				if(	e.which == 32 ||
					e.which == 8 ||
					e.which == 48 ||
					e.which == 49 ||
					e.which == 96 ||
					e.which == 106 ||
					(e.which >= 50 && e.which <= 57) || 
					(e.which >= 65 && e.which <= 90) || 
					(e.which >= 186 && e.which <= 192) || 
					(e.which >= 219 && e.which <= 222)) {
						
					//// LET'S SHOW OUR CONTENT AND DISPLAY A LOADING SIGN
					ulCont.html('').show().spin({ lines: 7, length: 0, width: 4, radius: 4, color: '#333', corners: 1, speed: 2.2});
					
					var searchString = inputCont.val();
					
					//// IF STRING ISNT EMPTY
					if(searchString != '') {
						
						//// IF OUR AJAX GLOBAL IS SET WE ABOR IT
						if(typeof theAutoLoad != 'undefined') { theAutoLoad.abort(); }
						
						//// DOES AN AJAX QUERY TO LOOK FOR TAGS
						theAutoLoad = jQuery.ajax({
							
							url: 				sf.ajaxurl,
							type: 				'post',
							dataType: 			'json',
							data: {
								
								action: 		'load_tag_suggestions',
								nonce: 			sf.load_tag_suggestions_nonce,
								string: 		searchString
								
							},
							success: function(data) {
								
								//// IF DATA IS EMPTY WE JUST HIDE THE SUGGESTIONS
								if(!data.results) {
									
									ulCont.spin(false).hide();
									
								} else {
									
									//// IF NO RESULTS
									if(data.results.length === 0) {
										
										ulCont.spin(false).hide();
										
									}
									
									ulCont.spin(false);
									
									//// GO THROUGH EACH RESULTS AND THEN APPEND IT TO THE UL, BOLDING THE MATCHED INPUT
									jQuery.each(data.results, function(i, obj) {
										
										var the_string = obj.name.replace(searchString, '<strong>'+searchString+'</strong>');
										
										//// APPEND IT TO THE UL
										ulCont.append('<li onclick="jQuery(this).search_the_keyword()">'+the_string+'</li>');
										
									});
					
									//// IF WE CLICK ANY OF THE HIGHTLIGHTS
									ulCont.children('li').hover(function() {
										
										jQuery(this).siblings('.highlight').removeClass('highlight');
										jQuery(this).addClass('highlight');
										
									});
									
								}
								
							}
							
						});
						
					} else {
						
						ulCont.spin(false).hide();
						
					}
						
				}
				
			});
			
			inputCont.focusout(function() {
			
				var thisLi = ulCont.children('li.highlight');
				var inputCont = ulCont.siblings('input');
				
				//// IF HIGHLIGHT IS SET
				if(thisLi.length > 0) { inputCont.val(thisLi.text()); thisLi.parent().hide(); ulCont.html(''); }
										
				if(ulCont.children('li').length > 0) { ulCont.html('').hide(); }
				
				//// SUBMIT FORM
				jQuery('#search-spots').submit();
				
			});
				
				/// IS THE USER PRESSES THE DOEN KEY
				inputCont.keyup(function(d) {
					
					//// IF USER HAS PRESSED KEY DOWN
					if(d.which == 40 || d.which == 38 || d.which == 13) {
						
						//// IF USER AHS PRESSED DOWN
						if(d.which == 40) {
						
							//// IF USER HAS PRESSED DOWN WE CHECK FOR RESULTS WITHIN OUR LI
							//// IF THERE IS CONTENT WE MAKE ONE OF THE SELECTED
							if(ulCont.find('li').length > 0) {
								
								//// IF THERE IS NONE SELECTED WE SELECT THE FIRST
								if(ulCont.find('> li.highlight').length > 0) {
									
									/// IF ITS NOT THE LAST ONE
									var thisActive = ulCont.children('li.highlight');
									var nextActive = ulCont.children('li.highlight').next();
									
									//// IF THERE IS A NEXT
									if(nextActive.length > 0) {
										
										thisActive.removeClass('highlight');
										nextActive.addClass('highlight');
										
									}
									
								} else {
									
									ulCont.children('li:eq(0)').addClass('highlight');
									
								}
								
							}
							
						} else if(d.which == 38) {
						
							//// IF USER HAS PRESSED UP WE CHECK FOR RESULTS WITHIN OUR LI
							//// IF THERE IS CONTENT WE MAKE ONE OF THE SELECTED
							if(ulCont.children('li').length > 0) {
								
								//// IF THERE IS NONE SELECTED WE SELECT THE FIRST
								if(ulCont.children('li.highlight').length > 0) {
									
									/// IF ITS NOT THE LAST ONE
									var thisActive = ulCont.children('li.highlight');
									var nextActive = ulCont.children('li.highlight').prev();
									
									//// IF THERE IS A NEXT
									if(nextActive.length > 0) {
										
										thisActive.removeClass('highlight');
										nextActive.addClass('highlight');
										
									} else {
										
										ulCont.children('li.highlight').removeClass('highlight');
										
									}
									
								}
								
							}
							
						}
						
						if(d.which == 13) {
								
							ulCont.search_the_keyword();
							ulCont.children('li.highlight').removeClass('highlight');
							
						}
						
						/// RETURN FALSE
						d.preventDefault();
						return false;
						
					}
					
				});
			
		},
		
		search_the_keyword: function() {
			
			var ulCont = this;
			var thisLi = this.children('li.highlight');
			var inputCont = ulCont.siblings('input');
			
			//// IF HIGHLIGHT IS SET
			if(thisLi.length > 0) { inputCont.val(thisLi.text()); thisLi.parent().hide(); ulCont.html(''); }
			
			inputCont.blur();
			
			
		},
		
		spot_slider_scroll: function() {
			
			var mainCont = this;
			var ulCont = mainCont.find('ul:first');
			
			///// SETS THE WIDTH OF OUR LIS
			var liWidth = ulCont.find('li:first').width();
			
			ulCont.children('li').width(liWidth);
			
			//// ADDS THE SPOT CLASS
			mainCont.addClass('spots-short-slider');
			
			mainCont.mCustomScrollbar({
				
				horizontalScroll:true
				
			});
			
		},
		
		_sf_spot_single_gallery: function() {
			
			// vars
			var mainCont = this;
			var mainImage = jQuery('#spot-gallery-main');
			var ulCont = jQuery('#spot-gallery-thumbs ul');
			
			//// FIRST LETS FIX OUR IMAGE POSITIONING
			//mainImage.find('img').css({ position: 'absolute' });
			
			///// WHEN THE USER CLICKS A THUMBNAILS
			ulCont.find('li').click(function() {
				
				///// IF ITS NOT CURRENT
				if(jQuery(this).attr('class').indexOf('current') == -1) {
					
					var thisLi = jQuery(this);
					
					//// CHANGES THE CURRENT
					jQuery(this).siblings('.current').removeClass('current');
					jQuery(this).addClass('current');
					
					var imgHeight = mainCont.find('img').height();
					mainImage.css('height', imgHeight+'px');
					
					//// LETS ADD A LOADING SIGN AND FADEOUT THE CURRENT IMAGE
					mainImage.spin({ lines: 11, length: 9, width: 4, radius: 11, corners: 1, speed: 2, shadow: false });
					mainImage.find('img').fadeOut(200, function() {
					
						///// LETS LOAD OUR NEW IMAGE
						var imageUrl = thisLi.find('.main').text();
						var img = new Image();
						jQuery(img).attr('src', imageUrl).load(function() {
							
							//// LETS APPEND OUR NEW IMAGE TO OUR MAIN COINTAINER
							mainImage.find('img').remove();
							mainImage.find('a').append(this);
							mainImage.find('img').hide();
							mainImage.find('img').css({ position: 'relative' });
					
							var imgHeight = mainCont.find('img').height();
							mainImage.css('height', imgHeight+'px');
							
							///// FADES IT IN
							mainImage.spin(false).find('img').fadeIn(200);
							
						});
						
						//// UPDATES OUR HREF TAG
						var fullImage = thisLi.find('.full').attr('href');
						mainImage.find('a').attr('href', fullImage);
						
					});
					
				}
				
			});
			
			//// WHEN THE USER CLICKS THE A FOR THE MAIN IMAGE
			mainImage.find('a').click(function(e) {
				
				//// GETS THE THUMBNAIL INDEX
				ulCont.find('li.current').index();
				
				//// TRIGGERS A CLICK ON IT
				ulCont.find('li.current a.full').trigger('click');
				
				//// PREVENTS FROM OPENIONG IT
				e.preventDefault();
				return false;
				
			});
			
			///// DEALS WITH OUR THUMBNAIL SLIDER
			if(!Modernizr.touch) {
				
				ulCont.parent().mousemove(function(e) {
					
					/// LETS CALCULATE A FEW VALUES
					var liWidth = ulCont.find('li:first').width();
					var liLength = ulCont.find('li').length;
					var maxLeft = ((liLength * (liWidth + 6 + 8)) - ulCont.parent().width()) - 7; var hundredPercent = maxLeft;
					
					//// LET'S CALCULATE THE MOUSE POSITION RELATIVE TO OUR CONTAINER
					var parentOffset = jQuery(this).parent().offset(); 
					var relX = e.pageX - parentOffset.left;
					var percentX = (relX / jQuery(this).parent().width()) * 100;
					
					//// IF ITS LESS THAN 10% or GREATER thNA 90% WE ROUND IT UP
					if(percentX < 10) { percentX = 0; }
					if(percentX > 90) { percentX = 100; }
					
					/// ANIMATES OUR UL TO THAT PERCENTAGE
					var newLeft = Math.round((maxLeft / 100) * percentX);
					
					//// AIMATES OUR UL
					ulCont.animate({ left: ['-'+newLeft+"px", "easeOutCirc"] }, { queue:false, duration:200 })
					
				});
				
			} else {
				
				// DEALS WITH SWIPE FOR TOUCH
				ulCont.parent().swipe({
					
					//// WHEN WE SWIPE LEFT
					swipeStatus: function(event, phase, direction, distance, duration, fingercount) {
						
						//// IF START GETS INITIAL LEFT
						if(phase == 'start') {
							
							ulCont.stop();
							initLeft = Math.abs(parseInt(ulCont.css('left')));
							
						}
						
						///// IF WE ARE ON THE MOVE STAGE
						if(phase == 'move') {
					
								/// LETS CALCULATE A FEW VALUES
								var liWidth = ulCont.find('li:first').width();
								var liLength = ulCont.find('li').length;
						
							//// IF WE ARE SWIPING LEFT
							if(direction == 'left') {
								
								var maxLeft = ((liLength * (liWidth + 6 + 8)) - ulCont.parent().width()) - 7; var hundredPercent = maxLeft;
								var newLeft = (Math.abs(initLeft) + distance);
								if(newLeft > maxLeft) { newLeft = maxLeft; }
								
								//// ANIAMTES IT
								ulCont.animate({ left: '-'+newLeft }, { queue:false, duration:200, easing: 'easeOutCirc' });
								
							}
						
							//// IF WE ARE SWIPING LEFT
							if(direction == 'right') {
								
								var maxLeft = 0;
								var newLeft = (Math.abs(initLeft) - distance);
								if(newLeft < maxLeft) { newLeft = maxLeft; }
								
								//// ANIAMTES IT
								ulCont.animate({ left: '-'+newLeft }, { queue:false, duration:200, easing: 'easeOutCirc' });
								
							}
						
						}
						
					},
					
					tap: function(event, target) {
						
						///// WHEN WE TAP WE TRIGGER THE CLICK
						jQuery(target).parent().trigger('click');
						
						//alert('cliuck');
						
					}
					
				});
				
			}
			
		},
		
		_sf_spot_enquiry: function(post_id) {
			
			//// VARS
			var mainCont = this;
			var thankCont = mainCont.find('.thank-you');
			var nameCont = mainCont.find('input[name="name"]');
			var emailCont = mainCont.find('input[name="email"]');
			var messageCont = mainCont.find('textarea[name="message"]');
			var errorCont = mainCont.find('small.error');
			var buttonCont = mainCont.find('input[type="submit"]');
			
			//// WHEN THE USER SUBMITS THE FORM
			mainCont.submit(function(e) {
				
				var error = '';
				
				//// VALIDATES OUR FORM
				nameCont.removeClass('error');
				if(nameCont.val() == '' || nameCont.val() == 'Your name') { nameCont.addClass('error'); error += sf.contact_form_name_error+'<br>'; }
				
				emailCont.removeClass('error');
				if(emailCont.val() == '' || emailCont.val() == 'Email address') { emailCont.addClass('error'); error += sf.contact_form_email_error+'<br>'; }
				
				messageCont.removeClass('error');
				if(messageCont.val() == '' || messageCont.val() == 'Message') { messageCont.addClass('error'); error += sf.contact_form_message_error+'<br>'; }
				
				//// IF NO ERRORS
				if(error == '') {
					
					/// DISPLAYS LOADING SIGN
					errorCont.hide();
					mainCont.spin({ lines: 11, length: 9, width: 4, radius: 11, corners: 1, speed: 2, shadow: false }).find('input, textarea').stop().animate({ opacity: .2 }, 100);
					buttonCont.attr('disabled', 'disabled');
					
					/// SENDS OUR FORM
					jQuery.ajax({
						
						url: 					sf.ajaxurl,
						type: 					'post',
						dataType: 				'json',
						data: {
						
							nonce:					sf.spot_enquiry_nonce,
							action: 				'spot_enquiry',
							name: 					nameCont.val(),
							email: 					emailCont.val(),
							message: 				messageCont.val(),
							post_id: 				post_id
							
						}, 
						success: function(data) {
							
							//console.log(data);
							
							//// IF NO ERRORS
							if(data.error == false) {
								
								mainCont.removeClass('loading').find('*').fadeOut(200, function() {
									
									thankCont.fadeIn(200);
									thankCont.find('p').fadeIn(200);
									
								});
								
							} else {
								
								/// IF WE CANT SEND THE MEAIL
								if(data.error_email != '') {
									
									alert(data.error_email);
									
								} else {
								
									errorCont.css({ display: 'block' }).html(data.error_message).slideDown(200, function() { jQuery(this).delay(5000).slideUp(200); });
						
									/// DISPLAYS LOADING SIGN
									mainCont.spin(false).find('input, textarea').stop().animate({ opacity: 1 }, 300);
									buttonCont.removeAttr('disabled');
								
								}
								
							}
							
						}
						
					})
					
				} else {
					
					errorCont.css({ display: 'block' }).html(error).slideDown(200, function() { jQuery(this).delay(5000).slideUp(200); });
					
				}
				
				//// PREVENTS NON AJAX SUBMISSIONS
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_mobile_menu: function() {
			
			//vars
			var mainCont = this;
			var wCont = this.children('div');
			var button = jQuery('#mobile-menu-button');
			var closeBtn = jQuery('#mobile-menu-close');
			
			button.swipe({
				
				tap: function(event, target) {
				
					//// LETS GET THE DOCUMENT HEIGHT AND SET THE MINIMUM HEIGHT
					var dH = jQuery(document).height();
					mainCont.css({ 'min-height': dH });
					
					//// PUTS IT ALL TO THE LEFT
					wCont.css({ left: '100%' });
					mainCont.show();
					
					//// ANIMATES IT TO 0
					wCont.stop().animate({ left: 0 }, 200);
					
				}
				
			});
			
			//// WHEN THE USER CLICKS TO CLOSE THE BUTTON
			closeBtn.swipe({
				
				tap: function(event, target) {
				
					wCont.stop().animate({ left: '100%', opacity: 0 }, 200, function() {
						
						jQuery(this).css({ opacity: 1 });
						mainCont.hide();
						
					});
					
				}
				
			});
			
			
		},
		
		_sf_mobile_filter: function() {
			
			//// vars
			var buttonCont = this;
			var mainCont = jQuery('#search-hover, #custom-header #search-spots');
			var searchCont = jQuery('#search, #custom-header #search-spots');
			var closeBtn = jQuery('#finish-filter');
			var clearBtn = jQuery('#clear-filter');
			var ipadBtn = jQuery('#search-ipad');
			
			///// IF OUR MAIN CONTAINER DOES NOT EXIST HIDE IT
			if(mainCont.length === 0) { buttonCont.hide(); return false; }
			
			//// WHEN THE USER CLICKS THE BUTTON
			buttonCont.swipe({
				
				tap: function() {
				
					//// LETS GET THE DOCUMENT HEIGHT AND SET THE MINIMUM HEIGHT
					var dH = jQuery(document).height();
					searchCont.css({ 'min-height': dH });
					jQuery('#custom-header').css({ 'z-index': 21000 });
					
					//// PUTS IT ALL TO THE LEFT
					mainCont.css({ left: '-100%', top: 0, 'z-index': 21000 }).show();
					
					//// ANIMATES IT TO 0
					mainCont.stop().animate({ avoidTransforms: false, left: 0 }, 200);
				
				}
				
			});
			
			//// WHEN THE USER CLICKS THE BUTTON
			ipadBtn.click(function() {
				
				//// LETS GET THE DOCUMENT HEIGHT AND SET THE MINIMUM HEIGHT
				var dH = jQuery('#slider').height();
				searchCont.css({ 'min-height': dH });
				jQuery('#custom-header').css({ 'z-index': 21000 });
					
				//// PUTS IT ALL TO THE LEFT
				mainCont.css({ top: '-'+dH+'px', left: 0 }).show();
				searchCont.show();
				
				mainCont.animate({ avoidTransforms: false, top: 0 }, 200);
				
				ipadBtn.fadeOut(200);
				
			});
			
			//// WHEN THE USER CLICKS TO CLOSE THE BUTTON
			closeBtn.swipe({
				tap: function() {
					mainCont.stop().animate({ avoidTransforms: false, left: '-100%', opacity: 0 }, 200, function() {
						jQuery(this).css({ opacity: 1 }).hide();
					});
					if(jQuery(window).width() > 700) { ipadBtn.fadeIn(200); }
					jQuery('#custom-header').css({ 'z-index': 0 });
				}
			});

/* DAHERO #1667517 STRT */
			//// WHEN THE USER CLICKS TO CLEAR BUTTON
			clearBtn.swipe({
				tap: function() {
					clearBtn.closest('form').find('.ui-slider').each(function() {
						var s = jQuery(this);
						var values = [
							s.slider("option", "min"),
							s.slider("option", "max")
						];
						s.slider("option", "values", values);
						s.slider('option','slide').call(s, null, {values: values});
					});
					clearBtn.closest('form').find(':input').each(function() {
						switch(this.type) {
							case 'password':
							case 'text':
							case 'textarea':
								jQuery(this).val('');
								break;
							case 'select-multiple':
							case 'select-one':
								jQuery(this).find(':selected').attr('selected', null);
								jQuery(this).find('option:first').attr('selected', 'selected');
								jQuery(this).trigger('change');
								break;
							case 'checkbox':
							case 'radio':
								this.checked = false;
						}
					});
					jQuery('#search-spots').submit();
				}
			});
/* DAHERO #1667517 STOP */
		},
		
		_sf_login_widget_tabs: function() {
			
			var mainCont = this;
			var tabs = mainCont.find('ul.tabs');
			var tabbed = mainCont.find('ul.tabbed');
			
			tabs.find('li').click(function() {
				
				//// IF NOT CURRENT
				if(jQuery(this).attr('class').indexOf('current') == -1) {

					tabs.find('.current').removeClass('current').addClass('other');
					jQuery(this).addClass('current').removeClass('other');
					
					tabbed.find('.current').siblings('li').slideDown(200, function() { jQuery(this).addClass('current'); });
					tabbed.find('.current').slideUp(200, function() { jQuery(this).removeClass('current'); });
					
				}
				
			});
			
		},
		
		_sf_login_widget_signup: function() {
			
			var formCont = this;
			var button = formCont.find('submit');
			
			//// WHEN THE USER CLICKS SIGN UP
			formCont.submit(function(e) {
				
				//// ADDS SPINNING SIGN
				formCont.children('*').stop().animate({ opacity: .3 });
				button.attr('disabled', 'disabled');
				formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				formCont.find('small.error, p.error small').remove();
				formCont.find('p.error').removeClass('error');
				
				jQuery.ajax({
					
					url:				sf.ajaxurl,
					type: 				'post',
					dataType: 			'json',
					data: {
						
						action: 		'login_widget_signup',
						nonce: 			sf.login_widget_signup_nonce,
						data: 			formCont.serialize()
						
					},
					success: function(data) {
						
						formCont.children('*').stop().animate({ opacity: 1 });
						button.removeAttr('disabled');
						formCont.spin(false);
						
						//// IF ANY ERRORS
						if(data.error) {
							
							//// SHOWS ERROR
							formCont.prepend('<p><small class="error" style="display: block;">'+data.message+'</small></p>');
							formCont.children('small').fadeIn(300);
							
						} else {
							
							//// SHOWS SUCCESS MESSAGE
							formCont.prepend('<p><small class="success" style="display: block;">'+data.message+'</small></p>');
							formCont.children('small').fadeIn(300, function() { jQuery(this).delay(3000).fadeOut(300, function() { jQuery(this).remove(); }); });
							formCont.find('input[type="password"]').val('');
							
						}
						
					}
					
				});
				
				//// PREVENTS NON AJAX SUBMITS
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_login_widget_login: function() {
			
			var formCont = this;
			var button = formCont.find('submit');
			
			//// WHEN THE USER CLICKS SIGN UP
			formCont.submit(function(e) {
				
				//// ADDS SPINNING SIGN
				formCont.children('*').stop().animate({ opacity: .3 });
				button.attr('disabled', 'disabled');
				formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				formCont.find('small.error, p.error small').remove();
				formCont.find('p.error').removeClass('error');
				
				jQuery.ajax({
					
					url:				sf.ajaxurl,
					type: 				'post',
					dataType: 			'json',
					data: {
						
						action: 		'login_widget_login',
						nonce: 			sf.login_widget_login_nonce,
						username: 		formCont.find('input[name="username"]').val(),
						password: 		formCont.find('input[name="password"]').val(),
						login_url:		true
						
					},
					success: function(data) {
						
						formCont.children('*').stop().animate({ opacity: 1 });
						button.removeAttr('disabled');
						formCont.spin(false);
						
						//// IF ANY ERRORS
						if(data.error) {
							
							//// SHOWS ERROR
							formCont.prepend('<p><small class="error" style="display: block;">'+data.message+'</small></p>');
							formCont.children('small').fadeIn(300);
							
						} else {
							
							//// SHOWS SUCCESS MESSAGE
							formCont.prepend('<p><small class="success" style="display: block;">'+data.message+'</small></p>');
							formCont.children('small').fadeIn(300, function() { jQuery(this).delay(3000).fadeOut(300, function() { window.location.href = data.url; }); });
							formCont.find('input[type="password"]').val('');
							window.location.href = data.url;
							
						}
						
					}
					
				});
				
				//// PREVENTS NON AJAX SUBMITS
				e.preventDefault();
				return false;
				
			});
			
		},
		
		
		_sf_fb_sign_up_widget: function() {
			
			var button = this;
			isFacebookLoading = false;
			var formCont = button.closest('form');
			
			//// WHEN USER CLICKS THE FACEBOOK BUTTON
			button.click(function() {
				
				//// LETS TRY AND LOG THE USER IN
				FB.login(function(response) {
					
					//// IF WE ARE SUCCESSFULLY CONNECTED
					if(response.status === 'connected') {
						
						///// LETS LOG HIM IN / REGISTER HIM
						formCont._sf_fb_log_in_widget(response);
						
					}
					
				}, { scope: 'email' });
				
			});
			
		},
		
		_sf_fb_log_in_widget: function(data) {
			
			var formCont = this;
			var button = formCont.find('submit');
			
			if(isFacebookLoading === false) {
				
				isFacebookLoading = true;
				
				//// RETRIEVES USER DATA - IF FB IS NOT LOADING
				FB.api('/me', function(response) {
					
					//// MAKE SURE ITS NOT LOADING AGAIN
					isFacebookLoading = false;
					
					//// ADDS OUR LOADING SIGN
					formCont.children('*').stop().animate({ opacity: .3 });
					button.attr('disabled', 'disabled');
					formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
					formCont.find('small.error, p.error small').remove();
					formCont.find('p.error').removeClass('error');
			
					//// LETS LOG HIM IN
					jQuery.ajax({
						
						url: 				sf.ajaxurl,
						type: 				'post',
						dataType: 			'json',
						data: {
							
							action: 		'_sf_us_fb_login_widget',
							nonce: 			sf._sf_us_fb_login_nonce_widget,
							firstname: 	response.first_name,
							lastname: 		response.last_name,
							user_id: 		response.id,
							email: 			response.email,
							login_url: 	true
							
						},
						success: function(data) {
							
							if(data.error) {
								
								alert(data.message);
								
							} else {
								
								//// REFRESHES WINDOW
								if(data.url) {
									
									window.location.href = data.url;
									
								} else {
									
									window.location.href = window.location.href;
									
								}
								
							}
							
						}
						
					});
					
					//console.log(response);
				
				});
			
			}
			
		},
		
		sf_sticky_header: function() {
			
			//// VARS
			var mainCont = this;
			
			//// SETS UP IT AS FIXED
			mainCont.css({ 'position': 'fixed' });
			
			///// GETS THE HEIGHT AND APPLY IT AS PADDING
			var headerHeight = mainCont.outerHeight();
			mainCont.before('<div id="header-space" style="height: '+headerHeight+'px;"></div>');
			
		},
		
		_sf_show_recurring_tooltip: function() {
			
			var mainCont = this;
			var tooltip = mainCont.find('._sf_recurring_tooltip');
			
			if(typeof sfTooltipTimeout != 'undefined') { clearTimeout(sfTooltipTimeout); }
			
			if(!tooltip.is(':visible')) { tooltip.css({ opacity: 0, display: 'block', 'margin-top': '10px' }).stop().animate({ opacity: 1, 'margin-top': 0 }, 200); }
			
		},
		
		_sf_hide_recurring_tooltip: function() {
			
			var mainCont = this;
			var tooltip = mainCont.find('._sf_recurring_tooltip');
			
			sfTooltipTimeout = setTimeout( function() {
				
				if(tooltip.is(':visible')) { tooltip.stop().animate({ opacity: 0, 'margin-top': '10px' }, 200, function() { jQuery(this).hide(); }); }
				
			}, 50);
			
		}
		
	});
	
})(jQuery);






/*! Backstretch - v2.0.3 - 2012-11-30
* http://srobbin.com/jquery-plugins/backstretch/
* Copyright (c) 2012 Scott Robbin; Licensed MIT */
(function(e,t,n){"use strict";e.fn.backstretch=function(r,s){return(r===n||r.length===0)&&e.error("No images were supplied for Backstretch"),e(t).scrollTop()===0&&t.scrollTo(0,0),this.each(function(){var t=e(this),n=t.data("backstretch");n&&(s=e.extend(n.options,s),n.destroy(!0)),n=new i(this,r,s),t.data("backstretch",n)})},e.backstretch=function(t,n){return e("body").backstretch(t,n).data("backstretch")},e.expr[":"].backstretch=function(t){return e(t).data("backstretch")!==n},e.fn.backstretch.defaults={centeredX:!0,centeredY:!0,duration:5e3,fade:0};var r={wrap:{left:0,top:0,overflow:"hidden",margin:0,padding:0,height:"100%",width:"100%",zIndex:-999999},img:{position:"absolute",display:"none",margin:0,padding:0,border:"none",width:"auto",height:"auto",maxWidth:"none",zIndex:-999999}},i=function(n,i,o){this.options=e.extend({},e.fn.backstretch.defaults,o||{}),this.images=e.isArray(i)?i:[i],e.each(this.images,function(){e("<img />")[0].src=this}),this.isBody=n===document.body,this.$container=e(n),this.$wrap=e('<div class="backstretch"></div>').css(r.wrap).appendTo(this.$container),this.$root=this.isBody?s?e(t):e(document):this.$container;if(!this.isBody){var u=this.$container.css("position"),a=this.$container.css("zIndex");this.$container.css({position:u==="static"?"relative":u,zIndex:a==="auto"?0:a,background:"none"}),this.$wrap.css({zIndex:-999998})}this.$wrap.css({position:this.isBody&&s?"fixed":"absolute"}),this.index=0,this.show(this.index),e(t).on("resize.backstretch",e.proxy(this.resize,this)).on("orientationchange.backstretch",e.proxy(function(){this.isBody&&t.pageYOffset===0&&(t.scrollTo(0,1),this.resize())},this))};i.prototype={resize:function(){try{var e={left:0,top:0},n=this.isBody?this.$root.width():this.$root.innerWidth(),r=n,i=this.isBody?t.innerHeight?t.innerHeight:this.$root.height():this.$root.innerHeight(),s=r/this.$img.data("ratio"),o;s>=i?(o=(s-i)/2,this.options.centeredY&&(e.top="-"+o+"px")):(s=i,r=s*this.$img.data("ratio"),o=(r-n)/2,this.options.centeredX&&(e.left="-"+o+"px")),this.$wrap.css({width:n,height:i}).find("img:not(.deleteable)").css({width:r,height:s}).css(e)}catch(u){}return this},show:function(t){if(Math.abs(t)>this.images.length-1)return;this.index=t;var n=this,i=n.$wrap.find("img").addClass("deleteable"),s=e.Event("backstretch.show",{relatedTarget:n.$container[0]});return clearInterval(n.interval),n.$img=e("<img />").css(r.img).bind("load",function(t){var r=this.width||e(t.target).width(),o=this.height||e(t.target).height();e(this).data("ratio",r/o),e(this).fadeIn(n.options.speed||n.options.fade,function(){i.remove(),n.paused||n.cycle(),n.$container.trigger(s,n)}),n.resize()}).appendTo(n.$wrap),n.$img.attr("src",n.images[t]),n},next:function(){return this.show(this.index<this.images.length-1?this.index+1:0)},prev:function(){return this.show(this.index===0?this.images.length-1:this.index-1)},pause:function(){return this.paused=!0,this},resume:function(){return this.paused=!1,this.next(),this},cycle:function(){return this.images.length>1&&(clearInterval(this.interval),this.interval=setInterval(e.proxy(function(){this.paused||this.next()},this),this.options.duration)),this},destroy:function(n){e(t).off("resize.backstretch orientationchange.backstretch"),clearInterval(this.interval),n||this.$wrap.remove(),this.$container.removeData("backstretch")}};var s=function(){var e=navigator.userAgent,n=navigator.platform,r=e.match(/AppleWebKit\/([0-9]+)/),i=!!r&&r[1],s=e.match(/Fennec\/([0-9]+)/),o=!!s&&s[1],u=e.match(/Opera Mobi\/([0-9]+)/),a=!!u&&u[1],f=e.match(/MSIE ([0-9]+)/),l=!!f&&f[1];return!((n.indexOf("iPhone")>-1||n.indexOf("iPad")>-1||n.indexOf("iPod")>-1)&&i&&i<534||t.operamini&&{}.toString.call(t.operamini)==="[object OperaMini]"||u&&a<7458||e.indexOf("Android")>-1&&i&&i<533||o&&o<6||"palmGetResource"in t&&i&&i<534||e.indexOf("MeeGo")>-1&&e.indexOf("NokiaBrowser/8.5.0")>-1||l&&l<=6)}()})(jQuery,window);




/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */
 
 
 
 /*!
 * jQuery Cookie Plugin v1.3.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as anonymous module.
		define(['jquery'], factory);
	} else {
		// Browser globals.
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function raw(s) {
		return s;
	}

	function decoded(s) {
		return decodeURIComponent(s.replace(pluses, ' '));
	}

	function converted(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}
		try {
			return config.json ? JSON.parse(s) : s;
		} catch(er) {}
	}

	var config = $.cookie = function (key, value, options) {

		// write
		if (value !== undefined) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}

			value = config.json ? JSON.stringify(value) : String(value);

			return (document.cookie = [
				config.raw ? key : encodeURIComponent(key),
				'=',
				config.raw ? value : encodeURIComponent(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// read
		var decode = config.raw ? raw : decoded;
		var cookies = document.cookie.split('; ');
		var result = key ? undefined : {};
		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = decode(parts.join('='));

			if (key && key === name) {
				result = converted(cookie);
				break;
			}

			if (!key) {
				result[name] = converted(cookie);
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) !== undefined) {
			$.cookie(key, '', $.extend(options, { expires: -1 }));
			return true;
		}
		return false;
	};

}));




/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license.
 * Copyright 2007, 2013 Brian Cherne
 */
(function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})(jQuery);




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




/*
 * JQuery URL Parser plugin, v2.2.1
 * Developed and maintanined by Mark Perkins, mark@allmarkedup.com
 * Source repository: https://github.com/allmarkedup/jQuery-URL-Parser
 * Licensed under an MIT-style license. See https://github.com/allmarkedup/jQuery-URL-Parser/blob/master/LICENSE for details.
 */ 

;(function(factory){if(typeof define==='function'&&define.amd){if(typeof jQuery!=='undefined'){define(['jquery'],factory);}else{define([],factory);}}else{if(typeof jQuery!=='undefined'){factory(jQuery);}else{factory();}}})(function($,undefined){var tag2attr={a:'href',img:'src',form:'action',base:'href',script:'src',iframe:'src',link:'href'},key=['source','protocol','authority','userInfo','user','password','host','port','relative','path','directory','file','query','fragment'],aliases={'anchor':'fragment'},parser={strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,loose:/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/},toString=Object.prototype.toString,isint=/^[0-9]+$/;function parseUri(url,strictMode){var str=decodeURI(url),res=parser[strictMode||false?'strict':'loose'].exec(str),uri={attr:{},param:{},seg:{}},i=14;while(i--){uri.attr[key[i]]=res[i]||'';}uri.param['query']=parseString(uri.attr['query']);uri.param['fragment']=parseString(uri.attr['fragment']);uri.seg['path']=uri.attr.path.replace(/^\/+|\/+$/g,'').split('/');uri.seg['fragment']=uri.attr.fragment.replace(/^\/+|\/+$/g,'').split('/');uri.attr['base']=uri.attr.host?(uri.attr.protocol?uri.attr.protocol+'://'+uri.attr.host:uri.attr.host)+(uri.attr.port?':'+uri.attr.port:''):'';return uri;};function getAttrName(elm){var tn=elm.tagName;if(typeof tn!=='undefined')return tag2attr[tn.toLowerCase()];return tn;}function promote(parent,key){if(parent[key].length==0)return parent[key]={};var t={};for(var i in parent[key])t[i]=parent[key][i];parent[key]=t;return t;}function parse(parts,parent,key,val){var part=parts.shift();if(!part){if(isArray(parent[key])){parent[key].push(val);}else if('object'==typeof parent[key]){parent[key]=val;}else if('undefined'==typeof parent[key]){parent[key]=val;}else{parent[key]=[parent[key],val];}}else{var obj=parent[key]=parent[key]||[];if(']'==part){if(isArray(obj)){if(''!=val)obj.push(val);}else if('object'==typeof obj){obj[keys(obj).length]=val;}else{obj=parent[key]=[parent[key],val];}}else if(~part.indexOf(']')){part=part.substr(0,part.length-1);if(!isint.test(part)&&isArray(obj))obj=promote(parent,key);parse(parts,obj,part,val);}else{if(!isint.test(part)&&isArray(obj))obj=promote(parent,key);parse(parts,obj,part,val);}}}function merge(parent,key,val){if(~key.indexOf(']')){var parts=key.split('['),len=parts.length,last=len-1;parse(parts,parent,'base',val);}else{if(!isint.test(key)&&isArray(parent.base)){var t={};for(var k in parent.base)t[k]=parent.base[k];parent.base=t;}set(parent.base,key,val);}return parent;}function parseString(str){return reduce(String(str).split(/&|;/),function(ret,pair){try{pair=decodeURIComponent(pair.replace(/\+/g,' '));}catch(e){}var eql=pair.indexOf('='),brace=lastBraceInKey(pair),key=pair.substr(0,brace||eql),val=pair.substr(brace||eql,pair.length),val=val.substr(val.indexOf('=')+1,val.length);if(''==key)key=pair,val='';return merge(ret,key,val);},{base:{}}).base;}function set(obj,key,val){var v=obj[key];if(undefined===v){obj[key]=val;}else if(isArray(v)){v.push(val);}else{obj[key]=[v,val];}}function lastBraceInKey(str){var len=str.length,brace,c;for(var i=0;i<len;++i){c=str[i];if(']'==c)brace=false;if('['==c)brace=true;if('='==c&&!brace)return i;}}function reduce(obj,accumulator){var i=0,l=obj.length>>0,curr=arguments[2];while(i<l){if(i in obj)curr=accumulator.call(undefined,curr,obj[i],i,obj);++i;}return curr;}function isArray(vArg){return Object.prototype.toString.call(vArg)==="[object Array]";}function keys(obj){var keys=[];for(prop in obj){if(obj.hasOwnProperty(prop))keys.push(prop);}return keys;}function purl(url,strictMode){if(arguments.length===1&&url===true){strictMode=true;url=undefined;}strictMode=strictMode||false;url=url||window.location.toString();return{data:parseUri(url,strictMode),attr:function(attr){attr=aliases[attr]||attr;return typeof attr!=='undefined'?this.data.attr[attr]:this.data.attr;},param:function(param){return typeof param!=='undefined'?this.data.param.query[param]:this.data.param.query;},fparam:function(param){return typeof param!=='undefined'?this.data.param.fragment[param]:this.data.param.fragment;},segment:function(seg){if(typeof seg==='undefined'){return this.data.seg.path;}else{seg=seg<0?this.data.seg.path.length+seg:seg-1;return this.data.seg.path[seg];}},fsegment:function(seg){if(typeof seg==='undefined'){return this.data.seg.fragment;}else{seg=seg<0?this.data.seg.fragment.length+seg:seg-1;return this.data.seg.fragment[seg];}}};};if(typeof $!=='undefined'){$.fn.url=function(strictMode){var url='';if(this.length){url=$(this).attr(getAttrName(this[0]))||'';}return purl(url,strictMode);};$.url=purl;}else{window.purl=purl;}});




/* Modernizr 2.6.2 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-history-touch-teststyles-prefixes
 */
;window.Modernizr=function(a,b,c){function v(a){i.cssText=a}function w(a,b){return v(l.join(a+";")+(b||""))}function x(a,b){return typeof a===b}function y(a,b){return!!~(""+a).indexOf(b)}function z(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:x(f,"function")?f.bind(d||b):f}return!1}var d="2.6.2",e={},f=b.documentElement,g="modernizr",h=b.createElement(g),i=h.style,j,k={}.toString,l=" -webkit- -moz- -o- -ms- ".split(" "),m={},n={},o={},p=[],q=p.slice,r,s=function(a,c,d,e){var h,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:g+(d+1),l.appendChild(j);return h=["&#173;",'<style id="s',g,'">',a,"</style>"].join(""),l.id=g,(m?l:n).innerHTML+=h,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=f.style.overflow,f.style.overflow="hidden",f.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),f.style.overflow=k),!!i},t={}.hasOwnProperty,u;!x(t,"undefined")&&!x(t.call,"undefined")?u=function(a,b){return t.call(a,b)}:u=function(a,b){return b in a&&x(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=q.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(q.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(q.call(arguments)))};return e}),m.touch=function(){var c;return"ontouchstart"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:s(["@media (",l.join("touch-enabled),("),g,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(a){c=a.offsetTop===9}),c},m.history=function(){return!!a.history&&!!history.pushState};for(var A in m)u(m,A)&&(r=A.toLowerCase(),e[r]=m[A](),p.push((e[r]?"":"no-")+r));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)u(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof enableClasses!="undefined"&&enableClasses&&(f.className+=" "+(b?"":"no-")+a),e[a]=b}return e},v(""),h=j=null,e._version=d,e._prefixes=l,e.testStyles=s,e}(this,this.document);




/* TOUCHSWIPE */
(function(e){var o="left",n="right",d="up",v="down",c="in",w="out",l="none",r="auto",k="swipe",s="pinch",x="tap",i="doubletap",b="longtap",A="horizontal",t="vertical",h="all",q=10,f="start",j="move",g="end",p="cancel",a="ontouchstart" in window,y="TouchSwipe";var m={fingers:1,threshold:75,cancelThreshold:null,pinchThreshold:20,maxTimeThreshold:null,fingerReleaseThreshold:250,longTapThreshold:500,doubleTapThreshold:200,swipe:null,swipeLeft:null,swipeRight:null,swipeUp:null,swipeDown:null,swipeStatus:null,pinchIn:null,pinchOut:null,pinchStatus:null,click:null,tap:null,doubleTap:null,longTap:null,triggerOnTouchEnd:true,triggerOnTouchLeave:false,allowPageScroll:"auto",fallbackToMouseEvents:true,excludedElements:"button, input, select, textarea, a, .noSwipe"};e.fn.swipe=function(D){var C=e(this),B=C.data(y);if(B&&typeof D==="string"){if(B[D]){return B[D].apply(this,Array.prototype.slice.call(arguments,1))}else{e.error("Method "+D+" does not exist on jQuery.swipe")}}else{if(!B&&(typeof D==="object"||!D)){return u.apply(this,arguments)}}return C};e.fn.swipe.defaults=m;e.fn.swipe.phases={PHASE_START:f,PHASE_MOVE:j,PHASE_END:g,PHASE_CANCEL:p};e.fn.swipe.directions={LEFT:o,RIGHT:n,UP:d,DOWN:v,IN:c,OUT:w};e.fn.swipe.pageScroll={NONE:l,HORIZONTAL:A,VERTICAL:t,AUTO:r};e.fn.swipe.fingers={ONE:1,TWO:2,THREE:3,ALL:h};function u(B){if(B&&(B.allowPageScroll===undefined&&(B.swipe!==undefined||B.swipeStatus!==undefined))){B.allowPageScroll=l}if(B.click!==undefined&&B.tap===undefined){B.tap=B.click}if(!B){B={}}B=e.extend({},e.fn.swipe.defaults,B);return this.each(function(){var D=e(this);var C=D.data(y);if(!C){C=new z(this,B);D.data(y,C)}})}function z(a0,aq){var av=(a||!aq.fallbackToMouseEvents),G=av?"touchstart":"mousedown",au=av?"touchmove":"mousemove",R=av?"touchend":"mouseup",P=av?null:"mouseleave",az="touchcancel";var ac=0,aL=null,Y=0,aX=0,aV=0,D=1,am=0,aF=0,J=null;var aN=e(a0);var W="start";var T=0;var aM=null;var Q=0,aY=0,a1=0,aa=0,K=0;var aS=null;try{aN.bind(G,aJ);aN.bind(az,a5)}catch(ag){e.error("events not supported "+G+","+az+" on jQuery.swipe")}this.enable=function(){aN.bind(G,aJ);aN.bind(az,a5);return aN};this.disable=function(){aG();return aN};this.destroy=function(){aG();aN.data(y,null);return aN};this.option=function(a8,a7){if(aq[a8]!==undefined){if(a7===undefined){return aq[a8]}else{aq[a8]=a7}}else{e.error("Option "+a8+" does not exist on jQuery.swipe.options")}};function aJ(a9){if(ax()){return}if(e(a9.target).closest(aq.excludedElements,aN).length>0){return}var ba=a9.originalEvent?a9.originalEvent:a9;var a8,a7=a?ba.touches[0]:ba;W=f;if(a){T=ba.touches.length}else{a9.preventDefault()}ac=0;aL=null;aF=null;Y=0;aX=0;aV=0;D=1;am=0;aM=af();J=X();O();if(!a||(T===aq.fingers||aq.fingers===h)||aT()){ae(0,a7);Q=ao();if(T==2){ae(1,ba.touches[1]);aX=aV=ap(aM[0].start,aM[1].start)}if(aq.swipeStatus||aq.pinchStatus){a8=L(ba,W)}}else{a8=false}if(a8===false){W=p;L(ba,W);return a8}else{ak(true)}}function aZ(ba){var bd=ba.originalEvent?ba.originalEvent:ba;if(W===g||W===p||ai()){return}var a9,a8=a?bd.touches[0]:bd;var bb=aD(a8);aY=ao();if(a){T=bd.touches.length}W=j;if(T==2){if(aX==0){ae(1,bd.touches[1]);aX=aV=ap(aM[0].start,aM[1].start)}else{aD(bd.touches[1]);aV=ap(aM[0].end,aM[1].end);aF=an(aM[0].end,aM[1].end)}D=a3(aX,aV);am=Math.abs(aX-aV)}if((T===aq.fingers||aq.fingers===h)||!a||aT()){aL=aH(bb.start,bb.end);ah(ba,aL);ac=aO(bb.start,bb.end);Y=aI();aE(aL,ac);if(aq.swipeStatus||aq.pinchStatus){a9=L(bd,W)}if(!aq.triggerOnTouchEnd||aq.triggerOnTouchLeave){var a7=true;if(aq.triggerOnTouchLeave){var bc=aU(this);a7=B(bb.end,bc)}if(!aq.triggerOnTouchEnd&&a7){W=ay(j)}else{if(aq.triggerOnTouchLeave&&!a7){W=ay(g)}}if(W==p||W==g){L(bd,W)}}}else{W=p;L(bd,W)}if(a9===false){W=p;L(bd,W)}}function I(a7){var a8=a7.originalEvent;if(a){if(a8.touches.length>0){C();return true}}if(ai()){T=aa}a7.preventDefault();aY=ao();Y=aI();if(a6()){W=p;L(a8,W)}else{if(aq.triggerOnTouchEnd||(aq.triggerOnTouchEnd==false&&W===j)){W=g;L(a8,W)}else{if(!aq.triggerOnTouchEnd&&a2()){W=g;aB(a8,W,x)}else{if(W===j){W=p;L(a8,W)}}}}ak(false)}function a5(){T=0;aY=0;Q=0;aX=0;aV=0;D=1;O();ak(false)}function H(a7){var a8=a7.originalEvent;if(aq.triggerOnTouchLeave){W=ay(g);L(a8,W)}}function aG(){aN.unbind(G,aJ);aN.unbind(az,a5);aN.unbind(au,aZ);aN.unbind(R,I);if(P){aN.unbind(P,H)}ak(false)}function ay(bb){var ba=bb;var a9=aw();var a8=aj();var a7=a6();if(!a9||a7){ba=p}else{if(a8&&bb==j&&(!aq.triggerOnTouchEnd||aq.triggerOnTouchLeave)){ba=g}else{if(!a8&&bb==g&&aq.triggerOnTouchLeave){ba=p}}}return ba}function L(a9,a7){var a8=undefined;if(F()||S()){a8=aB(a9,a7,k)}else{if((M()||aT())&&a8!==false){a8=aB(a9,a7,s)}}if(aC()&&a8!==false){a8=aB(a9,a7,i)}else{if(al()&&a8!==false){a8=aB(a9,a7,b)}else{if(ad()&&a8!==false){a8=aB(a9,a7,x)}}}if(a7===p){a5(a9)}if(a7===g){if(a){if(a9.touches.length==0){a5(a9)}}else{a5(a9)}}return a8}function aB(ba,a7,a9){var a8=undefined;if(a9==k){aN.trigger("swipeStatus",[a7,aL||null,ac||0,Y||0,T]);if(aq.swipeStatus){a8=aq.swipeStatus.call(aN,ba,a7,aL||null,ac||0,Y||0,T);if(a8===false){return false}}if(a7==g&&aR()){aN.trigger("swipe",[aL,ac,Y,T]);if(aq.swipe){a8=aq.swipe.call(aN,ba,aL,ac,Y,T);if(a8===false){return false}}switch(aL){case o:aN.trigger("swipeLeft",[aL,ac,Y,T]);if(aq.swipeLeft){a8=aq.swipeLeft.call(aN,ba,aL,ac,Y,T)}break;case n:aN.trigger("swipeRight",[aL,ac,Y,T]);if(aq.swipeRight){a8=aq.swipeRight.call(aN,ba,aL,ac,Y,T)}break;case d:aN.trigger("swipeUp",[aL,ac,Y,T]);if(aq.swipeUp){a8=aq.swipeUp.call(aN,ba,aL,ac,Y,T)}break;case v:aN.trigger("swipeDown",[aL,ac,Y,T]);if(aq.swipeDown){a8=aq.swipeDown.call(aN,ba,aL,ac,Y,T)}break}}}if(a9==s){aN.trigger("pinchStatus",[a7,aF||null,am||0,Y||0,T,D]);if(aq.pinchStatus){a8=aq.pinchStatus.call(aN,ba,a7,aF||null,am||0,Y||0,T,D);if(a8===false){return false}}if(a7==g&&a4()){switch(aF){case c:aN.trigger("pinchIn",[aF||null,am||0,Y||0,T,D]);if(aq.pinchIn){a8=aq.pinchIn.call(aN,ba,aF||null,am||0,Y||0,T,D)}break;case w:aN.trigger("pinchOut",[aF||null,am||0,Y||0,T,D]);if(aq.pinchOut){a8=aq.pinchOut.call(aN,ba,aF||null,am||0,Y||0,T,D)}break}}}if(a9==x){if(a7===p||a7===g){clearTimeout(aS);if(V()&&!E()){K=ao();aS=setTimeout(e.proxy(function(){K=null;aN.trigger("tap",[ba.target]);if(aq.tap){a8=aq.tap.call(aN,ba,ba.target)}},this),aq.doubleTapThreshold)}else{K=null;aN.trigger("tap",[ba.target]);if(aq.tap){a8=aq.tap.call(aN,ba,ba.target)}}}}else{if(a9==i){if(a7===p||a7===g){clearTimeout(aS);K=null;aN.trigger("doubletap",[ba.target]);if(aq.doubleTap){a8=aq.doubleTap.call(aN,ba,ba.target)}}}else{if(a9==b){if(a7===p||a7===g){clearTimeout(aS);K=null;aN.trigger("longtap",[ba.target]);if(aq.longTap){a8=aq.longTap.call(aN,ba,ba.target)}}}}}return a8}function aj(){var a7=true;if(aq.threshold!==null){a7=ac>=aq.threshold}return a7}function a6(){var a7=false;if(aq.cancelThreshold!==null&&aL!==null){a7=(aP(aL)-ac)>=aq.cancelThreshold}return a7}function ab(){if(aq.pinchThreshold!==null){return am>=aq.pinchThreshold}return true}function aw(){var a7;if(aq.maxTimeThreshold){if(Y>=aq.maxTimeThreshold){a7=false}else{a7=true}}else{a7=true}return a7}function ah(a7,a8){if(aq.allowPageScroll===l||aT()){a7.preventDefault()}else{var a9=aq.allowPageScroll===r;switch(a8){case o:if((aq.swipeLeft&&a9)||(!a9&&aq.allowPageScroll!=A)){a7.preventDefault()}break;case n:if((aq.swipeRight&&a9)||(!a9&&aq.allowPageScroll!=A)){a7.preventDefault()}break;case d:if((aq.swipeUp&&a9)||(!a9&&aq.allowPageScroll!=t)){a7.preventDefault()}break;case v:if((aq.swipeDown&&a9)||(!a9&&aq.allowPageScroll!=t)){a7.preventDefault()}break}}}function a4(){var a8=aK();var a7=U();var a9=ab();return a8&&a7&&a9}function aT(){return !!(aq.pinchStatus||aq.pinchIn||aq.pinchOut)}function M(){return !!(a4()&&aT())}function aR(){var ba=aw();var bc=aj();var a9=aK();var a7=U();var a8=a6();var bb=!a8&&a7&&a9&&bc&&ba;return bb}function S(){return !!(aq.swipe||aq.swipeStatus||aq.swipeLeft||aq.swipeRight||aq.swipeUp||aq.swipeDown)}function F(){return !!(aR()&&S())}function aK(){return((T===aq.fingers||aq.fingers===h)||!a)}function U(){return aM[0].end.x!==0}function a2(){return !!(aq.tap)}function V(){return !!(aq.doubleTap)}function aQ(){return !!(aq.longTap)}function N(){if(K==null){return false}var a7=ao();return(V()&&((a7-K)<=aq.doubleTapThreshold))}function E(){return N()}function at(){return((T===1||!a)&&(isNaN(ac)||ac===0))}function aW(){return((Y>aq.longTapThreshold)&&(ac<q))}function ad(){return !!(at()&&a2())}function aC(){return !!(N()&&V())}function al(){return !!(aW()&&aQ())}function C(){a1=ao();aa=event.touches.length+1}function O(){a1=0;aa=0}function ai(){var a7=false;if(a1){var a8=ao()-a1;if(a8<=aq.fingerReleaseThreshold){a7=true}}return a7}function ax(){return !!(aN.data(y+"_intouch")===true)}function ak(a7){if(a7===true){aN.bind(au,aZ);aN.bind(R,I);if(P){aN.bind(P,H)}}else{aN.unbind(au,aZ,false);aN.unbind(R,I,false);if(P){aN.unbind(P,H,false)}}aN.data(y+"_intouch",a7===true)}function ae(a8,a7){var a9=a7.identifier!==undefined?a7.identifier:0;aM[a8].identifier=a9;aM[a8].start.x=aM[a8].end.x=a7.pageX||a7.clientX;aM[a8].start.y=aM[a8].end.y=a7.pageY||a7.clientY;return aM[a8]}function aD(a7){var a9=a7.identifier!==undefined?a7.identifier:0;var a8=Z(a9);a8.end.x=a7.pageX||a7.clientX;a8.end.y=a7.pageY||a7.clientY;return a8}function Z(a8){for(var a7=0;a7<aM.length;a7++){if(aM[a7].identifier==a8){return aM[a7]}}}function af(){var a7=[];for(var a8=0;a8<=5;a8++){a7.push({start:{x:0,y:0},end:{x:0,y:0},identifier:0})}return a7}function aE(a7,a8){a8=Math.max(a8,aP(a7));J[a7].distance=a8}function aP(a7){return J[a7].distance}function X(){var a7={};a7[o]=ar(o);a7[n]=ar(n);a7[d]=ar(d);a7[v]=ar(v);return a7}function ar(a7){return{direction:a7,distance:0}}function aI(){return aY-Q}function ap(ba,a9){var a8=Math.abs(ba.x-a9.x);var a7=Math.abs(ba.y-a9.y);return Math.round(Math.sqrt(a8*a8+a7*a7))}function a3(a7,a8){var a9=(a8/a7)*1;return a9.toFixed(2)}function an(){if(D<1){return w}else{return c}}function aO(a8,a7){return Math.round(Math.sqrt(Math.pow(a7.x-a8.x,2)+Math.pow(a7.y-a8.y,2)))}function aA(ba,a8){var a7=ba.x-a8.x;var bc=a8.y-ba.y;var a9=Math.atan2(bc,a7);var bb=Math.round(a9*180/Math.PI);if(bb<0){bb=360-Math.abs(bb)}return bb}function aH(a8,a7){var a9=aA(a8,a7);if((a9<=45)&&(a9>=0)){return o}else{if((a9<=360)&&(a9>=315)){return o}else{if((a9>=135)&&(a9<=225)){return n}else{if((a9>45)&&(a9<135)){return v}else{return d}}}}}function ao(){var a7=new Date();return a7.getTime()}function aU(a7){a7=e(a7);var a9=a7.offset();var a8={left:a9.left,right:a9.left+a7.outerWidth(),top:a9.top,bottom:a9.top+a7.outerHeight()};return a8}function B(a7,a8){return(a7.x>a8.left&&a7.x<a8.right&&a7.y>a8.top&&a7.y<a8.bottom)}}})(jQuery);






/*
jquery.animate-enhanced plugin v1.02
---
http://github.com/benbarnett/jQuery-Animate-Enhanced
http://benbarnett.net
@benpbarnett
*/

(function(e,t,n){function S(e){return e.match(/\D+$/)}function x(e,t,n,r){if(n=="d")return;if(!M(e))return;var i=u.exec(t),s=e.css(n)==="auto"?0:e.css(n),o=typeof s=="string"?O(s):s,a=typeof t=="string"?O(t):t,f=r===true?0:o,l=e.is(":hidden"),c=e.translation();if(n=="left")f=parseInt(o,10)+c.x;if(n=="right")f=parseInt(o,10)+c.x;if(n=="top")f=parseInt(o,10)+c.y;if(n=="bottom")f=parseInt(o,10)+c.y;if(!i&&t=="show"){f=1;if(l)e.css({display:A(e.context.tagName),opacity:0})}else if(!i&&t=="hide"){f=0}if(i){var h=parseFloat(i[2]);if(i[1])h=(i[1]==="-="?-1:1)*h+parseInt(f,10);return h}else{return f}}function T(e,t,n){return n===true||E===true&&n!==false&&w?"translate3d("+e+"px, "+t+"px, 0)":"translate("+e+"px,"+t+"px)"}function N(t,n,r,s,o,u,a,l){var h=t.data(c),p=h&&!L(h)?h:e.extend(true,{},f),d=o,v=e.inArray(n,i)>-1;if(v){var m=p.meta,g=O(t.css(n))||0,y=n+"_o";d=o-g;m[n]=d;m[y]=t.css(n)=="auto"?0+d:g+d||0;p.meta=m;if(a&&d===0){d=0-m[y];m[n]=d;m[y]=0}}return t.data(c,C(t,p,n,r,s,d,u,a,l))}function C(e,t,n,r,i,o,u,a,f){var l=false,c=u===true&&a===true;t=t||{};if(!t.original){t.original={};l=true}t.properties=t.properties||{};t.secondary=t.secondary||{};var h=t.meta,p=t.original,d=t.properties,v=t.secondary;for(var m=s.length-1;m>=0;m--){var g=s[m]+"transition-property",y=s[m]+"transition-duration",b=s[m]+"transition-timing-function";n=c?s[m]+"transform":n;if(l){p[g]=e.css(g)||"";p[y]=e.css(y)||"";p[b]=e.css(b)||""}v[n]=c?T(h.left,h.top,f):o;d[g]=(d[g]?d[g]+",":"")+n;d[y]=(d[y]?d[y]+",":"")+r+"ms";d[b]=(d[b]?d[b]+",":"")+i}return t}function k(e){for(var t in e){if((t=="width"||t=="height")&&(e[t]=="show"||e[t]=="hide"||e[t]=="toggle")){return true}}return false}function L(e){for(var t in e){return false}return true}function A(e){e=e.toUpperCase();var t={LI:"list-item",TR:"table-row",TD:"table-cell",TH:"table-cell",CAPTION:"table-caption",COL:"table-column",COLGROUP:"table-column-group",TFOOT:"table-footer-group",THEAD:"table-header-group",TBODY:"table-row-group"};return typeof t[e]=="string"?t[e]:"block"}function O(e){return parseFloat(e.replace(S(e),""))}function M(e){var t=true;e.each(function(e,n){t=t&&n.ownerDocument;return t});return t}function _(t,n,i){if(!M(i)){return false}var s=e.inArray(t,r)>-1;if((t=="width"||t=="height"||t=="opacity")&&parseFloat(n)===parseFloat(i.css(t)))s=false;return s}var r=["top","right","bottom","left","opacity","height","width"],i=["top","right","bottom","left"],s=["-webkit-","-moz-","-o-",""],o=["avoidTransforms","useTranslate3d","leaveTransforms"],u=/^([+-]=)?([\d+-.]+)(.*)$/,a=/([A-Z])/g,f={secondary:{},meta:{top:0,right:0,bottom:0,left:0}},l="px",c="jQe",h="cubic-bezier(",p=")",d=null,v=false;var m=document.body||document.documentElement,g=m.style,y="webkitTransitionEnd oTransitionEnd transitionend",b=g.WebkitTransition!==undefined||g.MozTransition!==undefined||g.OTransition!==undefined||g.transition!==undefined,w="WebKitCSSMatrix"in window&&"m11"in new WebKitCSSMatrix,E=w;if(e.expr&&e.expr.filters){d=e.expr.filters.animated;e.expr.filters.animated=function(t){return e(t).data("events")&&e(t).data("events")[y]?true:d.call(this,t)}}e.extend({toggle3DByDefault:function(){return E=!E},toggleDisabledByDefault:function(){return v=!v},setDisabledByDefault:function(e){return v=e}});e.fn.translation=function(){if(!this[0]){return null}var e=this[0],t=window.getComputedStyle(e,null),n={x:0,y:0};if(t){for(var r=s.length-1;r>=0;r--){var i=t.getPropertyValue(s[r]+"transform");if(i&&/matrix/i.test(i)){var o=i.replace(/^matrix\(/i,"").split(/, |\)$/g);n={x:parseInt(o[4],10),y:parseInt(o[5],10)};break}}}return n};e.fn.animate=function(n,r,u,a){n=n||{};var f=!(typeof n["bottom"]!=="undefined"||typeof n["right"]!=="undefined"),d=e.speed(r,u,a),m=this,g=0,w=function(){g--;if(g===0){if(typeof d.complete==="function"){d.complete.apply(m,arguments)}}},E=typeof n["avoidCSSTransitions"]!=="undefined"?n["avoidCSSTransitions"]:v;if(E===true||!b||L(n)||k(n)||d.duration<=0){return t.apply(this,arguments)}if(typeof n.avoidTransforms==="undefined"){return t.apply(this,arguments)}return this[d.queue===true?"queue":"each"](function(){var r=e(this),u=e.extend({},d),a=function(t){var o=r.data(c)||{original:{}},u={};if(t.eventPhase!=2)return;if(n.leaveTransforms!==true){for(var a=s.length-1;a>=0;a--){u[s[a]+"transform"]=""}if(f&&typeof o.meta!=="undefined"){for(var h=0,p;p=i[h];++h){u[p]=o.meta[p+"_o"]+l;e(this).css(p,u[p])}}}r.unbind(y).css(o.original).css(u).data(c,null);if(n.opacity==="hide"){r.css({display:"none",opacity:""})}w.call(this)},v={bounce:h+"0.0, 0.35, .5, 1.3"+p,linear:"linear",swing:"ease-in-out",easeInQuad:h+"0.550, 0.085, 0.680, 0.530"+p,easeInCubic:h+"0.550, 0.055, 0.675, 0.190"+p,easeInQuart:h+"0.895, 0.030, 0.685, 0.220"+p,easeInQuint:h+"0.755, 0.050, 0.855, 0.060"+p,easeInSine:h+"0.470, 0.000, 0.745, 0.715"+p,easeInExpo:h+"0.950, 0.050, 0.795, 0.035"+p,easeInCirc:h+"0.600, 0.040, 0.980, 0.335"+p,easeInBack:h+"0.600, -0.280, 0.735, 0.045"+p,easeOutQuad:h+"0.250, 0.460, 0.450, 0.940"+p,easeOutCubic:h+"0.215, 0.610, 0.355, 1.000"+p,easeOutQuart:h+"0.165, 0.840, 0.440, 1.000"+p,easeOutQuint:h+"0.230, 1.000, 0.320, 1.000"+p,easeOutSine:h+"0.390, 0.575, 0.565, 1.000"+p,easeOutExpo:h+"0.190, 1.000, 0.220, 1.000"+p,easeOutCirc:h+"0.075, 0.820, 0.165, 1.000"+p,easeOutBack:h+"0.175, 0.885, 0.320, 1.275"+p,easeInOutQuad:h+"0.455, 0.030, 0.515, 0.955"+p,easeInOutCubic:h+"0.645, 0.045, 0.355, 1.000"+p,easeInOutQuart:h+"0.770, 0.000, 0.175, 1.000"+p,easeInOutQuint:h+"0.860, 0.000, 0.070, 1.000"+p,easeInOutSine:h+"0.445, 0.050, 0.550, 0.950"+p,easeInOutExpo:h+"1.000, 0.000, 0.000, 1.000"+p,easeInOutCirc:h+"0.785, 0.135, 0.150, 0.860"+p,easeInOutBack:h+"0.680, -0.550, 0.265, 1.550"+p},m={},b=v[u.easing||"swing"]?v[u.easing||"swing"]:u.easing||"swing";for(var E in n){if(e.inArray(E,o)===-1){var S=e.inArray(E,i)>-1,T=x(r,n[E],E,S&&n.avoidTransforms!==true);if(_(E,T,r)){N(r,E,u.duration,b,T,S&&n.avoidTransforms!==true,f,n.useTranslate3d)}else{m[E]=n[E]}}}r.unbind(y);var C=r.data(c);if(C&&!L(C)&&!L(C.secondary)){g++;r.css(C.properties);var k=C.secondary;setTimeout(function(){r.bind(y,a).css(k)})}else{u.queue=false}if(!L(m)){g++;t.apply(r,[m,{duration:u.duration,easing:e.easing[u.easing]?u.easing:e.easing.swing?"swing":"linear",complete:w,queue:u.queue}])}return true})};e.fn.animate.defaults={};e.fn.stop=function(t,r,i){if(!b)return n.apply(this,[t,r]);if(t)this.queue([]);this.each(function(){var o=e(this),u=o.data(c);if(u&&!L(u)){var f,h={};if(r){h=u.secondary;if(!i&&typeof u.meta["left_o"]!==undefined||typeof u.meta["top_o"]!==undefined){h["left"]=typeof u.meta["left_o"]!==undefined?u.meta["left_o"]:"auto";h["top"]=typeof u.meta["top_o"]!==undefined?u.meta["top_o"]:"auto";for(f=s.length-1;f>=0;f--){h[s[f]+"transform"]=""}}}else if(!L(u.secondary)){var p=window.getComputedStyle(o[0],null);if(p){for(var d in u.secondary){if(u.secondary.hasOwnProperty(d)){d=d.replace(a,"-$1").toLowerCase();h[d]=p.getPropertyValue(d);if(!i&&/matrix/i.test(h[d])){var v=h[d].replace(/^matrix\(/i,"").split(/, |\)$/g);h["left"]=parseFloat(v[4])+parseFloat(o.css("left"))+l||"auto";h["top"]=parseFloat(v[5])+parseFloat(o.css("top"))+l||"auto";for(f=s.length-1;f>=0;f--){h[s[f]+"transform"]=""}}}}}}o.unbind(y);o.css(u.original).css(h).data(c,null)}else{n.apply(o,[t,r])}});return this}})(jQuery,jQuery.fn.animate,jQuery.fn.stop)




Number.prototype.formatMoney = function(){
	
	var n = parseInt(this);
	
	var value = numeral(n).format('0,0');
	
	return value;
	
 };
 
 
 
 /*!
 * numeral.js
 * version : 1.5.1
 * author : Adam Draper
 * license : MIT
 * http://adamwdraper.github.com/Numeral-js/
 */
(function(){function a(a){this._value=a}function b(a,b,c){var d,e,f=Math.pow(10,b);return e=(Math.round(a*f)/f).toFixed(b),c&&(d=new RegExp("0{1,"+c+"}$"),e=e.replace(d,"")),e}function c(a,b){var c;return c=b.indexOf("$")>-1?e(a,b):b.indexOf("%")>-1?f(a,b):b.indexOf(":")>-1?g(a,b):i(a._value,b)}function d(a,b){var c,d,e,f,g,i=b,j=["KB","MB","GB","TB","PB","EB","ZB","YB"],k=!1;if(b.indexOf(":")>-1)a._value=h(b);else if(b===o)a._value=0;else{for("."!==m[n].delimiters.decimal&&(b=b.replace(/\./g,"").replace(m[n].delimiters.decimal,".")),c=new RegExp("[^a-zA-Z]"+m[n].abbreviations.thousand+"(?:\\)|(\\"+m[n].currency.symbol+")?(?:\\))?)?$"),d=new RegExp("[^a-zA-Z]"+m[n].abbreviations.million+"(?:\\)|(\\"+m[n].currency.symbol+")?(?:\\))?)?$"),e=new RegExp("[^a-zA-Z]"+m[n].abbreviations.billion+"(?:\\)|(\\"+m[n].currency.symbol+")?(?:\\))?)?$"),f=new RegExp("[^a-zA-Z]"+m[n].abbreviations.trillion+"(?:\\)|(\\"+m[n].currency.symbol+")?(?:\\))?)?$"),g=0;g<=j.length&&!(k=b.indexOf(j[g])>-1?Math.pow(1024,g+1):!1);g++);a._value=(k?k:1)*(i.match(c)?Math.pow(10,3):1)*(i.match(d)?Math.pow(10,6):1)*(i.match(e)?Math.pow(10,9):1)*(i.match(f)?Math.pow(10,12):1)*(b.indexOf("%")>-1?.01:1)*((b.split("-").length+Math.min(b.split("(").length-1,b.split(")").length-1))%2?1:-1)*Number(b.replace(/[^0-9\.]+/g,"")),a._value=k?Math.ceil(a._value):a._value}return a._value}function e(a,b){var c,d=b.indexOf("$")<=1?!0:!1,e="";return b.indexOf(" $")>-1?(e=" ",b=b.replace(" $","")):b.indexOf("$ ")>-1?(e=" ",b=b.replace("$ ","")):b=b.replace("$",""),c=i(a._value,b),d?c.indexOf("(")>-1||c.indexOf("-")>-1?(c=c.split(""),c.splice(1,0,m[n].currency.symbol+e),c=c.join("")):c=m[n].currency.symbol+e+c:c.indexOf(")")>-1?(c=c.split(""),c.splice(-1,0,e+m[n].currency.symbol),c=c.join("")):c=c+e+m[n].currency.symbol,c}function f(a,b){var c,d="",e=100*a._value;return b.indexOf(" %")>-1?(d=" ",b=b.replace(" %","")):b=b.replace("%",""),c=i(e,b),c.indexOf(")")>-1?(c=c.split(""),c.splice(-1,0,d+"%"),c=c.join("")):c=c+d+"%",c}function g(a){var b=Math.floor(a._value/60/60),c=Math.floor((a._value-60*60*b)/60),d=Math.round(a._value-60*60*b-60*c);return b+":"+(10>c?"0"+c:c)+":"+(10>d?"0"+d:d)}function h(a){var b=a.split(":"),c=0;return 3===b.length?(c+=60*60*Number(b[0]),c+=60*Number(b[1]),c+=Number(b[2])):2===b.length&&(c+=60*Number(b[0]),c+=Number(b[1])),Number(c)}function i(a,c){var d,e,f,g,h,i,j=!1,k=!1,l=!1,p="",q="",r="",s=Math.abs(a),t=["B","KB","MB","GB","TB","PB","EB","ZB","YB"],u="",v=!1;if(0===a&&null!==o)return o;if(c.indexOf("(")>-1?(j=!0,c=c.slice(1,-1)):c.indexOf("+")>-1&&(k=!0,c=c.replace(/\+/g,"")),c.indexOf("a")>-1&&(c.indexOf(" a")>-1?(p=" ",c=c.replace(" a","")):c=c.replace("a",""),s>=Math.pow(10,12)?(p+=m[n].abbreviations.trillion,a/=Math.pow(10,12)):s<Math.pow(10,12)&&s>=Math.pow(10,9)?(p+=m[n].abbreviations.billion,a/=Math.pow(10,9)):s<Math.pow(10,9)&&s>=Math.pow(10,6)?(p+=m[n].abbreviations.million,a/=Math.pow(10,6)):s<Math.pow(10,6)&&s>=Math.pow(10,3)&&(p+=m[n].abbreviations.thousand,a/=Math.pow(10,3))),c.indexOf("b")>-1)for(c.indexOf(" b")>-1?(q=" ",c=c.replace(" b","")):c=c.replace("b",""),f=0;f<=t.length;f++)if(d=Math.pow(1024,f),e=Math.pow(1024,f+1),a>=d&&e>a){q+=t[f],d>0&&(a/=d);break}return c.indexOf("o")>-1&&(c.indexOf(" o")>-1?(r=" ",c=c.replace(" o","")):c=c.replace("o",""),r+=m[n].ordinal(a)),c.indexOf("[.]")>-1&&(l=!0,c=c.replace("[.]",".")),g=a.toString().split(".")[0],h=c.split(".")[1],i=c.indexOf(","),h?(h.indexOf("[")>-1?(h=h.replace("]",""),h=h.split("["),u=b(a,h[0].length+h[1].length,h[1].length)):u=b(a,h.length),g=u.split(".")[0],u=u.split(".")[1].length?m[n].delimiters.decimal+u.split(".")[1]:"",l&&0===Number(u.slice(1))&&(u="")):g=b(a,null),g.indexOf("-")>-1&&(g=g.slice(1),v=!0),i>-1&&(g=g.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1"+m[n].delimiters.thousands)),0===c.indexOf(".")&&(g=""),(j&&v?"(":"")+(!j&&v?"-":"")+(!v&&k?"+":"")+g+u+(r?r:"")+(p?p:"")+(q?q:"")+(j&&v?")":"")}function j(a,b){m[a]=b}var k,l="1.5.1",m={},n="en",o=null,p="0,0",q="undefined"!=typeof module&&module.exports;k=function(b){return k.isNumeral(b)?b=b.value():0===b||"undefined"==typeof b?b=0:Number(b)||(b=k.fn.unformat(b)),new a(Number(b))},k.version=l,k.isNumeral=function(b){return b instanceof a},k.language=function(a,b){if(!a)return n;if(a&&!b){if(!m[a])throw new Error("Unknown language : "+a);n=a}return(b||!m[a])&&j(a,b),k},k.language("en",{delimiters:{thousands:",",decimal:"."},abbreviations:{thousand:"k",million:"m",billion:"b",trillion:"t"},ordinal:function(a){var b=a%10;return 1===~~(a%100/10)?"th":1===b?"st":2===b?"nd":3===b?"rd":"th"},currency:{symbol:"$"}}),k.zeroFormat=function(a){o="string"==typeof a?a:null},k.defaultFormat=function(a){p="string"==typeof a?a:"0.0"},k.fn=a.prototype={clone:function(){return k(this)},format:function(a){return c(this,a?a:p)},unformat:function(a){return d(this,a?a:p)},value:function(){return this._value},valueOf:function(){return this._value},set:function(a){return this._value=Number(a),this},add:function(a){return this._value=this._value+Number(a),this},subtract:function(a){return this._value=this._value-Number(a),this},multiply:function(a){return this._value=this._value*Number(a),this},divide:function(a){return this._value=this._value/Number(a),this},difference:function(a){var b=this._value-Number(a);return 0>b&&(b=-b),b}},q&&(module.exports=k),"undefined"==typeof ender&&(this.numeral=k),"function"==typeof define&&define.amd&&define([],function(){return k})}).call(this);