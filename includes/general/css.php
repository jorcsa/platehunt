<?php

	//// ADDS IT TO OUR WP_HEAD
	add_action('wp_head', 'btoa_insert_custom_style');
	
	function btoa_insert_custom_style() {
		
	///////////////////////////////////
	///// HEADER VARS
	///////////////////////////////////
	
	///// CALCULATE THE HEIGHT OF THE HEADER BASED ON OUR LOGO HEIGHT
	$logo_height = ddp('logo_image_height'); if(!is_numeric($logo_height)) { $logo_height = 31; }
	$header_height = ddp('logo_image_height')+40;
	
	$main_color = '#da2639';

?>

	<style type="text/css">
    
/* DAHERO #1667517 STRT */
        #header, #clear-filter, #finish-filter, #map-resize { <?php echo ddp_bg_color('header_bg_color'); ?> border-top-color: <?php echo ddp('header_border_color'); ?>; }
		#menu ul ul { <?php echo ddp_bg_color('header_bg_color'); ?> }
		#header-mobile, #mobile-menu-wrapper, #filter-menu { <?php echo ddp_bg_color('header_border_color'); ?> <?php echo ddp_color('menu_link_color'); ?> }
		#mobile-menu-button, #mobile-filter-button, #mobile-menu-close, #filter-menu-close, #mobile-menu-wrapper > ul > li, #clear-filter, #finish-filter { border-color: <?php echo ddp_rgb(ddp('header_bg_color'), .5); ?>; }
		#mobile-menu a, #clear-filter, #finish-filter { <?php echo ddp_color('menu_link_color'); ?> }
/* DAHERO #1667517 STOP */
		
		#menu ul li a { line-height: <?php echo $header_height; ?>px; <?php echo ddp_color('menu_link_color'); ?> border-color: <?php echo ddp('header_border_color'); ?>; }
		#menu ul li a:hover, #map-resize { <?php echo ddp_color('menu_link_color_hover'); ?> border-color: <?php echo ddp('menu_link_color_border_hover'); ?> }
		#menu ul li.current-menu-item > a, #menu ul li.current-parent-item > a, #menu ul li.current-menu-parent > a , #menu ul li.current_page_item > a, #mobile-menu > ul > li > a { <?php echo ddp_color('menu_link_color_active'); ?> border-color: <?php echo ddp('menu_link_color_border_active'); ?>; }
		#mobile-menu-close { <?php echo ddp_color('menu_link_color_active'); ?> }
		
		#social { margin-top: <?php echo ($header_height - 34) / 2; ?>px; }
		#social li a { <?php echo ddp_bg_color('social_icons_bg'); ?> <?php echo ddp_color('social_icons_color'); ?> }
		#social li a:hover { background: <?php echo ddp('header_border_color'); ?>; }
		
		body, #content, #_sf_tooltip_wrapper .inside .content, .facebook-divider .text { <?php echo ddp_bg_color('page_bg'); ?> }
		/* small.error { display: none; } */
		
		a, a:hover, .color, .primary, ._sf_us_addtocart, ._sf_us_addtocart_over span { <?php echo ddp_color('primary_color'); ?> }
		.secondary { <?php echo ddp_color('primary_color'); ?> }
		.secondary-color, #spots .spot-cats a, .post-info .comments, .post-info .comments a, .post-info .categories a, .post-info .tags a, #comments .author, #comments .author a, #comments .date, #comments .reply a, ul.related-spots h5 a, #user-content-area h5 { <?php echo ddp_color('type_body_color_sec'); ?> }
		.post-info a, .post-info strong, #comments .reply a:hover, .comment-pagination a, #cancel-comment-reply-link, #_sf_tooltip_wrapper .inside .content, #_sf_tooltip_wrapper .inside .content h4 { <?php echo ddp_color('type_body_color') ?> }
		.page-title, .page-header, #user-spots li, #user-spots-header, h3, .post, .post-info, .post-info .categories, .post-info .tags, #comments, #comments ol > li, #comments ol ul, #comments ol ul li, .sidebar-item > ul > li { border-color: <?php echo ddp('secondary_color'); ?>; }
		.button-primary, .form-submit #submit, #searchsubmit, .listing-featured-badge span, h5.sticky-featured span { <?php echo ddp_bg_color('primary_color'); ?> }
		.button-secondary, .divider-top, .notify-me:hover, .facebook-divider .line, h5.sticky span { <?php echo ddp_bg_color('secondary_color'); ?> <?php echo ddp_color('type_body_color') ?> }
		#user-spots li a.edit-post, .sidebar-item > ul > li > a, .sidebar-item .menu a, .notify-me, #reviews ul li .rating-comment a { <?php echo ddp_color('type_body_color') ?> }
		#user-spots-header, ._sf_box .head, #subheader, .notify-me, #page-view-labels, #_sf_categories_box, #_sf_gallery_images, #_sf_custom_fields_list, ._sf_login_sign_up_widget .tabs li.current, #spots.spot-list > li.spot-list-alt.listing-featured, ._sf_login_sign_up_widget .tabbed li, #_sf_user_profile_public, .submission-field-text, .submission-field-select, .submission-field-file, .fieldset { background: <?php echo ddp('secondary_color'); ?>; background: <?php echo ddp_rgb(ddp('secondary_color'), '.3'); ?>; }
		
		#search-hover { <?php if(ddp('search_visibility') == 'Show on hover') : ?>position: absolute; left: 0;<?php endif; ?> }
		#search, #search-ipad { <?php echo ddp_bg_color('search_bg'); ?> <?php if(ddp('search_visibility') == 'Show on hover') : ?>position: absolute;<?php endif; ?> }
		#search .down-arrow { background: <?php echo ddp('search_bg'); ?>; }
		#search .down-arrow:after { border-bottom-color: <?php echo ddp('search_bg'); ?>; }
		#search .up-arrow { background: <?php echo ddp('search_bg'); ?>; }
		#search .up-arrow:after { border-top-color: <?php echo ddp('search_bg'); ?>; }
		#search, .custom-header-form #search-spots { <?php echo ddp_bg_color('search_bg'); ?> }
		#slider-map-message span { <?php echo ddp_bg_color('search_bg'); ?> }
		#search, #search-spots label, #slider-map-message span, #slider-map-message a, #search-ipad { <?php echo ddp_color('search_color'); ?> }
		#search input, #search-spots .select-replace > span, #search-spots .select-replace i, #search .field-range .ui-widget-header, #search .checkbox-replace, #search .radio-replace, #search .type-text-wrapper ul { <?php echo ddp_bg_color('search_inputs_bg'); ?> <?php echo ddp_color('search_inputs_color'); ?> }
		#search-spots .checkbox-replace i, #search .radio-replace i { <?php echo ddp_color('search_inputs_color'); ?> }
		#search-spots .form-divider { <?php echo ddp_bg_color('search_divider_color'); ?> }
		#search-spots .field-range { <?php echo ddp_bg_color('search_inputs_bg', .5); ?> }
		#search-spots .field-range .ui-slider-handle { <?php echo ddp_bg_color('primary_color'); ?>; }
		
		.overlay-title-wrapper .title span, .map-overlay, #map-zoom-out, #map-zoom-in, .overlay-single-wrapper .inside, #_sf_tooltip_wrapper .inside, .overlay-cluster { <?php echo ddp_bg_color('map_overlay_bg'); ?> <?php echo ddp_color('map_overlay_color'); ?> }
		.overlay-title-wrapper .arrow-down, #_sf_tooltip_wrapper .inside > i { border-top-color: <?php echo ddp('map_overlay_bg'); ?>; border-top-color: <?php echo ddp_rgb(ddp('map_overlay_bg'), ddp('map_overlay_bg_opacity')); ?>; <?php echo ddp_color('map_overlay_bg'); ?> }
		.overlay-single-wrapper .inside img { border-color: <?php echo ddp('map_overlay_bg'); ?> !important; }
		.map-overlay .arrow, .overlay-single-wrapper .arrow-down, .overlay-cluster .arrow { border-right-color: <?php echo ddp('map_overlay_bg'); ?>; border-right-color: <?php echo ddp_rgb(ddp('map_overlay_bg'), ddp('map_overlay_bg_opacity')); ?>; }
		.map-overlay { width: <?php echo ddp('overlay_width'); ?>px; }
		 .overlay-cluster ul li a { border-bottom-color: <?php echo ddp_rgb(ddp('map_overlay_color'), .3); ?>; }
		.overlay-featured-wrapper, .overlay-featured-wrapper .arrow-down { border-color: <?php echo ddp('map_overlay_bg'); ?>; border-color: <?php echo ddp_rgb(ddp('map_overlay_bg'), ddp('map_overlay_bg_opacity')); ?>; }
		.overlay-content a, .overlay-content h5, .overlay-content ul { <?php echo ddp_color('map_overlay_color_secondary'); ?> }
		.overlay-content h2 a, .overlay-content ul span, .overlay-content ul strong, .overlay-cluster ul li a { <?php echo ddp_color('map_overlay_color'); ?> }
		#map-zoom-out:hover, #map-zoom-in:hover { <?php echo ddp_bg_color('map_overlay_color'); ?> <?php echo ddp_color('map_overlay_bg'); ?> }
		<?php if(ddp('search_position') == 'Bottom') : ?>#map-zoom-in { bottom: auto; top: 1px; } #map-zoom-out { bottom: auto; top: 47px; }<?php endif; ?>
		#slider-bar { <?php echo ddp_bg_color('map_bar_bg') ?> <?php echo ddp_color('map_bar_color') ?> }
		#slider-bar a, #slider-bar strong { <?php echo ddp_color('map_bar_color') ?> }
		
		._sf_us_addtocart_over em, ._sf_us_addtocart em { color: <?php echo ddp('type_color'); ?>; }
		
		<?php if(ddp('search_position') == 'Top' && ddp('search_visibility') == 'Show on hover') : /// IF SHOW ON HOVER AND ON TOP?>
		
			#search-hover { top: 0; overflow: hidden; }
			#search { bottom: 70px; }
		
		<?php endif; ?>
		
		<?php if(ddp('search_position') == 'Bottom' && ddp('search_visibility') == 'Show on hover') : /// IF SHOW ON HOVER AND ON TOP?>
		
			#search-hover { bottom: 0; overflow: hidden; }
			#search { top: 70px; }
		
		<?php endif; ?>
		
		<?php if(ddp('search_position') == 'Bottom' && ddp('search_visibility') == 'Always Visible') : /// IF SHOW ON HOVER AND ON TOP?>
		
			#search-hover { bottom: 0; top: auto; }
		
		<?php endif; ?>
		
		label, .checkbox-replace i, .radio-replace i { <?php echo ddp_color('label_color'); ?> }
		input[type="text"],input[type="password"],input[type="date"],input[type="datetime"],input[type="datetime-local"],input[type="month"],input[type="week"],input[type="email"],input[type="number"],input[type="search"],input[type="tel"],input[type="time"],input[type="url"],textarea, ._sf_box .inside { <?php echo ddp_bg_color('input_bg'); ?> border-color: <?php echo ddp('inputs_border'); ?>; border-color: <?php echo ddp_rgb(ddp('inputs_border'), ddp('inputs_border_opacity')); ?>; }
		input[type="text"]:focus,input[type="password"]:focus,input[type="date"]:focus,input[type="datetime"]:focus,input[type="datetime-local"]:focus,input[type="month"]:focus,input[type="week"]:focus,input[type="email"]:focus,input[type="number"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="time"]:focus,input[type="url"]:focus,textarea:focus, .checkbox-replace, .radio-replace, #comments ol > li { <?php echo ddp_bg_color('input_bg_focus'); ?> border-color: <?php echo ddp('inputs_border_focus'); ?>; border-color: <?php echo ddp_rgb(ddp('inputs_border_focus'), ddp('inputs_border_focus_opacity')); ?>; }
		._sf_box .head, #_sf_categories_box, .checkbox-replace, .radio-replace, #content .select-replace span, select[multiple="multiple"], #_sf_custom_fields_list li._sf_box .close, #submit-cart, .cart-items > li, ._sf_us_addtocart_over, #subheader, .border-color-input, #page-pagination, #subheader .select-replace span, .sidebar-item, ._sf_login_sign_up_widget .tabbed li.current, ._sf_login_sign_up_widget .tabs li, #user-content, #reviews, #post-review, .submission-field-file ul li, .fieldset, .fieldset .original, .border-color-input { border-color: <?php echo ddp('inputs_border'); ?>; border-color: <?php echo ddp_rgb(ddp('inputs_border'), ddp('inputs_border_opacity')); ?>; }
		.radio-replace i, ._sf_box .field-range .ui-slider-handle { <?php echo ddp_bg_color('label_color'); ?> }
		._sf_box .field-range, .upload-bar { <?php echo ddp_bg_color('inputs_border'); ?> }
		
		#spots .spot-image span, .upload-bar span { background: <?php echo ddp('primary_color'); ?>; background: <?php echo ddp_rgb(ddp('primary_color'), .8); ?> }
		
		#pagination li.current a, #page-pagination > span { border-color: <?php echo ddp('primary_color'); ?>; }
		
		#spot-gallery-thumbs ul li { border-color: <?php echo ddp('page_bg'); ?>; }
		#spot-gallery-thumbs ul li.current { border-color: <?php echo ddp('primary_color'); ?> !important; }
		
		#footer { <?php echo ddp_bg_color('footer_bg') ?> <?php echo ddp_color('footer_color') ?> border-top-color: <?php echo ddp('footer_border_color'); ?>; border-top-color: <?php echo ddp_rgb(ddp('footer_border_color'), ddp('footer_border_color_opacity')); ?>; }
		#footer h1, #footer h2, #footer h3
		#footer h4, #footer h4, #footer h6 { <?php echo ddp_color('footer_headings_color') ?> }
		#footer a { <?php echo ddp_color('footer_a_color'); ?> }
		
		#reviews ul li .rating-comment { <?php echo ddp_bg_color('rating_bg') ?>  }
		
		#copyright { <?php echo ddp_bg_color('copyright_bg') ?> <?php echo ddp_color('copyright_color') ?> border-top-color: <?php echo ddp('copyright_border_color'); ?>; border-top-color: <?php echo ddp_rgb(ddp('copyright_border_color'), ddp('copyright_border_color_opacity')); ?>; }
		
		@media 
(-webkit-min-device-pixel-ratio: 2), 
(min-resolution: 192dpi) {
	
			/* #logo { background-image: url('<?php echo ddp('logo2x'); ?>') !important; background-size: <?php echo ddp('logo_image_width'); ?>px <?php echo ddp('logo_image_height'); ?>px; } */
	
		}
		
		@media all and (max-width: 700px) {
			
			#search { background: <?php echo ddp_rgb(ddp('search_bg'), 1); ?> }
			
		}
		
		
		
		<?php echo ddp('custom_css'); ?>
    
    </style>

<?php 

	get_template_part('includes/general/typography/functions'); //// NECESSARY TO BE DISPLAYED AFTER THE WP_HEAD - THIS SHOWS A STYLE TAG

} ?>