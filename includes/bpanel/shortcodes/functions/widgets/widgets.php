<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('twitter_widget', 'ddshort_twitter_widget');
	add_shortcode('dribbble_widget', 'ddshort_dribbble_widget');
	add_shortcode('blog_widget', 'ddshort_blog_widget');
		
		//// INCLUDE THE DRIBBBLE API
		include('api/dribbble.php');
	
	function ddshort_twitter_widget($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'user' => 'envato',
			'count' => '4'
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$output = '<ul class="ddtwitter_widget">';
		
			//// LET'S GET OUR FEED
			$limit = $count;
			$tweet_array = array();
			$i = 1;
			$username = $user;
			
			$settings = array(
				'oauth_access_token' => "897105582-2I5o03W2xfqIwcyu7OmNSqfDyj3qkRNXsxp5Ob7g",
				'oauth_access_token_secret' => "nmLYrHwoWlk20PEqBJ57AVKNquLezQH61c2nvNqzU",
				'consumer_key' => "dKpmemJnt4YBTTlCQe5Qw",
				'consumer_secret' => "rm9OVBKPgVEPkVhGfC2CfXfVG26fZs3sD56chAUH9gc"
			);
			
			$connection = new wp_TwitterOAuth($settings['consumer_key'], $settings['consumer_secret'], $settings['oauth_access_token'], $settings['oauth_access_token_secret']);
			
			$connection->ssl_verifypeer = TRUE;
			
			$options = array(
			
				'screen_name' => $username,
				'include_entities' => 1,
				'count' => $count,
				'include_rts' => 0,
				'exclude_replies' => 0,
			
			);
			
			$result = $connection->get('statuses/user_timeline', $options);
			
			$tweets = json_decode($result['body']);
			
			//// IF NO ERRORS
			if($tweets->errors) {
				
				//// DISPLAY TWEETS
				echo '<li>An error occurred. Could not authorize tweets.</li>';
				
			} else {
				
				foreach($tweets as $tweet) {
					
					$date = date(get_option('date_format'), strtotime($tweet->created_at));
					
					$output .= '<li>'.$tweet->text.'<span class="date">'.$date.'</span></li>';
					
				}
				
			}
		
		//// CLOSES OUR OUTPUT
		$output .= '</ul>';
		
		//// RETURNS OUTPUT
		return $output;
		
	}
	
	//// DRIBBBLE
	function ddshort_dribbble_widget($atts, $content = null) {
		
		extract(shortcode_atts(array(
			
			'user' => 'salumguilherme',
			'count' => '6',
			'titles' => 'true',
			'info' => 'true',
			'shot_width' => '158',
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$output = '';
		
		//// LET'S GET OUR SHOTS
		$dribbble = new Dribbble();  
		$this_shots = $dribbble->get_player_shots($user);
		
		//// STARTS OUR UL OUTPUT
		$output .= '<ul class="dribbble-shots">';
		
		//// LOOPS OUR SHOTS
		$shotsI = 1;
		foreach($this_shots->shots as $shot) {
			
			////SHOTS COUNT
			if($shotsI <= $count) {
				
				//// STARTS OUR LI
				$output .= '<li>';
				
				////SHOT WRAPPER
				$output .= '<div class="shot">';
				
					//// OUR IMAGE
					$output .= '<a href="'.$shot->url.'" target="_blank"><img src="'.ddTimthumb($shot->image_url, $shot_width).'" alt="'.$shot->title.'" title="'.$shot->title.'" />';
					
					//// IF USER WANTS TITLE
					if($titles != 'false') { $height = round(($shot_width/4)*3); $output .= '<span class="shot-title" style="width: '.($shot_width-30).'px; height: '.($height-60).'px;">'.$shot->title.'</span>'; }
					
					//// CLOSES OUR LINK TAG
					$output .= '</a>';
					
					//// OUR INFO - IF USER WANTS IT
					if($info != 'false') { $output .= '<span class="shot-info"><span class="shot-views">'.$shot->views_count.'</span><span class="shot-comments">'.$shot->comments_count.'</span><span class="shot-likes">'.$shot->likes_count.'</span></span>'; }
				
				//// CLOSES SHOW WRAPPER
				$output .= '</div>';
				
				//// CLOSES OUR LI
				$output .= '</li>';
				
			} else { break; }
			
			$shotsI++;
			
		}
		
		//// CLOSES UL
		$output .= '</ul>';
		
		//// RETURNS OUTPUT
		return $output;
		
	}
	
	//// BLOG
	function ddshort_blog_widget($atts, $content = null) {
		
		extract(shortcode_atts(array(
			
			'cat' => 'all',
			'count' => '4',
			'columns' => '4',
			'width' => '188',
			'height' => '130',
			'info' => 'true',
			'thumbs' => 'true',
			'read_more' => 'true',
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$output = '';
		
		//// STARTS OUR UL OUTPUT
		$output .= '<ul class="blog-widget">';
		
		//// LET'S QUERY OUR POSTS
		$args = array(
		
			'post_type' => 'post',
			'posts_per_page' => $count
		
		); if($cat != 'all') { $args['cat'] = $cat; } //// IF THERE'S A SPECIFIC CATEGORY
		
		//// WP OBJECT
		$blogWidgetQuery = new WP_Query($args);
		
		//// LOOPS OUR POSTS
		$columnsI = 1;
		if($blogWidgetQuery->have_posts()) { while($blogWidgetQuery->have_posts()) { $blogWidgetQuery->the_post();
		
			//// OPENS OUR LI
			$output .= '<li id="blog-widget-'.get_the_ID().'" class="blog-widget-post';
			if($columnsI % $columns == 0) { $output .= ' last'; }
			$output .= '" style="width: '.($width+10).'px;">';
			
			//// STARTS WITH OUR THUMBNAIL
			if($thumbs != 'false') { 
			
				$thumb = ddGetFeaturedImage(get_the_ID());
				$output .= '<a href="'.get_permalink().'" class="blog-widget-thumbnail"><img src="'.ddTimthumb($thumb[0], $width, $height).'" alt="'.get_the_title().'" title="'.get_the_title().'" /></a>';
			
			}
			
			//// POST INFO
			if($info != 'false') { 
			
				$output .= '<div class="blog-widget-info"><span class="date">'.get_the_time(get_option('date_format')).'</span><a class="comments" href="'.get_permalink().'#comments">'.get_comments_number(get_the_ID()).' comment';
				
				if(get_comments_number(get_the_ID()) > 1 || get_comments_number(get_the_ID()) == 0) { $output .= 's'; }
				
				$output .= '</a></div>';
			
			}
			
			//// TITLE
			$output .= '<h5><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
			
			//// READ MORE
			if($read_more != 'false') { $output .= '<p><a href="'.get_permalink().'" class="button white">'.__('Read more', 'ultrasharp').'</a></p>'; }
			
			//// CLOSES OUR LI
			$output .= '</li>';
			
			$columnsI++;
		
		} }
		
		//// CLOSES UL
		$output .= '</ul>';
		
		//// RETURNS OUTPUT
		return $output;
		
	}
	
	//include('tinyMCE.php');

?>