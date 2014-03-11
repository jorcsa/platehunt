(function($){ 

    $.fn.extend({
		
		_sf_logout: function(e) {
			
			/// ADDS SPINNING SIGN
			this.css({ opacity: .8 }).spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9, left: -33 });
			
			/// LOGS OUT USER
			jQuery.ajax({
				
				url: 	sf_us.ajaxurl,
				type: 	'post',
				dataType: 'json',
				data: {
					
					action: 	'_sf_logout',
					nonce: 		sf_us._sf_logout_nonce
					
				},
				success: function(data) {
					
					//// redirects user
					window.location.reload();
					
				}
				
			});
			
			e.preventDefault();
			return false;
			
		},
		
		_sf_login: function() {
			
			//// WHEN USER SUBMITS
			var formCont = this;
			formCont.submit(function(e) {
				
				//// GETS USERNAME AND PASSWORD CONTAINERS
				var username = formCont.find('input[name="username"]');
				var password = formCont.find('input[name="password"]');
				var button = formCont.find('input[type="submit"]');
				
				//// ADDS SPINNING SIGN
				formCont.children('*').stop().animate({ opacity: .3 });
				button.attr('disabled', 'disabled');
				formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				formCont.find('small.error, p.error small').remove();
				formCont.find('p.error').removeClass('error');
				
				//// DOES THE AJAX QUERY
				jQuery.ajax({
					
					url: 				sf_us.ajaxurl,
					type: 				'post',
					dataType: 			'json',
					data: {
						
						action: 		'_sf_login',
						nonce: 			sf_us._sf_login_nonce,
						username: 		username.val(),
						password: 		password.val()
						
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
							
							window.location.reload();
							
						}
						
					}
					
				})
				
				/// PREVENTS NON AJAX
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_register: function() {
			
			//// WHEN USER SUBMITS
			var formCont = this;
			formCont.submit(function(e) {
				
				//// GETS USERNAME AND EMAIL CONTAINERS
				var username = formCont.find('input[name="username"]');
				var email = formCont.find('input[name="email"]');
				var button = formCont.find('input[type="submit"]');
				
				//// ADDS SPINNING SIGN
				formCont.children('*').stop().animate({ opacity: .3 });
				button.attr('disabled', 'disabled');
				formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				formCont.find('small.error, p.error small').remove();
				formCont.find('p.error').removeClass('error');
				
				//// DOES THE AJAX QUERY
				jQuery.ajax({
					
					url: 				sf_us.ajaxurl,
					type: 				'post',
					dataType: 			'json',
					data: {
						
						action: 		'_sf_register',
						nonce: 			sf_us._sf_register_nonce,
						username: 		username.val(),
						email: 		email.val()
						
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
					
				})
				
				/// PREVENTS NON AJAX
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_lost_password: function() {
			
			//// WHEN USER SUBMITS
			var formCont = this;
			formCont.submit(function(e) {
				
				//// GETS USERNAME OR EMAIL CONTAINER
				var dataCont = formCont.find('input[name="email_user"]');
				var button = formCont.find('input[type="submit"]');
				
				//// ADDS SPINNING SIGN
				formCont.children('*').stop().animate({ opacity: .3 });
				button.attr('disabled', 'disabled');
				formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				formCont.find('small.error, p.error small').remove();
				formCont.find('p.error').removeClass('error');
				
				//// DOES THE AJAX QUERY
				jQuery.ajax({
					
					url: 				sf_us.ajaxurl,
					type: 				'post',
					dataType: 			'json',
					data: {
						
						action: 		'_sf_lost_password',
						nonce: 			sf_us._sf_lost_password_nonce,
						input: 			dataCont.val(),
						page_url: 		window.location.href
						
					},
					success: function(data) {
								
						formCont.children('*').stop().animate({ opacity: 1 });
						button.removeAttr('disabled');
						formCont.spin(false);
						
						//// IF ANY ERRORS
						if(data.error) {
							
							//// SHOWS ERROR
							formCont.prepend('<p><small class="error" style="display: block;">'+data.message+'</small></p>');
							formCont.find('small').fadeIn(300);
							
						} else {
							
							//// SHOWS SUCCESS MESSAGE
							formCont.prepend('<p><small class="success" style="display: block;">'+data.message+'</small></p>');
							formCont.children('small').fadeIn(300, function() { jQuery(this).delay(3000).fadeOut(300, function() { jQuery(this).remove(); }); });
							dataCont.val('');
							
						}
						
					}
					
				})
				
				/// PREVENTS NON AJAX
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_reset_password: function() {
			
			//// WHEN USER SUBMITS
			var formCont = this;
			formCont.submit(function(e) {
				
				//// GETS USERNAME OR EMAIL CONTAINER
				var passwordCont = formCont.find('input[name="password"]');
				var passwordConfirmCont = formCont.find('input[name="password_confirm"]');
				var username = formCont.find('input[name="username"]');
				var button = formCont.find('input[type="submit"]');
				
				//// ADDS SPINNING SIGN
				formCont.children('*').stop().animate({ opacity: .3 });
				button.attr('disabled', 'disabled');
				formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				formCont.find('small.error, p.error small').remove();
				formCont.find('p.error').removeClass('error');
				
				//// DOES THE AJAX QUERY
				jQuery.ajax({
					
					url: 				sf_us.ajaxurl,
					type: 				'post',
					dataType: 			'json',
					data: {
						
						action: 		'_sf_reset_password',
						nonce: 			sf_us._sf_reset_password_nonce,
						password:		passwordCont.val(),
						password_c:		passwordConfirmCont.val(),
						user:			username.val(),
						
					},
					success: function(data) {
								
						formCont.children('*').stop().animate({ opacity: 1 });
						button.removeAttr('disabled');
						formCont.spin(false);
						
						//// IF ANY ERRORS
						if(data.error) {
							
							//// SHOWS ERROR
							formCont.prepend('<p><small class="error" style="display: block;">'+data.message+'</small></p>');
							formCont.find('small').fadeIn(300);
							
						} else {
							
							//// SHOWS SUCCESS MESSAGE
							formCont.prepend('<p><small class="success" style="display: block;">'+data.message+'</small></p>');
							formCont.find('small').fadeIn(300, function() { jQuery(this).delay(3000).fadeOut(300, function() { window.location.reload(); jQuery(this).remove();  }); });
							
						}
						
					}
					
				})
				
				/// PREVENTS NON AJAX
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_sortable_gallery: function() {
			
			//// vars
			var mainCont = this;
			var inputCont = mainCont.siblings('input');
			
			//// MAKES IT SORTABLE
			mainCont.sortable({
				
				items: '> li',
				revert: 100,
				stop: function(event, ui) {
					
					mainCont._sf_refresh_gallery();
					
				}
				
			});
			
		},
		
		_sf_refresh_gallery: function() {
			
			//// vars
			var mainCont = this;
			var inputCont = mainCont.siblings('input');
			
			//// GOESLI BY LI AND ADDS TO THE INPUT CONTAINER
			var theArr = {};
			mainCont.children('li').each(function(i, obj) {
				
				/// ADDS IT TO THE ARRAY
				theArr[i] = jQuery(this).find('.id').text();
				
			});
			
			//// PUTS IN THE INPUT FIELD
			var theValue = JSON.stringify(theArr);
			inputCont.val(theValue);
			
		},
		
		_sf_sortable_gallery_remove: function() {
			
			var thisLi = this.parent();
			var mainCont = thisLi.parent();
			
			thisLi.fadeOut(200, function() {
				
				jQuery(this).remove();
				mainCont._sf_refresh_gallery();
				
			});
			
		},
		
		_sf_upload_gallery: function(post_id) {
			
			var buttonUpload = this;
			var button = jQuery('#_sf_gallery_upload_button');
			var ulCont = jQuery('#_sf_gallery_images');
			var image_id = jQuery(this).attr('id');
			isUploadingImage = false;
			
			//// OUR FORMDATA
			formAction = new Object();
			formAction.name = 'action';
			formAction.value = '_sf_gallery_upload';
			
			//// OUR FORMDATA
			formPostId = new Object();
			formPostId.name = 'post_id';
			formPostId.value = post_id;
			
			//// OUR FORMDATA
			formNonce = new Object();
			formNonce.name = 'nonce';
			formNonce.value = sf_us._sf_gallery_upload_nonce;
			
			//// Form Data Array
			var postIdArr = new Array(formAction, formPostId, formNonce);
			
			var theImageUpload = buttonUpload.fileupload({
				
				url: 				sf_us.ajaxurl,
				dataType: 			'json',
				type: 				'post',
				sequentialUploads:	true,
				formData: 			postIdArr,
        		acceptFileTypes: /(\.|\/)(gif|jpe?g|png|GIF|JPE?G|PNG)$/i,
				done: function(e, data) {
					
					///// PREVENTS IT MOVING FORWARD
					isUploadingImage = false;
					
					//// IF ANY ERRORS
					if(data.result.error) {
						
						//// DISPLAYS OUR ERROR
						ulCont.parent().prepend('<small class="error" style="margin-top: 0; margin-bottom: 15px;">'+data.result.message+'</small>');
						ulCont.parent().find('small').delay(3000).fadeOut(300, function() { jQuery(this).remove(); });
						ulCont.spin(false).children('li').css({ opacity: 1 });
						
					} else {
						
						///// LETS LOAD OUR THUMBNAIL SINCE THIS CAN TAKE A WHILE
						///ulCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 }).children('li').css({ opacity: .3 });
						
						jQuery('<li/>').appendTo(ulCont);
						var thisLi = ulCont.children('li:last');
						thisLi.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
						thisLi.append('<span class="hidden id">'+data.result.image.id+'</span>');
						
						var theImage = new Image();
						jQuery(theImage).attr('src', data.result.image.thumb).load(function() {
							
							//// NOW THAT'S LOADED LETS APPEND OUR LI TO THE UL
							thisLi.append('<img src="'+data.result.image.thumb+'" alt="" title="" style="display: none;" /><span class="remove" onclick="jQuery(this)._sf_sortable_gallery_remove();"><i class="icon-trash"></i></span>');
							thisLi.find('img').fadeIn(300);
							thisLi.spin(false);
							
						});
						
						//// ATTACHES THE IMAGE TO OUR UL AND THEN REFRESHES THE INPUT
						//ulCont.spin(false).append('<li><img src="'+data.result.image.thumb+'" alt="" title="" /><span class="hidden id">'+data.result.image.id+'</span><span class="remove" onclick="jQuery(this)._sf_sortable_gallery_remove();"><i class="icon-trash"></i></span></li>');
						//ulCont.children('li').css({ opacity: 1 });
						ulCont._sf_sortable_gallery()
						ulCont._sf_refresh_gallery();
						
					}
					
				}
				
			}).on('fileuploadadd', function (e, data) {
				
				//// LETS ADDING A SPIN AND DISABLING THE BUTTON
				isUploadingImage = true;
				button.css({ opacity: .8 }).spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9, left: -33 });
				
				///// FIRST LETS MAKE SURE THE USER CAN UPLOAD THIS IMAGE
				var uploadingImages = data.originalFiles.length; 
				var totalImages = ulCont.children('li').length;
				var allowedImages = sf_us._sf_gallery_upload_count;
				if(jQuery('#_sf_gallery_extra').length > 0) { allowedImages = sf_us._sf_gallery_upload_count_extra; }
				allowedImages = allowedImages - totalImages;
				
				//// IF THE USER TRIES TO UPLOAD MORE THAN HE CAN
				if(uploadingImages > allowedImages) {
					
					//// SHOWS ERROR
					ulCont.parent().prepend('<small class="error" style="margin-top: 0; margin-bottom: 15px;">'+sf_us._sf_gallery_upload_count_message+'</small>');
					ulCont.parent().find('small').delay(3000).fadeOut(300, function() { jQuery(this).remove(); });
					
					//// ENABLES BUTTON AGAIN
					button.removeAttr('disabled').css({ opacity: 1 }).spin(false);
					
					///// PREVENTS IT MOVING FORWARD
					isUploadingImage = false;
					theImageUpload.abort();
					return false;
					
				} else {
					
					//// LETS UPLOAD THEM!
					button.parent().siblings('.upload-bar, .upload-bar-file').fadeIn(200);
					
					data.submit();
					
				}
				
			}).on('fileuploadprogressall', function (e, data) {
				
				//// UPDATES PROGRESS BAR
				var progress = parseInt(data.loaded / data.total * 100, 10);
				button.parent().siblings('.upload-bar').find('span').css( 'width', progress + '%');
				
				///// IF PROGRESS IS 100% PUT THINGS BACK TO NORMAL
				if(progress == 100) {
					
					//// HIDES UPLAOD BAR
					button.parent().siblings('.upload-bar, .upload-bar-file').fadeOut(200);
					button.parent().siblings('.upload-bar').find('span').css( 'width', '6px');
					
					//// REMOVES LOADING
					button.spin(false).css({ opacity: 1 });
					
				}
				
			}).on('fileuploadsend', function (e, data) {
				
				var file = data.files;
				
				button.parent().siblings('.upload-bar-file').text(file[0].name);
				
			});
			
		},
		
		_sf_upload_file_submission: function(post_id, field_id, number_of_files) {
			
			var buttonUpload = this;
			var button = jQuery('#_sf_upload_file_submission_'+field_id);
			var ulCont = jQuery('#_sf_submission_field_'+field_id+'_list');
			var image_id = jQuery(this).attr('id');
			isUploadingFile = false;
			
			//// OUR FORMDATA
			formAction = new Object();
			formAction.name = 'action';
			formAction.value = '_sf_field_submission_upload';
			
			//// OUR FORMDATA
			formPostId = new Object();
			formPostId.name = 'post_id';
			formPostId.value = post_id;
			
			//// FIELD ID
			formFieldId = new Object();
			formFieldId.name = 'field_id';
			formFieldId.value = field_id;
			
			//// OUR FORMDATA
			formNonce = new Object();
			formNonce.name = 'nonce';
			formNonce.value = sf_us._sf_field_submission_upload_nonce;
			
			//// Form Data Array
			var postIdArr = new Array(formAction, formPostId, formNonce, formFieldId);
			
			var theImageUpload = buttonUpload.fileupload({
				
				url: 				sf_us.ajaxurl,
				dataType: 			'json',
				type: 				'post',
				sequentialUploads:	true,
				formData: 			postIdArr,
        		acceptFileTypes: /(\.|\/)(pdf|txt|doc|csv|pps|xla|xls|xlt|xlw|docx|xlsx|pptx|PDF|TXT|DOC|CSV|PPS|XLA|XLS|XLT|XLW|DOCX|XLSX|PPTX)$/i,
				done: function(e, data) {
					
					///// PREVENTS IT MOVING FORWARD
					isUploadingImage = false;
					
					//// IF ANY ERRORS
					if(data.result.error) {
						
						//// DISPLAYS OUR ERROR
						ulCont.parent().prepend('<small class="error" style="margin-top: 0; margin-bottom: 15px;">'+data.result.message+'</small>');
						ulCont.parent().find('small').delay(3000).fadeOut(300, function() { jQuery(this).remove(); });
						ulCont.spin(false).children('li').css({ opacity: 1 });
						
					} else {
						
						console.log(data);
						
						///// LETS LOAD OUR THUMBNAIL SINCE THIS CAN TAKE A WHILE
						ulCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 }).children('li').css({ opacity: .3 });
						
						///// NOW THAT WE HAVE OUR DATA LETS CLONE THE LI AND ADD TO OUR ARRAY
						ulCont.find('li._sf_box_clone').clone().appendTo(ulCont);
						var cloneLi = ulCont.find('li._sf_box_clone:last-child');
						cloneLi.find('.head .left').text(data.result.file.name);
						cloneLi.find('.filetype').text(data.result.file.type);
						cloneLi.find('input._sf_submission_file').val(data.result.file.name);
						cloneLi.find('.filesize').text(parseInt(data.result.file.size / 1024) + ' kb');
						
						//// REMOVES THE CLONE LI
						ulCont.spin(false).children('li').css({ opacity: 1 });
						cloneLi.css({ display: 'none' }).removeClass('_sf_box_clone').slideDown(200);
						
						cloneLi.find('input[name="_sf_submission_attachment_id"]').val(data.result.file.id);
						
						//// REFRESHES THE INPUT
						ulCont._sf_refresh_submission_file();
						
						
						
					}
					
				}
				
			}).on('fileuploadadd', function (e, data) {
				
				//// LETS ADDING A SPIN AND DISABLING THE BUTTON
				isUploadingImage = true;
				button.css({ opacity: .8 }).spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9, left: -33 });
				
				///// FIRST LETS MAKE SURE THE USER CAN UPLOAD THIS FILE
				var uploadingImages = data.originalFiles.length; 
				var totalImages = ulCont.children('li:not(._sf_box_clone)').length;
				var allowedImages = number_of_files;
				allowedImages = allowedImages - totalImages;
				
				//// IF THE USER TRIES TO UPLOAD MORE THAN HE CAN
				if(uploadingImages > allowedImages) {
					
					//// SHOWS ERROR
					ulCont.parent().prepend('<small class="error" style="margin-top: 0; margin-bottom: 15px;">'+sf_us._sf_field_submission_upload_count_message+'</small>');
					ulCont.parent().find('small').delay(3000).fadeOut(300, function() { jQuery(this).remove(); });
					
					//// ENABLES BUTTON AGAIN
					button.removeAttr('disabled').css({ opacity: 1 }).spin(false);
					
					///// PREVENTS IT MOVING FORWARD
					isUploadingImage = false;
					theImageUpload.abort();
					return false;
					
				} else {
					
					//// LETS UPLOAD THEM!
					button.parent().siblings('.upload-bar, .upload-bar-file').fadeIn(200);
					
					data.submit();
					
				}
				
			}).on('fileuploadprogressall', function (e, data) {
				
				//// UPDATES PROGRESS BAR
				var progress = parseInt(data.loaded / data.total * 100, 10);
				button.parent().siblings('.upload-bar').find('span').css( 'width', progress + '%');
				
				///// IF PROGRESS IS 100% PUT THINGS BACK TO NORMAL
				if(progress == 100) {
					
					//// HIDES UPLAOD BAR
					button.parent().siblings('.upload-bar, .upload-bar-file').fadeOut(200);
					button.parent().siblings('.upload-bar').find('span').css( 'width', '6px');
					
					//// REMOVES LOADING
					button.spin(false).css({ opacity: 1 });
					
				}
				
			}).on('fileuploadsend', function (e, data) {
				
				var file = data.files;
				
				button.parent().siblings('.upload-bar-file').text(file[0].name);
				
			});
			
		},
		
		_sf_refresh_submission_file: function() {
			
			//// vars
			var mainCont = this;
			var inputCont = mainCont.siblings('input');
			
			//// GOESLI BY LI AND ADDS TO THE INPUT CONTAINER
			var theArr = {};
			mainCont.children('li:not(._sf_box_clone)').each(function(i, obj) {
				
				var thisField = {};
				
				//// ADDS IT TO OUR ARRAY
				thisField['ID'] = jQuery(this).find('input[name="_sf_submission_attachment_id"]').val();
				thisField['title'] = jQuery(this).find('._sf_submission_file').val();
				thisField['desc'] = jQuery(this).find('._sf_submission_description').val();
				thisField['size'] = jQuery(this).find('.filesize').text();
				
				/// ADDS IT TO THE ARRAY
				theArr[i] = thisField;
				
			});
			
			//// PUTS IN THE INPUT FIELD
			var theValue = JSON.stringify(theArr);
			inputCont.val(theValue);
			
		},
		
		_sf_submission_file_update: function() {
			
			//// vars
			var mainCont = this.parent().parent().parent().parent();
			var labelCont = mainCont.find('._sf_submission_file');
			var headCont = mainCont.find('.head .left');
			var ulCont = mainCont.parent();
			
			//// IF LABEL IS EMPTY
			if(labelCont.val() == '') { labelCont.val('-').siblings('small').fadeIn(200, function() { jQuery(this).delay(3000).fadeOut(200); }); }
			
			//// CHANGES HEAD
			headCont.text(labelCont.val());
			
			//// REFRESHES FIELD
			ulCont._sf_refresh_submission_file();
			
		},
		
		_sf_submission_file_remove: function(e) {
			
			//// REMOVES THE LI
			var mainCont = this.parent().parent();
			var ulCont = mainCont.find('ul._sf_submission_field_file_list');
			
			
			mainCont.slideUp(200, function() {
				
				jQuery(this).remove();
				ulCont._sf_refresh_submission_file();
				
			});
			
		},
		
		_sf_upload_profile_pic: function() {
			
			var buttonUpload = jQuery('#_sf_user_profile_pic_upload');
			var button = jQuery('#_sf_user_profile_pic_upload_button');
			var image_id = '_sf_user_profile_pic_upload';
			var mainCont = this;
			var imageCont = jQuery('#_sf_user_profile_image');
			var inputCont = jQuery('#_sf_user_profile_pic');
			isUploadingImage = false;
			
			//// OUR FORMDATA
			formAction = new Object();
			formAction.name = 'action';
			formAction.value = '_sf_gallery_upload';
			
			//// OUR FORMDATA
			formPostId = new Object();
			formPostId.name = 'post_id';
			formPostId.value = '';
			
			//// OUR FORMDATA
			formPostThumb = new Object();
			formPostThumb.name = 'thumb_size';
			formPostThumb.value = '92_108';
			
			//// OUR FORMDATA
			formNonce = new Object();
			formNonce.name = 'nonce';
			formNonce.value = sf_us._sf_gallery_upload_nonce;
			
			//// Form Data Array
			var postIdArr = new Array(formAction, formPostId, formNonce, formPostThumb);
			
			var theImageUpload = buttonUpload.fileupload({
				
				url: 				sf_us.ajaxurl,
				dataType: 			'json',
				type: 				'post',
				sequentialUploads:	true,
				formData: 			postIdArr,
        		acceptFileTypes: /(\.|\/)(gif|jpe?g|png|GIF|JPE?G|PNG)$/i,
				done: function(e, data) {
					
					///// PREVENTS IT MOVING FORWARD
					isUploadingImage = false;
					
					//// IF ANY ERRORS
					if(data.result.error) {
						
						//// DISPLAYS OUR ERROR
						mainCont.prepend('<small class="error" style="margin-top: 0; margin-bottom: 15px;">'+data.result.message+'</small>');
						mainCont.find('small').delay(3000).fadeOut(300, function() { jQuery(this).remove(); });
						imageCont.spin(false).children('img').css({ opacity: 1 });
						
					} else {
						
						///// LETS LOAD OUR THUMBNAIL SINCE THIS CAN TAKE A WHILE
						///ulCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 }).children('li').css({ opacity: .3 });
						
						imageCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
						
						var theImage = new Image();
						jQuery(theImage).attr('src', data.result.image.thumb).load(function() {
							
							//// NOW THAT'S LOADED LETS APPEND OUR LI TO THE UL
							imageCont.html('');
							imageCont.append('<img src="'+data.result.image.thumb+'" alt="" title="" style="display: none;" />');
							imageCont.find('img').fadeIn(300);
							imageCont.spin(false);
							
						});
						
						//// UPDATES OUR INPUT
						inputCont.val(data.result.image.id);
						
					}
					
				}
				
			}).on('fileuploadadd', function (e, data) {
				
				//// LETS ADDING A SPIN AND DISABLING THE BUTTON
				isUploadingImage = true;
				button.css({ opacity: .8 }).spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9});
					
				//// LETS UPLOAD THEM!
				mainCont.find('.upload-bar, .upload-bar-file').fadeIn(200);
				
				data.submit();
				
			}).on('fileuploadprogressall', function (e, data) {
				
				//// UPDATES PROGRESS BAR
				var progress = parseInt(data.loaded / data.total * 100, 10);
				mainCont.find('.upload-bar').find('span').css( 'width', progress + '%');
				
				///// IF PROGRESS IS 100% PUT THINGS BACK TO NORMAL
				if(progress == 100) {
					
					//// HIDES UPLAOD BAR
					mainCont.find('.upload-bar, .upload-bar-file').fadeOut(200);
					mainCont.find('.upload-bar').find('span').css( 'width', '6px');
					
					//// REMOVES LOADING
					button.spin(false).css({ opacity: 1 });
					
				}
				
			}).on('fileuploadsend', function (e, data) {
				
				var file = data.files;
				
				mainCont.find('.upload-bar-file').text(file[0].name);
				
			});
			
			//// WHEN THE USER CLICKS REMOVE
			jQuery('#_sf_user_profile_pic_remove').click(function() {
				
				inputCont.val('');
				
				//// REMOVES THE CURRENT IMAGE AND APPENDS OUR PLACEHOLDER
				imageCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				imageCont.find('img').fadeOut(300);
				
				var theNewImage = new Image();
				jQuery(theNewImage).attr('src', sf_us._sf_us_placeholder).load(function() {
					
					imageCont.find('img').remove();
					imageCont.append(this);
					
					imageCont.spin(false);
					
				});
				
			});
			
		},
		
		_sf_remove_tag: function() {
			
			var ulCont = this.parent().parent().parent();
			var liCont = this.parent().parent();
			
			liCont.fadeOut(100, function() {
				
				jQuery(this).remove();
				ulCont._sf_refresh_tags();
				
			});
			
		},
		
		_sf_refresh_tags: function() {
			
			var ulCont = this;
			var inputCont = jQuery('#_sf_tags_input');
			
			//// GOES THROUGH LI BY LI
			var theArr = {};
			
			ulCont.children('li').each(function(i, obj) {
				
				var theVal = jQuery(this).text();
				
				//// IF IT'S NOT ALREADY IN THE ARRAY
				var isInArray = false;
				jQuery.each(theArr, function(_i, _obj) {
					
					if(_obj == theVal) { isInArray = true; }
					
				});
				
				
				//// IF NOT IN THER EADD TO THE ARRAY
				if(isInArray === false) { theArr[i] = theVal; }
				
			});
			
			//// PUTS IN THE INPUT FIELD
			var theValue = JSON.stringify(theArr);
			inputCont.val(theValue);
			
		},
		
		_sf_adding_tags_input: function() {
			
			var theInput = this;
			var ulCont = jQuery('#_sf_tags_list');
			
			/// WHEN WE ARE FOCUSED ON THE INPUT AND PRESS ENTER
			theInput.keydown(function(e) {
				
				//// IF WE HAVE PRESSED ENTER
				if(e.which == 13) {
					
					//// ADDS TAG TO OUR UL
					theVal = theInput.val();
					ulCont._sf_add_tag(theVal);
					
					//// REMOVES THE VAL
					theInput.val('');
					
					/// AVOIDS SUBMISSION OF THIS FORM
					e.preventDefault();
					return false;
					
				}
				
			});
			
		},
		
		_sf_add_tag: function(the_val) {
			
			var ulCont = this;
			var theInput = jQuery('#_sf_tags_input');
			var totalTags = 0
			
			//// IF VALUE IS EMPTY
			if(the_val == '') {
				
				//// THROWS ERROR
				ulCont.parent().prepend('<small class="error" style="margin-top: 0; margin-bottom: 15px;">'+sf_us._sf_tags_empty_message+'</small>');
				ulCont.parent().find('small').delay(2000).fadeOut(300, function() { jQuery(this).remove(); });
				
				return false;
				
			}
			
			//// IF OUR STRING IS JSON
			if(IsJsonString(theInput.val()) === true) {
				
				var allTags = jQuery.parseJSON(theInput.val());
				jQuery.each(allTags, function(i, obj) {
					
					totalTags++;
					
				});
				
			}
			
			//// IF THE USER CAN ADD TAGS
			if(totalTags < sf_us._sf_tags_count || (jQuery('#_sf_tags_extra').length > 0 && totalTags < sf_us._sf_tags_count_extra)) {
				
				//// CHECKS TO SEE IF THE TAG IS ALREADY THERE
				var isTagInArray = false;
				
				if(IsJsonString(theInput.val()) === true) {
					
					jQuery.each(allTags, function(i, obj) {
						
						//// IF THE TAG IS IN HERE
						if(obj == the_val) { isTagInArray = true; }
						
					});
				
				}
				
				//// IF TAG IS IN ARRAY
				if(isTagInArray === true) {
					
					var the_message = sf_us._sf_tags_exist_message;
				
					//// THROWS ERROR
					ulCont.parent().prepend('<small class="error" style="margin-top: 0; margin-bottom: 15px;">'+the_message+'</small>');
					ulCont.parent().find('small').delay(2000).fadeOut(300, function() { jQuery(this).remove(); });
					
				} else {
					
					//// ADDS IT TO OUR UL
					ulCont.append('<li><span><i class="icon-minus" onclick="jQuery(this)._sf_remove_tag();"></i></span>'+the_val+'</li>');
					ulCont._sf_refresh_tags();
					
				}
				
			} else {
					
				var the_message = sf_us._sf_tags_count_message;
				if(jQuery('#_sf_tags_extra').length > 0) { the_message = sf_us._sf_tags_count_message_extra; }
				
				//// THROWS ERROR
				ulCont.parent().prepend('<small class="error" style="margin-top: 0; margin-bottom: 15px;">'+the_message+'</small>');
				ulCont.parent().find('small').delay(2000).fadeOut(300, function() { jQuery(this).remove(); });
				
			}
			
		},
		
		_sf_location_get_pinpoint: function() {
			
			//// vars
			var inputCont = jQuery('#_sf_address');
			var theMap = jQuery('#_sf_location_map');
			var theLat = jQuery('#_sf_latitude');
			var theLng = jQuery('#_sf_longitude');
			
			//// GETS THE LAT AND LNG BASED ON THE ADDRESS
			if(inputCont.val() != '') {
				
				var geocoder = new google.maps.Geocoder();
				var latLng = geocoder.geocode({
									
					address: inputCont.val()
					
				}, function(results, status) {
					
					if(status == google.maps.GeocoderStatus.OK) {
								
						//// GETS LAT AND LNG AND ADDS TO THE FIELDS		
						lat = results[0].geometry.location.lat();
						lng = results[0].geometry.location.lng();
										
						theLat.val(lat);
						theLng.val(lng);
						
						//// ADDS THE PIN TO OUR MAP
						jQuery(theMap).gmap3({
							
							get: {
								
								name: 'marker',
								all: true,
								callback: function(objs) {
									
									jQuery.each(objs, function(i, obj) {
										
										obj.setMap(null);
										
									})
									
								}
								
							},
							
							map: {
								
								options: {
								
									zoom: 14,
									center: new google.maps.LatLng(lat, lng)
								
								}
								
							},
							marker: {
								
								values: [{ latLng:[lat, lng] }],
								options: {
									
									draggable: true
									
								},
								events: {
									
									mouseup: function(marker, event, context) {
										
										//// GETS MARKER LATITUDE AND LONGITUDE
										var thePos = marker.getPosition();
										var lat = thePos.lat();
										var lng = thePos.lng();
										
										theLat.val(lat);
										theLng.val(lng);
										
									}
									
								}
								
							}
							
						});
						
					} else {
						
						//// COULD NOT FIND THE ADDRESS
						alert('Could not pinpoint "'+inputCont.val()+'"');
						
					}
					
				});
				
			}
			
		},
		
		_sf_save_spot: function(post_id, show_message, callback) {
			
			//// LET'S SUBMIT OUR FORM VIA AJAX
			var formCont = jQuery('#_sf_spot');
			var button = this;
			
			//// ADDS LOADING SIGN
			button.css({ opacity: .8 }).spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9, left: -33 });
			
			/// MAKES SURE WE GET THE CONTENT FROM THE VISUAL EDITOR
			tinyMCE.triggerSave();tinyMCE.triggerSave();
			
			jQuery.ajax({
				
				url:				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_save',
					nonce: 			sf_us._sf_save_nonce,
					data: 			formCont.serialize(),
					post_id: 		post_id
					
				},
				success: function(data) {
					
					//// CALLBACK
					if(typeof callback == 'function') {
						
						callback.call(this);
						
					}
					
					if(typeof show_message == 'undefined') {
					
						//// IF ANY ERRORS
						if(data.error === true) {
						
							//// REMOVES LOADING SIGN
							button.css({ opacity: 1 }).spin(false);
							
							//// SHOWS SUCCESS MESSAGE
							jQuery('#message').removeClass('success').addClass('error').find('span').text(sf_us.error_message);
							jQuery('#message i').attr('class', 'icon-cancel-circle');
							jQuery('#message').slideDown(300, function() { jQuery(this).delay(2000).slideUp(300); });
							
							//// GOES THROUGH OUR ARRAY OF FIELDS
							jQuery.each(data.error_fields, function(i, obj) {
								
								//// CHECK IF IT'S AN INSIDE FIELD
								if(obj.inside) {
									
									//// SHOWS ALERT
									jQuery('#'+obj.field_id).find('.tooltip').text(obj.message).fadeIn(200, function() { jQuery(this).delay(7000).fadeOut(200); });
									
									//// OPENS THE INSIDE
									jQuery('#'+obj.field_id).parent().slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }); });
									
								}
								
							})
							
						} else {
						
							//// REMOVES LOADING SIGN
							button.css({ opacity: 1 }).spin(false);
							
							//// SHOWS SUCCESS MESSAGE
							jQuery('#message').removeClass('error').addClass('success').find('span').text(sf_us._sf_draft_saved_message);
							jQuery('#message i').attr('class', 'icon-ok-circle');
							jQuery('#message').slideDown(300, function() { jQuery(this).delay(2000).slideUp(300); });
						
						}
					
					} else {
						
						
						
					}
					
				}
				
			});
			
		},
		
		_sf_load_initial_dependents: function(parent, parent_id, dependent_id, callback) {
			
			//// GETS INITIAL SELECT FIELD
			var selP = this;
			var selCont = this.find('select');
			var messageCont = selP.siblings('p.message');
			
			//console.log(parent.find('option:selected').val());
			
			///// GETS ALL SELECTED PARENTS
			var parentArr = new Array();
			parent.find('option:selected').each(function() {
				
				parentArr.push(jQuery(this).val());
				
			});
			
			//// LOADS THE FIELDS
			jQuery.ajax({
				
				url: 				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_load_dependent_fields',
					nonce: 			sf_us._sf_load_dependent_fields_nonce,
					parent: 		parentArr,
					parent_id: 		parent_id,
					dependent_id: 	dependent_id
					
				},
				success: function(data) {
					
					//// IF FIELDS ISNT EMPTY
					console.log(data);
					
					//// IF THERE ARE SECTIONS
					if(typeof data.sections == 'object' && typeof data.sections.length == 'undefined') {
						
						var markup = '';
						
						//// LOOPS THROUGH EACH SECTION
						jQuery.each(data.sections, function(i, _section) {
							
							/// STARTS OUR OPTGROUP
							markup += '<optgroup label="'+_section.label+'">';
							
							//// LOOPS OUR FIELDS WITHIN HERE – IF ANY
							if(_section.fields.length > 0) {
								
								/// LOOPS FIELDS
								jQuery.each(_section.fields, function(i, _field) {
									
									//// ADDS OUR MARKUP
									markup += '<option value="'+_field.id+'';
									
									//// IF WE HAVE SELECTED FIELDS CHECK FOR IT
									if(selCont.parent().parent().find('input[name="selected_dependents"]').length > 0) {
										
										//alert(decodeURIComponent(selCont.parent().parent().find('input[name="selected_dependents"]').val()));
										
										var selArr = jQuery.parseJSON(decodeURIComponent(selCont.parent().parent().find('input[name="selected_dependents"]').val()));
										
										if(jQuery.inArray(_field.id, selArr) != -1) { markup += '" selected="selected'; }
										
									}
									
									markup += '">'+_field.label+'</option>';
									
								})
								
							} else {
								
								//// ADDS A NULL
								markup += '<option value="null">-</option>';
								
							}
							
							//// CLOSES OPTGROUP
							markup += '</optgroup>';
							
						});
						
					} else {
						
						//// ADDS A NULL
						markup = '';
						
					}
					
					if(markup != '') {
					
						//// SHOWS OUR SELECT
						messageCont.hide();
						selCont.html(markup);
						selP.show();
						
						//// AMKES SURE WE SHOW THATIN OUR REPLACE
						var selected = selCont.find('option:selected');
						selP.find('.select-replace span').text(selected.text());
					
					} else {
					
						//// SHOWS OUR SELECT
						messageCont.show();
						selCont.html('');
						selP.hide();
						
					}
					
							if(typeof callback == 'function') { callback.call(this); }
					
				}
				
			});
			
		},
		
		_sf_switch: function() {
			
			var mainCont = this;
			var inputCont = this.find('input');
			var onCont = this.find('._sf_switch_on');
			var handle = this.find('._sf_switch_handle');
			
			//// PUTS OPACITY 0 FOR BETTER TRANSITIONS
			onCont.css({ display: 'block', opacity: 0 });
			
			//// IF THE INPUT IS ALREADY CHECKED
			if(inputCont.val() == 'on') { mainCont.addClass('_sf_switch_checked'); onCont.css({ opacity: 1 }); }
			
			//// WHEN THE USER CLICKS THE BUTTON
			mainCont.click(function() {
				
				//// IF IT'S ON - PUT IT OFF
				if(inputCont.val() == 'on') {
					
					//// ANIMATES THE HANDLE AND ON
					handle.stop().animate({ right: '51px' }, { duration: 200, easing: 'easeInOutQuint' });
					onCont.stop().animate({ opacity: 0 }, { duration: 200, easing: 'easeInOutQuint' });
					
					//// CHECKS CONTAINER
					inputCont.val('off');
					
				} else {
					
					//// ANIMATES THE HANDLE AND ON
					handle.stop().animate({ right: '2px' }, { duration: 200, easing: 'easeInOutQuint' });
					onCont.stop().animate({ opacity: 1 }, { duration: 200, easing: 'easeInOutQuint' });
					
					//// CHECKS CONTAINER
					inputCont.val('on');
					
				}
				
			});
			
		},
		
		_sf_custom_field_open: function(e) {
			
			//// IF WE HAVE CLICKED ANYTHING BUT THE REMOVE BUTTON
			if(e.srcElement.className.indexOf('close') == -1 && e.srcElement.className.indexOf('cancel') == -1) {
			
				//// vars
				var mainCont = this.parent();
				var insideCont = mainCont.find('.inside');
				
				//// IF INSIDE IS OPEN
				if(insideCont.is(':visible')) {
					
					insideCont.slideUp(200);
					
				} else {
					
					insideCont.slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }) });
					
				}
			
			}
			
		},
		
		_sf_custom_field_remove: function(e) {
			
			//// vars
			var mainCont = this.parent().parent();
			
			//// REMOVES LI
			mainCont.slideUp(200, function() {
				
				jQuery(this).remove();
				
				//// REFRESHES INPUT
				jQuery('#_sf_custom_fields_list')._sf_custom_field_refresh();
				
			});
			
		},
		
		_sf_custom_field_update: function() {
			
			//// vars
			var mainCont = this.parent().parent().parent().parent();
			var labelCont = mainCont.find('._sf_custom_field_label');
			var valueCont = mainCont.find('._sf_custom_field_value');
			var headCont = mainCont.find('.head .left');
			var ulCont = jQuery('#_sf_custom_fields_list');
			
			//// IF LABEL IS EMPTY
			if(labelCont.val() == '') { labelCont.val('-').siblings('small').fadeIn(200, function() { jQuery(this).delay(3000).fadeOut(200); }); }
			
			//// IF VALUE IS EMPTY
			if(valueCont.val() == '') { valueCont.val('-').siblings('small').fadeIn(200, function() { jQuery(this).delay(3000).fadeOut(200); }); }
			
			//// CHANGES HEAD
			headCont.text(labelCont.val());
			
			//// REFRESHES FIELD
			ulCont._sf_custom_field_refresh();
			
		},
		
		_sf_wpml_update_custom_field_translations: function() {
			
			var ulCont = this;
			
			///// ONCE THE USER FOCUS OUT A FIELD
			ulCont.find('input').blur(function() {
				
				var error = false;
			
				//// LETS GO LI BY LI REFRESHING THE FIELD
				ulCont.children('li').each(function() {
					
					//// MAKES SURE THE FIELD IS FILLED OUT
					jQuery(this).find('input').each(function() {
						
						jQuery(this).parent().removeClass('error');
						
						if(jQuery(this).val().length == 0) {
							
							error = true;
							
							///// THROWS AN ERROR
							jQuery(this).parent().addClass('error');
							jQuery(this).siblings('small').fadeIn(200, function() {
								
								var spanError = jQuery(this);
								
								setTimeout(function() {
									
									spanError.fadeOut(200);
									
								}, 2000)
								
							});
							
						}
						
					});
					
				});
				
				//// IF NO ERRROS WE REFRESH THE VALUES
				if(error === false) {
					var inputCont = jQuery('#_sf_custom_fields_input');
					
					//// GOES THROUGH LI BY LI AND ADDS TO OUR INPUT
					var theArr = {};
					
					ulCont.children('li').each(function(i, obj) {
						
						var thisField = {};
						
						//// ADDS IT TO OUR ARRAY
						thisField['label'] = jQuery(this).find('.label').val();
						thisField['value'] = jQuery(this).find('.value').val();
						
						//// ADDS THIS FIELD TO THE MAIN ARRAY
						theArr[i] = thisField;
						
					});
					
					//// PUTS IN THE INPUT FIELD
					var theValue = JSON.stringify(theArr);
					inputCont.val(theValue);
					
				}
				
			});
			
		},
		
		_sf_add_custom_field: function() {
			
			//// VARS
			var mainCont = this.parent().parent();
			var titleCont = mainCont.find('#_sf_custom_field_label');
			var valueCont = mainCont.find('#_sf_custom_field_value');
			var labelTitle = titleCont.siblings('label').text();
			var labelValue = valueCont.siblings('label').text();
			var ulCont = jQuery('#_sf_custom_fields_list');
			
			//// MAKES SURE THE FIELDS AREN't EMPTY
			if(titleCont.val() == '') { titleCont.siblings('small').fadeIn(200, function() { jQuery(this).delay(3000).fadeOut(200); }); return false; }
			if(valueCont.val() == '') { valueCont.siblings('small').fadeIn(200, function() { jQuery(this).delay(3000).fadeOut(200); }); return false; }
			
			//// DOES OUR MARKUP
			var markup = '<li class="_sf_box" style="display: none;"><div class="head" onclick="jQuery(this)._sf_custom_field_open(event);"><div class="left"></div><div class="right close" onclick="jQuery(this)._sf_custom_field_remove(event);"><i class="icon-cancel"></i></div><div class="clear"></div></div><div class="inside"><div class="one-half"><p style="position: relative;"><label>'+labelTitle+'</label><input type="text" class="_sf_custom_field_label small-input" onblur="jQuery(this)._sf_custom_field_update();" /><small class="error tooltip right" style="top: 19px;">!</small></p></div><div class="one-half last"><p style="position: relative;"><label>'+labelValue+'</label> <input type="text" class="_sf_custom_field_value small-input" onblur="jQuery(this)._sf_custom_field_update();" /><small class="error tooltip left" style="top: 19px;">!</small></p></div><div class="clear"></div></div></li>';
			
			//// ADDS TO THE UL
			ulCont.append(markup);
			
			//// ADDS THE LABEL AND VALUE
			var liCont = ulCont.find('li:last');
			liCont.find('.head .left').text(titleCont.val());
			liCont.find('input._sf_custom_field_label').val(titleCont.val());
			liCont.find('input._sf_custom_field_value').val(valueCont.val());
			liCont.fadeIn(200);
			
			//// EMPTIES INPUT AND FOCUS ON TITLE
			titleCont.val('').focus();
			valueCont.val('');
			
			//// REFRESHES THE CONT
			ulCont._sf_custom_field_refresh();
			
			//// REFRESHES SORTING
			ulCont._sf_custom_field_refresh_sortable();
			
			
		},
		
		_sf_custom_field_add_all: function() {
			
			//// IF WE HAVE FOCUS ON EITHER ONE OF THE INPUT FIELDS
			jQuery('#_sf_custom_field_label, #_sf_custom_field_value').keydown(function(e) {
				
				//// IF WE PRESS ENTER
				if(e.which == 13) {
					
					//// ADDS THE FIELD
					jQuery('#_sf_custom_field_add')._sf_add_custom_field();
					
					e.preventDefault();
					return false;
					
				}
				
			});
			
		},
		
		_sf_custom_field_refresh_sortable: function() {
			
			var ulCont = this;
			
			ulCont.sortable({
				
				items:		'> li',
				handle: 	'.head',
				helper : 'clone',
				revert: 100,
				stop: function(event, ui) {
					
					ulCont._sf_custom_field_refresh();
					
				}
				
			});
			
		},
		
		_sf_custom_field_refresh: function() {
			
			var ulCont = this;
			var inputCont = jQuery('#_sf_custom_fields_input');
			console.log('a');
			
			//// GOES THROUGH LI BY LI AND ADDS TO OUR INPUT
			var theArr = {};
			
			ulCont.children('li').each(function(i, obj) {
				
				var thisField = {};
				
				//// ADDS IT TO OUR ARRAY
				thisField['label'] = jQuery(this).find('._sf_custom_field_label').val();
				thisField['value'] = jQuery(this).find('._sf_custom_field_value').val();
				
				//// ADDS THIS FIELD TO THE MAIN ARRAY
				theArr[i] = thisField;
				
			});
			
			//// PUTS IN THE INPUT FIELD
			var theValue = JSON.stringify(theArr);
			inputCont.val(theValue);
			
		},
		
		_sf_delete_submission: function(post_id) {
			
			var mainCont = this.parent().parent();
			
			//// FIRST CONFIRM USER WANTS TO DELETE SUBMISSION
			jQuery.ajax({
				
				url:				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_delete_submission',
					nonce: 			sf_us._sf_delete_submission_nonce,
					post_id: 		post_id
					
				},
				success: function(data) {
					
					//// IF NO ERRORS
					if(!data.error) {
						
						mainCont.slideUp(200, function() { jQuery(this).remove(); });
						
						// SHOW ERROR MESSAGE
						jQuery('#message').removeClass('error').addClass('success').find('span').text(data.message);
						jQuery('#message i').attr('class', 'icon-ok-circle');
						jQuery('#message').slideDown(200, function() { jQuery(this).delay(3000).slideUp(200); });
						
					} else {
						
						// SHOW ERROR MESSAGE
						jQuery('#message').removeClass('success').addClass('error').find('span').text(data.message);
						jQuery('#message i').attr('class', 'icon-cancel-circle');
						jQuery('#message').slideDown(200, function() { jQuery(this).delay(3000).slideUp(200); });
						
					}
					
				}
				
			})
			
		},
		
		_sf_spot_submit: function() {
			
			//// VARS
			var formCont = this;
			
			//// WHEN USER SUBMITS FORM
			formCont.submit(function(e) {
			
				/// MAKES SURE WE GET THE CONTENT FROM THE VISUAL EDITOR
				tinyMCE.triggerSave();tinyMCE.triggerSave();
				
				//// LET'S DISPLAY THE SPINNING SIGN
				formCont.spin({ lines: 11, length: 16, width: 5, radius: 14, corners: 1, speed: 1.9, color: '#000', top: '100' }).children('*:not(div.spinner)').css({ opacity: .3 });
				
				//// REMOVES ALL ERROS
				formCont.find('small.error').hide();
				formCont.find('*.error:not(small)').removeClass('error');
				
				//// VALIDATES FIELDS
				var error = false;
				var error_fields = new Array();
				
				//// TITLE
				var titleCont = formCont.find('#_sf_spot_title');
				if(titleCont.val() == '') { error = true; error_fields.push('#_sf_spot_title'); }
				
				//// IF THERE ARE CATEGORIES
				if(jQuery('#_sf_categories_box').length > 0) {
					
					//// IF THERE ARE NO CATEGORIES
					var catSel = false;
					formCont.find('input[name="_sf_category[]"]').each(function() { if(jQuery(this).is(':checked')) { catSel = true; } });
					if(catSel === false) { error = true; error_fields.push('#_sf_categories_box'); }
					
				}
				
				//// LOCATION - ADDRESS
				var addressCont = formCont.find('#_sf_address');
				if(addressCont.val() == '') { error = true; error_fields.push('#_sf_address'); }
				
				//// LOCATION - LATITUDE
				var latCont = formCont.find('#_sf_latitude');
				if(latCont.val() == '' || latCont.val() < -90 || latCont.val() > 90 || isNaN(latCont.val())) { error = true; error_fields.push('#_sf_latitude'); }
				
				//// LOCATION - LONGITUDE
				var lngCont = formCont.find('#_sf_longitude');
				if(lngCont.val() == '' || lngCont.val() < -180 || lngCont.val() > 180 || isNaN(lngCont.val())) { error = true; error_fields.push('#_sf_longitude'); }
				
				//// CHECKS FOR REQUIRED DROPDOWNS
				jQuery('.required-dropdown').each(function() {
					
					//// ONLY IF IT'S VISIBLE
					if(jQuery(this).closest('._sf_box').is(':visible')) {
					
						//// IF NOTHING IS SET
						if(jQuery(this).find('option:selected').length == 0) { error = true; var the_ID = jQuery(this).attr('id'); error_fields.push('#'+the_ID); jQuery(this).parent().parent().slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }) }); }
						
					}
					
				});
				
				//// CHECKS FOR REQUIRED DEPENDENTS
				jQuery('.required-dependent').each(function() {
					
					//// ONLY IF IT'S VISIBLE
					if(jQuery(this).closest('._sf_box').is(':visible')) {
					
						var selCont = jQuery(this).find('select');
						
						//// IF NOTHING IS SET
						if(selCont.find('option:selected').length == 0 && selCont.find('option').length > 0) { error = true; var the_ID = selCont.attr('id'); error_fields.push('#'+the_ID); selCont.parent().parent().slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }) }); }
					
					}
					
				});
				
				//// CHECKS FOR MIN-VALS NAD MAX-VALS
				
				//// CHECKS FOR REQUIRED DEPENDENTS
				jQuery('.required-num').each(function() {
					
					//// ONLY IF IT'S VISIBLE
					if(jQuery(this).closest('._sf_box').is(':visible')) {
					
						//// IF NOTHING IS SET
						if(jQuery(this).val() == '' || isNaN(jQuery(this).val())) { error = true; var the_ID = jQuery(this).attr('id'); error_fields.push('#'+the_ID); jQuery(this).parent().parent().slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }) }); }
						
					}
					
				});
				
				//// CHECKS FOR OTHER REQUIREDS
				jQuery('.required').each(function() {
					
					//// ONLY IF IT'S VISIBLE
					if(jQuery(this).closest('._sf_box').is(':visible')) {
					
						//// IF NOTHING IS SET
						if(jQuery(this).val() == '') { error = true; var the_ID = jQuery(this).attr('id'); error_fields.push('#'+the_ID); jQuery(this).closest('.error').slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }) }); }
						
					}
					
				});
				
				//// CHECKS FOR REQUIRED FILES
				jQuery('.required-file').each(function() {
					
					//// ONLY IF IT'S VISIBLE
					if(jQuery(this).closest('._sf_box').is(':visible')) {
					
						//// IF NOTHING IS SET
						if(jQuery(this).children('li:not(._sf_box_clone)').length == 0) { error = true; var the_ID = jQuery(this).attr('id'); error_fields.push('#'+the_ID); jQuery(this).siblings('.error').slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }) }); }
						
					}
					
				});
				
				//// IF THERE ARE ERRORS LET'S DISPLAY THEM
				if(error === true) {
					
					formCont.spin(false).children('*').css({ opacity: 1 });
					
					//// DISPLAY ERROR MESSAGE
					jQuery('#message').removeClass('success').addClass('error').find('span').text(sf_us.submit_error_message);
					jQuery('#message i').attr('class', 'icon-cancel-circle');
					jQuery('#message').slideDown(200, function() { jQuery(this).delay(3000).slideUp(200); });
					jQuery("html, body").animate({ scrollTop: 0 }, 500);
					
					//// GOES THROUGH OUR ERROR FIELDS
					jQuery.each(error_fields, function(i, _error) {
						
						//// DISPLAYS THE MESSAGE OF THIS FIELD
						jQuery(_error).siblings('small').fadeIn(200, function() { jQuery(this).delay(3000).fadeOut(200); });
						
						//// ADDS ERROR CLASS
						jQuery(_error).addClass('error');
						
					});
					
				} else {
					
					var post_id = jQuery('#_sf_spot_id').val();
					
					//// SUBMITS IT VIA AJAX
					jQuery.ajax({
						
						url: 				sf_us.ajaxurl,
						type: 				'post',
						dataType: 			'json',
						data: {
							
							action: 		'_sf_submit',
							nonce: 			sf_us._sf_submit_nonce,
							data: 			formCont.serialize(),
							post_id: 		post_id
							
						},
						success: function(data) {
							
							console.log(data);
							
							//// IF NO ERRORS
							if(!data.error) {
								
								////IF WE ARE ADDING
								if(window.location.href.indexOf('action=add-new') != -1) {
									
									theHref = window.location.href.replace('action=add-new', 'message=success');
									
								} else {
									
									theHref = window.location.href.split('?');
									theHref = theHref[0]+'?message=success';
									
								}
								
								//// REDIRECTS THE USER
								//theHref = window.location.href.replace('action=add-new', 'message=success');
								window.location.href = theHref;
								
							} else {
					
								formCont.spin(false).children('*').css({ opacity: 1 });
								
								//// DISPLAY ERROR MESSAGE
								jQuery('#message').removeClass('success').addClass('error').find('span').text(data.message);
								jQuery('#message i').attr('class', 'icon-cancel-circle');
								jQuery('#message').slideDown(200, function() { jQuery(this).delay(4000).slideUp(200); });
								jQuery("html, body").animate({ scrollTop: 0 }, 300);
								
							}
							
						}
						
					})
					
				}
				
				//// PREVENTS NON AJAX SUBMISSIONS
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_refresh_cart: function(post_id) {
			
			isCartRefreshing = true;
			
			//// VARS
			var mainCont = this;
			
			//// ADDS THE LOADING SIGN TO OUR CART
			mainCont.children('*').hide();
			mainCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
			
			if(typeof _sf_us_refresh_cart != 'undefined') { _sf_us_refresh_cart.abort(); }
			
			//// GETS THE CART ITEMS FOR THIS POST
			_sf_us_refresh_cart = jQuery.ajax({
				
				url: 				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_refresh_cart',
					nonce: 			sf_us._sf_refresh_cart_nonce,
					post_id: 		post_id
					
				},
				success: function(data) {
					
					console.log(data);
					
					//// IF THERE IS SOMETHING IN OUR CART
					if(data.cart_items.length > 0) {
						
						mainCont.children('*').show();
						mainCont.show().spin(false);
						
						//// GOES THROUGH ITEM BY ITEM AND SETS UP OUR MARKUP
						var markup = '';
						jQuery.each(data.cart_items, function(i, _item) {
							
							//// STARTS OUR MARKUP
							markup += '<li class="cart-item';
							
							//// IF IT'S NOT TRASHEABLE
							if(_item.trash === false) { markup += ' not-trash'; }
							markup += '">';
							
							///// ADDS THE TRASH ICON
							markup += '<span class="cart-trash" onclick="jQuery(this)._sf_remove_from_cart('+post_id+', \''+_item.cartid+'\');"><i class="icon-trash"></i></span>';
							
							//// TITLE AND DESC
							markup += '<h4>'+_item.title+'</h4><h5>'+_item.description+'</h5>';
							
							//// PRICE
							markup += '<span class="price">'+_item.price+'</span>';
							
							///// CLOSES THIS MARKUP
							markup += '</li>';
							
						});
						
						//// APPENDS THE CART ITEM TO OUR UL
						mainCont.find('ul.cart-items').html(markup);
						
						//// REFRESHES OUR CART TOTAL
						mainCont.find('.total span').html(data.cart_total);
						
						//// SHOWS THE AREA
						mainCont.find('.cart-totals').show();
						
						//// REPLACES CHECKBOX
						mainCont.find('input[type="checkbox"]').each(function() { jQuery(this).replaceCheckbox(); });
						
					} else {
						
						//// HIDE CART
						mainCont.fadeOut(200);
						
					}
					
					isCartRefreshing = false;
					
				}
				
			});
			
		},
		
		_sf_us_add_to_cart: function(action, post_id) {
			
			var cartCont = jQuery('#submit-cart');
			var itemCont = this;
			
			//// WHEN USER CLICKS WE FADE IT OUT AND ADD THE LOADING SIGN
			itemCont.hide();
			itemCont.parent().spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9, color: '#333' });
			
			cartCont.children('*').hide();
			cartCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
			
			//// NOW WE DO OUR AJAX QUERY AND UPDATE THE CART META
			jQuery.ajax({
				
				url: 				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_add_to_cart',
					nonce: 			sf_us._sf_add_to_cart_nonce,
					post_id: 		post_id,
					field_action: 	action
					
				},
				success: function(data) {
					
					///// SAVES THE SPOT AS A DRAFT
					
					//// NOW THAT WE HAVE ADDED WE FADE THE SPINNER OUT AND SCROLL TO TOP
					itemCont.parent().spin(false);
					
					//// SCROLL TO TOP
					jQuery('body, html').stop().animate({ 'scrollTop': 0 }, 300);
					
					//// REFRESHES CART
					cartCont.show()._sf_refresh_cart(post_id);
					
					//// DISPLAY THE EM
					itemCont.parent().find('em').css({ display: 'inline' });
					
				}
				
			});
			
		},
		
		_sf_us_add_to_cart_2: function(action, post_id) {
			
			var cartCont = jQuery('#submit-cart');
			var itemCont = this;
			
			//// WHEN USER CLICKS WE FADE IT OUT AND ADD THE LOADING SIGN
			itemCont.find('span').hide();
			itemCont.spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9, color: '#333' });
			
			cartCont.children('*').hide();
			cartCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
			
			//// NOW WE DO OUR AJAX QUERY AND UPDATE THE CART META
			jQuery.ajax({
				
				url: 				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_add_to_cart',
					nonce: 			sf_us._sf_add_to_cart_nonce,
					post_id: 		post_id,
					field_action: 	action
					
				},
				success: function(data) {
					
					///// SAVES THE SPOT AS A DRAFT
					
					//// NOW THAT WE HAVE ADDED WE FADE THE SPINNER OUT AND SCROLL TO TOP
					itemCont.spin(false);
					
					//// SCROLL TO TOP
					jQuery('body, html').stop().animate({ 'scrollTop': 0 }, 300);
					
					//// REFRESHES CART
					cartCont.show()._sf_refresh_cart(post_id);
					
					//// DISPLAY THE EM
					itemCont.find('em').fadeIn(200);
					
				}
				
			});
			
		},
		
		_sf_remove_from_cart: function(post_id, action) {
			
			var mainCont = this;
			var cartCont = jQuery('#submit-cart');
			
			//// HIDE THE CONTAINER AND SHOW CART SPINNING
			mainCont.hide();
			
			cartCont.children('*').hide();
			cartCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
			
			//// DOES OUR AJAX QUERY
			jQuery.ajax({
				
				url: 				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_remove_from_cart',
					nonce: 			sf_us._sf_remove_from_cart_nonce,
					post_id: 		post_id,
					field_action: 	action
					
				},
				success: function(data) {
					
					//// NOW THAT WE HAVE ADDED WE FADE THE SPINNER OUT AND SCROLL TO TOP
					mainCont.spin(false);
					
					//// REFRESHES CART
					cartCont.show()._sf_refresh_cart(post_id);
					
					///// SHOWS IT BACK IN THE ADMIN AREA
					jQuery('#'+action).show();
					jQuery('#'+action).find('*').show();
					
					//// HIDES THE EM
					jQuery('#'+action+' em').hide();
					
				}
				
			});
			
		},
		
		_sf_checkout_cart: function(e, post_id) {
			
			//// vars
			var mainCont = this;
			var formCont = jQuery('#_sf_spot');
			
			//// ADDS LOADING SIGN
			mainCont.spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9, left: -33, color: '#333' });
			
			if(typeof checkoutUrl != 'undefined') { checkoutUrl.abort(); }
			
			///// CHECKS FOR RECURRING
			var recurring_submission = 'false';
			if(jQuery('#_sf_submission_recurring').length > 0) { if(jQuery('#_sf_submission_recurring').is(':checked')) { recurring_submission = 'true'; } }
			var recurring_featured = 'false';
			if(jQuery('#_sf_featured_recurring').length > 0) { if(jQuery('#_sf_featured_recurring').is(':checked')) { recurring_featured = 'true'; } }
			
			//// LETS LOAD OUR PAYPAL LINK
			checkoutUrl = jQuery.ajax({
				
				url:				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_checkout',
					nonce: 			sf_us.checkout_nonce,
					post_id: 		post_id,
					current_url: 	window.location.href,
					recurring_featured: recurring_featured,
					recurring_submission: recurring_submission
					
				},
				success: function(data) {
					
					///// REMOVES SPIN
					mainCont.spin(false);
					
					//// IF THERE ARE NO ERRORS
					if(data.error === true) {
						
						// SHOW ERROR MESSAGE
						jQuery('#message').removeClass('success').addClass('error').find('span').text(data.error_message);
						jQuery('#message i').attr('class', 'icon-cancel-circle');
						jQuery('#message').slideDown(200, function() { jQuery(this).delay(3000).slideUp(200); });
						
					} else {
						
						//// SAVES SPOST
						jQuery('#_sf_spot')._sf_save_spot(post_id, 'false', function() {
							
							//// SHOWS SUCCESS MESSAGE
							jQuery('#message').removeClass('error').addClass('success').find('span').text(data.message);
							jQuery('#message i').attr('class', 'icon-ok-circle');
							jQuery('#message').slideDown(200, function() {
							
								//// REDIRECTS TO PAYPAL
								window.location.href = data.redirect;
							
							});
						
						});
						
					}
					
				}
				
			});
			
			e.preventDefault();
			return false;
			
		},
		
		_sf_open_user_notification: function() {
			
			//// WHEN USER CLICKS THE LINK
			var aCont = this;
			
			aCont.click(function(e) {
				
				/// DOCUMENT HEIGHT
				var docH = jQuery(document).height();
				
				//// APPENDS OUR OUTER MARKUP
				jQuery('body').append('<div id="notify-me-signup" style="height: '+docH+'px;"><div><div class="inside"></div></div></div>');
				
				//// SCROLL TO TOP
				jQuery('body, html').animate({ scrollTop: 0 }, 400);
				
				//// FADES IN
				var mainCont = jQuery('#notify-me-signup').fadeIn(300);
				var insideCont = mainCont.children('div').children('div');
				
				//// WHEN WE CLICK OUTSIDE
				mainCont.click(function(e) {
					
					///// IF WE HAVE CLICKED ON THE OUTSIDE WE CLOSE
					if(e.target.id == 'notify-me-signup') {
						
						mainCont._sf_close_user_notification();
						
					}
					
				});
				
				//// ADDS SPINNING
				insideCont.spin({lines: 9,  length: 5,  width: 3,  radius: 6,  corners: 1,  color: '#000',  speed: 1.8 });
				
				//// OUR SEARCH FORM FOR SENDING DATA
				formCont = jQuery('#search-spots');
				
				//// LOADS OUR INNER HTML
				oepnNotificationAjax = jQuery.ajax({
					
					url: 			sf_us.ajaxurl,
					type: 			'post',
					dataType: 		'HTML',
					data: {
						
						action: 	'_sf_load_notification_signup',
						nonce: 		sf_us._sf_load_notification_signup_nonce,
						data: 		formCont.serialize()
						
					},
					success: function(data) {
						
						///// ANIMATES OUR WIDTH
						insideCont.spin(false).stop().parent().animate({ width: '300px' }, 200, function() {
							
							//// APPENDS OUR HTML AND FADES IT IN
							insideCont.html(data);
							insideCont.children('*:not(.thankyou)').fadeIn(200);
							insideCont.parent().css({ height: 'auto' });
				
							///// WHEN WE CLICK THE CLOSE BUTTON
							insideCont.find('h2 i').click(function() { mainCont._sf_close_user_notification(); });
							
						});
						
					}
					
				});
				
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_close_user_notification : function() {
			
			var mainCont = this;
			
			if(typeof oepnNotificationAjax != 'undefined') { oepnNotificationAjax.abort(); }
			
			//// CLOSES IT
			mainCont.fadeOut(300, function() { jQuery(this).remove(); });
			
		},
		
		_sf_send_user_notification: function() {
			
			var formCont = this;
			var button = formCont.find('input[type="submit"]');
			
			//// WHEN SUER SUBMITS THE FORM
			formCont.submit(function(e) {
				
				//// ADDS OUR SPINNING SIGN
				formCont.children('*').stop().animate({ opacity: .1 });
				button.attr('disabled', 'disabled');
				formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				formCont.find('small.error, p.error small').remove();
				formCont.find('p.error').removeClass('error');
				
				///// LETS DO OUR AJAX REQUEST
				sendNotificationAjax = jQuery.ajax({
					
					url: 				sf_us.ajaxurl,
					type: 				'post',
					dataType: 			'json',
					data: {
						
						action: 	'_sf_send_notification_signup',
						nonce: 		sf_us._sf_send_notification_signup_nonce,
						data: 		formCont.serialize()
						
					},
					success: function(data) {
						
						console.log(data);
						
						//// IF ERROR IS TRUE
						if(data.error) {
								
							formCont.children('*').stop().animate({ opacity: 1 });
							button.removeAttr('disabled');
							formCont.spin(false);
							
							//// IF ITS AN ARRAY
							if(data.error = 'field') {
								
								jQuery.each(data.message, function(i, obj) {
									
									//// ADDS THE ERROR TO OUR FIELD
									formCont.find('input[name="'+obj.field+'"]').parent().addClass('error').append('<small>'+obj.message+'</small>');
									
								});
								
							} else {
							
								//// SHOWS ERROR
								formCont.prepend('<p><small class="error" style="display: block;">'+data.message+'</small></p>');
								formCont.children('small').fadeIn(300);
								
							}
							
						} else {
							
							//// HIDES FORM
							formCont.slideUp(200);
							formCont.siblings('.thankyou').slideDown(200);
							
						}
						
					}
					
				});
				
				
				//// PREVENTS NON AJAX
				e.preventDefault();
				return false;
				
			});
			
		},
		
		generatePlot: function(data) {
			
			var mainCont = this;
			
			jQuery.plot(mainCont, data, {
				series: {
					stack: 0,
					lines: {
						show: true,
						lineWidth: 0,
						fill: true,
					},
					points: {
						show: true,
					}
				},
				xaxis: {
					
					mode: "time",
					timeformat: "%d/%m",
					ticks: 8,
					tickLength: 10,
					tickColor: '#d0d0d0'
					
				},
				yaxis: {
					show: false,
					autoscaleMargin: .1
					
				},
				grid: {
					
					hoverable: true,
					clickable: true,
					borderWidth: {
						
						left: 1,
						right: 1,
						top: 0,
						bottom: 1
						
					},
					borderColor: '#d0d0d0',
					margin: {
						
						top: 20
						
					},
					
				},
				legend: {
					
					show: true,
					labelFormatter: function(label, series) {
						
						var exists = false;
						
						//// GOES THROUGH LABEL BY LABEL TO SEE IF IT EXISTS
						jQuery('#page-view-labels ul li').each(function() {
							
							
							if(jQuery(this).attr('title') == label) { exists = true; }
							
						});
						
						/// ONLY IF WE DONT HAVE LABELS
						if(exists == false) {
						
							//// LETS APPEND THIS LABEL TO OUR VIEW OPTION
							markup = '<li title="'+label+'"><span>';
							
							//// LETS START WITH A THE COLOR
							markup += '<input type="hidden" name="color" value="'+series.color+'" />';
							
							//// ADDS OUR SQAURE
							markup += '<div style="width:4px;height:0;border:8px solid '+series.color+';overflow:hidden; float: left; margin-right: 7px; margin-top: 3px;"></div>';
							
							//// ADDS TITLE
							markup += '<span>'+label+'</span>';
							
							//// CLOSES MARKUP
							markup += '</span></li>';
							
							//// APPENDS TO OUR CONTAINER
							jQuery('#page-view-labels ul').append(markup);
						
						}
						
						return false;
						
					}
					
				}
				
			});
			
		},
		
		_sf_tooltips: function(steps, nex_text, dismiss_text, previous_text, cookie) {
			
			/// VARS FIRST
			var bodyCont = this;
			_sf_current_step = 0;
			
			_sf_tooltips_steps = steps;
			_sf_tooltips_next = nex_text;
			_sf_tooltips_dismiss = dismiss_text;
			_sf_tooltips_prev = previous_text;
			_sf_tooltips_cookie = cookie;
			
			//// LETS GENERATE OUR MARKUP
			if(jQuery('#_sf_tooltip_wrapper').length == 0) { jQuery('body').append('<div id="_sf_tooltip_wrapper"></div>'); }
			
			//// IF THE USER CLICKS THE BG
			jQuery('#_sf_tooltip_wrapper').click(function(e) {
				
				/// IF ITS OUR REAL TARGET PLAY NEXT
				if(e.target.id == '_sf_tooltip_wrapper') {
					
					jQuery('#_sf_tooltip_wrapper')._sf_tooltips_next();
					
				}
				
			});
			
			//// IF OUR CART IS REFRESHING WE NEED TO WAIT FOR IT TO FINISH
			if(typeof isCartRefreshing != 'undefined') {
				
				_sf_tooltip_interval = setInterval(function() {
					
					if(isCartRefreshing === false) {
						
						bodyCont._sf_tooltips_call(steps);
						
					}
					
				}, 200);
				
			} else {
			
				/// LETS CALL OUR FIRST TOOLTIP
				bodyCont._sf_tooltips_call(steps);
				
			}
			
		},
		
		_sf_tooltips_call: function(steps) {
			
			if(typeof _sf_tooltip_interval != 'undefined') { clearInterval(_sf_tooltip_interval); }
			
			//// IF OUR COOKEI IS SET TO FALSE
			var theCookie = jQuery.cookie(_sf_tooltips_cookie);
			
			if(theCookie == 'false') { return false; }
			
			//// VARS
			var bodyCont = this;
			var field = jQuery('#'+steps[_sf_current_step].container);
			
			//// FIXES WIDTH AND HEIGHT
			var tCont = jQuery('#_sf_tooltip_wrapper');
			var dH = jQuery(document).height();
			var dW = jQuery(document).width();
			tCont.height(dH);
			tCont.width(dW);
			
			//// CREATES THE TOOLTIP MARKUP
			var markup = '<div class="_sf_tooltip_wrapper"><div class="inside"><i class="icon-sort-up"></i><div class="left">'+(parseInt(_sf_current_step)+1)+'</div>';
			
			markup += '<div class="right">';
			
			markup += '<div class="content"><h4>'+steps[_sf_current_step].title+'</h4><p>'+steps[_sf_current_step].description+'</p></div>';
			
			markup += '<span class="dismiss" onclick="jQuery(\'#_sf_tooltip_wrapper\')._sf_tooltips_dismiss();"><i class="icon-block"></i>'+_sf_tooltips_dismiss+'</span>';
			
			//// ONLY ADDS THIS IF WE HAVE SOMETHING TO MOVE ON
			if((_sf_current_step+1) < steps.length) {
				markup += '<span class="next" onclick="jQuery(\'#_sf_tooltip_wrapper\')._sf_tooltips_next();">'+_sf_tooltips_next+'<i class="icon-right-circled"></i></span>';
			}
			
			if(_sf_current_step > 0) { markup += '<span class="prev" onclick="jQuery(\'#_sf_tooltip_wrapper\')._sf_tooltips_prev();"><i class="icon-left-circled"></i>'+_sf_tooltips_prev+'</span>'; }
			
			markup += '</div>';
			//// RIGHT
			
			markup += '<div class="clear"></div></div>';
			//// INSIDE
			
			markup += '</div>';
			//// tooltip wrapper
			
			tCont.html('').append(markup);
			
			///// IF ITS CONTENT - WE SHOW AS A TOOLTIP
			if(steps[_sf_current_step].container == 'content') {
				
				var contentW = jQuery('#content .wrapper').width() * 0.9;
				
				///// FIXES TOP AND LEFT
				fieldOffset = jQuery('#content .wrapper').offset();
				fieldTop = fieldOffset.top + 100;
				
				tCont.children('div').css({ left: (fieldOffset.left + (jQuery('#content .wrapper').width() * 0.05)), top: fieldTop });
				
				tCont.children('div').width(contentW);
				
				tCont.find('.icon-sort-up').remove();
				
			} else {
			
				//// FIXES WIDTH OF OUR TOOLTIP
				var fieldW = field.outerWidth();
				if(fieldW<300) { fieldW = 300; }
				tCont.children('div').width(fieldW);
				
				///// FIXES TOP AND LEFT
				fieldOffset = field.offset();
				fieldTop = fieldOffset.top + field.outerHeight() + 15;
				
				//// CHANGES THE Z INDEX OF THE FIELD
				field.css({ 'z-index': 5000, position: 'relative' });
				
				tCont.children('div').css({ left: fieldOffset.left, top: fieldTop });
			
			}
			
			///// IF ALIGNMENT IN ON THE RIGHT
			if(steps[_sf_current_step].align == 'right') {
				
				/// ALIGNMENT AUTO
				tCont.children('div').css({ left: 'auto' });
				
				///// LETS CALCULATE THE RIGHT
				tCont.css({ display: 'block', opacity: 1 });
				tCont.children('div').css({ display: 'block', opacity: 0 });
				
				var theWidth = tCont.children('div').width();
				var newRight = jQuery(window).width() - (fieldOffset.left + field.width()) - 15;
				tCont.children('div').addClass('right-align').css({ right: newRight+'px', opacity: 1, display: 'none' });
				
			} else {
				
				tCont.children('div').removeClass('right-align').css({ right: 'auto' });
				
			}
			
			//// FADES IN TOOLTIP
			tCont.fadeIn(150);
			tCont.children('div').fadeIn(150);
			
			//jQuery('body, html').scrollTo(field, field, { gap: { y: -15 }, animation: { duration: 150 } });
			
			var difference = 50;
			if(jQuery('#header-space').length > 0) { var difference = 50 + jQuery('#header-space').height(); }
			
			jQuery(window).bind("mousewheel", function() {
				jQuery("html, body").stop(true);
			});
			
			//// SKIPS THE SCROLL TO TOP TO THE CONTAINER
			jQuery('body, html').animate({ scrollTop: (fieldOffset.top - difference) }, 150, function() {
				
				//jQuery("body, html").stop(true);
				
				
			});
			
		},
		
		_sf_tooltips_next: function() {
			
			///// IF ITS THE LAST STEP
			if((_sf_current_step+1) == _sf_tooltips_steps.length) {
				
				jQuery('#_sf_tooltip_wrapper')._sf_tooltips_dismiss();
				
			}
			
			var field = jQuery('#'+_sf_tooltips_steps[_sf_current_step].container);
			
			//// FIRSTLY LETS FADE OUT THE CURRENT TOOLTIP
			var tCont = this;
			tCont.children('div').fadeOut(200);
			
			//// INCREASES THE CURRENT STEP
			_sf_current_step++;
			
			//// REMOVES THE Z INDEX FROM THE CURRENT FIELD
			field.css({ 'z-index': 'auto' });
			
			jQuery('body')._sf_tooltips_call(_sf_tooltips_steps);
			
		},
		
		_sf_tooltips_prev: function() {
			
			var field = jQuery('#'+_sf_tooltips_steps[_sf_current_step].container);
			
			//// FIRSTLY LETS FADE OUT THE CURRENT TOOLTIP
			var tCont = this;
			tCont.children('div').fadeOut(200);
			
			//// INCREASES THE CURRENT STEP
			_sf_current_step--;
			
			//// REMOVES THE Z INDEX FROM THE CURRENT FIELD
			field.css({ 'z-index': 'auto' });
			
			jQuery('body')._sf_tooltips_call(_sf_tooltips_steps);
			
		},
		
		_sf_tooltips_dismiss: function() {
			
			var field = jQuery('#'+_sf_tooltips_steps[_sf_current_step].container);
			
			//// FIRSTLY LETS FADE OUT THE TOOLTIPS
			var tCont = this;
			tCont.fadeOut(300);
			
			//// REMOVES THE Z INDEX FROM THE CURRENT FIELD
			field.css({ 'z-index': 'auto' });
			
			//// SETS THE COOKIG
			jQuery.cookie(_sf_tooltips_cookie, 'false', { path: '/' });
			
		},
		
		_sf_fb_sign_up: function() {
			
			var button = this;
			isFacebookLoading = false;
			
			//// WHEN USER CLICKS THE FACEBOOK BUTTON
			button.click(function() {
				
				//// LETS TRY AND LOG THE USER IN
				FB.login(function(response) {
					
					//// IF WE ARE SUCCESSFULLY CONNECTED
					if(response.status === 'connected') {
						
						///// LETS LOG HIM IN / REGISTER HIM
						button._sf_fb_log_in(response);
						
					}
					
				}, { scope: 'email' });
				
			});
			
		},
		
		_sf_fb_log_in: function(data) {
			
			if(isFacebookLoading === false) {
				
				isFacebookLoading = true;
				
				//// RETRIEVES USER DATA - IF FB IS NOT LOADING
				FB.api('/me', function(response) {
					
					//// MAKE SURE ITS NOT LOADING AGAIN
					isFacebookLoading = false;
					
					//// ADDS OUR LOADING SIGN
					jQuery('#_sf_login_row').children('*').stop().animate({ opacity: .3 });
					jQuery('#_sf_login_row input[type="submit"]').attr('disabled', 'disabled');
					jQuery('#_sf_login_row').spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
					jQuery('#_sf_login_row').find('small.error, p.error small').remove();
					jQuery('#_sf_login_row').find('p.error').removeClass('error');
			
					//// LETS LOG HIM IN
					jQuery.ajax({
						
						url: 				sf_us.ajaxurl,
						type: 				'post',
						dataType: 			'json',
						data: {
							
							action: 		'_sf_us_fb_login',
							nonce: 			sf_us._sf_us_fb_login_nonce,
							firstname: 	response.first_name,
							lastname: 		response.last_name,
							user_id: 		response.id,
							email: 			response.email
							
						},
						success: function(data) {
							
							if(data.error) {
								
								alert(data.message);
								
							} else {
								
								//// REFRESHES WINDOW
								window.location.href = window.location.href;
								
							}
							
						}
						
					});
					
					console.log(response);
				
				});
			
			}
			
			
		},
		
		_sf_field_categories: function() {
			
			//// ADDS THE EVENT TO EACH INPUT
			var ulCont = this;
			
			//// OUR CATEGORY ARRAY IN CASE OF MULTIPLE FIELDS
			_sf_field_categories_array = [];
			
			//// CHECKS FOR INITIAL STATUS
			ulCont.find('input').each(function() {
					
				var input = jQuery(this);
				
				//// IF WE HAVE SELECTED ADD TO THE ARRAY
				if(input.is(':checked')) {
					
					//// PUSHES THE ID
					var theInputId = input.val();
					_sf_field_categories_array.push(theInputId);
					
				} else {
					
					var theInputId = input.val();
					
					//// GOES THROUGH THE ARRAY AND REMOVES THE ID
					jQuery.each(_sf_field_categories_array, function(i, obj) {
						
						if(obj === theInputId) {
							
							//// REMOVES IT
							_sf_field_categories_array.splice(i, 1);
							
						}
						
					});
					
				}
				
			});
			
			//// DOES IT STRAIGHT AWAY
			jQuery('#_sf_custom_search_fields_wrapper')._sf_field_categories_sort();
			
			ulCont.find('.checkbox-replace, .radio-replace').each(function() {
				
				//// ADDS THE EVENT
				jQuery(this).click(function(e) {
					
					var input = jQuery(this).find('input');
					
					///// IF ITS A RADIO WE ONLY SELECT ONE
					if(input.attr('type') == 'radio') {
						
						_sf_field_categories_array = new Array();
						
					}
					
					//// IF WE HAVE SELECTED ADD TO THE ARRAY
					if(input.is(':checked')) {
						
						//// PUSHES THE ID
						var theInputId = input.val();
						_sf_field_categories_array.push(theInputId);
						
					} else {
						
						var theInputId = input.val();
						
						//// GOES THROUGH THE ARRAY AND REMOVES THE ID
						jQuery.each(_sf_field_categories_array, function(i, obj) {
							
							if(obj === theInputId) {
								
								//// REMOVES IT
								_sf_field_categories_array.splice(i, 1);
								
							}
							
						});
						
					}
					
					console.log(_sf_field_categories_array);
					
					//// SHOWS / HIDES FIELDS
					jQuery('#_sf_custom_search_fields_wrapper')._sf_field_categories_sort();
					
				});
				
			});
			
		},
		
		_sf_field_categories_sort: function() {
			
			var mainCont = this;
			
			//// GOES THROUGH EACH ITEM AND CHECKS WHETHER OR NOT THEY SHOULD BE SHOWN
			jQuery('body').find('._sf_box').each(function() {
				
				//// IF THIS BOXES ID IS IN THE ARRAY
				var classes = jQuery(this).attr('class').split(' ');
				var this_field = jQuery(this);
				
				console.log(classes);
				var catClasses = classes[3];
				if(typeof catClasses == 'undefined') { catClasses = 'all'; }
				
				//// IF THERE IS NO ALL WE NEED TO SORT IT
				if(catClasses.indexOf('all') == -1) {
					
					//// GETS ALL CLASSES
					var all_ids = catClasses.split('_');
					
					var is_in_array = false;
					
					//// SEARCHES ID BY ID AND CHECKS IF ITS IN THE ARRAY
					jQuery.each(all_ids, function(i, this_id) {
						
						//// IF THIS ID IS IN THERE SET IT TO TRUE AND BREAK
						if(jQuery.inArray(this_id, _sf_field_categories_array) != -1) {
							
							is_in_array = true;
							
						}
						
					});
					
					//// IF ITS TRUE
					if(is_in_array === true) { this_field.show(); }
					else { this_field.hide(); }
					
				} else {
					
					jQuery(this).show();
					
				}
				
			});
			
		},
		
		_sf_show_user_info: function() {
			
			var mainCont = this;
			var partial = mainCont.find('.init');
			var full = mainCont.find('.full');
			
			partial.hide();
			full.show();
			
		},
		
		_sf_field_categories_load_subcats: function() {
			
			var inputs = this;
			var clickCont = inputs.parent().parent().find('> .checkbox-replace, > .checkbox-label');
			clickCont.each(function() {
				
				jQuery(this).on('click', function() {
					
					//// IF ITS CHECKED
					if(jQuery(this).parent().find('> .checkbox-replace > input:first').is(':checked')) {
						
						//// LOADS CHILDREN
						var the_parent_id = jQuery(this).parent().find('> .checkbox-replace > input:first').val();
						jQuery(this)._sf_load_subcategories_submission(the_parent_id);
						
					} else {
						
						//// REMOVES CHILDREN
						jQuery(this).siblings('ul').fadeOut(250, function() { jQuery(this).remove(); });
						
					}
					
				});
				
			});
			
		},
		
		
		_sf_load_subcategories_submission: function(parent_id) {
			
			//// LETS ADD A LOADING SIGN UNDERNEATH THE LI
			var mainCont = this;
			mainCont.parent().css({ 'padding-bottom': '30px' }).spin({ lines: 7, length: 0, width: 4, radius: 4, corners: 1, speed: 1.9, top: 28 });
			
			//// LOADS VIA AJAX
			jQuery.ajax({
				
				url:				sf_us.ajaxurl,
				type: 				'post',
				dataType: 			'json',
				data: {
					
					action: 		'_sf_load_subcategories_submission',
					nonce: 			sf_us._sf_load_subcategories_submission_nonce,
					parent: 		parent_id
					
				},
				success: function(data) {
					
					///// IF THERE ANY ERRORS DONT DO ANYTHING
					if(data.error) {
						
						mainCont.parent().spin(false);
						
					} else {
						
						//// APPENDS AN UL TO OUR LI
						mainCont.parent().append('<ul></ul>');
						var ulCont = mainCont.parent().children('ul');
						
						///// GOES THROUGH EACH ONE OF OUR TERMS
						jQuery.each(data.terms, function(i, obj) {
							
							var the_class = '';
							if(obj.has_children) { the_class = ' class="load-subcategories"'; }
							
							ulCont.append('<li style="display: none;"><input type="checkbox" name="_sf_category[]" id="_sf_category_'+obj.ID+'" value="'+obj.ID+'"'+the_class+' /><span class="checkbox-label">'+obj.name+'</span></li>');
							
							//// REMOVES SPIN
							mainCont.parent().spin(false).css({ 'padding-bottom': 0 });
							
							//// DOES THE CHECKBOX REPLACE
							ulCont.children('li').children('input[type="checkbox"]').each(function() {
								
								var parentLi = jQuery(this).parent();
								
								jQuery(this).replaceCheckbox();
								
								//// WHEN WE CLICK THE CLABEL
								parentLi.children('.checkbox-label').click(function() {
									
									if(jQuery(this).siblings('div.checkbox-replace').children('input').is(':checked')) {
										
										jQuery(this).siblings('div.checkbox-replace').removeClass('checkbox-replace-checked').children('input').removeAttr('checked');
										
									} else {
										
										jQuery(this).siblings('div.checkbox-replace').addClass('checkbox-replace-checked').children('input').attr('checked', 'checked');
										
									}
									
								});
								
							});
							
						});
							
						//// LETS UNBIND AND THEN BIND THE EVENTS AGAIN
						ulCont.children('li').children('.load-subcategories').children('input')._sf_field_categories_load_subcats();
						
						ulCont.find('li').fadeIn(300);
						
					}
					
				}
				
			});
			
		},
		
		_sf_spot_submit_translation: function() {
			
			//// VARS
			var formCont = this;
			
			//// WHEN USER SUBMITS FORM
			formCont.submit(function(e) {
			
				/// MAKES SURE WE GET THE CONTENT FROM THE VISUAL EDITOR
				tinyMCE.triggerSave();tinyMCE.triggerSave();
				
				//// LET'S DISPLAY THE SPINNING SIGN
				formCont.spin({ lines: 11, length: 16, width: 5, radius: 14, corners: 1, speed: 1.9, color: '#000', top: '100' }).children('*:not(div.spinner)').css({ opacity: .3 });
				
				//// REMOVES ALL ERROS
				formCont.find('small.error').hide();
				formCont.find('*.error:not(small)').removeClass('error');
				
				//// VALIDATES FIELDS
				var error = false;
				var error_fields = new Array();
				
				//// TITLE
				var titleCont = formCont.find('#_sf_spot_title');
				if(titleCont.val() == '') { error = true; error_fields.push('#_sf_spot_title'); }
				
				//// LOCATION - ADDRESS
				var addressCont = formCont.find('#_sf_address');
				if(addressCont.val() == '') { error = true; error_fields.push('#_sf_address'); }
				
				//// CHECKS FOR OTHER REQUIREDS
				jQuery('.required').each(function() {
					
					//// ONLY IF IT'S VISIBLE
					if(jQuery(this).closest('._sf_box').is(':visible')) {
					
						//// IF NOTHING IS SET
						if(jQuery(this).val() == '') { error = true; var the_ID = jQuery(this).attr('id'); error_fields.push('#'+the_ID); jQuery(this).closest('.error').slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }) }); }
						
					}
					
				});
				
				//// CHECKS FOR REQUIRED FILES
				jQuery('.required-file').each(function() {
					
					//// ONLY IF IT'S VISIBLE
					if(jQuery(this).closest('._sf_box').is(':visible')) {
					
						//// IF NOTHING IS SET
						if(jQuery(this).children('li:not(._sf_box_clone)').length == 0) { error = true; var the_ID = jQuery(this).attr('id'); error_fields.push('#'+the_ID); jQuery(this).siblings('.error').slideDown(200, function() { jQuery(this).css({ overflow: 'visible' }) }); }
						
					}
					
				});
				
				//// IF THERE ARE ERRORS LET'S DISPLAY THEM
				if(error === true) {
					
					formCont.spin(false).children('*').css({ opacity: 1 });
					
					//// DISPLAY ERROR MESSAGE
					jQuery('#message').removeClass('success').addClass('error').find('span').text(sf_us.submit_error_message);
					jQuery('#message i').attr('class', 'icon-cancel-circle');
					jQuery('#message').slideDown(200, function() { jQuery(this).delay(3000).slideUp(200); });
					jQuery("html, body").animate({ scrollTop: 0 }, 500);
					
					//// GOES THROUGH OUR ERROR FIELDS
					jQuery.each(error_fields, function(i, _error) {
						
						//// DISPLAYS THE MESSAGE OF THIS FIELD
						jQuery(_error).siblings('small').fadeIn(200, function() { jQuery(this).delay(3000).fadeOut(200); });
						
						//// ADDS ERROR CLASS
						jQuery(_error).addClass('error');
						
					});
					
				} else {
					
					var post_id = jQuery('#_sf_spot_id').val();
					
					//// SUBMITS IT VIA AJAX
					jQuery.ajax({
						
						url: 				sf_us.ajaxurl,
						type: 				'post',
						dataType: 			'json',
						data: {
							
							action: 		'_sf_submit_translation',
							nonce: 			sf_us._sf_submit_translation_nonce,
							data: 			formCont.serialize(),
							post_id: 		post_id
							
						},
						success: function(data) {
							
							console.log(data);
							
							//// IF NO ERRORS
							if(!data.error) {
								
								////IF WE ARE ADDING
								if(window.location.href.indexOf('action=add-new') != -1) {
									
									theHref = window.location.href.replace('action=add-new', 'message=success');
									
								} else {
									
									theHref = window.location.href.split('?');
									theHref = theHref[0]+'?message=success';
									
								}
								
								//// REDIRECTS THE USER
								//theHref = window.location.href.replace('action=add-new', 'message=success');
								window.location.href = theHref;
								
							} else {
					
								formCont.spin(false).children('*').css({ opacity: 1 });
								
								//// DISPLAY ERROR MESSAGE
								jQuery('#message').removeClass('success').addClass('error').find('span').text(data.message);
								jQuery('#message i').attr('class', 'icon-cancel-circle');
								jQuery('#message').slideDown(200, function() { jQuery(this).delay(4000).slideUp(200); });
								jQuery("html, body").animate({ scrollTop: 0 }, 300);
								
							}
							
						}
						
					});
					
				}
				
				//// PREVENTS NON AJAX SUBMISSIONS
				e.preventDefault();
				return false;
				
			});
			
		},
		
	});
	
})(jQuery);


function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}



/*!
 * jquery.scrollto.js 0.0.1 - https://github.com/yckart/jquery.scrollto.js
 * Scroll smooth to any element in your DOM.
 *
 * Copyright (c) 2012 Yannick Albert (http://yckart.com)
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 * 2013/02/17
 **/
jQuery.scrollTo = jQuery.fn.scrollTo = function(x, y, options, callback){
    if (!(this instanceof jQuery)) return jQuery.fn.scrollTo.apply(jQuery('html, body'), arguments);

    options = jQuery.extend({}, {
        gap: {
            x: 0,
            y: 0
        },
        animation: {
            easing: 'swing',
            duration: 600,
            complete: jQuery.noop,
            step: jQuery.noop,
        }
    }, options);

    return this.each(function(){
        var elem = jQuery(this);
        elem.stop().animate({
            scrollTop: !isNaN(Number(y)) ? y : jQuery(y).offset().top + options.gap.y
        }, options.animation);
    });
};
