

	<?php
	
		//// LETS GET ALL OUR SEARCH FIELDS
		$custom_fields = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), '_sf_custom_fields', true)));
		
		///// IF WE HAVE CUSTOM FIELD
		if(is_object($custom_fields)) :
	
	?>
    
    	<ul class="spot-search-fields">
        
        	<?php foreach($custom_fields as $_field) : ?>
            
            	<li><strong><?php echo $_field->label ?>:</strong> <?php echo $_field->value; ?></li>
            
            <?php endforeach; ?>
        
        </ul>
        <!-- .spot-custom-fields -->
    
    <?php endif; ?>