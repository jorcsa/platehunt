<?php

	//// WHAT POSTS TYPE SHOULD WE INCLUDE
	$post_type = array(
	
		'post',
		'page',
		'portfolio_posts',
		'home_posts',
		'slides'
	
	);
	
	$shortcodes = array(
	
		array(
		
			'title' => 'Audio & Video',
			'shortcodes' => array(
			
				array(
					
					'name' => 'video_html5',
					'type' => 'simple',
					'title' => 'HTML 5 - .mp4 Video',
					'fields' => array(
					
						array(
							
							'name' => 'file',
							'title' => 'MP4 File URL',
							'desc' => 'Your .mp4 File',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'poster',
							'title' => 'Preview Image',
							'desc' => 'The preview image users see before playing the video',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'width',
							'title' => 'Player Width',
							'desc' => 'Width of your video player in pixels.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'height',
							'title' => 'Player Height',
							'desc' => 'Height of your video player in pixels.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), // SHORTCODE
			
				array(
					
					'name' => 'audio',
					'type' => 'simple',
					'title' => 'HTML 5 Audio',
					'fields' => array(
					
						array(
							
							'name' => 'file',
							'title' => 'File URL',
							'desc' => 'Your .mp3 file URL.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), // SHORTCODE
			
				array(
					
					'name' => 'video',
					'type' => 'simple',
					'title' => 'Youtube, Vimeo & Dailymotion Videos',
					'fields' => array(
					
						array(
							
							'name' => 'type',
							'title' => 'Video Source',
							'desc' => 'Where are you embedding your video from?',
							'type' => 'select',
							'options' => array(
							
								'youtube',
								'vimeo',
								'dailymotion'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'video_id',
							'title' => 'Video ID',
							'desc' => 'Your Video ID. This is usually just the code of the video on the video\'s page URL.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'width',
							'title' => 'Player Width',
							'desc' => 'Width of your video player in pixels.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'height',
							'title' => 'Player Height',
							'desc' => 'Height of your video player in pixels.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), // SHORTCODE
			
			)
		
		), // TYPE AUDIO & VIDEO
		
		array(
		
			'title' => 'Buttons',
			'shortcodes' => array(
			
				array(
				
					'name' => 'button',
					'type' => 'wrapped',
					'title' => 'Normal Button',
					'fields' => array(
					
						array(
							
							'name' => 'link',
							'title' => 'Button Link',
							'desc' => 'URL your button will point to.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'wrapped',
							'title' => 'Button Text',
							'desc' => 'Text of your button.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'color',
							'title' => 'Color',
							'desc' => 'Color of your button. Leave default to use theme\'s default color.',
							'type' => 'select',
							'options' => array(
							
								'default',
								'grey',
								'blue',
								'light-blue',
								'deep-blue',
								'red',
								'deep-red',
								'pink',
								'yellow',
								'orange',
								'light-orange',
								'light-pink',
								'hot-pink',
								'green',
								'deep-green',
								'green',
								'cream',
								'chocolate',
								'brown',
								'black',
								'aqua',
								'gold',
								'white'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'type',
							'title' => '',
							'desc' => 'URL your button will point to.',
							'type' => 'hidden',
							'value' => 'normal',
						
						), // FIELD
					
						array(
							
							'name' => 'target',
							'title' => 'Target',
							'desc' => 'Target attribute of your button.<br>_blank - Opens in a new window.',
							'type' => 'select',
							'options' => array(
							
								'_self',
								'_blank'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'size',
							'title' => 'Size',
							'desc' => 'Size of your button',
							'type' => 'select',
							'options' => array(
							
								'small',
								'medium',
								'big'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'title',
							'title' => 'Title',
							'desc' => 'The title attribute of your button. Useful for SEO purposes.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'class',
							'title' => 'Class (Advanced)',
							'desc' => 'Add a custom class to your button',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'id',
							'title' => 'Custom ID',
							'desc' => 'Add a custom ID to your button (Advanced)',
							'type' => 'text',
						
						), // FIELD
					
					), //FIELDS
				
				), // SHORTCODE
			
				array(
				
					'name' => 'button',
					'type' => 'simple',
					'title' => 'Big Button',
					'fields' => array(
					
						array(
							
							'name' => 'link',
							'title' => 'Button Link',
							'desc' => 'URL your button will point to.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'wrapped',
							'title' => 'Button Text',
							'desc' => 'Text of your button.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'description',
							'title' => 'Description',
							'desc' => 'Description of your button. The text that goes under the Button Text.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'color',
							'title' => 'Color',
							'desc' => 'Color of your button. Leave default to use theme\'s default color.',
							'type' => 'select',
							'options' => array(
							
								'default',
								'grey',
								'blue',
								'light-blue',
								'deep-blue',
								'red',
								'deep-red',
								'pink',
								'yellow',
								'orange',
								'light-orange',
								'light-pink',
								'hot-pink',
								'green',
								'deep-green',
								'green',
								'cream',
								'chocolate',
								'brown',
								'black',
								'aqua',
								'gold',
								'white'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'type',
							'title' => '',
							'desc' => 'URL your button will point to.',
							'type' => 'hidden',
							'value' => 'big',
						
						), // FIELD
					
						array(
							
							'name' => 'target',
							'title' => 'Target',
							'desc' => 'Target attribute of your button.<br>_blank - Opens in a new window.',
							'type' => 'select',
							'options' => array(
							
								'_self',
								'_blank'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'size',
							'title' => 'Size',
							'desc' => 'Size of your button',
							'type' => 'select',
							'options' => array(
							
								'small',
								'medium',
								'big'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'title',
							'title' => 'Title',
							'desc' => 'The title attribute of your button. Useful for SEO purposes.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'class',
							'title' => 'Class (Advanced)',
							'desc' => 'Add a custom class to your button',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'id',
							'title' => 'Custom ID',
							'desc' => 'Add a custom ID to your button (Advanced)',
							'type' => 'text',
						
						), // FIELD
					
					), //FIELDS
				
				), // SHORTCODE
			
			)
		
		), // BUTTONS
		
		array(
		
			'title' => 'Blockquotes & Pullquotes',
			'shortcodes' => array(
			
				array(
				
					'name' => 'slogan_slider',
					'type' => 'wrapped',
					'title' => 'Slogan Slider - Wrapper',
					'fields' => array(
					
						array(
							
							'desc' => 'This is just the wrapper of the shortcode. Please insert Slogan Slider Items inside this wrapper after you create it.',
							'type' => 'info',
						
						), // FIELD
					
						array(
							
							'name' => 'delay',
							'title' => 'Autoslide Delay',
							'desc' => 'Autoslide delay in miliseconds. Leave blank to not autoslide.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), //shortcode
			
				array(
				
					'name' => 'slogan_slide',
					'type' => 'wrapped',
					'title' => 'Slogan Slider Item',
					'fields' => array(
					
						array(
							
							'desc' => 'This is a single slogan slide. Make sure this shortcode is inserted within the Slogan Slider - Wrapper',
							'type' => 'info',
						
						), // FIELD
					
						array(
							
							'name' => 'wrapped',
							'title' => 'Slide Content',
							'desc' => 'Content of your slide. Accepts other shortcodes.',
							'type' => 'textarea',
						
						), // FIELD
					
					),
				
				), //shortcode
			
				array(
				
					'name' => 'blockquote',
					'type' => 'wrapped',
					'title' => 'Blockquote',
					'fields' => array(
					
						array(
							
							'name' => 'style',
							'title' => 'Style',
							'desc' => 'Your Blockquote Style',
							'type' => 'select',
							'options' => array(
							
								'quote',
								'quote2',
								'quote3',
								'box',
								'box2'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'author',
							'title' => 'Author',
							'desc' => '(optional) Insert an author for your quote.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'wrapped',
							'title' => 'Text',
							'desc' => 'Your blockquote text',
							'type' => 'textarea',
						
						), // FIELD
					
					),
				
				), //shortcode
			
				array(
				
					'name' => 'pullquote',
					'type' => 'wrapped',
					'title' => 'Pullquote',
					'fields' => array(
					
						array(
							
							'name' => 'style',
							'title' => 'Style',
							'desc' => 'Your pullquote Style',
							'type' => 'select',
							'options' => array(
							
								'quote',
								'quote2',
								'quote3',
								'box',
								'box2'
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'author',
							'title' => 'Author',
							'desc' => '(optional) Insert an author for your quote.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'wrapped',
							'title' => 'Text',
							'desc' => 'Your pullquote text',
							'type' => 'textarea',
						
						), // FIELD
					
						array(
							
							'name' => 'side',
							'title' => 'Pullquote Side',
							'desc' => 'Side of your pullquote',
							'type' => 'select',
							'options' => array(
							
								'left',
								'right',
							
							),
						
						), // FIELD
					
					),
				
				), //shortcode
			
			),
		
		), // BLOCK & PULLQUOTES
		
		array(
		
			'title' => 'Contact Form',
			'shortcodes' => array(
				
				array(
				
					'name' => 'contact_form',
					'title' => 'Contact Form',
					'type' => 'wrapped',
					'fields' => array(
					
						array(
							
							'name' => 'to',
							'title' => 'Email address',
							'desc' => 'Email adress the message will be sent to',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'wrapped',
							'title' => 'Thank You Message',
							'desc' => 'Thankyou message once the message is sent. Accepts shortcodes and HTML',
							'type' => 'textarea',
						
						), // FIELD
					
					)
				
				), // SHORTCODE - CONTAC FORM
			
			),
		
		), // CONTACT FORM
		
		array(
		
			'title' => 'Columns',
			'shortcodes' => array(
				
				array(
				
					'name' => 'column',
					'title' => 'Column',
					'type' => 'wrapped',
					'fields' => array(
					
						array(
							
							'name' => 'size',
							'title' => 'Column Size',
							'desc' => 'Size of your column. Refer to the live preview of columns for further information.',
							'type' => 'select',
							'options' => array(
							
								'one-half',
								'one-third',
								'two-thirds',
								'one-fourth',
								'three-fourths',
								'one-fifth',
								'two-fifths',
								'three-fifths',
								'four-fifths',
								'one-sixth',
								'five-sixths',
								'one-seventh',
								'two-sevenths',
								'three-sevenths',
								'four-sevenths',
								'five-sevenths',
								'six-sevenths',
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'wrapped',
							'title' => 'Content',
							'desc' => 'Your column content.',
							'type' => 'textarea',
						
						), // FIELD
					
						array(
							
							'name' => 'last',
							'title' => 'Last Column?',
							'desc' => 'If this is your last column of your group of columns, check the box to prevent margin from being added in the last column.',
							'type' => 'check',
							'value' => 'true',
						
						), // FIELD
					
					)
				
				), // SHORTCODE - COLUMN
			
			)
		
		), // COLUMNS
		
		array(
		
			'title' => 'Formatting & Advanced',
			'shortcodes' => array(
			
				array(
				
					'type' => 'simple',
					'name' => 'padding',
					'title' => 'Spacing',
					'fields' => array(
					
						array(
							
							'name' => 'size',
							'title' => 'Spacing Size',
							'desc' => 'Height in pixels of your spacing.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), // SHORTCODE
			
				array(
				
					'type' => 'simple',
					'name' => 'divider_top',
					'title' => 'Divider',
					'fields' => array(
					
						array(
							
							'name' => 'text',
							'title' => 'Go to Top Text',
							'desc' => 'Your go to top text. Leave blank to not show.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), // SHORTCODE
			
				array(
				
					'type' => 'wrapped',
					'name' => 'image_preload',
					'title' => 'Image Preloader',
					'fields' => array(
					
						array(
							
							'name' => 'wrapped',
							'title' => 'Image URL',
							'desc' => 'Your image URL to be preloaded.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'width',
							'title' => 'Image Width',
							'desc' => 'Your image width in pixels.',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'height',
							'title' => 'Image Height',
							'desc' => 'Your image height in pixels.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), // SHORTCODE
			
				array(
				
					'type' => 'wrapped',
					'name' => 'lightbox',
					'title' => 'Lightbox',
					'fields' => array(
					
						array(
							
							'name' => 'link',
							'title' => 'Lightbox Link',
							'desc' => 'URL that lightbox will open. Accepts images, videos, youtube and vimeo',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'id',
							'title' => 'Gallery ID',
							'desc' => 'Insert an unique gallery ID to display lighbox as an image gallery.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), // SHORTCODE
			
			),
		
		), // FORMATTING & ADVANCED
		
		array(
		
			'title' => 'Headers',
			'shortcodes' => array(
			
				array(
				
					'type' => 'wrapped',
					'name' => 'header',
					'title' => 'Fancy Header',
					'fields' => array(
					
						array(
							
							'name' => 'type',
							'title' => 'Header Size',
							'desc' => 'What size of header.',
							'type' => 'select',
							'options' => array(
							
								'h6',
								'h5',
								'h4',
								'h3',
								'h2',
								'h1',
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'style',
							'title' => 'Style',
							'desc' => 'Style of your header',
							'type' => 'select',
							'options' => array(
							
								'divider',
								'divider2',
								'divider3',
								'fancy1',
								'fancy2',
								'fancy3',
								'fancy4',
								'fancy5',
								'fancy6',
							
							),
						
						), // FIELD
						
						array(
						
							'type' => 'text',
							'name' => 'wrapped',
							'title' => 'Header Text',
							'desc' => 'Text of your header',
						
						),
						
						array(
						
							'type' => 'select',
							'name' => 'text_align',
							'title' => 'Text Alignment',
							'desc' => 'Align your header left, right or center',
							'options' => array(
							
								'left',
								'center',
								'right'
							
							),
						
						)
					
					),
				
				), // SHORTCODE
			
				array(
				
					'type' => 'wrapped',
					'name' => 'header',
					'title' => 'Colored Header',
					'fields' => array(
					
						array(
							
							'name' => 'type',
							'title' => 'Header Size',
							'desc' => 'What size of header.',
							'type' => 'select',
							'options' => array(
							
								'h6',
								'h5',
								'h4',
								'h3',
								'h2',
								'h1',
							
							),
						
						), // FIELD
					
						array(
							
							'name' => 'color',
							'title' => 'Color',
							'desc' => 'Color of your button. Leave default to use theme\'s default color.',
							'type' => 'select',
							'options' => array(
							
								'colored grey',
								'colored blue',
								'colored light-blue',
								'colored deep-blue',
								'colored red',
								'colored deep-red',
								'colored pink',
								'colored yellow',
								'colored orange',
								'colored light-orange',
								'colored light-pink',
								'colored hot-pink',
								'colored green',
								'colored deep-green',
								'colored green',
								'colored cream',
								'colored chocolate',
								'colored brown',
								'colored black',
								'colored aqua',
								'colored gold',
								'colored white'
							
							),
						
						), // FIELD
						
						array(
						
							'type' => 'text',
							'name' => 'wrapped',
							'title' => 'Header Text',
							'desc' => 'Text of your header',
						
						),
						
						array(
						
							'type' => 'select',
							'name' => 'text_align',
							'title' => 'Text Alignment',
							'desc' => 'Align your header left, right or center',
							'options' => array(
							
								'left',
								'center',
								'right'
							
							),
						
						)
					
					),
				
				), // SHORTCODE
			
			),
		
		), // HEADERS
		
		array(
		
			'title' => 'Icons',
			'shortcodes' => array(
			
				array(
					
					'name' => 'font_icon',
					'type' => 'simple',
					'title' => 'Icon',
					'fields' => array(
					
						array(
							
							'name' => 'type',
							'title' => 'Icon Type:',
							'desc' => 'Which icon to display',
							'type' => 'icons',
							'options' => array( 
							
								'plus','minus','left','up','right','down','home','pause','fast-fw','fast-bw','to-end','to-start','stop','up-dir','play','right-dir','down-dir','left-dir','cloud','umbrella','star','star-empty-1','check','left-hand','up-hand','right-hand','down-hand','th-list','heart-empty','heart','music','th','flag','cog','attention','flash','cog-alt','scissors','flight','mail','edit','pencil','ok','ok-circle','cancel','cancel-circle','asterisk','attention-circle','plus-circle','minus-circle','forward','ccw','cw','resize-vertical','resize-horizontal','eject','star-half','ok-circle2','cancel-circle2','help-circle','info-circle','th-large','eye','eye-off','tag','tags','camera-alt','export','print','retweet','comment','chat','location-1','trash','basket','login','logout','resize-full','resize-small','zoom-in','zoom-out','down-circle2','up-circle2','down-open','left-open','right-open','up-open','arrows-cw','play-circle2','to-end-alt','to-start-alt','inbox','font','bold','italic','text-height','text-width','align-left','align-center','align-right','align-justify','list','indent-left','indent-right','off','road','list-alt','qrcode','barcode','ajust','tint','magnet','baseball','basketball','location','move','link-ext','check-empty','bookmark-empty','phone-squared','twitter','facebook-1','github-circled','rss','hdd','certificate','left-circled','right-circled','up-circled','down-circled','tasks','filter','resize-full-alt','beaker','docs','blank','menu','list-bullet','list-numbered','strike','underline','table','magic','pinterest-circled','pinterest-squared','gplus-squared','gplus','money','columns','sort','sort-down','sort-up','mail-alt','linkedin','gauge','comment-empty','chat-empty','sitemap','paste','lightbulb','exchange','download-cloud','upload-cloud','user-md','stethoscope','suitcase','bell-alt','coffee','food','doc-alt','building','hospital','ambulance','medkit','fighter-jet','beer','h-sigh','plus-squared','angle-double-left','angle-double-right','angle-double-up','angle-double-down','angle-left','angle-right','angle-up','angle-down','desktop','laptop','tablet','mobile','circle-empty','quote-left','quote-right','spinner','circle','reply','github','folder-empty','folder-open-empty','github-squared','github-circled-1','flickr','flickr-circled','twitter-squared','vimeo','vimeo-circled','facebook-squared','twitter-1','twitter-circled','facebook','linkedin-squared','facebook-circled','facebook-squared-1','gplus-1','gplus-circled','pinterest','pinterest-circled-1','tumblr','tumblr-circled','linkedin-1','linkedin-circled','dribbble','dribbble-circled','stumbleupon','stumbleupon-circled','lastfm','lastfm-circled','rdio','rdio-circled','spotify','spotify-circled','qq','instagram','dropbox','evernote','flattr','skype','skype-circled','renren','sina-weibo','paypal','picasa','soundcloud','mixi','behance','google-circles','vkontakte','smashing','db-shape','sweden','logo-db','picture','globe','leaf','lemon','glass','gift','videocam','headphones','video','target','award','thumbs-up','thumbs-down','bag','user','users-1','credit-card','briefcase','floppy','folder','folder-open','doc','calendar','chart-bar','pin','attach','book','phone','megaphone','upload','download','signal','camera','shuffle','volume-off','volume-down','volume-up','search','key','lock','lock-open','bell','bookmark','link','fire','wrench','hammer','clock','truck','block',
							
							)
						
						), // FIELD
					
						array(
							
							'name' => 'color',
							'title' => 'Icon Color',
							'desc' => 'Icon color HEX code (format #FFFFFF)',
							'type' => 'text',
						
						), // FIELD
					
						array(
							
							'name' => 'size',
							'title' => 'Icon Size',
							'desc' => 'Size of your icon in pixels. Numer only.',
							'type' => 'text',
						
						), // FIELD
					
					),
				
				), // SHORTCODE
			
			)
		
		), // TYPE AUDIO & VIDEO
		
		array(
		
			'title' => 'jQuery Toggles',
			'shortcodes' => array(
			
				array(
				
					'name' => 'toggle',
					'title' => 'Normal Toggle',
					'type' => 'wrapped',
					'fields' => array(
					
						array(
							
							'name' => 'color',
							'title' => 'Color',
							'desc' => 'Color of your toggle.',
							'type' => 'select',
							'options' => array(
							
								'grey',
								'blue',
								'light-blue',
								'deep-blue',
								'red',
								'deep-red',
								'pink',
								'yellow',
								'orange',
								'light-orange',
								'light-pink',
								'hot-pink',
								'green',
								'deep-green',
								'green',
								'cream',
								'chocolate',
								'brown',
								'black',
								'aqua',
								'gold',
								'white'
							
							),
						
						), // FIELD
						
						array(
						
							'type' => 'text',
							'name' => 'title',
							'title' => 'Toggle Title',
							'desc' => 'Title of your toggle',
						
						), // FIELD
						
						array(
						
							'type' => 'textarea',
							'name' => 'wrapped',
							'title' => 'Toggle Content',
							'desc' => 'Content of your toggle',
						
						), // FIELD
						
						array(
						
							'type' => 'select',
							'name' => 'initial',
							'title' => 'Toggle Initial Status',
							'desc' => 'Whether it shows opened or closed',
							'options' => array(
							
								'closed',
								'open'
							
							),
						
						), // FIELD
						
						array(
						
							'type' => 'text',
							'name' => 'id',
							'title' => 'ID',
							'desc' => 'Your toggle ID. Select an unique ID to give it an accordion effect.',
						
						), // FIELD
					
					),
				
				),// SHORTCODES
			
				array(
				
					'name' => 'toggle',
					'title' => 'Boxed Toggle',
					'type' => 'wrapped',
					'fields' => array(
					
						array(
							
							'name' => 'color',
							'title' => 'Color',
							'desc' => 'Color of your toggle.',
							'type' => 'select',
							'options' => array(
							
								'grey',
								'blue',
								'light-blue',
								'deep-blue',
								'red',
								'deep-red',
								'pink',
								'yellow',
								'orange',
								'light-orange',
								'light-pink',
								'hot-pink',
								'green',
								'deep-green',
								'green',
								'cream',
								'chocolate',
								'brown',
								'black',
								'aqua',
								'gold',
								'white'
							
							),
						
						), // FIELD
						
						array(
						
							'type' => 'text',
							'name' => 'title',
							'title' => 'Toggle Title',
							'desc' => 'Title of your toggle',
						
						), // FIELD
						
						array(
						
							'type' => 'hidden',
							'name' => 'type',
							'value' => 'boxed',
						
						), // FIELD
						
						array(
						
							'type' => 'textarea',
							'name' => 'wrapped',
							'title' => 'Toggle Content',
							'desc' => 'Content of your toggle',
						
						), // FIELD
						
						array(
						
							'type' => 'select',
							'name' => 'initial',
							'title' => 'Toggle Initial Status',
							'desc' => 'Whether it shows opened or closed',
							'options' => array(
							
								'closed',
								'open'
							
							),
						
						), // FIELD
						
						array(
						
							'type' => 'text',
							'name' => 'id',
							'title' => 'ID',
							'desc' => 'Your toggle ID. Select an unique ID to give it an accordion effect.',
						
						), // FIELD
					
					),
				
				),// SHORTCODES
			
			),
		
		), // TOGGLES
		
		array(
		
			'title' => 'jQuery Image Slider',
			'shortcodes' => array(
			
				array(
				
					'name' => 'image_slider',
					'title' => 'With Thumbnails — Wrapper',
					'type' => 'wrapped',
					'fields' => array(
					
						array(
						
							'type' => 'text',
							'name' => 'autoslide',
							'title' => 'Slide Delay',
							'desc' => 'Time in miliseconds to play the next slide',
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'width',
							'title' => 'Width',
							'desc' => 'Width in pixels of your slider',
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'height',
							'title' => 'Height',
							'desc' => 'Height in pixels of your slider',
						
						), // FIELD
					
						array(
						
							'type' => 'hidden',
							'name' => 'selector',
							'value' => 'true',
						
						), // FIELD
					
					)
				
				), // SHORTCODE
			
				array(
				
					'name' => 'image_slider',
					'title' => 'No Thumbnails — Wrapper',
					'type' => 'wrapped',
					'fields' => array(
					
						array(
						
							'type' => 'text',
							'name' => 'autoslide',
							'title' => 'Slide Delay',
							'desc' => 'Time in miliseconds to play the next slide',
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'width',
							'title' => 'Width',
							'desc' => 'Width in pixels of your slider',
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'height',
							'title' => 'Height',
							'desc' => 'Height in pixels of your slider',
						
						), // FIELD
					
						array(
						
							'type' => 'hidden',
							'name' => 'selector',
							'value' => 'false',
						
						), // FIELD
					
					)
				
				), // SHORTCODE
			
				array(
				
					'name' => 'slide_item',
					'title' => 'Slide Item',
					'type' => 'wrapped',
					'fields' => array(
					
						array(
						
							'type' => 'text',
							'name' => 'wrapped',
							'title' => 'Image URL',
							'desc' => 'Your Image URL.',
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'title',
							'title' => 'Image Title',
							'desc' => 'Your Image Title',
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'description',
							'title' => 'Description',
							'desc' => 'Image description here. Shows below title',
						
						), // FIELD
					
						array(
						
							'type' => 'select',
							'name' => 'type',
							'title' => 'Link Type',
							'desc' => 'Whether to show link as link or open in lightbox',
							'options' => array(
							
								'lightbox',
								'link'
							
							),
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'link',
							'title' => 'Link',
							'desc' => 'Where your slide will lead upon clicking',
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'width',
							'title' => 'Width',
							'desc' => 'Width in pixels of your Image. For Cropping',
						
						), // FIELD
					
						array(
						
							'type' => 'text',
							'name' => 'height',
							'title' => 'Height',
							'desc' => 'Height in pixels of your Image. For Cropping',
						
						), // FIELD
					
					)
				
				), // SHORTCODE
			
			),
		
		), // IMAGE SLIDER
		
		array(
		
			'title' => 'Image Frames',
			'shortcodes' => array(
			
				array(
				
					'name' => 'image_frame',
					'type' => 'wrapped',
					'title' => 'Image Frame',
					'fields' => array(
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Style',
							'desc' => 'Style of your frame',
							'options' => array(
							
								'1',
								'2',
								'3',
								'4'
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'wrapped',
							'type' => 'text',
							'title' => 'Image URL',
							'desc' => 'Your Image to be framed.',
							'image' => 'true',
						
						), // FIELD
					
						array(
						
							'name' => 'width',
							'type' => 'text',
							'title' => 'Width',
							'desc' => 'Your image width',
						
						), // FIELD
					
						array(
						
							'name' => 'height',
							'type' => 'text',
							'title' => 'Height',
							'desc' => 'Your image height',
						
						), // FIELD
					
						array(
						
							'name' => 'caption',
							'type' => 'text',
							'title' => 'Caption',
							'desc' => 'Your image caption. Leave blank to not show.',
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'image_frame',
					'type' => 'wrapped',
					'title' => 'Aligned - Image Frame',
					'fields' => array(
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Style',
							'desc' => 'Style of your frame',
							'options' => array(
							
								'1',
								'2',
								'3',
								'4'
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'wrapped',
							'type' => 'text',
							'title' => 'Image URL',
							'desc' => 'Your Image to be framed.',
							'image' => 'true',
						
						), // FIELD
					
						array(
						
							'name' => 'align',
							'type' => 'select',
							'title' => 'Align Image',
							'desc' => 'Align your image left/right',
							'options' => array(
							
								'left',
								'right'
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'width',
							'type' => 'text',
							'title' => 'Width',
							'desc' => 'Your image width',
						
						), // FIELD
					
						array(
						
							'name' => 'height',
							'type' => 'text',
							'title' => 'Height',
							'desc' => 'Your image height',
						
						), // FIELD
					
						array(
						
							'name' => 'caption',
							'type' => 'text',
							'title' => 'Caption',
							'desc' => 'Your image caption. Leave blank to not show.',
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
			),
		
		), //
		
		array(
		
			'title' => 'Image Gallery',
			'shortcodes' => array(
			
				array(
				
					'name' => 'image_gallery',
					'type' => 'simple',
					'title' => 'WP Gallery - Image Gallery',
					'fields' => array(
					
						array(
						
							'type' => 'info',
							'desc' => 'In order to show image from your WP Gallery, you must have images on your page gallery. Just upload new images using the WP Image uploader and they are automatically added to your gallery.',
						
						), // FIELD
					
						array(
						
							'name' => 'type',
							'type' => 'hidden',
							'value' => 'wp_gallery',
						
						), // FIELD
					
						array(
						
							'name' => 'count',
							'type' => 'text',
							'title' => 'Number of Images',
							'desc' => 'Maximum number of images to show on your gallery',
						
						), // FIELD
					
						array(
						
							'name' => 'full_size',
							'type' => 'text',
							'title' => 'Big Image Size',
							'desc' => 'Dimensions of your large image. Use the format WIDTHxHEIGHT.<br>i.e: 260x260',
						
						), // FIELD
					
						array(
						
							'name' => 'thumbs',
							'type' => 'text',
							'title' => 'Thumbnails Size',
							'desc' => 'Dimensions of your thumbnails. Use the format WIDTHxHEIGHT.<br>i.e: 62x62',
						
						), // FIELD
					
						array(
						
							'name' => 'thumb_columns',
							'type' => 'text',
							'title' => 'Number of thumbnails columns',
							'desc' => 'Number of columns of thumbnails. i.e: 3',
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'image_gallery',
					'type' => 'simple',
					'title' => 'Portfolio - Image Gallery',
					'fields' => array(
					
						array(
						
							'type' => 'info',
							'desc' => 'This image gallery will fetch images from your portfolio posts.',
						
						), // FIELD
					
						array(
						
							'name' => 'type',
							'type' => 'hidden',
							'value' => 'portfolio',
						
						), // FIELD
					
						array(
						
							'name' => 'count',
							'type' => 'text',
							'title' => 'Number of Images',
							'desc' => 'Maximum number of images to show on your gallery',
						
						), // FIELD
					
						array(
						
							'name' => 'full_size',
							'type' => 'text',
							'title' => 'Big Image Size',
							'desc' => 'Dimensions of your large image. Use the format WIDTHxHEIGHT.<br>i.e: 260x260',
						
						), // FIELD
					
						array(
						
							'name' => 'thumbs',
							'type' => 'text',
							'title' => 'Thumbnails Size',
							'desc' => 'Dimensions of your thumbnails. Use the format WIDTHxHEIGHT.<br>i.e: 62x62',
						
						), // FIELD
					
						array(
						
							'name' => 'thumb_columns',
							'type' => 'text',
							'title' => 'Number of thumbnails columns',
							'desc' => 'Number of columns of thumbnails. i.e: 3',
						
						), // FIELD
					
						array(
						
							'name' => 'cat',
							'type' => 'portfolio_cats',
							'title' => 'Portfolio Category',
							'desc' => 'Portfolio category to fetch images from',
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
			),
		
		), //
		
		array(
		
			'title' => 'Image Hovers',
			'shortcodes' => array(
			
				array(
				
					'name' => 'image_hover',
					'type' => 'wrapped',
					'title' => 'Simple Hover',
					'fields' => array(
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Hover Style',
							'desc' => 'Select your hover style',
							'options' => array(
							
								'zoom',
								'go',
								'link',
								'audio',
								'mail',
								'facebook',
								'doc',
								'mail',
							
							),
						
						), // FIELD
						
						array(
						
							'name' => 'wrapped',
							'type' => 'text',
							'title' => 'Image URL',
							'desc' => 'Your image that will take the hover.',
							'image' => 'true',
						
						), // FIELD
						
						array(
						
							'name' => 'icon',
							'type' => 'text',
							'title' => 'Custom Hover Image',
							'desc' => 'You can insert your own icon here. Overrides Style.',
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'image_hover',
					'type' => 'wrapped',
					'title' => 'Aligned Hover',
					'fields' => array(
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Hover Style',
							'desc' => 'Select your hover style',
							'options' => array(
							
								'zoom',
								'go',
								'link',
								'audio',
								'mail',
								'facebook',
								'doc',
								'mail',
							
							),
						
						), // FIELD
						
						array(
						
							'name' => 'wrapped',
							'type' => 'text',
							'title' => 'Image URL',
							'desc' => 'Your image that will take the hover.',
							'image' => 'true',
						
						), // FIELD
						
						array(
						
							'name' => 'icon',
							'type' => 'text',
							'title' => 'Custom Hover Image',
							'desc' => 'You can insert your own icon here. Overrides Style.',
						
						), // FIELD
						
						array(
						
							'name' => 'align',
							'type' => 'select',
							'title' => 'Align',
							'desc' => 'Align left or right',
							'options' => array(
							
								'left',
								'right'
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
			),
		
		), //
		
		array(
		
			'title' => 'Spots',
			'shortcodes' => array(
			
				array(
				
					'name' => 'show_spots',
					'type' => 'simple',
					'title' => 'Show Spots',
					'fields' => array(
					
						array(
							
							'name' => 'featured',
							'title' => 'Show Featured Only',
							'desc' => 'Whether to show featured-only spots.',
							'type' => 'select',
							'options' => array(
							
								'false',
								'true',
							
							),
						
						),
					
						array(
							
							'name' => 'category',
							'title' => 'Spots from this category',
							'desc' => 'Fetch spots from this category',
							'type' => 'taxonomy',
							'taxonomy' => 'spot_cats',
						
						),
					
						array(
							
							'name' => 'count',
							'title' => 'Number of spots to show',
							'desc' => 'How many spots to show',
							'type' => 'text',
						
						),
					
						array(
							
							'name' => 'columns',
							'title' => 'Column sizes',
							'desc' => 'Size of the columns to display the spots',
							'type' => 'select',
							'options' => array(
							
								'one',
								'one-half',
								'one-third',
								'one-fourth',
								'one-fifth',
								'one-sixth',
							
							),
						
						),
					
						array(
							
							'name' => 'slider',
							'title' => 'Horizontal Slider',
							'desc' => 'Instead of stacking spots on top of each other, this includes a resposive horizontal slider',
							'type' => 'select',
							'options' => array(
							
								'true',
								'false'
							
							),
						
						),
					
						array(
							
							'name' => 'show_cats',
							'title' => 'Display Categories',
							'desc' => 'Displays categories on your spots',
							'type' => 'select',
							'options' => array(
							
								'true',
								'false'
							
							),
						
						),
					
						array(
							
							'name' => 'thumbnails',
							'title' => 'Display thumbnails',
							'desc' => 'Displays thumbnails on your spots',
							'type' => 'select',
							'options' => array(
							
								'true',
								'false'
							
							),
						
						),
					
						array(
							
							'name' => 'thumb_w',
							'title' => 'Thumbnail Width',
							'desc' => 'Width of your thumbnails in pixels',
							'type' => 'text',
						
						),
					
						array(
							
							'name' => 'thumb_h',
							'title' => 'Thumbnail Height',
							'desc' => 'Height of your thumbnails in pixels',
							'type' => 'text',
						
						),
					
						array(
							
							'name' => 'excerpt',
							'title' => 'Display Excerpt',
							'desc' => 'Displays excerpt on your spots',
							'type' => 'select',
							'options' => array(
							
								'true',
								'false'
							
							),
						
						),
					
						array(
							
							'name' => 'excerpt_length',
							'title' => 'Excerpt Length',
							'desc' => 'Length of your excerpt (character count)',
							'type' => 'text',
						
						),
					
						array(
							
							'name' => 'link',
							'title' => 'Display Read More Link',
							'desc' => 'Displays read more links at the bottom of your spot',
							'type' => 'select',
							'options' => array(
							
								'true',
								'false'
							
							),
						
						),
					
						array(
							
							'name' => 'link_title',
							'title' => 'Link Title',
							'desc' => 'Title of your link',
							'type' => 'text',
						
						),
					
						array(
							
							'name' => 'orderby',
							'title' => 'Order Spots By',
							'desc' => 'How to display the order of your spots',
							'type' => 'select',
							'options' => array(
							
								'date',
								'title',
								'random'
							
							),
						
						),
					
					),
				
				)
			
			),
		
		),
		
		array(
		
			'title' => 'Notification Boxes',
			'shortcodes' => array(
			
				array(
				
					'name' => 'notification',
					'type' => 'wrapped',
					'title' => 'Notification Box',
					'fields' => array(
					
						array(
							
							'name' => 'color',
							'title' => 'Color',
							'desc' => 'Color of your notification box.',
							'type' => 'select',
							'options' => array(
							
								'grey',
								'blue',
								'light-blue',
								'deep-blue',
								'red',
								'deep-red',
								'pink',
								'yellow',
								'orange',
								'light-orange',
								'light-pink',
								'hot-pink',
								'green',
								'deep-green',
								'green',
								'cream',
								'chocolate',
								'brown',
								'black',
								'aqua',
								'gold',
								'white'
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'side',
							'type' => 'select',
							'title' => 'Align',
							'desc' => 'Align your box to the left or to the right.',
							'options' => array(
							
								'none',
								'left',
								'right'
							
							),
						
						), // FIELD
						
						array(
						
							'name' => 'wrapped',
							'type' => 'textarea',
							'title' => 'Box Content',
							'desc' => 'What goes in your notification box. Accepts shortcodes & HTML.',
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'alert_box',
					'type' => 'wrapped',
					'title' => 'Alert Box',
					'fields' => array(
					
						array(
							
							'name' => 'type',
							'title' => 'Type',
							'desc' => 'Type of your alert box.',
							'type' => 'select',
							'options' => array(
							
								'success',
								'error',
								'info',
								'attention',
								'blank',
							
							),
						
						), // FIELD
						
						array(
						
							'name' => 'wrapped',
							'type' => 'textarea',
							'title' => 'Alert Box Content',
							'desc' => 'What goes in your alert box. Accepts shortcodes & HTML.',
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
			),
		
		), //
		
		array(
		
			'title' => 'Social Media',
			'shortcodes' => array(
			
				array(
				
					'name' => 'facebook_like',
					'type' => 'simple',
					'title' => 'Facebook Like',
					'fields' => array(
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Style',
							'desc' => 'Style of your facebook like.',
							'options' => array(
							
								'standard',
								'box',
								'button'
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'tweet',
					'type' => 'simple',
					'title' => 'Tweet',
					'fields' => array(
					
						array(
						
							'name' => 'size',
							'type' => 'select',
							'title' => 'Size',
							'desc' => 'Note that if you select size "big", counter will have no effect.',
							'options' => array(
							
								'normal',
								'big',
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'counter',
							'type' => 'select',
							'title' => 'Include Counter',
							'desc' => 'If you have selected size BIG, this will have no effect',
							'options' => array(
							
								'vertical',
								'horizontal',
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'google_1',
					'type' => 'simple',
					'title' => 'Google +1',
					'fields' => array(
					
						array(
						
							'name' => 'text',
							'type' => 'select',
							'title' => 'Text Style',
							'desc' => 'Text style of your button.',
							'options' => array(
							
								'none',
								'bubble',
								'inline'
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'size',
							'type' => 'select',
							'title' => 'Size',
							'desc' => 'Sizeof your button',
							'options' => array(
							
								'small',
								'medium',
								'standard',
								'tall'
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'digg',
					'type' => 'simple',
					'title' => 'Digg',
					'fields' => array(
					
						array(
						
							'name' => 'size',
							'type' => 'select',
							'title' => 'Size',
							'desc' => 'Size of your button.',
							'options' => array(
							
								'compact',
								'wide',
								'medium',
								'icon',
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'linkedin',
					'type' => 'simple',
					'title' => 'LinkedIn',
					'fields' => array(
					
						array(
						
							'name' => 'counter',
							'type' => 'select',
							'title' => 'Counter',
							'desc' => 'Show counter.',
							'options' => array(
							
								'top',
								'right',
								'none',
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
			),
		
		), //
		
		array(
		
			'title' => 'Tabs',
			'shortcodes' => array(
			
				array(
				
					'name' => 'tabs',
					'type' => 'wrapped',
					'title' => 'Tabs – Wrapper – Step 1',
					'fields' => array(
					
						array(
						
							'type' => 'info',
							'desc' => 'This is the wrapper of your tabs. Add your tabs content on step 2.',
						
						), // FIELD
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Style',
							'desc' => 'Style of your tab',
							'options' => array(
							
								'1',
								'2',
								'3'
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'tab',
					'type' => 'wrapped',
					'title' => 'Tabs – Step 2',
					'fields' => array(
					
						array(
						
							'type' => 'info',
							'desc' => 'This is the content of your tabs. Make sure you\'ve added your wrapper already.',
						
						), // FIELD
					
						array(
						
							'name' => 'title',
							'type' => 'text',
							'title' => 'Title',
							'desc' => 'Title of your tab'
						
						), // FIELD
					
						array(
						
							'name' => 'wrapped',
							'type' => 'textarea',
							'title' => 'Content',
							'desc' => 'Content of your tab. Accepts Shortcodes & HTML'
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
			),
		
		), //
		
		array(
		
			'title' => 'Typography & Lists',
			'shortcodes' => array(
			
				array(
				
					'name' => 'dropcap',
					'type' => 'wrapped',
					'title' => 'Dropcap',
					'fields' => array(
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Style',
							'desc' => 'Style of your dropcap',
							'options' => array(
							
								'1',
								'2',
								'3',
								'4',
								'5',
								'6'
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'wrapped',
							'type' => 'text',
							'title' => 'Dropcap Letter',
							'desc' => 'Your dropcap letter'
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'icon',
					'type' => 'wrapped',
					'title' => 'Icon',
					'fields' => array(
					
						array(
						
							'name' => 'type',
							'type' => 'select',
							'title' => 'Icon Type',
							'desc' => 'Style of your Icon',
							'options' => array(
							
								'alarm',
								'auction',
								'audio',
								'back',
								'box',
								'calendar',
								'download',
								'error',
								'facebook',
								'go',
								'cross',
								'mail',
								'megaphone',
								'note',
								'pin',
								'refresh',
								'return',
								'tick',
								'trophy',
								'user',
								'zoom',
								'point-down',
								'ok',
								'config',
								'smiley',
								'dinner',
								'man',
								'alert',
								'chart',
								'help',
								'gold',
								'silver',
								'bronze',
								'save',
								'info',
								'globe',
								'store',
								'plus',
								'cone',
								'star',
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'wrapped',
							'type' => 'text',
							'title' => 'Text',
							'desc' => 'Your text that will take the icon'
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'highlight',
					'type' => 'wrapped',
					'title' => 'Highlight',
					'fields' => array(
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Style',
							'desc' => 'Style of your highlight',
							'options' => array(
							
								'1',
								'2',
								'3',
							
							),
						
						), // FIELD
					
						array(
						
							'name' => 'wrapped',
							'type' => 'text',
							'title' => 'Highlighted Text',
							'desc' => 'Your highlighted text'
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'list',
					'type' => 'wrapped',
					'title' => 'List',
					'fields' => array(
					
						array(
						
							'type' => 'info',
							'desc' => 'Note that this is just your wrapper. Insert &lt;li> tags insie your wrapper to use the shortcode.'
						
						), // FIELD
					
						array(
						
							'name' => 'style',
							'type' => 'select',
							'title' => 'Color',
							'desc' => 'Color of your list',
							'options' => array(
							
								'standard',
								'blue',
								'grey',
								'dark',
								'green',
								'yellow',
								'purple',
								'arrow',
								'tick',
								'grey-tick',
								'balloon',
								'warning',
								'star',
								'grey-star',
								'error',
								'grey-error',
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
			),
		
		), //
		
		array(
		
			'title' => 'Widgets',
			'shortcodes' => array(
			
				array(
				
					'name' => 'blog_widget',
					'type' => 'simple',
					'title' => 'Blog Widget',
					'fields' => array(
					
						array(
						
							'name' => 'count',
							'type' => 'text',
							'title' => 'Number of Posts',
							'desc' => 'Number of posts to display',
						
						), // FIELD
						
						array(
						
							'name' => 'columns',
							'type' => 'text',
							'title' => 'Number of Columns',
							'desc' => 'Number of columns.',
						
						), // FIELD
						
						array(
						
							'name' => 'width',
							'type' => 'text',
							'title' => 'Width',
							'desc' => 'Width of your columns or thumbnails in pixels',
						
						), // FIELD
						
						array(
						
							'name' => 'info',
							'type' => 'check',
							'title' => 'Remove Post Info?',
							'desc' => 'Remove post info? (date and comment number)',
							'value' => 'false',
						
						), // FIELD
						
						array(
						
							'name' => 'thumbs',
							'type' => 'check',
							'title' => 'Remove Thumbnails',
							'desc' => 'Remove thumbnails?',
							'value' => 'false',
						
						), // FIELD
						
						array(
						
							'name' => 'cat',
							'type' => 'categories',
							'title' => 'Category',
							'desc' => 'Category to retrieve your posts from.',
						
						), // FIELD
						
						array(
						
							'name' => 'read_more',
							'type' => 'check',
							'title' => 'Remove Read More Button',
							'desc' => 'Remove read more button?',
							'value' => 'false',
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'flickr_widget',
					'type' => 'simple',
					'title' => 'Flickr Widget',
					'fields' => array(
					
						array(
						
							'name' => 'user',
							'type' => 'text',
							'title' => 'Flickr User ID',
							'desc' => 'Your flickr username. This is not your username, but your user ID - You can get it from <a href="http://idgettr.com/" target="_blank">here</a>'
						
						), // FIELD
					
						array(
						
							'name' => 'count',
							'type' => 'text',
							'title' => 'Number of photos',
							'desc' => 'Number of photos to retrieve'
						
						), // FIELD
					
						array(
						
							'name' => 'size',
							'type' => 'text',
							'title' => 'Thumbnail Size',
							'desc' => 'Size of your thumbnails in pixels'
						
						), // FIELD
					
						array(
						
							'name' => 'order',
							'type' => 'select',
							'title' => 'Order',
							'desc' => 'Display random or latest.',
							'options' => array(
							
								'latest',
								'random'
							
							),
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'twitter_widget',
					'type' => 'simple',
					'title' => 'Twitter Widget',
					'fields' => array(
					
						array(
						
							'name' => 'user',
							'type' => 'text',
							'title' => 'Twitter Username',
							'desc' => 'Your twitter username.'
						
						), // FIELD
					
						array(
						
							'name' => 'count',
							'type' => 'text',
							'title' => 'Number of Tweets',
							'desc' => 'Number of tweets to retrieve'
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'dribbble_widget',
					'type' => 'simple',
					'title' => 'Dribbble Widget',
					'fields' => array(
					
						array(
						
							'name' => 'user',
							'type' => 'text',
							'title' => 'Dribbble Username',
							'desc' => 'Your dribbble username.'
						
						), // FIELD
					
						array(
						
							'name' => 'count',
							'type' => 'text',
							'title' => 'Number of dribbbles',
							'desc' => 'Number of dribbbles to retrieve'
						
						), // FIELD
					
						array(
						
							'name' => 'titles',
							'type' => 'check',
							'title' => 'Remove Titles on Hover',
							'desc' => '',
							'value' => 'false',
						
						), // FIELD
					
						array(
						
							'name' => 'info',
							'type' => 'check',
							'title' => 'Remove Dribbble Info',
							'desc' => 'Removes views, comments and likes counts.',
							'value' => 'false',
						
						), // FIELD
					
						array(
						
							'name' => 'shot_width',
							'type' => 'text',
							'title' => 'Shot Width',
							'desc' => 'Width of your shots.'
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
				array(
				
					'name' => 'twitter_feed',
					'type' => 'simple',
					'title' => 'Twitter Bar',
					'fields' => array(
					
						array(
						
							'name' => 'user',
							'type' => 'text',
							'title' => 'Twitter Username',
							'desc' => 'Your twitter username.'
						
						), // FIELD
					
						array(
						
							'name' => 'count',
							'type' => 'text',
							'title' => 'Number of tweets',
							'desc' => 'Number of tweets to retrieve'
						
						), // FIELD
					
						array(
						
							'name' => 'delay',
							'type' => 'text',
							'title' => 'Delay',
							'desc' => 'Delay between each tweet.'
						
						), // FIELD
					
					),
				
				), //SHORTCODE
			
			),
		
		), //
	
	);

?>