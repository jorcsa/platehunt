(function() {
	
	// CREATES THE PLUGIN
    tinymce.create('tinymce.plugins.dd_tooltip', {  
		
		// INITIATES
        init : function(ed, url) { 
		 
			
			// REGISTER OUR COMMANDS SO WE CAN OPEN A NEW WINDOW
			ed.addCommand('cmd_dd_tooltip', function() {
				
				ed.windowManager.open({
					
					file : url+'/window.php',
					width : 630,
					height : 495,
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});
			
			
			// ADDS OUT BUTTON
            ed.addButton('dd_tooltip', {
				  
                title : 'Add a Tooltip',  
                image : url+'/icon.png',
				cmd: 'cmd_dd_tooltip'
				 
            }); 
			 
        },  
		
        createControl : function(n, cm) {  
		
            return null; 
			 
        },  
		
    });
	  
    tinymce.PluginManager.add('dd_tooltip', tinymce.plugins.dd_tooltip);  
	
})();