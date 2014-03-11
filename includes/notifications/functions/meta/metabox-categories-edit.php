<?php

	//// TERM ID
	$t_id = $term->term_id;
	
	//// TERM VALUES
	$term_meta = get_option('taxonomy_'.$t_id);
	if(!isset($term_meta['default_pin'])) { $term_meta['default_pin'] = 'default'; }
	if(empty($term_meta['default_pin'])) { $term_meta['default_pin'] = 'default'; }
	if(!isset($term_meta['search_form'])) { $term_meta['search_form'] = ''; }
	if(empty($term_meta['search_form'])) { $term_meta['search_form'] = ''; }

?>

<style type="text/css">

	.pins li { cursor: pointer; background: #fafafa; float: left; width: 40px; height: 40px; margin: 0 10px 10px 0; text-align: center; padding: 10px; border: 1px solid #dfdfdf;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -ms-border-radius: 3px; -o-border-radius: 3px; border-radius: 3px;
	-webkit-transition: all .11s ease-in-out; -moz-transition: all .11s ease-in-out; -ms-transition: all .11s ease-in-out; -o-transition: all .11s ease-in-out; transition: all .11s ease-in-out; }
	.pins li img { display: block; margin: 6px auto 0; }
	.pins li.current { border: 1px solid #aaa !important; background: #d0d0d0 !important; }
	.pins li:hover { border-color: #ccc; background: #f0f0f0; }

</style>

<script type="text/javascript">

	jQuery(document).ready(function() {
		
		//// WHEN USER CLCIKS A PIN
		jQuery('ul.pins li').click(function() {
			
			/// REMOVES CURRENT
			jQuery('ul.pins li.current').removeClass('current');
			jQuery(this).addClass('current');
			
			//// UPDATES INPUT
			var selected_pin = jQuery(this).attr('title');
			jQuery('#default_pin').val(selected_pin);
			
		});
		
	});

</script>

<tr class="form-field">

	<th scope="row" valign="top"><label for="term_meta[default_pin]">Default Pin</label></th>
	
	<td>
    
    	<input type="hidden" name="term_meta[default_pin]" id="default_pin" value="<?php echo esc_attr( $term_meta['default_pin'] ) ? esc_attr( $term_meta['default_pin'] ) : ''; ?>" />
        
        <ul class="pins">
        
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
				
				if($pin == 'default') { echo '<li class="default'; if($term_meta['default_pin'] == 'default') { echo ' current'; } echo '">Use Default</li>'; }
				else {
		?>
        
        	<li class="<?php echo $pin; ?><?php if($term_meta['default_pin'] == $pin) { echo ' current'; } ?>" title="<?php echo $pin; ?>"><img src="<?php echo get_template_directory_uri() ?>/images/pins/<?php echo $pin; ?>.png" /></li>
        
        <?php } endforeach; ?>
        
        
        
        </ul>
        
        <div class="clear"></div> 
        
		<p class="description"><?php _e('Default pin for this category', 'btoa'); ?></p>
		
	</td>
		
</tr>

<tr class="form-field">

	<th scope="row" valign="top"><label for="term_meta[custom_pin]">Custom Pin</label></th>
	
	<td>
	
		<input type="text" name="term_meta[custom_pin]" id="term_meta[custom_pin]" value="<?php echo esc_attr( $term_meta['custom_pin'] ) ? esc_attr( $term_meta['custom_pin'] ) : ''; ?>" />
		<p class="description"><?php _e('Custom pin. Overrides default pin', 'btoa'); ?></p>
		
	</td>
		
</tr>

<tr class="form-field">

	<th scope="row" valign="top"><label for="term_meta[search_form]">Category Search Form</label></th>
	
	<td>
    
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
            
            	<option value="<?php the_ID() ?>"<?php if($term_meta['search_form'] == get_the_ID()) { echo ' selected="selected"'; } ?>><?php the_title(); ?></option>
            
            <?php endwhile; wp_reset_postdata(); ?>
            
            </select>
            
        <?php endif; ?>
	
		<p class="description"><?php _e('Which search form to display in this category page.', 'btoa'); ?></p>
		
	</td>
		
</tr>