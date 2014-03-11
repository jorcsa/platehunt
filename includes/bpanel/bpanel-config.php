<?php

	//Configuration variables. Edit these
	$ddpConf = array(
		
		'panel_version' => 'bPanel v2.0',
		'theme_name' => 'SpotFinder',
		'theme_version' => '1.35.5'
	
	);
	
$myOpts = array(

	array(

		'title' => 'Header Options',
		'icon' => 'config.png',
		'tabs' => array(
			
			array(
				
				'title' => 'Logo',
				'info' => 'These options will affect your logo',
				'fields' => array(
					
					array(
					
						'type' => 'image',
						'name' => 'logo',
						'title' => 'Your Logo',
						'default' => get_template_directory_uri().'/images/logo.png',
						'desc' => 'Your logo'
					
					),
					
					array(
					
						'type' => 'image',
						'name' => 'logo2x',
						'title' => 'Your Logo @2x',
						'default' => get_template_directory_uri().'/images/logo@2x.png',
						'desc' => 'Your logo twice the size for retina displays'
					
					)
				
				)
			
			), //TOP Bar Tab
			
			array(
			
				'title' => 'Social Icons',
				'info' => 'Social Icons on your top bar',
				'fields' => array(
				
					array(
					
						'name' => 'social_icons',
						'type' => 'check',
						'title' => 'Enable Social Icons',
						'default' => 'on',
						'desc' => 'Toggle display of social icons in header',
					
					),
				
					array(
					
						'name' => 'social_icons_alt',
						'type' => 'textarea',
						'title' => 'Social Icons HTML',
						'default' => '',
						'desc' => 'Insert your own HTML in the social Icons area',
					
					),
				
					array(
					
						'name' => 'social_facebook',
						'type' => 'text',
						'title' => 'Facebook Link',
						'default' => 'http://facebook.com/BTOAThemes',
						'desc' => 'Your social link',
					
					),
				
					array(
					
						'name' => 'social_twitter',
						'type' => 'text',
						'title' => 'Twitter Link',
						'default' => 'http://twitter.com/BTOAThemes',
						'desc' => 'Your social link',
					
					),
				
					array(
					
						'name' => 'social_vimeo',
						'type' => 'text',
						'title' => 'Vimeo Link',
						'default' => '',
						'desc' => 'Your social link',
					
					),
				
					array(
					
						'name' => 'social_google',
						'type' => 'text',
						'title' => 'Google Plus Link',
						'default' => '',
						'desc' => 'Your social link',
					
					),
				
					array(
					
						'name' => 'social_pinterest',
						'type' => 'text',
						'title' => 'Pinterest Link',
						'default' => '',
						'desc' => 'Your social link',
					
					),
				
					array(
					
						'name' => 'social_tumblr',
						'type' => 'text',
						'title' => 'Tumblr Link',
						'default' => '',
						'desc' => 'Your social link',
					
					),
				
					array(
					
						'name' => 'social_linkedin',
						'type' => 'text',
						'title' => 'LinkedIn Link',
						'default' => '',
						'desc' => 'Your social link',
					
					),
				
					array(
					
						'name' => 'social_dribbble',
						'type' => 'text',
						'title' => 'Dribbble Link',
						'default' => '',
						'desc' => 'Your social link',
					
					),
				
					array(
					
						'name' => 'social_instagram',
						'type' => 'text',
						'title' => 'Instagram Link',
						'default' => '',
						'desc' => 'Your social link',
					
					),
				
				),
			
			),
			
			array(
			
				'title' => 'Styling',
				'info' => 'Edit the style of your header',
				'fields' => array(
				
				
					array(
					
						'type' => 'check',
						'name' => 'header_sticky',
						'title' => 'Header Sticky Menu',
						'default' => '',
						'desc' => 'If toggled it will amek the header sticky.',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'header_border_color',
						'title' => 'Header Top Border Color',
						'default' => '#2b2b2b',
						'desc' => 'Color of the border at the top of your header',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'header_bg_color',
						'title' => 'Header Background Color',
						'default' => '#3d3d3b',
						'desc' => 'Color of your header background',
						'opacity' => '0.98',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'menu_link_color',
						'title' => 'Menu Link Color',
						'default' => '#cacac8',
						'desc' => 'Header Link Color',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'menu_link_color_hover',
						'title' => 'Menu Link Color - HOVER',
						'default' => '#ffffff',
						'desc' => 'Header Link Color',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'menu_link_color_active',
						'title' => 'Menu Link Color - ACTIVE',
						'default' => '#ffffff',
						'desc' => 'Header Link Color',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'menu_link_color_border_hover',
						'title' => 'Menu Link Color Border - HOVER',
						'default' => '#000000',
						'desc' => 'Header Link Color',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'menu_link_color_border_active',
						'title' => 'Menu Link Color Border - ACTIVE',
						'default' => '#da2639',
						'desc' => 'Header Link Color',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'social_icons_color',
						'title' => 'Social Icons Color',
						'default' => '#3d3d3b',
						'desc' => 'Header Link Color',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'social_icons_bg',
						'title' => 'Social Icons Background Color',
						'default' => '#ffffff',
						'desc' => 'Header Link Color',
						'opacity' => '.9',
					
					),
				
				),
			
			),
			
		),
		
	),

	array(

		'title' => 'Content Options',
		'icon' => 'config.png',
		'tabs' => array(
			
			array(
				
				'title' => 'Layout',
				'info' => 'These options will affect your content Layout',
				'fields' => array(
					
					array(
					
						'type' => 'select',
						'name' => 'sidebar_default',
						'title' => 'Default Sidebar Position',
						'default' => 'Right Side',
						'desc' => 'The default place where your sidebar is located.<br>Although you can change it when editing a page, this is good because it will set the initial state of your sidebar.',
						'options' => array(
						
							'Right Side',
							'Left Side',
							'No Sidebar (Full Width)'
						
						)
					
					),
					
					array(
					
						'type' => 'image',
						'name' => 'header_bg',
						'title' => 'Default Fancy Header Background',
						'default' => get_template_directory_uri().'/images/header_bg.jpg',
						'desc' => 'Default background for header backgrounds.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'spotfinder_rtl',
						'title' => 'Enable RTL (Right to left)',
						'default' => '',
						'desc' => 'If enabled this will show RTL text.',
					
					),
				
				)
			
			), //TOP Bar Tab
			
			array(
			
				'title' => 'General Styling',
				'info' => 'Edit the style of your header',
				'fields' => array(
				
					array(
					
						'type' => 'textarea',
						'title' => 'Custom CSS',
						'name' => 'custom_css',
						'default' => '',
						'desc' => 'Add a custom CSS to your theme',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'page_bg',
						'title' => 'Content Background',
						'default' => '#fafafa',
						'desc' => 'Background color of your content area',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'primary_color',
						'title' => 'Primary Color',
						'default' => '#da2639',
						'desc' => 'Primary Color of your theme',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'secondary_color',
						'title' => 'Secondary Color',
						'default' => '#d0d0d0',
						'desc' => 'Secondary Color of your theme',
						'opacity' => '1',
					
					)
				
				),
			
			),
			
			array(
			
				'title' => 'Forms Styling',
				'info' => 'Edit the style of your forms',
				'fields' => array(
				
					array(
					
						'type' => 'color',
						'name' => 'label_color',
						'title' => 'Labels',
						'default' => '#484544',
						'desc' => 'Color of your form labels',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'input_bg',
						'title' => 'Inputs Background',
						'default' => '#ffffff',
						'desc' => 'Background color of your inputs',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'inputs_border',
						'title' => 'Inputs Border Color',
						'default' => '#d0d0d0',
						'desc' => 'Border of your inputs',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'input_bg_focus',
						'title' => 'Inputs Background - On Focus',
						'default' => '#fafafa',
						'desc' => 'Background color of your inputs',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'inputs_border_focus',
						'title' => 'Inputs Border Color - On Focus',
						'default' => '#bbbbbb',
						'desc' => 'Border of your inputs omn focus',
						'opacity' => '1',
					
					),
				
				),
			
			),
			
			array(
			
				'title' => 'Import Options',
				'info' => 'Paste the string you generated to import your backed up options.',
				'fields' => array(
					
					array(
					
						'type' => 'import',
						'title' => 'Backup String',
						'desc' => 'Paste your past generated back up.',
					
					)
				
				)
			
			), // Import Options
			
			array (
			
				'title' => 'Custom Sidebars',
				'info' => 'Add/Remove your custom sidebars here.',
				'fields' => array(
					
					array (
					
						'type' => 'sidebars'
					
					)
				
				)
			
			), //custom sidebars tab
			
		),
		
	),

	array(

		'title' => 'Homepage Options',
		'icon' => 'home.png',
		'tabs' => array(
			
			array(
				
				'title' => 'Slider',
				'info' => 'These options will affect your homepage slider',
				'fields' => array(
					
					array(
					
						'type' => 'select',
						'name' => 'home_slider',
						'title' => 'Homepage Slider',
						'default' => 'Map',
						'desc' => 'Which Homepage slider to use',
						'options' => array(
						
							'Map',
							'Slider Revolution'
						
						),
						
					),
					
					array(
					
						'type' => 'text',
						'name' => 'home_slider_alias',
						'title' => 'Slider Alias',
						'default' => '',
						'desc' => 'type in here the alias of your slider - As created in the plugin',
					
					),
				
				)
			
			), //TOP Bar Tab
			
		)
		
	),
	
	array(
	
		'title' => 'Search Options',
		'icon' => 'search.png',
		'tabs' => array(
		
			array(
			
				'title' => 'Main Options',
				'info' => 'These will affect your search bar',
				'fields' => array(
				
					array(
					
						'type' => 'post_type',
						'post_type' => 'search_form',
						'name' => 'search_form',
						'title' => 'Search Bar',
						'default' => '',
						'desc' => 'Which search bar to use on homepage',
					
					),
				
					array(
					
						'type' => 'select',
						'name' => 'search_position',
						'title' => 'Search Bar Position',
						'default' => 'top',
						'desc' => 'Where your search bar should be placed',
						'options' => array('Top', 'Bottom'),
					
					),
				
					array(
					
						'type' => 'select',
						'name' => 'search_visibility',
						'title' => 'Initial Visibility',
						'default' => 'Show on hover',
						'desc' => 'Visibility of your search bar',
						'options' => array('Show on hover', 'Always Visible'),
					
					),
				
					array(
					
						'type' => 'pages',
						'name' => 'listing_page',
						'title' => 'Listings Page',
						'default' => '',
						'desc' => 'Set your default listing page here.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'future_notification',
						'title' => 'Enable User Notifications for Matching Submissions',
						'default' => 'on',
						'desc' => 'If enabled, this will allow users to sign up for an internal newsletter where they will get notified of future submissions matching their criteria.',
					
					)
				
				),
			
			),
		
			array(
			
				'title' => 'Listing Options',
				'info' => 'These will affect your listing page options',
				'fields' => array(
				
					array(
					
						'type' => 'select',
						'name' => 'lst_view',
						'title' => 'Initial List View',
						'default' => 'List',
						'desc' => 'Initial listing view',
						'options' => array(
						
							'List',
							'Grid'
						
						),
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'lst_logo',
						'title' => 'Disable Gallery and Use Image as Logo',
						'default' => '',
						'desc' => 'If enabled, this option will disable the gallery, and the image uploaded by users will be used as their logo. Useful for listings that do not require a gallery.',
					
					),
				
					array(
					
						'type' => 'textarea',
						'name' => 'lst_per_page',
						'title' => 'Listings per page options',
						'default' => '9
15
21',
						'desc' => 'Listings per page options. One option per line.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'lst_featured',
						'title' => 'Featured Spots always on top',
						'default' => 'on',
						'desc' => 'Whether to always display featured spots on top of listings',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'lst_excerpt',
						'title' => 'Display Excerpt',
						'default' => 'on',
						'desc' => 'Display excerpt of listings?',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'lst_excerpt_length',
						'title' => 'Excerpt Length',
						'default' => '350',
						'desc' => 'Length of your excerpt on list view.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'lst_cats',
						'title' => 'Display Categories',
						'default' => 'on',
						'desc' => 'Display the category within your listings',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'lst_search',
						'title' => 'Display Search Field Values',
						'default' => 'on',
						'desc' => 'Display search field values within your listings? Choose which ones to display in your search fields themselves',
					
					),
				
					array(
					
						'type' => 'image',
						'name' => 'placeholder',
						'title' => 'Placeholder Image',
						'default' => get_template_directory_uri().'/images/placeholder.jpg',
						'desc' => 'Placeholder for submissions without any images.',
					
					),
				
				)
				
			),
		
			array(
			
				'title' => 'Styling',
				'info' => 'These will affect your search bar\'s styling',
				'fields' => array(
				
					array(
					
						'type' => 'color',
						'name' => 'search_bg',
						'title' => 'Search Bar Background Color',
						'default' => '#484544',
						'desc' => 'Search bar opacity',
						'opacity' => '.8',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'search_color',
						'title' => 'Search Bar Text Color',
						'default' => '#ffffff',
						'desc' => 'Color of search bar elements',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'search_divider_color',
						'title' => 'Search Bar Divider Color',
						'default' => '#ffffff',
						'desc' => 'Color of search bar dividers',
						'opacity' => '.3',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'search_inputs_bg',
						'title' => 'Search Bar Inputs Background',
						'default' => '#ffffff',
						'desc' => 'Color of inputs background',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'search_inputs_color',
						'title' => 'Search Bar Inputs Color',
						'default' => '#484544',
						'desc' => 'Color of inputs text',
						'opacity' => '1',
					
					)
				
				),
			
			)
		
		),
	
	),
	
	array(
	
		'title' => 'Spots Options',
		'icon' => 'target.png',
		'tabs' => array(
		
			array(
			
				'title' => 'Main Options',
				'info' => 'These options will affect your spots',
				'fields' => array(
				
					array(
					
						'type' => 'text',
						'name' => 'spot_name',
						'title' => 'Spot Name',
						'default' => 'Spot',
						'desc' => 'You can call these anything. Be careful with exclusive wordpress names such as Post and Pages',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'spot_name_p',
						'title' => 'Spot Name - Plural',
						'default' => 'Spots',
						'desc' => 'You can call these anything.It\'s the plural form of the option above.',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'spot_slug',
						'title' => 'Spots Slug',
						'default' => 'spot',
						'desc' => 'You can call these anything. Be careful with exclusive wordpress names such as Post and Pages',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'spot_cat_slug',
						'title' => 'Spots Categories Slug',
						'default' => 'spot-type',
						'desc' => 'slug of your category pages for spots.',
					
					)
				
				),
			
			)
		
		),
	
	),
	
	array(
	
		'title' => 'Rating Options',
		'icon' => 'star.png',
		'tabs' => array(
		
			array(
			
				'title' => 'Main Settings',
				'info' => 'These options will affect the rating system in your theme',
				'fields' => array(
				
					array(
					
						'type' => 'check',
						'name' => 'rating',
						'title' => 'Enable Rating System',
						'desc' => 'If enabled, this will allow users to rate listings within your theme.',
						'default' => '',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'rating_registered',
						'title' => 'User must be registered and logged in to submit reviews',
						'desc' => 'If enabled users will have to be registeres and logged in in order to be able to submit ratings',
						'default' => '',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'rating_review',
						'title' => 'Reviews must be reviewed to be published',
						'desc' => 'If enabled ratings will not be published until an admin has approved them.',
						'default' => '',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'rating_sortby',
						'title' => 'Enable sorting of listings by rating',
						'desc' => 'If enabled users will be able to sort listings by review',
						'default' => '',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'rating_frontend',
						'title' => 'Display reviews in listings page',
						'desc' => 'If enabled reviews or ratings will be displayed under the description like comments.',
						'default' => '',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'rating_overlay',
						'title' => 'Display rating in overlays',
						'desc' => 'If enabled reviews or ratings will be displayed in your overlays.',
						'default' => '',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'rating_per_page',
						'title' => 'Reviews per page',
						'desc' => 'How many reviews per page',
						'default' => '15',
						'range' => '1,50'
					
					),
				
					array(
					
						'type' => 'image',
						'name' => 'rating_avatar',
						'title' => 'Default Avatar',
						'desc' => 'default avatar for user reviews in case they have not signed up with gravatar.',
						'default' => get_template_directory_uri().'/images/rating_default_avatar.jpg',
					
					),
				
				),
			
			),
			
			array(
			
				'title' => 'Styling',
				'info' => 'Styling of the review section',
				'fields' => array(
				
					array(
					
						'type' => 'color',
						'name' => 'rating_bg',
						'title' => 'Comment Background Color',
						'default' => '#f0f0f0',
						'desc' => 'Background color of each rating viewed in front end.',
						'opacity' => '1',	
					
					)
				
				),	
			
			),
		
		),
	
	),
	
	array(
	
		'title' => 'Map Options',
		'icon' => 'pin.png',
		'tabs' => array(
		
			array(
			
				'title' => 'Main Options',
				'info' => 'These options will affect your map',
				'fields' => array(
				
					array(
					
						'type' => 'check',
						'name' => 'map_bar',
						'title' => 'Enable Map Bar',
						'default' => 'on',
						'desc' => 'If enabled the bar at the bottom of the map will be enabled',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_overlays',
						'title' => 'Enable Map Overlays',
						'default' => 'on',
						'desc' => 'If enabled when a pin is clicked, the overlay is shown.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_featured_overlay',
						'title' => 'Enable Featured Overlays',
						'default' => 'on',
						'desc' => 'If enabled when a listing is featured, the image is shows as a pin.',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'map_zoom',
						'title' => 'Initial Zool',
						'default' => '14',
						'desc' => 'Your map\'s initial zoom. 20 being the closest and 1 the furthest',
						'range' => '1,20',
					
					),
				
					array(
					
						'type' => 'select',
						'name' => 'map_type',
						'title' => 'Map Type',
						'default' => 'ROADMAP',
						'desc' => 'Type of your map',
						'options' => array('ROADMAP', 'HYBRID', 'TERRAIN', 'SATELLITE'),
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_clustering',
						'title' => 'Enable Clustering',
						'default' => 'on',
						'desc' => 'Whether or not to enable clustering',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_auto_height',
						'title' => 'Enable Map Auto Height',
						'default' => 'on',
						'desc' => 'If enabled your map height will always be 80% of the page',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'map_height',
						'title' => 'Map Manual Height',
						'default' => '600',
						'desc' => 'If auto is disabled this is the height of your map',
						'range' => '100,1200',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_resize',
						'title' => 'Enable Map Resizing',
						'default' => 'on',
						'desc' => 'If enabled, user is able to resize his map.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_scroll',
						'title' => 'Enable Zoom with Scroll Wheel',
						'default' => '',
						'desc' => 'If enabled user will be able to zoom in and out using scroll wheel',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_zoom_controls',
						'title' => 'Enable Zoom Controls',
						'default' => 'on',
						'desc' => 'If enabled zoom in and out buttons will be available',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_directions',
						'title' => 'Enable Get Directions',
						'default' => '',
						'desc' => 'Only available if using geolocation.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_pois',
						'title' => 'Disable Business Points of Interests',
						'default' => 'on',
						'desc' => 'This removes default point of interests from your map such as local business names.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_b_w',
						'title' => 'Black & White Map',
						'default' => '',
						'desc' => 'Will desaturate the colors of your map. May work well in some layouts',
					
					),
				
					array(
					
						'type' => 'select',
						'name' => 'map_directions_travel',
						'title' => 'Directions Travelmode',
						'default' => 'DRIVING',
						'desc' => 'Only available if using geolocation and directions',
						'options' => array('DRIVING', 'BICYCLING', 'TRANSIT', 'WALKING'),
					
					),
				
				),
			
			), /// ENDS OPTIONS TAB
			
			array(
			
				'title' => 'Geolocation Options',
				'info' => 'These option swill affect geolocation options within your map',
				'fields' => array(
				
					array(
					
						'type' => 'check',
						'name' => 'map_geolocation',
						'title' => 'Enable Geolocation',
						'default' => '',
						'desc' => 'Whether or not to enable geolocation',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_geolocation_redirect_user',
						'title' => 'Redirect User To his Location',
						'default' => '',
						'desc' => 'If Checked - This will set the map in the center at the user when he enables geolocation',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_geolocation_sort',
						'title' => 'Sort By Distance',
						'default' => '',
						'desc' => 'Whether or not the user is able to sort his listings by location. ATTENTION: This may slow server processing on sites with a high volume of listings.',
					
					),
				
					array(
					
						'type' => 'select',
						'name' => 'geo_distance_type',
						'title' => 'Kilometres or Miles',
						'default' => 'Kilometres',
						'desc' => 'Please choose whether you would like to work with kilometres or Miles',
						'options' => array(
						
							'Kilometres',
							'Miles'
						
						),
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'map_initial_pos_lat',
						'title' => 'Initial Latitude Position',
						'default' => '-37.814107',
						'desc' => 'Intitial map positon - Latitude',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'map_initial_pos_lng',
						'title' => 'Initial Longitude Position',
						'default' => '144.96327999999994',
						'desc' => 'Intitial map positon - Longitude',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_radius_resizing',
						'title' => 'Enable Radius Resizing',
						'default' => '',
						'desc' => 'Whether or not to enable resizing of radius in the map',
					
					),
				
					array(
					
						'type' => 'image',
						'name' => 'map_radius_resizing_icon_',
						'title' => 'Resizing Icon',
						'default' => get_template_directory_uri().'/images/pins/resizing/pink.png',
						'desc' => 'Whether or not to enable resizing of radius in the map (40px x 40px) @ 2x',
					
					),
				
				),
			
			),
			
			array(
			
				'title' => 'Styling',
				'info' => 'This will affect the styling of your overlays etc.',
				'fields' => array(
				
					array(
					
						'type' => 'color',
						'name' => 'map_overlay_bg',
						'title' => 'Overlays Background Color',
						'default' => '#484544',
						'desc' => 'Background color of your map overlays.',
						'opacity' => '.97',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'map_overlay_color',
						'title' => 'Overlays Color',
						'default' => '#ffffff',
						'desc' => 'Color of your text on overlays',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'map_overlay_color_secondary',
						'title' => 'Overlays Secondary Color',
						'default' => '#cccccc',
						'desc' => 'Secondary color of your text on overlays',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'select',
						'name' => 'map_clustering_color',
						'title' => 'Cluster Color',
						'default' => 'grey',
						'desc' => 'Color fo your clusters',
						'options' => array(
				
							'default',
							'aqua',
							'black',
							'blue',
							'dark-blue',
							'dark-green',
							'fire',
							'green',
							'grey',
							'lilac',
							'lime',
							'orange',
							'pink',
							'purple',
							'red',
							'sky-blue',
							'yellow',
						
						),
					
					),
				
					array(
					
						'type' => 'image',
						'name' => 'map_default_pin',
						'title' => 'Default Pin',
						'default' => get_template_directory_uri().'/images/pins/pink.png',
						'desc' => 'Your default pin. If all custom pins fail, this is your fallback.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_pin_twox',
						'title' => 'Enable Pins @2x',
						'default' => 'on',
						'desc' => 'If enabled this will force @2x pins for retina devices. Note that you will need to set the width and height of the pins in order for this to take place',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'map_pin_2x_width',
						'title' => 'Pins @2x - Width',
						'default' => '15',
						'desc' => 'The width of your pins. This is only used when the @2x for pins is enabled. Note that this is the final width of your pins and the actual image needs to be twice the size.',
						'range' => '1,80',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'map_pin_2x_height',
						'title' => 'Pins @2x - Height',
						'default' => '27',
						'desc' => 'The height of your pins. This is only used when the @2x for pins is enabled. Note that this is the final height of your pins and the actual image needs to be twice the size.',
						'range' => '1,140',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'map_pin_2x',
						'title' => 'Enable Pins @2x',
						'default' => 'on',
						'desc' => 'If enabled this will force @2x pins for retina devices. Note that you will need to set the width and height of the pins in order for this to take place',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'map_bar_bg',
						'title' => 'Map Bar Background',
						'default' => '#484544',
						'desc' => 'Background Color of your search bar',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'map_bar_color',
						'title' => 'Map Bar Color',
						'default' => '#ffffff',
						'desc' => 'Text Color of your search bar',
						'opacity' => '1',
					
					),
				
				),
			
			),
			
			array(
			
				'title' => 'Overlay Structure',
				'info' => 'Here you can change your overlay structure',
				'fields' => array(
				
					array(
					
						'type' => 'range',
						'name' => 'overlay_height',
						'title' => 'Overlay Height',
						'default' => '215',
						'desc' => 'This is the overall height of your overlay',
						'range' => '50,400',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'overlay_width',
						'title' => 'Overlay Width',
						'default' => '325',
						'desc' => 'This is the overall width of your overlay',
						'range' => '50,500',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'overlay_image',
						'title' => 'Overlay Image Width',
						'default' => '135',
						'desc' => 'This is the overall width of the featured image in your overlay',
						'range' => '50,300',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'overlay_cats',
						'title' => 'Display Categories',
						'default' => 'on',
						'desc' => 'If on, this wil ldisplay your categories if available.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'overlay_excerpt',
						'title' => 'Display Excerpt',
						'default' => 'on',
						'desc' => 'If on, this will display an excerpt on your overlay',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'overlay_excerpt_length',
						'title' => 'Excerpt Length',
						'default' => '75',
						'desc' => 'If on, this will display an excerpt on your overlay',
					
					)
				
				),
			
			)
		
		),
	
	),
	
	array(
	
		'title' => 'Public Submissions',
		'icon' => 'config.png',
		'tabs' => array(
		
			array(
			
				'title' => 'Main Settings',
				'info' => 'Main Public submission settings',
				'fields' => array(
				
					array(
					
						'type' => 'check',
						'name' => 'public_submissions',
						'title' => 'Enable Public Submissions',
						'default' => '',
						'desc' => 'If enabled, this will allow users to login and submit spots.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'public_submissions_register',
						'title' => 'Enable Public Registrations',
						'default' => 'on',
						'desc' => 'If enabled, this will allow users to register on your website. Only used if Public submissions are enabled',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_enable_editing',
						'title' => 'Enable Editing',
						'default' => 'on',
						'desc' => 'If enabled, this will allow users to edit thir submissions. NOTE THAT THIS WILL NOT REQUIRE REVIEWS',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_publish',
						'title' => 'Let users publish directly',
						'default' => '',
						'desc' => 'IMPORTANT. If enabled, users will be able to publish their submissions directly without the need for reviewing.',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'pbl_count',
						'title' => 'Maximum Submissions per user',
						'default' => '5',
						'desc' => 'How many submissions an user is allowed to submit',
						'range' => '1,999',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_profile',
						'title' => 'Enable Users Profiles',
						'default' => '',
						'desc' => 'Enabling this will allow your users to publish their profile in their submissions such as profile picture, telephone and email address.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_force_contact',
						'title' => 'Force Contact Forms',
						'default' => '',
						'desc' => 'If enabled, all listing pages will include a contact form.',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'pbl_profile_title',
						'title' => 'Users Title',
						'default' => 'Agent',
						'desc' => 'This is the word used to when agent is displayed in the listings page.',
					
					),
				
					array(
					
						'type' => 'image',
						'name' => 'pbl_profile_placeholder',
						'title' => 'Profile Picture Placeholder',
						'default' => get_template_directory_uri().'/images/profile_placeholder.png',
						'desc' => 'In case your user does not have a profile picture this is what shows instead',
					
					),
				
				)
			
			),
			
			array(
			
				'title' => 'Facebook Login Options',
				'info' => 'Type in your facebook app details to allow users to log in using facebook',
				'fields' => array(
				
					array(
					
						'type' => 'text',
						'name' => 'fb_login_app_id',
						'title' => 'Facebook App ID',
						'default' => '',
						'desc' => 'The APP ID of your created facebook app. You must register your app with facebook in order to enable this.',
					
					),
				
				),
			
			),
		
			array(
			
				'title' => 'Limitations',
				'info' => 'Limit what users can do for free',
				'fields' => array(
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_cats',
						'title' => 'Enable Multiple Categories',
						'default' => '',
						'desc' => 'If enabled, user will be able to select as many categories as he wants.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_images_check',
						'title' => 'Enable Upload of Images',
						'default' => 'on',
						'desc' => 'If enabled, user will be able to add images to his submission.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_featured',
						'title' => 'Enable Featured Selection',
						'default' => '',
						'desc' => 'If enabled, user will be able to select whether or not the submission is featured.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_enable_tags',
						'title' => 'Enable Tags',
						'default' => 'on',
						'desc' => 'If enabled, user will be able to select tags',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'pbl_tags_no',
						'title' => 'Maximum Tags per Spot - FREE',
						'default' => '15',
						'desc' => 'Maximum number of tags an user can set for free.',
						'range' => '1,100',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'pbl_images',
						'title' => 'Maximum Images per Spot - FREE',
						'default' => '1',
						'desc' => 'How many images a user can submit for free.',
						'range' => '1,20',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_contact_form',
						'title' => 'Enable Contact Form',
						'default' => 'on',
						'desc' => 'Whether or not users can choose to display a contact form in their submissions',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_custom_fields',
						'title' => 'Enable Custom Fields',
						'default' => 'on',
						'desc' => 'Enable users to set custom fields?',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'pbl_custom_pin',
						'title' => 'Enable Custom Pin',
						'default' => 'on',
						'desc' => 'Enable users to set custom pin?',
					
					),
				
					array(
					
						'type' => 'textarea',
						'name' => 'pbl_custom_fields_desc',
						'title' => 'Custom Fields Description',
						'default' => 'Insert custom fields as an option to add additional information such as Opening hours, special days and more. HTML not accepted.',
						'desc' => 'Description text shown at the top of your custom fields if enabled',
					
					),
				
				)
			
			),
		
			array(
			
				'title' => 'Payment Info',
				'info' => 'Please fill in your Paypal Details',
				'fields' => array(
				
					array(
					
						'type' => 'check',
						'name' => 'paypal_sandbox',
						'default' => 'on',
						'title' => 'Enable Paypal Sandbox mode',
						'desc' => 'If enabled, paypal will work in the sandbox mode and no real charges will be made',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'paypal_user',
						'default' => '',
						'title' => 'Paypal API Username',
						'desc' => 'Please type here your paypal API username',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'paypal_password',
						'default' => '',
						'title' => 'Paypal API Password',
						'desc' => 'Your Paypal API password',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'paypal_signature',
						'default' => '',
						'title' => 'Paypal API Signature',
						'desc' => 'Your Paypal API Signature',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'paypal_currency',
						'default' => 'USD',
						'title' => 'Paypal Currency Code',
						'desc' => 'Type in the currency your transactions will be made in (Currency Code)',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'paypal_name',
						'default' => 'Submission',
						'title' => 'Payment Name',
						'desc' => 'Payment name of the transaction.',
					
					),
					
					
					array(
					
						'type' => 'text',
						'name' => 'price_sign_before',
						'title' => 'Pricing Sign - Before Price',
						'default' => '$',
						'desc' => 'Choose the pricing sign that shows BEFORE the total amounts.',
					
					),
					
					
					array(
					
						'type' => 'text',
						'name' => 'price_sign_after',
						'title' => 'Pricing Sign - After Price',
						'default' => '',
						'desc' => 'Choose the pricing sign that shows AFTER the total amounts.',
					
					),
				
				),
			
			),
			
			array (
			
				'title' => 'Prices',
				'info' => 'Here you can decide how much to charge per extras',
				'fields' => array(
				
					array(
					
						'type' => 'text',
						'name' => 'price_submission',
						'default' => '',
						'title' => 'Price per submission',
						'desc' => 'Price per submission, leave blank or 0 to not charge per submission.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'price_submission_recurring',
						'default' => '',
						'title' => 'Enable Recurring Payments for Submissions',
						'desc' => 'If enabled, SpotFinder will try to bill the client every X number of days as set below. Please note that recurring payments are only available for publishing submission and featured ad.',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'submission_days',
						'default' => '',
						'title' => 'Expiry date in days',
						'desc' => 'Upon publishing, after how many days will the submission expire? After this amount of days the submission goes back to pending and if a price is set for submission, he\'ll have to make the payment again. Leave blank or 0 to set forever.',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'price_featured',
						'default' => '20',
						'title' => 'Price for featured selection',
						'desc' => 'Price for featured seelction, leave blank or 0 to disable.',
					
					),
				
					array(
					
						'type' => 'check',
						'name' => 'price_featured_recurring',
						'default' => '',
						'title' => 'Enable Recurring Payments for Featured Selection',
						'desc' => 'If enabled, SpotFinder will try to bill the client every X number of days as set below to make submission featured. If disabled featured payments will be a once-off payment.',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'price_featured_days',
						'default' => '',
						'title' => 'Featured - Expiry date in days',
						'desc' => 'Upon publishing, after how many days should spotfinder bill the customer again for featured selection?',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'price_images',
						'default' => '2',
						'title' => 'Price for extra images',
						'desc' => 'Price for extra images, leave blank or 0 to disable.',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'price_images_num',
						'default' => '9',
						'title' => 'Number of extra images',
						'desc' => 'How many images user can upload upon getting extra images.',
						'range' => '2,60',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'price_tags',
						'default' => '1',
						'title' => 'Price for extra tags',
						'desc' => 'Price for extra tags, leave blank or 0 to disable.',
					
					),
				
					array(
					
						'type' => 'range',
						'name' => 'price_tags_num',
						'default' => '100',
						'title' => 'Number of extra tags',
						'desc' => 'How many tags user can add upon getting extra tags.',
						'range' => '2,1000',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'price_custom_pin',
						'default' => '1',
						'title' => 'Price for custom pin',
						'desc' => 'Price for custom pin, leave 0 for free and blank to totally disable.',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'price_custom_fields',
						'default' => '1',
						'title' => 'Price for custom fields',
						'desc' => 'Price for custom fields, leave 0 or blank to let user add for free.',
					
					),
				
					array(
					
						'type' => 'text',
						'name' => 'price_contact_form',
						'default' => '1',
						'title' => 'Price for contact form',
						'desc' => 'Price for contact form, leave 0 or blank to let user enable for free.',
					
					),
				
				),
			
			)
		
		)
		
	),
	
	array(
	
		'title' => 'Footer',
		'icon' => 'wireframe.png',
		'tabs' => array(
		
			array(
			
				'title' => 'Main Options',
				'info' => 'These options will affect your footer general settings',
				'fields' => array(
					
					array(
					
						'type' => 'textarea',
						'name' => 'footer_column',
						'title' => 'Footer Column Template',
						'default' => 'one-third
one-third
one-third',
						'desc' => 'Your footer column template. This will define your widget areas for your footer in the widgets panel.<br>
						Use the same attribute as for the columns to create the size of your columns. For more information see documentation.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'copyright',
						'title' => 'Enable Copyright Bar',
						'default' => 'on',
						'desc' => 'Toggle on/off your copyright bar',
					
					),
					
					array(
					
						'type' => 'text',
						'name' => 'copyright_left',
						'title' => 'Copyright - Left',
						'default' => '&copy; %%year%% - '.get_bloginfo('name'),
						'desc' => 'What appears on the left side of your copyright bar',
					
					),
					
					array(
					
						'type' => 'text',
						'name' => 'copyright_right',
						'title' => 'Copyright - Right',
						'default' => 'All Rights Reserved.',
						'desc' => 'What appears on the right side of your copyright bar',
					
					),
				
				),
			
			),
		
			array(
			
				'title' => 'Footer Styling',
				'info' => 'These options affect the styling of your footer',
				'fields' => array(
				
					array(
					
						'type' => 'color',
						'name' => 'footer_bg',
						'title' => 'Footer Background Color',
						'default' => '#484343',
						'desc' => 'Footer Background Color',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'footer_headings_color',
						'title' => 'Footer Headings Color',
						'default' => '#ffffff',
						'desc' => 'Color of your footer headings',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'footer_color',
						'title' => 'Footer Text Color',
						'default' => '#cacbc3',
						'desc' => 'Color of your footer text',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'footer_a_color',
						'title' => 'Footer Links Color',
						'default' => '#ffffff',
						'desc' => 'Color of links in your footer',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'footer_border_color',
						'title' => 'Footer Top Border',
						'default' => '#3f3b3b',
						'desc' => 'Color of the top border of your footer',
						'opacity' => '1',
					
					),
				
				),
			
			),
		
			array(
			
				'title' => 'Copyright Bar Styling',
				'info' => 'These options affect the styling of your copyright bar, if enabled',
				'fields' => array(
				
					array(
					
						'type' => 'color',
						'name' => 'copyright_bg',
						'title' => 'Copyright Background Color',
						'default' => '#3f3b3b',
						'desc' => 'Background of your copyright bar',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'copyright_color',
						'title' => 'Copyright Text Color',
						'default' => '#cacbc3',
						'desc' => 'Color of your copyright text',
						'opacity' => '1',
					
					),
				
					array(
					
						'type' => 'color',
						'name' => 'copyright_border_color',
						'title' => 'Copyright Top Border',
						'default' => '#373333',
						'desc' => 'Color of the top border of your copyright bar',
						'opacity' => '1',
					
					),
				
				),
			
			),
		
		),
	
	),
	
	array(
	
		'title' => 'Typography',
		'icon' => 'type.png',
		'tabs' => array(
		
			array(
			
				'title' => 'Main Body',
				'info' => 'Set typography settings for your body',
				'fields' => array(
					
					array(
					
						'type' => 'text',
						'name' => 'type_body_font',
						'title' => 'Font-Family',
						'default' => '"Titillium Web", Helvetica, Arial, sans-serif',
						'desc' => 'The font-family of your body text',
					
					),
					
					array(
					
						'type' => 'range',
						'name' => 'type_body_size',
						'title' => 'Body Font Size',
						'default' => '14',
						'desc' => 'Size of your body text.',
						'range' => '6,80',
					
					),
					
					array(
					
						'type' => 'color',
						'name' => 'type_body_color',
						'title' => 'Page Title Color',
						'default' => '#484544',
						'desc' => 'Color of your body text.',
						'opacity' => '1',
					
					),
					
					array(
					
						'type' => 'color',
						'name' => 'type_body_color_sec',
						'title' => 'Page Title Secondary Color',
						'default' => '#888888',
						'desc' => 'Secondary color of your body text.',
						'opacity' => '1',
					
					)
				
				),
			
			), // HEADERS
		
			array(
			
				'title' => 'Headers',
				'info' => 'Set typography settings for your headers',
				'fields' => array(
					
					array(
					
						'type' => 'select',
						'name' => 'type_type',
						'title' => 'Source',
						'default' => 'Google Fonts',
						'desc' => 'Set where you\'d like to get your font from.',
						'options' => array(
						
							'Default CSS',
							'Cufon',
							'Google Fonts',
							'@Font-Face'
						
						),
					
					),
					
					array(
					
						'type' => 'text',
						'name' => 'type_css_main',
						'title' => 'Font-Family CSS - Main Headers',
						'default' => 'Lato, Helvetica, Arial, sans-serif',
						'desc' => 'In case your using Default CSS, this is the font of your main headers',
					
					),
					
					array(
					
						'type' => 'select',
						'name' => 'type_css_main_style',
						'title' => 'Font-Family CSS - Main Headers Style',
						'default' => 'Normal',
						'desc' => 'In case your using Default CSS, this is the font style of your main headers',
						'options' => array(
						
							'Normal',
							'Italic',
							'Bold Italic',
							'Bold'
						
						),
					
					),
					
					array(
					
						'type' => 'range',
						'name' => 'type_h1_size',
						'title' => 'H1 Size',
						'default' => '32',
						'desc' => 'Size of your H1 header. This is also your page title.',
						'range' => '6,80',
					
					),
					
					array(
					
						'type' => 'range',
						'name' => 'type_h2_size',
						'title' => 'H2 Size',
						'default' => '26',
						'desc' => 'Size of your H2 header.',
						'range' => '6,80',
					
					),
					
					array(
					
						'type' => 'range',
						'name' => 'type_h3_size',
						'title' => 'H3 Size',
						'default' => '22',
						'desc' => 'Size of your H3 header.',
						'range' => '6,80',
					
					),
					
					array(
					
						'type' => 'range',
						'name' => 'type_h4_size',
						'title' => 'H4 Size',
						'default' => '16',
						'desc' => 'Size of your H4 header.',
						'range' => '6,80',
					
					),
					
					array(
					
						'type' => 'range',
						'name' => 'type_h5_size',
						'title' => 'H5 Size',
						'default' => '14',
						'desc' => 'Size of your H5 header.',
						'range' => '6,80',
					
					),
					
					array(
					
						'type' => 'range',
						'name' => 'type_h6_size',
						'title' => 'H6 Size',
						'default' => '11',
						'desc' => 'Size of your H6 header.',
						'range' => '6,80',
					
					),
					
					array(
					
						'type' => 'color',
						'name' => 'type_color',
						'title' => 'Header\'s Color',
						'default' => '#484544',
						'desc' => 'Color of your headers',
					
					),
					
					array(
					
						'type' => 'color',
						'name' => 'type_color_page_title',
						'title' => 'Page Title Color',
						'default' => '#ffffff',
						'desc' => 'Color of your page title.',
					
					)
				
				),
			
			), // HEADERS
			
			array(
			
				'title' => 'Cufon Options',
				'info' => 'In case you\'re using Cufon, these are your options.',
				'fields' => array(
					
					array(
					
						'type' => 'file',
						'name' => 'cufon_file_main',
						'title' => 'Main Header Cufon File',
						'default' => '',
						'desc' => 'Upload your cufon.js file for your main headers',
					
					),
					
					array(
					
						'type' => 'text',
						'name' => 'cufon_family_main',
						'title' => 'Main Header Font Name',
						'default' => '',
						'desc' => 'When uploading your cufon file, please insert the full name of your font. You can find out exactly the name of your font by opening your generated cufon file. It will be in between quotation marks, at the very beginning of the code.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'cufon_all_headers',
						'title' => 'Apply to all headers',
						'default' => 'on',
						'desc' => 'If checked this will apply Cufon to all your headers, and will override the selections below.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'cufon_h1',
						'title' => 'H1 headers',
						'default' => '',
						'desc' => 'Apply cufon to H1 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'cufon_h2',
						'title' => 'H2 headers',
						'default' => '',
						'desc' => 'Apply cufon to H2 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'cufon_h3',
						'title' => 'H3 headers',
						'default' => '',
						'desc' => 'Apply cufon to H3 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'cufon_h4',
						'title' => 'H4 headers',
						'default' => '',
						'desc' => 'Apply cufon to H4 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'cufon_h5',
						'title' => 'H5 headers',
						'default' => '',
						'desc' => 'Apply cufon to H5 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'cufon_h6',
						'title' => 'H6 headers',
						'default' => '',
						'desc' => 'Apply cufon to H6 headers.',
					
					)
				
				)
			
			), // CUFON
			
			array(
			
				'title' => 'Google Font Options',
				'info' => 'If you\'re using google fonts, this are your options.',
				'fields' => array(
					
					array(
					
						'type' => 'text',
						'name' => 'google_font_main',
						'title' => 'Google Font Name - Main Headers',
						'default' => 'Lato:300,400,700,900,400italic,700italic',
						'desc' => 'Browse fonts <a href="http://www.google.com/webfonts" target="_blank">here &rarr;</a><br>Insert the exact name of the font. In case using a certain weight, insert the weight of the font after the font name.<br>i.e: Signika:700',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'google_all_headers',
						'title' => 'Apply to all headers',
						'default' => 'on',
						'desc' => 'If checked this will apply Google Fonts to all your headers, and will override the selections below.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'google_h1',
						'title' => 'H1 headers',
						'default' => '',
						'desc' => 'Apply google fonts to H1 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'google_h2',
						'title' => 'H2 headers',
						'default' => '',
						'desc' => 'Apply google fonts to H2 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'google_h3',
						'title' => 'H3 headers',
						'default' => '',
						'desc' => 'Apply google fonts to H3 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'google_h4',
						'title' => 'H4 headers',
						'default' => '',
						'desc' => 'Apply google fonts to H4 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'google_h5',
						'title' => 'H5 headers',
						'default' => '',
						'desc' => 'Apply google fonts to H5 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'google_h6',
						'title' => 'H6 headers',
						'default' => '',
						'desc' => 'Apply google fonts to H6 headers.',
					
					)
				
				)
			
			), // GOOGLE FONTS
			
			array(
			
				'title' => '@font-face Options',
				'info' => 'If you\'re using font-face, these are your options',
				'fields' => array(
					
					array(
					
						'type' => 'text',
						'name' => 'fontface_file_main',
						'title' => 'Font File URL - Main Headers',
						'default' => '',
						'desc' => 'Your font-face font file URL for main headers.',
					
					),
					
					array(
					
						'type' => 'text',
						'name' => 'fontface_name_main',
						'title' => 'Font Name - Main Headers',
						'default' => '',
						'desc' => 'Your font-face font name for main headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'fontface_all_headers',
						'title' => 'Apply to all headers',
						'default' => 'on',
						'desc' => 'If checked this will apply @font-face to all your headers, and will override the selections below.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'fontface_h1',
						'title' => 'H1 headers',
						'default' => '',
						'desc' => 'Apply @font-face fonts to H1 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'fontface_h2',
						'title' => 'H2 headers',
						'default' => '',
						'desc' => 'Apply @font-face fonts to H2 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'fontface_h3',
						'title' => 'H3 headers',
						'default' => '',
						'desc' => 'Apply @font-face fonts to H3 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'fontface_h4',
						'title' => 'H4 headers',
						'default' => '',
						'desc' => 'Apply @font-face fonts to H4 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'fontface_h5',
						'title' => 'H5 headers',
						'default' => '',
						'desc' => 'Apply @font-face fonts to H5 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'fontface_h6',
						'title' => 'H6 headers',
						'default' => '',
						'desc' => 'Apply @font-face fonts to H6 headers.',
					
					),
					
					array(
					
						'type' => 'check',
						'name' => 'fontface_menu',
						'title' => 'Main Bar Menu',
						'default' => '',
						'desc' => 'Apply @font-face fonts to your main bar menu.',
					
					)
				
				),
			
			), /// FONT-FACE
		
		)
	
	), //// TYPOGRAPHY
	
	array(
	
		'title' => 'Google Analytics',
		'icon' => 'analytics.png',
		'tabs' => array(
			
			array(
			
				'title' => 'Analytics',
				'info' => 'Paste in your analytics code if you have one.',
				'fields' => array(
					
					array(
					
						'type' => 'textarea',
						'name' => 'google_analytics',
						'title' => 'Google Analytics Code',
						'default' => '',
						'desc' => 'Paste your google analytics code here.',
					
					),
				
				),
			
			)
		
		),
	
	), /// ANALYTICS

);
	
	//lets loop trhoug our fields and check if they are already stored, if not store default values
	foreach($myOpts as $opt) {
		
		if($opt['tabs'] != NULL) { foreach($opt['tabs'] as $tab) {
			
			if($tab['fields'] != NULL) { foreach($tab['fields'] as $field) {
				
				//if the default value isn't null or its info type
				if(isset($field['default'])) { if($field['default'] != NULL && $field['type'] != 'info') {
					
					//if the option does not exist
					if(get_option('ddp_'.$field['name']) == FALSE) {
						
						//inserts the default option
						add_option('ddp_'.$field['name'], $field['default']);
						
						//// IF IT'S A COLOR STORE OPACITY TOO
							  
						  //// IF ITS A COLOR WE NEED TO SAVE OPACITY AS WELL
						  if($field['type'] == 'color') {
							  
							  if(!isset($field['opacity'])) { $field['opacity'] = 1; }
							  
							  if($field['opacity'] != NULL) { update_option('ddp_'.$field['name'].'_opacity', addslashes($field['opacity'])); }
							  
						  }
						
					}
					
				} }
				
			} }
			
		} }
		
	}

?>