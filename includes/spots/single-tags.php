<?php
	//// GETS TAGS
	$tags = get_the_terms($post->ID, 'spot_tags');
	
	if (is_array($tags)) { ?>
<!-- DAHERO #1667450 STRT -->
		<p class="spot-tags"><strong><?php _e('Plate:', 'btoa'); ?> </strong><?=$tags[0]->name;?></p>
<!-- DAHERO #1667450 STOP -->
<?php } ?>
	<?php }
?>