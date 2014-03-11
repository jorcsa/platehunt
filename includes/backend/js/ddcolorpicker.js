(function($){ 

    $.fn.extend({
		
		ddColorPicker: function() {
			
			//main vars
			var mainCont = this.parent();
			var inputCont = this;
			var colorCont = mainCont.children('span');
			
			var colorCode = colorToHex(colorCont.children('span').css('background-color'));
			
			// color activator
			colorCont.ColorPicker({
				
				//initial color
				color: colorToHex(colorCont.children('span').css('background-color')),
				
				//on click
				onShow: function() { colorCont.addClass('colorpicker-clicked'); },
				
				//when user changes it
				onChange: function(hsb, hex, rgb, el) {
					
					colorCont.children('span').css('background-color', '#'+hex);
					inputCont.val(hex);
					
				},
				
				//when submits
				onSubmit: function(hsb, hex, rgb, el) {
					
					colorCont.children('span').css('background-color', '#'+hex);
					inputCont.val(hex);
					
				},
				
				//when hides
				onHide: function() { colorCont.removeClass('colorpicker-clicked'); }
				
			});
			
		}
		
	});
	
})(jQuery);

function colorToHex(color) {
    if (color.substr(0, 1) === '#') {
        return color;
    }
    var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);
    
    var red = parseInt(digits[2]);
    var green = parseInt(digits[3]);
    var blue = parseInt(digits[4]);
    
    var rgb = blue | (green << 8) | (red << 16);
    return digits[1] +  rgb.toString(16);
};