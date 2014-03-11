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