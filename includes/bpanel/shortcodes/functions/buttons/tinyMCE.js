(function() {
	
	// CREATES THE PLUGIN
    tinymce.create('tinymce.plugins.dd_buttons', {  
		
		// INITIATES
        init : function(ed, url) { 
		 
			
			// REGISTER OUR COMMANDS SO WE CAN OPEN A NEW WINDOW
			ed.addCommand('cmd_dd_buttons', function() {
				
				ed.windowManager.open({
					
					file : url+'/window.php',
					width : 630,
					height : 340,
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});
			
			
			// ADDS OUT BUTTON
            ed.addButton('dd_buttons', {
				  
                title : 'Add a Button',  
                image : url+'/icon.png',
				cmd: 'cmd_dd_buttons'
				 
            }); 
			 
        },  
		
        createControl : function(n, cm) {  
		
            return null; 
			 
        },  
		
    });
	  
    tinymce.PluginManager.add('dd_buttons', tinymce.plugins.dd_buttons);  
	
})();