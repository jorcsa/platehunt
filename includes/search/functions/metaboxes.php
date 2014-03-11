<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// METABOXES
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('admin_menu' ,'btoa_search_field_metabox');
	add_action('save_post', 'btoa_search_field_metabox_save');
	
	//// FUNCTION
	function btoa_search_field_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_search_field_metabox_meta', 'Search Field Options', 'btoa_search_field_metabox_create', 'search_field', 'normal', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_search_field_metabox_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/metaboxes.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function btoa_search_field_metabox_save($post_id) {
		
		//// GLOBAL $POST
		global $post;
		
		//// CHECK IF IT'S AN AUTOSAVE
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
		
		if(isset($_POST['post_type'])) {
		
			//// VERIFY PERMISSIONS
			if('page' == $_POST['post_type']) {
				 
				//// IF USER CAN'T EDIT PAGE
				if(!current_user_can('edit_page', $post_id)) { return $post_id; }
				
				//// IF USER CAN'T EDIT POST
				if(!current_user_can('edit_post', $post_id)) { return $post_id; }
				
			}
			
			if('search_field' == $_POST['post_type']) {
					
			
			//// FREE TO SAVE METABOX
			if(isset($_POST['field_type'])) { update_post_meta($post_id, 'field_type', htmlspecialchars($_POST['field_type'])); }
			if(isset($_POST['text_autoload'])) { update_post_meta($post_id, 'text_autoload', htmlspecialchars($_POST['text_autoload'])); } else { update_post_meta($post_id, 'text_autoload', ''); }
			if(isset($_POST['text_type'])) { update_post_meta($post_id, 'text_type', htmlspecialchars($_POST['text_type'])); }
			if(isset($_POST['text_default'])) { update_post_meta($post_id, 'text_default', htmlspecialchars($_POST['text_default'])); }
			if(isset($_POST['dropdown_change_location'])) { update_post_meta($post_id, 'dropdown_change_location', htmlspecialchars($_POST['dropdown_change_location'])); } else { update_post_meta($post_id, 'dropdown_change_location', ''); }
			if(isset($_POST['dropdown_values'])) {  update_post_meta($post_id, 'dropdown_values', htmlspecialchars($_POST['dropdown_values'])); }
			if(isset($_POST['dependent_values'])) { update_post_meta($post_id, 'dependent_values', htmlspecialchars($_POST['dependent_values'])); }
			if(isset($_POST['min_val_values'])) { update_post_meta($post_id, 'min_val_values', htmlspecialchars($_POST['min_val_values'])); }
			if(isset($_POST['max_val_values'])) { update_post_meta($post_id, 'max_val_values', htmlspecialchars($_POST['max_val_values'])); }
			if(isset($_POST['range_minimum'])) { update_post_meta($post_id, 'range_minimum', htmlspecialchars($_POST['range_minimum'])); }
			if(isset($_POST['range_maximum'])) { update_post_meta($post_id, 'range_maximum', htmlspecialchars($_POST['range_maximum'])); }
			if(isset($_POST['range_increments'])) { update_post_meta($post_id, 'range_increments', htmlspecialchars($_POST['range_increments'])); }
			if(isset($_POST['range_label'])) { update_post_meta($post_id, 'range_label', htmlspecialchars($_POST['range_label'])); }
			if(isset($_POST['range_input'])) { update_post_meta($post_id, 'range_input', htmlspecialchars($_POST['range_input'])); } else { update_post_meta($post_id, 'range_input', ''); }
			if(isset($_POST['range_price'])) { update_post_meta($post_id, 'range_price', htmlspecialchars($_POST['range_price'])); } else { update_post_meta($post_id, 'range_price', ''); }
			if(isset($_POST['dependent_change_location'])) { update_post_meta($post_id, 'dependent_change_location', htmlspecialchars($_POST['dependent_change_location'])); }
			if(isset($_POST['dependent_parent'])) { update_post_meta($post_id, 'dependent_parent', htmlspecialchars($_POST['dependent_parent'])); }
			if(isset($_POST['include_overlay'])) { update_post_meta($post_id, 'include_overlay', htmlspecialchars($_POST['include_overlay'])); } else { update_post_meta($post_id, 'include_overlay', ''); }
			if(isset($_POST['enable_sort'])) { update_post_meta($post_id, 'enable_sort', htmlspecialchars($_POST['enable_sort'])); } else { update_post_meta($post_id, 'enable_sort', ''); }
			if(isset($_POST['overlay_markup'])) { update_post_meta($post_id, 'overlay_markup', htmlspecialchars($_POST['overlay_markup'])); }
			if(isset($_POST['public_field'])) { update_post_meta($post_id, 'public_field', htmlspecialchars($_POST['public_field'])); } else { update_post_meta($post_id, 'public_field', ''); }
			if(isset($_POST['public_field_required'])) { update_post_meta($post_id, 'public_field_required', htmlspecialchars($_POST['public_field_required'])); } else { update_post_meta($post_id, 'public_field_required', ''); }
			if(isset($_POST['public_field_selection'])) { update_post_meta($post_id, 'public_field_selection', htmlspecialchars($_POST['public_field_selection'])); }
			if(isset($_POST['public_field_description'])) { update_post_meta($post_id, 'public_field_description', htmlspecialchars($_POST['public_field_description'])); }
			if(isset($_POST['public_field_category'])) { update_post_meta($post_id, 'public_field_category', $_POST['public_field_category']); }
			if(isset($_POST['public_field_price'])) { update_post_meta($post_id, 'public_field_price', absint($_POST['public_field_price'])); }
			if(isset($_POST['public_field_price_description'])) { update_post_meta($post_id, 'public_field_price_description', htmlspecialchars($_POST['public_field_price_description'])); }
			if(isset($_POST['dropdown_type'])) { update_post_meta($post_id, 'dropdown_type', htmlspecialchars($_POST['dropdown_type'])); }
			if(isset($_POST['dropdown_categories'])) { update_post_meta($post_id, 'dropdown_categories', $_POST['dropdown_categories']); }
			if(isset($_POST['include_rating_overlay'])) { update_post_meta($post_id, 'include_rating_overlay', htmlspecialchars($_POST['include_rating_overlay'])); } else { update_post_meta($post_id, 'include_rating_overlay', ''); }
			if(isset($_POST['google_places_country'])) { update_post_meta($post_id, 'google_places_country', $_POST['google_places_country']); }
			//// IF DROPDOWN TYPE IS CATEGORIES LETS MAKE SURE TO NOT PUT IT IN THE PUBLIC SUBMISSION 
			if(isset($_POST['dropdown_type'])) { if($_POST['dropdown_type'] == 'categories') { update_post_meta($post_id, 'public_field', ''); } }
			
			//// GOOGLE PLACES API SENSITIVITY - NEEDS TO BE A FLOAT NUMBER
			if(isset($_POST['google_places_sensitivity'])) {
				
				if(is_float($_POST['google_places_sensitivity']) || is_numeric($_POST['google_places_sensitivity'])) {
					
					update_post_meta($post_id, 'google_places_sensitivity', $_POST['google_places_sensitivity']);
					
				} elseif($_POST['google_places_sensitivity'] != '') {
					
					/// THROWS AN ERROR
					add_filter('redirect_post_location',  'display_google_sensitivity_error' );
					
				}
				
			}
			
			///// GOOGLE PLACES API
			if(isset($_POST['google_places_api'])) {
				
				//// IF WE PROVIDED AN API
				if($_POST['google_places_api'] != '') {
					
					update_post_meta($post_id, 'google_places_api', $_POST['google_places_api']);
					update_option('ddp_google_places_api', $_POST['google_places_api']);
					
				} else {
					
					//// NO API PROVIDED - LETS SEE IF THERE IS ANY OTHER FIELD WITH THIS FILLED
					$args = array(
					
						'post_type' => 'search_field',
						'posts_per_page' => -1,
						'meta_query' => array(
						
							array(
							
								'key' => 'google_places_api',
								'compare' => 'EXISTS',
							
							)
						
						),
					
					);
					
					$tempQ = new WP_Query($args);
					
					///// IF WE HAVENT FOUND ANYTHING
					if($tempQ->found_posts == 0) {
						
						///// LETS GET THIS OUT OF OUR DATABASE
						delete_option('ddp_google_places_api');
						
					}
					
				}
				
			}
			
			global $sitepress;
			
			//// LOOKS FOR WPML FIELDS
			if(isset($sitepress)) {
				
				if(count($sitepress->get_active_languages()) > 1) {
					
					foreach($sitepress->get_active_languages() as $lang) {
						
						if($lang['code'] != $sitepress->get_default_language()) {
							
							//// IF FIELD IS SET
							if(isset($_POST['overlay_markup_wpml_'.$lang['code']])) { update_post_meta($post_id, 'overlay_markup_wpml_'.$lang['code'], $_POST['overlay_markup_wpml_'.$lang['code']]); }
							if(isset($_POST['public_field_description_wpml_'.$lang['code']])) { update_post_meta($post_id, 'public_field_description_wpml_'.$lang['code'], $_POST['public_field_description_wpml_'.$lang['code']]); }
							if(isset($_POST['public_field_price_description_wpml_'.$lang['code']])) { update_post_meta($post_id, 'public_field_price_description_wpml_'.$lang['code'], $_POST['public_field_price_description_wpml_'.$lang['code']]); }
							if(isset($_POST['title_'.$lang['code']])) { update_post_meta($post_id, 'title_'.$lang['code'], $_POST['title_'.$lang['code']]); }
							if(isset($_POST['text_default_'.$lang['code']])) { update_post_meta($post_id, 'text_default_'.$lang['code'], $_POST['text_default_'.$lang['code']]); }
							
						}
						
					}
					
				}
				
			}
			
		  
		} }
		
	}
	
	
	/// THIS FUNCTIONS IS MEANT TO DISPLAY THE GOOGLE SENSITIVITY ERROR
	function display_google_sensitivity_error($loc) {
		
		return add_query_arg('sf_error', urlencode("Your Google Places Sensitivity must be a floating number!"), $loc);
		
	}
	
	add_action( 'admin_notices', 'display_google_sensitivity_error_display' );
	
	function display_google_sensitivity_error_display() {
		
		if(isset($_GET['sf_error'])) { ?>
			
			<div class="error"><p><strong><?php echo urldecode($_GET['sf_error']); ?></strong></p></div>
			
		<?php }
		
	}
	
	

?>