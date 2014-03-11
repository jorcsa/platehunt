<?php
	
	//if the user has submitted
	if(isset($_POST['ddp_submit_1']) || isset($_POST['ddp_submit_2'])) {
		
		// UPDATE OUR EDITED TIME
		$time = time();
		update_option('ddp_bpanel_edited_time', $time);
		
		//let's loop trough our fields
		foreach($myOpts as $opt) {
		
			if($opt['tabs'] != NULL) { foreach($opt['tabs'] as $tab) {
				
				if($tab['fields'] != NULL) { foreach($tab['fields'] as $field) {
					
					//if the default value isn't null or its info type
					if($field['type'] != 'info') {
						
						/// IF FIELD IS IMAGE, SAVE HEIGHT AND WIDTH AS WELL
						if($field['type'] == 'image') {
						
							if($_POST['ddp_'.$field['name']] != NULL) {
							
								//updates our options
								update_option('ddp_'.$field['name'].'_image_height', $_POST['ddp_'.$field['name'].'_image_height']);
								update_option('ddp_'.$field['name'].'_image_width', $_POST['ddp_'.$field['name'].'_image_width']);
								update_option('ddp_'.$field['name'], $_POST['ddp_'.$field['name']]);
								
							} else {
								
								update_option('ddp_'.$field['name'], '');
								update_option('ddp_'.$field['name'].'_image_height', '');
								update_option('ddp_'.$field['name'].'_image_width', '');
								
							}
							
						}
						///// IF IT'S A COLOR SAVE OPACITY AS WELL
						elseif($field['type'] == 'color') {
						
							if($_POST['ddp_'.$field['name']] != NULL) {
							
								//updates our options
								update_option('ddp_'.$field['name'], $_POST['ddp_'.$field['name']]);
								update_option('ddp_'.$field['name'].'_opacity', $_POST['ddp_'.$field['name'].'_opacity']);
								
							} else {
								
								update_option('ddp_'.$field['name'], '');
								update_option('ddp_'.$field['name'].'_opacity', $_POST['ddp_'.$field['name'].'_opacity'], '1');
								
							}
							
						} else {
							
							//// IS SET
							if(isset($field['name'])) {
							
								if(isset($_POST['ddp_'.$field['name']])) {
						
									if($_POST['ddp_'.$field['name']] != NULL) {
									
										//updates our option
										update_option('ddp_'.$field['name'], $_POST['ddp_'.$field['name']]);
										
									} else {
										
										update_option('ddp_'.$field['name'], '');
										
									}
									
								} else {
										
										update_option('ddp_'.$field['name'], '');
										
									}
								
							}
							
						}
						
						$ddpStore = 1;
						
					}
					
				} }
				
			} }
			
		}	
		
		//// LETS TRY AND GET LISTIGS WITH NO RATINGS IN CASE THERE ARE ANY
		if(ddp('rating') == 'on') { $args = array(
		
			'posts_per_page' => -1,
			'post_type' => 'spot',
			'meta_query' => array(
			
				array(
				
					'key' => 'rating',
					'value' => 1,
					'compare' => 'NOT EXISTS',
				
				)
			
			),
			'post_status' => 'publish',
		
			);
			
			$rQ = new WP_Query($args);
			
			if($rQ->have_posts()) { while($rQ->have_posts()) { $rQ->the_post(); update_post_meta(get_the_ID(), 'rating', 0); } wp_reset_postdata(); }
			
			}
		
		_btoa_rewrite_rules();
		
	}
	
	//if the user wants to reset to default
	if(isset($_GET['reset_default'])) {
		
		if($_GET['reset_default'] == 1) {
			
			//lets loop trhoug our fields and check if they are already stored, if not store default values
			foreach($myOpts as $opt) {
				
				if($opt['tabs'] != NULL) { foreach($opt['tabs'] as $tab) {
					
					if($tab['fields'] != NULL) { foreach($tab['fields'] as $field) {
						
						//if its not an info field
						if($field['type'] != 'info') {
							
							//if the default is not null
							if($field['default'] != NULL) {
								
								update_option('ddp_'.$field['name'], addslashes($field['default']));
								
							}
							
							// if the default is null reset the field to blank
							else {
								
								update_option('ddp_'.$field['name'], '');
								
							}
								
							//// IF ITS A COLOR WE NEED TO SAVE OPACITY AS WELL
							if($field['type'] == 'color') {
								
								if($field['opacity'] != NULL) { update_option('ddp_'.$field['name'].'_opacity', addslashes($field['opacity'])); }
								
							}
							
						}
						
					} }
					
				} }
				
			}
	
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.get_bloginfo('wpurl').'/wp-admin/admin.php?page=DDPanel">';
	
			exit();
			
		}
		
	}
	
	function time_elapsed_string($ptime) {
		$etime = time() - $ptime;
		
		if ($etime < 1) {
			return '0 seconds';
		}
		
		$a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
					30 * 24 * 60 * 60       =>  'month',
					24 * 60 * 60            =>  'day',
					60 * 60                 =>  'hour',
					60                      =>  'minute',
					1                       =>  'second'
					);
		
		foreach ($a as $secs => $str) {
			$d = $etime / $secs;
			if ($d >= 1) {
				$r = round($d);
				return $r . ' ' . $str . ($r > 1 ? 's' : '');
			}
		}
	}

?>