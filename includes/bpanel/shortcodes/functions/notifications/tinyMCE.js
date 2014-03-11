(function() {
	
	// CREATES THE PLUGIN
    tinymce.create('tinymce.plugins.dd_notifications', {  
		
		// INITIATES
        init : function(ed, url) { 
		 
			
			// REGISTER OUR COMMANDS SO WE CAN OPEN A NEW WINDOW
			ed.addCommand('cmd_dd_notifications', function() {
				
				ed.windowManager.open({
					
					file : url+'/window.php',
					width : 630,
					height : 290,
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});
			
			
			// ADDS OUT BUTTON
            ed.addButton('dd_notifications', {
				  
                title : 'Add a Notification/Alert Box',  
                image : url+'/icon.png',
				cmd: 'cmd_dd_notifications'
				 
            }); 
			 
        },  
		
        createControl : function(n, cm) {  
		
            return null; 
			 
        },  
		
    });
	  
    tinymce.PluginManager.add('dd_notifications', tinymce.plugins.dd_notifications);  
	
})();