(function() {
	
	// CREATES THE PLUGIN
    tinymce.create('tinymce.plugins.dd_audioandvideo', {  
		
		// INITIATES
        init : function(ed, url) { 
		 
			
			// REGISTER OUR COMMANDS SO WE CAN OPEN A NEW WINDOW
			ed.addCommand('cmd_dd_audioandvideo', function() {
				
				ed.windowManager.open({
					
					file : url+'/window.php',
					width : 630,
					height : 270,
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});
			
			
			// ADDS OUT BUTTON
            ed.addButton('dd_audioandvideo', {
				  
                title : 'Add Video or Tooltip',  
                image : url+'/icon.png',
				cmd: 'cmd_dd_audioandvideo'
				 
            }); 
			 
        },  
		
        createControl : function(n, cm) {  
		
            return null; 
			 
        },  
		
    });
	  
    tinymce.PluginManager.add('dd_audioandvideo', tinymce.plugins.dd_audioandvideo);  
	
})();