<?php
/**
 * This file is has all the hooks need to interact with WPML
 *
 * @author BTOA
 * @version 1.35.5
 */


	////////////////////////////////////////
	//// WEHENEVER WE ADD A NEW POST, LETS
	//// DUPLICATE IT IN OTHER LANGUAGES
	////////////////////////////////////////
	
	add_action('save_post', '_sf_wpml_duplicate_new_spots');
	
	function _sf_wpml_duplicate_new_spots($post_id) {
		
		global $sitepress, $iclTranslationManagement;
		
		//// NO AUTOSAVE OR REVISION
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) { return $post_id; }
		
		$post = get_post($post_id);
		
		//// LETS MAKE SURE IT IS A SPOT AND WE HAVE MORE THAN ONE LANGUAGE
		if(get_post_type($post_id) == 'spot' && count($sitepress->get_active_languages()) > 1 && $post->post_status != 'auto-draft' && $post->post_status != 'trash') {
			
			///// OUR MASTER POST ID
			$master_post_id = $post_id;
			$master_post = get_post($post_id);
			
			//// ORIGINAL LANGUAGE
			$language_details_original = $sitepress->get_element_language_details($master_post_id, 'post_' . $master_post->post_type);
			
			///// LETS UNHOOK THE ACTION SO IT DOESNT GO FOREVER
			remove_action('save_post', '_sf_wpml_duplicate_new_spots');
			
			///// LETS LOOP OUR LANGUAGES AND CHECK IF WE HAVE THAT TRANSLATION
			foreach($sitepress->get_active_languages() as $lang => $details) {
				
				//// IF WE CANT FIND THE LANGUAGE
				if(!icl_object_id($post_id, 'spot', false, $lang)) {
					
					//// MAKES A DUPLICATE
					$iclTranslationManagement->make_duplicate($master_post_id, $lang); 
					
					//// NOW WE NEED TO MAKE SURE THAT THE TRANSLATION IS INDEPENDENT FROM THE PARENT POST,
					//// WE'LL TAKE CARE OF UPDATING CONTENT FURTHER ON - THIS IS NECESSARY FOR OUR
					//// FRONT END SUBMISSION TRANSLATIONS TO WORK PROPERLY
					$iclTranslationManagement->reset_duplicate_flag(icl_object_id($post_id, 'spot', false, $lang));
					
				}
				
			}  // ENDS FOREACH
			
			//// LETS REHOOK IT
			add_action('save_post', '_sf_wpml_duplicate_new_spots');
			
		}
		
	}
	
	
	


	////////////////////////////////////////
	//// WHEN WE EDIT A SPOT, WE NEED TO
	//// TRANSFER THE COMMON DATA INTO THE
	//// OTHER VERSIONS
	////////////////////////////////////////
	
	add_action('save_post', '_sf_wpml_update_spot_translations', 10, 2);
	
	function _sf_wpml_update_spot_translations($post_id, $post) {
		
		global $sitepress, $iclTranslationManagement;
		
		//// NO AUTOSAVE OR REVISION
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) { return $post_id; }
		
		//// LETS MAKE SURE IT IS A SPOT AND WE HAVE MORE THAN ONE LANGUAGE
		if(get_post_type($post_id) == 'spot' && count($sitepress->get_active_languages()) > 1 && $post->post_status != 'auto-draft' && $post->post_status != 'trash') {
			
			//// GETS OUR CURRENT LANGUAGE
			$cur_language = $sitepress->get_default_language();
			
			//// GETS ALL LANGUAGES ALL LOOPS IT
			$all_langs = $sitepress->get_active_languages();
			foreach($all_langs as $lang => $description) {
				
				//// NOW LETS GET THE TRANSLATED POST HERE
				$translated_post = icl_object_id($post_id, 'spot', false, $lang);
				
				///// IF IT'S NOT THE CURRENT POST
				if($translated_post != $post_id) {
					
					
				
					////////////////////////////////////////
					//// LETS UPDATE SOME IMPORTANT METABOXES
					////////////////////////////////////////
					update_post_meta($translated_post, 'latitude', get_post_meta($post_id, 'latitude', true));
					update_post_meta($translated_post, 'longitude', get_post_meta($post_id, 'longitude', true));
					update_post_meta($translated_post, 'pin', get_post_meta($post_id, 'pin', true));
					update_post_meta($translated_post, '_sf_gallery_images', get_post_meta($post_id, '_sf_gallery_images', true));
					update_post_meta($translated_post, 'contact_form', get_post_meta($post_id, 'contact_form', true));
					update_post_meta($translated_post, 'featured', get_post_meta($post_id, 'featured', true));
					
					
				
					////////////////////////////////////////
					//// LETS UPDATE EXPIRE INFORMATION
					////////////////////////////////////////
					
					//// EXPIRY DATE
					if(get_post_meta($post_id, 'expiry_date', true) != '') {
						
						update_post_meta($translated_post, 'expiry_date', get_post_meta($post_id, 'expiry_date', true));
						
					} else {
						
						update_post_meta($translated_post, 'expiry_date', '');
						
					}
					
					/////FEATURED EXPIRY
					if(get_post_meta($post_id, 'featured_payment_expire', true) != '') {
						
						update_post_meta($translated_post, 'featured_payment_expire', get_post_meta($post_id, 'featured_payment_expire', true));
						
					} else {
						
						update_post_meta($translated_post, 'featured_payment_expire', '');
						
					}
					
					
				
					////////////////////////////////////////
					//// LETS UPDATE CART INFORMATION
					////////////////////////////////////////
					if(ddp('price_submission') != '' && ddp('price_submission') != '0') { update_post_meta($translated_post, 'price_submission_payment', get_post_meta($post_id, 'price_submission_payment', true)); }
					if(ddp('price_images') != '' && ddp('price_images') != '0') {update_post_meta($translated_post, 'price_images', get_post_meta($post_id, 'price_images', true)); }
					if(ddp('price_images') != '' && ddp('price_images') != '0') {update_post_meta($translated_post, 'price_images_cart', get_post_meta($post_id, 'price_images_cart', true)); }
					if(ddp('price_featured') != '' && ddp('price_featured') != '0') {update_post_meta($translated_post, 'price_featured', get_post_meta($post_id, 'price_featured', true)); }
					if(ddp('price_featured') != '' && ddp('price_featured') != '0') {update_post_meta($translated_post, 'price_featured_cart', get_post_meta($post_id, 'price_featured_cart', true)); }
					if(ddp('price_tags') != '' && ddp('price_tags') != '0') {update_post_meta($translated_post, 'price_tags', get_post_meta($post_id, 'price_tags', true)); }
					if(ddp('price_tags') != '' && ddp('price_tags') != '0') {update_post_meta($translated_post, 'price_tags_cart', get_post_meta($post_id, 'price_tags_cart', true)); }
					if((ddp('price_custom_pin') != '' && ddp('price_custom_pin') != '0') && (ddp('pbl_custom_pin') == 'on')) { update_post_meta($translated_post, 'price_custom_pin', get_post_meta($post_id, 'price_custom_pin', true)); }
					if((ddp('price_custom_pin') != '' && ddp('price_custom_pin') != '0') && (ddp('pbl_custom_pin') == 'on')) {update_post_meta($translated_post, 'price_custom_pin_cart', get_post_meta($post_id, 'price_custom_pin_cart', true)); }
					if((ddp('price_custom_fields') != '' && ddp('price_custom_fields') != '0') && (ddp('pbl_custom_fields') == 'on')) {update_post_meta($translated_post, 'price_custom_fields', get_post_meta($post_id, 'price_custom_fields', true)); }
					if((ddp('price_custom_fields') != '' && ddp('price_custom_fields') != '0') && (ddp('pbl_custom_fields') == 'on')) {update_post_meta($translated_post, 'price_custom_fields_cart', get_post_meta($post_id, 'price_custom_fields_cart', true)); }
					if((ddp('price_contact_form') != '' && ddp('price_contact_form') != '0') && (ddp('pbl_contact_form') == 'on')) {update_post_meta($translated_post, 'price_contact_form', get_post_meta($post_id, 'price_contact_form', true)); }
					if((ddp('price_contact_form') != '' && ddp('price_contact_form') != '0') && (ddp('pbl_contact_form') == 'on')) {update_post_meta($translated_post, 'price_contact_form_cart', get_post_meta($post_id, 'price_contact_form_cart', true)); }
					
					
				
					////////////////////////////////////////
					//// WE NEED TO COPY OVER THE SEARCH FIELDS SINCE THEY ARE NOT TRASNALATED BY THE USER
					//// LOOPS SEARCH FIELDS
					////////////////////////////////////////
					$args = array(
					
						'post_type' => 'search_field',
						'posts_per_page' => -1,
						'post_status' => 'publish',
					
					);
					
					
				
					////////////////////////////////////////
					//// LETS UPDATE REVIEWS IF SET
					////////////////////////////////////////
					if(ddp('rating') == 'on') {
						
						update_post_meta($translated_post, 'rating', get_post_meta($post_id, 'rating', true));
						update_post_meta($translated_post, 'rating_count', get_post_meta($post_id, 'rating_count', true));
						
					}
					
					$sQ = new WP_Query($args);
					
					if($sQ->have_posts()) { while($sQ->have_posts()) { $sQ->the_post();
					
						$meta = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
					
						//// CHECKS FOR FIELD VALUE AND UPDATES IT
						if($meta != '') { update_post_meta($translated_post, '_sf_field_'.get_the_ID(), $meta); }
						else { update_post_meta($translated_post, '_sf_field_'.get_the_ID(), ''); }
						
						//////////////////////////////////////////
						//// LETS CHECK FOR THE PRICE INFORMATION
						//////////////////////////////////////////
						
						///// ONLY IF THE FIELD HAS A PRICE SET
						$price_meta = get_post_meta(get_the_ID(), 'public_field_price', true);
						if($price_meta != 0 || $price_meta != '') {
					
							//// CHECKS FOR FIELD VALUE AND UPDATES IT
							if($price_meta != '') { 
							
								update_post_meta($translated_post, '_sf_'.get_the_ID(), 'on');
								update_post_meta($translated_post, '_sf_'.get_the_ID().'_cart', 'on');
								
							} else {
							
								update_post_meta($translated_post, '_sf_'.get_the_ID(), '');
								update_post_meta($translated_post, '_sf_'.get_the_ID().'_cart', '');
								
							}
							
						}
					
					} }
					
				}
				
			}
			
		}
		
	}
	
	
	
	
	
	///// GETS FLAG URL
	function _sf_get_flag($flag) {
		
		//// GTES THE FLAG URL
		if($flag->from_template) {
			
			$wp_upload_dir = wp_upload_dir();
			$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
			
		} else {
			
			$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
			
		}
		
		return $flag_url;
		
	}
	
	
	
	///// HERE WE ARE GOING TO SET UP OUR WPML SUBPAGE SO WE CAN SYNC OUR SPOTS
	add_action('admin_menu', '_sf_wpml_add_spots_sync_page');
	
	function _sf_wpml_add_spots_sync_page() {
		
		add_submenu_page('theme-panel', 'Sync Spot Translations', 'WPML Listings Sync', 'add_users', 'theme-panel-sync-spots', '_sf_wpml_add_spots_sync_page_function');
		
	}
	
	function _sf_wpml_add_spots_sync_page_function() {
		
		//// IF OUR SUBMIT IS SET
		if(isset($_POST['submit'])) { ?>
			
			<h2>Duplicating Untranslated Listings...</h2>
			
		<?php
		
			global $sitepress, $iclTranslationManagement;
		
			//// LETS GET ALL OUR LISTINGS
			$args = array(
			
				'post_type' => 'spot',
				'posts_per_page' => -1,
				'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'trash'),
			
			);
			
			$sC = new WP_Query($args);
			
			///// LOOPS ALL FOUND POSTS
			if($sC->have_posts()) {
				
				while($sC->have_posts()) {
					
					$sC->the_post();
					
					echo '<p> Translating <strong>'.get_the_title().'</strong> (<strong>ID:</strong> '.get_the_ID().' -- <strong>Status:</strong> '.get_post_status(get_the_ID()).')';
					
					echo '<ul style="margin-top: 0;">';
					
					//// NOW THAT WE HAVE THE PSOT, LETS TRY AN GET THE TRANSLATIONS
					foreach($sitepress->get_active_languages() as $lang => $details) {
						
						if($lang != $sitepress->get_default_language()) {
						
							//// TRIES TO GET THE TRANSLATION
							if(is_numeric(icl_object_id(get_the_ID(), 'spot', false, $lang))) {
								
								echo '<li><strong>'.$details['display_name'].': </strong>Already Translated</li>';
								
							} else {
								
								echo '<li><strong>'.$details['display_name'].': </strong><strong style=" color: #ff0000;">Translation Missing - Translated</strong></li>';
								
								//// LETS EXECUTE THE SAVE POST FUNCTION, THIS WAY WE CAN TRANSLATE IT AUTOMATICALLY
								do_action('save_post', get_the_ID(), get_post(get_the_ID()));
								
							}
						
						}
						
					}
					
					echo '</ul></p><br>';
					
				} /// END WHILE
				
				wp_reset_postdata();
				
			} else {
				
				echo 'Could not find any listings.';
				
			}
		
		} else {
		
		//// ADDS IN THE BUTTON ?>
		
		<script type="text/javascript">
		
			jQuery(document).ready(function() {
				
			});
		
		</script>
		
		<form action="" method="post" id="duplicate-listings">
		
			<h2>Sync and Duplicate All Untranslated Listings</h2>
		
			<p><input type="submit" name="submit" id="submit" class="button button-primary" value="Sync Now"></p>
			
			<p>By clicking this button, SpotFinder will find all listings that are untranslated and duplicate them. Use this when you first install WPML and already have untranslated content.</p>
		
		</form>
		
	<?php }
	
	
	}
	


?>