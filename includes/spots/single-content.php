

<div class="one-fourth last right">

	<?php do_action('single_spot_before_address', get_the_ID(), 'before_address'); ?>

	<h4 class="content-title"><?php the_title() ?></h4>
    
    <h5 class="content-address"><?php echo get_post_meta(get_the_ID(), 'address', true); ?></h5>
	
	<?php do_action('single_spot_after_address', get_the_ID(), 'after_address'); ?>
    
    <?php
	
		//////////////////////////////////////////////////
		///// GETS SEARCH FIELDS
		//////////////////////////////////////////////////
		
		if(ddp('rating') == 'on') { get_template_part('includes/spots/single', 'rating'); }
	
	?>
    
    <?php
	
		//////////////////////////////////////////////////
		///// GETS SEARCH FIELDS
		//////////////////////////////////////////////////
		
		get_template_part('includes/spots/loop', 'search');
	
	?>
	
	<?php do_action('single_spot_after_search', get_the_ID(), 'after_search'); ?>
    
    <?php
	
		//////////////////////////////////////////////////
		///// GETS CUSTOM FIELDS
		//////////////////////////////////////////////////
		
		get_template_part('includes/spots/single', 'custom-fields');
	
	?>
	
	<?php do_action('single_spot_after_custom_fields', get_the_ID(), 'after_custom'); ?>
    
    <?php
	
		//////////////////////////////////////////////////
		///// GETS TAGS
		//////////////////////////////////////////////////
		
		get_template_part('includes/spots/single', 'tags');
	
	?>

</div>
<!-- .one-fourth -->

<div class="three-fourths">

<?php do_action('single_spot_before_content', get_the_ID(), 'before_content'); ?>

	<?php the_content(); ?>
	
<?php do_action('single_spot_after_content', get_the_ID(), 'after_content'); ?>
                
                	<?php
					
						//////////////////////////////////////////////////////////////////
						///// GETS OUR PUBLIC PROFILE AREA - IF AVAILABLE
						//////////////////////////////////////////////////////////////////
						global $current_user;
						if(ddp('pbl_profile') == 'on') { if(get_the_author_meta('public_profile', $current_user->ID) == 'on') { get_template_part('includes/spots/single', 'user'); } }
					
					?>

</div>