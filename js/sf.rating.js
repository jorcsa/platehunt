(function($){ 

    $.fn.extend({
		
		_sf_listings_review_stars: function() {
			
			var mainCont = this;
			var stars = mainCont.find('i');
			var input = mainCont.find('input');
			var fullClass = 'icon-star';
			var emptyClass = 'icon-star-empty';
			
			//// SETS THE INITIAL OPACITY
			stars.css({ opacity: .3 });
			
			//// WHEN WE HOVER THE STARS
			stars.hover(function() {
				
				//// MAKE SURE THE ONES BEFORE IT ARE OPAQUE AND FULL
				var theIndex = jQuery(this).index();
				
				//// THE ONES THAT SHOULD BE FULL
				mainCont.find('i:lt('+theIndex+')').attr('class', fullClass).css({ opacity: 1 });
				jQuery(this).attr('class', fullClass).css({ opacity: 1 });
				
				///// THE OTHER ONES
				mainCont.find('i:gt('+theIndex+')').attr('class', emptyClass).css({ opacity: .3 });
				
			}, function() {
				
				//// IF OUR VALUE IS EMPTY
				if(input.val() == '') {
				
					///// THE OTHER ONES
					mainCont.find('i').attr('class', emptyClass).css({ opacity: .3 });
					
				} else {
					
					var theIndex = input.val()-1;
					
					//// PUT IT BACK TO THE STORED VALUE
					mainCont.find('i:lt('+theIndex+'), i:eq('+theIndex+')').attr('class', fullClass).css({ opacity: 1 });
					
					///// THE OTHER ONES
					mainCont.find('i:gt('+theIndex+')').attr('class', emptyClass).css({ opacity: .3 });
					
				}
				
			});
			
			/// WHEN WE CLICK UPDATE INPUT
			stars.click(function() {
				
				var theIndex = jQuery(this).index();
				
				//// UPDATES INPUT
				input.val((theIndex+1));
				
			});
			
		},
		
		_sf_review_submit: function() {
			
			var formCont = this;
			var buttonCont = this.find('input[type="submit"]');
			
			formCont.submit(function(e) {
				
				jQuery('input.error, textarea.error').removeClass('error');
				jQuery('small.error').fadeOut(300);
				var errors = false;
				
				//// LETS MAKE SURE ALL FIELDS ARE SET
				formCont.find('input, textarea').each(function() {
					
					if(jQuery(this).val() == '') { errors = true; jQuery(this).addClass('error').siblings('small').fadeIn(300, function() { jQuery(this).delay(3000).fadeOut(300); }); }
					
				});
				
				///// IF THERE ARE NO ERRORS WE CAN SUBMIT IT
				if(errors === false) {
					
					//// LOADING SIGN
					formCont.children('*:not(.spinner)').stop().animate({ opacity: .2 }, 300);
					formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
					buttonCont.attr('disabled', 'disabled');
					
					//// DOES OUR AJAX REQUEST
					jQuery.ajax({
						
						url: 				sf_r.ajaxurl,
						type: 				'post',
						dataType: 			'json',
						data: {
							
							action: 		'sf_rating',
							nonce: 			sf_r._sf_rating_nonce,
							data: 			formCont.serialize()
							
						},
						success: function(data) {
							
							console.log(data);
							
							//// IF THERE ARE ERRORS
							if(data.error) {
								
								///// PUTS FORM ABCK TO NORMAL
								formCont.spin(false).children('*').stop().animate({ opacity: 1 }, 300);
								buttonCont.removeAttr('disabled');
								
								//// DISPLAYS THE MESSAGE AT THE TOP
								if(data.error_message) {
									
									formCont.prepend('<p class="error" style="display:none"><br><small>'+data.error_message+'</small></p>');
									formCont.children('p.error').slideDown(250, function() { jQuery(this).delay(3000).slideUp(250, function() { jQuery(this).remove(); }); });
								
								}
								
								//// FIELD ERRORS
								if(data.error_fields.length > 0) {
									
									jQuery.each(data.error_fields, function(i, the_field) {
										
										//// ADDS THE RROR TO THAT FIELD
										jQuery('#'+the_field.field).parent().addClass('error').append('<small>'+the_field.message+'</small>');
										setTimeout(function() { jQuery('#'+the_field.field).parent().removeClass('error').find('small:not(.error)').remove(); }, 3000);
										
									});
									
								}
								
							} else {
								
								//// REMOVES THE FORM AND DISPLAYS MESSAGE
								formCont.fadeOut(300, function() {
									
									formCont.html('<h4>'+data.message+'</h4>').fadeIn(300);
									
								})
								
							}
							
						}
						
					});
					
				}
				
				//// PREVENTS NON AJAX SUBMISSIONS
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_load_more_reviews: function(parent) {
			
			var mainCont = this;
			var button = mainCont.children('a');
			var ulCont = jQuery('#reviews > ul');
			
			/// WHEN WE CLICK IT
			button.click(function(e) {
				
				var reviewsCount = ulCont.children('li').length;
				
				//// HIDES THE BUTTON AND ADDS A SPINNING SIGN
				button.hide();
				mainCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				
				//// LOADS MORE COMMENTS VIA AJAX
				jQuery.ajax({
						
					url: 				button.attr('href'),
					type: 				'get',
					dataType: 			'html',
					success: function(data) {
						
						//// LETS GET THE HTML WE JUST LOADDED AND APPEND IT TO OUR UL
						var theMarkup = jQuery(data).find('#reviews ul').html();
						ulCont.append(theMarkup);
						
						///// CHECKS IF WE HAVE A LOAD MORE BUTTON
						if(jQuery(data).find('#reviews-load-more').length == 0) { jQuery('#reviews-load-more').remove(); }
						else { button.attr('href', jQuery(data).find('#reviews-load-more a').attr('href')).show(); mainCont.spin(false); }
						
					}
					
				});
				
				//// PREVENTS NON AJAX CLICKS
				e.preventDefault()
				return false;
				
			});
			
		},
		
		sf_report_rating: function(e, post_id) {
			
			var button = this;
			var mainCont = button.closest('li');
			
			///// FADES IT OUT AND ADDS SPINNER
			mainCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 }).children('*:not(.spinner)').animate({ opacity: .3 }, 200);
			
			///// DOES OUT AJAX REQUEST
			jQuery.ajax({
				
				url:				sf_r.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'sf_report_review',
					nonce: 			sf_r._sf_report_review_nonce,
					post_id: 		post_id
					
				},
				success: function(data) {
					
					if(data.error) { alert(data.error); }
					else { mainCont.spin(false).children('*:not(.spinner)').animate({ opacity: 1 }, 200); mainCont.find('.rating-comment').html(data.message); }
					
				}
				
			});
			
			///// PREVENTS DEFAULT,
			e.preventDefault();
			return false;
			
		},
		
		sf_trash_rating: function(e, post_id) {
			
			var button = this;
			var mainCont = button.closest('li');
			
			///// FADES IT OUT AND ADDS SPINNER
			mainCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 }).children('*:not(.spinner)').animate({ opacity: .3 }, 200);
			
			///// DOES OUT AJAX REQUEST
			jQuery.ajax({
				
				url:				sf_r.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'sf_trash_review',
					nonce: 			sf_r._sf_trash_review_nonce,
					post_id: 		post_id
					
				},
				success: function(data) {
					
					if(data.error) { alert(data.error); }
					else { mainCont.spin(false).children('*:not(.spinner)').animate({ opacity: 1 }, 200); mainCont.slideUp(300); }
					
				}
				
			});
			
			///// PREVENTS DEFAULT,
			e.preventDefault();
			return false;
			
		},
		
		sf_restore_rating: function(e, post_id) {
			
			var button = this;
			var mainCont = button.closest('li');
			
			///// FADES IT OUT AND ADDS SPINNER
			mainCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 }).children('*:not(.spinner)').animate({ opacity: .3 }, 200);
			
			///// DOES OUT AJAX REQUEST
			jQuery.ajax({
				
				url:				sf_r.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'sf_restore_review',
					nonce: 			sf_r._sf_restore_review_nonce,
					post_id: 		post_id
					
				},
				success: function(data) {
					
					if(data.error) { alert(data.error); }
					else { mainCont.spin(false).children('*:not(.spinner)').animate({ opacity: 1 }, 200); mainCont.removeClass('review-moderate').find('.rating-comment').html(data.message); }
					
				}
				
			});
			
			///// PREVENTS DEFAULT,
			e.preventDefault();
			return false;
			
		}
		
	});
	
})(jQuery);