<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('tweet', 'ddshort_tweet');
	add_shortcode('facebook_like', 'ddshort_facebook_like');
	add_shortcode('google_1', 'ddshort_google_1');
	add_shortcode('digg', 'ddshort_digg');
	add_shortcode('stumbleupon', 'ddshort_stumbleupon');
	add_shortcode('linkedin', 'ddshort_linkedin');
	
	//Our Funciton
	function ddshort_tweet($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'counter' => 'horizontal',
			'via' => '',
			'size' => '',
		
		), $atts));
		
		////STARTS OUR CONTENT
		$return = '<a href="https://twitter.com/share" class="twitter-share-button" data-count="'.$counter.'"';
		
		//// IF SIZE BIG
		if($size == 'big') { $return .= ' data-size="large"'; }
		
		//// IF SIZE BIG
		if($via != '') { $return .= ' data-via="'.$via.'"'; }
		
		$return .= '>Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_facebook_like($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'style' => 'standard',
		
		), $atts));
		
		//// DEPEMDS ON THE TYPE
		if($style == 'standard') {
			
			$return = '<iframe src="//www.facebook.com/plugins/like.php?href&amp;send=false&amp;layout=standard&amp;width=58&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=175731505819846" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>';
			
		} elseif($style == 'button') {
			
			$return = '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=175731505819846";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script><div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>';
			
		} elseif($style == 'box') {
			
			$return = '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=175731505819846";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script><div class="fb-like" data-send="false" data-layout="box_count" data-width="450" data-show-faces="true"></div>';
			
		}
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_google_1($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'size' => 'small',
			'text' => 'bubble',
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$return = '<g:plusone size="'.$size.'" annotation="'.$text.'" width="580"></g:plusone>';
		
		$return .= "<script type=\"text/javascript\">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>";
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_digg($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'size' => 'compact',
		
		), $atts));
		
		if($size == 'compact') { $size = 'Compact'; }
		if($size == 'wide') { $size = 'Wide'; }
		if($size == 'medium') { $size = 'Medium'; }
		if($size == 'icon') { $size = 'Icon'; }
		
		//// STARTS OUR OUTPUT
		$return = "<script type=\"text/javascript\">
(function() {
var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
s.type = 'text/javascript';
s.async = true;
s.src = 'http://widgets.digg.com/buttons.js';
s1.parentNode.insertBefore(s, s1);
})();
</script>";

		$return .= '<a class="DiggThisButton Digg'.$size.'"></a>';
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_stumbleupon($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'size' => '1',
		
		), $atts));
		
		$return = '<!-- Place this tag where you want the su badge to render -->
<su:badge layout="'.$size.'"></su:badge>

<!-- Place this snippet wherever appropriate --> 
 <script type="text/javascript"> 
 (function() { 
     var li = document.createElement(\'script\'); li.type = \'text/javascript\'; li.async = true; 
      li.src = \'https://platform.stumbleupon.com/1/widgets.js\'; 
      var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(li, s); 
 })(); 
 </script>
';
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_linkedin($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'counter' => 'right',
		
		), $atts));
		
		$return = '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-counter="'.$counter.'"></script>';
		
		return $return;
		
	}
	
	//include('tinyMCE.php');

?>