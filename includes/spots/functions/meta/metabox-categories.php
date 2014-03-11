<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />

<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

	jQuery(document).ready(function() {
		
		jQuery('#cat_title').iphoneStyle();
		
	});

</script>

<?php

	$screen = get_current_screen();

?>

<?php if($screen->taxonomy == 'spot_cats') : //// ONLY SHOW THESE IN CATEGORIES ?>


<div class="form-field">

		<label for="term_meta[default_pin]">Default Pin</label>
        
        <select name="term_meta[default_pin]" id="term_meta[default_pin]" class="widefat">
		
			<?php
            
                //// GETS OUR TERMS
                $pins = array(
				
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
				
				);
				
				foreach($pins as $pin) :
            
            ?>
        
        		<option value="<?php echo $pin ?>"><?php echo $pin ?></option>
            
            <?php endforeach; ?>
        
        </select>
        
		<p class="description"><?php _e('Default pin for this category', 'btoa'); ?></p>
		
</div>

<div class="form-field">

		<label for="term_meta[custom_pin]"><?php _e('Custom Pin', 'btoa'); ?></label>
        
        <input type="text" name="term_meta[custom_pin]" id="term_meta[custom_pin]" value="">
        
		<p class="description"><?php _e('Custom pin. Overrides default pin', 'btoa'); ?></p>
		
</div>

<div class="form-field">

		<label for="term_meta[custom_pin]"><?php _e('Category Search Form', 'btoa'); ?></label>
    
    	<?php
		
			$args = array(
			
				'post_type' => 'search_form',
				'posts_per_page' => -1,
			
			);
			
			$tQ = new WP_Query($args);
			
			if($tQ->have_posts()) : ?>
            
            	<select name="term_meta[search_form]" id="search_form">
                
            	<option value=""><?php _e('Same as homepage', 'btoa'); ?></option>
            
            <?php while($tQ->have_posts()): $tQ->the_post(); ?>
            
            	<option value="<?php the_ID() ?>"><?php the_title(); ?></option>
            
            <?php endwhile; wp_reset_postdata(); ?>
            
            </select>
            
        <?php endif; ?>
        
		<p class="description"><?php _e('Which search form to display in this category page.', 'btoa'); ?></p>
		
</div>

<?php endif; ?>

<div class="form-field">

		<label for="term_meta[cat_title]"><?php _e('Display Category Title:', 'btoa'); ?></label>
        
       <p style="position: relative; width: 70px; margin: 0 0 20px;"><input type="checkbox" name="term_meta[cat_title]" id="cat_title"<?php if($term_meta['cat_title'] == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</p>
        
		<p class="description"><?php _e('Whether to or not to display the category title on top of the page in the category page', 'btoa'); ?></p>
		
</div>