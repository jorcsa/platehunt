<?php

	//// GETS VARIABLES
	if(is_page() || is_single()) { $post_id = get_the_ID(); }
	$bg = get_page_header_bg($post_id);
	$slogan = get_post_meta($post_id, 'fancy_slogan', true);
	$color = get_post_meta($post_id, 'header_color', true);
	$title = get_post_meta($post_id, 'header_title', true);

?>


<style type="text/css">

	#custom-header { background: url(<?php echo $bg; ?>) no-repeat center top; }
	#custom-header h2, #custom-header h4,
	#custom-header h2 a, #custom-header h4 a { color: <?php echo $color; ?> }

</style>

<script type="text/javascript">

	jQuery(document).ready(function() {
		
		jQuery('#custom-header').backstretch('<?php echo $bg; ?>');
		
	});

</script>


<div id="custom-header">

	<div class="wrapper">
    
    	<?php if($title != '') : ?><h2><?php echo $title; ?></h2><?php endif; ?>
    	<?php if($slogan != '') : ?><h4><?php echo $slogan; ?></h4><?php endif; ?>
    
    </div>
    <!-- /#custom-header-wrapper/ -->

</div>
<!-- /#custom-header/ -->