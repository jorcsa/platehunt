<?php

	//// OUR VARIABLES
	$price_submission_payment = get_post_meta($post->ID, 'price_submission_payment', true);
	$price_images = get_post_meta($post->ID, 'price_images', true);
	$price_images_cart = get_post_meta($post->ID, 'price_images_cart', true);
	$price_tags = get_post_meta($post->ID, 'price_tags', true);
	$price_tags_cart = get_post_meta($post->ID, 'price_tags_cart', true);
	$price_custom_pin = get_post_meta($post->ID, 'price_custom_pin', true);
	$price_custom_pin_cart = get_post_meta($post->ID, 'price_custom_pin_cart', true);
	$price_custom_fields = get_post_meta($post->ID, 'price_custom_fields', true);
	$price_custom_fields_cart = get_post_meta($post->ID, 'price_custom_fields_cart', true);
	$price_contact_form = get_post_meta($post->ID, 'price_contact_form', true);
	$price_contact_form_cart = get_post_meta($post->ID, 'price_contact_form_cart', true);

?>

<?php if(ddp('price_submission') != '' && ddp('price_submission') != '0') : //// IF USER HAS TO PAY FOR THE SUBMISSION ?>

	<p class="cart-field">
    <label><?php _e('Submission payment', 'btoa'); ?></label>
    <input type="checkbox" name="price_submission_payment" id="price_submission_payment" <?php if($price_submission_payment == 'on') { echo 'checked="checked"'; } ?> />
	</p>
    
<?php endif; ?>



<?php if(ddp('price_images') != '' && ddp('price_images') != '0') : //// IF USER HAS TO PAY FOR THE SUBMISSION ?>

	<p class="cart-field">
    <label><?php _e('Extra images in cart', 'btoa'); ?></label>
    <input type="checkbox" name="price_images_cart" id="price_images_cart" <?php if($price_images_cart == 'on') { echo 'checked="checked"'; } ?> />
    
	<br /><br />
    
    <label><?php _e('Extra images payment', 'btoa'); ?></label>
    <input type="checkbox" name="price_images" id="price_images" <?php if($price_images == 'on') { echo 'checked="checked"'; } ?> />
	</p>
    
<?php endif; ?>



<?php if(ddp('price_tags') != '' && ddp('price_tags') != '0') : //// IF USER HAS TO PAY FOR THE SUBMISSION ?>

	<p class="cart-field">
    <label><?php _e('Extra tags in cart', 'btoa'); ?></label>
    <input type="checkbox" name="price_tags_cart" id="price_tags_cart" <?php if($price_tags_cart == 'on') { echo 'checked="checked"'; } ?> />
	
    <br /><br />
    
    <label><?php _e('Extra tags payment', 'btoa'); ?></label>
    <input type="checkbox" name="price_tags" id="price_tags" <?php if($price_tags == 'on') { echo 'checked="checked"'; } ?> />
	</p>
    
<?php endif; ?>



<?php if((ddp('price_custom_pin') != '' && ddp('price_custom_pin') != '0') && (ddp('pbl_custom_pin') == 'on')) : //// IF USER HAS TO PAY FOR CUSTOM PIN ?>

	<p class="cart-field">
    <label><?php _e('Custom Pin in cart', 'btoa'); ?></label>
    <input type="checkbox" name="price_custom_pin_cart" id="price_custom_pin_cart" <?php if($price_custom_pin_cart == 'on') { echo 'checked="checked"'; } ?> />
	
    <br /><br />
    
    <label><?php _e('Custom Pin payment', 'btoa'); ?></label>
    <input type="checkbox" name="price_custom_pin" id="price_custom_pin" <?php if($price_custom_pin == 'on') { echo 'checked="checked"'; } ?> />
	</p>
    
<?php endif; ?>



<?php if((ddp('price_custom_fields') != '' && ddp('price_custom_fields') != '0') && (ddp('pbl_custom_fields') == 'on')) : //// IF USER HAS TO PAY FOR CUSTOM FIELDS ?>

	<p class="cart-field">
    <label><?php _e('Custom Fields in cart', 'btoa'); ?></label>
    <input type="checkbox" name="price_custom_fields_cart" id="price_custom_fields_cart" <?php if($price_custom_fields_cart == 'on') { echo 'checked="checked"'; } ?> />
	
    <br /><br />
    
    <label><?php _e('Custom Fields payment', 'btoa'); ?></label>
    <input type="checkbox" name="price_custom_fields" id="price_custom_fields" <?php if($price_custom_fields == 'on') { echo 'checked="checked"'; } ?> />
	</p>
    
<?php endif; ?>



<?php if((ddp('price_contact_form') != '' && ddp('price_contact_form') != '0') && (ddp('pbl_contact_form') == 'on')) : //// IF USER HAS TO PAY FOR CUSTOM FIELDS ?>

	<p class="cart-field">
    <label><?php _e('Contact Form in cart', 'btoa'); ?></label>
    <input type="checkbox" name="price_contact_form_cart" id="price_contact_form_cart" <?php if($price_contact_form_cart == 'on') { echo 'checked="checked"'; } ?> />
	
    <br /><br />
    
    <label><?php _e('Contact Form payment', 'btoa'); ?></label>
    <input type="checkbox" name="price_contact_form" id="price_contact_form" <?php if($price_contact_form == 'on') { echo 'checked="checked"'; } ?> />
	</p>
    
<?php endif; ?>


<?php

	$orig_post = $post;

	///// NOW WE GET ALL OUR SEARCH FIELDS THAT HAVE A PRICE SET
	$args = array(
	
		'post_type' => 'search_field',
		'posts_per_page' => -1,
		'meta_query' => array(
		
			array(
			
				'key' => 'public_field_price',
				'value' => '0',
				'compare' => '>',
				'type' => 'NUMERIC',
			
			)
		
		),
	
	);
	
	$fieldsQ = new WP_Query($args);
	
	while($fieldsQ->have_posts()) : $fieldsQ->the_post();

?>

	<p class="cart-field">
    <label><?php the_title(); ?> <?php _e('in cart', 'btoa'); ?></label>
    <input type="checkbox" name="_sf_<?php the_ID(); ?>_cart" id="_sf_<?php the_ID(); ?>_cart" <?php if(get_post_meta($orig_post->ID, '_sf_'.get_the_ID().'_cart', true) == 'on') { echo 'checked="checked"'; } ?> />
	
    <br /><br />
    
    <label><?php the_title(); ?> <?php _e('payment', 'btoa'); ?></label>
    <input type="checkbox" name="_sf_<?php the_ID(); ?>" id="_sf_<?php the_ID(); ?>" <?php if(get_post_meta($orig_post->ID, '_sf_'.get_the_ID(), true) == 'on') { echo 'checked="checked"'; } ?> />
	</p>

<?php endwhile; wp_reset_postdata(); $post = $orig_post; ?>