(function() {
	
	// CREATES THE PLUGIN
    tinymce.create('tinymce.plugins.dd_slider', {  
		
		// INITIATES
        init : function(ed, url) { 
		 
			
			// REGISTER OUR COMMANDS SO WE CAN OPEN A NEW WINDOW
			ed.addCommand('cmd_dd_slider', function() {
				
				ed.windowManager.open({
					
					file : url+'/window.php',
					width : 630,
					height : 505,
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});
			
			
			// ADDS OUT BUTTON
            ed.addButton('dd_slider', {
				  
                title : 'Add an Image Slider',  
                image : url+'/icon.png',
				cmd: 'cmd_dd_slider'
				 
            }); 
			 
        },  
		
        createControl : function(n, cm) {  
		
            return null; 
			 
        },  
		
    });
	  
    tinymce.PluginManager.add('dd_slider', tinymce.plugins.dd_slider);  
	
})();