<?php

	//// GETS VARIABLES
	if(is_page() || is_single()) { $post_id = get_the_ID(); }
	else { $post_id = ''; }
	$bg = get_page_header_bg($post_id);

?>

<style type="text/css">

	#custom-header { background: url(<?php echo $bg; ?>) no-repeat center top; padding: 30px 0; }

</style>

<script type="text/javascript">

	jQuery(document).ready(function() {
		
		jQuery('#custom-header').backstretch('<?php echo $bg; ?>');
		
		hasFormLoadedOnce = true;
		
	});

</script>


<div id="custom-header" class="custom-header-form">

<div id="search-ipad" class="ipad-only"><i class="icon-search"></i> <?php _e('Filter Listings', 'btoa'); ?></div>

	<div class="wrapper row">
        
		<?php
        
            /////////////////////////////////////////////////////////////////
            ///// GETS OUR SEARCH FIELDS
            /////////////////////////////////////////////////////////////////
            
            get_template_part('includes/search/search', 'fields');
        
        ?>
    
    </div>
    <!-- /#custom-header-wrapper/ -->

</div>
<!-- /#custom-header/ -->