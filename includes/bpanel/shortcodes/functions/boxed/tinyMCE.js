(function() {
	
	// CREATES THE PLUGIN
    tinymce.create('tinymce.plugins.dd_boxed', {  
		
		// INITIATES
        init : function(ed, url) { 
		 
			
			// REGISTER OUR COMMANDS SO WE CAN OPEN A NEW WINDOW
			ed.addCommand('cmd_dd_boxed', function() {
				
				ed.windowManager.open({
					
					file : url+'/window.php',
					width : 630,
					height : 235,
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});
			
			
			// ADDS OUT BUTTON
            ed.addButton('dd_boxed', {
				  
                title : 'Add a Boxed Content',  
                image : url+'/icon.png',
				cmd: 'cmd_dd_boxed'
				 
            }); 
			 
        },  
		
        createControl : function(n, cm) {  
		
            return null; 
			 
        },  
		
    });
	  
    tinymce.PluginManager.add('dd_boxed', tinymce.plugins.dd_boxed);  
	
})();