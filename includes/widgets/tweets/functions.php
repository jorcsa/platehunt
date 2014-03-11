<?php

include('TwitterAPIExchange.php');


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "latest_tweets" );' ) );
	
	
	//// OUR WIDGET CLASS
	class latest_tweets extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'us_latest_tweets', // BASE ID
				__('Custom - Tweets', 'ultrasharp'), // NAME
				array('description' => __('Displays your latest tweets', 'ultrasharp')) // DESCRIPTION
			
			);
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// FRONT-END FUNCTION
		public function widget($args, $instance) {
			
			global $wpdb, $post;
			
			//// EXTRACT OUR INPUTS
			extract($args);
			extract($instance);
			
			//// LET'S START OUR OUTPUT
			echo $before_widget;
			
			//// OUR TITLE
			if($title != '') { echo $before_title.$title.$after_title; }
			
			//// LET'S START OUR TWEET OUTPUT
			$limit = $count;
			
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
			
			if(is_wp_error($result)) { echo '<p>Twitter seems to be unavalable at this time.</p>'; }
			
			else {
			
			$tweets = json_decode($result['body']);
			
				//// IF NO ERRORS
				if(isset($tweets->errors)) {
					
					//// DISPLAY TWEETS
					echo '<p>An error occurred. Could not authorize tweets.</p>';
					
				} else {
					
					//echo '<pre>'; print_r($tweets); exit;
					
					if($icon == 'Twitter Bird') {
					
						//// OPENS OUR UL
						echo '<ul class="ddtwitter_widget">';
						
						//// LOOPS OUR TWEETS
						foreach($tweets as $tweet) {
							
							$date = date(get_option('date_format'), strtotime($tweet->created_at));
						
							echo '<li><span class="date">'.$date.'</span>'.$tweet->text.'</li>';
							
						}
						
						//// CLOSES OUR UL
						echo '</ul>';
						
					} else {
					
						//// OPENS OUR UL
						echo '<div class="twitter-widget">';
						
						if($title == '') { echo '<img src="'.get_template_directory_uri().'/images/icons/twitter-widget-bird.png" alt="" />'; } else { echo '<div class="padding" size="20"></div>'; }
						
						echo '<ul>';
						
						//// LOOPS OUR TWEETS
						foreach($tweets as $tweet) {
							
							$date = date(get_option('date_format'), strtotime($tweet->created_at));
							
							$profile_image = $tweet->user->profile_image_url;
						
							echo '<li>
							
									<div class="twitter-image"><img src="'.$profile_image.'" alt="" width=""></div>
											
									<div class="twitter-content">
									
										<span class="author">'.$username.'</span>
										
										<p>'.$tweet->text.'</p>
										
										<span class="time">'.$date.'</span>
									
									</div>
									
								</li>';
							
						}
						
						//// CLOSES OUR UL
						echo '</ul></div>';
						
					}
					
				}
			
			}
			
			//// CLOSES OUR ITEM
			echo $after_widget;
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			//// OUR DEFAULTS
			$defaults = array(
			
				'username' => 'envato',
				'count' => '4',
			
			);
			$instance = wp_parse_args((array) $instance, $defaults);
			
			//// OUR FORM ?>
            
            	<p style="border-bottom: 1px solid #dfdfdf; padding-bottom: 15px; margin-bottom: 15px;">
                
                	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ultrasharp'); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
                
                </p>
            
            	<p style="border-bottom: 1px solid #dfdfdf; padding-bottom: 15px; margin-bottom: 15px;">
                
                	<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter Username', 'ultrasharp'); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($instance['username']); ?>" />
                
                </p>
            
            	<p>
                
                	<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of tweets:', 'ultrasharp'); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($instance['count']); ?>" />
                
                </p>
            
            	<p>
                
                	<label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Style:', 'ultrasharp'); ?></label> 
                    <select name="<?php echo $this->get_field_name('icon'); ?>" id="<?php echo $this->get_field_id('icon'); ?>" class="widefat">
                    
                    	<option<?php if($instance['icon'] == 'Twitter Bird') { echo ' selected="selected"'; } ?>>Twitter Bird</option>
                    	<option<?php if($instance['icon'] == 'User Display Image') { echo ' selected="selected"'; } ?>>User Display Image</option>
                    
                    </select>
                
                </p>
            
            <?php
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// SAVE FUNCTION
		public function update($new, $old) {
			
			//// NEW INSTANCE ARRAY
			$instance = array();
			
			//// OUR FIELDS
			$instance['count'] = strip_tags($new['count']);
			$instance['username'] = strip_tags($new['username']);
			$instance['title'] = strip_tags($new['title']);
			$instance['icon'] = strip_tags($new['icon']);
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}
	
	if(!function_exists('twitter_status')) {
		
				function twitter_status($twitter_id, $count) {	
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, "http://api.twitter.com/1/statuses/user_timeline.xml?screen_name=".$twitter_id."&count=".$count);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3);
			curl_setopt($c, CURLOPT_TIMEOUT, 5);
			$response = curl_exec($c);
			$responseInfo = curl_getinfo($c);
			curl_close($c);
			if (intval($responseInfo['http_code']) == 200) {
				if (class_exists('SimpleXMLElement')) {
					$xml = new SimpleXMLElement($response);
					return $xml;
				} else {
					return $response;
				}
			} else {
				return false;
			}
		}

	}
	
	if(!function_exists('processLinks')) {

		/** Method to add hyperlink html tags to any urls, twitter ids or hashtags in the tweet */ 
		function processLinks($text) {
			$text = utf8_decode( $text );
			$text = preg_replace('@(https?://([-\w\.]+)+(d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>',  $text );
			$text = preg_replace("#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" >@\\2</a>'", $text);  
			$text = preg_replace("#(^|[\n ])\#([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://hashtags.org/search?query=\\2\" >#\\2</a>'", $text);
			return $text;
		}

	}


?>