<?php
	//// GETS TAGS
	$tags = get_the_terms($post->ID, 'spot_tags');
	
	if ($tags) { ?>
<?php if (defined('DAHERO_CHANGE_1')) { ?>
		<p class="spot-tags">
			<strong><?php _e('Plate:', 'btoa'); ?> </strong>
			<?php $i=0; foreach ($tags as $single_tag) : ?>
			    <?=($i++==0) ? '' : ', ';?><?=$single_tag->name;?>
			<?php endforeach; ?>
		</p>
<?php } else { ?>
		<p class="spot-tags">
			<strong><?php _e('Tags:', 'btoa'); ?> </strong>
			<?php
				$tags_html = '';
				foreach ($tags as $single_tag) {
					//// ADDS TO OUR MARKUP
					$tags_html .= '<a href="'.get_term_link($single_tag, 'spot_tags').'">'.$single_tag->name.'</a>, ';
				}
				//// TRIMS LAST COME
				echo rtrim($tags_html, ', ');
			?>
		</p>
<?php } /* DDAHERO_CHANGE_X */ ?>
	<?php }
?>