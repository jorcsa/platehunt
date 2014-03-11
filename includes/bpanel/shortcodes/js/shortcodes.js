
(function($){ 
    $.fn.extend({ 
	
		ddToggle: function() {
			
			//main vars
			var mainCont = this.parent();
			var titleCont = this;
			var textCont = mainCont.children('div');
			
			//find out the state of the toggle
			if(mainCont.attr('class').indexOf('toggle-open') != -1) {
				
				//It's open
				
				//slides up
				textCont.slideUp(300);
				mainCont.removeClass('toggle-open');
				titleCont.children('span').removeClass('close');
				
			} else {
				
				//it's closed
				
				//if it has a toggle id — Close all others
				if(mainCont.attr('class').indexOf('toggleid') != -1) {
					
					//gets the toggle id and adds a quick class to not close the current toggle
					mainCont.addClass('notThisToggle');
					var toggleIds = mainCont.attr('class').split(' ');
					var toggleId = '';
					for(var i in toggleIds) {
						
						if(toggleIds[i].indexOf('toggleid') != -1) { toggleId = toggleIds[i]; }
						
					}
					
					//closes all toggles
					jQuery('.'+toggleId+':not(notThisToggle)').children('div').slideUp(300, function() {
						
						jQuery(this).parent().removeClass('toggle-open');
						jQuery(this).parent().children('h6').children('span').removeClass('close');
						
					});
					
				}
				
				//slides down and changes state
				textCont.slideDown(300);
				mainCont.addClass('toggle-open').removeClass('notThisToggle');
				titleCont.children('span').addClass('close');
				
			}
			
		},
		
		ddTooltip: function() {
			
			//main vars
			var mainCont = this;
			var toolCont = this.children('div.tooltip-content');
			var mainContWidth = mainCont.width();
			var mainContHeight = mainCont.height();
			
			var toolSides = mainCont.attr('class').split(' ');
			var toolSide = '';
			for(var i in toolSides) {
				if(toolSides[i].indexOf('tooltip-side-') != -1) { toolSide = toolSides[i].split('-'); toolSide = toolSide[2]; }
			}
			
			//sets initial position
			if(toolSide == 'right') {
				toolCont.css({ left: (mainContWidth)+'px', top: 3+'px' });
			} else if (toolSide == 'left') {
				toolCont.css({ right: (mainContWidth)+'px', top: 3+'px' });
			} else if (toolSide == 'top') {
				toolCont.css({ bottom: (mainContHeight)+'px', left: 0 });
			} else {
				toolCont.css({ top: (mainContHeight)+'px', left: 0 });
			}
			
			//when user hovers it
			mainCont.hover(function() {
				
				//shows it
				if(toolCont.children('div').children('span.close').length == 0) {
					
					toolCont.css({ opacity: 0, display: 'block' }).stop().animate({ opacity: 1 }, 300);
					
				} else {
					
					toolCont.fadeIn(300);
					
				}
				
			}, function() {
				
				//If it's not fixed
				if(toolCont.children('div').children('span.close').length == 0) {
					
					toolCont.stop().animate({ opacity: 0 }, 300, function() {
						
						jQuery(this).hide();
						
					});	
					
				}
				
			});
			
			// closes if user clicks close button
			if(toolCont.children('div').children('span.close').length > 0) {
				
				toolCont.children('div').children('span.close').click(function() {
					
					toolCont.fadeOut(300);
					
				});
				
			}
			
		},
		
		ddGetTheCode: function() {
			
			// MAIN VARS
			var mainCont = this.parent();
			var headerCont = this;
			var codeCont = mainCont.children('div');
			
			// if the h6 has the collapse tag
			if(headerCont.attr('class').indexOf('collapse') != -1) {
				
				codeCont.hide();
				headerCont.attr('class', 'open');
				
			} else {
				
				codeCont.show();
				headerCont.attr('class', 'collapse');
				
			}
			
		},
		
		ddGoToTop: function() {
			
			jQuery('html, body').stop().animate({ scrollTop: 0 }, 300);
			
		},
		
		ddSloganSlider: function() {
			
			//// MAIN VARS
			var maincont = this;
			var totalSlogans = maincont.children('.ddslogan_slide').length;
			var selCont = maincont.children('.ddslogan_slider_selector');
			isSloganPlaying = 0;
			stopAutoSlogan = 0;
			
			//// IF IT'S MORE THAN ONE SLOGAN ADD THE SELECTORS
			if(totalSlogans > 1) {
				
				//// ADDS THE SELECTORS
				for(i=1;i<= totalSlogans;i++) { selCont.append('<li></li>'); }
				
				//// SHOWS THE FIRST ONE
				maincont.children('.ddslogan_slide:first').addClass('current').slideDown(300);
				selCont.children('li:first').addClass('current');
				
				//// WHEN USER CLICKS A SELECTOR
				selCont.children('li').click(function() {
					
					if(isSloganPlaying === 0) {
						
						stopAutoSlogan = 1;
						isSloganPlaying = 1;
						
						var clickedIndex = jQuery(this).index();
						selCont.children('li.current').removeClass('current');
						jQuery(this).addClass('current');
						
						//// FADES OUT CURRENT
						maincont.children('.ddslogan_slide.current').fadeOut(200, function() {
							
							//// FADES IN NEXT ONE
							jQuery(this).removeClass('current');
							maincont.children('.ddslogan_slide:eq('+clickedIndex+')').addClass('current').fadeIn(200, function() { isSloganPlaying = 0; });
							
							
						});
						
					}
					
				});
				
				//// AUTOSLIDE
				var slideDelay = maincont.attr('class').split(' ');
				slideDelay = slideDelay[1].split('-');
				if(slideDelay[1] != '' && slideDelay[1] != 'false') {
					
					//// SETS UP OUR INTERVAL
					setInterval(function() {
						
						if(isSloganPlaying === 0 && stopAutoSlogan === 0) {
					
							isSloganPlaying = 1;
							
							var nextItem = selCont.children('li.current').next();
							if(nextItem.length > 0 ) {  } else { nextItem = selCont.children('li:first'); }
							
							var clickedIndex = nextItem.index();
							selCont.children('li.current').removeClass('current');
							nextItem.addClass('current');
							
							//// FADES OUT CURRENT
							maincont.children('.ddslogan_slide.current').fadeOut(200, function() {
								
								//// FADES IN NEXT ONE
								jQuery(this).removeClass('current');
								maincont.children('.ddslogan_slide:eq('+clickedIndex+')').addClass('current').fadeIn(200, function() { isSloganPlaying = 0; });
								
								
							});
							
						}
						
					}, slideDelay[1]);
					
				}
				
			} else {
			//// JUST DISPLAY THE FIRST ONE	
				
				maincont.children('.ddslogan_slide:first').slideDown(300);
				
			}
			
		},
		
		ddImagePreload: function() {
			
			//// main vars
			var mainCont = this;
			var imageUrl = mainCont.children('span').text();
			
			var thisImageObj = new Image();
			jQuery(thisImageObj).attr('src', imageUrl);
			
			jQuery(thisImageObj).load(function() {
				
				mainCont.children('span').remove();
				mainCont.append(this);
				
				mainCont.children('img').fadeIn(300, function() {
					
					jQuery(this).css({ display: 'block' });
					mainCont.removeClass('imagePreload');
					
				});
				
			});
			
		},
		
		ddFadeOnHover: function(thisOpacity) {
			
			//vars
			var thisItem = this;
			thisItem.each(function() {
				
				//each item on hover
				jQuery(this).hover(function() {
					
					//fades out
					jQuery(this).stop().animate({ opacity: thisOpacity }, 300);
					
				}, function() {
					
					//goes back to normal
					jQuery(this).stop().animate({ opacity: 1 }, 300);
					
				});
				
			});
			
		},
		
		ddFadeOthersOnHover: function(thisOpacity) {
			
			//vars
			var thisItem = this;
			thisItem.hover(function() {
				
				jQuery(this).siblings().stop().animate({ opacity: thisOpacity }, 150);
				
			}, function() {
				
				jQuery(this).siblings().stop().animate({ opacity: 1 }, 150);
				
			});
			
		},
		
		closeNotification: function() {
			
			//our main container
			var mainCont = this;
			
			//when clicked
			this.children('span.close').click(function() {
				
				mainCont.slideUp(300);
				
			});
			
		},
		
		ddImageSlider: function() {
			
			//// main vars
			var mainCont = this;
			var imageCont = this.children('.full-image');
			var selCont = this.children('.slider-selector').children('ul');
			var leftArrowCont = this.children('.left-arrow').css({ display: 'block', opacity: 0 });
			var rightArrowCont = this.children('.right-arrow').css({ display: 'block', opacity: 0 });
			var prevArrow = imageCont.children('.prev-slide').css({ display: 'block', opacity: 0 });
			var nextArrow = imageCont.children('.next-slide').css({ display: 'block', opacity: 0 });
			
			//checks if it has autoslide
			if(mainCont.attr('class').indexOf('sliderauto') != -1) { var autoSlide = mainCont.attr('class').split(' '); var autoSlide = autoSlide[1].split('-'); }
			
			//globals
			isSlideLoading = 0;
			isThumbPlaying = 0;
			
			//// loads first image and sets up slider
			var firstImage = selCont.children('li:first');
			firstImage.ddImageSliderLoadImage();
			
			//// activates our thumbnails selector
			//hover effect
			selCont.children('li:not(.current)').css({ opacity: .6 }).hover(function() {
				
				jQuery(this).stop().animate({ opacity: 1 }, 100);
				
			}, function() {
				
				if(jQuery(this).attr('class') != 'current') { jQuery(this).stop().animate({ opacity: .6 }, 300); }
				
			});
			
			//scrolls our thumbnails
			mainCont.hover(function() {
				
				mainCont.mousemove(function(e) {
				
					var thisOffset = jQuery(this).offset();
					var fullHeight = jQuery(this).children('.full-image').height();
					var fullWidth = jQuery(this).children('.full-image').width();
					var selWidth = (selCont.children('li').length * 80);
					var x = e.pageX - thisOffset.left;
					var y = e.pageY - thisOffset.top;
					
					//if the mouse is on the right side of the thumbnails
					if((x > (fullWidth/4*3) && (y > fullHeight)) ) {
						
						var currentLeft = Math.abs(parseInt(selCont.css('left')));
						var eachSlide = fullWidth / 2;
						var currentSlide = (currentLeft / eachSlide);
						
						//number of total slides we can get
						var totalSlides = Math.floor((selWidth - fullWidth) / eachSlide);
						
						//IF WE CAN STILL PLAY SLDIES SHOW THE NEXT
						if(currentSlide <= totalSlides) {
							
							rightArrowCont.stop().animate({ opacity: 1 }, 100);
							
						} else {
							
							rightArrowCont.stop().animate({ opacity: 0 }, 100);
							
						}
						
					} else {
						
						//hides in case we move out
						rightArrowCont.stop().animate({ opacity: 0 }, 100);
						
					}
					
					//if the mouse is on the right side of the thumbnails
					if((x < (fullWidth/4*1) && (y > fullHeight)) ) {
						
						var currentLeft = Math.abs(parseInt(selCont.css('left')));
						var eachSlide = fullWidth / 2;
						var currentSlide = (currentLeft / eachSlide);
						
						//number of total slides we can get
						var totalSlides = Math.floor((selWidth - fullWidth) / eachSlide);
						
						//IF WE CAN STILL PLAY SLDIES SHOW THE NEXT
						if(currentSlide > 0) {
							
							leftArrowCont.stop().animate({ opacity: 1 }, 100);
							
						} else {
							
							leftArrowCont.stop().animate({ opacity: 0 }, 100);
							
						}
						
						
						
					} else {
						
						//hides in case we move out
						leftArrowCont.stop().animate({ opacity: 0 }, 100);
						
					}
				
				});
				
			}, function() {
				
				//// HIDES IT ALL
				rightArrowCont.stop().animate({ opacity: 0 }, 100);
				leftArrowCont.stop().animate({ opacity: 0 }, 100);
				
			});
			
			//when user clicks to scroll our thumbnails (next)
			rightArrowCont.click(function() {
				
				if(isThumbPlaying === 0) {
				
					var fullWidth = mainCont.children('.full-image').width();
					var selWidth = (selCont.children('li').length * 80);
					
					var currentLeft = Math.abs(parseInt(selCont.css('left')));
					var eachSlide = fullWidth / 2;
					var currentSlide = (currentLeft / eachSlide);
					var totalSlides = Math.floor((selWidth - fullWidth) / eachSlide);
					
					if(currentSlide <= totalSlides) {
					
						isThumbPlaying = 1;
						
						var nextLeft = (currentSlide+1) * eachSlide;
						selCont.stop().animate({ left: '-'+nextLeft+'px' }, 200, function() { isThumbPlaying = 0; });
						
					}
				
				}
				
			});
			
			//when user clicks to scroll our thumbnails (prev)
			leftArrowCont.click(function() {
				
				if(isThumbPlaying === 0) {
				
					var fullWidth = mainCont.children('.full-image').width();
					var selWidth = (selCont.children('li').length * 80);
					
					var currentLeft = Math.abs(parseInt(selCont.css('left')));
					var eachSlide = fullWidth / 2;
					var currentSlide = (currentLeft / eachSlide);
					var totalSlides = Math.floor((selWidth - fullWidth) / eachSlide);
					
					if(currentSlide > 0) {
					
						isThumbPlaying = 1;
						
						var nextLeft = (currentSlide-1) * eachSlide;
						selCont.stop().animate({ left: '-'+nextLeft+'px' }, 200, function() { isThumbPlaying = 0; });
						
					}
					
				}
				
			});
			
			//// if user selects a new slider
			selCont.children('li').click(function() {
				
				if(mainCont.attr('class').indexOf('clicked') == -1) { mainCont.addClass('clicked'); }
				//IF ITS NOT CURRENT
				if(jQuery(this).attr('class') != 'current' && isSlideLoading === 0) {
					
					isSlideLoading = 1;
					jQuery(this).ddImageSliderLoadImage();
					
				}
				
			});
			
			//// fades out when we hover the full image
			mainCont.children('.full-image').children('a').hover(function() {
				
				jQuery(this).children('span').stop().animate({ opacity: .2 }, 200);
				
			}, function() {
				
				jQuery(this).children('span').stop().animate({ opacity: 1 }, 200);
				
			});
			
			//// show arrows when suer hovers the full image
			imageCont.hover(function() {
				
				jQuery(this).children('.prev-slide, .next-slide').stop().animate({ opacity: .2 }, 150);
				
			}, function() {
				
				jQuery(this).children('.prev-slide, .next-slide').stop().animate({ opacity: 0 }, 150);
				
			});
			
			//slide arrow
			prevArrow.hover(function() { jQuery(this).mousemove(function() { jQuery(this).stop().animate({ opacity: 1 }, 100); }); }, function() { jQuery(this).stop().animate({ opacity: .2 }, 200); });
			nextArrow.hover(function() { jQuery(this).mousemove(function() { jQuery(this).stop().animate({ opacity: 1 }, 100); }); }, function() { jQuery(this).stop().animate({ opacity: .2 }, 200); });
			
			prevArrow.click(function() {
				
				if(mainCont.attr('class').indexOf('clicked') == -1) { mainCont.addClass('clicked'); }
				var previousSlide = selCont.children('li.current').prev();
				if(previousSlide.length > 0) {} else { previousSlide = selCont.children('li:last'); }
				
				if(isSlideLoading === 0) {
					
					isSlideLoading = 1;
					previousSlide.ddImageSliderLoadImage();
					
				}
				
			});
			
			nextArrow.click(function() {
				
				if(mainCont.attr('class').indexOf('clicked') == -1) { mainCont.addClass('clicked'); }
				var nextSlide = selCont.children('li.current').next();
				if(nextSlide.length > 0) {} else { nextSlide = selCont.children('li:first'); }
				
				if(isSlideLoading === 0) {
					
					isSlideLoading = 1;
					nextSlide.ddImageSliderLoadImage();
					
				}
				
			});
			
			// when users hovers the slider stop autoslide
			mainCont.hover(function() {
				
				jQuery(this).addClass('hovering');
				
			}, function() {
				
				jQuery(this).removeClass('hovering');
				
			});
			
			//if it has autoslide
			if(autoSlide != undefined) {
				
				var slideAuto = setInterval(function() {
					
					// USER ISN'T HOVERING OR HASNT CLICKED
					if((mainCont.attr('class').indexOf('hovering') == -1) && (mainCont.attr('class').indexOf('clicked') == -1)) {
				
						var nextSlide = selCont.children('li.current').next();
						if(nextSlide.length > 0) {} else { nextSlide = selCont.children('li:first'); }
					
						if(isSlideLoading === 0) {
							
							isSlideLoading = 1;
							nextSlide.ddImageSliderLoadImage();
							
						}
						
					}
					
				}, autoSlide[1]);
				
			}
			
		},
		
		ddImageSliderLoadImage: function() {
			
			//mainvars
			var liCont = this;
			var imageUrl = liCont.children('.full').text();
			var linkUrl = liCont.children('.link').text();
			var imageTitle = liCont.children('img').attr('title');
			var imageDesc = liCont.children('img').attr('alt');
			var mainCont = this.parent().parent().parent().children('.full-image').children('a');
			
			if(liCont.children('.link').attr('class').indexOf('lightbox') != -1) { var linkType = 'lightbox'; }
			else { var linkType = 'link'; }
			
			//decides the current
			liCont.siblings('li.current').removeClass('current').css({ opacity: .6 });
			liCont.addClass('current').css({ opacity: 1 });
			
			//let's fadeout what's there so we can tell the user we're loading
			mainCont.animate({ opacity: .3 }, 150, function() {
				
				mainCont.attr('href', '#');
			
				//image object
				var newImage = new Image();
				jQuery(newImage).attr('src', imageUrl);
				
				//loads it
				jQuery(newImage).load(function() {
					
					var newImageObject = this;
					
					//removes what's in there
					mainCont.animate({ opacity: 0 }, 150, function() {
						
						//appeds image
						mainCont.html('').append(newImageObject);
						
						//appeds title & desc
						mainCont.append('<span>'+imageTitle+'</span>');
						if(imageDesc != undefined) { mainCont.children('span').append('<span>'+imageDesc+'</span>'); }
						
						//updates link
						if(linkType == 'link') { mainCont.attr('href', linkUrl).attr('target', '_blank').removeAttr('rel'); }
						else { mainCont.attr('href', linkUrl).attr('rel', 'prettyPhoto').removeAttr('target');
						
							jQuery("a[rel^='prettyPhoto']").prettyPhoto({
					
								theme: 'timeless',
								show_title: false,
								social_tools: ''
								
							});
						
						}
						
						//fades in
						mainCont.animate({ opacity: 1 }, 200);
						
						isSlideLoading = 0;
						
					});
					
				});
				
			});
			
		},
		
		ddTabs: function() {
			
			//main vars
			var mainCont = this;
			var tabsCont = this.children('ul.dd-tabs');
			var tabbedCont = this.children('ul.dd-tabbed');
			
			//we need to set up our content correctly first
			var i = 0;
			tabbedCont.children('li').each(function() {
				
				// get the title
				var thisTitle = jQuery(this).attr('title');
				
				//attach it to our tabs
				if(i === 0) {
					
					tabsCont.append('<li class="current">'+thisTitle+'<span></span></li>');
					jQuery(this).addClass('current');
					
				} else {
					
					tabsCont.append('<li>'+thisTitle+'<span></span></li>');
					
				}
				
				// removes title attr
				jQuery(this).removeAttr('title');
				
				i++;
				
			});
			
			// show it
			mainCont.show();
			
			//sets up initial
			tabsCont.children('li').click(function() {
				
				if(jQuery(this).attr('class') != 'current') {
					
					jQuery(this).callDDTab();
					
				}
				
			});
			
		},
		
		callDDTab: function() {
			
			//main vars
			var liCont = this;
			var mainCont = this.parent().parent();
			var tabsCont = mainCont.children('ul.dd-tabs');
			var tabbedCont = mainCont.children('ul.dd-tabbed');
			
			//find the index of our li.
			var thisIndex = (liCont.index() - 2);
			
			//removes current from previous tab
			tabsCont.children('li:not(.shadow-left, .shadow-right).current').removeClass('current');
			liCont.addClass('current');
			
			//fadesout the current tabbed
			tabbedCont.children('li.current').animate({ opacity: 0 }, 150, function() {
				
				jQuery(this).hide().css({ opacity: 1 }).removeClass('current');
				
				tabbedCont.children('li:eq('+thisIndex+')').fadeIn(150, function() { jQuery(this).addClass('current'); });
				
			})
			
		},
		
		ddPricing: function() {
			
			var mainCont = this;
			
			/// LETS CHECK THE HEAD
			var maximumHeadHeight = 0;
			mainCont.children('.ddpricing-col').each(function() {
				
				var thisHeadHeight = jQuery(this).children('.ddpricing-head').height();
				if(thisHeadHeight > maximumHeadHeight) { maximumHeadHeight = thisHeadHeight; }
				
			});
			
			//sets new height 
			mainCont.children('.ddpricing-col').children('.ddpricing-head').animate({ height: maximumHeadHeight+'px' }, 300);
			
			
			/// LETS CHECK THE BODY
			var maximumBodyHeight = 0;
			mainCont.children('.ddpricing-col').each(function() {
				
				var thisBodyHeight = jQuery(this).children('.ddpricing-body').height();
				if(thisBodyHeight > maximumBodyHeight) { maximumBodyHeight = thisBodyHeight; }
				
			});
			
			//sets new height 
			mainCont.children('.ddpricing-col').children('.ddpricing-body').animate({ height: maximumBodyHeight+'px' }, 300);
			
		},
		
		ddContact: function() {
			
			//// main vars
			var mainCont = this;
			var formCont = this.children('form');
			var thankCont = this.children('.ddcontact_thankyou');
			var nameField = formCont.children('p.contactName').children('input');
			var emailField = formCont.children('p.contactEmail').children('input');
			var emailToField = formCont.children('p.emailTo').children('input');
			var messageField = formCont.children('p.contactMessage').children('textarea');
			var errorField = mainCont.children('.notification');
			var formUrl = formCont.attr('action'); 
			
			//// When the users submits the form we cancel it!
			formCont.submit(function() {
				
				var errorMessage = ''; errorField.fadeOut(200);
				nameField.removeClass('alert');
				emailField.removeClass('alert');
				messageField.removeClass('alert');
				
				//// LET'S VALIDATE OUR FIELDS
				if(nameField.val() == '') { errorMessage += 'Please fill out the Name field.<br>'; nameField.addClass('alert'); }
				if(emailField.val() == '') { errorMessage += 'Please fill out the Email field.<br>'; emailField.addClass('alert'); }
				if(messageField.val() == '') { errorMessage += 'Please fill out the Message area.<br>'; messageField.addClass('alert'); }
				
				//// IF THERE'S AN ERROR
				if(errorMessage != '') {
					
					//// fills in the rror field and shows it
					errorField.children('span').html(errorMessage);
					errorField.fadeIn(200);
					
				} else {
					
					//// LET'S SUBMIT THIS FELLOW
					//// ADDS THE LOADING EVENT & Disabels Button
					mainCont.addClass('loading');
					formCont.animate({ opacity: .3 }, 200);
					formCont.find('input[type="submit"]').attr('disabled', 'disabled');
					
					//// SEND REQUEST
					jQuery.ajax({
						
						url:		formUrl,
						type:		'POST',
						dataType: 	'json',
						data: 		{
							
							name: nameField.val(),
							email: emailField.val(),
							message: messageField.val(),
							emailTo: emailToField.val()
							
						},
						success:	function(data){
							
							////THERE'S NO ERRORS
							if(data.error == false) {
								
								/// Let's hide the form and show our Thankyou message
								formCont.stop().animate({ opacity: 0 }, 300, function() {
									
									jQuery(this).hide();
									mainCont.removeClass('loading');
									thankCont.fadeIn(300);
									
								});
								
							} else {
								
								//fades the form back in, removes load and shows the error
								formCont.stop().animate({ opacity: 1 }, 300, function() {
									
									mainCont.removeClass('loading');
									formCont.find('input[type="submit"]').removeAttr('disabled');
									errorField.children('span').html(data.error_msg);
									errorField.fadeIn(200);									
									
								});
								
							}
							
						},
						error: 		function(XMLHttpRequest, textStatus, errorThrown){
							
							alert('There was an error with the server. Error: '+errorThrown);
							
						}
						
					});
					
				}
				
				return false;
				
			});
			
		},
		
		ddImageHover: function(opacityHover) {
			
			//main container
			var maincont = this;
			var thisBg = this.attr('class');
			var extraClass = '';
			if(maincont.attr('class').indexOf('align-left') != -1) { extraClass = ' align-left' }
			if(maincont.attr('class').indexOf('align-right') != -1) { extraClass = ' align-right' }
			maincont.attr('class', 'image-hover'+extraClass);
			
			maincont.hover(function() {
				
				maincont.attr('class', thisBg);
				jQuery(this).find('img').stop().animate({ opacity: opacityHover }, 250);
				
			}, function() {
				
				jQuery(this).find('img').stop().animate({ opacity: 1 }, 250, function() {
					
					maincont.attr('class', 'image-hover'+extraClass);
					
				});
				
			});
			
		}
	
	});
	
})(jQuery);

jQuery(document).ready(function() {
	
	jQuery('.dribbble-shots li a').hover(function() {
		
		jQuery(this).children('span').fadeIn(150);
		
	}, function() {
		
		jQuery(this).children('span').fadeOut(150);
		
	});
	
});