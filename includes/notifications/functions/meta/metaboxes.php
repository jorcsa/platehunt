<?php

	//// OUR VARIABLE
	$email = get_post_meta($post->ID, 'email', true);
	$key = get_post_meta($post->ID, 'key', true);

?>

<!-- /CSS FILE/ -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/icons.css" media="screen" />

<!-- /JAVASCRIPT FILE/ -->
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/select.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/gmap3.min.js"></script>
<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?sensor=false'></script>

<div class="bpanel-tabbed-meta">
    
    <ul class="tabbed tabbed-fields">
        
        <li class="current">
            
            <div class="one-fifth"><label for="email"><?php _e('User Email:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="email" id="email" value="<?php echo $email ?>" class="widefat" disabled="disabled" style="margin-bottom: 5px;" /></div>
            <div class="two-fifths description last"><?php _e('User Email', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="key"><?php _e('Subscription Key:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="key" id="key" value="<?php echo $key ?>" class="widefat" disabled="disabled" style="margin-bottom: 5px;" /></div>
            <div class="two-fifths description last"><?php _e('Key for unsubscription', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <?php
			
				$all_fields = get_post_meta($post->ID, 'all_fields', true);
			
				$the_post = $post;
			
				//// LETS GET ALL OUR SEARCH FIELDS AND SEE WHICH ONES WE HAVE SELECTED TO THIS POST
				//// BUT ONLY GETS THE POSTS IN OUR ALL FIELDS ARRAY
				$args = array(
				
					'post_type' => 'search_field',
					'posts_per_page' => -1,
					'post__in' => $all_fields,
				
				);
				
				$sQ = new WP_Query($args);
				
				if($sQ->have_posts()) : while($sQ->have_posts()) : $sQ->the_post();
				
				//// TRIES TO GET THIS SEARCH FIELD META
				$field = get_post_meta($the_post->ID, '_sf_field_'.get_the_ID(), true);
				
				//// IF FIELD IS SET
				if($field != '') :
			
			?>
            
            <div class="one-fifth"><label for="email"><?php the_title(); ?></label></div>
            <div class="two-fifths"><input type="text" name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>" value="<?php echo $field; ?>" class="widefat" disabled="disabled" style="margin-bottom: 5px;" /></div>
            <div class="two-fifths description last"></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <?php endif; /// IF WE HAVE THIS FIELD - ENDS ?>
            
            
            <?php endwhile; wp_reset_postdata(); endif; $post = $the_post; ?>
            
            <div class="clear"></div>
        
        </li>
    
    </ul>
    <!-- /.tabbed/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->

</div>