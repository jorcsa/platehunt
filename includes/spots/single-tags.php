<?php
	//// GETS TAGS
	$tags = get_the_terms($post->ID, 'spot_tags');
	
	if (is_array($tags)) { ?>
<!-- DAHERO #1816104 REMOVED PLATE FROM HERE -->
	<?php }
?>