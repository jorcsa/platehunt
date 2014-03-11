(function() {
	
	// CREATES THE PLUGIN
    tinymce.create('tinymce.plugins.dd_toggle', {  
		
		// INITIATES
        init : function(ed, url) { 
		 
			
			// REGISTER OUR COMMANDS SO WE CAN OPEN A NEW WINDOW
			ed.addCommand('cmd_dd_toggle', function() {
				
				ed.windowManager.open({
					
					file : url+'/window.php',
					width : 630,
					height : 415,
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});
			
			
			// ADDS OUT BUTTON
            ed.addButton('dd_toggle', {
				  
                title : 'Add a Toggled Content',  
                image : url+'/icon.png',
				cmd: 'cmd_dd_toggle'
				 
            }); 
			 
        },  
		
        createControl : function(n, cm) {  
		
            return null; 
			 
        },  
		
    });
	  
    tinymce.PluginManager.add('dd_toggle', tinymce.plugins.dd_toggle);  
	
})();