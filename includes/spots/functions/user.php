<?php

	///// ADDS FIELDS TO OUR USER IN THE BACK END - PROFILE PICTURE  AND TELEPHONE
	add_action( 'edit_user_profile', 'add_custom_fields_user' );
	add_action( 'show_user_profile', 'add_custom_fields_user' );
	
	function add_custom_fields_user($user) {
		
		
		include('meta/user.php');
		
	}
	
	
	
	///// SAVES FIELDS
	add_action( 'personal_options_update', 'save_custom_fields_user' );
	add_action( 'edit_user_profile_update', 'save_custom_fields_user' );
	 
	function save_custom_fields_user( $user_id ) {
		
		if ( !current_user_can( 'edit_user', $user_id ) )
			return FALSE;
		
		update_user_meta( $user_id, 'phone', $_POST['phone'] );
		update_user_meta( $user_id, 'position', $_POST['position'] );
		update_user_meta( $user_id, 'profile_pic', $_POST['profile_pic'] );
		if(isset($_POST['public_profile'])) { update_user_meta( $user_id, 'public_profile', 'on'); } else { update_user_meta( $user_id, 'public_profile', ''); }
		
	}
	
	
	
	
	////////  GETS USER PROFILE PIC
	function _sf_get_user_profile_pic($user_id) {
		
		//// CHECKS IF HE HAS A PROFILE PIC
		if($image = wp_get_attachment_image_src(get_the_author_meta( 'profile_pic', $user_id ), 'full')) {
			
			return $image[0];
			
		} else {
			
			//// RETURN PLACEHOLDER
			return ddp('pbl_profile_placeholder');
			
		}
		
	}

?>