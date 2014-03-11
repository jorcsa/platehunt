<?php



	//// OUR HOOK
	add_action('contextual_help', 'pages_add_help_text', 10, 3);
	
	//// OUR FUNCTIONS
	function pages_add_help_text($contextual_help, $screen_id, $screen) {
		
		//// IF IT'S OUR PAGES PAGE
		if($screen->id == 'page') {
			
			//// BASICS TAB
			$screen->add_help_tab(
			
				array(
				
					'id' => 'page_basics',
					'title' => 'Page Basics',
					'content' => '<h3>Basics</h3>
					
					<p>Creating pages is overall very very easy. All you need is a title and a content. Filling out these two will get the basic of your page up and running.</p>
					
					<p>However there several extra fields to help you control the look of your page. Below there\'s a brief description of each one.</p>
					
					<p><strong>Page Layout</strong> &mdash; Helps you control the layout of your page. Options included are show/hide your title, your slogan and the position of your sidebar (or full-width).</p>
					
					<p><strong>Custom Sidebar</strong> &mdash; Lets you choose or add a custom sidebar to your post. This is helpful when you need unique content on the sidebar of that page. Creating a new sidebar will automatically add this to your widgets panel. Make sure you update your page for change to take effects.</p>',
				
				)
			
			);
			
			//// PAGE LAYOUT TAB
			$screen->add_help_tab(
			
				array(
				
					'id' => 'page_layout',
					'title' => 'Page Layout',
					'content' => '<h3>Page Layout</h3>
					
					<p>At the very top of your right sidebar, you\'ll see the Page Layout section. This section lets you take more control over your page\'s appearance. There are four field. They are explained below in order.</p>
					
					<p><strong>Show Page Title</strong> — Switch on/off to show the page title on the page. This is usually helpful if you\'re using templates like the blog page where the page title isn\'t really needed.</p>
					
					<p><strong>Page Slogan</strong> — It\'s the slogan that comes at the very bottom of your title. Will only show if your page title is enabled.</p>
					
					<p><strong>Layout Type</strong> — Lets you override the default layout type. Leave Default to follow the default layout type set in the DDPanel.</p>
					
					<p><strong>Sidebar Position</strong> — Lets you choose the position of your sidebar or if the page is full width. Leave Default to follow the default value set in the DDPanel.</p>',
				
				)
			
			);
			
			//// PAGE LAYOUT TAB
			$screen->add_help_tab(
			
				array(
				
					'id' => 'page_sidebar',
					'title' => 'Custom Sidebar',
					'content' => '<h3>Custom Sidebar</h3>
					
					<p>For each page you can create and set a custom sidebar. This is very helpful when it comes to having different content on the sidebars of each page. You can select one of the custom sidebars you have already created or create a brand new one.</p>
					
					<p>Upon selecting the Add new sidebar, put an unique name for your sidebar and add it. As soon as you create the sidebar, it will automatically be added to your Widgets panel.</p>',
				
				)
			
			);
			
			//// PAGE LAYOUT TAB
			$screen->add_help_tab(
			
				array(
				
					'id' => 'page_faq',
					'title' => 'FAQ',
					'content' => '<h3>FAQ</h3>
					
					<p><strong><big>Why isn\'t my page showing on my menu?</big></strong><br>
					Make sure you have published your page and that you have added it to your menu in the <a href="'.get_bloginfo('url').'/wp-admin/nav-menus.php">Menus panel</a>. Also make sure you have saved your menu once you\'ve added it to your menu.</p>',
				
				)
			
			);
			
		}
		
	}


?>