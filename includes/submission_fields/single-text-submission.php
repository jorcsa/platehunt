<div class="submission-field-text">

	<?php
	
		$value = get_post_meta($post_id, '_sf_submission_field_'.get_the_ID(), true);
	
		//// FIRST LETS MAKE SURE THIS ISNT A YOUTUBE OR VIMEO VIDEO
		if((strpos($value, 'youtube') !== false || strpos($value, 'vimeo') !== false) && get_post_meta(get_the_ID(), 'allow_video', true)) {
			
			///// IF ITS A YOUTUBE VIDEO
			if(strpos($value, 'youtube') !== false) {
				
				//// LETS GET THE VIDEO ID
				preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value, $matches);
				
				//// IF WE HAVE A MATCH FOR OUR ID
				if($matches[1]) {
					
					//// DISPLAY OUR YOUTUBE VIDEO
					echo '<iframe width="100%" height="300" style="width: 100%;" src="//www.youtube.com/embed/'.$matches[1].'?rel=0" frameborder="0" allowfullscreen></iframe>';
					
				}
				
			} elseif(strpos($value, 'vimeo') !== false) {
				
				//// LETS GET THE VIDEO ID
				$matches = explode('/', $value);
				
				//// IF WE HAVE A MATCH FOR OUR ID
				if(is_numeric($matches[count($matches)-1])) {
					
					//// DISPLAY OUR YOUTUBE VIDEO
					echo '<iframe src="//player.vimeo.com/video/'.$matches[count($matches)-1].'?title=0&amp;byline=0&amp;portrait=0&amp;badge=0" width="100%" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="width: 100%;"></iframe>';
					
				}
				
			}
			
		} else {
	
			//// LETS GET THE FRONT END MARKUP
			$markup = str_replace('%%',$value, htmlspecialchars_decode(get_post_meta(get_the_ID(), 'markup', true)));
			
			//// REPLACES LINKS
			$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $markup);
			
			$ret = ' ' . $text;
			$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
			$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
			$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
			$ret = substr($ret, 1);
			
			echo $ret;
		
		}
	
	?>

</div>
<!-- .submission-field-text -->