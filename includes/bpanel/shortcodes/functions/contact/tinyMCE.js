(function() {
	
	// CREATES THE PLUGIN
    tinymce.create('tinymce.plugins.dd_contact', {  
		
		// INITIATES
        init : function(ed, url) { 
		 
			
			// REGISTER OUR COMMANDS SO WE CAN OPEN A NEW WINDOW
			ed.addCommand('cmd_dd_contact', function() {
				
				ed.windowManager.open({
					
					file : url+'/window.php',
					width : 630,
					height : 261,
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});
			
			
			// ADDS OUT BUTTON
            ed.addButton('dd_contact', {
				  
                title : 'Add a Contact Form',  
                image : url+'/icon.png',
				cmd: 'cmd_dd_contact'
				 
            }); 
			 
        },  
		
        createControl : function(n, cm) {  
		
            return null; 
			 
        },  
		
    });
	  
    tinymce.PluginManager.add('dd_contact', tinymce.plugins.dd_contact);  
	
})();