<?php global $post; $current_user = get_user_by( 'id', $post->post_author); ?>

<div id="user-content">

	<?php
	
		//// USER IMAGE
		$user_picture = _sf_get_user_profile_pic($current_user->ID);
		
		$name = $current_user->display_name;
	
	?>
	
	<img src="<?php echo ddTimthumb($user_picture, 240, 280) ?>" alt="" title="" />
	
	<div id="user-content-area">
	
		<h4><?php echo $name; ?></h4>
		
		<?php if(get_the_author_meta( 'position', $current_user->ID ) != '') : ?><h5><?php echo get_the_author_meta( 'position', $current_user->ID ); ?></h5><?php endif; ?>
		
		<?php
		
			$phone = get_the_author_meta( 'phone', $current_user->ID );
			$email = $current_user->user_email;
			
			if($phone != '' || $position != '') :
		
		?>
			
			<div class="user-info">
			
				<?php if($phone != '') : ?>
				
					<span class="phone" onclick="jQuery(this)._sf_show_user_info();"><i class="icon-phone"></i> <span class="init"><?php echo substr($phone, 0, (round(strlen($phone)/2))); ?>...</span><span class="full hidden"><?php echo $phone; ?></span></span>
				
				<?php endif; ?>
				
				<span class="email" onclick="jQuery(this)._sf_show_user_info();"><i class="icon-mail"></i> <span class="init"><?php echo array_shift(explode('@', $email)); ?>@...</span><span class="full hidden"><?php echo $email; ?></span></span>
			
			</div>
			<!-- #user-info -->
		
		<?php endif; ?>
		
		<?php if(get_the_author_meta( 'description', $current_user->ID ) != '') : ?>
		
			<p><?php echo get_the_author_meta( 'description', $current_user->ID ) ?></p>
			
		<?php endif; ?>
	
	</div>
	<!-- #user-content-areay -->

</div>
<!-- #user-content -->