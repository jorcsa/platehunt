(function($){ 

    $.fn.extend({
		
		ddUploadImage: function() {
			
			//main vars
			var mainCont = this.parent().parent();
			var image_input = this;
			var the_button = mainCont.children('span').children('.upload-button');
			var image_id = the_button.attr('id');
			
			new AjaxUpload(image_id, {
				
				  action: ajaxurl,
				  name: image_id,
				  
				  // Additional data
				  data: {
					  
					action: 'ddpanel_ajax_upload',
					data: image_id
					
				  },
				  
				  autoSubmit: true,
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension) {
					  	
						//animates the input
						var old_image = image_input.val();
						image_input.val('uploading...').css({ color: '#aaaaaa' });
						image_input_interval = setInterval(function() {
							
							if(image_input.css('color') == 'rgb(170, 170, 170)') {
								
								image_input.stop().animate({ color: '#ffffff' }, 500)
								
							} else {
								
								image_input.stop().animate({ color: '#aaaaaa' }, 500)
								
							}
							
						}, 500);
						
						//disables button
						the_button.attr('disabled', 'disabled');
									  
				  },
				  
				  onComplete: function(file, response) {
					  	
						//clears the animation
						clearInterval(image_input_interval);
						
						the_button.removeAttr('disabled');
						
						if(response.search("Error") > -1){
							
							alert("There was an error uploading:\n"+response);
							
						}
						
						else{		
											
							image_input.stop().animate({ color: '#ffffff' }, 400, function() {
								
								image_input.val(response).stop().animate({ color: '#999999' }, 400);
								
							});
								
						}
						
						
						
					}
			});
			
		}
		
	});
	
})(jQuery);